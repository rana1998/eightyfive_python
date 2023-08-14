<?php 
include "core/connection.php";
include('userInformation.php');
    // If the user is not logged in redirect to the login page...
if(!isset($_SESSION['user_name'])){
  header("Location: ../mlm_landing/index.php");
  exit();
}
$user_name = $_SESSION['user_name'];
// Getting User Status 
$sql = "SELECT * FROM user_registration WHERE user_name = ?"; // SQL with parameters
$stmt = $con->prepare($sql); 
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result
$data = $result->fetch_assoc();
$userStatus = $data['status'];
$total_invest = $data['total_invest'];
$totalIncome = $data['total_income'];
$full_name = $data['full_name'];
$fectchUserName = $data['user_name'];

$threexcamountt = $data['threex_amount'];
$userStreet = $data['address'];
$userCity = $data['city'];
$userState = $data['state'];
$userPostalCode = $data['postal_code'];
$userMobile = $data['phone'];
$userCountry = $data['country'];
$transactionPassword = $data['transaction_password'];
$userImage = $data['profile_pic'];
$email = $data['email'];
$userDirectBonus = $data['db'];
$userPassword = $data['password'];
$sponsorNameHeader = $data['sponsor_name'];
$userCurrentBalance = $data['current_balance'];
$userIWallet = $data['iwallet'];
// $userHoldBalance = $data['hold_balance'];
$userMaxIncome = $data['max_income'];
$userOldOtp = $data['otp_code'];
$pendingBalance = $data['pending_amount'];
$userUsdtTrcAdress = $data['wallet_address'];
$userPkgId = $data['pkg_id'];
// $dTeam = $data['d_team'];
$userDSales = $data['d_sale'];
$userTeamSales = $data['team_sales'];
$userDirectSales = $data['d_sale'];
$userTotalTeam = $data['total_team'];
$userDirectTeam = $data['direct_team'];
$userRank = $data['rank'];
$userKyc = $data['kyc'];
$roiToday = $data['roi_today'];
$roiDaily = $data['roi_daily'];
$sflag = $data['sflag'];
$userIdb= $data['idb'];
$userRoi= $data['roi'];
$userMonthlyShare = $data['monthly_share'];
// $leaderTeamSales = $data['leader_team_sales'];
// $leadershipBonus = $data['leadership_bonus'];
$activationFee = $data['activation_fee'];

$regDate=$data['date'];

$stmt->close();

// $packageId = $data['pkg_id'];
// if($packageId == 0){
//     header("location: buy-pkg.php?package_type=1");
// }

if($sflag != 1){
  unset($_SESSION['email']);
  unset($_SESSION['user_name']);
  $_SESSION['errorMsg'] = "Your account has been locked due to security reason.";
  header("Location: ../mlm_landing/index.php");
  exit();
}


// $packageDetailsQuery="select * from package where id='$userPkgId'";
// $packageDetailsQueryResult=mysqli_query($con,$packageDetailsQuery);
// $packageDetailsResult = mysqli_fetch_assoc($packageDetailsQueryResult);

// $userPkgName=$packageDetailsResult['pkg_name'];


$selectImages = "select * from project_management";
$resultImages = mysqli_query($con,$selectImages);
$rowImages = mysqli_fetch_assoc($resultImages);

$logo = $rowImages['logo'];
$favIcon = $rowImages['fav_icon'];

$logo1 = 'https://GTRON.com/admin_portal/'.$logo;
$favIcon1 = 'https://GTRON.com/admin_portal/'.$favIcon;


?>
<!-- Mirrored from codervent.com/rocker/demo/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 15 Aug 2021 08:45:37 GMT -->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="<?=$favIcon1?>" type="image/png" />
    <!--plugins-->

    <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
     <!--image uploader-->
    <link href="assets/plugins/fancy-file-uploader/fancy_fileupload.css" rel="stylesheet" />
	<link href="assets/plugins/Drag-And-Drop/dist/imageuploadify.min.css" rel="stylesheet" />
	<!--image uploader end-->
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
   
    <!--date picker-->
    <link href="assets/plugins/datetimepicker/css/classic.css" rel="stylesheet" />
	<link href="assets/plugins/datetimepicker/css/classic.time.css" rel="stylesheet" />
	<link href="assets/plugins/datetimepicker/css/classic.date.css" rel="stylesheet" />
	<link rel="stylesheet" href="assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css">
    <!--date picker end-->
    <!--tree structure-->
    <!--<link href="assets/css/tree-structure.css" rel="stylesheet">-->
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    
    <!--Fonr awsome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="assets/plugins/treeview/treeview.css">  
    <link rel="stylesheet" href="assets/plugins/iconfonts/font-awesome/css/font-awesome.min.css" />
    
    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="assets/css/dark-theme.css" />
    <link rel="stylesheet" href="assets/css/semi-dark.css" />
    <link rel="stylesheet" href="assets/css/header-colors.css" />
    <script src="https://cdn.jsdelivr.net/npm/web3@1.5.2/dist/web3.min.js"></script>

    <!-- Select 2 script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!---Toastify --->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <script src="https://cdn.jsdelivr.net/npm/tronweb/dist/tronweb.js"></script>

    <title><?= $page_title?></title>
    
    
    <style>
        .error
        {
            color:red;
        }
    </style>
</head>

<body>
    <!-- Modal -->
<div class="modal fade" id="copySponsorLink" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Sponsor Link</h5>
        <span id="linkCopiedMsg" style="font-size:18px" class="text-success"></span>
      </div>
      <div class="modal-body">
        <div class="">
        <input type="text" readonly value="https://mlm-user.eighty5technologies.com/mlm_landing/index.php?reff=<?php echo $user_name?>" class="form-control form-control-sm" id="copyReferal">
        
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        <button type="button" onclick="copyReferal()" class="btn bg-gradient-rose-button-dark  text-white btn-sm">Copy</button>
      </div>
    </div>
  </div>
</div>

<!--modal end-->
<!--wrapper-->
<div class="wrapper">
    <!--sidebar wrapper -->
    <div class="sidebar-wrapper bg-gradient-rose-button" data-simplebar="true">
        <div class="sidebar-header">
            <div>
                <!--<img src="<?php echo 'https://GTRON.com/admin_portal/'.$favIcon?>" width="40" height="40" class="" alt="logo icon">-->
            </div>
            <div>
                <b class="logo-text" style="color:#1e2340;font-size:16px">GTRON</b>
                <!--<img src="<?php echo 'https://GTRON.com/admin_portal/'.$logo?>" width="130" class="logo-text img-fluid" alt="logo icon">-->
            
            </div>
            <div class="toggle-icon ms-auto"><i style="color :#1e2340" class='bx bx-arrow-to-left'></i>
            </div>
        </div>
        <!--navigation-->
        <ul class="metismenu" id="menu">
            <li>
                <a href="index.php" class="text-white">
                    <div class="parent-icon "><i class='bx bx-home-circle'></i>
                    </div>
                    <div class="menu-title ">Dashboard</div>
                </a>
            </li>
            <?php
            if($userStatus=='Approved')
            {
            ?>
            <li >
            
                  <a style="border: 1px solid white;" href="#" data-bs-toggle="modal" data-bs-target="#copySponsorLink" class=" text-white bg-gradient-rose-button-dark">
                      <!--<i class="fa fa-copy"></i>-->
                      <!--<span>Copy Sponsor Link</span>-->
                      <div class="parent-icon "><i class='bx bx-copy'></i>
                        </div>
                        <div class="menu-title ">Copy Sponsor Link</div>
                  </a>
                
            </li>
            <?php
            }
            ?>
            <li>
                <a href="profile.php" class="text-white">
                    <div class="parent-icon"><i class='bx bxs-user'></i>
                    </div>
                    <div class="menu-title">Profile</div>
                </a>
            </li>
            <li>
                <a href="kyc.php" class="text-white">
                    <div class="parent-icon"><i class="bx bxs-file-image"></i>
                    </div>
                    <div class="menu-title">KYC</div>
                </a>
              </li>
            
            <li>
                <a href="buy-pkg.php" class="text-white">
                    <div class="parent-icon"><i class='bx bx-dollar'></i>
                    </div>
                    <div class="menu-title">Buy Package</div>
                </a>
            </li>
             <li>
                <a href="withdrawal.php" class="text-white">
                    <div class="parent-icon"><i class='bx bxs-dollar-circle'></i>
                    </div>
                    <div class="menu-title">Withdrawal</div>
                </a>
            </li>
            <li>
                <a href="internal-wallet-transfer.php" class="text-white">
                    <div class="parent-icon"><i class='bx bxs-dollar-circle'></i>
                    </div>
                    <div class="menu-title">Internal Wallet Transfer</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="has-arrow text-white">
                    <div class="parent-icon"><i class="lni lni-users"></i>
                    </div>
                    <div class="menu-title">Network</div>
                </a>
                <ul class="bg-gradient-rose-button border-0 text-white">
                    <li> <a href="direct_team.php" style="color: white"><i class="bx bx-right-arrow-alt"></i>Referral Team</a>
                    </li>
                    <!--<li> <a href="structure.php" style="color: white"><i class="bx bx-right-arrow-alt "></i>Tree Structure</a>-->
                    <!--</li>-->

                </ul>
            </li>
         
            <li>
                <a href="javascript:;" class="has-arrow text-white">
                    <div class="parent-icon"><i class="bx bxs-file"></i>
                    </div>
                    <div class="menu-title">Summary </div>
                </a>
                <ul class="bg-gradient-rose-button border-0 text-white">
                    <li> <a href="package_summary.php" style="color: white"><i class="bx bx-right-arrow-alt"></i>Package Summary</a>
                    </li>
                    <li> <a href="bonuses_summary.php" style="color: white"><i class="bx bx-right-arrow-alt"></i>Level Bonus Summary</a>
                    </li>
                   
                    <li> <a href="level_report.php" style="color: white"><i class="bx bx-right-arrow-alt "></i>Level Report</a>
                    </li>
                    
                    <li> <a href="withdrawal_summary.php" style="color: white"><i class="bx bx-right-arrow-alt "></i>Withdrawals</a>
                    </li>
                    <li> <a href="cash_wallet_summary.php" style="color: white"><i class="bx bx-right-arrow-alt "></i>Wallet Summary</a>
                    </li>
                    <li> <a href="pending-wallet-balance-summary.php" style="color: white"><i class="bx bx-right-arrow-alt "></i>Pending Balance Wallet Summary</a>
                    </li>
                </ul>
            </li>
           
            
            
            <li>
                <a href="javascript:;" class="has-arrow text-white">
                    <div class="parent-icon"><i class="bx bx-support"></i>
                    </div>
                    <div class="menu-title">Support </div>
                </a>
                <ul class="bg-gradient-rose-button border-0 text-white">
                    <li> <a href="support.php" style="color: white"><i class="bx bx-right-arrow-alt"></i>Submit Ticket</a>
                    </li>
                    <li> <a href="support_summary.php" style="color: white"><i class="bx bx-right-arrow-alt"></i>Summary</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="logout.php" class="text-white">
                    <div class="parent-icon"><i class='bx bx-log-out-circle'></i>
                    </div>
                    <div class="menu-title">Logout</div>
                </a>
            </li>

        </ul>
        <!--end navigation-->
    </div>
    <!--end sidebar wrapper -->
    <!--start header -->
    <header>
        <div class="topbar d-flex align-items-center">
            <nav class="navbar navbar-expand">
                <div class="mobile-toggle-menu"><i class='bx bx-menu'></i>
                </div>
                <div class="search-bar flex-grow-1">
<!--                    <div class="position-relative search-bar-box">-->
<!--                        <input type="text" class="form-control search-control" placeholder="Type to search..."> <span class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span>-->
<!--                        <span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span>-->
<!--                    </div>-->
                </div>
                <div class="top-menu ms-auto">
                    <ul class="navbar-nav align-items-center">
                        <!--<li class="nav-item mobile-search-icon">-->
                        <!--    <a class="nav-link" href="#">	<i class='bx bx-search'></i>-->
                        <!--    </a>-->
                        <!--</li>-->
                        <li class="nav-item dropdown dropdown-large">
<!--                            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">	<i class='bx bx-category'></i>-->
<!--                            </a>-->
                            <div class="dropdown-menu dropdown-menu-end">
                                <div class="row row-cols-3 g-3 p-3">
                                    <div class="col text-center">
                                        <div class="app-box mx-auto bg-gradient-cosmic text-white"><i class='bx bx-group'></i>
                                        </div>
                                        <div class="app-title">Teams</div>
                                    </div>
                                    <div class="col text-center">
                                        <div class="app-box mx-auto bg-gradient-burning text-white"><i class='bx bx-atom'></i>
                                        </div>
                                        <div class="app-title">Projects</div>
                                    </div>
                                    <div class="col text-center">
                                        <div class="app-box mx-auto bg-gradient-lush text-white"><i class='bx bx-shield'></i>
                                        </div>
                                        <div class="app-title">Tasks</div>
                                    </div>
                                    <div class="col text-center">
                                        <div class="app-box mx-auto bg-gradient-kyoto text-dark"><i class='bx bx-notification'></i>
                                        </div>
                                        <div class="app-title">Feeds</div>
                                    </div>
                                    <div class="col text-center">
                                        <div class="app-box mx-auto bg-gradient-blues text-dark"><i class='bx bx-file'></i>
                                        </div>
                                        <div class="app-title">Files</div>
                                    </div>
                                    <div class="col text-center">
                                        <div class="app-box mx-auto bg-gradient-rose-button text-white"><i class='bx bx-filter-alt'></i>
                                        </div>
                                        <div class="app-title">Alerts</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown dropdown-large">
                            <!--<a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">7</span>-->
                            <!--    <i class='bx bx-bell'></i>-->
                            <!--</a>-->
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:;">
                                    <div class="msg-header">
                                        <p class="msg-header-title">Notifications</p>
                                        <p class="msg-header-clear ms-auto">Marks all as read</p>
                                    </div>
                                </a>
                                <div class="header-notifications-list">
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-primary text-primary"><i class="bx bx-group"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">New Customers<span class="msg-time float-end">14 Sec
												ago</span></h6>
                                                <p class="msg-info">5 new user registered</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-danger text-danger"><i class="bx bx-cart-alt"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">New Orders <span class="msg-time float-end">2 min
												ago</span></h6>
                                                <p class="msg-info">You have recived new orders</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-success text-success"><i class="bx bx-file"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">24 PDF File<span class="msg-time float-end">19 min
												ago</span></h6>
                                                <p class="msg-info">The pdf files generated</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-warning text-warning"><i class="bx bx-send"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">Time Response <span class="msg-time float-end">28 min
												ago</span></h6>
                                                <p class="msg-info">5.1 min avarage time response</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-info text-info"><i class="bx bx-home-circle"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">New Product Approved <span
                                                        class="msg-time float-end">2 hrs ago</span></h6>
                                                <p class="msg-info">Your new product has approved</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-danger text-danger"><i class="bx bx-message-detail"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">New Comments <span class="msg-time float-end">4 hrs
												ago</span></h6>
                                                <p class="msg-info">New customer comments recived</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-success text-success"><i class='bx bx-check-square'></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">Your item is shipped <span class="msg-time float-end">5 hrs
												ago</span></h6>
                                                <p class="msg-info">Successfully shipped your item</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-primary text-primary"><i class='bx bx-user-pin'></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">New 24 authors<span class="msg-time float-end">1 day
												ago</span></h6>
                                                <p class="msg-info">24 new authors joined last week</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="notify bg-light-warning text-warning"><i class='bx bx-door-open'></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">Defense Alerts <span class="msg-time float-end">2 weeks
												ago</span></h6>
                                                <p class="msg-info">45% less alerts last 4 weeks</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="text-center msg-footer">View All Notifications</div>
                                </a>
                            </div>
                        </li>
                        <li class="nav-item dropdown dropdown-large">
<!--                            <a class="nav-link dropdown-toggle dropdown-toggle-nocaret position-relative" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> <span class="alert-count">8</span>-->
<!--                                <i class='bx bx-comment'></i>-->
<!--                            </a>-->
                            <div class="dropdown-menu dropdown-menu-end">
                                <a href="javascript:;">
                                    <div class="msg-header">
                                        <p class="msg-header-title">Messages</p>
                                        <p class="msg-header-clear ms-auto">Marks all as read</p>
                                    </div>
                                </a>
                                <div class="header-message-list">
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="user-online">
                                                <img src="assets/images/avatars/avatar-1.png" class="msg-avatar" alt="user avatar">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">Daisy Anderson <span class="msg-time float-end">5 sec
												ago</span></h6>
                                                <p class="msg-info">The standard chunk of lorem</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="user-online">
                                                <img src="assets/images/avatars/avatar-2.png" class="msg-avatar" alt="user avatar">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">Althea Cabardo <span class="msg-time float-end">14
												sec ago</span></h6>
                                                <p class="msg-info">Many desktop publishing packages</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="user-online">
                                                <img src="assets/images/avatars/avatar-3.png" class="msg-avatar" alt="user avatar">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">Oscar Garner <span class="msg-time float-end">8 min
												ago</span></h6>
                                                <p class="msg-info">Various versions have evolved over</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="user-online">
                                                <img src="assets/images/avatars/avatar-4.png" class="msg-avatar" alt="user avatar">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">Katherine Pechon <span class="msg-time float-end">15
												min ago</span></h6>
                                                <p class="msg-info">Making this the first true generator</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="user-online">
                                                <img src="assets/images/avatars/avatar-5.png" class="msg-avatar" alt="user avatar">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">Amelia Doe <span class="msg-time float-end">22 min
												ago</span></h6>
                                                <p class="msg-info">Duis aute irure dolor in reprehenderit</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="user-online">
                                                <img src="assets/images/avatars/avatar-6.png" class="msg-avatar" alt="user avatar">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">Cristina Jhons <span class="msg-time float-end">2 hrs
												ago</span></h6>
                                                <p class="msg-info">The passage is attributed to an unknown</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="user-online">
                                                <img src="assets/images/avatars/avatar-7.png" class="msg-avatar" alt="user avatar">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">James Caviness <span class="msg-time float-end">4 hrs
												ago</span></h6>
                                                <p class="msg-info">The point of using Lorem</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="user-online">
                                                <img src="assets/images/avatars/avatar-8.png" class="msg-avatar" alt="user avatar">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">Peter Costanzo <span class="msg-time float-end">6 hrs
												ago</span></h6>
                                                <p class="msg-info">It was popularised in the 1960s</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="user-online">
                                                <img src="assets/images/avatars/avatar-9.png" class="msg-avatar" alt="user avatar">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">David Buckley <span class="msg-time float-end">2 hrs
												ago</span></h6>
                                                <p class="msg-info">Various versions have evolved over</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="user-online">
                                                <img src="assets/images/avatars/avatar-10.png" class="msg-avatar" alt="user avatar">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">Thomas Wheeler <span class="msg-time float-end">2 days
												ago</span></h6>
                                                <p class="msg-info">If you are going to use a passage</p>
                                            </div>
                                        </div>
                                    </a>
                                    <a class="dropdown-item" href="javascript:;">
                                        <div class="d-flex align-items-center">
                                            <div class="user-online">
                                                <img src="assets/images/avatars/avatar-11.png" class="msg-avatar" alt="user avatar">
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="msg-name">Johnny Seitz <span class="msg-time float-end">5 days
												ago</span></h6>
                                                <p class="msg-info">All the Lorem Ipsum generators</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <a href="javascript:;">
                                    <div class="text-center msg-footer">View All Messages</div>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="user-box dropdown">
                    <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="assets/images/user-profile/<?= $userImage?>" class="user-img" alt="user avatar">
                        <div class="user-info ps-3">
                            <p class="user-name mb-0 text-capitalize"><?= $full_name?></p>
                            <p class="designattion mb-0 text-uppercase"><?= $user_name?></p>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profile.php"><i class="bx bx-user"></i><span>Profile</span></a>
                        </li>
                       
                        <li>
                            <div class="dropdown-divider mb-0"></div>
                        </li>
                        <li><a class="dropdown-item" href="logout.php"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!--end header -->