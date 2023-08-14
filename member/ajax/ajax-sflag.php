<?php
session_start();
include '../connection.php';

    
    $user_email = $_SESSION['email_verify'];
 
    
if(isset($_POST['otp']) and isset($_POST['loginPassword'])){
    # code...
    $password1 = mysqli_real_escape_string($con,$_POST['loginPassword']);
    $new_otp = intval(mysqli_real_escape_string($con,$_POST['otp']));
    $email = $user_email;
    
       
    // echo "$email and $password1 and $new_otp";
    // exit();
    
    if(empty($password1)){
    echo "Error Password cannot be blank. Try Again";
    exit();
    }
    if(empty($new_otp)){
    echo "Error OTP cannot be blank. Try Again";
    exit();
    }

    $sql = "SELECT * FROM user_registration WHERE email = ? or user_name = ?";
    $stmt = $con->prepare($sql); 
    $stmt->bind_param("ss", $email, $email);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    $data = $result->fetch_assoc(); // fetch data  
    $full_name = $data['full_name'];
    $old_otp = $data['otp_code'];
    
    if($new_otp == $old_otp)
    {
        $hash_pass = password_hash($password1, PASSWORD_BCRYPT);
        
        $sql = "UPDATE user_registration SET password = ?, sflag = 1 , otp_code='' WHERE email= ? or user_name= ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("sss", $hash_pass, $email, $email);
        
        if ($stmt->execute() === TRUE) {
            unset( $_SESSION['user_name']);
            echo 'Password Changed. Now you can login';
            $stmt->close();
            exit();
        
        }else{
             unset( $_SESSION['user_name']);
            echo "Error inserting record: " . $con->error;
            header("Location: sflag.php");
            $stmt->close();
            exit();
        
        }
    
    }
    else
    {
        echo "Error Wrong Otp";
        $stmt->close();
        exit();
    }
    
}
    
?>