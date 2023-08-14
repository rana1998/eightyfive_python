<?php
include 'core/connection.php';

if(isset($_GET['action']) && isset($_GET['email'])){


    if($_GET['action'] == 'Expire')
    {

        $email = mysqli_real_escape_string($con,$_GET['email']);

        // Expire Email Verification
        $sql = "UPDATE user_registration SET sflag=0 WHERE email ='$email'";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        $stmt->close();


        echo "<h3 style='text-align:center;margin-top:25px;'>Account Blocked Successfully</h3>";


    }
    else{
        header("Location: index.php");
    }

}


?>