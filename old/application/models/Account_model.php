<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account_model extends CI_Model {

	public function getUser($email)
	{
		$email = addslashes($email);
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('user_email'=>(string)strtolower($email)));
		$sor = $this->mongo_db->get('user_datas');
		return $sor;
	}
	public function getUserByAddress($address)
	{
		$address = addslashes($address);
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('user_address'=>(string)($address)));
		$sor = $this->mongo_db->get('user_datas');
		return $sor;
	}
	public function getUserInfoDetail($email)
	{
		$email = addslashes($email);
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('user_email'=>(string)$email));
		$sor = $this->mongo_db->get('user_info_datas');
		return $sor;
	}
	public function getUserAct($email)
	{
		$email = addslashes($email);
		$this->mongo_db->order_by(array('act_date'=>'desc'));
		$this->mongo_db->where(array('act_email'=>(string)$email));
		$sor = $this->mongo_db->get('user_activity_datas');
		return $sor;
	}
	public function getUserlogin($email,$pass)
	{
		$email = addslashes($email);
		$Newpass = parolaSifrele($pass);
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('user_email'=>(string)strtolower($email),'user_pass'=>(string)$Newpass));
		$sor = $this->mongo_db->get('user_datas');
		return $sor;
	}
	public function getUserMailCodeGuncelle($email,$islem="")
	{	
		$code = emailCode();
		$md5Code = md5($code);
		$email = addslashes($email);
		$this->email_model->code_email($code,$email,$islem);
		$this->mongo_db->where('user_email',(string)$email);
		$this->mongo_db->set('user_mailcode',$md5Code);
		$this->mongo_db->update('user_datas');
		//return $sor;
	}
	

	public function getUserLoginConfirm($email,$pass,$code,$system,$key)
	{
		if($system=="M"){
			$sorgu = getUserMailCodeKontrol((string)$email,(string)$code);
		}elseif($system=="G"){
			$sorgu = getUserGoogleCodeKontrol((string)$key, (string)$code);
		}else{return "farklı";}
			if($sorgu=='ok'){
				$this->userActivity((string)$email,'Login');
				return "tamam";
			}else{ 
				if(get_cookie('yasak')==10){
					$this->session->set_flashdata('hata', lang("bigerrorologin").' '.lang("accountbloke"));
					set_cookie('blokemail',$email,time()+900);
					set_cookie('blokezaman',time()+900,time()+900);
					$this->userActivity($email,lang("bigerrorologin").' '.lang("accountbloke"));
					return "bloke";
				}else{
					$this->session->set_flashdata('hata', lang("codeerror").' '.(10-get_cookie('yasak')).' '.lang("bloketime"));
					set_cookie('yasak',get_cookie('yasak')+1,time()+50);
					$this->userActivity($email,lang("loginerror").' '.lang("codeerror"));
					return "hata";
				}
			}
	}
	public function insertUser($email,$pass,$rpass)
	{
		$email = addslashes($email);
		$Newpass = parolaSifrele($pass);
		$googlesecretkey = createGoogleKey();
		$emailconf = yeniSifrele($email);
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('user_email'=>(string)$email));
		$sor = $this->mongo_db->get('user_datas');
		if(!empty($sor)){
			return "var";
		}else{
			if(validatePass($pass)=="ok"){
			if($pass===$rpass){
				$veri = array(
					'user_id'=>uretken(28),
					'user_email'=>(string)strtolower($email),
					'user_pass'=>(string)$Newpass,
					'user_mailcode'=>md5(emailCode()),
					'user_create'=>(int)time(),
					'user_ex_status'=>(int)1,
					'user_wallet_status'=>(int)1,
					'user_login_status'=>(int)1,
					'user_conf_key'=>(string)$emailconf,
					'user_with_conf'=>(string)"M",
					'user_login_conf'=>(string)"M",
					'user_google_key'=>yeniSifrele($googlesecretkey),
					'user_google_conf'=>(int)0,
					'user_referans_code'=>uretken(10),
					'user_email_conf'=>(int)0,
					'user_free_trade'=>(int)0,
					'user_api_key'=> (string)uretken(8)."-".uretken(4)."-".uretken(4)."-".uretken(4)."-".uretken(12),
					'user_ip'=> (string)"DISABLED",
				);
			$insert = $this->mongo_db->insert('user_datas',$veri);
			if(count($insert)){
				$this->email_model->email_confirm($emailconf,$email);
				return "tamam";
			}else{return "hata";}
			}else{return "pass";}
			}else{return "pass1";}
		}
	}
	public function getUserMailConf($gelen)
	{
		$gelen = addslashes($gelen);
		$email = yeniSifreCoz($gelen);
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('user_email'=>(string)strtolower($email),'user_email_conf'=>(int)1));
		$kontrol = $this->mongo_db->get('user_datas');
		if(!empty($kontrol)){
			return "confok";
		}else{
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('user_email'=>(string)strtolower($email),'user_conf_key'=>(string)$gelen));
		$sor = $this->mongo_db->get('user_datas');
		if(!empty($sor)){
		$this->mongo_db->where('user_email',(string)strtolower($email));
		$this->mongo_db->where('user_email_conf',(int)0);
		$this->mongo_db->set('user_email_conf',(int)1);
		$this->mongo_db->set('user_conf_key',yeniSifrele($gelen));
		$this->mongo_db->update('user_datas');
		$this->userActivity((string)strtolower($email), lang("emailconf"));
		return "tamam";
		}else{
			return "hata";
			$this->userActivity((string)strtolower($email), lang("notconflink"));
		}
		}
	}
	public function getUserpassLink($email)
	{
		$email = addslashes($email);
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('user_email'=>(string)$email));
		$sor = $this->mongo_db->get('user_datas');
		if(!empty($sor)){
			$code = yeniSifrele(emailCode().$email);
			$this->email_model->pass_update($code,$email);
			$this->mongo_db->where('user_email',(string)$email);
			$this->mongo_db->set('user_conf_key',sha1($code));
			$update = $this->mongo_db->update('user_datas');
			if($update){
				$this->session->set_flashdata('onay', lang("sendemailok"));
				$this->session->set_userdata('pass_reset_email', $email);
				$this->account_model->userActivity((string)$email,lang("passconfcode"));
				return "tamam";
			}else{
				$this->session->set_flashdata('hata', lang("hata").' 118');
				return "hata";
			}
				
		}else{
			$this->session->set_flashdata('hata', lang("notaccount"));
			return "hata";
		}
	}
	public function getUserPassConf($gelen)
	{
		$gelen = addslashes($gelen);
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('user_conf_key'=>sha1($gelen)));
		$sor = $this->mongo_db->get('user_datas');
		if(!empty($sor)){
			return "tamam";
		}else{
			$this->session->set_flashdata('hata', lang("passresetemail"));
			$this->account_model->userActivity($sor{0}["user_email"],lang("passresetemail"));
			return "hata";
		}
	}
	public function getUserPassUpdate($token,$pass,$rpass)
	{
		$gelen = addslashes($token);
		$Newpass = parolaSifrele($pass);
		if($pass===$rpass){
			$this->mongo_db->where(array('user_conf_key'=>sha1($gelen)));
			$this->mongo_db->set('user_conf_key',yeniSifrele($gelen));
			$this->mongo_db->set('user_pass',(string)$Newpass);
			$update = $this->mongo_db->update('user_datas');
			if($update){
				$this->session->set_flashdata('onay', lang("passchangesuccess"));
				$this->account_model->userActivity($this->session->userdata('pass_reset_email'),lang("passchangesuccess"));
				return "tamam";
			}
			
		}else{
			return "hata";
		}
		
	}
	public function userActivity($email,$act)
	{
		if(!empty($email) && $email!=null){
		$email = addslashes($email);
		$activite = parolaSifrele($act);
			$veri = array(
				'act_email'=>(string)$email,
				'act_title'=>(string)$act,
				'act_ip'=> GetIP(),
				'act_browser'=>$_SERVER["HTTP_USER_AGENT"],
				'act_date'=>time()
			);
			return $insert = $this->mongo_db->insert('user_activity_datas',$veri);
		}
	}
	public function userIpUpdate($userID,$email,$user_ip)
	{
		$email = addslashes($email);
		$user_ip = addslashes($user_ip);
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('user_id'=>(string)$userID,"user_email"=>(string)$email));
		$sor = $this->mongo_db->get('user_datas');
		if(!empty($sor)){
			$this->mongo_db->where(array('user_id'=>(string)$userID,"user_email"=>(string)$email));
			$this->mongo_db->set('user_ip',(string)$user_ip);
			$this->mongo_db->update('user_datas');
		return "tamam";
		}else{
			return "yok";
		}
	}
	public function getUser2faaktif($email,$durum)
	{
		$email = addslashes($email);
		$durum = addslashes($durum);
		if($durum==0){
			$googlesecretkey = $this->googleauthenticator->createSecret();
			$this->mongo_db->where(array('user_email'=>(string)$email));
			$this->mongo_db->set('user_google_conf',(int)$durum);
			$this->mongo_db->set('user_login_conf',(string)"M");
			$this->mongo_db->set('user_with_conf',(string)"M");
			$this->mongo_db->set('user_google_key',yeniSifrele($googlesecretkey));
			$update = $this->mongo_db->update('user_datas');
		}elseif($durum==1){
			$this->mongo_db->where(array('user_email'=>(string)$email));
			$this->mongo_db->set('user_google_conf',(int)$durum);
			$update = $this->mongo_db->update('user_datas');
		}
			if($update){
				return "tamam";
			}
	}
	public function guvenlikTercihi($email,$islem,$tercih)
	{
		$email = addslashes($email);
		$islem = addslashes($islem);
		$tercih = addslashes($tercih);
		if($islem=="W"){
			$this->mongo_db->where(array('user_email'=>(string)$email));
			$this->mongo_db->set('user_with_conf',(string)$tercih);
			$update = $this->mongo_db->update('user_datas');
		}elseif($islem=="L"){
			$this->mongo_db->where(array('user_email'=>$email));
			$this->mongo_db->set('user_login_conf',(string)$tercih);
			$update = $this->mongo_db->update('user_datas');
		}
			if($update){
				return "tamam";
			}
	}

	public function userInfoUpdate($userID,$email,$firsname,$middlename,$lastname,$ulke,$sehir,$semt,$address,$idnumber,$telefon,$dogum)
	{
		$userID = addslashes($userID); 
		$email = addslashes($email); 
		$firsname = addslashes($firsname); 
		$middlename = addslashes($middlename); 
		$lastname = addslashes($lastname); 
		$ulke = addslashes($ulke); 
		$sehir = addslashes($sehir); 
		$semt = addslashes($semt); 
		$address = addslashes($address); 
		$idnumber = addslashes($idnumber); 
		$telefon = addslashes($telefon); 
		$dogum = addslashes($dogum); 
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('user_email'=>(string)$email,'user_id'=>(string)$userID));
		$sor = $this->mongo_db->get('user_info_datas');
		if(!empty($sor)){
			$this->mongo_db->where(array('user_email' => (string)$email, 'user_id' => (string)$userID));
			$this->mongo_db->set('user_first_name',(string)$firsname);
			$this->mongo_db->set('user_middle_name',(string)$middlename);
			$this->mongo_db->set('user_last_name',(string)$lastname);
			$this->mongo_db->set('user_country',(string)$ulke);
			$this->mongo_db->set('user_city',(string)$sehir);
			$this->mongo_db->set('user_district',(string)$semt);
			$this->mongo_db->set('user_address',(string)$address);
			$this->mongo_db->set('user_id_number',(string)$idnumber);
			$this->mongo_db->set('user_tel',(string)$telefon);
			$this->mongo_db->set('user_dogum',(string)$dogum);
			$kontrol = $this->mongo_db->update('user_info_datas');
				if($kontrol->getModifiedCount()==1){
					return "ok";
				}
		}else{
			$veri = array(
				'user_id' => (string)$userID,
				'user_email' => (string)$email,
				'user_first_name' => (string)$firsname,
				'user_middle_name' => (string)$middlename,
				'user_last_name' => (string)$lastname,
				'user_country'=> (string)$ulke,
				'user_city' => (string)$sehir,
				'user_district' => (string)$semt,
				'user_address' => (string)$address,
				'user_id_number' => (string)$idnumber,
				'user_tel' => (string)$telefon,
				'user_dogum' => (string)$dogum,
				'user_tax_id' => (string)"0",
			);
			$insert = $this->mongo_db->insert('user_info_datas',$veri);
			if(count($insert)){
				return "ok";
			}
		}
	}
}
?>