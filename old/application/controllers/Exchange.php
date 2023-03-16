<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exchange extends CI_Controller {
	public function __construct() {
		parent::__construct();
		dilBul();
		header('X-Frame-Options: SAMEORIGIN');
		if(siteSetting()["site_status"]!=1 && $_SESSION['key']!="admin_bakim"){redirect('/maintenance');}		
	}
	public function index()
	{
		$market = $this->uri->segment(2);
		$veri = explode("-", $market);
		if(count($veri) != 2){redirect('/market');
		}else{
			$getMarket = $this->exchange_model->getWalletPairs($veri[0],$veri[1]);
			if(!empty($getMarket)){
				if(!empty($_SESSION['user_data'][0]['user_id']) && !empty($_SESSION['user_data'][0]['user_email'])){
					$userID = $_SESSION['user_data'][0]['user_id'];
					$email = $_SESSION['user_data'][0]['user_email'];
				}else{
					$email = 0; $userID = 0;
				}
				
				$getMarketPairs = $this->exchange_model->getMainWallet();
				$toWallet = $this->exchange_model->getWallet($veri[1]);
				$fromWallet = $this->exchange_model->getWallet($veri[0]);
				$toWalletInfo = $this->exchange_model->getWalletInfo($veri[1]);
				$fromBalance = userWalletBalance($getMarket{0}['from_wallet_id'],$userID,$email);
				$toBalance= userWalletBalance($getMarket{0}['to_wallet_id'],$userID,$email);
				$data = array(
					'getMarketPairs' => $getMarketPairs,
					'toWallet' => $toWallet,
					'fromWallet' => $fromWallet,
					'fromBalance' => $fromBalance,
					'toBalance' => $toBalance,
					'lastPrice' => $getMarket{0}["to_wallet_last_price"],
					'toWalletInfo' => $toWalletInfo
				);
				$this->load->view('exchange',$data);
			}else{
				redirect('/market');
			}
		}
	}
	/*
	public function exchangeMarket($market)
	{
		$veri = explode("-", $market);
		if(count($veri) != 2){redirect('/404');
		}else{
			$getMarket = $this->exchange_model->getWalletPairs($veri[0],$veri[1]);
			if(!empty($getMarket)){
				if(!empty($_SESSION['user_data'][0]['user_id']) && !empty($_SESSION['user_data'][0]['user_email'])){
					$userID = $_SESSION['user_data'][0]['user_id'];
					$email = $_SESSION['user_data'][0]['user_email'];
				}else{
					$email = 0; $userID = 0;
				}
				
				$getMarketPairs = $this->exchange_model->getMainWallet();
				$toWallet = $this->exchange_model->getWallet($veri[1]);
				$fromWallet = $this->exchange_model->getWallet($veri[0]);
				$toWalletInfo = $this->exchange_model->getWalletInfo($veri[1]);
				$fromBalance = userWalletBalance($getMarket{0}['from_wallet_id'],$userID,$email);
				$toBalance= userWalletBalance($getMarket{0}['to_wallet_id'],$userID,$email);
				$data = array(
					'getMarketPairs' => $getMarketPairs,
					'toWallet' => $toWallet,
					'fromWallet' => $fromWallet,
					'fromBalance' => $fromBalance,
					'toBalance' => $toBalance,
					'lastPrice' => $getMarket{0}["to_wallet_last_price"],
					'toWalletInfo' => $toWalletInfo
				);
				$this->load->view('exchange',$data);
			}else{
				redirect('/404');
			}
		}
	}
*/
	public function trade()
	{	
		$unit = addslashes($this->input->post('unit'));
		$price = addslashes($this->input->post('price'));
		$fromID = $this->input->post('fromID');
		$toID = $this->input->post('toID');
		$toShort = addslashes($this->input->post('toShort'));
		$fromShort = addslashes($this->input->post('fromShort'));
		$type = addslashes($this->input->post('type'));
		if(is_numeric($unit) && $unit>0 && is_numeric($price) && $price>0  && is_numeric($fromID)  && is_numeric($toID)){
			//$sorSira = $this->exchange_model->tradeSirayaAl('sor');
			if(exchangeLimit()!="ok"){
					//$silSira = $this->exchange_model->tradeSirayaAl('delete');
					$data = array("durum" => 'error',"mesaj"=> lang("bigdemand").' '.lang("tryagain"));
					echo json_encode($data);
			}else{
				//$sirayaAl = $this->exchange_model->tradeSirayaAl('siraAl',$_SESSION['user_data'][0]['user_email']);
				$unitSon = Number($unit,8); 
				$priceSon = Number($price,8); 
				$data = $this->exchange_model->tradeKontrol($unitSon,$priceSon,$fromID,$toID,$toShort,$fromShort,$type);
				echo json_encode($data);
				//$silSira = $this->exchange_model->tradeSirayaAl('delete');
			}
		}else{
			$data = array("durum" => 'error',"mesaj"=> lang("errordatas").' '.lang("tryagain"));
			echo json_encode($data);
		}
	}

	public function deleteorder()
	{	
		$id = addslashes($this->input->post('id'));
		$socketId = $this->input->post('socketId');
		if($id){
			 $data = $this->exchange_model->orderDelete($id,$socketId);
			echo json_encode($data);
		}
	}
}