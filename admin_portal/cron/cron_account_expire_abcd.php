<?php 
ini_set('max_execution_time', 0);
//  ROI Cron Job File.
include '../db_config.php';





$q="select * from user_registration where total_income >= max_income and status='Approved' and pkg_id > 0";
$result= mysqli_query($con,$q);

$userArray = array();


while($res = mysqli_fetch_assoc($result))
{
    $userName= $res['user_name'];
    
    array_push($userArray,$userName);
    
}

// echo "<pre>";
// print_r($userArray);
// die();

foreach($userArray as $value)
{
    
     
         $qu="update user_registration set status = 'Expired' where user_name='$value'";
         $result= mysqli_query($con,$qu);
         
         
         $qy="update package_details set status='Expired', roi_status='Expired' where user_name='$value'";
         $result= mysqli_query($con,$qy);
         
}






// cron Log
$sql = "INSERT INTO cron_log (filename) VALUES('cron_account_expire.php')";
$stmt = mysqli_query($con,$sql); 
if ($stmt === FALSE) {
    $_SESSION['errorMsg'] =  __LINE__ ." Error inserting cron log: " . $con->error;
    exit();
}else{
    echo "Added To Cron Log";
}

// -------------------End of File------------------------ //


 ?>