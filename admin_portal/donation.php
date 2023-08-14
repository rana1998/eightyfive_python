<?php 
    include "header.php";


    if(isset($_GET['id']) && isset($_GET['action']))
    {
      $orderId = intval($_GET['id']);
      $status = mysqli_real_escape_string($con,$_GET['action']);
      
       
      $q="select * from donate where id='$orderId'";
      $result = mysqli_query($con,$q);
      if(mysqli_num_rows($result) > 0)
      {
         
          if($status =='approved')
          {
              $q="update donate set status='Approved' where id='$orderId'";
              $result = mysqli_query($con,$q);
              if($result == TRUE)
              {
                  $_SESSION['successMsg'] = 'Donation approved successfully';
                  header("location: donation.php");
                  exit();
              }
          }
          elseif($status =='rejected')
          {
              $q="update donate set status='Rejected' where id='$orderId'";
              $result = mysqli_query($con,$q);
              if($result == TRUE)
              {
                  $_SESSION['errorMsg'] = 'Donation Rejected';
                  header("location: donation.php");
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
                                                    <h4>Donation</h4>
                                                    <span>Summary of donations</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">Pending Donations</a> </li>
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
                                                <th>Amount</th>
                                                <th>Mode</th>
                                                <th>Bank</th>
                                                <th>Image</th>
                                                <th>Tansaction ID</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                        <?php
                        $status= 'Pending';
                        $sql = "SELECT * FROM donate WHERE status = ?"; // SQL with parameters
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
                                <td><?= $data['amount'] ?></td>
                                <td><?= $data['mode'] ?></td>
                                <td><?= $data['bank'] ?></td>
                                <td><a href="../member/<?= $data['image'] ?>" target="blank"><img src="../member/<?= $data['image'] ?>" height="20" width="20"></a></td>
                                <td><?= $data['trans_id'] ?></td>
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
                                    <a href="donation.php?id=<?=$data['id']?>&action=approved" class="btn btn-sm btn-success">Approved</a>
                                    <a href="donation.php?id=<?=$data['id']?>&action=rejected" class="btn btn-sm btn-danger">Reject</a>
                                    
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
                                                <th>Amount</th>
                                                <th>Mode</th>
                                                <th>Bank</th>
                                                <th>Image</th>
                                                <th>Tansaction ID</th>
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