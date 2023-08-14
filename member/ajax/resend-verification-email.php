<?php

include "../connection.php";
$userName= $_SESSION['verification_email_user_name'];





$q="select * from user_registration where user_name='$userName'";
$result=mysqli_query($con,$q);
$res=mysqli_fetch_assoc($result);
$email = $res['email'];
$full_name = $res['full_name'];

$code = md5($email).rand();
$verify_link = 'https://'.$_SERVER['HTTP_HOST']."/member/email-verification.php?module=email-verification&email=".$email."&code=".$code;


$qy="update user_registration set email_code='$code' where user_name='$userName'";
$resultt= mysqli_query($con,$qy);


if(isset($_POST['resend_verification']))
    {
      $selectImages = "select * from project_management";
        $resultImages = mysqli_query($con,$selectImages);
        $rowImages = mysqli_fetch_assoc($resultImages);
        
        $logo = $rowImages['logo'];
        $favIcon = $rowImages['fav_icon'];
        
        $logo1 = 'https://ecf9-2409-4042-4d82-4ad8-6112-cf03-1610-bc2e.ngrok-free.app/mlmgtron/mlm_landing/index.php/admin_portal/'.$logo;
        $favIcon1 = 'https://account.vizeoncapital.com/admin_portal/'.$favIcon;   
    $subject = "Verification - vizeoncapital";
    $email_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Verification | globalinvestorshub.com</title>
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
                <td align="center" bgcolor="#ffffff" style="padding: 30px 10px 0px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 20px; font-weight: bold;">
                     <img src="'.$logo1.'" alt="Welcome Email" width="256" height="60" style="display:block; margin-bottom: 15px;">
                   
                </td>
            </tr>
           
            <tr>
                <td align="center" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 32px; line-height: 25px; ">
                    <b>Verify your email</b><br>                    
                </td>
            </tr>
          
            <tr>
                <td align="center" bgcolor="#ffffff" style="padding: 20px 25px 20px 0px; font-family: Arial, sans-serif;">
                    <table bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
                        <tr>
                            <td align="center" height="50" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 18px; font-weight: bold;" class="button">
                                <a href="'.$verify_link.'" style="background:#ED3237;color: white; text-align: center;padding:8px;border-radius:8px;text-decoration:none">Verify Now</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#ff9700" style="padding: 15px 10px 15px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px;">
                    <b>vizeoncapital © All Rights Reserved</a></b>
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
    $param = array(
        'subject' => $subject ,
        'email_template' => $email_template ,
        'receiver_email' => $email ,
        'receiver_name' => $full_name 
     );
    
    
    if( send_email($param) )
    {
        
        echo "Verification Email Send Successfully";
    }
    else
    {
        // $_SESSION['errorMsg'] =  "Error inserting record: " . $conn->error;
        // header("Location: index.php");
        // $stmt->close();
        // exit();
        echo "Email Send Not Send";
    
    }
    
    }