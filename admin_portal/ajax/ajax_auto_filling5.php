<?php
require_once('../core/config.php');
require_once('../core/session.php');
// require_once('../helper/AdminHelper.php');
$connection = getDB();    

// If the user is not logged in redirect to the login page...
if(!isset($_SESSION['admin_name'])){
    header("location:login.php"); 
    exit();
}


try {

    // Function to fetch new user IDs from the users table
    function fetchNewUserIds($connection) {
        $sql = "SELECT user_id FROM users WHERE user_id NOT IN (SELECT referrer_id FROM referrals)";
        $stmt = $connection->query($sql);
        $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // print_r($userIds);
        return $userIds;
    }

    // Function to get the number of children of a referrer
    function countReferrerChildren($referrerId, $connection) {
        $sql = "SELECT COUNT(*) AS count FROM referrals WHERE referrer_id = :referrerId";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count;
    }


    // Function to find the next available level for inserting new users
function findNextAvailableLevel($connection) {
    // Query to find the maximum level in the referrals table
    $sql = "SELECT MAX(level) FROM referrals";
    $stmt = $connection->query($sql);
    $maxLevel = $stmt->fetchColumn();

    // The next available level will be the maximum level + 1
    $nextLevel = $maxLevel + 1;
    return $nextLevel;
}


function findAvailableReferrer($newUserId, $connection) {
    // Check if the referrals table is empty
    $sql = "SELECT COUNT(*) FROM referrals";
    $stmt = $connection->query($sql);
    $rowCount = $stmt->fetchColumn();
    
    if ($rowCount === 0) {
        // The referrals table is empty, so make the new user the root user
        return null;  // No need to find a referrer, as this user will be the root
    }

    // Check if the new user has been referred by less than 2 users
    $sql = "SELECT id FROM referrals WHERE (referrer_id = :newUserId) AND 
            (SELECT COUNT(*) FROM referrals WHERE referrer_id = :newUserId) < 2";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':newUserId', $newUserId, PDO::PARAM_INT);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        return $row['id'];
    }

    return null;  // No available spot for the new user
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

// Function to insert the new user under a referrer
function insertUserUnderReferrer($referrerId, $newUserId, $connection) {
    try {
        $connection->beginTransaction();

        // Get the level of the referrer
        $referrerLevel = getReferrerLevel($referrerId, $connection);

        // Check if the referrer's level has reached the maximum children
        $maxChildrenThisLevel = pow(2, $referrerLevel);
        $numChildren = countReferrerChildren($referrerId, $connection);

        if ($numChildren < $maxChildrenThisLevel) {
            // Determine the insertion position based on the level
            $insertionPosition = $numChildren;

            $columnName = ($insertionPosition % 2 == 0) ? 'left_child_id' : 'right_child_id';

            // Update the appropriate child column with the new user's ID
            $sql = "UPDATE referrals SET $columnName = :newUserId WHERE id = :referrerId";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':newUserId', $newUserId, PDO::PARAM_INT);
            $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            echo "Referrer (ID: $referrerId) has reached the maximum allowed children for user (ID: $newUserId).<br>";
        }

        $connection->commit();
    } catch (PDOException $e) {
        $connection->rollback();
        echo "Error: " . $e->getMessage();
    }
}

// ... (the rest of your code)

// Fetch new user IDs from the users table
$newUserIds = fetchNewUserIds($connection);

// }
// Function to insert a root referrer
function insertRootReferrer($connection) {
    $sql = "INSERT INTO referrals (referral_id, level) VALUES ('', 0)";
    $stmt = $connection->prepare($sql);
    $stmt->execute();

    // Get the ID of the inserted root referrer
    return $connection->lastInsertId();
}

$newUserIds = fetchNewUserIds($connection);

    foreach ($newUserIds as $newUserId) {
        // Find an available referrer for the new user
        $referrerId = findAvailableReferrer($newUserId, $connection);

        if ($referrerId !== null) {
            // Insert the new user under the available referrer
            insertUserUnderReferrer($referrerId, $newUserId, $connection);
        } else {
            // If no available referrer, create a root referrer and insert the user under it
            $rootReferrerId = insertRootReferrer($connection);
            if ($rootReferrerId !== null) {
                insertUserUnderReferrer($rootReferrerId, $newUserId, $connection);
            } else {
                echo "Unable to create a root referrer for user (ID: $newUserId).<br>";
            }
        }

        
    }

 




} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Close the database connection
$connection = null;


?>


