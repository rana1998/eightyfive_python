<?php 

    include "header.php";
// Login User Account from Admin Panel
    if (isset($_GET['id']) && $_GET['action']=='Login') {
    $id = $_GET['id'];
    $select = "SELECT * FROM user_registration WHERE id  = '$id'";
    $run=mysqli_query($con,$select);

        if(!$run){
            echo mysqli_error($con);
        }else{
            $row = mysqli_fetch_array($run);
            $_SESSION['user_name'] = $row['user_name'];
            header("Location: ../member/index.php");
            exit();
        }
}

// Blocked User

        if (isset($_GET['id']) && $_GET['action']=='Block') {
        $id = $_GET['id'];
        $update = "UPDATE user_registration SET login_status = 'Block' WHERE id ='$id'";
        $run=mysqli_query($con,$update);

            if(!$run){
                echo mysqli_error($con);
            }else{
                $_SESSION['successMsg'] = "User login status is blocked";
                header("Location: all_users.php");
                exit();
            }

}else if  (isset($_GET['id']) && $_GET['action']=='Unblock'){
     $id = $_GET['id'];
        $update = "UPDATE user_registration SET login_status = 'Unblock' WHERE id ='$id'";
        $run=mysqli_query($con,$update);

            if(!$run){
                echo mysqli_error($con);
            }else{
            $_SESSION['successMsg'] = "User login status is Unblocked";
                header("Location: all_users.php");
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
                                                    <h4>List of All Users</h4>
                                                    <span>Following are the list of all users </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">All Users</a> </li>
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


                                                    </div>
                                                    <div class="card-block">
                                                        <div class="dt-responsive table-responsive">
                                                            <table id="basic-btn" class="table table-striped table-bordered nowrap" data-page-length='100'>
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Full Name</th>
                                                                        <th>User Name</th>
                                                                        <th>Sponsor Name</th>
                                                                        <th>Email</th>
                                                                        <th>Phone</th>
                                                                        <th>Status</th>
                                                                        <th>OTP</th>
                                                                        <th>Date</th>
                                                                        <th>Login Status</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                        <?php 
                        $sql = "SELECT * FROM  user_registration";
                        $result = mysqli_query($con, $sql);
                        $x= 1;
                        while ( $data = mysqli_fetch_array($result)):
                            $id = $data['id'];
                            $status = $data['status'];
                            $loginStatus = $data['login_status'];
    // echo "$pos";
                        ?>
                                                            <tr>
                                                                <td><?php echo $x++;  ?></td>
                                                                <td><?php echo $data['full_name'];  ?></td>
                                                                <td><?php echo $data['user_name'];  ?></td>
                                                                <td><?php echo $data['sponsor_name'];  ?></td>
                                                                <td><?php echo $data['email'];  ?></td>
                                                                <td><?php echo $data['mobile'];  ?></td>
                                                                
                                                                
                                                        
                                                                <td><?php if ($status == 'Approved') {
  	            echo "<span class=\"badge badge-success\">Approved</span>"; 
  	            }
  	            
  	            elseif ($status != 'Approved') {
  	            echo "<span class=\"badge badge-warning text-white \">$status</span>";
  	            }
  	            
  	            
  	            ?></td>
                                                                
                                                                
                                                                
                                                                
                                                                <td><?php echo $data['otp_code']  ?></td>
                                                                <td><?php echo date('Y-m-d',strtotime($data['date']) );  ?></td>
                                                                
                                                                
                                                                <td><?php if ($loginStatus == 'Unblock') {
  	            echo "<span class=\"badge badge-success\">Active</span>"; 
  	            }
  	            
  	            elseif ($loginStatus != 'Unblocked') {
  	            echo "<span class=\"badge badge-danger text-white \">Blocked</span>";
  	            }
  	            
  	            
  	            ?></td>
                                                                
                                                                
                                                                
                                                                
                                                                
                                                                <td>
                                                                    <?php if($data['login_status'] == 'Unblock'): ?>
                                                                    <a href="all_users.php?id=<?php echo $id ; ?>&action=Block" class="btn btn-outline-danger btn-sm" >Block</a>

                                                                     <?php elseif($data['login_status'] == 'Block'): ?>
                                                                    <a href="all_users.php?id=<?php echo $id ; ?>&action=Unblock" class="btn btn-outline-success btn-sm" >Unblock</a>

                                                                     <?php endif; ?>   
                                                                    <a href="all_users.php?id=<?php echo $id ; ?>&action=Login" class="btn btn-outline-info btn-sm" target= "_blank" >Login</a>

                                                                </td>
                                                            </tr>
                        <?php endwhile; ?>                                    
                                                        </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Full Name</th>
                                                                        <th>User Name</th>
                                                                        <th>Sponsor Name</th>
                                                                        <th>Email</th>
                                                                        <th>Phone</th>
                                                                        <th>Status</th>
                                                                        <th>OTP</th>
                                                                        <th>Date</th>
                                                                        <th>Login Status</th>
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