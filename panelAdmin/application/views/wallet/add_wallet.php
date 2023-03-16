<?php include __DIR__ . "/../include/header.php"; ?>
<div class="main-content-inner">
    <form action="<?php echo base_url(); ?>wallet/addwallet" method="POST">
        <div class="form-group">
            <div class="mt-5">
                <?php
                if (!empty($this->session->flashdata('hata'))) {
                    echo '<div class="alert alert-danger" id="hata" role="alert">' . $this->session->flashdata('hata') . '</div>';
                } elseif (!empty($this->session->flashdata('onay'))) {
                    echo '<div class="alert alert-success" id="hata" role="alert">' . $this->session->flashdata('onay') . '</div>';
                } ?>
            </div>
            <div class="row mt-3">
                <div class="col-12 col-lg-6 mt-3">
                    <label for="short">Wallet ID</label>
                    <input type="text" readonly="readonly" class="form-control form-control-sm" name="wallet_id" value="<?php echo $wallet_id + 1; ?>">
                </div>
                <div class="col-12 col-lg-6 mt-3">
                    <label for="short">Wallet Short <i>(It can never be changed)</i></label>
                    <input type="text" class="form-control form-control-sm" name="wallet_short" placeholder="Please enter data.." value="<?php echo set_value('wallet_short'); ?>" required>
                </div>
                <div class="col-12 col-lg-6 mt-3">
                    <label for="short">Wallet Name</label>
                    <input type="text" class="form-control form-control-sm" name="wallet_name" placeholder="Please enter data.." value="<?php echo set_value('wallet_name'); ?>" required>
                </div>
                <div class="col-12 col-lg-3 mt-3">
                    <label for="system">Wallet System</label>
                    <select name="wallet_system" class="custom-select custom-select-sm" required>
                        <option value="">Select</option>
                        <option value="token">TOKEN</option>
                        <option value="coin">COIN</option>
                        <option value="eth">ETH</option>
                        <option value="ark">ARK</option>
                        <option value="tron">TRON</option>
                        <option value="monero">MONERO</option>
                        <option value="xrp">XRP</option>
                        <option value="note">NOTE</option>
                        <option value="fiat">FIAT</option>
                    </select>
                </div>
                <div class="col-12 col-lg-3 mt-3">
                    <label for="system">Wallet Network</label>
                    <select name="wallet_network" class="custom-select custom-select-sm" required>
                        <option value="">Select</option>
                        <option value="1">Ethereum</option>
                        <option value="56">Binance</option>
                    </select>
                </div>
                <div class="col-12 col-lg-6 mt-3">
                    <?php if ($_SESSION['user_data_admin'][0]['admin_type'] == "administrator") { ?>
                        <button class="btn btn-primary" name="insertWallet">Save Wallet</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </form>
</div>
<?php include __DIR__ . "/../include/footer.php"; ?>
