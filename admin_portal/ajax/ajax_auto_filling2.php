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

    // // Function to insert a new user in the hierarchy
    function insertUserHierarchy($referrerId, $newUserId, $connection) {
        // Get the current level and count of children
        $referrerLevel = getUserLevel($referrerId, $connection);
        $numChildren = countReferrerChildren($referrerId, $connection);

        // Determine if there's space in the current level
        $maxChildrenThisLevel = pow(2, $referrerLevel);
        if ($numChildren < $maxChildrenThisLevel) {
            // Determine the insertion position based on the level
            $insertionPosition = $numChildren;

            $columnName = ($insertionPosition % 2 == 0) ? 'left_child_id' : 'right_child_id';

            $sql = "UPDATE referrals SET $columnName = :newUserId WHERE referrer_id = :referrerId";
            $stmt = $connection->prepare($sql);
            $stmt->bindParam(':newUserId', $newUserId, PDO::PARAM_INT);
            $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            echo "Referrer (ID: $referrerId) has reached the maximum allowed children for user (ID: $newUserId).<br>";
        }
    }

    // Function to check if a root referrer exists
    function checkRootReferrerExists($connection) {
        $sql = "SELECT COUNT(*) FROM referrals WHERE parent_id IS NULL";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $rootExists = ($stmt->fetchColumn() > 0);
        return $rootExists;
    }

//     // Call the function with the correct PDO connection object
// $rootExists = checkRootReferrerExists($connection);

    // Function to create a root referrer
    function createRootReferrer($connection) {
        $sql = "INSERT INTO referrals (referrer_id, level) VALUES (0, 0)";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
    }


    // Function to find an available referrer for a new user
function findAvailableReferrer($newUserId, $connection) {
    // Start with the root referrer
    $currentReferrerId = 0; // Assuming root referrer ID is 0

    while (true) {
        // Check if the referrer has available spots for children
        $numChildren = countReferrerChildren($currentReferrerId, $connection);
        $referrerLevel = getUserLevel($currentReferrerId, $connection);
        $maxChildrenThisLevel = pow(2, $referrerLevel);
        
        if ($numChildren < $maxChildrenThisLevel) {
            // Check if the left child spot is available
            if (isChildSlotAvailable($currentReferrerId, 'left_child_id', $connection)) {
                return $currentReferrerId;
            }
            
            // Check if the right child spot is available
            if (isChildSlotAvailable($currentReferrerId, 'right_child_id', $connection)) {
                return $currentReferrerId;
            }
        }
        
        // If this level is full, move to the next level
        $nextReferrerId = findNextReferrerInLevel($currentReferrerId, $connection);
        
        if ($nextReferrerId === null) {
            // No available referrers in this level, move to the parent level
            $parentReferrerId = getParentReferrer($currentReferrerId, $connection);
            
            if ($parentReferrerId === null) {
                // No available referrers in any level, return null
                return null;
            }
            
            $currentReferrerId = $parentReferrerId;
        } else {
            $currentReferrerId = $nextReferrerId;
        }
    }
}

// Function to check if a child slot is available for a referrer
function isChildSlotAvailable($referrerId, $childColumnName, $connection) {
    $sql = "SELECT $childColumnName FROM referrals WHERE referrer_id = :referrerId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
    $stmt->execute();
    $childId = $stmt->fetchColumn();
    
    return ($childId === null);
}

// Function to find the next referrer in the same level
function findNextReferrerInLevel($referrerId, $connection) {
    // Get the parent referrer's ID
    $parentId = getParentReferrer($referrerId, $connection);
    if ($parentId === null) {
        return null; // No parent, so no next referrer in the same level
    }

    // Check if the provided referrer is in the left or right slot
    $childColumn = getChildColumnOfReferrer($parentId, $referrerId, $connection);

    if ($childColumn === 'left_child_id') {
        // Find the referrer in the right slot of the parent
        $sql = "SELECT referrer_id FROM referrals WHERE parent_id = :parentId AND right_child_id IS NOT NULL";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':parentId', $parentId, PDO::PARAM_INT);
        $stmt->execute();
        $nextReferrerId = $stmt->fetchColumn();
        return $nextReferrerId;
    } elseif ($childColumn === 'right_child_id') {
        // Get the parent referrer's ID
        $parentParentId = getParentReferrer($parentId, $connection);
        if ($parentParentId === null) {
            return null; // No grandparent, so no next referrer in the same level
        }

        // Find the referrer's next sibling in the parent's right slot
        $sql = "SELECT referrer_id FROM referrals WHERE parent_id = :parentParentId AND right_child_id = :referrerId";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':parentParentId', $parentParentId, PDO::PARAM_INT);
        $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
        $stmt->execute();
        $nextReferrerId = $stmt->fetchColumn();
        return $nextReferrerId;
    }

    return null; // Default case, no next referrer found
}


// Function to get the parent referrer's ID
function getParentReferrer($referrerId, $connection) {
    $sql = "SELECT parent_id FROM referrals WHERE referrer_id = :referrerId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
    $stmt->execute();
    $parentId = $stmt->fetchColumn();
    
    return $parentId;
}


    // // Function to insert a new user in the hierarchy
    // function insertUserHierarchy($newUserId, $connection) {
    //     // Check if there's a root referrer, if not, create it
    //     $rootExists = checkRootReferrerExists($connection);
    //     if (!$rootExists) {
    //         createRootReferrer($connection);
    //     }

    //     // Find an available referrer
    //     $referrerId = findAvailableReferrer($newUserId, $connection);

    //     if ($referrerId !== null) {
    //         // Get the current level and count of children
    //         $referrerLevel = getUserLevel($referrerId, $connection);
    //         $numChildren = countReferrerChildren($referrerId, $connection);

    //         // Determine if there's space in the current level
    //         $maxChildrenThisLevel = pow(2, $referrerLevel);
    //         if ($numChildren < $maxChildrenThisLevel) {
    //             // Determine the insertion position based on the level
    //             $insertionPosition = $numChildren;

    //             $columnName = ($insertionPosition % 2 == 0) ? 'left_child_id' : 'right_child_id';

    //             $sql = "UPDATE referrals SET $columnName = :newUserId WHERE referrer_id = :referrerId";
    //             $stmt = $connection->prepare($sql);
    //             $stmt->bindParam(':newUserId', $newUserId, PDO::PARAM_INT);
    //             $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
    //             $stmt->execute();
    //         } else {
    //             echo "Referrer (ID: $referrerId) has reached the maximum allowed children for user (ID: $newUserId).<br>";
    //         }
    //     } else {
    //         echo "No available referrer for user (ID: $newUserId).<br>";
    //     }
    // }

//     // Function to insert a new user in the hierarchy
// function insertUserHierarchy($newUserId, $connection) {
//     try {
//         $connection->beginTransaction();

//         // Check if there's a root referrer, if not, create it
//         $rootExists = checkRootReferrerExists($connection);
//         if (!$rootExists) {
//             createRootReferrer($connection);
//         }

//         // Find an available referrer
//         $referrerId = findAvailableReferrer($newUserId, $connection);

//         if ($referrerId !== null) {
//             // Get the current level and count of children
//             $referrerLevel = getUserLevel($referrerId, $connection);
//             $numChildren = countReferrerChildren($referrerId, $connection);

//             // Determine if there's space in the current level
//             $maxChildrenThisLevel = pow(2, $referrerLevel);
//             if ($numChildren < $maxChildrenThisLevel) {
//                 // Determine the insertion position based on the level
//                 $insertionPosition = $numChildren;

//                 $columnName = ($insertionPosition % 2 == 0) ? 'left_child_id' : 'right_child_id';

//                 $sql = "UPDATE referrals SET $columnName = :newUserId WHERE referrer_id = :referrerId";
//                 $stmt = $connection->prepare($sql);
//                 $stmt->bindParam(':newUserId', $newUserId, PDO::PARAM_INT);
//                 $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
//                 $stmt->execute();
//             } else {
//                 echo "Referrer (ID: $referrerId) has reached the maximum allowed children for user (ID: $newUserId).<br>";
//             }
//         } else {
//             echo "No available referrer for user (ID: $newUserId).<br>";
//         }

//         $connection->commit();
//     } catch (PDOException $e) {
//         $connection->rollback();
//         echo "Error: " . $e->getMessage();
//     }
// }



    // Function to get the level of a user
    function getUserLevel($userId, $connection) {
        $sql = "SELECT level FROM referrals WHERE referrer_id = :userId";
        $stmt = $connection->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();
        $level = $stmt->fetchColumn();

        return $level;
    }

    // Fetch new user IDs from the users table
    $newUserIds = fetchNewUserIds($connection);
    // print_r($newUserIds);

    // Function to fetch the referrer's ID based on criteria
    // Function to fetch the referrer's ID based on criteria
    function fetchReferrerId($newUserId, $connection) {
        // Modify this query to fit your criteria for finding an available referrer
        $sql = "SELECT referrer_id FROM referrals WHERE left_child_id IS NULL OR right_child_id IS NULL LIMIT 1";
        $stmt = $connection->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return $row['referrer_id'];
        }

        // If no referrer found, you can implement fallback logic here
        // For example, selecting the referrer with the least number of children
        // If no referrer found, insert the new user as the root (level 0)
        $rootUserId = 0; // Replace with the actual root user ID
        insertUserHierarchy($rootUserId, $newUserId, $connection);
        return $rootUserId;
    }

    // // Fetch new user IDs from the users table
    // $newUserIds = fetchNewUserIds($connection);

    // foreach ($newUserIds as $newUserId) {
    //     // Fetch the referrer's ID from the user table based on your criteria
    //     $referrerId = fetchReferrerId($newUserId, $connection);
    //     // print_r($referrerId);
    //     insertUserHierarchy($newUserId, $connection);
    // }

    // Fetch new user IDs from the users table
    $newUserIds = fetchNewUserIds($connection);

    foreach ($newUserIds as $newUserId) {
        // Fetch the referrer's ID from the user table based on your criteria
        $referrerId = fetchReferrerId($newUserId, $connection);
        // print_r($referrerId);
        insertUserHierarchy($referrerId, $newUserId, $connection); // Corrected argument order
    }

    // function fetchReferrerId($newUserId, $connection) {
    //     $sql = "SELECT referrer_id FROM referrals WHERE left_child_id IS NULL OR right_child_id IS NULL LIMIT 1";
    //     $stmt = $connection->prepare($sql);
    //     $stmt->execute();
    //     $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //     print_r($row);

    //     if ($row) {
    //         return $row['referrer_id'];
    //     }

    //     // If no referrer found, you can implement fallback logic here
    //     // For example, selecting the referrer with the least number of children
    //     // If no referrer found, insert the new user as the root (level 0)
    //     // Assuming the root user ID is 0 or some predefined value
    //     // Modify this to match your specific logic
    //     // return 0;
    //     $rootUserId = 0; // Replace with the actual root user ID
    //     insertUserHierarchy($rootUserId, $newUserId, $connection);
    //     return $rootUserId;
    // }


    // foreach ($newUserIds as $newUserId) {
    //     // Fetch the referrer's ID from the user table based on your criteria
    //     $referrerId = fetchReferrerId($newUserId, $connection);
    //     print_r($referrerId);
    //     insertUserHierarchy($referrerId, $newUserId, $connection);
    // }

} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Close the database connection
$connection = null;


?>


