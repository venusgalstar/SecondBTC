<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Market extends CI_Controller {

	public function __construct() {
		parent::__construct();
		dilBul();
		header('X-Frame-Options: SAMEORIGIN');
		 if(siteSetting()["site_status"]!=1 && $_SESSION['key']!="admin_bakim"){redirect('/maintenance');}		
	}
	public function index()
	{
		$data["news"] = $this->market_model->getNews();
		$data["marketPair"] = $this->market_model->getMainWallet();
		$data["marketUst"] = $this->market_model->getWalletUst();
		$this->load->view('market',$data);

	}
}
