<?php
session_start();
$page_title = "Secure Account";

if(isset($_SESSION['email_verify'])){
$user_email = $_SESSION['email_verify'];
}
else{
    $_SESSION['errorMsg'] = "Invalid Request.";
    header("Location: login.php");
    exit();
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
    
    <title>Security</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="#" class="sign-in-form">
            <h2 class="title">Security</h2>
            <?php if(isset($_SESSION['successMsg'])): ?>
                <h5 id="removeMsg" class="successColor"><?php echo $_SESSION['successMsg']; ?> &nbsp;&nbsp;&nbsp; <a href="#" id="crossMsg" ><i class="errorColor fas fa-times-circle"></i></a></h5>
            <?php  unset($_SESSION['successMsg']);     endif;  ?>
            
            <?php if(isset($_SESSION['errorMsg'])): ?>
                <h5 id="removeMsg" class="errorColor"><?php echo $_SESSION['errorMsg']; ?> &nbsp;&nbsp;&nbsp; <a href="#" id="crossMsg" ><i class="errorColor fas fa-times-circle"></i></a></h5>
            <?php  unset($_SESSION['errorMsg']);     endif;  ?>
            
            
            <h5 class="errorColor" id="loginError"></h5>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" id="loginPassword" placeholder="New Password" />
              <div class="errorMsg"></div>
            </div>
            <div class="input-field">
              <i class="fas fa-key"></i>
              <input type="text" id="otp" autocomplete="off" placeholder="OTP" />
              <div class="errorMsg"></div>
            </div>
            <div class="input-group">
                <span class="emailMessageAjax" style="font-size:14px;color:green"></span> &nbsp;&nbsp;&nbsp;
                <div style="height:30px;font-size:12px;width:110px;text-align:center;padding-top:5px;background:#36b37e" class="btn solid sendOtpEmail">SEND CODE</div>
            </div>
            <input type="submit" id="loginSubmit" value="Update" class="btn solid" />
           
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
    $( document ).ready(function() {

    $(".sendOtpEmail").click(function(){
    
        var sendMail = 'Email Send';
       
        $.post("ajax/otp_generator.php",{otp_send:sendMail},function(feedback){
            // alert(feedback);
            $('.emailMessageAjax').text(feedback);
            $(".sendOtpEmail").prop('disabled', false);
            $(".sendOtpEmail").text('SEND CODE');
        })
        
        $(".sendOtpEmail").prop('disabled', true);
        $(".sendOtpEmail").text('Processing...');
        //  alert("button work");
    })
  
   
});
</script>


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
          text: 'Password Changed Successfully. Now you can login.',
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
        $('#otp').val('');
        $('#loginPassword').val('');
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
    var otp = $('#otp');
    var loginPassword = $('#loginPassword');
    
    
    if(loginPassword.val() == '')
    {
        loginPassword.siblings(".errorMsg").html('Please Enter password');
        loginPassword.parent('.input-field').addClass('error');
        e.preventDefault();
    }
    else if(otp.val() == '')
    {
        otp.siblings(".errorMsg").html('Enter OTP code');
        otp.parent('.input-field').addClass('error');
         e.preventDefault();
    }
    else
    {
         $('#loginSubmit').val('Processing...');
         
        var otp = $('#otp').val();
        var loginPassword = $('#loginPassword').val();
   
             $.post( "ajax/ajax-sflag.php",{otp:otp,loginPassword:loginPassword}, function(feedback) {
                 
                      $('#loginSubmit').val('Update');
                      alertResponse(feedback);
                 
                  
             });
        e.preventDefault();
    }
    
    // keyup functions
    otp.on("keyup",function()
    {
        otp.siblings(".errorMsg").html('');
        otp.parent('.input-field').removeClass('error');
        $('#loginError').html('');
         e.preventDefault();
    })
    loginPassword.on("keyup",function()
    {
        loginPassword.siblings(".errorMsg").html('');
        loginPassword.parent('.input-field').removeClass('error');
        $('#loginError').html('');
         e.preventDefault();
    })
    
    
})


</script>



