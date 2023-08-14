<?php
ob_start();
$page_title="Dashboard";
include 'header.php';
?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 ">
            <div class="col-12">


        <?php
                require 'connect.php';
                $isPackageActive = 0;
                $levelBonus = 0;

                $sql = $conn->prepare("SELECT COUNT(*) AS total_count FROM user_registration WHERE sponsor_name = '".$_SESSION['user_name']."'");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $result = $sql->fetch();
                $totalDirectReferalCount = $result['total_count'];


                // function countIndirectReferrals($conn, $sponsorId) {
                //     $sql = $conn->prepare("SELECT COUNT(*) AS total_count FROM user_registration WHERE sponsor_name = :sponsor_id");
                //     $sql->bindParam(':sponsor_name', $sponsorId);
                //     $sql->execute();
                //     $result = $sql->fetch(PDO::FETCH_ASSOC);
                //     $totalCount = $result['total_count'];
                
                //     $indirectCount = 0;
                
                //     if ($totalCount > 0) {
                //         // Loop through each direct referral
                //         while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
                //             $indirectCount += countIndirectReferrals($conn, $row['id']);
                //         }
                //     }
                
                //     return $totalCount + $indirectCount;
                // }
                
                // // Usage
                // $sponsorId = $_SESSION['user_name']; // Assuming you have the sponsor ID in the session
                // $totalIndirectCount = countIndirectReferrals($conn, $sponsorId);


                $sql= $conn->prepare("SELECT * FROM user_registration WHERE user_name='".$_SESSION['user_name']."'");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                if($sql->rowCount()>0){
                    foreach (($sql->fetchAll()) as $key => $row) {

                        $threex_amount = $row['threex_amount'];
                        $threex_amount_limit = $row['threex_amount_limit'];

                        $limit = $threex_amount - $threex_amount_limit;

                        $packageId = $row['pkg_id'];

                        $current_bonus_status = $row['current_bonus_status'];

                        if($packageId == 0){

                            header("location: buy-pkg.php?package_type=1");

                        }
                        $threex_amount_limit_rem = $threex_amount_limit - 50;
                        if($threex_amount >= $threex_amount_limit_rem){

                            $isPackageActive = 1;
                
                         }

                        //  if($threex_amount >= $threex_amount_limit){

                        //     $isPackageActive = 2;
                        //     header("location: buy-pkg.php?package_type=1");
                
                        //  }

                         //find total level bonus
                         $levelBonus = $row['l1'] + $row['l2'] + $row['l3'] + $row['l4'] + $row['l5'] + $row['l6'] + $row['l7'] + $row['l8'] + $row['l9'] + $row['l10'];
                    }
                }
        ?>
            
    <?php        if($isPackageActive == 1){
           
           echo '<div class="alert alert-danger alert-dismissible">
           <strong>Your Package is about to expire. Please Purchase New Package to Start Using Our Service.</strong>
           </div>';
     } else  if($isPackageActive == 2){
           
        echo '<div class="alert alert-danger alert-dismissible">
        <strong>Your Package is expired. Please Purchase New Package to Start Using Our Service.</strong>
        </div>';
  }  ?>      




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


                                    <!-- <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-white">Alert!! </h6>
                                                <div class="text-white">Pending Balance of $125 from Your Pending Wallet is about to expire. Please Use it to Upgrade or Buy new Package before it Expires.</div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div> -->
            </div>
            <div class="col-md-4">
				<div class="card radius-10 overflow-hidden">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0">Current Balance</p>
								<h5 class="mb-0">$<?= number_format($userCurrentBalance,2);?></h5>
							</div>
							<div class="ms-auto">	<img src="images/icons/save-money.png" height="40">
							</div>
						</div>
					</div>
					<div class="" id="w-chart5"></div>
				</div>
			</div>
            <div class="col-md-4">
				<div class="card radius-10 overflow-hidden">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0">Referral Bonus(Pending)</p>
								<h5 class="mb-0">$<?= number_format($pendingBalance,2);?></h5>
							</div>
							<div class="ms-auto">	<img src="images/icons/save-money.png" height="40">
							</div>
						</div>
					</div>
					<div class="" id="w-chart2"></div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card radius-10 overflow-hidden">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0">Total Income</p>
								<h5 class="mb-0">$<?=number_format($totalIncome,2);?></h5>
							</div>
							<div class="ms-auto">	<img src="images/icons/wallet.png" height="40">
							</div>
						</div>
					</div>
					<div class="" id="w-chart6"></div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card radius-10 overflow-hidden">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>

                            <?php
   require 'connect.php';                          
  $data = $conn->query("SELECT sum(pkg_price) as Total1 FROM package_details WHERE user_name='".$_SESSION["user_name"]."'")->fetchAll();
               foreach ($data as $row) {  
                     
                     $total_invest = $row['Total1'];

            }
                            ?>


								<p class="mb-0">Total Invest</p>
								<h5 class="mb-0">$<?=number_format($total_invest,2)?></h5>
							</div>
							<div class="ms-auto">	<img src="images/icons/growth.png" height="40">
							</div>
						</div>
					</div>
					<div class="" id="w-chart7"></div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card radius-10 overflow-hidden">
					<div class="card-body">
						<div class="d-flex align-items-center">
							<div>
								<p class="mb-0">Active Investment</p>
								<?php
           require 'connect.php';
           $sql= $conn->prepare("SELECT * FROM user_registration WHERE user_name='".$_SESSION['user_name']."'");
           $sql->execute();
           $sql->setFetchMode(PDO::FETCH_ASSOC);
           if($sql->rowCount()>0){
            foreach (($sql->fetchAll()) as $key => $row) {
          
            $active_investment = $row['active_investment'];

}
}
?>
								<h5 class="mb-0">$<?php echo number_format($active_investment,2); ?></h5>
							</div>
							<div class="ms-auto">	<img src="images/icons/investment.png" height="40">
							</div>
						</div>
					</div>
					<div class="" id="w-chart8"></div>
				</div>
			</div>
            
            <!--second line of cards-->
             <!-- <div class="col">
                <div class="card radius-10 border-start border-0 border-3  border-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0">Direct Bonus</p>
                                <h4 class="my-1 text-danger">$<?=number_format($userDirectBonus,2)?></h4>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-danger text-white ms-auto"><i class='bx bx-money'></i>
                            </div>
                        </div>
                    </div>
                    <div class="" id="w-chart2"></div>
                </div>
            </div> -->
            <div class="col-md-4">
                <div class="card radius-10 border-start border-0 border-3 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0">Level Bonus</p>
                                <h4 class="my-1 text-primary">$<?=number_format($levelBonus,2)?></h4>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-gradient-rose-button text-white ms-auto"><i class='bx bx-money'></i>
                            </div>
                        </div>
                    </div>
                    <div class="" id="w-chart4"></div>
                </div>
            </div>
            
             <div class="col-md-4">
                <div class="card radius-10 border-start border-0 border-3 border-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>

                            	<?php
           require 'connect.php';
           $sql= $conn->prepare("SELECT * FROM user_registration WHERE user_name='".$_SESSION['user_name']."'");
           $sql->execute();
           $sql->setFetchMode(PDO::FETCH_ASSOC);
           if($sql->rowCount()>0){
            foreach (($sql->fetchAll()) as $key => $row) {
          
            $pool_bonus = $row['threex_amount'];

}
}
?>
                                <p class="mb-0">Pool Bonus</p>
                                <h4 class="my-1 text-warning">$<?php echo number_format($pool_bonus,2); ?></h4>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-warning text-white ms-auto"><i class='bx bx-money'></i>
                            </div>
                        </div>
                    </div>
                    <div class="" id="w-chart-success"></div>
                </div>
            </div>

                <div class="card radius-10 border-start border-0 border-3  border-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <?php if($current_bonus_status == 'threeex'){ ?>
                                    <p class="mb-0">Current 3x Amount: </p>
                                <?php }elseif($current_bonus_status == 'fourex'){ ?>
                                    <p class="mb-0">Current 4x Amount: </p>
                                <?php } else{ ?>
                                    <p class="mb-0">Current 2x Amount: </p>
                                <?php } ?>
                                <h4 class="my-1 text-danger">$<?=number_format($threexcamountt,2)?></h4>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-danger text-white ms-auto"><i class='bx bx-money'></i>
                            </div>
                        </div>
                    </div>
                    <div class="" id="w-chart2"></div>
                </div>

            <!-- <div class="col">
                <div class="card radius-10 border-start border-0 border-3 border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-0">Direct Sales</p>
                                <h4 class="my-1 text-success">$<?=number_format($userDirectSales,2)?></h4>
                            </div>
                            <div class="widgets-icons-2 rounded-circle bg-success text-white ms-auto"><i class='bx bx-money' ></i>
                            </div>
                        </div>
                    </div>
                    <div class="" id="w-chart-primary"></div>
                </div>
            </div>	 -->
        </div>
        <!--end row-->
    <!--    <div class="row row-cols-1 row-cols-md-3 row-cols-xl-3">-->
    <!--               <div class="col">-->
				<!--	 <div class="card radius-10 border-start border-0 border-3 border-info">-->
				<!--		<div class="card-body">-->
				<!--			<div class="d-flex align-items-center">-->
				<!--				<div>-->
				<!--					<p class="mb-0">ROI Today</p>-->
				<!--					<h4 class="my-1 text-info"><?='$'.number_format($roiToday,2)?></h4>-->
				<!--				</div>-->
				<!--				<div class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto"><i class='bx bx-money'></i>-->
				<!--				</div>-->
				<!--			</div>-->
				<!--		</div>-->
				<!--	 </div>-->
				<!--   </div>-->
				<!--   <div class="col">-->
				<!--	<div class="card radius-10 border-start border-0 border-3 border-danger">-->
				<!--	   <div class="card-body">-->
				<!--		   <div class="d-flex align-items-center">-->
				<!--			   <div>-->
				<!--				   <p class="mb-0">ROI This Month</p>-->
				<!--				   <h4 class="my-1 text-danger"><?='$'.number_format($roiDaily,2)?></h4>-->
				<!--			   </div>-->
				<!--			   <div class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto"><i class='bx bx-money'></i>-->
				<!--			   </div>-->
				<!--		   </div>-->
				<!--	   </div>-->
				<!--	</div>-->
				<!--  </div>-->
				<!--  <div class="col">-->
				<!--	<div class="card radius-10 border-start border-0 border-3 border-success">-->
				<!--	   <div class="card-body">-->
				<!--		   <div class="d-flex align-items-center">-->
				<!--			   <div>-->
				<!--				   <p class="mb-0">ROI Total</p>-->
				<!--				   <h4 class="my-1 text-success"><?='$'.number_format($userRoi,2)?></h4>-->
				<!--			   </div>-->
				<!--			   <div class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto"><i class='bx bx-money' ></i>-->
				<!--			   </div>-->
				<!--		   </div>-->
				<!--	   </div>-->
				<!--	</div>-->
				<!--  </div>-->
				
				<!--end row-->
    <!--    </div>-->
         <!--row start-->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body ">
                        <b>Announcement:</b>
                        <marquee style="font-size:18px" onmouseover="stop()" onmouseout="start()">
                            <?php
                                $quuy="select * from announcement";
                                $resulltt = mysqli_query($con,$quuy);
                                while($resuu = mysqli_fetch_assoc($resulltt))
                                {
                                    echo "<a class='text-capitalize' target='blank' href='view-announcement.php?id=".$resuu['id']."'>".$resuu['title']." &nbsp;&nbsp;&nbsp;</a>";
                                }
                            ?>
                        </marquee>
                    </div>
                </div>
            </div>
        </div>
        <!--row end-->
       
        <!--row start-->
        <div class="row">
            <div class="col-lg-6">
			    <div class="card border-primary border-bottom border-3 border-0">
							<!--<img src="assets/images/gallery/01.png"  alt="...">-->
							<h4 class="card-img-top bg-gradient-rose-button text-white text-center p-3">Withdrawals</h4>
							<div class="card-body">
								<ul class="list-group list-group-flush">
											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0">Approved</h6>
												<h6 class="mb-0">Pending</h6>
										
											</li>
											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<p class="mb-0">$<?php 
												$query="select sum(desire_amount) from withdrawal where status='Approved' and user_name='$fectchUserName'";
												$queryResult=mysqli_query($con,$query);
												$dataRes= mysqli_fetch_array($queryResult);
												if($dataRes['sum(desire_amount)'] == NULL)
												{
												    echo '0';
												}
												else
												{
												    echo $dataRes['sum(desire_amount)'];
												} 
												?></p>
												<p class="mb-0">
												    $<?php 
												$query="select sum(desire_amount) from withdrawal where status='Pending' and user_name='$fectchUserName'";
												$queryResult=mysqli_query($con,$query);
												$dataRes= mysqli_fetch_array($queryResult);
												if($dataRes['sum(desire_amount)'] == NULL)
												{
												    echo '0';
												}
												else
												{
												    echo $dataRes['sum(desire_amount)'];
												} 
												?>
												</p>
											</li>
									
											
										</ul>
							</div>
				</div>
			</div>
			<div class="col-lg-6">
			    <div class="card border-primary border-bottom border-3 border-0">
							<!--<img src="assets/images/gallery/01.png"  alt="...">-->
							<h4 class="card-img-top bg-gradient-rose-button text-white text-center p-3">Team Sales</h4>
							<div class="card-body">
								<ul class="list-group list-group-flush">
											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0">Direct Referral</h6>
												<h6 class="mb-0">Level Sales</h6>
										
											</li>
											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<p class="mb-0"><?= $totalDirectReferalCount ?></p>
												<p class="mb-0">$<?= $levelBonus ?></p>
											</li>
									
											
										</ul>
							</div>
				</div>
			</div>
			<!-- <div class="col-lg-4">
			    <div class="card border-primary border-bottom border-3 border-0">
							<h4 class="card-img-top bg-gradient-rose-button text-white text-center p-3">Group</h4>
							<div class="card-body">
								<ul class="list-group list-group-flush">
											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0">Direct Team</h6>
												<h6 class="mb-0">Total Team</h6>
											</li>
											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<p class="mb-0"><?= $userDirectTeam?></p>
												<p class="mb-0"><?=$userTotalTeam?></p>
											</li>
									
											
										</ul>
							</div>
				</div> -->
			</div>
        </div>
        <!--row end-->
     
        <!-- <div class="card radius-10">
            <div class="card-body">
                <div class="d-flex align-items-center p-3 justify-content-between">
                    <div class="">
                        <h5 class="">Login History</h5>
                    </div>
                   <span style="font-size:16px;font-weight:200" class="badge bg-gradient-rose-button text-white">Lastest 5</span>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th>IP</th>
                                <th>City</th>
                                <th>PostalCode</th>
                                <th>Region</th>
                                <th>Country</th>
                                <th>Browser</th>
                                <th>Device</th>
                                <th>O.S</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $qry="select * from login_history where user_name='$fectchUserName' ORDER BY id DESC LIMIT 5";
                            $qryResult=mysqli_query($con,$qry);
                            while($ress=mysqli_fetch_assoc($qryResult))
                            {
                            ?>
                            <tr>
                                <td><?php echo $ress['ip']?></td>
                                <td><?php echo $ress['city']?></td>
                                <td><?php echo $ress['postal_code']?></td>
                                <td><?php echo $ress['region']?></td>
                                <td><?php echo $ress['country']?></td>
                                <td><?php echo $ress['browser']?></td>
                                <td><?php echo $ress['device']?></td>
                                <td><?php echo $ress['os']?></td>
                                <td><?php echo $ress['date']?></td>
                            </tr>
                            <?php
                            }
                            ?>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div> -->
        
    </div>
</div>
<!--end page wrapper -->
<!--start overlay-->
<div class="overlay toggle-icon"></div>
<!--end overlay-->
<!--Start Back To Top Button-->
<a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
<!--End Back To Top Button-->
<footer class="page-footer">
    <p class="mb-0">Copyright © 2021. All right reserved.</p>
</footer>
</div>
<!--end wrapper-->


<?php
//ip code start

if (getenv('HTTP_CLIENT_IP')) {	$ip_address = getenv('HTTP_CLIENT_IP');}elseif (getenv('HTTP_X_FORWARDED_FOR')) {	$ip_address = getenv('HTTP_X_FORWARDED_FOR');}elseif (getenv('HTTP_X_FORWARDED')) {	$ip_address = getenv('HTTP_X_FORWARDED');}elseif (getenv('HTTP_FORWARDED_FOR')) {	$ip_address = getenv('HTTP_FORWARDED_FOR');}elseif (getenv('HTTP_FORWARDED')) {	$ip_address = getenv('HTTP_FORWARDED');}else {	$ip_address = $_SERVER['REMOTE_ADDR'];}

      $details = json_decode(file_get_contents("http://ipinfo.io/152.57.241.245/json"));
  
      $city = $details->city;
      $region = $details->region;
      $postalCode = $details->postal;
      $countryName= $details->country;
    
        
    
    
    
    if($countryName =='PK')
    {
        $countryName= 'Pakistan';
    }
    else
    {
        $countryName =  $details->country;
    }
//ip code end




$expire_link = "https://ecf9-2409-4042-4d82-4ad8-6112-cf03-1610-bc2e.ngrok-free.app/mlmgtron/mlm_landing/index.php/member/expire_flag.php?action=Expire&email=".$email;

// if(isset($_SESSION['s_email'])){
    
  
    
// $subject = "Login Successful - GTRON";
// $email_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
// <html xmlns="http://www.w3.org/1999/xhtml">
//     <head>
//         <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

//         <title>Infinte Trade Group</title>
//         <meta name="viewport" content="width=device-width">
        
//         <link rel="icon" href="" type="image/x-icon">
//       <style type="text/css">
//             @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
//                 body[yahoo] .buttonwrapper { background-color: transparent !important; }
//                 body[yahoo] .button { padding: 0 !important; }
//                 body[yahoo] .button a { background-color: #9b59b6; padding: 15px 25px !important; }
//             }

//             @media only screen and (min-device-width: 601px) {
//                 .content { width: 600px !important; }
//                 .col387 { width: 387px !important; }
//             }
//         </style>
//     </head>
//     <body bgcolor="#34495E" style="margin: 0; padding: 0;" yahoo="fix">
      
//         <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
//           <tr>
//             <td>
//         <![endif]-->
//         <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;" class="content">
//            <tr>
//                 <td align="left" bgcolor="#ffffff" style="padding: 30px 10px 00px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 36px; font-weight: bold;">
//                     <img src="'.$logo1.'" alt="logo" width="256" height="60" style="display:block; margin-bottom: 15px;">
                    
//                 </td>
//             </tr>
//             <tr>
//                 <td align="left" bgcolor="#ffffff" style="padding: 10px 20px 0px 10px; color: #0A8B4E; font-family: Arial, sans-serif; font-size: 18px; line-height: 30px; ">
//                     <b>Login Successful</b>
//                 </td>
//             </tr>
//             <tr>
//                 <td align="left" bgcolor="#ffffff" style="padding: 10px 20px 0px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 24px; ">
//                     <b>This Email is to inform you that you are logged into your account successfully. You can use and explore all the features in your account. We provide an Authorised Login system.</b>
//                 </td>
//             </tr>
//             <tr>
//             <td align="left" bgcolor="#ffffff" style="padding: 10px 20px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 30px; ">
//                     <b>Login Time:</b> '.date('l, d-M-Y', time()).'
//                 </td>
//             </tr>
//             <tr>
//             <td align="left" bgcolor="#ffffff" style="padding: 10px 20px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 10px; ">
//                     <b>IP Address :</b> '.$ip_address.'
//                 </td>
//             </tr>
//             <tr>
//             <td align="left" bgcolor="#ffffff" style="padding: 10px 20px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 10px; ">
//                     <b>City:</b> '.$details->city.'
//                 </td>
//             </tr>
//             <tr>
//             <td align="left" bgcolor="#ffffff" style="padding: 10px 20px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 10px; ">
//                     <b>Postal Code:</b> '.$details->postal.'
//                 </td>
//             </tr>
//             <tr>
//             <td align="left" bgcolor="#ffffff" style="padding: 10px 20px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 10px; ">
//                     <b>Region:</b> '.$details->region.'
//                 </td>
//             </tr>
//             <tr>
//             <td align="left" bgcolor="#ffffff" style="padding: 10px 20px 20px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 15px; line-height: 10px; ">
//                     <b>Country:</b> '.$countryName.'
//                 </td>
//             </tr>
//             <tr>
//                 <td align="left" bgcolor="#ffffff" style="padding: 0px 30px 0px 10px; color: #ED3237; font-family: Arial, sans-serif; font-size: 15px; line-height: 20px; ">
//                     <span><b>Important:</b></span>
//                 </td>
//             </tr>   
//             <tr>
//                 <td align="left" bgcolor="#ffffff" style="padding: 2px 30px 10px 10px; color: #555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 20px; ">
//                     <span><b>If it is not you, Please <a href="'.$expire_link.'">Click Here</a> to temporary block your account and change your password immediately.</b></span>
//                 </td>
//             </tr>   
//             <tr>
//                 <td align="center" bgcolor="#ff9700" style="padding: 15px 10px 15px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 12px; line-height: 18px; ">
//                     <b>GTRON.com - All Rights Reserved</b>
//                 </td>
//             </tr>
//         </table>
        
//                 </td>
//             </tr>
//         </table>
//         <![endif]-->
//     </body>
// </html>';

// $param = array(
//     'subject' => $subject ,
//     'email_template' => $email_template ,
//     'receiver_email' => $email ,
//     'receiver_name' => $full_name 
//  );


// 	if(send_email($param)){
	    
// 	      $qyyy="INSERT INTO `login_history` (`user_name`,`ip`, `city`, `postal_code`, `region`, `country`, `browser`, `device`, `os`) 
//         VALUES ('$user_name','$ip_address','$city','$postalCode','$region','$countryName','$browser','$deviceName','$operatingSystem')";
//         $resultt=mysqli_query($con,$qyyy);
	    
// 		unset($_SESSION['s_email']);
// 	};
// }

?> 

<?php include 'footer.php'?>
