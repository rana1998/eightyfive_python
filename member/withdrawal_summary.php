<?php
$page_title = 'Withdrawal Summary';
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
										<th>Sr</th>
										<th>Amount</th>
										<th>Fee</th>
										<th>After Fee</th>
										<th>Withdrawal Address</th>
										<th>Transaction Status</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
								    <?php
								    $qyy="select  * from withdrawal where user_name='$fectchUserName'";
								    $result = mysqli_query($con,$qyy);
								    $count=1;
								    while ($res=mysqli_fetch_assoc($result)){
								    ?>
									<tr>
									    <td><?php echo $count?></td>
										<td><?php echo $res['desire_amount']?></td>
										<td><?php echo $res['tax']?></td>
										<td><?php echo $res['amount_after_tax']?></td>
										<td><?php echo $res['btc_address']?></td>
										<td><?php 
										$status= $res['status'];
										if($status == 'Pending')
										{
										    echo '<span class="badge bg-warning"> Pending </span>';
										}
										elseif($status == 'Rejected')
										{
										    echo '<span class="badge bg-danger"> Rejected</span>';
										}
										elseif($status == 'Completed')
										{
										    echo '<span class="badge bg-success"> Completed </span>';
										}
										
										?></td>
										<td><?php echo $res['date']?></td>
										
									</tr>
								<?php
								$count++;
								    }
								?>
								</tbody>
								<tfoot>
									<tr>
									<th>Sr</th>
										<th>Amount</th>
										<th>Fee</th>
										<th>After Fee</th>
										<th>Withdrawal Address</th>
										<th>Transaction Status</th>
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
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
    
    <?php include 'footer.php'; ?>