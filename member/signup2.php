<?php
$page_name = "Register";
include 'core/connection.php';


if($_GET['user_name'])
{
    $referral = $_GET['user_name'];
    $checkRef = "1";
}
else
{
    $referral='rc0001';
    $checkRef='';
}



?>
<!doctype html>
<html lang="en">


<!-- Mirrored from codervent.com/rocker/demo/vertical/authentication-signup.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 15 Aug 2021 08:50:22 GMT -->
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
    <title>Sign Up</title>
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
    <div class="d-flex align-items-center justify-content-center my-5 my-lg-0">
        <div class="container">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-2">
                <div class="col mx-auto">
                    
                    <div class="card mt-4">
                        <div class="card-body">
                            <div class="border p-4 rounded">
                                <div class="text-center">
                                    <div class="mb-4 text-center">
                                        <img src="assets/images/logo-basic2.png" width="256" alt="" />
                                    </div>
                                    <br>
                                    <h3 class="">Sign Up</h3>
                                    <p>Already have an account? <a class="text-muted" href="login.php">Sign in here</a>
                                    </p>
                                </div>
                                <div class="login-separater text-center mb-4"> <span>ENTER DETAILS BELOW</span>
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
                                    <!--<div id="validateMessage" style="width: 100%" class="text-center alert alert-danger">-->

                                    </div>
                                    <form id="formSubmit" method="post" class="row g-3">
                                        <div class="col-sm-6">
                                            <label  for="uname" class="form-label">Sponsor Id</label>
                                            <input type="text" name="sponsor_name" class="form-control" id="uname" value="<?=$referral?>" placeholder="Enter Sponsor ID">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="full-name" class="form-label">Name</label>
                                            <input  type="text" name="full_name" class="form-control" id="full-name" placeholder="Enter Full Name">
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" name="email" class="form-control" id="email" placeholder="example@user.com">
                                             <div style="color:red" id="sponsorNameError"></div>
                                        </div>
                                       
                                        <div class="col-sm-6">
                                            <label for="pass1" class="form-label">Password</label>
                                            <div class="input-group" id="show_hide_password">
                                                <input name="password" type="password" class="form-control border-end-0" id="pass1" value="" placeholder="Enter Password"> <a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
                                               
                                            </div>
                                            <div style="font-size: 11px" id="strength"></div>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="inputSelectCountry" class="form-label">Country</label>
                                            <select class="form-select" name="country_name" id="country" aria-label="Default select example">
                                                <option value="">Select country</option>
                                                <?php
                                                $select = "SELECT * FROM country";
                                                $res = mysqli_query($con, $select);

                                                while ($data = mysqli_fetch_array($res)) { ?>
                                                    <option value="<?php echo $data['name'] ?>"><?php echo $data['name'] ?></option>
                                                <?php }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="inputEmailAddress" class="form-label">Phone</label>
                                            <div class="input-group mb-3 align-items-center">
<!--                                                <span class="input-group-text">-->
<!---->
<!--                                                </span>-->
                                                <div>
                                                    <img id="flag" style="border-radius: 8px" height="35"  width="40" class="p-1" src="https://fbsworldnetwork.com/member/images/flags/flag.png" alt="">
                                                </div>
                                                <!--<span class="input-group-text" id="countryCode">+92 </span>-->
                                                <input style="width:60px" class="input-group-text" readonly id="countryCode" type="text"  >
                                                <input name="phone" id="mobileNumber" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" type="text" class="form-control" placeholder="Mobile" aria-label="Dollar amount (with dot and two decimal places)">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" name="agree"  type="checkbox" id="flexSwitchCheckChecked">
                                                <label class="form-check-label" for="flexSwitchCheckChecked">I read and agree to Terms & Conditions</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button type="submit" name="sign_up" id="submit" value="Sign Up" class="btn bg-gradient-rose-button text-white"><i class='lni lni-user'></i>Sign up</button>
                                            </div>
                                        </div>
                                        <div style="display:none;" id="checkRef"><?=$checkRef?></div>
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


<script type="text/javascript">

    function sweetAlertSuccess()
    {
      Swal.fire({
          icon: 'success',
          title: 'Thank you!',
          backdrop: false,
          showConfirmButton: false,
          allowOutsideClick:false,
          backdrop:true,
          text: 'Your account has been created successfully please verify your email.',
          footer: '<a class="btn btn-success" href="login.php">Click here to login</a>'
        })

    }


    $(document).ready(function () {
        
        if($('#checkRef').text()== '1')
        {
            $('#uname').prop('readonly', true);

        }
        else
        {
            $('#uname').prop('readonly', false);
        }
        $('#validateMessage').hide();

        // $('#submit').click(function (e) {
        //     $sponserName = $('#uname').val();
        //     $fullName = $('#full-name').val();
        //     $country = $('#country').val();
        //     $mobileNumber = $('#mobileNumber').val();
        //     $email = $('#email').val();
        //     $password = $('#pass1').val();

        //     $termCheck = $('#flexSwitchCheckChecked').val();

        //     // alert($termCheck);

                


        //     if($sponserName=='')
        //     {
        //         $('#validateMessage').show();
        //         $('#validateMessage').text('Please Enter Sponser Name');
        //         $('#uname').css("border", "1px solid red");
        //         e.preventDefault();
        //     }
        //     else if($fullName=='')
        //     {
        //         $('#validateMessage').show();
        //         $('#validateMessage').text('Please Enter Full Name');
        //         $('#full-name').css("border", "1px solid red");
        //         e.preventDefault();
        //     }
        //      else if($email=='')
        //     {
        //         $('#validateMessage').show();
        //         $('#validateMessage').text('Please Enter Email');
        //         $('#email').css("border", "1px solid red");
        //         e.preventDefault();
        //     }
        //     else if($password=='')
        //     {
        //         $('#validateMessage').show();
        //         $('#validateMessage').text('Please Enter Password');
        //         $('#pass1').css("border", "1px solid red");
        //         e.preventDefault();
        //     }
        //     else if ($('#pass1').val().length < 8)
        //     {
        //          $('#validateMessage').show();
        //         $('#validateMessage').text('Your password length is short');
        //         $('#pass1').css("border", "1px solid red");
        //         e.preventDefault();
        //     }
        //     else if($country=='')
        //     {
        //         $('#validateMessage').show();
        //         $('#validateMessage').text('Please Select Country');
        //         $('#country').css("border", "1px solid red");
        //         e.preventDefault();
        //     }
        //     else if($mobileNumber=='')
        //     {
        //         $('#validateMessage').show();
        //         $('#validateMessage').text('Please Enter Mobile Number');
        //         $('#mobileNumber').css("border", "1px solid red");
        //         e.preventDefault();
        //     }
           
        //     else if( $('#flexSwitchCheckChecked').is(":checked"))
        //     {
                  
                  
        //           $.ajax({
        //           type: "POST",
        //           url: 'ajax/ajax-signup.php',
        //           data: {sponsor_name: $sponserName,full_name:$fullName,country_name:$country,mobile:$mobileNumber,email:$email,password:$password},
        //           success: function(data)
        //           {
        //               alert(data);
        //               $('#submit').prop('disabled', false);
        //               $('#submit').html("Sign up");
        //           },
        //           beforeSend: function()
        //           {
        //               $('#submit').prop('disabled', true);
        //               $('#submit').html("Processing...");
        //           }
                  
        //         });
                

        //     }
        //     else
        //     {
        //         $('#validateMessage').show();
        //         $('#validateMessage').text('Please accept our terms and conditions');
        //         e.preventDefault();
        //     }


        //     $(':input').keyup(function () {
        //         $('#validateMessage').hide();
        //         $('#uname').css("border","1px solid #dddddd");
        //         $('#full-name').css("border","1px solid #dddddd");
        //         $('#mobileNumber').css("border","1px solid #dddddd");
        //         $('#email').css("border","1px solid #dddddd");
        //         $('#pass1').css("border","1px solid #dddddd");
        //         e.preventDefault();
        //     });
        //     $('#country').change(function () {
        //         $('#country').css("border","1px solid #dddddd");
        //         $('#validateMessage').hide();
        //         e.preventDefault();

        //     });

        // });
        // $('#email').keyup(function () {
        //     var eml = $('#email').val();

        //     $.post("checkemail.php",{email:eml},function (feedback) {
        //         $('#emailError').html(feedback)
        //     })

        // });
        // $("#pass1").keyup(function() {
        //     if ($('#pass1').val()=='')
        //     {
        //         $('#strength').text('');
        //     }
        //     if ($('#pass1').val().length > 0)
        //     {
        //         $('#strength').text('(Minimum 8)');
        //         $('#strength').css('color','red');
        //     }
        //     if ($('#pass1').val().length > 8)
        //     {
        //         $('#strength').text('Weak Password');
        //         $('#strength').css('color','red');
        //     }
        //     if($('#pass1').val().length > 8 && $('#pass1').val().match(/([a-z].*[A-Z])|([A-Z].*[a-z])/))
        //     {
        //         $('#strength').text('Good Password');
        //         $('#strength').css('color','#ef9b0e');
        //     }
        //     if($('#pass1').val().length > 8 && $('#pass1').val().match(/([!,%,&,@,#,$,^,*,?,_,~])/))
        //     {
        //         $('#strength').text('Strong Password');
        //         $('#strength').css('color','#00a211');
        //     }
        // });
        
        
    });

//email check

  $("#email").keyup(function(){
      var email = $(this).val();
      
             $.post( "ajax/user_email_check.php",{email:email}, function( feedback ) {
        //   $( ".result" ).html( data );
                  $('#sponsorNameError').text(feedback);
             });
    })

//email check end



//country select start 
    $("#country").change(function(){
        var country = $(this).val();
        if (country!='') {
            $.ajax({
                url: "ajax/country.php?country="+country,
                success: function(result)
                {
                    if(result)
                    {
                        var array = result.split('|');
                        var a = array[0];
                        var b = array[1];
                        b=b.toLowerCase();
                        $("#countryCode").val(a);
                        var img="images/flags/"+b+".svg";
                        $('#flag').attr('src',img);
                        $('#mobileNumber').focus();

                    }
                }
            });
        }
    })
//country select end
    

     
</script>
<script>
    //Form Validator
 //alert Response
function alertResponse(alertMsg)
{
    response = alertMsg.slice(0,5);
    if(response =='Error')
    {
        
        alertMsg = alertMsg.slice(6);
        var alertDiv='<div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2"><div class="d-flex align-items-center"><div class="font-35 text-white"><i class="bx bxs-message-square-x"></i></div><div class="ms-3"><h6 class="mb-0 text-white">Error </h6><div class="text-white">'+alertMsg+'</div></div></div><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
        $('#alertMsg').html(alertDiv);
        setTimeout(function(){ $('#modalAlertMsg').html(''); }, 3000);
    }
    else if(response =='InfoF')
    {
        
        alertMsg = alertMsg.slice(6);
        var alertDiv='<div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2"><div class="d-flex align-items-center"><div class="font-35 text-white"><i class="bx bxs-message-square-x"></i></div><div class="ms-3"><h6 class="mb-0 text-white">Error </h6><div class="text-white">'+alertMsg+'</div></div></div><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
        $('#alertMsg').html(alertDiv);
        setTimeout(function(){ $('#modalAlertMsg').html(''); }, 3000);
    }
    else if(response =='InfoT')
    {
        
        alertMsg = alertMsg.slice(6);
        var alertDiv='<div class="alert alert-success border-0 bg-danger alert-dismissible fade show py-2"><div class="d-flex align-items-center"><div class="font-35 text-white"><i class="bx bxs-message-square-x"></i></div><div class="ms-3"><h6 class="mb-0 text-white">Error </h6><div class="text-white">'+alertMsg+'</div></div></div><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
        $('#alertMsg').html(alertDiv);
        setTimeout(function(){
            location.replace("index.php");
        }, 3000);
    }
    else
    {
    //   var alertDiv='<div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2"><div class="d-flex align-items-center"><div class="font-35 text-white"><i class="bx bxs-message-square-x"></i></div><div class="ms-3"><h6 class="mb-0 text-white">Success </h6><div class="text-white">'+alertMsg+'</div></div></div><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
    //     $('#alertMsg').html(alertDiv);
    //     setTimeout(function(){ $('#modalAlertMsg').html(''); }, 3000);
    
    $('#formSubmit').trigger("reset");
    sweetAlertSuccess();
    }
    
}         
            
$("#formSubmit").validate( {
			    
			   rules: {
					sponsor_name : {
					    required: true
					},
					full_name : {
					    required: true
					},
					email: {
						required: true,
						email: true
					},
					password : {
					    required: true
					},
				    country_name : {
				        required: true
				    },
				    phone: {
				        required: true
				    },
				    agree: {
                        required: true
                    }
				},
				messages: {
				    
				    sponsor_name: "Please enter sponsor name",
					full_name : "Please enter full name",
					password : "Please enter password",
					country_name : "Please select country",
					phone : "Please enter phone number",
				    email: {
						required: "Please provide email",
						email: "Please enter a valid email address"
					},
					agree : "Please accept terms and conditions"
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
				submitHandler: function (){
				   insertRecord(); 
				}
				
			} );
			
]			
	//insert record
function insertRecord()
{
    
    var sponsor_name = $("input[name='sponsor_name']").val();
    var full_name = $("input[name='full_name']").val();
    var email = $("input[name='email']").val();
    var password = $("input[name='password']").val();
    var country_name = $("select[name='country_name']").val();
    var phone = $("input[name='phone']").val();
    var insert_record = 'insertRecord';

    // alert(sponsor_name+full_name+email+password+country_name+phone+insert_record);

    $.ajax({
      url: "ajax/ajax-signup.php",
      type: "POST",
      data: {
            
            sponsor_name:sponsor_name,
            full_name:full_name,
            email:email,
            password:password,
            country_name:country_name,
            phone:phone,
            insert_record:insert_record
      },
      beforeSend: function() {
            $('#submit').text('Processing...');
            $("#submit").prop('disabled', true);
        },
      success: function(data,status){
            $('#submit').text('Sign Up');
            $("#submit").prop('disabled', false);
            alertResponse(data);
          },
      error: function () {
            alert("error");
            alert(status);
          }
          
    });
    
}


</script>

</body>


<!-- Mirrored from codervent.com/rocker/demo/vertical/authentication-signup.html by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 15 Aug 2021 08:50:22 GMT -->
</html>