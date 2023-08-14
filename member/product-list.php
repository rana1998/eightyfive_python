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




	if(isset($_POST['submit']))
	{
	    
		$mainCategory =  mysqli_real_escape_string($con,$_POST['mainCategoryName']);
		$subCategory =  mysqli_real_escape_string($con,$_POST['subCategoryName']);
		$productTitle =  mysqli_real_escape_string($con,$_POST['productTitle']);
		$productDescription =  mysqli_real_escape_string($con,$_POST['productDescription']);
		$productPrice = mysqli_real_escape_string($con,$_POST['productPrice']);
		$productStrikePrice = mysqli_real_escape_string($con,$_POST['productStrikePrice']);
		$productQuantity = mysqli_real_escape_string($con,$_POST['productQuantity']);
		$productPV = mysqli_real_escape_string($con,$_POST['productPV']);
		$productPromotion = mysqli_real_escape_string($con,$_POST['productPromotion']);
		$productId = intval($_POST['productId']);
		
		$file= $_FILES['productImage'];
		
// 		$_SESSION['errorMsg'] = "mainC = $mainCategory , subC = $subCategory , title = $productTitle ,
// 		desc= $productDescription , price= $productPrice , strike= $productStrikePrice , quanity = $productQuantity , PV = $productPV ,
// 		promotion = $productPromotion ,  id = $productId";
//             header("Location: product-list.php");
//             exit();
		
		
		 //Image settings
        $ImgName = $file['name'];
        $ImgError = $file['error'];
        $ImgTemp = $file['tmp_name'];
        $ImgSize = $file['size'];
    
        $ImgText = explode('.',$ImgName);
        $ImgCheck = strtolower(end($ImgText));
        
        if (empty($mainCategory) || empty($subCategory) || empty($productTitle) || empty($productDescription) || empty($productPrice)
        || empty($productQuantity) || empty($productPV) || empty($productPromotion) || empty($productId))
        {
            $_SESSION['errorMsg'] = "Please fill all data";
            header("Location: product-list.php");
            exit();
        }
        elseif (empty($ImgName))
        {
        
            
            $q="UPDATE `product` SET
            `main_category`='$mainCategory',
            `sub_category`='$subCategory',
            `product_title`='$productTitle',
            `product_description`='$productDescription',
            `product_price`='$productPrice',
            `product_strike_price`='$productStrikePrice',
            `product_quantity`='$productQuantity',
            `product_pv`='$productPV',
            `product_promotion`='$productPromotion'
             WHERE `id`='$productId'";
            $result= mysqli_query($con,$q);
            
            if($result==TRUE)
            {
                $_SESSION['successMsg'] = "Product Update successfully";
                header("Location: product-list.php");
                exit();
            }
            
        }
        elseif($ImgSize > 5000000)
        {
            $_SESSION['errorMsg'] = "Image size is greater than 5MB";
            header("Location: product-list.php");
            exit();
        }
        elseif($ImgCheck=='png' || $ImgCheck=='jpg' || $ImgCheck=='jpeg')
        {
            
      
          
            $ImgDestinationFile = 'images/product/' . md5(rand()) . '-' . $ImgName;
            move_uploaded_file($ImgTemp, $ImgDestinationFile);
            
            $q="UPDATE `product` SET
            `main_category`='$mainCategory',
            `sub_category`='$subCategory',
            `product_title`='$productTitle',
            `product_description`='$productDescription',
            `product_price`='$productPrice',
            `product_strike_price`='$productStrikePrice',
            `product_image`='$ImgDestinationFile',
            `product_quantity`='$productQuantity',
            `product_pv`='$productPV',
            `product_promotion`='$productPromotion'
             WHERE `id`='$productId'";
            $result= mysqli_query($con,$q);
            
            if($result==TRUE)
            {
                $_SESSION['successMsg'] = "Product created successfully";
                header("Location: product-list.php");
                exit();
            }
    
        }
        else
        {
            $_SESSION['errorMsg'] = "Image format not PNG, JPG, JPEG";
            header("Location: product-list.php");
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
							<h4>Product List</h4>
							<span>All Products </span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">All Products</a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Page-header end -->
		<div class="page-body">
			<div class="container">
			
				<!-- ROI Percentage Table -->
				<div class="row">
					<div class="col-sm-12">
					     <!-- Success Message -->
                                    <?php if (isset($_SESSION['successMsg'])) {
                                    ?>
                                    <div class="alert alert-success background-success">
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
												<th>Description</th>
												<th>Price</th>
												<th>Strike Price</th>
												<th>Quantity</th>
												<th>PV</th>
												<th>Promition</th>
												<th>Image</th>
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
												<td><a href="<?=$data['product_image']?>" target="_blank"><img src="<?=$data['product_image']?>" height="30"></a></td>
												<td><?php echo date('Y-m-d',strtotime($data['date']) );  ?></td>
											    <td>
											        <a href="product-list.php?id=<?=$data['id']?>&action=delete" class="btn btn-danger btn-sm">Delete</a>
											        
											        <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal<?=$x?>">
                                              Update
                                            </button>
                                            
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal<?=$x?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel<?=$x?>">Update Email</h5>
                                                  </div>
                                                  <div class="modal-body  pr-5">
                                                  <form enctype="multipart/form-data" method="POST">
								    
								    
										<label class="form-label">Main Category</label>
									
											<select name="mainCategoryName" class="form-control">
											    <option value="<?=$data['main_category'];?>"><?=$categoryName?></option>
											    <?php
											    $qq="SELECT * FROM `category`";
											    $resultt = mysqli_query($con,$qq);
											    while($ress = mysqli_fetch_assoc($resultt))
											    {
											        $categoryId = $ress['id'];
											        $categoryName = $ress['category_name'];
											    ?>
											    
											    <option value="<?=$categoryId?>"><?=$categoryName?></option>
											    
											    <?php
											    }
											    ?>
											</select>
								
									
									
										<label class="form-label">Sub Category</label>
									
											<select name="subCategoryName" class="form-control">
											    <option hidden value="<?=$data['sub_category'];?>"><?=$subCategoryName?></option>
											    <?php
											    $qq="SELECT * FROM `sub_category`";
											    $resultt = mysqli_query($con,$qq);
											    while($ress = mysqli_fetch_assoc($resultt))
											    {
											        $categoryId = $ress['id'];
											        $categoryName = $ress['sub_category'];
											    ?>
											    
											    <option value="<?=$categoryId?>"><?=$categoryName?></option>
											    
											    <?php
											    }
											    ?>
											</select>
									
									
										<label class="form-label">Product Title</label>
									
											<input type="text" class="form-control" value="<?=$data['product_title'] ?>" name="productTitle" id="productTitle">
									
									
										<label class="form-label">Product Description</label>
										
											<textarea type="text"  rows="8" class="form-control" name="productDescription" id="productDescription"><?=$data['product_description']?></textarea>   
								
										<label class="form-label">Product Price</label>
									
											<input type="text" value="<?=$data['product_price']?>" class="form-control" name="productPrice" id="productPrice" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
								
										<label class="form-label">Strike Price</label>
									
											<input type="text" value="<?=$data['product_strike_price']?>" class="form-control" name="productStrikePrice" id="productStrikePrice" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
									
									        
										<label class="form-label">Product Image <br><small class="text-danger">(300 x 338)</small></label>
									        <img src="<?=$data['product_image']?>" height="50" width="50">
											<input type="file" class="form-control" name="productImage" id="img" >
								
										<label class="form-label">Product Quantity</label>
										
											<input type="text" class="form-control" value="<?=$data['product_quantity']?>" name="productQuantity" id="productQuantity" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
									
								
										<label class="form-label">Product PV</label>
										
											<input type="text" class="form-control" value="<?=$data['product_pv']?>" name="productPV" id="productPV">
									
									
										<label class="form-label">Product Promotion</label>
										
											<select class="form-control" name="productPromotion" id="productPromotion">
											    <option value="<?=$data['product_promotion']?>"><?=$data['product_promotion']?></option>
											    <option value="Yes">Yes</option>
											    <option value="No">No</option>
											</select>    
									
									        <input type="hidden" name="productId" value="<?=$data['id']?>">
											<button type="submit" class="btn btn-warning waves-effect text-center m-t-20 m-b-20" name="submit">Update</button>
								
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
											<th>Category</th>
											<th>Sub Category</th>
											<th>Title</th>
											<th>Description</th>
											<th>Price</th>
											<th>Strike Price</th>
											<th>Quantity</th>
											<th>PV</th>
											<th>Promition</th>
											<th>Image</th>
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