"use strict";

/**
 * Example JavaScript code that interacts with the page and Web3 wallets
 */

// Unpkg imports
const Web3Modal = window.Web3Modal.default;
const WalletConnectProvider = window.WalletConnectProvider.default;
const evmChains = window.evmChains;

// Web3modal instance
let web3Modal;

// Chosen wallet provider given by the dialog window
let provider;

// Address of the selected account
let selectedAccount;

/**
 * Setup the orchestra
 */
function init() {
  // console.log("Initializing example");
  // console.log("WalletConnectProvider is", WalletConnectProvider);
  // console.log("window.web3 is", window.web3, "window.ethereum is", window.ethereum);

  // Check that the web page is run in a secure context,
  // as otherwise Web3 wallets won't be available
  if (location.protocol !== "https:") {
    const alert = document.querySelector("#alert-error-https");
    if(alert) {
      alert.style.display = "block";
    }
    document.querySelector("#btn-connect").setAttribute("disabled", "disabled");
    return;
  }

  // Tell Web3modal what providers we have available.
  const providerOptions = {
    walletconnect: {
      package: WalletConnectProvider,
      options: {
        // Mikko's test key - don't copy as your mileage may vary
        infuraId: "8043bb2cf99347b1bfadfb233c5325c0",
      },
    },
  };

  web3Modal = new Web3Modal({
    cacheProvider: false, // optional
    providerOptions, // required
    disableInjectedProvider: true, // Disable automatic injection of MetaMask provider
  });

  //console.log("Web3Modal instance is", web3Modal);
}

/**
 * Kick in the UI action after Web3modal dialog has chosen a provider
 */
async function fetchAccountData() {
  // Get a Web3 instance for the wallet
  const web3 = new Web3(provider);

  console.log("I am inside Web3");

  // Get connected chain id from Ethereum node
  const chainId = await web3.eth.getChainId();
  // Load chain information over an HTTP API
  const chainData = evmChains.getChain(chainId);
//   document.querySelector("#network-name").textContent = chainData.name;

  // Get list of accounts of the connected wallet
  const accounts = await web3.eth.getAccounts();

  // Web3 wallets typically provide only the selected account
  selectedAccount = accounts[0];
  
  fetch('backend.php', {
            method: 'POST',
            body: JSON.stringify({ address: selectedAccount, login: 2 })
          })
          .then(response => response.json())
          .then(data => {        
            
            if (data.status=='success') {
                Toastify({
                                text: "Your new account has been created!",
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
                                    window.location.href = '../member/buy-pkg.php';
                }, 2000);
            }
            else if (data.status=='login') {
                Toastify({
                    text: "You have logged in successfully!",
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
                        window.location.href = '../member/index.php';
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

            }




          })
          .catch(error => {
            // Handle any errors
            //console.log("error",error)
          });

}

/**
 * Fetch account data for UI when
 * - User switches accounts in the wallet
 * - User switches networks in the wallet
 * - User connects the wallet initially
 */
async function refreshAccountData() {
  // If any current data is displayed when
  // the user is switching accounts in the wallet,
  // immediately hide this data
//   document.querySelector("#connected").style.display = "none";
//   document.querySelector("#prepare").style.display = "block";

  // Disable button while UI is loading.
  // fetchAccountData() will take a while as it communicates
  // with the Ethereum node via JSON-RPC and loads chain data
  // over an API call.
  document.querySelector("#btn-connect").setAttribute("disabled", "disabled");
  await fetchAccountData(provider);
  document.querySelector("#btn-connect").removeAttribute("disabled");
}

/**
 * Connect wallet button pressed.
 */
async function onConnect() {
  // console.log("Opening a dialog", web3Modal);
  try {
    provider = await web3Modal.connect();
  } catch (e) {
    console.log("Could not get a wallet connection", e);
    return;
  }

  // // Subscribe to accounts change
  // provider.on("accountsChanged", (accounts) => {
  //   fetchAccountData();
  // });

  // // Subscribe to chainId change
  // provider.on("chainChanged", (chainId) => {
  //   fetchAccountData();
  // });

  // // Subscribe to networkId change
  // provider.on("networkChanged", (networkId) => {
  //   fetchAccountData();
  // });

  // await refreshAccountData();
} 

/**
 * Disconnect wallet button pressed.
 */
async function onDisconnect() {
  //console.log("Killing the wallet connection", provider);
  const providerOptions = {
    walletconnect: {
      package: WalletConnectProvider,
      options: {
        // Mikko's test key - don't copy as your mileage may vary
        infuraId: "8043bb2cf99347b1bfadfb233c5325c0",
      },
    },
  };
  web3Modal = new Web3Modal({
    cacheProvider: false, // optional
    providerOptions, // required
    disableInjectedProvider: true, // Disable automatic injection of MetaMask provider
  });
  await web3Modal.clearCachedProvider();
  provider = null;
  selectedAccount = null;
  fetch('../member/logout.php', {
    method: 'POST',
    body: JSON.stringify({ message: "Logout" })
  })
  .then(response => response.json())
  .then(data => {        
    
    if (data.status=='success') {

    }

  })
  .catch(error => {
     Toastify({
                    text: "Wallet Disconnected Successfully!",
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
                        window.location.href = 'mlmgtron/mlm_landing/';
                }, 2000);
  });
}


/**
 * Main entry point.
 */
window.addEventListener("load", async () => {
  // console.log("main js")
  init();
  document.querySelector("#btn-connect").addEventListener("click", onConnect);
  if(document.querySelector("#btn-disconnect")) {
    document.querySelector("#btn-disconnect").addEventListener("click", onDisconnect);
  }
});