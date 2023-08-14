<?php
$page_title = 'Sub Category';
include 'header.php'; 

// Update ROI Percentage Value
	if(isset($_POST['submit']))
	{
		$mainCategory =  mysqli_real_escape_string($con,$_POST['mainCategoryName']);
		$subCategory =  mysqli_real_escape_string($con,$_POST['subCategoryName']);

        if (empty($mainCategory))
        {
            $_SESSION['errorMsg'] = "Please select main category";
            header("Location: sub-category.php");
            exit();
        }
        elseif (empty($subCategory))
        {
            $_SESSION['errorMsg'] = "Please provide sub category";
            header("Location: sub-category.php");
            exit();
        }
        else {
            $q="INSERT INTO `sub_category`(`main_category_id`, `sub_category`) 
            VALUES ('$mainCategory','$subCategory')";
            $result= mysqli_query($con,$q);
            if($result==TRUE)
            {
                $_SESSION['successMsg'] = "Category created successfully";
                header("Location: sub-category.php");
                exit();
            }
    
        }
	}
 
	



?>
<!-- Page Content Start Here -->
<div class="page-wrapper">
    <div class="page-content">
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
      <div class="col-sm-9">
        <h4 class="page-title"><?= $page_title; ?></h4>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li>&nbsp; / &nbsp;</li>
          <li class="breadcrumb-item active" aria-current="page"><?= $page_title; ?></li>
        </ol>
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
												<th>Sub Category</th>
												<th>Title</th>
												<th>Date</th>
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
												<td><?=$data['product_description'] ?></td>
												<td><?='PKR '.$data['product_price'] ?></td>
												<td><?php
												if($data['product_strike_price']=='')
												{
												    echo '';
												}
												else
												{
												   echo 'PKR '.$data['product_strike_price'];
												}
												
												?></td>
												<td><?=$data['product_quantity'] ?></td>
												<td><?=$data['product_pv'] ?></td>
												<td><?=$data['product_promotion'] ?></td>
												<td><a href="assets/images/products/<?=$data['product_image']?>" target="_blank"><img src="assets/images/products/<?=$data['product_image']?>" height="30"></a></td>
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
  <!-- End container-fluid-->
  
  </div><!--End content-wrapper-->
  
  <?php include 'footer.php'; ?>
  
  <script>

  </script>