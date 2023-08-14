<?php
include "header.php";
require_once "./core/config.php";
require_once "./helper/AdminHelper.php";

$db = getDB();
$response = AdminHelper::getDailyUserLevelBonusHistory($db);
?>  

<!-- pending_withdrawal.php tamplated used here -->

  <!-- Main-body start -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- Page-header start -->
        <div class="page-header">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <div class="d-inline">
                            <h4>User level bonus history</h4>
                            <span>Summary of all level bonuses of users</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="index.php"> <i class="feather icon-home"></i> </a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">User level bonus info</a> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page-header end -->

        <div class="page-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-block">
                            <div class="dt-responsive table-responsive">
                            <div class="row align-items-center">
                                <div class="mr-4">
                                <select class="btn btn-primary my-2" id="level-bonus-day-select">
                                    <option value="default">Today</option>
                                    <option value="weekly">Last 7 days</option>
                                    <option value="monthly">Current Month </option>
                                </select>
                                </div>
                                <div class="">
                                    <!-- <p>Choose Time Interval</p> -->
                                    <label for="start_date">Start Date:</label>
                                    <input type="date" id="start_date" name="start_date">

                                    <label for="end_date">End Date:</label>
                                    <input type="date" id="end_date" name="end_date">

                                    <input type="button" onclick="getData()" value="Get Data">
                                </div>
                            </div>
                                
                                <!-- Table id could be user-info-table but basic-btn already intergated inbuilt funtions -->
                                <table id="user-info-table" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Level</th>
                                            <th>User name</th>
                                            <th>Bonus amount</th>
                                            <th>Level</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Level</th>
                                            <th>User name</th>
                                            <th>Bonus amount</th>
                                            <th>Level</th>
                                            <th>Date</th>
                                        </tr>
                                    </tfoot>                                
                                    <tbody>
                                        <?php
                                        foreach ($response as $data) { ?>
                                            <tr>
                                                <td><?php echo $data["id"]; ?></td>
                                                <td><?php echo $data["sender"]; ?></td>
                                                <td><?php echo $data["receiver"]; ?></td>
                                                <td><?php echo $data["bonus_amount"]; ?></td>
                                                <td><?php echo $data["level"]; ?></td>
                                                <td><?php echo $data["date"]; ?></td>
                                            </tr>
                                        <?php }
                                        ?>
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

<?php include "footer.php"; ?>

<script>
    function getData() {
        var filterValue = "day-internal"; // Example: Filter for "weekly" days name
        var startingDate = document.getElementById('start_date').value;
        var endingDate = document.getElementById('end_date').value;
        if(startingDate =='' || endingDate == '') {
            alert("Please select both date");
            return;
        }
        $.ajax({
            url: "ajax/ajax_user_level_bonus_history.php", // Replace with your PHP file that fetches filtered data
            method: "GET",
            data: { filter: filterValue, start_date:startingDate,  end_date: endingDate },
            dataType: "html",
            success: function(response) {
                var table = $('#user-info-table').DataTable();
                let jsonResponse = JSON.parse(response);

                // Clear the existing rows in the table body
                table.clear().draw();

                // Iterate through the data array and add rows using DataTables API
                jsonResponse.forEach(function(obj) {
                    table.row.add([
                        obj.id,
                        obj.sender,
                        obj.receiver,
                        obj.bonus_amount,
                        obj.level,
                        obj.date,
                    ]);
                });
                // Redraw the table to reflect the newly added rows
                table.draw();
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    }

$(document).ready(function() {
    $('#user-info-table').DataTable({
        dom: 'Bfrtip',
        buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print']
    });
    // Filter button click event
    $("#level-bonus-day-select").change(function(event) {
        var filterValue = $(event.target).val(); // Example: Filter for "weekly" days name

        $.ajax({
            url: "ajax/ajax_user_level_bonus_history.php", // Replace with your PHP file that fetches filtered data
            method: "GET",
            data: { filter: filterValue },
            dataType: "html",
            success: function(response) {
                var table = $('#user-info-table').DataTable();
                let jsonResponse = JSON.parse(response);

                // Clear the existing rows in the table body
                table.clear().draw();

                // Iterate through the data array and add rows using DataTables API
                jsonResponse.forEach(function(obj) {
                    table.row.add([
                        obj.id,
                        obj.sender,
                        obj.receiver,
                        obj.bonus_amount,
                        obj.level,
                        obj.date,
                    ]);
                });
                // Redraw the table to reflect the newly added rows
                table.draw();
            },
            error: function(xhr, status, error) {
                console.log("Error: " + error);
            }
        });
    });

});
</script>


