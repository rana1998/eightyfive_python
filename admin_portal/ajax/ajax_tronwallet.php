<?php
// require '../../vendor/autoload.php';

require '../../vendor/autoload.php';

use IEXBase\TronAPI\Tron;

require_once('../core/config.php');
require_once('../core/session.php');
require_once('../helper/AdminHelper.php');
$db = getDB();  

session_start();


if(isset($_SESSION['isOTPmatch']) && $_SESSION['isOTPmatch'] == true) {

    unset($_SESSION['isOTPmatch']);

    $curl = curl_init();

    $receiverWalletAddress = $_POST['walletAddress'];
    $gtronAmount = (float)$_POST['gtronAmount'];

    curl_setopt_array($curl, [
    CURLOPT_URL => "https://api.shasta.trongrid.io/wallet/createtransaction",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode([
        'owner_address' => 'TZ4UXDV5ZhNW7fb2AMSbgfAEZ7hWsnYS2g',
        // 'to_address' => '$receiverWalletAddress',
        'to_address' => 'TPswDDCAWhJAZGdHPidFg5nEf8TkNToDX1',
        'amount' => $gtronAmount,
        'visible' => true
    ]),
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "content-type: application/json"
    ],
    ]);

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    // echo $response;
    // exit();

    if ($err) {
    // echo "cURL Error #:" . $err;
    echo "failed";
    } else {
        // $res = AdminHelper::updateAdminWalletSummeryLogs($db,$gtronAmount,$receiverWalletAddress);
        // if($res == 'Data inserted successfully.') {
            // echo $response;
        // }
        // Include Composer's autoloader
        


        // // Replace 'your_private_key' with your actual private key
        // $privateKey = 'c77eff71a698c77a108f20b85c1f16c88aca4422b15164a88de86088b1b1eef5';

        // // Instantiate Tron
        // $tron = new Tron('https://api.shasta.trongrid.io');

        // // Replace with the correct addresses
        // $ownerAddress = 'TZ4UXDV5ZhNW7fb2AMSbgfAEZ7hWsnYS2g';
        // $toAddress = 'TPswDDCAWhJAZGdHPidFg5nEf8TkNToDX1';
        // $gtronAmount = 100; // Replace with the actual amount

        // try {
        //     // Create the transaction
        //     $transaction = $tron->transactionBuilder->sendTrx($toAddress, $gtronAmount, $ownerAddress, $ownerAddress);

        //     // Sign the transaction using your private key
        //     $signedTransaction = $tron->signTransaction($transaction, $privateKey);

        //     // Broadcast the signed transaction
        //     $broadcastResponse = $tron->sendRawTransaction($signedTransaction);

        //     if ($broadcastResponse['result'] == true) {
        //         echo "Transaction Broadcasted Successfully. TXID: " . $broadcastResponse['txid'];
        //     } else {
        //         echo "Broadcasting Failed. Error: " . $broadcastResponse['message'];
        //     }
        // } catch (Exception $e) {
        //     echo "Error: " . $e->getMessage();
        // }
        
    }
} else {
    echo "failed";
}

?>