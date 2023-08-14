<?php

include "../connection.php";
$userName= $_SESSION['user_name'];

if(!isset($_SESSION['user_name']))
{
    echo "Error"; 
}


if(isset($_POST['id']) and !empty($_POST['id']))
{
    $id = intval($_POST['id']);
    
    
    $q="select * from sub_category where main_category_id='$id'";
    $result = mysqli_query($con,$q);
    
    while($res = mysqli_fetch_assoc($result))
    {
        $responseArray[] = $res;
    }
     echo json_encode($responseArray);
     exit();
    
}