<?php 
include "header.php";

  if (isset($_GET['approved_btn']) && $_GET['action'] == 'Approved') {
              
              $id = $_GET['approved_btn'];
              
              $update = "UPDATE kyc SET status='Approved' WHERE id='$id'";
              $run    = mysqli_query($con, $update);
              if (!$run) {
                  echo '<h6>' . mysqli_error($con) . '</h6>';
                  exit();
              } else {
                  
				$sql_kyc = "SELECT * FROM kyc WHERE `id` = '$id'";
				$run_kyc    = mysqli_query($con, $sql_kyc);
				$row_kyc = mysqli_fetch_array($run_kyc);
				$user_name = $row_kyc['user_name'];

                  // Select Email, Full Name form user_registration table
                  $sql_s = "SELECT * FROM user_registration WHERE user_name = '$user_name'";
                  $run_s = mysqli_query($con, $sql_s);
                  if (!$run_s) {
                      echo "Error:" . mysqli_error($con);
                      exit();
                  }
                  $row_s = mysqli_fetch_array($run_s);
                  $full_name = $row_s['full_name'];
                  $email = $row_s['email'];


		        $_SESSION['successMsg']='KYC Approved Successfully';
		        header("Location:kyc_summary.php");
		        exit();

           // Send Email to current user //
	   

	$message = Swift_Message::newInstance();
	$message->setTo(array(
	$email => $full_name
	));
	$message->setSubject("KYC Approved - Infinite Trade Group");
	$email_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title>TKyc Approved | Infinite Trade Group</title>
        <meta name="viewport" content="width=device-width">
        <!-- Favicon icon -->
        <link rel="icon" href="https://infinitetradegroup.com/data/assets/images/logo-icon.png" type="image/x-icon">
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
                        
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#0073AA" style="padding: 20px 20px 20px 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
                    <img src="https://seemise.com/files/email_template/img/newsletter.png" alt="KYC Approval" width="152" height="152" style="display:block; margin-bottom: 15px;">
                    Welcome <span style="color: #ffe81f">'.$full_name.'</span>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#ffffff" style="padding: 40px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
                    <b>Thank you very much for choosing Infinite Trade Group!</b><br><br>
                    <span style="font-size: 18px;">Your KYC Details has been Approved Successfully.</span>
                </td>
            </tr>   
            <tr>
                <td align="center" bgcolor="#f9f9f9" style="padding: 30px 20px 30px 20px; font-family: Arial, sans-serif;">
                    <table bgcolor="#0073AA" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
                        <tr>
                            <td align="center" height="50" style=" padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <a href="https://infinitetradegroup.com/data/login.php" target="_blank" style="color: #ffffff; text-align: center; text-decoration: none;">Get Started</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#dddddd" style="padding: 15px 10px 15px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;">
                    <b>Infinite Trade Group</b>
                </td>
            </tr>
            <tr>
                <td style="padding: 15px 10px 15px 10px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" width="100%" style="color: #fff; font-family: Arial, sans-serif; font-size: 12px;">
                                2019-20 &copy; <a href="https://infinitetradegroup.com/" style="color: #0073AA;">Infinite Trade Group</a>
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
</html>';



    $message->setBody($email_template, 'text/html');
    
    $message->setReplyTo('noreply@infnitetradegroup.com');
    $message->setFrom('noreply@infinitetradegroup.com', 'Infinite Trade Group');
    // Send the email
    $mailer = Swift_Mailer::newInstance($transport);
    if($mailer->send($message))
    
    {
        $_SESSION['successMsg']='KYC Approved Successfully';
        header("Location: kyc_summary.php");
        exit();
    }

}

        }elseif (isset($_GET['reject_reason']) && $_GET['action']=='Reject') {
                              # code...
                  $reject_id = $_GET['reject_id'];
                  $reason = $_GET['reason_txtarea'];
              $update = "UPDATE kyc SET status='Reject', reason = '$reason' WHERE id='$reject_id'";
              $run    = mysqli_query($con, $update);
              if (!$run) {
                  echo '<h6>' . mysqli_error($con) . '</h6>';
                  exit();
              } else {
                  
				$sql_kyc = "SELECT * FROM kyc WHERE id = '$reject_id'";
				$run_kyc    = mysqli_query($con, $sql_kyc);
				$row = mysqli_fetch_array($run_kyc);
				$user_name = $row['user_name'];

                  // Select Email, Full Name form user_registration table
                  $sql_s = "SELECT * FROM user_registration WHERE user_name = '$user_name'";
                  $run_s = mysqli_query($con, $sql_s);
                  if (!$run_s) {
                      echo "Error:" . mysqli_error($con);
                      exit();
                  }
                  $row_s = mysqli_fetch_array($run_s);
                  $full_name = $row_s['full_name'];
                  $email = $row_s['email'];

			      $_SESSION['errorMsg']='KYC Rejected';
			      header("Location:kyc_summary.php");
			      exit();


     // Send Email to current user //

$message = Swift_Message::newInstance();
$message->setTo(array(
$email => $full_name
));
$message->setSubject("KYC Rejected - Infinitetradegroup");
$email_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title>KYC Rejected | Infinite Trade Group</title>
        <meta name="viewport" content="width=device-width">
        <!-- Favicon icon -->
        <link rel="icon" href="https://infinitetradegroup.com/data/assets/images/logo-icon.png" type="image/x-icon">
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
                            
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#0073AA" style="padding: 20px 20px 20px 20px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
                    <img src="https://seemise.com/files/email_template/img/newsletter.png" alt="KYC Approval" width="152" height="152" style="display:block; margin-bottom: 15px;">
                    Welcome <span style="color: #ffe81f">'. $full_name.' </span>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#ffffff" style="padding: 40px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
                    <b>Thank you very much for choosing Infinite Trade!</b><br><br>
                    <span style="font-size: 18px;">Your KYC Details has been Rejected, <br> Due to follwoing Reason:</span>
                </td>
            </tr>  

            <tr>
                <td align="center" bgcolor="#ffffff" style="padding: 40px 20px 40px 20px; color: #555555; font-family: Arial, sans-serif; font-size: 20px; line-height: 30px; border-bottom: 1px solid #f6f6f6;">
                    <table width="128" align="left" border="0" cellpadding="0" cellspacing="0">
                        
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
                                        <th style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">Reason:</th>
                                        <td style="padding: 0 0 10px 0; color: #555555; text-align: left; font-family: Arial, sans-serif; font-size: 15px; line-height: 24px;">'. $reason .'</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>                    
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#f9f9f9" style="padding: 30px 20px 30px 20px; font-family: Arial, sans-serif;">
                    <table bgcolor="#0073AA" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
                        <tr>
                            <td align="center" height="50" style=" padding: 0 25px 0 25px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <a href="https://infinitetradegroup.com/data/login.php" target="_blank" style="color: #ffffff; text-align: center; text-decoration: none;">Get Started</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#dddddd" style="padding: 15px 10px 15px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px;">
                    <bInfinite Trade Group</b>
                </td>
            </tr>
            <tr>
                <td style="padding: 15px 10px 15px 10px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td align="center" width="100%" style="color: #fff; font-family: Arial, sans-serif; font-size: 12px;">
                               Since 2021 &copy; <a href="https:/infinitetradegroup.com/" style="color: #0073AA;">Infinite Trade Group</a>
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
</html>';



    $message->setBody($email_template, 'text/html');
    
    $message->setReplyTo('noreply@infinitetradegroup.com');
    $message->setFrom('noreply@infinitetradegroup.com', 'Infinite Trade Group');
    // Send the email
    $mailer = Swift_Mailer::newInstance($transport);
    if($mailer->send($message))
    
    {
      $_SESSION['errorMsg']='KYC Rejected';
      header("Location:kyc_summary.php");
      exit();
	}
		}
			}
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
                                                    <h4>Approved KYC</h4>
                                                    <span>Following are the list of  approved KYC requests </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">Approved KYC</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Page-header end -->

                                <div class="page-body">
									<div class="row">
									    <div class="col-md-12">
									                            <!-- Sussess Message  -->
									                    <?php if (isset($_SESSION['successMsg'])) {
									                    ?>
									                    <div class="alert alert-success background-success">
									                        <button type="button" class="close m-0" data-dismiss="alert" aria-label="Close">
									                        <i class="icofont icofont-close-line-circled text-default"></i>
									                        </button>
									                        <strong>Success!</strong> <?php echo $_SESSION['successMsg'];?>
									                    </div>
									                    <?php
									                    unset($_SESSION['successMsg']);
									                    } ?>



									                            <!-- Error Message  -->
									                    <?php if (isset($_SESSION['errorMsg'])) {
									                    ?>
									                    <div class="alert alert-danger background-danger">
									                        <button type="button" class="close m-0" data-dismiss="alert" aria-label="Close">
									                        <i class="icofont icofont-close-line-circled text-default"></i>
									                        </button>
									                        <strong>Error!</strong> <?php echo $_SESSION['errorMsg'];?>
									                    </div>
									                    <?php
									                    unset($_SESSION['errorMsg']);
									                    } ?>
									    </div>
									</div>

                          <div class="row">
                                            <div class="col-sm-12">
                                                <!-- HTML5 Export Buttons table start -->
                                                <div class="card">
                                                     <div class="card-header table-card-header text-center">

                                                    </div>
                                                    <div class="card-block">
                                                        <div class="dt-responsive table-responsive">
                                                            <table id="basic-btn" class="table table-striped table-bordered nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>User Name</th>
                                                                        <th>Doc Type</th>
                                                                        <th>Doc Number</th>
                                                                        <th>Issue Date</th>
                                                                        <th>Expire Date</th>
                                                                        <th>Profile Image</th>
                                                                        <th>Front Image</th>
                                                                        <th>Back Image </th>
                                                                        <th>Status</th>
                                                                        <th>Date</th>
                                                                        
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                        <?php 
                        $sql = "SELECT * FROM  kyc WHERE status = 'Approved'";
                        $result = mysqli_query($con, $sql);
                        $x = 1;
                        while ( $data = mysqli_fetch_array($result)):
                        ?>
                                                            <tr>
                                                                <td><?php echo $x++;  ?></td>
                                                                <td><?php echo $data['user_name'];  ?></td>
                                                                <td><?php echo $data['doc_type'];  ?></td>
                                                                <td><?php echo $data['id_no'];  ?></td>
                                                                <td><?php echo $data['issue_date'];  ?></td>
                                                                <td><?php echo $data['expire_date'];  ?></td>
                                                                <td>
                                                                    <?php if($data['image1'] != ''): ?>
                                                                    <a href="<?php echo '../data/assets/images/kyc/'.$data['image1'] ; ?>" data-toggle="lightbox"><?php echo $data['image1'] ?></a>
                                                                    <?php endif;  ?>
                                                                </td>
                                                                <td>
                                                                    <?php if($data['image2'] != ''): ?>
                                                                    <a href="<?php echo '../data/assets/images/kyc/'.$data['image2'] ; ?>" data-toggle="lightbox"><?php echo $data['image2'] ?></a>
                                                                    <?php endif;  ?>
                                                                </td>
                                                                <td>
                                                                    <?php if($data['image3'] != ''): ?>
                                                                    <a href="<?php echo '../data/assets/images/kyc/'.$data['image3'] ; ?>" data-toggle="lightbox"><?php echo $data['image3'] ?></a>
                                                                    <?php endif;  ?>
                                                                </td>

                                                                <td><?php echo $data['status'];  ?></td>
                                                                <td><?php echo date('Y-m-d',strtotime($data['date']) );  ?></td>
																
                                                            </tr>
                        <?php endwhile; ?>                                    
                                                        </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>User Name</th>
                                                                        <th>Doc Type</th>
                                                                        <th>Doc Number</th>
                                                                        <th>Issue Date</th>
                                                                        <th>Expire Date</th>
                                                                        <th>Profile Image</th>
                                                                        <th>Front Image</th>
                                                                        <th>Back Image </th>
                                                                        <th>Status</th>
                                                                        <th>Date</th>
                                                                      
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- HTML5 Export Buttons end -->
                                            </div>
                                        </div>


                                </div>
                            </div>
                        </div>


<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectModalLabel">Reason</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
<form method = 'GET'>
      <div class="modal-body">
    <input type="hidden" id="rejectID" name="reject_id"      value="">
    <input type="hidden" name="action"  value="Reject">
 <div class="form-group">
    <label for="reason_txtarea">Why?</label>
    <textarea class="form-control" name = "reason_txtarea" id="reason_txtarea" rows="3"></textarea>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="reject_reason">Reject</button>

      </div>
  </form>
    </div>
  </div>
</div>


<?php
    include "footer.php";
?>