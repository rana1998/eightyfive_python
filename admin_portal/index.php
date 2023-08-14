<?php 
    include 'header.php';
    require_once('./core/config.php');
    require_once('./helper/AdminHelper.php');

    $db = getDB();    
    $visitorCount = AdminHelper::getDailyVisitorCount($db);
    $weeklyVisitedUserIDs  = AdminHelper::getWeeklyVisitedUserIds($db);
    $monthlyVisitedUserIDs  = AdminHelper::getMonthlyVisitedUserIds($db);
    $userDividendOnDailyBasis  = AdminHelper::getUserDividendOnDailyBasis($db);

    $dailyRegisteredUsers = AdminHelper::getDailyRegisteredUserCount($db);
    $daiyPurchaseHistoryAsDeposit = AdminHelper::getDailyUserDepositHistroy($db);
    $daiyUserWithdrawalCount = AdminHelper::getDailyUserWithdrawalCountHistory($db);

    $gtronTokenWalletbalance = AdminHelper::getGtronTokenWalletSummary($db);


?>
<style>
  .bg-c-black{
    font-weight: 900;
    background: linear-gradient(to right, #ff877c, #fe9365);
    color: black!important;
  }
  .text-white {
    font-weight: 600;
    color: black!important;
}
</style>
<!-- Main Body Content Start Here -->
<div class="main-body">
    <div class="page-wrapper">
        <div class="page-body">
            <div class="row">
                <div class="col-xl-12">
                    <?php if(isset($_SESSION['successMsg'])):  ?>
                    <div class="alert alert-success background-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="icofont icofont-close-line-circled text-white"></i>
                        </button>
                        <strong>Success!</strong> <?php echo $_SESSION['successMsg'];  ?>
                    </div>
                    <?php 
                                                        unset($_SESSION['successMsg']);
                                                        endif; ?>

                    <?php
                                                if(isset($_SESSION['reject'])): ?>
                    <div class="alert alert-danger background-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="icofont icofont-close-line-circled text-white"></i>
                        </button>
                        <strong>Rejected!</strong> <?php echo $_SESSION['reject'];  ?>
                    </div>
                    <?php
                                        unset($_SESSION['reject']);
                                        
                                        endif; ?>

                </div>
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <?php    
                                        $current_balance = 0;
                                        $total_income = 0;
                                        $iwallet = 0;
                                        $sql = "SELECT `current_balance`,`total_income` ,`iwallet` FROM user_registration";
                                        $run = mysqli_query($con, $sql);
                                        while ($row = mysqli_fetch_array($run)) {
                                                $current_balance = $current_balance + $row['current_balance'];
                                                $total_income = $total_income + $row['total_income'];
                                                $iwallet = $iwallet + $row['iwallet'];
                                        }
                                    ?>
                                    <h5 class="text-white"><?php echo $current_balance; ?></h5>
                                    <!-- <h6 class="text-white m-b-0">Users Total Balance</h6> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="text-white m-b-0">Users Total Balance</p>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"><?php
$q="select sum(total_invest) from user_registration";
$result = mysqli_query($con,$q);
$ress = mysqli_fetch_assoc($result);

echo $ress['sum(total_invest)'];

?>
                                    </h5>
                                    <h6 class="text-white m-b-0">Total Income</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="text-white m-b-0">Total amount all users earned</p>
                        </div>
                    </div>
                </div> -->

                <!-- <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"><?php


echo $ress['sum(total_invest)'] - $current_balance;

?>
                                    </h5>
                                    <h6 class="text-white m-b-0">Available Balance</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="text-white m-b-0">Admin Available Balance</p>
                        </div>
                    </div>
                </div> -->



                <!-- Pending Withdrawal Count -->
                <?php 
$select= "SELECT * FROM `withdrawal` WHERE status = 'Pending'";
$res=mysqli_query($con,$select);
if (!$res) {
echo '<h6>'.mysqli_error($con).'</h6>';
exit();
}
$count = 0;
$pamount = 0;
while($data=mysqli_fetch_array($res)){

$pamount = $pamount+ $data['desire_amount'];
$count++;
}
?>

                <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"><?php echo $pamount;  ?></h5>
                                    <h6 class="text-white m-b-0">Pending Withdrawal</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="text-white m-b-0"><?php echo 'Total Pending Withdrawal Request: '.$count;   ?></p>
                        </div>
                    </div>
                </div>



                <!-- Approved Withdrawal Count -->
                <?php 
$select= "SELECT * FROM `withdrawal` WHERE status = 'Approved'";
$res=mysqli_query($con,$select);
if (!$res) {
echo '<h6>'.mysqli_error($con).'</h6>';
exit();
}
$count = 0;
$pamount = 0;
while($data=mysqli_fetch_array($res)){

$pamount = $pamount+ $data['desire_amount'];
$count++;
}
?>

                <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"><?php echo $pamount;  ?></h5>
                                    <h6 class="text-white m-b-0">Approved Withdrawal</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="text-white m-b-0"><?php echo 'Total Approved Withdrawal Request: '.$count;   ?>
                            </p>
                        </div>
                    </div>
                </div>


                <!-- Approved Package Count -->
                <?php 
$select= "SELECT * FROM `package_details` WHERE `status` = 'Approved'";
$res=mysqli_query($con,$select);
if (!$res) {
echo '<h6>'.mysqli_error($con).'</h6>';
exit();
}
$count = 0;
while($data=mysqli_fetch_array($res)){

$count++;
}
?>

                <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"><?php echo $count; ?></h5>
                                    <h6 class="text-white m-b-0">Approved Package</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="text-white m-b-0">Total Approved Package. </p>
                        </div>
                    </div>
                </div>

                <!-- Approved Investment Count -->
                <?php 
$select= "SELECT sum(amount) FROM `donate`";
$res=mysqli_query($con,$select);
if (!$res) {
echo '<h6>'.mysqli_error($con).'</h6>';
exit();
}
$count = 0;
$data= mysqli_fetch_assoc($res);
$donateTotalAmount = $data['sum(amount)'];

?>
<!-- 
                <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"><?php echo $donateTotalAmount; ?></h5>
                                    <h6 class="text-white m-b-0">Donate Amount </h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="text-white m-b-0">Total Donate Amount. </p>
                        </div>
                    </div>
                </div> -->




                <!-- All User Count -->
                <?php 
$select= "SELECT * FROM `user_registration` WHERE id>1";
$res=mysqli_query($con,$select);
if (!$res) {
echo '<h6>'.mysqli_error($con).'</h6>';
exit();
}
$count = 0;
while($data=mysqli_fetch_array($res)){

$count++;
}
?>

                <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"><?php echo $count; ?></h5>
                                    <h6 class="text-white m-b-0">All User</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="text-white m-b-0">All User. </p>
                        </div>
                    </div>
                </div>



                <!-- Active User Count -->
                <?php 
$select= "SELECT * FROM `user_registration` WHERE id>1 AND status = 'Approved'";
$res=mysqli_query($con,$select);
if (!$res) {
echo '<h6>'.mysqli_error($con).'</h6>';
exit();
}
$count = 0;
while($data=mysqli_fetch_array($res)){

$count++;
}
?>

                <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"><?php echo $count; ?></h5>
                                    <h6 class="text-white m-b-0">Active User</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="text-white m-b-0">Active User. </p>
                        </div>
                    </div>
                </div>



                <!-- Inactive User Count -->
                <?php 
$select= "SELECT * FROM `user_registration` WHERE id>1 AND status != 'Approved'";
$res=mysqli_query($con,$select);
if (!$res) {
echo '<h6>'.mysqli_error($con).'</h6>';
exit();
}
$count = 0;
while($data=mysqli_fetch_array($res)){

$count++;
}
?>

                <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"><?php echo $count; ?></h5>
                                    <h6 class="text-white m-b-0">Inactive User</h6>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="text-white m-b-0">Inactive User. </p>
                        </div>
                    </div>
                </div>

                
    <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <?php    
$current_balance = 0;
$total_income = 0;
$iwallet = 0;
   $sql = "SELECT `id`, `total_pool_amount`, `total_sale_amount` FROM user_pool_amount";
   $run = mysqli_query($con, $sql);
   while ($row = mysqli_fetch_array($run)) {
        $current_balance =  $row['total_pool_amount'];
        $total_income = $row['total_sale_amount'];
   }


    ?>
                                    <h5 class="text-white">Pool Amount: $<?php echo $current_balance; ?></h5>
                                    <h5 class="text-white">Total Sale: $<?php echo $total_income; ?></h5>
                                    <!-- <h6 class="text-white m-b-0">Users Total Balance</h6> -->
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="text-white m-b-0">Total Pool Amount & Sale</p>
                        </div>
                    </div>
                </div>


                <!-- <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"><?php echo $dailyRegisteredUsers;  ?></h5>
                                    <h6 class="text-white m-b-0">User Registration chart</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"><?php echo $daiyPurchaseHistoryAsDeposit;  ?></h5>
                                    <h6 class="text-white m-b-0">User Deposit chart</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"><?php echo $daiyUserWithdrawalCount;  ?></h5>
                                    <h6 class="text-white m-b-0">User Withdrawal  chart</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->


                <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white">Total: <?php  $roundedNumber = number_format($gtronTokenWalletbalance, 2);echo $roundedNumber; ?></h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <p class="text-white m-b-0">Gtron total token balance</p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white">User Registration chart: <?php echo $dailyRegisteredUsers;  ?></h5>
                                    <canvas id="registeredUsersChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white">User Withdrawal  chart: <?php echo $daiyUserWithdrawalCount;  ?></h5>
                                    <canvas id="myChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white">User Deposit chart: <?php echo $daiyPurchaseHistoryAsDeposit;?></h5>
                                    <canvas id="daiyPurchaseHistoryAsDeposit"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                

                <!-- Daily Total User Report and Chart: This section would display the total number of users registered or active on a daily basis. It may include a chart to visualize the user growth or trends -->
                <!-- <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"> <?php echo $visitorCount;?> </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <h6 class="text-white m-b-0">Daily Total User Active </h6>
                        </div>
                    </div>
                </div> -->

                <!-- Daily User Dividend Report: This report would show the dividends earned by users on a daily basis, indicating the amount distributed to each user. -->
                <!-- <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"> 0 </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <h6 class="text-white m-b-0">Today's User Dividend </h6>
                        </div>
                    </div>
                </div> -->

                <!-- Weekly User ID Report: This report would provide a list of user IDs or usernames for the current week, allowing administrators to track user activity -->
                <!-- <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"> 0 </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <h6 class="text-white m-b-0">Weekly User ID </h6>
                        </div>
                    </div>
                </div> -->

                <!-- Monthly User ID Report: Similar to the weekly report, this report would display user IDs or usernames for the current month. -->
                <!-- <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"> 0 </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <h6 class="text-white m-b-0">Monthly User ID</h6>
                        </div>
                    </div>
                </div> -->

                <!-- Gtorn Commission 10% Report: This report would show the commissions earned by Gtorn, calculated as 10% of certain transactions or activities. It may be available on a daily, weekly, and monthly basis, and can be accompanied by a chart to visualize the commission trends. -->
                <!-- <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"> 0 </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <h6 class="text-white m-b-0">Gtorn Commission 10%</h6>
                        </div>
                    </div>
                </div> -->

                <!-- Gtorn Total Profit Report: This report would summarize the overall profit generated by Gtorn, taking into account various revenue sources and expenses. -->
                <!-- <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"> 0 </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <h6 class="text-white m-b-0">Gtorn Total Profit</h6>
                        </div>
                    </div>
                </div> -->

                <!-- Owner Wallet: This section would display information about the owner's wallet, which may include the balance and recent transactions. -->
                <!-- <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"> 0 </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <h6 class="text-white m-b-0">Owner Wallet</h6>
                        </div>
                    </div>
                </div> -->

                <!-- Gtorn Commission 10%: This section would provide details about the commission structure, such as the specific transactions or activities that incur a 10% commission.-->
                <!-- <div class="col-xl-4 col-md-6">
                    <div class="card bg-c-black update-card">
                        <div class="card-block">
                            <div class="row align-items-end">
                                <div class="col-12">
                                    <h5 class="text-white"> 0 </h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <h6 class="text-white m-b-0">Gtorn Commission 10%</h6>
                        </div>
                    </div>
                </div> -->

                <!-- Trans PW & Email Verification: This feature could involve handling transactions, password changes, and email verification processes for users, ensuring security and accountability.  -->


            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
    const ctx = document.getElementById('myChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
        labels: ['Daily'],
        datasets: [{
            label: 'User Withdrawal  chart',
            data: [<?php echo (int)$daiyUserWithdrawalCount;?>],
            borderWidth: 1
        }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });


    const registeredUsersChart = document.getElementById('registeredUsersChart');
    new Chart(registeredUsersChart, {
        type: 'bar',
        data: {
        labels: ['Daily'],
        datasets: [{
            label: 'User Registration chart',
            data: [<?php echo (int)$dailyRegisteredUsers;?>],
            borderWidth: 1
        }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });


    const daiyPurchaseHistoryAsDeposit = document.getElementById('daiyPurchaseHistoryAsDeposit');
    new Chart(daiyPurchaseHistoryAsDeposit, {
        type: 'bar',
        data: {
        labels: ['Daily'],
        datasets: [{
            label: 'User Deposit chart',
            data: [<?php echo (int)$daiyPurchaseHistoryAsDeposit;?>],
            borderWidth: 1
        }]
        },
        options: {
        scales: {
            y: {
            beginAtZero: true
            }
        }
        }
    });


    </script>


    <?php 
  include 'footer.php';

?>
