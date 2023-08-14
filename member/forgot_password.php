<?php
include 'core/connection.php';
$page_title = "Recover Password";

// Send Password Reset Link to your email address...!
if(isset($_POST['reset_pass'])){
    $email = strtolower(mysqli_real_escape_string($con, $_POST['email_address']));
    $email = preg_replace("/\s+/", "", $email);        
    
    // Check Form Empty or not.
    if(empty($email)){
    $_SESSION['errorMsg'] = "Please Enter Valid Email Address.";
    header("Location: forgot_password.php");
    exit();
    }
    
    $sql = "SELECT * FROM user_registration WHERE email = ?";
    $stmt = $con->prepare($sql); 
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
        if($result->num_rows < 1){
            $_SESSION['errorMsg'] = "Please Enter Valid Email Address.";
            header("Location: forgot_password.php");
            $stmt->close();
            exit();
    
        }
    $data = $result->fetch_assoc(); // fetch data  
    $full_name = $data['full_name'];
    $code = md5($email).rand();
    $verify_link = $_SERVER['HTTP_HOST']."/member/reset-pass.php?module=reset&email=".$email."&code=".$code;
    $sql = "UPDATE user_registration SET  email_code = ?  WHERE email = ?";
    $stmt = $con->prepare($sql); 
    $stmt->bind_param("ss",$code ,$email);
    
    if ($stmt->execute() === TRUE) {
    
        // $stmt->close();
        // $_SESSION['successMsg']='Check Your Email.Before email';
        // header("Location: login.php");
        // exit();
    
    
    $subject = "Password Reset - fbsworldnetwork";
    $email_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    <html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>OTP Code | Wealth Trade Hub</title>
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="https://wealthtradehub.com/affiliate/images/icons/logo.png" type="image/x-icon">
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
                <td align="left" bgcolor="#ffffff" style="padding: 30px 10px 0px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 20px; font-weight: bold;">
                    <img src="https://fbsworldnetwork.com/member/assets/images/logo-basic2.png" alt="logo" width="217" height="81" style="display:block; margin-bottom: 15px;">
                    
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 20px 20px 0px 10px; color: green; font-family: Arial, sans-serif; font-size: 15px; line-height: 25px; ">
                    <b>Forgot your password? Let\'s get you a new one!</b><br>                    
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
                    <b>© All Rights Reserved - fbsworldnetwork</a></b>
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
        $_SESSION['successMsg']='Check Your Email.';
        header("Location: login.php");
        $stmt->close();
        exit();
    }
    
    
    
    
    }else{
        $_SESSION['errorMsg'] =  "Error inserting record: " . $con->error;
        header("Location: forgot_password.php");
        $stmt->close();
        exit();
    
    }
    
    } // End of isset
    
    // if(isset($_POST['recover_pass'])){
    // # code...
    // $password1 = mysqli_real_escape_string($conn, $_POST['password1']);
    // $password2 = mysqli_real_escape_string($conn, $_POST['password2']);
    // if(empty($password1) AND empty($password2)  ){
    // $_SESSION['errorMsg'] = "Password cannot be blank";
    // header("Location: forgot-password.php?module=reset&email=".$_GET['email']."&code=".$_GET['code']);
    // exit();
    // }elseif($password1 == $password2)
    // {
    // $email = $_GET['email'];
    // $hash_pass = password_hash($password1, PASSWORD_BCRYPT);
    
    // $sql = "UPDATE user_registration SET password = ?, email_code = NULL WHERE email= ? ";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("ss", $hash_pass, $email);
    
    // if ($stmt->execute() === TRUE) {
    //     $_SESSION['successMsg']='Password Changed.';
    //     header("Location: login.php");
    //     $stmt->close();
    //     exit();
    
    // }else{
    //     $_SESSION['errorMsg'] =  "Error inserting record: " . $conn->error;
    //     header("Location: forgot-password.php");
    //     $stmt->close();
    //     exit();
    
    // }
    
    // }else{
    // $_SESSION['errorMsg'] = "Password Invalid";
    // header("Location: forgot-password.php?module=reset&email=".$_GET['email']."&code=".$_GET['code']);
    // $stmt->close();
    // exit();
    // }
    
    // }
    
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
    <title>Forgot Password</title>
</head>
<style>
    body
    {
background-color: #880900;
background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 2000 1500'%3E%3Cdefs%3E%3CradialGradient id='a' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%23BA2D2D'/%3E%3Cstop offset='1' stop-color='%23880900'/%3E%3C/radialGradient%3E%3ClinearGradient id='b' gradientUnits='userSpaceOnUse' x1='0' y1='750' x2='1550' y2='750'%3E%3Cstop offset='0' stop-color='%23a11b17'/%3E%3Cstop offset='1' stop-color='%23880900'/%3E%3C/linearGradient%3E%3Cpath id='s' fill='url(%23b)' d='M1549.2 51.6c-5.4 99.1-20.2 197.6-44.2 293.6c-24.1 96-57.4 189.4-99.3 278.6c-41.9 89.2-92.4 174.1-150.3 253.3c-58 79.2-123.4 152.6-195.1 219c-71.7 66.4-149.6 125.8-232.2 177.2c-82.7 51.4-170.1 94.7-260.7 129.1c-90.6 34.4-184.4 60-279.5 76.3C192.6 1495 96.1 1502 0 1500c96.1-2.1 191.8-13.3 285.4-33.6c93.6-20.2 185-49.5 272.5-87.2c87.6-37.7 171.3-83.8 249.6-137.3c78.4-53.5 151.5-114.5 217.9-181.7c66.5-67.2 126.4-140.7 178.6-218.9c52.3-78.3 96.9-161.4 133-247.9c36.1-86.5 63.8-176.2 82.6-267.6c18.8-91.4 28.6-184.4 29.6-277.4c0.3-27.6 23.2-48.7 50.8-48.4s49.5 21.8 49.2 49.5c0 0.7 0 1.3-0.1 2L1549.2 51.6z'/%3E%3Cg id='g'%3E%3Cuse href='%23s' transform='scale(0.12) rotate(60)'/%3E%3Cuse href='%23s' transform='scale(0.2) rotate(10)'/%3E%3Cuse href='%23s' transform='scale(0.25) rotate(40)'/%3E%3Cuse href='%23s' transform='scale(0.3) rotate(-20)'/%3E%3Cuse href='%23s' transform='scale(0.4) rotate(-30)'/%3E%3Cuse href='%23s' transform='scale(0.5) rotate(20)'/%3E%3Cuse href='%23s' transform='scale(0.6) rotate(60)'/%3E%3Cuse href='%23s' transform='scale(0.7) rotate(10)'/%3E%3Cuse href='%23s' transform='scale(0.835) rotate(-40)'/%3E%3Cuse href='%23s' transform='scale(0.9) rotate(40)'/%3E%3Cuse href='%23s' transform='scale(1.05) rotate(25)'/%3E%3Cuse href='%23s' transform='scale(1.2) rotate(8)'/%3E%3Cuse href='%23s' transform='scale(1.333) rotate(-60)'/%3E%3Cuse href='%23s' transform='scale(1.45) rotate(-30)'/%3E%3Cuse href='%23s' transform='scale(1.6) rotate(10)'/%3E%3C/g%3E%3C/defs%3E%3Cg %3E%3Cg transform=''%3E%3Ccircle fill='url(%23a)' r='3000'/%3E%3Cg opacity='0.5'%3E%3Ccircle fill='url(%23a)' r='2000'/%3E%3Ccircle fill='url(%23a)' r='1800'/%3E%3Ccircle fill='url(%23a)' r='1700'/%3E%3Ccircle fill='url(%23a)' r='1651'/%3E%3Ccircle fill='url(%23a)' r='1450'/%3E%3Ccircle fill='url(%23a)' r='1250'/%3E%3Ccircle fill='url(%23a)' r='1175'/%3E%3Ccircle fill='url(%23a)' r='900'/%3E%3Ccircle fill='url(%23a)' r='750'/%3E%3Ccircle fill='url(%23a)' r='500'/%3E%3Ccircle fill='url(%23a)' r='380'/%3E%3Ccircle fill='url(%23a)' r='250'/%3E%3C/g%3E%3Cg transform='rotate(-3.6 0 0)'%3E%3Cuse href='%23g' transform='rotate(10)'/%3E%3Cuse href='%23g' transform='rotate(120)'/%3E%3Cuse href='%23g' transform='rotate(240)'/%3E%3C/g%3E%3Ccircle fill-opacity='0.08' fill='url(%23a)' r='3000'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
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
                                       
                    <div class="card">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                 <div class="mb-4 text-center">
                                            <img src="assets/images/logo-basic2.png" width="256" alt="" />
                                        </div>
                                <div class="text-center">
                                    <h3 class="">Forgot Password</h3>
<!--                                    <p>Don't have an account yet? <a href="signup.php">Sign up here</a>-->
<!--                                    </p>-->
                                </div>

                                <div class="login-separater text-center mb-4"> <span>FORGOT YOUR PASSWORD?</span>
                                    <hr/>
                                </div>
                                <div class="form-body">
                                    <P style="font-size: 12px;text-align: center;color: #9d9d9d">Don't worry, we'll send you an email to reset your password.</P>
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
                                            <input type="email" name="email_address" class="form-control" id="username" placeholder="Enter Email">
                                            <small>Don't remember your email? <a href="#" class="text-muted">Contact Support</a></small>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" name="reset_pass" class="btn bg-gradient-rose-button text-white"><i class="bx bxs-lock-open"></i>Reset password</button>
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

</body>


<!-- Mirrored from codervent.com/rocker/demo/vertical/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 15 Aug 2021 08:50:22 GMT -->
</html>