<?php
session_start();
include "db_config.php";
if (!empty($_SESSION['admin_name'])) {
    header("location:index.php");
}



if (isset($_POST['submit'])) {
    
    $uid = strtolower(mysqli_real_escape_string($con, $_POST['admin_name']));
    $uid = preg_replace("/\s+/", "", $uid);        

    $pwd = mysqli_real_escape_string($con, $_POST['password']);
    
    // Error Handlers
    // Check if input are empty
    if (empty($uid) || empty($pwd)) {
        $_SESSION['errorMsg'] = "Please Enter Valid Username and Password ";
        header("Location: login.php");
        exit();
    } else {
        $sql         = "SELECT * FROM admin_login WHERE user_name = '$uid'";
        $result      = mysqli_query($con, $sql);
        $resultCheck = mysqli_num_rows($result);
        
        if ($resultCheck < 1) {
            $_SESSION['errorMsg'] = "Please Enter Valid Username and Password ";
            header("Location: login.php");
            exit();
        } else {
            if ($row = mysqli_fetch_assoc($result)) {
                // De-Hashed Password
                $hashedPwdCheck = password_verify($pwd, $row['password']);
                if ($hashedPwdCheck == false) {
                    $_SESSION['errorMsg'] = "Please Enter Valid Username and Password ";
                    header("Location: login.php");
                    exit();
                } elseif ($hashedPwdCheck == true) {
                    // login the user here
                
                    session_regenerate_id();
                    $_SESSION['admin_name'] = $row['user_name'];
                    header("Location: index.php");
                    exit();
                }
            }
        }
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
<title>Login</title>


<!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="description" content="#">
<meta name="keywords" content="">
<meta name="author" content="#">

<link rel="icon" href="../data/assets/images/favicon.ico" type="image/x-icon">
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,800" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="files/bower_components/bootstrap/css/bootstrap.min.css">

<link rel="stylesheet" type="text/css" href="files/assets/icon/themify-icons/themify-icons.css">

<link rel="stylesheet" type="text/css" href="files/assets/icon/icofont/css/icofont.css">

<link rel="stylesheet" type="text/css" href="files/assets/css/style.css">
</head>
<style>
    body
    {
background-color: #FFF9B5;
background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='100%25' height='100%25' viewBox='0 0 1600 800'%3E%3Cg %3E%3Cpath fill='%23ffefb0' d='M486 705.8c-109.3-21.8-223.4-32.2-335.3-19.4C99.5 692.1 49 703 0 719.8V800h843.8c-115.9-33.2-230.8-68.1-347.6-92.2C492.8 707.1 489.4 706.5 486 705.8z'/%3E%3Cpath fill='%23ffe5aa' d='M1600 0H0v719.8c49-16.8 99.5-27.8 150.7-33.5c111.9-12.7 226-2.4 335.3 19.4c3.4 0.7 6.8 1.4 10.2 2c116.8 24 231.7 59 347.6 92.2H1600V0z'/%3E%3Cpath fill='%23ffd9a5' d='M478.4 581c3.2 0.8 6.4 1.7 9.5 2.5c196.2 52.5 388.7 133.5 593.5 176.6c174.2 36.6 349.5 29.2 518.6-10.2V0H0v574.9c52.3-17.6 106.5-27.7 161.1-30.9C268.4 537.4 375.7 554.2 478.4 581z'/%3E%3Cpath fill='%23ffcb9f' d='M0 0v429.4c55.6-18.4 113.5-27.3 171.4-27.7c102.8-0.8 203.2 22.7 299.3 54.5c3 1 5.9 2 8.9 3c183.6 62 365.7 146.1 562.4 192.1c186.7 43.7 376.3 34.4 557.9-12.6V0H0z'/%3E%3Cpath fill='%23FFBD9A' d='M181.8 259.4c98.2 6 191.9 35.2 281.3 72.1c2.8 1.1 5.5 2.3 8.3 3.4c171 71.6 342.7 158.5 531.3 207.7c198.8 51.8 403.4 40.8 597.3-14.8V0H0v283.2C59 263.6 120.6 255.7 181.8 259.4z'/%3E%3Cpath fill='%23ffc49a' d='M1600 0H0v136.3c62.3-20.9 127.7-27.5 192.2-19.2c93.6 12.1 180.5 47.7 263.3 89.6c2.6 1.3 5.1 2.6 7.7 3.9c158.4 81.1 319.7 170.9 500.3 223.2c210.5 61 430.8 49 636.6-16.6V0z'/%3E%3Cpath fill='%23ffcb9a' d='M454.9 86.3C600.7 177 751.6 269.3 924.1 325c208.6 67.4 431.3 60.8 637.9-5.3c12.8-4.1 25.4-8.4 38.1-12.9V0H288.1c56 21.3 108.7 50.6 159.7 82C450.2 83.4 452.5 84.9 454.9 86.3z'/%3E%3Cpath fill='%23ffd39a' d='M1600 0H498c118.1 85.8 243.5 164.5 386.8 216.2c191.8 69.2 400 74.7 595 21.1c40.8-11.2 81.1-25.2 120.3-41.7V0z'/%3E%3Cpath fill='%23ffda9a' d='M1397.5 154.8c47.2-10.6 93.6-25.3 138.6-43.8c21.7-8.9 43-18.8 63.9-29.5V0H643.4c62.9 41.7 129.7 78.2 202.1 107.4C1020.4 178.1 1214.2 196.1 1397.5 154.8z'/%3E%3Cpath fill='%23FFE19A' d='M1315.3 72.4c75.3-12.6 148.9-37.1 216.8-72.4h-723C966.8 71 1144.7 101 1315.3 72.4z'/%3E%3C/g%3E%3C/svg%3E");
background-attachment: fixed;
background-size: cover;
 overflow-y:hidden;
     }
     .error
     {
         color:red;
     }
     .goog-te-banner-frame
        {
            display:none !important;
        }
</style>

<body>



<div class="theme-loader">
<div class="ball-scale">
<div class='contain'>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
<div class="ring"><div class="frame"></div></div>
</div>
</div>
</div>

<section class="login-block">

<div class="container">
<div class="row">
<div class="col-sm-12">

<form method = "POST" class="md-float-material form-material">
<!--<div class="text-center">-->
<!--<img src="files/assets/images/logo.png" alt="logo.png">-->
<!--</div>-->
<div class="auth-box card">
<div class="card-block">
<div class="row m-b-20">
<div class="col-md-12">
<h3 class="text-center">Admin Area</h3>

<!--Login Status Error -->

<?php if(isset($_SESSION['errorMsg'])): ?>
          <div class="alert alert-danger background-danger text-center">
              <button type="button" class="close " data-dismiss="alert" aria-label="Close">
                 <i class="icofont icofont-close-line-circled text-white"></i>
              </button>
              <strong>Error!</strong> <?php echo $_SESSION['errorMsg']; ?>
          </div>
<?php  unset($_SESSION['errorMsg']);     endif;  ?>


</div>
</div>
 <!--<div id="google_translate_element"></div>-->
<div class="form-group form-primary">
<input type="text" name="admin_name" class="form-control"  placeholder="Enter Your Username">
<span class="form-bar"></span>
</div>
<div class="form-group form-primary">
<input type="password" name="password" class="form-control"  placeholder="Password">
 <span class="form-bar"></span>
</div>

<div class="row m-t-30">
<div class="col-md-12">
<button type="submit" name ="submit" class="btn btn-primary btn-md btn-block waves-effect waves-light text-center m-b-20">Sign in</button>
</div>
</div>
<hr />
</div>
</div>
</form>

</div>

</div>

</div>

</section>

<script type="text/javascript" src="files/bower_components/jquery/js/jquery.min.js"></script>
<script type="text/javascript" src="files/bower_components/jquery-ui/js/jquery-ui.min.js"></script>
<script type="text/javascript" src="files/bower_components/popper.js/js/popper.min.js"></script>
<script type="text/javascript" src="files/bower_components/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="files/assets/js/common-pages.js"></script>

<!--google translator-->
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({pageLanguage: 'en'}, 'google_translate_element');
}
</script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>


</body>
</html>