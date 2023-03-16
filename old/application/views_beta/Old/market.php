<?php include "include/header.php"; ?>
<style>
    table.dataTable tbody th,
    table.dataTable tbody td {
        padding: 10px 10px !important;
    }
</style>
<div class="container-flud ust-card">
    <div class="row ml-5 mr-5 pt-5">
        <div class="col-xl-12">
            <div class="row">
                <?php foreach ($marketUst as $marketUst) {
                    if ($marketUst["change"] < 0) {
                        $renk = "danger";
                        $arrow = "down";
                    } else {
                        $renk = "success";
                        $arrow = "up";
                    } ?>
                    <div class="col-lg-3 mb-2 mt-1">
                        <div class="widget-flat card border-left-dark ust-card-2">
                            <div class="card-body pb-1">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <h5 class="font-weight-normal pb-0 text-muted" title="Number of Customers"> <?php echo $marketUst["to_wallet_name"]; ?> <img style="float:right" src="<?php echo base_url("assets/home/images/logo/") . walletHelper($marketUst["to_wallet_short"])['wallet_logo']; ?>" width="40" height="40" alt="<?php echo $marketUst["to_wallet_name"]; ?>" title="<?php echo $marketUst["to_wallet_name"]; ?>"></h5>
                                        <h4 class="mt-2 mb-2 font-size-16 text-<?php echo $renk; ?>"><i class="fas fa-long-arrow-alt-<?php echo $arrow; ?>"></i> <?php echo Number($marketUst["to_wallet_last_price"], 8); ?> <?php echo $marketUst["from_wallet_short"]; ?></h4>
                                        <p class="mb-0 text-muted">
                                            <span class="text-<?php echo $renk; ?> mr-2"> <?php echo $marketUst["change"]; ?>%</span>
                                            <span class="font-weight-bold"><?php echo Number($marketUst["to_wallet_24h_vol"], 2); ?> <?php echo $marketUst["from_wallet_short"]; ?> </span>
                                        </p>
                                        <h2 class=" font-size-8 mt-2 text-right mb-0"><a href="#" style="font-weight-light; color:#f89d31;" target="_blank">Top Volume</a></h2>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row mt-4">
        <!-- <div class="col-12 text-center font-size-15 text-secondary font-weight-bold"><i class="fas fa-bullhorn"></i> <?php echo $news{
                                                                                                                            0}['news_title']; ?>: <?php echo kisaltKelime($news{
                                                                                                                                                                    0}['news_detail'], 35); ?><span class="ml-3"><a href="<?php echo base_url(); ?>/news">|  <?php echo lang("detail"); ?></a></span></div>-->
    </div>
    <div class="row mt-5">
        <!--<div class="col-6"><h1 class="font-size-16">MARKET</h1></div>
            <div class="col-6"><h3 class="font-size-16 text-right">24HR VOLUME : 106.4574 BTC <p>1.012.254$</p></h3></div>-->
    </div>
    <div class="col-12">
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <?php foreach ($marketPair as $pairs) {
                if ($pairs['wallet_main_pairs'] == 1) {
                    $active = 'active';
                } else {
                    $active = '';
                }
                $marketTab = $pairs['wallet_short'];
                if ($pairs['wallet_main_pairs'] <= 5) {
            ?>
                    <li class="nav-item">
                        <a class="d-none" id="<?php echo $active; ?>"><?php echo $pairs['wallet_id']; ?></a> <a class="nav-link <?php echo $active; ?>" onclick="myFunction('<?php echo $pairs['wallet_id']; ?>')" data-toggle="tab" href="#<?php echo $pairs['wallet_short']; ?>" role="tab" aria-controls="<?php echo $pairs['wallet_short']; ?>" aria-selected="true"><?php echo $pairs['wallet_short']; ?></a>
                    </li>
            <?php }
            } ?>
        </ul>
        <div class="tab-content " id="myTabContent">
            <div class="tab-pane fade show active" id="ETH" role="tabpanel" aria-labelledby="ETH-tab">
                <div class="col-12 table-responsive">
                    <table class="table table-hover table-sm marketTable" id="marketEx" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-left" scope="col"><?php echo lang("market"); ?></th>
                                <th class="text-left" scope="col"><?php echo lang("currency"); ?></th>
                                <th class="text-right" scope="col"><?php echo lang("lastprice"); ?></th>
                                <th class="text-right" scope="col"><?php echo lang("change"); ?></th>
                                <th class="text-right" scope="col"><?php echo lang("volume"); ?></th>
                                <th class="text-right" scope="col"><?php echo lang("24high"); ?></th>
                                <th class="text-right" scope="col"><?php echo lang("24low"); ?></th>
                            </tr>
                        </thead>
                        <tbody id="market">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include "include/footer.php"; ?>