<?php
session_start();


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
    
    <title>Forgot password</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="#" class="sign-in-form">
            <h2 class="title">Forgot Password</h2>
            <?php if(isset($_SESSION['successMsg'])): ?>
                <h5 id="removeMsg" class="successColor"><?php echo $_SESSION['successMsg']; ?> &nbsp;&nbsp;&nbsp; <a href="#" id="crossMsg" ><i class="errorColor fas fa-times-circle"></i></a></h5>
            <?php  unset($_SESSION['successMsg']);     endif;  ?>
            
            <?php if(isset($_SESSION['errorMsg'])): ?>
                <h5 id="removeMsg" class="errorColor"><?php echo $_SESSION['errorMsg']; ?> &nbsp;&nbsp;&nbsp; <a href="#" id="crossMsg" ><i class="errorColor fas fa-times-circle"></i></a></h5>
            <?php  unset($_SESSION['errorMsg']);     endif;  ?>
            
            
            <h5 class="errorColor" id="loginError"></h5>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" id="email" autocomplete="off" placeholder="Enter email" />
              <div class="errorMsg"></div>
            </div>
            <input type="submit" id="loginSubmit" value="Reset Password" class="btn solid" />
           
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
          <!--<img src="login-signup/img/log.svg" class="image" alt="" />-->
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
          text: 'Password link send successfully to your email',
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
        $('#email').val('');
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
 
 


  
  
  
//*************Login*****************
$('#loginSubmit').click(function(e)
{
    var email = $('#email');
    
    
    if(email.val() == '')
    {
        email.siblings(".errorMsg").html('Enter email');
        email.parent('.input-field').addClass('error');
         e.preventDefault();
    }
    else
    {
         $('#loginSubmit').val('Processing...');
         
        var email = $('#email').val();
             $.post( "ajax/ajax-forgot-password.php",{email:email}, function(feedback) {
                 
                      $('#loginSubmit').val('Reset Password');
                      alertResponse(feedback);
                        // alert(feedback);
                  
             });
        e.preventDefault();
    }
    
    // keyup functions
    email.on("keyup",function()
    {
        email.siblings(".errorMsg").html('');
        email.parent('.input-field').removeClass('error');
        $('#loginError').html('');
         e.preventDefault();
    })
    
    
})


</script>



