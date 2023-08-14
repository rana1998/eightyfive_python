<?php
$page_title = 'Ebook';
include 'header.php'; 

    $sql1 = "SELECT * FROM user_registration where user_name = '$user_name' and status ='Approved'";
    $result2 = mysqli_query($con, $sql1);
    $rowCount1 = mysqli_num_rows($result2); 

if($rowCount1 >= 1)
{
if(isset($_GET['category']) and isset($_GET['subCategory']) and isset($_GET['bookName']) and !empty($_GET['category']) and !empty($_GET['subCategory']) and !empty($_GET['bookName']))
{
    $categoryId = $_GET['category'];
    $subCategory = $_GET['subCategory'];
    $bookName = $_GET['bookName'];
    $sql = "SELECT * FROM product where main_category='$categoryId' and sub_category= '$subCategory' and product_title = '$bookName'";
    $result1 = mysqli_query($con, $sql);
    $rowCount = mysqli_num_rows($result1);
}
else
{
   $sql = "SELECT * FROM product";
    $result1 = mysqli_query($con, $sql);
    $rowCount = mysqli_num_rows($result1); 
}
}
else
{
   $_SESSION['errorMsg'] ='Please purchase a package first';
   header("location: index.php");
   exit();
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
    <!-- End Breadcrumb-->
    <div class="row  mb-5">
      <div class="col-lg-12 mx-auto">
        <div class="card">
            <form class="row g-3 p-3" method="get">
									<div class="col-md-3">
										<select id="category" class="form-control" name="category">
										    <option value="" hidden>Select Catagory</option>
										    <?php
										    $q="SELECT * FROM `category`";
										    $result = mysqli_query($con,$q);
										    while($res = mysqli_fetch_assoc($result))
										    {
										      ?>
										      <option value="<?=$res['id']?>"><?=$res['category_name']?></option>
										      <?php
										    }
										    ?>
										</select>
									</div>
									<div class="col-md-3">
										<select class="form-control" id="subCategory" name="subCategory">
										    <option value="" hidden>Select Sub Catagory</option>
										</select>
									</div>
									<div class="col-md-3">
										<input type="text" class="form-control" placeholder="Enter e-book name" name="bookName">
									</div>
									<div class="col-md-3">
										<input type="submit" class="btn btn-primary" name="search" value="Search">
									</div>
			</form>						
        </div>  
        <div class="card">
          <div class="card-body">
            <div class="card-title">Product List</div>
              <?php if(isset($_SESSION['successMsg'])): ?>
                    <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
                        <div class="d-flex align-items-center">
                            <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                            </div>
                            <div class="ms-3">
                                <h6 class="mb-0 text-white">Success </h6>
                                <div class="text-white"><?php echo $_SESSION['successMsg']; ?></div>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php  unset($_SESSION['successMsg']);     endif;  ?>
                    
                        <?php if(isset($_SESSION['errorMsg'])): ?>
                        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                            <div class="d-flex align-items-center">
                                <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Error </h6>
                                    <div class="text-white"><?php echo $_SESSION['errorMsg']; ?></div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php  unset($_SESSION['errorMsg']);     endif;  ?>  
                        </div>
                    
                    
                    <div class="row p-2">
                        <!-- <div class="col-12"> -->
                        <!-- This card will be generated dynamically -->
                        <?php
                        
                        $x = 1;
                        if($rowCount >= 1)
                        {
                        while ( $data = mysqli_fetch_assoc($result1))
                        {
                        ?>
                        <div class="col-sm-12 col-md-4">
                            <div class="card text-center">
                                <div class="card-body m-2">
                                    <img src="assets/images/file.png" width="50"/>
                                </div>
                                    <p class="text-center text-capitalize"><a href="https://demo.fliktus.com/admin_portal/<?php echo $data['product_image'];  ?>" download><?php echo $data['product_title'];  ?></a></p>
                            </div>
                        </div>
                        <?php 
                        } 
                        }else
                        {
                          echo '<p class="text-center text-capitalize">No Record Found</p>';  
                        }
                        ?>
                        <!-- This card will be generated dynamically -->
                        <!-- </div> -->
                    </div>
      
      <!--silver-->
     
    </div>
  </div>
    
  </div>
  <!-- End container-fluid-->
  </div><!--End content-wrapper-->
  
  <?php include 'footer.php'; ?>

<script>
$('#category').on('change',function()
{
            $('#subCategory').html('');
            var value = $('#category').val();
             $.post( "ajax/category-ajax.php",{id:value},function(feedback) {
                var data = JSON.parse(feedback);
              
                if(data != null)
                {
                    $('#subCategory').append('<option value="" hidden>Select Sub Catagory</option>')
                $.each(data, function( index, value ) {
                    
                    var subCategoryId = value['id'];
                    var subCategory = value['sub_category'];

                    //this is for side cart
                    $('#subCategory').append('<option value="'+subCategoryId+'">'+subCategory+'</option>');
             
                });  
                }
                else
                {
                     $('#subCategory').append('<option value="">No Record found</option>')
                }
             });
})


        

</script>
  
  