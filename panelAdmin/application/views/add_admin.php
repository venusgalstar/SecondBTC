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
        <div class="col-12 col-xl-6 offset-xl-3" >
            <form action="<?php echo base_url(); ?>admin/addAdmin" method="POST">
                <div class="form-group">
                    <label for="formGroupExampleInput2">Google Code</label>
                    <input type="text" class="form-control" name="googleCode" id="googleCode" placeholder="Google Code" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">Admin Email</label>
                    <input type="email" class="form-control" name="admin_email" id="admin_email" placeholder="email" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">Admin Yetki</label>
                    <select name="admin_yetki" id="admin_yetki">
                        <option value="1">1</option>
                    </select>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="addAdmin">Add Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>    
<?php include "include/footer.php"; ?>