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
                        <th>Expires At</th>
                        <th>Is Expired</th>
                        
                    </tr>
                </thead>
                <tbody>
<?php

$user_name = $_SESSION['user_name'];
$sql = "SELECT * FROM pending_pacakge_amount WHERE userid = ? ORDER BY id DESC"; // SQL with parameters
$stmt = $con->prepare($sql);

if ($stmt === false) {
    die('Error: ' . $con->error); // Display the error message
}

$stmt->bind_param("s", $user_name); // Bind the parameter
$stmt->execute(); // Execute the statement
$result = $stmt->get_result();
if($result->num_rows < 1){
    echo ' <tr>No recode found.</tr>';
    $stmt->close();
}else{
    $x = 1;
    while ($data = $result->fetch_assoc()): ?>

    

    <tr>
        <td><?= $x++; ?></td>
        <td><?= '$'. $data['amount'] ?></td>
        
        
        <td><?= $data['expires_at'] ?></td>
        <td><?php if ($data['is_expired'] == 0) {
  	            echo "<span class=\"badge bg-success\">No</span>"; 
  	            }
  	            
  	            else{
  	            echo "<span class=\"badge bg-danger\">Yes</span>";
  	            }
  	            
  	            ?></td>
                
        
        
        
        
        

        
    </tr>


    <?php endwhile;

}

?>
              </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Amount</th>
                        <th>Expires At</th>
                        <th>Is Expired</th>
                        
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