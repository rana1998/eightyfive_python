<?php

$page_title = "Payment Requests";
include 'header.php'; 

include 'coinpaymentapi.php';

function sanitize($stringToSanitize) {
    return addslashes(htmlspecialchars($stringToSanitize));
}

$user_name = $_SESSION['user_name'];

$txn_id=sanitize($_GET['txid']);
$qy="select * from payment_requests where transaction_id='$txn_id'";
$result = mysqli_query($con,$qy);
$res = mysqli_fetch_assoc($result);


$amount=$res['amount'];
$timeOut=0;
$confirms_needed= $res['transaction_confirms_needed'];
$address= $res['transaction_address'];
$checkout_url=$res['checkout_url'];
$status_url=$res['status_url'];
$qrcode_url=$res['qrcode_url'];
$currency=$res['mode'];
#create transaction call end



?>



<!--start-->
   <div class="page-wrapper">
    <div class="page-content">
						
						<!-- row opened -->
						<div class="row">
							<div class="offset-sm-3 col-sm-6">
								<div class="card mb-5">
								    <div class="card-body">
								        <div class="table-responsive">
                                            <table class="table">
                                        <thead>
                                        <tr>
                                            <th class="text-center" colspan="2"><strong>Payment Information</strong></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td width="25%" align="right">Status:</td>
                                            <td width="75%">
                                                <span id="payment_status">Waiting for buyer funds...</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right">Deposit Amount:</td>
                                            <td><?= $amount ?></td>
                                        </tr>
                                        <?php
                                        if($currency == 'USDT.TRC20')
                                        {
                                        ?>
                                       
                                        <?php
                                         
                                            if($activationFee=='Unpaid')
                                            {
                                        ?>
                                        <tr>
                                            <td colspan="2"><h5 style="padding:7px;background:green;text-align:center"><span class="text-white">$20 account activation fee</span></h5></td>
                                        </tr>
                                        <?php
                                            }
                                            else
                                            {
                                                
                                            }
                                        ?>
                                         <tr>
                                            <td align="right"><b style="color:red">NOTE:</b></td>
                                            <td style="color:red">$1 Transaction Fee (Blockchain) Apply.</td>
                                        </tr>
                                        
                                        <tr>
                                            <td align="right">Total Amount to Send:</td>
                                            <td><?php echo $currency." <b style='color:red'>". ($amount+1)."</b> (total confirms needed: ".$confirms_needed.")" ?></td>
                                        </tr>
                                        <?php
                                        }
                                        elseif($currency == 'DOGE')
                                        {
                                        ?>
                                        <tr>
                                            <td align="right"><b style="color:red">NOTE:</b></td>
                                            <td style="color:red">10 DOGE Transaction Fee (Blockchain) Apply.</td>
                                        </tr>
                                        <tr>
                                            <td align="right">Total Amount to Send:</td>
                                            <td><?php echo $currency." <b style='color:red'>". ($amount+10)."</b> (total confirms needed: ".$confirms_needed.")" ?></td>
                                        </tr>
                                        <?php
                                        }
                                        elseif($currency == 'BTC')
                                        {
                                            $amountPercentage = $amount*0.10;
                                            $amount = $amount + $amountPercentage;
                                        ?>
                                        <tr>
                                            <td align="right"><b style="color:red">NOTE:</b></td>
                                            <td style="color:red">10% BTC Transaction Fee (Blockchain) Apply.</td>
                                        </tr>
                                        <tr>
                                            <td align="right">Total Amount to Send:</td>
                                            
                                            <td><?php echo $currency." <b style='color:red'>". ($amount)."</b> (total confirms needed: ".$confirms_needed.")" ?></td>
                                        </tr>
                                        <?php
                                        }
                                        elseif($currency == 'BNB')
                                        {
                                            $amountPercentage = $amount*0.01;
                                            $amount = $amount + $amountPercentage;
                                        ?>
                                        <tr>
                                            <td align="right"><b style="color:red">NOTE:</b></td>
                                            <td style="color:red">1% BNB Transaction Fee (Blockchain) Apply.</td>
                                        </tr>
                                        <tr>
                                            <td align="right">Total Amount to Send:</td>
                                            
                                            <td><?php echo $currency." <b style='color:red'>". ($amount)."</b> (total confirms needed: ".$confirms_needed.")" ?></td>
                                        </tr>
                                        <?php
                                        }
                                        elseif($currency == 'ETH')
                                        {
                                            $amountPercentage = $amount*0.02;
                                            $amount = $amount + $amountPercentage;
                                        ?>
                                        <tr>
                                            <td align="right"><b style="color:red">NOTE:</b></td>
                                            <td style="color:red">2% ETH Transaction Fee (Blockchain) Apply.</td>
                                        </tr>
                                        <tr>
                                            <td align="right">Total Amount to Send:</td>
                                            
                                            <td><?php echo $currency." <b style='color:red'>". ($amount)."</b> (total confirms needed: ".$confirms_needed.")" ?></td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                        <tr>
                                            <td align="right">Received Amount</td>
                                            <td><p id="received_confirms"></p></td>
                                        </tr>
                                         <tr>
                                            <td align="right">Pending Amount</td>
                                            <td><p id="pending_confirms"></p></td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="center">
                                                <img src="<?= $qrcode_url?>" class="img-fluid img-thumbnail">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td align="right">Send To Address:</td>
                                            <td><p style="word-break: break-all;"><?= $address ?></p><p></p></td>
                                        </tr>
                                        <tr>
                                            <td align="right">Time Left:</td>
                                            <td><span id="payment_timeout">0s</span> seconds</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" align="center" class="border-bottom-0">
                                                <a class="btn btn-success btn-lg" target="_blank" href="<?=$checkout_url?>"><?= $txn_id ?></a>
                                            </td>
                                        </tr>
                                        </tbody>
                </table>
								        </div>
                                    </div>
                                </div>
							</div>
						</div>
						<!-- row closed -->
					</div>
				</div>
				<!-- App-content closed -->

<?php include 'footer.php'; ?>

<!--end-->
<script>

    var statusInterVall;
    var timerInterval;
    $(document).ready(function() {
        getTimer('#payment_timeout', <?= $timeOut ?>);
        getStatus("<?= $txn_id ?>");
    });
    
    function getStatus(txn_id)
    {
        $('#payment_status').html('Checking...');

        $.ajax({
            url:'ajax/coinpayment-status.php',
            data:'action=getStatus&txn_id='+txn_id,
            type:'post',
            dataType:'json',
            success:function(json){
                $('#payment_status').html(json.status_text);
                getTimer('#payment_timeout', json.timeOut);
                $('#received_confirms').html(json.receivedf);
                
                var pendingConfirms = parseFloat(json.amountf) - parseFloat(json.receivedf);
                $('#pending_confirms').html(pendingConfirms);
               
                console.log(json.status)
                
                if(json.status>='100' || json.status=='1') {
                    // alert('Congrats! Fund Received!');
                    window.location.href='successPayment.php';
                }else{

                        // Transaction Completed
                    }
                if(json.timeOut>0) {
                    setTimeout('getStatus("'+txn_id+'")', (10*1000));
            }
            }
        });
    }

    function getTimer(div, timer) {
        //alert(seconds);
        var myInterval=setInterval(function () {

            hours = parseInt(timer / 3600, 10);
            rem_mins = timer - (hours*3600);
            mins = parseInt(rem_mins / 60, 10);
            seconds = parseInt(timer % 60, 10);

            if (timer == 0) {
                $(div).html('Expired!');
                clearInterval(myInterval);
                return false;
            } else {
                hours = hours < 10 ? "0" + hours : hours;
                mins = mins < 10 ? "0" + mins : mins;
                seconds = seconds < 10 ? "0" + seconds : seconds;

                $(div).html(hours+'h : '+mins+'m : '+seconds+'s');
                timer--;
            }
        }, 1000);
    }

</script>