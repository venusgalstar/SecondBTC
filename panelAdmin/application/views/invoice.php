<?php include "include/header.php"; ?>
<div class="main-content-inner mt-5">
    <div class="mt-5">
        <?php
        if (!empty($this->session->flashdata('hata'))) {
            echo '<div class="alert alert-danger" id="hata" role="alert">' . $this->session->flashdata('hata') . '</div>';
        } elseif (!empty($this->session->flashdata('onay'))) {
            echo '<div class="alert alert-success" id="hata" role="alert">' . $this->session->flashdata('onay') . '</div>';
        } ?>
    </div>
    <div class="row">
        <div class="col-12 col-xl-6 offset-xl-3">
            <?php if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 6) { ?>
                <form action="<?php echo base_url(); ?>invoice" method="POST">
                    <?php if (!empty($invoice[0]["invoice_id"])) { ?>
                        <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $invoice[0]["invoice_id"]; ?>">
                    <?php } else { ?>
                        <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo uretken(25); ?>">
                    <?php } ?>
                    <div class="form-group">
                        <label for="client_id">Client ID</label>
                        <input type="text" class="form-control" name="client_id" id="client_id" value="<?php echo yeniSifreCoz($invoice[0]["client_id"]); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?php echo yeniSifreCoz($invoice[0]["username"]); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" value="<?php echo yeniSifreCoz($invoice[0]["password"]); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="redirect_uri">Redirect Uri</label>
                        <input type="text" class="form-control" name="redirect_uri" id="redirect_uri" value="<?php echo yeniSifreCoz($invoice[0]["redirect_uri"]); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="company_id">Company ID</label>
                        <input type="text" class="form-control" name="company_id" id="company_id" value="<?php echo yeniSifreCoz($invoice[0]["company_id"]); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput2">Invoice Status</label>
                        <select name="invoice_status" id="invoice_status">
                            <option value="<?php echo $invoice[0]["invoice_status"]; ?>"><?php if ($invoice[0]["invoice_status"] == 1) {
                                                                                                echo "ON";
                                                                                            } else {
                                                                                                echo "OFF";
                                                                                            } ?></option>
                            <option value="0">OFF</option>
                            <option value="1">ON</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" name="save">Save Setting</button>
                    </div>
                </form>
            <?php } ?>
        </div>
    </div>
</div>
<?php include "include/footer.php"; ?>