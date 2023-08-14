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
    <link rel="stylesheet" href="login-signup/style.css" />
    
    <title>Sign in & Sign up</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="#" class="sign-in-form">
            <h2 class="title">Sign in</h2>
            <?php if(isset($_SESSION['successMsg'])): ?>
                <h5 id="removeMsg" class="successColor"><?php echo $_SESSION['successMsg']; ?> &nbsp;&nbsp;&nbsp; <a href="#" id="crossMsg" ><i class="errorColor fas fa-times-circle"></i></a></h5>
            <?php  unset($_SESSION['successMsg']);     endif;  ?>
            
            <?php if(isset($_SESSION['errorMsg'])): ?>
                <h5 id="removeMsg" class="errorColor"><?php echo $_SESSION['errorMsg']; ?> &nbsp;&nbsp;&nbsp; <a href="#" id="crossMsg" ><i class="errorColor fas fa-times-circle"></i></a></h5>
            <?php  unset($_SESSION['errorMsg']);     endif;  ?>
            
            
            <h5 class="errorColor" id="loginError"></h5>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" id="loginUsername" placeholder="Username" />
              <div class="errorMsg"></div>
            </div>
            <div class="input-field">
              <i  id="passwordLock2" class="fas fa-lock"></i>
              <i  id="passwordEyeSlash2" style="display:none;cursor:pointer;color:#5995fd" class='fas fa-eye-slash'></i>
              <i  id="passwordEye2" style="display:none;cursor:pointer;color:#5995fd" class='fas fa-eye'></i>
              <input type="password" id="loginPassword" placeholder="Password" />
              <div class="errorMsg"></div>
            </div>
            <input type="submit" id="loginSubmit" value="Login" class="btn solid" />
            <a class="social-text" href="forgot-password.php">Forgot Password?</a>
           
          </form>
           
          <form id="formSignUp" action="#" class="sign-up-form">
            <h2 class="title">Sign up</h2>
            <h5 class="errorColor" id="signupError"></h5>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" id="sponsor_name" name="sponsor_name" autocomplete="off" value="master" placeholder="Sponsor Id" />
              <div id="sponsorError" class="errorMsg"></div>
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" id="username" name="username" autocomplete="off" placeholder="Username" />
              <div id="usernameError" class="errorMsg"></div>
            </div>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" id="full_name" name="full_name" autocomplete="off" placeholder="Full Name" />
              <div id="fullNameError" class="errorMsg"></div>
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" id="email" name="email" autocomplete="off" placeholder="Email" />
              <div id="emailError" class="errorMsg"></div>
            </div>
            <div class="input-field">
              <i id="passwordLock" class="fas fa-lock"></i>
              <i  id="passwordEyeSlash" style="display:none;cursor:pointer;color:#5995fd" class='fas fa-eye-slash'></i>
              <i  id="passwordEye" style="display:none;cursor:pointer;color:#5995fd" class='fas fa-eye'></i>
              <input autocomplete="off" type="password" id="password" name="password" placeholder="Password" title="Min 8, Special Character, Integer, Upper Case"/>
              <div class="errorMsg"></div>
            </div>
            <div class="input-field">
              <i><img id="flag" height="30px" width="30px" style="padding-top:7px" src="http://GTRON.com/member/images/flags/flag.png"></i>
              <select id="country_name" name="country_name"  >
                <option value="">Select Country</option>
                <option value="AFGHANISTAN">AFGHANISTAN</option>
                <option value="ALBANIA">ALBANIA</option>
                <option value="ALGERIA">ALGERIA</option>
                <option value="AMERICAN SAMOA">AMERICAN SAMOA</option>
                <option value="ANDORRA">ANDORRA</option>
                <option value="ANGOLA">ANGOLA</option>
                <option value="ANGUILLA">ANGUILLA</option>
                <option value="ANTARCTICA">ANTARCTICA</option>
                <option value="ANTIGUA AND BARBUDA">ANTIGUA AND BARBUDA</option>
                <option value="ARGENTINA">ARGENTINA</option>
                <option value="ARMENIA">ARMENIA</option>
                <option value="ARUBA">ARUBA</option>
                <option value="AUSTRALIA">AUSTRALIA</option>
                <option value="AUSTRIA">AUSTRIA</option>
                <option value="AZERBAIJAN">AZERBAIJAN</option>
                <option value="BAHAMAS">BAHAMAS</option>
                <option value="BAHRAIN">BAHRAIN</option>
                <option value="BANGLADESH">BANGLADESH</option>
                <option value="BARBADOS">BARBADOS</option>
                <option value="BELARUS">BELARUS</option>
                <option value="BELGIUM">BELGIUM</option>
                <option value="BELIZE">BELIZE</option>
                <option value="BENIN">BENIN</option>
                <option value="BERMUDA">BERMUDA</option>
                <option value="BHUTAN">BHUTAN</option>
                <option value="BOLIVIA">BOLIVIA</option>
                <option value="BOSNIA AND HERZEGOVINA">BOSNIA AND HERZEGOVINA</option>
                <option value="BOTSWANA">BOTSWANA</option>
                <option value="BOUVET ISLAND">BOUVET ISLAND</option>
                <option value="BRAZIL">BRAZIL</option>
                <option value="BRITISH INDIAN OCEAN TERRITORY">BRITISH INDIAN OCEAN TERRITORY</option>
                <option value="BRUNEI DARUSSALAM">BRUNEI DARUSSALAM</option>
                <option value="BULGARIA">BULGARIA</option>
                <option value="BURKINA FASO">BURKINA FASO</option>
                <option value="BURUNDI">BURUNDI</option>
                <option value="CAMBODIA">CAMBODIA</option>
                <option value="CAMEROON">CAMEROON</option>
                <option value="CANADA">CANADA</option>
                <option value="CAPE VERDE">CAPE VERDE</option>
                <option value="CAYMAN ISLANDS">CAYMAN ISLANDS</option>
                <option value="CENTRAL AFRICAN REPUBLIC">CENTRAL AFRICAN REPUBLIC</option>
                <option value="CHAD">CHAD</option>
                <option value="CHILE">CHILE</option>
                <option value="CHINA">CHINA</option>
                <option value="CHRISTMAS ISLAND">CHRISTMAS ISLAND</option>
                <option value="COCOS (KEELING) ISLANDS">COCOS (KEELING) ISLANDS</option>
                <option value="COLOMBIA">COLOMBIA</option>
                <option value="COMOROS">COMOROS</option>
                <option value="CONGO">CONGO</option>
                <option value="CONGO, THE DEMOCRATIC REPUBLIC OF THE">CONGO, THE DEMOCRATIC REPUBLIC OF THE</option>
                <option value="COOK ISLANDS">COOK ISLANDS</option>
                <option value="COSTA RICA">COSTA RICA</option>
                <option value="COTE D'IVOIRE">COTE D'IVOIRE</option>
                <option value="CROATIA">CROATIA</option>
                <option value="CUBA">CUBA</option>
                <option value="CYPRUS">CYPRUS</option>
                <option value="CZECH REPUBLIC">CZECH REPUBLIC</option>
                <option value="DENMARK">DENMARK</option>
                <option value="DJIBOUTI">DJIBOUTI</option>
                <option value="DOMINICA">DOMINICA</option>
                <option value="DOMINICAN REPUBLIC">DOMINICAN REPUBLIC</option>
                <option value="ECUADOR">ECUADOR</option>
                <option value="EGYPT">EGYPT</option>
                <option value="EL SALVADOR">EL SALVADOR</option>
                <option value="EQUATORIAL GUINEA">EQUATORIAL GUINEA</option>
                <option value="ERITREA">ERITREA</option>
                <option value="ESTONIA">ESTONIA</option>
                <option value="ETHIOPIA">ETHIOPIA</option>
                <option value="FALKLAND ISLANDS (MALVINAS)">FALKLAND ISLANDS (MALVINAS)</option>
                <option value="FAROE ISLANDS">FAROE ISLANDS</option>
                <option value="FIJI">FIJI</option>
                <option value="FINLAND">FINLAND</option>
                <option value="FRANCE">FRANCE</option>
                <option value="FRENCH GUIANA">FRENCH GUIANA</option>
                <option value="FRENCH POLYNESIA">FRENCH POLYNESIA</option>
                <option value="FRENCH SOUTHERN TERRITORIES">FRENCH SOUTHERN TERRITORIES</option>
                <option value="GABON">GABON</option>
                <option value="GAMBIA">GAMBIA</option>
                <option value="GEORGIA">GEORGIA</option>
                <option value="GERMANY">GERMANY</option>
                <option value="GHANA">GHANA</option>
                <option value="GIBRALTAR">GIBRALTAR</option>
                <option value="GREECE">GREECE</option>
                <option value="GREENLAND">GREENLAND</option>
                <option value="GRENADA">GRENADA</option>
                <option value="GUADELOUPE">GUADELOUPE</option>
                <option value="GUAM">GUAM</option>
                <option value="GUATEMALA">GUATEMALA</option>
                <option value="GUINEA">GUINEA</option>
                <option value="GUINEA-BISSAU">GUINEA-BISSAU</option>
                <option value="GUYANA">GUYANA</option>
                <option value="HAITI">HAITI</option>
                <option value="HEARD ISLAND AND MCDONALD ISLANDS">HEARD ISLAND AND MCDONALD ISLANDS</option>
                <option value="HOLY SEE (VATICAN CITY STATE)">HOLY SEE (VATICAN CITY STATE)</option>
                <option value="HONDURAS">HONDURAS</option>
                <option value="HONG KONG">HONG KONG</option>
                <option value="HUNGARY">HUNGARY</option>
                <option value="ICELAND">ICELAND</option>
                <option value="INDIA">INDIA</option>
                <option value="INDONESIA">INDONESIA</option>
                <option value="IRAN, ISLAMIC REPUBLIC OF">IRAN, ISLAMIC REPUBLIC OF</option>
                <option value="IRAQ">IRAQ</option>
                <option value="IRELAND">IRELAND</option>
                <option value="ISRAEL">ISRAEL</option>
                <option value="ITALY">ITALY</option>
                <option value="JAMAICA">JAMAICA</option>
                <option value="JAPAN">JAPAN</option>
                <option value="JORDAN">JORDAN</option>
                <option value="KAZAKHSTAN">KAZAKHSTAN</option>
                <option value="KENYA">KENYA</option>
                <option value="KIRIBATI">KIRIBATI</option>
                <option value="KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF">KOREA, DEMOCRATIC PEOPLE'S REPUBLIC OF</option>
                <option value="KOREA, REPUBLIC OF">KOREA, REPUBLIC OF</option>
                <option value="KUWAIT">KUWAIT</option>
                <option value="KYRGYZSTAN">KYRGYZSTAN</option>
                <option value="LAO PEOPLE'S DEMOCRATIC REPUBLIC">LAO PEOPLE'S DEMOCRATIC REPUBLIC</option>
                <option value="LATVIA">LATVIA</option>
                <option value="LEBANON">LEBANON</option>
                <option value="LESOTHO">LESOTHO</option>
                <option value="LIBERIA">LIBERIA</option>
                <option value="LIBYAN ARAB JAMAHIRIYA">LIBYAN ARAB JAMAHIRIYA</option>
                <option value="LIECHTENSTEIN">LIECHTENSTEIN</option>
                <option value="LITHUANIA">LITHUANIA</option>
                <option value="LUXEMBOURG">LUXEMBOURG</option>
                <option value="MACAO">MACAO</option>
                <option value="MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF">MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF</option>
                <option value="MADAGASCAR">MADAGASCAR</option>
                <option value="MALAWI">MALAWI</option>
                <option value="MALAYSIA">MALAYSIA</option>
                <option value="MALDIVES">MALDIVES</option>
                <option value="MALI">MALI</option>
                <option value="MALTA">MALTA</option>
                <option value="MARSHALL ISLANDS">MARSHALL ISLANDS</option>
                <option value="MARTINIQUE">MARTINIQUE</option>
                <option value="MAURITANIA">MAURITANIA</option>
                <option value="MAURITIUS">MAURITIUS</option>
                <option value="MAYOTTE">MAYOTTE</option>
                <option value="MEXICO">MEXICO</option>
                <option value="MICRONESIA, FEDERATED STATES OF">MICRONESIA, FEDERATED STATES OF</option>
                <option value="MOLDOVA, REPUBLIC OF">MOLDOVA, REPUBLIC OF</option>
                <option value="MONACO">MONACO</option>
                <option value="MONGOLIA">MONGOLIA</option>
                <option value="MONTSERRAT">MONTSERRAT</option>
                <option value="MOROCCO">MOROCCO</option>
                <option value="MOZAMBIQUE">MOZAMBIQUE</option>
                <option value="MYANMAR">MYANMAR</option>
                <option value="NAMIBIA">NAMIBIA</option>
                <option value="NAURU">NAURU</option>
                <option value="NEPAL">NEPAL</option>
                <option value="NETHERLANDS">NETHERLANDS</option>
                <option value="NETHERLANDS ANTILLES">NETHERLANDS ANTILLES</option>
                <option value="NEW CALEDONIA">NEW CALEDONIA</option>
                <option value="NEW ZEALAND">NEW ZEALAND</option>
                <option value="NICARAGUA">NICARAGUA</option>
                <option value="NIGER">NIGER</option>
                <option value="NIGERIA">NIGERIA</option>
                <option value="NIUE">NIUE</option>
                <option value="NORFOLK ISLAND">NORFOLK ISLAND</option>
                <option value="NORTHERN MARIANA ISLANDS">NORTHERN MARIANA ISLANDS</option>
                <option value="NORWAY">NORWAY</option>
                <option value="OMAN">OMAN</option>
                <option value="PAKISTAN">PAKISTAN</option>
                <option value="PALAU">PALAU</option>
                <option value="PALESTINIAN TERRITORY, OCCUPIED">PALESTINIAN TERRITORY, OCCUPIED</option>
                <option value="PANAMA">PANAMA</option>
                <option value="PAPUA NEW GUINEA">PAPUA NEW GUINEA</option>
                <option value="PARAGUAY">PARAGUAY</option>
                <option value="PERU">PERU</option>
                <option value="PHILIPPINES">PHILIPPINES</option>
                <option value="PITCAIRN">PITCAIRN</option>
                <option value="POLAND">POLAND</option>
                <option value="PORTUGAL">PORTUGAL</option>
                <option value="PUERTO RICO">PUERTO RICO</option>
                <option value="QATAR">QATAR</option>
                <option value="REUNION">REUNION</option>
                <option value="ROMANIA">ROMANIA</option>
                <option value="RUSSIAN FEDERATION">RUSSIAN FEDERATION</option>
                <option value="RWANDA">RWANDA</option>
                <option value="SAINT HELENA">SAINT HELENA</option>
                <option value="SAINT KITTS AND NEVIS">SAINT KITTS AND NEVIS</option>
                <option value="SAINT LUCIA">SAINT LUCIA</option>
                <option value="SAINT PIERRE AND MIQUELON">SAINT PIERRE AND MIQUELON</option>
                <option value="SAINT VINCENT AND THE GRENADINES">SAINT VINCENT AND THE GRENADINES</option>
                <option value="SAMOA">SAMOA</option>
                <option value="SAN MARINO">SAN MARINO</option>
                <option value="SAO TOME AND PRINCIPE">SAO TOME AND PRINCIPE</option>
                <option value="SAUDI ARABIA">SAUDI ARABIA</option>
                <option value="SENEGAL">SENEGAL</option>
                <option value="SERBIA AND MONTENEGRO">SERBIA AND MONTENEGRO</option>
                <option value="SEYCHELLES">SEYCHELLES</option>
                <option value="SIERRA LEONE">SIERRA LEONE</option>
                <option value="SINGAPORE">SINGAPORE</option>
                <option value="SLOVAKIA">SLOVAKIA</option>
                <option value="SLOVENIA">SLOVENIA</option>
                <option value="SOLOMON ISLANDS">SOLOMON ISLANDS</option>
                <option value="SOMALIA">SOMALIA</option>
                <option value="SOUTH AFRICA">SOUTH AFRICA</option>
                <option value="SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS">SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS</option>
                <option value="SPAIN">SPAIN</option>
                <option value="SRI LANKA">SRI LANKA</option>
                <option value="SUDAN">SUDAN</option>
                <option value="SURINAME">SURINAME</option>
                <option value="SVALBARD AND JAN MAYEN">SVALBARD AND JAN MAYEN</option>
                <option value="SWAZILAND">SWAZILAND</option>
                <option value="SWEDEN">SWEDEN</option>
                <option value="SWITZERLAND">SWITZERLAND</option>
                <option value="SYRIAN ARAB REPUBLIC">SYRIAN ARAB REPUBLIC</option>
                <option value="TAIWAN, PROVINCE OF CHINA">TAIWAN, PROVINCE OF CHINA</option>
                <option value="TAJIKISTAN">TAJIKISTAN</option>
                <option value="TANZANIA, UNITED REPUBLIC OF">TANZANIA, UNITED REPUBLIC OF</option>
                <option value="THAILAND">THAILAND</option>
                <option value="TIMOR-LESTE">TIMOR-LESTE</option>
                <option value="TOGO">TOGO</option>
                <option value="TOKELAU">TOKELAU</option>
                <option value="TONGA">TONGA</option>
                <option value="TRINIDAD AND TOBAGO">TRINIDAD AND TOBAGO</option>
                <option value="TUNISIA">TUNISIA</option>
                <option value="TURKEY">TURKEY</option>
                <option value="TURKMENISTAN">TURKMENISTAN</option>
                <option value="TURKS AND CAICOS ISLANDS">TURKS AND CAICOS ISLANDS</option>
                <option value="TUVALU">TUVALU</option>
                <option value="UGANDA">UGANDA</option>
                <option value="UKRAINE">UKRAINE</option>
                <option value="UNITED ARAB EMIRATES">UNITED ARAB EMIRATES</option>
                <option value="UNITED KINGDOM">UNITED KINGDOM</option>
                <option value="UNITED STATES">UNITED STATES</option>
                <option value="UNITED STATES MINOR OUTLYING ISLANDS">UNITED STATES MINOR OUTLYING ISLANDS</option>
                <option value="URUGUAY">URUGUAY</option>
                <option value="UZBEKISTAN">UZBEKISTAN</option>
                <option value="VANUATU">VANUATU</option>
                <option value="VENEZUELA">VENEZUELA</option>
                <option value="VIET NAM">VIET NAM</option>
                <option value="VIRGIN ISLANDS, BRITISH">VIRGIN ISLANDS, BRITISH</option>
                <option value="VIRGIN ISLANDS, U.S.">VIRGIN ISLANDS, U.S.</option>
                <option value="WALLIS AND FUTUNA">WALLIS AND FUTUNA</option>
                <option value="WESTERN SAHARA">WESTERN SAHARA</option>
                <option value="YEMEN">YEMEN</option>
                <option value="ZAMBIA">ZAMBIA</option>
                <option value="ZIMBABWE">ZIMBABWE</option>
              </select>
              <div class="errorMsg"></div>
            </div>
            <p class="social-text"><input id="check" type="checkbox" name="agree"> I read and agree to Terms & Conditions</p>
            <input name="sign_up" id="submit" type="button" class="btn" value="Sign up" />
            
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Register Now</h3>
            <p>
              If you are not member of this website then create your account for successfull login
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <!--<img src="login-signup/img/log.svg" class="image" alt="" />-->
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>Already Account</h3>
            <p>
              Use your Account and type the username and password to sign in privately.

            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <!--<img src="login-signup/img/register.svg" class="image" alt="" />-->
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
          text: 'Your account has been created successfully please verify your email.',
          footer: '<a style="text-decoration:none" href="login.php">Click here to login</a>'
        })

    }

 
  //alert Response
function alertResponse(alertMsg)
{
    response = alertMsg.slice(0,5);
    if(response =='Error')
    {
        
        alertMsg = alertMsg.slice(6);
        $('#signupError').text(alertMsg);
        setTimeout(function(){ $('#signupError').text(''); }, 3000);
    }
    else
    {
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
     $('#signupError').text(''); 
 })
 
 
 
 
//login password visibility with eye code start
$('#loginPassword').on('focus',function()
{
    $('#passwordLock2').hide();
  
    if($('#loginPassword').attr('type')== 'password')
    {
        $('#passwordEyeSlash2').show();
        $('#passwordEye2').hide();
    }
    else if($('#loginPassword').attr('type')== 'text')
    {
        $('#passwordEyeSlash2').hide();
        $('#passwordEye2').show();

    }
}) 
//show password
$('#passwordEyeSlash2').click(function(event){
    
    $('#passwordEyeSlash2').hide();
    $('#passwordEye2').show();
     $('#loginPassword').attr('type', 'text');
})
//hide password
$('#passwordEye2').click(function(event){
    
    $('#passwordEyeSlash2').show();
    $('#passwordEye2').hide();
    $('#loginPassword').attr('type', 'password');
})
 
//login password visibility with eye code end 
 
 


//sign up password visibility with eye code start
$('#password').on('focus',function()
{
    $('#passwordLock').hide();
  
    if($('#password').attr('type')== 'password')
    {
        $('#passwordEyeSlash').show();
        $('#passwordEye').hide();
    }
    else if($('#password').attr('type')== 'text')
    {
        $('#passwordEyeSlash').hide();
        $('#passwordEye').show();

    }
}) 
//show password
$('#passwordEyeSlash').click(function(event){
    
    $('#passwordEyeSlash').hide();
    $('#passwordEye').show();
     $('#password').attr('type', 'text');
})
//hide password
$('#passwordEye').click(function(event){
    
    $('#passwordEyeSlash').show();
    $('#passwordEye').hide();
    $('#password').attr('type', 'password');
})
 
//signup password visibility with eye code end 

 
 
 
 
  
//*************sign up*****************

$('#submit').click(function(e)
{
     
    var sponsorName = $("#sponsor_name");
    var username = $('#username');
    var fullName = $('#full_name');
    var email = $('#email');
    var password = $('#password');
    var countryName = $('#country_name');
    
    //check special character include or not
    var Specialchar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
     //check number include or not in string
    var hasNumber = /\d/;
     
    var checkUpcase = /[A-Z]/;
    
    
    if(sponsorName.val() == '')
    {
        sponsorName.siblings(".errorMsg").html('Please enter sponsor name');
        sponsorName.parent('.input-field').addClass('error');
         e.preventDefault();
    }
    else if(username.val() == '')
    {
        username.siblings(".errorMsg").html('Please enter username');
        username.parent('.input-field').addClass('error');
         e.preventDefault();
    }
    else if(fullName.val() == '')
    {
        fullName.siblings(".errorMsg").html('Please enter full name');
        fullName.parent('.input-field').addClass('error');
         e.preventDefault();
    }
    else if(email.val() == '')
    {
        email.siblings(".errorMsg").html('Please enter email');
        email.parent('.input-field').addClass('error');
        e.preventDefault();
    }
    else if(password.val() == '')
    {
        password.siblings(".errorMsg").html('Please enter password');
        password.parent('.input-field').addClass('error');
         e.preventDefault();
    }
    else if(password.val().length < 8)
    {
        password.siblings(".errorMsg").html('Minimum 8 length');
        password.parent('.input-field').addClass('error');
        e.preventDefault();
    }
    else if(Specialchar.test(password.val()) == false)
    {
        password.siblings(".errorMsg").html('Include Special character e.g ($,@,#)');
        password.parent('.input-field').addClass('error');
        e.preventDefault();
    }
    else if(hasNumber.test(password.val()) == false)
    {
        password.siblings(".errorMsg").html('Include Integer e.g (1,2,3)');
        password.parent('.input-field').addClass('error');
        e.preventDefault();
    }
    else if(checkUpcase.test(password.val()) == false)
    {
        password.siblings(".errorMsg").html('Include Upper Case letter e.g (A,B,C)');
        password.parent('.input-field').addClass('error');
        e.preventDefault();
    }
    else if(countryName.val() == '')
    {
        countryName.siblings(".errorMsg").html('Please select country');
        countryName.parent('.input-field').addClass('error');
         e.preventDefault();
    }
    else if( $('#check').is(":checked"))
    {
            $.ajax({
                      url: "ajax/ajax-signup.php",
                      type: "POST",
                      data: {
                            
                            sponsor_name:sponsorName.val(),
                            username:username.val(),
                            full_name:fullName.val(),
                            email:email.val(),
                            password:password.val(),
                            country_name:countryName.val()
                      },
                      beforeSend: function() {
                            $('#submit').val('Processing...');
                            $("#submit").prop('disabled', true);
                            e.preventDefault();
                        },
                      success: function(data,status){
                            $('#submit').val('Sign Up');
                            $("#submit").prop('disabled', false);
                            alertResponse(data);
                            e.preventDefault();
                          },
                      error: function () {
                            alert("error");
                            alert(status);
                          }
                          
                    });     
    //   e.preventDefault();
    }
    else
    {
        $('#signupError').text('Please accept our terms and conditions');
        e.preventDefault();
    }
    
    
    
    
    
    // keyup functions
    sponsorName.on("keyup",function()
    {
        sponsorName.siblings(".errorMsg").html('');
        sponsorName.parent('.input-field').removeClass('error');
         e.preventDefault();
    })
    username.on("keyup",function()
    {
        username.siblings(".errorMsg").html('');
        username.parent('.input-field').removeClass('error');
         e.preventDefault();
    })
    fullName.on("keyup",function()
    {
        fullName.siblings(".errorMsg").html('');
        fullName.parent('.input-field').removeClass('error');
         e.preventDefault();
    })
    email.on("keyup",function()
    {
        email.siblings(".errorMsg").html('');
        email.parent('.input-field').removeClass('error');
         e.preventDefault();
    })
    password.on("keyup",function()
    {
        password.siblings(".errorMsg").html('');
        password.parent('.input-field').removeClass('error');
        e.preventDefault();
    })
    countryName.on("change",function()
    {
        countryName.siblings(".errorMsg").html('');
        countryName.parent('.input-field').removeClass('error');
         e.preventDefault();
    })
    
    
   
})  
  
  
//resend email
function resendEmail()
{
    
    // alert('email');
    $('#loginError').html('Email Processing...');
     $.post( "ajax/resend-verification-email.php",{resend_verification:'email'}, function(feedback) {
                  $('#loginError').css('color','green');
                    $('#loginError').html(feedback);
    });
    
    
    //  $.ajax({
    //           url: "ajax/resend-verification-email.php",
    //           type: "POST",
    //           data: {
    //                 resend_verification:'email';
    //           },
    //           beforeSend: function() {
    //                 $('#loginError').css('color','green');
    //                 $('#loginError').html('Processing...');
    //             },
    //           success: function(feedback,status){
    //                 $('#loginError').css('color','green');
    //                 $('#loginError').html(feedback);
    //               },
    //           error: function () {
    //                 alert("error");
    //                 alert(status);
    //               }
                  
    //         });
}
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  
//country select start 
    $("#country_name").change(function(){
        var countryName = $("#country_name").val();
     
        if (countryName!='') {
            $.ajax({
                url: "ajax/country.php?country="+countryName,
                success: function(result)
                {
                    if(result)
                    {
                        var array = result.split('|');
                        var a = array[0];
                        var b = array[1];
                        b=b.toLowerCase();
                        // $("#countryCode").val(a);
                        var img="images/flags/"+b+".svg";
                        $('#flag').attr('src',img);
                        $('#phone').focus();

                    }
                }
            });
        }
        
        
    })
//country select end


//email check
  $("#email").keyup(function(){
      var email = $(this).val();
      
             $.post( "ajax/user_email_check.php",{email:email}, function( feedback ) {
        //   $( ".result" ).html( data );
                  $('#emailError').text(feedback);
             });
    })

//email check end


//sponsor check
  $("#sponsor_name").focusout(function(){
      var sponsorName = $(this).val();
             $.post( "ajax/sponsor_check.php",{sponsorName:sponsorName}, function( feedback ) {
                  $('#sponsorError').text(feedback);
             });
    })
//sponsor check end

//username check
  $('#username').keyup(function(){
      var username = $(this).val();
             $.post( "ajax/usercheck.php",{username:username}, function( feedback ) {
                  $('#usernameError').text(feedback);
             });
    })
//username check end
    
  
  
  
//*************Login*****************
$('#loginSubmit').click(function(e)
{
    var loginUsername = $('#loginUsername');
    var loginPassword = $('#loginPassword');
    
    if(loginUsername.val() == '')
    {
        loginUsername.siblings(".errorMsg").html('Enter username');
        loginUsername.parent('.input-field').addClass('error');
         e.preventDefault();
    }
    else if(loginPassword.val() == '')
    {
        loginPassword.siblings(".errorMsg").html('Please Enter password');
        loginPassword.parent('.input-field').addClass('error');
        e.preventDefault();
    }
    else
    {
        var user_name = $('#loginUsername').val();
        var password = $('#loginPassword').val();
             $.post( "ajax/ajax-login.php",{user_name:user_name,password:password}, function(feedback) {
                 
                  if(feedback == 'success')
                  {
                      $('#loginError').css('color','green');
                      $('#loginError').html('Login Processing...');
                      $('#loginUsername').val('');
                      $('#loginPassword').val('');
                      location.replace('index.php');
                  }
                  else
                  {
                     $('#loginError').html(feedback);  
                  }
                  
             });
        
        // $('#loginError').html('login Successfull');
        e.preventDefault();
    }
    
    // keyup functions
    loginUsername.on("keyup",function()
    {
        loginUsername.siblings(".errorMsg").html('');
        loginUsername.parent('.input-field').removeClass('error');
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



