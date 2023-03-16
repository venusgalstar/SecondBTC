<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index_model extends CI_Model {

	public function insertSupport()
	{
        $email = addslashes($this->input->post('email'));
        $name = addslashes($this->input->post('name'));
        $subject = addslashes($this->input->post('subject'));
        $text = addslashes($this->input->post('text'));
        $name=  $this->security->xss_clean($name);
        $subject=  $this->security->xss_clean($subject);
        $name=  $this->security->xss_clean($name);
        $email=  $this->security->xss_clean($email);
        $text=  $this->security->xss_clean($text);
        if(!empty($email) && !empty($name) && !empty($subject) && !empty($text)){
            $upload = resimUpload("support");
            //if($upload["durum"]=="ok"){
            $veri = array(
                'sup_id' => uretken(28),
                'sup_name' => (string)$name,
                'sup_email' => (string)$email,
                'sup_subject' => (string)$subject,
                'sup_text' => (string)$text,
                'sup_file' => (string)$upload["data"]["file_name"],
                'sup_time' => (int)time(),
                'sup_status' => (int)1,
            );
            $insert = $this->mongo_db->insert('support_datas',$veri);
                if($insert){
                    $this->session->set_flashdata('onay', lang("supportok"));
                    redirect('/support');
                }else{
                    $this->session->set_flashdata('hata', lang("hata").' 301');
                }
            //}else{$this->session->set_flashdata('hata', $upload["error"]);}
        }else{$this->session->set_flashdata('hata', lang("bosluk"));}
    }

    public function statusWallet()
    {
        $this->mongo_db->where('wallet_status',(int)1);
	    return $this->mongo_db->get('wallet_datas');
    }
    public function statusWalletCom()
    {
        $this->mongo_db->where_ne('wallet_main_pairs',(int)0);
        $this->mongo_db->where('wallet_status',(int)1);
	    return $this->mongo_db->get('wallet_datas');
    }
    public function getNews()
	{
		$this->mongo_db->order_by(array('news_time'=>'desc'));
        $sor = $this->mongo_db->get('news_datas');	
        return $sor;
    }
    public function getNewsDetail($id)
	{
        $this->mongo_db->where('news_id',$id);
		$this->mongo_db->order_by(array('news_time'=>'desc'));
        $sor = $this->mongo_db->get('news_datas');	
        return $sor;
    }
    public function getTeam()
	{
        $this->mongo_db->order_by(array('team_sira'=>'asc'));
        $this->mongo_db->where_ne('team_sira',(int)0);        
        $sor = $this->mongo_db->get('team_datas');	
        return $sor;
    }
   /* public function getFaucet()
	{
        $this->mongo_db->order_by(array('faucet_status'=>'desc'));	
        $this->mongo_db->where('faucet_status',(int)1);        
        $sor = $this->mongo_db->get('wallet_faucet_datas');	
        return $sor;
    }*/
   /* public function userFaucetConfirm()
	{   
        $short = $this->input->post("short");
        $short=  $this->security->xss_clean($short);
        $userID = $_SESSION['user_data'][0]['user_id'];
        $email = $_SESSION['user_data'][0]['user_email'];
        $this->mongo_db->where('wallet_short',(string)$short);        
        $this->mongo_db->where('faucet_status',(int)1);        
        $sor = $this->mongo_db->get('wallet_faucet_datas');
        if(!empty($sor)){
            if(getUserFaucet($short,$sor{0}["faucet_period"])==1){
                $veri = array(
                    'faucet_user_email' => (string)$email,
                    'faucet_user_id' => (string)$userID,
                    'wallet_short' => (string)$short,
                    'faucet_time' => (int)time(),
                    'faucet_amount' => (double)$sor{0}["faucet_amount"],
                );
                $insert = $this->mongo_db->insert('user_faucet_datas',$veri);
                if(count($insert)){
                    $walletKontrol = getUserWalletKontrol($sor{0}["wallet_id"],$userID,$email);
		            if($walletKontrol){
                        $this->mongo_db->where(array('wallet_user_id' => (string)$userID, 'wallet_user_email' => (string)$email,'wallet_id' => (int)$sor{0}["wallet_id"]));
                        $this->mongo_db->inc('wallet_user_balance',(double)$sor{0}["faucet_amount"]);
                        $update = $this->mongo_db->update('user_wallet_datas');
                        if($update->getModifiedCount()==1){
                        return "ok";
                        }
                    }                    
                }
            }
        }
    }*/

    public function getMainWallet()
    {   
        $this->mongo_db->order_by(array('wallet_main_pairs'=>'asc'));
        $this->mongo_db->where('wallet_status', 1);
        $this->mongo_db->where_ne("wallet_main_pairs", 0);
        $sor = $this->mongo_db->get('wallet_datas');
        return $sor;
    }
    public function getWalletUst()
    {   
        $this->mongo_db->order_by(array('to_wallet_24h_vol'=>'desc'));
        $this->mongo_db->limit(4);
        $this->mongo_db->where_gte('to_wallet_last_trade_date', time()-86400);
        $this->mongo_db->where('market_status', 1);
        $this->mongo_db->where('wallet_status', 1);
        $sor = $this->mongo_db->get('market_datas');
        return $sor;
    }
}