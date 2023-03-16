<?php include "include/header.php" ; ?>

<div class="container">
    <div class="row mt-5">
        <div class="col-12 text-center mb-2">
        <h2><?php echo lang('announcement');?></h2>
        </div>
        <div class="col-12">
            <div class="row">
            <?php foreach ($news as $news) { 
                if($news["news_image"]==''){$resim = "news.png";}else{$resim = $news["news_image"];}
                if(($news["news_time"]+864000)<time()){$renk = "siyahBeyaz";}else{$renk = "";}
                ?>
            <div class="card ml-3 mb-3 <?php echo $renk; ?>" style="width: 16rem;">
            <a href="<?php echo base_url();?>newsdetail/<?php echo $news["news_id"]; ?>" class="text-dark text-decoration-none"> <img class="card-img-top" src="<?php echo base_url(); ?>assets/home/images/news/<?php echo $resim;?>" alt="">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $news["news_title"];?></h5>
                    <p class="card-text"><?php echo kisaltKelime($news["news_detail"],90);?></p>
                </div>
                </a>
            </div>
            <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php include "include/footer.php" ; ?>
