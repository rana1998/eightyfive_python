<?php
include 'db_config.php';

if(isset($_POST['companyName']))
{
    // echo $_POST['companyName'];
    
    $postedCompany = $_POST['companyName'];
    
    $q="select * from auto_model where company='$postedCompany'";
    $result= mysqli_query($con,$q);
    $resultRow= mysqli_num_rows($result);
    $data = mysqli_fetch_assoc($result);
    
    if($resultRow != 1)
    {
        echo 'something went wrong';
    }
    else
    {
        $selectedCompanyModel = $data['model'];
        echo '<option value="'.$selectedCompanyModel.'">'.$selectedCompanyModel.'</option>';
    }
    
    
    
    
    
}




?>