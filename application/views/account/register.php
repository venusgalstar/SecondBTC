<?php include __DIR__ ."/../include/header.php" ; ?>

<div class="container">
    <div class="row mt-5">
        <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 text-center mb-2 col-xl-5 offset-xl-3">
        <h2><?php echo lang('register');?></h2>
        </div>
        <div class="col-12">
            <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 col-xl-5 offset-xl-3">
            <h3 class="font-size-15 ml-3 text-center"> <?php echo lang('warning1');?></h3>
                <div class="border border-success logHeader text-center ml-5 mr-5 mb-3 font-size-15">
                    <span class="text-success"><i class="fa fa-lock font-size-13"></i> </span><?php echo siteSetting()["site_url"]; ?>
                </div>
            </div>
            <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 col-xl-5 offset-xl-3">
                <form id="newForm" action="#" method="POST" >
                <?php
                    if (!empty(validation_errors())) { ?>
                            <?php echo validation_errors('<div class="alert alert-danger" role="alert">', '</div>');?>
                    <?php }elseif(!empty($this->session->flashdata('hata'))){ ?>
                        <?php echo '<div class="alert alert-danger" id="hata" role="alert">'.$this->session->flashdata('hata').'</div>';}?>
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="bg-light input-group-text border-right-0" id="inputGroupPrepend3"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control border-left-0"  placeholder="<?php echo lang('email');?>" required>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="bg-light input-group-text border-right-0" id="inputGroupPrepend3"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" name="pass" class="form-control border-left-0" placeholder="<?php echo lang('pass');?>"  required>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="bg-light input-group-text border-right-0" id="inputGroupPrepend3"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" name="rpass" class="form-control border-left-0" placeholder="<?php echo lang('repass');?>" required>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="input-group">
                        <div class="custom-control custom-switch">
                            <input name="terms" type="checkbox" checked class="custom-control-input" id="switch1" disabled>
                            <label class="custom-control-label" for="switch1"><?php echo lang('okterms2');?> <?php echo siteSetting()["site_name"]; ?> <?php echo lang('okterms');?></label>
                        </div>
                        </div>
                    </div>
                    <div class="col-12 text-right mt-5">
                        <button class="btn btn-primary mb-4 btn-block g-recaptcha" data-sitekey="<?php  echo siteSetting()["google_recaptcha_key"]; ?>" data-callback='onSubmit' name="register" type="submit"><?php echo lang('register');?></button>
                    </div>
                    <div class="col-12 mb-5">
                        <div class="input-group text-center">
                        <label class="form-label font-size-14"><?php echo lang('alreadymember');?>  </label><a href="<?php echo base_url("login");?>"><label class="form-label ml-2 font-size-14"> <?php echo lang('login');?></label></a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function onSubmit(token) {
    document.getElementById("newForm").submit();
    }
</script>
<?php include __DIR__ ."/../include/footer.php" ; ?>