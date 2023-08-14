<?php 
    include "header.php";


    if(isset($_GET['id']) && !empty($_GET['id'])){
        $status_id = mysqli_real_escape_string($con, $_GET['id']);
        // Get values from package_details
        $sql_pd = "SELECT * FROM package_details WHERE id = '$status_id'";
        $run_pd = mysqli_query($con, $sql_pd);
        if(mysqli_num_rows($run_pd) > 0){
        $row_pd = mysqli_fetch_array($run_pd);
            if($row_pd['roi_status'] == 'Active'){
                        $update = "UPDATE package_details SET roi_status = 'Inactive' WHERE id = $status_id ";
                        $run_update = mysqli_query($con, $update);
                            $_SESSION['successMsg'] = "ROI Status Updated Successfully.";
                            header("Location: all_package.php");
                            exit();


            }else if ($row_pd['roi_status'] == 'Inactive'){
                        $update = "UPDATE package_details SET roi_status = 'Active' WHERE id = $status_id ";
                        $run_update = mysqli_query($con, $update);
                            $_SESSION['successMsg'] = "ROI Status Updated Successfully.";
                            header("Location: all_package.php");
                            exit();

            }

        }else{
            $_SESSION['errorMsg'] = "No Record Found.";
            header("Location: all_package.php");
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
                                                    <h4>Package Details</h4>
                                                    <span>List of  all Packages</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">Package Details</a> </li>
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
                                                                <!-- Error Message  -->
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
                                                            <table data-page-length="500" id="basic-btn" class="table table-striped table-bordered nowrap">
                                                                <thead>
                                                                    <tr>                                                                        
                                                                        <th>#</th>
                                                                        <th>Full Name</th>
                                                                        <th>User Name</th>
                                                                        <th>Package</th>
                                                                        <th>Price</th>
                                                                        <th>Mode</th>
                                                                        <th>Transaction ID</th>
                                                                        <th>Status</th>
                                                                        <th>Approved By</th>
                                                                        <th>Reject Reason</th>
                                                                        <th>Date</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                        <?php 
                        $sql = "SELECT * FROM  package_details";
                        $result = mysqli_query($con, $sql);
                        
                        
                        
                        $x = 1;
                        while ( $data = mysqli_fetch_array($result)):
                            $id         = $data['id'];
                            $uname      = $data['user_name'];
                            $sql2       = "SELECT `full_name`,`email` FROM  user_registration WHERE user_name = '$uname'";
                            $result2    = mysqli_query($con, $sql2);
                            $data2      = mysqli_fetch_array($result2);
                            $userEmail  = $email   = $data2['email'];
                            $full_name  = $data2['full_name'];
                            $pkgstatus = $data['status'];
                        //echo "$pkgstatus"."<br/>";
                            

                        ?>
                                                            <tr>
                                                                <td><?php echo $x++; ?></td>
                                                                <td><?php echo $full_name;  ?></td>
                                                                <td><?php echo $data['user_name'];  ?></td>
                                                                <td><?php echo $data['pkg_name'];  ?></td>
                                                                <td><?php echo 'PKR ' . $data['pkg_price'];  ?></td>
                                                                <td><?php echo $data['mode'];  ?></td>
                                                                <td><?php echo $data['trans_id'];  ?></td>
                                                                <td>
                                                                <?php if ($pkgstatus == 'Approved') {
  	                                                                  echo "<span class=\"badge badge-success\">Approved</span>"; 
  	                                                                  }
  	            
  	                                                                  elseif ($pkgstatus == 'Pending') {
  	                                                                         echo "<span class=\"badge badge-warning text-white \">Pending</span>";
  	                                                                  }
  	            
  	                                                                  elseif ($pkgstatus == 'Rejected') {
  	                                                                       echo "<span class=\"badge badge-danger\">Rejected</span>";
  	                                                                  }
  	                                                                  elseif ($pkgstatus == 'Expired') {
  	                                                                       echo "<span class=\"badge badge-dark\">Expired</span>";
  	                                                                  }
  	                                                                ?></td>
  	                                                              
                                                                 <td><?php echo $data['approved_by'];  ?></td>
                                                                 
                                                                 
                                                                 <td><?php if($data['reason'] == ''){
                                                                 echo "N/A";
                                                                 
                                                                 }elseif($data['reason'] != ''){
                                                                 echo $data['reason'];
                                                                 }
                                                                 ?></td>
                                                                 
                                                                 
                                                                <td><?php echo date('Y-m-d',strtotime($data['date']) );  ?></td>
                                                            </tr>
                                                            <?php endwhile; ?>                                    
                                                        </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Full Name</th>
                                                                        <th>User Name</th>
                                                                        <th>Package</th>
                                                                        <th>Price</th>
                                                                        <th>Mode</th>
                                                                        <th>Transaction ID</th>
                                                                        <th>Status</th>
                                                                        <th>Approved By</th>
                                                                        <th>Reject Reason</th>
                                                                        <th>Date</th>
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
 <script type="text/javascript">
     $(document).ready(function(){
// Reject
        $(document).on("click", ".edit_roi", function () {

        var roiID = $(this).data('wid');
        var roiDays = $(this).data('roidays');

     $(".modal-body #roiID").val( roiID );
     $(".modal-body #roiDays").val( roiDays );


     });

     });
 </script>  
