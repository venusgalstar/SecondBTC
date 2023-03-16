<div class="buy-sell">
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="pills-open-orders-tab" data-toggle="pill" href="#tab1" role="tab" aria-controls="pills-open-orders" aria-selected="true">BUY</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="pills-deposit-history-tab" data-toggle="pill" href="#tab2" role="tab" aria-controls="pills-deposit-history" aria-selected="false">SELL</a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="tab1">
            <form class="" autocomplete="off">
                <div class="form-group">
                    <label class="mt-2">
                        <h2 class="font-size-12 buyukharf">
                            <?php echo lang("buy"); ?> <?php echo strtoupper($toWallet[0]['wallet_name']); ?>
                        </h2>
                    </label>
                    <label class="float-right mt-2" for="userFromBalance"><b id="userFromBalance" class="mr-1 cursor-auto">0.00000000000000</b><i id="fromWallet"><?php echo $fromWallet[0]['wallet_short']; ?></i>
                    </label>
                    <div class="input-group-prepend">
                        <div class="input-group-text exchange-input"><?php echo $toWallet[0]['wallet_short']; ?></div>
                        <input type="text" class="form-control form-control-sm text-right" id="buyFromUnit" oninput="customJS.exchange.tradeBuyTotal(this.value)" aria-describedby="textHelp" data-toggle="tooltip" data-placement="right" title="<?php echo lang("amount"); ?>" placeholder="0.00000000000000">
                        <small id="buyFromAmountUyarı" class="form-text text-muted d-none">uyarı</small>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text exchange-input"><?php echo $fromWallet[0]['wallet_short']; ?></div><input type="text" class="form-control form-control-sm text-right" id="buyFromPrice" oninput="customJS.exchange.tradeBuyPrice(this.value)" aria-describedby="textHelp" value="<?php echo Number($lastPrice, 14); ?>" data-toggle="tooltip" data-placement="right" title="<?php echo lang("price"); ?>" placeholder="0.00000000000000"><small id="buyFromPriceUyarı" class="form-text text-muted d-none">uyarı</small>
                    </div>
                </div><?php if (!empty($_SESSION['user_data'][0]['user_email']) && !empty($_SESSION['user_data'][0]['user_id'])) { ?><div class="form-group">
                        <div class="input-group newgroup"><span class="input-group-addon yeniyazi"></span><input type="button" class="btn btn-primary btn-sm yuzde" onclick="javascript:customJS.exchange.RangeFrom('25')" value="25%"><input type="button" class="btn btn-primary btn-sm yuzde" onclick="javascript:customJS.exchange.RangeFrom('50')" value="50%"><input type="button" class="btn btn-primary btn-sm yuzde" onclick="javascript:customJS.exchange.RangeFrom('75')" value="75%"><input type="button" class="btn btn-primary btn-sm yuzde" onclick="javascript:customJS.exchange.RangeFrom('100')" value="100%"></div>
                    </div><?php } ?><div class="form-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text exchange-input"><?php echo $fromWallet[0]['wallet_short']; ?></div><input type="text" class="form-control form-control-sm text-right" id="buyFromTotal" oninput="customJS.exchange.tradeBuyUnit(this.value)" aria-describedby="BuyTotal" data-toggle="tooltip" data-placement="right" title="<?php echo lang("total"); ?>" placeholder="0.00000000000000"><small id="buyFromTotalUyarı" class="form-text text-muted d-none">uyarı</small>
                    </div>
                </div>
                <?php
                if (!empty($_SESSION['user_data'][0]['user_email']) && !empty($_SESSION['user_data'][0]['user_id']) && $toWallet[0]['wallet_ex_status'] == 1) {
                ?>
                    <button type="button" onclick="customJS.exchange.trade('buy')" id="buyButton" class="btn btn-buy btn-block buyukharf"><?php echo lang("buy"); ?><?php echo $toWallet[0]['wallet_short']; ?></button>
                <?php } elseif (!empty($_SESSION['user_data'][0]['user_email']) && !empty($_SESSION['user_data'][0]['user_id']) && $toWallet[0]['wallet_ex_status'] != 1) {
                ?>
                    <button type="button" class="btn btn-secondary btn-block"><?php echo lang("marketcloded"); ?></button>
                <?php } else {
                ?>
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-primary w-40 ml-2" onclick="window.location.href='<?php echo base_url(); ?>login'"><?php echo lang("login"); ?></button>
                        <button type="button" class="btn btn-primary w-40 ml-2" onclick="window.location.href='<?php echo base_url(); ?>register'"><?php echo lang("register"); ?></button>
                    </div>
                <?php } ?>
            </form>
        </div>
        <div class="tab-pane fade show" id="tab2">
            <form class="" autocomplete="off">
                <div class="form-group">
                    <label class="mt-2">
                        <h2 class="font-size-12 buyukharf"><?php echo lang("sell"); ?> <?php echo strtoupper($toWallet[0]['wallet_name']); ?></h2>
                    </label>

                    <label class="float-right mt-2" for="userToBalance"><b id="userToBalance" class="mr-1 cursor-auto">0.00000000000000</b><i id="toWallet"><?php echo $toWallet[0]['wallet_short']; ?></i></label>

                    <div class="input-group-prepend">
                        <div class="input-group-text exchange-input"><?php echo $toWallet[0]['wallet_short']; ?></div>
                        <input type="text" class="form-control form-control-sm text-right buyinput" id="sellToUnit" oninput="customJS.exchange.tradeSellTotal(this.value)" aria-describedby="sellToUnit" data-toggle="tooltip" data-placement="right" title="<?php echo lang("amount"); ?>" placeholder="0.00000000000000">
                    </div>
                    <small id="textHelp" class="form-text text-muted d-none">uyarı</small>
                </div>

                <div class="form-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text exchange-input"><?php echo $fromWallet[0]['wallet_short']; ?></div>
                        <input type="text" class="form-control form-control-sm text-right buyinput" id="sellToPrice" oninput="customJS.exchange.tradeSellPrice(this.value)" aria-describedby="sellToPrice" value="<?php echo Number($lastPrice, 14); ?>" data-toggle="tooltip" data-placement="right" title="<?php echo lang("price"); ?>" placeholder="0.00000000000000">

                    </div>
                    <small id="textHelp" class="form-text text-muted d-none">uyarı</small>

                </div>

                <?php if (!empty($_SESSION['user_data'][0]['user_email']) && !empty($_SESSION['user_data'][0]['user_id'])) { ?>
                    <div class="form-group">
                        <div class="input-group newgroup">
                            <span class="input-group-addon yeniyazi"></span>
                            <input type="button" class="btn btn-primary btn-sm yuzde" onclick="javascript:customJS.exchange.RangeTo('25')" value="25%">
                            <input type="button" class="btn btn-primary btn-sm yuzde" onclick="javascript:customJS.exchange.RangeTo('50')" value="50%">
                            <input type="button" class="btn btn-primary btn-sm yuzde" onclick="javascript:customJS.exchange.RangeTo('75')" value="75%">
                            <input type="button" class="btn btn-primary btn-sm yuzde" onclick="javascript:customJS.exchange.RangeTo('100')" value="100%">
                        </div>
                    </div>

                <?php } ?>

                <div class="form-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text exchange-input"><?php echo $fromWallet[0]['wallet_short']; ?></div>
                        <input type="text" class="form-control form-control-sm text-right buyinput" id="sellToTotal" oninput="customJS.exchange.tradeSellUnit(this.value)" aria-describedby="SellTotal" data-toggle="tooltip" data-placement="right" title="<?php echo lang("total"); ?>" placeholder="0.00000000000000">
                        <small id="buyToTotalUyarı" class="form-text text-muted d-none">uyarı</small>
                    </div>
                </div>
                <?php
                if (!empty($_SESSION['user_data'][0]['user_email']) && !empty($_SESSION['user_data'][0]['user_id']) && $toWallet[0]['wallet_ex_status'] == 1) { ?>
                    <button type="button" onclick="customJS.exchange.trade('sell')" id="sellButton" class="btn btn-sell btn-block buyukharf"><?php echo lang("sell"); ?> <?php echo $toWallet[0]['wallet_short']; ?></button>
                <?php } elseif (!empty($_SESSION['user_data'][0]['user_email']) && !empty($_SESSION['user_data'][0]['user_id']) && $toWallet[0]['wallet_ex_status'] != 1) { ?>
                    <button type="button" class="btn btn-secondary btn-block"><?php echo lang("marketcloded"); ?></button>
                <?php } else { ?>
                    <div class="form-group text-center">
                        <button type="button" class="btn btn-primary w-40 ml-2" onclick="window.location.href='<?php echo base_url(); ?>login'"><?php echo lang("login"); ?></button>
                        <button type="button" class="btn btn-primary w-40 ml-2" onclick="window.location.href='<?php echo base_url(); ?>register'"><?php echo lang("register"); ?></button>
                    </div>
                <?php } ?>

            </form>
        </div>
    </div>
</div>