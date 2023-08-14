<?php
// Get Country Details
include '../connection.php';

 

if(isset($_POST['username']) && !empty($_POST['username'])){

    $userInput = $_POST['username'];

    $select="SELECT * FROM user_registration WHERE user_name='$userInput'";
    $res=mysqli_query($con,$select);
    $row= mysqli_num_rows($res);
    $data=mysqli_fetch_array($res);
    if ($row < 1) {
      echo '';
    }
    else
    {
        echo 'Username already used';
    }
    
    

}

