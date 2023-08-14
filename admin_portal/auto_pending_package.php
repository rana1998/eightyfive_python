<?php
ob_start();
include "header.php";


//  Reject Query
        if (isset($_POST['reject_reason']) && $_POST['action']=='Reject') {
        $reason = $_POST['reason_txtarea'];
        $wid = $_POST['wid'];
        if(empty($_POST['reason_txtarea']))
        {
                       $_SESSION['reject']='Please enter reject reason';
                       header("Location: pending_package.php");
                       exit();  
        }
        $update = "UPDATE auto_package_details SET status = 'Rejected', reason = '$reason' , approved_by ='Admin' WHERE id ='$wid'";
        $run=mysqli_query($con,$update);


                // Update User Status Pending
                $sql1 = "SELECT * FROM auto_package_details WHERE id = '$wid'";
                $run1 = mysqli_query($con, $sql1);
                $row1 = mysqli_fetch_array($run1);
                $userName= $row1['user_name'];
                $paymentMode= $row1['mode'];
                $transactionId= $row1['trans_id'];
                $pkgName = $row1['company'].' '.$row1['model'].' '.$row1['variant'];
                $pkgPrice = $row1['pkg_price'];
                  
                $q="select * from user_registration where user_name='$userName'";
                $result=mysqli_query($con,$q);
                $res= mysqli_fetch_assoc($result);
                $fullName=$res['full_name'];
                $email=$res['email'];
                  
                      
                  
            if(!$run){
                echo '</h6>'.mysqli_error($con).'</h6>';
            }else
            {


                // Sending Email //

    $subject = "Rejection - Infinite Trade Group";
    $email_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>OTP Code | Wealth Trade Hub</title>
        <meta name="viewport" content="width=device-width">
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
                 
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 30px 10px 0px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 20px; font-weight: bold;">
                    <img src="https://infinitetradegroup.com/data/assets/images/logo-icon.png" alt="Welcome Email" width="114" height="80" style="display:block; margin-bottom: 15px;">
                    
                </td>
            </tr>
            <tr  bgcolor="#ffffff">
                <td style="padding: 20px 10px;font-size: 22px;color: rgb(241, 2, 2);font-family: Arial, Helvetica, sans-serif;font-weight: bold;">
                    Package Request Rejected
                </td>
            </tr>
            <!-- <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px; ">
                    <b>Thank you for choosing Infinite Trade Group as a business partner. Your package is purchased and your account is activated successfully. </b><br>                    
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
                                <span style="color: #0269f0; text-align: center;"> $'.$pkgPrice.'</span>
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
                    <b>© All Rights Reserved - Infinite Trade Group</a></b>
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
         header("Location: auto_pending_package.php");
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

        if (isset($_GET['id']) && $_GET['action']=='Approved') {
                    $id = $_GET['id'];
            
            
            
        $select = "SELECT * FROM auto_package_details WHERE id = '$id'";
        $result = mysqli_query($con, $select);
      
            $data = mysqli_fetch_array($result);
           $uname = $user_name = $data['user_name'];
            $user_pkg_id = $pkg_id = $new_pkg_id = $data['pkg_id'];
            $pkg_name = $data['company'].' '.$data['model'].' '.$data['variant'];
            $pkg_price = $data['pkg_price'];
       
        
        //  $_SESSION['successMsg']=$uname.$pkg_id;
        //  header("Location: auto_pending_package.php");
        //  exit();
            
        //   die();
    //     $uname = $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
    //     $user_pkg_id = mysqli_real_escape_string($con, $_POST['pkg_name']);
    
  
    // // Check if input are empty
    // if (empty($user_name) || empty($user_pkg_id)) {
    //     $_SESSION['errorMsg'] = "Please Select User and Package First. ";
    //     header("Location: normal_package.php");
    //     exit();
    // }
    


// Getting User Pkg Amount

        $sql_upa = "SELECT * FROM auto_variant WHERE id = '$user_pkg_id'";
        $run_upa = mysqli_query($con, $sql_upa);
        $row_upa = mysqli_fetch_array($run_upa);


        $pkg_name =  $row_upa['company'].' '.$row_upa['model'].' '.$row_upa['variant'];;
        $pkg_price=  $up_price  = $row_upa['pkg_price'];
        
        


// Getting Sponosr Name of Selected User
        $sql_sponsor = "SELECT * FROM user_registration WHERE user_name = '$user_name'";
        $run_sponsor = mysqli_query($con, $sql_sponsor);
        $row = mysqli_fetch_array($run_sponsor);


       $sname           = $sponsor_name = $sname1 = $sname2 = $row['sponsor_name'];
    //   $email           = $row['email'];
    //   $full_name       = $row['full_name'];
       $old_pkg_id      = $row['pkg_id'];
      
        //   echo "<script>alert(".$old_pkg_id.")</script>"; 
      //getting sponser d_team
      
       
      $sponsorQuery = "select * from user_registration where user_name = '$sname'";
      $runSponsorQuery=mysqli_query($con,$sponsorQuery);
      $sponserRow = mysqli_fetch_array($runSponsorQuery);
      
      $d_team = $sponserRow['d_team'];

    //   echo "<script>alert(".$d_team.")</script>";  
       
        


 
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

// Echo the random string.
// Optionally, you can give it a desired string length.
$trans_id = generateRandomString(10);


    //    Farhan CODE START  //


// //Insert Into Pakcage Details
//       $insert = "INSERT INTO package_details(`user_name`,`sponsor_name`,`pkg_id`,`pkg_name`,`pkg_price`,`mode`,`trans_id`,`status`,`roi_status`,`approved_by`)
//                     VALUES('$uname','$sname','$user_pkg_id','$pkg_name','$up_price','Activated','$trans_id','Approved','Active','Admin')";

//       $run_insert = mysqli_query($con, $insert);
//       if(!$run_insert){
//         echo '<h6>'.mysqli_error($con).'</h6>';
//       }      

        $updatePkgDetailsQuery="update auto_package_details set `status`='Approved' , roi_status='Active' , approved_by ='Admin'  where id='$id'";
        $updatePkgResult=mysqli_query($con,$updatePkgDetailsQuery);
        
        

//update selected user data in user registration

     
      if($old_pkg_id < $user_pkg_id){

            // Update User Status Approved
            $update = "UPDATE user_registration SET pkg_id = '$user_pkg_id',total_invest = total_invest + '$pkg_price', status = 'Approved', auto_team_sales= auto_team_sales + '$pkg_price' WHERE user_name = '$user_name'";
            $run = mysqli_query($con, $update);
                if(!$run){
                echo 'Error: '.mysqli_error($con);
            }
           
         

      }
      elseif($old_pkg_id >= $user_pkg_id){

            // Update User Status Approved
            $update = "UPDATE user_registration SET  total_invest = total_invest + '$pkg_price', status = 'Approved', auto_team_sales= auto_team_sales + '$pkg_price' WHERE user_name = '$user_name'";
            $run = mysqli_query($con, $update);
                if(!$run){
                echo 'Error: '.mysqli_error($con);
            }
           
           

      }

      
 //update sponsor data in user registration      
    
    if($old_pkg_id == 0)
    {
        $update = "UPDATE user_registration SET auto_d_team = auto_d_team + 1   WHERE user_name = '$sname'";
            $run = mysqli_query($con, $update);
                if(!$run){
                echo 'Error: '.mysqli_error($con);
            }
            else
            {
                //   echo "<script>alert('d team updated')</script>";
            }
     
    }
    else
    {
        // echo "<script>alert('d team not updated')</script>";
        
    }
    
//Hit profit code

    $sponsor_name = $sname1;

    $x = 1;
    while ($sponsor_name != '' and $x <= 5) {
        $sql  = "SELECT * FROM user_registration WHERE user_name = ?"; // SQL with parameters
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $sponsor_name);
        $run = $stmt->execute();
        if (!$run) {
            die(__LINE__ . 'Invalid Query' . $con->error);
        }
        $result = $stmt->get_result(); // get the mysqli result
        $data   = $result->fetch_assoc();
        $d_team = $data['d_team'];
        $sponsor_status = $status = $data['status'];
        $pkg_id = $data['pkg_id'];
       
        $stmt->close();
        
        // $sql  = "SELECT * FROM user_registration WHERE user_name = '$sponsor_name'";
        // $stmt= mysqli_query($con,$sql);
        // $data = mysqli_fetch_assoc($stmt);
        
        // $d_team = $data['d_team'];
        // $status = $data['status'];
        
        
        
      
            
         if ($x == 1) { 

        // Direct Bonus
        if($sponsor_status == 'Approved' && $pkg_id >=1){

            $direct_bonus= $pkg_price * 0.05;
            // Update Sponsor Pool 
          $update_s = "UPDATE user_registration SET current_balance = current_balance + '$direct_bonus', total_income = total_income + '$direct_bonus', auto_d_sale = auto_d_sale + '$pkg_price', l1 = l1 + '$direct_bonus', idb_weekly = idb_weekly + '$direct_bonus', idb_monthly = idb_monthly + '$direct_bonus' , idb=idb + '$direct_bonus' WHERE user_name = '$sponsor_name'";
          $run_s = mysqli_query($con, $update_s);
              if(!$run_s){
              echo 'Error: '.mysqli_error($con);
          } 
    
           
          // Insert Into Bonus Details
          $insert = "INSERT INTO bonuses_details(`receiver`,`sender`,`bonus_amount`,`level`) VALUES('$sponsor_name','$user_name','$direct_bonus','1')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
           
           
          // Insert Into Wallet Summary
          $insert = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) VALUES('$sponsor_name', '$direct_bonus', 'Level 1 Bonus', 'Cash Wallet', 'Credit')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
    
        }
        elseif($sponsor_status == 'Approved' && $pkg_id >=1){
            
            // if sponsor not approved
           $direct_bonus= $pkg_price * 0.05;
            // Update Sponsor Pool 
          $update_s = "UPDATE user_registration SET hold_balance = hold_balance + '$direct_bonus', total_income = total_income + '$direct_bonus', auto_d_sale = auto_d_sale + '$pkg_price', l1 = l1 + '$direct_bonus', idb_weekly = idb_weekly + '$direct_bonus', idb_monthly = idb_monthly + '$direct_bonus' , idb=idb + '$direct_bonus' WHERE user_name = '$sponsor_name'";
          $run_s = mysqli_query($con, $update_s);
              if(!$run_s){
              echo 'Error: '.mysqli_error($con);
          } 
    
           
          // Insert Into Bonus Details
          $insert = "INSERT INTO bonuses_details(`receiver`,`sender`,`bonus_amount`,`level`) VALUES('$sponsor_name','$user_name','$direct_bonus','1')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
           
           
          // Insert Into Wallet Summary
          $insert = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) VALUES('$sponsor_name', '$direct_bonus', 'Level 1 Bonus', 'Hold Wallet', 'Credit')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
        // insert into hold bonus details 
          $insert="INSERT INTO hold_bonus_details (`sender`, `receiver`, `bonus_amount`, `level`, `status`) VALUES ('$user_name','$sponsor_name','$direct_bonus','1','Hold')";
         $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
        
        
        }
         
        } 
    
  
    
    elseif ($x == 2) {
        
        // Direct Bonus
        if($sponsor_status == 'Approved' && $pkg_id >=1  && $d_team > 1){

            $direct_bonus= $pkg_price * 0.02;
            // Update Sponsor Pool 
          $update_s = "UPDATE user_registration SET current_balance = current_balance + '$direct_bonus', total_income = total_income + '$direct_bonus', l2 = l2 + '$direct_bonus', idb_weekly = idb_weekly + '$direct_bonus', idb_monthly = idb_monthly + '$direct_bonus' , idb=idb + '$direct_bonus' WHERE user_name = '$sponsor_name'";
          $run_s = mysqli_query($con, $update_s);
              if(!$run_s){
              echo 'Error: '.mysqli_error($con);
          } 
    
           
          // Insert Into Bonus Details
          $insert = "INSERT INTO bonuses_details(`receiver`,`sender`,`bonus_amount`,`level`) VALUES('$sponsor_name','$user_name','$direct_bonus','2')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
           
           
          // Insert Into Wallet Summary
          $insert = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) VALUES('$sponsor_name', '$direct_bonus', 'Level 2 Bonus', 'Cash Wallet', 'Credit')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
    
        }
        elseif($sponsor_status == 'Approved' && $pkg_id >=1 ){
            
            // if sponsor not approved
           $direct_bonus= $pkg_price * 0.02;
            // Update Sponsor Pool 
          $update_s = "UPDATE user_registration SET hold_balance = hold_balance + '$direct_bonus', total_income = total_income + '$direct_bonus', l2 = l2 + '$direct_bonus', idb_weekly = idb_weekly + '$direct_bonus', idb_monthly = idb_monthly + '$direct_bonus' , idb=idb + '$direct_bonus' WHERE user_name = '$sponsor_name'";
          $run_s = mysqli_query($con, $update_s);
              if(!$run_s){
              echo 'Error: '.mysqli_error($con);
          } 
    
           
          // Insert Into Bonus Details
          $insert = "INSERT INTO bonuses_details(`receiver`,`sender`,`bonus_amount`,`level`) VALUES('$sponsor_name','$user_name','$direct_bonus','2')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
           
           
          // Insert Into Wallet Summary
          $insert = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) VALUES('$sponsor_name', '$direct_bonus', 'Level 2 Bonus', 'Hold Wallet', 'Credit')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
        // insert into hold bonus details 
          $insert="INSERT INTO `hold_bonus_details`(`sender`, `receiver`, `bonus_amount`, `level`, `status`) VALUES ('$user_name','$sponsor_name','$direct_bonus','2','Hold')";
         $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
        
        
        }

    } 
    
    
    
  elseif ($x == 3) {
      
       // Direct Bonus
        if($sponsor_status == 'Approved' && $pkg_id >= 1 && $d_team > 2){

            $direct_bonus= $pkg_price * 0.01;
            // Update Sponsor Pool 
          $update_s = "UPDATE user_registration SET current_balance = current_balance + '$direct_bonus', total_income = total_income + '$direct_bonus', l3 = l3 + '$direct_bonus', idb_weekly = idb_weekly + '$direct_bonus', idb_monthly = idb_monthly + '$direct_bonus' , idb=idb + '$direct_bonus' WHERE user_name = '$sponsor_name'";
          $run_s = mysqli_query($con, $update_s);
              if(!$run_s){
              echo 'Error: '.mysqli_error($con);
          } 
    
           
          // Insert Into Bonus Details
          $insert = "INSERT INTO bonuses_details(`receiver`,`sender`,`bonus_amount`,`level`) VALUES('$sponsor_name','$user_name','$direct_bonus','3')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
           
           
          // Insert Into Wallet Summary
          $insert = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) VALUES('$sponsor_name', '$direct_bonus', 'Level 3 Bonus', 'Cash Wallet', 'Credit')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
    
        }
        elseif($sponsor_status == 'Approved' && $pkg_id >= 1){
            
            // if sponsor not approved
           $direct_bonus= $pkg_price * 0.01;
            // Update Sponsor Pool 
          $update_s = "UPDATE user_registration SET hold_balance = hold_balance + '$direct_bonus', total_income = total_income + '$direct_bonus', l3 = l3 + '$direct_bonus', idb_weekly = idb_weekly + '$direct_bonus', idb_monthly = idb_monthly + '$direct_bonus' , idb=idb + '$direct_bonus' WHERE user_name = '$sponsor_name'";
          $run_s = mysqli_query($con, $update_s);
              if(!$run_s){
              echo 'Error: '.mysqli_error($con);
          } 
    
           
          // Insert Into Bonus Details
          $insert = "INSERT INTO bonuses_details(`receiver`,`sender`,`bonus_amount`,`level`) VALUES('$sponsor_name','$user_name','$direct_bonus','3')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
           
           
          // Insert Into Wallet Summary
          $insert = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) VALUES('$sponsor_name', '$direct_bonus', 'Level 3 Bonus', 'Hold Wallet', 'Credit')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
        // insert into hold bonus details 
          $insert="INSERT INTO `hold_bonus_details`(`sender`, `receiver`, `bonus_amount`, `level`, `status`) VALUES ('$user_name','$sponsor_name','$direct_bonus','3','Hold')";
         $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
        
        
        }

  } 
    
    
    elseif ($x == 4) 
    {
        // Direct Bonus
        if($sponsor_status == 'Approved' && $pkg_id >= 1  && $d_team > 3){

            $direct_bonus= $pkg_price * 0.01;
            // Update Sponsor Pool 
          $update_s = "UPDATE user_registration SET current_balance = current_balance + '$direct_bonus', total_income = total_income + '$direct_bonus', l4 = l4 + '$direct_bonus', idb_weekly = idb_weekly + '$direct_bonus', idb_monthly = idb_monthly + '$direct_bonus' , idb=idb + '$direct_bonus' WHERE user_name = '$sponsor_name'";
          $run_s = mysqli_query($con, $update_s);
              if(!$run_s){
              echo 'Error: '.mysqli_error($con);
          } 
    
           
          // Insert Into Bonus Details
          $insert = "INSERT INTO bonuses_details(`receiver`,`sender`,`bonus_amount`,`level`) VALUES('$sponsor_name','$user_name','$direct_bonus','4')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
           
           
          // Insert Into Wallet Summary
          $insert = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) VALUES('$sponsor_name', '$direct_bonus', 'Level 4 Bonus', 'Cash Wallet', 'Credit')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
    
        }
        elseif($sponsor_status == 'Approved' && $pkg_id >= 1){
            
            // if sponsor not approved
           $direct_bonus= $pkg_price * 0.01;
            // Update Sponsor Pool 
          $update_s = "UPDATE user_registration SET hold_balance = hold_balance + '$direct_bonus', total_income = total_income + '$direct_bonus', l4 = l4 + '$direct_bonus', idb_weekly = idb_weekly + '$direct_bonus', idb_monthly = idb_monthly + '$direct_bonus' , idb=idb + '$direct_bonus' WHERE user_name = '$sponsor_name'";
          $run_s = mysqli_query($con, $update_s);
              if(!$run_s){
              echo 'Error: '.mysqli_error($con);
          } 
    
           
          // Insert Into Bonus Details
          $insert = "INSERT INTO bonuses_details(`receiver`,`sender`,`bonus_amount`,`level`) VALUES('$sponsor_name','$user_name','$direct_bonus','4')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
           
           
          // Insert Into Wallet Summary
          $insert = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) VALUES('$sponsor_name', '$direct_bonus', 'Level 4 Bonus', 'Hold Wallet', 'Credit')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
        // insert into hold bonus details 
          $insert="INSERT INTO `hold_bonus_details`(`sender`, `receiver`, `bonus_amount`, `level`, `status`) VALUES ('$user_name','$sponsor_name','$direct_bonus','4','Hold')";
         $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
        
        
        }
        
    } 
      elseif ($x == 5) 
    {
        // Direct Bonus
        if($sponsor_status == 'Approved' && $pkg_id >= 1  && $d_team > 4){

            $direct_bonus= $pkg_price * 0.005;
            // Update Sponsor Pool 
          $update_s = "UPDATE user_registration SET current_balance = current_balance + '$direct_bonus', total_income = total_income + '$direct_bonus', l5 = l5 + '$direct_bonus', idb_weekly = idb_weekly + '$direct_bonus', idb_monthly = idb_monthly + '$direct_bonus' , idb=idb + '$direct_bonus' WHERE user_name = '$sponsor_name'";
          $run_s = mysqli_query($con, $update_s);
              if(!$run_s){
              echo 'Error: '.mysqli_error($con);
          } 
    
           
          // Insert Into Bonus Details
          $insert = "INSERT INTO bonuses_details(`receiver`,`sender`,`bonus_amount`,`level`) VALUES('$sponsor_name','$user_name','$direct_bonus','5')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
           
           
          // Insert Into Wallet Summary
          $insert = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) VALUES('$sponsor_name', '$direct_bonus', 'Level 5 Bonus', 'Cash Wallet', 'Credit')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
    
        }
        elseif($sponsor_status == 'Approved' && $pkg_id >= 1 ){
            
            // if sponsor not approved
           $direct_bonus= $pkg_price * 0.005;
            // Update Sponsor Pool 
          $update_s = "UPDATE user_registration SET hold_balance = hold_balance + '$direct_bonus', total_income = total_income + '$direct_bonus', l5 = l5 + '$direct_bonus', idb_weekly = idb_weekly + '$direct_bonus', idb_monthly = idb_monthly + '$direct_bonus' , idb=idb + '$direct_bonus' WHERE user_name = '$sponsor_name'";
          $run_s = mysqli_query($con, $update_s);
              if(!$run_s){
              echo 'Error: '.mysqli_error($con);
          } 
    
           
          // Insert Into Bonus Details
          $insert = "INSERT INTO bonuses_details(`receiver`,`sender`,`bonus_amount`,`level`) VALUES('$sponsor_name','$user_name','$direct_bonus','5')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
           
           
          // Insert Into Wallet Summary
          $insert = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) VALUES('$sponsor_name', '$direct_bonus', 'Level 5 Bonus', 'Hold Wallet', 'Credit')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
        // insert into hold bonus details 
          $insert="INSERT INTO `hold_bonus_details`(`sender`, `receiver`, `bonus_amount`, `level`, `status`) VALUES ('$user_name','$sponsor_name','$direct_bonus','5','Hold')";
         $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
        
        
        }
     
    }

    

        
         // will check
        
        
        
        // Getting Next Sponsor
        $sql  = "SELECT * FROM user_registration WHERE user_name= ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $sponsor_name);
        $run = $stmt->execute();
        if (!$run) {
            die(__LINE__ . 'Invalid Query' . $con->error);
        }
        $result       = $stmt->get_result(); // get the mysqli result
        $data         = $result->fetch_assoc();
        $sponsor_name = $data['sponsor_name'];
        $stmt->close();

        $x++;
    }
    
    
// Hit profit code end    



// echo "<script>alert('loop executed')</script>";





// Update Team Sales 
while($sname2 != ''){

    $sql = "UPDATE user_registration SET auto_team_sales = auto_team_sales + ? WHERE user_name = ?";
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


        
        
        header("Location: package_purchased_email2.php?userName={$user_name}&&pkgId={$user_pkg_id}");
       
       
        

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
                                            <th>Company</th>
                                            <th>Model</th>
                                            <th>Variant</th>
                                            <th>Mode</th>
                                            <th>Transection ID</th>
                                            <th>Price</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sql = "SELECT * FROM  auto_package_details WHERE status = 'Pending'";
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
                                            <td><?php echo $data['company'];  ?></td>
                                            <td><?php echo $data['model'];  ?></td>
                                            <td><?php echo $data['variant'];  ?></td>
                                            <td><?php echo $data['mode'];  ?></td>
                                            <td><?php echo $data['trans_id'];  ?></td>
                                            <td><?php echo $data['pkg_price'];  ?>$</td>
                            
                                         
                                            <td><?php echo  date('Y-m-d', strtotime($data['date'])) ;  ?></td>
                                            <td>
                                              <a href="auto_pending_package.php?id=<?php echo $data['id']; ?>&action=Approved" class="btn btn-outline-info btn-sm"  onclick="return disableBtn(event);" >Approve</a>
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
                                            <th>Company</th>
                                            <th>Model</th>
                                            <th>Variant</th>
                                            <th>Mode</th>
                                            <th>Transection ID</th>
                                            <th>Price</th>
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