<?php

include "db_config.php";
if(!isset($_GET['userName']) && $_GET['userName']==' ')
{
      $_SESSION['errorMsg']='Something went wrong';
        header("Location: index.php?");
        $stmt->close();
        exit();
}
elseif(!isset($_GET['pkgId']) && $_GET['pkgId']==' ')
{
      $_SESSION['errorMsg']='Something went wrong';
        header("Location: index.php?");
        $stmt->close();
        exit();
}

$userName= $_GET['userName'];
$pkgId= $_GET['pkgId'];

// echo $userName.$pkgId;

// die();
$q="select * from user_registration where user_name='$userName'";
$result=mysqli_query($con,$q);
$res=mysqli_fetch_assoc($result);
$resRow= mysqli_num_rows($result);
if($resRow < 1)
{
   $_SESSION['successMsg']='Something went wrong';
        header("Location: index.php?");
        $stmt->close();
        exit(); 
}
$email = $res['email'];
$full_name = $res['full_name'];



        $sql_upa = "SELECT * FROM auto_variant WHERE id = '$pkgId'";
        $run_upa = mysqli_query($con, $sql_upa);
        $row_upa = mysqli_fetch_array($run_upa);
        $row_num = mysqli_num_rows($run_upa);
        if($row_num < 1)
        {
           $_SESSION['successMsg']='Something went wrong';
                header("Location: index.php?");
                $stmt->close();
                exit(); 
        }


       
        $pkgName =   $row_upa['company'].' '.$row_upa['model'].' '.$row_upa['variant'];
        $pkgPrice=  $up_price  = $row_upa['price'];
// echo $email . $full_name;
// die();

         
     
                // $_SESSION['successMsg']='OTP send to your email';
    $subject = "Auto Package Purchased - Infinite Trade Group";
    $email_template = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    
    
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>OTP Code | Wealth Trade Hub</title>
        <meta name="viewport" content="width=device-width">
        <link rel="icon" href="https://wealthtradehub.com/affiliate/images/icons/logo.png" type="image/x-icon">
       <style type="text/css">
            @media only screen and (max-width: 550px), screen and (max-device-width: 550px) {
                body[yahoo] .buttonwrapper { background-color: transparent !important; }
                body[yahoo] .button { padding: 0 !important; }
                body[yahoo] .button a { background-color: #9b59b6; padding: 15px 25px !important; }
            }

            @media only screen and (min-device-width: 601px) {
                .content { width: 600px !important; }
                .col387 { width: 387px !important; }
            }
        </style>
    </head>
    <body bgcolor="#34495E" style="margin: 0; padding: 0;" yahoo="fix">
        <!--[if (gte mso 9)|(IE)]>
        <table width="600" align="center" cellpadding="0" cellspacing="0" border="0">
          <tr>
            <td>
        <![endif]-->
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="border-collapse: collapse; width: 100%; max-width: 600px;" class="content">
            <tr>
                <td style="padding: 15px 10px 15px 10px;">
                 
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 30px 10px 0px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 20px; font-weight: bold;">
                    <img src="https://infinitetradegroup.com/data/assets/images/logo-icon.png" alt="Welcome Email" width="114" height="80" style="display:block; margin-bottom: 15px;">
                    
                </td>
            </tr>
            <tr  bgcolor="#ffffff">
                <td style="padding: 20px 10px;font-size: 22px;color: seagreen;font-family: Arial, Helvetica, sans-serif;font-weight: bold;">
                    Package Purchased Successfully
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px; ">
                    <b>Thank you for choosing Infinite Trade Group as a business partner. Your package is purchased and your account is activated successfully. </b><br>                    
                </td>
            </tr>
          
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 20px 25px 20px 0px; font-family: Arial, sans-serif;">
                    <table bgcolor="#ffffff" border="0" cellspacing="0" cellpadding="0" class="buttonwrapper">
                        <tr>
                            <td align="left" height="25" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <span style="color: #223035; text-align: center;">Package: </span>
                                <span style="color: #0269f0; text-align: center;">'.$pkgName.'</span>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" height="25" style=" padding: 0 25px 0 10px; font-family: Arial, sans-serif; font-size: 16px; font-weight: bold;" class="button">
                                <span style="color: #223035; text-align: center;">Price: </span>
                                <span style="color: #0269f0; text-align: center;">$'.$pkgPrice.'</span>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
             <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: #ED3237; font-family: Arial, sans-serif; font-size: 15px; line-height: 25px; ">
                    <b>Important:</b><br>                    
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px; ">
                    <b>* You receive ROI income of 3% to 5% on monthly basis.</b><br>                    
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 0px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px; ">
                    <b>* We introduced a unique idea of unlimited ROI income and you will be paid for an unlimited period.</b><br>                    
                </td>
            </tr>
            <tr>
                <td align="left" bgcolor="#ffffff" style="padding: 0px 20px 30px 10px; color: 555555; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px; ">
                    <b>* You can request your capital withdrawal after 3 months. 30 days processing period applies.</b><br>                    
                </td>
            </tr>
            <tr>
                <td align="center" bgcolor="#ff9700" style="padding: 15px 10px 15px 10px; color: #ffffff; font-family: Arial, sans-serif; font-size: 12px; line-height: 25px;">
                    <b>© All Rights Reserved - Infinite Trade Group</a></b>
                </td>
            </tr>
        </table>
        <!--[if (gte mso 9)|(IE)]>
                </td>
            </tr>
        </table>
        <![endif]-->
    </body>
</html>';
    $param = array(
        'subject' => $subject ,
        'email_template' => $email_template ,
        'receiver_email' => $email ,
        'receiver_name' => $full_name 
     );
    
    
    if( send_email($param) ){
        $_SESSION['successMsg']='Package Updated Successfully.';
        header("Location: auto_package.php");
       
       
        // echo "Email Send Successfully";
        exit();
    }
    else
    {
         echo "Email not Send";
         exit();
    }
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
    
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>OTP Code | Infinite Trade Group</title>
        <meta name="viewport" content="width=device-width">

    </head>
    <body bgcolor="#053b52" style="margin: 0; padding: 0;" yahoo="fix">
        
                <h1 style="color:white">Processing..</h1>
        
    </body>
</html>









  