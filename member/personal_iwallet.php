<?php
$page_title = 'Personal iWallet';
include 'header.php'; 


if (isset($_POST['withdrawal_request']) && $_POST) {

  $uname = $_SESSION['user_name'];
  $avail_balance     = $userCurrentBalance;
  $desired_amount    = floatval( mysqli_real_escape_string($con , $_POST['desired_amount']) );
  $tax               =  $desired_amount * 0.00;
  
  // $tax = floatval($tax);
  // $tax = number_format($tax, 2);
  $amount_after_tax  = $desired_amount - $tax ;
  $otpCode  = mysqli_real_escape_string($con, $_POST['otpCode']);
  
       
      
  // Check Validation
  if($avail_balance < 10 ){
    $_SESSION['errorMsg'] = "Your Available Balance is less than 10$.";
    header('Location: personal_iwallet.php');
    exit();
  }elseif ($desired_amount < 10 ) {
    $_SESSION['errorMsg'] = "Minimum withdrawal amount is 10$.";
    header('Location: personal_iwallet.php');
    exit();
  }elseif ($desired_amount > $avail_balance ) {
    $_SESSION['errorMsg'] = "Selected amount is greater than your current balance.";
    header('Location: personal_iwallet.php');
    exit();
  }elseif (empty($otpCode)) {
    $_SESSION['errorMsg'] = "Enter Your OTP Code.";
    header('Location: personal_iwallet.php');
    exit();
  }elseif($userOldOtp != $otpCode){
    $_SESSION['errorMsg'] = "Please Enter Valid OTP Code.";
    header('Location: personal_iwallet.php');
    exit();
  }
  else{
// Insert Into Wallet Summary
          $insert = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) 
          VALUES('$user_name', '$desired_amount', 'Transferred To Personal iWallet', 'Cash Wallet', 'Debit')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }
      
          // Insert Into Wallet Summary
          $insert = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) 
          VALUES('$user_name', '$amount_after_tax', 'Received From Personal Cash Wallet', 'iWallet', 'Credit')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }

      // Update User Balance $desired_amount $uname
      $sql = "UPDATE user_registration SET current_balance = current_balance - ? , otp_code=NULL WHERE  user_name = ?";
      $stmt = $con->prepare($sql);
      $stmt->bind_param("ds",$desired_amount, $user_name);
        if ($stmt->execute() === TRUE) {
            $stmt->close();

        }else{
          die(__LINE__ .' Invalid Query '. $con->error );
        }
        
          // Update User Balance $desired_amount $uname
      $sql = "UPDATE user_registration SET iwallet = iwallet + ? WHERE  user_name = ?";
      $stmt = $con->prepare($sql);
      $stmt->bind_param("ds",$amount_after_tax, $user_name);
        if ($stmt->execute() === TRUE) {
            $stmt->close();
            $_SESSION['successMsg'] = "Your Amount is transferred Successfully.";
            header('Location: personal_iwallet.php');
            exit();

        }else{
          die(__LINE__ .' Invalid Query '. $con->error );
        }
         
        
  }
}



?>
<!-- Page Content Start Here -->
<div class="page-wrapper">
  <div class="page-content">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title"><?= $page_title; ?></h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li>&nbsp; / &nbsp;</li>
          <li class="breadcrumb-item active" aria-current="page"><?= $page_title; ?></li>
        </ol>
      </div>
    </div>
    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-lg-6 mx-auto">
        <div class="card">
          <div class="card-body">
            <div class="card-title">To Request Your Withdrawal, Please fill the following form.</div>
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
            <hr>
            <form method = "POST">
              <div class="form-group">
                <label for="avail_balance">Available Balance</label>
                <input type="text" class="form-control " id="avail_balance2" name="avail_balance" value="<?= $userCurrentBalance ?>"  readonly = "">
              </div>

              <div class="form-group mt-3">
                <label for="desired_amount">Desired Amount</label>
                <input type="text" class="form-control " id="desired_amount2" name="desired_amount" value=""  placeholder="e.g. 25 $" >
              </div>

              <!--<div class="form-group mt-3">-->
              <!--  <label for="txtValue">Amount After TAX <small><strong class="text-danger"> (2% Tax)</strong></small> </label>-->
              <!--  <input type="text" class="form-control " id="txtValue2" name="amount_after_tax" value="0" readonly="" >-->
              <!--</div>-->

               <label for="exampleInputEmail1" class="form-label mt-3">OTP Code</label>
                <b class="badge bg-success text-white emailMessageAjax"></b>
             <div class="input-group "> 
                  <input type="text" name="otpCode" class="form-control" placeholder="Enter OTP Code">
                  <button class="btn btn-secondary sendOtpEmail" type="button" >Send Code</button>
              </div>
              <div class="input-group-sm mt-3">
                                <input class="btn bg-gradient-rose-button text-white buttonProcessing" name="withdrawal_request" type="submit" value="SUBMIT NOW">
                                <!--<button></button>-->
                            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
  </div>
  <!-- End container-fluid-->
  
  </div><!--End content-wrapper-->
  
  <?php include 'footer.php'; ?>