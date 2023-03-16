<?php
include('include/header.php');
?>
<div class="container">
    <section class="d-none">
        <h1>Markets</h1>
        <div class="row">
            <?php foreach ($marketUst as $marketUst) {
                if ($marketUst["change"] < 0) {
                    $renk = "danger";
                    $arrow = "down";
                } else {
                    $renk = "success";
                    $arrow = "up";
                } ?>
                <div class="col-sm-3">
                    <div class="card market">
                        <div class="card-body d-flex flex-row">
                            <div class="d-flex flex-column mr-4">
                                <h5 class="card-title"><?php echo $marketUst["to_wallet_name"]; ?>/ETH</h5>
                                <p class="market-price">0.01 ETH</p>
                                <p class="market-change"><span class="text-<?php echo $renk; ?> mr-2"> <?php echo $marketUst["change"]; ?>%</span></p>
                            </div>
                            <div class="d-flex flex-row align-items-start">
                                <img class="img-market" src="<?= base_url('assets/home/'); ?>img/eth.png">
                                <img class="img-market" src="<?php echo base_url("assets/home/images/logo/") . walletHelper($marketUst["to_wallet_short"])['wallet_logo']; ?>" width="47" height="47" alt="<?php echo $marketUst["to_wallet_name"]; ?>" title="<?php echo $marketUst["to_wallet_name"]; ?>">
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>
    <div class="my-5"></div>
    <div class="row">
        <div class="col-12">
            <div class="col-12">
                <ul class="nav nav-pills mb-3" id="myTab" role="tablist">
                    <?php
                    foreach ($marketPair as $pairs) {
                        if ($pairs['wallet_main_pairs'] == 1) {
                            $active = 'active';
                        } else {
                            $active = '';
                        }
                        $marketTab = $pairs['wallet_short'];
                        if ($pairs['wallet_main_pairs'] <= 5) {
                    ?>
                            <li class="nav-item">
                                <a class="d-none" id="<?php echo $active; ?>"><?php echo $pairs['wallet_id']; ?></a>
                                <a class="nav-link <?php echo $active; ?>" onclick="myFunction('<?php echo $pairs['wallet_id']; ?>')" data-toggle="tab" href="#<?php echo $pairs['wallet_short']; ?>" role="tab" aria-controls="<?php echo $pairs['wallet_short']; ?>" aria-selected="true"><?php echo $pairs['wallet_short']; ?></a>
                            </li>
                    <?php }
                    } ?>
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="ETH" role="tabpanel" aria-labelledby="ETH-tab">
                    <div class="col-12 table-responsive">
                        <table class="table table-dark table-hover table-sm marketTable" id="market-page" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-left" scope="col"><?php echo lang("market"); ?></th>
                                    <th class="text-left" scope="col"><?php echo lang("currency"); ?></th>
                                    <th class="text-right" scope="col"><?php echo lang("lastprice"); ?></th>
                                    <th class="text-right" scope="col"><?php echo lang("change"); ?></th>
                                    <th class="text-right" scope="col"><?php echo lang("volume"); ?></th>
                                    <th class="text-right" scope="col"><?php echo lang("24high"); ?></th>
                                    <th class="text-right" scope="col"><?php echo lang("24low"); ?></th>
                                    <th class="text-right" scope="col">Trade</th>
                                </tr>
                            </thead>
                            <tbody id="market"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('include/footer.php');
