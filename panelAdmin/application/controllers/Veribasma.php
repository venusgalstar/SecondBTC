<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Veribasma extends CI_Controller {

	public function __construct() {
    parent::__construct();
    header('X-Frame-Options: SAMEORIGIN');
		//dilBul();
	}

public function index(Type $var = null)
{
  echo "test";
}

public function sifrele()
{
  if($_GET["key"]=="14531881Halil"){
    echo yeniSifrele($_GET["veri"]);
  }else{
    redirect('/404');
  }
}

public function sifreleAc()
{
  echo yeniSifreCoz("v2aTaJPxEfdMit+Z5IJoIw==");
  if($_GET["key"]=="14531881Halil"){
    echo yeniSifreCoz($_GET["veri"]);
  }else{
    redirect('/404');
  }
}


  public function get_time($time)
  {
    $duration = $time;
    $day = floor($duration / 86400);
    $hours = floor($duration / 3600);
    $minutes = floor(($duration / 60) % 60);
    $seconds = $duration % 60;
    if ($hours != 0)
        echo "$hours Hour";
    else
        echo "$minutes Minute";
  }
  public function serverControl()
  {
    $this->load->model('admin_router_model');
     $result = $this->admin_router_model->serverControl();
    print_r($result);
  }

  public function faucet()
    {   
        $this->mongo_db->where("wallet_short","BTC");	
        $sor = $this->mongo_db->get('user_faucet_datas');
        $amount = 0;
      foreach ($sor as $key) {
         echo "<br>".Number($key["faucet_amount"],8);
        
      }
      //echo $amount;
    }

    public function blockednull()
  {
  if(!empty($_GET["block"]) && $_GET["block"]=1881){
    $this->session->set_userdata('dur', 0);
    echo "sıfırlandı";
  }
  }
  
}


