<?php 
// This file need work. Approved Withdrawal Par work karna hai //
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
                              <h4>Approved Requests</h4>
                              <span>Summary of all pending withdrawals</span>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4">
                      <div class="page-header-breadcrumb">
                          <ul class="breadcrumb-title">
                              <li class="breadcrumb-item">
                                  <a href="index.php"> <i class="feather icon-home"></i> </a>
                              </li>
                              <li class="breadcrumb-item"><a href="#!">Pending Withdrawals</a> </li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
          <!-- Page-header end -->

          <div class="page-body">
              <div class="row">
                  <div class="col-12">
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
                  <div class="col-12">
                   <div class="card">
<!--                                    <div class="card-header table-card-header">
                      <h5></h5>
                  </div>-->
                   <div class="card-block">
                      <div class="dt-responsive table-responsive">
      <table id="basic-btn" class="table table-striped table-bordered nowrap">
          <thead>
              <tr>
                  <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>Package Name</th>
                  <th>Package Price</th>
                  <th>Mode</th>
                  <th>Transaction Id</th>
                  <th>Days</th>
                  <th>Status</th>
                  <th>Date</th>
            
              </tr>
              </tr>
          </thead>
          <tfoot>
              <tr>
                  <th>#</th>
                  <th>Username</th>
                  <th>Package Name</th>
                  <th>Package Price</th>
                  <th>Mode</th>
                  <th>Transaction Id</th>
                  <th>Days</th>
                  <th>Status</th>
                  <th>Date</th>
                  
              </tr>
          </tfoot>                                
          <tbody>
          <?php 
              $select= "SELECT * FROM `capital_request` WHERE status = 'Delivered'";
                $res=mysqli_query($con,$select);
                if (!$res) {
                   echo '<h6>'.mysqli_error($con).'</h6>';
                   exit();
                }
                $x = 1;
              while($data=mysqli_fetch_array($res)) : ?>
                    <tr>
                      <td><?php echo $x++; ?></td>
                      <td><?php echo $data['user_name'];?></td>
                      <td><?php echo $data['pkg_name'];?></td>
                      <td><?php echo '$'.$data['pkg_price'];?></td>
                      <td><?php echo '$'.$data['mode'];?></td>
                      <td><?php echo '$'.$data['trans_id'];?></td>
                      <td><?php echo $data['days'];?></td>
                      <td><?php echo $data['status'];?></td>
                      <td><?php echo date('Y-m-d', strtotime( $data['dat']) )  ;?></td>
                     

                    </tr>

          <?php endwhile;  ?>
          </tbody>
              </table>
          </div>
      </div>
  </div>
</div>
</div>

</div>
</div>
</div>



<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog" aria-labelledby="rejectModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rejectModalLabel">Reason</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
<form method = 'GET'>
      <div class="modal-body">
    <input type="hidden" id="rejectID" name="wid"      value="">
    <input type="hidden" name="action"  value="Reject">
 <div class="form-group">
    <label for="reason_txtarea">Why?</label>
    <textarea class="form-control" name = "reason_txtarea" id="reason_txtarea" rows="3"></textarea>
  </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="reject_reason">Reject</button>

      </div>
  </form>
    </div>
  </div>
</div>

<?php include "footer.php"; ?>
 <script type="text/javascript">
     $(document).ready(function(){
// Reject
        $(document).on("click", ".btn-reject", function () {

        var rejectID = $(this).data('wid');

     $(".modal-body #rejectID").val( rejectID );


     });

     });
 </script>