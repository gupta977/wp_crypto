async function crypto_is_metamask_Connected() {

    var result = new Array();


    const accounts = await ethereum.request({
        method: 'eth_accounts'
    });
    const networkId = await ethereum.request({
        method: 'net_version'
    });

    if (accounts.length) {
        // console.log(`Connected to: ${accounts[0]}`);
        result['addr'] = accounts[0];
        result['network'] = networkId;

    } else {
        result['addr'] = '';
    }

    return result;
}



    const contractAddress = "0x826fe8a7E5983000E5E52657384C4f5d4BAE20D0"; // Update with the address of your smart contract
    const contractAbi = "./web3domain.json"; // Update with an ABI file, for example "./sampleAbi.json"
    let web3; // Web3 instance
    let contract; // Contract instance
    let account; // Your account as will be reported by Metamask

    function crypto_init()
    {
         // Create a Web3 instance
    web3 = new Web3(window.ethereum);
    connectWallet();
    connectContract(contractAbi, contractAddress);
    }

    // Connect to the MetaMast wallet
const connectWallet = async () => {
    const accounts = await ethereum.request({ method: "eth_requestAccounts" });
    account = accounts[0];
    console.log(`Connected account...........: ${account}`);
  };

  // Helper function to get JSON (in order to read ABI in our case)
const getJson = async (path) => {
    const response = await fetch(path);
    const data = await response.json();
    return data;
  };
  

  // Connect to the contract
const connectContract = async (contractAbi, contractAddress) => {
    const data = await getJson(contractAbi);
    const contractABI = data.abi;
    contract = new web3.eth.Contract(contractABI, contractAddress);
  };
  

