<?php
ob_start();
include "header.php";

if (isset($_POST['create'])) {
    $walletaddress = strtolower(mysqli_real_escape_string($con, $_POST['walletaddress']));
    $refferalusername = mysqli_real_escape_string($con, $_POST['refferalusername']);
    
    if (empty($walletaddress)) {
        $_SESSION['errorMsg'] = 'Please fill all data';
        header("Location: create_user.php");
        exit();
    }

    if ($refferalusername == "") {
        $sponsername = NULL;
    } else {
        $sponsername = $refferalusername;
    }
    
    $query = "SELECT `id` FROM `user_registration` ORDER BY `id` DESC LIMIT 1";
    $result = mysqli_query($con, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        $lastId = $row['id'];
        $last = $lastId + 1;
        $username = 'MLM' . $last;
        
        if($refferalusername == "") {
            $insert = "INSERT INTO `user_registration`(`wallet_address`, `user_name`, `verified`, `status`, `kyc`) VALUES ('$walletaddress','$username','1','Approved', 'Verified')";
        } else {
        echo   $insert = "INSERT INTO `user_registration`(`wallet_address`, `sponsor_name`, `user_name`, `verified`, `status`, `kyc`) VALUES ('$walletaddress','$sponsername','$username','1','Approved', 'Verified')";
        }

        $run_insert = mysqli_query($con, $insert);
        
        if (!$run_insert) {
            echo '<h6>' . mysqli_error($con) . '</h6>';
            exit();
        }
        
        $_SESSION['successMsg'] = 'User Created Successfully.';
        header("Location: create_user.php");
        exit();
    } else {
        echo "Failed to retrieve last ID: " . mysqli_error($con);
        exit();
    }
}

?>
<!-- Rest of the HTML code -->


<!-- Main-body start -->
<div class="main-body">
	<div class="page-wrapper">
		<!-- Page-header start -->
		<div class="page-header">
			<div class="row align-items-end">
				<div class="col-lg-8">
					<div class="page-header-title">
						<div class="d-inline">
							<h4>User</h4>
							<span>Create User</span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">User</a> </li>
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
										<h3 class="text-center ">Create User</h3>

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
										<label class="col-sm-3 col-form-label">User Wallet Address</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="walletaddress" id="packageName"  value="">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Select Referral</label>
										<div class="col-sm-9">
											<!--<input type="number" class="form-control" name="returnCapital" id="returnCapital"  value="">-->
											<select class="form-control" id="returnCapital" name="refferalusername">
    <option value="0">Not Referred by anyone</option>
    <?php 
    $sql = "SELECT * FROM `user_registration` WHERE 1";
    $result = mysqli_query($con, $sql);
    while ($data = mysqli_fetch_array($result)) {
        $hello = $data['user_name'];
    ?>
    <option value="<?php echo $hello; ?>"><?php echo $hello; ?></option>
    <?php } ?>
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