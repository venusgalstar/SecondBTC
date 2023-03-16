<?php include __DIR__ ."/../include/header.php" ; ?>

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
                <form action="#" method="POST">
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
                                <span class="bg-light input-group-text border-right-0" id="inputGroupPrepend3"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" name="pass" class="form-control border-left-0" placeholder="<?php echo lang('pass');?>" required>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="bg-light input-group-text border-right-0" id="inputGroupPrepend3"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" name="rpass" class="form-control border-left-0"  placeholder="<?php echo lang('repass');?>" required>
                            <input type="hidden" name="token" class="form-control border-left-0" value="<?php echo $this->input->get('token');?>">
                        </div>
                    </div>
                    <div class="col-12 text-right mt-5">
                        <button name="passupdate" value="passupdate" class="btn btn-primary mb-5 btn-block" type="submit"><?php echo lang('passupdate');?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ ."/../include/footer.php" ; ?>