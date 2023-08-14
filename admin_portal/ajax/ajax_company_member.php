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
    // Top 10 company members
    $companyMemberIds = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10);

    // Insert company members into the company_members table
    foreach ($companyMemberIds as $companyMemberId) {
        $stmt = $conn->prepare("INSERT INTO company_members (user_id) VALUES (:user_id)");
        $stmt->bindParam(":user_id", $companyMemberId);
        $stmt->execute();
        echo "Company member $companyMemberId inserted successfully.<br>";
    }

    // // Insert users into the referrals table
    // foreach ($companyMemberIds as $userId) {
    //     // Set parent ID to null for top-level users
    //     $parentId = null;

    //     // Determine level based on the parent ID
    //     $level = 0;

    //     // Set is_company_member flag for top 10 members
    //     $isCompanyMember = 1;

    //     $stmt = $conn->prepare("INSERT INTO referrals (user_id, parent_id, level, is_company_member, company_member_id) VALUES (:user_id, :parent_id, :level, :is_company_member, :company_member_id)");
    //     $stmt->bindParam(":user_id", $userId);
    //     $stmt->bindParam(":parent_id", $parentId);
    //     $stmt->bindParam(":level", $level);
    //     $stmt->bindParam(":is_company_member", $isCompanyMember);
    //     $stmt->bindParam(":company_member_id", $userId);
    //     $stmt->execute();
    //     echo "User $userId inserted into referrals successfully.<br>";
    // }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
