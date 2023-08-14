<?php
include "header.php";


    if(isset($_POST['buy_pkg']) && $_POST){
        $uname = $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
        $pkg_price =intval( mysqli_real_escape_string($con, $_POST['pkg_amount']));
// ROI Daily 
$up_roi_daily = ($pkg_price * 3)/100;

// max roi 
$max_roi = $pkg_price * 2.7;        
// Getting Sponosr form user table

$sql = "SELECT * FROM user_registration WHERE user_name = ?"; // SQL with parameters
$stmt = $con->prepare($sql); 
$stmt->bind_param("s", $user_name);
if ($stmt->execute() === FALSE) {
    $_SESSION['errorMsg'] =  "Error inserting record: " . $con->error;
    $stmt->close();
    header("Location: normal_package.php");
    exit();

}
$result = $stmt->get_result(); // get the mysqli result
$data = $result->fetch_assoc();
$sponsor_name = $data['sponsor_name'];
$status = $data['status'];
$full_name = $data['full_name'];
$email = $data['email'];
$stmt->close();


// Insert into package details
$sql = "INSERT INTO package_details (user_name, sponsor_name,pkg_price,status,roi_status,approved_by,mode) 
                VALUES(?,?,?,'Approved','Active','ROI Package', 'New Package')";
$stmt = $con->prepare($sql); 
$stmt->bind_param("ssi", $user_name,$sponsor_name,$pkg_price);
if ($stmt->execute() === FALSE) {
    $_SESSION['errorMsg'] =  "Error inserting record: " . $con->error;
    $stmt->close();
    header("Location: normal_package.php");
    exit();

}
    $stmt->close();

// Updaate User table User
$sql = "UPDATE user_registration SET status = 'Approved', total_invest = total_invest + ?, max_roi = max_roi + ? WHERE user_name = ?";
$stmt = $con->prepare($sql); 
$stmt->bind_param("iis",$pkg_price, $max_roi, $user_name);
if ($stmt->execute() === FALSE) {
    $_SESSION['errorMsg'] =  "Error inserting record: " . $con->error;
    $stmt->close();
    header("Location: normal_package.php");
    exit();

}
    $stmt->close();

// Sending Mail

    $message = Swift_Message::newInstance();
    $message->setTo(array(
      $email => $full_name
    ));
    $message->setSubject("Package Activation - The Fx Pro");
    $message->setBody('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title>The Fx Pro - A Professionals Hub</title>
        <meta name="viewport" content="width=device-width">
        <!-- Favicon icon -->
        <link rel="icon" href="https://thefxpro.org/admin_portal/files/assets/images/favicon.png" type="image/x-icon">
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
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" style="color: #fff; font-family: Arial, sans-serif; font-size: 12px;">
                                Email not displaying correctly?  <a href="#" style="color: #F58634;">View it in your browser</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#F58634" style="padding: 20px 20px 20px 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
                    <img src="https://thefxpro.org/admin_portal/files/email_template/img/newsletter.png" alt="Package Activation Email" width="152" height="152" style="display:block; margin-bottom: 15px;">
                    Welcome <span style="color: #ffe81f">'.$full_name.'</span>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#ffffff" style="padding: 40px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
                    <b>Thank you very much for choosing The Fx Pro!</b><br>
                    Your Package Has Been Activated. <br> Details are given below.
                </td>
            </tr>   
            <tr>
                <td align="center" bgcolor="#ffffff" style="padding: 40px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
                    <table width="128" align="left" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="128" style="padding: 0 20px 20px 0;">
                                <img src="https://thefxpro.org/admin_portal/files/email_template/img/box.png" alt="Lock" width="128" height="128" style="display: block;">
                            </td>
                        </tr>
                    </table>
                    <!--[if (gte mso 9)|(IE)]>
                      <table width="387" align="left" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td>
                    <![endif]-->
                    <table class="col387" align="left" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 387px;">
                        <tr>
                            <td>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <th style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">Package Amount:</th>
                                        <td style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">$'.$pkg_price.'</td>
                                    </tr>
                                    <tr>
                                        <th style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">ROI Daily:</th>
                                        <td style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">$'.$up_roi_daily  .'</td>
                                    </tr>
                                    <tr>
                                        <th style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">ROI Days:</th>
                                        <td style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">90 Day</td>
                                    </tr>
                                    <tr>
                                        <th style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">Activation Date:</th>
                                        <td style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">'.date('l, d-M-Y', time()).'</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>                    
                </td>
            </tr>         
            <tr>
                <td align="center" bgcolor="#ffffff" style="padding: 30px 20px 30px 20px; font-family: Arial, sans-serif;">
                    <table bgcolor="#F58634" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
                        <tr>
                            <td align="center" height="50" style=" padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <a href="https://thefxpro.org/data/login.php" target="_blank" style="color: #ffffff; text-align: center; text-decoration: none;">Get Started</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#dddddd" style="padding: 15px 10px 15px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;">
                    <b>The Fx Pro Inc.</b>
                </td>
            </tr>
            <tr>
                <td style="padding: 15px 10px 15px 10px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" width="100%" style="color: #fff; font-family: Arial, sans-serif; font-size: 12px;">
                                2019-20 &copy; <a href="https://thefxpro.org/" style="color: #F58634;">The Fx Pro</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
                </td>
            </tr>
        </table>
        <![endif]-->
    </body>
</html>', 'text/html');

    $message->setReplyTo('noreply@thefxpro.org');
    $message->setFrom('noreply@thefxpro.org', 'The Fx Pro');
    // Send the email
    $mailer = Swift_Mailer::newInstance($transport);
    if($mailer->send($message))
    {

        $_SESSION['successMsg']='Package has been activated.';
        header("Location: normal_package.php");
        exit();

    }
    
    
} // end of isset
?>  

                        <!-- Main-body start -->
                        <div class="main-body">
                            <div class="page-wrapper">
                                <!-- Page-header start -->
                                <div class="page-header">
                                    <div class="row align-items-end">
                                        <div class="col-lg-8">
                                            <div class="page-header-title">
                                                <div class="d-inline">
                                                    <h4>ROI Package</h4>
                                                    <span>Activate With ROI Only.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index.php"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">ROI Package</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Page-header end -->

                                <div class="page-body">

                                    <div class="container">
                                    <div class="row">
                                    <div class="col-lg-6 col-md-8 col-sm-12 mx-auto">

                                    <form class="md-float-material form-material" method = "POST">
                                    <div class="auth-box card">
                                    <div class="card-block">
                                    <div class="row m-b-20">
                                    <div class="col-md-12">
                                    <h3 class="text-center">Normal Package</h3>

                                    <!-- Success Message -->
                                    <?php if (isset($_SESSION['successMsg'])) {
                                    ?>
                                    <div class="alert alert-success background-success">
                                    <button type="button" class="close m-0" data-dismiss="alert" aria-label="Close">
                                    <i class="icofont icofont-close-line-circled text-white"></i>
                                    </button>
                                    <strong>Success!</strong> <?php echo $_SESSION['successMsg'] ;?>
                                    </div>
                                    <?php
                                    unset($_SESSION['successMsg']);
                                    } ?>

                                    <!-- Error Message -->
                                    <?php if (isset($_SESSION['errorMsg'])) {
                                    ?>
                                    <div class="alert alert-danger background-danger mb-0">
                                    <button type="button" class="close m-0" data-dismiss="alert" aria-label="Close">
                                    <i class="icofont icofont-close-line-circled text-white"></i>
                                    </button>
                                    <strong>Error!</strong> <?php echo $_SESSION['errorMsg'] ;?>
                                    </div>
                                    <?php
                                    unset($_SESSION['errorMsg']);
                                    } ?>
                                    </div>
                                    </div>

                                    <!-- <p class="text-muted text-center p-b-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->


                                        <!-- List of All Users  -->
                                    <div class="form-group form-primary">
                                    <!-- <label class="col-form-label">Select User:</label> -->
                                    <select class="form-control select2" name="user_name" id="user_name">
                                        <option value="">Select User</option>
                                    <?php 

                                        $sql_users = "SELECT * FROM user_registration WHERE id > 1";
                                        $run_users = mysqli_query($con , $sql_users);
                                        if(!$run_users){echo mysqli_error($con);}
                                        while ($row = mysqli_fetch_array($run_users)):
                                    ?>                                        
                                        <option value="<?php echo $row['user_name']; ?>"><?php echo $row['user_name']; ?></option>
                                    <?php endwhile; ?>    
                                    </select>
                                    </div>
                                        <!-- List of All Packages  -->

                                    <div class="form-group form-primary">
                                        <input type="number" class="form-control" id="pkgAmount" name="pkg_amount" placeholder="Enter Amount to invest" min="10" max="5000">
                                    </div>                                    
                                    <div class="row m-t-30">
                                    <div class="col-md-12">
                                    <button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" name = "buy_pkg">Submit Request</button>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </form>

                                    </div>

                                    </div>

                                    </div>

                                </div>
                            </div>
                        </div>


<?php

    include "footer.php";
?>                        