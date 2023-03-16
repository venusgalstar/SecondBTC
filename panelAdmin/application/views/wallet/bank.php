<?php include __DIR__ ."/../include/header.php"; ?>
<div class="main-content-inner">
    <form action="<?php echo base_url(); ?>fiat/addbank" method="POST">
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
                <div class="col-12 col-lg-6 mt-3">
                    <label for="system">Fiat Wallet</label>
                    <select name="fiat_short" id="fiat_short" class="custom-select custom-select-sm" required>
                        <option value="">Select</option>
                        <?php foreach ($fiatWallet as $fiatWallet) { ?>
                        <option value="<?php echo $fiatWallet["wallet_short"]; ?>"><?php echo $fiatWallet["wallet_short"]; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="col-12 col-lg-6 mt-3">
                    <label for="short">Bank Name</label>
                    <select class="form-control form-control-sm" required name="banka_name" id="banka_name">
                    <?php foreach ($dataBanks as $dataBanks) { ?>
                              <option value="<?php echo $dataBanks["name"]; ?>"><?php echo $dataBanks["name"]; ?></option>
                    <?php } ?>
                    </select>
                </div>
                <div class="col-12 col-lg-6 mt-3">
                    <label for="short">IBAN</label>
                    <input type="text" class="form-control form-control-sm buyukharf" id="banka_iban" name="banka_iban" value="" required>
                </div>
                <div class="col-12 col-lg-6 mt-3">
                    <label for="short">Company Name</label>
                    <input type="text" class="form-control form-control-sm" id="banka_hesap" name="banka_hesap" placeholder="Please enter data.." value="" required>
                </div>
                <div class="col-12 col-lg-6 mt-3">
                    <button class="btn btn-primary" name="buttonBank" value="save">Save Bank</button>
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
                        <table id="bankDataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>Fiat Short</th>
                                    <th>Bank Name</th>
                                    <th>IBAN</th>
                                    <th>Company Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php foreach ($bankList as $bankList) {?>
                                <tr id="<?php echo $bankList["banka_id"] ?>">
                                    <td><?php echo $bankList["fiat_short"] ?></td>
                                    <td><?php echo $bankList["banka_name"] ?></td>
                                    <td><?php echo $bankList["banka_iban"] ?></td>
                                    <td><?php echo $bankList["banka_hesap"] ?></td>
                                    <td>
                                        <i onclick="customJS.bank.bankUpdate('<?php echo $bankList['banka_id']; ?>')" class="fa fa-pencil-square-o text-info font-size-18" aria-hidden="true"></i> 
                                        <i onclick="customJS.bank.bankDelete('<?php echo $bankList['banka_id']; ?>')" class="fa fa-trash-o text-danger font-size-18" aria-hidden="true"></i>
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
<?php include __DIR__ ."/../include/footer.php"; ?>
