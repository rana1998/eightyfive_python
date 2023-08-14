<?php
$page_title = 'USDT Payment Request Summary';
include 'header.php'; 



?>

<!-- Page Content Start Here -->
<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-9">
                <h4 class="page-title"><?= $page_title; ?></h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li>&nbsp; / &nbsp;</li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $page_title; ?></li>
                </ol>
            </div>
        </div>
        <!-- End Breadcrumb-->
        <div class="row">
            <div class="col-12">
                <div class="card">
					<div class="card-body">
						<div class="table-responsive">
								<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th class="">#</th>
										<th class="">Package Price</th>
										<th class="">Mode</th>
										<th class="">Currency Amount</th>
										<th class="">Transaction ID</th>
										<th class="">Transaction Address</th>
										<th class="">Status</th>
										<th class="">Date</th>
									</tr>
								</thead>
								<tbody>
<?php 
	$user_name = $_SESSION['user_name'];
	// Getting User Status 
	$sql = "SELECT * FROM `payment_requests` WHERE user_name = ? order by id desc"; // SQL with parameters
	$stmt = $conn->prepare($sql); 
	$stmt->bind_param("s", $user_name);
	$stmt->execute();
	$result = $stmt->get_result(); // get the mysqli result
							if ($result->num_rows > 0):
			                    $x= 1;
			                    $balance = 0;
								while( $data = $result->fetch_assoc()):
 ?>													
								<tr>
								  <td><?= $x++; ?></td>
								  <td><?='$ '.$data['pkg_price'];?></td>
								  <td><?= $data['mode'];?></td>
								  <td><?= $data['amount'];?></td>
								  <td><?= $data['transaction_id'];?></td>
								  <td><?= $data['transaction_address'];?></td>
								  <td class="d-flex">
							          <?php
							          if($data['status']=='Processing')
							          {
							              echo "<span class='badge bg-warning d-flex align-items-center'>Processing</span>";
							              echo "<a target='blank' href='payments.php?txid=".$data['transaction_id']."' class='btn btn-sm btn-primary d-flex align-items-center ms-2'>View</a>";
							          }
							          elseif($data['status']=='Approved')
							          {
							              echo "<span class='badge bg-success d-flex align-items-center'>Approved</span>";
							          }
							          elseif($data['status']=='Cancelled')
							          {
							              echo "<span class='badge bg-danger d-flex align-items-center'>Cancelled</span>";
							          }
							          elseif($data['status']=='Pending')
							          {
							              echo "<span class='badge bg-info d-flex align-items-center'>Pending</span>";
							              echo "<a target='blank' href='payments.php?txid=".$data['transaction_id']."' class='btn btn-sm btn-primary d-flex align-items-center ms-2'>View</a>";
							          
							          }
							          ?>
							      
							      </td>
                                  <td><?= date('Y-m-d', strtotime( $data['date']) )  ;?></td>
						        </tr>
<?php 
  endwhile;
    $stmt->close();
    else:
      echo "<tr class='text-center'><td colspan= 8> -- No Recode Found.-- </td></tr>";
      $stmt->close();

    endif;
 ?>
</tbody>
								<tfoot>
									<tr>
									   	<th class="">#</th>
										<th class="">Package Price</th>
										<th class="">Mode</th>
										<th class="">Currency Amount</th>
										<th class="">Transaction ID</th>
										<th class="">Transaction Address</th>
										<th class="">Status</th>
										<th class="">Date</th>
									</tr>
								</tfoot>
							</table>
						</div>
					</div>
				</div>
                
                
            </div>
        </div>
    </div>
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
    
    <?php include 'footer.php'; ?>