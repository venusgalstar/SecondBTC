<!DOCTYPE html>
<html lang="<?php if (!empty(get_cookie('dil'))) {
                echo get_cookie('dil');
            } else {
                echo siteSetting()["site_default_lang"];
            } ?>">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/home/img/favi.ico" />
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

    <?php
    if ($this->uri->segment(1) == "exchange") { ?>
        <title> How to Buy <?php echo $toWallet{
                                0}['wallet_name']; ?> with Cash or Credit Card |Zero Fee Cryptocurrency Exchange</title>
    <?php } else { ?>
        <title><?php echo siteSetting()["site_title"]; ?> | <?php echo siteSetting()["site_name"]; ?></title>
    <?php } ?>


    <script>
        var search = "<?php echo lang("search"); ?>";
    </script>
    <!-- Custom font -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/home'); ?>/vendors/bootstrap-4.5.0/css/bootstrap.min.css">
    <!-- Custom styling -->
    <?php
    if (site_url() == current_url()) {
    ?>
        <link rel="stylesheet" href="<?= base_url('assets/home'); ?>/css/landing.css?v=<?= time(); ?>">
    <?php
    } else {
    ?>
        <link rel="stylesheet" href="<?= base_url('assets/home'); ?>/css/dark-theme.css?v=<?= time(); ?>">
    <?php
    }
    ?>
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
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <a class="navbar-brand" href="<?= site_url(); ?>">
            <img id="navbar-logo" src="<?= base_url('assets/home') ?>/img/logo-light.svg" height="40" alt="second logo" loading="lazy">
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
                    <a class="nav-link" href="<?= site_url(); ?>">Trade</a>
                </li>
                <li class="nav-item mr-4">
                    <a class="nav-link" href="<?= site_url('market'); ?>">Markets</a>
                </li>
                <li class="nav-item mr-4">
                    <a class="nav-link" href="<?= site_url('wallet'); ?>">Wallet</a>
                </li>
                <li class="nav-item mr-4">
                    <a class="nav-link" href="<?php echo base_url(); ?>order" title="Order"><?php echo lang("order") ?></a>
                </li>
                <?php if (empty($_SESSION['user_data'][0]['user_email'])) { ?>
                    <li class="nav-item mr-4">
                        <a class="btn btn-outline-primary cursor-pointer" onclick="customJS.auth.loginWithMetamask('<?= base_url() ?>')" href="#">Connect Wallet</a>
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
                        <div class="dropdown-menu dropdown-menu-right border-0" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item font-size-12" href="<?= preg_replace('/@.*$/', '', 'https://etherscan.io/address/' . $_SESSION['user_data'][0]['user_email']) ?>" title="etherscan" target="etherscan"><i class="fab fa-ethereum"></i>&nbsp;Etherscan</a>
                            <a class="dropdown-item font-size-12" href="<?= preg_replace('/@.*$/', '', 'https://bscscan.com/address/' . $_SESSION['user_data'][0]['user_email']) ?>" title="bscscan" target="bscscan"><i class="fas fa-chart-line"></i>&nbsp;Bscscan</a>
                            <a class="dropdown-item font-size-12" href="<?php echo base_url(); ?>account" title="Account"><i class="far fa-user"></i> <?php echo lang("account") ?></a>
                            <a class="dropdown-item font-size-12" href="<?php echo base_url(); ?>account/logout" title="Logout"><i class="fas fa-sign-out-alt"></i> <?php echo lang("exit") ?></a>
                    </li>
                <?php } ?>

                <li class="nav-item ml-2">
                    <a class="btn btn-outline-secondary" href="#"><img id="icon-theme" src="<?= base_url('assets/home') ?>/img/light-theme.svg" height="20" onclick="toggleLight(this)"></a>
                </li>
            </ul>
        </div>
    </nav>