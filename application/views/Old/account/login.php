<?php include __DIR__ . "/../include/header.php"; ?>
<?php if ($this->session->userdata('user_email')) {
    redirect('/account');
} ?>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 text-center mb-2 col-xl-5 offset-xl-3">
            <h2><?php echo lang('login'); ?></h2>
        </div>
        <div class="col-12">
            <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 col-xl-5 offset-xl-3">
                <h3 class="font-size-15 ml-3 text-center"> <?php echo lang("warning1"); ?></h3>
                <div class="border border-success logHeader text-center ml-5 mr-5 mb-3 font-size-15">
                    <span class="text-success"><i class="fa fa-lock font-size-13"></i> </span><?php echo siteSetting()["site_url"]; ?>
                </div>
            </div>
            <div class="col-md-8 offset-md-2 col-sm-12 col-lg-6 offset-lg-3 col-xl-5 offset-xl-3">
                <?php if ($this->session->flashdata('extra') == "tekrarmail" && $this->session->flashdata('extra')) { ?>
                    <form action="#" method="post">
                        <div class="col-12 text-center mt-2">
                            <input type="hidden" class="form-control border-left-0" name="temail" placeholder="Email" value="<?php echo $this->session->flashdata('email_onay'); ?>">
                            <button name="tekrarmail" value="tekrarmail" class="btn btn-primary mb-2" type="submit"><?php echo lang('againmail'); ?></button>
                        </div>
                    </form>
                <?php } ?>
                <form id="newForm" action="#" method="POST">
                    <?php
                    if (!empty(validation_errors())) {
                        echo validation_errors('<div class="alert alert-danger" role="alert">', '</div>');
                    } elseif (!empty($this->session->flashdata('hata'))) {
                        echo '<div class="alert alert-danger" id="hata" role="alert">' . $this->session->flashdata('hata') . '</div>';
                    } elseif (!empty($this->session->flashdata('onay'))) {
                        echo '<div class="alert alert-success" id="hata" role="alert">' . $this->session->flashdata('onay') . '</div>';
                    } ?>
                    <!-- <div class="col-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="bg-light input-group-text border-right-0" id="inputGroupPrepend3"><i class="fa fa-envelope"></i></span>
                            </div>
                            <input type="email" class="form-control border-left-0" name="email" placeholder="<?php echo lang('email'); ?>" value="<?php echo set_value('email'); ?>" required>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="bg-light input-group-text border-right-0" id="inputGroupPrepend3"><i class="fa fa-lock"></i></span>
                            </div>
                            <input type="password" class="form-control border-left-0" name="pass" placeholder="<?php echo lang('pass'); ?>" required>
                        </div>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="input-group">
                            <a href="<?php echo base_url(); ?>forgotpassword"><label class="form-label"><?php echo lang('forgotpass'); ?></label></a>
                        </div>
                    </div> -->
                    <div class="col-12 text-right mt-5">
                        <!-- <button name="login" class="btn btn-primary mb-4 btn-block g-recaptcha" data-sitekey="<?php echo siteSetting()["google_recaptcha_key"]; ?>" data-callback='onSubmit' type="submit"><?php echo lang('login'); ?></button> -->
                        <button name="login" onclick="loginWithMetamask()" type="button" class="btn btn-primary mb-4 btn-block g-recaptcha"><?php echo lang('login'); ?> metamask</button>
                    </div>
                    <div class="col-12 mb-3">
                        <div class="input-group text-center">
                            <!-- <label class="form-label font-size-14"><?php echo lang('dontaccount'); ?>  </label><a href="<?php echo base_url("register"); ?>"><label class="form-label ml-2 font-size-14"> <?php echo lang('register'); ?></label></a> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    const apiUrl = '<?php echo base_url(); ?>' + '/api';

    function onSubmit(token) {
        document.getElementById("newForm").submit();
    }

    function auth_request(accountAdress) {
        return fetch(apiUrl + '/auth-request', {
            body: 'address=' + accountAdress,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
            },
            method: 'POST'
        })
    }

    function auth_signature(accountAdress, signature) {
        return fetch(apiUrl + '/auth-signature', {
            body: 'address=' + accountAdress + '&signature=' + signature,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded;charset=UTF-8'
            },
            method: 'POST'
        })
    }

    async function loginWithMetamask() {

        try {
            const accountAddress = await ethereum.request({
                method: 'eth_requestAccounts'
            });
            if (accountAddress.length > 0) {
                let nonce;
                const auth_request_res = await auth_request(accountAddress[0])
                await auth_request_res.json().then((data) => nonce = data.ticket);

                window.web3.eth.personal.sign(
                    window.web3.utils.fromUtf8('starting session: ' + nonce),
                    accountAddress[0]
                ).then(async (signature) => {
                    var auth_signature_res = await auth_signature(accountAddress, signature);
                    await auth_signature_res.json().then((data) => {
                        if (data.status === 'ok') {
                            window.location = '<?php echo base_url(); ?>' + 'market';
                        } else {
                            alert('authentication error');
                        }
                    });

                })
            }
        } catch (err) {
            if (err.code && err.code === -32002) {
                alert('A login process already exists, please check your MetaMask');
                return;
            }
        }
    }
</script>
<?php include __DIR__ . "/../include/footer.php"; ?>