<?php
$page_title = 'Category';
include 'header.php'; 

// Update ROI Percentage Value
	if(isset($_POST['submit']))
	{
		$category =  mysqli_real_escape_string($con,$_POST['categoryName']);

        if (empty($category))
        {
            $_SESSION['errorMsg'] = "Please enter category name";
            header("Location: category.php");
            exit();
        }
        else
        {

            $q="INSERT INTO `category`(`category_name`) 
                VALUES ('$category')";
            $result= mysqli_query($con,$q);
            
            if($result==TRUE)
            {
                $_SESSION['successMsg'] = "Category created successfully";
                header("Location: category.php");
                exit();
            }
    
        }
	}



?>
  <div class="main-body">
	<div class="page-wrapper">
		<!-- Page-header start -->
		<div class="page-header">
			<div class="row align-items-end">
				<div class="col-lg-8">
					<div class="page-header-title">
						<div class="d-inline">
							<h4>Category</h4>
							<span>Main Category</span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Category</a> </li>
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
										<h3 class="text-center ">Add Category</h3>

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
							<form method = "POST">
              	<div class="form-group row">
					<label class="col-sm-3 col-form-label">Name</label>
					<div class="col-sm-9">
						<input type="text" class="form-control" name="categoryName" id="categoryName">
					</div>
				</div>
              <div class="input-group-sm mt-3">
                 	<button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" name="submit">Create</button>
                 <!--<button></button>-->
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
												<th>Category</th>
												
												<th>Date</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sql = "SELECT * FROM  category ORDER BY `date` DESC";
											$result = mysqli_query($con, $sql);
											$x= 1;
											while ( $data = mysqli_fetch_array($result)):
											?>
											<tr>
												<td><?php echo $x++;  ?></td>
												<td><?php echo $data['category_name'];  ?></td>
												<td><?php echo date('Y-m-d',strtotime($data['date']) );  ?></td>
											</tr>
											<?php endwhile; ?>
										</tbody>
										<tfoot>
										<tr>
											<th>#</th>
											<th>Category</th>
										
											<th>Date</th>
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
  
  <?php include 'footer.php'; ?>
  
  <script>

  </script>