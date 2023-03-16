<?php include "include/header.php" ; ?>
<?php ?>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-8 offset-md-2 col-sm-12 col-lg-5 offset-lg-3 text-center mb-2">
        <h2></h2>
        </div>
        <div class="col-12">
            <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3">
                <h3 class="font-size-15 ml-3"> </h3>
            </div>
            <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3">
                <form>
                    <?php
                    if (!empty(validation_errors())) {
                             echo validation_errors('<div class="alert alert-danger" role="alert">', '</div>');
                    }elseif(!empty($this->session->flashdata('hata'))){ 
                        echo '<div class="alert alert-danger" id="hata" role="alert">'.$this->session->flashdata('hata').'</div>';} 
                    elseif(!empty($this->session->flashdata('onay'))){
                        echo '<div class="alert alert-success font-size-17" id="hata" role="alert">'.$this->session->flashdata('onay').'</div>';} ?>
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "include/footer.php" ; ?>
