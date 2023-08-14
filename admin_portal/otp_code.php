<?php
ob_start();
include "header.php";


    //update data
    
    if(isset($_POST['submit']))
    {
       	
       	
		$otpCode = mysqli_real_escape_string($con,$_POST['otpCode']);
        
         if($otpCode == '')
        {
                $_SESSION['errorMsg']='Please select otp status';
				header("Location: otp_code.php");
				exit();
        }
        else
        {
               
        	        $qy="UPDATE `project_management` SET `otp_status`='$otpCode' WHERE `id`='1'";
        	        $result2 = mysqli_query($con,$qy);
        	        if($result2 == TRUE)
        	        {
        	            $_SESSION['successMsg']='Otp Code Status Update Successfully.';
        				header("Location: otp_code.php");
        				exit();
        	        }
        	    
        	    else
        	    {
        	            $_SESSION['errorMsg']='Error in updating record';
        				header("Location: otp_code.php");
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
							<h4>Otp Code</h4>
							<span>Otp Code Status</span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Otp Code</a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Page-header end -->
		<div class="page-body">
			<?php
			// Getting values from roi_percentage
			$sql_r = "SELECT * FROM `roi_percentage` where id='1'";
			$run_r = mysqli_query($con, $sql_r);
			if(!$run_r){
			echo '<h6>'.mysqli_error( $con ).'</h6>';
			exit();
			}else{
			$row = mysqli_fetch_assoc($run_r);  
			$roi_percentage = $row['roi_percentage'];
			}
			?>
			<div class="container">
				<div class="row">
					<div class="col-sm-8 ml-auto mr-auto">
						
						<div class="auth-box card">
							<div class="card-block">
								<div class="row m-b-20">
									<div class="col-md-12">
										<h3 class="text-center ">Update Status</h3>

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
								<form  class="md-float-material form-material" action="" method="POST">
							
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Otp Code Status</label>
										<div class="col-sm-9">
										<select class="form-control" id="otpCode" name="otpCode">
										    <option value="" hidden>Select</option>
										    <option value="0">Block</option>
										    <option value="1">Unblock</option>
										</select>
										</div>
									</div>
								
									<div class="form-group row">
										<div class="col-md-12">
											<button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" name = "submit">Update</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- ROI Percentage Table -->
				<div class="row">
					<div class="col-sm-12">
						<!-- HTML5 Export Buttons table start -->
						<div class="card">
							<div class="card-header table-card-header text-center">
							</div>
							<div class="card-block">
								<div class="dt-responsive table-responsive">
									<table id="basic-btn" class="table table-sm table-striped table-bordered " data-page-length='10'>
										<thead>
											<tr>
												<th>#</th>
												<th>Otp status</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sql = "SELECT * FROM `project_management`";
											$result = mysqli_query($con, $sql);
											$x= 1;
										    $data = mysqli_fetch_array($result);
											?>
											<tr>
											    <td><?php echo $x;?></td>
											    <td><?php 
											    if($data['otp_status'] == '1')
											    {
											        echo "<span class='badge badge-success p-1'>Unblock</span>";
											    }
											    else
											    {
											        echo "<span class='badge badge-warning text-light p-1'>Block</span>"; 
											    }
											    ?></td>
											</tr>
										</tbody>
										<tfoot>
										<tr>
												<th>#</th>
												<th>Otp status</th>
											
										</tr>
										</tfoot>
									</table>
								</div>
							</div>
						</div>
						<!-- HTML5 Export Buttons end -->
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
include "footer.php";
?>