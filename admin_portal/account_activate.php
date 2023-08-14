<?php 
ob_start();
	include "header.php";



    if(isset($_POST['buy_pkg'])){
        
        $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
       
  
        // Check if input are empty
        if (empty($user_name)){
            $_SESSION['errorMsg'] = "Please activate account ";
            header("Location: account_activate.php");
            exit();
        }
        
        $query="update user_registration set activation_fee='Paid' where user_name='$user_name'";
        $result = mysqli_query($con,$query);
        if($result == TRUE)
        {
            $_SESSION['successMsg'] = "Account Activated Successfully";
            header("Location: account_activate.php");
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
                                                    <h4>Account Activate</h4>
                                                    <span>Acccount Activate</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index.php"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">Acccount Activate</a> </li>
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
                                    <h3 class="text-center">Acccount Activate</h3>

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
                                    <div id="appendData">
                                        
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

    
</script>


