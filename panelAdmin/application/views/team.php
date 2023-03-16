<?php include "include/header.php"; ?>
<div class="main-content-inner-2" >
<div class="mt-5">
        <?php
        if(!empty($this->session->flashdata('hata'))){ 
            echo '<div class="alert alert-danger" id="hata" role="alert">'.$this->session->flashdata('hata').'</div>';} 
        elseif(!empty($this->session->flashdata('onay'))){
            echo '<div class="alert alert-success" id="hata" role="alert">'.$this->session->flashdata('onay').'</div>';} ?>
    </div>
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Data Table Default</h4>
                    <div class="data-tables">
                        <table id="adminDataTable" class="text-center table table-responsive">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th class="d-none"></th>
<th>Action</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Linkedin</th>
                                    <th>Telegram</th>
                                    <th>Job</th>
                                    <th>List Order</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                    <?php foreach ($team as $team) {?>
                                <tr>
                                    <td class="d-none" id="image_<?php echo $team['team_id']; ?>"><?php echo  $team["team_image"]; ?></td>
                                    <td>
                                        <i onclick="customJS.home.teamUpdate('<?php echo $team['team_id']; ?>')" class="fa fa-pencil-square-o text-info font-size-18" aria-hidden="true"></i> 
                                        <i onclick="customJS.home.teamDelete('<?php echo $team['team_id']; ?>')" class="fa fa-trash-o text-danger font-size-18" aria-hidden="true"></i>
                                    </td>
																		<td id="name_<?php echo $team['team_id']; ?>"><?php echo  $team["team_name"]; ?></td>
                                    <td id="email_<?php echo $team['team_id']; ?>"><?php echo  $team["team_email"]; ?></td>
                                    <td id="linkedin_<?php echo $team['team_id']; ?>"><?php echo  $team["team_linkedin"]; ?></td>
                                    <td id="telegram_<?php echo $team['team_id']; ?>"><?php echo  $team["team_telegram"]; ?></td>
                                    <td id="jop_<?php echo $team['team_id']; ?>"><?php echo  $team["team_jop"]; ?></td>
                                    <td id="sira_<?php echo $team['team_id']; ?>"><?php echo  $team["team_sira"]; ?></td>
                                    
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>     
<div class="modal fade" id="teamUpdateModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Team Modal</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="mt-3 ml-5">
                <img id="team_imageGor" src="" width="200">
            </div>
            <div class="modal-body"> 
                <form action="<?php echo base_url(); ?>home/updateTeam" method="POST" enctype="multipart/form-data"> 
                    <div class="input-group mb-5 ml-4 input-group-sm">
                        <input type="file" name="filename">
                    </div>
                    Name : 
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" class="form-control" name="team_name" id="team_name">
                        <input type="hidden" class="form-control" name="team_image" id="team_image">
                        <input type="hidden" class="form-control" name="team_id" id="team_id" >
                    </div>
                    Email : 
                    <div class="input-group mb-2 input-group-sm">
                        <input name="team_email" class="form-control" rows="10" id="team_email">
                    </div>
                    Linkedin :
                    <div class="input-group mb-2 input-group-sm">
                        <input name="team_linkedin" class="form-control" rows="10" id="team_linkedin">
                    </div>
                    Telegram :
                    <div class="input-group mb-2 input-group-sm">
                        <input name="team_telegram" class="form-control" rows="10" id="team_telegram">
                    </div>
                    Job :
                    <div class="input-group mb-2 input-group-sm">
                        <input name="team_jop" class="form-control" rows="10" id="team_jop">
                    </div>
                    
                    <div class="input-group mb-2 input-group-sm">
                        <select class="form-control" name="team_sira" id="team_sira">
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
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="addTeam" class="btn btn-primary">Update</button>
                    </div> 
                </form>
            </div>
        </div>
    </div>
</div>
<?php include "include/footer.php"; ?>