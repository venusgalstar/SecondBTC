<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exchange_model extends CI_Model {

	public function getMainWallet()
	{
		$this->mongo_db->order_by(array('wallet_main_pairs'=>'asc'));
		$this->mongo_db->where('wallet_status', 1);
		$this->mongo_db->where_ne("wallet_main_pairs", 0);
		$sor = $this->mongo_db->get('wallet_datas');
		return $sor;
	}

	public function getWallet($walletShort)
	{	
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('wallet_status' => 1,'wallet_short' => (string)$walletShort));
		$sor = $this->mongo_db->get('wallet_datas');
		return $sor;
	}

	public function getWalletInfo($walletShort)
	{	
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('wallet_short' => (string)$walletShort));
		$sor = $this->mongo_db->get('wallet_info_datas');
		return $sor;
	}

	public function getWalletPairs($from,$to)
	{
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('from_wallet_short'=>(string)$from,'to_wallet_short' => (string)$to, 'market_status' => 1));
		$sorMarket = $this->mongo_db->get('market_datas');
			if(!empty($sorMarket)){ 
				return $sorMarket;
			}else{
				return null;
			}
	}

	public function tradeKontrol($unit,$price,$fromID,$toID,$toShort,$fromShort,$type)
	{	
		$userID = $_SESSION['user_data'][0]['user_id'];
		$email = $_SESSION['user_data'][0]['user_email'];

		if(!empty($userID) && !empty($email)){

			if(UserStatus($userID,$email,"user_ex_status")==1){

				$this->mongo_db->limit(1);
				$this->mongo_db->where(array('wallet_id'=> (int)$toID,'wallet_short' =>(string)$toShort));
				$toWalletData = $this->mongo_db->get('wallet_datas');

				$this->mongo_db->limit(1);
				$this->mongo_db->where(array('wallet_id'=> (int)$fromID,'wallet_short' =>(string)$fromShort));
				$fromWalletData = $this->mongo_db->get('wallet_datas');
				if(!empty($toWalletData) && !empty($fromWalletData)){
				if($toWalletData[0]["wallet_ex_status"]==1){
					if($type=='buy'){
						$commission=$fromWalletData[0]["wallet_buy_com"];
						if(UserStatus($userID,$email,"user_free_trade")==1){$commission=1;} 
						$total =Number(($unit*$price)*$commission,20);
						$yuvarla = ($total*1.999999)-$total;
						$amount =Number($yuvarla,20);
						$walletID = $fromID;

					}elseif($type=='sell'){
						$commission=$fromWalletData[0]["wallet_sell_com"];
						if(UserStatus($userID,$email,"user_free_trade")==1){$commission=1;} 
						$amount =Number($unit,20);
						$walletID = $toID;
					}else{
						return array('durum' => 'error', 'mesaj' => lang("errordatas"));
					}

				$minUnit = $toWalletData[0]["wallet_min_unit"];
				$minTotal = $toWalletData[0]["wallet_min_total"];
				$minBid = $toWalletData[0]["wallet_min_bid"];

				if($unit<$minUnit){
					return array('durum' => 'error', 'mesaj' => lang("minimumunit")." : ".Number($minUnit,20)." ".$toShort);
				}elseif($price<$minBid){
					return array('durum' => 'error', 'mesaj' => lang("minimumbid")." : ".Number($minBid,20)." ".$fromShort);
				}elseif((Number(($unit*$price)*$commission,20))<$minTotal){
					return array('durum' => 'error', 'mesaj' => lang("minimumtotal")." : ".Number($minTotal,20)." ".$fromShort);
				}else{
					if(userWalletBalance($walletID,$userID,$email)>=$amount){
						if($type=='buy'){
							$orderSor = $this->orderBuyKontrol($toID,$fromID,$price);
							if(!empty($orderSor)){
								return $this->buyExchange($unit,$price,$fromID,$toID,$toShort,$fromShort,$type,$commission,$userID,$email,$orderSor);
							}else{
								return $this->createOrderBook($unit,$price,$fromID,$toID,$type,$commission,$userID,$email,$unit,$toShort,$fromShort);
							}
						}elseif($type=='sell'){
							$orderSor = $this->orderSellKontrol($toID,$fromID,$price);
							if(!empty($orderSor)){
								return $this->sellExchange($unit,$price,$fromID,$toID,$toShort,$fromShort,$type,$commission,$userID,$email,$orderSor);
							}else{
								return $this->createOrderBook($unit,$price,$fromID,$toID,$type,$commission,$userID,$email,$unit,$toShort,$fromShort);
							}
						}
					}else{return array('durum' => 'error', 'mesaj' => lang("notbalancevalue"));}
				}
			}else{return array('durum' => 'error', 'mesaj' => lang("marketcloded"));}
			}else{return array('durum' => 'error', 'mesaj' => lang("marketno"));}
			}else{return array('durum' => 'error', 'mesaj' => lang("accounttradeclosed"));}
		}else{return array('durum' => 'error', 'mesaj' => lang("pleaselogin"));}
	}

//Bot 
	public function tradeKontrolBot($unit,$price,$fromID,$toID,$toShort,$fromShort,$type,$email,$userID)
	{	
		
		if(!empty($userID) && !empty($email)){

				$this->mongo_db->limit(1);
				$this->mongo_db->where(array('wallet_id'=> (int)$toID,'wallet_short' =>(string)$toShort));
				$toWalletData = $this->mongo_db->get('wallet_datas');

				$this->mongo_db->limit(1);
				$this->mongo_db->where(array('wallet_id'=> (int)$fromID,'wallet_short' =>(string)$fromShort));
				$fromWalletData = $this->mongo_db->get('wallet_datas');
				if(!empty($toWalletData) && !empty($fromWalletData)){
				if($toWalletData[0]["wallet_ex_status"]==1){
					if($type=='buy'){
						$commission=1; 
						$total =Number(($unit*$price)*$commission,20);
						$yuvarla = ($total*1.999999)-$total;
						$amount =Number($yuvarla,20);
						$walletID = $fromID;

					}elseif($type=='sell'){
						$commission=1;
						$amount =Number($unit,20);
						$walletID = $toID;
					}else{
						return array('durum' => 'error', 'mesaj' => lang("errordatas"));
					}

						if($type=='buy'){
							$orderSor = $this->orderBuyKontrol($toID,$fromID,$price);
							if(!empty($orderSor)){
								//$_SESSION["test"]=$orderSor[0]["exchange_user_email"];
								$this->buyExchange($orderSor[0]["exchange_unit"],$price,$fromID,$toID,$toShort,$fromShort,$type,$commission,$userID,$email,$orderSor);
							}else{
								return "botok";
							}
						}elseif($type=='sell'){
							//$_SESSION["fiyat"] = $price;
							$orderSor = $this->orderSellKontrol($toID,$fromID,$price);
							if(!empty($orderSor)){
								//$_SESSION["test"]=$orderSor[0]["exchange_user_email"];
								$this->sellExchange($orderSor[0]["exchange_unit"],$price,$fromID,$toID,$toShort,$fromShort,$type,$commission,$userID,$email,$orderSor);
							}else{
								return "notok";
							}
						}
				
			}//market closed
			}//not wallet
		}//not user
	}


	public function orderBuyKontrol($toID,$fromID,$price)
	{		
			$this->mongo_db->limit(1);
			$this->mongo_db->order_by(array('exchange_bid'=>'asc'));
			$this->mongo_db->order_by(array('exchange_created'=>'asc'));
			$array = array(
				'exchange_to_wallet_id' => (int)$toID,
				'exchange_type' => (string)'sell',
				'exchange_status' => (int)1,
				'exchange_from_wallet_id' => (int)$fromID
			);
			$this->mongo_db->where($array);
			$this->mongo_db->where_lte('exchange_bid',(double)$price);
			$data = $this->mongo_db->get('exchange_datas');
			if(!empty($data) && $data[0]["exchange_user_id"]!="bot"){
				return $data;
			}else{
				$delarray = array( 
				'exchange_user_id' => (string)"bot",
				'exchange_type' => (string)'sell',
				'exchange_to_wallet_id' => (int)$toID,
				'exchange_from_wallet_id' => (int)$fromID
				);
				$this->mongo_db->where($delarray);
				$this->mongo_db->where_lte('exchange_bid',(double)$price);
				$cancel = $this->mongo_db->delete_all('exchange_datas');
				return null;
			}
	}

	public function orderSellKontrol($toID,$fromID,$price)
	{		
			$this->mongo_db->limit(1);
			$this->mongo_db->order_by(array('exchange_bid'=>'desc'));
			$this->mongo_db->order_by(array('exchange_created'=>'asc'));
			$array = array(
				'exchange_to_wallet_id' => (int)$toID,
				'exchange_type' => (string)'buy',
				'exchange_status' => (int)1,
				'exchange_from_wallet_id' => (int)$fromID
			);
			$this->mongo_db->where($array);
			$this->mongo_db->where_gte('exchange_bid',(double)$price);
			$data = $this->mongo_db->get('exchange_datas');
			if(!empty($data) && $data[0]["exchange_user_id"]!="bot"){
				return $data;
			}else{
				$delarray = array( 
				'exchange_user_id' => (string)"bot",
				'exchange_type' => (string)'buy',
				'exchange_to_wallet_id' => (int)$toID,
				'exchange_from_wallet_id' => (int)$fromID
				);
				$this->mongo_db->where($delarray);
				$this->mongo_db->where_gte('exchange_bid',(double)$price);
				$cancel = $this->mongo_db->delete_all('exchange_datas');
				return null;
			}
	}

	public function createOrderBook($unit,$price,$fromID,$toID,$type,$commission,$userID,$email,$firsUnit,$toShort,$fromShort)
	{	
		$total = Number(($unit*$price)*$commission,20);
		if($type=="buy"){ $eksilt = $total; $walletID = $fromID;
		}elseif($type=="sell"){ $eksilt = $unit; $walletID = $toID;
		}else{return array('durum' => 'error', 'mesaj' => lang("hata").' 201');}

		$this->mongo_db->where(array('wallet_user_id' => (string)$userID, 'wallet_user_email' => (string)$email,'wallet_id' => (int)$walletID));
		$this->mongo_db->inc('wallet_user_balance',-$eksilt);
		$update = $this->mongo_db->update('user_wallet_datas');
		if($eksilt>0){ $kontrol = $update->getModifiedCount(); $status = (int)1; $completed = null;
		}else{$kontrol=1; $status = (int)0; $completed = (int)time();}
			if($kontrol==1){
			$veri = array(
				'exchange_id' => uretken(28),
				'exchange_from_wallet_id' => (int)$fromID,
				'exchange_from_short' => (string)$fromShort,
				'exchange_to_wallet_id' => (int)$toID,
				'exchange_to_short' => (string)$toShort,
				'exchange_user_id'=> (string)$userID,
				'exchange_user_email' => (string)$email,
				'exchange_bid' => (double)$price,
				'exchange_first_unit' => (double)$firsUnit,
				'exchange_unit' => (double)$unit,
				'exchange_total' => (double)$total,
				'exchange_comission' => (double)$commission,
				'exchange_type' => (string)$type,
				'exchange_status' => (int)$status,
				'exchange_created' => (int)time(),
				'exchange_completed' => (int)$completed
			);
			$insert = $this->mongo_db->insert('exchange_datas',$veri);
			if(count($insert)){
				$aciklama = 
				lang($type).' '.lang("orderopennow").'<br>'
				.lang("amount").' : '.$unit.' '.$toShort.'<br>'
				.lang("price").' : '.$price.' '.$fromShort.'<br>'
				.lang("total").' : '.Number($unit*$price,20).' '.$fromShort.'<br>'
				.lang("time").' : '.date("H:i:s").'<br>';
				return array('durum' => 'info', 'mesaj' => $aciklama,'islem' => 'orderbook','id' => $userID, 'hesap' => $email);
			}else{
				$this->logger->write( "exchangeError", "trade", "(".microtime().") open order(createOrderBook) işleminde  kullanıcının bakiyesi düşüldü ama emir açılmadı: ,exchange_user_id : ".$userID.", Miktar : ".Number($unit,20).", Fiyat : ".Number($price,20).", fromid : ".$fromID.", toid : ".$toID.", type : ".$type);
				return array('durum' => 'error', 'mesaj' => lang("hata").' 202');}
		}else{
			$this->logger->write( "exchangeError", "trade", "(".microtime().") open order(createOrderBook) işleminde  kullanıcının bakiyesi düşülmedi: ,exchange_user_id : ".$userID."  ,Miktar : ".Number($eksilt,20)."  ,type : ".$type."From".$fromShort." To".$toShort);
			return array('durum' => 'error', 'mesaj' => lang("hata").' 203');
		}
	}

	public function buyExchange($unit,$price,$fromID,$toID,$toShort,$fromShort,$type,$commission,$userID,$email,$sellOrder)
	{
		
		$sellUnit = $sellOrder[0]["exchange_unit"];
		$sellID = $sellOrder[0]["exchange_id"];
		$sellPrice = $sellOrder[0]["exchange_bid"];
		$sellUserId = $sellOrder[0]["exchange_user_id"];
		$sellUserEmail = $sellOrder[0]["exchange_user_email"];
		$sellCommission = $sellOrder[0]["exchange_comission"];
		$sellTotal = $sellOrder[0]["exchange_total"];
		$sellTime = $sellOrder[0]["exchange_created"];
		$sellType = $sellOrder[0]["exchange_type"];

		if((double)$unit>=(double)$sellUnit){
			$kalanUnit = (double)$unit-(double)$sellUnit;//sel unit bitti eğer unit 0 dan büyükse tekrar et
			$alinanUnit  = (double)$unit-(double)$kalanUnit;
			$odenenTotal = Number(((double)$alinanUnit*(double)$sellPrice)*(double)$commission,20);
			$saticiyaOde = Number(((double)$alinanUnit*(double)$sellPrice)*(double)$sellCommission,20);
			$alicidanDus = Number(((double)$alinanUnit*(double)$sellPrice)*(double)$commission,20);

			//satıcının emrini güncelle
			$this->mongo_db->where(array('exchange_id' => (string)$sellID, 'exchange_user_id' => (string)$sellUserId,'exchange_user_email' => (string)$sellUserEmail,'exchange_created' => (int)$sellTime));
			$this->mongo_db->set('exchange_status',(int)0);
			$this->mongo_db->set('exchange_unit',(double)0);
			$this->mongo_db->set('exchange_total',(double)0);
			$this->mongo_db->set('exchange_completed',(int)time());
			$saticiEmir = $this->mongo_db->update('exchange_datas');
			if($saticiEmir->getModifiedCount()!=1){
					$this->logger->write( "exchangeError", "trade", "(".microtime().") trade işleminde satıcının emri güncellenmedi : ,exchange_id : ".$sellID."  ,exchange_user_id : ".$sellUserId." ,Miktar : ".Number($odenenTotal,20)." From ".$fromShort." To ".$toShort);
			}
				//satıcıya from coin öde
				$saticiFromWallet = $this->UserWalletUpdateArttir($sellUserId,$sellUserEmail,$fromID,$saticiyaOde);
				$this->tradeDataInsert($fromID,$toID,$toShort,$fromShort,$sellUnit,$sellPrice,$sellTotal,$sellUserId,$sellUserEmail,$sellType,$email,'maker',$sellCommission);
				if($saticiFromWallet->getModifiedCount()!=1){
					$this->logger->write( "exchangeError", "trade", "(".microtime().") trade işleminde satıcı sattığının karşılığını almadı : ,exchange_id : ".$sellID."  ,exchange_user_id : ".$sellUserId."  ,Miktar : ".Number($sellTotal,20)."From".$fromShort." To".$toShort);
				};
				//alıcıya to coin öde
				$aliciToWallet = $this->UserWalletUpdateArttir($userID,$email,$toID,$alinanUnit);
				if($aliciToWallet->getModifiedCount()!=1){
					$this->logger->write( "exchangeError", "trade", "(".microtime().") trade işleminde alıcı almak istediğini alamadı : ,exchange_id : ".$sellID."  ,exchange_user_id : ".$userID."  ,Miktar : ".Number($alinanUnit,20)."From".$fromShort." To".$toShort);
				};
				//alıcının from coini azalt
				$aliciFromWallet = $this->UserWalletUpdateAzalt($userID,$email,$fromID,$alicidanDus);
				if($aliciFromWallet->getModifiedCount()!=1){
					$this->logger->write( "exchangeError", "trade", "(".microtime().") trade işleminde alıcı aldığının karşılığını ödemedi : ,exchange_id : ".$sellID."  ,exchange_user_id : ".$userID."  ,Miktar : ".Number($alinanUnit,20)."From".$fromShort." To".$toShort);
				}
					if($kalanUnit >0){
						$sellOrder = $this->orderBuyKontrol($toID,$fromID,$price);
						if(!empty($sellOrder)){
							$aciklama = 
							lang($type).' '.lang("ordersucnow").'<br>'
							.lang("amount").' : '.$alinanUnit.' '.$toShort.'<br>'
							.lang("price").' : '.$sellPrice.' '.$fromShort.'<br>'
							.lang("total").' : '.Number($alinanUnit*$sellPrice,20).' '.$fromShort.'<br>'
							.lang("time").' : '.date("H:i:s").'<br>';
							$tekrarla = $this->buyExchange($kalanUnit,$price,$fromID,$toID,$toShort,$fromShort,$type,$commission,$userID,$email,$sellOrder);
							$this->tradeDataInsert($fromID,$toID,$toShort,$fromShort,$alinanUnit,$sellPrice,$odenenTotal,$userID,$email,$type,$sellUserEmail,'taker',$commission);
							$this->logger->write( "exchange", "trade", "(".microtime().") trade işleminde  : ".$userID." id nolu alıcı ".$sellUserId." id nolu satıcıdan ".Number($sellPrice,20)." fiyatından ".$unit." adet ".$fromID." id nolu coin karşılığında ".$toID." id nolu coin almak istedi ama satıcının miktarı(".$sellUnit.") yetmedi ve emir tekrar etti.");
							return array('durum' => 'success', 'mesaj' => $aciklama,'islem' => 'orderbook','id' => $userID, 'hesap' => $email,'toid' => $sellUserId);
						}else{
							$aciklama = 
							lang($type).' '.lang("ordersucnow").'<br>'
							.lang("amount").' : '.$alinanUnit.' '.$toShort.'<br>'
							.lang("price").' : '.$sellPrice.' '.$fromShort.'<br>'
							.lang("total").' : '.Number($alinanUnit*$sellPrice,20).' '.$fromShort.'<br>'
							.lang("time").' : '.date("H:i:s").'<br>';
							$this->tradeDataInsert($fromID,$toID,$toShort,$fromShort,$alinanUnit,$sellPrice,$odenenTotal,$userID,$email,$type,$sellUserEmail,'taker',$commission);
							$this->createOrderBook($kalanUnit,$price,$fromID,$toID,$type,$commission,$userID,$email,$unit,$toShort,$fromShort);
							$this->logger->write( "exchange", "trade", "(".microtime().") trade işleminde  : ".$userID." id nolu alıcı ".$sellUserId." id nolu satıcıdan ".Number($sellPrice,20)." fiyatından ".$alinanUnit." adet ".$fromID." id nolu coin karşılığında ".$toID." id nolu coin satın aldı. Satıcının miktarı yetmedi ve eşleşen bir fiyat olmadığı için ".$kalanUnit." adet alış emri açıldı.");
							return array('durum' => 'success', 'mesaj' => $aciklama,'islem' => 'orderbook','id' => $userID, 'hesap' => $email,'toid' => $sellUserId);
						}
					}else{
							$aciklama = 
							lang($type).' '.lang("ordersucnow").'<br>'
							.lang("amount").' : '.$alinanUnit.' '.$toShort.'<br>'
							.lang("price").' : '.$sellPrice.' '.$fromShort.'<br>'
							.lang("total").' : '.Number($alinanUnit*$sellPrice,20).' '.$fromShort.'<br>'
							.lang("time").' : '.date("H:i:s").'<br>';
							$this->tradeDataInsert($fromID,$toID,$toShort,$fromShort,$alinanUnit,$sellPrice,$odenenTotal,$userID,$email,$type,$sellUserEmail,'taker',$commission);
							$this->createOrderBook(0,$price,$fromID,$toID,$type,$commission,$userID,$email,$unit,$toShort,$fromShort);
							$this->logger->write( "exchange", "trade", "(".microtime().") trade işleminde  : ".$userID." id nolu alıcı ".$sellUserId." id nolu satıcıdan ".Number($sellPrice,20)." fiyatından ".$alinanUnit." adet ".$fromID." id nolu coin karşılığında ".$toID." id nolu coin satın aldı. Alıcı almak istediği miktarı aldı. Boş emir açıldı.");
							return array('durum' => 'success', 'mesaj' => $aciklama,'islem' => 'orderbook','id' => $userID, 'hesap' => $email,'toid' => $sellUserId);
					}
		}else{
			$kalanUnit = 0;//unit bitti 
			$alinanUnit  = $unit;
			$odenenTotal = Number(((double)$alinanUnit*(double)$sellPrice)*(double)$commission,20);
			$SkalanUnit = Number(((double)$sellUnit-(double)$unit),20);//unit bitti
			$SkalanTotal = Number(((double)$SkalanUnit*(double)$sellPrice),20);
			$saticiyaOde = Number(((double)$alinanUnit*(double)$sellPrice)*(double)$sellCommission,20);
			$alicidanDus = Number(((double)$alinanUnit*(double)$sellPrice)*(double)$commission,20);
			//return array('durum' => 'success', 'mesaj' => 'işlem tamamlandi : '.$alinanUnit);
			 
			//satıcının emrini güncelle
			$this->mongo_db->where(array('exchange_id' => (string)$sellID, 'exchange_user_id' => (string)$sellUserId,'exchange_user_email' => (string)$sellUserEmail,'exchange_created' => (int)$sellTime));
			$this->mongo_db->set('exchange_status',(int)1);
			$this->mongo_db->set('exchange_unit',(double)$SkalanUnit);
			$this->mongo_db->set('exchange_total',(double)$SkalanTotal);
			$this->mongo_db->set('exchange_completed',null);
			$saticiEmir = $this->mongo_db->update('exchange_datas');
			if($saticiEmir->getModifiedCount()!=1){
				$this->logger->write( "exchangeError", "trade", "(".microtime().") trade işleminde satıcının emri güncellenmedi : ,exchange_id : ".$sellID."  ,exchange_user_id : ".$sellUserId." From ".$fromShort." To".$toShort);
			}
			
			//satıcıya from coin öde
			$saticiFromWallet = $this->UserWalletUpdateArttir($sellUserId,$sellUserEmail,$fromID,$saticiyaOde);
			$this->tradeDataInsert($fromID,$toID,$toShort,$fromShort,$alinanUnit,$sellPrice,$saticiyaOde,$sellUserId,$sellUserEmail,$sellType,$email,'maker',$sellCommission);
			if($saticiFromWallet->getModifiedCount()!=1){
				$this->logger->write( "exchangeError", "trade", "(".microtime().") trade işleminde satıcı sattığının karşılığını almadı : ,exchange_id : ".$sellID."  ,exchange_user_id : ".$sellUserId."  ,Miktar : ".Number($sellTotal,20)."From".$fromShort." To".$toShort);
			};
			//alıcıya to coin öde
			$aliciToWallet = $this->UserWalletUpdateArttir($userID,$email,$toID,$alinanUnit);
			if($aliciToWallet->getModifiedCount()!=1){
				$this->logger->write( "exchangeError", "trade", "(".microtime().") ".$aliciToWallet->getModifiedCount()." trade işleminde alıcı almak istediğini alamadı : ,exchange_id : ".$sellID."  ,exchange_user_id : ".$userID."  ,Miktar : ".Number($alinanUnit,20)."From".$fromShort." To".$toShort);
			};
			//alıcının from coini azalt
			$aliciFromWallet = $this->UserWalletUpdateAzalt($userID,$email,$fromID,$alicidanDus);
			if($aliciFromWallet->getModifiedCount()!=1){
				$this->logger->write( "exchangeError", "trade", "(".microtime().") trade işleminde alıcı aldığının karşılığını ödemedi : ,exchange_id : ".$sellID."  ,exchange_user_id : ".$userID."  ,Miktar : ".Number($alinanUnit,20)."From".$fromShort." To".$toShort);
			}
			$aciklama = 
			lang($type).' '.lang("ordersucnow").'<br>'
			.lang("amount").' : '.$alinanUnit.' '.$toShort.'<br>'
			.lang("price").' : '.$sellPrice.' '.$fromShort.'<br>'
			.lang("total").' : '.Number($alinanUnit*$sellPrice,20).' '.$fromShort.'<br>'
			.lang("time").' : '.date("H:i:s").'<br>';
			$this->tradeDataInsert($fromID,$toID,$toShort,$fromShort,$alinanUnit,$sellPrice,$odenenTotal,$userID,$email,$type,$sellUserEmail,'taker',$commission);
			$this->createOrderBook(0,$price,$fromID,$toID,$type,$commission,$userID,$email,$unit,$toShort,$fromShort);
			$this->logger->write( "exchange", "trade", "(".microtime().") trade işleminde  : ".$userID." id nolu alıcı ".$sellUserId." id nolu satıcıdan ".Number($sellPrice,20)." fiyatından ".$alinanUnit." adet ".$fromID." id nolu coin karşılığında ".$toID." id nolu coin satın aldı. Emir kapandı.");
			return array('durum' => 'success', 'mesaj' => $aciklama,'islem' => 'orderbook','id' => $userID, 'hesap' => $email,'toid' => $sellUserId);
		
		}	
	}

	public function sellExchange($unit,$price,$fromID,$toID,$toShort,$fromShort,$type,$commission,$userID,$email,$buyOrder)
	{
		
		$buyUnit = $buyOrder[0]["exchange_unit"];
		$buyID = $buyOrder[0]["exchange_id"];
		$buyPrice = $buyOrder[0]["exchange_bid"];
		$buyUserId = $buyOrder[0]["exchange_user_id"];
		$buyUserEmail = $buyOrder[0]["exchange_user_email"];
		$buyCommission = $buyOrder[0]["exchange_comission"];
		$buyTotal = $buyOrder[0]["exchange_total"];
		$buyTime = $buyOrder[0]["exchange_created"];
		$buyType = $buyOrder[0]["exchange_type"];

		if((double)$unit>=(double)$buyUnit){
			$kalanUnit = (double)$unit-(double)$buyUnit;//sel unit bitti eğer unit 0 dan büyükse tekrar et
			$satilanUnit  = (double)$unit-(double)$kalanUnit;
			$odenenTotal = Number(((double)$satilanUnit*(double)$buyPrice)*(double)$commission,20);
			$saticiyaOde = Number(((double)$satilanUnit*(double)$buyPrice)*(double)$commission,20);
			

			//satıcının emrini güncelle
			$this->mongo_db->where(array('exchange_id' => (string)$buyID, 'exchange_user_id' => (string)$buyUserId,'exchange_user_email' => (string)$buyUserEmail,'exchange_created' => (int)$buyTime));
			$this->mongo_db->set('exchange_status',(int)0);
			$this->mongo_db->set('exchange_unit',(double)0);
			$this->mongo_db->set('exchange_completed',(int)time());
			$saticiEmir = $this->mongo_db->update('exchange_datas');
			if($saticiEmir->getModifiedCount()!=1){
				$this->logger->write( "exchangeError", "trade", "(".microtime().") trade işleminde alıcının emri güncellenmedi : ,exchange_id : ".$buyID."  ,exchange_user_id : ".$buyUserId." ,Miktar : ".Number($odenenTotal,20)." From ".$fromShort." To ".$toShort);
			}
				//alıcıya to coin öde
				$saticiFromWallet = $this->UserWalletUpdateArttir($buyUserId,$buyUserEmail,$toID,$satilanUnit);
				$this->tradeDataInsert($fromID,$toID,$toShort,$fromShort,$buyUnit,$buyPrice,$buyTotal,$buyUserId,$buyUserEmail,$buyType,$email,'maker',$buyCommission);
				if($saticiFromWallet->getModifiedCount()!=1){
					$this->logger->write( "exchangeError", "trade", "(".microtime().") trade işleminde alıcı almak istediğini alamadı : ,exchange_id : ".$buyID."  ,exchange_user_id : ".$buyUserId."  ,Miktar : ".Number($buyTotal,20)."From".$fromShort." To".$toShort);
				};
				//satıcı from coin öde
				$aliciToWallet = $this->UserWalletUpdateArttir($userID,$email,$fromID,$saticiyaOde);
				if($aliciToWallet->getModifiedCount()!=1){
					$this->logger->write( "exchangeError", "trade", "(".microtime().") trade işleminde satıcı sattığının karşılığını alamadı : ,exchange_id : ".$buyID."  ,exchange_user_id : ".$userID."  ,Miktar : ".Number($satilanUnit,20)."From".$fromShort." To".$toShort);
				};
				//satıcı to coini azalt
				$aliciFromWallet = $this->UserWalletUpdateAzalt($userID,$email,$toID,$satilanUnit);
				if($aliciFromWallet->getModifiedCount()!=1){
					$this->logger->write( "exchangeError", "trade", "(".microtime().") trade işleminde satıcı sattığı miktarı ödemedi : ,exchange_id : ".$buyID."  ,exchange_user_id : ".$userID."  ,Miktar : ".Number($satilanUnit,20)."From".$fromShort." To".$toShort);
				}
					if($kalanUnit >0){
						$buyOrder = $this->orderSellKontrol($toID,$fromID,$price);
						if(!empty($buyOrder)){
							$aciklama = 
							lang($type).' '.lang("ordersucnow").'<br>'
							.lang("amount").' : '.$satilanUnit.' '.$toShort.'<br>'
							.lang("price").' : '.$buyPrice.' '.$fromShort.'<br>'
							.lang("total").' : '.Number($satilanUnit*$buyPrice,20).' '.$fromShort.'<br>'
							.lang("time").' : '.date("H:i:s").'<br>';
							$tekrarla = $this->sellExchange($kalanUnit,$price,$fromID,$toID,$toShort,$fromShort,$type,$commission,$userID,$email,$buyOrder);
							$this->tradeDataInsert($fromID,$toID,$toShort,$fromShort,$satilanUnit,$buyPrice,$odenenTotal,$userID,$email,$type,$buyUserEmail,'taker',$commission);
							$this->logger->write( "exchange", "trade", "(".microtime().") trade işleminde  : ".$userID." id nolu satıcı ".$buyUserId." id nolu alıcıya ".Number($buyPrice,20)." fiyatından ".$unit." adet ".$fromID." id nolu coin karşılığında ".$toID." id nolu coini satmak istedi ama alıcının miktarı(".$buyUnit.") yetmedi ve emir tekrar etti.");
							return array('durum' => 'success', 'mesaj' => $aciklama,'islem' => 'orderbook','id' => $userID, 'hesap' => $email,'toid' => $buyUserId);
						}else{
							$aciklama = 
							lang($type).' '.lang("ordersucnow").'<br>'
							.lang("amount").' : '.$satilanUnit.' '.$toShort.'<br>'
							.lang("price").' : '.$buyPrice.' '.$fromShort.'<br>'
							.lang("total").' : '.Number($satilanUnit*$buyPrice,20).' '.$fromShort.'<br>'
							.lang("time").' : '.date("H:i:s").'<br>';
							$this->tradeDataInsert($fromID,$toID,$toShort,$fromShort,$satilanUnit,$buyPrice,$odenenTotal,$userID,$email,$type,$buyUserEmail,'taker',$commission);
							$this->createOrderBook($kalanUnit,$price,$fromID,$toID,$type,$commission,$userID,$email,$unit,$toShort,$fromShort);
							$this->logger->write( "exchange", "trade", "(".microtime().") trade işleminde  : ".$userID." id nolu satıcı ".$buyUserId." id nolu alıcıya ".Number($buyPrice,20)." fiyatından ".$satilanUnit." adet ".$fromID." id nolu coin karşılığında ".$toID." id nolu coin sattı. Alıcının miktarı yetmedi ve eşleşen bir fiyat olmadığı için ".$kalanUnit." adet satış emri açıldı.");
							return array('durum' => 'success', 'mesaj' => $aciklama,'islem' => 'orderbook','id' => $userID, 'hesap' => $email,'toid' => $buyUserId);
						}
					}else{
							$aciklama = 
							lang($type).' '.lang("ordersucnow").'<br>'
							.lang("amount").' : '.$satilanUnit.' '.$toShort.'<br>'
							.lang("price").' : '.$buyPrice.' '.$fromShort.'<br>'
							.lang("total").' : '.Number($satilanUnit*$buyPrice,20).' '.$fromShort.'<br>'
							.lang("time").' : '.date("H:i:s").'<br>';
							$this->tradeDataInsert($fromID,$toID,$toShort,$fromShort,$satilanUnit,$buyPrice,$odenenTotal,$userID,$email,$type,$buyUserEmail,'taker',$commission);
							$this->createOrderBook(0,$price,$fromID,$toID,$type,$commission,$userID,$email,$unit,$toShort,$fromShort);
							$this->logger->write( "exchange", "trade", "(".microtime().") trade işleminde  : ".$userID." id nolu satıcı ".$buyUserId." id nolu alıcıya ".Number($buyPrice,20)." fiyatından ".$satilanUnit." adet ".$fromID." id nolu coin karşılığında ".$toID." id nolu coin sattı. Emir kapandı.");
							return array('durum' => 'success', 'mesaj' => $aciklama,'islem' => 'orderbook','id' => $userID, 'hesap' => $email,'toid' => $buyUserId);
					}
		}else{
			$kalanUnit = 0;//unit bitti 
			$satilanUnit  = $unit;
			$odenenTotal = Number(((double)$satilanUnit*(double)$buyPrice)*(double)$buyCommission,20);
			$saticiyaOde = Number(((double)$satilanUnit*(double)$buyPrice)*(double)$commission,20);
			$BkalanUnit = Number(((double)$buyUnit-(double)$unit),20);//unit bitti
			$BkalanTotal = Number(((double)$BkalanUnit*(double)$buyPrice)*(double)$commission,20);
			//return array('durum' => 'success', 'mesaj' => 'işlem tamamlandi : '.$alinanUnit);
			 
			//satıcının emrini güncelle
			$this->mongo_db->where(array('exchange_id' => (string)$buyID, 'exchange_user_id' => (string)$buyUserId,'exchange_user_email' => (string)$buyUserEmail,'exchange_created' => (int)$buyTime));
			$this->mongo_db->set('exchange_status',(int)1);
			$this->mongo_db->set('exchange_unit',(double)$BkalanUnit);
			$this->mongo_db->set('exchange_total',(double)$BkalanTotal);
			$this->mongo_db->set('exchange_completed',null);
			$saticiEmir = $this->mongo_db->update('exchange_datas');
			if($saticiEmir->getModifiedCount()!=1){
				$this->logger->write( "exchangeError", "trade", "(".microtime().") trade işleminde alıcının emri güncellenmedi : ,exchange_id : ".$buyID."  ,exchange_user_id : ".$buyUserId." From ".$fromShort." To".$toShort);
			}
			
			//satıcıya from coin öde
			$saticiFromWallet = $this->UserWalletUpdateArttir($buyUserId,$buyUserEmail,$toID,$satilanUnit);
			$this->tradeDataInsert($fromID,$toID,$toShort,$fromShort,$satilanUnit,$buyPrice,$odenenTotal,$buyUserId,$buyUserEmail,$buyType,$email,'maker',$buyCommission);
			if($saticiFromWallet->getModifiedCount()!=1){
				$this->logger->write( "exchangeError", "trade", "(".microtime().") trade işleminde satıcı sattığının karşılığını almadı : ,exchange_id : ".$buyID."  ,exchange_user_id : ".$buyUserId."  ,Miktar : ".Number($buyTotal,20)."From".$fromShort." To".$toShort);
			};
			//alıcıya to coin öde
			$aliciToWallet = $this->UserWalletUpdateArttir($userID,$email,$fromID,$saticiyaOde);
			if($aliciToWallet->getModifiedCount()!=1){
				$this->logger->write( "exchangeError", "trade", "(".microtime().") trade işleminde alıcı almak istediğini alamadı : ,exchange_id : ".$buyID."  ,exchange_user_id : ".$userID."  ,Miktar : ".Number($satilanUnit,20)."From".$fromShort." To".$toShort);
			};
			//alıcının from coini azalt
			$aliciFromWallet = $this->UserWalletUpdateAzalt($userID,$email,$toID,$satilanUnit);
			if($aliciFromWallet->getModifiedCount()!=1){
				$this->logger->write( "exchangeError", "trade", "(".microtime().") trade işleminde alıcı aldığının karşılığını ödemedi : ,exchange_id : ".$buyID."  ,exchange_user_id : ".$userID."  ,Miktar : ".Number($satilanUnit,20)."From".$fromShort." To".$toShort);
			}
			$aciklama = 
			lang($type).' '.lang("ordersucnow").'<br>'
			.lang("amount").' : '.$satilanUnit.' '.$toShort.'<br>'
			.lang("price").' : '.$buyPrice.' '.$fromShort.'<br>'
			.lang("total").' : '.Number($satilanUnit*$buyPrice,20).' '.$fromShort.'<br>'
			.lang("time").' : '.date("H:i:s").'<br>';
			$this->tradeDataInsert($fromID,$toID,$toShort,$fromShort,$satilanUnit,$buyPrice,$saticiyaOde,$userID,$email,$type,$buyUserEmail,'taker',$commission);
			$this->createOrderBook(0,$price,$fromID,$toID,$type,$commission,$userID,$email,$unit,$toShort,$fromShort);
			$this->logger->write( "exchange", "trade", "(".microtime().") trade işleminde  : ".$userID." id nolu satıcı ".$buyUserId." id nolu alıcıya ".Number($buyPrice,20)." fiyatından ".$satilanUnit." adet ".$fromID." id nolu coin karşılığında ".$toID." id nolu coin sattı. Emir kapandı.");
			return array('durum' => 'success', 'mesaj' => $aciklama,'islem' => 'orderbook','id' => $userID, 'hesap' => $email,'toid' => $buyUserId);
		
		}	
	}

	public function orderDelete($id,$socketId)
	{
		$userID = $_SESSION['user_data'][0]['user_id'];
		$email = $_SESSION['user_data'][0]['user_email'];

		$array = array( 
			'exchange_id' => (string)$socketId,
			'exchange_created' => (int)$id,  
			'exchange_user_id' => (string)$userID,
			'exchange_user_email' => (string)$email,
			'exchange_status' => (int)1
		);
		$this->mongo_db->limit(1);
		$this->mongo_db->where($array);
		$order = $this->mongo_db->get('exchange_datas');
		if(!empty($order)){
			if($order[0]["exchange_type"]=="buy"){
				$iade = ($order[0]["exchange_bid"]*$order[0]["exchange_unit"])*$order[0]["exchange_comission"];
				$walletID = $order[0]["exchange_from_wallet_id"];
			}elseif($order[0]["exchange_type"]=="sell"){
				$iade = $order[0]["exchange_unit"];
				$walletID = $order[0]["exchange_to_wallet_id"];
			}else{
				return array('durum' => 'error', 'mesaj' => lang("hata").' 204');
			}
			$array2Up = array( 
				'exchange_id' => (string)$socketId,
				'exchange_created' => (int)$id,  
				'exchange_user_id' => (string)$userID,
				'exchange_user_email' => (string)$email,
				'exchange_status' => (int)1
			);
			$this->mongo_db->where($array2Up);
			$this->mongo_db->set('exchange_status',(int)0);
			$this->mongo_db->set('exchange_completed',(int)time());
			$cancel = $this->mongo_db->update('exchange_datas');
		
			/*$delarray = array( 
				'exchange_id' => (string)$socketId,
				'exchange_created' => (int)$id,  
				'exchange_user_id' => (string)$userID,
				'exchange_user_email' => (string)$email,
			);
			$this->mongo_db->where($delarray);
			$cancel = $this->mongo_db->delete('exchange_datas');*/
			//if($cancel->getDeletedCount()==1){
			if($cancel->getModifiedCount()==1){
				$this->mongo_db->where(array('wallet_user_id' => (string)$userID, 'wallet_user_email' => (string)$email,'wallet_id' => (int)$walletID));
				$this->mongo_db->inc('wallet_user_balance',$iade);
				$kontrol = $this->mongo_db->update('user_wallet_datas');
				if($kontrol->getModifiedCount()==1){
					return array('durum' => 'success', 'mesaj' => lang($order[0]["exchange_type"]).' '.lang("ordercancelnow"),'islem' => 'orderbook','id' => $userID, 'hesap' => $email);
				}return array('durum' => 'error', 'mesaj' => lang("hata").' 205');
			}return array('durum' => 'error', 'mesaj' => lang("hata").' 206');
		}else{return array('durum' => 'error', 'mesaj' => lang("hata").' 207');}
	}

	public function UserWalletUpdateArttir($userID,$email,$walletID,$amount)
	{
		//$this->mongo_db->limit(1);
		$walletKontrol = getUserWalletKontrol($walletID,$userID,$email);
		if($walletKontrol){
		$amount = Number($amount,20);
		//$this->mongo_db->limit(1);
		$this->mongo_db->where(array('wallet_user_id' => (string)$userID, 'wallet_user_email' => (string)$email,'wallet_id' => (int)$walletID));
		$this->mongo_db->inc('wallet_user_balance',(double)$amount);
		$update = $this->mongo_db->update('user_wallet_datas');
		if($update->getModifiedCount()==1){
		return $update;
		}
		}
	}

	public function UserWalletUpdateAzalt($userID,$email,$walletID,$amount)
	{	
		//$this->mongo_db->limit(1);
		$walletKontrol = getUserWalletKontrol($walletID,$userID,$email);
		if($walletKontrol){
		$amount = Number($amount,20);
		//$this->mongo_db->limit(1);
		$this->mongo_db->where(array('wallet_user_id' => (string)$userID, 'wallet_user_email' => (string)$email,'wallet_id' => (int)$walletID));
		$this->mongo_db->inc('wallet_user_balance',-(double)$amount);
		$update = $this->mongo_db->update('user_wallet_datas');
		if($update->getModifiedCount()==1){
		return $update;
		}
		}
	}

	public function tradeDataInsert($fromID,$toID,$toShort,$fromShort,$unit,$price,$total,$userID,$email,$type,$toUserEmail,$rol,$commission)
	{	
		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('trade_id'=>'desc'));
		$sonID = $this->mongo_db->get('trade_datas');
		if(!empty($sonID)){
			$veri = array(
				'trade_id' => (int)($sonID[0]["trade_id"]+1),
				'trade_from_wallet_id' => (int)$fromID,
				'trade_to_wallet_id' => (int)$toID,
				'trade_from_wallet_short' => (string)$fromShort,
				'trade_to_wallet_short' => (string)$toShort,
				'trade_user_id'=> (string)$userID,
				'trade_user_email' => (string)$email,
				'trade_bid' => (double)$price,
				'trade_unit' => (double)$unit,
				'trade_total' => (double)$total,
				'trade_commission' => (double)$commission,
				'trade_type' => (string)$type,
				'trade_to_user_email' => (string)$toUserEmail,
				'trade_exchange_rol' => (string)$rol,
				'trade_created' => (int)time(),
				'invoice_id' => (string)"0",
			);
			$insert = $this->mongo_db->insert('trade_datas',$veri);
			if(count($insert)){
			$this->updateLastPriceAndChange($fromID,$toID,$toShort,$price,$type);
			}
			$veri2 = array(
				'trade_from_wallet_id' => (int)$fromID,
				'trade_to_wallet_id' => (int)$toID,
				'trade_unit' => (double)$unit,
				'trade_total' => (double)$total,
				'trade_created' => (int)time(),
			);
			$insert2 = $this->mongo_db->insert('volume_datas',$veri2);

			$this->mongo_db->where_lte('trade_created',time()-86400);
			$cancel = $this->mongo_db->delete_all('volume_datas');
		}		
	}

	public function updateLastPriceAndChange($fromID,$toID,$toShort,$price,$type)
	{	
		$array1 = array( 
			'trade_from_wallet_id' => (int)$fromID,
			'trade_to_wallet_id' => (int)$toID,  
			'trade_to_wallet_short' => (string)$toShort
		);
		$array3 = array( 
			'trade_from_wallet_id' => (int)$fromID,
			'trade_to_wallet_id' => (int)$toID,  
			'trade_to_wallet_short' => (string)$toShort,
			'trade_exchange_rol' => "taker"
		);
		
		$arrayVol = array( 
			'trade_from_wallet_id' => (int)$fromID,
			'trade_to_wallet_id' => (int)$toID,
		);

		$date1 = time()-86400;
		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('trade_created'=>'asc'));
		$this->mongo_db->where($array1);
		$this->mongo_db->where_gte('trade_created',(int)$date1);
		$ilkFiyat = $this->mongo_db->get('trade_datas');

		$date2 = time();
		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('trade_created'=>'desc'));
		$this->mongo_db->where($array1);
		$this->mongo_db->where_lte('trade_created',(int)$date2);
	  	$ikinciFiyat = $this->mongo_db->get('trade_datas');
		$yuzde = (($ikinciFiyat[0]["trade_bid"]-$ilkFiyat[0]["trade_bid"])/$ilkFiyat[0]["trade_bid"])*100;


		$this->mongo_db->where($arrayVol);
		$this->mongo_db->where_gte('trade_created',(int)$date1);
		$hacim = $this->mongo_db->get('volume_datas');
		$totalVol = 0;
		$totalQuoteVol = 0;
		foreach ($hacim as $key ) {
			$totalVol = $totalVol+$key["trade_total"];
			$totalQuoteVol = $totalQuoteVol+$key["trade_unit"];
		}

		$date1 = time()-86400;
		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('trade_bid'=>'asc'));
		$this->mongo_db->where($array1);
		$this->mongo_db->where_gte('trade_created',(int)$date1);
		$enDusukfiyat = $this->mongo_db->get('trade_datas');

		$date1 = time()-86400;
		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('trade_bid'=>'desc'));
		$this->mongo_db->where($array1);
		$this->mongo_db->where_gte('trade_created',(int)$date1);
		$enYuksekfiyat = $this->mongo_db->get('trade_datas');

		$array2 = array( 
			'from_wallet_id' => (int)$fromID,
			'to_wallet_id' =>(int) $toID,  
			'to_wallet_short' => (string)$toShort
			);
		$this->mongo_db->where($array2);
		$this->mongo_db->set('to_wallet_last_trade_date',(int)time());
		$this->mongo_db->set('to_wallet_last_price',(double)$price);
		$this->mongo_db->set('last_trade',$type);
		$this->mongo_db->set('to_walet_24_low',(double)$enDusukfiyat[0]["trade_bid"]);
		$this->mongo_db->set('to_wallet_24_high',(double)$enYuksekfiyat[0]["trade_bid"]);
		$this->mongo_db->set('to_wallet_24h_vol',(double)Number($totalVol,4));
		$this->mongo_db->set('to_wallet_24h_quote_vol',(double)Number($totalQuoteVol,4));
		$this->mongo_db->set('change',Number($yuzde,2));
		$this->mongo_db->update('market_datas');	
	}
}
 ?>