<?php 
$page_title = 'Team Structure';
include 'header.php'; 

?>
    

                   <div class="content-wrapper" style="height:100vh">
                          <div class="container-fluid">
                            <!-- Main-body start -->
                            <div class="main-body">
                                <div class="page-wrapper">
                                    <!-- Page-header start -->
                                    <!-- Page-header end -->
                                    <div class="page-body" >
                                    	<div class="row">
                                    		<div class="col-12">
                                    			<?php if(isset($_GET['u'])): ?>
                                    			<a href="structure.php" class="btn btn-outline-primary btn-sm float-right">Go Back</a>
                                    		<?php endif; ?>
                                    		</div>
                                    	</div>
										     <section class="treeview"> 
										  <ul>
										  <?php if (isset($_GET['u'])){
										    $user=$_GET['u'];
										   }
										   else{
										    $user=$_SESSION['user_name'];
										   }

										  $select="SELECT * FROM user_registration WHERE user_name='$user'";
										    $res=mysqli_query($con,$select);
										      if (!$res) {
										          mysqli_error($con);
										      }
										     $data=mysqli_fetch_assoc($res);

										// Getting values from package_details                    
										$sql_pd = "SELECT 
										              sum(total_price) as product_d_price 
										              FROM package_details
										              WHERE user_name = '".$data['user_name']."'
										              AND status = 'Approved'";  
										            
										$run_pd = mysqli_query($con, $sql_pd);
										if($run_pd){
										  $row_pd = mysqli_fetch_assoc($run_pd);
										  $product_d_price = number_format( $row_pd['product_d_price'], 2);

										}

										// Getting Total DRC values from bonuses_details 
										$sql_drc = "SELECT sum(db) AS drc FROM user_registration 
										            WHERE receiver = '$user'";  
										$run_drc = mysqli_query($con, $sql_drc);

										$row_drc = mysqli_fetch_assoc($run_drc);
										$total_drc = number_format( $row_drc['db'] ,2);

										/////////////////////////////////////

										// Getting Total IRC values from bonuses_details 
										$sql_irc = "SELECT sum(bonus_amount) AS irc FROM bonuses_details 
										            WHERE receiver = '$user'
										            AND level <> 1";  
										$run_irc = mysqli_query($con, $sql_irc);

										$row_irc = mysqli_fetch_assoc($run_irc);
										$total_irc = number_format($row_irc['irc'], 2);




										 ?>
										  <li>
										    <a href="#" class="btnTooltip" 
										                data-toggle="popover"
										                data-content = "
										                <div><b>Full Name:</b> -   <?php echo strtoupper($data['full_name']) ?> </div>
										                <div><b>Total Income</b> - <?php echo '$'.number_format( $data['total_income'] ,2) ; ?>  </div>
										                <div><b>Total Invest</b> - <?php echo '$'.$product_d_price ; ?>  </div>
										                <!--<div><b>Direct Bonus</b> -          <?php echo '$'.$total_drc ; ?>  </div>-->
										                <!--<div><b>Indirect Bonus</b> -          <?php echo '$'.$total_irc ; ?>  </div>"-->
										                <title="Team Member Level 1">

										    <?php echo strtoupper($user) ?></a>
										  <ul class="sub_child">
										    <?php 
										        $select2="SELECT * FROM user_registration WHERE sponsor_name='$user'";
										        $res2=mysqli_query($con,$select2);
										        if (!$res2) {
										            echo mysqli_error($con);
										        }
										       while($data2=mysqli_fetch_assoc($res2)){

										        // Getting values from package_details where pkg_id = pkg_id                    
										        $sql_pd2 = "SELECT 
										                      sum(total_price) as product_d_price 
										                      FROM package_details
										                      WHERE user_name = '".$data2['user_name']."'
										                      AND status = 'Approved'";  
										                    
										        $run_pd2 = mysqli_query($con, $sql_pd2);
										        if($run_pd2){
										          $row_pd2 = mysqli_fetch_assoc($run_pd2);
										          $product_d_price2 = number_format( $row_pd2['product_d_price'], 2);

										        }

										        // Getting Total DRC values from bonuses_details 
										        $sql_drc2 = "SELECT sum(bonus_amount) AS drc FROM bonuses_details 
										                    WHERE receiver = '".$data2['user_name']."'
										                    AND level = 1";  
										        $run_drc2 = mysqli_query($con, $sql_drc2);

										        $row_drc2 = mysqli_fetch_assoc($run_drc2);
										        $total_drc2 = number_format( $row_drc2['db'] ,2);

										        /////////////////////////////////////

										        // Getting Total IRC values from bonuses_details 
										        $sql_irc2 = "SELECT sum(bonus_amount) AS irc FROM bonuses_details 
										                    WHERE receiver = '".$data2['user_name']."'
										                    AND level <> 1";  
										        $run_irc2 = mysqli_query($con, $sql_irc2);

										        $row_irc2 = mysqli_fetch_assoc($run_irc2);
										        $total_irc2 = number_format($row_irc2['irc'], 2);





										     ?>
										  <li>
										    <a href="#" class="btnTooltip" 
										                data-toggle="popover"  
										                data-content = "
										                <div><b>Full Name:</b> - <?php echo strtoupper($data2['full_name']) ?> </div>
										                <div><b>Total Income</b> - <?php echo '$'.number_format( $data2['total_income'] ,2) ; ?>  </div>
										                <div><b>Total Invest</b> - <?php echo '$'.$product_d_price2 ; ?>  </div>
										                <!--<div><b>Direct Bonus</b> -          <?php echo '$'.$total_drc2 ; ?>  </div>-->
										                <!--<div><b>IRC</b> -          <?php echo '$'.$total_irc2 ; ?>  </div>"-->
										                <title="Team Member Level 2">

										    <?php echo strtoupper($data2['user_name'])?></a>
										  <ul class="sub_child">
										    <?php 
										        $select3="SELECT * FROM user_registration WHERE sponsor_name='".$data2['user_name']."'";
										        $res3=mysqli_query($con,$select3);
										        if (!$res3) {
										            echo mysqli_error($con);
										        }
										       while($data3=mysqli_fetch_assoc($res3)){

										        // Getting values from package_details where pkg_id = pkg_id                    
										        $sql_pd3 = "SELECT 
										                      sum(total_price) as product_d_price 
										                      FROM package_details
										                      WHERE user_name = '".$data3['user_name']."'
										                      AND status = 'Approved'";  
										                    
										        $run_pd3 = mysqli_query($con, $sql_pd3);
										        if($run_pd3){
										          $row_pd3 = mysqli_fetch_assoc($run_pd3);
										          $product_d_price3 = number_format( $row_pd3['product_d_price'], 2);

										        }

										        // Getting Total DRC values from bonuses_details 
										        $sql_drc3 = "SELECT sum(bonus_amount) AS drc FROM bonuses_details 
										                    WHERE receiver = '".$data3['user_name']."'
										                    AND level = 1";  
										        $run_drc3 = mysqli_query($con, $sql_drc3);

										        $row_drc3 = mysqli_fetch_assoc($run_drc3);
										        $total_drc3 = number_format( $row_drc3['db'] ,2);

										        /////////////////////////////////////

										        // Getting Total IRC values from bonuses_details 
										        $sql_irc3 = "SELECT sum(bonus_amount) AS irc FROM bonuses_details 
										                    WHERE receiver = '".$data3['user_name']."'
										                    AND level <> 1";  
										        $run_irc3 = mysqli_query($con, $sql_irc3);

										        $row_irc3 = mysqli_fetch_assoc($run_irc3);
										        $total_irc3 = number_format($row_irc3['irc'], 2);



										     ?>
										      <li>
										        <a href="#"class="btnTooltip" 
										                  data-toggle="popover"  
										                  data-content = "
										                  <div><b>Full Name:</b> - <?php echo strtoupper($data3['full_name']) ?></div>
										                  <div><b>Total Income</b> - <?php echo '$'.number_format( $data3['total_income'] ,2) ; ?>  </div>
										                  <div><b>Total Invest</b> - <?php echo '$'.$product_d_price3 ; ?>  </div>
										                  <!--<div><b>Direct Bonus</b> -          <?php echo '$'.$total_drc3 ; ?>  </div>-->
										                  <!--<div><b>IRC</b> -          <?php echo '$'.$total_irc3 ; ?>  </div>"-->
										                 <title="Team Member Level 3">

										        <?php echo strtoupper($data3['user_name']) ?></a>
										        <ul class="sub_child" >
										           <?php 
										        $select4="SELECT * FROM user_registration WHERE sponsor_name='".$data3['user_name']."'";
										        $res4=mysqli_query($con,$select4);
										        if (!$res4) {
										          echo  mysqli_error($con);
										        }
										       while($data4=mysqli_fetch_assoc($res4)){

										        // Getting values from package_details where pkg_id = pkg_id                    
										        $sql_pd4 = "SELECT 
										                      sum(total_price) as product_d_price 
										                      FROM package_details
										                      WHERE user_name = '".$data4['user_name']."'
										                      AND status = 'Approved'";  
										                    
										        $run_pd4 = mysqli_query($con, $sql_pd4);
										        if($run_pd4){
										          $row_pd4 = mysqli_fetch_assoc($run_pd4);
										          $product_d_price4 = number_format( $row_pd4['product_d_price'], 2);

										        }


										        // Getting Total DRC values from bonuses_details 
										        $sql_drc4 = "SELECT sum(bonus_amount) AS drc FROM bonuses_details 
										                    WHERE receiver = '".$data4['user_name']."'
										                    AND level = 1";  
										        $run_drc4 = mysqli_query($con, $sql_drc4);

										        $row_drc4 = mysqli_fetch_assoc($run_drc4);
										        $total_drc4 = number_format( $row_drc4['db'] ,2);

										        /////////////////////////////////////

										        // Getting Total IRC values from bonuses_details 
										        $sql_irc4 = "SELECT sum(bonus_amount) AS irc FROM bonuses_details 
										                    WHERE receiver = '".$data4['user_name']."'
										                    AND level <> 1";  
										        $run_irc4 = mysqli_query($con, $sql_irc4);

										        $row_irc4 = mysqli_fetch_assoc($run_irc4);
										        $total_irc4 = number_format($row_irc4['irc'], 2);




										     ?>
										          <li>
										            <a href="#" class="btnTooltip" 
										                        data-toggle="popover"  
										                        data-content = "
										                        <div><b>Full Name:</b> - <?php echo strtoupper($data4['full_name']) ?></div>
										                        <div><b>Total Income</b> - <?php echo '$'.number_format( $data4['total_income'] ,2) ; ?>  </div>
										                        <div><b>Total Invest</b> - <?php echo '$'.$product_d_price4 ; ?>  </div>
										                        <!--<div><b>Direct Bonus</b> -          <?php echo '$'.$total_drc4 ; ?>  </div>-->
										                        <!--<div><b>IRC</b> -          <?php echo '$'.$total_irc4 ; ?>  </div>"-->
										                        <title="Team Member Level 4">

										            <?php echo strtoupper($data4['user_name']) ?></a>
										            <ul class="sub_child">
										                <?php 
										        $select5="SELECT * FROM user_registration WHERE sponsor_name='".$data4['user_name']."'";
										        $res5=mysqli_query($con,$select5);
										        if (!$res5) {
										          echo  mysqli_error($con);
										        }
										       while($data5=mysqli_fetch_assoc($res5)){

										        // Getting values from package_details where pkg_id = pkg_id                    
										        $sql_pd5 = "SELECT 
										                      sum(total_price) as product_d_price 
										                      FROM package_details
										                      WHERE user_name = '".$data5['user_name']."'
										                      AND status = 'Approved'";  
										                    
										        $run_pd5 = mysqli_query($con, $sql_pd5);
										        if($run_pd5){
										          $row_pd5 = mysqli_fetch_assoc($run_pd5);
										          $product_d_price5 = number_format( $row_pd5['product_d_price'], 2);

										        }

										        // Getting Total DRC values from bonuses_details 
										        $sql_drc5 = "SELECT sum(bonus_amount) AS drc FROM bonuses_details 
										                    WHERE receiver = '".$data5['user_name']."'
										                    AND level = 1";  
										        $run_drc5 = mysqli_query($con, $sql_drc5);

										        $row_drc5 = mysqli_fetch_assoc($run_drc5);
										        $total_drc5 = number_format( $row_drc5['db'] ,2);

										        /////////////////////////////////////

										        // Getting Total IRC values from bonuses_details 
										        $sql_irc5 = "SELECT sum(bonus_amount) AS irc FROM bonuses_details 
										                    WHERE receiver = '".$data5['user_name']."'
										                    AND level <> 1";  
										        $run_irc5 = mysqli_query($con, $sql_irc5);

										        $row_irc5 = mysqli_fetch_assoc($run_irc5);
										        $total_irc5 = number_format($row_irc5['irc'], 2);



										        ?>
										              <li>
										                <a href="#" class="btnTooltip" 
										                            data-toggle="popover"  
										                            data-content = "
										                            <div><b>Full Name:</b> - <?php echo strtoupper($data5['full_name']) ?></div>
										                            <div><b>Total Income</b> - <?php echo '$'.number_format( $data5['total_income'] ,2) ; ?>  </div>
										                            <div><b>Total Invest</b> - <?php echo '$'.$product_d_price5 ; ?>  </div>
										                            <!--<div><b>Direct Bonus</b> -          <?php echo '$'.$total_drc5 ; ?>  </div>-->
										                            <!--<div><b>IRC</b> -          <?php echo '$'.$total_irc5 ; ?>  </div>"-->
										                            <title="Team Member Level 5">

										                <?php echo strtoupper($data5['user_name']) ?></a>
										                <ul class="sub_child">
										                  <?php 
										        $select6="SELECT * FROM user_registration WHERE sponsor_name='".$data5['user_name']."'";
										        $res6=mysqli_query($con,$select6);
										        if (!$res6) {
										          echo  mysqli_error($con);
										        }
										       while($data6=mysqli_fetch_assoc($res6)){

										        // Getting values from package_details where pkg_id = pkg_id                    
										        $sql_pd6 = "SELECT 
										                      sum(total_price) as product_d_price 
										                      FROM package_details
										                      WHERE user_name = '".$data6['user_name']."'
										                      AND status = 'Approved'";  
										                    
										        $run_pd6 = mysqli_query($con, $sql_pd6);
										        if($run_pd6){
										          $row_pd6 = mysqli_fetch_assoc($run_pd6);
										          $product_d_price6 = number_format( $row_pd6['product_d_price'], 2);

										        }

										        // Getting Total DRC values from bonuses_details 
										        $sql_drc6 = "SELECT sum(bonus_amount) AS drc FROM bonuses_details 
										                    WHERE receiver = '".$data6['user_name']."'
										                    AND level = 1";  
										        $run_drc6 = mysqli_query($con, $sql_drc6);

										        $row_drc6 = mysqli_fetch_assoc($run_drc6);
										        $total_drc6 = number_format( $row_drc6['db'] ,2);

										        /////////////////////////////////////

										        // Getting Total IRC values from bonuses_details 
										        $sql_irc6 = "SELECT sum(bonus_amount) AS irc FROM bonuses_details 
										                    WHERE receiver = '".$data6['user_name']."'
										                    AND level <> 1";  
										        $run_irc6 = mysqli_query($con, $sql_irc6);

										        $row_irc6 = mysqli_fetch_assoc($run_irc6);
										        $total_irc6 = number_format($row_irc6['irc'],2);




										        ?>

										                  <li>
										                    <a href="structure.php?u=<?php echo strtoupper($data6['user_name']) ?>" class="btnTooltip" 
										                              data-toggle="popover"  
										                              data-content = "
										                              <div><b>Full Name:</b> - <?php echo strtoupper($data6['full_name']) ?></div>
										                              <div><b>Total Income</b> - <?php echo '$'.number_format( $data6['total_income'] ,2) ; ?>  </div>
										                              <div><b>Total Invest</b> - <?php echo '$'.$product_d_price6 ; ?>  </div>
										                              <!--<div><b>Direct Bonus</b> -          <?php echo '$'.$total_drc6 ; ?>  </div>-->
										                              <!--<div><b>IRC</b> -          <?php echo '$'.$total_irc6 ; ?>  </div>"-->
										                              <title="Team Member Level 6">

										                    <?php echo strtoupper($data6['user_name']) ?></a></li>
										                <?php } ?>
										                </ul>
										              </li>
										            <?php } ?>
										            </ul>
										          </li>
										        <?php } ?>
										        </ul>
										      </li>
										    <?php } ?>
										    </ul>
										  </li>
										  <?php } ?>
										  </ul>
										</li>
										</ul>
										</section>                          	
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



<?php include 'footer.php'; ?>