<?php
include '../connection.php';





// echo "ajax working";
// exit();



date_default_timezone_set("Asia/Karachi");
$currentDateTime= date('Y-m-d h:i:s A');
$getCurrentDate = substr($currentDateTime,0,10);
//$getCurrentTime= substr($currentDateTime,11,11);
//SIGNUP FORM CODE

// $lastRowQuery="SELECT * FROM `user_registration` ORDER BY id DESC LIMIT 1";
// $lastRowQueryResult = mysqli_query($con,$lastRowQuery);
// $lastRowQueryData = mysqli_fetch_assoc($lastRowQueryResult);

// // session_destroy();

// $lastRowId= $lastRowQueryData['id']+1;
// $user_name = 'rc000'.$lastRowId;


if (isset($_POST['sponsor_name']) 
and isset($_POST['username']) 
and isset($_POST['full_name']) 
and isset($_POST['country_name']) 
and isset($_POST['email'])
and isset($_POST['password'])
)
{


  $sponsor_name=strtolower(mysqli_real_escape_string($con, $_POST['sponsor_name']));  
  $sponsor_name = preg_replace("/\s+/", "", $sponsor_name);

  $user_name=strtolower(mysqli_real_escape_string($con, $_POST['username']));       
  $user_name = preg_replace("/\s+/", "", $user_name);
  
  $full_name=strtolower(mysqli_real_escape_string($con, $_POST['full_name']));
  
  $country= strtolower(mysqli_real_escape_string($con, $_POST['country_name']));
  
  $email= strtolower(mysqli_real_escape_string($con, $_POST['email']));
  $email = preg_replace("/\s+/","", $email);
  
  $password=$password1= mysqli_real_escape_string($con, $_POST['password']);


  //check username already exist or not
  $select="SELECT * FROM user_registration WHERE user_name='$user_name'";
  $res=mysqli_query($con,$select);
  $data=mysqli_fetch_array($res); 

  if($data['user_name']==$user_name){
  echo 'Error Username Already Taken.';
  exit();
  }

  //check email already exist or not
  $select="SELECT * FROM user_registration WHERE email='$email'";
  $res=mysqli_query($con,$select);
  $data=mysqli_fetch_array($res);

  if($data['email']==$email){
  echo 'Error Email Already Taken.';
  exit();
  }

  $select="SELECT * FROM user_registration WHERE user_name='$sponsor_name'";
  $res=mysqli_query($con,$select);
  $data=mysqli_num_rows($res);           
  
  if($data == 0){
  echo 'Error Invalid Sponsor Name.';
  exit();
  }
  
  //checking sponsor status start
  $row = mysqli_fetch_assoc($res);
  
    if($row['status']!='Approved')
    {
        echo 'Error Sponsor have no investment';
        exit();
    }  
  
  //checking sponsor status end
  
  $sname1=$sponsor_name;

  $insert="UPDATE user_registration SET direct_team = direct_team + 1 WHERE user_name='$sname1'";
  $res=mysqli_query($con,$insert);  

while ($sname1!='') {
   $insert="UPDATE user_registration SET total_team = total_team + 1 WHERE user_name='$sname1'";
   $res=mysqli_query($con,$insert);  
     
  $select="SELECT * FROM user_registration WHERE user_name='$sname1'";
  $res=mysqli_query($con,$select);
  $data=mysqli_fetch_array($res);
  $sname1=$data['sponsor_name'];
   
}

  // $hash_pass = $password1;
  $hash_pass = password_hash($password1, PASSWORD_BCRYPT);

// Inset into user_registration table
    $code = md5($email).rand();
    $verify_link = 'https://'.$_SERVER['HTTP_HOST']."/member/email-verification.php?module=email-verification&email=".$email."&code=".$code;

  $insert="INSERT INTO user_registration 
         (`sponsor_name`,`user_name`,`password`,`full_name`,`email`,`email_code`,`country`)
  VALUES ('$sponsor_name','$user_name','$hash_pass','$full_name','$email','$code','$country')";

 $res=mysqli_query($con,$insert);
 if(!$res){ 
    echo '0 Failed '.mysqli_error($con);
    exit();
  }
  else{
      
      $selectImages = "select * from project_management";
$resultImages = mysqli_query($con,$selectImages);
$rowImages = mysqli_fetch_assoc($resultImages);

$logo = $rowImages['logo'];
$favIcon = $rowImages['fav_icon'];

$logo1 = 'https://mazicoin.com/admin_portal/'.$logo;
$favIcon1 = 'https://mazicoin.com/admin_portal/'.$favIcon;

     $subject = "Signup Email - mazicoin.com";
     $email_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title>globalinvestorshub.com</title>
        <meta name="viewport" content="width=device-width">
        <!-- Favicon icon -->
        <link rel="icon" href="" type="image/x-icon">
       <style type="text/css">
            @media only screen and (max-width: 1240px), screen and (max-device-width: 1240px) {
                body[yahoo] .buttonwrapper { background-color: transparent !important; }
                body[yahoo] .button { padding: 0 !important; }
                body[yahoo] .button a { background-color: #9b59b6; padding: 15px 25px !important; }
            }

            @media only screen and (min-device-width: 601px) {
                .content { width: 600px !important; }
                .col387 { width: 450px !important; }
            }
        </style>
    </head>
    

    <body bgcolor="#34495E" style="margin: 0; padding: 0;" yahoo="fix">

        
        <!--[if (gte mso 9)|(IE)]>
        <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td>
        <![endif]-->
       
        <table align="left" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%;" class="content">
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 30px 10px 00px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
                    <img src="'.$logo1.'" alt="Welcome Email" width="256" height="60" style="display:block; margin-bottom: 15px;">
                    
                </td>
            </tr>
            
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 10px 10px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; ">
                    <b>Welcome to mazicoin!</b>
                </td>
            </tr>  

            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 10px 0px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; ">
                    <span >mazicoin is one of the best business platforms. We provide the best business opportunity and you can establish your own business even working from home. </span>
                </td>
            </tr> 
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 20px 10px 0px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; ">
                    <span >
                    We offer some amazing business packages. You can start a business with us at a minimum of $100 and you can invest up to $5,000. We offer amazing business income against these packages.
                 </span>
                </td>
            </tr> 
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 20px 10px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; border-bottom: 2px solid #d0cece;">
                    <span >
                    You can earn and increase your lifestyle by referring our system to your relations. We offer some amazing bonuses and commissions. So buy a package and refer us to change your financial life.
</span>
                </td>
            </tr> 
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 20px 10px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; ">
                    <b>Login Details:</b>
                </td>
            </tr>
            <tr>
              <td align="center" bgcolor="#ffffff" style="padding: 0px 10px 40px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 2px solid #d0cece;">
                    <!--[if (gte mso 9)|(IE)]>
                      <table width="387" align="left" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td>
                    <![endif]-->
                                <table class="col387" align="left" border="0" cellpadding="0" cellspacing="0" style= "width: 100%">
                                    <tr>
                                        <td>
                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                        <th style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">Email: </th>
                                        <td style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">'. $email.'</td>
                                        </tr>
                                        <tr>
                                        <th style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">Username: </th>
                                        <td style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">'. $user_name.'</td>
                                        </tr>
                                        <tr>
                                        <th style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">Name: </th>
                                        <td style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">'. $full_name.'</td>
                                        </tr>
                                        <tr>
                                        <th style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">Password: </th>
                                        <td style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">'. $password.'</td>
                                        </tr>
                                    
                                        <th style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">Registration Date:</th>
                                        <td style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">'. $getCurrentDate.'</td>
                                        </tr>
                                        
                                </table>
                            </td>
                        </tr>
                                       
              </td>
            </tr>  
            <tr>
                <td align="left" bgcolor="#f9f9f9" style="padding: 20px 10px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 22px; line-height: 30px; ">
                    <span>Verify Your Email.</span>
                </td>
            </tr> 
            <tr>
                <td align="left" bgcolor="#f9f9f9" style="padding: 0px 10px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; ">
                    <span>Click the button below to verify your email. Without Verfication you can\'t login to your account. This is one time verfication process. </span>
                </td>
            </tr> 

            <tr>
                <td align="left" bgcolor="#f9f9f9" style="padding: 0px 10px 30px 10px; font-family: Arial, sans-serif;">
                    <table style="width: 100%" bgcolor="#0373bd" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
                        <tr>
                            <td align="center" height="50" style=" padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <a href="'.$verify_link.'" target="_blank" style="color: #ffffff; text-align: center; text-decoration: none;">Verify Now</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#f9f9f9" style="padding: 0px 10px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 14px; line-height: 16px; ">
                    <span>If the button doesn\'t work, copy and paste the URL in your browser:</span>
                </td>
            </tr> 
            <tr>
                <td align="center" bgcolor="#f9f9f9" style="padding: 0px 10px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 14px; line-height: 16px; ">
                    <span><a href="'.$verify_link.'">'.$verify_link.'</a></span>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#ff9700" style="padding: 15px 10px 15px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;text-decoration:none">
                    <b><a style="text-decoration:none" href="#">© All Rights Reserved - mazicoin.com</a></b>
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


     if(send_email($param) ){
         echo 'Your account has been created successfully please verify your email.';
         exit();
     }
  }
 
     

}
else
{
    echo "Error connection error";
}
// End of Form Submit //

//Email protocol




?>