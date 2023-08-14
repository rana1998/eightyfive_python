<?php
ob_start();
include "header.php";
// insert code
	if(isset($_POST['create'])){
		
		
		$date = mysqli_real_escape_string($con,$_POST['date']);
        $item = mysqli_real_escape_string($con,$_POST['item']);
        $deal = mysqli_real_escape_string($con,$_POST['deal']);
        $amount = mysqli_real_escape_string($con,$_POST['amount']);
        $profit = mysqli_real_escape_string($con,$_POST['profit']);
        $profitAmount = mysqli_real_escape_string($con,$_POST['profit_amount']);

        if(empty($date) || empty($item) || empty($deal) || empty($amount) || empty($profit) || empty($profitAmount))
        {
                $_SESSION['errorMsg']='Please fill all data';
				header("Location: trade-history.php");
				exit();
        }
        
        

		// Insert into roi_roi_percentage_summary table
		$insert = "INSERT INTO `trade_history`(`buy_order`, `amount`, `deal`, `profit`, `profit_amount`, `date`) 
		            VALUES ('$item','$amount','$deal','$profit','$profitAmount','$date')";
		$run_insert = mysqli_query($con, $insert);
			if(!$run_update && !$run_insert){
				echo '<h6>'.mysqli_error( $con ).'</h6>';
				exit();
			}



				$_SESSION['successMsg']='Trade Created Successfully.';
				header("Location: trade-history.php");
				exit();
	}
	
	//delete code
	if(isset($_GET['id']))
	{
	    $id = intval(mysqli_real_escape_string($con,$_GET['id']));
	    
	    $q="select * from trade_history where id='$id'";
	    $result = mysqli_query($con,$q);
	    if(mysqli_num_rows($result) == 1)
	    {
	        $qy="delete from trade_history where id='$id'";
	        $result2 = mysqli_query($con,$qy);
	        if($result2 == TRUE)
	        {
	            $_SESSION['successMsg']='Trade Delete Successfully.';
				header("Location: trade-history.php");
				exit();
	        }
	    }
	    else
	    {
	            $_SESSION['errorMsg']='Invalid Access';
				header("Location: trade-history.php");
				exit();
	    }
  
	}

    //update data
    
    if(isset($_POST['submit']))
    {
        $id = intval(mysqli_real_escape_string($con,$_POST['id']));
        $date = mysqli_real_escape_string($con,$_POST['date']);
        $item = mysqli_real_escape_string($con,$_POST['item']);
        $deal = mysqli_real_escape_string($con,$_POST['deal']);
        $amount = mysqli_real_escape_string($con,$_POST['amount']);
        $profit = mysqli_real_escape_string($con,$_POST['profit']);
        $profitAmount = mysqli_real_escape_string($con,$_POST['profit_amount']);

        if(empty($date) || empty($item) || empty($deal) || empty($amount) || empty($profit) || empty($profitAmount))
        {
                $_SESSION['errorMsg']='Please fill all data';
				header("Location: trade-history.php");
				exit();
        }
        
        
        $q="select * from trade_history where id='$id'";
	    $result = mysqli_query($con,$q);
	    if(mysqli_num_rows($result) == 1)
	    {
	        $qy="UPDATE `trade_history` SET `buy_order`='$item',`amount`='$amount',`deal`='$deal',`profit`='$profit',`profit_amount`='$profitAmount',`date`='$date' WHERE `id`='$id'";
	        $result2 = mysqli_query($con,$qy);
	        if($result2 == TRUE)
	        {
	            $_SESSION['successMsg']='Item Update Successfully.';
				header("Location: trade-history.php");
				exit();
	        }
	    }
	    else
	    {
	            $_SESSION['errorMsg']='Invalid Access';
				header("Location: trade-history.php");
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
							<h4>Trade History</h4>
							<span>Create your trading. </span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Trading</a> </li>
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
										<h3 class="text-center ">Create Trading</h3>

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
										<label class="col-sm-3 col-form-label">Date</label>
										<div class="col-sm-9">
											<input type="date" class="form-control" name="date">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Buy Order</label>
										<div class="col-sm-9">
											<select class="form-control" name="item">
											    <option value="" hidden>Select Buy order</option>
											    <?php
											    $query="select * from trade_item";
											    $queryResult = mysqli_query($con,$query);
											    while($res = mysqli_fetch_assoc($queryResult))
											    {
											    ?>
											    
											    <option value="<?=$res['item'] ?>"><?=$res['item'] ?></option>
											    <?php
											    }
											    ?>
											    
											    
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Select Deal</label>
										<div class="col-sm-9">
											<select class="form-control" name="deal">
											    <option value="" hidden>Select Deal</option>
											    <option value="open">Open</option>
											    <option value="close">Close</option>
											    <option value="nothing">Nothing</option>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Amount</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="amount" id="roi_percentage"  value="">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Profit %</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="profit" id="roi_percentage"  value="">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Profit Amount</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="profit_amount" id="roi_percentage"  value="">
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
												<th>Date</th>
												<th>Buy Order</th>
												<th>Amount</th>
												<th>Deal</th>
												<th>Profit %</th>
												<th>Profit Amount</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sql = "SELECT * FROM  trade_history ORDER BY `id` DESC";
											$result = mysqli_query($con, $sql);
											$x= 1;
											while ( $data = mysqli_fetch_array($result)):
											?>
											<tr>
												<td><?php echo $x++;  ?></td>
												<td><?php echo $data['date']  ?></td>
												<td><?php echo $data['buy_order']  ?></td>
												<td><?php echo $data['amount']  ?></td>
												<td><?php echo $data['deal']  ?></td>
												<td><?php echo $data['profit']  ?></td>
												<td><?php echo $data['profit_amount']  ?></td>
												
												<td>
												    <!--update record-->
												    <span style="cursor:pointer" class="m-3 text-primary">
												        <i class="fas fa-pencil" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$x?>"></i>
												    </span>
                                            
                                                     <a class="text-danger" href="trade-history.php?id=<?php echo $data['id']?>"><i class="fas fa-trash-alt"></i></a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal<?=$x?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel<?=$x?>">Update Item</h5>
                                                  </div>
                                                  <div class="modal-body">
                                                    <div class="p-3">
                                                        <form   method="POST">
                    								    <input type="hidden" name="id" value="<?=$data['id']?>">
                    								    <div class="form-group row">
                    										<label>Date</label>
                    										<input type="date" value="<?=$data['date']?>" class="form-control" name="date">
                    									</div>
                    									<div class="form-group row">
                    										<label>Buy Order</label>
                    										
                    											<select class="form-control" name="item">
                    											    <option value="<?=$data['buy_order']?>"  hidden><?=$data['buy_order']?></option>
                    											    <?php
                    											    $query="select * from trade_item";
                    											    $queryResult = mysqli_query($con,$query);
                    											    while($res = mysqli_fetch_assoc($queryResult))
                    											    {
                    											    ?>
                    											    
                    											    <option value="<?=$res['item'] ?>"><?=$res['item'] ?></option>
                    											    <?php
                    											    }
                    											    ?>
                    											    
                    											    
                    											</select>
                    										
                    									</div>
                    									<div class="form-group row">
                    										<label>Select Deal</label>
                    									
                    											<select class="form-control" name="deal">
                    											    <option value="<?=$data['deal']?>"  hidden><?=$data['deal']?></option>
                    											    <option value="open">Open</option>
                    											    <option value="close">Close</option>
                    											    <option value="nothing">Nothing</option>
                    											</select>
                    										
                    									</div>
                    									<div class="form-group row">
                    										<label>Amount</label>
                    										
                    											<input type="text" value="<?=$data['amount']?>"  class="form-control" name="amount" id="roi_percentage">
                    										
                    									</div>
                    									<div class="form-group row">
                    										<label>Profit %</label>
                    										
                    											<input type="text" value="<?=$data['profit']?>"  class="form-control" name="profit" id="roi_percentage">
                    										
                    									</div>
                    									<div class="form-group row">
                    										<label>Profit Amount</label>
                    										
                    											<input type="text" value="<?=$data['profit_amount']?>"  class="form-control" name="profit_amount" id="roi_percentage">
                    										
                    									</div>
                    								
                    							
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                                   </form>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
												    
												    
												</td>
											</tr>
											<?php endwhile; ?>
										</tbody>
										<tfoot>
										<tr>
												<th>#</th>
												<th>Date</th>
												<th>Buy Order</th>
												<th>Amount</th>
												<th>Deal</th>
												<th>Profit %</th>
												<th>Profit Amount</th>
												<th>Action</th>
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