<?php
$page_title = 'Support';
include 'header.php'; 

		if (isset($_POST['submit_ticket'])) {
          $user_name = $_SESSION['user_name'];
          $subject = mysqli_real_escape_string($con, $_POST['subject']) ;
          $message = mysqli_real_escape_string($con, $_POST['message']) ;

          if(empty($subject) || empty($message)){
				$_SESSION['errorMsg'] =  "Please Complete the following form";
				header("Location: support.php");
				exit();

          }

          $sql="INSERT INTO support (`user_name`,`subject`,`message`) VALUES (?,?,?)";
          $stmt = $con->prepare($sql);
          $stmt->bind_param("sss", $user_name, $subject, $message);
			if ($stmt->execute() === TRUE) {
				$stmt->close();
				$_SESSION['successMsg']='You Ticket has been submmit successfully.';
				header("Location: support.php");
				exit();

			}else{
				$_SESSION['errorMsg'] =  "Error inserting record: " . $con->error;
				$stmt->close();
				header("Location: support.php");
				exit();
			}

        } 

?>
<!-- Page Content Start Here -->
<div class="page-wrapper">
	<div class="page-content">
		 <!--Breadcrumb-->
		<div class="row pt-2 pb-2">
			<div class="col-sm-9">
				<h4 class="page-title"><?= $page_title; ?></h4>
				<ol class="breadcrumb">
					<li class="breadcrumb-item"><a href="index.php">Home</a></li>
					<li> &nbsp; / &nbsp;</li>
					<li class="breadcrumb-item active" aria-current="page"><?= $page_title; ?></li>
				</ol>
			</div>
		</div>
		 <!--End Breadcrumb-->
		<div class="row">
			<div class="col-lg-10 col-md-8 col-sm-12 mx-auto">
				<div class="card">
					<div class="card-body">
						<div class="card-title">Generate Ticket</div>
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
						<form method = "POST">
						    <div class="form-group mt-3 mb-3">
						        <b>Email:</b> <span class="text-primary"><?= $email?></span>
						    </div>
							<div class="form-group">
								<label for="selectIssue">Select Issue</label>
								<select id="selectIssue" class="form-control form-control-rounded single-select" name="subject">
									<option value="">--- Select ---</option>
									<option value="Registration Related Issue">Registration Related Issue</option>
									<option value="Password Related Issue">Password Related Issue</option>
									<option value="Deposit Related Issue">Deposit Related Issue</option>
									<option value="Membership Related Issue">Membership Related Issue</option>
									<option value="Other">Other</option>
								</select>
							</div>
							<div class="form-group mt-3">
								<label for="messageText">Message</label>
								<textarea class="form-control" id="messageText" name="message" rows="4" placeholder="Message" ></textarea>
							</div>
							<div class="form-group">
								<button type="submit" class="btn  bg-gradient-rose-button text-white mt-3" name = "submit_ticket"><i class="icon-lock"></i> Submit Request</button>
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