<?php include "include/header.php"; ?>
<div class="main-content-inner">
    <div class="mt-5">
        <?php
        if(!empty($this->session->flashdata('hata'))){ 
            echo '<div class="alert alert-danger" id="hata" role="alert">'.$this->session->flashdata('hata').'</div>';} 
        elseif(!empty($this->session->flashdata('onay'))){
            echo '<div class="alert alert-success" id="hata" role="alert">'.$this->session->flashdata('onay').'</div>';} ?>
    </div>
    <table class="table table-striped" id="supportDataTable">
    <thead>
        <tr>
            <th scope="col" style="width: 1px">Detail</th>
            <th scope="col">Date</th>
            <th scope="col">User Name</th>
            <th scope="col">User Email</th>
            <th scope="col">Subject</th>
            <th scope="col">Detail</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($support as $support) { ?>
        <tr>
            <td>
                <input type="hidden" value="<?php echo $support["sup_file"]; ?>" id="img_<?php echo $support["sup_id"]; ?>">
                <input type="hidden" value="<?php echo $support["sup_name"]; ?>" id="name_<?php echo $support["sup_id"]; ?>">
                <input type="hidden" value="<?php echo $support["sup_email"]; ?>" id="email_<?php echo $support["sup_id"]; ?>">
                <input type="hidden" value="<?php echo $support["sup_subject"]; ?>" id="subject_<?php echo $support["sup_id"]; ?>">
                <textarea class="d-none" id="reply_<?php echo $support["sup_id"]; ?>"><?php echo @$support["sup_reply"]; ?></textarea>
                <textarea class="d-none" id="text_<?php echo $support["sup_id"]; ?>"><?php echo $support["sup_text"]; ?></textarea>
                <input type="hidden" value="<?php echo $support["sup_status"]; ?>" id="status_<?php echo $support["sup_id"]; ?>">
            </td>
            <td><span class="d-none"><?php echo $support["sup_time"]; ?></span><?php echo date("Y-m-d H:i:s",$support["sup_time"]); ?></td>
            <td><?php echo $support["sup_name"]; ?></td>
            <td><?php echo $support["sup_email"]; ?></td>
            <td><?php echo $support["sup_subject"]; ?></td>
            <td><?php echo kisaltKelime($support["sup_text"],30); ?></td>
            <td><span class="d-none"><?php echo $support["sup_status"];?></span><?php if($support["sup_status"]==1)echo "ON"; else echo "OFF"; ?></td>
            <td>
                <i onclick="customJS.home.supportUpdate('<?php echo $support['sup_id']; ?>')" class="fa fa-pencil-square-o text-info font-size-18" aria-hidden="true"></i> 
            </td>
        </tr>
        <?php } ?>
    </tbody>
    </table>
</div>    
<?php include "include/footer.php"; ?>
<div class="modal fade" id="supportUpdateModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Support Modal</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="mt-3 ml-5">
                <a href="#" class="buyukResim"><img id="support_imageGor" src="" width="30%"></a>
            </div>
            <div class="modal-body"> 
                <form action="<?php echo base_url(); ?>home/supportUpdate" method="POST" enctype="multipart/form-data"> 
                    <b>User Name :</b>
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" class="form-control" name="sup_name" id="sup_name">
                        <input type="hidden" class="form-control" name="sup_file" id="sup_file" >
                        <input type="hidden" class="form-control" name="sup_id" id="sup_id" >
                    </div>
                    <b>User Email :</b>
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" class="form-control" name="sup_email" id="sup_email">
                    </div>
                    <b>Subject : </b>
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" class="form-control" name="sup_subject" id="sup_subject">
                    </div>
                    <b>Status : </b>
                    <div class="input-group mb-2 input-group-sm">
                        <select onchange="customJS.home.supportStatusUpdate(this.value)" class="form-control" name="sup_status" id="sup_status">
                            <option value="1">ON</option>
                            <option value="0">OFF</option>
                        </select>
                    </div>
                    <b>Support Detail : </b>
                    <div><textarea readonly="readonly" class="form-control" rows="6" name="sup_text" id="sup_text" ></textarea></div>
                    <b>Reply : </b>
                    <div class="input-group mb-2 input-group-sm">
                        <textarea name="sup_reply" id="sup_reply" class="form-control" rows="6" ></textarea>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="updateSupport" class="btn btn-primary">Send</button>
                    </div> 
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="resimModal" >
    <div class="modal-dialog modal-lg" style="max-width: max-content;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body"> 
                <img id="imageBuyukGor" src="" width="100%">
            </div>
        </div>
    </div>
</div>