<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_fiat_model extends CI_Model {

    public function bankBul()
	{
        $sor = $this->mongo_db->get('banka_datas');
        if(!empty($sor)){
            return $sor;
        }else{
            return $sor;
        }
    }
    public function bankBul2($bankId)
	{
        $this->mongo_db->where(array('banka_id'=>(string)$bankId));
        $sor = $this->mongo_db->get('banka_datas');
        if(!empty($sor)){
            return $sor;
        }else{
            return "bos";
        }
    }

    public function bankSil($bankId)
	{
        $this->mongo_db->where('banka_id',(string)$bankId);
		$delete = $this->mongo_db->delete('banka_datas');
		if($delete->getDeletedCount()==1){
            return "ok";
        }else{
            return "hata";
        }
    }
    
    public function fiatBul()
	{
        $this->mongo_db->where(array('wallet_system'=>"fiat"));
        $sor = $this->mongo_db->get('wallet_datas');
        if(!empty($sor)){
            return $sor;
        }else{
            return "bos";
        }
    }

    public function bankInsert($bankID,$fiatShort,$bankName,$bankIban,$bankHesap)
	{
        $this->mongo_db->where(array('banka_id'=>(string)$bankID));
        $sor = $this->mongo_db->get('banka_datas');
        if(!empty($sor)){
            $this->mongo_db->where(array('banka_id' => $bankID));
            $this->mongo_db->set("fiat_short",(string)$fiatShort);
            $this->mongo_db->set("banka_name",(string)$bankName);
            $this->mongo_db->set("banka_iban",(string)$bankIban);
            $this->mongo_db->set("banka_hesap",(string)$bankHesap);
            $update = $this->mongo_db->update('banka_datas');
            if($update->getModifiedCount()==1){
                $this->session->set_flashdata('onay', 'New bank update success!');
                redirect('/fiat');
            }else{
                $this->session->set_flashdata('hata', 'New bank update error!');
                redirect('/fiat');
            }
        }else{
        $array2 = array(
            'banka_id' => (string)$bankID,
            'fiat_short' => (string)$fiatShort,
            'banka_name' => (string)$bankName,
            'banka_iban' => (string)$bankIban,
            'banka_hesap' => (string)$bankHesap,
            'banka_status' => (int)0,
           );
           $insert = $this->mongo_db->insert('banka_datas',$array2);
           if(count($insert)){
           $this->session->set_flashdata('onay', 'New bank insert success!');
           redirect('/fiat');
          }else{
               $this->session->set_flashdata('hata', 'New bank insert error!');
               redirect('/fiat');
          }
        }
    }
}

