<?php
ob_start();
include "header.php";
// insert code
	if(isset($_POST['update_roi'])){
		$roiVal = $_POST['roi_percentage'];

        if(empty($roiVal))
        {
                $_SESSION['errorMsg']='Enter Item';
				header("Location: trade-item.php");
				exit();
        }

		// Insert into roi_roi_percentage_summary table
		$insert = "INSERT INTO `trade_item`(`item`)
					VALUES('$roiVal')";
		$run_insert = mysqli_query($con, $insert);
			if(!$run_update && !$run_insert){
				echo '<h6>'.mysqli_error( $con ).'</h6>';
				exit();
			}



				$_SESSION['successMsg']='Item Created Successfully.';
				header("Location: trade-item.php");
				exit();
	}
	
	//delete code
	if(isset($_GET['id']))
	{
	    $id = intval(mysqli_real_escape_string($con,$_GET['id']));
	    
	    $q="select * from trade_item where id='$id'";
	    $result = mysqli_query($con,$q);
	    if(mysqli_num_rows($result) == 1)
	    {
	        $qy="delete from trade_item where id='$id'";
	        $result2 = mysqli_query($con,$qy);
	        if($result2 == TRUE)
	        {
	            $_SESSION['successMsg']='Item Delete Successfully.';
				header("Location: trade-item.php");
				exit();
	        }
	    }
	    else
	    {
	            $_SESSION['errorMsg']='Invalid Access';
				header("Location: trade-item.php");
				exit();
	    }
  
	}

    //update data
    
    if(isset($_POST['submit']))
    {
        $id = intval(mysqli_real_escape_string($con,$_POST['id']));
        $newItem = mysqli_real_escape_string($con,$_POST['newItem']);
        
        if(empty($newItem))
        {
                $_SESSION['errorMsg']='Enter Item Value';
				header("Location: trade-item.php");
				exit();
        }
        
        
        $q="select * from trade_item where id='$id'";
	    $result = mysqli_query($con,$q);
	    if(mysqli_num_rows($result) == 1)
	    {
	        $qy="update trade_item set item ='$newItem' where id='$id'";
	        $result2 = mysqli_query($con,$qy);
	        if($result2 == TRUE)
	        {
	            $_SESSION['successMsg']='Item Update Successfully.';
				header("Location: trade-item.php");
				exit();
	        }
	    }
	    else
	    {
	            $_SESSION['errorMsg']='Invalid Access';
				header("Location: trade-item.php");
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
							<h4>Trade Items</h4>
							<span>Create your trade item. </span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Trade Item</a> </li>
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
										<h3 class="text-center ">Create Trade Item</h3>

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
										<label class="col-sm-3 col-form-label">Enter Item</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="roi_percentage" id="roi_percentage"  value="">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-12">
											<button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" name = "update_roi">Create</button>
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
												<th>Item</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sql = "SELECT * FROM  trade_item ORDER BY `date` DESC";
											$result = mysqli_query($con, $sql);
											$x= 1;
											while ( $data = mysqli_fetch_array($result)):
											?>
											<tr>
												<td><?php echo $x++;  ?></td>
												<td><?php echo $data['item']  ?></td>
												<td>
												   
												    
												    <!--update record-->
												    <span style="cursor:pointer" class="m-3 text-primary">
												        <i class="fas fa-pencil" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$x?>"></i>
												    </span>
                                            
                                                     <a class="text-danger" href="trade-item.php?id=<?php echo $data['id']?>"><i class="fas fa-trash-alt"></i></a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal<?=$x?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel<?=$x?>">Update Item</h5>
                                                  </div>
                                                  <div class="modal-body">
                                                   <form method="post">
                                                        <div class="row p-2 mx-auto">
                                                            <input type="hidden" name="id" value="<?php echo $data['id']?>">
                                                        <div>
                                                            <label>Current Item</label>
                                                            <input type="text" name="currentItem" value="<?=$data['item']?>" readonly class="form-control">  
                                                        </div>
                                                        <br>
                                                        <div>
                                                            <label>Enter Item</label>
                                                            <input type="text" name="newItem" class="form-control">
                                                        </div>
                                                        
                                                    </div>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                                   </form>
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
											<th>Item</th>
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