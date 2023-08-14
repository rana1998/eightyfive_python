<?php
ob_start();
include "header.php";

//random string
function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$productCode = generateRandomString();

// Create product 
	if(isset($_POST['submit']))
	{
	    
		$mainCategory =  mysqli_real_escape_string($con,$_POST['mainCategoryName']);
		$subCategory =  mysqli_real_escape_string($con,$_POST['subCategoryName']);
		$productTitle =  mysqli_real_escape_string($con,$_POST['productTitle']);
		$productDescription =  mysqli_real_escape_string($con,$_POST['productDescription']);
		$productPrice = mysqli_real_escape_string($con,$_POST['productPrice']);
		$productStrikePrice = mysqli_real_escape_string($con,$_POST['productStrikePrice']);
		$productQuantity = mysqli_real_escape_string($con,$_POST['productQuantity']);
// 		$productPV = mysqli_real_escape_string($con,$_POST['productPV']); 
// 		$productPromotion = mysqli_real_escape_string($con,$_POST['productPromotion']);
		$productPV = '0';
		$productPromotion = 'No';
		
		$file= $_FILES['productImage'];
		
		 //Image settings
        $ImgName = $file['name'];
        $ImgError = $file['error'];
        $ImgTemp = $file['tmp_name'];
        $ImgSize = $file['size'];
    
        $ImgText = explode('.',$ImgName);
        $ImgCheck = strtolower(end($ImgText));
        
        if(empty($mainCategory) || empty($subCategory) || empty($productTitle) || empty($productDescription) || empty($productPrice) || empty($productQuantity))
        {
             $_SESSION['errorMsg'] = "Please fill all data";
            header("Location: create-product.php");
            exit();  
        }
        elseif (empty($ImgName))
        {
            $_SESSION['errorMsg'] = "Please select image";
            header("Location: create-product.php");
            exit();
        }
        elseif($ImgSize > 5000000)
        {
            $_SESSION['errorMsg'] = "Image size is greater than 5MB";
            header("Location: create-product.php");
            exit();
        }
        elseif($ImgCheck=='png' || $ImgCheck=='jpg' || $ImgCheck=='jpeg')
        {
          
            $ImgDestinationFile = 'images/product/' . md5(rand()) . '-' . $ImgName;
            move_uploaded_file($ImgTemp, $ImgDestinationFile);
            
            $q="INSERT INTO `product`(`main_category`, `sub_category`,`product_code`, `product_title`, `product_description`, `product_price`, `product_strike_price`, `product_image`, `product_quantity`, `product_pv`, `product_promotion`) 
                VALUES ('$mainCategory','$subCategory','$productCode','$productTitle','$productDescription','$productPrice','$productStrikePrice','$ImgDestinationFile','$productQuantity','$productPV','$productPromotion')";
            
            $result= mysqli_query($con,$q);
            
            if($result==TRUE)
            {
                $_SESSION['successMsg'] = "Product created successfully";
                header("Location: create-product.php");
                exit();
            }
    
        }
        else
        {
            $_SESSION['errorMsg'] = "Image format not PNG, JPG, JPEG";
            header("Location: create-product.php");
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
							<h4>Create Product</h4>
							<span>Create new product </span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Create Product</a> </li>
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
										<h3 class="text-center ">Create Product</h3>

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
								<form  class="md-float-material form-material" enctype="multipart/form-data" method="POST">
								    
								    <div class="form-group row">
										<label class="col-sm-3 col-form-label">Main Category</label>
										<div class="col-sm-9">
											<select name="mainCategoryName" class="form-control">
											    <option hidden value="">Select Category</option>
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
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Sub Category</label>
										<div class="col-sm-9">
											<select name="subCategoryName" class="form-control">
											    <option hidden value="">Select Category</option>
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
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Product Title</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="productTitle" id="productTitle">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Product Description</label>
										<div class="col-sm-9">
											<textarea type="text" rows="8" class="form-control" name="productDescription" id="productDescription">
											 </textarea>   
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Product Price</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="productPrice" id="productPrice" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Strike Price</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="productStrikePrice" id="productStrikePrice" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Product Image <br><small class="text-danger">(300 x 338)</small></label>
										<div class="col-sm-9">
											<input type="file" class="form-control" name="productImage" id="img" >
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-3 col-form-label">Product Quantity</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="productQuantity" id="productQuantity" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
										</div>
									</div>
									<!--<div class="form-group row">-->
									<!--	<label class="col-sm-3 col-form-label">Product PV</label>-->
									<!--	<div class="col-sm-9">-->
									<!--		<input type="text" class="form-control" name="productPV" id="productPV">-->
									<!--	</div>-->
									<!--</div>-->
									<!--<div class="form-group row">-->
									<!--	<label class="col-sm-3 col-form-label">Product Promotion</label>-->
									<!--	<div class="col-sm-9">-->
									<!--		<select class="form-control" name="productPromotion" id="productPromotion">-->
									<!--		    <option value="" hidden>Select</option>-->
									<!--		    <option value="Yes">Yes</option>-->
									<!--		    <option value="No">No</option>-->
									<!--		</select>    -->
									<!--	</div>-->
									<!--</div>-->
									<div class="form-group row">
										<div class="col-md-12">
											<button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" name="submit">Create</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php
include "footer.php";
?>