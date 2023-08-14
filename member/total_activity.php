<?php
$page_title = 'Total Report';
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
							 <table id="simpletable" class="table table-striped table-bordered nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Username</th>
                      <th>Package Name</th>
                      <th>Package Price</th>
                      <th>Level</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      
                    $select= "SELECT * 
                                FROM `activity_report` 
                                WHERE receiver = '$fectchUserName' 
                                ORDER BY
                                date DESC
                                ";
                                // echo $select;
                                // die();
                    $res=mysqli_query($con,$select);
                    if (!$res) {
                    echo '<h6>Error:'.mysqli_error($con).'</h6>';
                    exit();
                    }
                    $x= 1;
                    while($data=mysqli_fetch_array($res)) : ?>
                    <tr>
                      <td><?php echo $x++; ?></td>
                      <td><?php echo $data['sender'];?></td>
                      <td><?php echo $data['pkg_name'];?></td>
                      <td><?php echo $data['pkg_amount'].'$';?></td>
                      <td><?php echo 'Level '.$data['level'];?></td>
                      <td><?php echo date('Y-m-d', strtotime( $data['date']) )  ;?></td>
                    </tr>
                    <?php endwhile;  ?>
                  </tbody>
                  <tfoot>
                  <tr>
                      <th>#</th>
                      <th>Username</th>
                      <th>Package Name</th>
                      <th>Package Price</th>
                      <th>Level</th>
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