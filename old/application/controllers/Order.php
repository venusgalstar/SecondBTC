<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

	public function __construct() {
		parent::__construct();
		dilBul();
		header('X-Frame-Options: SAMEORIGIN');
		if(siteSetting()["site_status"]!=1 && $_SESSION['key']!="admin_bakim"){redirect('/maintenance');}		
		if($_SESSION['user_data'][0]['user_id']==''){redirect('/login');}
	}
	public function index()
	{

			$this->load->view('order',$data);
	}
}