<?php 
// include 'connect.php';
include 'core/db_config.php';
$conn = getDB();


                 $sql= $conn->prepare("SELECT * FROM user_pool_amount WHERE id='1'");
                 $sql->execute();
                 $sql->setFetchMode(PDO::FETCH_ASSOC);
                 if($sql->rowCount()>0){
                 foreach (($sql->fetchAll()) as $key => $row) {
                 
                 $total_pool_amount = $row['total_pool_amount'];
                 $total_sale_amount = $row['total_sale_amount'];
}
}


$sql="INSERT INTO user_pool_amount_history(total_pool_amount, total_sale_amount) VALUES (:total_pool_amount,:total_sale_amount)";
    $stmt= $conn->prepare($sql);
    $result= $stmt->execute(array(
      ':total_pool_amount'=>$total_pool_amount,
      ':total_sale_amount'=>$total_sale_amount,
    ));



//Calculating total shares
$total_shares = $total_sale_amount/50;   

//calculating price of each share from pool
$each_share = $total_pool_amount/$total_shares;


$sql2= $conn->prepare("SELECT * FROM user_registration");
                 $sql2->execute();
                 $sql2->setFetchMode(PDO::FETCH_ASSOC);
                 if($sql2->rowCount()>0){
                 foreach (($sql2->fetchAll()) as $key => $row2) {
                 
                 $user_name = $row2['user_name'];
                 $current_balance = $row2['current_balance'];
                 $threex_amount_limit = $row2['threex_amount_limit'];
                 $threex_amount = $row2['threex_amount'];
                 $eligible_shares = $row2['eligible_shares'];

                 //Calculating Amount to be credited

                 $amount_to_credit = $eligible_shares*$each_share;

                 //Amount to be credited in 3x limit 
                 $amount_to_credit_in_threex = $amount_to_credit+$threex_amount_limit;

                 //Amount to credit in ACCOUNT
                 $amount_to_credit_in_balance = $amount_to_credit+$current_balance;
                 

                 if ($threex_amount_limit<$threex_amount) {
                 	
                 $sql="UPDATE user_registration SET current_balance=:amount_to_credit_in_balance, threex_amount_limit=:amount_to_credit_in_threex WHERE user_name=:user_name";
                  $stmt= $conn->prepare($sql);
                  $result= $stmt->execute(array(
                  ':user_name'=>$user_name,
	              ':amount_to_credit_in_balance'=>$amount_to_credit_in_balance,
	              ':amount_to_credit_in_threex'=>$amount_to_credit_in_threex,

                  ));


                  $sql="INSERT INTO pool_share_credit_history(user_name, amount_credited, amount_before_credit, amount_after_credit) VALUES (:user_name,:amount_to_credit,:current_balance,:amount_to_credit_in_balance)";
                  $stmt= $conn->prepare($sql);
                  $result= $stmt->execute(array(
                  ':user_name'=>$user_name,
                  ':amount_to_credit'=>$amount_to_credit,
                  ':current_balance'=>$current_balance,
                  ':amount_to_credit_in_balance'=>$amount_to_credit_in_balance,
                   ));
                 



                 }

}
}

$zero = 0;

$sql="UPDATE user_pool_amount SET total_pool_amount=:zero, total_sale_amount=:zero WHERE id=1";
                  $stmt= $conn->prepare($sql);
                  $result= $stmt->execute(array(
                  ':zero'=>$zero,
                  ));







?>