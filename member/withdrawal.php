<?php
$page_title = 'Withdrawal Request';
include 'header.php'; 
    

//Sb(QUZi5@t}
//mailcheck@eighty5technologies.com
//

// $day = date('l', time());
// if($day != 'Saturday' && $day != 'Sunday' ){
//     $_SESSION['errorMsg'] = "Withdrawal is available only Saturday and Sunday.";
//     header('Location: index.php');
//     exit();
// }

if($userKyc!='Verified')
{
    $_SESSION['errorMsg'] = "Please approve your KYC";
    header('Location: index.php');
    exit();
}


$sel = "select * from withdrawal_limit where id = '1'";
$res = mysqli_query($con,$sel);
$rr = mysqli_fetch_assoc($res);
$withDrawalLimit = $rr['amount'];


$sql = "SELECT * FROM user_registration WHERE user_name = ?"; // SQL with parameters
$stmt = $con->prepare($sql); 
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result
if($result->num_rows < 1){
  $stmt->close();
  $_SESSION['errorMsg']='Invalid Request';
  header("Location: index.php");
  exit();
}else{
  $data = $result->fetch_assoc();
  $current_balance = $data['current_balance'];
  $email = $data['email'];
  $password = $data['password'];
}






    $select9 = "select * from taxes where type='withdrawal'";
    $result9 = mysqli_query($con,$select9);
    $row9 = mysqli_fetch_assoc($result9);
    $withdrawalPercentage1 = $row9['percentage'];
    $withdrawalTax1 = $withdrawalPercentage1/100;
    








if (isset($_POST['withdrawal_request']) && $_POST) {

  $avail_balance     = $userCurrentBalance;
  $desired_amount    = floatval( mysqli_real_escape_string($con , $_POST['desired_amount']) );
 

  $finalAmountTax = $desired_amount * $withdrawalTax1;
   

  

  // $tax = floatval($tax);
  // $tax = number_format($tax, 2);

  $transactionpassword  = mysqli_real_escape_string($con , $_POST['transactionpassword']);
  $amount_after_tax  = mysqli_real_escape_string($con , $_POST['amount_after_tax']);
  $btc_address       = $userUsdtTrcAdress;
  $otpCode              = mysqli_real_escape_string($con, $_POST['2facode']);
  $mode = 'USDT.TRC20';
//   $bank =  mysqli_real_escape_string($con, $_POST['bankName']);
//   $accountTitle =  mysqli_real_escape_string($con, $_POST['accountTitle']);
//   $accountNo =  mysqli_real_escape_string($con, $_POST['accountNo']);

$sql = "SELECT * FROM user_registration WHERE user_name = ?"; // SQL with parameters
$stmt = $con->prepare($sql); 
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result
if($result->num_rows < 1){
  $stmt->close();
  $_SESSION['errorMsg']='Invalid Request';
  header("Location: index.php");
  exit();
}else{
  $data = $result->fetch_assoc();
  $current_balance = $data['current_balance'];
  $email = $data['email'];
  $password = $data['password'];
  $currentOTP = $data['otp_code'];
}
  
if (empty($otpCode)) {
  $_SESSION['errorMsg'] = "Enter Your 2FA Code.";
  header('Location: withdrawal.php');
  exit();
}elseif($currentOTP != $otpCode){
  $_SESSION['errorMsg'] = "Please Enter Valid 2FA Code.";
  header('Location: withdrawal.php');
  exit();
}elseif(password_verify($transactionPassword, $transactionpassword)){
  $_SESSION['errorMsg'] = "Please Enter Correct Transaction Password..";
  header('Location: withdrawal.php');
  exit();
}
    

  // Check Validation
  if($avail_balance < $withDrawalLimit ){

    $_SESSION['errorMsg'] = "Your Available Balance is less than $withDrawalLimit.";
    header('Location: withdrawal.php');
    exit();

  }elseif ($desired_amount < $withDrawalLimit ) {

    $_SESSION['errorMsg'] = "Minimum withdrawal amount is $withDrawalLimit.";
    header('Location: withdrawal.php');
    exit();

  }elseif ($desired_amount > $avail_balance ) {

    $_SESSION['errorMsg'] = "Withdrawal amount is greater than your current balance.";
    header('Location: withdrawal.php');
    exit();
    
  }
  elseif(empty($mode))
  {
        $_SESSION['errorMsg'] = "Please Select Mode.";
        header('Location: withdrawal.php');
        exit();
  }
  elseif($mode=='USDT.TRC20' && empty($btc_address)) {
    $_SESSION['errorMsg'] = "Set your wallet address in profile";
    header('Location: withdrawal.php');
    exit();
  }
 
  else{
     
      
          
          $amountAfterTax = $desired_amount - $finalAmountTax;
          
         
          // Insert in Withdrawal table
      // $sql="INSERT INTO withdrawal( `user_name`, `email`, `desire_amount`, `amount_after_tax`, `tax`, `mode`, `btc_address`, `status` )
      //               VALUES(?,?,?,?,?,?,?,?)";
      // $stmt = $con->prepare($sql);
      // $stmt->bind_param("ssdddsss",$user_name,$email,$desired_amount,$amountAfterTax,$withdrawalPercentage1,$mode,$btc_address,'Completed');
      //   if ($stmt->execute() === TRUE) {
      //       $stmt->close();
      //   }else{
      //     die(__LINE__ .' Invalid Query '. $con->error );
      //   }
      $date = date('Y-m-d');
      
     echo $sql="INSERT INTO `withdrawal`(`id`, `user_name`, `email`, `desire_amount`, `amount_after_tax`, `tax`, `mode`, `bank`, `account_title`, `account_no`, `btc_address`, `status`, `reject_reason`, `date`) 
     VALUES ('','$user_name','$email','$desired_amount','$amountAfterTax','$withdrawalPercentage1','$mode','','','','$btc_address','Completed','','$date')";
                   $run_insert = mysqli_query($con, $sql);
// Insert Into Wallet Summary
          $insert = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) 
          VALUES('$user_name', '$desired_amount', 'Withdrawal Request', 'Cash Wallet', 'Debit')";
    
          $run_insert = mysqli_query($con, $insert);
          if(!$run_insert){
            echo '<h6>'.mysqli_error($con).'</h6>';
          }

      // Update User Balance $desired_amount $uname
      
      $sql = "UPDATE user_registration SET current_balance = current_balance - ? , otp_code = NULL WHERE  user_name = ?";
      $stmt = $con->prepare($sql);
      $stmt->bind_param("ds",$desired_amount, $user_name);
        if ($stmt->execute() === TRUE) {
            $stmt->close();
            $_SESSION['successMsg'] = "Your Withdrawal Request is Processed Successfully. Please wait for 3-4 Block Confirmation to reflect amount in Your Wallet.";
            header('Location: withdrawal.php');
            exit();

        }else{
          die(__LINE__ .' Invalid Query '. $con->error );
        }
        
        //insert wallet summary
      
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
                <input type="text" class="form-control " id="avail_balance_withdrawal" name="avail_balance" value="<?= $current_balance ?>"  readonly = "">
              </div>

              <div class="form-group mt-3">
                <label for="desired_amount">Desired Amount</label> <b id="taxAmountError" class="text-danger"></b>
                <input type="text" class="form-control " id="desireAmountWithdrawal" name="desired_amount" value="" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"   autocomplete="off" placeholder="e.g. <?php echo $withDrawalLimit;?>" >
              </div>

              <div class="form-group mt-3">
                <label for="txtValue">Receive Amount </label> <b class="text-danger">(<?=$withdrawalPercentage1?>% Withdrawal Fee.) <span id="usdAmountHERE"></span></b>
                <input type="text" class="form-control " id="txtValueWithdrawal" name="amount_after_tax" value="$0" readonly="" >
                
              </div>
              
              <?php
              if(empty($userUsdtTrcAdress))
              {
              ?>
              <br>
              <b>Your address is not set </b><a href="profile.php"><span class="badge bg-success">Click here</span></a> <b> to set address</b>
              <br>
                
              <?php
              }
              else
              {
              ?>
                <div class="form-group mt-3">
                    <label>Your USDT (TRC20) Address</label>
                    <br>
                    <b class="text-primary"><?=$userUsdtTrcAdress?></b>
                </div>
                
              <?php
              }
              ?>
               <label for="exampleInputEmail1" class="form-label mt-3">Request for 2FA Code:</label>
               <b class="badge bg-success text-white emailMessageAjax"></b>
             <div class="input-group "> 
                  <input type="text" name="otpCode" class="form-control" value="<?php echo $email; ?>" placeholder="Enter 2FA Code Sent on Email" readonly>
                  <button class="btn btn-secondary sendOtpEmail" type="button" >Send Code</button>
                  
              </div>

              
              <div class="form-group mt-3">
              <?php if($email !== ""){ ?>
                <label for="txtValue">Enter 2FA Code Sent on Email:</label>
                <input type="text" class="form-control " placeholder="Enter 2FA Code Sent on Email" name="2facode" value="">
                <?php }else{ ?><b>Don't have Email Set? </b><a href="profile.php"><span class="badge bg-success">Click here</span></a> <b> to set.</b>
              </div> <?php } ?>

              <div class="form-group mt-3">
                <label for="txtValue">Enter Transaction Password: </label>
                <input type="password" class="form-control " placeholder="Enter Transaction Password" name="transactionpassword" value="">
                <b>Don't have transaction Password Set? </b><a href="profile.php"><span class="badge bg-success">Click here</span></a> <b> to set.</b>
              </div>
              
              <div class="input-group-sm mt-3">
                 <input class="btn bg-gradient-rose-button text-white buttonProcessing" name="withdrawal_request" type="submit" value="Submit Now">
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
  
  <script>
      
    $('#desireAmountWithdrawal').on('keyup', function() {
    //   var desireValue = parseFloat($('#desireAmountWithdrawal').val());
    //   var avail_balance = parseFloat($('#avail_balance_withdrawal').val());
     
    //     if(desireValue == '')
    //     {
    //          finalAmount= '$0';
    //          $('#taxPercentage').html('');
    //          $('#taxAmountError').html('Minimum 20$');
    //     }
    //     else if(desireValue < 20)
    //     {
    //          finalAmount= '$0';
    //          $('#taxPercentage').html('');
    //          $('#taxAmountError').html('Minimum 20$');
    //     }
    //     else if(desireValue <= 50)
    //     {
    //          finalAmount = '$'+ (desireValue - 2);
    //          $('#taxPercentage').html('$2');
    //          $('#taxAmountError').html('');
    //     }
    //     else if(desireValue > 50)
    //     {
    //         finalAmount = '$'+ (desireValue - desireValue*0.03);
    //         $('#taxPercentage').html("");
    //         $('#taxAmountError').html('');
    //     }

    //   // withdrawal_amount =Math.round(withdrawal_amount);
    //   $('#txtValueWithdrawal').val(finalAmount);
      
      var desireValue = parseFloat($('#desireAmountWithdrawal').val());
      var avail_balance = parseFloat($('#avail_balance_withdrawal').val());
        var per = '<?php echo $withdrawalTax ?>';
        console.log(per)
        finalAmount = '$'+ (desireValue - desireValue*parseFloat(per));
        amountHere = '($' + (desireValue*parseFloat(per)) + ')';
        
        document.getElementById('usdAmountHERE').innerHTML = amountHere;

        // withdrawal_amount =Math.round(withdrawal_amount);
        $('#txtValueWithdrawal').val(finalAmount);
      
    });
  </script>