<?php
session_start();
// require 'connect.php';
include 'core/db_config.php';
$conn = getDB();
require './core/connect-two.php';
// $conn2 = mysqli_connect("localhost","arialkhk_python","gtron@12g","arialkhk_python")or die("could not connect to mysqli");


$avail_balance=$_POST['avail_balance'];
$desired_amount_transfer=$_POST['desired_amount_transfer'];
$amount_after_tax=$_POST['amount_after_tax'];
$selectedUser=$_POST['selectedUser'];

if ($desired_amount_transfer>$avail_balance) {
  echo "2";
  exit();
}

$new_avail_balance = $avail_balance - $desired_amount_transfer;

$sql="UPDATE user_registration SET current_balance=:new_avail_balance WHERE user_name='".$_SESSION['user_name']."'";
$stmt= $conn->prepare($sql);
$result= $stmt->execute(array(
	':new_avail_balance'=>$new_avail_balance,
));


if($result)
{

 $sql2= $conn->prepare("SELECT * FROM user_registration WHERE user_name='".$selectedUser."' or email='".$selectedUser."'");
              $sql2->execute();
              $sql2->setFetchMode(PDO::FETCH_ASSOC);
              if($sql2->rowCount()>0){
                foreach (($sql2->fetchAll()) as $key => $row) {
                     
                    $current_balance = $row['current_balance'];
                    $new_current_balance = $current_balance + $amount_after_tax;

                    $selected_user_name = $row['user_name'];
	                
                } 
                  

$sql3="UPDATE user_registration SET current_balance=:new_current_balance WHERE user_name='".$selectedUser."'";
$stmt= $conn->prepare($sql3);
$result2= $stmt->execute(array(
	':new_current_balance'=>$new_current_balance,
));


$sql="INSERT INTO wallet_transfer(transfer_from, transfer_to, transfer_amount) VALUES (:transfer_from,:transfer_to,:transfer_amount)";
    $stmt= $conn->prepare($sql);
    $result= $stmt->execute(array(
      ':transfer_from'=>$_SESSION['user_name'],
      ':transfer_to'=>$selectedUser,
      ':transfer_amount'=>$desired_amount_transfer,
    ));

    $date = date('Y-m-d');
    $message1 = 'Wallet Transfer to user '.$selected_user_name;
    $message2 = 'Wallet Transfer from user '.$_SESSION['user_name'];
    $usernn = $_SESSION['user_name'];
    $updateInsertOne = "INSERT INTO `wallet_summary`(`id`, `user_name`, `amount`, `description`, `wallet_type`, `type`, `date`) VALUES ('','$usernn','$desired_amount_transfer','$message1','Cash Wallet','Debit','$date')";
    mysqli_query($conn2, $updateInsertOne);

    $updateInsertTwo = "INSERT INTO `wallet_summary`(`id`, `user_name`, `amount`, `description`, `wallet_type`, `type`, `date`) VALUES ('','$selected_user_name','$amount_after_tax','$message2','Cash Wallet','Credit','$date')";
    mysqli_query($conn2, $updateInsertTwo);



if($result2)
{

echo "1";
}
else{
echo "0";	
}



              }else{
                echo "5";
              }

}
else
{
	echo "0";
}


?>