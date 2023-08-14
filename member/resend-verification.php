<?php
include 'core/connection.php';

if(!isset($_SESSION['verification_email_user_name']))
{
  header("Location: login.php"); 
}
else
{

    $user_name = $_SESSION['verification_email_user_name'];

    // echo $user_name;

        $sql = "SELECT * FROM user_registration WHERE user_name = ? or email=?";
		$stmt = $con->prepare($sql); 
		$stmt->bind_param("ss", $user_name, $user_name);
		$stmt->execute();
		$result = $stmt->get_result(); // get the mysqli result
	    $data = $result->fetch_assoc();
		$email = $data['email'];
		$full_name = $data['full_name'];
// 		die();
// 			Check Email Verification Status
		if(isset($_POST['send_email']) && $data['verified'] == '0'){
		    
		    // Inset into user_registration table
	 $email = $data['email'];
    $code = md5($email).rand();
    $verify_link = 'https://'.$_SERVER['HTTP_HOST']."/member/email-verification.php?module=email-verification&email=".$email."&code=".$code;

  $updateCode="update user_registration set email_code='$code' where email='$email'";

 $res=mysqli_query($con,$updateCode);
 if(!$res){ 
    $_SESSION['errorMsg']='Failed '.mysqli_error($con);
    header("Location: login.php");
    exit();
  }else{

     $subject = "Verification Link - My Events Int";
     $email_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title>My Events Int</title>
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
                    <img src="https://myeventsint.com/member/assets/images/logo-basic2.png" alt="logo" width="217" height="81" style="display:block; margin-bottom: 15px;">
                    
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
                    <table style="width: 100%" bgcolor="#fa6a21" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
                        <tr>
                            <td align="center" height="50" style=" padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;background:#087ac2" class="button">
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
                <td align="center" bgcolor="#fa6a21" style="padding: 15px 10px 15px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;">
                    <b><a style="text-decoration:none; color:white" href="https://myeventsint.com/">© All Rights Reserved - myeventsint.</a></b>
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
         	$_SESSION['successMsg'] = "Email send to your email address please verify your account first!";
			header("Location: resend-verification.php");
			$stmt->close();
			exit();
     }
  }
		    
		    
		    
		
		}
                
                
    
} 


?>


<!doctype html>
<html lang="en">


<!-- Mirrored from codervent.com/rocker/demo/vertical/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 15 Aug 2021 08:50:21 GMT -->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">
    <title>Email Verification</title>
</head>
<style>
    body
    {
background-color: #FFF9B5;
background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='100%25' viewBox='0 0 1600 800'%3E%3Cg %3E%3Cpath fill='%23ffefb0' d='M486 705.8c-109.3-21.8-223.4-32.2-335.3-19.4C99.5 692.1 49 703 0 719.8V800h843.8c-115.9-33.2-230.8-68.1-347.6-92.2C492.8 707.1 489.4 706.5 486 705.8z'/%3E%3Cpath fill='%23ffe5aa' d='M1600 0H0v719.8c49-16.8 99.5-27.8 150.7-33.5c111.9-12.7 226-2.4 335.3 19.4c3.4 0.7 6.8 1.4 10.2 2c116.8 24 231.7 59 347.6 92.2H1600V0z'/%3E%3Cpath fill='%23ffd9a5' d='M478.4 581c3.2 0.8 6.4 1.7 9.5 2.5c196.2 52.5 388.7 133.5 593.5 176.6c174.2 36.6 349.5 29.2 518.6-10.2V0H0v574.9c52.3-17.6 106.5-27.7 161.1-30.9C268.4 537.4 375.7 554.2 478.4 581z'/%3E%3Cpath fill='%23ffcb9f' d='M0 0v429.4c55.6-18.4 113.5-27.3 171.4-27.7c102.8-0.8 203.2 22.7 299.3 54.5c3 1 5.9 2 8.9 3c183.6 62 365.7 146.1 562.4 192.1c186.7 43.7 376.3 34.4 557.9-12.6V0H0z'/%3E%3Cpath fill='%23FFBD9A' d='M181.8 259.4c98.2 6 191.9 35.2 281.3 72.1c2.8 1.1 5.5 2.3 8.3 3.4c171 71.6 342.7 158.5 531.3 207.7c198.8 51.8 403.4 40.8 597.3-14.8V0H0v283.2C59 263.6 120.6 255.7 181.8 259.4z'/%3E%3Cpath fill='%23ffc49a' d='M1600 0H0v136.3c62.3-20.9 127.7-27.5 192.2-19.2c93.6 12.1 180.5 47.7 263.3 89.6c2.6 1.3 5.1 2.6 7.7 3.9c158.4 81.1 319.7 170.9 500.3 223.2c210.5 61 430.8 49 636.6-16.6V0z'/%3E%3Cpath fill='%23ffcb9a' d='M454.9 86.3C600.7 177 751.6 269.3 924.1 325c208.6 67.4 431.3 60.8 637.9-5.3c12.8-4.1 25.4-8.4 38.1-12.9V0H288.1c56 21.3 108.7 50.6 159.7 82C450.2 83.4 452.5 84.9 454.9 86.3z'/%3E%3Cpath fill='%23ffd39a' d='M1600 0H498c118.1 85.8 243.5 164.5 386.8 216.2c191.8 69.2 400 74.7 595 21.1c40.8-11.2 81.1-25.2 120.3-41.7V0z'/%3E%3Cpath fill='%23ffda9a' d='M1397.5 154.8c47.2-10.6 93.6-25.3 138.6-43.8c21.7-8.9 43-18.8 63.9-29.5V0H643.4c62.9 41.7 129.7 78.2 202.1 107.4C1020.4 178.1 1214.2 196.1 1397.5 154.8z'/%3E%3Cpath fill='%23FFE19A' d='M1315.3 72.4c75.3-12.6 148.9-37.1 216.8-72.4h-723C966.8 71 1144.7 101 1315.3 72.4z'/%3E%3C/g%3E%3C/svg%3E");
background-attachment: fixed;
background-size: cover;

     }
</style>
<body>
<!--wrapper-->
<div class="wrapper">
    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                                        <div class="mb-4 text-center">
                                            <img src="assets/images/logo-basic2.png" width="180" alt="" />
                                        </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                <div class="text-center">
                                    <h3 class="">Verify Email</h3>
<!--                                    <p>Don't have an account yet? <a href="signup.php">Sign up here</a>-->
<!--                                    </p>-->
                                </div>

                                <div class="login-separater text-center mb-4"> <span>EMAIL VERIFICATION</span>
                                    <hr/>
                                </div>
                                <div class="form-body">
                                    <?php if(isset($_SESSION['successMsg'])): ?>
                                    <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-white">Success </h6>
                                                <div class="text-white"><?php echo $_SESSION['successMsg']; ?></div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php  unset($_SESSION['successMsg']);     endif;  ?>
                                    
                                    <?php if(isset($_SESSION['errorMsg'])): ?>
                                    <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-white">Error </h6>
                                                <div class="text-white"><?php echo $_SESSION['errorMsg']; ?></div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php  unset($_SESSION['errorMsg']);     endif;  ?>
                                    <form method="POST" class="row g-3">
                                        <div class="col-12">
                                            <label for="username" class="form-label">Email</label>
                                            <input type="email" disabled value="<?php echo $email?>" class="form-control" id="username" placeholder="Enter Email">
                                        
                                        </div>
                                        <small class="text-danger">If you lost previous email...</small>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" id="submit" name="send_email" class="btn bg-gradient-ibiza text-white"><i class="bx bxs-envelope"></i>Resend Verification Link</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</div>
<!--end wrapper-->
<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<!--Password show & hide js -->
<script>
    $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("bx-hide");
                $('#show_hide_password i').removeClass("bx-show");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("bx-hide");
                $('#show_hide_password i').addClass("bx-show");
            }
        });
    });
</script>
<!--app JS-->
<script src="assets/js/app.js"></script>
<script>
     $('#submit').on("click",function(){
         setTimeout(function(){ 
                     
                      $('#submit').prop('disabled', true);
                   $('#submit').html("Processing...");
               
                     
                 }, 1000);
     })
    
    
</script>
</body>


<!-- Mirrored from codervent.com/rocker/demo/vertical/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 15 Aug 2021 08:50:22 GMT -->
</html>