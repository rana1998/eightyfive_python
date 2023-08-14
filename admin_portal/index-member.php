<?php

// require_once('header.php');

require_once('./core/config.php');
require_once('./helper/AdminHelper.php');

include_once("template-parts/footer.php");
include_once("template-parts/header_links.php");
include_once("template-parts/navbar.php");

$db = getDB();    
$visitorCount = AdminHelper::getDailyVisitorCount($db);
$weeklyVisitedUserIDs  = AdminHelper::getWeeklyVisitedUserIds($db);
$monthlyVisitedUserIDs  = AdminHelper::getMonthlyVisitedUserIds($db);
$userDividendOnDailyBasis  = AdminHelper::getUserDividendOnDailyBasis($db);

$dailyRegisteredUsers = AdminHelper::getDailyRegisteredUserCount($db);
$daiyPurchaseHistoryAsDeposit = AdminHelper::getDailyUserDepositHistroy($db);
$daiyUserWithdrawalCount = AdminHelper::getDailyUserWithdrawalCountHistory($db);

$gtronTokenWalletbalance = AdminHelper::getGtronTokenWalletSummary($db);

$getAdminWalletDetails = AdminHelper::getAdminWalletDetails($db);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">

	<title>Gtron MLM | Main</title>
     
  <?php echo header_links(); ?>

</head>
<body >


 <style>
  .owl-nav.disabled{
    display: none !important;
  }
</style>   

   <!---------NAVBAR START------>
<?php echo navbar_(); ?>
   <!-----NAVBAR END---->



<section id="outer">

<?php include_once("./header/index.php"); ?>

<div class="middle">
   
   <h1><img src="assets/images/icons/profile.png">Welcome, <span><?php echo $adminName;?></span></h1>

   <div class="input-div">
    <img src="assets/images/icons/search.svg" class="search-icon">  
   <input class="search" type="search"  aria-label="Search">
    <button class="search-btn">Search</button>
   </div>


   <div class="row">
      <div class="col-md-8 wallet-div">
         <p>Wallet address : <span>0xAB99a674486F9A2856958214B413a33b91F1a4Df</span></p>
         <button class="copy-btn"><img src="assets/images/icons/copy.svg">Copy</button>
      </div>
      <div class="col-md-4 id-div">
         <div class="id-div-inner">
            <p>My User ID</p> 
            <span>15364</span>
         </div>
      </div>
   </div>

   
   <div class="row">
      <div class="col-md-4 l-div">

         <div class="violet-div">
            <img src="assets/images/violet-graph.png">
            <p>Current Balance</p>
            <h2>$<?php echo number_format($getAdminWalletDetails['wallet_amount'],2) ;?></h2>
         </div>
          
         <div class="orange-div">
            <img src="assets/images/orange-graph.png">
            <p>Direct Referal</p>
            <h2>$8,964.00</h2>
         </div>

         <div class="grey-div">
            <div class="row">
               <div class="col-md-7 col-7">
                  <p>Level Bonus</p>
                  <h2>$867.00</h2>
               </div>
               <div class="col-md-5 col-5">
                  <p>Counts</p>
                  <h2>465</h2>
               </div>
            </div>
            <button>View</button>
         </div>


      </div>
      <div class="col-md-5 m-div">
         
       <div class="pink-div">
            <div class="row">
               <div class="col-md-7">
                  <p>Leadership Bonus</p>
                  <h2>$795.55</h2>
               </div>
               <div class="col-md-5">
                  <img src="assets/images/pink-graph.png">
               </div>
            </div>
            <button>View</button>
      </div>


      <div class="green-div">
            <div class="row">
               <div class="col-md-7">
                  <p>Total Invested</p>
                  <h2>$1,556.00</h2>
               </div>
               <div class="col-md-5">
                  <img src="assets/images/green-graph.png">
               </div>
            </div>
      </div>


      <div class="blue-div">
            <div class="row">
               <div class="col-md-7 col-7">
                  <p>Divident Bonus</p>
                  <h2>$1,375.00</h2>
               </div>
               <div class="col-md-5 col-5">
                  <img src="assets/images/blue-graph-1.png">
               </div>
            </div>

            <div class="row second-row">
               <div class="col-md-7 col-7">
                  <p>Current 3x Bonus</p>
                  <h2>$1,375.00</h2>
               </div>
               <div class="col-md-5 col-5">
                  <img src="assets/images/blue-graph-2.png">
               </div>
            </div>
      </div>


      </div>
      <div class="col-md-3 r-div">
         
      <div class="package-div">
         <div class="white-div">
            <p>ACTIVE PACKAGE</p>
            <h2>100</h2>
            <img src="assets/images/white-graph.png">
         </div>

         <div class="row">
            <div class="col-md-12 text-center">
               <h3>REMAINING TIME:</h3>
               <h4>01D   02H   07M   17S</h4>
            </div>
         </div>

         <button class="upgrade-btn"><img src="assets/images/icons/upgrade.svg">Upgrade</button>

         <hr/>

         <p>SUPER REWARDS</p>
         <img src="assets/images/rewards.png" class="rewards">

         <button class="tree-btn">Tree View</button>
         <button class="activated-btn">4x Activated</button>



      </div>

      </div>
   </div>




<div class="row">
   <div class="col-md-5 tree-div-outer">
      <div class="tree-div">
         <img src="assets/images/tree-view.png">
         <hr/>
         <h2>Tree View</h2>
      </div>
   </div>
   <div class="col-md-7 announcements-outer">
      <div class="announcements">
         <h2><img src="assets/images/icons/horn.svg">Announcements:</h2>
         <p><img src="assets/images/icons/hor.svg">Refer more than 4 people and get exciting 
<b>GTRON Rewards.</b></p>
<p><img src="assets/images/icons/hor.svg">Refer more than 4 people and get exciting 
<b>GTRON Rewards.</b></p>
<p><img src="assets/images/icons/hor.svg">Refer more than 4 people and get exciting 
<b>GTRON Rewards.</b></p>
<p><img src="assets/images/icons/hor.svg">Refer more than 4 people and get exciting 
<b>GTRON Rewards.</b></p>
      </div>
   </div>
</div>



<div class="row">
   <div class="col-md-9 token-div">
      <p>GTron Token Wallet : <span>0xAB99a674486F9A2856958214B413a33b91F1a4Df</span></p>
      <h2>$957</h2>
   </div>
</div>



</div>
<div class="right">
   
<button class="profile-btn"><img src="assets/images/icons/profile.png">Jayson Smith</button>
<h2><img src="assets/images/icons/withdrawals.svg">WITHDRAWALS</h2>


<div class="row">
   <div class="col-md-6 col-6" style="padding: 0.5vw;">
     <button class="wallet-btn">TO GTRON WALLET</button> 
   </div>
    <div class="col-md-6 col-6" style="padding: 0.5vw;">
      <button class="wallet-btn">TO CRYPTO WALLET</button> 
    </div>
</div>


<div class="white-div text-center">
   <input type="text" name="" placeholder="Enter Here">
   <button class="withdraw-btn"><img src="assets/images/icons/withdraw.svg">Withdraw</button>
</div>



</div>

</section>

















   <!---------FOOTER START------>
<?php echo footer_(); ?>
   <!---------FOOTER END------>

<!--------------------------- SCRIPTS ------------------------------------->

<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/sweetalert2.min.js"></script>


</body>
</html>