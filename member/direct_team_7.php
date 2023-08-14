<?php 
$page_title = 'Direct Team (level 7)';

include 'header.php'; ?>
  
<!-- Page Content Start Here -->
  <div class="page-wrapper">
    <div class="page-content">
    <!-- Breadcrumb-->
     <div class="row pt-2 pb-2">
        <div class="col-sm-9">
        <h4 class="page-title"><?= $page_title; ?></h4>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li> &nbsp; / &nbsp;</li>
            <li class="breadcrumb-item active" aria-current="page"><?= $page_title; ?></li>
         </ol>
     </div>
     </div>
    <!-- End Breadcrumb-->
    <div class="row">
      <?php

$user_name = $_GET['username'];

$sql="SELECT * FROM user_registration WHERE sponsor_name = ?";
$stmt = $con->prepare($sql); 
$stmt->bind_param("s", $user_name);
$stmt->execute();
$result = $stmt->get_result(); // get the mysqli result

if ($result->num_rows > 0) {

while( $data = $result->fetch_assoc()){


?>
    
<div class="col-lg-4 col-md-6 col-sm-12">
          <div style="border-bottom: 3px solid #0f4e91" class="card card-danger mt-3">
            <div style="margin-top: -25px;" class="d-felx text-center justify-content-center align-items-center">
                   <img  src="assets/images/user-profile/<?php echo $data['profile_pic']?>" class="rounded-circle p-1 border bg-primary" width="100" height="100" alt="Profile Pic">
           </div>
          <div class="card-body">
            <h5 style="color:#ffe088" class="card-title text-center"><?php echo ucwords( $data['full_name']); ?></h5>
            <div class="p-2" style="border-radius: 8px;border: solid 1px rgba(221, 228, 235, 0.1); ">
                <p class="card-text"><b>Username: </b><span class="text-uppercase"><?php echo  $data['user_name'];?></span></p>
                <p class="card-text"><b>Email: </b> <?php echo  $data['email']; ?></p>
                <p class="card-text"><b>Total Invest: </b><?php echo  '$'.$data['total_invest']; ?></p>
                <p class="card-text"><b>Team Sales: </b><?php echo  '$'.$data['team_sales']; ?></p>
                

                <?php
           require 'connect.php';
           $sql= $conn->prepare("SELECT * FROM user_registration WHERE sponsor_name='".$data['user_name']."'");
           $sql->execute();
           $sql->setFetchMode(PDO::FETCH_ASSOC);
           if($sql->rowCount()>0){
           echo '
           <form method="POST" action="direct_team_8.php?username='.$data['user_name'].'">
           <input type="submit" value="Show Team"  class="form-control">
           </form>';
}
?>

                


            </div>
          </div>
        </div>
 </div>
 
<?php 
  }
    $stmt->close();

    }else{
      echo "<p class='text-default pl-4'>You Don't have any members in your Direct Team.</p>";
      $stmt->close();

    }


 ?>


    </div>
    </div>
    <!-- End container-fluid-->
    
   </div><!--End content-wrapper-->
   
<?php include 'footer.php'; ?>


