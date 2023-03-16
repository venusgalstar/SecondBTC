<?php include "include/header.php"; ?>
<div class="main-content-inner mt-5">
<div class="mt-5">
        <?php
        if(!empty($this->session->flashdata('hata'))){ 
            echo '<div class="alert alert-danger" id="hata" role="alert">'.$this->session->flashdata('hata').'</div>';} 
        elseif(!empty($this->session->flashdata('onay'))){
            echo '<div class="alert alert-success" id="hata" role="alert">'.$this->session->flashdata('onay').'</div>';} ?>
    </div>
    <div class="row">
        <div class="col-12 col-xl-8 offset-xl-2" >
            <form action="<?php echo base_url(); ?>home/sendEmail" method="POST">
                <div class="form-group">
                    <label for="formGroupExampleInput2">Name</label>
                    <input type="text" class="form-control" name="email_name" id="email_name" placeholder="Name">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">Email</label>
                    <input type="email" class="form-control" name="email_email" id="email_email" placeholder="Email" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">Subject</label>
                    <input type="text" class="form-control" name="email_subject" id="email_subject" placeholder="Subject" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">Email Detail</label>
                    <textarea class="form-control" name="email_detail" id="" rows="6" required></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="sendMail">Send Mail</button>
                </div>
            </form>
        </div>
    </div>
</div>    
<?php include "include/footer.php"; ?>