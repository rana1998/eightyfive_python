<?php 
ob_start();

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
                                                    <h4>Approved Ticket</h4>
                                                    <span>List of all approved ticket </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">Approved Ticket</a> </li>
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
                                                        <!-- Success Message -->
                                                        <?php if (isset($_SESSION['reply'])) {
                                                        ?>
                                                        <div class="alert alert-success background-success">
                                                        <button type="button" class="close m-0" data-dismiss="alert" aria-label="Close">
                                                        <i class="icofont icofont-close-line-circled text-white"></i>
                                                        </button>
                                                        <strong>Success!</strong> <?php echo $_SESSION['reply'] ;?>
                                                        </div>
                                                        <?php
                                                        unset($_SESSION['reply']);
                                                        } ?>
                                                    </div>
                                                    <div class="card-block">
                                                        <div class="dt-responsive table-responsive">
                                                            <table id="basic-btn" class="table table-striped table-bordered nowrap">
                                                                <thead>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>Username</th>
                                                                        <th>Subject</th>
                                                                        <th>Message</th>
                                                                        <th>Reply</th>
                                                                        <th>Date</th>
                                                                        
                                                                       
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                 <?php

                                                    
                                                    $select1="select * from support where status='Resolved'";
                                                    $res1=mysqli_query($con,$select1);
                                                      $x=1;
                                                      while($data=mysqli_fetch_array($res1)){?>
                                                        <tr>
                                                            <td><?php echo $x; ?></td>
                                                            <td><?php echo $data['user_name']; ?></td>
                                                            <td><?php echo $data['subject']; ?></td>
                                                            <td><?php echo $data['message']; ?></td>
                                                            <td><?php echo $data['reply']; ?></td>
                                                            <td><?php echo date('Y-m-d', strtotime( $data['date']) )  ;?></td>
                                                        </tr>
                                                    
                                                    <?php } ?>
                                                        </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>ID</th>
                                                                        <th>Username</th>
                                                                        <th>Subject</th>
                                                                        <th>Message</th>
                                                                        <th>Reply</th>
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
               
