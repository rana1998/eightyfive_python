<?php

//get pool bonous
$conn2 = mysqli_connect("localhost","root","","arialkhk_python")or die("could not connect to mysqli");

$totalEligibleShares = 0;

//Get Sum of eligible_shares as total_eligible_shares from user_registration with a condition that the "threex_amount" column is greater than or equal to the "threex_amount_limit" column.
$query = "SELECT SUM(eligible_shares) AS total_eligible_shares 
          FROM user_registration 
          WHERE threex_amount >= threex_amount_limit";

$result = mysqli_query($conn2, $query);

//Checking if result is empty or not
if ($result) {
  $row = mysqli_fetch_assoc($result);
  $totalEligibleShares = $row['total_eligible_shares'];
}
// else To do


//Getting all columns from user_pool_amount Where and storing last stored value using loops
  $getpooldetails = "SELECT * FROM `user_pool_amount` WHERE 1";
    $by = mysqli_query($conn2,$getpooldetails);
    while($row = mysqli_fetch_array($by))
    { 
             $total_pool_amount = $row['total_pool_amount'];
             $total_sale_amount = $row['total_sale_amount'];
             $old_share = $row['old_share'];
             $todays_share = $row['todays_share'];
    }
  // else To do
 
    //If total_pool_amount > 0
    if($total_pool_amount > 0){
     echo "Pool Bonus Distributed Successfully!";echo "</br>";
   $total_share =  ($total_sale_amount/50); echo "</br>";

   //initial value
   if($old_share == 0){
       //first day value when old_shae is 0
       //share amount to distribute users
     echo  $share_amount =  ($total_pool_amount/$total_share);
       $updatePool = "UPDATE `user_pool_amount` SET `old_share`='$total_share', `todays_share`='0' WHERE 1";
       $by = mysqli_query($conn2,$updatePool);
       
   }else{
       
       if($totalEligibleShares > 0){
           //3x reached share removed to give them others from pools because we are including pools bonus for all including (3x reached)
           $finalShare = ($old_share + $todays_share) - $totalEligibleShares;
           
       }else{
           //if no one reached 3x thann final share
           $finalShare = $old_share + $todays_share;
           
       }
       
       
       echo  $share_amount =  ($total_pool_amount/$finalShare);
       $updatePool = "UPDATE `user_pool_amount` SET `old_share`='$finalShare', `todays_share`='0' WHERE 1";
       $by = mysqli_query($conn2,$updatePool);
       
       
   }
   

    }else{
      echo "No Pool Amount!";
      $total_share = 0;
      $share_amount = 0;
    }
    

    $findadminwallet = "SELECT * FROM `admin_wallet` WHERE 1";
    $adminwallet = mysqli_query($conn2,$findadminwallet);
    while($row = mysqli_fetch_array($adminwallet))
    {
        $wallet_amount = $row['wallet_amount'];
    }

    $walletAmount = $wallet_amount;

    //Find all users whose threex amount is not greater than threex amount limit
    $q = "SELECT * FROM `user_registration` WHERE 1";
    $b = mysqli_query($conn2,$q);
    while($row = mysqli_fetch_array($b))
    {        
		$pkg_id = $row['pkg_id'];
		$threex_amount_limit = $row['threex_amount_limit'];
		$threex_amount = $row['threex_amount'];
		$user_share = $row['eligible_shares'];
		$userid = $row['id'];
		$user_name = $row['user_name'];
		$active_investment = $row['active_investment'];


		$package_purchase_count = $row['package_purchase_count'];


		//To check user's jonining date
		$user_joining_date = $row['date'];
		$old_gtron_wallet =  $row['gtron_wallet'];

		$remainingAmount = $threex_amount_limit - $threex_amount;
		$userCount = 0;

		//check activeinvestment * 4 
		// remaining amout for 4ex = fouresamount - $threex_amount_limit
		//Get fourex amount by multiply  4 into active_investment
		$fourexAmount = $active_investment * 4;
		$remainingFourexAmount = $fourexAmount - $threex_amount_limit;

		$findtwox = $threex_amount_limit - $active_investment;
		$remainingtwoxAmount = $findtwox - $threex_amount;

		//linked user reffer count (user's refferred count)
		$query = "SELECT COUNT(*) AS user_count FROM user_registration WHERE sponsor_name = '$user_name'";
		$result = mysqli_query($conn2, $query);

		if ($result) {
		$row = mysqli_fetch_assoc($result);
		$userCount = $row['user_count'];
		} else {

        }

		//CHECK DIRECT 4 USER REFFERER WITHIN 7 DAYS REGISTRATION OF USER  4EX AMOUNT USER
		//3EXAMOUNT WALLET BONUS HALF AND HALF PART GTRON EWALLET FROM LINE 131 

		// Case : DIRECT 4 USER REFFERER WITHIN 7 DAYS REGISTRATION OF USER  4EX AMOUNT USER
		$registrationDate = $user_joining_date; 
		$registrationDateTime = new DateTime($registrationDate);
		$currentDateTime = new DateTime();
		$interval = $registrationDateTime->diff($currentDateTime);
		$daysDifference = $interval->days;
		if($userCount >= 4 && $daysDifference <= 7) {
				// The registration date is within the last seven days
				///To assign fourex amount to user which directed refferals 4 and more than 4 within 7 days of registartion 
				$user_bonus = ($share_amount * $user_share);
				//$remainingAmount NEEDS TO BE Updated according to fourex amount
				if ($user_bonus > $remainingFourexAmount) {
					$remaining_amount = $user_bonus - $remainingFourexAmount;
					//Half share stored in wallet and half gtron 
					$shareHeGot = ($user_bonus - $remaining_amount)/2;
					$userFinalll = $threex_amount + $shareHeGot;
					$newGtronWallet = $old_gtron_wallet  + $shareHeGot;
					//To do wallet_summery new field gtron_wallet use $shareHeGot
					$updateUser = "UPDATE `user_registration` SET `threex_amount`='$userFinalll', `gtron_wallet` = '$newGtronWallet', `current_bonus_status` = 'fourex' WHERE id='$userid'";
					$by = mysqli_query($conn2, $updateUser);
					$date = date('Y-m-d');
					$updateInsert = "INSERT INTO `wallet_summary`(`id`, `user_name`, `amount`, `description`, `wallet_type`, `type`, `date`, `gtron_wallet`, `credit_type`) VALUES ('', '$user_name', '$shareHeGot', 'Pool Bonus', 'Cash Wallet', 'Credit', '$date', '$shareHeGot', 'level_bonus')";
					mysqli_query($conn2, $updateInsert);
					$finalAdminwalletAmount = $walletAmount + $remaining_amount;
					$walletAmount = $finalAdminwalletAmount;
					$updateAdmin = "UPDATE `admin_wallet` SET `wallet_amount`='$finalAdminwalletAmount' WHERE 1";
					$by = mysqli_query($conn2, $updateAdmin);
				}
				else {			
					$user_bonus = ($share_amount * $user_share)/2;
					$finalFourexamount = $threex_amount + $user_bonus;
					$newGtronWallet = $old_gtron_wallet  + $user_bonus;
					$updateUser = "UPDATE `user_registration` SET `threex_amount`='$finalFourexamount', `gtron_wallet` = '$newGtronWallet', `current_bonus_status` = 'fourex' WHERE id='$userid'";
					$by = mysqli_query($conn2, $updateUser);
					//to do wallet summry add gtron_wallet but insert user_bonus
					$date = date('Y-m-d');
					$updateInsert = "INSERT INTO `wallet_summary`(`id`, `user_name`, `amount`, `description`, `wallet_type`, `type`, `date`, `gtron_wallet`, `credit_type`) VALUES ('', '$user_name', '$user_bonus', 'Pool Bonus', 'Cash Wallet', 'Credit', '$date', '$user_bonus', 'level_bonus')";
					mysqli_query($conn2, $updateInsert);
				}
		} 
		else {
			if($pkg_id != 0){
				if($threex_amount >= $threex_amount_limit){
						//do nothing eat five star
				}else{

					//kuch meeta ho jaye
					// if($total_share > 0){

					//   t = 250
					//   4 = 100

					//   //check here how much user is in need, rest put in admin wallet
					//   if($threex_amount)

					//   $user_bonus = $share_amount * $user_share;
					//   if($total_share >= $user_share){

					//       $total_share = $total_share - $user_share;
					//       $finalthreexamount = $threex_amount + $user_bonus;
					//       $updateUser = "UPDATE `user_registration` SET `threex_amount`='$finalthreexamount' WHERE id='$userid'";
					//       $by = mysqli_query($conn2,$updateUser);
					//       $date = date('Y-m-d');
					//       $updateInsert = "INSERT INTO `wallet_summary`(`id`, `user_name`, `amount`, `description`, `wallet_type`, `type`, `date`) VALUES ('','$user_name','$user_bonus','Pool Bonus','Cash Wallet','Credit','$date')";
					//       mysqli_query($conn2, $updateInsert);
						
					//   }

					// }
					if ($total_share > 0) {
						// Case 1: User's final 3x amount should be 300
						if($package_purchase_count > 1){
							//if more than 32 packages no  bonus distributon
						}else{
							if($userCount > 0){
								//user's directe reffer more than 1
								//3x amount distrubuted
								$user_bonus = ($share_amount * $user_share);
								if ($user_bonus > $remainingAmount) {
									$remaining_amount = $user_bonus - $remainingAmount;
									$shareHeGot = ($user_bonus - $remaining_amount)/2;
									$userFinalll = $threex_amount + $shareHeGot;
									$newGtronWallet = $old_gtron_wallet  + $shareHeGot;
									$updateUser = "UPDATE `user_registration` SET `threex_amount`='$userFinalll', `gtron_wallet` = '$newGtronWallet',`current_bonus_status` = 'threeex' WHERE id='$userid'";
									$by = mysqli_query($conn2, $updateUser);
									$date = date('Y-m-d');
									$updateInsert = "INSERT INTO `wallet_summary`(`id`, `user_name`, `amount`, `description`, `wallet_type`, `type`, `date`, `gtron_wallet`, `credit_type`) VALUES ('', '$user_name', '$shareHeGot', 'Pool Bonus', 'Cash Wallet', 'Credit', '$date', '$shareHeGot', 'level_bonus')";
									mysqli_query($conn2, $updateInsert);
									$finalAdminwalletAmount = $walletAmount + $remaining_amount;
									$walletAmount = $finalAdminwalletAmount;
									$updateAdmin = "UPDATE `admin_wallet` SET `wallet_amount`='$finalAdminwalletAmount' WHERE 1";
									$by = mysqli_query($conn2, $updateAdmin);
									// $total_share = $total_share - $user_share;
								}else {
									$user_bonus = ($share_amount * $user_share)/2;
									$finalthreexamount = $threex_amount + $user_bonus;
									$newGtronWallet = $old_gtron_wallet  + $user_bonus;

									$updateUser = "UPDATE `user_registration` SET `threex_amount`='$finalthreexamount', `gtron_wallet` = '$newGtronWallet',`current_bonus_status` = 'threeex' WHERE id='$userid'";
									$by = mysqli_query($conn2, $updateUser);
									//to do wallet summry add gtron_wallet but insert user_bonus
									$date = date('Y-m-d');
									$updateInsert = "INSERT INTO `wallet_summary`(`id`, `user_name`, `amount`, `description`, `wallet_type`, `type`, `date`, `gtron_wallet`,`credit_type`) VALUES ('', '$user_name', '$user_bonus', 'Pool Bonus', 'Cash Wallet', 'Credit', '$date', '$user_bonus', 'level_bonus')";
									mysqli_query($conn2, $updateInsert);
									// $total_share = $total_share - $user_share;
								}
							}else{
								//2x amount distrubuted not refferd
								$user_bonus = ($share_amount * $user_share);
								if ($user_bonus > $remainingtwoxAmount) {
									$remaining_amount = $user_bonus - $remainingtwoxAmount;
									$shareHeGot = ($user_bonus - $remaining_amount)/2;
									$userFinalll = $threex_amount + $shareHeGot;
									$newGtronWallet = $old_gtron_wallet  + $shareHeGot;

									$updateUser = "UPDATE `user_registration` SET `threex_amount`='$userFinalll' , `gtron_wallet` = '$newGtronWallet', `current_bonus_status` = 'twoex' WHERE id='$userid'";
									$by = mysqli_query($conn2, $updateUser);
									$date = date('Y-m-d');
									$updateInsert = "INSERT INTO `wallet_summary`(`id`, `user_name`, `amount`, `description`, `wallet_type`, `type`, `date`, `gtron_wallet`, `credit_type`) VALUES ('', '$user_name', '$shareHeGot', 'Pool Bonus', 'Cash Wallet', 'Credit', '$date', '$shareHeGot', 'level_bonus')";
									mysqli_query($conn2, $updateInsert);
									$finalAdminwalletAmount = $walletAmount + $remaining_amount;

									$walletAmount = $finalAdminwalletAmount;

									$updateAdmin = "UPDATE `admin_wallet` SET `wallet_amount`='$finalAdminwalletAmount' WHERE 1";
									$by = mysqli_query($conn2, $updateAdmin);
									// $total_share = $total_share - $user_share;
								}else {
									$user_bonus = ($share_amount * $user_share)/2;
									$finalthreexamount = $threex_amount + $user_bonus;
									$newGtronWallet = $old_gtron_wallet  + $user_bonus;

									$updateUser = "UPDATE `user_registration` SET `threex_amount`='$finalthreexamount', `gtron_wallet` = '$newGtronWallet' ,`current_bonus_status` = 'twoex' WHERE id='$userid'";
									$by = mysqli_query($conn2, $updateUser);

									//to do wallet summry add gtron_wallet but insert user_bonus
									$date = date('Y-m-d');
									$updateInsert = "INSERT INTO `wallet_summary`(`id`, `user_name`, `amount`, `description`, `wallet_type`, `type`, `date`, `gtron_wallet`, `credit_type`) VALUES ('', '$user_name', '$user_bonus', 'Pool Bonus', 'Cash Wallet', 'Credit', '$date', '$user_bonus', 'level_bonus')";
									mysqli_query($conn2, $updateInsert);
									// $total_share = $total_share - $user_share;
								}
							}
						}
					}

				}

			}

		}

    }

    $updatePoolBonus = "UPDATE `user_pool_amount` SET `total_pool_amount`='0', `total_sale_amount`='0' WHERE 1";
    $by = mysqli_query($conn2,$updatePoolBonus);

?>
