<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api_model extends CI_Model
{

	public function currencies()
	{
		$this->mongo_db->where('wallet_status', 1);
		$sor = $this->mongo_db->get('wallet_datas');
		return $sor;
	}

	public function currenciesFilter($get)
	{
		$this->mongo_db->limit(1);
		$this->mongo_db->where('wallet_short', (string)$get);
		$this->mongo_db->where('wallet_status', 1);
		$sor = $this->mongo_db->get('wallet_datas');
		return $sor;
	}
	public function tokenCurrencies()
	{
		$this->mongo_db->like('wallet_cont', '0x');
		$this->mongo_db->where('wallet_status', 1);
		$sor = $this->mongo_db->get('wallet_datas');
		return $sor;
	}

	public function tickers()
	{
		$this->mongo_db->where('market_status', 1);
		$this->mongo_db->where('wallet_status', 1);
		$sor = $this->mongo_db->get('market_datas');
		return $sor;
	}

	public function tickersFilter($to, $from)
	{
		$this->mongo_db->limit(1);
		$this->mongo_db->where('wallet_status', 1);
		$this->mongo_db->where(array('to_wallet_short' => (string)$to, 'from_wallet_short' => (string)$from));
		$sor = $this->mongo_db->get('market_datas');
		return $sor;
	}
	public function tickerslowestAsk($to, $from)
	{
		$array1 = array(
			'exchange_to_short' => (string)$to,
			'exchange_from_short' => (string)$from,
			'exchange_type' => (string)"sell",
			'exchange_status' => (int)1,
		);

		$date1 = time() - 86400;
		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('exchange_bid' => 'asc'));
		$this->mongo_db->where($array1);
		$enDusSat = $this->mongo_db->get('exchange_datas');
		if (!empty($enDusSat)) {
			return $enDusSat[0]["exchange_bid"];
		} else {
			return 0;
		}
	}
	public function tickershighestBid($to, $from)
	{
		$array1 = array(
			'exchange_to_short' => (string)$to,
			'exchange_from_short' => (string)$from,
			'exchange_type' => (string)"buy",
			'exchange_status' => (int)1,
		);

		$date1 = time() - 86400;
		$this->mongo_db->limit(1);
		$this->mongo_db->order_by(array('exchange_bid' => 'desc'));
		$this->mongo_db->where($array1);
		$enYukAl = $this->mongo_db->get('exchange_datas');
		if (!empty($enYukAl)) {
			return $enYukAl[0]["exchange_bid"];
		} else {
			return 0;
		}
	}

	public function recentTrades($to, $from, $limit)
	{
		if ($limit <= 50) {
			$limit = $limit;
		} else {
			$limit = 10;
		}
		$this->mongo_db->order_by(array('trade_id' => 'desc'));
		$this->mongo_db->limit($limit);
		$this->mongo_db->where(array('trade_to_wallet_short' => (string)$to, 'trade_from_wallet_short' => (string)$from));
		$sor = $this->mongo_db->get('trade_datas');
		return $sor;
	}

	public function orderBookBids($to, $from, $limit)
	{
		if ($limit <= 50) {
			$limit = $limit;
		} else {
			$limit = 10;
		}
		$this->mongo_db->order_by(array('exchange_bid' => 'desc'));
		$this->mongo_db->limit($limit);
		$this->mongo_db->where(array('exchange_to_short' => (string)$to, 'exchange_from_short' => (string)$from, 'exchange_status' => 1, 'exchange_type' => 'buy'));
		$sor = $this->mongo_db->get('exchange_datas');
		return $sor;
	}
	public function orderBookAsks($to, $from, $limit)
	{
		if ($limit <= 100) {
			$limit = $limit;
		} else {
			$limit = 10;
		}
		$this->mongo_db->order_by(array('exchange_bid' => 'asc'));
		$this->mongo_db->limit($limit);
		$this->mongo_db->where(array('exchange_to_short' => (string)$to, 'exchange_from_short' => (string)$from, 'exchange_status' => 1, 'exchange_type' => 'sell'));
		$sor = $this->mongo_db->get('exchange_datas');
		return $sor;
	}
}
