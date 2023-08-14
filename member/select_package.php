<?php
$page_title = 'Buy Package';
include 'header.php'; 

 if(isset($_POST['purchase']))
{
     
    $pkgPrice = mysqli_real_escape_string($con,$_POST['pkg_price']);
    $pkgIdPosted = mysqli_real_escape_string($con,$_POST['pkgIdPosted']);
    $mode = mysqli_real_escape_string($con,$_POST['mode']);
    
    if(empty($pkgIdPosted))
    {
        $_SESSION['errorMsg'] = "Invalid Request";
        header("location: buy-package.php");
        exit();
    }
    
     $pkgQuery1="select * from package where id='$pkgIdPosted'";
     $pkgResult1=mysqli_query($con,$pkgQuery1);
     $pkgResultData1 =mysqli_fetch_assoc($pkgResult1);
     $pkgNumRow1 = mysqli_num_rows($pkgResult1);
     
     if($pkgNumRow1 != 1)
     {
        $_SESSION['errorMsg'] = "Invalid Request";
        header("location: buy-pkg.php");
        exit(); 
     }
    
    if(empty($pkgPrice))
    {
        $_SESSION['errorMsg'] = "Please enter a valid amount";
        header("location: select_package.php?pkg_id=$pkgIdPosted");
        exit();
    }
    elseif(empty($mode))
    {
        $_SESSION['errorMsg'] = "Please select mode";
        header("location: select_package.php?pkg_id=$pkgIdPosted");
        exit();
    }
    
   
     
    $minAmount1 = $pkgResultData1['min_amount'];
    $maxAmount1 = $pkgResultData1['max_amount'];
     
    if($minAmount1 > $pkgPrice || $maxAmount1 < $pkgPrice)
    {
       $_SESSION['errorMsg'] = "Please enter valid amount between $minAmount1 and $maxAmount1";
        header("location: select_package.php?pkg_id=$pkgIdPosted");
        exit();  
    }
    
    if($mode =='usdt')
    {
        header("location: checkout-usdt.php?pkgPrice=$pkgPrice&pkgId=$pkgIdPosted");
        exit();
    }
    elseif($mode =='bank')
    {
        header("location: checkout-bank.php?pkgPrice=$pkgPrice&pkgId=$pkgIdPosted");
        exit();
    }
    elseif($mode =='iWallet')
    {
        header("location: checkout-balance.php?pkgPrice=$pkgPrice&pkgId=$pkgIdPosted");
        exit();
    }
   
}

elseif(isset($_GET['pkg_id']))
{
    
    $pkgId = mysqli_real_escape_string($con,$_GET['pkg_id']);
    
    $pkgQuery="select * from package where id='$pkgId'";
    $pkgResult=mysqli_query($con,$pkgQuery);
    $pkgResultData =mysqli_fetch_assoc($pkgResult);
    $pkgNumRow = mysqli_num_rows($pkgResult);
    
    if($pkgNumRow != 1)
    {
        $_SESSION['errorMsg'] = "Invalid Request";
        header("location: buy-pkg.php");
        exit();
    }

    $minAmount = $pkgResultData['min_amount'];
    $maxAmount = $pkgResultData['max_amount'];
    $packageName = $pkgResultData['package_name'];

}

else
{
     $_SESSION['errorMsg'] = "Invalid Request";
      header("location: buy-pkg.php");
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
        <div class="card ">
          <div class="card-body">
            
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
      
               <div class="card-title text-center"><h4><?php echo ucfirst($packageName);?></h4></div>
           <div class="row p-2 justify-content-center">
           <div class="col-md-6">
          <div class="card border-0" style="border:0 !important">
              <div class="card-body">
                    <div class="text-center">
                        <img height="250" src="assets/images/badges/<?=$packageName?>.png">
                        <hr>
                        <h4>$<?php echo $minAmount; ?> - $<?php echo $maxAmount; ?></h4>
                    </div>
                    <span class="text-danger" id="error"></span>
                    <form method="POST" action=''>
                    <input id="starterInput" name="pkg_price" type="text" class="form-control  form-control-sm" placeholder="<?php echo '$'.$minAmount.' $'.$maxAmount ?>">
                    <input id="" name="pkgIdPosted" type="hidden" value="<?php echo $pkgId;?>" class="form-control form-control-sm" >
                     
                     <label class="mb-2 mt-3">Select Mode</label>    
                    <div class="d-flex justify-content-between">
                    <div class="d-flex align-items-center radioError">
                        <b class="text-success">USDT (TRC20)</b> <input class="mx-2" type="radio" name="mode" value="usdt" id="usdt">
                    </div>
                    <div class="d-flex align-items-center">
                        <b class="text-danger">Bank</b> <input <input="" class="mx-2" type="radio" name="mode" value="bank" id="bank">
                    </div>
                    <div class="d-flex align-items-center">
                        <b class="text-primary">iWallet</b> <input <input="" class="mx-2" type="radio" name="mode" value="iWallet" id="iWallet">
                    </div>
                </div>
                
                    <input type="submit" id="purchase" name="purchase" value="Purchase" class="btn btn-sm mt-2 form-control bg-gradient-rose-button-dark text-white">
                    </form>
                    
              </div>
          </div>
      </div>
            </div>
      
      
      
      <!--silver-->
     
    </div>
  </div>
    
  </div>
  <!-- End container-fluid-->
  </div><!--End content-wrapper-->
  
  <?php include 'footer.php'; ?>

  
  