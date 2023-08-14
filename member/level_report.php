<?php
$page_title = 'Level Report';
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
										<th>Level</th>
										<th>Bonus Received</th>
									</tr>
								</thead>
								<tbody>
								    <?php
								    $qyy="select  * from user_registration where user_name='$fectchUserName'";
								    $result = mysqli_query($con,$qyy);
								    $res= mysqli_fetch_assoc($result);
								    ?>
									<tr>
										<td><?php echo 'Level 1'?></td>
										<td><?php echo '$'.$res['l1']?></td>
										
										
									</tr>
									<tr>
										<td><?php echo 'Level 2'?></td>
										<td><?php echo '$'.$res['l2']?></td>
											
									</tr>
									<tr>
										<td><?php echo 'Level 3'?></td>
										<td><?php echo '$'.$res['l3']?></td>
											
									</tr>
										<tr>
										<td><?php echo 'Level 4'?></td>
										<td><?php echo '$'.$res['l4']?></td>
											
									</tr>
										<tr>
										<td><?php echo 'Level 5'?></td>
										<td><?php echo '$'.$res['l5']?></td>
											
									</tr>
										<tr>
										<td><?php echo 'Level 6'?></td>
										<td><?php echo '$'.$res['l6']?></td>
											
									</tr>
										<tr>
										<td><?php echo 'Level 7'?></td>
										<td><?php echo '$'.$res['l7']?></td>
											
									</tr>
									<tr>
										<td><?php echo 'Level 8'?></td>
										<td><?php echo '$'.$res['l8']?></td>
											
									</tr>
									<tr>
										<td><?php echo 'Level 9'?></td>
										<td><?php echo '$'.$res['l9']?></td>
											
									</tr>
									<tr>
										<td><?php echo 'Level 10'?></td>
										<td><?php echo '$'.$res['l10']?></td>
											
									</tr>
								</tbody>
								<tfoot>
								<tr>
										<th>Level</th>
										<th>Bonus Received</th>
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