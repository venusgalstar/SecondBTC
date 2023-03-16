<?php include "include/header.php"; ?>
<?php if ($_SESSION['user_data_admin'][0]['admin_type'] != "administrator") {
    $disabled = "disabled";
} else {
    $disabled = "";
} ?>
<div class="main-content-inner-2">
    <div class="mt-5">
        <?php
        if (!empty($this->session->flashdata('hata'))) {
            echo '<div class="alert alert-danger" id="hata" role="alert">' . $this->session->flashdata('hata') . '</div>';
        } elseif (!empty($this->session->flashdata('onay'))) {
            echo '<div class="alert alert-success" id="hata" role="alert">' . $this->session->flashdata('onay') . '</div>';
        } ?>
    </div>
    <div class="row">
        <!-- data table start -->
        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Admin List</h4>
                    <div class="data-tables">
                        <table id="adminDataTable" class="text-center">
                            <thead class="bg-light text-capitalize">
                                <tr>
                                    <th>Admin Email</th>
                                    <th>Admin Pass</th>
                                    <th>Google Key</th>
                                    <th>Admin Type</th>
                                    <th>Admin Status</th>
                                    <th>Admin Google Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($admin as $admin) {
                                    $email = $admin['admin_email'];
                                    $randCode = emailCode(); ?>
                                    <tr>
                                        <td><?php if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 10 || $_SESSION['user_data_admin'][0]['admin_email'] == $email) {
                                                echo  yeniSifreCoz($admin["admin_email"]);
                                            } else {
                                                echo "********";
                                            } ?></td>

                                        <td id="admin_pass"><?php if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 10) {
                                                                echo  yeniSifreCoz($admin["admin_pass"]);
                                                            } else {
                                                                echo "********";
                                                            } ?>
                                            <a href="#" class="font-size-12 m-2" onclick="customJS.admin.adminUpdate('<?php echo $email; ?>',1,'admin_pass')">Change</a>
                                        </td>

                                        <td id="admin_google_key"><?php if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 10 || $_SESSION['user_data_admin'][0]['admin_email'] == $email) {
                                                                        echo "<a href='#'  onclick=customJS.admin.barkodeModal('" . $randCode . "')>" . yeniSifreCoz($admin["admin_google_key"]) . "</a>";
                                                                    } else {
                                                                        echo "********";
                                                                    } ?>
                                            <input type="hidden" id="<?php echo $randCode; ?>" value="<?php echo $this->googleauthenticator->getQRCodeGoogleUrl(siteSetting()["site_name"], yeniSifreCoz($admin["admin_email"]), yeniSifreCoz($admin["admin_google_key"])); ?>">
                                            <a href="#" class="font-size-12 m-2" onclick="customJS.admin.adminUpdate('<?php echo $email; ?>',1,'admin_google_key')">Change</a>
                                        </td>

                                        <td><?php if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 10 || $_SESSION['user_data_admin'][0]['admin_email'] == $email) { ?>
                                                <select onchange="customJS.admin.adminUpdate('<?php echo $email; ?>',2,this.id)" id="admin_yetki">
                                                    <option value="<?php echo $admin["admin_yetki"]; ?>"><?php echo $admin["admin_yetki"]; ?></option>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
                                            <?php } else {
                                                echo "********";
                                            } ?>
                                        </td>
                                        <td><?php if ($admin["admin_status"] == 1) {
                                                $status = "ON";
                                            } else {
                                                $status = 'OFF';
                                            } ?>
                                            <select onchange="customJS.admin.adminUpdate('<?php echo $email; ?>',2,this.id)" id="admin_status">
                                                <option value="<?php echo $status; ?>"><?php echo $status; ?></option>
                                                <option value="0">OFF</option>
                                                <option value="1">ON</option>
                                            </select>
                                        </td>
                                        <td><?php if ($admin["admin_2fa_status"] == 1) {
                                                $status2 = "ON";
                                            } else {
                                                $status2 = 'OFF';
                                            } ?>
                                            <select onchange="customJS.admin.adminUpdate('<?php echo $email; ?>',2,this.id)" id="admin_2fa_status">
                                                <option value="<?php echo $status2; ?>"><?php echo $status2; ?></option>
                                                <option value="0">OFF</option>
                                                <option value="1">ON</option>
                                            </select>
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
    <?php if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 6) { ?>
        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Admin Activity</h4>
                        <div class="data-tables">
                            <table id="adminActivityTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>Admin Email</th>
                                        <th>Entered incorrectly</th>
                                        <th>Admin Activity</th>
                                        <th>Activity Date</th>
                                        <th>Admin IP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($adminAct as $adminAct) { ?>
                                        <tr>
                                            <td><?php echo $adminAct["admin_email"]; ?></td>
                                            <td><?php echo $adminAct["admin_pass"]; ?></td>
                                            <td><?php echo $adminAct["admin_activity"]; ?></td>
                                            <td><?php echo date("Y-m-d H:i:s", $adminAct["admin_activity_time"]); ?></td>
                                            <td><?php echo $adminAct["admin_ip_address"]; ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
</div>
<div class="modal fade" id="barcodeModal">
    <div class="modal-dialog modal-lg" style="max-width: max-content;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <div class="modal-body">
                <img id="imageBarcodeGor" src="" width="100%">
            </div>
        </div>
    </div>
</div>
<?php include "include/footer.php"; ?>