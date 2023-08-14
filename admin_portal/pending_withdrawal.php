<?php 
// This file need work. Approved Withdrawal Par work karna hai //
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
                              <h4>Pending Withdrawals</h4>
                              <span>Summary of all pending withdrawals</span>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4">
                      <div class="page-header-breadcrumb">
                          <ul class="breadcrumb-title">
                              <li class="breadcrumb-item">
                                  <a href="index.php"> <i class="feather icon-home"></i> </a>
                              </li>
                              <li class="breadcrumb-item"><a href="#!">Pending Withdrawals</a> </li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
          <!-- Page-header end -->

          <div class="page-body">
              <div class="row">
                  <div class="col-12">
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
                  <div class="col-12">
                   <div class="card">
<!--                                    <div class="card-header table-card-header">
                      <h5></h5>
                  </div>-->
                   <div class="card-block">
                      <div class="dt-responsive table-responsive">
      <table id="basic-btn" class="table table-striped table-bordered nowrap">
          <thead>
              <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Desire Amt</th>
                  <th>Tax</th>
                  <th>After Tax</th>
                  <th>Mode</th>
                  <th>Wallet</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>Actions</th>
              </tr>
          </thead>
          <tfoot>
              <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Desire Amt</th>
                  <th>Tax</th>
                  <th>After Tax</th>
                  <th>Mode</th>
                  <th>Wallet</th>
                  <th>Status</th>
                  <th>Date</th>
                  <th>Actions</th>
              </tr>
          </tfoot>                                
          <tbody>
          <?php 
              $select= "SELECT * FROM `withdrawal` WHERE status = 'Pending'";
                $res=mysqli_query($con,$select);
                if (!$res) {
                   echo '<h6>'.mysqli_error($con).'</h6>';
                   exit();
                }
                $x = 1;
              while($data=mysqli_fetch_array($res)) : ?>
                    <tr>
                      <td><?php echo $x++; ?></td>
                      <td><?php echo $data['user_name']; ?></td>
                      <td><?php echo $data['email'];?></td>
                      <td><?php echo '$'.$data['desire_amount'];?></td>
                      <td><?php echo '%'.$data['tax'];?></td>
                      <td><?php echo '$'.$data['amount_after_tax'];?></td>
                      <td><?php echo $data['mode'];?></td>
                      <td><?php echo $data['btc_address'];?></td>
                      
                      <td><?php echo "<span class=\"badge badge-warning text-white \">Pending</span>";?></td>
                      <td><?php echo date('Y-m-d', strtotime( $data['date']) )  ;?></td>
                      <td> 
                             <a href="pending_withdrawal.php?approved_btn=<?php echo $data['id']; ?>&action=Approved"  class="btn btn-success btn-sm">Approve</a>
                             <a href="JavaScript:Void(0)"  class="btn btn-danger btn-sm btn-reject" data-toggle="modal" data-target="#rejectModal" data-wid = "<?php echo $data['id']; ?>">Reject</a>
                      </td>

                    </tr>

          <?php endwhile;  ?>
          </tbody>

    <?php 
          if (isset($_GET['approved_btn']) && $_GET['action'] == 'Approved') {
              
              $id = $_GET['approved_btn'];
              
              $update = "UPDATE withdrawal SET status='Approved' WHERE id='$id'";
              $run    = mysqli_query($con, $update);
              if (!$run) {
                  echo '<h6>' . mysqli_error($con) . '</h6>';
                  exit();
              } else {
                  
                  $select = "SELECT w.*, `u`.`full_name`,`u`.`sponsor_name`  
                              FROM `withdrawal`AS w
                              LEFT JOIN user_registration AS u
                              ON `w`.`user_name` = `u`.`user_name`
                              WHERE `w`.`id` = '$id'";
                  $res    = mysqli_query($con, $select);
                  $data   = mysqli_fetch_array($res);
                  
                  $username           =$u=$data['user_name'];
                  $sname              = $data['sponsor_name'];
                  $email              =$data['email'];
                  $full_name          =$data['full_name'];
                 $desiredAmount = $amount =$data['desire_amount'];
                  $tax                =$data['tax'];
                  $amount_after_tax   =$data['amount_after_tax'];
                  $transactionId = $wallet_address     =$data['btc_address'];
                  $status             =$data['status'];
                  $date               =$data['date'];
                  $paymentMode            =$data['mode'];
                  
             if($paymentMode =='PM')
            {
                $paymentMode='Perfect Money';
            }               
                
                

                //   $_SESSION['successMsg']='Withdrawal Approved Successfully';
                //   header("Location: pending_withdrawal.php");
                //   exit();
                
                
    $subject = "Withdrawal Approved - vizeoncapital";
    $email_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Withdrawal Approved | Tradeline Trading</title>
        <meta name="viewport" content="width=device-width">
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
                   <img src="'.$logo1.'" alt="logo" width="256" height="60" style="display:block; margin-bottom: 15px;">
                    
                </td>
            </tr>
            <tr  bgcolor="#ffffff">
                <td style="padding: 20px 10px;font-size: 22px;color: rgb(7, 196, 23);font-family: Arial, Helvetica, sans-serif;font-weight: bold;">
                    Withdrawal Request Approved
                </td>
            </tr>
            <!-- <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px; ">
                    <b>Thank you for choosing vizeoncapital. as a business partner. Your withdrawal request in approved and the net amount is transferred to your given wallet. </b><br>                    
                </td>
            </tr> -->
          
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 20px 25px 20px 0px; font-family: Arial, sans-serif;">
                    <table bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
                        <tr>
                            <td align="left" height="25" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <span style="color: #223035; text-align: center;">Payment Mode: </span>
                                <span style="color: #0269f0; text-align: center;">'.$paymentMode.'</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" height="25" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <span style="color: #223035; text-align: center;">Transaction ID: </span>
                                <span style="color: #0269f0; text-align: center;">'.$transactionId.'</span>
                            </td>
                        </tr>
                      
                        <tr>
                            <td align="left" height="25" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <span style="color: #223035; text-align: center;">Desired Amount: </span>
                                <span style="color: #0269f0; text-align: center;">$'.$desiredAmount.'</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
             <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: rgb(7, 196, 23); font-family: Arial, sans-serif; font-size: 18px; line-height: 25px; ">
                    <b>Good Luck:</b><br>                    
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 30px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 14px; line-height: 25px; ">
                    <b>Have a happy life ahead.</b><br>                    
                </td>
            </tr>
        
            <tr>
                <td align="center" bgcolor="#ff9700" style="padding: 15px 10px 15px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px;">
                    <b>© All Rights Reserved - vizeoncapital</a></b>
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
    
    
    // if( send_email($param) ){
    //       $_SESSION['successMsg']='Withdrawal Approved';
    //               header("Location: pending_withdrawal.php");
    //               exit();

    // }
    // else
    // {
    //      echo "Email not Send";
    //      exit();
    // }
                
                
                }

// Send Email to current user //



        }
        elseif (isset($_GET['reject_reason']) && $_GET['action']=='Reject') {
            $reason = $_GET['reason_txtarea'];
            $update = "UPDATE withdrawal SET status='Rejected', reject_reason = '$reason' WHERE id='".$_GET['wid']."'";
            $run=mysqli_query($con,$update);
            $select = "SELECT w.*, `u`.`full_name`  
                        FROM `withdrawal`AS w
                        LEFT JOIN user_registration AS u
                        ON `w`.`user_name` = `u`.`user_name`
                        WHERE `w`.`id` = '".$_GET['wid']."'";
            $res=mysqli_query($con,$select);
            if (!$run || !$res  ) {
                $_SESSION['errorMsg'] = mysqli_error($con);
                header("Location: pending_withdrawal.php");
                exit();
              }
            $data=mysqli_fetch_array($res);
            $username=$u=$data['user_name'];
            $email=$data['email'];
            $full_name=$data['full_name'];
           $desiredAmount = $amount1=$amount=$data['desire_amount'];
            $amount_after_tax=$data['amount_after_tax'];
            $tax=$data['tax'];
            $status=$data['status'];
            $reason = $reject_reason=$data['reject_reason'];
            $transactionId=$data['btc_address'];
            $date=$data['date'];
            $paymentMode=$data['mode'];
            if($paymentMode =='PM')
            {
                $paymentMode='Perfect Money';
            }
            
            
            
            $update_ur = "UPDATE user_registration SET current_balance = current_balance + $amount WHERE user_name='$u'";
            $run_ur = mysqli_query($con,$update_ur);
     
             $insert = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) VALUES('$username', '$amount', 'Withdrawal Reversed', 'Cash Wallet', 'Credit')";
    
              $run_insert = mysqli_query($con, $insert);
              if(!$run_insert){
                echo '<h6>'.mysqli_error($con).'</h6>';
              }
                 
        
                   
              if ($run_ur) {
            
                 
                // Send Email to current user //

                // Sending Email //

    $subject = "Wtihdrawal Rejected - GTRON";
    $email_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Withdrawal Rejected | GTRON</title>
        <meta name="viewport" content="width=device-width">
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
                    <img src="'.$logo1.'" alt="logo" width="256" height="60" style="display:block; margin-bottom: 15px;">
                    
                </td>
            </tr>
            <tr  bgcolor="#ffffff">
                <td style="padding: 20px 10px;font-size: 22px;color: rgb(241, 2, 2);font-family: Arial, Helvetica, sans-serif;font-weight: bold;">
                    Withdrawal Request Rejected
                </td>
            </tr>
            <!-- <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px; ">
                    <b>Your withdrawal is rejected and reason is given below. </b><br>                    
                </td>
            </tr> -->
          
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 20px 25px 20px 0px; font-family: Arial, sans-serif;">
                    <table bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
                        <tr>
                            <td align="left" height="25" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <span style="color: #223035; text-align: center;">Payment Mode: </span>
                                <span style="color: #0269f0; text-align: center;">'.$paymentMode.'</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" height="25" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <span style="color: #223035; text-align: center;">Transaction ID: </span>
                                <span style="color: #0269f0; text-align: center;">'.$transactionId.'</span>
                            </td>
                        </tr>
                      
                        <tr>
                            <td align="left" height="25" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <span style="color: #223035; text-align: center;">Desired Amount: </span>
                                <span style="color: #0269f0; text-align: center;">$'.$desiredAmount.'</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
             <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: rgb(241, 2, 2); font-family: Arial, sans-serif; font-size: 18px; line-height: 25px; ">
                    <b>Reason:</b><br>                    
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 30px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 14px; line-height: 25px; ">
                    <b>'.$reason.'</b><br>                    
                </td>
            </tr>
        
            <tr>
                <td align="center" bgcolor="#ff9700" style="padding: 15px 10px 15px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px;">
                    <b>© All Rights Reserved - vizeoncapital</a></b>
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
        'receiver_name' =>  $full_name 
     );
    
    
    // if( send_email($param) ){
    //       $_SESSION['successMsg']='Withdrawal Rejected';
    //               header("Location: pending_withdrawal.php");
    //               exit();

    // }
    // else
    // {
    //      echo "Email not Send";
    //      exit();
    // }
                    
                    
                    
                    
             }
             else
             {
                echo '<h6>'.mysqli_error($con).'</h6>';
                exit();
             }
}
  ?>
              </table>
          </div>
      </div>
  </div>
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
    <input type="hidden" id="rejectID" name="wid"      value="">
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

<?php include "footer.php"; ?>
 <script type="text/javascript">
     $(document).ready(function(){
// Reject
        $(document).on("click", ".btn-reject", function () {

        var rejectID = $(this).data('wid');

     $(".modal-body #rejectID").val( rejectID );


     });

     });
 </script>