<!doctype html>
<html class="no-js" lang="en">
<?php

?>

<head>

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title><?php echo base_url(); ?> Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="/assets/home/images/favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/metisMenu.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/owl.carousel.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/slicknav.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/toast.css">
    <!-- amchart css -->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assetsAdmin/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assetsAdmin/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assetsAdmin/css/responsive.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assetsAdmin/css/responsive.jqueryui.min.css">
    <link href="<?php echo base_url(); ?>assetsAdmin/editor/summernote-bs4.css" rel="stylesheet">
    <!-- others css -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/typography.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/default-css.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/styles.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/responsive.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/customAdmin.css?v=12">

    <script src="<?php echo base_url(); ?>assetsAdmin/js//modernizr-2.8.3.min.js"></script>
    <script src="<?php echo base_url(); ?>assetsAdmin/js/jquery-3.4.1.js"></script>
    <script src="<?php echo base_url(); ?>assetsAdmin/js/socket.io.js"></script>
    <script src="<?php echo base_url(); ?>assetsAdmin/js/adminsockets.js?v=<?= time(); ?>"></script>
    <script src="<?php echo base_url(); ?>assetsAdmin/js/jquery.mask.min.js"></script>

</head>

<body>
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <div class="page-container">
        <div id="url" class="d-none"><?php echo base_url(); ?></div>
        <!-- sidebar menu area start -->
        <?php include "sidebar.php"; ?>
        <!-- sidebar menu area end -->
        <!-- main content area start -->
        <div class="main-content">
            <!-- header area start -->
            <div class="header-area">
                <p class="d-none" id="adminmail"><?php echo $_SESSION['user_data_admin'][0]['admin_email'] ?></p>
                <div class="row align-items-center">
                    <!-- nav and search button -->
                    <div class="col-md-6 col-sm-8 clearfix">
                        <div class="nav-btn pull-left">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <!-- profile info & task notification -->
                    <div class="col-md-6 col-sm-4 clearfix">
                        <ul class="notification-area pull-right">
                            <li id="metamaskControl" class="dropdown">
                              <a class="btn btn-outline-secondary btn-xs" onclick="customJS.auth.loginWithMetamask('<?= base_url() ?>')" title="Login">login with metamask</a>
<!-- <img id="icon" style="max-width: 60%;" alt="Ícono de extensión" title="Login with metamask" aria-label="Relacionada con MetaMask" src="data:image/png;base64,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"> -->
                            </li>
                            <li class="dropdown">
                                <i class="ti-user dropdown-toggle" data-toggle="dropdown">
                                    <span id="onlineUser">0</span>
                                </i>
                            </li>
                            <li class="dropdown">
                                <i class="ti-wallet dropdown-toggle" data-toggle="dropdown">
                                    <span id="pwithSayi1">0</span>
                                </i>
                                <div class="dropdown-menu bell-notify-box notify-box">
                                    <span class="notify-title">You have <span id="pwithSayi2"></span> new withdrawal <a href="<?php echo base_url(); ?>wallet/withdraw">view all</a></span>
                                    <div class="nofity-list" id="pendingWithdrawVeri">
                                    </div>
                                </div>
                            </li>
                            <li class="dropdown">
                                <i class="ti-bell dropdown-toggle" data-toggle="dropdown">
                                    <span id="psupSayi1">0</span>
                                </i>
                                <div class="dropdown-menu bell-notify-box notify-box">
                                    <span class="notify-title">You have <span id="psupSayi2"></span> new notifications <a href="<?php echo base_url(); ?>home/support">view all</a></span>
                                    <div class="nofity-list" id="supportVeri"></div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- header area end -->
            <!-- page title area start -->
            <div class="page-title-area">
                <div class="row align-items-center">
                    <div class="col-sm-6">
                        <div class="breadcrumbs-area clearfix">
                            <h4 class="page-title pull-left"></h4>
                            <ul class="breadcrumbs pull-left">
                                <li><a href="<?php echo base_url(); ?>">Home</a></li>
                                <?php if (!empty($this->uri->segment(1))) { ?>
                                    <li><span><a href="<?php echo base_url($this->uri->segment(1)); ?>"><?php echo $this->uri->segment(1); ?></a></span></li>
                                <?php }
                                if (!empty($this->uri->segment(2))) { ?>
                                    <li><span><a href="<?php echo base_url($this->uri->segment(1) . "/" . $this->uri->segment(2)); ?>"><?php echo $this->uri->segment(2); ?></a></span></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6 clearfix">
                        <div class="user-profile pull-right">
                        </div>
                    </div>
                </div>
            </div>
            <!-- page title area end -->
