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
            <form action="<?php echo base_url(); ?>home/addTeam" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="formGroupExampleInput2">Name</label>
                    <input type="text" class="form-control" name="team_name" id="team_name" placeholder="Member's Name" required>
                </div>
                <div class="form-group">
                    <label for="team_email">Email</label>
                    <input type="email" class="form-control" name="team_email" id="team_email" placeholder="Member's Email" required>
                </div>
                <div class="form-group">
                    <label for="team_linkedin">Linkedin</label>
                    <input type="text" class="form-control" name="team_linkedin" id="team_linkedin" placeholder="Member's Linkedin" required>
                </div>
                <div class="form-group">
                    <label for="team_telegram">Telegram</label>
                    <input type="text" class="form-control" name="team_telegram" id="team_telegram" placeholder="Member's Telegram" required>
                </div>
                <div class="form-group">
                    <label for="team_jop">Job</label>
                    <input type="text" class="form-control" name="team_jop" id="team_jop" placeholder="Member's Job" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">List Order</label>
                    <select name="team_sira" id="team_sira">
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="file" name="filename">
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="addTeam">Add Team</button>
                </div>
            </form>
        </div>
    </div>
</div>    
<?php include "include/footer.php"; ?>