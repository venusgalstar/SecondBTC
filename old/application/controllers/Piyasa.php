<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Piyasa extends CI_Controller {

	public function __construct() {
		parent::__construct();
		dilBul();
		if(siteSetting()["site_status"]!=1 && $_SESSION['key']!="admin_bakim"){redirect('/maintenance');}		
	}
	public function index()
	{
		if($_GET && $_GET["fromCoin"]!="" && $_GET["toCoin"]!=""){
			$data["botList"] = $this->bot_model->botVeriMan($_GET["fromCoin"],$_GET["toCoin"]);
			$this->load->view('piyasa',$data);
		}else{
			$data["botList"] = $this->bot_model->botVeri();
			$this->load->view('piyasa',$data);
		}
		
	}

	public function piyasaBuy()
	{
		$fromShort = $this->input->post("fromShort");
		$toShort = $this->input->post("toShort");
		$fromID = $this->input->post("fromID");
		$toID = $this->input->post("toID");
		$userEmail = $this->input->post("userEmail");
		$userId = $this->input->post("userId");
		$apiWebSite = $this->input->post("apiSite");
		$buyPrice = $this->input->post("buyPrice");
		$volumeBot = $this->input->post("botVolume");
		$refCoin1 = $this->input->post("refCoin1");
		$refCoin2 = $this->input->post("refCoin2");
		$botAction = $this->input->post("botAction");
		if(!empty($fromShort) && !empty($toShort) && !empty($fromID) && !empty($toID) && !empty($apiWebSite)){
				$data =  $this->apiSite($fromShort,$toShort,$apiWebSite);
				if($apiWebSite=="bittrex"){
					if($botAction==2){

					}else{
					$enyuksekBids = $data["buy"][0]["Rate"];
					$unit = $data["buy"][0]["Quantity"]*($volumeBot*5);
					}
				}elseif($apiWebSite=="crex"){
					if($botAction==2){

					}else{
					$enyuksekBids = $data["buyLevels"][0]["price"];
					$unit = $data["buyLevels"][0]["volume"]*($volumeBot*5);
					}
				}elseif($apiWebSite=="bitforex"){
					if($botAction==2){
						$data1 =  $this->apiSite("BTC",$refCoin1,$apiWebSite);
						$data2 =  $this->apiSite("BTC",$refCoin2,$apiWebSite);
						$unit = $data2["asks"][rand(0,15)]["amount"]*$volumeBot;
						if(!empty($data1) && !empty($data2)){
						$enyuksekBids = $data2["asks"][0]["price"]/$data1["asks"][0]["price"];
						}else{$enyuksekBids=0;}
					}else{
						$unit = $data["bids"][0]["amount"]*$volumeBot;
						$enyuksekBids = $data["bids"][0]["price"];
					}
				}else{
					if($botAction==2){

					}else{
					$enyuksekBids = $data["bids"][0][0];
					$unit = $data["bids"][0][1]*($volumeBot*5);
					}
				}

				if(!empty($enyuksekBids)){
					$enyuksekBids = $enyuksekBids-$buyPrice;
					$this->bot_model->deleteAllBuy($fromShort,$toShort,$enyuksekBids,$userEmail,$userId);
					$aynı = $this->bot_model->ayniFiyatSor($fromShort,$toShort,$enyuksekBids,"buy");
					
					if(empty($aynı)){
						$bul = $this->bot_model->ucuzSellVarmi($fromShort,$toShort,$enyuksekBids);
						
						if(empty($bul)){
							if($enyuksekBids>=0.00000001 && is_numeric($enyuksekBids)){
							$insertBuy = $this->bot_model->insertOrder($fromShort,$toShort,$fromID,$toID,$enyuksekBids,$unit,"buy",$userEmail,$userId,0);
							$this->bot_model->deleteEski($userEmail,$userId);
							}
						}elseif($bul{0}["exchange_user_email"]!=$userEmail){
							//$_SESSION["deneme"] = "aa".$bul{0}["exchange_user_email"];
							if($enyuksekBids>=0.00000001 && is_numeric($enyuksekBids)){
							$insertBuy = $this->bot_model->insertOrder($fromShort,$toShort,$fromID,$toID,$enyuksekBids,$unit,"buy",$userEmail,$userId,1);
							$this->bot_model->deleteEski($userEmail,$userId);
							}
						}else{
							$this->bot_model->deleteAllBuy($fromShort,$toShort,$bul{0}["exchange_bid"]);
						}
					}
			}
		}
		echo "OK";
	}


	public function piyasaSell()
	{
		$fromShort = $this->input->post("fromShort");
		$toShort = $this->input->post("toShort");
		$fromID = $this->input->post("fromID");
		$toID = $this->input->post("toID");
		$userEmail = $this->input->post("userEmail");
		$userId = $this->input->post("userId");
		$apiWebSite = $this->input->post("apiSite");
		$sellPrice = $this->input->post("sellPrice");
		$volumeBot = $this->input->post("botVolume");
		$refCoin1 = $this->input->post("refCoin1");
		$refCoin2 = $this->input->post("refCoin2");
		$botAction = $this->input->post("botAction");
		if(!empty($fromShort) && !empty($toShort) && !empty($fromID) && !empty($toID) && !empty($apiWebSite)){
				$data =  $this->apiSite($fromShort,$toShort,$apiWebSite);
				if($apiWebSite=="bittrex"){
					if($botAction==2){

					}else{
					$endusukAsks = $data["sell"][0]["Rate"];
					$unit = $data["sell"][0]["Quantity"]*($volumeBot*5);
					}
				}elseif($apiWebSite=="crex"){
					if($botAction==2){

					}else{
					$endusukAsks = $data["sellLevels"][0]["price"];
					$unit = $data["sellLevels"][0]["volume"]*($volumeBot*5);
					}
				}elseif($apiWebSite=="bitforex"){
					if($botAction==2){
						$data1 =  $this->apiSite("BTC",$refCoin1,$apiWebSite);
						$data2 =  $this->apiSite("BTC",$refCoin2,$apiWebSite);
						$unit = $data2["bids"][rand(0,15)]["amount"]*$volumeBot;
						if(!empty($data1) && !empty($data2)){
						$endusukAsks= $data2["bids"][0]["price"]/$data1["bids"][0]["price"];
						//$_SESSION["fiyatvar"] = " fiyat : ".$endusukAsks." Amount : ".$unit." type: sell";
						}else{$endusukAsks=0;}
					}else{
						$unit = $data["asks"][0]["amount"]*$volumeBot;
						$endusukAsks = $data["asks"][0]["price"];
					}
				}else{
					if($botAction==2){

					}else{
					$endusukAsks = $data["asks"][0][0];
					$unit = $data["asks"][0][1]*($volumeBot*5);
					}
				}
				
				if(!empty($endusukAsks)){
					$endusukAsks = $endusukAsks+($sellPrice);
					$this->bot_model->deleteAllSell($fromShort,$toShort,$endusukAsks,$userEmail,$userId);
					$aynı = $this->bot_model->ayniFiyatSor($fromShort,$toShort,$endusukAsks,"sell");
					if(empty($aynı)){
						$bul2 = $this->bot_model->pahaliBuyVarmi($fromShort,$toShort,$endusukAsks);
						if(empty($bul2)){
							if($endusukAsks>=0.00000001 && is_numeric($endusukAsks)){
							$insertSell = $this->bot_model->insertOrder($fromShort,$toShort,$fromID,$toID,$endusukAsks,$unit,"sell",$userEmail,$userId,0);
							$this->bot_model->deleteEski($userEmail,$userId);
							}
						}elseif($bul2{0}["exchange_user_email"]!=$userEmail){
							if($endusukAsks>=0.00000001 && is_numeric($endusukAsks)){
							$insertSell = $this->bot_model->insertOrder($fromShort,$toShort,$fromID,$toID,$endusukAsks,$unit,"sell",$userEmail,$userId,1);
							$this->bot_model->deleteEski($userEmail,$userId);
							}
						}else{
							$this->bot_model->deleteAllSell($fromShort,$toShort,$bul2{0}["exchange_bid"]);
						}
					}
				}
		}
		echo "OK";
	}

	public function piyasaBuyOther()
	{
		
		$fromShort = $this->input->post("fromShort");
		$toShort = $this->input->post("toShort");
		$fromID = $this->input->post("fromID");
		$toID = $this->input->post("toID");
		$userEmail = $this->input->post("userEmail");
		$userId = $this->input->post("userId");
		$apiWebSite = $this->input->post("apiSite");
		$buyPrice = $this->input->post("buyPrice");
		$volumeBot = $this->input->post("botVolume");
		$refCoin1 = $this->input->post("refCoin1");
		$refCoin2 = $this->input->post("refCoin2");
		$botAction = $this->input->post("botAction");
		if(!empty($fromShort) && !empty($toShort) && !empty($fromID) && !empty($toID) && !empty($apiWebSite)){
				$data =  $this->apiSite($fromShort,$toShort,$apiWebSite);
				$rand = rand(1,90);
				if($apiWebSite=="bittrex"){
					if($botAction==2){
						
					}else{
					$fiyat = $data["buy"][$rand]["Rate"];
					$unit = $data["buy"][$rand]["Quantity"]*($volumeBot*5);
					}
				}elseif($apiWebSite=="crex"){
					if($botAction==2){
						
					}else{
					$rand = rand(1,20);
					$fiyat = $data["buyLevels"][$rand]["price"];
					$unit = $data["buyLevels"][$rand]["volume"]*($volumeBot*5);
					}
				}elseif($apiWebSite=="bitforex"){
					if($botAction==2){

					}else{
					$unit = $data["bids"][$rand]["amount"]*$volumeBot;
					$fiyat = $data["bids"][$rand]["price"];
					}
				}else{
					if($botAction==2){

					}else{
					$fiyat = $data["bids"][$rand][0];
					$unit = $data["bids"][$rand][1]*($volumeBot*5);
					}
				}
				if(!empty($fiyat) && $fiyat>0){
					$fiyat = $fiyat-($buyPrice);
					$aynı = $this->bot_model->ayniFiyatSor($fromShort,$toShort,$fiyat,"buy");
					if(empty($aynı)){
						//$_SESSION["fiyat"] = $fiyat;
						$insertBuy = $this->bot_model->insertOrderOther($fromShort,$toShort,$fromID,$toID,$fiyat,$unit,"buy",$userEmail,$userId);
					}
				}
		}
		echo "OK";
	}

	public function piyasaSellOther()
	{

		$fromShort = $this->input->post("fromShort");
		$toShort = $this->input->post("toShort");
		$fromID = $this->input->post("fromID");
		$toID = $this->input->post("toID");
		$userEmail = $this->input->post("userEmail");
		$userId = $this->input->post("userId");
		$apiWebSite = $this->input->post("apiSite");
		$sellPrice = $this->input->post("sellPrice");
		$volumeBot = $this->input->post("botVolume");
		$refCoin1 = $this->input->post("refCoin1");
		$refCoin2 = $this->input->post("refCoin2");
		$botAction = $this->input->post("botAction");
		if(!empty($fromShort) && !empty($toShort) && !empty($fromID) && !empty($toID) && !empty($apiWebSite)){
				$data =  $this->apiSite($fromShort,$toShort,$apiWebSite);
				$rand = rand(1,90);
				if($apiWebSite=="bittrex"){
					if($botAction==2){
						
					}else{
					$fiyat = $data["sell"][$rand]["Rate"];
					$unit = $data["sell"][$rand]["Quantity"]*($volumeBot*5);
					}

				}elseif($apiWebSite=="crex"){
					if($botAction==2){

					}else{
					$rand = rand(1,20);
					$fiyat = $data["sellLevels"][$rand]["price"];
					$unit = $data["sellLevels"][$rand]["volume"]*($volumeBot*5);
					}
				}elseif($apiWebSite=="bitforex"){
					if($botAction==2){

					}else{
					$unit = $data["asks"][$rand]["amount"]*$volumeBot;
					$fiyat = $data["asks"][$rand]["price"];
					}
				}else{
					if($botAction==2){
						
					}else{
					$fiyat = $data["asks"][$rand][0];
					$unit = $data["asks"][$rand][1]*($volumeBot*5);
					}
				}
				if(!empty($fiyat) && $fiyat>0){
					$fiyat = $fiyat+($sellPrice);
					$aynı = $this->bot_model->ayniFiyatSor($fromShort,$toShort,$fiyat,"sell");
					if(empty($aynı)){
						$insertSell = $this->bot_model->insertOrderOther($fromShort,$toShort,$fromID,$toID,$fiyat,$unit,"sell",$userEmail,$userId);
					}
				}
			
		}
		echo "OK";
	}
	public function apiSite($fromShort,$toShort,$apiWebSite)
	{
		
		if($apiWebSite==="btcturk"){
			$rand = rand(1,2);
			if($rand==1){
				if($fromShort=="TRY"){$from="TRY";}
				$veri = vericek("https://api.btcturk.com/api/v2/orderbook?pairSymbol=".$toShort."_".$from);
				$data = json_decode($veri,true);
				return $data["data"];
			}else{
				return null;
			}
		}elseif($apiWebSite==="bittrex"){
			$veri = vericek("https://api.bittrex.com/api/v1.1/public/getorderbook?market=".$fromShort."-".$toShort."&type=both");
			$data = json_decode($veri,true);
			return $data["result"];
		}elseif($apiWebSite==="binance"){
			$veri = vericek("https://api.binance.com/api/v1/depth?symbol=".$toShort.$fromShort."&limit=100");
			return $data = json_decode($veri,true);
		}elseif($apiWebSite==="crex"){
			$veri = vericek("https://api.crex24.com/v2/public/orderBook?instrument=".$toShort."-".$fromShort);
			return $data = json_decode($veri,true);
		}elseif($apiWebSite==="hotbit"){
			$veri = vericek("https://api.hotbit.io/api/v1/order.depth?market=".$toShort."/".$fromShort."&limit=100&interval=1e-8");
			$data = json_decode($veri,true);
			return $data["result"];
		}elseif($apiWebSite==="bitforex"){
			$veri = vericek("https://api.bitforex.com/api/v1/market/depth?symbol=coin-".mb_strtolower($fromShort)."-".mb_strtolower($toShort)."&size=100");
			$data = json_decode($veri,true);
			return $data["data"];
		}
	}

	public function piyasaTrade()
	{
		//$_SESSION["fiyatvar"] = "";
		//$_SESSION["deneme"] = "";
		$fromShort = $this->input->post("fromShort");
		$toShort = $this->input->post("toShort");
		$fromID = $this->input->post("fromID");
		$toID = $this->input->post("toID");
		$apiWebSite = $this->input->post("apiSite");
		$userEmail = $this->input->post("userEmail");
		$userId = $this->input->post("userId");
		$volumeBot = $this->input->post("botVolume");
		$sellPrice = $this->input->post("sellPrice");
		$buyPrice = $this->input->post("buyPrice");
		$refCoin1 = $this->input->post("refCoin1");
		$refCoin2 = $this->input->post("refCoin2");
		$botAction = $this->input->post("botAction");
		$rand = rand(1,2);
		$say = rand(3,10);
		if($rand===1){
			$type="bids"; $type2="buy"; $type3="buyLevels"; $sType= "sell";
		}else{
			$type="asks"; $type2="sell"; $type3="sellLevels"; $sType= "buy";
		}
		$data =  $this->apiSite($fromShort,$toShort,$apiWebSite);
		if($apiWebSite=="bittrex"){
			if($botAction==2){
						
			}else{
			$fiyat = $data[$type2][0]["Rate"];
			$unit = $data[$type2][$say]["Quantity"]*$volumeBot;
			$randUnit = "0.0".rand(1,69);
			if($unit==0){$unit = ($data[$type][1][1]*$randUnit)*$volumeBot;}
			}
		}elseif($apiWebSite=="crex"){
			if($botAction==2){
						
			}else{
			$fiyat = $data[$type3][0]["price"];
			$unit = $data[$type3][$say]["volume"]*$volumeBot;
			$randUnit = "0.0".rand(1,69);
			if($unit==0){$unit = ($data[$type][1][1]*$randUnit)*$volumeBot;}
			}
		}elseif($apiWebSite=="bitforex"){
			if($botAction==2){
				$data1 =  $this->apiSite("BTC",$refCoin1,$apiWebSite);
				$data2 =  $this->apiSite("BTC",$refCoin2,$apiWebSite);
				$unit = $data2[$type][$say]["amount"]*$volumeBot;
				$randUnit = "0.0".rand(1,69);
				if($unit==0){$unit = ($data[$type][1]["amount"]*$randUnit)*$volumeBot;}
				if(!empty($data1) && !empty($data2)){
				$fiyat = $data2["asks"][0]["price"]/$data1["asks"][0]["price"];
				}else{$fiyat="bos";}
			}else{
				$unit = $data[$type][$say]["amount"]*$volumeBot;
				$randUnit = "0.0".rand(1,69);
				if($unit==0){$unit = ($data[$type][1]["amount"]*$randUnit)*$volumeBot;}
				$fiyat = $data[$type][0]["price"];
			}
		}else{
			if($botAction==2){
						
			}else{
			$fiyat = $data[$type][0][0];
			$unit = $data[$type][$say][1]*$volumeBot;
			$randUnit = "0.0".rand(1,69);
			if($unit==0){$unit = ($data[$type][1][1]*$randUnit)*$volumeBot;}
			}
		}
		if($fiyat>=0.00000001){
		if($sType=="sell"){
			$bul = $this->bot_model->pahaliBuyVarmi($fromShort,$toShort,$fiyat);
		}elseif($sType=="buy"){
			$bul = $this->bot_model->ucuzSellVarmi($fromShort,$toShort,$fiyat);
		}
		if(empty($bul) || $userEmail==$bul{0}["exchange_user_email"]){
			if($sType=="buy"){
				$fiyat = $fiyat-($buyPrice);
			}elseif($sType=="sell"){
				$fiyat = $fiyat+($sellPrice);
			}
			//$_SESSION["fiyatvar"] = $sType." - ".$bul{0}["exchange_user_email"]." Fiyat : ".Number($fiyat,8)." Adet : ".$unit." - rand : ".$rand."<br>";
		
		$insertTrade = $this->bot_model->insertTrade($fromShort,$toShort,$fromID,$toID,$fiyat,$unit,$sType);
		
		}else{
			//$_SESSION["deneme"] = $sType." - ".$bul{0}["exchange_user_email"]." Fiyat : ".Number($fiyat,8)." Adet : ".$unit." - rand : ".$rand." Açılmadı<br>";
		}
	} 
		
	}

}