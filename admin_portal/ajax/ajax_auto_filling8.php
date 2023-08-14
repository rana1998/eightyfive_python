<?php
require_once('../core/config.php');
require_once('../core/session.php');
$connection = getDB();

// If the user is not logged in, redirect to the login page...
if (!isset($_SESSION['admin_name'])) {
    header("location:login.php");
    exit();
}

// // Function to insert a new referrer
// function insertReferrer($referralId, $referrerId, $parentReferrerId, $level, $connection) {
//     $sql = "INSERT INTO referrals (referral_id, referrer_id, parent_id, level) VALUES (:referralId, :referrerId, :parentReferrerId, :level)";
//     $stmt = $connection->prepare($sql);
//     $stmt->bindParam(':referralId', $referralId, PDO::PARAM_INT);
//     $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
//     $stmt->bindParam(':parentReferrerId', $parentReferrerId, PDO::PARAM_INT);
//     $stmt->bindParam(':level', $level, PDO::PARAM_INT);
//     $stmt->execute();
// }

// // Function to get the parent referrer's ID
// function getParentReferrer($referralId, $connection) {
//     $sql = "SELECT parent_id FROM referrals WHERE referral_id = :referralId";
//     $stmt = $connection->prepare($sql);
//     $stmt->bindParam(':referralId', $referralId, PDO::PARAM_INT);
//     $stmt->execute();
//     $parentId = $stmt->fetchColumn();
    
//     return $parentId;
// }

// // Function to insert a user into the hierarchy
// function insertUserHierarchy($referralId, $level, $connection) {
//     $parentReferrerId = getParentReferrer($referralId, $connection);
    
//     if ($parentReferrerId === null) {
//         // Insert the user as a root referrer
//         insertReferrer($referralId, $referralId, null, $level, $connection);
//     } else {
//         // Insert the user under the parent referrer
//         insertReferrer($referralId, $referralId, $parentReferrerId, $level, $connection);
//     }
// }

// // Function to fetch new user IDs from the users table
// function fetchNewUserIds($connection) {
//     $sql = "SELECT user_id FROM users";
//     $stmt = $connection->query($sql);
//     $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

//     return $userIds;
// }

// // Example usage
// $connection = getDB(); // Replace with your database connection

// $newUserIds = fetchNewUserIds($connection);
// foreach ($newUserIds as $userId) {
//     // Determine the level based on the number of users in the hierarchy
//     $level = determineLevel($connection);
    
//     insertUserHierarchy($userId, $level, $connection);
// }

// // Close the database connection
// $connection = null;

// // Function to determine the level based on the number of users in the hierarchy
// function determineLevel($connection) {
//     try {
//         $sql = "SELECT COUNT(*) AS total_users FROM users";
//         $stmt = $connection->prepare($sql);
//         $stmt->execute();
//         $result = $stmt->fetch(PDO::FETCH_ASSOC);

//         $totalUsers = $result['total_users'];

//         $level = 1;
//         while ($totalUsers >= 2 * $level) {
//             $level++;
//         }

//         return $level;
//     } catch (PDOException $e) {
//         // Handle any errors here
//         return 1; // Default to level 1 in case of an error
//     }
// }


// Code 2

// try {
//     // Function to determine the maximum number of children for a given level
//     function getMaxChildrenForLevel($level) {
//         return 2 * $level;
//     }

//     // Function to get the number of children of a referrer
//     function countReferrerChildren($referrerId, $connection) {
//         $sql = "SELECT COUNT(*) AS count FROM referrals WHERE referrer_id = :referrerId";
//         $stmt = $connection->prepare($sql);
//         $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
//         $stmt->execute();
//         $count = $stmt->fetchColumn();

//         return $count;
//     }


//     // Function to insert a new user into the referrals table
//     function insertUserInReferrals($newUserId, $parentReferrerId, $currentLevel, $connection) {
//         $sql = "INSERT INTO referrals (referral_id, referrer_id, level) VALUES (:newUserId, :parentReferrerId, :currentLevel)";
//         $stmt = $connection->prepare($sql);
//         $stmt->bindParam(':newUserId', $newUserId, PDO::PARAM_INT);
//         $stmt->bindParam(':parentReferrerId', $parentReferrerId, PDO::PARAM_INT);
//         $stmt->bindParam(':currentLevel', $currentLevel, PDO::PARAM_INT);
//         $stmt->execute();
//     }

//     // Fetch new user IDs from the users table
//     // $sql = "SELECT user_id FROM users";
//     // $stmt = $connection->query($sql);
//     // $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
//     $sql = "SELECT user_id FROM users";
//     $stmt = $connection->query($sql);
//     $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

//     // Start with level 0 and the root as the parent referrer
//     $currentLevel = 0;
//     $parentReferrerId = null;

//     foreach ($userIds as $newUserId) {
//         // Check if the current parent referrer can have more children
//         $maxChildren = getMaxChildrenForLevel($currentLevel);
//         $currentChildren = countReferrerChildren($parentReferrerId, $connection);

//         if ($currentChildren >= $maxChildren) {
//             // Move to the next level and set the parent referrer to the last inserted user
//             $currentLevel++;
//             $parentReferrerId = $newUserId;
//         }

//         // Insert the user with the appropriate parent referrer and level
//         insertUserInReferrals($newUserId, $parentReferrerId, $currentLevel, $connection);

//         echo "Inserted user (ID: $newUserId) at level $currentLevel under parent referrer (ID: $parentReferrerId).<br>";
//     }
// } catch (PDOException $e) {
//     echo "Connection failed: " . $e->getMessage();
// }

// CODE 3
try {
    // Fetch new user IDs from the users table
    $newUserIds = fetchNewUserIds($connection);

    foreach ($newUserIds as $newUserId) {
        insertUserHierarchy($newUserId, $connection);
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

// Close the database connection
$connection = null;

function fetchNewUserIds($connection) {
    $sql = "SELECT user_id FROM users";
    $stmt = $connection->query($sql);
    $userIds = $stmt->fetchAll(PDO::FETCH_COLUMN);
    return $userIds;
}

// function insertUserHierarchy($newUserId, $connection) {
//     try {
//         $connection->beginTransaction();

//         $rootReferrerId = getRootReferrerId($connection);
//         if ($rootReferrerId === null) {
//             $rootReferrerId = insertRootReferrer($connection);
//         }

//         $referrerId = findAvailableReferrer($rootReferrerId, $connection);

//         if ($referrerId !== null) {
//             insertUserUnderReferrer($referrerId, $newUserId, $connection);
//         } else {
//             echo "No available referrer for user (ID: $newUserId).<br>";
//         }

//         $connection->commit();
//     } catch (PDOException $e) {
//         $connection->rollback();
//         echo "Error: " . $e->getMessage();
//     }
// }

function insertUserHierarchy($newUserId, $connection) {
    try {
        $connection->beginTransaction();

        $rootReferrerId = getRootReferrerId($connection);
        if ($rootReferrerId === null) {
            $rootReferrerId = insertRootReferrer($connection);
        }

        $referrerId = findAvailableReferrer($rootReferrerId, $connection);

        if ($referrerId !== null) {
            insertUserUnderReferrer($referrerId, $newUserId, $connection);
        } else {
            // No available referrer found in the current level, move to the next level
            $nextLevel = getReferrerLevel($rootReferrerId, $connection) + 1;
            $referrerId = findAvailableReferrerAtLevel($rootReferrerId, $nextLevel, $connection);

            if ($referrerId !== null) {
                insertUserUnderReferrer($referrerId, $newUserId, $connection);
            } else {
                echo "No available referrer for user (ID: $newUserId) in level $nextLevel.<br>";
            }
        }

        $connection->commit();
    } catch (PDOException $e) {
        $connection->rollback();
        echo "Error: " . $e->getMessage();
    }
}





function getRootReferrerId($connection) {
    $sql = "SELECT referral_id FROM referrals WHERE parent_id IS NULL";
    $stmt = $connection->query($sql);
    $rootReferrerId = $stmt->fetchColumn();
    return $rootReferrerId;
}

function insertRootReferrer($connection) {
    $sql = "INSERT INTO referrals (referral_id, level) VALUES (0, 0)";
    $stmt = $connection->prepare($sql);
    $stmt->execute();
    return $connection->lastInsertId();
}

function findAvailableReferrer($referrerId, $connection) {
    // Check if the referrer has available spots for children
    $numChildren = countReferrerChildren($referrerId, $connection);
    $referrerLevel = getReferrerLevel($referrerId, $connection);
    $maxChildrenThisLevel = pow(2, $referrerLevel);

    if ($numChildren < $maxChildrenThisLevel) {
        return $referrerId;
    }

    return null;
}

function countReferrerChildren($referrerId, $connection) {
    $sql = "SELECT COUNT(*) AS count FROM referrals WHERE parent_id = :referrerId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
    $stmt->execute();
    $count = $stmt->fetchColumn();
    return $count;
}

function getReferrerLevel($referrerId, $connection) {
    $sql = "SELECT level FROM referrals WHERE referral_id = :referrerId";
    $stmt = $connection->prepare($sql);
    $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
    $stmt->execute();
    $level = $stmt->fetchColumn();
    return $level;
}

function insertUserUnderReferrer($referrerId, $newUserId, $connection) {
    $sql = "INSERT INTO referrals (referral_id, parent_id, level) VALUES (:newUserId, :referrerId, :level)";
    $stmt = $connection->prepare($sql);
    $referrerLevel = getReferrerLevel($referrerId, $connection);
    $level = $referrerLevel + 1;
    $stmt->bindParam(':newUserId', $newUserId, PDO::PARAM_INT);
    $stmt->bindParam(':referrerId', $referrerId, PDO::PARAM_INT);
    $stmt->bindParam(':level', $level, PDO::PARAM_INT);
    $stmt->execute();
}

?>
