<?php 
ob_start();
	include "header.php";

    if(isset($_POST['buy_pkg'])){
        
        $uname2 = $uname1 = $uname = $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
        $pkg_price = mysqli_real_escape_string($con,$_POST['pkg_price']);
        $pkg_type = mysqli_real_escape_string($con,$_POST['pkg_type']);
    
    
    
  
    // Check if input are empty
    if (empty($user_name) || empty($pkg_price) || empty($pkg_type) ){
        $_SESSION['errorMsg'] = "Please fill all fields. ";
        header("Location: leader-package.php");
        exit();
    }
    elseif($pkg_price < 100)
    {
        $_SESSION['errorMsg'] = "Minimum package price is ".'$100';
        header("Location: leader-package.php");
        exit();
    }
    else if($pkg_price > 99 && $pkg_price <= 1999)
    {
         $pkg_name= 'Starter';
    }
    else if($pkg_price  > 1999 && $pkg_price  <= 4999)
    {
        $pkg_name= 'Elite';
    }
    else if($pkg_price > 4999 && $pkg_price <= 9999)
    {
         $pkg_name= 'Premium';
    }
    else if($pkg_price > 9999 && $pkg_price <= 49999)
    {
         $pkg_name= 'Supreme';
    }
    else if($pkg_price > 49999)
    {
         $pkg_name= 'Executive';
    }
 
    
     
    $maxIncome = $pkg_price *4;
        

    //current user sponsor get
    $sql  = "SELECT * FROM user_registration WHERE user_name = ?"; // SQL with parameters
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $user_name);
    $run = $stmt->execute();
    if (!$run) {
        die(__LINE__ . 'Invalid Query' . $con->error);
    }
    $result = $stmt->get_result(); // get the mysqli result
    $data   = $result->fetch_assoc();
    $sname = $sname1 = $sname2 = $sponsor_name = $data['sponsor_name'];
    $stmt->close();



     //first sponsor details
    $sql  = "SELECT * FROM user_registration WHERE user_name = ?"; // SQL with parameters
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $sponsor_name);
    $run = $stmt->execute();
    if (!$run) {
        die(__LINE__ . 'Invalid Query' . $con->error);
    }
    $result = $stmt->get_result(); // get the mysqli result
    $data2   = $result->fetch_assoc();
    $sponsorTotalInvest = $data2['total_invest']; 
    $sponsorStatus = $data2['status']; 

    
      
       

 
    // Generate Random String Function
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    $trans_id = generateRandomString(10);
    

    //insert pacakge details
    $pkgMode= 'Leader PIN';
    $pkgStatus= 'Approved';
    $pkgRoiStatus='Inactive';
    $pkgApprovedBy ='Admin';
    
    $sql="INSERT INTO `package_details`(`user_name`, `sponsor_name`, `pkg_name`, `pkg_price`, `mode`,`type`, `trans_id`, `status`, `roi_status`, `approved_by`) 
                                VALUES (?,?,?,?,?,?,?,?,?,?)";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssissssss", $user_name,$sponsor_name,$pkg_name,$pkg_price,$pkgMode,$pkg_type,$trans_id,$pkgStatus,$pkgRoiStatus,$pkgApprovedBy);
    $run = $stmt->execute();
    if (!$run) {
        die(__LINE__ . 'Invalid Query' . $con->error);
    }
    $stmt->close();
    

    //update user_registration current user
    $updateUserStatus = 'Approved';
    $sql="update user_registration set total_invest = total_invest + ? , max_income = max_income + ? , status = ? where user_name= ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ddss",$pkg_price,$maxIncome,$updateUserStatus,$user_name);
    $run = $stmt->execute();
    if (!$run) {
        die(__LINE__ . 'Invalid Query' . $con->error);
    }
    $stmt->close();
    
 
     
    // $_SESSION['successMsg']= "userName: $user_name <br> 
    // packagePrice: $pkg_price <br> 
    // packageType: $pkg_type <br> 
    // PackageName: $pkg_name <br>
    // SponsorName : $sponsor_name <br>
    // SponsorTotalInvest: $sponsorTotalInvest <br>
    // SponsorStatus : $sponsorStatus <br>
    // ";
    // header("Location: leader-package.php");
    // exit();  
 


    //insert into admin log
    $activityMessage= 'Leader PIN Package Activated '.$uname2.' And Amount is '.$pkg_price;
    $adminNameSession = $_SESSION['admin_name'];
    $qyy="INSERT INTO `admin_log`(`user_name`, `activity`) 
          VALUES ('$adminNameSession','$activityMessage')";
    $result = mysqli_query($con,$qyy);
    
    
    
    $_SESSION['successMsg']= "Package Activated Successfully";
    header("Location: leader-package.php");
    exit();  
    
    
    
    // header("Location: package_purchased_email.php?userName={$user_name}&&pkgId={$user_pkg_id}&&transId={$trans_id}");
       
        
        



     


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
                                                    <h4>Leader PIN Package</h4>
                                                    <span>Activate Without Bonuses and without ROI.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index.php"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">Leader PIN Package</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Page-header end -->

                                <div class="page-body">

                                    <div class="container">
                                    <div class="row">
                                    <div class="col-lg-6 col-md-8 col-sm-12 mx-auto">

                                    <form class="md-float-material form-material" method = "POST">
                                    <div class="auth-box card">
                                    <div class="card-block">
                                    <div class="row m-b-20">
                                    <div class="col-md-12">
                                    <h3 class="text-center">Leader PIN Package</h3>

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
                                    </div>
                                    </div>

                                    <!-- <p class="text-muted text-center p-b-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->


                                        <!-- List of All Users  -->
                                    <div class="form-group form-primary">
                                    <!-- <label class="col-form-label">Select User:</label> -->
                                    <select class="form-control select2" name="user_name" id="user_name">
                                        <option value="">Select User</option>
                                    <?php 

                                        $sql_users = "SELECT * FROM user_registration WHERE id > 1";
                                        $run_users = mysqli_query($con , $sql_users);
                                        if(!$run_users){echo mysqli_error($con);}
                                        while ($row = mysqli_fetch_array($run_users)):
                                    ?>                                        
                                        <option value="<?php echo $row['user_name']; ?>"><?php echo $row['user_name']; ?></option>
                                    <?php endwhile; ?>    
                                    </select>
                                    </div>
                                    
                                        <!-- List of All Packages  -->
                                        <div class="m-b-20" id="appendData">
                                            
                                        </div>
                                      

                                    <div class="form-group form-primary">
                                        <input id="pkgAmount" name="pkg_price" type="text" class="form-control" placeholder="Min ($100)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                                        <div id="pkgName">
                                            
                                        </div>
                                    </div> 
                                    
                                    
                                    <div class="form-group form-primary">
                                    <!-- <label class="col-form-label">Select User:</label> -->
                                    <select class="form-control select2" name="pkg_type" id="pkgType">
                                        <option value="">Select package type</option>
                                  
                                        <option value="1">Basic</option>
                                        <option value="2">Property</option>
                                
                                    </select>
                                    </div>
                                    
                                    
                                    <div class="row m-t-30">
                                    <div class="col-md-12">
                                    <button type="submit" class="btn btn-warning btn-md btn-block waves-effect text-center m-b-20" name = "buy_pkg">Submit Request</button>
                                    </div>
                                    </div>
                                    </div>
                                    </div>
                                    </form>

                                    </div>

                                    </div>

                                    </div>

                                </div>
                            </div>
                        </div>


<?php

	include "footer.php";
?>                        
<script>
    $('#user_name').on("change",function()
    {
        var userName = $('#user_name').val();
        // alert(userName);
        
        //ajax start
        
            $.ajax({
              url: "ajax/ajax_user_verify.php",
              type: "POST",
              data: {
                    userName:userName,
              },
              beforeSend: function() {
                   $('#appendData').html('Processing...');
                },
              success: function(data,status){
                //   alert(data);
                    $('#appendData').html(data);
                  },
              error: function () {
                    alert("error");
                    alert(status);
                  }
                  
            });
        //ajax end
        
    });
    
    
    
    
    //pkgAmount calculate
    $('#pkgAmount').on('keyup',function()
    {
        var pkgAmount = $('#pkgAmount').val();
        
        if(pkgAmount < '100')
        {
            $('#pkgName').html('<span class="badge bg-danger">Enter Amount</span>');
        }
        else if(pkgAmount > 99 && pkgAmount <= 1999)
        {
             $('#pkgName').html('<span class="badge bg-warning">Starter</span>');
        }
        else if(pkgAmount > 1999 && pkgAmount <= 4999)
        {
             $('#pkgName').html('<span class="badge bg-info">Elite</span>');
        }
        else if(pkgAmount > 4999 && pkgAmount <= 9999)
        {
             $('#pkgName').html('<span class="badge bg-secondary">Premium</span>');
        }
        else if(pkgAmount > 9999 && pkgAmount <= 49999)
        {
             $('#pkgName').html('<span class="badge bg-dark">Supreme</span>');
        }
        else if(pkgAmount > 49999)
        {
             $('#pkgName').html('<span class="badge bg-success">Executive</span>');
        }
        
    })
    
</script>


