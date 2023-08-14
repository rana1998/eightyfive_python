<?php 

include 'core/connection.php';

// Recover Your Password
if(isset($_GET['module']) && $_GET['module'] == "email-verification"){ 

$email = $_GET['email'];
$code = $_GET['code'];

$sql = "SELECT * FROM user_registration WHERE email= ? AND email_code = ?";
$stmt = $con->prepare($sql); 
$stmt->bind_param("ss", $email, $code);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result
	if($result->num_rows < 1){
		$_SESSION['errorMsg'] = "Invalid Request.";
		header("Location: login.php");
		$stmt->close();
		exit();
    // echo"record not found for updation";
	}else{

	// Update Email Verified 
		$sql = "UPDATE user_registration SET verified = 1, email_code = '' WHERE email= ? ";
		$stmt = $con->prepare($sql);
		$stmt->bind_param("s", $email);
		if( $stmt->execute() ){
			$_SESSION['successMsg'] = 'Email verified successfully.';
			header("Location: login.php");
			$stmt->close();
            exit();
 		}
    // echo"record found for updation";
        
	}
}else{
		$_SESSION['errorMsg'] = "Invalid Request.";
		header("Location: login.php");
		exit();
}
?>
