<?php include "include/header.php" ; ?>
<style>

</style>
<div class="container">
    <div class="row mt-5">
        <div class="col-12 text-center mb-2">
        <h2><?php echo $newsDetail{0}["news_title"];?></h2>
        </div>
        <div class="col-12">
            <div class="col-12">
                <?php echo $newsDetail{0}["news_detail"]; ?>
            </div>
            <div class="col-12 text-right pr-5">
                <?php echo date("Y-m-d H:i:s",$newsDetail{0}["news_time"]); ?>
            </div>
        </div>
    </div>
</div>
<div class="min-vh-30"></div>

<?php include "include/footer.php" ; ?>
