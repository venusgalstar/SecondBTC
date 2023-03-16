<?php include "include/header.php"; ?>
<div class="main-content-inner mt-5">
    <div class="row">
        <div class="col-12 col-xl-8 offset-xl-2" >
            <form action="<?php echo base_url(); ?>home/newsAdd" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="file" name="filename">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">News Title</label>
                    <input type="text" class="form-control" name="news_title" id="news_title" placeholder="Title">
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2">News Detail</label>
                    <textarea class="form-control" name="news_detail" id=""></textarea>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" name="addNews">Add News</button>
                </div>
            </form>
        </div>
    </div>
</div>    
<?php include "include/footer.php"; ?>