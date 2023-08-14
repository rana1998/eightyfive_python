<?php
$page_title = 'Cash Wallet';
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
							 <table id="default-datatable" class="table table-bordered table-striped table-hover">
                <thead class="">
                    <tr>
                        <th>#</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Transaction Status</th>
                        
                    </tr>
                </thead>
                <tbody>
<?php

$user_name = $_SESSION['user_name'];
$sql = "SELECT * FROM wallet_summary WHERE user_name = ? AND wallet_type = 'Cash Wallet' ORDER BY id DESC"; // SQL with parameters
$stmt = $con->prepare($sql); 
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result
if($result->num_rows < 1){
    echo ' <tr>No recode found.</tr>';
    $stmt->close();
}else{
    $x = 1;
    while ($data = $result->fetch_assoc()): ?>
    <?php $type = $data['type'];
          $primary = 0;
    // echo "$type";
    
    ?>
    

    <tr>
        <td><?= $x++; ?></td>
        <td><?= '$'. $data['amount'] ?></td>
        <td><?= $data['description'] ?></td>
        
        
        
        <td><?php if ($type == 'Credit') {
  	            echo "<span class=\"badge bg-success\">Credit</span>"; 
  	            }
  	            
  	            elseif ($type == 'Debit') {
  	            echo "<span class=\"badge bg-danger\">Debit</span>";
  	            }
  	            
  	            ?></td>
                <td><?= $data['date'] ?></td>
        <td><?php echo "<span class=\"badge bg-success\">Success</span>"; ?></td>
        
        
        
        <!-- <td>$<?php 
                            // if($data['type'] == 'Debit'){
                            //     echo    $balance = $balance - $data['amount'];
                            // }elseif($data['type'] == 'Credit'){
                            //     echo  $balance = $balance + $data['amount'];
                            // }

                            ?></td> -->
        
        
        
        
        

        
    </tr>


    <?php endwhile;

}

?>
              </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Type</th>
                        <th>Date</th>
                        <th>Transaction Status</th>
                        
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