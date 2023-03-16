<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {

	public function __construct() {
		parent::__construct();
		header('X-Frame-Options: SAMEORIGIN');
		// if(siteSetting()["site_status"]!=1 && $_SESSION['key']!="admin_bakim"){redirect('/maintenance');}
		dilBul();
	}

	public function index()
	{
		if($_SESSION['user_data'][0]['user_email']){
		$userInfo = $this->account_model->getUser($_SESSION['user_data'][0]['user_email']);
		$userAct = $this->account_model->getUserAct($_SESSION['user_data'][0]['user_email']);
		$userInfoDetail = $this->account_model->getUserInfoDetail($_SESSION['user_data'][0]['user_email']);
		$data = array(
			"user_google_key" => yeniSifreCoz($userInfo{0}["user_google_key"]),
			"user_login_conf" => $userInfo{0}["user_login_conf"],
			"user_with_conf" => $userInfo{0}["user_with_conf"],
			"user_google_conf" => $userInfo{0}["user_google_conf"],
			"user_ip" => $userInfo{0}["user_ip"],
			"user_act" => $userAct,
			"userInfoDetail" => $userInfoDetail,
		);
		$data["googleQR"] = $this->googleauthenticator->getQRCodeGoogleUrl(base_url(), siteSetting()["site_name"].":".$_SESSION['user_data'][0]['user_email'], $data["user_google_key"]);

			$this->load->view('account',$data);
			

		}else{redirect('/login');}
	}
	public function register()
	{	
		if($this->input->post('email') && $this->input->post('pass') && $this->input->post('rpass')){
			if(recaptcha($_POST['g-recaptcha-response'])!=1){
				$this->session->set_flashdata('hata', lang("robot"));
				redirect('/pass_email');
				}else{
			$this->form_validation->set_rules("email", "Email address", "trim|required|valid_email");
			$this->form_validation->set_rules("pass", "Password", "trim|required|max_length[50]|min_length[8]|matches[rpass]");
        	$this->form_validation->set_rules("rpass", "Confirm password (Tekrar)", "required|trim");
 
        $this->form_validation->set_message(
            array(
                "required"      => "{field} ".lang("bosluk"),
                "valid_email"   => "{field} ".lang("emailformat"),
                "matches"       => "{field} ".lang("repasserror"),
                "max_length"    => "{field} ".lang("maxkarakter"),
                "min_length"    => "{field} ".lang("passminerror"),
            )
        );
        if ($this->form_validation->run()){ 
			$email = strtolower($this->input->post('email'));
			$pass = $this->input->post('pass');
			$rpass = $this->input->post('rpass');
			$email = trim($email);
			$email=  $this->security->xss_clean($email);
			$insert = $this->account_model->insertUser($email,$pass,$rpass);

			if($insert=="var"){
				$this->session->set_flashdata('hata', lang("useraddready"));
				redirect('/register');
			}elseif($insert=="tamam"){
				$this->session->set_flashdata('onay', lang("congratulations").'<br>'.lang("pleaseemailconf"));
				$this->account_model->userActivity($email,'Register');
				redirect('/alertpage');
			}elseif($insert=="pass1"){
				$this->session->set_flashdata('hata', lang("passminerror"));
				redirect('/register');
			}elseif($insert=="pass"){
				$this->session->set_flashdata('hata', lang("repasserror"));
				redirect('/register');
			}else{
				$this->session->set_flashdata('hata', lang("hata").' 101'); 
				redirect('/register');
			}
        }else{
            $this->load->view('account/register');
		}}
		}else{
			$this->load->view('account/register');
		}
		
	}
	public function login()
	{
			if($this->input->post('email') && $this->input->post('pass')){
				if(recaptcha($_POST['g-recaptcha-response'])!=1){
					$this->session->set_flashdata('hata', lang("robot"));
					redirect('/login');
				}else{
				if(get_cookie('blokemail')!=strtolower($this->input->post('email')) || get_cookie('blokezaman')<time()){
					set_cookie('blokemail','',0);
					set_cookie('blokezaman','',0);
					set_cookie('yasak','0',0);

			$this->load->library("form_validation");
			$this->form_validation->set_rules("email", "Email address", "trim|required|valid_email");
			$this->form_validation->set_rules("pass", "Password", "trim|required|max_length[50]");
			$this->form_validation->set_message(
				array(
					"required"      => "{field} ".lang("bosluk"),
                	"valid_email"   => "{field} ".lang("emailformat"),
					"max_length"    => "{field} ".lang("maxkarakter"),
				)
			);
			if ($this->form_validation->run()){
				$email = strtolower($this->input->post('email'));
				$pass = $this->input->post('pass');
				$varmi = $this->account_model->getUser($email);
				$email=  $this->security->xss_clean($email);
				if(!empty($varmi)){
				$sorgu = $this->account_model->getUserlogin($email,$pass);
				if(!empty($sorgu)){
					if($sorgu{0}["user_email_conf"]=="1"){
						if($sorgu{0}["user_login_conf"]=="M"){
							$this->account_model->getUserMailCodeGuncelle(strtolower($email),lang('login'));
							$this->session->set_userdata(array(
								'gecici_email' => strtolower($email),
								'gecici_pass' => $pass,
								'gecici_system'=>$sorgu{0}["user_login_conf"],
								'user_id'=>$sorgu{0}{"user_id"},
								'girissecenegi' => lang("emaillogincode")));
							redirect('/logincode');
						}elseif($sorgu{0}["user_login_conf"]=="G"){
							$this->session->set_userdata(array(
								'gecici_email' => strtolower($email),
								'gecici_pass' => $pass,
								'gecici_system'=> $sorgu{0}["user_login_conf"],
								'gecici_google_key' => $sorgu{0}["user_google_key"],
								'user_id'=> $sorgu{0}{"user_id"},
								'girissecenegi' => lang("2falogincode")));
							redirect('/logincode');
						}
					}else{
						$this->session->set_flashdata('extra', 'tekrarmail');
						$this->session->set_flashdata('email_onay', strtolower($email));
						$this->session->set_flashdata('hata', lang("pleaseemailconf"));
						$this->account_model->userActivity(strtolower($email),lang("loginerror").' '.lang("accountconf"));
						redirect('/login');
					}
				}else{ 
					$this->session->set_flashdata('hata', lang("emailpasserror"));
					$this->account_model->userActivity(strtolower($email),lang("loginerror").' '.lang("emailpasserror"));
					redirect('/login');}
				}else{ 
					$this->session->set_flashdata('hata', lang("notaccount"));
					redirect('/login');}
			   
			}else{
				$this->load->view("account/login");
			}
			}else{
				$this->session->set_flashdata('hata', lang("accountbloke").' '.date("i:s",(get_cookie('blokezaman')-time())).' '.lang("bloketime"));
				redirect('/login');
			}
			}
		}elseif($this->input->post('tekrarmail') && $this->input->post('temail')){
			$sor = $this->account_model->getUser(strtolower($this->input->post('temail')));
			$kontrol = $this->email_model->email_confirm($sor{0}['user_conf_key'],$this->input->post('temail'));
			if($sor){
				$this->session->set_flashdata('onay', lang("emailconfagain"));
				$this->account_model->userActivity(strtolower($this->input->post('email')),lang("emailconfagain"));
				redirect('/login');
			}else{
				redirect('/login');
			}
		}else{
			$this->load->view('account/login');
		}

		
	}
	public function logincode()
	{		
			$email = $this->session->userdata('gecici_email');
			$pass = $this->session->userdata('gecici_pass');
			$system = $this->session->userdata('gecici_system');
			$key = $this->session->userdata('gecici_google_key');
			$code= addslashes($this->input->post('code'));
			$email=  $this->security->xss_clean($email);
		if($this->input->post('buttonCode') && $this->input->post('code')){
			if(is_numeric($code)){
			$sorgu = $this->account_model->getUserLoginConfirm(strtolower($email),$pass,$code,$system,yeniSifreCoz($key));
			if($sorgu=="bloke"){
				redirect('/login');
			}elseif($sorgu=="hata"){
				$this->load->view("account/code_page");
			}elseif($sorgu=="tamam"){
				$this->session->unset_userdata(array('gecici_email','gecici_pass','gecici_system','gecici_google_key'));
				$this->session->set_userdata('user_data', $this->account_model->getUserlogin(strtolower($email),$pass));
				redirect('/market');
			}else{
				redirect('/login');
			}
		}else{
			redirect('/login');
		}
		}elseif(strtolower($email)!='' && $pass!=''){
			$this->load->view('account/code_page');
		}else{
			redirect('/login');
		}
	}
	public function emailonay()
	{	if($this->input->get('token')){
		$gelen = str_replace(' ', '+', $this->input->get('token'));
		$sorgu = $this->account_model->getUserMailConf($gelen);
			if($sorgu=='tamam'){
				$this->session->set_flashdata('onay', lang("accconfsuc"));
				redirect('/login');
			}elseif($sorgu=='confok'){
				$this->session->set_flashdata('hata', lang("accountconfok"));
				redirect('/login');
			}else{
				$this->session->set_flashdata('hata', lang("notconflink"));
				redirect('/login');
			}
		}else{
			redirect('/login');
		}
	}
	public function passsendmail()
	{	
		if($this->input->post('email')){
			if(recaptcha($_POST['g-recaptcha-response'])!=1){
			$this->session->set_flashdata('hata', lang("robot"));
			redirect('/forgotpassword');
			}else{

			$email = strtolower($this->input->post('email'));
			$email=  $this->security->xss_clean($email);
			$sorgu = $this->account_model->getUserpassLink($email);
			if($sorgu=="tamam"){
				redirect('/login');
			}else{
				redirect('/login');
			}}
		}else{
			$this->load->view('account/pass_email');
		}
		
	}
	public function password()
	{
		$token = str_replace(' ', '+', $this->input->get('token'));
		if($this->input->get('token') && !$this->input->post('passupdate')){
			$this->session->set_flashdata('onay', '');
			$sorgu = $this->account_model->getUserPassConf($token);
			if($sorgu=="tamam"){
				$this->load->view('account/passUpdate');
			}else{
				redirect('/login');
			}
			
		}elseif($this->input->post('pass') && $this->input->post('rpass') && $this->input->post('passupdate') && $this->input->post('token')){
			$pass = $this->input->post('pass');
			$rpass = $this->input->post('rpass');
			
			$this->form_validation->set_rules("pass", "Password", "trim|required|max_length[50]|min_length[8]|matches[rpass]");
        	$this->form_validation->set_rules("rpass", "Confirm password (Tekrar)", "required|trim");
 
        	$this->form_validation->set_message(
            array(
                "required"      => "{field} ".lang("bosluk"),
                "matches"       => "{field} ".lang("repasserror"),
                "max_length"    => "{field} ".lang("maxkarakter"),
                "min_length"    => "{field} ".lang("passminerror"),
            )
        	);
			if ($this->form_validation->run()){ 
				$sorgu = $this->account_model->getUserPassUpdate($token,$pass,$rpass);
				if($_SESSION['user_data'][0]['user_email']!=''){
					redirect('/account');
				}else{
					redirect('/login');
				}
			}else{
				$this->load->view('account/passUpdate');
			}
		}else{
			redirect('/login');
		}
		
	}
	public function logout()
	
	{	
		$this->account_model->userActivity($_SESSION['user_data'][0]['user_email'],'Exit');
		unset($_SESSION['user_data']);
		//$this->session->sess_destroy();
			redirect('/');
		
	}
	public function uyarısayfası()
	{
		$this->load->view('alert_page');
	}
	public function ipupdate()
	{	
		if($_SESSION['user_data'][0]['user_email']){
		$email = strtolower($_SESSION['user_data'][0]['user_email']);
			if(!empty($email)){
				$userID = $_SESSION['user_data'][0]['user_id'];
				$user_ip = $this->input->post("user_ip");
				$islem = $this->input->post("islem");
				$code = $this->input->post("code");
				$email=  $this->security->xss_clean($email);
					if(getUserMailCodeKontrol($email,$code)=='ok'){
						if($islem=="kaydet"){$user_ip = $user_ip;}elseif($islem=="sil"){$user_ip = "DISABLED";}
						$update = $this->account_model->userIpUpdate($userID,$email,$user_ip);
							if($update=="tamam"){
								$data = array("durum" => "success","mesaj"=> lang("processingsuccess"));
							}else{$data = array("durum" => "error","mesaj"=> lang("hata").' 102');}
					}else{$data = array("durum" => "error","mesaj"=> lang("codeerror")); }
			}else{$data = array("durum" => "error","mesaj"=> lang("hata").' 103');}
		}else{
			$data = array("durum" => "error","mesaj"=> lang("hata").' 104');
			redirect('/login');
		}
		echo json_encode($data);
	}
	public function ipupdateemail()
	{	
		$secret = yeniSifreCoz($this->input->post("id"));
		if($_SESSION['user_data'][0]['user_email'] && $secret==$_SESSION['user_data'][0]['user_id']){
		$email = strtolower($_SESSION['user_data'][0]['user_email']);
		$this->account_model->getUserMailCodeGuncelle($email,lang('accountpage'));
		}else{
			redirect('/login');
		}
	}

	public function passupdateS()
	{	
		$secret = yeniSifreCoz($this->input->post("id"));
		if($_SESSION['user_data'][0]['user_email'] && $secret==$_SESSION['user_data'][0]['user_id']){
		$email = strtolower($_SESSION['user_data'][0]['user_email']);
		$kontrol=$this->account_model->getUserpassLink($email);
		if($kontrol=="tamam"){
			$data = array("durum" => "success","mesaj"=> lang("processingsuccess"));
		}else{
			$data = array("durum" => "error","mesaj"=> lang("hata").' 105');
		}
		}else{
			$data = array("durum" => "error","mesaj"=> lang("hata").' 106');
			redirect('/login');
		}
		echo json_encode($data);
	}
	
	public function twofasetting()
	{	
		
		$email = strtolower($_SESSION['user_data'][0]['user_email']);
		$tercih = $this->input->post("tercih");
		$code = $this->input->post("code");
		$key = $this->input->post("key");
		$email=  $this->security->xss_clean($email);
		if($email && $tercih && $code && $key){
			if($tercih=="E"){
				if(getUserGoogleCodeKontrol($key, $code)=='ok'){
					$this->account_model->getUser2faaktif($email,"1");
					$data = array("durum" => "success","mesaj"=> lang("processingsuccess"));
				}else{
					$data = array("durum" => "error","mesaj"=> lang("codeerror"));
				}
			}elseif($tercih=="D"){
				if(getUserGoogleCodeKontrol($key, $code)=='ok'){
					$this->account_model->getUser2faaktif($email,"0");
					$data = array("durum" => "success","mesaj"=> lang("processingsuccess"));
				}else{
					$data = array("durum" => "error","mesaj"=> lang("codeerror"));
				}
			}
		}else{
			$data = array("durum" => "error","mesaj"=> lang("hata").' 107');
		}
		echo json_encode($data);
	}
	public function confirmoption()
	{	
		$email = strtolower($_SESSION['user_data'][0]['user_email']);
		$islem = $this->input->post("islem");
		$tercih = $this->input->post("tercih");
		if($email && $tercih && $islem){
		$update =	$this->account_model->guvenlikTercihi($email,$islem,$tercih);
			if($update=="tamam"){
				$data = array("durum" => "success","mesaj"=> lang("processingsuccess"));
			}else{
				$data = array("durum" => "error","mesaj"=> lang("hata").' 108');
			}
		}else{
			$data = array("durum" => "error","mesaj"=> lang("hata").' 109');
			redirect('/login');
		}
		echo json_encode($data);
	}

	public function infoupdate()
	{	
		$email = strtolower($_SESSION['user_data'][0]['user_email']);
		if(!empty($email)){
			$userID = $_SESSION['user_data'][0]['user_id'];
			$firsname = $this->input->post("firsname");
			$middlename = $this->input->post("middlename");
			$lastname = $this->input->post("lastname");
			$ulke = $this->input->post("ulke");
			$sehir = $this->input->post("sehir");
			$semt = $this->input->post("semt");
			$address = $this->input->post("address");
			$idnumber = $this->input->post("idnumber");
			$telefon = $this->input->post("telefon");
			$dogum = $this->input->post("dogum");
			$code = $this->input->post("code");
				if(getUserMailCodeKontrol($email,$code)=='ok'){
					if($ulke=="Türkiye"){
						if(TCcheck($idnumber,$firsname,$middlename,$lastname,date("Y", strtotime($dogum)))==true){
							$update = $this->account_model->userInfoUpdate($userID,$email,$firsname,$middlename,$lastname,$ulke,$sehir,$semt,$address,$idnumber,$telefon,$dogum);
							if($update=="ok"){
								$data = array("durum"=>"success", "mesaj"=> lang("processingsuccess"));
							}else{
								$data = array("durum"=>"info", "mesaj"=> lang("notchange"));
							}
						}else{
							$data = array("durum"=>"error", "mesaj"=> lang("errordatas").' '.lang("notidnumber"));
						}
					}else{
						$update = $this->account_model->userInfoUpdate($userID,$email,$firsname,$middlename,$lastname,$ulke,$sehir,$semt,$address,$idnumber,$telefon,$dogum);
						if($update=="ok"){
							$data = array("durum"=>"success", "mesaj"=> lang("processingsuccess"));
						}else{
							$data = array("durum"=>"error", "mesaj"=> lang("hata").' 110');
						}
					}
				}else{
					$data = array("durum"=>"error", "mesaj"=> lang("codeerror"));
				}
		}else{
			$data = array("durum"=>"error", "mesaj"=> lang("hata").' 111');
			redirect('/login');
		}
		echo json_encode($data);
	}
}