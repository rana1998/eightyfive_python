<?php
ob_start();
include "header.php";
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
                            <h4>Pending Ticket</h4>
                            <span>List of all pending ticket </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Pending Ticket</a> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page-header end -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-6 offset-sm-3">
                    
                    <div class="card">
                        <div class="card-body">
                            <h4 class="mt-0 header-title"></h4>
                            <form method="POST">
                                <?php
                                $id = $_GET['id'];
                                $sql = "SELECT * FROM support WHERE id = '$id' ";
                                $run = mysqli_query($con, $sql);
                                $row = mysqli_fetch_array($run);
                                ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        
                                        <div class="form-group form-primary">
                                            <label class="col-form-label"><strong>Subject:  </strong><?php echo $row['subject']; ?></label>
                                            <br>
                                            <label class="col-form-label"><strong>Question:  </strong><?php echo $row['message']; ?></label>
                                            <br>
                                            <label class="col-form-label"><strong>Message:  </strong></label>
                                            <textarea class="form-control"  name="descr" required="" row="3"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-30">
                                    <div class="col-md-12">
                                        <button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" name="btn_reply" >Send Message</button>
                                    </div>
                                </div>
                                
                            </form>
                            <?php
                            if (isset($_POST['btn_reply']) && $_POST) {
                            
                            $descr =  mysqli_real_escape_string($con,   $_POST['descr']);
                            $id=$_GET['id'];
                            $sel = "select * from support where id = '$id'";
    $result = mysqli_query($con,$sel);
    $row = mysqli_fetch_assoc($result);
    $userName = $row['user_name'];
    $userSubject = $row['subject'];
    $message = $row['message'];
    $date = $row['date'];
    $date = date('Y-m-d', strtotime($date));
    
    $sel1 = "select * from  user_registration where user_name = '$userName'";
    $result1 = mysqli_query($con,$sel1);
    $row1 = mysqli_fetch_assoc($result1);
    $email = $row1['email'];
    $full_name = $row1['full_name'];
    
    $update = "UPDATE support SET reply ='$descr',status='Resolved' WHERE id='$id'";
    $run=mysqli_query($con,$update);
    if($run){
        
    //email start
    $subject = "Support Reply - TradeLine";
    $email_template = '<!DOCTYPE html>

<html lang="en" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<title></title>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<!--[if mso]><xml><o:OfficeDocumentSettings><o:PixelsPerInch>96</o:PixelsPerInch><o:AllowPNG/></o:OfficeDocumentSettings></xml><![endif]-->
<!--[if !mso]><!-->
<link href="https://fonts.googleapis.com/css?family=Cabin" rel="stylesheet" type="text/css"/>
<link href="https://fonts.googleapis.com/css?family=Droid+Serif" rel="stylesheet" type="text/css"/>
<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css"/>
<link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css"/>
<link href="https://fonts.googleapis.com/css?family=Oxygen" rel="stylesheet" type="text/css"/>
<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css"/>
<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet" type="text/css"/>
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet" type="text/css"/>
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css"/>
<!--<![endif]-->
<style>
		* {
			box-sizing: border-box;
		}

		body {
			margin: 0;
			padding: 0;
		}

		a[x-apple-data-detectors] {
			color: inherit !important;
			text-decoration: inherit !important;
		}

		#MessageViewBody a {
			color: inherit;
			text-decoration: none;
		}

		p {
			line-height: inherit
		}

		@media (max-width:520px) {
			.icons-inner {
				text-align: center;
			}

			.icons-inner td {
				margin: 0 auto;
			}

			.fullMobileWidth,
			.row-content {
				width: 100% !important;
			}

			.image_block img.big {
				width: auto !important;
			}

			.stack .column {
				width: 100%;
				display: block;
			}
		}
	</style>
</head>
<body style="background-color: #FFFFFF; margin: 0; padding: 0; -webkit-text-size-adjust: none; text-size-adjust: none;">
<table border="0" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #FFFFFF;" width="100%">
<tbody>
<tr>
<td>
<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-2" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff;" width="100%">
<tbody>
<tr>
<td>
<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 500px;" width="500">
<tbody>
<tr>
<td class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 15px; padding-bottom: 10px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
<table border="0" cellpadding="20" cellspacing="0" class="image_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
<tr>
<td>
<div align="center" style="line-height:10px"><img alt="Support" class="fullMobileWidth big" src="https://backoffice.ybco.net/user-panel/assets/images/customer-service.png" style="display: block; height: auto; border: 0; width: 275px; max-width: 100%;" title="Support" width="275"/></div>
</td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="heading_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
<tr>
<td style="padding-bottom:10px;padding-left:15px;padding-right:15px;padding-top:10px;text-align:center;width:100%;">
<h1 style="margin: 0; color: #f9a826; direction: ltr; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 33px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: center; margin-top: 0; margin-bottom: 0;"><strong>Thank You for contacting us</strong></h1>
</td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="heading_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
<tr>
<td style="padding-bottom:10px;padding-left:15px;padding-right:15px;padding-top:25px;text-align:center;width:100%;">
<h1 style="margin: 0; color: #1d150b; direction: ltr; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 25px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0;"><strong>Your Message</strong></h1>
</td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="heading_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
<tr>
<td style="padding-bottom:10px;padding-left:15px;padding-right:15px;padding-top:10px;text-align:center;width:100%;">
<h1 style="margin: 0; color: #171719; direction: ltr; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0;"><strong>Date : '.$date.'</strong></h1>
</td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="heading_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
<tr>
<td style="padding-bottom:10px;padding-left:15px;padding-right:15px;padding-top:10px;text-align:center;width:100%;">
<h1 style="margin: 0; color: #9191d5; direction: ltr; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 20px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0;"><strong>Subject :  '.$userSubject.' </strong></h1>
</td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
<tr>
<td style="padding-bottom:20px;padding-left:10px;padding-right:10px;padding-top:10px;">
<div style="font-family: Arial, sans-serif">
<div style="font-size: 14px; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 25.2px; color: #39374e; line-height: 1.8;">
<p style="margin: 0; font-size: 14px; text-align: justify; mso-line-height-alt: 28.8px;"><span style="font-size:16px;">'.$message.'</span></p>
</div>
</div>
</td>
</tr>
</table>

</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>

	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-3" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #f2f2f2;" width="100%">
		<tbody>
		<tr>
		<td>
		<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 500px;" width="500">
		<tbody>
		<tr>
		<td class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 0px; padding-bottom: 10px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
		<table border="0" cellpadding="20" cellspacing="0" class="image_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tr>
		<td>
		<div align="center" style="line-height:10px"><img alt="Support" class="fullMobileWidth big" src="https://backoffice.ybco.net/user-panel/assets/images/reply.png" style="display: block; height: auto; border: 0; width: 150px; max-width: 100%;" title="Support" width="275"/></div>
		</td>
		</tr>
		</table>
		
		<table border="0" cellpadding="0" cellspacing="0" class="heading_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
		<tr>
		<td style="padding-bottom:10px;padding-left:15px;padding-right:15px;padding-top:0px;text-align:center;width:100%;">
		<h1 style="margin: 0; color: #f9a826; direction: ltr; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 25px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: left; margin-top: 0; margin-bottom: 0;"><strong>Reply</strong></h1>
		</td>
		</tr>
		</table>
		
		<table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
		<tr>
		<td style="padding-bottom:20px;padding-left:10px;padding-right:10px;padding-top:10px;">
		<div style="font-family: Arial, sans-serif">
		<div style="font-size: 14px; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 25.2px; color: #39374e; line-height: 1.8;">
		<p style="margin: 0; font-size: 14px; text-align: justify; mso-line-height-alt: 28.8px;"><span style="font-size:16px;">'.$descr.'</span></p>
		</div>
		</div>
		</td>
		</tr>
		</table>
		
		</td>
		</tr>
		</tbody>
		</table>
		</td>
		</tr>
		</tbody>
		</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-4" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff;" width="100%">
<tbody>
<tr>
<td>
<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 500px;" width="500">
<tbody>
<tr>
<td class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-top: 30px; padding-bottom: 10px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
<table border="0" cellpadding="0" cellspacing="0" class="heading_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
<tr>
<td style="padding-bottom:5px;padding-left:15px;padding-right:15px;padding-top:5px;text-align:center;width:100%;">
<h1 style="margin: 0; color: #f9a826; direction: ltr; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; font-size: 26px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: center; margin-top: 0; margin-bottom: 0;"><strong>How to contact us ?</strong></h1>
</td>
</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
<tr>
<td style="padding-bottom:10px;padding-left:15px;padding-right:15px;padding-top:10px;">
<div style="font-family: Arial, sans-serif">
<div style="font-size: 14px; font-family: Open Sans, Helvetica Neue, Helvetica, Arial, sans-serif; mso-line-height-alt: 25.2px; color: #39374e; line-height: 1.8;">
<p style="margin: 0; font-size: 14px; text-align: center;">We are always available to support you. You can contact us easily in many ways. We believe in the best services and we solve issues in priority basis. </p>
</div>
</div>
</td>

</tr>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-5" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #ffffff;" width="100%">
	<tbody>
	<tr>
	<td>
	<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 500px;" width="500">
	<tbody>
	<tr>
	<td class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; padding-left: 10px; padding-bottom: 20px; padding-right: 10px; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="100%">
	<table border="0" cellpadding="0" cellspacing="0" class="image_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td style="padding-top:2px;width:100%;padding-right:0px;padding-left:0px;">
	</td>
	</tr>
	</table>
	</td>
	<td class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="16.666666666666668%">
	<table border="0" cellpadding="0" cellspacing="0" class="empty_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td style="padding-right:0px;padding-bottom:5px;padding-left:0px;padding-top:7px;">
	<div></div>
	</td>
	</tr>
	</table>
	</td>
	<td class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="16.666666666666668%">
	<table border="0" cellpadding="0" cellspacing="0" class="heading_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td style="padding-left:5px;padding-right:5px;padding-top:9px;text-align:center;width:100%;padding-bottom:5px;">
	<h1 style="margin: 0; color: #39374e; direction: ltr; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; font-size: 13px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: right; margin-top: 0; margin-bottom: 0;"></h1>
	</td>
	</tr>
	</table>
	</td>
	<td class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="16.666666666666668%">
	<table border="0" cellpadding="0" cellspacing="0" class="heading_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
	<tr>
	<td style="padding-left:5px;padding-right:5px;padding-top:9px;text-align:center;width:100%;padding-bottom:5px;">
	<h1 style="margin: 0; color: #39374e; direction: ltr; font-family: Lato, Tahoma, Verdana, Segoe, sans-serif; font-size: 13px; font-weight: normal; letter-spacing: normal; line-height: 120%; text-align: right; margin-top: 0; margin-bottom: 0;"></h1>
	</td>
	</tr>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
	</td>
	</tr>
	</tbody>
	</table>
<table align="center" border="0" cellpadding="0" cellspacing="0" class="row row-6" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
<tbody>
<tr>
<td>
<table align="center" border="0" cellpadding="0" cellspacing="0" class="row-content stack" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; color: #000000; width: 500px;" width="500">
<tbody>
<tr>
<td class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
<table border="0" cellpadding="0" cellspacing="0" class="heading_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
<tr>

</tr>
</table>
<table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
<tr>

</tr>
</table>
</td>
<td class="column" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; font-weight: 400; text-align: left; vertical-align: top; border-top: 0px; border-right: 0px; border-bottom: 0px; border-left: 0px;" width="50%">
<table border="0" cellpadding="0" cellspacing="0" class="heading_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt;" width="100%">
</table>
<table border="0" cellpadding="0" cellspacing="0" class="text_block" role="presentation" style="mso-table-lspace: 0pt; mso-table-rspace: 0pt; word-break: break-word;" width="100%">
<tr>

</tr>
</table>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>

</td>
</tr>
</tbody>
</table><!-- End -->
</body>
</html>';
    $param = array(
        'subject' => $subject ,
        'email_template' => $email_template ,
        'receiver_email' => $email ,
        'receiver_name' => $full_name 
     );
    
    
    if(send_email($param)){
        $_SESSION['reply']='Message Sent Successfully.';
        
        //  Insert into Activity Log
        // $add = $_SESSION['admin_name'];
        // $sql = "INSERT INTO activity_report (admin_name, user_name,activity) VALUES(?,?,'Ticket Replied')";
        // $stmt = $con->prepare($sql); 
        // $stmt->bind_param("ss", $add,$userName);
        // if ($stmt->execute() === FALSE) {
        //     $_SESSION['reply'] =  __LINE__ ." Error inserting record: " . $con->error;
        //     $stmt->close();
        //     header("Location: pending_support.php");
        //     exit();
    
        // }
        // $stmt->close();

        header("Location: pending_support.php");
        exit();
    }
    else
    {
         $_SESSION['reply']= "Email not Send";
         header("Location: pending_support.php");
         exit();
    }
 
     
     
     //email end
                            }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
    </div>
</div>
<?php
include "footer.php";
?>