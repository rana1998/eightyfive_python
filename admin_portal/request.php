<?php 
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
                                                    <h4>Withdrawal Request</h4>
                                                    <span>lorem ipsum dolor sit amet, consectetur adipisicing elit</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="page-header-breadcrumb">
                                                <ul class="breadcrumb-title">
                                                    <li class="breadcrumb-item">
                                                        <a href="index-1.htm"> <i class="feather icon-home"></i> </a>
                                                    </li>
                                                    <li class="breadcrumb-item"><a href="#!">Withdrawal Request</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Page-header end -->

                                <div class="page-body">


<div class="container">
<div class="row">
<div class="col-sm-6 offset-3">

<form class="md-float-material form-material" method = "POST">
<div class="auth-box card">
<div class="card-block">
<div class="row m-b-20">
<div class="col-md-12">
<h3 class="text-center txt-primary">Withdrawal</h3>

<?php if (isset($_SESSION['ok'])) {
?>
<div class="alert alert-success background-success">
<button type="button" class="close m-0" data-dismiss="alert" aria-label="Close">
<i class="icofont icofont-close-line-circled text-white"></i>
</button>
<strong>Success!</strong> Fund has been transferred to SMC Wallet.
</div>
<?php
unset($_SESSION['ok']);
} ?>

</div>
</div>

<p class="text-muted text-center p-b-5">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>

<div class="form-group form-primary">
<label class="col-form-label">Available Balance</label>
<input type="text" name="avail_balance" class="form-control" value="22500 PKR"  readonly>
<span class="form-bar text-danger">
<?php if (isset($_SESSION['b'])) {
?>Insufficiant Balance for withdarawal<?php
unset($_SESSION['b']);
} ?>
</span>
</div>
<div class="form-group form-primary">
<label class="col-form-label">Desired Amount</label>
<input type="text" name="desired_amount" class="form-control"  id="dsireValue" placeholder="e.g. 5000 PKR">
<span class="form-bar text-danger">
    <?php if (isset($_SESSION['amount'])) {
?>Please enter a valid amount.<?php
unset($_SESSION['amount']);
} ?>
</span>
</div>
<div class="form-group form-primary">
<label class="col-form-label">Amount After TAX<small><strong class="text-muted"> (5% Tax)</strong></small></label>
<input type="text" name="after_tax_amount" id="txtValue" class="form-control"  value="0" readonly>
<span class="form-bar text-danger"></span>
</div>
<div class="form-group form-primary">
<label class="col-form-label">Select Bank:</label>
<select class="form-control" name="bank_name" id="bank_name">
    <option value="">Select Your Bank</option>
    <option value="1">HBL</option>
    <option value="2">Allied Bank</option>
    <option value="3">Bank Al Habib</option>
    <option value="4">Bank Alfalah</option>
    <option value="5">MCB Bank</option>
</select>
</div>

<div class="form-group form-primary">
    <label  class="col-form-label">Acc Number</label>
    <input type="text" name="bank_acc" class="form-control" placeholder="e.g. 5432 1765 8970 9087" >
</div>

<div class="form-group form-primary">
    <label  class="col-form-label">EPIN</label>
    <input type="password" name="epin" class="form-control" placeholder="Enter Your EPIN" >
</div>

<div class="row m-t-30">
<div class="col-md-12">
<button type="submit" class="btn btn-primary btn-md btn-block waves-effect text-center m-b-20" name = "withdrawal_request">Submit Request</button>
</div>
</div>
</div>
</div>
</form>

</div>

</div>

</div>



                                </div>
                            </div>
                        </div>


<?php

	include "footer.php";
?>                        