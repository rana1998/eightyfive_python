<?php
require_once('../core/config.php');
session_start();
$pdo = getDB();   

try {
    $userName= $_SESSION['admin_name'];
    if (isset($_POST['action']) && $_POST['action']=="confirm-otp") {
        $owner = $_POST['owner'];
        $email = $_POST['email'];
        //Get data from admin_wallet_summery Admin Information 
        $q = "SELECT * FROM admin_wallet_summary WHERE owner=:owner OR email=:email";
        $stmt = $pdo->prepare($q);
        $stmt->bindParam(':owner', $owner, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();
        $dbOtpCode = (int)$res['otp_code'];
        $userInptOTP = (int)$_POST['userInptOTP'];
        
        if (empty($userInptOTP)) {
            //Update otp code null after successfully matched otp
            $update = "UPDATE admin_wallet_summary SET otp_code='' WHERE owner=:owner OR email=:email";
            $stmt = $pdo->prepare($update);
            $stmt->bindParam(':owner', $owner, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $_SESSION['isOTPmatch'] = false;
            echo "failed";
            exit();
        }elseif($userInptOTP != $dbOtpCode){
            //Update otp code null after successfully matched otp
            $update = "UPDATE admin_wallet_summary SET otp_code='' WHERE owner=:owner OR email=:email";
            $stmt = $pdo->prepare($update);
            $stmt->bindParam(':owner', $owner, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $_SESSION['isOTPmatch'] = false;
            echo "failed";
            exit();
        } elseif ($userInptOTP == $dbOtpCode) {
            //Update otp code null after successfully matched otp
            $update = "UPDATE admin_wallet_summary SET otp_code='' WHERE owner=:owner OR email=:email";
            $stmt = $pdo->prepare($update);
            $stmt->bindParam(':owner', $owner, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();
            $_SESSION['isOTPmatch'] = true;
            echo "success";
            exit();
        }
    } else {
        header('Location: index.php');
        exit();
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
