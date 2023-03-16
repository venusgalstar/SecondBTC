<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Market_model extends CI_Model {

	public function getMainWallet()
	{	
		$this->mongo_db->order_by(array('wallet_main_pairs'=>'asc'));
		$this->mongo_db->where('wallet_status', 1);
		$this->mongo_db->where_ne("wallet_main_pairs", 0);
		$sor = $this->mongo_db->get('wallet_datas');
		return $sor;
	}
	
	public function getWalletUst()
	{	
		$this->mongo_db->order_by(array('to_wallet_24h_vol'=>'desc'));
		$this->mongo_db->limit(4);
		$this->mongo_db->where_gte('to_wallet_last_trade_date', time()-86400);
		$this->mongo_db->where('market_status', 1);
		$this->mongo_db->where('wallet_status', 1);
		$sor = $this->mongo_db->get('market_datas');
		return $sor;
	}
	
	public function getNews()
	{
		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('news_time'=>'desc'));
        $sor = $this->mongo_db->get('news_datas');	
        return $sor;
    }
    
}
