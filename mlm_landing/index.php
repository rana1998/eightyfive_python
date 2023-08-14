<?php
    session_start();
    if(isset($_GET['reff']) && $_GET['reff'] !== ''){ $_SESSION['reff'] = $_GET['reff']; } else { $_SESSION['reff'] = 'notdefined'; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gtron | The highly anticipated Decentralized Matrix platform</title>
    <link rel="icon" type="image/x-icon" href="images/gtron-fav.svg">
    <!-- <script src="https://cdn.jsdelivr.net/npm/tronweb/dist/tronweb.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/tronweb@5.3.0/dist/TronWeb.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/index1.css">
    <link rel="stylesheet" href="css/index2.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Position fixed to cover the whole screen */
    z-index: 1; /* Set a high z-index to make sure it overlays other elements */
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto; /* Enable scrolling if needed */
    background-color: rgba(0, 0, 0, 0.4); /* Black background with opacity */
  }
  
  .modal-content {
    background-color: #fefefe;
    margin: 15% auto; /* Center modal vertically and horizontally */
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    max-width: 600px;
  }

  p.sublabeltext {
    margin-top: -10px;
    color: #908c8c;
    white-space: pre-wrap;
  overflow-wrap: break-word;
}
  
  /* Button styles */
  .open-modal-btn {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 0;
    cursor: pointer;
  }
  p.labeltext {
    font-size: 20px;
    font-weight: 900;
    margin-top: 20px;
}

  .modal-top {
      display: flex;
      flex-direction: row;
      justify-content: space-around;
  }

  button.btnconnect {
  background: none;
  border: none;
  flex:1;
}

.modal-content {
  text-align: center;
}</style>
</head>
<body>
    <nav class="navbar custom-navbar navbar-expand-md ">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="images/gtron-logo.svg" alt="logo">
            </a>
            <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#getstrated">Get started</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#why">Benefits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#faq">FAQ</a>
                    </li>
                </ul>
                <span class="navbar-text">

                <?php if(isset( $_SESSION['user_name'])){ ?>
                    <button class="btn" id="btn-disconnect" onclick="onDisconnect()">
                        <img src="images/wallet.png" alt="">
                        Disconnect Wallet
                    </button>
                    <?php }else{ ?>
                <button class="btn" onclick="openModal()">
                        <img src="images/wallet.png" alt="">
                        Connect Wallet
                    </button>
<?php } ?>
                    

                    
                </span>
            </div>
        </div>
    </nav>
    <article class=" one-bg row">
        <div  class="">
            <h2>A New Born Crypto Innovation to<br><span class="blue-txt">Multiply your Wealth</span><span
                    class="blinking-cursor">_</span></h2>
            <p>A smart protocol where great ideas are<br> supported & decision are made through community governance</p>
            <button id="getstrated" class="btn" onclick="openModal()">Get Started</button>
        </div>
        <!-- <div class=" col-12 col-md-5">
            <img src="/images/one.gif" alt="">
        </div> -->
        <!-- <div class="box col-12 col-md-5">
            <div id="one"></div>
        </div> -->



    </article>

    <article class="global-community">
        <div class="global-div">
            <div>
                GLOBAL COMMUNITY
            </div>
        </div>
        <h2 id="why">Why Choose GTRON?</h2>
        <div class="row">
            <div class="col col-12  types-col">
                <div class="img-div">
                    <img src="images/security.png" alt="">
                </div>

                <h5>Transparency</h5>
                <p>You can transparently view all transactions and details that have been made since the date the Smart Contract was created.</p>
            </div>
            <div class="col col-12 types-col">
                <div class="img-div">
                    <img src="images/blockchain.png" alt="">
                </div>
                <h5>Decentralized</h5>
                <p>GTRON  is not managed by anyone, including its own software team. It is developed as a fully automatic system.</p>
            </div>
            <div class="col col-12 types-col">
                <div class="img-div">
                    <img src="images/padlock.png" alt="">
                </div>
                <h5>High Security</h5>
                <p>GTRON is a part of Blockchain technology. Blockchain is a secure technology that no hacker can access</p>
            </div>
        </div>
        <p>
        Welcome to GTRON - Smart Investment Platform!

At GTRON, you can invest and earn up to 200% on your investment with the potential for passive income. Our platform provides a unique opportunity for users to invest and grow their wealth through referrals, bonus distribution, and reinvestments.
        </p>
    </article>
    <article class="referral-income">
        <div class="referral-top">
            <div class="number">

                <img src="images/num-one.png" alt="">
            </div>
            <div class="referral-txt-div">
                <div>
                    REFERRAL INCOME
                </div>
            </div>
            <h2>Explanation of <span>Level Income</span></h2>
            <p>Choose from our range of flexible investment packages:</p>
        </div>
        <div class="referral-bottom row">
            <div class="col col-12 col-sm-6 explain-col-left">
                <div class="row heading">
                    <div class="col col-3 ">Level</div>
                    <div class="col col-1"></div>
                    <div class="col col-8">Referral</div>
                </div>
                <div class="row">
                    <div class="col col-3">1.</div>
                    <div class="col col-1">-</div>
                    <div class="col col-8">50% commission</div>
                </div>
                <div class="row">
                    <div class="col col-3">2.</div>
                    <div class="col col-1">-</div>
                    <div class="col col-8">8% commission (2 Direct Referrals Required)</div>
                </div>
                <div class="row">
                    <div class="col col-3">3.</div>
                    <div class="col col-1">-</div>
                    <div class="col col-8">6% commission (3 Direct Referrals Required)</div>
                </div>
                <div class="row">
                    <div class="col col-3">4.</div>
                    <div class="col col-1">-</div>
                    <div class="col col-8">4% commission (4 Direct Referrals Required)</div>
                </div>
                <div class="row">
                    <div class="col col-3">5.</div>
                    <div class="col col-1">-</div>
                    <div class="col col-8">3% commission (5 Direct Referrals Required)</div>
                </div>
                <div class="row">
                    <div class="col col-3">6.</div>
                    <div class="col col-1">-</div>
                    <div class="col col-8">1% commission (6 Direct Referrals Required)</div>
                </div>
                <div class="row">
                    <div class="col col-3">7.</div>
                    <div class="col col-1">-</div>
                    <div class="col col-8">1% commission (7 Direct Referrals Required)</div>
                </div>
                <div class="row">
                    <div class="col col-3">8.</div>
                    <div class="col col-1">-</div>
                    <div class="col col-8">1% commission (8 Direct Referrals Required)</div>
                </div>
                <div class="row">
                    <div class="col col-3">9.</div>
                    <div class="col col-1">-</div>
                    <div class="col col-8">0.5% commission (9 Direct Referrals Required)</div>
                </div>
                <div class="row">
                    <div class="col col-3">10.</div>
                    <div class="col col-1">-</div>
                    <div class="col col-8">0.5% commission (10 Direct Referrals Required)</div>
                </div>
            </div>

            <div class="col col-12 col-sm-6 explain-col-right">
                <h5 class="heading">Global Pool</h5>
                <ul>
                    <li>The total investment from the team exceeds $120000.</li>
                </ul>
                <h5 class="heading">Restriction of level Income</h5>
                <ul>
                    <li>To qualify for level 1 income, the user must have a minimum of 2 direct referrals.</li>
                    <li>Users will receive the same commission and bonus for every reinvestment, maximizing their earning potential.
                    </li>
                    <li>All GTRON users will receive a share of 20% from new user investments. For example, when someone joins with 100 USDT, 50% goes to their sponsor, 20% is distributed among 29 levels, and the remaining 20% is shared equally among all users.</li>
                </ul>
            </div>
        </div>

        <p class="blue-p">Start investing today and watch your wealth grow with GTRON</p>
    </article>

    <article class="partners-payout">
        <!-- <div class="partners-top">
            <div class="number">
                <img src="images/num-two.png" alt="">
            </div>
            <div class="partners-txt-div">
                <div>
                    PARTNERS PAYOUT
                </div>
            </div>
            <h2>Explanation of <span>Partner Income</span></h2>
            <p>The first user or parent will access the platform with an initial amount of $50 <br>Initial amount +
                referral
                income (USDT) = $50 + 7%</p>
        </div> -->

        <!-- <div class="join-members">
            <img src="images/join-members.png" alt="">
        </div> -->
    </article>
<style>
    .onebtt{   
        background: #09001D;
        border-radius: 15px;
        color: #5BEFE8;
        display: flex;
        align-items: end;
        padding: 0.5rem 1rem;
        border: 1px solid #685CFF;
        float: right;
    }
    </style>
    <article class="referral-income">
        <div class="referral-top">
            <div class="number">

                <img src="images/num-one.png" alt="">
            </div>
            <div class="referral-txt-div">
                <div>
                    PACKAGES
                </div>
            </div>
        </div>
        <div class="referral-bottom row">
            <div class="col col-12 col-sm-12 explain-col-left">
                <div class="row heading">
                    <div class="col col-3 ">Package</div>
                    <div class="col col-1"></div>
                    <div class="col col-8">Connect Wallet</div>
                </div>
                <div class="row">
                    <div class="col col-3">$50 USDT</div>
                    <div class="col col-1">-</div>
                    <div class="col col-8"><button class="btn onebtt" onclick="openModal()">
                        <img src="images/wallet.png" alt="">
                        Connect Wallet
                    </button></div>
                </div>
                <div class="row">
                <div class="col col-3">$100 USDT</div>
                    <div class="col col-1">-</div>
                    <div class="col col-8"><button class="btn onebtt" onclick="openModal()">
                        <img src="images/wallet.png" alt="">
                        Connect Wallet
                    </button></div>
                </div>
                <div class="row">
                <div class="col col-3">$250 USDT</div>
                    <div class="col col-1">-</div>
                    <div class="col col-8"><button class="btn onebtt" onclick="openModal()">
                        <img src="images/wallet.png" alt="">
                        Connect Wallet
                    </button></div>
                </div>
                <div class="row">
                <div class="col col-3">$500 USDT</div>
                    <div class="col col-1">-</div>
                    <div class="col col-8"><button class="btn onebtt" onclick="openModal()">
                        <img src="images/wallet.png" alt="">
                        Connect Wallet
                    </button></div>
                </div>
                <div class="row">
                <div class="col col-3">$1000 USDT</div>
                    <div class="col col-1">-</div>
                    <div class="col col-8"><button class="btn onebtt" onclick="openModal()">
                        <img src="images/wallet.png" alt="">
                        Connect Wallet
                    </button></div>
                </div>
            </div>

    </article>

    <article id="faq" class="faq">
        <h2>Frequently asked <span>Questions</span></h2>
        <p>You can send email with your questions and we'll give your answer</p>

        <div class="faq-accordion-main">
            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button " type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                            <img src="images/right-arrow.png" alt="">

                            What is Gtron?
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse show"
                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">
                            GTRON is a smart protocol where great ideas are
supported & decision are made through community governance</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                            <img src="images/right-arrow.png" alt="">

                            How many levels of total income streams are there with Gtron?
                        </button>
                    </h2>
                    <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">There are total 10 Level income streams available with GTRON.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseThree" aria-expanded="false"
                            aria-controls="flush-collapseThree">
                            <img src="images/right-arrow.png" alt="">

                            What is the minimum investment required to join Gtron?
                        </button>
                    </h2>
                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                        aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">Minimum investment to start with is $50 USDT.</div>
                    </div>
                </div>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingFour">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseFour" aria-expanded="false"
                            aria-controls="flush-collapseFour">
                            <img src="images/right-arrow.png" alt="">

                            How secure is my investment with Gtron?
                        </button>
                    </h2>
                    <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">GTRON is based on Blockchain Technology. Blockchain is most Secure from Hackers.</div>
                    </div>
                </div>
            </div>
        </div>
    </article>

    <article class="join-gtron">
        <div class="bg-img-left"><img src="images/left-box.png" alt=""></div>
        <div class="bg-img-right"><img src="images/right-box.png" alt=""></div>
        <div class="start-revo">
            <div>
                START THE REVOLUTION
            </div>
        </div>
        <h2>Ready to join <span>Gtron?</span></h2>
        <p>Create an account and start right away. <br>Want more information? Reach out us.</p>
        <div class="btn-div">
            <button class=" btn left" onclick="openModal()">Get Started</button>
            <button class="btn right">Get in Touch</button>
        </div>
    </article>

    <footer>
        <div class="top">
            <p>Smart-Contract :</p>
            <p><a href="">TR7NHqjeKQxGTCi8q8ZY4pL8otSzgjLj6t</a></p>
            <p>Support : support@gtron.com</p>
        </div>
        <div class="bottom">
            <div>&COPY; Gtron 2023 - All rights reserved</div>
            <div>
                <a href=""><img src="images/instagram.png" alt=""></a>
                <a href=""><img src="images/twitter.png" alt=""></a>
            </div>
        </div>
    </footer>
    <div id="myModal" class="modal">
    <!-- Modal content -->
        <div class="modal-content">
        <p class="labeltext">Choose your preferred wallet:</p>
        <div class="modal-top">
        <button class="btnconnect" onclick="connectWithTronlink('<?php if(isset($_GET['reff']) && $_GET['reff'] !== ''){ echo $_GET['reff']; } else { echo 'notdefined'; } ?>')">
            <img src="images/tron-link.png" alt="TronLink Logo" width="60" height="60">
            <p class="labeltext">TronLink</p>
            <p class="sublabeltext">Connect to Your TronLink</p>
        </button>
        <button class="btnconnect" id="btn-connect">
            <img src="images/wallet-connect.png" alt="WalletConnect Logo" width="60" height="60">
            <p class="labeltext">Wallet Connect</p>
            <p class="sublabeltext">Scan with WalletConnect to Connect</p>
        </button></div>
        </div>
    </div>
</body>
<script>
    const navbar = document.querySelector('.custom-navbar');
    window.onscroll = () => {
        if (window.scrollY > 100) {
            navbar.classList.add('nav-active');
        } else {
            navbar.classList.remove('nav-active');
        }
    };

    function openModal() {
      var modal = document.getElementById("myModal");
      modal.style.display = "block";
    }
    
    // Function to close the modal
    function closeModal() {
      var modal = document.getElementById("myModal");
      modal.style.display = "none";
    }
    
    // Function to handle TronLink connection
    function connectTronLink() {
      // Add your TronLink connection code here
      // ...
      alert("Connecting using TronLink");
      closeModal();
    }

</script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
    crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js"
    integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V"
    crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script type="text/javascript" src="https://unpkg.com/web3@1.2.11/dist/web3.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/web3modal@1.9.0/dist/index.js"></script>
    <script type="text/javascript" src="https://unpkg.com/evm-chains@0.2.0/dist/umd/index.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/@walletconnect/web3-provider@1.2.1/dist/umd/index.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/fortmatic@2.0.6/dist/fortmatic.js"></script>


    


    <!-- //cloudflaire cdn   -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/web3/4.0.3/web3.min.js" integrity="sha512-2oprd2T2vSkAii+dVWi6C+uATbQ1YGmCed6b6msb9Jxi33hsXAbnhwZ9thwCq6ndidZv4P51qaq58uo9b/x4nA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/web3@4.0.3/dist/web3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@luckyunicorn/web3modal@1.9.6/dist/index.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/evm-chains@0.2.0/dist/umd/index.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/walletconnect-web3-provider@0.7.28/dist/walletconnect-web3-provider.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fortmatic@2.4.0/dist/fortmatic.min.js"></script> -->

    
    <script type="text/javascript" src="main.js"></script>
<script>

    function connectWithTronlink(reff) {

        if (typeof window.tronWeb === 'undefined') {
            alert("Please install TronLink or another Tron wallet extension. Other wise Please use wallet connect.");
            return;
        }

        if (window.tronWeb && window.tronWeb.ready) {
            // Wallet is already connected, retrieve the address
         const address = window.tronWeb.defaultAddress.base58;
         
         console.log("tron address", address)
         fetch('backend.php', {
            method: 'POST',
            body: JSON.stringify({ address: address, reff: reff, login: 1 })
          })
          .then(response => response.json())
          .then(data => {        
            console.log(data);
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
            console.log("error",error)
          });

        } else {

            alert("No Tron Link Wallet Available. Please use Wallet connect.")

        }

    }
  </script>



</body>
</html>