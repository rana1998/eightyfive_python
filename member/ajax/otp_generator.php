<?php

include "../connection.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';
$mail = new PHPMailer(true);



//Create an instance; passing `true` enables exceptions
//$mail = new PHPMailer(true);
$userName= $_SESSION['user_name'];


$selectImages = "select * from project_management";
$resultImages = mysqli_query($con,$selectImages);
$rowImages = mysqli_fetch_assoc($resultImages);

$logo = $rowImages['logo'];
$favIcon = $rowImages['fav_icon'];

$logo1 = 'https://mazicoin.com/admin_portal/'.$logo;
$favIcon1 = 'https://mazicoin.com/admin_portal/'.$favIcon;


$q="select * from user_registration where user_name='$userName' or email='$userName'";
$result=mysqli_query($con,$q);
$res=mysqli_fetch_assoc($result);
$to = $res['email'];
$full_name = $res['full_name'];

// echo $email . $full_name;
// die();

if(isset($_POST['otp_send']))
    {
           
          $select = "SELECT * FROM `project_management` where id = '1'";
          $result1=mysqli_query($con,$select);
          $res1=mysqli_fetch_assoc($result1);
          
          if($res1['otp_status'] != 1)
          {
              echo "Otp code blocked by admin";
              exit();
          }
           
         $digits = 6;
         $code= rand(pow(10, $digits-1), pow(10, $digits)-1);
          
       // Update OTP Code in User Table
         $update="UPDATE user_registration SET otp_code='$code' WHERE user_name='$userName' or email='$userName'";
         $res=mysqli_query($con,$update);
         if($res == TRUE)
            {
//                  echo $code;
// die(); 


                // $_SESSION['successMsg']='OTP send to your email';
                $subject = "OTP for GTRON Withdrawals";
    $email_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>OTP Code | fbsworldnetwork</title>
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="'.$favIcon1.'" type="image/x-icon">
       <style type="text/css">
            @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
                body[yahoo] .buttonwrapper { background-color: transparent !important; }
                body[yahoo] .button { padding: 0 !important; }
                body[yahoo] .button a { background-color: #9b59b6; padding: 15px 25px !important; }
            }

            @media only screen and (min-device-width: 601px) {
                .content { width: 600px !important; }
                .col387 { width: 387px !important; }
            }
        </style>
    </head>
    <body bgcolor="#34495E" style="margin: 0; padding: 0;" yahoo="fix">
        <!--[if (gte mso 9)|(IE)]>
        <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td>
        <![endif]-->
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;" class="content">
            <tr>
                <td style="padding: 15px 10px 15px 10px;">
                    
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#070b20" style="padding: 30px 10px 0px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 20px; font-weight: bold;">
                     <img src="https://mlm-user.eighty5technologies.com/images/gtron-logo.svg" alt="GTRON" width="256" height="60" style="display:block; margin-bottom: 15px;">
                   
                </td>
            </tr>
           
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px; ">
                    <b>One time password (2FA Code) is send to your register email. Please use this code for furthur action. This code will expire after successful action.</b><br>                    
                </td>
            </tr>
          
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 20px 25px 20px 0px; font-family: Arial, sans-serif;">
                    <table bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
                        <tr>
                            <td align="center" height="50" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 32px; font-weight: bold;" class="button">
                                <span style="color: #000000; text-align: center;">2FA Code: </span>
                                <span style="color: #ED3237; text-align: center;">'.$code.'</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
             <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: #ED3237; font-family: Arial, sans-serif; font-size: 15px; line-height: 25px; ">
                    <b>Warning:</b><br>                    
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px; ">
                    <b>* This code is confidential and please don\'t share this with code with anyone.</b><br>                    
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px; ">
                    <b>* Keep your registered email and password confidential because code is sent to that email.</b><br>                    
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 30px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px; ">
                    <b>* This code is sent at your request and the company is not responsible for any misuse.</b><br>                    
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#070b20" style="padding: 15px 10px 15px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px;">
                    <b>Gtron © All Rights Reserved</a></b>
                </td>
            </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
                </td>
            </tr>
        </table>
        <![endif]-->
    </body>
</html>';


$mail->isSMTP();
$mail->Host = 'mail.eighty5technologies.com';
$mail->Port = 465;
$mail->SMTPAuth = true;
$mail->Username = 'mailcheck@eighty5technologies.com';
$mail->Password = 'Sb(QUZi5@t}';
$mail->SMTPSecure = 'ssl';

// Email content
$mail->setFrom('mailcheck@eighty5technologies.com', 'GTRON');
$mail->addAddress($to, 'Recipient Name');
$mail->Subject = $subject;
$mail->isHTML(true);
$mail->Body = $email_template;



    if ($mail->send()) {
        // $_SESSION['successMsg']='Check Your Email and Enter OTP Code.';
        // // unset($_SESSION['email_verify']);
        // header("Location: index.php?");
        // $stmt->close();
        // exit();
        echo "Email Send Successfully";
    
    }else{
        // $_SESSION['errorMsg'] =  "Error inserting record: " . $conn->error;
        // header("Location: index.php");
        // $stmt->close();
        // exit();
        echo "Email Send Not Send";
    
    }

}else{
    // $_SESSION['errorMsg'] =  "Error inserting record: " . $conn->error;
    // header("Location: index.php");
    // $stmt->close();
    // exit();
    echo "Email Send Not Send";

}


}else{
    // $_SESSION['errorMsg'] =  "Error inserting record: " . $conn->error;
    // header("Location: index.php");
    // $stmt->close();
    // exit();
    echo "Email Send Not Send";

}
    