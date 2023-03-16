<?php include "include/header.php" ; ?>

<div class="container">
    <div class="row mt-5">
        <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 text-center mb-2">
        <h2><?php echo lang("support");?></h2>
        </div>
        <div class="col-12">
            <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3">
                <h3 class="font-size-15 ml-3"> <?php echo lang("warning12");?></h3>
            </div>
            <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3">
                <?php
                    if (!empty(validation_errors())) {
                             echo validation_errors('<div class="alert alert-danger" role="alert">', '</div>');
                    }elseif(!empty($this->session->flashdata('hata'))){ 
                        echo '<div class="alert alert-danger" id="hata" role="alert">'.$this->session->flashdata('hata').'</div>';} 
                    elseif(!empty($this->session->flashdata('onay'))){
                        echo '<div class="alert alert-success" id="hata" role="alert">'.$this->session->flashdata('onay').'</div>';} 
                ?>
                <form id="supportForm" action="<?php echo base_url(); ?>support" method="POST" enctype="multipart/form-data">
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="bg-light input-group-text border-right-0"><i class="fa fa-user"></i></span>
                            </div>
                            <input type="name" name="name" class="form-control border-left-0" placeholder="<?php echo lang("firsname");?>" value="<?php echo set_value('name');?>" required>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="bg-light input-group-text border-right-0"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" name="email" class="form-control border-left-0" placeholder="<?php echo lang("email");?>" value="<?php echo set_value('email');?>" required>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="bg-light input-group-text border-right-0"><i class="fa fa-pencil"></i></span>
                            </div>
                            <input type="subject" name="subject" class="form-control border-left-0" placeholder="<?php echo lang("subject");?>" value="<?php echo set_value('subject');?>" required>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="bg-light input-group-text border-right-0"><i class="fa fa-book"></i></span>
                            </div>
                            <textarea name="text" class="form-control border-left-0" rows="3"><?php echo set_value('text');?></textarea>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="filename">
                                <label class="custom-file-label"><?php echo lang("choosefile");?></label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 text-right mt-5">
                        <button class="btn btn-primary mb-5 btn-block g-recaptcha" data-sitekey="<?php  echo siteSetting()["google_recaptcha_key"]; ?>" data-callback='onSubmit' name="support" type="submit"><?php echo lang("send");?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    function onSubmit(token) {
    document.getElementById("supportForm").submit();
    }
</script>
<?php include "include/footer.php" ; ?>