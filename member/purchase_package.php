<?php 
ob_start();
session_start(); 
require './core/connect-two.php';
// $conn2 = mysqli_connect("localhost","root","","arialkhk_python")or die("could not connect to mysqli");

// Retrieve the Ethereum address from the request
$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);

if (isset($data['id'])) {

    //Get Package Details Here
   $packageid = $data['id'];
   $txnid = $data['txnid'];


    // $packageid = 3;
   // $txnid = 'ds5';
   // $packageid = 1;

    $packageDetails = "SELECT * FROM `package` WHERE  `id`='$packageid'";
    $by = mysqli_query($conn2,$packageDetails);
    while($row = mysqli_fetch_array($by))
    { 
        
        $originalValue = $row['pkg_price'];
        $package_amount = $row['pkg_price'];
        $packageName = $row['package_name'];


    }


    //update active investment
    //update total invest
    //Create Transaction
    $user_name = $_SESSION['user_name'];
    $q = "SELECT * FROM `user_registration` WHERE `user_name`='$user_name'";
    $b = mysqli_query($conn2,$q);
    while($row = mysqli_fetch_array($b))
    { 
             $current_balance = $row['current_balance'];
             $active_investment = $row['active_investment'];
             $threex_amount_limit = $row['threex_amount_limit'];
             $sponsor_name = $row['sponsor_name'];
             $totalinvest = $row['total_invest'];

    }

    //Add This amount into pool
    $getpooldetails = "SELECT `id`, `total_pool_amount`, `total_sale_amount` FROM `user_pool_amount` WHERE 1";
    $by = mysqli_query($conn2,$getpooldetails);
    while($row = mysqli_fetch_array($by))
    { 
             $total_pool_amount = $row['total_pool_amount'];
             $total_sale_amount = $row['total_sale_amount'];
    }

    $percentageToRemove = 20;
    // Calculate the amount to remove
    $amountToRemove = ($percentageToRemove / 100) * $originalValue;
    // Subtract the amount to remove from the original value
    //$result = $originalValue - $amountToRemove;

    $finalpoolamount = $total_pool_amount + $amountToRemove;
    $total_pool_purchase_amount = $total_sale_amount + $originalValue;

    //update pool amount here
    $updatePool = "UPDATE `user_pool_amount` SET `total_pool_amount`='$finalpoolamount',`total_sale_amount`='$total_pool_purchase_amount' WHERE 1";
    $by = mysqli_query($conn2,$updatePool);

    $dateHere = date('Y-m-d');
    $three_x = ($originalValue * 3);
    $eligibleShares = ($package_amount/50);

    $total_invest = $totalinvest + $package_amount;
    $updateUser = "UPDATE `user_registration` SET `pkg_id`='$packageid',`active_investment`='$originalValue', `threex_amount_limit`='$three_x', `threex_amount`='0', `eligible_shares`='$eligibleShares', `total_invest` = '$total_invest', `order_date`='$dateHere' WHERE `user_name`='$user_name'";
    $by = mysqli_query($conn2,$updateUser);

    $user_name = $_SESSION['user_name'];
    $pdate = date('Y-m-d H:i:s');
    $insertTransaction = "INSERT INTO `package_details`(`id`, `user_name`, `sponsor_name`, `pkg_id`, `pkg_name`, `pkg_price`, `tax`, `amount_after_tax`, `mode`, `type`, `bank`, `image`, `days`, `trans_id`, `status`, `roi_status`, `received_roi`, `no_of_roi`, `reason`, `approved_by`, `date`) 
    VALUES ('','$user_name','','$packageid','$packageName','$package_amount','','','','','','','','$txnid','Approved','Active','','','','','$pdate')";
    mysqli_query($conn2, $insertTransaction);

    $insertId = mysqli_insert_id($conn2);

    if ($sponsor_name !== "" && $sponsor_name !== null) {

        //Get Sponsor Id from here
        $conn2 = mysqli_connect("localhost","arialkhk_python","gtron@12g","arialkhk_python")or die("could not connect to mysqli");
        $userQuery = "SELECT * FROM user_registration WHERE user_name='$user_name'";
        $userResult = mysqli_query($conn2, $userQuery);
        $user = mysqli_fetch_assoc($userResult);

        

        // Assuming you retrieve the sponsor's referral ID in a variable called $sponsor_referral_id
        $sponsor_name = $user['sponsor_name'];
        $level = 1;
        $directs_needed = 2;

        // Function to get the level percentage based on the level
        function getLevelPercentage($level)
        {
            // Define the level percentages as per the provided table
            $levelPercentages = [
                1 => 50,
                2 => 8,
                3 => 6,
                4 => 4,
                5 => 3,
                6 => 1,
                7 => 1,
                8 => 1,
                9 => 0.5,
                10 => 0.5,
            ];

            return $levelPercentages[$level];
        }

        // Function to get the count of directs for a sponsor
        function getDirectsCount($conn, $sponsor_referral_id)
        {
            $directsQuery = "SELECT COUNT(*) FROM user_registration WHERE sponsor_name = '$sponsor_referral_id'";
            $directsResult = mysqli_query($conn, $directsQuery);
            $directsCount = mysqli_fetch_row($directsResult)[0];

            return $directsCount;
        }
        // Loop through each level until level 10
        while ($level <= 10) {
            // Check if the level is Level 1
            if ($level === 1) {

                
                $sponseruserQuery = "SELECT * FROM user_registration WHERE user_name='$sponsor_name'";
                $sponseruserResult = mysqli_query($conn2, $sponseruserQuery);
                $sponseruser = mysqli_fetch_assoc($sponseruserResult);
                // Update the sponsor's total_income field with 50% of the package amount

                $level_amount = $package_amount * 0.5;
                $new_total_income = $sponseruser['total_income'] + ($package_amount * 0.5);
                $new_wallet_balance = $sponseruser['current_balance'] + ($package_amount * 0.5);
                $level_1_income = $sponseruser['l1'] + ($package_amount * 0.5);
                $level_bonus = ($package_amount * 0.5);

                $threeamtlimit = $sponseruser['threex_amount_limit'];
                $threexamount = $sponseruser['threex_amount'];
                
                
                // $updateQuery = "UPDATE user_registration SET current_balance = '$new_wallet_balance', total_income = '$new_total_income', l1 = $level_1_income  WHERE user_name = '$sponsor_name'";
                // mysqli_query($conn2, $updateQuery);

                if($threeamtlimit >= $threexamount){
                    echo $new_wallet_balance;
                    $remainingbalance = $threeamtlimit - $threexamount;
                    if($remainingbalance > $level_amount){
                        echo $sponsor_name;
                        $threexxamount = $level_amount + $sponseruser['threex_amount'];
                        $finalPending = $sponseruser['pending_amount'] + $threexxamount;
                        $updateQuery = "UPDATE user_registration SET current_balance = '$new_wallet_balance', total_income = '$new_total_income', threex_amount = '$threexxamount', pending_amount= '$finalPending', l1 = '$level_1_income'  WHERE user_name = '$sponsor_name'";
                        mysqli_query($conn2, $updateQuery);

                            $currentDate = date('Y-m-d H:i:s');
                            $newDate = date('Y-m-d H:i:s', strtotime($currentDate . ' + 7 days'));

                            $insertDb = "INSERT INTO `pending_pacakge_amount`(`id`, `userid`, `amount`, `orderid`, `expires_at`, `is_expired`) 
                            VALUES ('','$sponsor_name','$threexxamount','$insertId','$newDate','0')";
                            mysqli_query($conn2, $insertDb);

                    }else{

                        echo "I am here 1";

                            $getBalanceAddedToWallet = $remainingbalance;
                            $threexxamount = $remainingbalance + $sponseruser['threex_amount'];
                            $getBalanceAddedToPending = $level_amount - $remainingbalance;
                            $finalPending = $sponseruser['pending_amount'] + $getBalanceAddedToPending;
                            $new_wallet_balance_two = $sponseruser['current_balance'] + $getBalanceAddedToWallet;
                            $new_total_income_two = $sponseruser['total_income'] + $getBalanceAddedToWallet;
                            $updateQuery = "UPDATE user_registration SET current_balance = '$new_wallet_balance_two', pending_amount = '$finalPending', total_income = '$new_total_income_two', threex_amount = '$threexxamount', l1 = '$level_1_income'  WHERE user_name = '$sponsor_name'";
                            mysqli_query($conn2, $updateQuery);
echo $updateQuery;
                            $currentDate = date('Y-m-d H:i:s');
                            $newDate = date('Y-m-d H:i:s', strtotime($currentDate . ' + 7 days'));

                            $insertDb = "INSERT INTO `pending_pacakge_amount`(`id`, `userid`, `amount`, `orderid`, `expires_at`, `is_expired`) 
                            VALUES ('','$sponsor_name','$getBalanceAddedToPending','$insertId','$newDate','0')";
                            mysqli_query($conn2, $insertDb);


                    }

                }else{
 echo "I am here 4";
                    $remainingbalance = $threeamtlimit - $threexamount;
                    if($remainingbalance > $level_amount){
                        echo "3";
                        $threexxamount = $level_amount + $sponseruser['threex_amount'];
                        $finalPending = $sponseruser['pending_amount'] + $threexxamount;
                        $updateQuery = "UPDATE user_registration SET current_balance = '$new_wallet_balance', total_income = '$new_total_income', threex_amount = '$threexxamount', pending_amount='$finalPending', l1 = $level_1_income  WHERE user_name = '$sponsor_name'";
                        mysqli_query($conn2, $updateQuery);

                            $currentDate = date('Y-m-d H:i:s');
                            $newDate = date('Y-m-d H:i:s', strtotime($currentDate . ' + 7 days'));

                            $insertDb = "INSERT INTO `pending_pacakge_amount`(`id`, `userid`, `amount`, `orderid`, `expires_at`, `is_expired`) 
                            VALUES ('','$sponsor_name','$threexxamount','$insertId','$newDate','0')";
                            mysqli_query($conn2, $insertDb);

                    }else{
                        echo "4";
                            $getBalanceAddedToWallet = $remainingbalance;
                            $threexxamount = $remainingbalance + $sponseruser['threex_amount'];
                            $getBalanceAddedToPending = $level_amount - $remainingbalance;
                            $finalPending = $sponseruser['pending_amount'] + $getBalanceAddedToPending;
                            $new_wallet_balance_two = $sponseruser['current_balance'] + $getBalanceAddedToWallet;
                            $new_total_income_two = $sponseruser['total_income'] + $getBalanceAddedToWallet;
                            $updateQuery = "UPDATE user_registration SET current_balance = '$new_wallet_balance_two', pending_amount = '$finalPending', total_income = '$new_total_income_two', threex_amount = '$threexxamount', l1 = $level_1_income  WHERE user_name = '$sponsor_name'";
                            mysqli_query($conn2, $updateQuery);

                            $currentDate = date('Y-m-d H:i:s');
                            $newDate = date('Y-m-d H:i:s', strtotime($currentDate . ' + 7 days'));

                            $insertDb = "INSERT INTO `pending_pacakge_amount`(`id`, `userid`, `amount`, `orderid`, `expires_at`, `is_expired`) 
                            VALUES ('','$sponsor_name','$getBalanceAddedToPending','$insertId','$newDate','0')";
                            mysqli_query($conn2, $insertDb);


                    }

                    

                }

                $date = date('Y-m-d');

                $updateInsert = "INSERT INTO `wallet_summary`(`id`, `user_name`, `amount`, `description`, `wallet_type`, `type`, `date`) VALUES ('','$sponsor_name','$level_bonus','Level 1 Bonus','Cash Wallet','Credit','$date')";
                mysqli_query($conn2, $updateInsert);


                $updateLevelBonus = "INSERT INTO `bonuses_details`(`id`, `sender`, `receiver`, `bonus_amount`, `level`, `date`) VALUES ('','Level 1 Bonus','$sponsor_name','$level_bonus','1','$date')";
                mysqli_query($conn2, $updateLevelBonus);

                if ($sponseruser['sponsor_name'] !== "" && $sponseruser['sponsor_name'] !== null) {

                    $sponsor_name =  $sponseruser['sponsor_name'];

                }else{

                    break;

                }

            } else {


                $sponseruserQuery = "SELECT * FROM user_registration WHERE user_name='$sponsor_name'";
                $sponseruserResult = mysqli_query($conn2, $sponseruserQuery);
                $sponseruser = mysqli_fetch_assoc($sponseruserResult);
                // Check if the sponsor meets the criteria for the current level
                $directs_count = getDirectsCount($conn2, $sponsor_name);

                echo 'Direct counts '.$directs_count;
                if ($directs_count >= 2) {

                    // Calculate the amount to distribute for the current level
                    $level_percentage = getLevelPercentage($level);
                    $level_amount = ($package_amount * $level_percentage) / 100;

                    if($level == 2){

                        $le = 'l2';
                        $name = 'Level 2 Bonus';

                    }else if($level == 3){

                        $le = 'l3';
                        $name = 'Level 3 Bonus';

                    }else if($level == 4){

                        $le = 'l4';
                        $name = 'Level 4 Bonus';

                    }else if($level == 5){
                        $le = 'l5';
                        $name = 'Level 5 Bonus';

                    }else if($level == 6){

                        $le = 'l6';
                        $name = 'Level 6 Bonus';
                    }else if($level == 7){

                        $le = 'l7';
                        $name = 'Level 7 Bonus';
                    }else if($level == 8){

                        $le = 'l8';
                        $name = 'Level 8 Bonus';
                    }else if($level == 9){
                        $le = 'l9';
                        $name = 'Level 9 Bonus';

                    }else if($level == 10){

                        $le = 'l10';
                        $name = 'Level 10 Bonus';
                    }

                    // Update the sponsor's total_income field
                    $new_total_income = $sponseruser['total_income'] + $level_amount;
                    $new_wallet_balance = $sponseruser['current_balance'] + $level_amount;
                    $level_1_income = $sponseruser[$le] +  $level_amount;
                    
                    
                    // $updateQuery = "UPDATE user_registration SET current_balance = '$new_wallet_balance', total_income = '$new_total_income', $le = $level_1_income WHERE user_name = '$sponsor_name'";
                    // mysqli_query($conn2, $updateQuery);

                    if($threeamtlimit > $threexamount){

                        $remainingbalance = $threeamtlimit - $threexamount;
                        if($remainingbalance > $level_amount){
    
                            $threexxamount = $level_amount + $sponseruser['threex_amount'];
                            $finalPending = $sponseruser['pending_amount'] + $threexxamount;
                            $updateQuery = "UPDATE user_registration SET current_balance = '$new_wallet_balance', total_income = '$new_total_income', threex_amount = '$threexxamount', pending_amount='$finalPending', l1 = $level_1_income  WHERE user_name = '$sponsor_name'";
                            mysqli_query($conn2, $updateQuery);

                            $currentDate = date('Y-m-d H:i:s');
                            $newDate = date('Y-m-d H:i:s', strtotime($currentDate . ' + 7 days'));

                            $insertDb = "INSERT INTO `pending_pacakge_amount`(`id`, `userid`, `amount`, `orderid`, `expires_at`, `is_expired`) 
                            VALUES ('','$sponsor_name','$threexxamount','$insertId','$newDate','0')";
                            mysqli_query($conn2, $insertDb);
    
                        }else{
    
                            $getBalanceAddedToWallet = $remainingbalance;
                            $threexxamount = $remainingbalance + $sponseruser['threex_amount'];
                            $getBalanceAddedToPending = $level_amount - $remainingbalance;

                            $finalPending = $sponseruser['pending_amount'] + $getBalanceAddedToPending;
                            $new_wallet_balance_two = $sponseruser['current_balance'] + $getBalanceAddedToWallet;
                            $new_total_income_two = $sponseruser['total_income'] + $getBalanceAddedToWallet;
                            $updateQuery = "UPDATE user_registration SET current_balance = '$new_wallet_balance_two', pending_amount = '$finalPending', total_income = '$new_total_income_two', threex_amount = '$threexxamount', l1 = $level_1_income  WHERE user_name = '$sponsor_name'";
                            mysqli_query($conn2, $updateQuery);

                            $currentDate = date('Y-m-d H:i:s');
                            $newDate = date('Y-m-d H:i:s', strtotime($currentDate . ' + 7 days'));

                            $insertDb = "INSERT INTO `pending_pacakge_amount`(`id`, `userid`, `amount`, `orderid`, `expires_at`, `is_expired`) 
                            VALUES ('','$sponsor_name','$getBalanceAddedToPending','$insertId','$newDate','0')";
                            mysqli_query($conn2, $insertDb);
    
    
                        }
    
                    }else{
    
                        $remainingbalance = $threeamtlimit - $threexamount;
                        if($remainingbalance > $level_amount){


    
                            $threexxamount = $level_amount + $sponseruser['threex_amount'];
                            $finalPending = $sponseruser['pending_amount'] + $threexxamount;
                            $updateQuery = "UPDATE user_registration SET current_balance = '$new_wallet_balance', total_income = '$new_total_income', threex_amount = '$threexxamount', pending_amount='$finalPending', l1 = $level_1_income  WHERE user_name = '$sponsor_name'";
                            mysqli_query($conn2, $updateQuery);

                            $currentDate = date('Y-m-d H:i:s');
                            $newDate = date('Y-m-d H:i:s', strtotime($currentDate . ' + 7 days'));

                            

                            $insertDb = "INSERT INTO `pending_pacakge_amount`(`id`, `userid`, `amount`, `orderid`, `expires_at`, `is_expired`) 
                            VALUES ('','$sponsor_name','$threexxamount','$insertId','$newDate','0')";
                            mysqli_query($conn2, $insertDb);
    
                        }else{
                           
                            $getBalanceAddedToWallet = $remainingbalance;
                            $threexxamount = $remainingbalance + $sponseruser['threex_amount'];
                            $getBalanceAddedToPending = $level_amount - $remainingbalance;
                            $finalPending = $sponseruser['pending_amount'] + $getBalanceAddedToPending;
                            $new_wallet_balance_two = $sponseruser['current_balance'] + $getBalanceAddedToWallet;
                            $new_total_income_two = $sponseruser['total_income'] + $getBalanceAddedToWallet;
                            $updateQuery = "UPDATE user_registration SET current_balance = '$new_wallet_balance_two', pending_amount = '$finalPending', total_income = '$new_total_income_two', threex_amount = '$threexxamount', l1 = $level_1_income  WHERE user_name = '$sponsor_name'";
                            mysqli_query($conn2, $updateQuery);

                            $currentDate = date('Y-m-d H:i:s');
                            $newDate = date('Y-m-d H:i:s', strtotime($currentDate . ' + 7 days'));

                            $insertDb = "INSERT INTO `pending_pacakge_amount`(`id`, `userid`, `amount`, `orderid`, `expires_at`, `is_expired`) 
                            VALUES ('','$sponsor_name','$getBalanceAddedToPending','$insertId','$newDate','0')";
                            mysqli_query($conn2, $insertDb);
    
    
                        }
    
                        
    
                    }

                    $date = date('Y-m-d');

                    $updateInsert = "INSERT INTO `wallet_summary`(`id`, `user_name`, `amount`, `description`, `wallet_type`, `type`, `date`) VALUES ('','$sponsor_name','$level_amount','$name','Cash Wallet','Credit','$date')";
                    mysqli_query($conn2, $updateInsert);

                    $updateLevelBonus = "INSERT INTO `bonuses_details`(`id`, `sender`, `receiver`, `bonus_amount`, `level`, `date`) VALUES ('','$name','$sponsor_name','$level_amount','$level','$date')";
                    mysqli_query($conn2, $updateLevelBonus);

                }

                if ($sponseruser['sponsor_name'] !== "" && $sponseruser['sponsor_name'] !== null) {

                    $sponsor_name =  $sponseruser['sponsor_name'];

                }else{

                    break;

                }

              
            }

            // Increment the level and adjust directs needed for the next iteration
            $level++;
            $directs_needed++;
        }
    }



    // Close the database connection
    mysqli_close($conn2);
    if($insertTransaction){

        $response = [
            'status' => 'success',
            'message' => 'Transaction Success!'
        ];
        echo json_encode($response);

    }else{

        $response = [
            'status' => 'error',
            'message' => 'Transaction Failed!'
        ];
        echo json_encode($response);

    }

} else {

    $response = [
      'status' => 'error',
      'message' => 'ID Not Provided!'
    ];
    echo json_encode($response);
}