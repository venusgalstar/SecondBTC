<?php include __DIR__ ."/../include/header.php" ; ?>
<?php if($this->session->userdata('user_email')){
    redirect('/account');
}?>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 text-center mb-2 col-xl-5 offset-xl-3">
        <h2><?php echo lang('loginconfcode');?></h2>
        </div>
        <div class="col-12">
            <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 col-xl-5 offset-xl-3">
            <h3 class="font-size-15 ml-3 text-center"> <?php echo lang('warning1');?></h3>
                <div class="border border-success logHeader text-center ml-5 mr-5 mb-3 font-size-15">
                    <span class="text-success"><i class="fa fa-lock font-size-13"></i> </span><?php echo siteSetting()["site_url"]; ?>
                </div>
            </div>
            <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 col-xl-5 offset-xl-3">
                <form action="<?php echo base_url(); ?>account/logincode" method="POST">
                <?php if(!empty($this->session->flashdata('hata'))){ ?>
                        <?php echo '<div id="hata" class="alert alert-danger" role="alert">'.$this->session->flashdata('hata').'</div>';}?>
                    <div class="col-12 mb-3">
                            <input type="number" autofocus="autofocus" class="form-control" name="code" id="validationTooltip01" placeholder="<?php echo $this->session->userdata('girissecenegi'); ?>" required>
                            <div class="ml-5 valid-tooltip">
                                Looks good!
                            </div>
                    </div>
                    <div class="col-12 text-right mt-5">
                        <button name="buttonCode" value="code" class="btn btn-primary mb-5 btn-block" type="submit"><?php echo lang('login');?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ ."/../include/footer.php" ; ?>

