<?php
session_start();
// echo "<h1>Pyament Success</h1>";

$_SESSION['successMsg'] = "Payment received successfully";
header("location: index.php");
exit();

?>