<?php 
ob_start();
	include "header.php";

    if(isset($_POST['buy_pkg'])){
        $uname = $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
        $user_pkg_id = mysqli_real_escape_string($con, $_POST['pkg_name']);
    
  
    // Check if input are empty
    if (empty($user_name) || empty($user_pkg_id)) {
        $_SESSION['errorMsg'] = "Please Select User and Package First. ";
        header("Location: auto_package.php");
        exit();
    }
    


// Getting User Pkg Amount

        $sql_upa = "SELECT * FROM package WHERE id = '$user_pkg_id'";
        $run_upa = mysqli_query($con, $sql_upa);
        $row_upa = mysqli_fetch_array($run_upa);


        $pkg_name =  $row_upa['pkg_name'];
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


//Insert Into Pakcage Details
      $insert = "INSERT INTO package_details(`user_name`,`sponsor_name`,`pkg_id`,`pkg_name`,`pkg_price`,`mode`,`trans_id`,`status`,`roi_status`,`position`,`approved_by`)
                    VALUES('$uname','$sname','$user_pkg_id','$pkg_name','$up_price','Cash Wallet','$trans_id','Approved','Active','Running','Admin')";

      $run_insert = mysqli_query($con, $insert);
      if(!$run_insert){
        echo '<h6>'.mysqli_error($con).'</h6>';
      } 

//update selected user data in user registration

     
      if($old_pkg_id < $user_pkg_id){

            // Update User Status Approved
            $update = "UPDATE user_registration SET pkg_id = '$user_pkg_id',total_invest = total_invest + '$pkg_price', status = 'Approved', team_sales= team_sales + '$pkg_price' WHERE user_name = '$user_name'";
            $run = mysqli_query($con, $update);
                if(!$run){
                echo 'Error: '.mysqli_error($con);
            }
           
         

      }
      elseif($old_pkg_id >= $user_pkg_id){

            // Update User Status Approved
            $update = "UPDATE user_registration SET  total_invest = total_invest + '$pkg_price', status = 'Approved', team_sales= team_sales + '$pkg_price' WHERE user_name = '$user_name'";
            $run = mysqli_query($con, $update);
                if(!$run){
                echo 'Error: '.mysqli_error($con);
            }
           
           

      }

      
 //update sponsor data in user registration      
    
    if($old_pkg_id == 0)
    {
        $update = "UPDATE user_registration SET d_team = d_team + 1   WHERE user_name = '$sname'";
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


        
        
        header("Location: auto_package_purchased_email.php?userName={$user_name}&&pkgId={$user_pkg_id}");
       
        
        

    //    Farhan CODE END  //

    //     // Block of Activity Report Code for first 9 Sponsor
    //    $select3 = "SELECT * FROM user_registration WHERE user_name ='$uname' ";
    //     $result3 = mysqli_query($con, $select3);
        
    //     if($result3){
    //             $user_data = mysqli_fetch_array($result3);
    //             $sname=$user_data['sponsor_name'];
               
    //             $x=1;
    //             while($sname!='' && $x<=9)
    //             {
    //                 if ($x==1) {
    //                      //   insert in activity_report
    //             $insert = "INSERT INTO activity_report (`sender`,`receiver`,`pkg_name`,`pkg_amount`,`level`)
    //                             VALUES('$uname','$sname','$pkg_name','$pkg_price','$x')";
    //                 }else{
    //                     // $level = $x-1; 
    //                     $insert = "INSERT INTO activity_report (`sender`,`receiver`,`pkg_name`,`pkg_amount`,`level`)
    //                             VALUES('$uname','$sname','$pkg_name','$pkg_price','$x')";

    //                 }
    //                 $run2 = mysqli_query($con ,$insert);
    //                    if(!$run2){
    //         echo 'Error: '.mysqli_error($con);
    //     } 

    //               $select="select * from user_registration where user_name='$sname'";
    //               $res=mysqli_query($con,$select);
    //               $data=mysqli_fetch_array($res);
    //               $sname=$data['sponsor_name'];
    //                 //   if($sname==''){
    //                 //       break ;
    //                 //   }

    //                 $x++;
               
    //             } // end while 
    //     }          // End of  Activity Report Code for first 9 Sponsor
    

           // Send Email to current user //
           
// $message = Swift_Message::newInstance();
// $message->setTo(array(
// $email => 'user_name will be there'
// ));
// $message->setSubject("Package Approved - Businesstohomes");
// $email_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

// <html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:v="urn:schemas-microsoft-com:vml">
// <head>
// <!--[if gte mso 9]><xml><o:OfficeDocumentSettings><o:AllowPNG/><o:PixelsPerInch>96</o:PixelsPerInch></o:OfficeDocumentSettings></xml><![endif]-->
// <meta content="text/html; charset=utf-8" http-equiv="Content-Type"/>
// <meta content="width=device-width" name="viewport"/>
// <!--[if !mso]><!-->
// <meta content="IE=edge" http-equiv="X-UA-Compatible"/>
// <!--<![endif]-->
// <title></title>
// <!--[if !mso]><!-->
// <!--<![endif]-->
// <style type="text/css">
// body {
// margin: 0;
// padding: 0;
// }

// .table {
// width: 100%;
// margin-bottom: 1rem;
// color: #212529;
// border-collapse: collapse
// }

// .table td,
// .table th {
// padding: .75rem;
// vertical-align: top;
// border-top: 1px solid #dee2e6
// }

// .table thead th {
// vertical-align: bottom;
// border-bottom: 2px solid #dee2e6
// }

// .table tbody+tbody {
// border-top: 2px solid #dee2e6
// }

// .table-sm td,
// .table-sm th {
// padding: .3rem
// }

// .table-bordered {
// border: 1px solid #dee2e6
// }

// .table-bordered td,
// .table-bordered th {
// border: 1px solid #dee2e6
// }

// .table-bordered thead td,
// .table-bordered thead th {
// border-bottom-width: 2px
// }

// .table-borderless tbody+tbody,
// .table-borderless td,
// .table-borderless th,
// .table-borderless thead th {
// border: 0
// }

// a[x-apple-data-detectors=true] {
// color: inherit !important;
// text-decoration: none !important;
// }

// /* Media Query */
// @media (max-width: 620px) {

// .block-grid,
// .col {
// min-width: 320px !important;
// max-width: 100% !important;
// display: block !important;
// }

// .block-grid {
// width: 100% !important;
// }

// .col {
// width: 100% !important;
// }

// .col>div {
// margin: 0 auto;
// }

// img.fullwidth,
// img.fullwidthOnMobile {
// max-width: 100% !important;
// }

// .no-stack .col {
// min-width: 0 !important;
// display: table-cell !important;
// }

// .no-stack.two-up .col {
// width: 50% !important;
// }

// .no-stack .col.num4 {
// width: 33% !important;
// }

// .no-stack .col.num8 {
// width: 66% !important;
// }

// .no-stack .col.num4 {
// width: 33% !important;
// }

// .no-stack .col.num3 {
// width: 25% !important;
// }

// .no-stack .col.num6 {
// width: 50% !important;
// }

// .no-stack .col.num9 {
// width: 75% !important;
// }

// .video-block {
// max-width: none !important;
// }

// .mobile_hide {
// min-height: 0px;
// max-height: 0px;
// max-width: 0px;
// display: none;
// overflow: hidden;
// font-size: 0px;
// }

// .desktop_hide {
// display: block !important;
// max-height: none !important;
// }
// }
// </style>
// </head>
// <body class="clean-body" style="margin: 0; padding: 0; -webkit-text-size-adjust: 100%; background-color: #283C4B;">
// <!--[if IE]><div class="ie-browser"><![endif]-->
// <table bgcolor="#283C4B" cellpadding="0" cellspacing="0" class="nl-container" role="presentation" style="table-layout: fixed; vertical-align: top; min-width: 320px; Margin: 0 auto; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; background-color: #283C4B; width: 100%;" valign="top" width="100%">
// <tbody>
// <tr style="vertical-align: top;" valign="top">
// <td style="word-break: break-word; vertical-align: top;" valign="top">
// <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td align="center" style="background-color:#283C4B"><![endif]-->
// <div style="background-color:#283C4B;">
// <div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #283C4B;">
// <div style="border-collapse: collapse;display: table;width: 100%;background-color:#283C4B;">
// <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#283C4B;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:#283C4B"><![endif]-->
// <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#283C4B;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;"><![endif]-->
// <div class="col num12" style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
// <div style="width:100% !important;">
// <!--[if (!mso)&(!IE)]><!-->
// <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
// <!--<![endif]-->
// <div align="center" class="img-container center autowidth" style="padding-right: 25px;padding-left: 25px;">
// <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr style="line-height:0px"><td style="padding-right: 25px;padding-left: 25px;" align="center"><![endif]-->
// <div style="font-size:1px;line-height:25px"> </div>
// <div style="font-size:1px;line-height:25px"> </div>
// <!--[if mso]></td></tr></table><![endif]-->
// </div>
// <!--[if (!mso)&(!IE)]><!-->
// </div>
// <!--<![endif]-->
// </div>
// </div>
// <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
// <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
// </div>
// </div>
// </div>
// <div style="background-color:#283C4B;">
// <div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #101017;">
// <div style="border-collapse: collapse;display: table;width: 100%;background-color:#ffffff;">
// <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#283C4B;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:#101017"><![endif]-->
// <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#101017;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:0px;"><![endif]-->
// <div class="col num12" style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
// <div style="width:100% !important;">
// <!--[if (!mso)&(!IE)]><!-->
// <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:0px; padding-right: 0px; padding-left: 0px;">
// <!--<![endif]-->
// <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 20px; padding-left: 20px; padding-top: 30px; padding-bottom: 20px; font-family: Arial, sans-serif"><![endif]-->
// <div style="color:#FFFFFF;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:30px;padding-right:20px;padding-bottom:20px;padding-left:20px;">
// <div style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 12px; line-height: 1.2; color: #FFFFFF; mso-line-height-alt: 14px;">
// <p style="font-size: 24px; line-height: 1.2; text-align: center; mso-line-height-alt: 29px; margin: 0;"><span style="font-family: lucida sans unicode, lucida grande, sans-serif; font-size: 24px;">
// <img height="80" src="https://businesstohomes.com/files/assets/images/logo-blue.png">
// </span></p>
// </div>
// </div>
// <!--[if mso]></td></tr></table><![endif]-->
// <!--[if (!mso)&(!IE)]><!-->
// </div>
// <!--<![endif]-->
// </div>
// </div>
// <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
// <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
// </div>
// </div>
// </div>
// <div style="background-color:#283C4B;">
// <div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: #FFFFFF;">
// <div style="border-collapse: collapse;display: table;width: 100%;background-color:#FFFFFF;">
// <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#283C4B;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:#FFFFFF"><![endif]-->
// <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:#FFFFFF;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:0px; padding-bottom:15px;"><![endif]-->
// <div class="col num12" style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
// <div style="width:100% !important;">
// <!--[if (!mso)&(!IE)]><!-->
// <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:0px; padding-bottom:15px; padding-right: 0px; padding-left: 0px;">
// <!--<![endif]-->
// <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 30px; padding-left: 30px; padding-top: 10px; padding-bottom: 10px; font-family: Arial, sans-serif"><![endif]-->
// <div style="color:#283C4B;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:30px;padding-bottom:10px;padding-left:30px;">
// <div style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 12px; line-height: 1.5; color: #283C4B; mso-line-height-alt: 18px;">
// </div>
// </div>
// <!--[if mso]></td></tr></table><![endif]-->
// <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 30px; padding-left: 30px; padding-top: 10px; padding-bottom: 0px; font-family: Arial, sans-serif"><![endif]-->


// <div style="color:#283C4B;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.5;padding-top:10px;padding-right:30px;padding-bottom:0px;padding-left:30px;">
// <div style="font-family: Arial, Helvetica Neue, Helvetica, sans-serif; font-size: 12px; line-height: 1.5; color: #283C4B; mso-line-height-alt: 18px;">
// <p style="font-family: lucida sans unicode, lucida grande, sans-serif; font-size: 20px; text-transform: uppercase; font-weight: 800; line-height: 1.5; text-align: center; margin:0 0 20px 0; mso-line-height-alt: 21px;">Your Withdrawal request has been approved. <span style="font-family: lucida sans unicode, lucida grande, sans-serif; font-size: 16px; text-transform: uppercase; font-weight: 800; line-height: 1.5; text-align: center; margin:0 0 20px 0; mso-line-height-alt: 21px;">Details are given below.</span>
// </p>

// </div>
// </div>



// <!--[if mso]></td></tr></table><![endif]-->
// <div align="center" class="button-container" style="padding-top:25px;padding-right:0px;padding-bottom:0px;padding-left:0px;">
// <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="border-spacing: 0; border-collapse: collapse; mso-table-lspace:0pt; mso-table-rspace:0pt;"><tr><td style="padding-top: 25px; padding-right: 0px; padding-bottom: 0px; padding-left: 0px" align="center"><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="" style="height:39pt; width:183.75pt; v-text-anchor:middle;" arcsize="8%" stroke="false" fillcolor="#101017"><w:anchorlock/><v:textbox inset="0,0,0,0"><center style="color:#ffffff; font-family:Arial, sans-serif; font-size:14px"><![endif]-->
// <p style="font-size: 14px; line-height: 1.5; text-align: center; mso-line-height-alt: 21px; margin: 0;"><span style="font-family: lucida sans unicode, lucida grande, sans-serif; font-size: 14px;">

// </span></p>


// <!--[if mso]></center></v:textbox></v:roundrect></td></tr></table><![endif]-->

// </div>
// <!--[if mso]><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 20px; padding-left: 20px; padding-top: 20px; padding-bottom: 30px; font-family: Arial, sans-serif"><![endif]-->
// <div style="color:#555555;font-family:Arial, Helvetica Neue, Helvetica, sans-serif;line-height:1.2;padding-top:20px;padding-right:20px;padding-bottom:30px;padding-left:20px;">

// </div>
// <!--[if mso]></td></tr></table><![endif]-->
// <!--[if (!mso)&(!IE)]><!-->
// </div>
// <!--<![endif]-->
// </div>
// </div>
// <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
// <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
// </div>
// </div>
// </div>
// <div style="background-color:transparent;">
// <div class="block-grid" style="Margin: 0 auto; min-width: 320px; max-width: 600px; overflow-wrap: break-word; word-wrap: break-word; word-break: break-word; background-color: transparent;">
// <div style="border-collapse: collapse;display: table;width: 100%;background-color:transparent;">
// <!--[if (mso)|(IE)]><table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:transparent;"><tr><td align="center"><table cellpadding="0" cellspacing="0" border="0" style="width:600px"><tr class="layout-full-width" style="background-color:transparent"><![endif]-->
// <!--[if (mso)|(IE)]><td align="center" width="600" style="background-color:transparent;width:600px; border-top: 0px solid transparent; border-left: 0px solid transparent; border-bottom: 0px solid transparent; border-right: 0px solid transparent;" valign="top"><table width="100%" cellpadding="0" cellspacing="0" border="0"><tr><td style="padding-right: 0px; padding-left: 0px; padding-top:5px; padding-bottom:5px;"><![endif]-->
// <div class="col num12" style="min-width: 320px; max-width: 600px; display: table-cell; vertical-align: top; width: 600px;">
// <div style="width:100% !important;">
// <!--[if (!mso)&(!IE)]><!-->
// <div style="border-top:0px solid transparent; border-left:0px solid transparent; border-bottom:0px solid transparent; border-right:0px solid transparent; padding-top:5px; padding-bottom:5px; padding-right: 0px; padding-left: 0px;">
// <!--<![endif]-->
// <table border="0" cellpadding="0" cellspacing="0" class="divider" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top" width="100%">
// <tbody>
// <tr style="vertical-align: top;" valign="top">
// <td class="divider_inner" style="word-break: break-word; vertical-align: top; min-width: 100%; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 10px;" valign="top">
// <table align="center" border="0" cellpadding="0" cellspacing="0" class="divider_content" role="presentation" style="table-layout: fixed; vertical-align: top; border-spacing: 0; border-collapse: collapse; mso-table-lspace: 0pt; mso-table-rspace: 0pt; border-top: 0px solid transparent; width: 100%;" valign="top" width="100%">
// <tbody>
// <tr style="vertical-align: top;" valign="top">
// <td style="word-break: break-word; vertical-align: top; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%;" valign="top"><span></span></td>
// </tr>
// </tbody>
// </table>
// </td>
// </tr>
// </tbody>
// </table>
// <!--[if (!mso)&(!IE)]><!-->
// </div>
// <!--<![endif]-->
// </div>
// </div>
// <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
// <!--[if (mso)|(IE)]></td></tr></table></td></tr></table><![endif]-->
// </div>
// </div>
// </div>



// <!--[if (mso)|(IE)]></td></tr></table><![endif]-->
// </td>
// </tr>
// </tbody>
// </table>
// <!--[if (IE)]></div><![endif]-->
// </body>
// </html>';



//     $message->setBody($email_template, 'text/html');
    
//     $message->setReplyTo('noreply@businesstohomes.com');
//     $message->setFrom('noreply@businesstohomes.com', 'Business To Homes');
//     // Send the email
//     $mailer = Swift_Mailer::newInstance($transport);
//     if($mailer->send($message))
    
//     {
//         $_SESSION['successMsg']='Withdrawal Approved Successfully';
//         header("Location:normal_package.php");
//         exit();
//     }

     


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
                                                    <h4>Auto Normal Packages</h4>
                                                    <span>Activate With All Bonuses and Active ROI.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index.php"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">Auto Normal Packages</a> </li>
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
                                    <h3 class="text-center">Auto Normal Package</h3>

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
                                     <select class="form-control select2" name="pkg_name" id="pkg_name">
                                        <option value="">Select Package</option>
                                         <?php 

                                        $sql_pkg = "SELECT * FROM auto_variant where id>0";
                                        $run_pkg = mysqli_query($con , $sql_pkg);
                                        if(!$run_pkg){echo mysqli_error($con);}
                                        while ($row2 = mysqli_fetch_array($run_pkg)):
                                    ?>                                        
                                        <option value="<?php echo $row2['id']; ?>"><?php echo $row2['company'].' '.$row2['model'].' '.$row2['variant'].'  ($'.$row2['price'].')'; ?></option>
                                    <?php endwhile; ?>
                                        
                                    </select>
                                    
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