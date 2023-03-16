<?php include __DIR__ ."/../include/header.php"; ?>
<div class="main-content-inner-2" >
    <div class="row">
        <!-- data table start --> 
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Data Table Default</h4>
                    <div class="text-right mb-3">
                    <select class="form-control-sm" name="selectWallet" id="selectWallet" onChange="customJS.wallet.tradewalletSelect(this.id,this.value)">
                        <option value="">Select Market</option>
                        <?php foreach ($marketList as $marketList) { ?>
                        <option value="<?php echo $marketList["from_wallet_short"]; ?>-<?php echo $marketList["to_wallet_short"]; ?>"><?php echo $marketList["from_wallet_short"]; ?>-<?php echo $marketList["to_wallet_short"]; ?></option>
                        <?php } ?>
                    </select>
                    </div>
                    <div class="data-tables">
                        <table id="tradeHistoryDataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                            <tr>
                                <th>From Wallet</th>
                                <th>To Wallet</th>
                                <th>Type</th>
                                <th>Bid</th>
                                <th>Unit</th>
                                <th>Total</th>
                                <th>Commission</th>
                                <th>Created Date</th>
                                <th>User Email</th>
                                <th>Role</th>
                                <th>Order ID</th>
                            </tr>
                            </thead>
                            <tbody id="tradeHistoryVeri">
                                <tr>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                    <td><i class="spinner-border spinner-border-sm font-size-15" data-toggle="tooltip" data-placement="right" ></i></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>     
<?php include __DIR__ ."/../include/footer.php"; ?>