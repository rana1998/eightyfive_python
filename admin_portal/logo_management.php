<?php
ob_start();
include "header.php";
// insert code
	if(isset($_POST['create'])){
		
		
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
            header("Location: logo_management.php");
            exit();
        }
        elseif($ImgSize > 5000000)
        {
            $_SESSION['errorMsg'] = "Logo size is greater than 5MB";
            header("Location: logo_management.php");
            exit();
        }
        elseif($ImgCheck=='png' || $ImgCheck=='jpg' || $ImgCheck=='jpeg')
        {
          $ImgName = preg_replace("/\s+/","", $ImgName);
            $ImgDestinationFile = 'images/logoIcon/'.md5(rand()).'-'.$ImgName;
            move_uploaded_file($ImgTemp, $ImgDestinationFile);
            
            $q="update project_management set logo = '$ImgDestinationFile'";
            
            $result= mysqli_query($con,$q);
            
            if($result==TRUE)
            {
                $_SESSION['successMsg'] = "Logo updated successfully";
                header("Location: logo_management.php");
                exit();
            }
    
        }
        else
        {
            $_SESSION['errorMsg'] = "Image format not PNG, JPG, JPEG";
            header("Location: logo_management.php");
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
							<h4>Logo</h4>
							<span>Logo Management </span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Logo</a> </li>
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
										<h3 class="text-center ">Update Logo</h3>

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
								<form  class="md-float-material form-material" enctype="multipart/form-data" method="POST">
							
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Logo (png, jpg, jpeg only)</label>
										<div class="col-sm-9">
											<input type="file" class="form-control" name="file" id="file"  value="">
										</div>
									</div>

									<div class="form-group row">
										<div class="col-md-12">
											<button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" name = "create">Update</button>
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