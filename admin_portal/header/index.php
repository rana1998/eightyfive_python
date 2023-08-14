<?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Get the absolute path to the parent directory
$parentDir = dirname(__DIR__);

// Include the db_config.php file using the correct relative path
require_once $parentDir . '/db_config.php';

session_start();
/*Hearder File 
Contains all information about header */
// If the user is not logged in redirect to the login page...
if(!isset($_SESSION['admin_name'])){
      header("location:login.php"); 
      exit();
}
else
{
    $adminName = $_SESSION['admin_name'];
}

$adminName = $_SESSION['admin_name'];
$selectImages = "select * from project_management";
$resultImages = mysqli_query($con,$selectImages);
$rowImages = mysqli_fetch_assoc($resultImages);

$logo = $rowImages['logo'];
$favIcon = $rowImages['fav_icon'];

$logo1 = '';
$favIcon1 = '';
?>
<div class="left">
   <img src="assets/images/logo/logo.svg" class="logo">
   <ul>
      <li><a><img src="assets/images/icons/dashboard.svg" class="icon">Dashboard</a></li>
      <li><a><img src="assets/images/icons/link.svg" class="icon">Copy Sponsor Link</a></li>
      <li><a><img src="assets/images/icons/profile.svg" class="icon">Profile</a></li>
      <li><a><img src="assets/images/icons/kyc.svg" class="icon">KYC</a></li>
      <li><a><img src="assets/images/icons/buy.svg" class="icon">Buy Package</a></li>
      <li><a><img src="assets/images/icons/withdrawal.svg" class="icon">Withdrawal</a></li>
      <li><a><img src="assets/images/icons/wallet_transfer.svg" class="icon">Internal Wallet Transfer</a></li>
      <li><a><img src="assets/images/icons/network.svg" class="icon">Network</a></li>
      <li><a><img src="assets/images/icons/summary.svg" class="icon">Summary</a></li>
      <li><a><img src="assets/images/icons/support.svg" class="icon">Support</a></li>
   </ul>
   
   <button class="logout"><img src="assets/images/icons/logout.svg">Logout</button>
</div>