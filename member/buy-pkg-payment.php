<?php
$page_title = 'Buy Package Payment Method ';
 include 'header.php'; 
 if(isset($_GET['pkg_id']))
 {
     if($_GET['pkg_id']=='')
     {
        header('location:index.php');
        exit(); 
     }
     
     $getPkgId=$_GET['pkg_id'];
     
     $pkgQuery="select * from package where id='$getPkgId'";
     $pkgResult=mysqli_query($con,$pkgQuery);
     $pkgResultData=mysqli_fetch_assoc($pkgResult);
     $pkgRows= mysqli_num_rows($pkgResult);
     if($pkgRows < 1)
     {
        header('location:index.php');
        exit();  
     }
    
     if(isset($_POST['submit']))
     {
         
         $method = $_POST['method'];
         if($method == 'balance')
         {
             
                header("location:checkout-balance.php?pkg_id=$getPkgId");
            //   echo"<script>alert('You select balance')</script>";
         }
         elseif($method=='usdt')
         {
             header("location:checkout-usdt.php?pkg_id=$getPkgId");
            //   echo"<script>alert('You select usdt')</script>";
         }
         elseif($method=='pm')
         {
             header("location:checkout-pm.php?pkg_id=$getPkgId");
            //   echo"<script>alert('You select pm')</script>";
         }
          elseif($method=='bank')
         {
             header("location:checkout-bank.php?pkg_id=$getPkgId");
            //   echo"<script>alert('You select pm')</script>";
         }
         else
         {
             $_SESSION['errorMsg']='Please select payment method';
             header("location: buy-pkg-payment.php?pkg_id=$getPkgId");
             exit();
            //  echo"<script>alert('You select none')</script>";
         }
         
         
         
        //  echo"<script>alert(".$method.")</script>";
         
     }
     
     
     
 }
 else
 {
     header('location:index.php');
     exit();
 }
 
 
 
?>
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
          <!--Start Content-->
         
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
                        <form method="POST" >
                         
                            <div class="row justify-content-center">
                                <div class="col-sm-4">
							<div style="border-bottom: 3px solid bg-gradient-rose-button" class="card mb-5 mb-lg-0">
								<div class="card-header bg-gradient-rose-button py-3">
									<h5 class="card-title text-white text-uppercase text-center"><?php echo $pkgResultData['pkg_name'];?></h5>
									<h6 class="card-price text-white text-center display-6"><b>$<?php echo $pkgResultData['pkg_price'];?></b></h6>
								</div>
								<div class="card-body">
									<ul class="list-group list-group-flush">
										<li class="list-group-item">
    										<div class="form-check">
            									<input class="form-check-input" type="radio" value="balance" name="method" id="flexRadioDefault1">
            									<label class="form-check-label" for="flexRadioDefault1">Balance</label>
            								</div>
										</li>
									    <li class="list-group-item">
    										<div class="form-check">
            									<input class="form-check-input" type="radio" value="usdt" name="method" id="flexRadioDefault2">
            									<label class="form-check-label" for="flexRadioDefault2">USDT</label>
            								</div>
										</li>
										<li class="list-group-item">
    										<div class="form-check">
            									<input class="form-check-input" type="radio" value="pm" name="method" id="flexRadioDefault3">
            									<label class="form-check-label" for="flexRadioDefault3">Perfect Money</label>
            								</div>
										</li>
											<li class="list-group-item">
    										<div class="form-check">
            									<input class="form-check-input" type="radio" value="bank" name="method" id="flexRadioDefault4">
            									<label class="form-check-label" for="flexRadioDefault4">Bank</label>
            								</div>
										</li>
								
									</ul>
									<div class="d-flex justify-content-end">
									     <div class="m-2"> <a href="buy-pkg.php" class="btn btn-secondary my-2 radius-20">Back</a></div>
									    <div class="m-2"> <input type="submit" name="submit" value="Check Out" class="btn bg-gradient-rose-button my-2 radius-20 text-white"></div>
									   
									</div>
								</div>
							</div>
						</div>
                            </div>
                        </form>
              
          <!--End Content-->
    </div>
    <!-- End container-fluid-->
</div><!--End content-wrapper-->


<?php include 'footer.php'; ?>