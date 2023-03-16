<?php include('include/header.php')  ?>

<div class="jumbotron jumbotron-fluid h-100 d-flex align-items-center">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h1 class="display-4 mb-5">A trusted, secure and fully decentralized crypto exchange</h1>
                <p class="lead mb-5">No email, no password.
                    Login with MetaMask and start trading.
                    Simple as that!</p>
                <a href="trade.php" class="btn btn-lg btn-gradient">Start Trading</a>
            </div>
        </div>
    </div>
</div>
<style>
    #market-page_filter {
        display: none;
    }
</style>
<div class="container">
    <section>
        <h1>Markets</h1>
        <div class="markets-wrapper d-flex justify-content-between flex-nowrap">
            <?php foreach ($marketUst as $marketUst) {
                if ($marketUst["change"] < 0) {
                    $renk = "danger";
                    $arrow = "down";
                } else {
                    $renk = "success";
                    $arrow = "up";
                } ?>
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
            <?php } ?>
        </div>
    </section>
    <div class="my-5"></div>
    <div class="row">
        <div class="col-12">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
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
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="ETH" role="tabpanel" aria-labelledby="ETH-tab">
                    <div class="table-responsive">
                        <table class="table table-hover table-responsive table-dark table-sm marketTable" id="market-page">
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
</div>
<style>
    .page-link {
        padding: 5px;
        font-size: 12px;
    }
</style>
<footer class="m5">.</footer>
<?php
include('include/footer.php');
