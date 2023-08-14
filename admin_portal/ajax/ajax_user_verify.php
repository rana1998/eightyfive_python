<?php
include "../db_config.php";


if(!isset($_SESSION['admin_name'])){
      header("location:login.php"); 
      exit();
}
    


if(isset($_POST['userName']) and !empty($_POST['userName']))
{
   
    $userName = mysqli_real_escape_string($con,$_POST['userName']);
    
    $q="select * from user_registration where user_name ='$userName'";
    $result = mysqli_query($con,$q);
    
    if($result == 1)
    {
        $res = mysqli_fetch_assoc($result);
        $full_name = $res['full_name'];
        $email = $res['email'];
        
        //  echo $userName.$fullName.$email;
        //   die();
        
        echo "<div class='py-3'>
                  <b>Full Name:</b> $full_name
                  <br>
                  <b>Email:</b>  $email
              </div> ";
    }
    else
    {
        echo "Not Found";
    }
    
}





?>