<?php
// Get Country Details
include '../connection.php';


if(isset($_POST['email']))
{
    $email = strtolower(mysqli_real_escape_string($con, $_POST['email']));
    $email = preg_replace("/\s+/", "", $email);  
    
    $sql="select * from user_registration where email='$email'";
    $result=mysqli_query($con,$sql);
    if (mysqli_num_rows($result) > 0)
    {
        
        $data = $result->fetch_assoc(); // fetch data  
        $full_name = $data['full_name'];
        $code = md5($email).rand();
        $verify_link = $_SERVER['HTTP_HOST']."/member/reset-pass.php?module=reset&email=".$email."&code=".$code;
        
        
        $sql = "UPDATE user_registration SET  email_code= '$code'  WHERE email ='$email'";
        $stmt = mysqli_query($con,$sql);
       
       $selectImages = "select * from project_management";
        $resultImages = mysqli_query($con,$selectImages);
        $rowImages = mysqli_fetch_assoc($resultImages);
        
        $logo = $rowImages['logo'];
        $favIcon = $rowImages['fav_icon'];
        
        $logo1 = 'https://mazicoin.com/admin_portal/'.$logo;
        $favIcon1 = 'https://mazicoin.com/admin_portal/'.$favIcon;
       
       
        $subject = "Password Reset - mazicoin.com";
        $email_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
            <title>OTP Code | Wealth Trade Hub</title>
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
                        <img src="'.$logo1.'" alt="logo" width="217" height="81" style="display:block; margin-bottom: 15px;">
                        
                    </td>
                </tr>
                <tr>
                    <td align="left" bgcolor="#ffffff" style="padding: 20px 20px 0px 10px; color: green; font-family: Arial, sans-serif; font-size: 15px; line-height: 25px; ">
                        <b>Forgot your password? Let\'s get you a new one!</b><br>                    
                    </td>
                </tr>
                <tr>
                    <td style="margin: 20px 20px">
                    <br>
                    if link button not work copy and paste this link in new window
                    <br>
                    <br>
                    <a href="'.$verify_link.'">'.$verify_link.'</a>
                    </td>
                </tr>
                <tr>
                    <td align="left" bgcolor="#ffffff" style="padding: 20px 25px 20px 0px; font-family: Arial, sans-serif;">
                        <table bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
                            <tr>
                                <td align="center" height="50" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 18px; font-weight: bold;" class="button">
                                    <!-- <span style="color: #000000; text-align: center;">OTP: </span> -->
                                    <a href="'.$verify_link.'" style="color: #ffffff; text-align: center;text-decoration: none;background-color: #ED3237;padding:10px;border-radius: 5px;">Reset Password</a>
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
                        <b>* This code is confidential and please don\'t share this with anyone.</b><br>                    
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
                    <td align="center" bgcolor="#ff9700" style="padding: 15px 10px 15px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px;">
                        <b>© All Rights Reserved - mazicoin.com</a></b>
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

        if( send_email($param) ){
            echo 'Email send successfully';
            exit();
        }
    }
    else
    {
        echo 'Error Invalid Email';
    }

}



   
    
?>