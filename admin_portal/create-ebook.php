<?php
$page_title = 'Sub Category';
include 'header.php'; 

// Create product 
	if(isset($_POST['submit']))
	{
	    
		$mainCategory =  mysqli_real_escape_string($con,$_POST['mainCategoryName']);
		$subCategory =  mysqli_real_escape_string($con,$_POST['subCategoryName']);
		$productTitle =  mysqli_real_escape_string($con,$_POST['productTitle']);
		
		$file= $_FILES['productImage'];
		
		 //Image settings
        $ImgName = $file['name'];
        $ImgError = $file['error'];
        $ImgTemp = $file['tmp_name'];
        $ImgSize = $file['size'];
    
        $ImgText = explode('.',$ImgName);
        $ImgCheck = strtolower(end($ImgText));
        
        if (empty($mainCategory) || empty($subCategory) || empty($productTitle))
        {
            $_SESSION['errorMsg'] = "Please fill all data";
            header("Location: create-ebook.php");
            exit();
        }
        elseif (empty($ImgName))
        {
            $_SESSION['errorMsg'] = "Please select file";
            header("Location: create-ebook.php");
            exit();
        }
        elseif($ImgSize > 5000000)
        {
            $_SESSION['errorMsg'] = "File size is greater than 5MB";
            header("Location: create-ebook.php");
            exit();
        }
        elseif($ImgCheck=='png' || $ImgCheck=='jpg' || $ImgCheck=='jpeg' || $ImgCheck=='pdf' || $ImgCheck=='docx' || $ImgCheck=='doc' || $ImgCheck=='txt')
        {
          
            $ImgDestinationFile = 'images/product/' . md5(rand()) . '-' . $ImgName;
            move_uploaded_file($ImgTemp, $ImgDestinationFile);
            
            $q="INSERT INTO `product`(`main_category`, `sub_category`, `product_title`,  `product_image`) 
                VALUES ('$mainCategory','$subCategory','$productTitle','$ImgDestinationFile')";
            
            $result= mysqli_query($con,$q);
            
            if($result==TRUE)
            {
                $_SESSION['successMsg'] = "Product created successfully";
                header("Location: create-ebook.php");
                exit();
            }
    
        }
        else
        {
            $_SESSION['errorMsg'] = "file format not valid";
            header("Location: create-ebook.php");
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
							<span>Create Ebook</span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index-1.htm"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">Ebook</a> </li>
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
										<h3 class="text-center ">Create Ebook</h3>

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
							 <form method = "POST" enctype="multipart/form-data">
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
										<label class="col-sm-3 col-form-label">Ebook Title</label>
										<div class="col-sm-9">
											<input type="text" class="form-control" name="productTitle" id="productTitle">
										</div>
									</div>
				<div class="form-group row">
										<label class="col-sm-3 col-form-label">Ebook File </label>
										<div class="col-sm-9">
											<input type="file" class="form-control" name="productImage" id="img" >
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
			  
			</div>
		</div>
	</div>
</div>  
  
  
  <?php include 'footer.php'; ?>
  
  <script>

  </script>