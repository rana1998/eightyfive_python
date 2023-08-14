<?php
$page_title = 'Leadership Summary';
include 'header.php'; 



?>

<!-- Page Content Start Here -->
<div class="page-wrapper">
    <div class="page-content">
        <!--row start-->
        <div class="row">
            	 <div class="col-lg-4">
					<div style="min-height: 350px;min-height:350px;" class="card border-secondary border-bottom border-0 border-3">
						<div class="card-body">
						    <h5 class="text-center">Next Rank</h5>
                                <hr>
						    <?php
						        if($userRank == 0)
                                {
                                    $rankName ='no-rank';
                                }
                                else if($userRank == 1)
                                {
                                     $rankName = 'trainee';
                                }
                                else if($userRank == 2)
                                {
                                     $rankName = 'manager';
                                }
                                else if($userRank == 3)
                                {
                                     $rankName = 'executive';
                                }
                                else if($userRank == 4)
                                {
                                     $rankName = 'director';
                                }
                               
                               
						    
						    
						    ?>
						    
						    <div class="media-body text-center mt-3">
                                <img height="250" src="assets/images/ranks/<?=$rankName?>.png">
                              </div>
						    
						</div>
					</div>
			</div>
			 <div class="col-lg-4">
					<div style="min-height: 350px;min-height:350px;" class="card border-secondary border-bottom border-0 border-3">
						<div class="card-body">
						    <h5 class="text-center">Next Rank</h5>
                                <hr>
						    <?php
						        $userRank1 = $userRank + 1;
						    
						        if($userRank1 == 0)
                                {
                                    $rankName ='no-rank';
                                }
                                else if($userRank1 == 1)
                                {
                                     $rankName = 'rank1';
                                }
                                else if($userRank1 == 2)
                                {
                                     $rankName = 'rank2';
                                }
                               
                               
						    
						    
						    ?>
						    
						    <div class="media-body text-center mt-3">
                                <img height="250" src="assets/images/ranks/<?=$rankName?>.png">
                              </div>
						    
						</div>
					</div>
			</div>
            <div class="col-lg-4">
								<div style="min-height: 350px;min-height:350px;" class="card bg-white border-secondary border-bottom border-0 border-3">
									<div class="card-body">
										<div class="d-flex flex-column align-items-center text-center">
										    <img src="images/icons/ranking.png" class="m-2" alt="icon"  width="95">
											
											<div class="mt-3 mb-3">
												<h4 class="text-capitalize text-light">Next Rank Status</h4>
										
            								</div>
										</div>
										
										<?php
										
										if($userRank == 0)
										{
										    $requiredSale = 500000;
										}
										elseif($userRank == 1)
										{
										    $requiredSale = 1500000;
										}
										elseif($userRank == 2)
										{
										    $requiredSale = 3000000;
										}
										elseif($userRank == 3)
										{
										    $requiredSale = 6000000;
										}
										elseif($userRank == 4)
										{
										    $requiredSale = 0;
										}
										
										?>
										
										
										<ul class="list-group   list-group-flush">
											<li class="list-group-item bg-transparent d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0 text-light">Team Sales</h6>
												<b class="text-danger">$<?=number_format($userTeamSales,2)?></b>
											</li>
											<li class="list-group-item bg-transparent d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0 text-light">Next Level Sale Required</h6>
											<b class="text-danger">$<?=number_format($requiredSale,2)?></b>	
											</li>
											<li class="list-group-item bg-transparent d-flex justify-content-between align-items-center flex-wrap">
												<h6 class="mb-0 text-light">Remaining</h6>
												<?php
												$remaining = $requiredSale-$userTeamSales;
												if($remaining < 0)
												{
												    $remainingAmount = 0;
												}
												elseif($remaining > 0)
												{
												    $remainingAmount = $remaining;
												}
												?>
												<b class="text-danger">$<?=number_format($remainingAmount,2)?></b>
												
											</li>	
										</ul>
									</div>
								</div>
							</div>
			
			               				
        </div>
        <!--row end-->
        
        
        
        
        <div class="row">
            <div class="col-12">
                <div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>Sr</th>
										<th>Price</th>
										<th>Rank</th>
										<th>Status</th>
										<th>Date</th>
									</tr>
								</thead>
								<tbody>
								    <?php
								    $qyy="SELECT * FROM `reward` where user_name='$fectchUserName'";
								    $result = mysqli_query($con,$qyy);
								    $count=1;
								    while ($res=mysqli_fetch_assoc($result)){
								    ?>
									<tr>
									    <td><?php echo $count?></td>
										<td>$<?php echo $res['price']?></td>
										<td>$<?php echo $res['ranj=k']?></td>
										<td><span class="badge bg-success"><?php echo $res['status']?></span></td>
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
										<th>Price</th>
										<th>Rank</th>
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
    <!-- End container-fluid-->
    
    </div><!--End content-wrapper-->
    
    <?php include 'footer.php'; ?>