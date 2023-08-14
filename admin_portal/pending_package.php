<?php
ob_start();
include "header.php";


//  Reject Query
if (isset($_POST['reject_reason']) && $_POST['action']=='Reject') {
        $reason = mysqli_real_escape_string($con,$_POST['reason_txtarea']);
        $wid = $_POST['wid'];
        
        
        if(empty($_POST['reason_txtarea']))
        {
            $_SESSION['reject']='Please enter reject reason';
            header("Location: pending_package.php");
            exit();  
        }

        //update pacakge details
        $pkgStatus= 'Rejected';
        
        $sql = "update package_details set status= ? , reason= ? where id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssi",$pkgStatus,$reason,$wid);
        $run = $stmt->execute();
        if (!$run) {
            die(__LINE__ . 'Invalid Query' . $con->error);
        }
        $stmt->close();

        // select package detils row data

        $sql  = "SELECT * FROM package_details WHERE id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i", $wid);
        $run = $stmt->execute();
        if (!$run) {
            die(__LINE__ . 'Invalid Query' . $con->error);
        }
        $result = $stmt->get_result();
        $row1  = $result->fetch_assoc();
        $userName= $row1['user_name'];
        $paymentMode= $row1['mode'];
        $transactionId= $row1['trans_id'];
        $pkgName = $row1['pkg_name'];
        $pkgPrice = $row1['pkg_price'];
        
        $stmt->close();
                  
                  
                  
                  
         //select user details 
        $sql  = "SELECT * FROM user_registration WHERE user_name = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $userName);
        $run = $stmt->execute();
        if (!$run) {
            die(__LINE__ . 'Invalid Query' . $con->error);
        }
        $result = $stmt->get_result();
        $res  = $result->fetch_assoc();
        $fullName=$res['full_name'];
        $email=$res['email'];  
          
        $stmt->close();      
                  
        if(!$run){
                echo '</h6>'.mysqli_error($con).'</h6>';
        }else
            {

              //insert into admin log
                $activityMessage= 'Package Rejected '.$transactionId;
                $adminNameSession = $_SESSION['admin_name'];
                $qyy="INSERT INTO `admin_log`(`user_name`, `activity`) 
                      VALUES ('$adminNameSession','$activityMessage')";
                $result = mysqli_query($con,$qyy);
            
            
                // Sending Email //

    $subject = "Rejection - mazicoin";
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
                <td align="left" bgcolor="#ffffff" style="padding: 30px 10px 0px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 20px; font-weight: bold;">
                    <img src="'.$logo1.'" alt="logo" width="256" height="60" style="display:block; margin-bottom: 15px;">
                    
                </td>
            </tr>
            <tr  bgcolor="#ffffff">
                <td style="padding: 20px 10px;font-size: 22px;color: rgb(241, 2, 2);font-family: Arial, Helvetica, sans-serif;font-weight: bold;">
                    Package Request Rejected
                </td>
            </tr>
            <!-- <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px; ">
                    <b>Thank you for choosing tradeline.vip. Your package request has been rejected </b><br>                    
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
                                <span style="color: #223035; text-align: center;">Package Name: </span>
                                <span style="color: #0269f0; text-align: center;">'.$pkgName.'</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" height="25" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <span style="color: #223035; text-align: center;">Package Price: </span>
                                <span style="color: #0269f0; text-align: center;">$'.$pkgPrice.'</span>
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
                    <b>© All Rights Reserved - tradeline.vip</a></b>
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
        'receiver_name' => $fullName 
     );
    
    
    if( send_email($param) ){
         $_SESSION['reject']='Package Rejected';
         header("Location: pending_package.php");
         exit();
    }
    else
    {
         echo "Email not Send";
         exit();
    }




            }


}


// Approved Query

if (isset($_GET['id']) && $_GET['action']=='Approved') 
{
        
    $pkg_id = $id = intval(mysqli_real_escape_string($con,$_GET['id']));

    
    $sql  = "SELECT * FROM package_details WHERE id = '$pkg_id'";
    $result = mysqli_query($con,$sql);
    if(mysqli_num_rows($result)!=1)
    {
        $_SESSION['errorMsg']= "Something went wrong";
        header("Location: pending_package.php");
        exit();
    }   
    $data = mysqli_fetch_assoc($result);
    
    $uname2 = $uname1 = $uname = $user_name = $data['user_name'];
    $paymentMode= $data['mode'];
    $pkg_name =$pkgName =  $data['pkg_name'];
    $pkg_price = $bonusPkgPrice = $pkgPrice= $data['pkg_price'];
    $transactionId= $data['trans_id'];
    $packageId = $data['pkg_id'];
     
        
     // Check if input are empty
    if (empty($user_name) || empty($pkg_price)){
        $_SESSION['errorMsg'] = "Please fill all fields. ";
        header("Location: pending_package.php");
        exit();
    }
   
    $q="select distribution from package where id='$packageId'";
    $re = mysqli_query($con,$q);
    $row = mysqli_fetch_assoc($re);
    $distribution = $row['distribution'];


       
    // $_SESSION['successMsg']= "$distribution";
    // header("Location: pending_package.php");
    // exit(); 

    //current user sponsor get
    $sql  = "SELECT * FROM user_registration WHERE user_name = ?"; // SQL with parameters
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $user_name);
    $run = $stmt->execute();
    if (!$run) {
        die(__LINE__ . 'Invalid Query' . $con->error);
    }
    $result = $stmt->get_result(); // get the mysqli result
    $data   = $result->fetch_assoc();
    $sname = $sname1 = $sname2 = $sponsor_name = $data['sponsor_name'];
    $userPkgId = $data['pkg_id'];
    $fullName=$data['full_name'];
    $email=$data['email']; 
    $stmt->close();



     //first sponsor details
    $sql  = "SELECT * FROM user_registration WHERE user_name = ?"; // SQL with parameters
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $sponsor_name);
    $run = $stmt->execute();
    if (!$run) {
        die(__LINE__ . 'Invalid Query' . $con->error);
    }
    $result = $stmt->get_result(); // get the mysqli result
    $data2   = $result->fetch_assoc();
    $sponsorTotalInvest = $data2['total_invest']; 
    $sponsorStatus = $data2['status']; 

    
   

       

 
    // Generate Random String Function
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $trans_id = generateRandomString(10);
    

    //insert pacakge details
    $pkgMode= 'Normal';
    $pkgStatus= 'Approved';
    $pkgRoiStatus='Active';
    $pkgApprovedBy ='Admin';
    
    $sql="update package_details set status = 'Approved' , `roi_status` = 'Active' where id = '$id'";
    $stmt = $con->prepare($sql);
    $run = $stmt->execute();
    if (!$run) {
        die(__LINE__ . 'Invalid Query' . $con->error);
    }
    $stmt->close();
    
    
    
    if($userPkgId < $pkg_id)
    {
      // update user_registration current user update pkg id
      $pkgIdStatus = 'Updated';
        $query="update user_registration set pkg_id= '$pkg_id' ,  total_invest = total_invest + '$pkg_price' ,status = 'Approved' where user_name='$user_name'";
        $result = mysqli_query($con,$query);
    }
    else if($userPkgId >= $pkg_id)
    {
        // update user_registration current user
        $pkgIdStatus = 'Not Updated';
        $query="update user_registration set  total_invest = total_invest + '$pkg_price',status = 'Approved' where user_name='$user_name'";
        $result = mysqli_query($con,$query);
    }

//   $_SESSION['successMsg']= "userName: $user_name <br> 
//     packagePrice: $pkg_price <br> 
//     packageDays: $pkg_days <br> 
//     PackageName: $pkg_name <br>
//     PackageId Status: $pkgIdStatus <br>
//     SponsorName : $sponsor_name <br>
//     SponsorTotalInvest: $sponsorTotalInvest <br>
//     SponsorStatus : $sponsorStatus <br>
//     ROI Percentage : $roiPercentage <br>
//     Roi Bonus : $roiBonus <br>
//     Bonus Amount : $bonusAmount <br>
//     ";
//     header("Location: normal_package.php");
//     exit();
  


    //while loop start
 //fetch levels percentage
    $levelPercentageQuery="SELECT * FROM `level_percentage` where id='1'";
    $levelQueryResult= mysqli_query($con,$levelPercentageQuery);
    $levelPercentageResult = mysqli_fetch_assoc($levelQueryResult);
    

    
    //while loop start

    $sponsor_name = $sname1;

    $x = 1;
    while ($sponsor_name != '') {
        $sql  = "SELECT * FROM user_registration WHERE user_name = '$sponsor_name'";
        $result = mysqli_query($con,$sql);
        $data   = mysqli_fetch_assoc($result);
        $getSponsorStatus = $status = $data['status'];
        
            
        if($getSponsorStatus == 'Approved') 
        { 
            
               // Direct Bonus
                
                $percent = $distribution * 0.2;
                $bonus = $distribution - $percent;
 
                // Update user registration (While Sponsor)
                
                $sql="update user_registration set current_balance = current_balance + '$bonus',total_income = total_income + '$bonus' where user_name= '$sponsor_name'";
                
                $resu = mysqli_query($con,$sql);
        
        
                // insert into bonuses details
                $sql="INSERT INTO `bonuses_details`(`sender`, `receiver`, `bonus_amount`, `level`) 
                      VALUES ('$user_name','$sponsor_name','$bonus','$x')";
                $resu = mysqli_query($con,$sql); 
             
               
                // Insert Into Wallet Summary
                $summaryDescription= 'Level '.$x.' Bonus';
                $walletType = 'Cash Wallet';
                $incomeType = 'Credit';
                
                $sql = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) 
                       VALUES('$sponsor_name','$bonus','$summaryDescription','$walletType','$incomeType')";
                $resu = mysqli_query($con,$sql);
                
          
        } 
        
        
        
        $distribution = $percent;
        
        // Getting Next Sponsor
        $sql  = "SELECT * FROM user_registration WHERE user_name= '$sponsor_name'";
        $result = mysqli_query($con,$sql);
        $data         =  mysqli_fetch_assoc($result);
        $sponsor_name = $data['sponsor_name'];

        $x++;
    }
    
    


// Update Team Sales (While loop)
while($sname2 != ''){

    $sql = "UPDATE user_registration SET team_sales = team_sales + ? WHERE user_name = ?";
    $stmt = $con->prepare($sql); 
    $stmt->bind_param("is",$pkg_price,  $sname2);
    $stmt->execute();
    $stmt->close();

    // Getting Next Sponsor //

    $sql = "SELECT `sponsor_name` FROM user_registration WHERE user_name = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $sname2);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    $data = $result->fetch_assoc(); // fetch data  
    $sname2 = $data['sponsor_name'];

    $stmt->close();

}


    


    //insert into admin log
    $activityMessage= 'Pending Package Approved '.$uname2.' And Amount is '.$pkg_price;
    $adminNameSession = $_SESSION['admin_name'];
    $qyy="INSERT INTO `admin_log`(`user_name`, `activity`) 
          VALUES ('$adminNameSession','$activityMessage')";
    $result = mysqli_query($con,$qyy);
    
    
    $_SESSION['successMsg']= "Package Activated Successfully";
    header("Location: pending_package.php");
    exit(); 

  

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
                            <h4>Package Details</h4>
                            <span>List of all Pending Packages</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Package Details</a> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page-header end -->
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12">
                 
                    <!-- HTML5 Export Buttons table start -->
                    <div class="card">
                                                                   
                                                 <div class="card-header table-card-header text-center">
                                                        
                                                        <?php if(isset($_SESSION['invalid_request'])):  ?>
                                                        
                                        <div class="alert alert-danger background-danger">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <i class="icofont icofont-close-line-circled text-white"></i>
                                            </button>
                                            <strong>Error!</strong> <?php echo $_SESSION['invalid_request'];  ?>
                                        </div>
                                        <?php 
                                                        unset($_SESSION['invalid_request']);
                                                        endif; ?>

                                                        
                                                        <?php if(isset($_SESSION['successMsg'])):  ?>
                                        <div class="alert alert-success background-success">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <i class="icofont icofont-close-line-circled text-white"></i>
                                            </button>
                                            <strong>Success!</strong> <?php echo $_SESSION['successMsg'];  ?>
                                        </div>
                                        <?php 
                                                        unset($_SESSION['successMsg']);
                                                        endif; ?>

                                            <?php
                                                if(isset($_SESSION['reject'])): ?>
                                        <div class="alert alert-danger background-danger">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <i class="icofont icofont-close-line-circled text-white"></i>
                                            </button>
                                            <strong>Rejected!</strong> <?php echo $_SESSION['reject'];  ?>
                                        </div>
                                        <?php
                                        unset($_SESSION['reject']);
                                        
                                        endif; ?>
                                            <?php
                                                if(isset($_SESSION['approved'])): ?>
                                        <div class="alert alert-success background-success">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                <i class="icofont icofont-close-line-circled text-white"></i>
                                            </button>
                                            <strong>Success!</strong> <?php echo $_SESSION['approved'];  ?>
                                        </div>
                                        <?php
                                        unset($_SESSION['approved']);
                                        
                                        endif; ?>    


                                                    </div>    
                        
                        
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                                <table data-page-length="500" id="basic-btn" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Full Name</th>
                                            <th>User Name</th>
                                            <th>Sponsor Name</th>
                                            <th>Package Name</th>
                                            <th>Package Amount</th>
                                            <th>Mode</th>
                                            <!--<th>Days</th>-->
                                            <th>Bank</th>
                                            <th>Receipt</th>
                                            <th>Transection ID</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM  package_details WHERE status = 'Pending'";
                                        $result = mysqli_query($con, $sql);
                                        $count = 1;
                                        while ( $data = mysqli_fetch_array($result)):
                                        $id      = $data['id'];
                                        $uname   = $data['user_name'];
                                        $pkg_id  = $data['pkg_id'];
                                        $sql2    = "SELECT `full_name`,`email` FROM  user_registration WHERE user_name = '$uname'";
                                        $result2 = mysqli_query($con, $sql2);
                                        $data2   = mysqli_fetch_array($result2);
                                        $userEmail = $email   = $data2['email'];
                                        $fname   =  $full_name = $data2['full_name'];
                                        ?>
                                        <tr>
                                            <td><?php echo $count++; ?></td>
                                            <td><?php echo $full_name;  ?></td>
                                            <td><?php echo $data['user_name'];  ?></td>
                                            <td><?php echo $data['sponsor_name'];  ?></td>
                                            <td><?php echo $data['pkg_name'];  ?></td>
                                            <td>$<?php echo $data['pkg_price'];  ?></td>
                                            <td><?php echo $data['mode'];  ?></td>
                                            <!--<td><?php echo $data['days'];  ?></td>-->
                                            <td><?php echo $data['bank'];  ?></td>
                                            <td><a <?php if($data['image']==NULL){ echo "class='d-none'"; }?> target="blank" href="../member/<?php echo $data['image'];  ?>"><img height="50" src="../member/<?php echo $data['image'];  ?>" ></a></td>
                                            <td><?php echo $data['trans_id'];  ?></td>
                                            <td><?php echo  date('Y-m-d', strtotime($data['date'])) ;  ?></td>
                                            <td>
                                              <a href="pending_package.php?id=<?php echo $data['id']; ?>&action=Approved" class="btn btn-outline-info btn-sm"  onclick="return disableBtn(event);" >Approve</a>
                                              <a href="JavaScript:Void(0)" class="btn btn-outline-danger btn-sm btn-reject" data-toggle="modal" data-target="#rejectModal" data-wid = "<?php echo $data['id']; ?>">Reject</a>
                                            </td>

                                        </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Full Name</th>
                                        <th>User Name</th>
                                        <th>Sponsor Name</th>
                                        <th>Package Name</th>
                                        <th>Package Amount</th>
                                        <th>Mode</th>
                                        <!--<th>Days</th>-->
                                        <th>Bank</th>
                                        <th>Receipt</th>
                                        <th>Transection ID</th>
                                        <th>Date</th>
                                        <th>Action</th>
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
      <div class="modal-body">
<form method = 'POST'>
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

  </form>
      </div>
    </div>
  </div>
</div>


<?php
include "footer.php";
?>

 <script type="text/javascript">
     $(document).ready(function(){
// Reject
        $(document).on("click", ".btn-reject", function () {

        var rejectID = $(this).data('wid');

     $(".modal-body #rejectID").val( rejectID );


     });
});
 </script>