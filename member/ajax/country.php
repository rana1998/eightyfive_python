<?php
// Get Country Details
include '../connection.php';



if(isset($_GET['country']) && !empty($_GET['country'])){

    $country = $_GET['country'];

    $select="SELECT * FROM country WHERE name='$country'";
    $res=mysqli_query($con,$select);
    if (!$res) {
        mysqli_error($con);
    }
    $data=mysqli_fetch_array($res);
    echo $data['phonecode'].'|'.$data['iso'];

}

