<?php include __DIR__ ."/../include/header.php"; ?>
<div class="main-content-inner">
    <div class="form-group">
        <div class="row mt-3">
            <div class="col-12 col-lg-3">
                <label for="system">Change Setting</label>
                <select  id="change_setting"  class="custom-select custom-select-sm" onChange="customJS.wallet.allWalletSelect(this.id)">
                    <option value="">Select Setting</option>
                    <option value="0-wallet_status">All Wallet Status</option>
                    <option value="0-wallet_ex_status">All Wallet Exchange Status</option>
                    <option value="0-wallet_dep_status">All Wallet Deposit Status</option>
                    <option value="0-wallet_with_status">All Wallet Withdraw Status</option>
                    <option value="1-wallet_buy_com">All Wallet Buy Commission</option>
                    <option value="1-wallet_sell_com">All Wallet Sell Commission</option>
                    <option value="1-wallet_min_unit">All Wallet Minimum Unit</option>
                    <option value="1-wallet_min_total">All Wallet Minimum Total</option>
                    <option value="1-wallet_min_bid">All Wallet Minimum Bid</option>
                </select>
            </div>
            <input type="hidden" id="selectOption">
            <div class="col-12 col-lg-3 collapse" id="textInput">
                <label for="text_input">Value</label>
                <div class="input-group-append">
                    <input type="text" class="form-control form-control-sm" id="text_input" placeholder="Double value">
                    <button class="input-group-text button-input btn btn-primary" onclick="customJS.wallet.allWalletChange('text_input',1)" id="">Save</button>
                </div>
            </div>
            <div class="col-12 col-lg-3 collapse" id="selectInput">
            <label for="system">Value</label>
                <select  id="select_input"  class="custom-select custom-select-sm" onChange="customJS.wallet.allWalletChange(this.id,5)">
                    <option value="">Select Option</option>
                    <option value="1">On</option>
                    <option value="0">Off</option>
                </select>
            </div>
        </div>
    </div>
</div>    
<?php include __DIR__ ."/../include/footer.php"; ?>