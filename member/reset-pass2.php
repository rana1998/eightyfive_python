<?php
include 'core/connection.php';
$page_title = "Recover Password";

if(isset($_GET['module']) && $_GET['module'] == "reset")
{
    $email = $_GET['email'];
    $code = $_GET['code'];
     $sql = "SELECT * FROM user_registration WHERE email= ? AND email_code = ?";
    
    
    $stmt = $con->prepare($sql); 
    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    	if($result->num_rows < 1){
    		$_SESSION['errorMsg'] = "Invalid Request.";
    		header("Location: login.php");
    		$stmt->close();
    		exit();
            }
            else
            {
                    if(isset($_POST['recover_pass'])){
                    # code...
                    $password1 = mysqli_real_escape_string($con, $_POST['password1']);
                    $password2 = mysqli_real_escape_string($con, $_POST['password2']);
                    if(empty($password1) AND empty($password2)  ){
                    $_SESSION['errorMsg'] = "Password cannot be blank";
                    header("Location: reset-pass.php?module=reset&email=".$_GET['email']."&code=".$_GET['code']);
                    exit();
                    }elseif($password1 == $password2)
                    {
                    $email = $_GET['email'];
                    $hash_pass = password_hash($password1, PASSWORD_BCRYPT);
                    
                    $sql = "UPDATE user_registration SET password = ?, email_code = NULL WHERE email= ? ";
                    $stmt = $con->prepare($sql);
                    $stmt->bind_param("ss", $hash_pass, $email);
                    
                    if ($stmt->execute() === TRUE) {
                        $_SESSION['successMsg']='Password Changed.';
                        header("Location: login.php");
                        $stmt->close();
                        exit();
                    
                    }else{
                        $_SESSION['errorMsg'] =  "Error inserting record: " . $con->error;
                        header("Location: reset-pass.php");
                        $stmt->close();
                        exit();
                    
                    }
                    
                    }else{
                    $_SESSION['errorMsg'] = "Password Invalid";
                    header("Location: reset-pass.php?module=reset&email=".$_GET['email']."&code=".$_GET['code']);
                    $stmt->close();
                    exit();
                    }
                    
                    }
                
            }
}
else
{
                    $_SESSION['errorMsg'] = "Invalid Request";
                    header("Location: login.php");
                    $stmt->close();
                    exit();
    
}

    
    
    
?>
<!doctype html>
<html lang="en">


<!-- Mirrored from codervent.com/rocker/demo/vertical/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 15 Aug 2021 08:50:21 GMT -->
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
    <!--plugins-->
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet" />
    <script src="assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/icons.css" rel="stylesheet">
    <title>Reset Password</title>
</head>

<body class="bg-lock-screen">
<!--wrapper-->
<div class="wrapper">
    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    <!--                    <div class="mb-4 text-center">-->
                    <!--                        <img src="assets/images/logo-img.png" width="180" alt="" />-->
                    <!--                    </div>-->
                    <div class="card">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                <div class="text-center">
                                    <h3 class="">Reset Password</h3>
<!--                                    <p>Don't have an account yet? <a href="signup.php">Sign up here</a>-->
<!--                                    </p>-->
                                </div>

                                <div class="login-separater text-center mb-4"> <span>CREATE PASSWORD</span>
                                    <hr/>
                                </div>
                                <div class="form-body">
                                   <?php if(isset($_SESSION['successMsg'])): ?>
                                    <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-white">Success </h6>
                                                <div class="text-white"><?php echo $_SESSION['successMsg']; ?></div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php  unset($_SESSION['successMsg']);     endif;  ?>
                                    
                                    <?php if(isset($_SESSION['errorMsg'])): ?>
                                    <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                                        <div class="d-flex align-items-center">
                                            <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                                            </div>
                                            <div class="ms-3">
                                                <h6 class="mb-0 text-white">Error </h6>
                                                <div class="text-white"><?php echo $_SESSION['errorMsg']; ?></div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    <?php  unset($_SESSION['errorMsg']);     endif;  ?>
                                    <form method="POST" class="row g-3">
                                        <div class="col-12">
                                            <label for="pass" class="form-label">Enter Password</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input type="password" name="password1" class="form-control border-end-0" id="pass" value="" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="pass" class="form-label">Confrim Password</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input type="password" name="password2" class="form-control border-end-0" id="pass" value="" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" name="recover_pass" class="btn bg-gradient-ibiza text-white"><i class="bx bxs-lock-open"></i>Reset password</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</div>
<!--end wrapper-->
<!-- Bootstrap JS -->
<script src="assets/js/bootstrap.bundle.min.js"></script>
<!--plugins-->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
<script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
<script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
<!--Password show & hide js -->
<script>
    $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("bx-hide");
                $('#show_hide_password i').removeClass("bx-show");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("bx-hide");
                $('#show_hide_password i').addClass("bx-show");
            }
        });
    });
</script>
<!--app JS-->
<script src="assets/js/app.js"></script>

</body>


<!-- Mirrored from codervent.com/rocker/demo/vertical/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 15 Aug 2021 08:50:22 GMT -->
</html>