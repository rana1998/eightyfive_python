<?php 
    include "header.php";

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
                                                    <h4>List of  Active Users</h4>
                                                    <span>Following are the list of  active users </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">Active Users</a> </li>
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
                                                     <div class="card-header table-card-header text-center">

                                                    </div>
                                                    <div class="card-block">
                                                        <div class="dt-responsive table-responsive">
                                                            <table id="basic-btn" class="table table-striped table-bordered nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Full Name</th>
                                                                        <th>User Name</th>
                                                                        <th>Sponsor Name</th>
                                                                        <th>Email</th>
                                                                        <th>Status</th>
                                                                        <th>Date</th>
                                                                        
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                        <?php 
                        $sql = "SELECT * FROM  user_registration WHERE id>1 AND status = 'Approved'";
                        $result = mysqli_query($con, $sql);
                        $x= 1;
                        while ( $data = mysqli_fetch_array($result)):
                            $id = $data['id'];
                            $status = $data['status'];
                        ?>
                                                            <tr>
                                                                <td><?= $x++; ?></td>
                                                                <td><?php echo $data['full_name'];  ?></td>
                                                                <td><?php echo $data['user_name'];  ?></td>
                                                                <td><?php echo $data['sponsor_name'];  ?></td>
                                                                <td><?php echo $data['email'];  ?></td>
                                                                <td><?php echo "<span class=\"badge badge-success\">Approved</span>"  ?></td>
                                                                <td><?php echo date('Y-m-d',strtotime($data['date']) );  ?></td>
                                                             
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
                                                                        <th>Status</th>
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
               
