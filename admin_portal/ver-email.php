<?php 
ob_start();
    include "header.php";

// Email Verification

        if (isset($_GET['id']) && $_GET['action']=='verification') {
        $id = $_GET['id'];

        // Getting User Status 
        $sql = "SELECT * FROM user_registration WHERE id = ?"; // SQL with parameters
        $stmt = $con->prepare($sql); 
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result(); // get the mysqli result
        $data = $result->fetch_assoc();
        $user_name = $data['user_name'];
        $stmt->close();
      
       
        
        $update = "UPDATE user_registration SET verified = '1', email_code= '' WHERE user_name ='$user_name'";
        $run=mysqli_query($con,$update);

            if(!$run){echo mysqli_error($con);die('Error'. __LINE__ );}
            
            $_SESSION['successMsg'] = "Success: Email Verified";
                header("Location: ver-email.php");
                exit();


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
                                                    <h4>List of Unverified Emails</h4>
                                                    <span>Following are the list of all users with unvefied email. </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index.php"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">Email Verification</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Page-header end -->

                                <div class="page-body">
                          <div class="row">
                                            <div class="col-sm-12">
                                                <!-- HTML5 Export Buttons table start -->
                                                <div class="card">
                                                     <div class="card-header table-card-header">
                                                                <!-- Sussess Message  -->
                                                        <?php if (isset($_SESSION['successMsg'])) {
                                                        ?>
                                                        <div class="alert alert-success background-success">
                                                            <button type="button" class="close m-0" data-dismiss="alert" aria-label="Close">
                                                            <i class="icofont icofont-close-line-circled text-default"></i>
                                                            </button>
                                                            <strong>Success!</strong> <?php echo $_SESSION['successMsg'];?>
                                                        </div>
                                                        <?php
                                                        unset($_SESSION['successMsg']);
                                                        } ?>

                                                                <!-- Sussess Message  -->
                                                        <?php if (isset($_SESSION['errorMsg'])) {
                                                        ?>
                                                        <div class="alert alert-danger background-danger">
                                                            <button type="button" class="close m-0" data-dismiss="alert" aria-label="Close">
                                                            <i class="icofont icofont-close-line-circled text-default"></i>
                                                            </button>
                                                            <strong>Error!</strong> <?php echo $_SESSION['errorMsg'];?>
                                                        </div>
                                                        <?php
                                                        unset($_SESSION['errorMsg']);
                                                        } ?>


                                                    </div>
                                                    <div class="card-block">
                                                        <div class="dt-responsive table-responsive">
                                                            <table id="basic-btn" class="table table-striped table-bordered nowrap" data-page-length='100'>
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Full Name</th>
                                                                        <th>User Name</th>
                                                                        <th>Email</th>
                                                                        <th>Status</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                        <?php 
                        $sql = "SELECT * FROM user_registration WHERE verified='0'";
                        $result = mysqli_query($con, $sql);
                        $x= 1;
                        while ( $data = mysqli_fetch_array($result)):
                            $id = $data['id'];
                        ?>
                                                            <tr>
                                                                <td><?php echo $x++;  ?></td>
                                                                <td><?php echo $data['full_name'];  ?></td>
                                                                <td><?php echo $data['user_name'];  ?></td>
                                                                <td><?php echo $data['email'];  ?></td>
                                                                <td><?php echo $data['status'];  ?></td>
                                                                
                                                                <td>
                                                                    <?php if($data['verified'] == '0'): ?>
                                                                    <a href="ver-email.php?id=<?php echo $id ; ?>&action=verification" class="btn btn-outline-danger btn-sm" >Verify</a>
<?php endif; ?>   


                                                                </td>
                                                            </tr>
                        <?php endwhile; ?>                                    
                                                        </tbody>
                                                                <tfoot>
                                                                   <tr>
                                                                        <th>#</th>
                                                                        <th>Full Name</th>
                                                                        <th>User Name</th>
                                                                        <th>Email</th>
                                                                        <th>Status</th>
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


<?php
    include "footer.php";
?>