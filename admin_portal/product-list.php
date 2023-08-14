<?php
ob_start();
include "header.php";
// delete function

if(isset($_GET['id']) and $_GET['action']=='delete')
{
    
    $id = intval(mysqli_real_escape_string($con,$_GET['id']));
    
    
    $q="delete from product where id='$id'";
    $result= mysqli_query($con,$q);
    
    if($result == TRUE)
    {
        $_SESSION['successMsg']='Product delete successfully';
        header("location:product-list.php");
        exit();
        
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
							<h4>Ebook</h4>
							<span>Product List</span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Product List</a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Page-header end -->
		<div class="page-body">
		
			<div class="container">

				</div>
			   <!-- ROI Percentage Table -->
				<div class="row">
				    
				    
					<div class="col-sm-12">
						<!-- HTML5 Export Buttons table start -->
						<div class="card">
							<div class="card-header table-card-header text-center">
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
							<div class="card-block">
								<div class="dt-responsive table-responsive">
									<table id="basic-btn" class="table table-sm table-striped table-bordered " data-page-length='10'>
										<thead>
											<tr>
												<th>#</th>
												<th>Category</th>
												<th>Sub Category</th>
												<th>Title</th>
												
											
												
												<!--<th>PV</th>-->
												<!--<th>Promition</th>-->
												<th>File</th>
												<th>Date</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody>
											<?php
											$sql = "SELECT * FROM  product ORDER BY `date` DESC";
											$result = mysqli_query($con, $sql);
											$x= 1;
											while ( $data = mysqli_fetch_array($result)):
											?>
											<tr>
												<td><?php echo $x++;  ?></td>
												<td>
												<?php
												$id = $data['main_category'];
												$q="select * from category where id='$id'";
												$result2 = mysqli_query($con,$q);
												$res = mysqli_fetch_assoc($result2);
												$categoryName = $res['category_name'];
												echo $categoryName;
												
												?>
												</td>
												<td>
												    <?php
												$id = $data['sub_category'];
												$q="select * from sub_category where id='$id'";
												$result2 = mysqli_query($con,$q);
												$res = mysqli_fetch_assoc($result2);
												$subCategoryName = $res['sub_category'];
												echo $subCategoryName;
												
												?>
												</td>
												<td><?=$data['product_title'] ?></td>
												
											
												<td><a href="<?=$data['product_image']?>" target="_blank"><?=$data['product_image']?></a></td>
												<td><?php echo date('Y-m-d',strtotime($data['date']) );  ?></td>
											    <td>
											        <a href="product-list.php?id=<?=$data['id']?>&action=delete" class="btn btn-danger btn-sm">Delete</a>
											        
											    </td>
											</tr>
											<?php endwhile; ?>
										</tbody>
										<tfoot>
										<tr>
												<th>#</th>
												<th>Category</th>
												<th>Sub Category</th>
												<th>Title</th>
											
												<!--<th>PV</th>-->
												<!--<th>Promition</th>-->
												<th>File</th>
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