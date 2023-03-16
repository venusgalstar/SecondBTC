<?php include "include/header.php"; ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>

<link rel="stylesheet" href="<?php echo base_url(); ?>assets/home/css/2fa.css">

<style>
    .btn {
        border-radius: 2px;
        background: transparent;
        border-width: 1px;
    }
</style>

<?php

if ($user_google_conf == 1) {

    $disabled = "";
    $gotitle = "";

    $gobaslik = lang("disable") . " 2FA";

    $gosayfa = "twofad";
} else {

    $disabled = "disabled";

    $gotitle = "(Verify Two-Factor (2FA))";

    $gobaslik = lang("enable") . " 2FA";

    $gosayfa = "twofa";
}

if ($user_with_conf == "M") {
    $MWsecim = "selected";
} else {
    $MWsecim = "";
}

if ($user_with_conf == "G") {
    $GWsecim = "selected";
} else {
    $GWsecim = "";
}

if ($user_login_conf == "M") {
    $MLsecim = "selected";
} else {
    $MLsecim = "";
}

if ($user_login_conf == "G") {
    $GLsecim = "selected";
} else {
    $GLsecim = "";
}



?>

<div class="container">

    <div class="row mt-5">

        <div class="col-6">
            <h2 class="font-size-17"><?php echo lang("accountpage"); ?></h2>
        </div>

    </div>

    <div class="row" id="myGroup">

        <div class="col-12">

            <nav class="navbar col-md-6 offset-md-3 col-sm-12">

                <ul class="navbar-nav w-100">

                    <li class="nav-item  mb-2">

                        <a class="nav-link btn btn-primary" data-toggle="collapse" href="#options-tab" role="button" aria-expanded="false" aria-controls="collapseExample"><?php echo lang("securityop"); ?></a>

                    </li>

                    <li class="nav-item  mb-2">

                        <a class="nav-link btn btn-primary" data-toggle="collapse" href="#info-tab" role="button" aria-expanded="false" aria-controls="collapseExample"><?php echo lang("basicform"); ?></a>

                    </li>

                    <li class="nav-item  mb-2">

                        <a class="nav-link btn btn-primary" data-toggle="collapse" href="#pass-tab" role="button" aria-expanded="false" aria-controls="collapseExample"><?php echo lang("passchange"); ?></a>

                    </li>

                    <!--<li class="nav-item  mb-2">

                    <a class="nav-link btn btn-primary" data-toggle="collapse" href="#address-tab" role="button" aria-expanded="false" aria-controls="collapseExample">WITHDRAW ADDRESS</a>

                    </li>-->

                    <li class="nav-item mb-2">

                        <a class="nav-link btn btn-primary" data-toggle="collapse" href="#ip-tab" role="button" aria-expanded="false" aria-controls="collapseExample"><?php echo lang("ipwhitelist"); ?></a>

                    </li>

                    <li class="nav-item mb-2">

                        <a class="nav-link btn btn-primary" data-toggle="collapse" href="#<?= $gosayfa ?>-tab" role="button" aria-expanded="false" aria-controls="collapseExample"><?php echo $gobaslik; ?></a>

                    </li>

                </ul>

            </nav>

            <?php

            if (!empty($this->session->flashdata('hata'))) {

                echo '<div class="alert alert-danger text-center" id="hata" role="alert">' . $this->session->flashdata('hata') . '</div>';
            } elseif (!empty($this->session->flashdata('onay'))) {

                echo '<div class="alert alert-success text-center" id="hata" role="alert">' . $this->session->flashdata('onay') . '</div>';
            } ?>

        </div>

        <div class="col-12 col-md-12 mt-5">

            <div class="collapse" id="options-tab" data-parent="#myGroup">

                <div class="card card-body">

                    <table class="table table-hover table-sm">

                        <thead>

                            <tr>

                                <th class="border-bottom-0">
                                    <h3 class="font-size-15"><?php echo lang("email"); ?> :</h3>
                                </th>

                                <td>
                                    <h3 class="font-size-15"><?php echo $_SESSION['user_data'][0]['user_email']; ?></h3>
                                </td>

                            </tr>

                            <tr>

                                <th class="border-bottom-0">
                                    <h3 class="font-size-15"><?php echo lang("lastloginip"); ?> :</h3>
                                </th>

                                <td>
                                    <h3 class="font-size-15"><?php echo $user_act{
                                                                    0}["act_ip"]; ?></h3>
                                </td>

                            </tr>

                        </thead>

                    </table>

                    <div class="input-group mb-3">

                        <div class="input-group-prepend">

                            <button class="btn btn-outline-secondary" type="button"><?php echo lang("withconf"); ?></button>

                        </div>

                        <select class="custom-select" id="inputGroupSelect03" onchange="customJS.account.ConfirmOption('W',this.value)">

                            <option value="M" <?= $MWsecim ?>><?php echo lang("emailconf"); ?></option>

                            <option <?php echo $disabled; ?> <?= $GWsecim ?> value="G"><?php echo lang("2fagoogleaut"); ?> <?php echo $gotitle; ?></option>

                        </select>

                    </div>

                    <div class="input-group mb-3">

                        <div class="input-group-prepend">

                            <button class="btn btn-outline-secondary" type="button"><?php echo lang("loginconf"); ?></button>

                        </div>

                        <select class="custom-select" id="inputGroupSelect03" onchange="customJS.account.ConfirmOption('L',this.value)">

                            <option value="M" <?= $MLsecim ?>><?php echo lang("emailconf"); ?></option>

                            <option <?php echo $disabled; ?> <?= $GLsecim ?> value="G"><?php echo lang("2fagoogleaut"); ?> <?php echo $gotitle; ?></option>

                        </select>

                    </div>

                </div>

            </div>

            <div class="collapse text-center mt-2 mb-5" id="info-tab" data-parent="#myGroup">

                <h3 class="font-size-16"> <?php echo lang("bosluk"); ?>...</h3>

                <div class="col-md-6 offset-md-3 col-sm-12">

                    <?php if (!empty($userInfoDetail)) {
                        $Infodisabled = 'disabled="disabled"';
                    } else {
                        $Infodisabled = '';
                    } ?>

                    <form>

                        <div class="form-group text-left">

                            <label for="user_first_name"><?php echo lang("firsname"); ?> <i>(<?php echo lang("required"); ?>)</i></label>

                            <input type="text" class="form-control" <?= $Infodisabled ?> id="user_first_name" value="<?php if (!empty($userInfoDetail)) {
                                                                                                                            echo $userInfoDetail{
                                                                                                                                0}['user_first_name'];
                                                                                                                        } else {
                                                                                                                            echo '';
                                                                                                                        } ?>">

                            <label for="user_middle_name"><?php echo lang("middlename"); ?> </label>

                            <input type="text" class="form-control" <?= $Infodisabled ?> id="user_middle_name" value="<?php if (!empty($userInfoDetail)) {
                                                                                                                            echo $userInfoDetail{
                                                                                                                                0}['user_middle_name'];
                                                                                                                        } else {
                                                                                                                            echo '';
                                                                                                                        } ?>">

                            <label for="user_last_name"><?php echo lang("lastname"); ?> <i>(<?php echo lang("required"); ?>)</i></label>

                            <input type="text" class="form-control" <?= $Infodisabled ?> id="user_last_name" value="<?php if (!empty($userInfoDetail)) {
                                                                                                                        echo $userInfoDetail{
                                                                                                                            0}['user_last_name'];
                                                                                                                    } else {
                                                                                                                        echo '';
                                                                                                                    } ?>">

                            <label for="user_country"><?php echo lang("country"); ?> <i>(<?php echo lang("required"); ?>)</i></label>

                            <select <?= $Infodisabled ?> class="form-control" <?= $Infodisabled ?> id="user_country">

                                <option value="<?php if (!empty($userInfoDetail)) {
                                                    echo $userInfoDetail{
                                                        0}['user_country'];
                                                } else {
                                                    echo '';
                                                }; ?>"><?php if (!empty($userInfoDetail)) {
                                                            echo $userInfoDetail{
                                                                0}['user_country'];
                                                        } else {
                                                            echo '';
                                                        } ?></option>

                                <?php $ttt = countries();
                                foreach ($ttt as $sehirler => $value) { ?>

                                    <option value="<?php echo $value; ?>"><?php echo $value; ?></option>

                                <?php } ?>

                            </select>

                            <label for="user_city"><?php echo lang("city"); ?> </label>

                            <input type="text" class="form-control" <?= $Infodisabled ?> id="user_city" value="<?php if (!empty($userInfoDetail)) {
                                                                                                                    echo $userInfoDetail{
                                                                                                                        0}['user_city'];
                                                                                                                } else {
                                                                                                                    echo '';
                                                                                                                } ?>">

                            <label for="user_district"><?php echo lang("district"); ?> </label>

                            <input type="text" class="form-control" <?= $Infodisabled ?> id="user_district" value="<?php if (!empty($userInfoDetail)) {
                                                                                                                        echo $userInfoDetail{
                                                                                                                            0}['user_district'];
                                                                                                                    } else {
                                                                                                                        echo '';
                                                                                                                    } ?>">

                            <label for="user_address"><?php echo lang("address"); ?> </label>

                            <input type="text" class="form-control" <?= $Infodisabled ?> id="user_address" value="<?php if (!empty($userInfoDetail)) {
                                                                                                                        echo $userInfoDetail{
                                                                                                                            0}['user_address'];
                                                                                                                    } else {
                                                                                                                        echo '';
                                                                                                                    } ?>">

                            <label for="user_id_number"><?php echo lang("idnumber"); ?> <i>(<?php echo lang("required"); ?>)</i></label>

                            <input type="text" class="form-control" <?= $Infodisabled ?> id="user_id_number" value="<?php if (!empty($userInfoDetail)) {
                                                                                                                        echo $userInfoDetail{
                                                                                                                            0}['user_id_number'];
                                                                                                                    } else {
                                                                                                                        echo '';
                                                                                                                    } ?>">

                            <label for="user_tel"><?php echo lang("telnumber"); ?> <i>(<?php echo lang("required"); ?>)</i></label>

                            <input type="text" class="form-control" <?= $Infodisabled ?> id="user_tel" value="<?php if (!empty($userInfoDetail)) {
                                                                                                                    echo $userInfoDetail{
                                                                                                                        0}['user_tel'];
                                                                                                                } else {
                                                                                                                    echo '';
                                                                                                                } ?>">

                            <label for="user_dogum"><?php echo lang("birthdate"); ?> <i>(<?php echo lang("required"); ?>)</i></label>

                            <input type="text" class="form-control" <?= $Infodisabled ?> id="user_dogum" value="<?php if (!empty($userInfoDetail)) {
                                                                                                                    echo $userInfoDetail{
                                                                                                                        0}['user_dogum'];
                                                                                                                } else {
                                                                                                                    echo '';
                                                                                                                }; ?>">

                        </div>

                        <div class="form-group">

                            <button type="button" <?= $Infodisabled ?> class="btn btn-primary" onclick="customJS.account.userInfoChangeConfirm()" data-toggle="modal" data-target="#infoupdateModal" class="btn btn-primary"><?php echo lang("save"); ?></button>

                        </div>

                    </form>

                </div>

            </div>

            <div class="collapse text-center mt-5 mb-5" id="pass-tab" data-parent="#myGroup">

                <h3 class="font-size-16"> <?php echo lang("warning2"); ?></h3>

                <h3 class="font-size-16"><?php echo lang("warning3"); ?></h3>

                <button id="passchange" onclick="customJS.account.userPassChange()" class="btn btn-primary btn-sm mt-5" type="button"><?php echo lang("sendemail"); ?></button>

            </div>

            <div class="collapse text-center mt-5 mb-5" id="address-tab" data-parent="#myGroup">

                <h3 class="font-size-16"> Parola değişikliği için önce email gönder butonuna tıklayın.</h3>

                <h3 class="font-size-16">Sonra mail adresinize gelen linke tıklayarak şifrenizi değiştirebilirsiniz..</h3>

                <div class="col-md-6 offset-md-3 col-sm-12">

                    <form>

                        <div class="form-group">

                            <label for="exampleFormControlInput1">Adres Tag(Optional) </label>

                            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">

                        </div>

                        <div class="form-group">

                            <label for="exampleFormControlSelect1">Coin/Token Name</label>

                            <select class="form-control" id="exampleFormControlSelect1">

                                <option>Bitcoin (BTC)</option>

                            </select>

                        </div>

                        <div class="form-group">

                            <label for="exampleFormControlInput1">Adres </label>

                            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">

                        </div>

                        <div class="form-group">

                            <button class="btn btn-primary">Save</button>

                        </div>

                    </form>

                </div>

                <div class="col-md-6 offset-md-3 col-sm-12">

                    <table class="table table-hover table-sm">

                        <thead>

                            <tr>

                                <th>Address Name</th>

                                <th>Coin/Token</th>

                                <th>IP Address</th>

                                <th>Cancel</th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <td>Yeni Adres</td>

                                <td>Bitcoin</td>

                                <td>1clşaskjoıahfaşohfaohfe9ıhfaosjhfaofajıdj</td>

                                <td><i class="fa fa-minus-circle text-danger" title="cancel IP"></i></td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="collapse text-center mt-5 mb-5" id="ip-tab" data-parent="#myGroup">

                <h3 class="font-size-16"> <?php echo lang("warning4"); ?></h3>

                <h3 class="font-size-16"><?php echo lang("warning5"); ?> </h3>

                <div class="col-md-6 offset-md-3 col-sm-12">

                    <form>
                        <!--

                        <div class="form-group">

                            <label for="exampleFormControlInput1">IP Address Açıklaması </label>

                            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">

                        </div>-->

                        <div class="form-group">

                            <label for="exampleFormControlInput1"><?php echo lang("lastloginip"); ?> </label>

                            <input type="text" class="form-control" id="user_ip_value" value="<?php echo $user_act{
                                                                                                    0}["act_ip"]; ?>">

                        </div>

                        <div class="form-group">

                            <button type="button" class="btn btn-primary" onclick="customJS.account.userIPChangeConfirm()" data-toggle="modal" data-target="#ipupdateModal" class="btn btn-primary"><?php echo lang("save"); ?></button>

                        </div>

                    </form>

                </div>

                <div class="col-md-6 offset-md-3 col-sm-12">

                    <table class="table table-hover table-sm">

                        <thead>

                            <tr>

                                <!--     <th>Address Name</th>-->

                                <th><?php echo lang("ipaddress"); ?></th>

                                <th><?php echo lang("cancel"); ?></th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <!--       <td>Ev ip</td>-->

                                <td id="userIp"><?php echo $user_ip; ?></td>

                                <td><button class="border-0 bg-white" onclick="customJS.account.userIPChangeConfirm()" type="button" data-toggle="modal" data-target="#ipupdateModalsil"><i class="fa fa-minus-circle text-danger" title="cancel IP"></i></button></td>



                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

            <div class="collapse col-12" id="twofa-tab" data-parent="#myGroup">

                <h2 class="maincontent-title text-center">Two-Factor (2FA) <?php echo lang("confirm"); ?> </h2>

                <div class="maincontent-status"><?php echo lang("status"); ?>:

                    <div class="colorOrange"><?php echo lang("disable"); ?></div>

                </div>

                <div class="maincontent-box">

                    <p class="maincontent-description fa-desc"><?php echo lang("warning6"); ?> </p>

                    <div class="maincontent-item">

                        <span class="maincontent-item_current">1</span>

                        <span class="maincontent-item_text"><?php echo lang("warning7"); ?> </span>

                        <img src="<?php echo base_url(); ?>assets/home/images/other/google-authenticator.png" alt="" width="52">

                        <div class="fa-desc" style="font-size: 12px;">Google Authenticator </div>

                        <ul class="phone-list">

                            <li class="phone-list_item">

                                <a target="_blank" href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2">

                                    <img src="<?php echo base_url(); ?>assets/home/images/other/download-google-store.png" alt="Get it on Google Play">

                                </a>

                            </li>

                            <li class="phone-list_item">

                                <a target="_blank" href="https://itunes.apple.com/tr/app/google-authenticator/id388497605?mt=8">

                                    <img src="<?php echo base_url(); ?>assets/home/images/other/download-apple-store.png" alt="Download on the App Store">

                                </a>

                            </li>

                        </ul>

                    </div>

                    <div class="maincontent-item">

                        <span class="maincontent-item_current">2</span>

                        <span class="maincontent-item_text"><?php echo lang("warning8"); ?> </span>

                        <img src="<?php echo $googleQR; ?>">

                    </div>

                    <div class="maincontent-item">

                        <span class="maincontent-item_current">3</span>

                        <span class="maincontent-item_text"><?php echo lang("warning9"); ?> </span>

                        <div class="fa-desc mt-5" style="font-size: 12px;"></div>

                        <div class="form-group mt-4">

                            <label for="exampleInputEmail1" class="w-90"><?php echo lang("securitykey"); ?></label>

                            <input type="text" id="gokey" class="form-control form-control-sm bg-light" value="<?php echo $user_google_key; ?>" readonly="">

                        </div>

                    </div>

                    <div class="maincontent-item">

                        <span class="maincontent-item_current">4</span>

                        <span class="maincontent-item_text"><?php echo lang("warning10"); ?> </span>

                        <div class="fa-desc mt-5" style="font-size: 12px;">

                            <?php echo lang("warning11"); ?></div>

                        <div class="form-group mt-4">

                            <input type="text" autofocus="autofocus" class="form-control form-control-sm bg-light" maxlength="6" id="google_code" name="google_code" placeholder="<?php echo lang("2facodeenter"); ?>">

                        </div>

                    </div>

                    <button type="button" onclick="customJS.account.usertwofadurum('E')"><?php echo lang("enable"); ?> 2FA</button>

                </div>

            </div>

            <div class="collapse col-12" id="twofad-tab" data-parent="#myGroup">

                <div class="maincontent-status"><?php echo lang("status"); ?>:

                    <span class="text-success"><?php echo lang("active"); ?></span>

                    <button type="button" data-toggle="modal" data-target="#ipupdateModalGoogle"><?php echo lang("disable"); ?> 2FA</button>

                </div>

            </div>

        </div>

        <div class="col-12 mt-5">

            <table class="table table-hover table-sm" id="activity">

                <thead>

                    <tr>

                        <th><?php echo lang("date"); ?></th>

                        <th><?php echo lang("ipaddress"); ?></th>

                        <th><?php echo lang("browser"); ?></th>

                        <th><?php echo lang("activity"); ?></th>

                    </tr>

                </thead>

                <tbody>

                    <?php foreach ($user_act as $user_act) { ?>

                        <tr>

                            <td><?php echo date("Y-m-d H:i:s", $user_act["act_date"]); ?></td>

                            <td><?php echo $user_act["act_ip"]; ?></td>

                            <td><?php echo browser_kisalt($user_act["act_browser"]); ?></td>

                            <td><?php echo $user_act["act_title"]; ?></td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>





<!--modal -->



<div class="modal fade" id="ipupdateModalGoogle" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

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

                    <input autofocus="autofocus" type="number" class="form-control" id="goonay_kodu">

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang("cancel"); ?></button>

                <button type="button" onclick="customJS.account.usertwofadurum('D')" class="btn btn-primary"><?php echo lang("send"); ?></button>

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="ipupdateModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

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

                <button type="button" onclick="customJS.account.userIPChange('kaydet')" class="btn btn-primary"><?php echo lang("send"); ?></button>

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="ipupdateModalsil" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

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

                    <input autofocus="autofocus" type="number" class="form-control" id="onay_kodu2">

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang("cancel"); ?></button>

                <button type="button" onclick="customJS.account.userIPChange('sil')" class="btn btn-primary"><?php echo lang("send"); ?></button>

            </div>

        </div>

    </div>

</div>

<div class="modal fade" id="infoupdateModal" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

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

                    <input autofocus="autofocus" type="number" class="form-control" id="info_onay_kodu">

                </div>

            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo lang("cancel"); ?></button>

                <button type="button" onclick="customJS.account.userInfoChange('kaydet')" class="btn btn-primary"><?php echo lang("send"); ?></button>

            </div>

        </div>

    </div>

</div>

<input type="hidden" id="userSecret" value="<?php echo yeniSifrele($_SESSION['user_data'][0]['user_id']); ?>">

<p class="d-none" id="bosluk"><?php echo lang("bosluk"); ?></p>

<?php include "include/footer.php"; ?>



<script>
    $(document).ready(function() {
        $('#user_dogum').mask('00-00-0000', {
            placeholder: "DD-MM-YYYY"
        });
    });
</script>