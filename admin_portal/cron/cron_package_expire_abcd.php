<?php 
ini_set('max_execution_time', 0);
//  ROI Cron Job File.
include '../db_config.php';



$q="select * from package_details where status='Approved' and roi_status = 'Active'";
$result= mysqli_query($con,$q);

$pkgIdArray = array();


while($res = mysqli_fetch_assoc($result))
{
    $pkgId= $res['id'];
    
    array_push($pkgIdArray,$pkgId);
    
}

// echo "<pre>";
// print_r($pkgIdArray);
// die();

foreach($pkgIdArray as $value)
{
        $q="select * from package_details where id='$value'";
        $result= mysqli_query($con,$q);
        $res = mysqli_fetch_assoc($result);
        
        $receivedRoi = $res['received_roi'];
        $pkgPrice  = $res['pkg_price'];
        $userName = $res['user_name'];
        
        
        $limit = $pkgPrice*2;    
        
        
        $query="select * from package_details where user_name='$userName'";
        $result2 = mysqli_query($con,$query);
        if(mysqli_num_rows($result2)==1)
        {
             if($receivedRoi >= $limit)
            {
                $qy="update package_details set status='Expired' , roi_status='Inactive' where id='$value'";
                $resu = mysqli_query($con,$qy);
                
                $qu="update user_registration set status='Expired' where user_name='$userName'";
                $ress = mysqli_query($con,$qu);
                
                
                echo "Received ROI: $receivedRoi ,  Package Price: $pkgPrice , Limit: $limit *********Package and user status Expired*******<br>";
                
            }
           
        }
        elseif(mysqli_num_rows($result2)>1)
        {
             if($receivedRoi >= $limit)
            {
                $qy="update package_details set status='Expired' , roi_status='Inactive' where id='$value'";
                $resu = mysqli_query($con,$qy);
                echo "Received ROI: $receivedRoi ,  Package Price: $pkgPrice , Limit: $limit *********Package Expired*******<br>";
            }
        }
    
         
}






// cron Log
$sql = "INSERT INTO cron_log (filename) VALUES('cron_package_expire.php')";
$stmt = mysqli_query($con,$sql); 
if ($stmt === FALSE) {
    $_SESSION['errorMsg'] =  __LINE__ ." Error inserting cron log: " . $con->error;
    exit();
}else{
    echo "Added To Cron Log";
}

// -------------------End of File------------------------ //


 ?>