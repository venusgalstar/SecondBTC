<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        dilBul();
        header('X-Frame-Options: SAMEORIGIN');
        // if(siteSetting()["site_status"]!=1 && $_SESSION['key']!="admin_bakim"){redirect('/maintenance');}

    }

    public function index()
    {
        //if($_SESSION["dd"]=="halil"){
        $data["marketPair"] = $this->index_model->getMainWallet();
        $data["marketUst"] = $this->index_model->getWalletUst();
        // $this->load->view('index', $data);
        //}else{
        redirect("market");
        //}
    }

    public function dilsec($dil, $url = "", $url2 = '', $url3 = '')
    {
        dilBul($dil);
        if ($url2 != '') {
            redirect($url . "/" . $url2);
        } elseif ($url3 != '') {
            redirect($url . "/" . $url2 . "/" . $url3);
        } else {
            redirect($url);
        }
    }
    public function status()
    {
        $data["walletList"] = $this->index_model->statusWallet();
        $data["walletListCom"] = $this->index_model->statusWalletCom();
        $this->load->view('status', $data);
    }
    public function privacy()
    {
        $this->load->view('privacy');
    }
    public function terms()
    {
        $this->load->view('terms');
    }
    public function listing()
    {
        $this->load->view('listing');
    }
    public function news()
    {
        $data["news"] = $this->index_model->getNews();
        $this->load->view('news', $data);
    }
    public function newsdetail($id)
    {
        $data["newsDetail"] = $this->index_model->getNewsDetail($id);
        $this->load->view('news_detail', $data);
    }
    public function teamAboutus()
    {
        $data["teamList"] = $this->index_model->getTeam();
        $this->load->view('team_aboutus', $data);
    }
    public function faucet()
    {
        //$data["faucetList"] = $this->index_model->getFaucet();
        //$this->load->view('faucet',$data);
    }
    public function userFaucetConfirm()
    {
        if ($_POST) {
            $data = $this->index_model->userFaucetConfirm();
            echo json_encode($data);
        }
    }

    function trade()
    {
        $data = array();
        $market = $this->uri->segment(2);
        $veri = explode("-", $market);
        if (count($veri) != 2) {
            redirect('/market');
        } else {
            $getMarket = $this->exchange_model->getWalletPairs($veri[0], $veri[1]);
            if (!empty($getMarket)) {
                if (!empty($_SESSION['user_data'][0]['user_id']) && !empty($_SESSION['user_data'][0]['user_email'])) {
                    $userID = $_SESSION['user_data'][0]['user_id'];
                    $email = $_SESSION['user_data'][0]['user_email'];
                } else {
                    $email = 0;
                    $userID = 0;
                }
                $getMarketPairs = $this->exchange_model->getMainWallet();
                $toWallet = $this->exchange_model->getWallet($veri[1]);
                $fromWallet = $this->exchange_model->getWallet($veri[0]);
                $toWalletInfo = $this->exchange_model->getWalletInfo($veri[1]);
                $fromBalance = userWalletBalance($getMarket[0]['from_wallet_id'], $userID, $email);
                $toBalance = userWalletBalance($getMarket[0]['to_wallet_id'], $userID, $email);
                $data = array('getMarketPairs' => $getMarketPairs, 'toWallet' => $toWallet, 'fromWallet' => $fromWallet, 'fromBalance' => $fromBalance, 'toBalance' => $toBalance, 'lastPrice' => $getMarket[0]["to_wallet_last_price"], 'toWalletInfo' => $toWalletInfo);
            } else {
                redirect('/market');
            }
        }
        $this->load->view("trade", $data);
    }
}
