<?php
require_once('../core/config.php');
require_once('../core/session.php');
$connection = getDB();

// If the user is not logged in, redirect to the login page...
if (!isset($_SESSION['admin_name'])) {
    header("location:login.php");
    exit();
}


// Function to insert a new referrer
function insertReferrer($referralId, $referrerId, $level, $parentId, $connection) {
    $sql = "INSERT INTO referrals (referral_id, referrer_id, level, parent_id) VALUES (:referralId, :referrerId, :level, :parentId)";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':referralId', $referralId, PDO::PARAM_INT);
    $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
    $stmt->bindParam(':level', $level, PDO::PARAM_INT);
    $stmt->bindParam(':parentId', $parentId, PDO::PARAM_INT);
    $stmt->execute();
}

// Function to find the parent referrer's ID
function getParentReferrer($referrerId, $connection) {
    $sql = "SELECT parent_id FROM referrals WHERE referral_id = :referrerId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
    $stmt->execute();
    $parentId = $stmt->fetchColumn();
    
    return $parentId;
}

// Function to insert a new user into the hierarchy
function insertUserHierarchy($referralId, $connection) {
    $level = 0; // Start at level 0
    
    // while (true) {
        // Check if the current referrer has available spots for children
        $parentId = getParentReferrer($referralId, $connection);
        $numChildren = countReferrerChildren($parentId, $connection);
        $maxChildrenThisLevel = pow(2, $level);

        echo "<pre>";
        print_r($parentId);
        print_r($numChildren);
        print_r($maxChildrenThisLevel);
        echo "</pre>";

        if ($numChildren < $maxChildrenThisLevel) {
            // Insert the new user as a child of the current referrer
            insertReferrer($referralId, $referralId, $level, $parentId, $connection);
            // break; // User inserted, exit the loop
        } else {
            // No available spots, move to the next level
            $level++;
            
            // Check if the parent of the current referrer exists
            $parentReferralId = getParentReferrer($referralId, $connection);
            if ($parentReferralId === null) {
                // No parent referrer, insert a new root referrer
                insertReferrer($referralId, null, $level, null, $connection);
                // break; // User inserted, exit the loop
            }
            
            // Move up to the parent referrer
            $referralId = $parentReferralId;
        }
    // }
}

// Function to count the children of a referrer
function countReferrerChildren($parentId, $connection) {
    $sql = "SELECT COUNT(*) AS count FROM referrals WHERE parent_id = :parentId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':parentId', $parentId, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    return $count;
}

// Example usage
$referralId = 1; // Replace with the user's referral ID
$connection = getDB(); // Replace with your database connection

insertUserHierarchy($referralId, $connection);

// Close the database connection
$connection = null;
?>
