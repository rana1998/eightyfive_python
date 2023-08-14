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
                                                    <h4>Paid Payments</h4>
                                                    <span>List of  all Paid Payment</span>
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
                                                    <div class="card-block">
                                                        <div class="dt-responsive table-responsive">
                                                            <table data-page-length="500" id="basic-btn" class="table table-striped table-bordered nowrap">
                                                                <thead>
                                                                    <tr>                                                                        
                                                                        <th>#</th>
                                                                        <th>User Name</th>
                                                                        <th>Invoice ID</th>
                                                                        <th>Price(<i class="fa fa-dollar"></i>)</th>
                                                                        <th>Price(<i class="fa fa-bitcoin"></i>)</th>
                                                                        <th>Address</th>
                                                                        <th>Date</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                        <?php 
                        $sql = "SELECT * FROM  invoices";
                        $result = mysqli_query($con, $sql);
                        if(mysqli_num_rows($result) >0){


                        $x = 1;
                        while ( $data = mysqli_fetch_array($result)):
                            $invoice_id      = $data['invoice_id'];
                            $user_name   = $data['user_name'];
                            $price_in_usd  = $data['price_in_usd'];
                            $price_in_btc  = $data['price_in_btc'];
                            $address  = $data['address'];
                            $date  = $data['date'];

                        ?>
                                                            <tr>
                                                                <td><?php echo $x++; ?></td>
                                                                <td><?php echo $user_name;  ?></td>
                                                                <td><?php echo $invoice_id;  ?></td>
                                                                <td><?php echo '$'.$price_in_usd;  ?></td>
                                                                <td><?php echo $price_in_btc;  ?></td>
                                                                <td><?php echo $address;  ?></td>
                                                                <td><?php echo date('Y-m-d',strtotime($date) );  ?></td>
                                                            </tr>
                        <?php endwhile; 
                        }else{
                            echo '<tr>
                            <td colspan="8">No Record Found</td>
                            </tr>';
                        }
                        ?>                                    
                                                     
                                                        </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>User Name</th>
                                                                        <th>Invoice ID</th>
                                                                        <th>Amount(<i class="fa fa-dollar"></i>)</th>
                                                                        <th>BTC(<i class="fa fa-bitcoin"></i>)</th>
                                                                        <th>Address</th>
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