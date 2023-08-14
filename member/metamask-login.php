<!DOCTYPE html>
<html>
<head>
  <title>MetaMask Login</title>
  <script src="https://cdn.jsdelivr.net/npm/web3@1.5.2/dist/web3.min.js"></script>
</head>
<body>
  <h1>MetaMask Login</h1>

  <button onclick="loginWithMetaMask()">Log in with MetaMask</button>

  <script>
    function loginWithMetaMask() {
      // Check if MetaMask is available
      if (typeof window.ethereum !== 'undefined') {
        const web3 = new Web3(window.ethereum);

        // Request account access
        window.ethereum.enable().then(function(accounts) {
          // User has approved account access
          const address = accounts[0];

          // Send the address to the PHP backend
          fetch('backend.php', {
            method: 'POST',
            body: JSON.stringify({ address: address })
          })
          .then(response => response.json())
          .then(data => {
            console.log(data.message); // Log the value of the 'message' property in the parsed JSON data
          })
          .catch(error => {
            // Handle any errors
            console.log("error",error)
          });
        })
        .catch(function(error) {
          // User has denied account access
          // Handle the denial or display an error message
        });
      } else {
        // MetaMask is not available
        // Display an error message or handle the situation
      }
    }
  </script>
</body>
</html>
