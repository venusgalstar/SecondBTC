<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Charts extends CI_Controller {

	public function __construct() {
		parent::__construct();
		header('X-Frame-Options: SAMEORIGIN');
		// if(siteSetting()["site_status"]!=1){redirect('/maintenance');}
		dilBul();
	}
	public function index()
	{
	}

	public function history()
	{	
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		$history = $this->carts_model->getHistory();
		echo json_encode($history);
	}
	
	public function config()
	{
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		$json = array();
		$json["supported_resolutions"] = array(
			"1", 
			"5", 
			"15", 
			"30", 
			"60", 
			"240", 
			"1D"
		);

		$json["supports_group_request"] = false;
		$json["supports_marks"] = false;
		$json["supports_search"] = true;
		$json["supports_time"] = false;
		echo json_encode($json);
	}

	public function symbols()
	{
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		$from = "";
		$to = "";
		if(isset($_GET["symbol"])){
			$symbol = $_GET["symbol"];
			$from = explode("/", $_GET["symbol"])[1];
			$to = explode("/", $_GET["symbol"])[0];
		}
		$json = array();
		$symbol = $_GET["symbol"];
		$json["name"] = $symbol;
		$json["ticker"] = $symbol;
		$json["description"] = $symbol;
		$json["type"] = "Crypto";
		$json["session"] = "24x7";
		$json["exchange"] = siteSetting()['site_name'];
		$json["listed_exchange"] = siteSetting()['site_name'];
		$json["timezone"] = "UTC";
		$json["minmov"] = 1;
		$json["pricescale"] = 100000000;
		$json["minmove2"] = 0;
		$json["fractional"] = False;
		$json["has_intraday"] = True;
		$json["supported_resolutions"] = array("1", "5", "15", "30", "60", "240", "1D");
		$json["intraday_multipliers"] = "";
		$json["has_seconds"] = False;
		$json["seconds_multipliers"] = "";
		$json["has_daily"] = True;
		$json["has_weekly_and_monthly"] = False;
		$json["has_empty_bars"] = True;
		$json["force_session_rebuild"] = "";
		$json["has_no_volume"] = False;
		$json["volume_precision"] = True;
		$json["data_status"] = "";
		$json["expired"] = "";
		$json["expiration_date"] = "";
		$json["sector"] = "";
		$json["industry"] = "";
		$json["currency_code"] = "";
		echo json_encode($json);
	}

	public function time()
	{
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		$json = array();
		$json = time();
		echo  json_encode($json);
	}

	public function search()
	{
		header("Access-Control-Allow-Origin: *");
		header("Content-Type: application/json; charset=UTF-8");
		$history = $this->carts_model->getSearch();
		echo json_encode($history);
	}
}