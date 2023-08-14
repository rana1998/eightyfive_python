<?php
include 'core/connection.php';

$getEmail = mysqli_real_escape_string($con,$_GET['email']);

if(isset($_GET['module']) && $_GET['module'] == "reset")
{
    $email = $_GET['email'];
    $code = $_GET['code'];
    
    $sql = "SELECT * FROM user_registration WHERE email= ? AND email_code = ?";
    
    $stmt = $con->prepare($sql); 
    $stmt->bind_param("ss", $email, $code);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    if($result->num_rows < 1)
    {
        $_SESSION['errorMsg'] = "Invalid Request.";
        header("Location: login.php");
        $stmt->close();
        exit();
     }
}            

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/64d58efce2.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="login-signup/static-page.css" />
    <link rel="stylesheet" href="login-signup/style.css" />
    
    <title>Reset Password</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="#" class="sign-in-form">
            <h2 class="title">Reset Password</h2>
            <?php if(isset($_SESSION['successMsg'])): ?>
                <h5 id="removeMsg" class="successColor"><?php echo $_SESSION['successMsg']; ?> &nbsp;&nbsp;&nbsp; <a href="#" id="crossMsg" ><i class="errorColor fas fa-times-circle"></i></a></h5>
            <?php  unset($_SESSION['successMsg']);     endif;  ?>
            
            <?php if(isset($_SESSION['errorMsg'])): ?>
                <h5 id="removeMsg" class="errorColor"><?php echo $_SESSION['errorMsg']; ?> &nbsp;&nbsp;&nbsp; <a href="#" id="crossMsg" ><i class="errorColor fas fa-times-circle"></i></a></h5>
            <?php  unset($_SESSION['errorMsg']);     endif;  ?>
            
            
            <h5 class="errorColor" id="loginError"></h5>
            <div class="input-field">
              <i  id="passwordLock" class="fas fa-lock"></i>
              <i  id="passwordEyeSlash" style="display:none;cursor:pointer;color:#5995fd" class='fas fa-eye-slash'></i>
              <i  id="passwordEye" style="display:none;cursor:pointer;color:#5995fd" class='fas fa-eye'></i>
              <input type="password" id="password1" autocomplete="off" placeholder="New Password" title="Min 8, Special Character, Integer, Upper Case"/>
              <div class="errorMsg"></div>
            </div>
             <div class="input-field">
              <i  id="passwordLock2" class="fas fa-lock"></i>
              <i  id="passwordEyeSlash2" style="display:none;cursor:pointer;color:#5995fd" class='fas fa-eye-slash'></i>
              <i  id="passwordEye2" style="display:none;cursor:pointer;color:#5995fd" class='fas fa-eye'></i>
              <input type="password" id="password2" autocomplete="off" placeholder="Confirm Password" title="Min 8, Special Character, Integer, Upper Case" />
              <div class="errorMsg"></div>
            </div>
            <input type="submit" id="submit" value="Update Password" class="btn solid" />
           
          </form>
          <form id="formSignUp" action="#" class="sign-up-form">
              </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Already Account</h3>
            <p>
              Use your Account and type the username and password to sign in privately.
            </p>
            <a href="login.php">
                <button class="btn transparent" id="">
              Sign In
            </button>
            </a>
          </div>
          <img src="login-signup/img/log.svg" class="image" alt="" />
        </div>
        
      </div>
    </div>

    <script src="login-signup/app.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  </body>
</html>



<script>
 
 //sweet alert success
 function sweetAlertSuccess()
    {
      Swal.fire({
          icon: 'success',
          title: 'Thank you!',
          backdrop: false,
          showConfirmButton: false,
          allowOutsideClick:false,
          backdrop:true,
          text: 'Password update successfully',
          footer: '<a style="text-decoration:none" href="login.php">Click here to login</a>'
        })

    }
 

  //alert Response
function alertResponse(alertMsg)
{
    
    // alert(alertMsg);
    response = alertMsg.slice(0,5);
    if(response =='Error')
    {
        
        alertMsg = alertMsg.slice(6);
        $('#loginError').text(alertMsg);
        setTimeout(function(){ $('#loginError').text(''); }, 3000);
    }
    else
    {
        // $('#loginError').text(response);
        $('#password1').val('');
        $('#password2').val('');
        sweetAlertSuccess();
    }
    
}         
  
 
 
 
 
 
 
 
 //remove message
$('#crossMsg').click(function()
{
    $('#removeMsg').html('');    
})

 $('#check').click(function()
 {
     $('#loginError').text(''); 
 })
 
 
 
//login password visibility with eye code start
$('#password2').on('focus',function()
{
    $('#passwordLock2').hide();
  
    if($('#password2').attr('type')== 'password')
    {
        $('#passwordEyeSlash2').show();
        $('#passwordEye2').hide();
    }
    else if($('#password2').attr('type')== 'text')
    {
        $('#passwordEyeSlash2').hide();
        $('#passwordEye2').show();

    }
}) 
//show password
$('#passwordEyeSlash2').click(function(event){
    
    $('#passwordEyeSlash2').hide();
    $('#passwordEye2').show();
     $('#password2').attr('type', 'text');
})
//hide password
$('#passwordEye2').click(function(event){
    
    $('#passwordEyeSlash2').show();
    $('#passwordEye2').hide();
    $('#password2').attr('type', 'password');
})
 
//login password visibility with eye code end 
 
 


//sign up password visibility with eye code start
$('#password1').on('focus',function()
{
    $('#passwordLock').hide();
  
    if($('#password1').attr('type')== 'password')
    {
        $('#passwordEyeSlash').show();
        $('#passwordEye').hide();
    }
    else if($('#password1').attr('type')== 'text')
    {
        $('#passwordEyeSlash').hide();
        $('#passwordEye').show();

    }
}) 
//show password
$('#passwordEyeSlash').click(function(event){
    
    $('#passwordEyeSlash').hide();
    $('#passwordEye').show();
     $('#password1').attr('type', 'text');
})
//hide password
$('#passwordEye').click(function(event){
    
    $('#passwordEyeSlash').show();
    $('#passwordEye').hide();
    $('#password1').attr('type', 'password');
})
 
//signup password visibility with eye code end 

 
 


  
  
  
//*************Login*****************
$('#submit').click(function(e)
{
    var password1 = $('#password1');
    var password2 = $('#password2');
    
    //check special character include or not
    var Specialchar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
     //check number include or not in string
    var hasNumber = /\d/;
     
    var checkUpcase = /[A-Z]/;
    
    if(password1.val() == '')
    {
        password1.siblings(".errorMsg").html('Enter password');
        password1.parent('.input-field').addClass('error');
         e.preventDefault();
    }
     else if(password1.val().length < 8)
    {
        password1.siblings(".errorMsg").html('Minimum 8 length');
        password1.parent('.input-field').addClass('error');
        e.preventDefault();
    }
    else if(Specialchar.test(password1.val()) == false)
    {
        password1.siblings(".errorMsg").html('Include Special character e.g ($,@,#)');
        password1.parent('.input-field').addClass('error');
        e.preventDefault();
    }
    else if(hasNumber.test(password1.val()) == false)
    {
        password1.siblings(".errorMsg").html('Include Integer e.g (1,2,3)');
        password1.parent('.input-field').addClass('error');
        e.preventDefault();
    }
    else if(checkUpcase.test(password1.val()) == false)
    {
        password1.siblings(".errorMsg").html('Include Upper Case letter e.g (A,B,C)');
        password1.parent('.input-field').addClass('error');
        e.preventDefault();
    }
    else if(password2.val() == '')
    {
        password2.siblings(".errorMsg").html('Confirm password');
        password2.parent('.input-field').addClass('error');
         e.preventDefault();
    }
    else if(password1.val() != password2.val())
    {
        $('#loginError').text('Password not match');
        
        password1.parent('.input-field').addClass('error');
        password2.parent('.input-field').addClass('error');
         e.preventDefault();
         
    }
    else
    {
         $('#submit').val('Processing...');
         
        var password1 = $('#password1').val();
        var password2 = $('#password2').val();
        var email = '<?=$getEmail?>';
             $.post( "ajax/ajax-reset-password.php",{password1:password1,password2:password2,email:email}, function(feedback) {
                 
                      $('#loginSubmit').val('Reset Password');
                      alertResponse(feedback);
                        // alert(feedback);
                  
             });
        e.preventDefault();
    }
    
    // keyup functions
    password1.on("keyup",function()
    {
        password1.siblings(".errorMsg").html('');
        password1.parent('.input-field').removeClass('error');
        $('#loginError').html('');
         e.preventDefault();
    })
    
    password2.on("keyup",function()
    {
        password2.siblings(".errorMsg").html('');
        password2.parent('.input-field').removeClass('error');
        $('#loginError').html('');
         e.preventDefault();
    })
    
    
})


</script>



