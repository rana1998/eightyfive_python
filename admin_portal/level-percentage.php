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
	    $level6 = mysqli_real_escape_string($con,$_POST['level6']);
	    $level7 = mysqli_real_escape_string($con,$_POST['level7']);
	    $level8 = mysqli_real_escape_string($con,$_POST['level8']);
	    
	    if(empty($level1) || empty($level2) || empty($level3) || empty($level4) || empty($level5) || empty($level6) || empty($level7) || empty($level8))
	    {
	        	$_SESSION['errorMsg']='Please enter all level percentage values';
				header("Location: level-percentage.php");
				exit();
	    }
	    else
	    {
	        $q="UPDATE `level_percentage` SET `level1`='$level1',`level2`='$level2',`level3`='$level3',`level4`='$level4',`level5`='$level5' ,`level6`='$level6',`level7`='$level7',`level8`='$level8' WHERE 1";
	        $result = mysqli_query($con,$q);
	        if($result == TRUE)
	        {
	            //admin log
	            $qy="INSERT INTO `admin_log`(`user_name`, `activity`) VALUES ('$adminName','Levels update level1:$level1 , level2:$level2 , level3:$level3 , level4:$level4 , level5:$level5, level6:$level6 , level7:$level7, level8:$level8')";
	            $result1 = mysqli_query($con,$qy);
	            
	            $_SESSION['successMsg']='Levels value update successfully';
				header("Location: level-percentage.php");
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
							<h4>Level Percentage</h4>
							<span>Check and Update Level Percentage. </span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Level Percentage</a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Page-header end -->
		<div class="page-body">
			<?php
			// Getting values from roi_percentage
			$sql_r = "SELECT * FROM `roi_percentage`";
			$run_r = mysqli_query($con, $sql_r);
			if(!$run_r){
			echo '<h6>'.mysqli_error( $con ).'</h6>';
			exit();
			}else{
			$roi_percentage = $row['roi_percentage'];
// 			$pkg_name = $row['pkg_name'];
			}
			?>
			<div class="container">
				<div class="row">
					<div class="col-sm-8 ml-auto mr-auto">
						
						<div class="auth-box card">
							<div class="card-block">
								<div class="row m-b-20">
									<div class="col-md-12">
										<h3 class="text-center ">Level Percentage</h3>

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
                            $q="SELECT * FROM `level_percentage` where id='1'";
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
										<label class="col-sm-3 col-form-label">Level 6 %</label>
										<div class="col-sm-9">
											<input autocomplete="off" type="text" class="form-control" name="level6"  value="<?=$res['level6']?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Level 7 %</label>
										<div class="col-sm-9">
											<input autocomplete="off" type="text" class="form-control" name="level7"  value="<?=$res['level7']?>">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Level 8 %</label>
										<div class="col-sm-9">
											<input autocomplete="off" type="text" class="form-control" name="level8"  value="<?=$res['level8']?>">
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