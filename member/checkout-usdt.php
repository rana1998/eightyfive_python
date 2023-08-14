<?php
$page_title = 'Buy Package Payment Method ';
 include 'header.php'; 
 if(isset($_GET['pkgId']) and !empty($_GET['pkgId']))
 {
   
    $select = "select * from taxes where type='deposit'";
    $result = mysqli_query($con,$select);
    $row = mysqli_fetch_assoc($result);
    $depositTax = $row['percentage'];
     
      //get current date and time
    date_default_timezone_set("Asia/Manila");
    $currentDateTime= date('Y-m-d h:i:s A');
    $getCurrentDate = substr($currentDateTime,0,10);
    $getCurrentTime= substr($currentDateTime,11,11);
  
    $pkgPrice = mysqli_real_escape_string($con,$_GET['pkgPrice']);
    $pkgId = mysqli_real_escape_string($con,$_GET['pkgId']);
    
     $pkgQuery1="select * from package where id='$pkgId'";
     $pkgResult1=mysqli_query($con,$pkgQuery1);
     $pkgResultData1 =mysqli_fetch_assoc($pkgResult1);
     $pkgNumRow1 = mysqli_num_rows($pkgResult1);
     
     if($pkgNumRow1 != 1)
     {
        $_SESSION['errorMsg'] = "Invalid Request";
        header("location: index.php");
        exit(); 
     }

    $pkgName = $pkgResultData1['package_name'];
   
     
     
     if(isset($_POST['buy_pkg']))
     {
         $trans_id= mysqli_real_escape_string($con,$_POST['transaction_id']);
         
         if(empty($trans_id))
         {
             $_SESSION['errorMsg']='Please enter transaction ID';
             header("location: checkout-usdt.php?pkgPrice=$pkgPrice&pkgId=$pkgId");
             exit();
         }
         
         //verify transaction id duplication start
         
            $sql  = "select * from package_details where trans_id= ? "; // SQL with parameters
            $stmt = $con->prepare($sql);
            $stmt->bind_param("s", $trans_id);
            $run = $stmt->execute();
            if (!$run) {
                die(__LINE__ . 'Invalid Query' . $con->error);
            }
            $result = $stmt->get_result();
            if($result->num_rows > 0)
            {
                 $_SESSION['errorMsg']='Transaction ID already is used';
                 header("location: checkout-usdt.php?pkgPrice=$pkgPrice&pkgId=$pkgId");
                 exit();
            }
            else
            {
                //insert pacakge details
                $pkgMode= 'USDT TRC20';
                $pkgStatus= 'Pending';
                $pkgRoiStatus='Inactive';
                
                $pkgPercentagePrice1 = ($depositTax/100) * $pkgPrice;
                $amountAfterTax = $pkgPercentagePrice1 + $pkgPrice;
                 
                $pkgType = 'NULL';
                $sql="INSERT INTO `package_details`(`user_name`, `sponsor_name`,`pkg_id`,`pkg_name`, `pkg_price`,`tax`,`amount_after_tax`, `mode`,`type`, `trans_id`, `status`, `roi_status`) 
                                VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssisisssssss", $user_name,$sponsorNameHeader,$pkgId,$pkgName,$pkgPrice,$depositTax,$amountAfterTax,$pkgMode,$pkgType,$trans_id,$pkgStatus,$pkgRoiStatus);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
                
                 $_SESSION['successMsg']='Package request submit successfully';
                 header("location: index.php");

                 
                
                //Author: Saisarvesh
                //date updated: 09-05-2023

                 include 'connect.php';

                 $sql= $conn->prepare("SELECT * FROM user_pool_amount WHERE id='1'");
                 $sql->execute();
                 $sql->setFetchMode(PDO::FETCH_ASSOC);
                 if($sql->rowCount()>0){
                 foreach (($sql->fetchAll()) as $key => $row) {
                 
                 $total_pool_amount = $row['total_pool_amount'];
                 $total_sale_amount = $row['total_sale_amount'];

}
}
                
                if($pkgPrice==50){
                  $eligible_shares = 1;  
                }
                if($pkgPrice==100){
                  $eligible_shares = 2;  
                }
                if($pkgPrice==250){
                  $eligible_shares = 5;  
                }
                if($pkgPrice==500){
                  $eligible_shares = 10;  
                }
                if($pkgPrice==1000){
                  $eligible_shares = 20;  
                }

                $pool_amount = ($pkgPrice/100)*20;
                $new_total_pool_amount = $total_pool_amount + $pool_amount;
                $new_total_sale_amount = $total_sale_amount + $pkgPrice;

                $threex_amount_limit = 0;
                $threex_amount = $pkgPrice*3;

                $sql="UPDATE user_pool_amount SET total_sale_amount=:new_total_sale_amount, total_pool_amount=:new_total_pool_amount WHERE id=1";
                     $stmt= $conn->prepare($sql);
                    $result= $stmt->execute(array(
                     ':new_total_pool_amount'=>$new_total_pool_amount,
                     ':new_total_sale_amount'=>$new_total_sale_amount,
));


                $sql2="UPDATE user_registration SET active_investment=:active_investment, threex_amount_limit=:threex_amount_limit, threex_amount=:threex_amount, eligible_shares=:eligible_shares WHERE user_name='".$_SESSION['user_name']."'";
                     $stmt2= $conn->prepare($sql2);
                    $result2= $stmt2->execute(array(
                    ':active_investment'=>$pkgPrice,
                     ':threex_amount_limit'=>$threex_amount_limit,
                     ':threex_amount'=>$threex_amount,
                     ':eligible_shares'=>$eligible_shares,
));


                  

                 exit();  
                




             }
         
         
         
     }
     
     
 }
 else
 {
    $_SESSION['errorMsg'] = "Invalid Request";
    header("location: index.php");
    exit();  
 }
 
 
 
?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
          <!--Start Content-->
          <div class="row mt-5 mb-5">
              <div class="col-md-6 mx-auto">
                <div class="card card-border-color card-border-color-primary">
                    <div class="card-header card-header-divider text-center">
                        <h2><strong class="text-dark">Buy with USDT (TRC20)</strong></h2>
                    </div>
                    <div class="card-body">
                    <div class="col-md-12">
        <!-- successMsg Alert  -->
        
        <!-- errorMsg Alert  -->
              </div>
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
                        <form method="POST">
                            <!-- pkg id -->
                            <input class="form-control" name="pkg_id" value="<?php echo $pkgId;?>" type="hidden" readonly>
                            <div class="mb-3">
                                  <b>You have selected a package: <span class="btn btn-warning btn-sm"><?=$pkgName?></span></b>
                            </div>
                            <div class="p-3" style="">
                                <div class="d-flex justify-content-between">
                                    <div>To</div>
                                    <div>Date</div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <b>MLM Marketing</b>
                                    <b><?php echo $getCurrentDate;?></b>
                                </div>
                                <br>
                                <div class="d-flex justify-content-between">
                                    <div>Invoice Title</div>
                                    <div>Amount</div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <b>New Package</b>
                                    <b>$<?php echo $pkgPrice?></b>
                                </div>
                                
                                <div class="d-flex justify-content-between">
                                    <b>Activation Fee</b>
                                    <b><?php echo $depositTax?>%</b>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <b>Total Amount: </b>
                                    <b><?php
                                           
                                                      $pkgPercentagePrice = ($depositTax/100) * $pkgPrice;
                                                      $pkgPrice = $pkgPercentagePrice + $pkgPrice;
                                                 echo '$'.$pkgPrice;
                                           
                                            ?>
                                    </b>
                            </div>
                            <p class="text-center mt-3 mb-3">Please send your payment to the following address</p>
                            <div class="text-center">
                                    <img class="img-responsive center-block" src="https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=TV7njbQNi16uC8srMjExHQxp3L4BvSDvJa" alt="QRcode">
                                    <div class="mt-3">
                                        <b style="font-size:20px">Address</b>
                                        <div style="font-size:18px">TV7njbQNi16uC8srMjExHQxp3L4BvSDvJa</div>
                                    </div>
                                    <div class="mt-3">
                                        <b style="font-size:20px">Amount To Pay</b>
                                        <div style="font-size:18px">
                                            <?php
                                            //added price with tax
                                            echo '$'.$pkgPrice;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group-sm m-2">
                                <label class="col-form-label text-left" for="inputText3" style="font-size:14px;color:red">*Pay Exact Amount And Enter Transaction Id Here</label>
                                <input class="form-control" id="inputText3" placeholder="Enter Transaction ID" value="" name="transaction_id" type="text" >
                            </div>
                           
                            <div class="input-group-sm m-2">
                                <input class="btn bg-gradient-rose-button p-2 mb-2 text-white w-100" name="buy_pkg" type="submit" value="MAKE PAYMENT AS SENT">
                            </div>
                          
                        </form>
                    </div>
                </div>
            </div>
        </div>
         
         </div><!--End Row-->
          <!--End Content-->
    </div>
    <!-- End container-fluid-->
</div><!--End content-wrapper-->


<?php include 'footer.php'; ?>