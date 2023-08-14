<?php

// Retrieve the Ethereum address from the request
$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);

if (isset($data['address'])) {
  $address = $data['address'];
  // Use the address as needed
  // ...
} else {
  // Handle the case where the address is not provided
}

// Check if user with this wallet address already exist or not
//if exist make him login 

//            $sql= $conn->prepare("SELECT * FROM user_registration WHERE wallet_address='".$address."'");
//            $sql->execute();
//            $sql->setFetchMode(PDO::FETCH_ASSOC);
//            if($sql->rowCount()>0){
//             foreach (($sql->fetchAll()) as $key => $row) {
          
//            echo '1';

// }
// }
// else{
    

 
//  $sql="INSERT INTO user_registration(wallet_address) VALUES (:address)";
//     $stmt= $conn->prepare($sql);
//     $result= $stmt->execute(array(
//       ':address'=>$address,
//     ));


// }



//if not register and generate a code for him like mlm1...

// Return a response to the front end








$response = [
  'status' => 'success',
  'message' => $address
];
echo json_encode($response);
?>
