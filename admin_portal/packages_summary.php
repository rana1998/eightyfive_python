<?php
ob_start();
include "header.php";

	
	//delete code
	if(isset($_GET['id']))
	{
	    $id = intval(mysqli_real_escape_string($con,$_GET['id']));
	    
	    $q="select * from package where id='$id'";
	    $result = mysqli_query($con,$q);
	    if(mysqli_num_rows($result) == 1)
	    {
	        $qy="delete from package where id='$id'";
	        $result2 = mysqli_query($con,$qy);
	        if($result2 == TRUE)
	        {
	            $_SESSION['successMsg']='Package Delete Successfully.';
				header("Location: packages_summary.php");
				exit();
	        }
	    }
	    else
	    {
	            $_SESSION['errorMsg']='Invalid Access';
				header("Location: packages_summary.php");
				exit();
	    }
  
	}

    //update data
    
    if(isset($_POST['submit']))
    {
       	
       	$id = intval($_POST['id']);
		$packageName = strtolower(mysqli_real_escape_string($con,$_POST['packageName']));
        $noOfDays = mysqli_real_escape_string($con,$_POST['noOfDays']);
        $percentage = mysqli_real_escape_string($con,$_POST['percentage']);
        $minAmount = mysqli_real_escape_string($con,$_POST['minAmount']);
        $maxAmount = mysqli_real_escape_string($con,$_POST['maxAmount']);
        $returnCapital = mysqli_real_escape_string($con,$_POST['returnCapital']);

        if(empty($packageName) || empty($noOfDays) || empty($percentage) || empty($minAmount) || empty($maxAmount) || empty($returnCapital))
        {
                $_SESSION['errorMsg']='Please fill all data';
				header("Location: packages_summary.php");
				exit();
        }
        else
        {   
            $file= $_FILES['file'];  
            $ImgName = $file['name'];
        $ImgError = $file['error'];
        $ImgTemp = $file['tmp_name'];
        $ImgSize = $file['size'];
    
        $ImgText = explode('.',$ImgName);
        $ImgCheck = strtolower(end($ImgText));
        
        if(empty($ImgName))
        {
           
        
                $q="select * from package where id='$id'";
        	    $result = mysqli_query($con,$q);
        	    if(mysqli_num_rows($result) == 1)
        	    {
        	        $qy="UPDATE `package` SET `package_name`='$packageName',`no_of_days`='$noOfDays',`percentage_per_day`='$percentage',
        	        `min_amount`='$minAmount',`max_amount`='$maxAmount',`capital`='$returnCapital'  WHERE `id`='$id'";
        	        $result2 = mysqli_query($con,$qy);
        	        if($result2 == TRUE)
        	        {
        	            $_SESSION['successMsg']='Package Update Successfully.';
        				header("Location: packages_summary.php");
        				exit();
        	        }
        	    }
        	    else
        	    {
        	            $_SESSION['errorMsg']='Invalid Access';
        				header("Location: packages_summary.php");
        				exit();
        	    } 
          }    
          
          else{
              
            if($ImgSize > 5000000)
           {
            $_SESSION['errorMsg'] = "Image size is greater than 5MB";
            header("Location: packages_summary.php");
            exit();
           }
        elseif($ImgCheck=='png' || $ImgCheck=='jpg' || $ImgCheck=='jpeg')
        {
          $ImgName = preg_replace("/\s+/","", $ImgName);
            $ImgDestinationFile = 'images/packageImages/'.md5(rand()).'-'.$ImgName;
            move_uploaded_file($ImgTemp, $ImgDestinationFile);
            
             $q="select * from package where id='$id'";
        	    $result = mysqli_query($con,$q);
        	    if(mysqli_num_rows($result) == 1)
        	    {
        	        $qy="UPDATE `package` SET `package_name`='$packageName',`no_of_days`='$noOfDays',`percentage_per_day`='$percentage',
        	        `min_amount`='$minAmount',`max_amount`='$maxAmount', `image` = '$ImgDestinationFile', `capital`='$returnCapital'  WHERE `id`='$id'";
        	        $result2 = mysqli_query($con,$qy);
        	        if($result2 == TRUE)
        	        {
        	            $_SESSION['successMsg']='Package Update Successfully.';
        				header("Location: packages_summary.php");
        				exit();
        	        }
        	    }
        	    else
        	    {
        	            $_SESSION['errorMsg']='Invalid Access';
        				header("Location: packages_summary.php");
        				exit();
        	    } 
           
        
          }
         else
        {
            $_SESSION['errorMsg'] = "Image format not PNG, JPG, JPEG";
           header("Location: packages_summary.php");
        	exit();
        }
              
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
							<h4>Package</h4>
							<span>Package Details </span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Package</a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Page-header end -->
		<div class="page-body">
			<div class="container">
               	<div class="row m-b-20">
									<div class="col-md-12">

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
				<!-- Table -->
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
												<th>Package Name</th>
												<th>No of days</th>
												<th>Percentage per day</th>
												<th>Min amount</th>
												<th>Max amount</th>
												<th>Image</th>
												<th>Return Capital</th>
												<th>Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sql = "SELECT * FROM  package ORDER BY `id` DESC";
											$result = mysqli_query($con, $sql);
											$x= 1;
											while ( $data = mysqli_fetch_array($result)):
											?>
											<tr>
												<td><?php echo $x++;  ?></td>
												<td><?php echo $data['package_name']  ?></td>
												<td><?php echo $data['no_of_days']  ?></td>
												<td><?php echo $data['percentage_per_day']  ?></td>
												<td><?php echo '$'.$data['min_amount']?></td>
												<td><?php echo '$'.$data['max_amount']?></td>
												<td><img src="https://demo.fliktus.com/admin_portal/<?php echo $data['image']?>" class="img-fluid" style="height:40px;width:40px" alt="image"></td>
												<td><?php echo $data['capital']?></td>
												<td><?php echo date('Y-m-d',strtotime($data['date']))?></td>
												<td>
												    <!--update record-->
												    <span style="cursor:pointer" class="m-3 text-primary">
												        <i class="fas fa-pencil" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$x?>"></i>
												    </span>
                                            
                                                     <a class="text-danger" href="packages_summary.php?id=<?php echo $data['id']?>"><i class="fas fa-trash-alt"></i></a>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal<?=$x?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel<?=$x?>">Update Item</h5>
                                                  </div>
                                                  <div class="modal-body">
                                                    <div class="p-3">
                                                        <form   method="POST" enctype="multipart/form-data">
                    								    <input type="hidden" name="id" value="<?=$data['id']?>">
                    									<div class="form-group row">
                    										<label>Package Name</label>
                    										
                    											<input type="text" value="<?=$data['package_name']?>"  class="form-control" name="packageName" id="packageName">
                    										
                    									</div>
                    				
									<div class="form-group row">
										<label class="">No of days</label>
										
											<input type="number" value="<?=$data['no_of_days']?>" class="form-control" name="noOfDays" id="noOfDays"  value="">
										
									</div>
									<div class="form-group row">
										<label class="">Percentage Per Day</label>
										
											<input type="number" value="<?=$data['percentage_per_day']?>" class="form-control" name="percentage" id="percentage"  value="">
									
									</div>
										<div class="form-group row">
										<label class="">Min Amount</label>
										
											<input type="number" value="<?=$data['min_amount']?>" class="form-control" name="minAmount" id="minAmount"  value="">
										
									</div>
									<div class="form-group row">
										<label class="">Max Amount</label>
										
											<input type="number" value="<?=$data['max_amount']?>" class="form-control" name="maxAmount" id="maxAmount"  value="">
										
									</div>
									<div class="form-group row">
									    <img src="https://demo.fliktus.com/admin_portal/<?php echo $data['image']?>" class="img-fluid" style="height:70px;width:70px" alt="image">
									</div>
									<div class="form-group row">
										<label class="">Image (png, jpg, jpeg only)</label>
										
											<input type="file" class="form-control" name="file" id="file"  value="">
										
									</div>
										<div class="form-group row">
										<label class="">Return Capital</label>
										
										<select id="returnCapital" class="form-control" name="returnCapital" style="height: auto;">
										    <?php
										    if($data['capital'] == 'yes')
										    {
										        $yes = 'selected';
										    }
										    else
										    {
										        $yes = '';
										    }
										    if($data['capital'] == 'no')
										    {
										        $no = 'selected';
										    }
										    else
										    {
										        $no = '';
										    }
										    ?>
										    <option value="yes" <?php echo $yes;?>>yes</option>
										    <option value="no" <?php echo $no;?>>No</option>
										</select>
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
												<th>Package Name</th>
												<th>No of days</th>
												<th>Percentage per day</th>
												<th>Min amount</th>
												<th>Max amount</th>
												<th>Image</th>
												<th>Return Capital</th>
												<th>Date</th>
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