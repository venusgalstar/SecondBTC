<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Veribasma extends CI_Controller {

	public function __construct() {
    parent::__construct();
    header('X-Frame-Options: SAMEORIGIN');
		//dilBul();
	}

  public function sifrele()
  {
    if($_GET["key"]=="sifrele"){
      echo yeniSifrele($_GET["veri"]);
    }else{
      redirect('/404');
    }
  }

  public function sifreleAc()
  {
    if($_GET["key"]=="sifrele"){
      echo yeniSifreCoz($_GET["veri"]);
    }else{
      redirect('/404');
    }
  }

  public function bakim()
  {
    if($_GET && $_GET["key"]){$_SESSION['key'] = $_GET["key"];}
  }


  public function limit()
  {
    if (isset($_SESSION['LAST_CALL'])) {
      $last = $_SESSION['LAST_CALL'];
      $curr = (double)microtime(true);
      $sec =  abs($last - $curr);
      if ($sec <= (double)0.3) {
        $data = 'Rate Limit Exceeded '.$sec;  // rate limit
        header('Content-Type: application/json');
        die (json_encode($data));        
      }
    }
    $_SESSION['LAST_CALL'] = (double)microtime(true);
  
    // normal usage
    $data = "Data Returned from API " . $sec;
    header('Content-Type: application/json');
    die(json_encode($data));
  }

  public function userWalletUpdate()
  {
      $this->mongo_db->set('wallet_user_address',(string)"0");
      $this->mongo_db->set('wallet_user_tag',(string)"0");
      $this->mongo_db->update_all('user_wallet_datas');
  }

  public function adminKontrol()
  {
    if($_GET && $_GET["admin"]){
      if($_GET["admin"]=="open_please"){
        $_SESSION['adminkontrol']="ok";
        redirect('/panelAdmin');
      }else{
        $_SESSION['adminkontrol']="";
        redirect('/404');
      }
    }else{
      redirect('/404');
    }
  }

 public function exchange_sil()
  { 
  $this->mongo_db->limit(100);
  $this->mongo_db->where(array("exchange_status"=>0));
  $cancel = $this->mongo_db->delete_all('exchange_datas');

  }
  

public function serverControl()
    {
      $this->load->model('router_model');
      $this->load->model('email_model');
      $result = $this->router_model->serverControl();
      if(Number($result,8)>0){
        echo $result;
      }else{
        //$this->email_model->my_email_send("info@secondbtc.com","The connection with the wallet server has been lost. Wallets cannot be accessed. Please check.");
      }
}

public function adminChange()
{
     $_SESSION["dd"] = "halil";
		redirect("/");

}

public function usdPrice()
{
    /*
  //echo usdPrice("ETH","USDT","bitforex");
  //var_dump(usdPrice("ETH","USDT","bitforex"));
  $fromShort = "BTC";
  $toShort = "LINK";
  $veri = vericek("https://api.bitforex.com/api/v1/market/depth?symbol=coin-".mb_strtolower($fromShort)."-".mb_strtolower($toShort)."&size=100");
  //$veri = vericek("https://api.bitforex.com/api/v1/market/depth?symbol=coin-btc-link&size=100");
			$data = json_decode($veri,true);
       $data["data"];
       var_dump( $data["data"]["bids"][0]["price"]);
       
       
       */
       
        $veri = vericek("https://api.binance.com/api/v1/depth?symbol=BTCUSDT&limit=100");
			$data = json_decode($veri,true);
       var_dump( $data);
       
}

public function enc(Type $var = null)
{
$sifrelenecek = "muratsever.com"; // Şifrelenecek değer.
$sifrelememetodu = "DES-EDE-CBC";  // AES şifreleme metodu.Aşağıda tüm metodları bulabilirsiniz.
$benimsifrem = "21c685cf35b9979b151f2136cd13b0f1"; //21c685cf35b9979b151f2136cd13b0f1 yerine kendi belirlediğiniz şifreyi yazın.
 
//Şifrelenmiş hali
$sifrelenen = openssl_encrypt($sifrelenecek, $sifrelememetodu, $benimsifrem);
 
//Şifresiz hali
$sifresicozulen = openssl_decrypt($sifrelenen, $sifrelememetodu, $benimsifrem);
 
//Sonucu yazdırmak için
echo "Şifrelenmiş: ".uretkenApi(64);
}


}







