<?php include "include/header.php"; ?>
<?php if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 10) { ?>
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
                <form action="<?php echo base_url(); ?>home/addFund" method="POST">
                    <div class="form-group">
                        <label for="formGroupExampleInput2">User Email</label>
                        <input type="email" class="form-control" name="fund_email" id="fund_email" required>
                    </div>
                    <div class="form-group">
                        <label for="team_email">User ID</label>
                        <input type="text" class="form-control" name="fund_id" id="fund_id" required>
                    </div>
                    <div class="form-group">
                        <label for="team_linkedin">Wallet Short</label>
                        <input type="text" class="form-control" name="fund_wallet" id="fund_wallet" required>
                    </div>
                    <div class="form-group">
                        <label for="team_telegram">Amount</label>
                        <input type="text" class="form-control" name="fund_amount" id="fund_amount" required>
                    </div>
                    <div class="form-group">
                        <label for="team_telegram">Google Key</label>
                        <input type="number" class="form-control" name="googleCode" id="googleCode" required>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" name="addFund">Add Fund</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php } ?>
<div class="main-content-inner">
    <table class="table table-striped" id="fundDataTable">
        <thead>
            <tr>
                <th scope="col">User Email</th>
                <th scope="col">User ID</th>
                <th scope="col">Wallet Short</th>
                <th scope="col">Amount</th>
                <th scope="col">Admin Email</th>
                <th scope="col">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($oldFund as $oldFund) { ?>
                <tr>
                    <td><?php echo $oldFund["fund_email"]; ?></td>
                    <td><?php echo $oldFund["fund_id"]; ?></td>
                    <td><?php echo $oldFund["fund_wallet"]; ?></td>
                    <td><?php echo $oldFund["fund_amount"]; ?></td>
                    <td><?php echo yeniSifreCoz($oldFund["admin_email"]); ?></td>
                    <td><span class="d-none"><?php echo $oldFund["fund_time"]; ?></span><?php echo date("Y-m-d H:i:s", $oldFund["fund_time"]); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php include "include/footer.php"; ?>