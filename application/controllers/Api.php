<?php
defined('BASEPATH') or exit('No direct script access allowed');

use kornrunner\Keccak;

require_once(APPPATH . 'libraries/php-ecrecover/ecrecover_helper.php');


class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //if(siteSetting()["site_status"]!=1 && $_SESSION['key']!="admin_bakim"){redirect('/maintenance');}  
        $this->load->library('encryption');
        dilBul();
    }
    public function index()
    {
        $this->load->view('api');
    }

    public function currencies()
    {
        if (limit(2) == "ok") {
            if ($_GET) {
                $get = addslashes($_GET['filter']);
                $data = $this->api_model->currenciesFilter($get);
            } else {
                $data = $this->api_model->currencies();
            }
            header("Content-type: application/json; charset=utf-8");
            if (!empty($data)) {
                foreach ($data as $data) {
                    if ($data['wallet_system'] == 'fiat') {
                        $isFiat = 1;
                    } else {
                        $isFiat = 0;
                    }
                    $veri['symbol'] = (string)$data['wallet_short'];
                    $veri['name'] = (string)$data['wallet_name'];
                    $veri['isFiat'] = (bool)$isFiat;
                    $veri['canDeposit'] = (bool)$data['wallet_dep_status'];
                    $veri['depositConfirmationCount'] = (int)$data['wallet_conf'];
                    $veri['minDeposit'] = (float)$data['wallet_min_dep'];
                    $veri['canWithdraw'] = (bool)$data['wallet_with_status'];
                    $veri['minWithdrawal'] = (float)$data['wallet_min_with'];
                    $veri['maxWithdrawal'] = (float)$data['wallet_max_with'];
                    if ($_GET["admin"] == "Qwghai78*") {
                        $veri['walletBalance'] = (float)$data['wallet_balance'];
                    }
                    $veri['lastUpdateTimestamp'] = (string)date("Y-m-d H:m:s", ($data['wallet_status_time'] / 1000));
                    $json[] = $veri;
                }
            } else {
                $json["errorDescription"] = "Parameter 'filter' contains invalid value.";
            }
        } else {
            $json["errorDescription"] = limit(2);
        }
        echo $bas = json_encode($json);
    }

    public function tickers()
    {
        if ($_GET) {

            if (limit(1) == "ok") {
                $get = addslashes($_GET['filter']);
                $pairs = explode("_", $get);
                $data = $this->api_model->tickersFilter($pairs[0], $pairs[1]);

                header("Content-type: application/json; charset=utf-8");
                if (!empty($data)) {
                    foreach ($data as $data) {
                        $lowestAsk = $this->api_model->tickerslowestAsk($data['to_wallet_short'], $data['from_wallet_short']);
                        $highestBid = $this->api_model->tickershighestBid($data['to_wallet_short'], $data['from_wallet_short']);
                        if ($data['to_wallet_last_trade_date'] < (time() - 86400)) {
                            $data['to_walet_24_low'] = 0;
                            $data['to_wallet_24_high'] = 0;
                            $data['to_wallet_24h_vol'] = 0;
                            $data['to_wallet_24h_quote_vol'] = 0;
                            $data['change'] = 0;
                        }
                        $veri['tradingPairs'] = (string)$data['to_wallet_short'] . '_' . $data['from_wallet_short'];
                        $veri['LastPrice'] = (float)$data['to_wallet_last_price'];
                        $veri['percentChange'] = (float)$data['change'];
                        $veri['low24h'] = (float)$data['to_walet_24_low'];
                        $veri['high24h'] = (float)$data['to_wallet_24_high'];
                        $veri['baseVolume24h'] = (float)$data['to_wallet_24h_vol'];
                        $veri['quoteVolume24h'] = (float)$data['to_wallet_24h_quote_vol'];
                        $veri['lowestAsk'] = (float)$lowestAsk;
                        $veri['highestBid'] = (float)$highestBid;
                        $veri['lastUpdateTimestamp'] = (string)date("Y-m-d H:i:s", $data['to_wallet_last_trade_date']);
                        $veri['tradesEnabled'] = (bool)$data['market_status'];
                        $json[] = $veri;
                    }
                } else {
                    $json["errorDescription"] = "Parameter 'filter' contains invalid value.";
                }
            } else {
                $json["errorDescription"] = limit(1);
            }
            echo $bas = json_encode($json);
        } else {
            if (limit(1) == "ok") {
                header("Content-type: application/json; charset=utf-8");
                $dosya = '/home/secondbtc/apix.txt';
                include($dosya);
            } else {
                $json["errorDescription"] = limit(1);
                echo $bas = json_encode($json);
            }
        }
    }


    public function tickersxyzabc()
    {
        $data = $this->api_model->tickers();
        if (!empty($data)) {

            foreach ($data as $data) {
                $lowestAsk = $this->api_model->tickerslowestAsk($data['to_wallet_short'], $data['from_wallet_short']);
                $highestBid = $this->api_model->tickershighestBid($data['to_wallet_short'], $data['from_wallet_short']);
                if ($data['to_wallet_last_trade_date'] < (time() - 86400)) {
                    $data['to_walet_24_low'] = 0;
                    $data['to_wallet_24_high'] = 0;
                    $data['to_wallet_24h_vol'] = 0;
                    $data['to_wallet_24h_quote_vol'] = 0;
                    $data['change'] = 0;
                }
                $veri['tradingPairs'] = (string)$data['to_wallet_short'] . '_' . $data['from_wallet_short'];
                $veri['LastPrice'] = (float)$data['to_wallet_last_price'];
                $veri['percentChange'] = (float)$data['change'];
                $veri['low24h'] = (float)$data['to_walet_24_low'];
                $veri['high24h'] = (float)$data['to_wallet_24_high'];
                $veri['baseVolume24h'] = (float)$data['to_wallet_24h_vol'];
                $veri['quoteVolume24h'] = (float)$data['to_wallet_24h_quote_vol'];
                $veri['lowestAsk'] = (float)$lowestAsk;
                $veri['highestBid'] = (float)$highestBid;
                $veri['lastUpdateTimestamp'] = (string)date("Y-m-d H:i:s", $data['to_wallet_last_trade_date']);
                $veri['tradesEnabled'] = (bool)$data['market_status'];
                $json[] = $veri;
            }
            echo $bas = json_encode($json);
            $dosyaadi = "/home/secondbtc/apix.txt"; //Dosyan?n bulundu?u dizin
            $file = fopen($dosyaadi, "w");
            fwrite($file, $bas);
            fclose($file);
        }
    }

    public function recentTrades()
    {
        if (limit(5) == "ok") {
            if ($_GET) {
                $get = addslashes($_GET['filter']);
                if (!empty($_GET['limit'])) {
                    $limit = addslashes($_GET['limit']);
                } else {
                    $limit = 5;
                };
                $pairs = explode("_", $get);
                $data = $this->api_model->recentTrades($pairs[0], $pairs[1], $limit);

                header("Content-type: application/json; charset=utf-8");
                if (!empty($data)) {
                    foreach ($data as $data) {
                        if ($data['trade_exchange_rol'] == 'maker') {
                            $maker = 1;
                        } else {
                            $maker = 0;
                        }
                        $veri['tradeID'] = (int)$data['trade_id'];
                        $veri['price'] = (float)$data['trade_bid'];
                        $veri['baseVolume'] = (float)$data['trade_total'];
                        $veri['quoteVolume'] = (float)$data['trade_unit'];
                        $veri['type'] = (string)$data['trade_type'];
                        $veri['time'] = (string)date("Y-m-d H:i:s", $data['trade_created']);
                        $veri['isBuyerMaker'] = (bool)$maker;
                        $json[] = $veri;
                    }
                } else {
                    $json["errorDescription"] = "Parameter 'filter' contains invalid value.";
                }
            } else {
                $json["errorDescription"] = "Parameter 'filter' contains invalid value.";
            }
        } else {
            $json["errorDescription"] = limit(5);
        }
        echo $bas = json_encode($json);
        //echo $json["errorDescription"]="This page has been put into maintenance mode.";
    }

    public function orderBook()
    {

        if (limit(5) == "ok") {
            if ($_GET) {
                $get = addslashes($_GET['filter']);
                if (!empty($_GET['limit'])) {
                    $limit = addslashes($_GET['limit']);
                } else {
                    $limit = 5;
                }
                $pairs = explode("_", $get);
                if ($pairs[1] == "TRY") {
                    $pairs[1] = "TL";
                }
                $dataBids = $this->api_model->orderBookBids($pairs[0], $pairs[1], $limit);
                $dataAsks = $this->api_model->orderBookAsks($pairs[0], $pairs[1], $limit);

                header("Content-type: application/json; charset=utf-8");
                if (!empty($dataBids)) {
                    $json['LastUpdateTimestamp'] = $dataBids[0]["exchange_created"];
                    foreach ($dataBids as $data1) {
                        $veri[] = array(
                            (string)Number($data1['exchange_bid'], 8), (float)$data1['exchange_unit']
                        );
                    }
                    $json['bids'] = $veri;
                } else {
                    $json['bids'] = null;
                }
                if (!empty($dataAsks)) {
                    foreach ($dataAsks as $data2) {
                        $veri2[] = array(
                            (string)Number($data2['exchange_bid'], 8), (float)$data2['exchange_unit']
                        );
                    }
                    $json['asks'] = $veri2;
                } else {
                    $json['asks'] = null;
                }
            } else {
                $json["errorDescription"] = "Parameter 'filter' contains invalid value.";
            }
        } else {
            $json["errorDescription"] = limit(5);
        }
        echo $bas = json_encode($json);

        //echo $json["errorDescription"]="This page has been put into maintenance mode.";
    }

    public function walletDetail()
    {
    }

    public function authRequest()
    {
        // get the user using the wallet address
        $address = $this->input->post('address');
        $user = $this->account_model->getUserByAddress($address);

        // generate the ticket TODO: get it from database
        $key = bin2hex($this->encryption->create_key(16));

        if (count($user) < 1) {
            $veri = array(
                'user_id' => uretken(28),
                'user_email' => (string)strtolower($address . '@secondbtc.com'),
                'user_pass' => (string)'',
                'user_mailcode' => md5(emailCode()),
                'user_create' => (int)time(),
                'user_ex_status' => (int)1,
                'user_wallet_status' => (int)1,
                'user_login_status' => (int)1,
                'user_conf_key' => (string)'',
                'user_with_conf' => (string)"M",
                'user_login_conf' => (string)"M",
                'user_google_key' => yeniSifrele(''),
                'user_google_conf' => (int)0,
                'user_referans_code' => uretken(10),
                'user_email_conf' => (int)0,
                'user_free_trade' => (int)0,
                'user_api_key' => (string)uretken(8) . "-" . uretken(4) . "-" . uretken(4) . "-" . uretken(4) . "-" . uretken(12),
                'user_ip' => (string)"DISABLED",
                'user_address' => (string)$address,
                'user_ticket' => (string)$key
            );
            $this->mongo_db->insert('user_datas', $veri);
            $data = ['address' => $address, 'ticket' => $key];
            echo json_encode($data);
        } else {
            $this->mongo_db->where(array('user_id' => (string)$user[0]['user_id']));
            $this->mongo_db->set('user_ticket', (string)$key);
            $this->mongo_db->update('user_datas');

            // generate the response
            $data = ['address' => $address, 'ticket' => $key];
            echo json_encode($data);
        }
    }

    /** 
     * Verify metamask signature
     */
    public function authSignature()
    {
        $address = $this->input->post('address');
        $signature = $this->input->post('signature');
        $headingMessage = $this->input->post('headingMessage') ?? 'starting session: ';

        $user = $this->account_model->getUserByAddress($address);
        $ticket = $user[0]['user_ticket'];

        $message  = $headingMessage . $ticket;

        if (verifySignature($message, $signature, $address)) {
            $this->session->unset_userdata(array('gecici_email', 'gecici_pass', 'gecici_system', 'gecici_google_key'));
            $this->session->set_userdata('user_data', $user);
            $data = ['status' => 'ok'];
        } else {
            $data = ['status' => 'error'];
        }

        echo json_encode($data);
    }

    /**
     * Verify Ethereum and tokens account balance
     */
    public function accountMonitor()
    {
        $this->load->library('AccountMonitor');
        $this->accountmonitor->checkEther();
        sleep(1);
        $this->accountmonitor->checkBinance();
        sleep(1);
        $this->accountmonitor->checkTokensEthereum();
        sleep(1);
        $this->accountmonitor->checkTokensBinance();
    }




    /**
     * request a ticket for the next user protected operation
     */
    public function createTicketRequest()
    {
        // get the user using the wallet address
        $address = $_SESSION['user_data'][0]['user_address'];
        $user = $this->account_model->getUserByAddress($address);

        // generate the ticket TODO: get it from database
        $key = bin2hex($this->encryption->create_key(16));

        $this->mongo_db->where(array('user_id' => (string)$user[0]['user_id']));
        $this->mongo_db->set('user_ticket', (string)$key);
        $this->mongo_db->update('user_datas');

        // generate the response
        $data = ['status' => 'ok', 'address' => $address, 'ticket' => $key];

        echo json_encode($data);
    }
}
