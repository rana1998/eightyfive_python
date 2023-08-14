<?php
$page_title = 'KYC';
include 'header.php'; 
if($userKyc == 'Verified')
{
    $_SESSION['successMsg'] = "Kyc already verified.";
    header("Location: index.php");
    exit();
}


$user_name = $_SESSION['user_name'];
// Getting  Value from user_registration
$sql = "SELECT `ur`.`password`, `k`.`id` AS `kyc_user_id` , `k`.`image1`, `k`.`image2`, `k`.`image3` FROM user_registration AS ur
        LEFT JOIN kyc AS k
        ON `ur`.`user_name` = `k`.`user_name`
        WHERE `ur`.`user_name` = ?";
$stmt = $con->prepare($sql); 
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result
$data = $result->fetch_assoc();
$password = $data['password'];
$image1 = $data['image1'];
$image2 = $data['image2'];
$image3 = $data['image3'];
$kyc_user_id = $data['kyc_user_id'];

// Check if image file is a actual image or fake image
if(isset($_POST["kyc_submit"])) {

$type        = mysqli_real_escape_string($con, $_POST['select_type'] );
$id_no       = mysqli_real_escape_string($con, $_POST['id_no']);
$issue_date  = mysqli_real_escape_string($con, $_POST['issuence_date'] );
$expire_date = mysqli_real_escape_string($con, $_POST['expire_date'] );
// $new_pass    = mysqli_real_escape_string($con,$_POST['pass']);

$img1=basename( $_FILES["fileToUpload"]["name"]);
$img2=basename( $_FILES["fileToUpload1"]["name"]);
$img3=basename( $_FILES["fileToUpload2"]["name"]);
// $img4=basename( $_FILES["fileToUpload3"]["name"]);


if(empty($type)){
    $_SESSION['errorMsg'] = "Select Your Document Type.";
    header("Location: kyc.php");
    exit();

}elseif( empty($img1)){
    $_SESSION['errorMsg'] = "Upload Personal Picture.";
    header("Location: kyc.php");
    exit();
}elseif( empty($img2)){
    $_SESSION['errorMsg'] = "Upload Document Front Picture.";
    header("Location: kyc.php");
    exit();
}elseif( empty($img3)){
    $_SESSION['errorMsg'] = "Upload Document Back Picture.";
    header("Location: kyc.php");
    exit();    
}
elseif(empty($id_no)){
    $_SESSION['errorMsg'] = "Enter Document ID";
    header("Location: kyc.php");
    exit();

}elseif(empty($issue_date)){
    $_SESSION['errorMsg'] = "Enter Document Issuance Date";
    header("Location: kyc.php");
    exit();

}elseif(empty($expire_date)){
    $_SESSION['errorMsg'] = "Enter Document Expire Date.";
    header("Location: kyc.php");
    exit();

}

    $target_dir = "assets/images/kyc/";

    $temp = explode(".", $img1); // store file extention e.g .png, .jpg, .jpeg, .gif
    $newfilename = uniqid('img1-') . '.' . end($temp);
    $target_file = strtolower( $target_dir . $newfilename);

    $temp1 = explode(".", $img2); // store file extention e.g .png, .jpg, .jpeg, .gif
    $newfilename1 = uniqid('img2-') . '.' . end($temp1);
    $target_file1 = strtolower( $target_dir . $newfilename1);

    $temp2 = explode(".", $img3); // store file extention e.g .png, .jpg, .jpeg, .gif
    $newfilename2 = uniqid('img3-') . '.' . end($temp2);
    $target_file2 = strtolower( $target_dir . $newfilename2);


    $temp3 = explode(".", $img4); // store file extention e.g .png, .jpg, .jpeg, .gif
    $newfilename3 = uniqid('img4-') . '.' . end($temp3);
    $target_file3 = strtolower( $target_dir . $newfilename3);
    // $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    // $target_file1 = $target_dir . basename($_FILES["fileToUpload1"]["name"]);
    // $target_file2 = $target_dir . basename($_FILES["fileToUpload2"]["name"]);

    $uploadOk = 1;
    $uploadOk1 = 1;
    $uploadOk2 = 1;
    $uploadOk3 = 1;

    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $imageFileType1 = strtolower(pathinfo($target_file1,PATHINFO_EXTENSION));
    $imageFileType2 = strtolower(pathinfo($target_file2,PATHINFO_EXTENSION));
    $imageFileType3 = strtolower(pathinfo($target_file3,PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check  = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    $check1 = getimagesize($_FILES["fileToUpload1"]["tmp_name"]);
    $check2 = getimagesize($_FILES["fileToUpload2"]["tmp_name"]);
    // $check3 = getimagesize($_FILES["fileToUpload3"]["tmp_name"]);

    if($check !== false and $check1 !== false and $check2 !== false) {

        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
        // echo "File is an image - " . $check1["mime"] . ".";
        $uploadOk1 = 1;
        // echo "File is an image - " . $check2["mime"] . ".";
        $uploadOk2 = 1;
        // echo "File is an image - " . $check2["mime"] . ".";
        $uploadOk3 = 1;

    } else {
        $_SESSION['errorMsg'] = "File is not an image.";
        $uploadOk = 0;
        $uploadOk1 = 0;
        $uploadOk2 = 0;
        $uploadOk3 = 0;
        header("Location: kyc.php");
        exit();  
              

    }

// Check if file already exists
if (file_exists($target_file)) {
  $_SESSION['errorMsg'] = "Sorry, file already exists.";
  $uploadOk = 0;
  header("Location: kyc.php");
  exit();
}elseif (file_exists($target_file1)) {
  $_SESSION['errorMsg'] = "Sorry, file already exists.";
  $uploadOk = 0;
  header("Location: kyc.php");
  exit();
}elseif (file_exists($target_file2)) {
  $_SESSION['errorMsg'] = "Sorry, file already exists.";
  $uploadOk = 0;
  header("Location: kyc.php");
  exit();
}
elseif (file_exists($target_file3)) {
  $_SESSION['errorMsg'] = "Sorry, file already exists.";
  $uploadOk = 0;
  header("Location: kyc.php");
  exit();
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 5000000 && $_FILES["fileToUpload1"]["size"] > 5000000 && $_FILES["fileToUpload2"]["size"] > 5000000 ) {
        $_SESSION['errorMsg'] = "Sorry, your file is too large.";
        $uploadOk = 0;
        $uploadOk1 = 0;
        $uploadOk2 = 0;
        $uploadOk3 = 0;
        header("Location: kyc.php");
        exit();   
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
        $_SESSION['errorMsg'] = "Sorry, only JPG, JPEG, & PNG files are allowed.";
        $uploadOk = 0;
        $uploadOk1 = 0;
        $uploadOk2 = 0;
        $uploadOk3 = 0;
        header("Location: kyc.php");
        exit();   
}elseif($imageFileType1 != "jpg" && $imageFileType1 != "png" && $imageFileType1 != "jpeg" ){
        $_SESSION['errorMsg'] = "Sorry, only JPG, JPEG, & PNG files are allowed.";
        $uploadOk = 0;
        $uploadOk1 = 0;
        $uploadOk2 = 0;
        $uploadOk3 = 0;
        header("Location: kyc.php");
        exit();   

}elseif($imageFileType2 != "jpg" && $imageFileType2 != "png" && $imageFileType2 != "jpeg" ){
        $_SESSION['errorMsg'] = "Sorry, only JPG, JPEG, & PNG files are allowed.";
        $uploadOk = 0;
        $uploadOk1 = 0;
        $uploadOk2 = 0;
        $uploadOk3 = 0;
        header("Location: kyc.php");
        exit();   
}


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0 || $uploadOk1 == 0 || $uploadOk2 == 0) {
        $_SESSION['errorMsg'] = "Sorry, your file was not uploaded.";
        $uploadOk = 0;
        $uploadOk1 = 0;
        $uploadOk2 = 0;
        $uploadOk3 = 0;
        header("Location: kyc.php");
        exit();    
// if everything is ok, try to upload file
} else {

  // if(file_exists($target_dir.$image1)){
  //   unlink($target_dir.$image1);
  // }
  // if(file_exists($target_dir.$image2)){
  //   unlink($target_dir.$image2);
  // }
  // if(file_exists($target_dir.$image3)){
  //   unlink($target_dir.$image3);
  // }
  // if(file_exists($target_dir.$image4)){
  //   unlink($target_dir.$image4);
  // }


    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file) and move_uploaded_file($_FILES["fileToUpload1"]["tmp_name"], $target_file1) and move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file2)) {
        // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). "  has been uploaded.";
        // echo "The file ". basename( $_FILES["fileToUpload1"]["name"]). " has been uploaded.";
        // echo "The file ". basename( $_FILES["fileToUpload2"]["name"]). " has been uploaded.";
  } else {
        $_SESSION['errorMsg'] = "Sorry, there was an error uploading your file.";
        header("Location: kyc.php");
        exit();  
  }       
}        

// Insert in KYC Table
$sql = "REPLACE INTO `kyc` (`id`,`user_name`, `image1`, `image2`, `image3`,`image4`, `id_no`, `doc_type`, `issue_date`, `expire_date`)
          VALUES(?,?,?,?,?,?,?,?,?,?)";
$stmt = $con->prepare($sql);
$stmt->bind_param('isssssssss',$kyc_user_id, $user_name, $newfilename,$newfilename1,$newfilename2,$newfilename2,$id_no,$type,$issue_date,$expire_date);

if ($stmt->execute() === TRUE) {
  $stmt->close();
  $_SESSION['successMsg']='Your KYC request has been submitted!';
  header("Location: kyc.php");
  exit();

}else{
  $stmt->close();
  $_SESSION['errorMsg'] =  "Error inserting record: " . $con->error;
  header("Location: login.php");
  exit();
}



} // end of isset


 ?>
<!-- Page Content Start Here -->
<div class="page-wrapper">
  <div class="page-content">
    <!-- Breadcrumb-->
    <!--<div class="row pt-2 pb-2">-->
    <!--  <div class="col-sm-9">-->
    <!--    <h4 class="page-title"><?= $page_title; ?></h4>-->
    <!--    <ol class="breadcrumb">-->
    <!--      <li class="breadcrumb-item"><a href="index.php">Home</a></li>-->
    <!--      <li class="breadcrumb-item active" aria-current="page"><?= $page_title; ?></li>-->
    <!--    </ol>-->
    <!--  </div>-->
    <!--</div>-->
    <!-- End Breadcrumb-->
    <div class="row">
      <div class="col-lg-10 mx-auto">
        <div class="card">
          <div class="card-body">
            <div class="card-title">Upload Document</div>
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
            <hr>
            <form method = "POST" enctype="multipart/form-data">
                  <div class="form-group">
                      <label for="documentType">Select Document Type</label>
                      <select id="documentType" class="form-control form-control-rounded single-select" name="select_type">
                        <option value="">Select Document Type</option>
                        <option value="national_id">National Id</option>
                        <option value="driving_licence">Driving Licence</option>
                        <option value="passport">Passport</option>
                      </select>
                    </div>
              <div class="form-group mt-3">
                <label for="personalPic">Personal Picture</label>                
                  <small class=" text-danger">(Only jpg and png files are allowed)</small>
                <input type="file" class="form-control form-control-rounded" id="personalPic" name="fileToUpload" >
              </div>
              
              <div class="form-group mt-3">
                <label for="frontSide">Front Side</label>                
                  <small class="text-danger">(Only jpg and png files are allowed)</small>
                <input type="file" class="form-control form-control-rounded" id="frontSide" name="fileToUpload1" >
              </div>
              
              <div class="form-group mt-3">
                <label for="backSide">Back Side</label>                
                  <small class="text-danger">(Only jpg and png files are allowed)</small>
                <input type="file" class="form-control form-control-rounded" id="backSide" name="fileToUpload2" >
              </div>
              <!-- <div class="form-group mt-3">
                <label for="backSide">Contract Image</label>                
                  <small class="text-danger">(Only jpg and png files are allowed)</small>
                <input type="file" class="form-control form-control-rounded" id="contract" name="fileToUpload3" >
              </div> -->
              
              <div class="form-group mt-3">
                <label for="idNumber">Enter ID Number</label>
                <input type="text" class="form-control form-control-rounded" id="idNumber" name="id_no" placeholder="Enter Document ID">
              </div>
              
              <div class="form-group mt-3">
                <label for="issuanceDate ">Issuance Date</label>
                <input type="date" class="form-control form-control-rounded datepicker" id="issuanceDate" name="issuence_date" placeholder="Select Date..">
              </div>
              <div class="form-group mt-3">
                <label for="expiryDate">Expiry Date</label>
                <input type="date" class="form-control form-control-rounded datepicker" id="expiryDate" name="expire_date" placeholder="Select Date..">
              </div>
              
              <!-- <div class="form-group mt-3">
                <label for="pass">Password</label>
                <input type="password" class="form-control form-control-rounded" id="pass" name="pass" placeholder="Enter Password">
              </div> -->
              <div class="form-group mt-3 text-center">
                <button type="submit" class="btn bg-gradient-rose-button-dark text-white btn-round px-5" name = "kyc_submit"><i class="icon-lock"></i> Submit Request</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
  </div>
  <!-- End container-fluid-->
  
  </div><!--End content-wrapper-->
  
  <?php include 'footer.php'; ?>