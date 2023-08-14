<?php
	include "header.php";
// Getting user details from user_registration table 
	if(isset($_GET['id']) && !empty($_GET['id'])){
		$getid = $_GET['id'];
		$select = "SELECT * FROM user_registration WHERE id = '$getid'";
		$selrun = mysqli_query($con, $select);
		if(mysqli_num_rows($selrun) >0){
		$fetch = mysqli_fetch_array($selrun);
		$user_name = $fetch['user_name'];
		
// 		echo "$user_name";
		
		}else{
			$_SESSION['errorMsg'] = "Invalid Request.";
			header("Location: balance_update.php");
			exit();
		}
	}else{
			$_SESSION['errorMsg'] = "Invalid Request.";
			header("Location: balance_update.php");
			exit();
	}


// Update Current Balance and ROI Balance in user_registration table

	if(isset($_POST['update'])){
		$one   = intval(  mysqli_real_escape_string( $con,  $_POST['one']) );
		$two   = mysqli_real_escape_string( $con,  $_POST['two'] );
		$three = intval( mysqli_real_escape_string( $con,  $_POST['three']) );
		$four  = intval( mysqli_real_escape_string( $con,  $_POST['four']) );

		if(empty($two) || empty($three) || empty($four) ){
			$_SESSION['errorMsg'] = "Please fill all fields.";
			header("Location: edit_wallet.php?id=$getid");
			exit();

		}elseif($two == 'Debit' && $three != 0){
				$update = " UPDATE user_registration 
							SET `iwallet` = iwallet - '$three'
							WHERE `id` = '$getid'";
				$updateResult=mysqli_query($con,$update);			
				// inset into wallet summary
			    $insert_ws = "INSERT INTO wallet_summary(`user_name`, `amount`, `description`, `wallet_type`, `type`)
			    				                  VALUES('$user_name','$three','Debit By Admin','iWallet', 'Debit')";
			    $insertResult=mysqli_query($con,$insert_ws);
    			
    		
    			    $_SESSION['successMsg'] = "Update Successfully.";
        			header("Location: balance_update.php");
        			exit();
    			
    		
    			
                                                  
		}elseif($two == 'Credit' && $three != 0){
				$update = " UPDATE user_registration 
							SET `iwallet` = iwallet + '$three'
							WHERE `id` = '$getid'";
							$updateResult=mysqli_query($con,$update);

				// inset into wallet summary
			    $insert_ws = "INSERT INTO wallet_summary(`user_name`, `amount`, `description`, `wallet_type`, `type`)
			    				VALUES('$user_name','$three','Credit By Admin','iWallet', 'Credit')";
                $insertResult=mysqli_query($con,$insert_ws);
               
    			    $_SESSION['successMsg'] = "Update Successfully.";
        			header("Location: balance_update.php");
        			exit();
    			
    		
		}else{
			$_SESSION['errorMsg'] = "Enter Valid Amount.";
			header("Location: edit_balance.php?id=$getid");
			exit();
		}

// 		$res = mysqli_query($con, $update);
        // $run_insert_ws = mysqli_query($con, $insert_ws);    
// 		if(!$res){ echo mysqli_error($con); die();}
// 		else
// 		{
			
// 		} 
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
							<h4>Update iWallet</h4>
							<span>Update User iWallet</span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Update iWallet</a> </li>
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
										<h3 class="text-center">Update iWallet</h3>
									</div>
								</div>
								<div class="row m-b-20">
									<div class="col-md-12 text-center">
                                    
			                            <!-- Error Message  -->
			                    <?php if (isset($_SESSION['errorMsg'])) {
			                    ?>
			                    <div class="alert alert-danger background-danger">
			                        <button type="button" class="close m-0" data-dismiss="alert" aria-label="Close">
			                        <i class="icofont icofont-close-line-circled text-default"></i>
			                        </button>
			                        <strong>Error!</strong> <?php echo $_SESSION['errorMsg'];?>
			                    </div>
			                    <?php
			                    unset($_SESSION['errorMsg']);
			                    } ?>
								</div>
							</div>
								<div class="form-group form-primary">
									<label>Username</label>
									<input type = "text" name="user_name" class="form-control" value = "<?php echo $fetch['user_name']; ?>" readonly/>
								</div>
								<div class="form-group form-primary">
									<label>iWallet Balance</label>
									<input type = "text" name="one" id="currentBalance" class="form-control" value = "<?php echo $fetch['iwallet']; ?>" readonly/>
								</div>								
								<div class="form-group form-primary">
                                     <label class="col-form-label">Select Type:</label>	<b id="typeError" class="text-danger"></b>							    
                                    <select id="type" class="form-control " name="two" >
                                        <option value="">Choose one</option>
                                        <option value="Debit">Debit</option>
                                        <option value="Credit">Credit</option>
                                    </select>
								</div>
								
								<div class="form-group form-primary">
									<label>Enter Amount</label>
									<input autocomplete="off" type="text" name="three" id="enterAmount" class="form-control" value = "" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"/>
									<span id="valError"></span>
								</div>								
								<div class="form-group form-primary">
									<label>Updated Amount</label>
									<input type = "text" name="four"  id="updateAmount" class="form-control" value = "" readonly />
								</div>
								<div class="row m-t-30">
									<div class="col-md-12">
										<button type="submit" id="submitButton" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" name = "update">Update</button>
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
	
	<script>
	    $('#enterAmount').on("keyup",function()
	    {
	        var enterAmount = $('#enterAmount');
	        var updateAmount = $('#updateAmount');
	        var currentBalance  = $('#currentBalance');
	        var submitButton = $('#submitButton');
	        var type = $('#type');
	       // alert(enterAmount+' '+updateAmount+' '+currentBalance+' '+submitButton);
	       // alert(type.val());
	        if(type.val()==='')
	        {
	            $('#typeError').text('Plese select type first');

	        }
	        else if(type.val()==='Credit')
	        {
	            $('#typeError').text('');
	            
	            if(enterAmount.val() ==='')
    	        {
    	            updateAmount.val('');
    	            submitButton.show();
    	        }
    	        else
    	        {
    	            updateAmount.val(parseInt(currentBalance.val()) + parseInt(enterAmount.val()));
    	            submitButton.show();
    	            
    	        }
	        }
	        else if(type.val()==='Debit')
	        {
	            $('#typeError').text('');
	            
	            if(enterAmount.val() ==='')
    	        {
    	            updateAmount.val('');
    	            submitButton.show();
    	        }
    	        else if(enterAmount.val()  > currentBalance.val())
    	        {
    	            updateAmount.val('Available balance is low');
    	            submitButton.hide();
    	        }
    	        else
    	        {
    	            updateAmount.val(parseInt(currentBalance.val()-enterAmount.val()));
    	            submitButton.show();
    	        }
	        }
	        
	        
	    })
	</script>