<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_wallet_model extends CI_Model
{

    public function getWalletInfo($short)
    {
        $short = addslashes($short);
        $this->mongo_db->where(array('wallet_short' => $short));
        $sor = $this->mongo_db->get('wallet_datas');
        if (!empty($sor)) {
            return $sor;
        } else {
            return "bos";
        }
    }

    public function getAllMarket()
    {
        $this->mongo_db->order_by(array('from_wallet_short' => 'desc'));
        $sor = $this->mongo_db->get('market_datas');
        if (!empty($sor)) {
            return $sor;
        } else {
            return $sor;
        }
    }

    public function getWallet($short)
    {
        $short = addslashes($short);
        $this->mongo_db->where(array('wallet_short' => (string)$short));
        $sor = $this->mongo_db->get('wallet_datas');
        $this->mongo_db->where(array('wallet_short' => (string)$short));
        $sor2 = $this->mongo_db->get('wallet_info_datas');
        if (!empty($sor2)) {
            $walletInfo = $sor2[0];
        } else {
            $walletInfo = [];
        }
        $this->mongo_db->where_ne('wallet_main_pairs', 0);
        $sor3 = $this->mongo_db->get('wallet_datas');
        if (!empty($sor)) {
            $sor[0]["wallet_server_port"] = yeniSifreCoz($sor[0]["wallet_server_port"]);
            $sor[0]["wallet_server_username"] = yeniSifreCoz($sor[0]["wallet_server_username"]);
            $sor[0]["wallet_server_pass"] = yeniSifreCoz($sor[0]["wallet_server_pass"]);
            $sor[0]["wallet_password"] = yeniSifreCoz($sor[0]["wallet_password"]);
            $sor[1] = $walletInfo;
            $sor[2] = $sor3;
            return $sor;
        } else {
            return "bos";
        }
    }

    public function updateWallet($short, $satir, $veri, $type)
    {
        $short = addslashes($short);
        $satir = addslashes($satir);
        if ($satir == "wallet_buy_com") {
            if ($veri == 0 || $veri == '') {
                $veri = 1;
                $veri2 = 1;
            } else {
                $bol = $veri / 100;
                $veri2 = 1 - $bol;
                $veri = Number(($veri / 100) + 1, 5);
            }
            $this->mongo_db->where(array('wallet_short' => (string)$short));
            $this->mongo_db->set("wallet_buy_com", (float)$veri);
            $this->mongo_db->set("wallet_sell_com", (float)$veri2);
            $update = $this->mongo_db->update("wallet_datas");
        } else {
            $this->mongo_db->where(array('wallet_short' => (string)$short));
            if ($type == "2") {
                $this->mongo_db->set($satir, (float)$veri);
                $update = $this->mongo_db->update("wallet_datas");
            } elseif ($type == "3") {
                $this->mongo_db->set($satir, (int)$veri);
                $update = $this->mongo_db->update("wallet_datas");
            } else {
                $this->mongo_db->set($satir, $veri);
                $update = $this->mongo_db->update("wallet_datas");
            }
            if ($satir == "wallet_name") {
                $this->mongo_db->where(array('wallet_short' => (string)$short));
                $this->mongo_db->set("wallet_name", (string)$veri);
                $update2 = $this->mongo_db->update("user_wallet_datas");

                $this->mongo_db->where(array('to_wallet_short' => (string)$short));
                $this->mongo_db->set("to_wallet_name", (string)$veri);
                $update3 = $this->mongo_db->update("market_datas");

                $this->mongo_db->where(array('wallet_short' => (string)$short));
                $this->mongo_db->set("wallet_info_name", (string)$veri);
                $update4 = $this->mongo_db->update("wallet_info_datas");
            } elseif ($satir == "wallet_system") {
                $this->mongo_db->where(array('wallet_short' => (string)$short));
                $this->mongo_db->set("wallet_system", (string)$veri);
                $update4 = $this->mongo_db->update("user_wallet_datas");
            } elseif ($satir == "wallet_status") {
                $this->mongo_db->where(array('to_wallet_short' => (string)$short));
                $this->mongo_db->set("wallet_status", (int)$veri);
                $update4 = $this->mongo_db->update_all("market_datas");
            }
        }

        if ($update->getModifiedCount() == "1") {
            return "ok";
        } else {
            return "hata";
        }
    }

    public function updateWalletInfo($short, $satir, $veri, $type)
    {
        $short = addslashes($short);
        $satir = addslashes($satir);
        $veri = $veri;
        $this->mongo_db->where(array('wallet_short' => (string)$short));
        if ($type == "2") {
            $veri = (float)$veri;
        } elseif ($type == "3") {
            $veri = (int)$veri;
        } else {
            $veri = (string)$veri;
        }

        $this->mongo_db->set($satir, $veri);
        $update = $this->mongo_db->update("wallet_info_datas");

        if ($update->getModifiedCount() == "1") {
            return "ok";
        } else {
            return "hata";
        }
    }

    public function walletMarketUpdate($short, $toshort, $veri, $walletID, $toWalletID, $toWalletName, $pairId)
    {
        $short = addslashes($short);
        $toshort = addslashes($toshort);
        $veri = $veri;
        $this->mongo_db->where(array('from_wallet_short' => (string)$short, 'to_wallet_short' => (string)$toshort));
        $sor = $this->mongo_db->get('market_datas');
        if (!empty($sor)) {
            $this->mongo_db->where(array('from_wallet_short' => (string)$short, 'to_wallet_short' => (string)$toshort));
            $this->mongo_db->set("market_pair_id", (int)$pairId);
            $this->mongo_db->set("market_status", (int)$veri);
            $update = $this->mongo_db->update("market_datas");
            if ($update->getModifiedCount() == "1") {
                return "ok";
            } else {
                return "hata";
            }
        } else {
            $veri = array(
                'from_wallet_id' => (int)$walletID,
                'from_wallet_short' => (string)$short,
                'to_wallet_id' => (int)$toWalletID,
                'to_wallet_short' => (string)$toshort,
                'to_wallet_name' => (string)$toWalletName,
                'market_pair_id' => (int)$pairId,
                'to_wallet_last_price' => (float)0,
                'to_wallet_last_trade_date' => (int)time(),
                'market_status' => (int)1,
                'change' => "0.00",
                'to_wallet_24h_vol' => (float)0,
                'to_wallet_24h_quote_vol' => (float)0,
                'to_wallet_24_high' => (float)0,
                'to_walet_24_low' => (float)0,
                'wallet_status' => (float)1
            );
            $insert = $this->mongo_db->insert('market_datas', $veri);
            if (count($insert)) {
                return "ok";
            } else {
                return "hata";
            }
        }
    }

    public function walletMarketUpdateDecimal($short, $toshort, $priceDecimal, $amountDecimal, $totalDecimal)
    {
        $short = addslashes($short);
        $toshort = addslashes($toshort);
        $this->mongo_db->where(array('from_wallet_short' => (string)$short, 'to_wallet_short' => (string)$toshort));
        $sor = $this->mongo_db->get('market_datas');
        if (!empty($sor)) {
            $this->mongo_db->where(array('from_wallet_short' => (string)$short, 'to_wallet_short' => (string)$toshort));
            $this->mongo_db->set("market_priceDecimal", (int)$priceDecimal);
            $this->mongo_db->set("market_amountDecimal", (int)$amountDecimal);
            $this->mongo_db->set("market_totalDecimal", (int)$totalDecimal);
            $update = $this->mongo_db->update("market_datas");
            if ($update->getModifiedCount() == "1") {
                return "ok";
            } else {
                return "hata";
            }
        } else {
            return "hata";
        }
    }
    public function walletIDSor()
    {
        $this->mongo_db->order_by(array('wallet_id' => 'desc'));
        $sor = $this->mongo_db->get('wallet_datas');
        return $sor[0]["wallet_id"];
    }

    public function insertWallet($walletID, $walletShort, $walletName, $walletSystem, $walletNetwork)
    {
        $walletShort = strtoupper($walletShort);
        $this->mongo_db->where(array('wallet_short' => (string)$walletShort));
        $sor = $this->mongo_db->get('wallet_datas');
        if (!empty($sor)) {
            $this->session->set_flashdata('hata', $walletShort . '  wallet already exists. Please change "Wallet Short"!');
            return "hata";
        } else {
            $array = array(
                'wallet_id' => (int)$walletID,
                'wallet_name' => (string)$walletName,
                'wallet_short' => (string)$walletShort,
                'wallet_dec' => (int)1,
                'wallet_cont' => (string)0,
                'wallet_status' => (int)0,
                'wallet_ex_status' => (int)0,
                'wallet_dep_status' => (int)0,
                'wallet_with_status' => (int)0,
                'wallet_buy_com' => (float)1,
                'wallet_sell_com' => (float)1,
                'wallet_dep_com' => (float)0,
                'wallet_with_com' => (float)0,
                'wallet_min_with' => (float)0,
                'wallet_max_with' => (float)0,
                'wallet_min_dep' => (float) 0,
                'wallet_max_dep' => (float) 0,
                'wallet_min_unit' => (float) 0.0001,
                'wallet_min_total' => (float) 0.0001,
                'wallet_min_bid' => (float) 0.00000001,
                'wallet_conf' => (int)20,
                'wallet_main_pairs' => (int)0,
                'wallet_system' => $walletSystem,
                'wallet_logo' => "wallet.png",
                'wallet_balance' => (float)0,
                'wallet_tag_system' => (int)0,
                'wallet_server_port' => '0',
                'wallet_server_username' => '0',
                'wallet_server_pass' => '0',
                'wallet_password' => '0',
                'wallet_pass' => '0',
                'wallet_status_time' => time(),
                'wallet_network' => $walletNetwork
            );
            $insert = $this->mongo_db->insert('wallet_datas', $array);

            $array2 = array(
                'wallet_info_id' => (int)$walletID,
                'wallet_short' => (string)$walletShort,
                'wallet_info_name' => (string)$walletName,
                'wallet_info_website' => "...",
                'wallet_info_explorer' => "...",
                'wallet_info_chat' => "...",
                'wallet_info_social' => "...",
                'wallet_info_cmc' => "...",
                'wallet_info_maxsub' => "...",
                'wallet_info' => "...",
            );
            $insert2 = $this->mongo_db->insert('wallet_info_datas', $array2);
            if (count($insert) && count($insert2)) {
                $this->session->set_flashdata('onay', 'New wallet insert success. Edit all settings on the wallet list page !');
                redirect('/wallet/addwallet');
            } else {
                $this->session->set_flashdata('hata', 'New wallet insert error!');
                return "hata";
            }
        }
    }

    public function withdrawConfirm($walletInfo, $withid, $withuserid, $withuseremail, $withtxid, $withamount, $withaddress, $withcont, $withtag, $walletShort, $googleCode)
    {
        $this->mongo_db->where(array('wallet_user_address' => $withaddress, 'wallet_user_tag' => $withtag, "wallet_short" => $walletShort));
        $sor = $this->mongo_db->get('user_wallet_datas');
        if ($withtxid != '') {
            $array = array(
                'withdraw_id' => (string)$withid,
                'withdraw_user_id' => (string)$withuserid,
                'withdraw_user_email' => (string)$withuseremail,
                'withdraw_address' => (string)$withaddress
            );
            $this->mongo_db->where($array);
            $this->mongo_db->set('withdraw_txid', (string)$withtxid);
            $this->mongo_db->set('withdraw_status', (int)1);
            $update = $this->mongo_db->update('withdraw_history_datas');
            if ($update->getModifiedCount() == 1) {
                return array("txid" => $withtxid, "error" => null);
            } else {
                return array("txid" => $withtxid, "error" => null);
            }
        } elseif (!empty($sor)) {
            $array = array(
                'withdraw_id' => (string)$withid,
                'withdraw_user_id' => (string)$withuserid,
                'withdraw_user_email' => (string)$withuseremail,
                'withdraw_address' => (string)$withaddress
            );
            $timee = time();
            $this->mongo_db->where($array);
            $this->mongo_db->set('withdraw_txid', "Bitexlive Internal Transfer. Transfer ID : Bitexlive-" . $timee);
            $this->mongo_db->set('withdraw_status', (int)1);
            $update = $this->mongo_db->update('withdraw_history_datas');
            if ($update->getModifiedCount() == 1) {
                $this->mongo_db->where(array('wallet_user_address' => (string)$withaddress, 'wallet_user_id' => (string)$sor[0]["wallet_user_id"], 'wallet_user_email' => (string)$sor[0]["wallet_user_email"], "wallet_short" => (string)$walletShort));
                $this->mongo_db->inc('wallet_user_balance', (float)$withamount);
                $update = $this->mongo_db->update('user_wallet_datas');
                if ($update->getModifiedCount() == 1) {
                    $veri = array(
                        'dep_history_id' => (string)uretken(28),
                        'dep_history_address' => (string)$withaddress,
                        'dep_history_txid' => (string)"Bitexlive Internal Transfer. Transfer ID : Bitexlive-" . $timee,
                        'dep_history_wallet_short' => (string)$walletShort,
                        'dep_history_user_id' => (string)$sor[0]["wallet_user_id"],
                        'dep_history_user_email' => (string)$sor[0]["wallet_user_email"],
                        'dep_history_comfirmation' => (int)1,
                        'dep_history_amount' => (float)$withamount,
                        'dep_history_time' => (int)time(),
                        'dep_history_system' => (string)$sor[0]["wallet_system"],
                        'dep_history_tag' => (string)$sor[0]["wallet_user_tag"],
                        'dep_history_status' => (int)1,
                    );
                    $insert = $this->mongo_db->insert('deposit_history_datas', $veri);
                    if (count($insert)) {
                        return array("txid" => "Bitexlive Internal Transfer. Transfer ID : Bitexlive-" . $timee, "error" => null);
                    } else {
                        return array("txid" => null, "error" => "Internal transfer error! The user's deposit was not registered : Bitexlive-" . $timee);
                    }
                } else {
                    return array("txid" => null, "error" => "Internal transfer error! Internal transfer error! The user's deposit account has not been processed. : Bitexlive-" . $timee);
                }
            }
        } else {
            if ($walletShort == "XRP") {
                return "ripple";
            } else {
                $this->load->model('admin_router_model');
                $result = $this->admin_router_model->sendTransaction(
                    trim($withaddress),
                    trim($withcont),
                    trim($withtag),
                    $withamount,
                    $walletShort,
                    $googleCode,
                    $walletInfo[0]["wallet_dec"],
                    $walletInfo[0]["wallet_server_port"],
                    $walletInfo[0]["wallet_server_username"],
                    $walletInfo[0]["wallet_server_pass"],
                    $walletInfo[0]["wallet_system"],
                    $walletInfo[0]["wallet_password"]
                );
                if ($result["txid"] != null) {
                    $array = array(
                        'withdraw_id' => (string)$withid,
                        'withdraw_user_id' => (string)$withuserid,
                        'withdraw_user_email' => (string)$withuseremail,
                        'withdraw_address' => (string)$withaddress
                    );
                    $this->mongo_db->where($array);
                    $this->mongo_db->set('withdraw_txid', $result["txid"]);
                    $this->mongo_db->set('withdraw_status', (int)1);
                    $update = $this->mongo_db->update('withdraw_history_datas');
                }
                return $result;
            }
        }
    }

    public function confirmWithdrawMetamask($walletInfo, $withid, $withuserid, $withuseremail, $withtxid, $withamount, $withaddress, $withcont, $withtag, $walletShort, $googleCode)
    {
        // $this->mongo_db->where(array('wallet_user_address' => $withaddress, 'wallet_user_tag' => $withtag, "wallet_short" => $walletShort));
        // $sor = $this->mongo_db->get('user_wallet_datas');
        // withtxid = transaction id
        if ($withtxid != '') {
            $array = array(
                'withdraw_id' => (string)$withid,
                'withdraw_user_id' => (string)$withuserid,
                'withdraw_user_email' => (string)$withuseremail,
                'withdraw_address' => (string)$withaddress
            );
            $this->mongo_db->where($array);
            $this->mongo_db->set('withdraw_txid', (string)$withtxid);
            $this->mongo_db->set('withdraw_status', (int)1);
            $update = $this->mongo_db->update('withdraw_history_datas');
            if ($update->getModifiedCount() == 1) {
                return array("txid" => $withtxid, "error" => null);
            } else {
                return array("txid" => $withtxid, "error" => "could not confirm Withdraw, try again");
            }
        }else{
          return array("txid" => null, "error" => "TxID field required");
        }
        // } elseif (!empty($sor)) {
        //     $array = array(
        //         'withdraw_id' => (string)$withid,
        //         'withdraw_user_id' => (string)$withuserid,
        //         'withdraw_user_email' => (string)$withuseremail,
        //         'withdraw_address' => (string)$withaddress
        //     );
        //     $timee = time();
        //     $this->mongo_db->where($array);
        //     $this->mongo_db->set('withdraw_txid', "Bitexlive Internal Transfer. Transfer ID : Bitexlive-" . $timee);
        //     $this->mongo_db->set('withdraw_status', (int)1);
        //     $update = $this->mongo_db->update('withdraw_history_datas');
        //     if ($update->getModifiedCount() == 1) {
        //         $this->mongo_db->where(array('wallet_user_address' => (string)$withaddress, 'wallet_user_id' => (string)$sor[0]["wallet_user_id"], 'wallet_user_email' => (string)$sor[0]["wallet_user_email"], "wallet_short" => (string)$walletShort));
        //         $this->mongo_db->inc('wallet_user_balance', (float)$withamount);
        //         $update = $this->mongo_db->update('user_wallet_datas');
        //         if ($update->getModifiedCount() == 1) {
        //             $veri = array(
        //                 'dep_history_id' => (string)uretken(28),
        //                 'dep_history_address' => (string)$withaddress,
        //                 'dep_history_txid' => (string)"Bitexlive Internal Transfer. Transfer ID : Bitexlive-" . $timee,
        //                 'dep_history_wallet_short' => (string)$walletShort,
        //                 'dep_history_user_id' => (string)$sor[0]["wallet_user_id"],
        //                 'dep_history_user_email' => (string)$sor[0]["wallet_user_email"],
        //                 'dep_history_comfirmation' => (int)1,
        //                 'dep_history_amount' => (float)$withamount,
        //                 'dep_history_time' => (int)time(),
        //                 'dep_history_system' => (string)$sor[0]["wallet_system"],
        //                 'dep_history_tag' => (string)$sor[0]["wallet_user_tag"],
        //                 'dep_history_status' => (int)1,
        //             );
        //             $insert = $this->mongo_db->insert('deposit_history_datas', $veri);
        //             if (count($insert)) {
        //                 return array("txid" => "Bitexlive Internal Transfer. Transfer ID : Bitexlive-" . $timee, "error" => null);
        //             } else {
        //                 return array("txid" => null, "error" => "Internal transfer error! The user's deposit was not registered : Bitexlive-" . $timee);
        //             }
        //         } else {
        //             return array("txid" => null, "error" => "Internal transfer error! Internal transfer error! The user's deposit account has not been processed. : Bitexlive-" . $timee);
        //         }
        //     }
        //} else {
        //    if ($walletShort == "XRP") {
        //        return "ripple";
        //    } else {
        //        $this->load->model('admin_router_model');
        //        $result = $this->admin_router_model->sendTransaction(
        //            trim($withaddress),
        //            trim($withcont),
        //            trim($withtag),
        //            $withamount,
        //            $walletShort,
        //            $googleCode,
        //            $walletInfo[0]["wallet_dec"],
        //            $walletInfo[0]["wallet_server_port"],
        //            $walletInfo[0]["wallet_server_username"],
        //            $walletInfo[0]["wallet_server_pass"],
        //            $walletInfo[0]["wallet_system"],
        //            $walletInfo[0]["wallet_password"]
        //        );
        //        if ($result["txid"] != null) {
        //            $array = array(
        //                'withdraw_id' => (string)$withid,
        //                'withdraw_user_id' => (string)$withuserid,
        //                'withdraw_user_email' => (string)$withuseremail,
        //                'withdraw_address' => (string)$withaddress
        //            );
        //            $this->mongo_db->where($array);
        //            $this->mongo_db->set('withdraw_txid', $result["txid"]);
        //            $this->mongo_db->set('withdraw_status', (int)1);
        //            $update = $this->mongo_db->update('withdraw_history_datas');
        //        }
        //        return $result;
        //    }
        //}
    }

    public function fiatDepositConfirm($email, $userid, $depid, $islemcode, $walletShort)
    {
        $this->mongo_db->where(array('wallet_user_id' => (string)$userid, 'wallet_user_email' => (string)$email, "wallet_short" => (string)$walletShort));
        $sor = $this->mongo_db->get('user_wallet_datas');
        $this->mongo_db->where(array('dep_history_user_id' => $userid, 'dep_history_user_email' => (string)$email, "dep_history_wallet_short" => (string)$walletShort, "dep_history_txid" => (string)$islemcode));
        $sorDeposit = $this->mongo_db->get('deposit_history_datas');
        if (!empty($sor)) {
            $array = array(
                'dep_history_id' => (string)$depid,
                'dep_history_user_id' => (string)$userid,
                'dep_history_user_email' => (string)$email,
                'dep_history_txid' => (string)$islemcode,
                'dep_history_wallet_short' => (string)$walletShort,
                'dep_history_status' => (int)0,
            );
            $this->mongo_db->where($array);
            $this->mongo_db->set('dep_history_comfirmation', (int)1);
            $this->mongo_db->set('dep_history_status', (int)1);
            $update = $this->mongo_db->update('deposit_history_datas');
            if ($update->getModifiedCount() == 1) {
                $this->mongo_db->where(array('wallet_user_id' => (string)$userid, 'wallet_user_email' => (string)$email, "wallet_short" => (string)$walletShort));
                $this->mongo_db->inc('wallet_user_balance', (float)$sorDeposit[0]["dep_history_amount"]);
                $update2 = $this->mongo_db->update('user_wallet_datas');
                if ($update2->getModifiedCount() == 1) {
                    return "ok";
                } else {
                    return "bakiye";
                }
            } else {
                return " Update 1 çalışmadı";
            }
        } else {
            return "hata";
        }
    }

    public function getWithdrawInfo($withid, $withuserid)
    {
        $this->mongo_db->where(array('withdraw_id' => (string)$withid, "withdraw_user_id" => (string)$withuserid));
        $sor = $this->mongo_db->get('withdraw_history_datas');
        if (!empty($sor)) {
            return $sor;
        } else {
            return $sor;
        }
    }

    public function getWithdrawCancel($withid, $withuserid, $withaddress, $withtxid, $withamount, $coinShort)
    {
        $this->mongo_db->where(array('withdraw_address' => (string)$withaddress, 'withdraw_id' => (string)$withid, 'withdraw_user_id' => (string)$withuserid));
        $this->mongo_db->set('withdraw_txid', (string)$withtxid);
        $this->mongo_db->set('withdraw_status', (int)2);
        $update = $this->mongo_db->update('withdraw_history_datas');
        if ($update->getModifiedCount() == 1) {
            $withdrawInfo = $this->getWithdrawInfo($withid, $withuserid);

                $amount = $withamount + $withdrawInfo[0]["withdraw_commission"];
                $this->mongo_db->where(array('wallet_user_id' => (string)$withuserid, 'wallet_short' => (string)$coinShort));
                $this->mongo_db->inc('wallet_user_balance', (float)$amount);
                $update2 = $this->mongo_db->update('user_wallet_datas');
            
            return "ok";
        } else {
            return "notok";
        }
    }

    public function getWithdrawDelete($withid, $withuserid, $withtxid)
    {
        if ($withtxid == '') {
            $withtxid = "The withdrawal was deleted.";
        }
        $this->mongo_db->where(array('withdraw_id' => (string)$withid, 'withdraw_user_id' => (string)$withuserid));
        $this->mongo_db->set('withdraw_txid', (string)$withtxid);
        $this->mongo_db->set('withdraw_status', (int)3);
        $update = $this->mongo_db->update('withdraw_history_datas');
        if ($update->getModifiedCount() == 1) {
            return "ok";
        }
    }

    public function allwalletchange($sutun, $deger, $type)
    {
        $sor = $this->mongo_db->get('wallet_datas');
        foreach ($sor as $sor) {
            $this->mongo_db->where(array('wallet_short' => (string)$sor["wallet_short"], 'wallet_id' => (int)$sor["wallet_id"]));
            if ($type == "2") {
                $this->mongo_db->set($sutun, (float)$deger);
            } else {
                $this->mongo_db->set($sutun, (int)$deger);
            }
            $update = $this->mongo_db->update('wallet_datas');
        }
        return "ok";
    }

    public function fiat($walletShort)
    {
        $this->mongo_db->where(array('fiat_short' => (string)$walletShort));
        $sor = $this->mongo_db->get('banka_datas');
        if (!empty($sor)) {
            return $sor;
        } else {
            return "bos";
        }
    }
    public function walletBankUpdate($bankid, $status)
    {
        $this->mongo_db->where(array('banka_id' => (string)$bankid));
        $this->mongo_db->set('banka_status', (int)$status);
        $update = $this->mongo_db->update('banka_datas');
        if ($update->getModifiedCount() == 1) {
            return "ok";
        }
    }
    public function walletDepositChange($veriID, $veri, $type, $sutun, $userID)
    {
        if ($type == 1) {
            $veri = (string)$veri;
        } elseif ($type == 2) {
            $veri = (int)$veri;
        } elseif ($type == 3) {
            $veri = (float)$veri;
        }
        $this->mongo_db->where(array('dep_history_id' => (string)$veriID, 'dep_history_user_id' => (string)$userID));
        $this->mongo_db->set($sutun, $veri);
        $update = $this->mongo_db->update("deposit_history_datas");
        if ($update->getModifiedCount() == 1) {
            return "ok";
        }
    }

    public function deleteFiatDeposit()
    {
        $this->mongo_db->where_lte('dep_history_time', (time() - 86400));
        $this->mongo_db->where(array('dep_history_system' => 'fiat', 'dep_history_status' => 0));
        $delete = $this->mongo_db->delete_all('deposit_history_datas');
        if ($delete->getDeletedCount() == 1) {
            return "ok";
        }
    }

    public function cancelOpenOrder($email, $userID, $orderID, $time)
    {

        $array = array(
            'exchange_id' => (string)$orderID,
            'exchange_created' => (int)$time,
            'exchange_user_id' => (string)$userID,
            'exchange_user_email' => (string)$email,
            'exchange_status' => (int)1
        );

        $this->mongo_db->where($array);
        $order = $this->mongo_db->get('exchange_datas');
        if (!empty($order)) {
            if ($order[0]["exchange_type"] == "buy") {
                $iade = ($order[0]["exchange_bid"] * $order[0]["exchange_unit"]) * $order[0]["exchange_comission"];
                $walletID = $order[0]["exchange_from_wallet_id"];
            } elseif ($order[0]["exchange_type"] == "sell") {
                $iade = $order[0]["exchange_unit"];
                $walletID = $order[0]["exchange_to_wallet_id"];
            } else {
                return array('durum' => 'error', 'mesaj' => 'error 204');
            }
            $array2Up = array(
                'exchange_id' => (string)$orderID,
                'exchange_created' => (int)$time,
                'exchange_user_id' => (string)$userID,
                'exchange_user_email' => (string)$email,
                'exchange_status' => (int)1
            );
            $this->mongo_db->where($array2Up);
            $this->mongo_db->set('exchange_status', (int)0);
            $this->mongo_db->set('exchange_completed', (int)time());
            $cancel = $this->mongo_db->update('exchange_datas');

            if ($cancel->getModifiedCount() == 1) {
                $this->mongo_db->where(array('wallet_user_id' => (string)$userID, 'wallet_user_email' => (string)$email, 'wallet_id' => (int)$walletID));
                $this->mongo_db->inc('wallet_user_balance', $iade);
                $kontrol = $this->mongo_db->update('user_wallet_datas');
                if ($kontrol->getModifiedCount() == 1) {
                    return array('durum' => 'success', 'mesaj' => 'An open order was successfully canceled.');
                }
                return array('durum' => 'error', 'mesaj' => 'error 205');
            }
            return array('durum' => 'error', 'mesaj' => 'error 206');
        } else {
            return array('durum' => 'error', 'mesaj' => 'error 207');
        }
    }

    public function walletTotalResult($walletShort)
    {
        $this->mongo_db->where(array("withdraw_wallet_short" => (string)$walletShort, "withdraw_status" => 1));
        $withdraw = $this->mongo_db->get('withdraw_history_datas');

        $this->mongo_db->where(array("withdraw_wallet_short" => (string)$walletShort, "withdraw_status" => 0));
        $withdrawP = $this->mongo_db->get('withdraw_history_datas');

        $this->mongo_db->where(array("dep_history_wallet_short" => (string)$walletShort, "dep_history_status" => 1));
        $deposit = $this->mongo_db->get('deposit_history_datas');

        $this->mongo_db->where_not_in("exchange_user_email", array("and.tode@yahoo.ro", "bot"));
        $this->mongo_db->where(array("exchange_to_short" => (string)$walletShort, "exchange_status" => 1, "exchange_type" => (string)"sell"));
        $openorderTo = $this->mongo_db->get('exchange_datas');

        $this->mongo_db->where_not_in("exchange_user_email", array("and.tode@yahoo.ro", "bot"));
        $this->mongo_db->where(array("exchange_from_short" => (string)$walletShort, "exchange_status" => 1, "exchange_type" => (string)"buy"));
        $openorderFrom = $this->mongo_db->get('exchange_datas');

        $this->mongo_db->where(array("wallet_short" => (string)$walletShort));
        $userWallet = $this->mongo_db->get('user_wallet_datas');

        if (!empty($withdraw)) {
            $withdrawTotal = 0;
            foreach ($withdraw as $withdraw) {
                $withdrawTotal = $withdrawTotal + $withdraw["withdraw_amount"];
            }
        } else {
            $withdrawTotal = 0;
        }

        if (!empty($withdrawP)) {
            $withdrawTotalP = 0;
            foreach ($withdrawP as $withdrawP) {
                $withdrawTotalP = $withdrawTotalP + $withdrawP["withdraw_amount"];
            }
        } else {
            $withdrawTotalP = 0;
        }

        if (!empty($deposit)) {
            $depositTotal = 0;
            foreach ($deposit as $deposit) {
                $depositTotal = $depositTotal + $deposit["dep_history_amount"];
            }
        } else {
            $depositTotal = 0;
        }

        if (!empty($openorderTo)) {
            $openorderToTotal = 0;
            foreach ($openorderTo as $openorderTo) {
                $openorderToTotal = $openorderToTotal + $openorderTo["exchange_unit"];
            }
        } else {
            $openorderToTotal = 0;
        }

        if (!empty($openorderFrom)) {
            $openorderFromTotal = 0;
            foreach ($openorderFrom as $openorderFrom) {
                $openorderFromTotal = $openorderFromTotal + (($openorderFrom["exchange_bid"] * $openorderFrom["exchange_unit"]) * $openorderFrom["exchange_comission"]);
            }
        } else {
            $openorderFromTotal = 0;
        }

        if (!empty($userWallet)) {
            $userWalletTotal = 0;
            foreach ($userWallet as $userWallet) {
                $userWalletTotal = $userWalletTotal + $userWallet["wallet_user_balance"];
            }
        } else {
            $userWalletTotal = 0;
        }

        $data["withdraw"] = $withdrawTotal;
        $data["withdrawP"] = $withdrawTotalP;
        $data["deposit"] = $depositTotal;
        $data["openorder"] = $openorderToTotal + $openorderFromTotal;
        $data["userwallet"] = $userWalletTotal;
        return $data;
    }

    public function walletUserBalance($walletShort)
    {
        $this->mongo_db->where(array("wallet_short" => (string)$walletShort));
        $userWallet = $this->mongo_db->get('user_wallet_datas');
        return $userWallet;
    }

    public function deleteDeposit($depId)
    {
        if (!empty($depId)) {
            $this->mongo_db->where(array('dep_history_id' => (string)$depId));
            $delete = $this->mongo_db->delete('deposit_history_datas');
            if ($delete->getDeletedCount() == 1) {
                return "ok";
            }
        } else {
            return "not";
        }
    }
}
