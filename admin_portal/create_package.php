<?php
ob_start();
include "header.php";
// insert code
	if(isset($_POST['create'])){
		
		
		$packageName = strtolower(mysqli_real_escape_string($con,$_POST['packageName']));
        $noOfDays = mysqli_real_escape_string($con,$_POST['noOfDays']);
        $percentage = mysqli_real_escape_string($con,$_POST['percentage']);
        $minAmount = mysqli_real_escape_string($con,$_POST['minAmount']);
        $maxAmount = mysqli_real_escape_string($con,$_POST['maxAmount']);
        $returnCapital = mysqli_real_escape_string($con,$_POST['returnCapital']);

        if(empty($packageName) || empty($noOfDays) || empty($percentage) || empty($minAmount) || empty($maxAmount) || empty($returnCapital))
        {
                $_SESSION['errorMsg']='Please fill all data';
				header("Location: create_package.php");
				exit();
        }
        
         $file= $_FILES['file'];
	   //echo $file;
	   //exit();
	   //Image settings
        $ImgName = $file['name'];
        $ImgError = $file['error'];
        $ImgTemp = $file['tmp_name'];
        $ImgSize = $file['size'];
    
        $ImgText = explode('.',$ImgName);
        $ImgCheck = strtolower(end($ImgText));

        if(empty($ImgName))
        {
            $_SESSION['errorMsg'] = "Please select logo";
            header("Location: create_package.php");
            exit();
        }
        elseif($ImgSize > 5000000)
        {
            $_SESSION['errorMsg'] = "Image size is greater than 5MB";
            header("Location: create_package.php");
            exit();
        }
        elseif($ImgCheck=='png' || $ImgCheck=='jpg' || $ImgCheck=='jpeg')
        {
          $ImgName = preg_replace("/\s+/","", $ImgName);
            $ImgDestinationFile = 'images/packageImages/'.md5(rand()).'-'.$ImgName;
            move_uploaded_file($ImgTemp, $ImgDestinationFile);
            
           // Insert into bank table
    		$insert = "INSERT INTO `package`(`package_name`, `no_of_days`, `percentage_per_day`, `min_amount`, `max_amount`,`image`, `capital`) 
    		VALUES ('$packageName','$noOfDays','$percentage','$minAmount','$maxAmount','$ImgDestinationFile','$returnCapital')";
    		$run_insert = mysqli_query($con, $insert);
    			if(!$run_update && !$run_insert){
    				echo '<h6>'.mysqli_error( $con ).'</h6>';
    				exit();
    			}

				$_SESSION['successMsg']='Package Created Successfully.';
				header("Location: create_package.php");
				exit(); 
        
          }
         else
        {
            $_SESSION['errorMsg'] = "Image format not PNG, JPG, JPEG";
            header("Location: create_package.php");
            exit();
        }
	}
	

	
?>
<!-- Main-body start -->
<div class="main-body">
	<div class="page-wrapper">
		<!-- Page-header start -->
		<div class="page-header">
			<div class="row align-items-end">
				<div class="col-lg-8">
					<div class="page-header-title">
						<div class="d-inline">
							<h4>Package</h4>
							<span>Package Details </span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Package</a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Page-header end -->
		<div class="page-body">
			<div class="container">
				<div class="row">
					<div class="col-sm-8 ml-auto mr-auto">
						
						<div class="auth-box card">
							<div class="card-block">
								<div class="row m-b-20">
									<div class="col-md-12">
										<h3 class="text-center ">Create Package</h3>

                                    <!-- Success Message -->
                                    <?php if (isset($_SESSION['successMsg'])) {
                                    ?>
                                    <div class="alert alert-success background-success mb-0">
                                    <button type="button" class="close m-0" data-dismiss="alert" aria-label="Close">
                                    <i class="icofont icofont-close-line-circled text-white"></i>
                                    </button>
                                    <strong>Success!</strong> <?php echo $_SESSION['successMsg'] ;?>
                                    </div>
                                    <?php
                                    unset($_SESSION['successMsg']);
                                    } ?>

                                    <!-- Error Message -->
                                    <?php if (isset($_SESSION['errorMsg'])) {
                                    ?>
                                    <div class="alert alert-danger background-danger mb-0">
                                    <button type="button" class="close m-0" data-dismiss="alert" aria-label="Close">
                                    <i class="icofont icofont-close-line-circled text-white"></i>
                                    </button>
                                    <strong>Error!</strong> <?php echo $_SESSION['errorMsg'] ;?>
                                    </div>
                                    <?php
                                    unset($_SESSION['errorMsg']);
                                    } ?>


									</div>
								</div>
							</div>
							<div class="card-body">
								<form  class="md-float-material form-material" action="" enctype="multipart/form-data" method="POST">
							
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Package Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="packageName" id="packageName"  value="">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">No of days</label>
										<div class="col-sm-9">
											<input type="number" class="form-control" name="noOfDays" id="noOfDays"  value="">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Percentage Per Day</label>
										<div class="col-sm-9">
											<input type="number" class="form-control" name="percentage" id="percentage"  value="">
										</div>
									</div>
										<div class="form-group row">
										<label class="col-sm-3 col-form-label">Min Amount</label>
										<div class="col-sm-9">
											<input type="number" class="form-control" name="minAmount" id="minAmount"  value="">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Max Amount</label>
										<div class="col-sm-9">
											<input type="number" class="form-control" name="maxAmount" id="maxAmount"  value="">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Image (png, jpg, jpeg only)</label>
										<div class="col-sm-9">
											<input type="file" class="form-control" name="file" id="file"  value="">
										</div>
									</div>
										<div class="form-group row">
										<label class="col-sm-3 col-form-label">Return Capital</label>
										<div class="col-sm-9">
											<!--<input type="number" class="form-control" name="returnCapital" id="returnCapital"  value="">-->
											<select class="form-control" id="returnCapital" name="returnCapital">
											    <option value="" hidden>Select</option>
											    <option value="yes">Yes</option>
											    <option value="no">No</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-12">
											<button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" name = "create">Create</button>
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
<?php
include "footer.php";
?>