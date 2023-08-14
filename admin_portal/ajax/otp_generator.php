<?php
require_once('../core/config.php');
$pdo = getDB();   
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../../member/phpmailer/src/Exception.php';
require '../../member/phpmailer/src/PHPMailer.php';
require '../../member/phpmailer/src/SMTP.php';
$mail = new PHPMailer(true);

try {

    $userName = $_SESSION['admin_name'];

     // Prepare and execute the SELECT query
    $selectImages = "SELECT * FROM project_management";
    
    // $stmtImages = $pdo->query($selectImages);
    $stmtImages = $pdo->prepare($selectImages);
    $stmtImages->execute();
    // Fetch the row using fetch method
    $rowImages = $stmtImages->fetch();   
 
     // Access the values
    $logo = $rowImages['logo'];
    $favIcon = $rowImages['fav_icon'];

    $logo1 = 'https://mazicoin.com/admin_portal/'.$logo;
    $favIcon1 = 'https://mazicoin.com/admin_portal/'.$favIcon;


    // Rest of your code with PDO queries
    // ...

    if (isset($_POST['otp_send'])) {
        $owner = $_POST['owner'];
        $email = $_POST['email'];
        // ... Rest of your code with OTP verification and email sending ...

        //Get data from admin_wallet_summery Admin Information 
        $q = "SELECT * FROM admin_wallet_summary WHERE owner=:owner OR email=:email";
        $stmt = $pdo->prepare($q);
        $stmt->bindParam(':owner', $owner, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();
        $res = $stmt->fetch();

        $to = $res['email'];
        $full_name = $res['owner'];

        // ... Rest of your code with OTP generation and email sending ...

        if ($stmt->rowCount() > 0) {
            // ... Rest of your code with OTP generation and email sending ...

            $digits = 6;
            $code= rand(pow(10, $digits-1), pow(10, $digits)-1);

            $update = "UPDATE admin_wallet_summary SET otp_code=:code WHERE owner=:owner OR email=:email";
            $stmt = $pdo->prepare($update);
            $stmt->bindParam(':code', $code, PDO::PARAM_INT);
            $stmt->bindParam(':owner', $owner, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // ... Rest of your code with OTP generation and email sending ...
                // $subject = "OTP for GTRON Withdrawals";
                // $filename = '../resources/file.txt';
                // $content = file_get_contents($filename);
                // $content = str_replace("{{favIcon1}}", $favIcon1, $content);
				// $content = str_replace("{{code}}", $code, $content);
                // $email_template = $content;
                // $mail->isSMTP();
                // $mail->Host = 'mail.eighty5technologies.com';
                // $mail->Port = 465;
                // $mail->SMTPAuth = true;
                // $mail->Username = 'mailcheck@eighty5technologies.com';
                // $mail->Password = 'Sb(QUZi5@t}';
                // $mail->SMTPSecure = 'ssl';

                // // Email content
                // $mail->setFrom('mailcheck@eighty5technologies.com', 'GTRON');
                // $mail->addAddress($to, $full_name);
                // $mail->Subject = $subject;
                // $mail->isHTML(true);
                // $mail->Body = $email_template;

                // if ($mail->send()) {
                    echo "Email Sent Successfully";
                // } else {
                //     echo "Email Not Sent";
                // }
                
            } else {
                echo "Failed to update OTP code in the database.";
            }
        } else {
            echo "User not found in the database.";
        }
    } else {
        echo "Form not submitted.";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

?>
