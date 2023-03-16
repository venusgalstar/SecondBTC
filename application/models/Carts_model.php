<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Carts_model extends CI_Model {

	public function getHistory()
	{	
		$fromZaman = $_GET["from"];
		$toZaman = $_GET["to"];
		$from = explode("/", $_GET["symbol"])[1];
		$to = explode("/", $_GET["symbol"])[0];

		$this->mongo_db->where(array('trade_from_wallet_short'=>$from,'trade_to_wallet_short'=>$to));
		$this->mongo_db->where_lte('trade_created',(int)$toZaman);//küçük eşit
		$this->mongo_db->where_gte('trade_created',(int)$fromZaman); //büyük eşit
		$bul = $this->mongo_db->get('trade_datas');
		if(!empty($bul)){
			foreach ($bul as $row){
				$fiyat[] = $row["trade_bid"];
				$time[] = $row["trade_created"];
				$volume[] = $row["trade_total"];
			}
			$json["c"] = $fiyat;
			$json["v"] = $volume;
			$json["s"] = "ok";
			$json["t"] = $time;
		}else{
			$json["s"] = "no_data";
		}
		return $json;

	}

	public function getSearch()
	{
		$json = array();
		$query = "";
		$limit = 30;
		if(isset($_GET["query"])){
			$query = $_GET["query"];
		}

		if(isset($_GET["limit"])){
			$limit = $_GET["limit"];
		}

				$val =$query;
				$name["description"] = $query;
				$name["exchange"] = "";
				$name["full_name"] = $query;
				$name["symbol"] = $query;
				$name["ticker"] = $query;
				$name["type"] = "";
				$json[] = $name;
			
		return $json;
	}
}