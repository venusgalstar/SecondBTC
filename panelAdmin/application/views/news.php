<?php include "include/header.php"; ?>
<div class="main-content-inner">
    <div class="mt-5">
        <?php
        if(!empty($this->session->flashdata('hata'))){ 
            echo '<div class="alert alert-danger" id="hata" role="alert">'.$this->session->flashdata('hata').'</div>';} 
        elseif(!empty($this->session->flashdata('onay'))){
            echo '<div class="alert alert-success" id="hata" role="alert">'.$this->session->flashdata('onay').'</div>';} ?>
    </div>
    <table class="table table-striped" id="newsDataTable">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Date</th>
                <th scope="col">Title</th>
                <th scope="col">Detail</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($news as $news) { ?>
            <tr>
                <td>
                    <input type="hidden" value="<?php echo $news["news_image"]; ?>" id="img_<?php echo $news["news_id"]; ?>">
                    <input type="hidden" value="<?php echo $news["news_title"]; ?>" id="title_<?php echo $news["news_id"]; ?>">
                    <textarea class="d-none" id="detail_<?php echo $news["news_id"]; ?>"><?php echo $news["news_detail"]; ?></textarea>
                    <input type="hidden" value="<?php echo $news["news_status"]; ?>" id="status_<?php echo $news["news_id"]; ?>">
                </td>
                <td><span class="d-none"><?php echo $news["news_time"]; ?></span><?php echo date("Y-m-d H:i:s",$news["news_time"]); ?></td>
                <td><?php echo $news["news_title"]; ?></td>
                <td><?php echo kisaltKelime($news["news_detail"],30); ?></td>
                <td><?php if($news["news_status"]==1)echo "ON"; else echo "OFF"; ?></td>
                <td>
                    <i onclick="customJS.home.newsUpdate('<?php echo $news['news_id']; ?>')" class="fa fa-pencil-square-o text-info font-size-18" aria-hidden="true"></i> 
                    <i onclick="customJS.home.neswDelete('<?php echo $news['news_id']; ?>')" class="fa fa-trash-o text-danger font-size-18" aria-hidden="true"></i>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>    
<?php include "include/footer.php"; ?>
<div class="modal fade" id="newsUpdateModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">News Modal</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="mt-3 ml-5">
                <img id="news_imageGor" src="" width="100">
            </div>
            <div class="modal-body"> 
                <form action="<?php echo base_url(); ?>home/newsUpdate" method="POST" enctype="multipart/form-data"> 
                    <div class="input-group mb-5 ml-4 input-group-sm">
                        <input type="file" name="filename">
                    </div>News Title : 
                    <div class="input-group mb-2 input-group-sm">
                        <input type="text" class="form-control" name="news_title" id="news_title">
                        <input type="hidden" class="form-control" name="news_image" id="news_image" >
                        <input type="hidden" class="form-control" name="news_id" id="news_id" >
                    </div>News Detail : 
                    <div class="input-group mb-2 input-group-sm">
                        <textarea name="news_detail" class="form-control" rows="10" id="news_detail"></textarea>
                    </div>News Status :
                    <div class="input-group mb-2 input-group-sm">
                        <select class="form-control" name="news_status" id="news_status">
                            <option value="0">OFF</option>
                            <option value="1">ON</option>
                        </select>
                    </div>
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="addNews" class="btn btn-primary">Update</button>
                    </div> 
                </form>
            </div>
        </div>
    </div>
</div>