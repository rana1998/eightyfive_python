<?php
	include '../db_config.php';



   $sql = "SELECT * FROM banks
         WHERE id LIKE '%".$_POST['id']."%'"; 


   $result = mysqli_query($con, $sql);



   while($row = mysqli_fetch_array($result)){
   	$json['acc_title'] = $row['acc_title'];
   	$json['acc_number'] = $row['acc_number'];
   	
   }


   echo json_encode($json);
?>