<?php
$page_title = "Rank and Rewards Summary";

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
              <h4>Rank & Rewards Summary</h4>
              <span>Summary of all  Rewards</span>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="page-header-breadcrumb">
            <ul class="breadcrumb-title">
              <li class="breadcrumb-item">
                <a href="index.php"> <i class="feather icon-home"></i> </a>
              </li>
              <li class="breadcrumb-item"><a href="#!">Summary</a> </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <!-- Page-header end -->
    <div class="page-body">
      <div class="row">
        <div class="col-12">
          <div class="card auth-box">
            <!-- <div class="card-header table-card-header">
              <h5></h5>
            </div>-->
            <div class="card-block">
              <div class="dt-responsive table-responsive">
                <table id="basic-btn" class="table table-striped table-bordered nowrap">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Username</th>
                      <th>Rank</th>
                      <th>Prize</th>
                      <th>Date</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $select= "SELECT * FROM `reward`";
                    $res=mysqli_query($con,$select);
                    if (!$res) {
                    echo '<h6>'.mysqli_error($con).'</h6>';
                    exit();
                    }
                    $x= 1;
                    while($data=mysqli_fetch_array($res)) : ?>
                    <tr>
                      <td><?php echo $x++; ?></td>
                      <td><?php echo $data['user_name'];?></td>
                      <td><?php echo $data['rank'];?></td>
                      <td><?php echo '$'.$data['amount'];?></td>
                      <td><?php echo date('Y-m-d', strtotime( $data['dat']) )  ;?></td>
                    </tr>
                    <?php endwhile;  ?>
                  </tbody>
                  <tfoot>
                  <tr>
                      <th>#</th>
                      <th>Username</th>
                      <th>Rank</th>
                      <th>Prize</th>
                      <th>Date</th>
                  </tr>
                  </tfoot>

<?php include "footer.php"; ?>