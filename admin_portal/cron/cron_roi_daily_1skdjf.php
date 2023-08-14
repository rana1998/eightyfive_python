<?php 

// This File Deliver ROI and Place it into Cash Wallet column in database on monthly basis //


ini_set('max_execution_time', 0);

//  ROI Cron Job File.
include '../db_config.php';


    $qy="select * from `roi_percentage` where id='1'";
    $result = mysqli_query($con,$qy);
    $res=mysqli_fetch_assoc($result);
    $roi_percentage= $res['roi_percentage'];
 

 
   
// -------------------Getting Package Details----------------------- //
 	$sql = "SELECT * FROM package_details WHERE `roi_status` = 'Active' AND `status` ='Approved'";
	$stmt1 = $con->prepare($sql); 
	$stmt1->execute();
	$result = $stmt1->get_result(); // get the mysqli result
		if($result->num_rows > 0){
		while ($cuser_pkg_data = $result->fetch_assoc()) {

			$package_details_id = $cuser_pkg_data['id'];
			$user_name = $cuser_pkg_data['user_name'];
			$pkg_price = $cuser_pkg_data['pkg_price'];
			
            
            $qy="select * from user_registration where user_name='$user_name'";
            $resullt = mysqli_query($con,$qy);
            $ress = mysqli_fetch_assoc($resullt);
            
            $totalIncome = $ress['total_income'];
            $maxIncome = $ress['max_income'];
            $userStatus = $ress['status']; 
            
            
			// Calculate Date Diff
			
			
			$roi_bonus1 = ($pkg_price * $roi_percentage)/100;
			$perDayRoi = $roi_bonus1;
			
			$roi_bonus2 = $perDayRoi + $totalIncome;
			
            if($roi_bonus2 <= $maxIncome )
            {
                $roi_bonus = $perDayRoi;
            }
            elseif($roi_bonus2 > $maxIncome)
            {
                $roi_bonus = $maxIncome - $totalIncome;
            }
			
			
			
	        echo "User Name: $user_name **** Package Price: $pkg_price **** Roi Bonus: $roi_bonus **** Total Income: $totalIncome **** Max Income: $maxIncome **** Per Day: $perDayRoi<br>";
			 
		
			if($userStatus == 'Approved'){

				// ---------Update User ROI--------- //
				$sql = "UPDATE user_registration SET  current_balance = current_balance + ? , total_income = total_income + ?, roi = roi + ?, roi_daily = roi_daily + ? , roi_today = ? ,temp_roi = temp_roi + ?, roi_monthly = roi_monthly + ? WHERE user_name = ?"; // SQL with parameters
				$stmt = $con->prepare($sql); 
				$stmt->bind_param("ddddddds", $roi_bonus,$roi_bonus, $roi_bonus, $roi_bonus, $roi_bonus, $roi_bonus,$roi_bonus, $user_name);
				$stmt->execute();
				$stmt->close();

				// ---------Update No Of ROI--------- //
				$sql = "UPDATE package_details SET no_of_roi = no_of_roi + 1 , received_roi = received_roi + ? WHERE id = ?"; // SQL with parameters
				$stmt = $con->prepare($sql); 
				$stmt->bind_param("di",$roi_bonus,$package_details_id);
				$stmt->execute();
				$stmt->close();

				// ---------Insert into ROI Summary--------- //
		        $sql = "INSERT INTO roi (user_name, amount, percentage) VALUES (?,?,?)";
		        $stmt = $con->prepare($sql); 
		        $stmt->bind_param("sdd", $user_name, $roi_bonus,$roi_percentage);
		        $stmt->execute();
		        $stmt->close();

			
				
                }
				        
// 		} // End of Outer While Loop
	}
		$stmt1->close();
	

// cron Log
$sql = "INSERT INTO cron_log (filename) VALUES('cron_roi_daily.php')";
$stmt = $con->prepare($sql); 
if ($stmt->execute() === FALSE) {
    $_SESSION['errorMsg'] =  __LINE__ ." Error inserting cron log: " . $con->error;
    $stmt->close();
    exit();
}else{
    echo "Added To Cron Log";
}

// -------------------End of File------------------------ //

}
 ?>