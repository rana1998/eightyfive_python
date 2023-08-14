<?php
ob_start();
session_start();
require '../member/core/connect.php';

// Retrieve the Ethereum address from the request
$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);
// $conn2 = mysqli_connect("localhost","arialkhk_python","gtron@12g","arialkhk_python")or die("could not connect to mysqli");
// $conn2 = mysqli_connect("localhost","root","","arialkhk_python")or die("could not connect to mysqli");
require '../member/core/connect-two.php';
if (isset($data['address'])) {

  $address = $data['address'];
  $reff = $_SESSION['reff'];
  $current_login = $data["login"];
  if($reff == 'notdefined'){ 

    $sql= $conn->prepare("SELECT * FROM user_registration WHERE wallet_address='".$address."'");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    if($sql->rowCount()>0){

           

         foreach (($sql->fetchAll()) as $key => $row) {

           $id = $row['id'];
           $sql2="UPDATE user_registration SET current_login=:current_login WHERE id=:id";
           $stmt2= $conn->prepare($sql2);
           $result2= $stmt2->execute(array(':current_login'=>$current_login,':id'=>$id,));
           $_SESSION['user_name'] = $row['user_name'];
           $response = [
             'status' => 'login',
             'message' => 'login success',
             'logintype' => 1
           ];
           echo json_encode($response);
       }
     }else{

           $sql="INSERT INTO user_registration(wallet_address, current_login) VALUES (:address, :current_login)";
           $stmt= $conn->prepare($sql);
           $result= $stmt->execute(array(
             ':address'=>$address,
             ':current_login'=>$current_login
           ));

           $id = $conn->lastInsertId();
           $user_name = "mlm{$id}";

           $sql="UPDATE user_registration SET user_name=:user_name WHERE id=:id";
           $stmt= $conn->prepare($sql);
           $result= $stmt->execute(array(':user_name'=>$user_name,':id'=>$id,));

           $_SESSION['user_name'] = $user_name;


           $response = [
             'status' => 'success',
             'message' => $address,
             'logintype' => 0
           ];
           echo json_encode($response);

     }

  } else {

    $sql2= $conn->prepare("SELECT * FROM user_registration WHERE user_name='".$reff."'");
    $sql2->execute();
    $sql2->setFetchMode(PDO::FETCH_ASSOC);
    if($sql2->rowCount()>0){

      foreach (($sql2->fetchAll()) as $key => $row) {
        $username = $row['user_name'];
      }

      $sql= $conn->prepare("SELECT * FROM user_registration WHERE wallet_address='".$address."'");
      $sql->execute();
      $sql->setFetchMode(PDO::FETCH_ASSOC);
      if($sql->rowCount()>0){

         foreach (($sql->fetchAll()) as $key => $row) {

          $id = $row['id'];
          $sql2="UPDATE user_registration SET current_login=:current_login WHERE id=:id";
          $stmt2= $conn->prepare($sql2);
          $result2= $stmt2->execute(array(':current_login'=>$current_login,':id'=>$id,));
           $_SESSION['user_name'] = $row['user_name'];
           $response = [
             'status' => 'login',
             'message' => 'login success',
             'logintype' => 1
           ];
           echo json_encode($response);
       }

     }else{

          $q = "INSERT INTO `user_registration`(`id`, `wallet_address`, `pkg_id`, `sponsor_name`, `user_name`, `current_login`) VALUES ('','$address','','$username','','$current_login')";
          $b = mysqli_query($conn2,$q);
          
           $id = mysqli_insert_id($conn2);
           $user_name = "mlm{$id}";

           $sql="UPDATE user_registration SET user_name=:user_name WHERE id=:id";
           $stmt= $conn->prepare($sql);
           $result= $stmt->execute(array(':user_name'=>$user_name,':id'=>$id,));

           $_SESSION['user_name'] = $user_name;


           $response = [
             'status' => 'success',
             'message' => $address,
             'logintype' => 0
           ];
           echo json_encode($response);

     }

    } else {

      $response = [
        'status' => 'error',
        'message' => 'Invalid Referral Code Found!'
      ];
      echo json_encode($response);

    }

  }
          
} else {
  $response = [
    'status' => 'error',
    'message' => 'Address not provided'
  ];
  echo json_encode($response);
  // Handle the case where the address is not provided
}
?>
