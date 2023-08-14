<?php
admin_session_start();
function admin_session_start()
{
    if (isset($_COOKIE['PHPSESSID'])) {
        $sessid = $_COOKIE['PHPSESSID'];
    } elseif (isset($_GET['PHPSESSID'])) {
        $sessid = $_GET['PHPSESSID'];
    } else {
        session_start();
        return false;
    }
    
    if (!preg_match('/^[a-zA-Z0-9]{26}$/', $sessid)) {
        return false;
    }
    
    session_start();
    return true;
}

?>