<?php
require_once('../core/config.php');
require_once('../core/session.php');
$conn = getDB();

// If the user is not logged in, redirect to the login page...
if (!isset($_SESSION['admin_name'])) {
    header("location:login.php");
    exit();
}

// Function to insert a user and maintain binary tree structure
function insertUser($userid, $parent_id, $levelid, $conn) {
    try {
        $stmt = $conn->prepare("INSERT INTO referrals (user_id, parent_id, level) VALUES (?, ?, ?)");
        $stmt->execute([$userid, $parent_id, $levelid]);
        echo "User '$userid' inserted successfully.<br>";
    } catch (PDOException $e) {
        echo "Error inserting user: " . $e->getMessage() . "<br>";
    }
}

// Example data to insert
$userData = [
    ["Alice", null, 1],  // Root user
    ["Bob", 1, 2],       // Alice's referral
    ["Charlie", 1, 2],   // Alice's referral
    ["David", 2, 3],     // Bob's referral
    ["Eve", 2, 3],       // Bob's referral
    // ... and so on
];


function getLevelMaxMember() {
    try {    
        // Get the count of members for the specified level
        $countQuery = "
            SELECT COUNT(*) AS member_count
            FROM referrals
            WHERE level = :targetLevel
        ";
    
        $countStmt = $conn->prepare($countQuery);
        $countStmt->bindParam(':targetLevel', $targetLevel, PDO::PARAM_INT);
        $countStmt->execute();
        
        $memberCountResult = $countStmt->fetch(PDO::FETCH_ASSOC);
        $memberCount = $memberCountResult['member_count'];
    
        // Get the maximum allowed member count for the specified level
        $maxMemberQuery = "
            SELECT max_member_count
            FROM level_limits
            WHERE level = :targetLevel
        ";
    
        $maxMemberStmt = $conn->prepare($maxMemberQuery);
        $maxMemberStmt->bindParam(':targetLevel', $targetLevel, PDO::PARAM_INT);
        $maxMemberStmt->execute();
    
        $maxMemberResult = $maxMemberStmt->fetch(PDO::FETCH_ASSOC);
        $maxAllowedCount = $maxMemberResult['max_member_count'];
    
        if ($memberCount > $maxAllowedCount) {
            echo "Level $targetLevel member count exceeds the limit.";
        } else {
            echo "Level $targetLevel member count is within the limit.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Insert users
foreach ($userData as $user) {
    $userid = $user[0];
    $parent_id = $user[1];
    $levelid = $user[2];

    // Check level and jump to new level if needed
    $stmt = $conn->prepare("SELECT COUNT(*) as referrals_count FROM referrals WHERE parent_id = ?");
    $stmt->execute([$parent_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row && $row["referrals_count"] >= 2) {
        // Find the next available referral spot
        $new_parent_id = findNextAvailableSpot($parent_id, $levelid, $conn);
        $parent_id = $new_parent_id;
    }

    // Insert user with the updated parent_id
    insertUser($userid, $parent_id, $levelid, $conn);
}



// ... Rest of the logic to find and return the next available spot ...
function findNextAvailableSpot($parent_id, $levelid, $conn) {
    // Assuming you have a way to determine left and right spots based on parent_id and levelid
    $next_spot_query = "SELECT parent_id FROM referrals WHERE parent_id = :parent_id AND level = :levelid LIMIT 2";
    $stmt = $conn->prepare($next_spot_query);
    $stmt->bindParam(':parent_id', $parent_id);
    $stmt->bindParam(':levelid', $levelid);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Similar to the previous example, you might need more complex logic to find the next available spot.
        // This depends on your specific binary tree structure and how you determine spots based on parent_id and levelid.
        // The code below is a simplified example and might need further refinement based on your actual structure.

        $left_taken = false;
        $right_taken = false;

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row["parent_id"] === "$parent_id-left") {
                $left_taken = true;
            } elseif ($row["parent_id"] === "$parent_id-right") {
                $right_taken = true;
            }
        }

        if (!$left_taken) {
            return "$parent_id-left";
        } elseif (!$right_taken) {
            return "$parent_id-right";
        }
    }

    // If both spots are taken, you might need to further navigate the tree to find the next available spot.
    // This is a simplified example and might require more complex logic based on your actual structure.
    // For instance, you might need to search the next available spot starting from the left or right referral of the parent.
    // If you have more than two spots per level, the logic will need to be more elaborate.
}



// Close the database connection
$conn = null;
// Function to find the next available referral spot


// Close the database connection
$conn->close();
?>
