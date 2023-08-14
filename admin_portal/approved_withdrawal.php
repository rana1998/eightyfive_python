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
                                                    <h4>Approved Withdrawals</h4>
                                                    <span>Summary of all Approved withdrawals</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">Approved Withdrawals</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Page-header end -->

                                <div class="page-body">
                                    <div class="row">
                                        <div class="col-12">
                                         <div class="card">
<!--                                    <div class="card-header table-card-header">
                                            <h5></h5>
                                        </div>
 -->                                        <div class="card-block">
                                            <div class="dt-responsive table-responsive">
                            <table id="basic-btn" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Desire Amt</th>
                                        <th>After Tax</th>
                                        <th>Tax</th>
                                        <th>BTC Wallet</th>
                                        <th>Status</th>
                                       <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php 
                                    $select= "SELECT * FROM `withdrawal` WHERE status = 'Approved'";
                                      $res=mysqli_query($con,$select);
                                      if (!$res) {
                                         mysqli_error($con);
                                      }
                                      $x = 1;
                                    while($data=mysqli_fetch_array($res)) {



                                       ?>
                                    <tr>
                                      <td><?php echo $x++; ?></td>
                                      <td><?php echo $data['user_name']; ?></td>
                                      <td><?php echo $data['email'];?></td>
                                      <td><?php echo '$'.$data['desire_amount'];?></td>
                                      <td><?php echo '$'.$data['tax'];?></td>
                                      <td><?php echo '$'.$data['amount_after_tax'];?></td>
                                      <td><?php echo $data['btc_address'];?></td>
                                      <td><?php echo "<span class= \"badge badge-success \">Approved</span>";?></td>
                                      <td><?php echo date('Y-m-d', strtotime( $data['dat']) )  ;?></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Desire Amt</th>
                                        <th>After Tax</th>
                                        <th>Tax</th>
                                        <th>BTC Wallet</th>
                                        <th>Status</th>
                                       <th>Date</th>
                                    </tr>
                                </tfoot>                                
                            </table>
                                </div>
                            </div>
                        </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>





 <?php include "footer.php"; ?>