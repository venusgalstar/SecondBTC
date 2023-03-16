<?php include "include/header.php"; ?>
<?php $userID = $_SESSION['user_data'][0]['user_id'];
$email = $_SESSION['user_data'][0]['user_email']; ?>
<style>
    .dataTables_filter {
        display: flex;
        justify-content: flex-end;
        margin-top: -54px;
        width: 200px;
        float: right;
    }
</style>
<div class="container text-white">
    <div class="row mt-5">
        <div class="col-6">
            <h2 class="font-size-17"><?php echo lang("wallet"); ?></h2>
        </div>
    </div>
    <div class="sub-header d-flex justify-content-between">
        <div class="market-pairs">
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#tab1" role="tab">Spot Wallet</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab2" role="tab">Pending Deposit</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab3" role="tab">Deposit History</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab4" role="tab">Pending Wthdrawal</a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#tab5" role="tab">Wthdrawal History</a></li>
            </ul>
        </div>
        <div>
            <!-- <form>
                <div class="form-group"><input type="search" class="form-control searchbar" placeholder="Search"></div>
            </form> -->
        </div>
    </div>
    <?php
    $pendingDeposit = $depositHistory;
    $DepositHistory = $depositHistory;
    $pendingWithdraw = $withdrawHistory;
    $WithdrawHistory = $withdrawHistory;
    ?>
    <div class="clearfix">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="tab1">
                <table class="table table-dark table-hover table-sm display" id="wallet-page">
                    <thead>
                        <tr>
                            <th class="text-left" scope="col"><?php echo lang("currency"); ?></th>
                            <th class="text-right" scope="col"><?php echo lang("market"); ?></th>
                            <th class="text-right" scope="col"><?php echo lang("balance"); ?></th>
                            <th class="text-right" scope="col"><?php echo lang("openorders"); ?></th>
                            <th class="text-right" scope="col"><?php echo lang("total"); ?></th>
                            <th class="text-right" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($WalletInfo as $walletInfo) {
                            if ($walletInfo["wallet_dep_status"] == 0) {
                                $disabledDep = "#";
                                $bgd = "secondary";
                                $title = lang("maintenance");
                            } else {
                                $title = "";
                                $bgd = "primary";
                                $disabledDep = base_url("wallet/deposit?wallet=") . $walletInfo["wallet_short"];
                            }
                            if ($walletInfo["wallet_with_status"] == 0) {
                                $disabledWith = "#";
                                $bgw = "secondary";
                                $titlew = lang("maintenance");
                            } else {
                                $titlew = "";
                                $bgw = "primary";
                                $disabledWith = base_url("wallet/withdraw?wallet=") . $walletInfo["wallet_short"];
                            } ?><tr>
                                <td class="text-left align-middle" scope="row"><?php echo $walletInfo["wallet_name"]; ?></td>
                                <td class="text-right align-middle" scope="row"><?php echo $walletInfo["wallet_short"]; ?></td>
                                <td class="text-right align-middle"><?php echo $balance = userWalletBalance($walletInfo["wallet_id"], $userID, $email); ?></td>
                                <td class="text-right align-middle"><?php echo Number($orders = userOpenOrdersTo($walletInfo["wallet_id"], $userID, $email) + userOpenOrdersFrom($walletInfo["wallet_id"], $userID, $email), 8); ?></td>
                                <td class="text-right align-middle"><?php echo Number($balance + $orders, 8); ?></td>
                                <td class="text-center" scope="row">
                                    <h2 class="font-size-16 mb-0"><a data-toggle="tooltip" data-placement="top" title="<?php echo $title; ?>" class="btn btn-sm btn-buy" href="<?php echo $disabledDep; ?>"><?php echo lang("deposit"); ?></a><a data-toggle="tooltip" data-placement="top" title="<?php echo $titlew; ?>" class="btn btn-sm btn-sell" href="<?php echo $disabledWith; ?>"><?php echo lang("withdraw"); ?></a></h2>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade show" id="tab2">
                <table class="table table-hover table-sm header-fixed" id="pendingDepositTable">
                    <thead>
                        <tr>
                            <th class="border-top-0"><?php echo lang("detail"); ?></td>
                            <th class="border-top-0 text-left"><?php echo lang("date"); ?></th>
                            <th class="border-top-0 text-center"><?php echo lang("currency"); ?></th>
                            <th class="border-top-0 text-right"><?php echo lang("amount"); ?></th>
                            <th class="border-top-0 text-right"><?php echo lang("confirm"); ?></th>
                            <th class="border-top-0 text-center"><?php echo lang("status"); ?></td>
                        </tr>
                    </thead>
                    <tbody><?php
                            foreach ($pendingDeposit as $pendingDeposit) {
                                if ($pendingDeposit['dep_history_status'] == "0") { ?>
                                <tr class="align-bottom" id="dep_<?php echo $pendingDeposit['dep_history_wallet_short'] . $pendingDeposit['dep_history_time']; ?>">
                                    <td><button class="btn btn-outline-primary btn-sm border-0" data-toggle="collapse" onclick="customJS.wallet.transactionsDetailModal( '<?php echo $pendingDeposit['dep_history_wallet_short']; ?>', '<?php echo Number($pendingDeposit['dep_history_amount'], 8); ?>', '<?php echo $pendingDeposit['dep_history_address']; ?>', '<?php echo $pendingDeposit['dep_history_txid']; ?>', '<?php echo date('Y-m-d H:i:s', $pendingDeposit['dep_history_time']); ?>', )" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-plus-circle"></i></button></td>
                                    <td class="text-left align-middle"><?php echo date("Y-m-d H:i:s", $pendingDeposit['dep_history_time']); ?></td>
                                    <td class="text-center align-middle"><?php echo $pendingDeposit['dep_history_wallet_short']; ?></td>
                                    <td class="text-right align-middle"><?php echo Number($pendingDeposit['dep_history_amount'], 8); ?></td>
                                    <td class="text-right align-middle"><?php echo $pendingDeposit['dep_history_comfirmation']; ?>/<?php echo walletHelper($pendingDeposit['dep_history_wallet_short'])["wallet_conf"] ?></td>
                                    <td class="text-center align-middle"><i class="spinner-border text-success spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" title="<?php echo lang("processing"); ?>..."></i><?php if ($pendingDeposit['dep_history_system'] == "fiat") { ?><i class="fa fa-times-circle cursor-pointer text-warning font-size-18" onclick="customJS.wallet.depositCancel('<?php echo $pendingDeposit['dep_history_wallet_short']; ?>','<?php echo $pendingDeposit['dep_history_time']; ?>')" data-toggle="tooltip" data-placement="right" title="<?php echo lang("clickcancel"); ?>"></i><?php } ?></td>
                                </tr>
                        <?php }
                            } ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade show" id="tab3">
                <table class="table table-dark table-hover table-sm display header-fixed" id="depositHistoryTable">
                    <thead>
                        <tr>
                            <th style="width: 10%;" class="border-top-0"><?php echo lang("detail"); ?></td>
                            <th style="width: 10%;" class="border-top-0 text-left"><?php echo lang("date"); ?></th>
                            <th style="width: 10%;" class="border-top-0 text-center"><?php echo lang("currency"); ?></th>
                            <th style="width: 50%;" class="border-top-0 text-center">txid</th>
                            <th style="width: 10%;" class="border-top-0 text-right"><?php echo lang("amount"); ?></th>
                            <th style="width: 10%;" class="border-top-0 text-center"><?php echo lang("status"); ?></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($DepositHistory as $DepositHistory) {
                            if ($DepositHistory['dep_history_status'] == "1") { ?><tr class="align-bottom">
                                    <td><button class="btn btn-outline-primary btn-sm border-0" data-toggle="collapse" onclick="customJS.wallet.transactionsDetailModal( '<?php echo $DepositHistory['dep_history_wallet_short']; ?>', '<?php echo Number($DepositHistory['dep_history_amount'], 8); ?>', '<?php echo $DepositHistory['dep_history_address']; ?>', '<?php echo $DepositHistory['dep_history_tag']; ?>', '<?php echo $DepositHistory['dep_txid_link']; ?>', '<?php echo date('Y-m-d H:i:s', $DepositHistory['dep_history_time']); ?>', )" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-plus-circle"></i></button></td>
                                    <td class="text-left align-middle"><?= date("Y-m-d H:i:s", $DepositHistory['dep_history_time']); ?></td>
                                    <td class="text-center align-middle"><?= $DepositHistory['dep_history_wallet_short']; ?></td>
                                    <td class="text-center align-middle"><a href="<?= $DepositHistory['dep_txid_link'] ?>" target="_blank"><?= $DepositHistory['dep_history_txid'] ?></a></td>
                                    <td class="text-right align-middle"><?= Number($DepositHistory['dep_history_amount'], 8); ?></td>
                                    <td class="text-center align-middle"><i class="fa fa-check-circle text-success font-size-19" data-toggle="tooltip" data-placement="right" title="<?php echo lang("processingsuccess"); ?>"></i></td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade show" id="tab4">
                <table class="table table-dark table-hover table-sm display header-fixed" id="pendingWithdrawTable">
                    <thead>
                        <tr>
                            <th class="border-top-0"><?php echo lang("detail"); ?></th>
                            <th class="border-top-0 text-left"><?php echo lang("date"); ?></th>
                            <th class="border-top-0 text-center"><?php echo lang("currency"); ?></th>
                            <th class="border-top-0 text-right"><?php echo lang("amount"); ?></th>
                            <th class="border-top-0 text-center"><?php echo lang("status"); ?></th>
                        </tr>
                    </thead>
                    <tbody><?php
                            $pendingWithdraw = $withdrawHistory;
                            $WithdrawHistory = $withdrawHistory;
                            foreach ($pendingWithdraw as $withdrawHistory) {
                                if ($withdrawHistory['withdraw_status'] == "0") { ?><tr class="align-bottom" id="with_<?php echo $withdrawHistory['withdraw_id']; ?>">
                                    <td><button class="btn btn-outline-primary btn-sm border-0" data-toggle="collapse" onclick="customJS.wallet.transactionsDetailModal( '<?php echo $withdrawHistory['withdraw_wallet_short']; ?>', '<?php echo Number($withdrawHistory['withdraw_amount'], 8); ?>', '<?php echo $withdrawHistory['withdraw_address']; ?>', 'Waiting...', '<?php echo date('Y-m-d H:i:s', $withdrawHistory['withdraw_time']); ?>', )" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-plus-circle"></i></button></td>
                                    <td class="text-left align-middle"><?php echo date("Y-m-d H:i:s", $withdrawHistory['withdraw_time']); ?></td>
                                    <td class="text-center align-middle"><?php echo $withdrawHistory['withdraw_wallet_short']; ?></td>
                                    <td class="text-right align-middle"><?php echo Number($withdrawHistory['withdraw_amount'], 8); ?></td>
                                    <td class="text-center align-middle"><?php if (($withdrawHistory["withdraw_time"] + 300) > time()) { ?><i class="fa fa-times-circle cursor-pointer text-warning font-size-25" onclick="customJS.wallet.withdrawCancel('<?php echo $withdrawHistory['withdraw_id']; ?>')" data-toggle="tooltip" data-placement="right" title="<?php echo lang("clickcancel"); ?>"></i><?php } else { ?><i class="spinner-border text-success spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" title="<?php echo lang("processing"); ?>..."></i><?php } ?></td>
                                </tr>
                        <?php }
                            } ?>
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade show" id="tab5">
                <table class="table table-dark table-hover table-sm display header-fixed" id="WithdrawHistoryTable">
                    <thead>
                        <tr>
                            <th style="width: 10%;" class="border-top-0"><?php echo lang("detail"); ?></th>
                            <th style="width: 10%;" class="border-top-0 text-left"><?php echo lang("date"); ?></th>
                            <th style="width: 10%;" class="border-top-0 text-center"><?php echo lang("currency"); ?></th>
                            <th style="width: 50%;" class="border-top-0 text-center">txid</th>
                            <th style="width: 10%;" class="border-top-0 text-right"><?php echo lang("amount"); ?></th>
                            <th style="width: 10%;" class="border-top-0 text-center"><?php echo lang("status"); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($WithdrawHistory as $withdrawHistory2) {
                            if ($withdrawHistory2['withdraw_status'] == "1" || $withdrawHistory2['withdraw_status'] == "2") {
                                if ($withdrawHistory2['withdraw_status'] == "1") {
                                    $durum = "fa fa-check-circle";
                                    $renk = "success";
                                    $titlewith = lang("processingsuccess");
                                    $font = "19";
                                } elseif ($withdrawHistory2['withdraw_status'] == "2") {
                                    $durum = "fa fa-times-circle";
                                    $renk = "warning";
                                    $titlewith = lang("processingcancel");
                                    $font = "19";
                                } ?>

                                <tr class="align-bottom">
                                    <td><button class="btn btn-outline-primary btn-sm border-0" data-toggle="collapse" onclick="customJS.wallet.transactionsDetailModal(
'<?php echo $withdrawHistory2['withdraw_wallet_short']; ?>',
'<?php echo Number($withdrawHistory2['withdraw_amount'], 8); ?>',
'<?php echo $withdrawHistory2['withdraw_address']; ?>',
'<?php echo $DepositHistory['dep_history_tag']; ?>',
'<?php echo $withdrawHistory2['withdraw_txid_link']; ?>',
'<?php echo date('Y-m-d H:i:s', $withdrawHistory2['withdraw_time']); ?>',

)" role="button" aria-expanded="false" aria-controls="collapseExample"><i class="fas fa-plus-circle"></i></button>
                                    </td>
                                    <td class="text-left align-middle"><?php echo date("Y-m-d H:i:s", $withdrawHistory2['withdraw_time']); ?></td>
                                    <td class="text-center align-middle"><?php echo $withdrawHistory2['withdraw_wallet_short']; ?></td>
                                    <td class="text-center align-middle"><a href="<?= $withdrawHistory2['withdraw_txid_link'] ?>" target="_blank"><?= $withdrawHistory2['withdraw_txid'] ?></a></td>
                                    <td class="text-right align-middle"><?php echo Number($withdrawHistory2['withdraw_amount'], 8); ?></td>
                                    <td class="text-center align-middle"><i class="<?php echo $durum . " text-" . $renk; ?> font-size-<?php echo $font; ?>" data-toggle="tooltip" data-placement="right" title="<?php echo $titlewith; ?>"></i></td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade collapse" id="transactionsModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="exampleModalLabel"><?php echo lang("detail"); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" style="font-size: 12px;">
                <table class="table-responsive">
                    <thead>
                        <tr>
                            <th class="w-25 pb-2"><?php echo lang("short"); ?>: </th>
                            <td class="pb-2" id="modalShort"></td>
                        </tr>
                        <tr>
                            <th class="pb-2"><?php echo lang("amount"); ?>: </th>
                            <td class="pb-2" id="modalAmount"></td>
                        </tr>
                        <tr>
                            <th class="pb-2"><?php echo lang("date"); ?>: </th>
                            <td class="pb-2" id="modalDate"></td>
                        </tr>
                        <tr>
                            <th class="pb-2"><?php echo lang("address"); ?>: </th>
                            <td class="text-break pb-2" id="modalAddress"></td>
                        </tr>
                        <tr>
                            <th class="pb-2">Txid : </th>
                            <td class="text-break pb-2" id="modaTxid"></td>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="userSecret" value="<?php echo yeniSifrele($_SESSION['user_data'][0]['user_id']); ?>">
<?php include "include/footer.php"; ?>