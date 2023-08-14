<?php
ob_start();
include "header.php";

if(isset($_POST['submit']))
{
    
    $companyName = mysqli_real_escape_string($con,$_POST['companyName']);
    $modelName = mysqli_real_escape_string($con,$_POST['modelName']);
    
    // echo $companyName.$modelName;

    $q="select * from `auto_model` where `company`='$companyName' and model='$modelName'";
    $result=mysqli_query($con,$q);
    $resultRow= mysqli_num_rows($result);
    
    if(empty($companyName) || empty($modelName))
    {
        $_SESSION['errorMsg'] = ' Please enter company and model name ';
        header('location:auto_model.php');
        exit();
    }
    elseif($resultRow > 0)
    {
        $_SESSION['errorMsg'] = ' Company model name already in record ';
        header('location:auto_model.php');
        exit();
    }
    else
    {
        $qy="INSERT INTO `auto_model`( `company`,`model`) VALUES ('$companyName','$modelName')";
        $result2=mysqli_query($con,$qy);
        if($result2 == TRUE)
        {
             $_SESSION['successMsg'] = ' Model Added Successfully';
             header('location:auto_model.php');
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
							<h4>Auto Company Model</h4>
							<span>Add company model below. </span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Auto Company Model</a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Page-header end -->
		<div class="page-body">
			<div class="container">
				<div class="row">
					<div class="col-sm-6 ml-auto mr-auto">
						
						<div class="auth-box card">
							<div class="card-block">
								<div class="row m-b-20">
									<div class="col-md-12">
										<h3 class="text-center ">Add Company Model</h3>

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
								<form  class="md-float-material form-material" method="POST">
									
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Select Company</label>
										<div class="col-sm-9">
										    <?php 
									    $qyy="select * from auto_company";
									    $result3=mysqli_query($con,$qyy);
									  
									    ?>
											<select class="form-control" name="companyName">
											    <option value="">select company</option>
											    <?php while($res=mysqli_fetch_assoc($result3)){?>
										
											    <option value="<?php echo $res['company']?>"><?php echo $res['company']?></option>
											
											<?php
										    }
											?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Model Name</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="modelName" id="roi_percentage">
										</div>
									</div>
									<div class="form-group row">
										<div class="col-md-12">
											<button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" name = "submit">Submit</button>
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
									    <?php 
									    $qyy="select * from auto_model";
									    $result3=mysqli_query($con,$qyy);
									    $count=1;
									    ?>
										<thead>
											<tr>
												<th>#</th>
												<th>Company</th>
												<th>Model</th>
												<th>Date</th>
											</tr>
										</thead>
										<tbody>
										    <?php while($res=mysqli_fetch_assoc($result3)){?>
											<tr>
											    <td><?php echo $count++?></td>
											    <td><?php echo $res['company']?></td>
											    <td><?php echo $res['model']?></td>
											    <td><?php echo $res['date']?></td>
											</tr>
											<?php
										    }
											?>
										</tbody>
										<tfoot>
										<tr>
											<th>#</th>
											<th>Company</th>
											<th>Model</th>
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
<?php
include "footer.php";
?>