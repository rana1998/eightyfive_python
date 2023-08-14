<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);


// $receiverWalletAddress = $_POST['walletAddress'];
// $gtronAmount = (float)$_POST['gtronAmount'];

// Sample receiver wallet address and amount
$receiverWalletAddress = "TPHyyDRvbT3LgoSmqWTHVuMUBeZB45jKvk";
$ownerAddress = "TMshLMuGQjpBW3HvyuCCgYM2tQ7CoQSyQv"; //"Development purpose"
$gtronAmount = 100;

// Sample private key for demonstration purposes (DO NOT USE THIS IN PRODUCTION)
$privateKey = 'c77eff71a698c77a108f20b85c1f16c88aca4422b15164a88de86088b1b1eef5';

// TronWeb API endpoint for creating and broadcasting transactions (Shasta testnet)
$apiEndpoint = 'https://api.shasta.trongrid.io';

// Construct the transaction data in JSON format
$transactionData = [
    'to_address' => $receiverWalletAddress,
    'owner_address' => 'TMshLMuGQjpBW3HvyuCCgYM2tQ7CoQSyQv',
    // 'owner_address' => $ownerAddress,
    'amount' => $gtronAmount,
    'visible' => true
];

// Create the transaction using cURL
$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => "{$apiEndpoint}/wallet/createtransaction",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => json_encode($transactionData),
    CURLOPT_HTTPHEADER => [
        "accept: application/json",
        "content-type: application/json"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

if ($err) {
    echo "cURL Error: " . $err;
} else {
    // Decode the transaction data
    $transaction = json_decode($response, true);

    // Sign the transaction using the provided private key
    $signedTransaction = [
        'transaction' => $transaction,
        'privateKey' => $privateKey
    ];

    print_r($signedTransaction);

    // // Broadcast the signed transaction using cURL
    // $curl = curl_init();
    // curl_setopt_array($curl, [
    //     CURLOPT_URL => "{$apiEndpoint}/wallet/broadcasttransaction",
    //     CURLOPT_RETURNTRANSFER => true,
    //     CURLOPT_ENCODING => "",
    //     CURLOPT_MAXREDIRS => 10,
    //     CURLOPT_TIMEOUT => 30,
    //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //     CURLOPT_CUSTOMREQUEST => "POST",
    //     CURLOPT_POSTFIELDS => json_encode($signedTransaction),
    //     CURLOPT_HTTPHEADER => [
    //         "accept: application/json",
    //         "content-type: application/json"
    //     ],
    // ]);

    // $broadcastResponse = curl_exec($curl);
    // var_dump($broadcastResponse); // or print_r($broadcastResponse);

    // $err = curl_error($curl);
    // curl_close($curl);

    // if ($err) {
    //     echo "Broadcasting Error: " . $err;
    // } else {
    //     // Process the broadcast response
    //     $broadcastResponse = json_decode($broadcastResponse, true);
    //     if (isset($broadcastResponse['result']) && $broadcastResponse['result']) {
    //         echo "Transaction Broadcasted Successfully. TXID: " . $broadcastResponse['txid'];
    //     } else {
    //         if (isset($broadcastResponse['error']) && isset($broadcastResponse['error']['message'])) {
    //             echo "Broadcasting Failed. Error: " . $broadcastResponse['error']['message'];
    //         } else {
    //             echo "Broadcasting Failed. Unknown Error.";
    //         }
    //     }
    // }
}



?>