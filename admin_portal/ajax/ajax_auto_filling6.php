<?php
require_once('../core/config.php');
require_once('../core/session.php');
$connection = getDB();

// If the user is not logged in, redirect to the login page...
if (!isset($_SESSION['admin_name'])) {
    header("location:login.php");
    exit();
}

try {
    // Function to fetch new user IDs from the users table
    function fetchNewUserIds($connection) {
        $sql = "SELECT user_id FROM users";
        $stmt = $connection->query($sql);
        $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $userIds;
    }

    // Function to insert a new root referrer
    function insertRootReferrer($connection) {
        $sql = "INSERT INTO referrals (referral_id, level) VALUES (0, 0)";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        return $connection->lastInsertId();
    }

    // Function to insert a new user under a referrer
    function insertUserUnderReferrer($referrerId, $newUserId, $connection) {
        $sql = "INSERT INTO referrals (referral_id, referrer_id, level, parent_id) VALUES (:newUserId, :referrerId, :level, :parentId)";
        $referrerLevel = getReferrerLevel($referrerId, $connection);
        $level = $referrerLevel + 1;
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':newUserId', $newUserId, PDO::PARAM_INT);
        $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
        $stmt->bindParam(':level', $level, PDO::PARAM_INT);
        $stmt->bindParam(':parentId', $referrerId, PDO::PARAM_INT); // Parent ID is the referrer ID
        $stmt->execute();
    }

    // Function to get the level of a referrer
    function getReferrerLevel($referrerId, $connection) {
        $sql = "SELECT level FROM referrals WHERE id = :referrerId";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
        $stmt->execute();
        $level = $stmt->fetchColumn();
        return $level;
    }

    // Fetch new user IDs from the users table
    $newUserIds = fetchNewUserIds($connection);

    // Insert new users into the hierarchy
    foreach ($newUserIds as $newUserId) {
        $rootReferrerId = insertRootReferrer($connection);
        insertUserUnderReferrer($rootReferrerId, $newUserId, $connection);
    }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Close the database connection
$connection = null;
?>
