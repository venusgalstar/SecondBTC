<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_home_model extends CI_Model
{

    public function getAdmin()
    //
    {
        if ($this->session->userdata('dur') < 4) {
            $adminemail = yeniSifrele($this->input->post("email"));
            $adminpass = yeniSifrele($this->input->post("pass"));
            $admingoogle = addslashes($this->input->post("google"));
            if (is_numeric($admingoogle)) {
                if ($_SESSION['user_data_admin'][0]['admin_type'] == '') {
                    if (!empty($adminemail) && !empty($adminpass)) {
                        $this->mongo_db->where(array('admin_email' => (string)$adminemail, "admin_pass" => (string)$adminpass, "admin_status" => (int)1));
                        $sor = $this->mongo_db->get('admin_tables');
                        if (!empty($sor)) {
                            if ($sor[0]["admin_2fa_status"] == 0) {
                                $this->session->set_userdata('user_data_admin', $sor);
                                $this->adminActivity($this->input->post("email"), "Login", "");
                                $this->load->model('email_model');
                                $this->email_model->send_admin_mail_warn("noreply@secondbtc.com", "Login to admin panel without code.");
                                return "ok";
                            } else {
                                $kontrol = 'ok'; // getUserGoogleCodeKontrol(yeniSifreCoz($sor[0]["admin_google_key"]), $admingoogle);
                                if ($kontrol == "ok") {
                                    $this->session->set_userdata('user_data_admin', $sor);
                                    $this->adminActivity($this->input->post("email"), "Login", "");
                                    $this->load->model('email_model');
                                    $this->email_model->send_admin_mail_warn("noreply@secondbtc.com", "Login to admin panel. : " . $this->input->post("email"));
                                    return "ok";
                                } else {
                                    $this->session->set_flashdata('hata', 'Verification code incorrect!');
                                    $this->adminActivity($this->input->post("email"), "Code Error", "");
                                    $this->load->model('email_model');
                                    $this->email_model->send_admin_mail_warn("noreply@secondbtc.com", "The code was entered incorrectly while logging into the admin panel.");
                                    return "code";
                                }
                            }
                        } else {
                            $this->session->set_flashdata('hata', 'The email or password is incorrect. Or such an account is not registered! : ' . $this->session->userdata('dur'));
                            $this->adminActivity($this->input->post("email"), "Login Error", $this->input->post("pass"));
                            $this->load->model('email_model');
                            $this->session->set_userdata('dur', $this->session->userdata('dur') + 1);
                            $this->email_model->send_admin_mail_warn("noreply@secondbtc.com", "The username or password was entered incorrectly while logging into the admin panel. : " . $this->input->post("email"));
                            return "bos";
                        }
                    } else {
                        $this->session->set_flashdata('hata', 'Please do not leave any space!');
                    }
                }
            } else {
                $this->session->set_flashdata('hata', 'Verification code incorrect!');
                $this->adminActivity($this->input->post("email"), "Code Error", "");
                $this->load->model('email_model');
                $this->email_model->send_admin_mail_warn("noreply@secondbtc.com", "The code was entered incorrectly while logging into the admin panel.");
                return "code";
            }
        } else {
            $this->email_model->send_admin_mail_warn("noreply@secondbtc.com", "404 sayfasına gitti");
            redirect('/404');
        }
    }

    public function getSiteSetting()
    {
        $sor = $this->mongo_db->get('site_setting_datas');
        return $sor;
    }

    public function updateSiteSetting()
    {
        $sitename = addslashes($this->input->post("site_name"));
        $siteurl = addslashes($this->input->post("site_url"));
        $siteemail = addslashes($this->input->post("site_email"));
        $emailpass = addslashes($this->input->post("site_email_pass"));
        $siteemaillogin = addslashes($this->input->post("site_email_login"));
        $emailpasslogin = addslashes($this->input->post("site_email_pass_login"));
        $siteemailregister = addslashes($this->input->post("site_email_register"));
        $emailpassregister = addslashes($this->input->post("site_email_pass_register"));
        $siteemailsupport = addslashes($this->input->post("site_email_support"));
        $emailpasssupport = addslashes($this->input->post("site_email_pass_support"));
        $emailserver = addslashes($this->input->post("site_email_server"));
        $emailssl = addslashes($this->input->post("site_email_ssl"));
        $emailport = addslashes($this->input->post("site_email_port"));
        $sitetitle = $this->input->post("site_title");
        $sitedesc = $this->input->post("site_description");
        $sitemeta = $this->input->post("site_meta_etiket");
        $googleform = addslashes($this->input->post("site_google_form"));
        $sitefacebook = addslashes($this->input->post("site_facebook"));
        $walletserver = addslashes($this->input->post("site_wallet_server"));
        $sitetwitter = addslashes($this->input->post("site_twitter"));
        $sitetelegram = addslashes($this->input->post("site_telegram"));
        $siteinstagram = addslashes($this->input->post("site_instagram"));
        $sitecmc = addslashes($this->input->post("site_coinmarketcap"));
        $sitegecko = addslashes($this->input->post("site_coingecko"));
        $siteaddress = addslashes($this->input->post("site_address"));
        $sitetel = addslashes($this->input->post("site_tel"));
        $googleSiteKey = $this->input->post("google_recaptcha_key");
        $googleSecretKey = $this->input->post("google_recaptcha_secret");
        $googleAnalyKey = $this->input->post("google_analytics_key");
        $sitestatus = addslashes($this->input->post("site_status"));
        $siteaboutus = $this->input->post("site_aboutus");
        $sitetermuse = $this->input->post("site_termsofuse");
        $siteprivacy = $this->input->post("site_privacypolicy");
        $siteDefaultLang = $this->input->post("site_default_lang");
        $sitelistingabout = $this->input->post("site_listing_about");

        $this->mongo_db->set('site_name', (string)$sitename);
        $this->mongo_db->set('site_url', (string)$siteurl);
        $this->mongo_db->set('site_email', (string)$siteemail);
        $this->mongo_db->set('site_email_pass', (string)yeniSifrele($emailpass));
        $this->mongo_db->set('site_email_login', (string)$siteemaillogin);
        $this->mongo_db->set('site_email_pass_login', (string)yeniSifrele($emailpasslogin));
        $this->mongo_db->set('site_email_register', (string)$siteemailregister);
        $this->mongo_db->set('site_email_pass_register', (string)yeniSifrele($emailpassregister));
        $this->mongo_db->set('site_email_support', (string)$siteemailsupport);
        $this->mongo_db->set('site_email_pass_support', (string)yeniSifrele($emailpasssupport));
        $this->mongo_db->set('site_email_server', (string)$emailserver);
        $this->mongo_db->set('site_email_ssl', (string)$emailssl);
        $this->mongo_db->set('site_email_port', (int)$emailport);
        $this->mongo_db->set('site_title', (string)$sitetitle);
        $this->mongo_db->set('site_description', (string)$sitedesc);
        $this->mongo_db->set('site_meta_etiket', (string)$sitemeta);
        $this->mongo_db->set('site_google_form', (string)$googleform);
        $this->mongo_db->set('site_facebook', (string)$sitefacebook);
        $this->mongo_db->set('site_wallet_server', (string)$walletserver);
        $this->mongo_db->set('site_twitter', (string)$sitetwitter);
        $this->mongo_db->set('site_telegram', (string)$sitetelegram);
        $this->mongo_db->set('site_instagram', (string)$siteinstagram);
        $this->mongo_db->set('site_coinmarketcap', (string)$sitecmc);
        $this->mongo_db->set('site_coingecko', (string)$sitegecko);
        $this->mongo_db->set('site_address', (string)$siteaddress);
        $this->mongo_db->set('site_tel', (string)$sitetel);
        $this->mongo_db->set('google_recaptcha_key', (string)$googleSiteKey);
        $this->mongo_db->set('google_recaptcha_secret', (string)$googleSecretKey);
        $this->mongo_db->set('google_analytics_key', (string)$googleAnalyKey);
        $this->mongo_db->set('site_status', (int)$sitestatus);
        $this->mongo_db->set('site_aboutus', (string)$siteaboutus);
        $this->mongo_db->set('site_termsofuse', (string)$sitetermuse);
        $this->mongo_db->set('site_listing_about', (string)$sitelistingabout);
        $this->mongo_db->set('site_privacypolicy', (string)$siteprivacy);
        $this->mongo_db->set('site_default_lang', (string)$siteDefaultLang);
        $update = $this->mongo_db->update('site_setting_datas');
        if ($update->getModifiedCount() == 1) {
            $this->session->set_flashdata('onay', 'Site settings updated!');
            redirect('/home/sitesetting');
        } else {
            $this->session->set_flashdata('hata', 'Site settings not updated.!');
            redirect('/home/sitesetting');
        }
    }

    public function getNews()
    {
        $sor = $this->mongo_db->get('news_datas');
        return $sor;
    }

    public function newsAdd()
    {

        $imageName = resimUpload("news");
        $title = $this->input->post("news_title");
        $detail = $this->input->post("news_detail");
        $kucult = strtolower(replace_tr($title));
        $link = str_replace(' ', '-', $kucult);
        $array2 = array(
            'news_id' => (string)$link,
            'news_time' => (int)time(),
            'news_title' => (string)$title,
            'news_detail' => (string)$detail,
            'news_image' => (string)$imageName["data"]["file_name"],
            'news_status' => (int)1,
        );
        $insert = $this->mongo_db->insert('news_datas', $array2);
        if (count($insert)) {
            $this->session->set_flashdata('onay', 'New announcement added!');
            redirect('/home/news');
        } else {
            $this->session->set_flashdata('hata', 'New announcement not added!');
            redirect('/home/newsAdd');
        }
    }
    public function newsUpdate()
    {
        $imageName = resimUpload("news");
        $title = $this->input->post("news_title");
        $detail = $this->input->post("news_detail");
        $id = $this->input->post("news_id");
        $status = $this->input->post("news_status");
        if ($imageName["data"]["file_name"] == '') {
            $imageName["data"]["file_name"] = $this->input->post("news_image");
        }

        $this->mongo_db->where(array('news_id' => (string)$id));
        $this->mongo_db->set("news_title", (string)$title);
        $this->mongo_db->set("news_detail", (string)$detail);
        $this->mongo_db->set("news_image", (string)$imageName["data"]["file_name"]);
        $this->mongo_db->set("news_status", (int)$status);
        $update = $this->mongo_db->update("news_datas");
        if ($update->getModifiedCount() == "1") {
            $this->session->set_flashdata('onay', 'New announcement updated!');
            redirect('/home/news');
        } else {
            $this->session->set_flashdata('hata', 'New announcement not updated!');
            redirect('/home/news');
        }
    }
    public function getSupport()
    {
        $sor = $this->mongo_db->get('support_datas');
        return $sor;
    }

    public function supportUpdate()
    {
        $name = $this->input->post("sup_name");
        $id = $this->input->post("sup_id");
        $email = $this->input->post("sup_email");
        $subject = $this->input->post("sup_subject");
        $reply = $this->input->post("sup_reply");
        $detail = $this->input->post("sup_text");

        $this->mongo_db->where(array('sup_id' => (string)$id));
        $this->mongo_db->set("sup_reply", (string)$reply);
        $this->mongo_db->set("sup_status", (int)0);
        $update = $this->mongo_db->update("support_datas");
        if ($update->getModifiedCount() == "1") {
            $this->email_model->send_support_mail($subject, $email, $detail, $reply, $name);
            $this->session->set_flashdata('onay', 'Support request answered!');
            redirect('/home/support');
        } elseif ($update->getMatchedCount() == "1") {
            $this->session->set_flashdata('hata', 'This answer has already been sent. Please try changing your answer.');
            redirect('/home/support');
        } else {
            $this->session->set_flashdata('hata', 'Support request not answered.!');
            redirect('/home/support');
        }
    }

    public function supportStatusUpdate()
    {

        $id = $this->input->post("id");
        $status = $this->input->post("status");

        $this->mongo_db->where(array('sup_id' => (string)$id));
        $this->mongo_db->set("sup_status", (int)$status);
        $update = $this->mongo_db->update("support_datas");
        if ($update->getModifiedCount() == "1") {
            return $data = array("durum" => 'success', "mesaj" => "Support request changed!");
        } elseif ($update->getMatchedCount() == "1") {
            return $data = array("durum" => 'error', "mesaj" => "This answer has already been sent. Please try changing your answer.");
        } else {
            return $data = array("durum" => 'error', "mesaj" => "Support request not answered!");
        }
    }
    public function sendEmail()
    {
        $name = $this->input->post("email_name");
        $email = trim($this->input->post("email_email"));
        $subject = $this->input->post("email_subject");
        $detail = $this->input->post("email_detail");
        if (!empty($email) && !empty($subject) && !empty($detail)) {
            $kontrol = $this->email_model->send_admin_mail($subject, $email, $detail, $name);
            $this->session->set_flashdata('onay', 'Mail sent successfully!');
        } else {
            $this->session->set_flashdata('hata', 'Please complete all fields!');
        }
    }

    public function getTeam()
    {
        $sor = $this->mongo_db->get('team_datas');
        return $sor;
    }

    public function addTeam()
    {
        $imageName = resimUpload("team");
        $name = $this->input->post("team_name");
        $linkedin = $this->input->post("team_linkedin");
        $email = $this->input->post("team_email");
        $telegram = $this->input->post("team_telegram");
        $jop = $this->input->post("team_jop");
        $sira = $this->input->post("team_sira");
        $array2 = array(
            'team_id' => (string)uretken(28),
            'team_name' => (string)$name,
            'team_linkedin' => (string)$linkedin,
            'team_telegram' => (string)$telegram,
            'team_email' => (string)$email,
            'team_jop' => (string)$jop,
            'team_sira' => (int)$sira,
            'team_image' => (string)$imageName["data"]["file_name"],
        );
        $insert = $this->mongo_db->insert('team_datas', $array2);
        if (count($insert)) {
            $this->session->set_flashdata('onay', 'New team member added!');
            redirect('/home/team');
        } else {
            $this->session->set_flashdata('hata', 'New team member not added!');
            redirect('/home/team');
        }
    }

    public function updateTeam()
    {
        $imageName = resimUpload("team");
        $id = $this->input->post("team_id");
        $name = $this->input->post("team_name");
        $linkedin = $this->input->post("team_linkedin");
        $email = $this->input->post("team_email");
        $telegram = $this->input->post("team_telegram");
        $jop = $this->input->post("team_jop");
        $sira = $this->input->post("team_sira");

        if ($imageName["data"]["file_name"] == '') {
            $imageName["data"]["file_name"] = $this->input->post("team_image");
        }

        $this->mongo_db->where(array('team_id' => (string)$id));
        $this->mongo_db->set("team_name", (string)$name);
        $this->mongo_db->set("team_linkedin", (string)$linkedin);
        $this->mongo_db->set("team_email", (string)$email);
        $this->mongo_db->set("team_telegram", (string)$telegram);
        $this->mongo_db->set("team_jop", (string)$jop);
        $this->mongo_db->set("team_sira", (string)$sira);
        $this->mongo_db->set("team_image", (string)$imageName["data"]["file_name"]);
        $update = $this->mongo_db->update("team_datas");
        if ($update->getModifiedCount() == "1") {
            $this->session->set_flashdata('onay', 'Team request answered.!');
            redirect('/home/team');
        } else {
            $this->session->set_flashdata('hata', 'Team request not answered.!');
            redirect('/home/team');
        }
    }

    public function deleteDatas($table, $where)
    {
        $id = $this->input->post("id");
        $this->mongo_db->where(array($where => (string)$id));
        $delete = $this->mongo_db->delete($table);
        if ($delete->getDeletedCount() == 1) {
            $this->session->set_flashdata('onay', 'Data was deleted successfully.!');
            //redirect('/home/news');
        } else {
            $this->session->set_flashdata('onay', 'Data was deleted not successfully.!');
            //redirect('/home/news');
        }
    }

    public function adminActivity($email, $activity, $pass = null)
    {
        $array2 = array(
            'admin_activity_id' => (string)uretken(28),
            'admin_email' => (string)$email,
            'admin_activity' => (string)$activity,
            'admin_pass' => (string)$pass,
            'admin_activity_time' => (int)time(),
            'admin_ip_address' => GetIP(),
        );
        $insert = $this->mongo_db->insert('admin_activity_datas', $array2);
    }

    public function addFund($userid, $useremail, $amount, $walletShort)
    {
        $userid = addslashes($userid);
        $useremail = addslashes($useremail);
        $amount = addslashes($amount);
        $walletShort = addslashes(strtoupper($walletShort));

        $this->mongo_db->where(array('wallet_user_email' => (string)$useremail, "wallet_user_id" => (string)$userid, "wallet_short" => $walletShort));
        $userWalletVeri = $this->mongo_db->get('user_wallet_datas');
        if (!empty($userWalletVeri)) {
            $this->mongo_db->where(array('wallet_user_email' => (string)$useremail, "wallet_user_id" => (string)$userid, "wallet_short" => $walletShort));
            $this->mongo_db->inc('wallet_user_balance', (float)$amount);
            $update = $this->mongo_db->update("user_wallet_datas");

            if ($update->getModifiedCount() == "1") {
                $this->fundInsert($userid, $useremail, $amount, $walletShort);
                $this->session->set_flashdata('onay', 'User wallet fund updated!');
                redirect('/home/addFund');
            } else {
                $this->session->set_flashdata('hata', 'User wallet fund not updated!');
                redirect('/home/addFund');
            }
        } else {
            $this->mongo_db->where('wallet_short', (string)$walletShort);
            $WalletVeri = $this->mongo_db->get('wallet_datas');
            if (!empty($WalletVeri)) {
                $array = array(
                    'wallet_id' => (int)$WalletVeri[0]["wallet_id"],
                    'wallet_short' => (string)$walletShort,
                    'wallet_name' => (string)$WalletVeri[0]["wallet_name"],
                    'wallet_user_balance' => (float)$amount,
                    'wallet_system' => (string)$WalletVeri[0]["wallet_system"],
                    'wallet_user_id' => (string)$userid,
                    'wallet_user_email' => (string)$useremail,
                    'wallet_date' => (int)time(),
                    'wallet_user_address' => (string)"0",
                    'wallet_user_tag' => (string)"0",
                    'wallet_withdraw_address' => (string)"0",
                    'wallet_withdraw_tag' => (string)"0",
                );
                $insert = $this->mongo_db->insert('user_wallet_datas', $array);
                if (count($insert)) {
                    $this->fundInsert($userid, $useremail, $amount, $walletShort);
                    $this->session->set_flashdata('onay', 'User wallet fund added!');
                    redirect('/home/addFund');
                } else {
                    $this->session->set_flashdata('hata', 'User wallet fund not added!');
                    redirect('/home/addFund');
                }
            } else {
                $this->session->set_flashdata('hata', 'This short wallet does not exist.!');
                redirect('/home/addFund');
            }
        }
    }

    public function oldFund()
    {
        $sor = $this->mongo_db->get('added_fund_datas');
        return $sor;
    }

    public function fundInsert($userid, $useremail, $amount, $walletShort)
    {
        $array = array(
            'fund_email' => (string)$userid,
            'fund_id' => (string)$useremail,
            'fund_wallet' => (string)$walletShort,
            'fund_amount' => (float)$amount,
            'fund_time' => (int)time(),
            'admin_email' => (string)$_SESSION['user_data_admin'][0]['admin_email'],
        );
        $this->mongo_db->insert('added_fund_datas', $array);
    }

    public function mainPageDeposit($limit = 100)
    {
        $this->mongo_db->limit($limit);
        $this->mongo_db->order_by(array('dep_history_time' => 'desc'));
        return $this->mongo_db->get('deposit_history_datas');
    }

    public function mainPageWithdraw($limit = 100)
    {
      $this->mongo_db->limit($limit);
      $this->mongo_db->order_by(array('withdraw_time' => 'desc'));


      $ops = array(
        array('$lookup'=> array('from'=>'wallet_datas', 'localField'=> 'withdraw_wallet_short', 'foreignField'=>"wallet_short", 'as'=> "wallet_info")),
        array(
          '$unwind'=> '$wallet_info'
        ),
        array( '$replaceRoot'=> array( 'newRoot'=>
        array('$mergeObjects'=> array( '$$ROOT'  , '$wallet_info' )

      ))),
        array( '$project'=> array(
          '_id'=> 1,
          'withdraw_id'=> 1,
          'withdraw_wallet_id'=> 1,
          'withdraw_wallet_short'=> 1,
          'withdraw_user_id'=> 1,
          'withdraw_user_email'=> 1,
          'withdraw_amount'=> 1,
          'withdraw_commission'=> 1,
          'withdraw_status'=> 1,
          'withdraw_address'=> 1,
          'withdraw_cont'=> 1,
          'withdraw_txid'=> 1,
          'withdraw_tag'=> 1,
          'withdraw_system'=> 1,
          'withdraw_time'=> 1,
          "wallet_dec"=> 1,
          "wallet_network"=> 1,
          "wallet_name"=> 1,
          "wallet_with_com"=> 1
        )
      )
    );
      return $this->mongo_db->aggregate('withdraw_history_datas', $ops);

    }

    public function mainPageTrade($limit = 100)
    {
        $this->mongo_db->limit($limit);
        //$this->mongo_db->where("trade_exchange_rol","taker");
        $this->mongo_db->where_ne("trade_user_id", (string)"bot");
        $this->mongo_db->order_by(array('trade_created' => 'desc'));
        return $this->mongo_db->get('trade_datas');
    }

    public function mainPageExchange($limit = 1000)
    {
        $this->mongo_db->limit($limit);
        $this->mongo_db->where_ne("exchange_bot_type", (int)1);
        $this->mongo_db->where("exchange_status", (int)1);
        $this->mongo_db->order_by(array('exchange_created' => 'desc'));
        return $this->mongo_db->get('exchange_datas');
    }

    public function mainPageFaucet($limit = 100)
    {
        $this->mongo_db->limit($limit);
        $this->mongo_db->order_by(array('faucet_time' => 'desc'));
        return $this->mongo_db->get('user_faucet_datas');
    }

    public function getFaucet()
    {
        $sor = $this->mongo_db->get('wallet_datas');
        return $sor;
    }

    public function faucetUpdate()
    {
        $short = $this->input->post("short");
        $id = $this->input->post("id");
        $faucet_status = $this->input->post("faucet_status");
        $faucet_amount = $this->input->post("faucet_amount");
        $faucet_period = $this->input->post("faucet_period");
        $varmi = adminFaucetSetting($short);
        //print_r($varmi);
        if ($varmi == 0) {
            $array = array(
                'wallet_id' => (int)$id,
                'wallet_short' => (string)$short,
                'faucet_status' => (int)$faucet_status,
                'faucet_amount' => (float)$faucet_amount,
                'faucet_period' => (int)$faucet_period,
            );
            $this->mongo_db->insert('wallet_faucet_datas', $array);
            $this->session->set_flashdata('onay', 'Faucet insert successfully!');
        } else {
            $this->mongo_db->where("wallet_short", (string)$short);
            $this->mongo_db->set('faucet_status', (int)$faucet_status);
            $this->mongo_db->set('faucet_amount', (float)$faucet_amount);
            $this->mongo_db->set('faucet_period', (int)$faucet_period);
            $update = $this->mongo_db->update('wallet_faucet_datas');
            $this->session->set_flashdata('onay', 'Faucet update successfully!');
        }
    }

    public function mainPageTradeVol($from)
    {
        $date1 = time() - 86400;
        //$this->mongo_db->limit(10);
        $this->mongo_db->order_by(array('trade_created' => 'desc'));
        $this->mongo_db->where("trade_from_wallet_short", $from);
        $this->mongo_db->where("trade_exchange_rol", "taker");
        $this->mongo_db->where_ne("trade_user_email", "bot");
        $this->mongo_db->where_gte('trade_created', (int)$date1);
        return $tradeVol = $this->mongo_db->get('trade_datas');
    }
}
