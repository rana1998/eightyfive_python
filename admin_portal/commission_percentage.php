<?php
ob_start();
include "header.php";




// Update ROI Percentage Value
	if(isset($_POST['update'])){
	    
	    $level1 = mysqli_real_escape_string($con,$_POST['level1']);
	    $level2 = mysqli_real_escape_string($con,$_POST['level2']);
	    $level3 = mysqli_real_escape_string($con,$_POST['level3']);
	    $level4 = mysqli_real_escape_string($con,$_POST['level4']);
	    $level5 = mysqli_real_escape_string($con,$_POST['level5']);
	    
	    if(empty($level1) || empty($level2) || empty($level3) || empty($level4) || empty($level5))
	    {
	        	$_SESSION['errorMsg']='Please enter all package percentage values';
				header("Location: commission_percentage.php");
				exit();
	    }
	    else
	    {
	        $q="UPDATE `commission_percentage` SET `level1`='$level1',`level2`='$level2',`level3`='$level3',`level4`='$level4',`level5`='$level5' WHERE 1";
	        $result = mysqli_query($con,$q);
	        if($result == TRUE)
	        {
	            //admin log
	            $qy="INSERT INTO `admin_log`(`user_name`, `activity`) VALUES ('$adminName','Commission percentage update level1:$level1 , level2:$level2 , level3:$level3 , level4:$level4 , level5:$level5')";
	            $result1 = mysqli_query($con,$qy);
	            
	            $_SESSION['successMsg']='Packages percentage update successfully';
				header("Location: commission_percentage.php");
				exit();
	        }
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
							<h4>Commission Percentage</h4>
							<span>Check and Update Commission Percentage. </span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Commission Percentage</a> </li>
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
										<h3 class="text-center ">Commission Percentage</h3>

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
							<?php
							
							//select percentages
                            $q="SELECT * FROM `commission_percentage` where id='1'";
                            $result = mysqli_query($con,$q);
                            $res = mysqli_fetch_assoc($result);
							
							?>
							<div class="card-body">
								<form  class="md-float-material form-material" action="" method="POST">
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Level 1 %</label>
										<div class="col-sm-9">
											<input autocomplete="off" type="text" class="form-control" name="level1"  value="<?=$res['level1']?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Level 2 %</label>
										<div class="col-sm-9">
											<input autocomplete="off" type="text" class="form-control" name="level2"  value="<?=$res['level2']?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Level 3 %</label>
										<div class="col-sm-9">
											<input autocomplete="off" type="text" class="form-control" name="level3"  value="<?=$res['level3']?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Level 4 %</label>
										<div class="col-sm-9">
											<input autocomplete="off" type="text" class="form-control" name="level4"  value="<?=$res['level4']?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Level 5 %</label>
										<div class="col-sm-9">
											<input autocomplete="off" type="text" class="form-control" name="level5"  value="<?=$res['level5']?>">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-12">
											<button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" name = "update">Update</button>
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