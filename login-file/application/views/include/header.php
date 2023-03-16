<!DOCTYPE html>
<html lang="<?php if (!empty(get_cookie('dil'))) {
                echo get_cookie('dil');
            } else {
                echo siteSetting()["site_default_lang"];
            } ?>">

<head>

    <meta http-equiv="Content-Language" content="<?php if (!empty(get_cookie('dil'))) {
                                                        echo get_cookie('dil');
                                                    } else {
                                                        echo siteSetting()["site_default_lang"];
                                                    } ?>">
    <meta name="author" content="<?php echo siteSetting()["site_url"]; ?>" />
    <link rel="alternate" href="<?php echo base_url($_SERVER['REQUEST_URI']); ?>" hreflang="en-US" />
    <link rel="alternate" href="<?php echo base_url($_SERVER['REQUEST_URI']); ?>" hreflang="tr-TR" />
    <link rel="alternate" href="<?php echo base_url($_SERVER['REQUEST_URI']); ?>" hreflang="ru-RU" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="keywords" content="<?php echo siteSetting()["site_meta_etiket"]; ?>" />
    <meta name="description" content="Buy/Sell <?php echo $toWallet{
                                                    0}['wallet_name']; ?> with Cash or Credit Card |Zero Fee Cryptocurrency Exchange,Easily buy and sale <?php echo $toWallet{
                                                                                                                                                                0}['wallet_name']; ?> on Secondbtc cryptocurrency Exchange" />
    <link rel="canonical" href="<?php echo base_url($_SERVER['REQUEST_URI']); ?>" />
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/home/images/favicon.ico" />
    <meta name="robots" content="index, follow">

    <meta property="og:site_name" content="<?php echo siteSetting()["site_name"]; ?>" />
    <meta property="og:type" content="website">
    <meta property="og:locale" content="<?php if (!empty(get_cookie('dil'))) {
                                            echo get_cookie('dil') . "_" . strtoupper(get_cookie('dil'));
                                        } else {
                                            echo siteSetting()["site_default_lang"] . "_" . strtoupper(siteSetting()["site_default_lang"]);
                                        } ?>" />
    <meta property="og:url" content="<?php echo base_url($_SERVER['REQUEST_URI']); ?>" />
    <?php if ($this->uri->segment(1) == "exchange") { ?>
        <meta property="og:title" content="How to Buy <?php echo $toWallet{
                                                            0}['wallet_name']; ?> with Cash or Credit Card | <?php echo siteSetting()["site_name"]; ?> | Zero Fee Cryptocurrency Exchange" />
    <?php } else { ?>
        <meta property="og:title" content=" <?php echo siteSetting()["site_title"]; ?> | <?php echo siteSetting()["site_name"]; ?>" />
    <?php } ?>
    <meta property="og:description" content="Buy/Sell <?php echo $toWallet{
                                                            0}['wallet_name']; ?> with Cash or Credit Card |Zero Fee Cryptocurrency Exchange,Easily buy and sale <?php echo $toWallet{
                                                                                                                                                                        0}['wallet_name']; ?> on Secondbtc cryptocurrency Exchange" />
    <meta property="og:see_also" content="<?php echo siteSetting()["site_facebook"]; ?>" />
    <meta property="og:see_also" content="<?php echo siteSetting()["site_twitter"]; ?>" />
    <meta property="og:see_also" content="<?php echo siteSetting()["site_telegram"]; ?>" />
    <meta property="og:see_also" content="<?php echo siteSetting()["site_instagram"]; ?>" />

    <?php if ($this->uri->segment(1) == "exchange") { ?>
        <title> How to Buy <?php echo $toWallet{
                                0}['wallet_name']; ?> with Cash or Credit Card |Zero Fee Cryptocurrency Exchange</title>
    <?php } else { ?>
        <title><?php echo siteSetting()["site_title"]; ?> | <?php echo siteSetting()["site_name"]; ?></title>
    <?php } ?>


    <script>
        var search = "<?php echo lang("search"); ?>";
    </script>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/css/bootstrap.min.css" defer />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/css/newTheme.css?v=<?= rand(1000, 9999); ?>" defer />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/css/toast.css" defer />
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/css/custom.css?v=<?= rand(1000, 9999); ?>" defer />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/home/css/jquery.dataTables.min.css" defer />

    <script src="<?php echo base_url(); ?>assets/home/js/fontawesome_kit.js" defer></script>
    <script src="<?php echo base_url(); ?>assets/home/js/jquery-3.4.1.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/home/js/socket.io.js" defer></script>
    <script src="<?php echo base_url(); ?>assets/home/js/socket.js?v=<?= time(); ?>" defer></script>
    <script src="<?php echo base_url(); ?>assets/home/js/jquery.mask.min.js" defer></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>


    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo siteSetting()['google_analytics_key']; ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', '<?php echo siteSetting()["google_analytics_key"]; ?>');
    </script>
</head>

<body>
    <div id="preloader">
        <div class="row loader">
            <div class="loader-icon"> </div>
        </div>
    </div>
    <div class="main">
        <!-- Nav bar başlangıç -->
        <nav class="navbar bg-dark navbar-dark navbar-expand-md">
            <a class="navbar-brand" href="<?php echo base_url(); ?>"><img src="<?php echo base_url(); ?>assets/home/images/logo.png?v=5" width="200" height="50" alt="<?php echo siteSetting()["site_name"]; ?>" /></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">

                </ul>
                <ul class="navbar-nav">
                    <?php if (empty($_SESSION['user_data'][0]['user_email'])) { ?>
                        <li class="nav-item active text-right">
                            <a class="nav-link cursor-pointer" onclick="customJS.auth.connect('<?= base_url() ?>')" title="Login"><i class="fas fa-sign-in-alt"></i> <?php echo lang("login") ?></a>
                        </li>
                        <!-- <li class="nav-item text-right">
                    <a class="nav-link" href="<?php echo base_url(); ?>register" title="Register"><i class="fas fa-user-plus"></i> <?php echo lang("register") ?></a>
                </li> -->
                    <?php } ?>
                    <li class="nav-item text-right">
                        <a class="nav-link" href="<?php echo base_url(); ?>exchange/BTC-LTC" title="Exchange"><i class="fas fa-exchange-alt"></i> <?php echo lang("exchange") ?></a>
                    </li>
                    <li class="nav-item text-right">
                        <a class="nav-link" href="<?php echo base_url(); ?>market" title="Market"><i class="fas fa-bars"></i> <?php echo lang("market") ?></a>
                    </li>
                    <?php if (!empty($_SESSION['user_data'][0]['user_email'])) { ?>
                        <li class="nav-item text-right">
                            <a class="nav-link" href="<?php echo base_url(); ?>wallet" title="Wallet"><i class="fas fa-wallet"></i> <?php echo lang("wallet") ?></a>
                        </li>
                        <li class="nav-item text-right">
                            <a class="nav-link" href="<?php echo base_url(); ?>order" title="Order"><i class="fas fa-folder-open"></i> <?php echo lang("order") ?></a>
                        </li>
                        <li class="nav-item dropdown text-right">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php echo substr($_SESSION['user_data'][0]['user_email'], 0, 4) . ' ..... ' . substr($_SESSION['user_data'][0]['user_email'], -18, 4); ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right text-right border-0 bg-dark" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item text-light font-size-12" href="<?= preg_replace('/@.*$/','','https://etherscan.io/address/'.$_SESSION['user_data'][0]['user_email'])?>" title="etherscan" target="etherscan"><i class="fab fa-ethereum"></i>&nbsp;Etherscan</a>
                                <a class="dropdown-item text-light font-size-12" href="<?= preg_replace('/@.*$/','','https://bscscan.com/address/'.$_SESSION['user_data'][0]['user_email'])?>" title="bscscan" target="bscscan"><i class="fas fa-chart-line"></i>&nbsp;Bscscan</a>
                                <a class="dropdown-item text-light font-size-12" href="<?php echo base_url(); ?>account" title="Account"><i class="far fa-user"></i> <?php echo lang("account") ?></a>
                                <a class="dropdown-item text-light font-size-12" href="<?php echo base_url(); ?>account/logout" title="Logout"><i class="fas fa-sign-out-alt"></i> <?php echo lang("exit") ?></a>
                        </li>
                    <?php } ?>
                    <li class="nav-item dropdown text-right">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-globe-europe"></i> <?php echo lang("lang") ?>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right text-right border-0 bg-dark" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item text-light font-size-12" href="<?php echo base_url(); ?>home/dilsec/tr/<?php echo $this->uri->uri_string() ?>" title="Türkçe">Türkçe</a>
                            <a class="dropdown-item text-light font-size-12" href="<?php echo base_url(); ?>home/dilsec/en/<?php echo $this->uri->uri_string() ?>" title="English">English</a>
                            <a class="dropdown-item text-light font-size-12" href="<?php echo base_url(); ?>home/dilsec/ru/<?php echo $this->uri->uri_string() ?>" title="Pусский">Pусский</a>
                            <a class="dropdown-item text-light font-size-12" href="<?php echo base_url(); ?>home/dilsec/es/<?php echo $this->uri->uri_string() ?>" title="Español">Español</a>
                            <a class="dropdown-item text-light font-size-12" href="<?php echo base_url(); ?>home/dilsec/id/<?php echo $this->uri->uri_string() ?>" title="Indonesia">Indonesia</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div id="url" class="d-none"><?php echo base_url(); ?></div>
        <div id="soketID" class="d-none"><?php if (!empty($_SESSION['user_data'][0]['user_id'])) {
                                                echo $_SESSION['user_data'][0]['user_id'];
                                            } else {
                                                echo 0;
                                            } ?></div>
        <div id="hesap" class="d-none"><?php if (!empty($_SESSION['user_data'][0]['user_email'])) {
                                            echo $_SESSION['user_data'][0]['user_email'];
                                        } else {
                                            echo 0;
                                        } ?></div>
        <!-- Nav bar bitiş -->
