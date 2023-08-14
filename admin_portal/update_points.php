<?php
	include "header.php";
// Getting user details from tree table 
	if(isset($_GET['id']) && !empty($_GET['id'])){
		$getid = $_GET['id'];
		$select = "SELECT * FROM tree WHERE id = '$getid'";
		$selrun = mysqli_query($con, $select);
		if(mysqli_num_rows($selrun) >0){
			$fetch = mysqli_fetch_array($selrun);
		}else{
			$_SESSION['errorMsg'] = "Invalid Request.";
			header("Location: all_points.php");
			exit();
		}
	}else{
			$_SESSION['errorMsg'] = "Invalid Request.";
			header("Location: all_points.php");
			exit();
	}


// Update Current points and ROI points in tree table

	if(isset($_POST['update'])){
		$one 	= mysqli_real_escape_string( $con,   $_POST['one']);
		$two 	= mysqli_real_escape_string( $con,   $_POST['two']);
		$three 	= mysqli_real_escape_string( $con,   $_POST['three']);
		$update = " UPDATE tree 
					SET `left_points` ='$one', `right_points` = '$two', `binary_points` = '$three'
					WHERE `id` = '$getid'";
		$res = mysqli_query($con, $update);
		if(!$res)
		{
			$_SESSION['errorMsg'] = mysqli_error($con);
			header("Location: all_points.php");
			exit();
		}else{
			$_SESSION['successMsg'] = "Update Successfully.";
			header("Location: all_points.php");
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
							<h4>Update Points</h4>
							<span>Update Users Left, Right and Binary Points.</span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index.php"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Update Points</a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Page-header end -->
		<div class="page-body">
			<div class="row">
				<div class="col-md-6 ml-auto mr-auto">
					<form class="md-float-material form-material" method = "POST">
						<div class="auth-box card">
							<div class="card-block">
								<div class="row m-b-20">
									<div class="col-md-12">
										<h3 class="text-center">Update Points</h3>
									</div>
								</div>
								<div class="form-group form-primary">
									<label>Username</label>
									<input type = "text" name="user_name" class="form-control" value = "<?php echo $fetch['user_name']; ?>" readonly/>
								</div>
								<div class="form-group form-primary">
									<label>Left Points</label>
									<input type = "text" name="one" class="form-control" value = "<?php echo $fetch['left_points']; ?>"/>
								</div>
								<div class="form-group form-primary">
									<label>Right Points</label>
									<input type = "text" name="two" class="form-control" value = "<?php echo $fetch['right_points']; ?>"/>
								</div>
								<div class="form-group form-primary">
									<label>Binary Points</label>
									<input type = "text" name="three" class="form-control" value = "<?php echo $fetch['binary_points']; ?>"/>
								</div>
								<div class="row m-t-30">
									<div class="col-md-12">
										<button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" name = "update">Update</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
				</div> <!-- .row -->
			</div>
		</div>
	</div>
	<?php
		include "footer.php";
	?>