<!DOCTYPE html>
<html>
<head>
  <title>Web3Modal Example</title>
</head>
<body>
  <h1>Web3Modal Example</h1>

  <button id="connectButton">Connect with Web3Modal</button>

  <script src="https://cdn.jsdelivr.net/npm/web3modal@1.10.0/dist/web3modal.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@web3modal/ethereum@1.10.0/dist/index.umd.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@wagmi/core@1.2.0/dist/wagmi.umd.min.js"></script>
  <script>
    // Function to initialize the Web3Modal
    function initWeb3Modal() {
      // Define the chains and project ID
      const chains = [
        <?php echo json_encode(arbitrum); ?>,
        <?php echo json_encode(mainnet); ?>,
        <?php echo json_encode(polygon); ?>
      ];
      const projectId = 'YOUR_PROJECT_ID';

      // Configure the chains and create the Web3Modal config
      const { publicClient } = configureChains(chains, [w3mProvider({ projectId })]);
      const wagmiConfig = createConfig({
        autoConnect: true,
        connectors: w3mConnectors({ projectId, version: 1, chains }),
        publicClient
      });

      // Create the EthereumClient and Web3Modal instances
      const ethereumClient = new EthereumClient(wagmiConfig, chains);
      const web3modal = new Web3Modal({ projectId }, ethereumClient);

      // Event listener for the connect button
      const connectButton = document.getElementById('connectButton');
      connectButton.addEventListener('click', async () => {
        try {
          // Open the Web3Modal provider selection dialog
          const provider = await web3modal.open();

          // Get the selected provider's instance
          const web3 = new Web3(provider);

          // Retrieve the user's accounts
          const accounts = await web3.eth.getAccounts();
          const address = accounts[0];

          console.log('Connected with Web3Modal');
          console.log('Address:', address);

          // Perform other actions with the connected wallet here...

        } catch (error) {
          console.log('Error connecting with Web3Modal:', error);
        }
      });
    }

    // Initialize the Web3Modal
    initWeb3Modal();
  </script>
</body>
</html>
