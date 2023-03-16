<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {

	public function __construct() {
		parent::__construct();
		dilBul();
		header('X-Frame-Options: SAMEORIGIN');
		if(siteSetting()["site_status"]==1){redirect('/');}
	}
	public function index()
	{
		$this->load->view('maintenance');
	}
}
