<?php 
session_start();
// include 'connect.php';
include 'core/db_config.php';
$conn = getDB();


           $sql= $conn->prepare("SELECT * FROM user_registration");
           $sql->execute();
           $sql->setFetchMode(PDO::FETCH_ASSOC);
           if($sql->rowCount()>0){
            foreach (($sql->fetchAll()) as $key => $row) {
          
           
          $user_name = $row['user_name'];
          $first_bonus = $row['first_bonus'];
          $second_bonus = $row['second_bonus'];

            $data = $conn->query("SELECT count(id) as Total1 FROM user_registration WHERE sponsor_name='".$user_name."'")->fetchAll();
               foreach ($data as $row) {  

             
             echo  $Total1 = $row['Total1'];  
             echo ","; 
                  
            }


           if ($first_bonus==0) {
           	
             if ($Total1>5) {
          	
          	//find second level users
          $sql= $conn->prepare("SELECT * FROM user_registration WHERE sponsor_name='".$user_name."' ");
           $sql->execute();
           $sql->setFetchMode(PDO::FETCH_ASSOC);
           if($sql->rowCount()>0){
            foreach (($sql->fetchAll()) as $key => $row) {
          
           echo '';

}
}


          }


           }
           else{
           	exit(0);
           }



         


}
}




?>