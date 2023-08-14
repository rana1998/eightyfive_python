<?php
session_start();
unset($_SESSION['user_name']);
unset($_SESSION['faVerified']);
//  $_SESSION['successMsg'] = 'Logout Successfully.';
// session_destroy();					
header("location:../mlm_landing/index.php");
exit();
?>