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
							<h4>Update User Balance</h4>
							<span>Following are all Users Balance Details</span>
						</div>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="page-header-breadcrumb">
						<ul class="breadcrumb-title">
							<li class="breadcrumb-item">
								<a href="index.php"> <i class="feather icon-home"></i> </a>
							</li>
							<li class="breadcrumb-item"><a href="#!">User Balance</a> </li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<!-- Page-header end -->
		<div class="page-body">
			<div class="row">
			    <div class="col-md-12">
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
			    </div>
			</div>

			<div class="row">
				<div class="col-md-12">
					
					<!-- HTML5 Export Buttons table start -->
					<div class="card">
						<div class="card-header table-card-header text-center"></div>
						<div class="card-block">
							<div class="dt-responsive table-responsive">
								<table id="basic-btn" class="table table-striped table-bordered nowrap">
									<thead>
										<tr>
											<th>#</th>
											<th>Full Name</th>
											<th>Email</th>
											<th>Wallet Address</th>
											<th>User Name</th>
											<th>Cash Wallet</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sql = "SELECT * FROM  user_registration WHERE id > 1";
										$result = mysqli_query($con, $sql);
										$count = 1;
										while ( $data = mysqli_fetch_array($result)):
										?>
 											<tr>
                                                <td><?php echo $count++;?></td>
                                                <td><?php echo $data['full_name'];  ?></td>
												<td><?php echo $data['email'];  ?></td>
												<td><?php echo $data['wallet_address'];  ?></td>
                                                <td><?php echo $data['user_name'] ?></td>
                                                <td><?php echo '$'.$data['current_balance'] ?></td>
                                                <td>
                                                	<a href="edit_balance.php?id=<?php echo $data['id'];  ?>" class="btn btn-outline-info btn-sm"> <i class="feather icon-edit"></i> Edit Balance</a>
                                                	 <!-- <a href="edit_wallet.php?id=<?php echo $data['id'];  ?>" class="btn btn-outline-info btn-sm"> <i class="feather icon-edit"></i> Edit  Iwallet</a>  -->
                                                </td>
                                                
                                                 
                                            </tr>

												<?php endwhile; ?>
											</tbody>
											<tfoot>
											<tr>
												<th>#</th>
												<th>Full Name</th>
												<th>Email</th>
											    <th>Wallet Address</th>
												<th>User Name</th>
												<th>Cash Wallet</th>											
												<th>Action</th>
											</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>
							<!-- HTML5 Export Buttons end -->
							
						</div>
						</div> <!--.row -->
					</div>
				</div>
			</div>
			<?php
				include "footer.php";
			?>