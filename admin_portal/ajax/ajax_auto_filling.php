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
    // Function to check if a user has two referred child nodes
    function hasTwoReferredChildren($userId, $connection) {
        $sql = "SELECT COUNT(*) AS count FROM referrals WHERE referrer_id = :userId AND (left_child_id IS NOT NULL AND right_child_id IS NOT NULL)";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count >= 2;
    }

    // Function to insert a new user as a child in the hierarchy
    function insertChildNode($referrerId, $newUserId, $connection) {
        if (!hasLeftChild($referrerId, $connection)) {
            $columnName = 'left_child_id';
        } elseif (!hasRightChild($referrerId, $connection)) {
            $columnName = 'right_child_id';
        } else {
            return; // Referrer already has two children
        }

        $sql = "UPDATE referrals SET $columnName = :newUserId WHERE referrer_id = :referrerId";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':newUserId', $newUserId, PDO::PARAM_INT);
        $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Function to check if a referrer has a left child
    function hasLeftChild($referrerId, $connection) {
        $sql = "SELECT left_child_id FROM referrals WHERE referrer_id = :referrerId";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
        $stmt->execute();
        $leftChildId = $stmt->fetchColumn();

        return $leftChildId !== null;
    }

    // Function to check if a referrer has a right child
    function hasRightChild($referrerId, $connection) {
        $sql = "SELECT right_child_id FROM referrals WHERE referrer_id = :referrerId";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
        $stmt->execute();
        $rightChildId = $stmt->fetchColumn();

        return $rightChildId !== null;
    }


    // Function to fetch users with incomplete nodes
    function fetchUsersWithIncompleteNodes($connection) {
        $sql = "SELECT user_id FROM users";
        $stmt = $connection->query($sql);
        $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        $incompleteUsers = [];

        foreach ($userIds as $userId) {
            if (!hasTwoReferredChildren($userId, $connection)) {
                $incompleteUsers[] = $userId;
            }
        }

        return $incompleteUsers;
    }

    // Function to fetch unconnected new users
    function fetchUnconnectedNewUsers($connection) {
        $sql = "SELECT user_id FROM users WHERE user_id NOT IN (SELECT referrer_id FROM referrals)";
        $stmt = $connection->query($sql);
        $newUserIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        return $newUserIds;
    }

    // Function to connect new users in the referral hierarchy
    function connectUnconnectedNewUsers($connection) {
        $incompleteUsers = fetchUsersWithIncompleteNodes($connection);
        $newUserIds = fetchUnconnectedNewUsers($connection);

        foreach ($incompleteUsers as $referrerId) {
            if (!empty($newUserIds)) {
                $newUserId = array_shift($newUserIds);
                insertChildNode($referrerId, $newUserId, $connection);
            } else {
                break; // No more unconnected new users
            }
        }
    }

    // Connect unconnected new users in the referral hierarchy
    connectUnconnectedNewUsers($connection);

    //New code START 
    
    // Function to get the number of children of a referrer
    function countReferrerChildren($referrerId, $connection) {
        $sql = "SELECT COUNT(*) AS count FROM referrals WHERE referrer_id = :referrerId";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        return $count;
    }

    // Function to insert a new user in the hierarchy
    function insertUserHierarchy($referrerId, $newUserId, $connection) {
        $numChildren = countReferrerChildren($referrerId, $connection);

        // Determine the insertion position based on the level
        $level = getUserLevel($referrerId, $connection);
        $insertionPosition = $numChildren;

        if ($level == 0) {
            $insertionPosition += 1;
        } elseif ($level > 0) {
            $insertionPosition += ($level * 2);
        }

        $columnName = ($insertionPosition % 2 == 0) ? 'left_child_id' : 'right_child_id';

        $sql = "UPDATE referrals SET $columnName = :newUserId WHERE referrer_id = :referrerId";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':newUserId', $newUserId, PDO::PARAM_INT);
        $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Function to get the level of a user
    function getUserLevel($userId, $connection) {
        $sql = "SELECT level FROM referrals WHERE referrer_id = :userId";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $level = $stmt->fetchColumn();

        return $level;
    }

    // Example usage
    $newUserId = 123; // Replace with the actual new user's ID

    // Fetch the referrer's ID from the user table based on your criteria
    $referrerId = fetchReferrerId($newUserId, $connection);

    // Check if the referrer's children are within the allowed limit
    $referrerLevel = getUserLevel($referrerId, $connection);
    $maxChildren = ($referrerLevel + 1) * 2;
    
    if (countReferrerChildren($referrerId, $connection) < $maxChildren) {
        insertUserHierarchy($referrerId, $newUserId, $connection);
        echo "New user added in the hierarchy.";
    } else {
        echo "Referrer has reached the maximum allowed children.";
    }



    // // Function to fetch users with incomplete nodes
    // function fetchUsersWithIncompleteNodes($connection) {
    //     $sql = "SELECT user_id FROM users";
    //     $stmt = $connection->query($sql);
    //     $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

    //     $incompleteUsers = [];

    //     foreach ($userIds as $userId) {
    //         if (!hasTwoReferredChildren($userId, $connection)) {
    //             $incompleteUsers[] = $userId;
    //         }
    //     }

    //     return $incompleteUsers;
    // }

    // // Function to insert a new user in the hierarchy based on timestamp (level order)
    // function insertNewUserLevelOrder($referrerId, $newUserId, $connection) {
    //     // Check left child first
    //     if (!hasLeftChild($referrerId, $connection)) {
    //         insertChildNode($referrerId, $newUserId, $connection);
    //     }
    //     // If left child is occupied, check right child
    //     elseif (!hasRightChild($referrerId, $connection)) {
    //         insertChildNode($referrerId, $newUserId, $connection);
    //     }
    //     // If both children are occupied, continue to next level
    //     else {
    //         // Implement logic to traverse hierarchy and find the next available spot for insertion
    //         // This can involve using a queue or other data structure to perform a level-order traversal
    //     }
    // }

    // // Fetch users with incomplete nodes
    // $incompleteUsers = fetchUsersWithIncompleteNodes($connection);

    // // Insert new users in level order
    // foreach ($incompleteUsers as $incompleteUserId) {
    //     $newUserId = /* Generate new user ID */;
    //     $referrerId = $incompleteUserId;

    //     insertNewUserLevelOrder($referrerId, $newUserId, $connection);
    // }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}




   

// Close the database connection
$connection = null;

?>


?>
