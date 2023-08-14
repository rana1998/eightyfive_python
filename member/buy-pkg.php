<?php
include 'header.php';
$page_title = 'Buy Package';
$packageId = 0;
$isPackageActive = 0;
    require 'connect.php';
    $sql= $conn->prepare("SELECT * FROM user_registration WHERE user_name='".$_SESSION['user_name']."'");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    if($sql->rowCount()>0){
     foreach (($sql->fetchAll()) as $key => $row) {

       $threex_amount = $row['threex_amount'];
       $threex_amount_limit = $row['threex_amount_limit'];
       $limit = $threex_amount - $threex_amount_limit;
       $packageHereId = $row['pkg_id'];
       $threex_amount_limit_rem = $threex_amount_limit - 50;
         if(( $packageHereId != 0)){
            
            if($threex_amount >= $threex_amount_limit_rem){
                $packageId = 2;
            }
            

         }
         if($threex_amount_limit > $threex_amount){

            $isPackageActive = 1;
            $packageId = 23;

         }
    }	
}
?>
 <script type="text/javascript" src="https://unpkg.com/web3@0.20.6/dist/web3.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/web3modal@1.9.0/dist/index.js"></script>
    <script type="text/javascript" src="https://unpkg.com/evm-chains@0.2.0/dist/umd/index.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/@walletconnect/web3-provider@1.2.1/dist/umd/index.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>


// window.addEventListener("load", async () => {
//     init();
//     console.log("Intialised")
// });


async function processTransactionHere(id, pkgPrice) {


    var button = document.getElementById("purchaseButton-" + id);
    var accountvalue = document.getElementById("accountvalue").value;

    console.log("amount here", accountvalue)
    // const button = document.getElementById(`purchaseButton-${id}`);
    // button.innerText = 'Processing';
    // button.disabled = true;

    if(parseFloat(accountvalue) > 0){

            //deduct and process the rest of the amount
            if((parseFloat(accountvalue)) > (parseFloat(pkgPrice))){
                var finalprice = ((parseFloat(accountvalue)) - (parseFloat(pkgPrice)));
            }else{
                var finalprice = ((parseFloat(pkgPrice)) - (parseFloat(accountvalue)));
            }
            

            const Web3Modal = window.Web3Modal.default;
const WalletConnectProvider = window.WalletConnectProvider.default;
const evmChains = window.evmChains;

// Web3modal instance
let web3Modal;

// Chosen wallet provider given by the dialog window


// Address of the selected account
let selectedAccount;

/**
 * Setup the orchestra
 */
 
  
//   const providerOptions = {
//   walletconnect: {
//     package: WalletConnectProvider,
//     options: {
//       rpc: {
//         1: 'https://mainnet.infura.io/v3/8043bb2cf99347b1bfadfb233c5325c0' // Replace with your Infura project ID or another Infura endpoint
//       },
//       network: 'mainnet'
//     }
//   },
// };

const providerOptions = {
  walletconnect: {
    package: WalletConnectProvider,
    options: {
      rpc: {
        5: 'https://goerli.infura.io/v3/8043bb2cf99347b1bfadfb233c5325c0' // Replace with your Infura project ID or another Infura endpoint
      },
      network: 'ropsten'
    }
  },
};
  
 web3Modal = new Web3Modal({
    cacheProvider: false, // optional
    providerOptions, // required
    disableInjectedProvider: true, // Disable automatic injection of MetaMask provider
  });
  
let provider = await web3Modal.connect();
    // Connect to WalletConnect and handle connection, session, signing, etc.
    const web3 = new Web3(provider);
    const accounts = await web3.eth.accounts[0];
  try {
    await provider.enable();
    const web3 = new Web3(provider);
    const accounts = await web3.eth.getAccounts();

    const usdtContractAddress = '0xdAC17F958D2ee523a2206206994597C13D831ec7'; // Replace with your actual USDT contract address
    const usdtContractAbi = [
      // USDT Transfer function
      {
        constant: false,
        inputs: [
          {
            name: '_to',
            type: 'address',
          },
          {
            name: '_value',
            type: 'uint256',
          },
        ],
        name: 'transfer',
        outputs: [
          {
            name: '',
            type: 'bool',
          },
        ],
        payable: false,
        stateMutability: 'nonpayable',
        type: 'function',
      },
    ];

    // Get the USDT contract instance
    const usdtContract = new web3.eth.Contract(usdtContractAbi, usdtContractAddress);
    const toAddress = '0xFa544E40b0543F93756F6f1c781E7e924F56f8b2'; // Replace with the recipient's Ethereum address

    // Convert the amount to USDT's decimal representation
    const decimals = 6; // Adjust decimals based on the token's decimal value
    const amountInWei = parseFloat(finalprice); // Make sure pkgPrice is defined and has a valid value

    // Send the USDT transaction

    const result = await usdtContract.methods.transfer(toAddress, amountInWei).send({
  from: accounts[0],
})
  .on('transactionHash', (transactionHash) => {
    // console.log('Transaction hash:', transactionHash);
    // Call the API to store the transaction details
    // Toastify({
    //                             text: `Payment Completed Successfully! Transaction Hash ${transactionHash}`,
    //                             duration: 3000,
    //                             newWindow: true,
    //                             close: true,
    //                             gravity: "top", // `top` or `bottom`
    //                             position: "center", // `left`, `center` or `right`
    //                             stopOnFocus: true, // Prevents dismissing of toast on hover
    //                             style: {
    //                                 background: "linear-gradient(to right, #00b09b, #96c93d)",
    //                             },
    //                             onClick: function(){} // Callback after click
    //                             }).showToast();
    //                             setTimeout(function(){
    //                                 window.location.href = '../member/';
    //             }, 2000);

    fetch('purchase_package_two.php', { 
            method: 'POST',
            body: JSON.stringify({ id: id, txnid: transactionHash })
          })
          .then(response => response.json())
          .then(data => {       
            console.log("error 2",data)
            if (data.status=='success') {
                Toastify({
                                text: "Payment Completed Successfully!",
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top", // `top` or `bottom`
                                position: "center", // `left`, `center` or `right`
                                stopOnFocus: true, // Prevents dismissing of toast on hover
                                style: {
                                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                                },
                                onClick: function(){} // Callback after click
                                }).showToast();
                                setTimeout(function(){
                                    window.location.href = '../member/';
                }, 2000);
            } else {

                Toastify({
                        text: `${data.message}`,
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top", // `top` or `bottom`
                        position: "center", // `left`, `center` or `right`
                        stopOnFocus: true, // Prevents dismissing of toast on hover
                        style: {
                            background: "linear-gradient(to right, #FF0000, #CB4335)",
                        },
                        onClick: function(){} // Callback after click
                        }).showToast();

                        button.innerText = 'Purchase';

            }
        })
          .catch(error => {
            // Handle any errors
            console.log("error",error)
            button.innerText = 'Purchase';
          });


  })
  .on('receipt', (receipt) => {
    console.log('Transaction receipt:', receipt);
    // Perform actions for successful transaction

                Toastify({
                                text: "Payment Completed Successfully!",
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top", // `top` or `bottom`
                                position: "center", // `left`, `center` or `right`
                                stopOnFocus: true, // Prevents dismissing of toast on hover
                                style: {
                                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                                },
                                onClick: function(){} // Callback after click
                                }).showToast();
                                setTimeout(function(){
                                    window.location.href = '../member/';
                }, 2000);

    onSuccess();
  })
  .on('error', (error) => {
    console.error('Transaction error:', error);
    // Perform actions for failed transaction
                Toastify({
                                text: "Payment Error!",
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top", // `top` or `bottom`
                                position: "center", // `left`, `center` or `right`
                                stopOnFocus: true, // Prevents dismissing of toast on hover
                                style: {
                                    background: "linear-gradient(to right, #FF0000, #CB4335)",
                                },
                                onClick: function(){} // Callback after click
                                }).showToast();
                                setTimeout(function(){
                                    window.location.href = '../member/';
                }, 2000);
  });

    // const transactionHash = result.transactionHash;

//     const receipt = await usdtContract.methods.transfer(toAddress, amountInWei).send({
//   from: accounts[0],
// });

// const transactionHash = receipt.transactionHash;
//     const transactionStatus = 'success'

// console.log("result here", result)
//     if(result == null){

//     Toastify({
//                                 text: "Payment Completed Successfully!",
//                                 duration: 3000,
//                                 newWindow: true,
//                                 close: true,
//                                 gravity: "top", // `top` or `bottom`
//                                 position: "center", // `left`, `center` or `right`
//                                 stopOnFocus: true, // Prevents dismissing of toast on hover
//                                 style: {
//                                     background: "linear-gradient(to right, #00b09b, #96c93d)",
//                                 },
//                                 onClick: function(){} // Callback after click
//                                 }).showToast();
//                                 setTimeout(function(){
//                                     window.location.href = '../member/';
//                 }, 2000);

//             }

    // Update the transaction status or perform other actions
    // based on the result of the transaction

    // Optionally, you can also update the UI with the transaction status

  } catch (error) {
    Toastify({
                        text: `Payment Cancelled by User. Transaction Failed. Please Try again.`,
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top", // `top` or `bottom`
                        position: "center", // `left`, `center` or `right`
                        stopOnFocus: true, // Prevents dismissing of toast on hover
                        style: {
                            background: "linear-gradient(to right, #FF0000, #CB4335)",
                        },
                        onClick: function(){} // Callback after click
                        }).showToast();

                        button.innerText = 'Purchase';
  }


        

    }else{


    

    const Web3Modal = window.Web3Modal.default;
const WalletConnectProvider = window.WalletConnectProvider.default;
const evmChains = window.evmChains;

// Web3modal instance
let web3Modal;

// Chosen wallet provider given by the dialog window


// Address of the selected account
let selectedAccount;

/**
 * Setup the orchestra
 */
 
  
//   const providerOptions = {
//   walletconnect: {
//     package: WalletConnectProvider,
//     options: {
//       rpc: {
//         1: 'https://mainnet.infura.io/v3/8043bb2cf99347b1bfadfb233c5325c0' // Replace with your Infura project ID or another Infura endpoint
//       },
//       network: 'mainnet'
//     }
//   },
// };

const providerOptions = {
  walletconnect: {
    package: WalletConnectProvider,
    options: {
      rpc: {
        5: 'https://goerli.infura.io/v3/8043bb2cf99347b1bfadfb233c5325c0' // Replace with your Infura project ID or another Infura endpoint
      },
      network: 'ropsten'
    }
  },
};
  
 web3Modal = new Web3Modal({
    cacheProvider: false, // optional
    providerOptions, // required
    disableInjectedProvider: true, // Disable automatic injection of MetaMask provider
  });
  
let provider = await web3Modal.connect();
    // Connect to WalletConnect and handle connection, session, signing, etc.
    const web3 = new Web3(provider);
    const accounts = await web3.eth.accounts[0];
  try {
    await provider.enable();
    const web3 = new Web3(provider);
    const accounts = await web3.eth.getAccounts();

    const usdtContractAddress = '0xdAC17F958D2ee523a2206206994597C13D831ec7'; // Replace with your actual USDT contract address
    const usdtContractAbi = [
      // USDT Transfer function
      {
        constant: false,
        inputs: [
          {
            name: '_to',
            type: 'address',
          },
          {
            name: '_value',
            type: 'uint256',
          },
        ],
        name: 'transfer',
        outputs: [
          {
            name: '',
            type: 'bool',
          },
        ],
        payable: false,
        stateMutability: 'nonpayable',
        type: 'function',
      },
    ];

    // Get the USDT contract instance
    const usdtContract = new web3.eth.Contract(usdtContractAbi, usdtContractAddress);
    const toAddress = '0xFa544E40b0543F93756F6f1c781E7e924F56f8b2'; // Replace with the recipient's Ethereum address

    // Convert the amount to USDT's decimal representation
    const decimals = 6; // Adjust decimals based on the token's decimal value
    const amountInWei = pkgPrice; // Make sure pkgPrice is defined and has a valid value

    // Send the USDT transaction

    const result = await usdtContract.methods.transfer(toAddress, amountInWei).send({
  from: accounts[0],
})
  .on('transactionHash', (transactionHash) => {
    // console.log('Transaction hash:', transactionHash);
    // Call the API to store the transaction details
    // Toastify({
    //                             text: `Payment Completed Successfully! Transaction Hash ${transactionHash}`,
    //                             duration: 3000,
    //                             newWindow: true,
    //                             close: true,
    //                             gravity: "top", // `top` or `bottom`
    //                             position: "center", // `left`, `center` or `right`
    //                             stopOnFocus: true, // Prevents dismissing of toast on hover
    //                             style: {
    //                                 background: "linear-gradient(to right, #00b09b, #96c93d)",
    //                             },
    //                             onClick: function(){} // Callback after click
    //                             }).showToast();
    //                             setTimeout(function(){
    //                                 window.location.href = '../member/';
    //             }, 2000);

    fetch('purchase_package.php', { 
            method: 'POST',
            body: JSON.stringify({ id: id, txnid: transactionHash })
          })
          .then(response => response.json())
          .then(data => {       
            console.log("error 2",data)
            if (data.status=='success') {
                Toastify({
                                text: "Payment Completed Successfully!",
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top", // `top` or `bottom`
                                position: "center", // `left`, `center` or `right`
                                stopOnFocus: true, // Prevents dismissing of toast on hover
                                style: {
                                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                                },
                                onClick: function(){} // Callback after click
                                }).showToast();
                                setTimeout(function(){
                                    window.location.href = '../member/';
                }, 2000);
            } else {

                Toastify({
                        text: `${data.message}`,
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top", // `top` or `bottom`
                        position: "center", // `left`, `center` or `right`
                        stopOnFocus: true, // Prevents dismissing of toast on hover
                        style: {
                            background: "linear-gradient(to right, #FF0000, #CB4335)",
                        },
                        onClick: function(){} // Callback after click
                        }).showToast();

                        button.innerText = 'Purchase';

            }
        })
          .catch(error => {
            // Handle any errors
            console.log("error",error)
            button.innerText = 'Purchase';
          });


  })
  .on('receipt', (receipt) => {
    console.log('Transaction receipt:', receipt);
    // Perform actions for successful transaction

                Toastify({
                                text: "Payment Completed Successfully!",
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top", // `top` or `bottom`
                                position: "center", // `left`, `center` or `right`
                                stopOnFocus: true, // Prevents dismissing of toast on hover
                                style: {
                                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                                },
                                onClick: function(){} // Callback after click
                                }).showToast();
                                setTimeout(function(){
                                    window.location.href = '../member/';
                }, 2000);

    onSuccess();
  })
  .on('error', (error) => {
    console.error('Transaction error:', error);
    // Perform actions for failed transaction
                Toastify({
                                text: "Payment Error!",
                                duration: 3000,
                                newWindow: true,
                                close: true,
                                gravity: "top", // `top` or `bottom`
                                position: "center", // `left`, `center` or `right`
                                stopOnFocus: true, // Prevents dismissing of toast on hover
                                style: {
                                    background: "linear-gradient(to right, #FF0000, #CB4335)",
                                },
                                onClick: function(){} // Callback after click
                                }).showToast();
                                setTimeout(function(){
                                    window.location.href = '../member/';
                }, 2000);
  });

    // const transactionHash = result.transactionHash;

//     const receipt = await usdtContract.methods.transfer(toAddress, amountInWei).send({
//   from: accounts[0],
// });

// const transactionHash = receipt.transactionHash;
//     const transactionStatus = 'success'

// console.log("result here", result)
//     if(result == null){

//     Toastify({
//                                 text: "Payment Completed Successfully!",
//                                 duration: 3000,
//                                 newWindow: true,
//                                 close: true,
//                                 gravity: "top", // `top` or `bottom`
//                                 position: "center", // `left`, `center` or `right`
//                                 stopOnFocus: true, // Prevents dismissing of toast on hover
//                                 style: {
//                                     background: "linear-gradient(to right, #00b09b, #96c93d)",
//                                 },
//                                 onClick: function(){} // Callback after click
//                                 }).showToast();
//                                 setTimeout(function(){
//                                     window.location.href = '../member/';
//                 }, 2000);

//             }

    // Update the transaction status or perform other actions
    // based on the result of the transaction

    // Optionally, you can also update the UI with the transaction status

  } catch (error) {
    Toastify({
                        text: `Payment Cancelled by User. Transaction Failed. Please Try again.`,
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top", // `top` or `bottom`
                        position: "center", // `left`, `center` or `right`
                        stopOnFocus: true, // Prevents dismissing of toast on hover
                        style: {
                            background: "linear-gradient(to right, #FF0000, #CB4335)",
                        },
                        onClick: function(){} // Callback after click
                        }).showToast();

                        button.innerText = 'Purchase';
  }

}
}

</script>

<style>
.pendingBalance {
    padding: 5px;
    border-radius: 20px;
    background: #badbcc;
    color: #0f5132!important;
}
</style>
<!-- Page Content Start Here -->
<div class="page-wrapper">
    <div class="page-content">
        <!-- Breadcrumb-->
        <div class="row pt-2 pb-2">
            <div class="col-sm-10">
                <h4 class="page-title"><?= $page_title; ?></h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                    <li>&nbsp; / &nbsp;</li>
                    <li class="breadcrumb-item active" aria-current="page"><?= $page_title; ?></li>
                </ol>
            </div>

            <div class="col-sm-2 pendingBalance">
                <h4 class="page-title">$<?= number_format($pendingBalance,2); ?></h4>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active" aria-current="page">Pending Referral Bonus</li>
                </ol>
            </div>
        </div>
        <!-- End Breadcrumb-->
        <div class="col-lg-12 mx-auto">
            <?php
            if($isPackageActive == 1){

                echo '<div class="alert alert-success alert-dismissible">
                    <strong>You already have package subscribed.</strong>
                    </div>';

            }else if($packageId == 0){
           
                    echo '<div class="alert alert-danger alert-dismissible">
                    <strong>Please Purchase Package to Start Using Our Service.</strong>
                    </div>';

            } else if($packageId == 2){
           
                echo '<div class="alert alert-danger alert-dismissible">
                <strong>Your Package is about to expire. Please Purchase New Package to Start Using Our Service.</strong>
                </div>';
          } ?>
        </div>
        <div class="row  mb-5">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">Select your desired package.</div>
                        <?php if(isset($_SESSION['successMsg'])): ?>
                        <div class="alert alert-success border-0 bg-success alert-dismissible fade show py-2">
                            <div class="d-flex align-items-center">
                                <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Success </h6>
                                    <div class="text-white"><?php echo $_SESSION['successMsg']; ?></div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php  unset($_SESSION['successMsg']);     endif;  ?>

                        <?php if(isset($_SESSION['errorMsg'])): ?>
                        <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show py-2">
                            <div class="d-flex align-items-center">
                                <div class="font-35 text-white"><i class='bx bxs-message-square-x'></i>
                                </div>
                                <div class="ms-3">
                                    <h6 class="mb-0 text-white">Error </h6>
                                    <div class="text-white"><?php echo $_SESSION['errorMsg']; ?></div>
                                </div>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php  unset($_SESSION['errorMsg']);     endif;  ?>
                    </div>

                    <div class="row p-2">
                        <?php
       
       $select = "select * from `package`";
       $result = mysqli_query($con,$select);
       
       
       while($row9 = mysqli_fetch_assoc($result))
       {
         $image = $row9['image'];   
         $pkgName = $row9['package_name'];
       ?>


                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <input type="hidden" id="accountvalue" value="<?php echo $pendingBalance; ?>" />
                                        <h4><?php echo ucfirst($row9['package_name']);?></h4>
                                        <hr>
                                        <h4>$<?php echo $row9['pkg_price']; ?></h4>
                                    </div>
                                    <button class="btn btn-sm mt-2 form-control bg-gradient-rose-button-dark text-white"
                                    id="purchaseButton-<?php echo $id; ?>" onclick="this.innerText = 'Processing'; processTransactionHere(<?=$row9['id']?>, <?=$row9['pkg_price']?>)">Purchase</button>
                                </div>
                            </div>
                        </div>

                        <?php  }
       
       
      ?>

                    </div>

                    <!--silver-->

                </div>
            </div>

        </div>
        <!-- End container-fluid-->
    </div>
    <!--End content-wrapper-->

    <?php include 'footer.php'; ?>

    <script>
    //starter
    $('#starterPurchase').on('click', function() {
        if ($('#starterInput').val() == '') {
            $('#starterInput').siblings("#error").html('');
            $('#starterInput').siblings("#error").html('Amount between $50 - $199');
        } else if ($('#starterInput').val() >= 50 && $('#starterInput').val() < 200) {
            $('#starterInput').siblings("#error").html('');
            location.replace("checkout-usdt.php?pkgPrice=" + $('#starterInput').val());
        } else {
            $('#starterInput').siblings("#error").html('Amount between $50 - $199');
        }
    })

    //silver
    $('#silverPurchase').on('click', function() {
        if ($('#silverInput').val() == '') {
            $('#silverInput').siblings("#error").html('');
            $('#silverInput').siblings("#error").html('Amount between $200 - $499');
        } else if ($('#silverInput').val() >= 200 && $('#silverInput').val() < 500) {
            $('#silverInput').siblings("#error").html('');
            location.replace("checkout-usdt.php?pkgPrice=" + $('#silverInput').val());
        } else {
            $('#silverInput').siblings("#error").html('Amount between $200 - $499');
        }
    })
    //gold
    $('#goldPurchase').on('click', function() {
        if ($('#goldInput').val() == '') {
            $('#goldInput').siblings("#error").html('');
            $('#goldInput').siblings("#error").html('Amount between $500 - $999');
        } else if ($('#goldInput').val() >= 500 && $('#goldInput').val() < 1000) {
            $('#goldInput').siblings("#error").html('');
            location.replace("checkout-usdt.php?pkgPrice=" + $('#goldInput').val());
        } else {
            $('#goldInput').siblings("#error").html('Amount between $500 - $999');
        }
    })
    //platinum
    $('#platinumPurchase').on('click', function() {
        if ($('#platinumInput').val() == '') {
            $('#platinumInput').siblings("#error").html('');
            $('#platinumInput').siblings("#error").html('Amount between $1000 - $4999');
        } else if ($('#platinumInput').val() >= 1000 && $('#platinumInput').val() < 5000) {
            $('#platinumInput').siblings("#error").html('');
            location.replace("checkout-usdt.php?pkgPrice=" + $('#platinumInput').val());
        } else {
            $('#platinumInput').siblings("#error").html('Amount between $1000 - $4999');
        }
    })
    //diamond
    $('#diamondPurchase').on('click', function() {
        if ($('#diamondInput').val() == '') {
            $('#diamondInput').siblings("#error").html('');
            $('#diamondInput').siblings("#error").html('Amount between $5000 - $9999');
        } else if ($('#diamondInput').val() >= 5000 && $('#diamondInput').val() < 10000) {
            $('#diamondInput').siblings("#error").html('');
            location.replace("checkout-usdt.php?pkgPrice=" + $('#diamondInput').val());
        } else {
            $('#diamondInput').siblings("#error").html('Amount between $5000 - $9999');
        }
    })
    //blue-diamond
    $('#blue-diamondPurchase').on('click', function() {
        if ($('#blue-diamondInput').val() == '') {
            $('#blue-diamondInput').siblings("#error").html('');
            $('#blue-diamondInput').siblings("#error").html('Amount between $10000 - $19999');
        } else if ($('#blue-diamondInput').val() >= 10000 && $('#blue-diamondInput').val() < 20000) {
            $('#blue-diamondInput').siblings("#error").html('');
            location.replace("checkout-usdt.php?pkgPrice=" + $('#blue-diamondInput').val());
        } else {
            $('#blue-diamondInput').siblings("#error").html('Amount between $10000 - $19999');
        }
    })
    //black-diamond
    $('#black-diamondPurchase').on('click', function() {
        if ($('#black-diamondInput').val() == '') {
            $('#black-diamondInput').siblings("#error").html('');
            $('#black-diamondInput').siblings("#error").html('Min Amount $20000');
        } else if ($('#black-diamondInput').val() >= 20000) {
            $('#black-diamondInput').siblings("#error").html('');
            location.replace("checkout-usdt.php?pkgPrice=" + $('#black-diamondInput').val());
        } else {
            $('#black-diamondInput').siblings("#error").html('Min Amount $20000');
        }
    })
    </script>

    <script type="text/javascript" src="https://unpkg.com/web3@1.2.11/dist/web3.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/web3modal@1.9.0/dist/index.js"></script>
    <script type="text/javascript" src="https://unpkg.com/evm-chains@0.2.0/dist/umd/index.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/@walletconnect/web3-provider@1.2.1/dist/umd/index.min.js">
    </script>
