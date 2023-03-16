<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta http-equiv="Content-Language" content="en">
    <meta name="author" content="https://bitmaa.com" />
    <link rel="alternate" href="https://bitmaa.com/market" hreflang="en-US" />
    <link rel="alternate" href="https://bitmaa.com/market" hreflang="tr-TR" />
    <link rel="alternate" href="https://bitmaa.com/market" hreflang="ru-RU" />
    <meta name="viewport" content="width=device-width, initial-scamle=1, shrink-to-fit=no" />
    <meta name="keywords" content="Buy Bitcoin , Buy Ethereum, Buy Litecoin , Exchange,DEX+CEX Crypto currency Exchange" />
    <meta name="description" content="Buy/Sell  TRADE memecoin in 1 place |Zero Fee Cryptocurrency Exchange,Easily buy and sale  on BITMAA cryptocurrency Exchange" />
    <link rel="canonical" href="https://bitmaa.com/market" />
    <link rel="icon" type="image/x-icon" href="https://bitmaa.com/assets/home/img/favi.ico" />
    <meta name="robots" content="index, follow">

    <meta property="og:site_name" content="BITMAA" />
    <meta property="og:type" content="website">
    <meta property="og:locale" content="en_EN" />
    <meta property="og:url" content="https://bitmaa.com/market" />
            <meta property="og:title" content=" Buy Trade Bitcoin & Cryptocurrency in India | BITMAA" />
        <meta property="og:description" content="Buy/Sell  with Cash or Credit Card |Zero Fee Cryptocurrency Exchange,Easily buy and sale  on Bitmaa cryptocurrency Exchange" />
    <meta property="og:see_also" content="https://www.facebook.com/" />
    <meta property="og:see_also" content="https://twitter.com/bitmaac" />
    <meta property="og:see_also" content="#" />
    <meta property="og:see_also" content="#" />

            <title>Buy Trade Bitcoin & Cryptocurrency in India | BITMAA.COM | BITMAA</title>
    

    <script>
        var search = "Search";
    </script>
    <!-- Custom font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://bitmaa.com/assets/home/vendors/bootstrap-4.5.0/css/bootstrap.min.css">
    <!-- Custom styling -->
            <link id="theme" rel="stylesheet" href="https://bitmaa.com/assets/home/css/dark-theme.css?v=1633583439">
        <link rel="stylesheet" href="https://bitmaa.com/assets/home/css/toast.css" defer />
    <script src="https://bitmaa.com/assets/home/js/fontawesome_kit.js" defer></script>
    <script src="https://bitmaa.com/assets/home/js/jquery-3.4.1.min.js"></script>
    <script src="https://bitmaa.com/assets/home/js/socket.io.js" defer></script>
    <script src="/assets/home/js/socket.js?v=<?= time(); ?>" defer></script>
    <script src="https://bitmaa.com/assets/home/js/jquery.mask.min.js" defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    
    
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <a class="navbar-brand" href="https://bitmaa.com/">
            <img id="navbar-logo" src="https://bitmaa.com/assets/home/img/logo-light.svg" height="40" alt="bitmaa logo" loading="lazy">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                    <defs>
                        <style>
                            .fa-secondary {
                                opacity: .4
                            }
                        </style>
                    </defs>
                    <path d="M400 32H48A48 48 0 0 0 0 80v352a48 48 0 0 0 48 48h352a48 48 0 0 0 48-48V80a48 48 0 0 0-48-48zm-51.37 182.31L232.06 348.16a10.38 10.38 0 0 1-16.12 0L99.37 214.31C92.17 206 97.28 192 107.43 192h233.14c10.15 0 15.26 14 8.06 22.31z" class="fa-secondary" />
                    <path d="M348.63 214.31L232.06 348.16a10.38 10.38 0 0 1-16.12 0L99.37 214.31C92.17 206 97.28 192 107.43 192h233.14c10.15 0 15.26 14 8.06 22.31z" class="fa-primary" />
                </svg>
            </span>
        </button>
        <div class="collapse navbar-collapse justify-content-between align-items-center w-100" id="navbarNav">
            <ul class="navbar-nav mx-auto text-center"></ul>
            <ul class="navbar-nav">
                <li class="nav-item mr-4">
                    <a class="nav-link" href="https://bitmaa.com/market">Market</a>
                </li>
                <li class="nav-item mr-4">
                    <a class="nav-link" href="https://bitmaa.com/wallet">Wallet</a>
                </li>
                <li class="nav-item mr-4">
                    <a class="nav-link" href="https://bitmaa.com/order" title="Order">Order</a>
                </li>
                <?php if (empty($_SESSION['user_data'][0]['user_email'])) { ?>
                
              
                    <li class="nav-item mr-4">
                        <a id="walletconnectbtn1" class="btn btn-outline-primary cursor-pointer" onclick="customJS.auth.connect('<?= base_url() ?>')" href="#">Connect Wallet</a>
                        <!-- <button  style="border: 5px solid red">Wallet Connect</button> -->
                       
                    </li> 
                    <!-- <li class="nav-item text-right">
                    <a class="nav-link" href="<?php echo base_url(); ?>register" title="Register"><i class="fas fa-user-plus"></i> <?php echo lang("register") ?></a>
                </li> -->
                <?php } else { ?>
                    <!-- <li class="nav-item mr-4">
                        <a class="nav-link" href="<?php echo base_url(); ?>wallet" title="Wallet"><i class="fas fa-wallet"></i> <?php echo lang("wallet") ?></a>
                    </li> -->
                    <!-- <li class="nav-item mr-4">
                        <a class="nav-link" href="<?php echo base_url(); ?>order" title="Order"><?php echo lang("order") ?></a>
                    </li> -->
                    <li class="nav-item dropdown mr-4">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php echo substr($_SESSION['user_data'][0]['user_email'], 0, 4) . ' ..... ' . substr($_SESSION['user_data'][0]['user_email'], -18, 4); ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right border-0 bg-dark" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-light font-size-12" href="<?= preg_replace('/@.*$/', '', 'https://etherscan.io/address/' . $_SESSION['user_data'][0]['user_email']) ?>" title="etherscan" target="etherscan"><i class="fab fa-ethereum"></i>&nbsp;Etherscan</a>
                            <a class="dropdown-item text-light font-size-12" href="<?= preg_replace('/@.*$/', '', 'https://bscscan.com/address/' . $_SESSION['user_data'][0]['user_email']) ?>" title="bscscan" target="bscscan"><i class="fas fa-chart-line"></i>&nbsp;Bscscan</a>
                            <a class="dropdown-item text-light font-size-12" href="<?php echo base_url(); ?>account" title="Account"><i class="far fa-user"></i> <?php echo lang("account") ?></a>
                            <!-- <a class="dropdown-item text-light font-size-12" href="<?php echo base_url(); ?>account/logout" title="Logout"><i class="fas fa-sign-out-alt"></i> <?php echo lang("exit") ?></a> -->

                            <a class="dropdown-item text-light font-size-12" href="#"
                                onclick="customJS.auth.disconnect()"
                             title="Logout"><i class="fas fa-sign-out-alt"></i> <?php echo lang("exit") ?></a>

                    </li>
                <?php } ?>
                                
              
                    <!--<li class="nav-item mr-4">-->
                    <!--    <a class="btn btn-outline-primary cursor-pointer" onclick="customJS.auth.connect('https://BITMAA.com/')" href="#">Connect Wallet</a>-->
                       
                    <!--</li> -->
                    <!-- <li class="nav-item text-right">
                    <a class="nav-link" href="https://BITMAA.com/register" title="Register"><i class="fas fa-user-plus"></i> Register</a>
                </li> -->
                                <li class="nav-item dropdown mr-4">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-globe-europe"></i> Language                    </a>
                    <div class="dropdown-menu dropdown-menu-right border-0 bg-dark" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item text-light font-size-12" href="https://bitmaa.com/home/dilsec/tr/market" title="Türkçe">Türkçe</a>
                        <a class="dropdown-item text-light font-size-12" href="https://bitmaa.com/home/dilsec/en/market" title="English">English</a>
                        <a class="dropdown-item text-light font-size-12" href="https://bitmaa.com/home/dilsec/ru/market" title="Pусский">Pуссий</a>
                        <a class="dropdown-item text-light font-size-12" href="https://bitmaa.com/home/dilsec/es/market" title="Español">Espaol</a>
                        <a class="dropdown-item text-light font-size-12" href="https://bitmaa.com/home/dilsec/id/market" title="Indonesia">Indonesia</a>
                </li>
                <li class="nav-item ml-2">
                    <a class="btn btn-outline-secondary" href="#"><img id="icon-theme" src="https://bitmaa.com/assets/home/img/light-theme.svg" height="20" onclick="toggleLight(this)"></a>
                </li>
            </ul>
        </div>
    </nav>
    <div id="url" class="d-none">https://bitmaa.com/</div>
    <div id="soketID" class="d-none">0</div>
    <div id="hesap" class="d-none">0</div>
<style>
    .jumbotron {
        background-color: transparent;
        background-image: url('/assets/home/img/landing-img.svg');
        background-position: right;
        background-repeat: no-repeat;
        background-size: contain;
    }

    .jumbotron h1 {
        font-size: 50px;
    }

    .dark-theme .jumbotron h1 {
        font-weight: 700 !important;
        color: #FEFEFF;
    }

    .light-theme .jumbotron h1 {
        color: #444;
    }

    .jumbotron p {
        color: #FEFEFF;
    }

    .light-theme .jumbotron p {
        color: #444;
    }

    @media (max-width: 768px) {
        .markets-wrapper {
            flex-wrap: wrap !important;
        }

        .card {
            margin-right: 0;
            margin-bottom: 2rem;
            width: 100%;
        }

        .jumbotron h1 {
            font-size: 46px;
        }
    }
</style>
<div class="jumbotron jumbotron-fluid h-100 d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="display-4 mb-5">A trusted, secure and semi-fully decentralized crypto exchange</h1>
                <p class="lead mb-5">No email, no password.
                    Login with MetaMask and start trading.
                    Simple as that!</p>
                <a href="trade.php" class="btn btn-lg btn-gradient">Start Trading</a>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <section>
        <h1>Markets</h1>
        <div class="markets-wrapper d-flex justify-content-between flex-nowrap">
            <?php foreach ($marketUst as $marketAna) {?>
                <div class="card market">                    
                    <div class="card-body d-flex flex-row">
                        <div class="d-flex flex-column mr-4">
                            <h5 class="card-title"><?php echo $marketAna["to_wallet_name"]; ?>/<?php echo $marketAna["from_wallet_short"]; ?></h5>
                            <p class="market-price" style="font-size:12px"><?php echo Number($marketAna["to_wallet_last_price"],8); ?> <?php echo $marketAna["from_wallet_short"]; ?></p>
                            <p class="market-price"><?php echo Number($marketAna["to_wallet_24h_vol"],4); ?> <?php echo $marketAna["from_wallet_short"]; ?></p>
                            <p class="market-change"><span class="text-danger mr-2"></span></p>
                        </div>
                        <div class="d-flex flex-row align-items-start">
                            <img class="img-market" src="https://bitmaa.com/assets/home/images/logo/<?php echo walletHelper($marketAna["from_wallet_short"])["wallet_logo"]; ?>" width="40" height="40">
                            <img class="img-market" src="https://bitmaa.com/assets/home/images/logo/<?php echo walletHelper($marketAna["to_wallet_short"])["wallet_logo"]; ?>" width="40" height="40" alt="<?php echo $marketAna["to_wallet_name"]; ?>" title="<?php echo $marketAna["to_wallet_name"]; ?>">
                        </div>
                    </div>
                </div>
                
            <?php } ?>
            
                <!--<div class="card market">
                    <div class="card-body d-flex flex-row">
                        <div class="d-flex flex-column mr-4">
                            <h5 class="card-title">Chainlink/ETH</h5>
                            <p class="market-price">0.01 ETH</p>
                            <p class="market-change"><span class="text-danger mr-2"> -3.51%</span></p>
                        </div>
                        <div class="d-flex flex-row align-items-start">
                            <img class="img-market" src="https://bitmaa.com/assets/home/img/eth.png">
                            <img class="img-market" src="https://bitmaa.com/assets/home/images/logo/chain.png" width="47" height="47" alt="Chainlink" title="Chainlink">
                        </div>
                    </div>
                </div>
                <div class="card market">
                    <div class="card-body d-flex flex-row">
                        <div class="d-flex flex-column mr-4">
                            <h5 class="card-title">Power Ledger/ETH</h5>
                            <p class="market-price">0.01 ETH</p>
                            <p class="market-change"><span class="text-danger mr-2"> -4.60%</span></p>
                        </div>
                        <div class="d-flex flex-row align-items-start">
                            <img class="img-market" src="https://bitmaa.com/assets/home/img/eth.png">
                            <img class="img-market" src="https://bitmaa.com/assets/home/images/logo/25122019_151746_logo.png" width="47" height="47" alt="Power Ledger" title="Power Ledger">
                        </div>
                    </div>
                </div>
                <div class="card market">
                    <div class="card-body d-flex flex-row">
                        <div class="d-flex flex-column mr-4">
                            <h5 class="card-title">Unibright/ETH</h5>
                            <p class="market-price">0.01 ETH</p>
                            <p class="market-change"><span class="text-danger mr-2"> -1.88%</span></p>
                        </div>
                        <div class="d-flex flex-row align-items-start">
                            <img class="img-market" src="https://bitmaa.com/assets/home/img/eth.png">
                            <img class="img-market" src="https://bitmaa.com/assets/home/images/logo/11052020_180648_logo.png" width="47" height="47" alt="Unibright" title="Unibright">
                        </div>
                    </div>
                </div> -->
            </div>
    </section>
    <div class="my-5"></div>
    <div class="row">
        <div class="col-12">
            <div class="col-12">
                <ul class="nav nav-pills mb-3" id="myTab" role="tablist">
                            <!-- <li class="nav-item">
                                <a class="d-none" id="active">2</a>
                                <a class="nav-link active" onclick="myFunction('2')" data-toggle="tab" href="#ETH" role="tab" aria-controls="ETH" aria-selected="true">ETH</a>
                            </li> -->
                                                <li class="nav-item">
                                <a class="d-none" id="active">3</a>
                                <a class="nav-link active" onclick="myFunction('3')" id="" data-toggle="tab" href="#USDT" role="tab" aria-controls="USDT" aria-selected="true">USDT</a>
                            </li>
                            <!-- <li class="nav-item">
                                <a class="d-none" id="">61</a>
                                <a class="nav-link " onclick="myFunction('61')" data-toggle="tab" href="#BNB" role="tab" aria-controls="BNB" aria-selected="true">BNB</a>
                            </li> -->
                                    </ul>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="USDT" role="tabpanel" aria-labelledby="USDT-tab">
                    <div class="col-12 table-responsive">
                        <table class="table table-dark table-hover table-sm marketTable table-responsive" id="market-page" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-left" scope="col">Market</th>
                                    <th class="text-left" scope="col">Currency</th>
                                    <th class="text-right" scope="col">Last Price</th>
                                    <th class="text-right" scope="col">Change</th>
                                    <th class="text-right" scope="col">Volume</th>
                                    <th class="text-right" scope="col">24h High</th>
                                    <th class="text-right" scope="col">24h Low</th>
                                    <th class="text-right" scope="col">Trade</th>
                                </tr>
                            </thead>
                            <tbody id="market"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    footer{
        background: #444;
        padding-top: 40px;
    }
    
    footer .flogo{
        margin-top: 60px;
    }
    
    footer a{
        color: #888;
    }
    footer a:hover{
        color: #fff;
        text-decoration: none;
    }
    footer h4{
        font-size: 16px;
        color: #666;
    }
    
    footer ul{
        list-style: none;
        margin: 0 0 20px 0;
        padding: 0;
    }
    
    footer ul li{
        margin-bottom: 2px;
    }
    
    footer ul li a{
        display: block;
        padding: 3px 0;
    }
    
    .copyright{
        background: #222;
        color: #fff;
        padding: 5px 0;
        font-size: 12px;
        text-align: center;
    }
</style>
<footer>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2">
                <div class="flogo">
                    <img src="https://bitmaa.com/assets/home/img/logo-light.svg" class="img-fluid" />
                </div>
            </div>
            <div class="col-sm-3">
                <h4>Support</h4>
                <ul>
                    <li><a href="https://twitter.com/bitmaac?lang=en">Twitter</a></li>
                    <li><a href="https://t.me/bitmaac">Bitmaa</a></li>
                    
                  
                </ul>
            </div>
            <div class="col-sm-3">
                <h4>Social</h4>
                <ul>
                    <li><a href="https://twitter.com/bitmaac?lang=en">Twitter</a></li>
                    <li><a href="https://coinmarketcap.com/exchanges/bitmaa/">CMC</a></li>
                    <li><a href="https://www.coingecko.com/en/exchanges/bitmaa">Coingecko</a></li>
                    
                </ul>
            </div>
            <div class="col-sm-2">
                <h4>Email</h4>
                <ul>
                    <li><a href="#">reply[@]bitmaa.com</a></li>
                </ul>
            </div>
            <div class="col-sm-2">
                <h4>Contact us</h4>
                <ul>
                <li><a href="https://twitter.com/bitmaac?lang=en">Twitter</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="copyright">Copyright 2023. All rights reserved.</div>
</footer>

<script type="text/javascript">
    var SITE_BASEURL = '<?php echo base_url(); ?>';
</script>

<script src="https://bitmaa.com/assets/home/vendors/bootstrap-4.5.0/js/jquery-3.5.1.min.js"></script>
<script src="https://bitmaa.com/assets/home/vendors/bootstrap-4.5.0/js/popper.min.js"></script>
<script src="https://bitmaa.com/assets/home/vendors/bootstrap-4.5.0/js/bootstrap.min.js"></script>
<script src="https://bitmaa.com/assets/home/js/jquery.dataTables.min.js"></script>
<script src="https://bitmaa.com/assets/home/js/dataTables.bootstrap4.min.js"></script>
<script src="https://bitmaa.com/assets/home/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/web3@1.2.11/dist/web3.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/web3modal@1.9.0/dist/index.js"></script>
    <script type="text/javascript" src="https://unpkg.com/evm-chains@0.2.0/dist/umd/index.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/@walletconnect/web3-provider@1.2.1/dist/umd/index.min.js"></script>
    <script type="text/javascript" src="https://unpkg.com/fortmatic@2.0.6/dist/fortmatic.js"></script>
<script src="/assets/home/js/custom.js?v=<?php echo time(); ?>"></script>
<script src="https://bitmaa.com/assets/home/js/main.js?v=10"></script>
<script src="https://bitmaa.com/assets/home/js/toast.js?v=1"></script>
<script src="https://bitmaa.com/assets/home/js/toggleTheme.js?v=1633583439"></script>

<script src="/assets/home/js/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="/assets/home/css/sweetalert2.min.css">



</body>

</html>

