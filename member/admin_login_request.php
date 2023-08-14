<?php
include "core/connection.php";

if(isset($_GET['userName']) and isset($_GET['loginCode']) and !empty($_GET['userName']) and !empty($_GET['loginCode']))
{
    $userName = mysqli_real_escape_string($con,$_GET['userName']);
    $loginCode = mysqli_real_escape_string($con,$_GET['loginCode']);
    
    // echo "userName: $userName and login code: $loginCode";
    
    $q="select * from user_registration where user_name='$userName' and session_code='$loginCode' and session_code!=''";
    $result = mysqli_query($con,$q);
    if(mysqli_num_rows($result)==1)
    {
         $res = mysqli_fetch_assoc($result);
         $_SESSION['user_name'] = $userName;
         $_SESSION['full_name'] = $res['full_name'];
         
         
         $qy="update user_registration set session_code='' where user_name='$userName'";
         $result1 = mysqli_query($con,$qy);
         header("location: index.php");
         exit();
    }
    else
    {
        header("location:login.php");
        session_destroy();
        exit();
    }
    
}





?>