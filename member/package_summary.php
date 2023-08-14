<?php
$page_title = 'Package Summary';
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
										<th>Package</th>
										<th>Price</th>
										<th>Mode</th>
										<th>Transactio ID</th>
										<th>Transaction Status</th>
										<th>Order Date</th>
									</tr>
								</thead>
								<tbody>
								    <?php
								    $qyy="select  * from package_details where user_name='$fectchUserName'";
								    $result = mysqli_query($con,$qyy);
								    $count=1;
								    while ($res=mysqli_fetch_assoc($result)){
								    ?>
									<tr>
									    <td><?php echo $count?></td>
										<td><?php echo $res['pkg_name']?></td>
										<td>$<?php echo $res['pkg_price']?></td>
										<td>USDT(TRC 20)</td>
										<td><?php echo $res['trans_id']?></td>
										<td><?php if($res['status'] == "Approved"){ echo "<b class='badge bg-success'>Completed<b>"; }else{ echo "<b class='badge bg-danger'>Failed</b>"; }?></td>
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
									    <th>Package</th>
										<th>Price</th>
										<th>Mode</th>
										<th>Transactio ID</th>
										<th>Transaction Status</th>
										<th>Order Date</th>
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

