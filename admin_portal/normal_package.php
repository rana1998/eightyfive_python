<?php 
ob_start();
	include "header.php";



    if(isset($_POST['buy_pkg'])){
        
        $uname2 = $uname1 = $uname = $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
        $pkg_price = mysqli_real_escape_string($con,$_POST['pkg_price']);
    
    
    
  
    // Check if input are empty
    if (empty($user_name) || empty($pkg_price)){
        $_SESSION['errorMsg'] = "Please fill all fields. ";
        header("Location: normal_package.php");
        exit();
    }
   
    $q="select * from package where pkg_price ='$pkg_price'";
    $result  = mysqli_query($con,$q);
    if(mysqli_num_rows($result)==1)
    {
        $res = mysqli_fetch_assoc($result);
        $pkg_name = $res['package_name'];
        $pkg_id = $res['id'];
        
    }
    else
    {
        $_SESSION['errorMsg'] = "Invalid Package";
        header("Location: normal_package.php");
        exit(); 
    }
    
    
   
    $maxIncome = $pkg_price * 2;

    //current user sponsor get
    $sql  = "SELECT * FROM user_registration WHERE user_name = ?"; // SQL with parameters
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $user_name);
    $run = $stmt->execute();
    if (!$run) {
        die(__LINE__ . 'Invalid Query' . $con->error);
    }
    $result = $stmt->get_result(); // get the mysqli result
    $data   = $result->fetch_assoc();
    $sname = $sname1 = $sname2 = $sponsor_name = $data['sponsor_name'];
    $userPkgId = $data['pkg_id'];
    $fullName=$data['full_name'];
    $email=$data['email'];
    $accountActivation = $data['activation_fee'];
    $stmt->close();


    //account activation check start
      if($accountActivation=='Unpaid')
      {
          $_SESSION['errorMsg']='Please activate account of this user with $20';
          header('location:normal_package.php');
          exit();
      }

    //account activation check end

     //first sponsor details
    $sql  = "SELECT * FROM user_registration WHERE user_name = ?"; // SQL with parameters
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $sponsor_name);
    $run = $stmt->execute();
    if (!$run) {
        die(__LINE__ . 'Invalid Query' . $con->error);
    }
    $result = $stmt->get_result(); // get the mysqli result
    $data2   = $result->fetch_assoc();
    $sponsorTotalInvest = $data2['total_invest']; 
    $sponsorStatus = $data2['status']; 

    
   

       

 
    // Generate Random String Function
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $trans_id = generateRandomString(10);
    

    //insert pacakge details
    $pkgMode= 'Normal';
    $pkgStatus= 'Approved';
    $pkgRoiStatus='Active';
    $pkgApprovedBy ='Admin';
    
    $sql="INSERT INTO `package_details`(`user_name`, `sponsor_name`,`pkg_id` ,`pkg_name`, `pkg_price`, `mode`, `trans_id`, `status`, `roi_status`, `approved_by`) 
                                VALUES (?,?,?,?,?,?,?,?,?,?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssisisssss", $user_name,$sponsor_name,$pkg_id,$pkg_name,$pkg_price,$pkgMode,$trans_id,$pkgStatus,$pkgRoiStatus,$pkgApprovedBy);
    $run = $stmt->execute();
    if (!$run) {
        die(__LINE__ . 'Invalid Query' . $con->error);
    }
    $stmt->close();
    
    
    
    if($userPkgId < $pkg_id)
    {
      // update user_registration current user update pkg id
        $pkgIdStatus = 'Updated';
        $query="update user_registration set pkg_id= '$pkg_id' ,  total_invest = total_invest + '$pkg_price' , max_income = max_income + '$maxIncome',status = 'Approved' , activation_fee='Paid' where user_name='$user_name'";
        $result = mysqli_query($con,$query);
    }
    else if($userPkgId >= $pkg_id)
    {
        // update user_registration current user
        $pkgIdStatus = 'Not Updated';
        $query="update user_registration set  total_invest = total_invest + '$pkg_price', max_income = max_income + '$maxIncome' , status = 'Approved' , activation_fee='Paid' where user_name='$user_name'";
        $result = mysqli_query($con,$query);
    }

    
    
 

//   $_SESSION['successMsg']= "userName: $user_name <br> 
//     packagePrice: $pkg_price <br> 
//     packageDays: $pkg_days <br> 
//     PackageName: $pkg_name <br>
//     PackageId Status: $pkgIdStatus <br>
//     SponsorName : $sponsor_name <br>
//     SponsorTotalInvest: $sponsorTotalInvest <br>
//     SponsorStatus : $sponsorStatus <br>
//     ROI Percentage : $roiPercentage <br>
//     Roi Bonus : $roiBonus <br>
//     Bonus Amount : $bonusAmount <br>
//     ";
//     header("Location: normal_package.php");
//     exit();
  


    //while loop start
 //fetch levels percentage
    $levelPercentageQuery="SELECT * FROM `level_percentage` where id='1'";
    $levelQueryResult= mysqli_query($con,$levelPercentageQuery);
    $levelPercentageResult = mysqli_fetch_assoc($levelQueryResult);
    

    
    //while loop start

    $sponsor_name = $sname1;

    $x = 1;
    while ($sponsor_name != '' and $x <= 8) {
        $sql  = "SELECT * FROM user_registration WHERE user_name = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $sponsor_name);
        $run = $stmt->execute();
        if (!$run) {
            die(__LINE__ . 'Invalid Query' . $con->error);
        }
        $result = $stmt->get_result();
        $data   = $result->fetch_assoc();
        $getSponsorStatus = $status = $data['status'];
        $getTotalIncome = $data['total_income'];
        $getMaxIncome = $data['max_income'];
        $getDirectTeam = $data['direct_team'];
        $stmt->close();
        
            
        if ($x == 1 and $getSponsorStatus == 'Approved' and $getDirectTeam>=1) 
        { 
            
               // Direct Bonus
                
            
                $calculateBonus = $pkg_price * ($levelPercentageResult['level1']/100);
                $initialBonus = $calculateBonus + $getTotalIncome;
                
                if($initialBonus <= $getMaxIncome)
                {
                    $bonus = $calculateBonus;
                }
                elseif($initialBonus > $getMaxIncome)
                {
                    $bonus = $getMaxIncome - $getTotalIncome;
                }
            
                
                
                
            
                // Update user registration (While Sponsor)
                $updateUserStatus = 'Approved';
                $sql="update user_registration set 
                current_balance = current_balance + ? ,
                total_income = total_income + ? ,
                d_sale = d_sale + ? ,
                l1 = l1 + ? ,
                s1 = s1 + ? ,
                db = db + ? ,
                idb_weekly = idb_weekly + ? ,
                idb_monthly = idb_monthly + ? 
                where user_name= ?";
                
                $stmt = $con->prepare($sql);
                $stmt->bind_param("dddddddds",$bonus,$bonus,$pkg_price,$bonus,$pkg_price,$bonus,$bonus,$bonus,$sponsor_name);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
        
        
                // insert into bonuses details
                $levelNumber = 1;
                $sql="INSERT INTO `bonuses_details`(`sender`, `receiver`, `bonus_amount`, `level`) 
                      VALUES (?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssdi",$user_name,$sponsor_name,$bonus,$levelNumber);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();  
             
               
                // Insert Into Wallet Summary
                $summaryDescription= 'Level 1 Bonus';
                $walletType = 'Cash Wallet';
                $incomeType = 'Credit';
                
                $sql = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) 
                       VALUES(?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sdsss",$sponsor_name,$bonus,$summaryDescription,$walletType,$incomeType);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
          
        } 
        else if ($x == 2 and $getSponsorStatus == 'Approved' and $getDirectTeam>=1) 
        { 
                // Direct Bonus
                 $calculateBonus = $pkg_price * ($levelPercentageResult['level2']/100);
                $initialBonus = $calculateBonus + $getTotalIncome;
                
                if($initialBonus <= $getMaxIncome)
                {
                    $bonus = $calculateBonus;
                }
                elseif($initialBonus > $getMaxIncome)
                {
                    $bonus = $getMaxIncome - $getTotalIncome;
                }
            
                // Update user registration (While Sponsor)
                $updateUserStatus = 'Approved';
                $sql="update user_registration set 
                current_balance = current_balance + ? ,
                total_income = total_income + ? ,
                d_sale = d_sale + ? ,
                l2 = l2 + ? ,
                s2 = s2 + ? ,
                idb = idb + ? ,
                idb_weekly = idb_weekly + ? ,
                idb_monthly = idb_monthly + ? 
                where user_name= ?";
                
                $stmt = $con->prepare($sql);
                $stmt->bind_param("dddddddds",$bonus,$bonus,$pkg_price,$bonus,$pkg_price,$bonus,$bonus,$bonus,$sponsor_name);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
        
        
                // insert into bonuses details
                $levelNumber = 2;
                $sql="INSERT INTO `bonuses_details`(`sender`, `receiver`, `bonus_amount`, `level`) 
                      VALUES (?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssdi",$user_name,$sponsor_name,$bonus,$levelNumber);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();  
             
               
                // Insert Into Wallet Summary
                $summaryDescription= 'Level 2 Bonus';
                $walletType = 'Cash Wallet';
                $incomeType = 'Credit';
                
                $sql = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) 
                       VALUES(?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sdsss",$sponsor_name,$bonus,$summaryDescription,$walletType,$incomeType);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
          
        } 
        else if ($x == 3 and $getSponsorStatus == 'Approved' and $getDirectTeam>=1) 
        { 
                // Direct Bonus
                $calculateBonus = $pkg_price * ($levelPercentageResult['level3']/100);
                $initialBonus = $calculateBonus + $getTotalIncome;
                
                if($initialBonus <= $getMaxIncome)
                {
                    $bonus = $calculateBonus;
                }
                elseif($initialBonus > $getMaxIncome)
                {
                    $bonus = $getMaxIncome - $getTotalIncome;
                }
            
                //Update user registration (While Sponsor)
                
                $updateUserStatus = 'Approved';
                $sql="update user_registration set 
                current_balance = current_balance + ? ,
                total_income = total_income + ? ,
                d_sale = d_sale + ? ,
                l3 = l3 + ? ,
                s3 = s3 + ? ,
                idb = idb + ? ,
                idb_weekly = idb_weekly + ? ,
                idb_monthly = idb_monthly + ? 
                where user_name= ?";
                
                $stmt = $con->prepare($sql);
                $stmt->bind_param("dddddddds",$bonus,$bonus,$pkg_price,$bonus,$pkg_price,$bonus,$bonus,$bonus,$sponsor_name);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
        
        
                // insert into bonuses details
                $levelNumber = 3;
                $sql="INSERT INTO `bonuses_details`(`sender`, `receiver`, `bonus_amount`, `level`) 
                      VALUES (?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssdi",$user_name,$sponsor_name,$bonus,$levelNumber);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();  
             
               
                // Insert Into Wallet Summary
                $summaryDescription= 'Level 3 Bonus';
                $walletType = 'Cash Wallet';
                $incomeType = 'Credit';
                
                $sql = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) 
                       VALUES(?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sdsss",$sponsor_name,$bonus,$summaryDescription,$walletType,$incomeType);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
          
        }
        else if ($x == 4 and $getSponsorStatus == 'Approved' and $getDirectTeam>=2) 
        { 
                // Direct Bonus
                 $calculateBonus = $pkg_price * ($levelPercentageResult['level4']/100);
                $initialBonus = $calculateBonus + $getTotalIncome;
                
                if($initialBonus <= $getMaxIncome)
                {
                    $bonus = $calculateBonus;
                }
                elseif($initialBonus > $getMaxIncome)
                {
                    $bonus = $getMaxIncome - $getTotalIncome;
                }
            
                //Update user registration (While Sponsor)
                
                $updateUserStatus = 'Approved';
                $sql="update user_registration set 
                current_balance = current_balance + ? ,
                total_income = total_income + ? ,
                d_sale = d_sale + ? ,
                l4 = l4 + ? ,
                s4 = s4 + ? ,
                idb = idb + ? ,
                idb_weekly = idb_weekly + ? ,
                idb_monthly = idb_monthly + ? 
                where user_name= ?";
                
                $stmt = $con->prepare($sql);
                $stmt->bind_param("dddddddds",$bonus,$bonus,$pkg_price,$bonus,$pkg_price,$bonus,$bonus,$bonus,$sponsor_name);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
        
        
                // insert into bonuses details
                $levelNumber = 4;
                $sql="INSERT INTO `bonuses_details`(`sender`, `receiver`, `bonus_amount`, `level`) 
                      VALUES (?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssdi",$user_name,$sponsor_name,$bonus,$levelNumber);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();  
             
               
                // Insert Into Wallet Summary
                $summaryDescription= 'Level 4 Bonus';
                $walletType = 'Cash Wallet';
                $incomeType = 'Credit';
                
                $sql = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) 
                       VALUES(?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sdsss",$sponsor_name,$bonus,$summaryDescription,$walletType,$incomeType);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
          
        }
        else if ($x == 5 and $getSponsorStatus == 'Approved' and $getDirectTeam>=3) 
        { 
                // Direct Bonus
                 $calculateBonus = $pkg_price * ($levelPercentageResult['level5']/100);
                $initialBonus = $calculateBonus + $getTotalIncome;
                
                if($initialBonus <= $getMaxIncome)
                {
                    $bonus = $calculateBonus;
                }
                elseif($initialBonus > $getMaxIncome)
                {
                    $bonus = $getMaxIncome - $getTotalIncome;
                }
            
                //Update user registration (While Sponsor)
                
                $updateUserStatus = 'Approved';
                $sql="update user_registration set 
                current_balance = current_balance + ? ,
                total_income = total_income + ? ,
                d_sale = d_sale + ? ,
                l5 = l5 + ? ,
                s5 = s5 + ? ,
                idb = idb + ? ,
                idb_weekly = idb_weekly + ? ,
                idb_monthly = idb_monthly + ? 
                where user_name= ?";
                
                $stmt = $con->prepare($sql);
                $stmt->bind_param("dddddddds",$bonus,$bonus,$pkg_price,$bonus,$pkg_price,$bonus,$bonus,$bonus,$sponsor_name);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
        
        
                // insert into bonuses details
                $levelNumber = 5;
                $sql="INSERT INTO `bonuses_details`(`sender`, `receiver`, `bonus_amount`, `level`) 
                      VALUES (?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssdi",$user_name,$sponsor_name,$bonus,$levelNumber);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();  
             
               
                // Insert Into Wallet Summary
                $summaryDescription= 'Level 5 Bonus';
                $walletType = 'Cash Wallet';
                $incomeType = 'Credit';
                
                $sql = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) 
                       VALUES(?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sdsss",$sponsor_name,$bonus,$summaryDescription,$walletType,$incomeType);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
          
        }
        else if ($x == 6 and $getSponsorStatus == 'Approved' and $getDirectTeam>=4) 
        { 
                // Direct Bonus
                 $calculateBonus = $pkg_price * ($levelPercentageResult['level6']/100);
                $initialBonus = $calculateBonus + $getTotalIncome;
                
                if($initialBonus <= $getMaxIncome)
                {
                    $bonus = $calculateBonus;
                }
                elseif($initialBonus > $getMaxIncome)
                {
                    $bonus = $getMaxIncome - $getTotalIncome;
                }
            
                //Update user registration (While Sponsor)
                
                $updateUserStatus = 'Approved';
                $sql="update user_registration set 
                current_balance = current_balance + ? ,
                total_income = total_income + ? ,
                d_sale = d_sale + ? ,
                l6 = l6 + ? ,
                s6 = s6 + ? ,
                idb = idb + ? ,
                idb_weekly = idb_weekly + ? ,
                idb_monthly = idb_monthly + ? 
                where user_name= ?";
                
                $stmt = $con->prepare($sql);
                $stmt->bind_param("dddddddds",$bonus,$bonus,$pkg_price,$bonus,$pkg_price,$bonus,$bonus,$bonus,$sponsor_name);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
        
        
                // insert into bonuses details
                $levelNumber = 6;
                $sql="INSERT INTO `bonuses_details`(`sender`, `receiver`, `bonus_amount`, `level`) 
                      VALUES (?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssdi",$user_name,$sponsor_name,$bonus,$levelNumber);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();  
             
               
                // Insert Into Wallet Summary
                $summaryDescription= 'Level 6 Bonus';
                $walletType = 'Cash Wallet';
                $incomeType = 'Credit';
                
                $sql = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) 
                       VALUES(?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sdsss",$sponsor_name,$bonus,$summaryDescription,$walletType,$incomeType);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
          
        }
        else if ($x == 7 and $getSponsorStatus == 'Approved' and $getDirectTeam>=5) 
        { 
                // Direct Bonus
                 $calculateBonus = $pkg_price * ($levelPercentageResult['level7']/100);
                $initialBonus = $calculateBonus + $getTotalIncome;
                
                if($initialBonus <= $getMaxIncome)
                {
                    $bonus = $calculateBonus;
                }
                elseif($initialBonus > $getMaxIncome)
                {
                    $bonus = $getMaxIncome - $getTotalIncome;
                }
            
                //Update user registration (While Sponsor)
                
                $updateUserStatus = 'Approved';
                $sql="update user_registration set 
                current_balance = current_balance + ? ,
                total_income = total_income + ? ,
                d_sale = d_sale + ? ,
                l7 = l7 + ? ,
                s7 = s7 + ? ,
                idb = idb + ? ,
                idb_weekly = idb_weekly + ? ,
                idb_monthly = idb_monthly + ? 
                where user_name= ?";
                
                $stmt = $con->prepare($sql);
                $stmt->bind_param("dddddddds",$bonus,$bonus,$pkg_price,$bonus,$pkg_price,$bonus,$bonus,$bonus,$sponsor_name);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
        
        
                // insert into bonuses details
                $levelNumber = 7;
                $sql="INSERT INTO `bonuses_details`(`sender`, `receiver`, `bonus_amount`, `level`) 
                      VALUES (?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssdi",$user_name,$sponsor_name,$bonus,$levelNumber);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();  
             
               
                // Insert Into Wallet Summary
                $summaryDescription= 'Level 7 Bonus';
                $walletType = 'Cash Wallet';
                $incomeType = 'Credit';
                
                $sql = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) 
                       VALUES(?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sdsss",$sponsor_name,$bonus,$summaryDescription,$walletType,$incomeType);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
          
        }
        else if ($x == 8 and $getSponsorStatus == 'Approved' and $getDirectTeam>=6) 
        { 
                // Direct Bonus
                 $calculateBonus = $pkg_price * ($levelPercentageResult['level8']/100);
                $initialBonus = $calculateBonus + $getTotalIncome;
                
                if($initialBonus <= $getMaxIncome)
                {
                    $bonus = $calculateBonus;
                }
                elseif($initialBonus > $getMaxIncome)
                {
                    $bonus = $getMaxIncome - $getTotalIncome;
                }
            
                //Update user registration (While Sponsor)
                
                $updateUserStatus = 'Approved';
                $sql="update user_registration set 
                current_balance = current_balance + ? ,
                total_income = total_income + ? ,
                d_sale = d_sale + ? ,
                l8 = l8 + ? ,
                s8 = s8 + ? ,
                idb = idb + ? ,
                idb_weekly = idb_weekly + ? ,
                idb_monthly = idb_monthly + ? 
                where user_name= ?";
                
                $stmt = $con->prepare($sql);
                $stmt->bind_param("dddddddds",$bonus,$bonus,$pkg_price,$bonus,$pkg_price,$bonus,$bonus,$bonus,$sponsor_name);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
        
        
                // insert into bonuses details
                $levelNumber = 8;
                $sql="INSERT INTO `bonuses_details`(`sender`, `receiver`, `bonus_amount`, `level`) 
                      VALUES (?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssdi",$user_name,$sponsor_name,$bonus,$levelNumber);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();  
             
               
                // Insert Into Wallet Summary
                $summaryDescription= 'Level 8 Bonus';
                $walletType = 'Cash Wallet';
                $incomeType = 'Credit';
                
                $sql = "INSERT INTO wallet_summary(`user_name`,`amount`,`description`,`wallet_type`,`type`) 
                       VALUES(?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("sdsss",$sponsor_name,$bonus,$summaryDescription,$walletType,$incomeType);
                $run = $stmt->execute();
                if (!$run) {
                    die(__LINE__ . 'Invalid Query' . $con->error);
                }
                $stmt->close();
          
        }
        
        
        
        // Getting Next Sponsor
        $sql  = "SELECT * FROM user_registration WHERE user_name= ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("s", $sponsor_name);
        $run = $stmt->execute();
        if (!$run) {
            die(__LINE__ . 'Invalid Query' . $con->error);
        }
        $result       = $stmt->get_result(); // get the mysqli result
        $data         = $result->fetch_assoc();
        $sponsor_name = $data['sponsor_name'];
        $stmt->close();

        $x++;
    }
    
    


// Update Team Sales (While loop)
while($sname2 != ''){

    $sql = "UPDATE user_registration SET team_sales = team_sales + ? WHERE user_name = ?";
    $stmt = $con->prepare($sql); 
    $stmt->bind_param("is",$pkg_price,  $sname2);
    $stmt->execute();
    $stmt->close();

    // Getting Next Sponsor //

    $sql = "SELECT `sponsor_name` FROM user_registration WHERE user_name = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $sname2);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    $data = $result->fetch_assoc(); // fetch data  
    $sname2 = $data['sponsor_name'];

    $stmt->close();

}

  // Block of Activity Report Code for first 9 Sponsor
    $select3 = "SELECT * FROM user_registration WHERE user_name ='$uname1' ";
    $result3 = mysqli_query($con, $select3);
        
    if($result3)
    {
        $user_data = mysqli_fetch_array($result3);
        $sname11=$user_data['sponsor_name'];
                
        $x=1;
        while($sname11!='' && $x<=8)
        {
            if ($x==1) 
            {
                 //   insert in activity_report
                $insert = "INSERT INTO activity_report (`sender`,`receiver`,`pkg_name`,`pkg_amount`,`level`)
                                VALUES('$uname1','$sname11','$pkg_name','$pkg_price','$x')";
            }
            else
            {
                        // $level = $x-1; 
                $insert = "INSERT INTO activity_report (`sender`,`receiver`,`pkg_name`,`pkg_amount`,`level`)
                                VALUES('$uname1','$sname11','$pkg_name','$pkg_price','$x')";

            }
            $run2 = mysqli_query($con ,$insert);
            if(!$run2)
            {
                echo 'Error: '.mysqli_error($con);
            } 

            $select="select * from user_registration where user_name='$sname11'";
            $res=mysqli_query($con,$select);
            $data=mysqli_fetch_array($res);
            $sname11=$data['sponsor_name'];
              
            $x++;
               
        } 
    } 


    //insert into admin log
    $activityMessage= 'Normal Package Active '.$uname2.' And Amount is '.$pkg_price;
    $adminNameSession = $_SESSION['admin_name'];
    $qyy="INSERT INTO `admin_log`(`user_name`, `activity`) 
          VALUES ('$adminNameSession','$activityMessage')";
    $result = mysqli_query($con,$qyy);
    
    // Sending Email //

    $subject = "Package Activated - vizeoncapital";
    $email_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>OTP Code | Wealth Trade Hub</title>
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="'.$favIcon1.'" type="image/x-icon">
       <style type="text/css">
            @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
                body[yahoo] .buttonwrapper { background-color: transparent !important; }
                body[yahoo] .button { padding: 0 !important; }
                body[yahoo] .button a { background-color: #9b59b6; padding: 15px 25px !important; }
            }

            @media only screen and (min-device-width: 601px) {
                .content { width: 600px !important; }
                .col387 { width: 387px !important; }
            }
        </style>
    </head>
    <body bgcolor="#34495E" style="margin: 0; padding: 0;" yahoo="fix">
        <!--[if (gte mso 9)|(IE)]>
        <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td>
        <![endif]-->
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;" class="content">
            <tr>
                <td style="padding: 15px 10px 15px 10px;">
                 
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#ffffff" style="padding: 30px 10px 0px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 20px; font-weight: bold;">
                    <img src="'.$logo1.'" alt="logo" width="256" height="60" style="display:block; margin-bottom: 15px;">
                    
                </td>
            </tr>
            <tr  bgcolor="#ffffff">
                <td align="center" style="padding: 20px 10px;font-size: 22px;color: rgb(31 175 49);font-family: Arial, Helvetica, sans-serif;font-weight: bold;text-center;">
                    <h1 style="color:green">Package Activated Successfully</h1>
                </td>
            </tr>
            <!-- <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px; ">
                    <b>Thank you for choosing vizeoncapital. Your package request has been approved </b><br>                    
                </td>
            </tr> -->
          
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 20px 25px 20px 0px; font-family: Arial, sans-serif;">
                    <table bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
                        <tr>
                            <td align="left" height="25" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <span style="color: #223035; text-align: center;">Payment Mode: </span>
                                <span style="color: #0269f0; text-align: center;">Normal</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" height="25" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <span style="color: #223035; text-align: center;">Transaction ID: </span>
                                <span style="color: #0269f0; text-align: center;">'.$trans_id.'</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" height="25" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <span style="color: #223035; text-align: center;">Package Name: </span>
                                <span style="color: #0269f0; text-align: center;">'.$pkg_name.'</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" height="25" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <span style="color: #223035; text-align: center;">Package Price: </span>
                                <span style="color: #0269f0; text-align: center;">$'.$pkg_price.'</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
        
            <tr>
                <td align="center" bgcolor="#1d2b3a" style="padding: 15px 10px 15px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px;">
                    <b>© All Rights Reserved - vizeoncapital.com</b>
                </td>
            </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
                </td>
            </tr>
        </table>
        <![endif]-->
    </body>
</html>';
    $param = array(
        'subject' => $subject ,
        'email_template' => $email_template ,
        'receiver_email' => $email ,
        'receiver_name' => $fullName 
     );
    
    
    if( send_email($param) ){
    
    $_SESSION['successMsg']= "Package Activated Successfully";
    header("Location: index.php");
    exit();    
    
    }
    // header("Location: package_purchased_email.php?userName={$user_name}&&pkgId={$user_pkg_id}&&transId={$trans_id}");
       
        
        



     


}



?> 

                        <!-- Main-body start -->
                        <div class="main-body">
                            <div class="page-wrapper">
                                <!-- Page-header start -->
                                <div class="page-header">
                                    <div class="row align-items-end">
                                        <div class="col-lg-8">
                                            <div class="page-header-title">
                                                <div class="d-inline">
                                                    <h4>Normal Packages</h4>
                                                    <span>Activate With All Bonuses and Active ROI.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index.php"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">Normal Packages</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Page-header end -->

                                <div class="page-body">

                                    <div class="container">
                                    <div class="row">
                                    <div class="col-lg-6 col-md-8 col-sm-12 mx-auto">

                                    <form class="md-float-material form-material" method = "POST">
                                    <div class="auth-box card">
                                    <div class="card-block">
                                    <div class="row m-b-20">
                                    <div class="col-md-12">
                                    <h3 class="text-center">Normal Package</h3>

                                    <!-- Success Message -->
                                    <?php if (isset($_SESSION['successMsg'])) {
                                    ?>
                                    <div class="alert alert-success background-success">
                                    <button type="button" class="close m-0" data-dismiss="alert" aria-label="Close">
                                    <i class="icofont icofont-close-line-circled text-white"></i>
                                    </button>
                                    <strong>Success!</strong> <?php echo $_SESSION['successMsg'] ;?>
                                    </div>
                                    <?php
                                    unset($_SESSION['successMsg']);
                                    } ?>

                                    <!-- Error Message -->
                                    <?php if (isset($_SESSION['errorMsg'])) {
                                    ?>
                                    <div class="alert alert-danger background-danger mb-0">
                                    <button type="button" class="close m-0" data-dismiss="alert" aria-label="Close">
                                    <i class="icofont icofont-close-line-circled text-white"></i>
                                    </button>
                                    <strong>Error!</strong> <?php echo $_SESSION['errorMsg'] ;?>
                                    </div>
                                    <?php
                                    unset($_SESSION['errorMsg']);
                                    } ?>
                                    </div>
                                    </div>

                                    <!-- <p class="text-muted text-center p-b-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->


                                        <!-- List of All Users  -->
                                    <div class="form-group form-primary">
                                    <!-- <label class="col-form-label">Select User:</label> -->
                                    <select class="form-control select2" name="user_name" id="user_name">
                                        <option value="">Select User</option>
                                    <?php 

                                        $sql_users = "SELECT * FROM user_registration WHERE id > 1";
                                        $run_users = mysqli_query($con , $sql_users);
                                        if(!$run_users){echo mysqli_error($con);}
                                        while ($row = mysqli_fetch_array($run_users)):
                                    ?>                                        
                                        <option value="<?php echo $row['user_name']; ?>"><?php echo $row['user_name']; ?></option>
                                    <?php endwhile; ?>    
                                    </select>
                                    </div>
                                    <div id="appendData">
                                        
                                    </div>
                                        <!-- List of All Users  -->
                                    <div class="form-group form-primary">
                                    <!-- <label class="col-form-label">Select User:</label> -->
                                    <select class="form-control select2" name="pkg_price">
                                        <option value="">Select Package</option>
                                    <?php 

                                        $sql_users = "SELECT * FROM package";
                                        $run_users = mysqli_query($con , $sql_users);
                                        if(!$run_users){echo mysqli_error($con);}
                                        while ($row = mysqli_fetch_array($run_users)):
                                    ?>                                        
                                        <option value="<?php echo $row['pkg_price']; ?>"><?php echo $row['package_name']; ?></option>
                                    <?php endwhile; ?>    
                                    </select>
                                    </div>
                                   
                                    
                                    <div class="row m-t-30">
                                    <div class="col-md-12">
                                    <button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" name = "buy_pkg">Submit Request</button>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </form>

                                    </div>

                                    </div>

                                    </div>

                                </div>
                            </div>
                        </div>


<?php

	include "footer.php";
?>                        
<script>
    $('#user_name').on("change",function()
    {
        var userName = $('#user_name').val();
        // alert(userName);
        
        //ajax start
        
            $.ajax({
              url: "ajax/ajax_user_verify.php",
              type: "POST",
              data: {
                    userName:userName,
              },
              beforeSend: function() {
                   $('#appendData').html('Processing...');
                },
              success: function(data,status){
                //   alert(data);
                    $('#appendData').html(data);
                  },
              error: function () {
                    alert("error");
                    alert(status);
                  }
                  
            });
        //ajax end
        
    });

    
</script>


