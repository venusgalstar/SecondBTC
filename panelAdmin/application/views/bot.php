<?php include "include/header.php"; ?>
<div class="main-content-inner">
    <form action="<?php echo base_url(); ?>bot/addBot" method="POST">
        <div class="form-group">
            <div class="mt-5">
                    <?php
                    if(!empty($this->session->flashdata('hata'))){ 
                        echo '<div class="alert alert-danger" id="hata" role="alert">'.$this->session->flashdata('hata').'</div>';} 
                    elseif(!empty($this->session->flashdata('onay'))){
                        echo '<div class="alert alert-success" id="hata" role="alert">'.$this->session->flashdata('onay').'</div>';} ?>
            </div>
            <div class="row mt-3">
                <input type="hidden" id="banka_id" name="banka_id" value="<?php echo uretken(20); ?>">
                <div class="col-12 col-sm-3 mt-3">
                    <label for="system">Market (From-To)</label>
                    <select name="bot_short" id="bot_short" class="custom-select custom-select-sm" required>
                        <option value="">Select</option>
                        <?php foreach ($marketList as $marketList) { 
                            if(getAllBotSor($marketList["from_wallet_short"],$marketList["to_wallet_short"])=="yok"){?>
                        <option value="<?php echo $marketList["from_wallet_short"]."_".$marketList["from_wallet_id"]."_".$marketList["to_wallet_short"]."_".$marketList["to_wallet_id"]; ?>"><?php echo $marketList["from_wallet_short"]; ?>_<?php echo $marketList["to_wallet_short"]; ?></option>
                        <?php }} ?>
                    </select>
                </div>
                <div class="col-12 col-sm-3 mt-3">
                    <label for="system">Api Website</label>
                    <select name="bot_api" id="bot_api" class="custom-select custom-select-sm" required>
                        <option value="">Select</option>
                        <option value="binance">Binance</option>
                        <option value="bittrex">Bittrex</option>
                        <option value="crex">Crex</option>
                        <option value="hotbit">Hotbit</option>
                        <option value="bitforex">Bitforex</option>
                        <option value="pancakeswap">pancakeswap</option>
                        <option value="catetools-pancakeswap">Catetools-Pancakeswap</option>
                        <option value="catetools-uniswap">Catetools-Uniswap</option>
                    </select>
                </div>
                <div class="col-12 col-sm-3 mt-3">
                    <label for="system">Bot Live Trade</label>
                    <select name="bot_trade" id="bot_trade"  class="custom-select custom-select-sm" required>
                        <option value="0">Close</option>
                        <option value="1">Open</option>
                    </select>
                    <input type="text" id="userEmail" name="userEmail" class="form-control form-control-sm mt-2 collapse" placeholder="User Email">
                    <input type="text" id="userId" name="userID" class="form-control form-control-sm mt-2 collapse" placeholder="User ID">
                </div>
                <div class="col-12 col-sm-3 mt-3">
                        <label for="system">Bot action type</label>
                        <select name="bot_action_type" id="bot_action_type"  class="custom-select custom-select-sm" required>
                            <option value="0">Normal</option>
                            <option value="1">Reference Coin Price</option>
                            <option value="2">Two References Coin Usd Price</option>
                        </select>
                    </div>
                <div class="col-12 col-sm-3 mt-3">
                        <label for="system">BuyPrice -</label>
                        <input type="text" id="bot_buyPrice" name="bot_buyPrice" class="form-control form-control-sm " value="0">
                </div>
                <div class="col-12 col-sm-3 mt-3">
                        <label for="system">SellPrice +</label>
                        <input type="text" id="bot_sellPrice" name="bot_sellPrice" class="form-control form-control-sm " value="0">
                </div>
                <div class="col-12 col-sm-3 mt-3">
                        <label for="system">Bot Volume </label>
                        <input type="text" id="bot_volume" name="bot_volume" class="form-control form-control-sm " value="1">
                </div>
                <div class="col-12 col-sm-3 mt-3">
                        <label for="system">Price Reference Coin 1 </label>
                        <input type="text" id="ref_coin_1" name="ref_coin_1" class="form-control form-control-sm " value="null">
                </div>
                <div class="col-12 col-sm-3 mt-3">
                        <label for="system">Price Reference Coin 2 </label>
                        <input type="text" id="ref_coin_2" name="ref_coin_2" class="form-control form-control-sm " value="null">
                </div>
                <div class="col-12 mt-3">
                    <button class="btn btn-primary" name="buttonBank" value="save">Save Bot</button>
                </div>
            </div>
        </div>
    </form>
</div>    
<div class="main-content-inner-2" >
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Data Table Default</h4>
                    <div class="data-tables">
                        <table id="bankDataTable" class="table table-hover text-center" style="width: 100%">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>Market (From-To)</th>
                                    <th>Price Ref. Coin 1</th>
                                    <th>Price Ref. Coin 2</th>
                                    <th>Bot action type</th>
                                    <th>Api Website</th>
                                    <th>Bot User Email</th>
                                    <th>Bot User Id</th>
                                    <th>Status</th>
                                    <th>BuyPrice -</th>
                                    <th>SellPrice +</th>
                                    <th>Volume</th>
                                    <th>Update</th>
                                    <th>Delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php foreach ($botList as $botList) {?>
                                <tr>
                                    <td><?php echo $botList["bot_from_short"] ?>_<?php echo $botList["bot_to_short"] ?></td>
                                    <td><?php echo $botList["ref_coin_1"] ?></td>
                                    <td><?php echo $botList["ref_coin_2"] ?></td>
                                    <td><?php echo $botList["bot_action_type"] ?></td>
                                    <td><?php echo $botList["bot_api"] ?></td>
                                    <td><?php echo $botList["bot_userEmail"] ?></td>
                                    <td><?php echo $botList["bot_userId"] ?></td>
                                    <td><input type="checkbox" onclick="customJS.bot.botStatusUpdate('<?php echo $botList['bot_id']; ?>')" id="<?php echo $botList['bot_id']; ?>_bot_status" name="bot_status" <?php if($botList["bot_status"]==1){echo "checked";}?>></td>
                                    <td><input type="text" id="<?php echo $botList['bot_id']; ?>_bot_buyPrice" name="bot_buyPrice" class="form-control form-control-sm mt-2" value="<?php if(empty($botList["bot_buyPrice"])){ echo "0";} else{ echo Number($botList["bot_buyPrice"],8);} ?>"></td>
                                    <td><input type="text" id="<?php echo $botList['bot_id']; ?>_bot_sellPrice" name="bot_sellPrice" class="form-control form-control-sm mt-2" value="<?php if(empty($botList["bot_sellPrice"])){ echo "0";} else{ echo Number($botList["bot_sellPrice"],8);} ?>"></td>
                                    <td><input type="text" id="<?php echo $botList['bot_id']; ?>_bot_volume" name="bot_volume" class="form-control form-control-sm mt-2" value="<?php if(empty($botList["bot_volume"])){ echo "0";} else{ echo $botList["bot_volume"];} ?>"></td>
                                    <td>
                                        <i onclick="customJS.bot.botUpdate('<?php echo $botList['bot_id']; ?>')" class="fa fa-pencil text-info font-size-18" aria-hidden="true"></i>
                                    </td>
                                    <td>
                                        <i onclick="customJS.bot.botDelete('<?php echo $botList['bot_id']; ?>')" class="fa fa-trash-o text-danger font-size-18" aria-hidden="true"></i>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>   
<?php include "include/footer.php"; ?>

<script>
$("#bot_trade").change(function(){

    if($(this).val()==1){
        $("#userEmail").show();
        $("#userId").show();
    }else{
        $("#userEmail").hide();
        $("#userId").hide();
    }
//alert('Selected value: ' + $(this).val());
});

</script>
