<?php
include "header.php";
require_once "./core/config.php";
require_once "./helper/AdminHelper.php";

$db = getDB();
$response = AdminHelper::getAdminWalletSummary($db);
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
                            <h4>Admin wallet summery table</h4>
                            <span>Summary of all Admin wallet</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class="breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="index.php"> <i class="feather icon-home"></i> </a>
                            </li>
                            <li class="breadcrumb-item"><a href="#!">Admin wallet info</a> </li>
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
                                <!-- Table id could be user-info-table but basic-btn already intergated inbuilt funtions -->
                                <table id="user-info-table" class="table table-striped table-bordered nowrap">
                                    <thead>
                                        <tr>
                                            <th>Owner Id</th>
                                            <th>Wallet Address</th>
                                            <th>Email</th>
                                            <th>Owner</th>
                                            <th>Gtron commission</th>
                                            <th>Date</th>
                                            <th>Claim</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Owner Id</th>
                                            <th>Wallet Address</th>
                                            <th>Email</th>
                                            <th>Owner</th>
                                            <th>Gtron commission</th>
                                            <th>Date</th>
                                            <th>Claim</th>
                                        </tr>
                                    </tfoot>                                
                                    <tbody>
                                        <?php
                                        foreach ($response as $data) { ?>
                                            <tr>
                                                <td><?php echo $data["owner_id"]; ?></td>
                                                <td><?php echo $data["wallet_address"]; ?></td>
                                                <td><?php echo $data["email"]; ?></td>
                                                <td><?php echo $data["owner"]; ?></td>
                                                <td><?php echo $data["gtron_commission"]; ?></td>
                                                <td><?php echo $data["date"]; ?></td>
                                                <!-- <td><button class="data-button">Claim</button></td> -->
                                                <td><button type="button" class="btn btn-primary data-button" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">claim</button></td>
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


<!-- claim gtron value modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Gtron wallet transfer</h5>
      </div>
      <div class="modal-body">
        <form>
          <div class="mb-3">
            <input type="hidden" value="" id="gtron-wallet"/>
            <div class="input-group "> 
                <input type="hidden" value="" id="owner" />
                <input type="hidden" value="" id="email-id" />
                <input type="text" name="otpCode" class="form-control" id="admin-mail" value="" placeholder="Otp Code Sent on Email" >
                <button class="btn btn-secondary sendOtpEmail" type="button" >SEND OTP</button>
            </div>
            <p class="text-success otpSendSuccessMessage"></p>
            <p class="text-danger otpSendErrorMessage"></p>

            <div class="input-group ">
                <input type="text" class="form-control" id="otp-value" placeholder="Enter Otp and confirm">
                <button class="btn btn-secondary confirmOtp" type="button" >CONFIRM OTP</button>
            </div>
            <p class="text-success confirmOtpSuccessMessage"></p>
            <p class="text-danger confirmOtpErrorMessage"></p>
          </div>
            <div class="mb-3">
                <label for="message-text" class="col-form-label">Wallet address:</label>
                <input type="text" class="form-control" id="wallet-address"></input>
            </div>
            <p class="text-success withdrawalSuccessMessage"></p>
            <p class="text-danger withdrawalErrorMessage"></p>
        </form>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary"  id="withdrawal-btn">WITHDRAWAL</button>
        </div>
        
    </div>
  </div>
</div>

<?php include "footer.php"; ?>

<script>
$(document).ready(function() {
    $('#user-info-table').DataTable({
        dom: 'Bfrtip',
        buttons: [ 'copy', 'csv', 'excel', 'pdf', 'print']
    });

    // Get all the buttons with the class "data-button"
    const dataButtons = document.querySelectorAll(".data-button");
    // Loop through each button and add a click event listener
    dataButtons.forEach(button => {
        button.addEventListener("click", function() {
            document.getElementById('otp-value').value = '';
            $('.otpSendSuccessMessage').text('');
            $('.otpSendErrorMessage').text('')
            $('.confirmOtpSuccessMessage').text('');
            $('.confirmOtpErrorMessage').text('')
            $('.withdrawalSuccessMessage').text('');
            $('.withdrawalErrorMessage').text('')
            // Get the parent row of the clicked button (the row containing the data)
            const row = this.closest("tr");
            // Get the data from the row
            const walletAddress = row.cells[1].innerText;
            const adminMail = row.cells[2].innerText;
            const gtromAmount = row.cells[4].innerText;  
            const owner = row.cells[3].innerText;  
            const email = row.cells[2].innerText;  
            // Now you can do whatever you want with the data
            const walletAddressElement = document.getElementById("wallet-address");
            const adminMailElement = document.getElementById("admin-mail");
            const gtronWalletElement = document.getElementById("gtron-wallet");
            const ownerElement = document.getElementById("owner");
            const emailElement = document.getElementById("email-id");
            walletAddressElement.value = walletAddress;
            adminMailElement.value = adminMail;
            gtronWalletElement.value = gtromAmount;
            ownerElement.value = owner;
            emailElement.value = email;
            // Or perform any other operations with the data
        });
    });

    $(".sendOtpEmail").click(function(){
        let sendMail = 'Email Send';
        let owner = document.getElementById('owner').value;
        let email = document.getElementById('email-id').value;
        $(".sendOtpEmail").prop('disabled', true);
        $(".sendOtpEmail").text('Processing');
        $.post("./ajax/otp_generator.php",{otp_send:sendMail, owner:owner, email:email}).done(function (feedback) {
            if(feedback == 'Email Sent Successfully') {
                $('.otpSendSuccessMessage').text(feedback);
                $('.otpSendErrorMessage').text('');
            } else {
                $('.otpSendSuccessMessage').text('');
                $('.otpSendErrorMessage').text(feedback);
            }
            $(".sendOtpEmail").prop('disabled', false);
            $(".sendOtpEmail").text('SEND OTP');
            // ...
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
            alert("Error occurred during the AJAX request. Check the console for details.");
        })
    })

    $(".confirmOtp").click(function(){
        var userInptOTP = document.getElementById('otp-value').value;
        let owner = document.getElementById('owner').value;
        let email = document.getElementById('email-id').value;
        if(userInptOTP == ''){
            alert("please enter valid otp");
            return;
        } 
        $(".confirmOtp").prop('disabled', true);
        $(".confirmOtp").text('Processing');
        $.post("./ajax/ajax_otp_confirmation.php",{action:"confirm-otp",userInptOTP:userInptOTP, owner:owner, email:email}).done(function (feedback) {
            if(feedback == 'success') {
                $('.confirmOtpSuccessMessage').text(feedback);
                $('.confirmOtpErrorMessage').text('')
            } else {
                $('.confirmOtpSuccessMessage').text('');
                $('.confirmOtpErrorMessage').text(feedback);
            }
            $(".confirmOtp").prop('disabled', false);
            $(".confirmOtp").text('CONFIRM OTP');
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
            alert("Error occurred during the AJAX request. Check the console for details.");
        })
    })

    $("#withdrawal-btn").click(function(){
        let gtronAmount = document.getElementById("gtron-wallet").value;
        let walletAddress = document.getElementById("wallet-address").value;
        $("#withdrawal-btn").prop('disabled', true);
        $("#withdrawal-btn").text('Processing');
        $.post("./ajax/ajax_tronwallet.php",{gtronAmount:gtronAmount,walletAddress:walletAddress}).done(function (feedback) {
            if(feedback == 'failed') {
                $('.withdrawalSuccessMessage').text('');
                $('.withdrawalErrorMessage').text(feedback);
            } else {
                let obj  = JSON.parse(feedback); 
                if(obj.visible == true) {
                    $('.withdrawalSuccessMessage').text("Successfully transferred");
                    $('.withdrawalErrorMessage').text('')
                } else {
                    $('.withdrawalSuccessMessage').text('');
                    $('.withdrawalErrorMessage').text(feedback);
                }
            }  
            $("#withdrawal-btn").prop('disabled', false);
            $("#withdrawal-btn").text('WITHDRAWAL');
        })
        .fail(function (jqXHR, textStatus, errorThrown) {
            console.error(textStatus, errorThrown);
            alert("Error occurred during the AJAX request. Check the console for details.");
        })
    })

});
</script>


