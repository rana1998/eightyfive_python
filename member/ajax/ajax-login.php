<?php
include '../connection.php';


$selectImages = "select * from project_management";
$resultImages = mysqli_query($con,$selectImages);
$rowImages = mysqli_fetch_assoc($resultImages);

$logo = $rowImages['logo'];
$favIcon = $rowImages['fav_icon'];
$logo = mysqli_real_escape_string($con, $logo);
if (isset($_POST['user_name']) and isset($_POST['password'])) {

    $user_name = strtolower(mysqli_real_escape_string($con, $_POST['user_name']));
    $user_name = preg_replace("/\s+/", "", $user_name);        

    $pwd = mysqli_real_escape_string($con, $_POST['password']);

    // Error Handlers
    // Check if input are empty
    if (empty($user_name) || empty($pwd)) {
        echo "Please Enter Username and Password ";
        exit();
    } else {
        $sql = "SELECT * FROM user_registration WHERE user_name = ? or email=?";
		$stmt = $con->prepare($sql); 
		$stmt->bind_param("ss", $user_name,$user_name);
		$stmt->execute();
		$result = $stmt->get_result(); // get the mysqli result
		if($result->num_rows < 1){

		echo 'Please Enter Valid Username & Password.';
		$stmt->close();
		exit();

		}
		$data = $result->fetch_assoc();
		// Check Login Status
		if($data['login_status'] == 'Block'){
			echo $user_name ." is blocked!";
			$stmt->close();
			exit();
		}
		
                
                
             // De-Hashed Password
                $hashedPwdCheck = password_verify($pwd, $data['password']);
                if ($hashedPwdCheck == false) {
                   echo "Please Enter Valid Password ";
					$stmt->close();
                    exit();
                }
                	// Check Email Verification Status
			
			
        		elseif($data['verified'] == '0'){
        		    
        		     echo 'Your email is not verified. <span style="color:green;cursor:pointer" onclick="resendEmail()">Click Here</span> to verify ';
        		     $_SESSION['verification_email_user_name'] = $data['user_name'];
        		    	$stmt->close();
        			  exit();
        		}
        		//Check sFlag Status
                    elseif($data['sflag'] != 1){
                        $_SESSION['email_verify'] = $data['email'];
                        $_SESSION['user_name'] = $data['user_name'];
                        echo "This account has been locked due to security reason. <a style='color:green;cursor:pointer;text-decoration:none' href='sflag.php'>Click Here</a>";
                        // $stmt->close();
                        exit();
                    }
                elseif ($hashedPwdCheck == true) {
                    // login the user here

                      $_SESSION['user_name'] = $data['user_name'];
                     $_SESSION['full_name'] = $data['full_name'];
                     $_SESSION['s_email'] = true;
               
                    echo "success";
                     
                }
    }
} 



?>