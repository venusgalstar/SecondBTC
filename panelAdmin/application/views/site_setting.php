<?php include "include/header.php"; ?>
<div class="main-content-inner">
    <form action="<?php echo base_url(); ?>home/updateSiteSetting" method="POST">
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
                <div class="col-12 col-lg-4 mt-3">
                    <label for="short">WebSite Name</label>
                    <input type="text" class="form-control form-control-sm" name="site_name" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_name"]; ?>">
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label for="short">WebSite URL</label>
                    <input type="text" class="form-control form-control-sm" name="site_url" placeholder="https://domain.com" value="<?php echo $siteSetting[0]["site_url"]; ?>" required>
                </div>

                <?php if (yetki($_SESSION['user_data_admin'][0]['admin_email']) >= 6) { ?>
                    <div class="col-12 col-lg-4 mt-3">
                        <label for="short">WebSite Support Email<i>(Support mail address.)</i></label>
                        <input type="text" class="form-control form-control-sm" name="site_email_support" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_email_support"]; ?>" required>
                    </div>
                    <div class="col-12 col-lg-4 mt-3">
                        <label for="short">WebSite Support Email Password</label>
                        <input type="password" class="form-control form-control-sm" name="site_email_pass_support" placeholder="Please enter data.." value="<?php echo yeniSifreCoz($siteSetting[0]["site_email_pass_support"]); ?>" required>
                    </div>
                    <div class="col-12 col-lg-4 mt-3">
                        <label for="short">WebSite Info Email<i>(Info mail address.)</i></label>
                        <input type="text" class="form-control form-control-sm" name="site_email" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_email"]; ?>" required>
                    </div>
                    <div class="col-12 col-lg-4 mt-3">
                        <label for="short">WebSite Info Email Password</label>
                        <input type="password" class="form-control form-control-sm" name="site_email_pass" placeholder="Please enter data.." value="<?php echo yeniSifreCoz($siteSetting[0]["site_email_pass"]); ?>" required>
                    </div>
                    <div class="col-12 col-lg-4 mt-3">
                        <label for="short">WebSite Login Code Email<i>(Login mail address.)</i></label>
                        <input type="text" class="form-control form-control-sm" name="site_email_login" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_email_login"]; ?>" required>
                    </div>
                    <div class="col-12 col-lg-4 mt-3">
                        <label for="short">WebSite Login Code Email Password</label>
                        <input type="password" class="form-control form-control-sm" name="site_email_pass_login" placeholder="Please enter data.." value="<?php echo yeniSifreCoz($siteSetting[0]["site_email_pass_login"]); ?>" required>
                    </div>
                    <div class="col-12 col-lg-4 mt-3">
                        <label for="short">WebSite Register Email<i>(Register mail address.)</i></label>
                        <input type="text" class="form-control form-control-sm" name="site_email_register" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_email_register"]; ?>" required>
                    </div>
                    <div class="col-12 col-lg-4 mt-3">
                        <label for="short">WebSite Register Email Password</label>
                        <input type="password" class="form-control form-control-sm" name="site_email_pass_register" placeholder="Please enter data.." value="<?php echo yeniSifreCoz($siteSetting[0]["site_email_pass_register"]); ?>" required>
                    </div>
                    <div class="col-12 col-lg-4 mt-3">
                        <label for="short">WebSite Email Server</label>
                        <input type="text" class="form-control form-control-sm" name="site_email_server" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_email_server"]; ?>" required>
                    </div>
                    <div class="col-12 col-lg-4 mt-3">
                        <label for="system">WebSite Email Security</label>
                        <select name="site_email_ssl" class="custom-select custom-select-sm" required>
                            <option value="<?php echo $siteSetting[0]["site_email_ssl"]; ?>"><?php echo strtoupper($siteSetting[0]["site_email_ssl"]); ?></option>
                            <option value="disable">DISABLE</option>
                            <option value="ssl">SSL</option>
                            <option value="tls">TLS</option>
                        </select>
                    </div>
                    <div class="col-12 col-lg-4 mt-3">
                        <label for="short">WebSite Email Port</label>
                        <input type="number" class="form-control form-control-sm" name="site_email_port" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_email_port"]; ?>" required>
                    </div>
                <?php } ?>
                <div class="col-12 col-lg-8 mt-3">
                    <label for="short">WebSite Description</label>
                    <input type="text" class="form-control form-control-sm" name="site_description" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_description"]; ?>" required>
                </div>
                <div class="col-12 col-lg-6 mt-3">
                    <label for="short">WebSite Meta Tag</label>
                    <input type="text" class="form-control form-control-sm" name="site_meta_etiket" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_meta_etiket"]; ?>" required>
                </div>
                <div class="col-12 col-lg-6 mt-3">
                    <label for="short">WebSite Title</label>
                    <input type="text" class="form-control form-control-sm" name="site_title" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_title"]; ?>" required>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label for="short">Google Listing Form</label>
                    <input type="text" class="form-control form-control-sm" name="site_google_form" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_google_form"]; ?>" required>
                </div>
                <div class="col-12 col-lg-4 mt-3 <?php if (yetki($_SESSION['user_data_admin'][0]['admin_email']) < 5) {
                                                        echo 'd-none';
                                                    } ?>">
                    <label for="short">Wallet Server URL</label>
                    <input type="text" class="form-control form-control-sm" name="site_wallet_server" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_wallet_server"]; ?>" required>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label for="short">WebSite Facebook</label>
                    <input type="text" class="form-control form-control-sm" name="site_facebook" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_facebook"]; ?>" required>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label for="short">WebSite Twitter</label>
                    <input type="text" class="form-control form-control-sm" name="site_twitter" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_twitter"]; ?>" required>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label for="short">WebSite Instagram</label>
                    <input type="text" class="form-control form-control-sm" name="site_instagram" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_instagram"]; ?>" required>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label for="short">WebSite Telegram</label>
                    <input type="text" class="form-control form-control-sm" name="site_telegram" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_telegram"]; ?>" required>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label for="short">WebSite Coinmarketcap</label>
                    <input type="text" class="form-control form-control-sm" name="site_coinmarketcap" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_coinmarketcap"]; ?>" required>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label for="short">WebSite Coingecko</label>
                    <input type="text" class="form-control form-control-sm" name="site_coingecko" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_coingecko"]; ?>" required>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label for="short">Company Address</label>
                    <input type="text" class="form-control form-control-sm" name="site_address" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_address"]; ?>" required>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label for="site_tel">Company Phone Number</label>
                    <input type="text" class="form-control form-control-sm" name="site_tel" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["site_tel"]; ?>" required>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label for="site_tel">Google reCAPTCHA Site Key</label>
                    <input type="text" class="form-control form-control-sm" name="google_recaptcha_key" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["google_recaptcha_key"]; ?>" required>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label for="site_tel">Google reCAPTCHA Secret Key</label>
                    <input type="password" class="form-control form-control-sm" name="google_recaptcha_secret" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["google_recaptcha_secret"]; ?>" required>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label for="site_status">WebSite Status</label>
                    <select name="site_status" class="custom-select custom-select-sm" required>
                        <option value="<?php echo $siteSetting[0]["site_status"]; ?>"><?php if ($siteSetting[0]["site_status"] == 1) {
                                                                                            echo "Normal Mode";
                                                                                        } else {
                                                                                            echo "Maintenance Mode";
                                                                                        } ?></option>
                        <option value="1">Normal Mode</option>
                        <option value="0">Maintenance Mode</option>
                    </select>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label for="site_tel">Google Analytics Key</label>
                    <input type="text" class="form-control form-control-sm" name="google_analytics_key" placeholder="Please enter data.." value="<?php echo $siteSetting[0]["google_analytics_key"]; ?>" required>
                </div>
                <div class="col-12 col-lg-4 mt-3">
                    <label for="site_default_lang">Default Language</label>
                    <select name="site_default_lang" class="custom-select custom-select-sm" required>
                        <option value="<?php echo $siteSetting[0]["site_default_lang"]; ?>"><?php echo strtoupper($siteSetting[0]["site_default_lang"]); ?></option>
                        <option value="en">EN</option>
                        <option value="tr">TR</option>
                        <option value="ru">RU</option>
                    </select>
                </div>
                <div class="col-12 mt-5">
                    <div for="site_aboutus" class="font-size-18"><b>Company About Us</b></div>
                    <textarea name="site_aboutus" class="form-control" id="site_aboutus" rows="10"><?php echo $siteSetting[0]["site_aboutus"]; ?></textarea>
                </div>
                <div class="col-12 mt-5">
                    <div for="site_termsofuse" class="font-size-18"><b>Terms Of Use</b></div>
                    <textarea name="site_termsofuse" id="site_termsofuse" rows="50" cols="150"><?php echo $siteSetting[0]["site_termsofuse"]; ?></textarea>
                </div>
                <div class="col-12 mt-5">
                    <label for="site_privacypolicy" class="font-size-18"><b>Privacy Policy</b></label>
                    <textarea name="site_privacypolicy" id="site_privacypolicy" rows="50" cols="150"><?php echo $siteSetting[0]["site_privacypolicy"]; ?></textarea>
                </div>
                <div class="col-12 mt-5">
                    <div for="site_listing_about" class="font-size-18"><b>Site Listing About</b></div>
                    <textarea name="site_listing_about" id="site_listing_about" rows="50" cols="150"><?php echo $siteSetting[0]["site_listing_about"]; ?></textarea>
                </div>



                <div class="col-12 col-lg-4 mt-3">
                    <button class="btn btn-primary" name="saveSetting">Save Setting</button>
                </div>
            </div>
        </div>
    </form>
</div>
<?php include "include/footer.php"; ?>