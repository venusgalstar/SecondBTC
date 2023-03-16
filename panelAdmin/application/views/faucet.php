<?php include "include/header.php"; ?>
<div class="main-content-inner">
    <div class="mt-5">
        <?php
        if(!empty($this->session->flashdata('hata'))){ 
            echo '<div class="alert alert-danger" id="hata" role="alert">'.$this->session->flashdata('hata').'</div>';} 
        elseif(!empty($this->session->flashdata('onay'))){
            echo '<div class="alert alert-success" id="hata" role="alert">'.$this->session->flashdata('onay').'</div>';} ?>
    </div>
    <table class="table table-striped" id="faucetDataTable">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Wallet Short</th>
                <th scope="col">Wallet Name</th>
                <th scope="col">Faucet Status</th>
                <th scope="col">Faucet Amount</th>
                <th scope="col">Period</th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($faucet as $faucet) { ?>
            <tr>
                <td><?php echo $faucet["wallet_id"]; ?></td>
                <td><?php echo $faucet["wallet_short"]; ?></td>
                <td><?php echo $faucet["wallet_name"]; ?></td>
                <td><select class="custom-select" name="faucet_status" id="<?php echo $faucet["wallet_short"]; ?>-faucet_status">
                        <option value="<?php echo @adminFaucetSetting($faucet["wallet_short"])["faucet_status"]; ?>"><?php if(@adminFaucetSetting($faucet["wallet_short"])["faucet_status"]==0){echo "OFF";}else{echo "ON";} ?></option>
                        <option value="1">ON</option>
                        <option value="0">OFF</option>
                    </select>
                </td>
                <td><input class="form-control" name="faucet_amount" id="<?php echo $faucet["wallet_short"]; ?>-faucet_amount" value="<?php echo Number(@adminFaucetSetting($faucet["wallet_short"])["faucet_amount"],8); ?>"></td>
                <td><select class="custom-select" name="faucet_period" id="<?php echo $faucet["wallet_short"]; ?>-faucet_period">
                        <option value="<?php echo @adminFaucetSetting($faucet["wallet_short"])["faucet_period"]; ?>"><?php echo get_time(@adminFaucetSetting($faucet["wallet_short"])["faucet_period"]); ?></option>
                        <option value="3600">1 hour</option>
                        <option value="7200">2 hour</option>
                        <option value="10800">3 hour</option>
                        <option value="14400">4 hour</option>
                        <option value="18000">5 hour</option>
                        <option value="21600">6 hour</option>
                        <option value="43200">12 hour</option>
                        <option value="86400">24 hour</option>
                    </select>
                </td>
                <td><button onclick="customJS.home.faucetUpdate('<?php echo $faucet['wallet_short']; ?>',<?php echo $faucet['wallet_id']; ?>)" class="btn btn-primary btn-sm">Save</button></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>    
<?php include "include/footer.php"; ?>
