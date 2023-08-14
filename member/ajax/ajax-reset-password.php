<?php

include '../connection.php';

if(isset($_POST['password1']) and isset($_POST['password2']) and isset($_POST['email']))
{
        # code...
        $password1 = mysqli_real_escape_string($con, $_POST['password1']);
        $password2 = mysqli_real_escape_string($con, $_POST['password2']);
        $email =   mysqli_real_escape_string($con, $_POST['email']) ; 
     
        
        if(empty($password1) AND empty($password2))
        {
            echo "Error Password cannot be blank";
            exit();
        }
        elseif($password1 == $password2)
        {
            $hash_pass = password_hash($password1, PASSWORD_BCRYPT);
            
            $qy = "UPDATE user_registration SET password='$hash_pass' , email_code='' WHERE email='$email'";
            $result = mysqli_query($con,$qy);
            
            if($result == TRUE)
            {
                echo "success message";
            }
            else
            {
                echo "Error this is error";
            }
        
        }
                    
}
else
{
    echo "Error Invalid Request";
    exit();
}

?>