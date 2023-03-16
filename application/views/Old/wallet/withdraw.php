<?php include  __DIR__ . "/../include/header.php"; ?>

<div class="container">
  <div class="row mt-5">
    <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 text-center mb-2">
      <h2 class="buyukharf"><?php echo lang("withdraw"); ?> <span id="wallet"><?php echo $_GET["wallet"]; ?></h2>
    </div>
    <div class="col-12">
      <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3">
        <h3 class="font-size-15 ml-3"> <?php echo lang("warning17"); ?> <b><?php echo lang("warning18"); ?></b></h3>
      </div>
      <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3">
        <form>
          <div class="col-12 text-center">
            <label for="validationServer02" class="font-size-14 font-weight-bold"><?php echo lang("balance"); ?> : <span id="balance"><?php echo userWalletBalance($walletDetail[0]["wallet_id"], $userDetail[0]["user_id"], $userDetail[0]["user_email"]); ?></span></label>
          </div>
          <?php if ($walletDetail[0]["wallet_tag_system"] == "1") { ?>
            <div class="col-12 mb-3">
              <label for="validationServer02">Tag</label>
              <div class="input-group">
                <input type="text" class="form-control border-right-0" id="tag" placeholder="">
                <div class="input-group-prepend">
                  <span class="bg-light input-group-text" id="tag"><?php echo lang("optionally"); ?></span>
                </div>
              </div>
            </div>
          <?php } ?>
          <div class="col-12 mb-3">
            <label for="validationServer02"><?php echo lang("address"); ?></label>
            <div class="input-group">
              <input type="text" class="form-control border-right-0" id="address">
              <div class="input-group-prepend">
                <span class="bg-light input-group-text" id="address"><?php echo $_GET["wallet"]; ?></span>
              </div>
            </div>
          </div>
          <div class="col-12 mb-3">
            <label for="validationServer02"><?php echo lang("amount"); ?></label>
            <div class="input-group">
              <input type="text" class="form-control border-right-0" oninput="customJS.wallet.withdrawValue(this.value)" id="amount" placeholder="0.00000000" required>
              <div class="input-group-prepend">
                <span class="bg-light input-group-text" id="amount"><?php echo $_GET["wallet"]; ?></span>
              </div>
              <div class="my-feedback">Min. <?php echo lang("withdraw"); ?> : <?php echo Number($walletDetail[0]["wallet_min_with"], 8); ?> Max. <?php echo lang("withdraw"); ?> : <?php echo Number($walletDetail[0]["wallet_max_with"], 4); ?></div>
            </div>
          </div>
          <div class="col-12 text-right">
            <label for="validationServer02" class="font-size-14 font-weight-bold"><?php echo lang("withdraw"); ?> <?php echo lang("fee"); ?>: <?php echo $walletDetail[0]["wallet_with_com"]; ?><?php if ($walletDetail[0]["wallet_system"] == 'token') {
                                                                                                                                                                                                  echo  " ETH";
                                                                                                                                                                                                } else {
                                                                                                                                                                                                  echo ' ' . $_GET["wallet"];
                                                                                                                                                                                                } ?></label>
          </div>
          <div class="col-12 text-right">
            <label for="validationServer02" class="font-size-14 font-weight-bold"><?php echo lang("total"); ?> <?php echo lang("withdraw"); ?>: <span id="totalWith">0.00000000</span> <?php echo $_GET["wallet"]; ?></label>
          </div>
          <div class="col-12 text-right">
            <!-- <?php if ($userDetail[0]['user_with_conf'] == "M") {
                    $modal = "withdrawModalEmail";
                  } else {
                    $modal = "withdrawModal2FA";
                  } ?>
                        <button class="btn btn-primary mb-5" onclick="customJS.wallet.userWithdrawConfirm()"  id="modalButton" data-toggle="modal" data-target="#<?php echo $modal; ?>" type="button"><?php echo lang("withdraw"); ?></button>
                    </div> -->
            <button class="btn btn-primary mb-5" onclick="customJS.wallet.userWithdrawMetamask()" type="button"><?php echo lang("withdraw"); ?></button>

        </form>
      </div>
      <input type="hidden" id="withConf" value="<?php echo $userDetail[0]['user_with_conf']; ?>">
      <input type="hidden" id="commission" value="<?php if ($walletDetail[0]["wallet_system"] == 'token') {
                                                    echo  0;
                                                  } else {
                                                    echo $walletDetail[0]["wallet_with_com"];
                                                  } ?>">
    </div>
  </div>
</div>
<div class="modal fade" id="withdrawModalEmail" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo lang("emailcode"); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="recipient-name" class="col-form-label"><?php echo lang("processconfcode"); ?>:</label>
          <input autofocus="autofocus" type="number" class="form-control" id="onay_kodu">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang("cancel"); ?></button>
        <button type="button" onclick="customJS.wallet.userWithdrawCreate('M')" class="btn btn-primary"><?php echo lang("send"); ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="withdrawModal2FA" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"><?php echo lang("2facodeenter"); ?></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label for="recipient-name" class="col-form-label"><?php echo lang("processconfcode"); ?>:</label>
          <input autofocus="autofocus" type="number" class="form-control" id="onay_kodu2">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang("cancel"); ?></button>
        <button type="button" onclick="customJS.wallet.userWithdrawCreate('G')" class="btn btn-primary"><?php echo lang("send"); ?></button>
      </div>
    </div>
  </div>
</div>
<input type="hidden" id="userSecret" value="<?php echo yeniSifrele($_SESSION['user_data'][0]['user_id']); ?>">
<?php include  __DIR__ . "/../include/footer.php"; ?>