<?php
include 'core/connection.php';

if(!empty($_SESSION['user_name']))
{
  header("Location: index.php"); 
}
unset($_SESSION['verification_email_user_name']);



if (isset($_POST['sign_in'])) {

    $user_name = strtolower(mysqli_real_escape_string($con, $_POST['user_name']));
    $user_name = preg_replace("/\s+/", "", $user_name);        

    $pwd = mysqli_real_escape_string($con, $_POST['password']);

       


    // Error Handlers
    // Check if input are empty
    if (empty($user_name) || empty($pwd)) {
        $_SESSION['errorMsg'] = "Please Enter Username and Password ";
        header("Location: login.php");
        exit();
    } else {
        $sql = "SELECT * FROM user_registration WHERE user_name = ? or email=?";
		$stmt = $con->prepare($sql); 
		$stmt->bind_param("ss", $user_name,$user_name);
		$stmt->execute();
		$result = $stmt->get_result(); // get the mysqli result
		if($result->num_rows < 1){

		$_SESSION['errorMsg']='Please Enter Valid Username & Password.';
		header("Location: login.php");
		$stmt->close();
		exit();

		}
		$data = $result->fetch_assoc();
		// Check Login Status
		if($data['login_status'] == 'Block'){
			$_SESSION['errorMsg'] = $user_name ." is blocked!";
			header("Location: login.php");
			$stmt->close();
			exit();
		}
		
                
                
             // De-Hashed Password
                $hashedPwdCheck = password_verify($pwd, $data['password']);
                if ($hashedPwdCheck == false) {
                    $_SESSION['errorMsg'] = "Please Enter Valid Username and Password ";
                    header("Location: login.php");
					$stmt->close();
                    exit();
                }
                	// Check Email Verification Status
			
			
        		elseif($data['verified'] == '0'){
        		    
        		     $_SESSION['errorMsg'] = 'Your email is not verified. Verify your email first to a successfull login!';
        		     $_SESSION['verification_email_user_name'] = $data['user_name'];
        		     header("Location: resend-verification.php");
        		    	$stmt->close();
        			  exit();
        		}
        		//Check sFlag Status
                    elseif($data['sflag'] != 1){
                        $_SESSION['email_verify'] = $data['email'];
                        $_SESSION['user_name'] = $data['user_name'];
                        $_SESSION['errorMsg'] = "This account has been locked due to security reason.";
                        // $stmt->close();
                        header("Location: sflag.php");
                        exit();
                    }
                elseif ($hashedPwdCheck == true) {
                    // login the user here

                    $_SESSION['user_name'] = $data['user_name'];
                    $_SESSION['full_name'] = $data['full_name'];
                    // $_SESSION['login_email'] = true;
                      $_SESSION['s_email'] = true;
                    // session_regenerate_id(true);
    
                    
                    $_SESSION['login_success'] = "Login Successfully..!";
                    header("Location: index.php");
					$stmt->close();                    
                    exit();
                }
    }
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
    <title>Login</title>
</head>
<style>
    body
    {
background-color: #880900;
background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 2000 1500'%3E%3Cdefs%3E%3CradialGradient id='a' gradientUnits='objectBoundingBox'%3E%3Cstop offset='0' stop-color='%23BA2D2D'/%3E%3Cstop offset='1' stop-color='%23880900'/%3E%3C/radialGradient%3E%3ClinearGradient id='b' gradientUnits='userSpaceOnUse' x1='0' y1='750' x2='1550' y2='750'%3E%3Cstop offset='0' stop-color='%23a11b17'/%3E%3Cstop offset='1' stop-color='%23880900'/%3E%3C/linearGradient%3E%3Cpath id='s' fill='url(%23b)' d='M1549.2 51.6c-5.4 99.1-20.2 197.6-44.2 293.6c-24.1 96-57.4 189.4-99.3 278.6c-41.9 89.2-92.4 174.1-150.3 253.3c-58 79.2-123.4 152.6-195.1 219c-71.7 66.4-149.6 125.8-232.2 177.2c-82.7 51.4-170.1 94.7-260.7 129.1c-90.6 34.4-184.4 60-279.5 76.3C192.6 1495 96.1 1502 0 1500c96.1-2.1 191.8-13.3 285.4-33.6c93.6-20.2 185-49.5 272.5-87.2c87.6-37.7 171.3-83.8 249.6-137.3c78.4-53.5 151.5-114.5 217.9-181.7c66.5-67.2 126.4-140.7 178.6-218.9c52.3-78.3 96.9-161.4 133-247.9c36.1-86.5 63.8-176.2 82.6-267.6c18.8-91.4 28.6-184.4 29.6-277.4c0.3-27.6 23.2-48.7 50.8-48.4s49.5 21.8 49.2 49.5c0 0.7 0 1.3-0.1 2L1549.2 51.6z'/%3E%3Cg id='g'%3E%3Cuse href='%23s' transform='scale(0.12) rotate(60)'/%3E%3Cuse href='%23s' transform='scale(0.2) rotate(10)'/%3E%3Cuse href='%23s' transform='scale(0.25) rotate(40)'/%3E%3Cuse href='%23s' transform='scale(0.3) rotate(-20)'/%3E%3Cuse href='%23s' transform='scale(0.4) rotate(-30)'/%3E%3Cuse href='%23s' transform='scale(0.5) rotate(20)'/%3E%3Cuse href='%23s' transform='scale(0.6) rotate(60)'/%3E%3Cuse href='%23s' transform='scale(0.7) rotate(10)'/%3E%3Cuse href='%23s' transform='scale(0.835) rotate(-40)'/%3E%3Cuse href='%23s' transform='scale(0.9) rotate(40)'/%3E%3Cuse href='%23s' transform='scale(1.05) rotate(25)'/%3E%3Cuse href='%23s' transform='scale(1.2) rotate(8)'/%3E%3Cuse href='%23s' transform='scale(1.333) rotate(-60)'/%3E%3Cuse href='%23s' transform='scale(1.45) rotate(-30)'/%3E%3Cuse href='%23s' transform='scale(1.6) rotate(10)'/%3E%3C/g%3E%3C/defs%3E%3Cg %3E%3Cg transform=''%3E%3Ccircle fill='url(%23a)' r='3000'/%3E%3Cg opacity='0.5'%3E%3Ccircle fill='url(%23a)' r='2000'/%3E%3Ccircle fill='url(%23a)' r='1800'/%3E%3Ccircle fill='url(%23a)' r='1700'/%3E%3Ccircle fill='url(%23a)' r='1651'/%3E%3Ccircle fill='url(%23a)' r='1450'/%3E%3Ccircle fill='url(%23a)' r='1250'/%3E%3Ccircle fill='url(%23a)' r='1175'/%3E%3Ccircle fill='url(%23a)' r='900'/%3E%3Ccircle fill='url(%23a)' r='750'/%3E%3Ccircle fill='url(%23a)' r='500'/%3E%3Ccircle fill='url(%23a)' r='380'/%3E%3Ccircle fill='url(%23a)' r='250'/%3E%3C/g%3E%3Cg transform='rotate(-3.6 0 0)'%3E%3Cuse href='%23g' transform='rotate(10)'/%3E%3Cuse href='%23g' transform='rotate(120)'/%3E%3Cuse href='%23g' transform='rotate(240)'/%3E%3C/g%3E%3Ccircle fill-opacity='0.08' fill='url(%23a)' r='3000'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
background-attachment: fixed;
background-size: cover;

     }
      .error
     {
         color:red;
     }
</style>
<body>
<!--wrapper-->
<div class="wrapper">
    <div class="section-authentication-signin d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container-fluid">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    
                    <div style="" class="card">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                <div class="mb-4 text-center">
                                    <img src="assets/images/logo-basic2.png" width="256" alt="" />
                                </div>
                                <div class="text-center">
                                    <h3 class="">Sign in</h3>
                                    <p>Don't have an account yet? <a href="signup.php" class="text-muted">Sign up here</a>
                                    </p>
                                </div>

                                    <div class="login-separater text-center mb-4"> <span>SIGN IN WITH EMAIL OR MEID</span>
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
                                    
                                    <!--alert msg start-->
                                			<div id="alertMsg">
                                			    
                                			</div>
                                		<!--alert msg close-->
                                    <form id="formSubmit" method="POST" class="row g-3">
                                        <div class="col-12">
                                            <label for="username" class="form-label">Email / MEID</label>
                                            <input type="text" name="user_name" class="form-control" id="username" placeholder="Enter Email / MEID">
                                        </div>
                                        <div class="col-12">
                                            <label for="pass" class="form-label">Enter Password</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input type="password" name="password" class="form-control border-end-0" id="pass" value="" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                            </div>

                                        </div>
                                        <div class="col-md-12">
                                            <div class="d-flex justify-content-end">
                                            
                                                <a class="text-muted" href="forgot_password.php">Forgot Password ?</a>
                                              
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="d-grid">
                                                <input type="submit" id="submit" name="sign_in" class="btn bg-gradient-rose-button text-white buttonProcessing" value="Sign In">
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
<script src="assets/js/jqueryValidator.min.js"></script>
<!--<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>-->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
<script>
  

    $("#formSubmit").validate( {
			    
			   rules: {
					user_name : {
					    required: true
					},
					password : {
					    required: true
					}
				},
				messages: {
				    
				    user_name: "Please enter Email / MEID",
					password : "Please enter password"
				},
				errorElement: "em",
				errorPlacement: function ( error, element ) {
					error.addClass( "help-block" );
					if ( element.prop( "type" ) === "password" ) {
						error.insertAfter( element.parent(".input-group") );
					}
					else if ( element.prop( "type" ) === "checkbox" ) {
						error.insertAfter( element.parent(".form-switch") );
					}
					else {
						error.insertAfter( element );
					}
				},
				highlight: function ( element, errorClass, validClass ) {
					$( element ).addClass( "is-invalid state-invalid" ).removeClass( "is-valid state-valid" );
				},
				unhighlight: function (element, errorClass, validClass) {
					$( element ).addClass( "is-valid state-valid" ).removeClass( "is-invalid state-invalid" );
				},
				
				
			} );
			
			
		
			
</script>


// <script>
//     $('#rememberme').click(function() {
//         if ($('#rememberme').is(':checked')){

//             // alert('i am checked');
//             document.cookie = "rememberme=yes;domain="+window.location.hostname+";path=/";
//             // save username and password
//             localStorage.usrname = $('#username').val();
//             localStorage.pass = $('#pass').val();
//             localStorage.chkbx = $('#rememberme').val();
//         }
//         else {
//             document.cookie = "rememberme=no;domain="+window.location.hostname+";path=/";
//             localStorage.usrname = '';
//             localStorage.pass = '';
//             localStorage.chkbx = '';
//         }
//     });
//      $('.buttonProcessing').click(function(){
         
//          $(".buttonProcessing").val('Processing...');
         
//          setTimeout(function(){ 
             
//              $(".buttonProcessing").prop('disabled', true);
             
//          }, 200);
//      })
     
// </script>


</body>


<!-- Mirrored from codervent.com/rocker/demo/vertical/authentication-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 15 Aug 2021 08:50:22 GMT -->
</html>