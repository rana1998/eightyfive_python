<!DOCTYPE html>
<html>
<head>
  <title>USDT Purchase</title>
  <script src="https://cdn.ethers.io/lib/ethers-5.0.umd.min.js"></script>
</head>
<body>
  <h1>USDT Purchase</h1>

  <button id="connectBtn">Connect MetaMask</button>
  <br><br>
  <button id="purchaseBtn" disabled>Purchase Product</button>

  <script>
    // Replace with your actual USDT contract address
    const usdtContractAddress = '0x...';

    // Replace with the URL of your saveorder.php script
    const saveOrderScript = 'https://example.com/saveorder.php';

    // Connect MetaMask when the Connect button is clicked
    document.getElementById('connectBtn').addEventListener('click', connectMetaMask);

    // Trigger purchase when the Purchase button is clicked
    document.getElementById('purchaseBtn').addEventListener('click', () => {
      const product = 'Product Name';
      const amount = 1; // Set the desired amount of USDT
      
      purchaseWithUSDT(product, amount, usdtContractAddress, saveOrderScript);
    });

    // Function to enable the Purchase button when MetaMask is connected
    function enablePurchaseButton() {
      document.getElementById('purchaseBtn').disabled = false;
    }

    // Function to disable the Purchase button when MetaMask is disconnected
    function disablePurchaseButton() {
      document.getElementById('purchaseBtn').disabled = true;
    }

    // Function to handle MetaMask connection
    async function connectMetaMask() {
      if (typeof window.ethereum !== 'undefined') {
        try {
          await window.ethereum.request({ method: 'eth_requestAccounts' });
          console.log('MetaMask connected');
          enablePurchaseButton();
        } catch (error) {
          console.error('MetaMask connection error:', error);
          disablePurchaseButton();
        }
      } else {
        console.error('MetaMask not found');
        disablePurchaseButton();
      }
    }

    // Rest of the code for purchaseWithUSDT, getGasLimit, encodeTransferData,
    // waitForTransactionConfirmation, delay functions, as shown in the previous JavaScript code

  </script>
</body>
</html>