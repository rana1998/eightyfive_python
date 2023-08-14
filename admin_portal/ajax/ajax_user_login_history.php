<?php 
require_once('../core/config.php');
require_once('../core/session.php');
require_once('../helper/AdminHelper.php');
$db = getDB();    

// If the user is not logged in redirect to the login page...
if(!isset($_SESSION['admin_name'])){
    header("location:login.php"); 
    exit();
}
//To validate given text only string
if (isset($_GET['filter']) && $_GET['filter'] != '') {  
    if (is_string($_GET['filter'])) {
        $filter = $_GET['filter']; // Get the filter value from the GET parameter 
    } else {
        return false;
    }
} else {
    return false;;
}

if(isset($filter) && $filter =='weekly')
{
    $response = AdminHelper::getWeeklyVisitorsLoginHistory($db);
} else if(isset($filter) && $filter =='monthly') {
    $response = AdminHelper::getMonthlyVisitorsLoginHistory($db);
} else {
    $response = AdminHelper::getDailyVisitorsLoginHistory($db);
}

print_r(json_encode($response));

?>