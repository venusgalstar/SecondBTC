<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bot_model extends CI_Model {

	public function botVeri()
	{	
		$this->mongo_db->where("bot_status",(int)1);
		 $varmi = $this->mongo_db->get('bot_datas');
		$bul = count($varmi);
		$rand = rand(0,$bul-1);
		return $varmi{$rand};
	}

	public function botVeriMan($fromShort,$toShort)
	{	
		$this->mongo_db->where("bot_status",(int)1);
		$this->mongo_db->where("bot_from_short",$fromShort);
		$this->mongo_db->where("bot_to_short",$toShort);
		$varmi = $this->mongo_db->get('bot_datas');
		return $varmi{0};
	}

	public function ayniFiyatSor($from,$to,$fiyat,$type)
	{	
		$arraybul = array(
		'exchange_from_short' => (string)$from,
		'exchange_to_short' => (string)$to,
		'exchange_bid' => (double)Number($fiyat,8),
		'exchange_type' => (string)$type,
		'exchange_status' => (int)1,
		);
		$this->mongo_db->limit(1);
		$this->mongo_db->where($arraybul);
		return $bul = $this->mongo_db->get('exchange_datas');
	}

	public function deleteAllBuy($from,$to,$bids,$userEmail,$userId)
	{	
		$delarray = array( 
			'exchange_user_email' => (string)$userEmail,  
			'exchange_user_id' => (string)$userId,
			'exchange_type' => (string)"buy",
			'exchange_from_short' => (string)$from,
			'exchange_to_short' => (string)$to,
		);
		$this->mongo_db->where($delarray);
		$this->mongo_db->where_gte('exchange_bid',(double)Number($bids,8));
		$cancel = $this->mongo_db->delete_all('exchange_datas');
	}

	public function deleteEski($userEmail,$userId)
	{	
		$delarray = array( 
			'exchange_user_email' => (string)$userEmail,  
			'exchange_user_id' => (string)$userId,
		);
		$this->mongo_db->where($delarray);
		$this->mongo_db->where_lte('exchange_created',time()-864000);
		$cancel = $this->mongo_db->delete_all('exchange_datas');

		$delarray0 = array( 
			'exchange_user_email' => (string)"bot",  
			'exchange_user_id' => (string)"bot",
		);
		$this->mongo_db->where($delarray0);
		$this->mongo_db->where_lte('exchange_created',time()-864000);
		$this->mongo_db->delete_all('exchange_datas');

		$delarray2 = array( 
			'trade_user_id' => (string)"bot",  
			'trade_user_email' => (string)"bot",
		);
		$this->mongo_db->where($delarray2);
		$this->mongo_db->where_lte('trade_created',time()-864000);
		$this->mongo_db->delete_all('trade_datas');
	}

	public function ucuzSellVarmi($from,$to,$bids)
	{	
		$this->mongo_db->order_by(array('exchange_bid'=>'asc'));
		$this->mongo_db->order_by(array('exchange_created'=>'asc'));
		$arraybul = array(
		'exchange_from_short' => (string)$from,
		'exchange_to_short' => (string)$to,
		'exchange_type' => (string)"sell",
		'exchange_status' => (int)1,
		);
		$this->mongo_db->limit(1);
		$this->mongo_db->where($arraybul);
		$this->mongo_db->where_lte('exchange_bid',(double)Number($bids,8));
		return $bul = $this->mongo_db->get('exchange_datas');
	}

	public function deleteAllSell($from,$to,$asks,$userEmail,$userId)
	{	
		$delarray = array( 
			'exchange_user_email' => (string)$userEmail,  
			'exchange_user_id' => (string)$userId,
			'exchange_type' => (string)"sell",
			'exchange_from_short' => (string)$from,
			'exchange_to_short' => (string)$to,
		);
		$this->mongo_db->where($delarray);
		$this->mongo_db->where_lte('exchange_bid',(double)Number($asks,8));
		$cancel = $this->mongo_db->delete_all('exchange_datas');
	}

	public function pahaliBuyVarmi($from,$to,$asks)
	{	
		$this->mongo_db->order_by(array('exchange_bid'=>'desc'));
		$this->mongo_db->order_by(array('exchange_created'=>'asc'));
		$arraybul = array(
		'exchange_from_short' => (string)$from,
		'exchange_to_short' => (string)$to,
		'exchange_type' => (string)"buy",
		'exchange_status' => (int)1,
		);
		$this->mongo_db->limit(1);
		$this->mongo_db->where($arraybul);
		$this->mongo_db->where_gte('exchange_bid',(double)Number($asks,8));
		return $bul = $this->mongo_db->get('exchange_datas');
	}

	public function insertOrder($from,$to,$fromID,$toID,$bids,$unit,$type,$userEmail,$userId,$durum)
	{	
		
		if($userId!="bot" && $durum==1){
			//$this->load->model('exchange_model');
			$_SESSION["deneme"] = "aa".$userId;
			$result = $this->exchange_model->tradeKontrolBot($unit,$bids,$fromID,$toID,$to,$from,$type,$userEmail,$userId);
		
			if($bids>=0.00000001  && $unit>=0.00000001  && $result=="notok"){ 
			$unit = $unit;
			$veri = array(
				'exchange_id' => (string)uretken(28),
				'exchange_from_wallet_id' => (int)$fromID,
				'exchange_from_short' => (string)$from,
				'exchange_to_wallet_id' => (int)$toID,
				'exchange_to_short' => (string)$to,
				'exchange_user_id'=> (string)$userId,
				'exchange_user_email' => (string)$userEmail,
				'exchange_bid' => (double)Number($bids,8),
				'exchange_first_unit' => (double)Number($unit,8),
				'exchange_unit' => (double)Number($unit,8),
				'exchange_total' => (double)Number($unit*$bids,8),
				'exchange_comission' => (double)1,
				'exchange_type' => (string)$type,
				'exchange_status' => (int)1,
				'exchange_created' => (int)time(),
				'exchange_completed' => (int)0,
				'exchange_bot_type' => (int)1
			);
			$insert = $this->mongo_db->insert('exchange_datas',$veri);
			}
		}else{
			
			if($bids>=0.00000001  && $unit>=0.00000001 ){
			$veri = array(
				'exchange_id' => (string)uretken(28),
				'exchange_from_wallet_id' => (int)$fromID,
				'exchange_from_short' => (string)$from,
				'exchange_to_wallet_id' => (int)$toID,
				'exchange_to_short' => (string)$to,
				'exchange_user_id'=> (string)$userId,
				'exchange_user_email' => (string)$userEmail,
				'exchange_bid' => (double)Number($bids,8),
				'exchange_first_unit' => (double)Number($unit,8),
				'exchange_unit' => (double)Number($unit,8),
				'exchange_total' => (double)Number(($unit*$bids),8),
				'exchange_comission' => (double)1,
				'exchange_type' => (string)$type,
				'exchange_status' => (int)1,
				'exchange_created' => (int)time(),
				'exchange_completed' => (int)0,
				'exchange_bot_type' => (int)1
			);
			$insert = $this->mongo_db->insert('exchange_datas',$veri);
			/*if(count($insert)){
				$_SESSION["deneme"] = "aa---zzasasasas".Number($bids,8);
			}*/
			}
		}
	}

	public function insertOrderOther($from,$to,$fromID,$toID,$bids,$unit,$type,$userEmail,$userId)
	{	
			if($bids>=0.00000001 && $unit>=0.00000001 && is_numeric($bids)){ 
			$veri = array(
				'exchange_id' => (string)uretken(28),
				'exchange_from_wallet_id' => (int)$fromID,
				'exchange_from_short' => (string)$from,
				'exchange_to_wallet_id' => (int)$toID,
				'exchange_to_short' => (string)$to,
				'exchange_user_id'=> (string)$userId,
				'exchange_user_email' => (string)$userEmail,
				'exchange_bid' => (double)Number($bids,8),
				'exchange_first_unit' => (double)Number($unit,8),
				'exchange_unit' => (double)Number($unit,8),
				'exchange_total' => (double)Number($unit*$bids,8),
				'exchange_comission' => (double)1,
				'exchange_type' => (string)$type,
				'exchange_status' => (int)1,
				'exchange_created' => (int)time(),
				'exchange_completed' => (int)0,
				'exchange_bot_type' => (int)1
			);
			$insert = $this->mongo_db->insert('exchange_datas',$veri);
			}
		
	}

	public function insertTrade($from,$to,$fromID,$toID,$bids,$unit,$type)
	{	
		if($bids>0 && $unit>0 ){ 
		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('trade_id'=>'desc'));
		$sonID = $this->mongo_db->get('trade_datas');
		if(!empty($sonID)){$yeniID = $sonID{0}["trade_id"]+1;}else{$yeniID = 1;}
		$total = $bids*$unit;
		if($total>=0.00000001 && is_numeric($bids)){
		$veri = array(
			'trade_id' => (int)$yeniID,
			'trade_from_wallet_id' => (int)$fromID,
			'trade_to_wallet_id' => (int)$toID,
			'trade_from_wallet_short' => (string)$from,
			'trade_to_wallet_short' => (string)$to,
			'trade_user_id'=> (string)"bot",
			'trade_user_email' => (string)"bot",
			'trade_bid' => (double)Number($bids,8),
			'trade_unit' => (double)Number($unit,8),
			'trade_total' => (double)Number($unit*$bids,8),
			'trade_commission' => (int)1,
			'trade_type' => (string)$type,
			'trade_to_exchange_id' => (string)"bot",
			'trade_exchange_rol' => (string)"taker",
			'trade_created' => (int)time(),
		);
		$insert = $this->mongo_db->insert('trade_datas',$veri);
		$veri2 = array(
			'trade_from_wallet_id' => (int)$fromID,
			'trade_to_wallet_id' => (int)$toID,
			'trade_unit' => (double)Number($unit,8),
			'trade_total' => (double)Number($unit*$bids,8),
			'trade_created' => (int)time(),
		);
		$insert2 = $this->mongo_db->insert('volume_datas',$veri2);
		
		$this->mongo_db->where_lte('trade_created',time()-86400);
		$cancel = $this->mongo_db->delete_all('volume_datas');

		if(count($insert)){
			$this->updateLastPriceAndChange($fromID,$toID,$to,$bids,$type);
		}
		}
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
		if(!empty($ilkFiyat) && !empty($ikinciFiyat)){
		$yuzde = (($ikinciFiyat{0}["trade_bid"]-$ilkFiyat{0}["trade_bid"])/$ilkFiyat{0}["trade_bid"])*100;
		}else{$yuzde = 0.00;}

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
		$this->mongo_db->set('to_walet_24_low',(double)$enDusukfiyat{0}["trade_bid"]);
		$this->mongo_db->set('to_wallet_24_high',(double)$enYuksekfiyat{0}["trade_bid"]);
		$this->mongo_db->set('to_wallet_24h_vol',(double)Number($totalVol,4));
		$this->mongo_db->set('to_wallet_24h_quote_vol',(double)Number($totalQuoteVol,4));
		$this->mongo_db->set('change',Number($yuzde,2));
		$this->mongo_db->update('market_datas');	
	}
	
	
    
}
