<?php
// Get Country Details
include '../connection.php';



if(isset($_POST['email']))
{
    $email = $_POST['email'];
    $sql="select * from user_registration where email='$email'";
    $result=mysqli_query($con,$sql);
    if (mysqli_num_rows($result) > 0)
    {
        echo 'Email already used';
    }
    else
    {
        echo '';
    }

}

