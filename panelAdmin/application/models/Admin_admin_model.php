<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_admin_model extends CI_Model {

    public function getAdmin()
	{
        return $sor = $this->mongo_db->get('admin_tables');		
    }

    public function adminUpdate($email,$style,$satir,$veri)
	{
        if($style==1){$veri = (string)$veri;}elseif($style==2){$veri = (int)$veri;}
        if($satir=="admin_pass"){
            $pass = uretken(10);
            $veri = yeniSifrele($pass);
            $kontrol = $this->email_model->pass_update($pass,yeniSifreCoz($email));
        }
        if($satir=="admin_google_key"){
            $veri = (string)yeniSifrele(createGoogleKey());
        }

        $this->mongo_db->where("admin_email",$email);
        $this->mongo_db->set($satir,$veri);
        $update = $this->mongo_db->update('admin_tables');	
        if($update->getModifiedCount()==1){
            return array("durum" => "success", "mesaj" => "Admin information was updated..");
        }else{
            return array("durum" => "error", "mesaj" => "Admin information was not updated..".$update);
        }
    }

    public function addAdmin()
	{   
        $email = $this->input->post("admin_email");
		$yetki = $this->input->post("admin_yetki");
        $array2 = array(
            'admin_id' => (string)uretken(28),
            'admin_email' => (string)yeniSifrele($email),
            'admin_google_key' => (string)yeniSifrele(createGoogleKey()),
            'admin_pass' => (string)yeniSifrele(uretken(8)),
            'admin_type' => (string)"person",
            'admin_2fa_status' => (int)0,
            'admin_status' => (int)0,
            'admin_yetki' => (int)1,
           );
           $insert = $this->mongo_db->insert('admin_tables',$array2);
           if(count($insert)){
           $this->session->set_flashdata('onay', 'New admin added!');
           redirect('/admin');
          }else{
               $this->session->set_flashdata('hata', 'New admin not added!');
               redirect('/admin');
          }
    }

    public function adminActivity()
	{   
		$this->mongo_db->order_by(array('admin_activity_time'=>'desc'));
        return $sor = $this->mongo_db->get('admin_activity_datas');		
    }
}

