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
                                                    <h4>All Orders</h4>
                                                    <span>Summary of all Orders</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">All Orders</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Page-header end -->

                                <div class="page-body">
                                    <div class="row">
                                        <div class="col-12">
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
                                            
                                            
                                            
                                         <div class="card">
<!--                                    <div class="card-header table-card-header">
                                            <h5></h5>
                                        </div>
 -->                                        <div class="card-block">
                                            <div class="dt-responsive table-responsive">
                            <table id="basic-btn" class="table table-striped table-bordered nowrap">
                                <thead class="">
                                            <tr>
                                                <th>#</th>
                                                <th>Username</th>
                                                <th>Title</th>
                                                <th>Product Amount</th>
                                                <th>Quantity</th>
                                                <th>Final Amount</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                        <?php
                       
                        $sql = "SELECT * FROM orders"; // SQL with parameters
                        $stmt = $con->prepare($sql); 
                        $stmt->execute();
                        $result = $stmt->get_result(); // get the mysqli result
                        if($result->num_rows < 1){
                            echo ' <tr>No recode found.</tr>';
                            $stmt->close();
                        }
                        else
                        {
                            $x = 1;
                            while ($data = $result->fetch_assoc()): ?>
                        
                            <tr>
                                <td><?= $x++; ?></td>
                                <td><?= $data['user_name']?></td>
                                <td><?php
                                $productId = $data['product_id'];
                                $qy="select * from product where id='$productId'";
                                $result = mysqli_query($con,$qy);
                                $res = mysqli_fetch_assoc($result);
                                echo $res['product_title'];
                                
                                ?></td>
                                <td>PKR <?= $data['product_price'] ?></td>
                                <td><?= $data['product_quantity'] ?></td>
                                <td>PKR <?= $data['final_price'] ?></td>
                                <td><?php
                                if($data['status'] == 'Pending')
                                {
                                    echo "<span class='badge bg-warning text-dark'>Pending</span>";
                                }
                                elseif($data['status'] == 'Delivered')
                                {
                                    echo "<span class='badge bg-success'>Delivered</span>";
                                }
                                elseif($data['status'] == 'Rejected')
                                {
                                    echo "<span class='badge bg-success'>Rejected</span>";
                                }
                                
                                ?></td>
                                <td><?= date("Y-m-d", strtotime($data['date'])) ?></td>
                              
                            </tr>
                        
                        
                            <?php endwhile;
                        
                        }
                        
                        ?>
                                      </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Username</th>
                                                <th>Title</th>
                                                <th>Product Amount</th>
                                                <th>Quantity</th>
                                                <th>Final Amount</th>
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