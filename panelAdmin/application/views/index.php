
<?php include "include/header.php"; ?>

    <div class="main-content-inner">
        
        <div class="row">
            <div class="col-12 col-lg-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Last 100 Faucet</h4>
                        <div class="data-tables table-responsive">
                            <table id="mainFaucetDataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Short</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>User Email</th>
                                        <th>UserID</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($faucet as $faucet) {?>
                                    <tr>
                                        <td><?php echo $faucet["wallet_short"]; ?></td>
                                        <td class="text-right"><?php echo Number($faucet["faucet_amount"],8); ?></td>
                                        <td class="wb-150"><span class="d-none"><?php echo $faucet["faucet_time"]; ?></span><?php echo date("Y-m-d H:i:s",$faucet["faucet_time"]); ?></td>
                                        <td><?php echo $faucet["faucet_user_email"]; ?></td>
                                        <td><?php echo $faucet["faucet_user_id"]; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="col-12 col-lg-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Total faucets coin/token.</h4>
                        <div class="data-tables table-responsive">
                            <table id="mainFaucetTotalDataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Short</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="faucetBody">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-12 col-lg-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Last 200 Deposit</h4>
                        <div class="data-tables table-responsive">
                            <table id="mainDepositDataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Short</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>User Email</th>
                                        <th>Date</th>
                                        <th>System</th>
                                        <th>Address</th>
                                        <th>Txid</th>
                                        <th>Tag</th>
                                        <th>UserID</th>
                                        <th>DepositID</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($deposit as $deposit) {?>
                                    <tr>
                                        <td><?php echo $deposit["dep_history_wallet_short"]; ?></td>
                                        <td class="text-right"><?php echo Number($deposit["dep_history_amount"],8); ?></td>
                                        <td><?php if($deposit["dep_history_status"]==1){echo '<span class="d-none">1</span></i><i class="fa fa-check-circle text-success"></i>';
                                        }else{echo '<span class="d-none">0</span></i><i class="spinner-border text-success spinner-border-sm text-warning"></i>('.$deposit["dep_history_comfirmation"].')';} ?></td>
                                        <td><?php echo $deposit["dep_history_user_email"]; ?></td>
                                        <td class="wb-150"><span class="d-none"><?php echo $deposit["dep_history_time"]; ?></span><?php echo date("Y-m-d H:i:s",$deposit["dep_history_time"]); ?></td>
                                        <td><?php echo $deposit["dep_history_system"]; ?></td>
                                        <td><?php echo $deposit["dep_history_address"]; ?></td>
                                        <td><?php echo $deposit["dep_history_txid"]; ?></td>
                                        <td><?php echo $deposit["dep_history_tag"]; ?></td>
                                        <td><?php echo $deposit["dep_history_user_id"]; ?></td>
                                        <td><?php echo $deposit["dep_history_id"]; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="col-12 col-lg-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Last 100 Withdraw</h4>
                        <div class="data-tables table-responsive">
                            <table id="mainWithdrawDataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Short</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>User Email</th>
                                        <th>Date</th>
                                        <th>System</th>
                                        <th>Address</th>
                                        <th>Txid</th>
                                        <th>Tag</th>
                                        <th>UserID</th>
                                        <th>WithdrawID</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($withdraw as $withdraw) {?>
                                    <tr>
                                        <td><?php echo $withdraw["withdraw_wallet_short"]; ?></td>
                                        <td class="text-right"><?php echo Number($withdraw["withdraw_amount"],8); ?></td>
                                        <td><?php if($withdraw["withdraw_status"]==0){echo '<span class="d-none">0</span></i><i class="spinner-border text-success spinner-border-sm text-warning">';}else{echo '<span class="d-none">1</span></i><i class="fa fa-check-circle text-success"></i>';}; ?></td>
                                        <td><?php echo $withdraw["withdraw_user_email"]; ?></td>
                                        <td class="wb-150"><span class="d-none"><?php echo $withdraw["withdraw_time"]; ?></span><?php echo date("Y-m-d H:i:s",$withdraw["withdraw_time"]); ?></td>
                                        <td><?php echo $withdraw["withdraw_system"]; ?></td>
                                        <td><?php echo $withdraw["withdraw_address"]; ?></td>
                                        <td><?php echo $withdraw["withdraw_txid"]; ?></td>
                                        <td><?php echo $withdraw["withdraw_tag"]; ?></td>
                                        <td><?php echo $withdraw["withdraw_user_id"]; ?></td>
                                        <td><?php echo $withdraw["withdraw_id"]; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-12 col-lg-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Last 100 Exchange</h4>
                        <div class="data-tables table-responsive">
                            <table id="mainExchangeDataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>From Short</th>
                                        <th>To Short</th>
                                        <th>Price</th>
                                        <th>Amount</th>
                                        <th>Total</th>
                                        <th>Type</th>
                                        <th>User Email</th>
                                        <th>Date</th>
                                        <th>UserID</th>
                                        <th>ExchangeID</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($exchange as $exchange) {?>
                                    <tr>
                                        <td><?php echo $exchange["exchange_from_short"]; ?></td>
                                        <td><?php echo $exchange["exchange_to_short"]; ?></td>
                                        <td class="text-right"><?php echo Number($exchange["exchange_bid"],8); ?></td>
                                        <td class="text-right"><?php echo Number($exchange["exchange_unit"],8); ?></td>
                                        <td class="text-right"><?php echo Number(($exchange["exchange_bid"]*$exchange["exchange_unit"]),8); ?></td>
                                        <td><?php echo $exchange["exchange_type"]; ?></td>
                                        <td><?php echo $exchange["exchange_user_email"]; ?></td>
                                        <td><span class="d-none"><?php echo $exchange["exchange_created"]; ?></span><?php echo date("Y-m-d H:i:s",$exchange["exchange_created"]); ?></td>
                                        <td><?php echo $exchange["exchange_user_id"]; ?></td>
                                        <td><?php echo $exchange["exchange_id"]; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>  
            <div class="col-12 col-lg-6 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Last 100 Trade</h4>
                        <div class="data-tables table-responsive">
                            <table id="mainTradeDataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>From Short</th>
                                        <th>To Short</th>
                                        <th>Price</th>
                                        <th>Amount</th>
                                        <th>Total</th>
                                        <th>Type</th>
                                        <th>User Email</th>
                                        <th>Rol</th>
                                        <th>Date</th>
                                        <th>UserID</th>
                                        <th>TradeID</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($trade as $trade) {?>
                                    <tr>
                                        <td><?php echo $trade["trade_from_wallet_short"]; ?></td>
                                        <td><?php echo $trade["trade_to_wallet_short"]; ?></td>
                                        <td class="text-right"><?php echo Number($trade["trade_bid"],8); ?></td>
                                        <td class="text-right"><?php echo Number($trade["trade_unit"],8); ?></td>
                                        <td class="text-right"><?php echo Number(($trade["trade_bid"]*$trade["trade_unit"]),8); ?></td>
                                        <td><?php echo $trade["trade_type"]; ?></td>
                                        <td><?php echo $trade["trade_user_email"]; ?></td>
                                        <td><?php echo $trade["trade_exchange_rol"]; ?></td>
                                        <td><span class="d-none"><?php echo $trade["trade_created"]; ?></span><?php echo date("Y-m-d H:i:s",$trade["trade_created"]); ?></td>
                                        <td><?php echo $trade["trade_user_id"]; ?></td>
                                        <td><?php echo $trade["trade_id"]; ?></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="row">
            <div class="col-12 col-lg-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Last 24 Hours BTC Trade</h4>
                        <div class="data-tables table-responsive">
                            <table id="mainvolBTCDataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>UserEmail</th>
                                        <th>FromShort</th>
                                        <th>ToShort</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Vol</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $totalBTC=0; foreach ($tradeVolBTC as $tradeVolBTC) {?>
                                    <tr>
                                        <td><?php echo $tradeVolBTC["trade_user_email"]; ?></td>
                                        <td class="text-right"><?php echo $tradeVolBTC["trade_from_wallet_short"]; ?></td>
                                        <td class="wb-150"><?php echo $tradeVolBTC["trade_to_wallet_short"]; ?></td>
                                        <td><?php echo date("Y-m-d H:i:s",$tradeVolBTC["trade_created"]); ?></td>
                                        <td><?php echo $tradeVolBTC["trade_type"]; ?></td>
                                        <td><?php echo $tradeVolBTC["trade_total"]; ?></td>
                                    </tr>
                                    <?php 
                                    $totalBTC = $totalBTC+$tradeVolBTC["trade_total"];
                                } ?>
                                </tbody>
                                Total BTC Vol : <?php echo Number($totalBTC,8)?>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">
            <div class="col-12 col-lg-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Last 24 Hours ETH Trade</h4>
                        <div class="data-tables table-responsive">
                            <table id="mainvolETHDataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>UserEmail</th>
                                        <th>FromShort</th>
                                        <th>ToShort</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Vol</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $totalETH=0; foreach ($tradeVolETH as $tradeVolETH) {?>
                                    <tr>
                                        <td><?php echo $tradeVolETH["trade_user_email"]; ?></td>
                                        <td class="text-right"><?php echo $tradeVolETH["trade_from_wallet_short"]; ?></td>
                                        <td class="wb-150"><?php echo $tradeVolETH["trade_to_wallet_short"]; ?></td>
                                        <td><?php echo date("Y-m-d H:i:s",$tradeVolETH["trade_created"]); ?></td>
                                        <td><?php echo $tradeVolETH["trade_type"]; ?></td>
                                        <td><?php echo $tradeVolETH["trade_total"]; ?></td>
                                    </tr>
                                    <?php 
                                    $totalETH = $totalETH+$tradeVolETH["trade_total"];
                                } ?>
                                </tbody>
                                Total ETH Vol : <?php echo Number($totalETH,8)?>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
        <div class="row">
            <div class="col-12 col-lg-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Last 24 Hours USDT Trade</h4>
                        <div class="data-tables table-responsive">
                            <table id="mainvolUSDTDataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>UserEmail</th>
                                        <th>FromShort</th>
                                        <th>ToShort</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th>Vol</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $totalUSDT=0; foreach ($tradeVolUSDT as $tradeVolUSDT) {?>
                                    <tr>
                                        <td><?php echo $tradeVolUSDT["trade_user_email"]; ?></td>
                                        <td class="text-right"><?php echo $tradeVolUSDT["trade_from_wallet_short"]; ?></td>
                                        <td class="wb-150"><?php echo $tradeVolUSDT["trade_to_wallet_short"]; ?></td>
                                        <td><?php echo date("Y-m-d H:i:s",$tradeVolUSDT["trade_created"]); ?></td>
                                        <td><?php echo $tradeVolUSDT["trade_type"]; ?></td>
                                        <td><?php echo $tradeVolUSDT["trade_total"]; ?></td>
                                    </tr>
                                    <?php 
                                    $totalUSDT = $totalUSDT+$tradeVolUSDT["trade_total"];
                                } ?>
                                </tbody>
                                Total USDT Vol : <?php echo Number($totalUSDT,8)?>
                            </table>
                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
<?php include "include/footer.php"; ?>
