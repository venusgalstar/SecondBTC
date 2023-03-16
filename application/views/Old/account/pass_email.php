<?php include __DIR__ ."/../include/header.php" ; ?>
<?php if($this->session->userdata('user_email')){
    redirect('/account');
}?>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 text-center mb-2 col-xl-5 offset-xl-3">
        <h2><?php echo lang('passupdate');?></h2>
        </div>
        <div class="col-12">
            <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 col-xl-5 offset-xl-3">
            <h3 class="font-size-15 ml-3 text-center"> <?php echo lang('warning1');?></h3>
                <div class="border border-success logHeader text-center ml-5 mr-5 mb-3 font-size-15">
                    <span class="text-success"><i class="fa fa-lock font-size-13"></i> </span><?php echo siteSetting()["site_url"]; ?>
                </div>
            </div>
            <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 col-xl-5 offset-xl-3">
                <form id="newForm" action="#" method="POST">
                <?php
                    if (!empty(validation_errors())) {
                             echo validation_errors('<div class="alert alert-danger" role="alert">', '</div>');
                    }elseif(!empty($this->session->flashdata('hata'))){ 
                        echo '<div class="alert alert-danger" id="hata" role="alert">'.$this->session->flashdata('hata').'</div>';} 
                    elseif(!empty($this->session->flashdata('onay'))){
                        echo '<div class="alert alert-success" id="hata" role="alert">'.$this->session->flashdata('onay').'</div>';} ?>
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="bg-light input-group-text border-right-0" id="inputGroupPrepend3"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control border-left-0"  placeholder="<?php echo lang('email');?>" required>
                        </div>
                    </div>
                    <div class="col-12 text-right mt-5">
                        <button name="passemail" class="btn btn-primary mb-5 btn-block g-recaptcha" data-sitekey="<?php  echo siteSetting()["google_recaptcha_key"]; ?>" data-callback='onSubmit' type="submit"><?php echo lang('sendemail');?></button>
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