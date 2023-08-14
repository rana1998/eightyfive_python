<?php 
    include "header.php";


    if(isset($_GET['id']) && isset($_GET['action']))
    {
      $orderId = intval($_GET['id']);
      $status = mysqli_real_escape_string($con,$_GET['action']);
      
       
      $q="select * from orders where id='$orderId'";
      $result = mysqli_query($con,$q);
      if(mysqli_num_rows($result) > 0)
      {     
            $res = mysqli_fetch_assoc($result);
            $orderUsername = $res['user_name'];
            $orderFinalPrice = $res['final_price'];
            $productQuantity = $res['product_quantity'];
            $productId = $res['product_id'];
         
          if($status =='approved')
          {
              $q="update orders set status='Delivered' where id='$orderId'";
              $result = mysqli_query($con,$q);
              if($result == TRUE)
              {
                  $_SESSION['successMsg'] = 'Order deliver status updated successfully';
                  header("location: order_pending.php");
                  exit();
              }
          }
          elseif($status =='rejected')
          {
              
              $qy="update user_registration set iwallet = iwallet + '$orderFinalPrice' where user_name='$orderUsername' ";
              $result = mysqli_query($con,$qy);
              
              $qyy="INSERT INTO `wallet_summary`(`user_name`, `amount`, `description`, `wallet_type`, `type`) 
                    VALUES ('$orderUsername','$orderFinalPrice','Order amount reversal','iWallet','Credit')";
                $result = mysqli_query($con,$qyy);
              
              $qyyy ="update product set product_quantity = product_quantity + '$productQuantity' where id='$productId'";
              $resullt = mysqli_query($con,$qyyy);
              
              $q="update orders set status='Rejected' where id='$orderId'";
              $result = mysqli_query($con,$q);
              if($result == TRUE)
              {
                  $_SESSION['errorMsg'] = 'Order rejected status updated successfully';
                  header("location: order_pending.php");
                  exit();
              }
          }
               
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
                                                    <h4>Pending Orders</h4>
                                                    <span>Summary of all Pending Orders</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">Pending Orders</a> </li>
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
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                        <?php
                        $status= 'Pending';
                        $sql = "SELECT * FROM orders WHERE status = ?"; // SQL with parameters
                        $stmt = $con->prepare($sql); 
                        $stmt->bind_param("s", $status);
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
                                <td>
                                    <a href="order_pending.php?id=<?=$data['id']?>&action=approved" class="btn btn-sm btn-success">Approved</a>
                                    <a href="order_pending.php?id=<?=$data['id']?>&action=rejected" class="btn btn-sm btn-danger">Reject</a>
                                    
                                </td>
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
                                                <th>Action</th>
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