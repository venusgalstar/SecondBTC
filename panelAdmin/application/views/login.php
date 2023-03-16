
<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Login - srtdash</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/customAdmin.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/themify-icons.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/default-css.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assetsAdmin/css/styles.css">
    <script src="<?php echo base_url(); ?>assetsAdmin/js//modernizr-2.8.3.min.js"></script>
    <script src="<?php echo base_url(); ?>assetsAdmin/js/jquery-3.4.1.js"></script>
</head>

<body>
    <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <!-- preloader area start -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- preloader area end -->
    <!-- login area start -->
    <div class="login-area login-s2">
        <div class="container">
            <div class="login-box ptb--100">
                <form action="login" method="POST">
                    <div class="login-form-head">
                        <h4>Sign In</h4>
                        <p><?php
                    if (!empty(validation_errors())) {
                             echo validation_errors('<div class="alert alert-danger" role="alert">', '</div>');
                    }elseif(!empty($this->session->flashdata('hata'))){ 
                        echo '<div class="alert alert-danger" id="hata" role="alert">'.$this->session->flashdata('hata').'</div>';} 
                    elseif(!empty($this->session->flashdata('onay'))){
                        echo '<div class="alert alert-success" id="hata" role="alert">'.$this->session->flashdata('onay').'</div>';} ?></p>
                    </div>
                    <div class="login-form-body">
                        <div class="form-gp">
                            <label class="font-size-13" for="exampleInputEmail1">Email address</label>
                            <input name="email" type="email" id="exampleInputEmail1">
                            <i class="ti-email"></i>
                        </div>
                        <div class="form-gp">
                            <label class="font-size-13" for="exampleInputPassword1">Password</label>
                            <input name="pass" type="password" id="exampleInputPassword1">
                            <i class="ti-lock"></i>
                        </div>
                        <div class="form-gp">
                            <label class="font-size-13" for="exampleInputCode1">Google Code</label>
                            <input name="google" type="number" id="exampleInputCode1">
                            <i class="ti-lock"></i>
                        </div>
                        <div class="row mb-4 rmber-area">
                            <div class="col-6">
                            </div>
                            <div class="col-6 text-right">
                                <a href="#">Forgot Password?</a>
                            </div>
                        </div>
                        <div class="submit-btn-area">
                            <button name="form_submit_login" value="send" type="submit">Submit <i class="ti-arrow-right"></i></button>
                        </div>
                        <div class="form-footer text-center mt-5">
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- login area end -->

    <script src="<?php echo base_url(); ?>assetsAdmin/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url(); ?>assetsAdmin/js/metisMenu.min.js"></script>
    <script src="<?php echo base_url(); ?>assetsAdmin/js/jquery.slimscroll.min.js"></script>
    <script src="<?php echo base_url(); ?>assetsAdmin/js/jquery.slicknav.min.js"></script>
    
    <!-- others plugins -->
    <script src="<?php echo base_url(); ?>assetsAdmin/js/scripts.js"></script>
</body>

</html>