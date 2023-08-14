<?php
require_once('../core/config.php');
require_once('../core/session.php');
$conn = getDB();

// If the user is not logged in, redirect to the login page...
if (!isset($_SESSION['admin_name'])) {
    header("location:login.php");
    exit();
}
try {
    function fetchNewUserIds($connection) {
        $sql = "SELECT user_id FROM users";
        $stmt = $connection->query($sql);
        $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
        return $userIds;
    }

    // User IDs and parent IDs will be used for the referral hierarchy
    // $userIds = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
    $userIds  = fetchNewUserIds($conn);

    // Insert users into the referrals table
    foreach ($userIds as $userId) {
        // Get parent IDs based on the hierarchy
        $parentId = floor($userId / 2);

        // Determine level based on the parent ID
        $level = 0;
        $parentIdCopy = $parentId;
        while ($parentIdCopy > 0) {
            $parentIdCopy = floor($parentIdCopy / 2);
            $level++;
        }

        // Check if the level limit is not exceeded
        $maxMembersInLevel = pow(2, $level);
        $stmt = $conn->prepare("SELECT COUNT(*) as member_count FROM referrals WHERE level = :level");
        $stmt->bindParam(":level", $level);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row['member_count'] < $maxMembersInLevel) {
            $stmt = $conn->prepare("INSERT INTO referrals (user_id, parent_id, level) VALUES (:user_id, :parent_id, :level)");
            $stmt->bindParam(":user_id", $userId);
            $stmt->bindParam(":parent_id", $parentId);
            $stmt->bindParam(":level", $level);
            $stmt->execute();
            echo "User $userId inserted successfully.<br>";
        } else {
            echo "Level $level has reached its maximum member limit.<br>";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;

?>