<?php 
ob_start();
$page_title = 'Profile';
include 'header.php'; 

// $sql="SELECT * FROM user_registration WHERE user_name = ?";
// $stmt = $con->prepare($sql); 
// $stmt->bind_param("s", $user_name);
// $stmt->execute();
// $result = $stmt->get_result(); // get the mysqli result

// if ($result->num_rows > 0) {
//     $data = $result->fetch_assoc();
// }
// $stmt->close();


// require 'connect.php';
include 'core/db_config.php';
$conn = getDB();

$sql= $conn->prepare("SELECT * FROM user_registration WHERE user_name='".$_SESSION['user_name']."'");
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
if($sql->rowCount()>0){
    foreach (($sql->fetchAll()) as $key => $row) {

        $threex_amount = $row['threex_amount'];
        $threex_amount_limit = $row['threex_amount_limit'];

        $limit = $threex_amount - $threex_amount_limit;

        $packageId = $row['pkg_id'];

        if($packageId == 0){

            header("location: buy-pkg.php?package_type=1");

        }
    }
}


if(isset($_POST['edit_profile']) ){
    $full_name=mysqli_real_escape_string($con, $_POST['full_name']);
    $address=mysqli_real_escape_string($con, $_POST['address']);
    $city=mysqli_real_escape_string($con, $_POST['city']);
    $state=mysqli_real_escape_string($con, $_POST['state']);
    $postal_code=mysqli_real_escape_string($con, $_POST['postal_code']);
    $phone = mysqli_real_escape_string($con,$_POST['phone']);
    $country=mysqli_real_escape_string($con, $_POST['country']);
    $email=mysqli_real_escape_string($con, $_POST['email']);
    $newPassword= mysqli_real_escape_string($con, $_POST['txnpassword']);
    


    // $userPassword= $data['password'];
    // $userHashedPasswordCheck = password_verify($password, $userPassword);
        
           
    
    if (empty($full_name)) {
        $_SESSION['errorMsg'] = "Enter your Name.";
        header('Location: profile.php');
        exit();
    }
    
    elseif (!preg_match('/([A-Z]{1,})/', $newPassword)) 
     {
            // altleast one capital letter
          
        $_SESSION['errorMsg'] = 'Minimum 1 capital letter in password';
        header('location:profile.php');
        exit();
     }
    elseif (!preg_match('/([\d]{1,})/', $newPassword)) 
    {
            // altelast one digit
        $_SESSION['errorMsg'] = 'Minimum 1 digit in password';
        header('location:profile.php');
        exit();
    }
    elseif (!preg_match('/[^a-zA-Z\d]/', $newPassword)) 
    {
           // special characters
        $_SESSION['errorMsg'] = 'Minimum 1 special characters in password';
        header('location:profile.php');
        exit();
    }
    elseif (strlen($newPassword) < 8) {
         // atleast 8 characters length
         
        $_SESSION['errorMsg'] = 'Minimum password length 8 characters';
        header('location:profile.php');
        exit();
        
    }
// Check if the email already exists for any account other than the current user
$emailExistsSql = "SELECT COUNT(*) FROM user_registration WHERE email = :email AND user_name != :user_name";
$emailExistsStmt = $conn->prepare($emailExistsSql);
$emailExistsStmt->bindParam(':email', $email);
$emailExistsStmt->bindParam(':user_name', $user_name);
$emailExistsStmt->execute();
$emailExists = $emailExistsStmt->fetchColumn();

// Check if the phone number already exists for any account other than the current user
$phoneExistsSql = "SELECT COUNT(*) FROM user_registration WHERE phone = :phone AND user_name != :user_name";
$phoneExistsStmt = $conn->prepare($phoneExistsSql);
$phoneExistsStmt->bindParam(':phone', $phone);
$phoneExistsStmt->bindParam(':user_name', $user_name);
$phoneExistsStmt->execute();
$phoneExists = $phoneExistsStmt->fetchColumn();

if ($emailExists) {

    $_SESSION['errorMsg']='Email already exists for another account.';
                header("Location: profile.php");
                exit();
    // Additional handling or error message can be added here as per your requirements
} elseif ($phoneExists) {

    $_SESSION['errorMsg']='Phone number already exists for another account.';
                header("Location: profile.php");
                exit();
    // Additional handling or error message can be added here as per your requirements
} else {
    $hashPassword = password_hash($newPassword, PASSWORD_BCRYPT);
    $sql = "UPDATE user_registration 
    SET full_name = :full_name, 
        address = :address, 
        city = :city, 
        state = :state, 
        postal_code = :postal_code, 
        phone = :phone, 
        country = :country, 
        email = :email, 
        transaction_password = :transaction_password 
    WHERE user_name = :user_name";

// Create a prepared statement
$statement = $conn->prepare($sql);

// Bind the parameters
$statement->bindParam(':full_name', $full_name);
$statement->bindParam(':address', $address);
$statement->bindParam(':city', $city);
$statement->bindParam(':state', $state);
$statement->bindParam(':postal_code', $postal_code);
$statement->bindParam(':phone', $phone);
$statement->bindParam(':country', $country);
$statement->bindParam(':email', $email);
$statement->bindParam(':transaction_password', $hashPassword);
$statement->bindParam(':user_name', $user_name); // You need to provide the value for $user_name

// Execute the statement
$statement->execute();

// Check if the update was successful
$affectedRows = $statement->rowCount();
if ($affectedRows > 0) {

       $_SESSION['successMsg']='Your Profile has been updated successfully.';
              header("Location: profile.php");
              exit();

} else {

        $_SESSION['errorMsg']='Network error detected. Please try again sometimes.';
                header("Location: profile.php");
                exit();

}

}

    
            //    $hashPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            //    $hello =  "UPDATE user_registration SET full_name = '$full_name' WHERE user_name = '$user_name'";
         
            //    echo "<script>alert('$user_name');</script>";
        //  echo $sql = "UPDATE user_registration SET full_name = '$full_name',  email = '$email', street='$address', 
        //                city= '$city', state='$state', postal_code= '$postal_code',mobile='$phone' ,country= '$country' WHERE user_name = '$user_name'";
        //       $stmt = mysqli_query($con,$sql); 

              
            // if($stmt== TRUE){
              
            //   $_SESSION['successMsg']='Your Profile has been updated successfully.';
            //   header("Location: profile.php");
            //   exit();

            // }else{

            //     $_SESSION['errorMsg']='Network error detected. Please try again sometimes.';
            //     header("Location: profile.php");
            //     exit();

            //  }
            
      
        
   
        



}
//update email start

if(isset($_POST['update_email']))
{
      $otpCode  = strtolower( mysqli_real_escape_string($con, $_POST['otpCode']));   
      $new_email  = strtolower( mysqli_real_escape_string($con, $_POST['email']));
      $new_email  = preg_replace("/\s+/", "", $new_email);
    
    if (empty($new_email)) {
        $_SESSION['errorMsg'] = "Enter Email Address.";
        header('Location: profile.php');
        exit();
    }
    elseif(empty($otpCode)) {
        $_SESSION['errorMsg'] = "Enter OTP Code.";
        header('Location: profile.php');
        exit();
    }
    elseif($otpCode!= $userOldOtp)
    {
         $_SESSION['errorMsg'] = "Wrong OTP Code.";
        header('Location: profile.php');
        exit();
    }
    else{
    
    // Check Email Already Exists
    $sql = "SELECT * FROM user_registration WHERE email = ?"; // SQL with parameters
    $stmt = $con->prepare($sql); 
    $stmt->bind_param("s", $new_email);
    $stmt->execute();
    $result = $stmt->get_result(); // get the mysqli result
    
        if($result->num_rows > 0){
    
        $stmt->close();
        $_SESSION['errorMsg']='Email Already Taken.';
        header("Location: profile.php");
        exit();
    
        }
        else
        {
                $sql2 = "UPDATE user_registration SET email= '$new_email', verified='0' , otp_code= NULL  WHERE user_name = '$user_name'";
                $stmt2 = mysqli_query($con,$sql2); 
                 if($stmt2== TRUE){
                  $_SESSION['successMsg']='Your Email has been updated successfully. Login Again';
                  echo '<script>
                  setTimeout(function(){ location.replace("logout.php"); }, 3000);
                  
                  </script>';
                  
                }
           
        }
    }
    
    
}


//end update email

//update password
if(isset($_POST['updatePassword']))
{
     $currentPassword= mysqli_real_escape_string($con, $_POST['currentPassword']);
     $newPassword= mysqli_real_escape_string($con, $_POST['newPassword']);
     $confirmPassword= mysqli_real_escape_string($con, $_POST['confirmPassword']);
     
     if(empty($currentPassword) || empty($newPassword) || empty($confirmPassword))
     {
         $_SESSION['errorMsg'] = 'Please fill all fields of password';
         header('location:profile.php');
         exit();
     }
     elseif (!preg_match('/([A-Z]{1,})/', $newPassword)) 
     {
            // altleast one capital letter
          
        $_SESSION['errorMsg'] = 'Minimum 1 capital letter in password';
        header('location:profile.php');
        exit();
     }
    elseif (!preg_match('/([\d]{1,})/', $newPassword)) 
    {
            // altelast one digit
        $_SESSION['errorMsg'] = 'Minimum 1 digit in password';
        header('location:profile.php');
        exit();
    }
    elseif (!preg_match('/[^a-zA-Z\d]/', $newPassword)) 
    {
           // special characters
        $_SESSION['errorMsg'] = 'Minimum 1 special characters in password';
        header('location:profile.php');
        exit();
    }
    elseif (strlen($newPassword) < 8) {
         // atleast 8 characters length
         
        $_SESSION['errorMsg'] = 'Minimum password length 8 characters';
        header('location:profile.php');
        exit();
        
    }
    elseif($newPassword != $confirmPassword)
    {
          $_SESSION['errorMsg'] = 'Password not match';
         header('location:profile.php');
         exit();
    }
    else
    {
        
        $userHashedPasswordCheck = password_verify($currentPassword, $userPassword);
            if ($userHashedPasswordCheck == false)
            {
                $_SESSION['errorMsg'] = "Wrong Password ";
                header("Location: profile.php");
                exit();
            }
            elseif ($userHashedPasswordCheck == true)
            {
             
             $hashPassword = password_hash($newPassword, PASSWORD_BCRYPT);
             
            $sql = "UPDATE user_registration SET password=? WHERE user_name = ?";
            $stmt = $con->prepare($sql); 
            $stmt->bind_param("ss",$hashPassword ,$user_name);
                                 
             if($stmt->execute()){
                $stmt->close();
                $_SESSION['successMsg']='Your Password has been updated successfully.';
                header("Location: profile.php");
                exit();
                }
            }
     }
  }
  //end update password


// Image Upload and Update DB  //
// Image Upload Code
if (isset($_POST['image_upload'])) {

// Image Upload Code //
$target_dir = "assets/images/user-profile/";
$profile_pic = basename($_FILES["profile_pic"]["name"]);
$temp = explode(".", $profile_pic); // store file extention e.g .png, .jpg, .jpeg, .gif
$newfilename = uniqid('profile-') . '.' . end($temp);
$target_file = strtolower( $target_dir . $newfilename);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
  $check = getimagesize($_FILES["profile_pic"]["tmp_name"]);
  if($check !== false) {
    // echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    $_SESSION['errorMsg'] =   "File is not an image, Only JPG, JPEG & PNG  files are allowed.";
    $uploadOk = 0;
    header("Location: profile.php");
    exit();             
  }

// Check if file already exists
if (file_exists($target_file)) {
    $_SESSION['errorMsg'] =   "Sorry, file already exists.";
    $uploadOk = 0;
    header("Location: profile.php");
    exit();
}

// Check file size
if ($_FILES["profile_pic"]["size"] > 500000) {
    $_SESSION['errorMsg'] =   "Sorry, your file is too large.";
    $uploadOk = 0;
    header("Location: profile.php");
    exit();
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
    $_SESSION['errorMsg'] =   "Sorry, only JPG, JPEG & PNG  files are allowed.";
    $uploadOk = 0;
    header("Location: profile.php");
    exit();

}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $_SESSION['errorMsg'] =   "Sorry, your file was not uploaded.";
    header("Location: profile.php");
    exit();
// if everything is ok, try to upload file
} else {


if (file_exists($target_dir.$data['profile_pic']) || !empty($data['profile_pic'])) {
  // echo $data['profile_pic']. '  file exists.';
    if($data['profile_pic'] != 'user-profile.png'){
      unlink($target_dir.$data['profile_pic']); // delete image from server        
    }


  }   

  if (move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
    // echo "The file ". basename( $_FILES["profile_pic"]["name"]). " has been uploaded.";
  } else {
    $_SESSION['errorMsg'] =   "Sorry, there was an error uploading your file.";
    header("Location: profile.php");
    exit();
  }

    $sql = "UPDATE user_registration SET profile_pic = ?  WHERE user_name = ?";
    $stmt = $con->prepare($sql); 
    $stmt->bind_param("ss",$newfilename,$user_name);
    if($stmt->execute()){
    $stmt->close();
    $_SESSION['successMsg']='Profile Image Update Successfully';
    header("Location: profile.php");
    exit();
    }else{
    $_SESSION['errorMsg']=  __LINE__ .' Invalid Query '. $con->error ;
    $stmt->close();
    header("Location: profile.php");
    exit();
    }


}

// End Image Upload Code



}





if(isset($_POST['updateUsdtAddress']))
{
    $usdtAddress = mysqli_real_escape_string($con,$_POST['usdtAddress']);
   // $usdtOtpCode = mysqli_real_escape_string($con,$_POST['usdtOtpCode']);
    
    
    if(empty($usdtAddress))
    {
        $_SESSION['errorMsg']='Please enter all data';
        header("Location: profile.php");
        exit();
    }
    // elseif($usdtOtpCode!= $userOldOtp)
    // {
    //      $_SESSION['errorMsg'] = "Wrong OTP Code.";
    //     header('Location: profile.php');
    //     exit();
    // }
    else
    {
        $query="select * from user_registration where usdttrc_address='$usdtAddress'";
        $ressult = mysqli_query($con,$query);
        if(mysqli_num_rows($ressult)==0)
        {
            $q="update user_registration set usdttrc_address ='$usdtAddress' , otp_code=NULL where user_name='$user_name'";
            $result = mysqli_query($con,$q);
            
            if($result == TRUE)
            {
                $_SESSION['successMsg'] = "Address update successfully";
                header('Location: profile.php');
                exit();
            }
        }
        else
        {
                $_SESSION['errorMsg'] = "USDT Address already in record";
                header('Location: profile.php');
                exit();
        }
        
        
    }
    
    
    
    
}

?>
<!--start page wrapper -->
<style>
    .alert{
        margin-top: 30px;
    }
</style>
		<div class="page-wrapper">
			<div class="page-content">
			
				<div class="container">
					<div class="main-body">
						<div class="row">
							<div class="col-lg-4">
								<div class="card">
									<div class="card-body">
										<div class="d-flex flex-column align-items-center text-center">
											<img src="assets/images/user-profile/<?=$userImage?>" alt="Admin" class="rounded-circle p-1 bg-primary" width="120">
											<div class="mt-3">
												<h4 class="text-capitalize"><?= $full_name?></h4>
												<!--<input type="file" class="btn btn-sm">-->
												<!--<button class="btn btn-primary btn-sm">Upload</button>-->
    											<form method="POST" enctype="multipart/form-data" >
    											    <div class="input-group">
                    									<input type="file" name="profile_pic" class="form-control form-control-sm" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">
                    									<button class="btn btn-secondary btn-sm" type="submit" name="image_upload" id="inputGroupFileAddon04">Upload</button>
                								    </div>
    											</form>
            								</div>
										</div>
										<hr class="my-4" />
										<ul class="list-group list-group-flush">
										    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0">Registered Date</h6>
												
												<?php

                                                echo  $regDate;
												// if($activationFee == 'Paid')
												// {
												//    echo'<span class="badge bg-success">Paid</span>'; 
												// }
												// elseif($activationFee == 'Unpaid')
												// {
												//     echo'<span class="badge bg-warning">Unpaid</span>'; 
												// }
											
												?>
												<!--<span class="badge bg-success">Active</span>-->
											</li>
											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0">Account Status</h6>
												
												<?php
												if($userStatus == 'Approved')
												{
												   echo'<span class="badge bg-success">Active</span>'; 
												}
												elseif($userStatus == 'Pending')
												{
												    echo'<span class="badge bg-warning">Pending</span>'; 
												}
												else
												{
												    echo'<span class="badge bg-danger">Matured</span>';
												}
												?>
												<!--<span class="badge bg-success">Active</span>-->
											</li>
											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0">KYC Status</h6>
												
												<?php
												if($userKyc == 'Verified')
												{
												   echo'<span class="badge bg-success">Verified</span>'; 
												}
												elseif($userKyc == 'Unverified')
												{
												    echo'<span class="badge bg-danger">Unverified</span>'; 
												}
												elseif($userKyc == 'Rejected')
												{
												    echo'<span class="badge bg-danger">Rejected</span>';
												}
												?>
												<!--<span class="badge bg-success">Verified</span>-->
											</li>
											<li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0">Current Package</h6>
												<span class="badge bg-info">
												   <?php
                              if($userPkgId == 0)
                                {
                                    $pkgName ='No Package';
                                }
                                else if($userPkgId == 1)
                                {
                                     $pkgName = 'Starter';
                                }
                                else if($userPkgId == 2)
                                {
                                     $pkgName = 'Silver';
                                }
                                else if($userPkgId == 3)
                                {
                                     $pkgName = 'Gold';
                                }
                                else if($userPkgId == 4)
                                {
                                     $pkgName = 'Platinum';
                                }
                                else if($userPkgId == 5)
                                {
                                     $pkgName = 'Diamond';
                                }
                                else if($userPkgId == 6)
                                {
                                     $pkgName = 'Blue Diamond';
                                }
                                else if($userPkgId == 7)
                                {
                                     $pkgName = 'Black Diamond';
                                }
                                
                                echo $pkgName;
                                ?>
												</span>
											</li>
											<!-- <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0">Total Invest</h6>
												<span class="text-info">$<?=$total_invest?></span>
											</li> -->
											
											
										</ul>
									</div>
								</div>
							</div>
							<div class="col-lg-8">
						<div class="card">
							<div class="card-body">
							   
								<ul class="nav nav-tabs nav-danger" role="tablist">
									<li class="nav-item" role="presentation">
										<a class="nav-link active" data-bs-toggle="tab" href="#dangerhome" role="tab" aria-selected="true">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class='bx bx-pencil font-18 me-2'></i>
												</div>
												<div class="tab-title">Edit</div>
											</div>
										</a>
									</li>
									
									<!-- <li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="tab" href="#dangercontact" role="tab" aria-selected="false">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class='bx bx-lock font-18 me-2'></i>
												</div>
												<div class="tab-title">Change Password</div>
											</div>
										</a>
									</li> -->
									<!-- <li class="nav-item" role="presentation">
										<a class="nav-link" data-bs-toggle="tab" href="#usdtAddress" role="tab" aria-selected="false">
											<div class="d-flex align-items-center">
												<div class="tab-icon"><i class='bx bx-wallet font-18 me-2'></i>
												</div>
												<div class="tab-title">USDT Address</div>
											</div>
										</a>
									</li> -->
								</ul>
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
								<div class="tab-content py-3">
									<div class="tab-pane fade show active p-3 mt-3" id="dangerhome" role="tabpanel">
									    <form method="POST">
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Full Name</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="full_name" class="form-control form-control-sm" placeholder="Enter Full Name" value="<?= $full_name?>" required/>
											</div>
										</div>
                                        <div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Email</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input name="email" type="text" class="form-control form-control-sm" placeholder="Email" value="<?= $email ?>" required />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Address</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input type="text" name="address" class="form-control form-control-sm" placeholder="Street" value="<?= $userStreet?>" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0"></h6>
											</div>
											<div class="col-sm-4 text-secondary">
												<input type="text" name="city" class="form-control form-control-sm" placeholder="City" value="<?= $userCity?>" />
											</div>
											<div class="col-sm-5 text-secondary">
												<input type="text" name="state" class="form-control form-control-sm" placeholder="State" value="<?= $userState?>" />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0"></h6>
											</div>
											<div class="col-sm-4 text-secondary">
												<input type="text" name="postal_code" class="form-control form-control-sm" placeholder="Postal Code" value="<?= $userPostalCode ?>" />
											</div>
											<div class="col-sm-5 text-secondary">
												<input type="text" name="phone" class="form-control form-control-sm" placeholder="Phone" value="<?=$userMobile ?>" required />
											</div>
										</div>
										<div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Country</h6>
											</div>
											<div class="col-sm-9 text-secondary">
												<input name="country" type="text" class="form-control form-control-sm" placeholder="Country" value="<?= $userCountry ?>" />
											</div>
										</div>

                                        <div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">Transaction Password</h6>
											</div>
                                            <style>
                                            .input-group {
                                                max-width: 100%;
                                                width: 75%;
                                            }</style>
                                            <div class="col-sm-9 input-group" id="show_hide_password2">
												    <input type="password" id="pass1" name="txnpassword" class="form-control form-control-sm" placeholder="Transaction Password"  required /><a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
									        <span style="color:red">Password Should Contain: Minimum 8 Characters, 1 Digit,  1 Capital Letter, 1 Small Letter and 1 Symbol.</span>
                                                </div>
                                            
										</div>
										<!-- <div class="row mb-3">
											<div class="col-sm-3">
												<h6 class="mb-0">2FA Code</h6>
											</div>
											<div class="col-sm-7 text-secondary">
											    
												<input name="otp_code" type="text" class="form-control form-control-sm" placeholder="Enter 2FA Code" value="" />
												<b class="text-success emailMessageAjax"></b>
											</div>
											<div class="col-sm-2 text-secondary">
											
												<button class="btn btn-sm btn-secondary text-white sendOtpEmail">Send Code</button>
											</div>
									
										</div> -->
										<div class="row mt-3">
											<div class="col-sm-3"></div>
											<div class="col-sm-9">
												<div class="d-flex ">
												    <input type="submit" name="edit_profile" class="btn btn-sm bg-gradient-rose-button text-white" value="Update" />
												</div>
											</div>
										</div>	
									</div>
									</form>
							
									<div class="tab-pane fade p-3" id="dangercontact" role="tabpanel">
								    <form method="POST">
								    <div class="row mb-3">
										<div class="col-sm-3">
												<h6 class="mb-0">Current Password</h6>
											</div>
											<div class="col-sm-9 text-secondary">
								                <div class="input-group" id="show_hide_password">
								                    <input type="password" name="currentPassword" class="form-control form-control-sm" placeholder="Current Password" value="" /><a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
									            </div>
										    </div>
									</div>
									 <div class="row mb-3">
										<div class="col-sm-3">
												<h6 class="mb-0">New Password</h6>
											</div>
											<div class="col-sm-9 text-secondary">
											    <div class="input-group" id="show_hide_password2">
												    <input type="password" id="pass1" name="newPassword" class="form-control form-control-sm" placeholder="New Password" value="" /><a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
									            </div>
									              <ul class="passValidate mt-2" style="display:none">
            									      <li class=" text-danger text-left charlength" style="font-size: 12px;">Password should be 8 character</li>
            									      <li class="text-danger  text-left specialChar" style="font-size: 12px;">Special character must be include</li>
            									      <li class="text-danger text-left integerMust" style="font-size: 12px;">Integer must be include</li>
            									      <li class="text-danger  text-left captLetter mb-1" style="font-size: 12px;">Capital Letter must be include</li>
            									   </ul>
									    	</div>
									</div>
									<div class="row mb-3">
										<div class="col-sm-3">
												<h6 class="mb-0">Confirm Password</h6>
											</div>
											
										    <div class="col-sm-9 text-secondary">
											    <div class="input-group" id="show_hide_password3">
												    <input type="password" id="pass2" name="confirmPassword" class="form-control form-control-sm" placeholder="New Password" value="" /><a href="javascript:;" class="input-group-text bg-transparent"><i class='bx bx-hide'></i></a>
									            </div>
									    	</div>
									</div>
									
										<div class="row mt-3">
											<div class="col-sm-3"></div>
											<div class="col-sm-9">
												<div class="d-flex ">
												    <input type="submit" name="updatePassword" class="btn btn-sm bg-gradient-rose-button text-white" value="Update" />
												</div>
											</div>
										</div>	
								    </form>
									</div>
								</div>
							</div>
						</div>
					</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	


  

<?php include 'footer.php'; ?>

<script>

                //check special character include or not
                 var Specialchar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/;
                 //check number include or not in string
                 var hasNumber = /\d/;
                 
                var checkUpcase = /[A-Z]/;
                 // security pass
                 $('.passValidate').hide()
                  $('#pass1').focusout(function(){
                 $('.passValidate').hide()
                  })
                $('#pass1').on('keyup',function(){
                       $('.passValidate').show()
                     $('.charlength').show()
                     $('.specialChar').show()
                     $('.integerMust').show()
                     $('.captLetter').show()
                     var passLength = $('#pass1').val()
                    if(passLength.length >= 8) {
                       $('.charlength').hide()
                    }
                    else
                    {
                      $('.charlength').show() 
                    }
                    if(Specialchar.test(passLength)){
                        $('.specialChar').hide()
                    }
                    if(hasNumber.test(passLength)){
                        $('.integerMust').hide()
                    }
                    if(checkUpcase.test(passLength)){
                        $('.captLetter').hide()
                    }
                })
                 $('#pass1').on('click',function(){
                       $('.passValidate').show()
                     $('.charlength').show()
                     $('.specialChar').show()
                     $('.integerMust').show()
                     $('.captLetter').show()
                     var passLength = $('#pass1').val()
                    if(passLength.length >= 8) {
                       $('.charlength').hide()
                    }
                    else
                    {
                      $('.charlength').show() 
                    }
                    if(Specialchar.test(passLength)){
                        $('.specialChar').hide()
                    }
                    if(hasNumber.test(passLength)){
                        $('.integerMust').hide()
                    }
                    if(checkUpcase.test(passLength)){
                        $('.captLetter').hide()
                    }
                })
                //------
        

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
        
        $("#show_hide_password2 a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password2 input').attr("type") == "text") {
                $('#show_hide_password2 input').attr('type', 'password');
                $('#show_hide_password2 i').addClass("bx-hide");
                $('#show_hide_password2 i').removeClass("bx-show");
            } else if ($('#show_hide_password2 input').attr("type") == "password") {
                $('#show_hide_password2 input').attr('type', 'text');
                $('#show_hide_password2 i').removeClass("bx-hide");
                $('#show_hide_password2 i').addClass("bx-show");
            }
        });
        
        $("#show_hide_password3 a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password3 input').attr("type") == "text") {
                $('#show_hide_password3 input').attr('type', 'password');
                $('#show_hide_password3 i').addClass("bx-hide");
                $('#show_hide_password3 i').removeClass("bx-show");
            } else if ($('#show_hide_password3 input').attr("type") == "password") {
                $('#show_hide_password3 input').attr('type', 'text');
                $('#show_hide_password3 i').removeClass("bx-hide");
                $('#show_hide_password3 i').addClass("bx-show");
            }
        });
        
    });
   
</script>