<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_user_model extends CI_Model {

  public function userSearch($userData)
	{
    $userData = addslashes($userData);
    $this->mongo_db->limit(100);
		$this->mongo_db->where('user_email',strtolower($userData));
    $sor = $this->mongo_db->get('user_datas');
    if(!empty($sor)){
        return $sor;
    }else{
      $this->mongo_db->limit(100);
      $this->mongo_db->where('user_id',$userData);
      $sor2 = $this->mongo_db->get('user_datas');
      if(!empty($sor2)){
        return $sor2;
      }else{
        return "yok";
      }
    }
  }

    public function updateUser($userid,$useremail,$colleccion,$veri,$type,$satir)
	{
        $userid = addslashes($userid);
        $useremail = addslashes($useremail);
        $colleccion = addslashes($colleccion);
        $veri = $veri;

            $this->mongo_db->where(array('user_id'=>$userid,"user_email" => $useremail));
            if($type=="2"){
                $this->mongo_db->set($satir, (double)$veri);
                $update = $this->mongo_db->update($colleccion);
            }elseif($type=="3"){
                $this->mongo_db->set($satir, (int)$veri);
                $update = $this->mongo_db->update($colleccion);
            }else{
                $this->mongo_db->set($satir, $veri);
                $update = $this->mongo_db->update($colleccion); 
            }
            
            if($update->getModifiedCount()=="1"){
            return "ok";
            }else{
                return "hata";
            }	
    }

    public function updateUserWalletBalance($userid,$useremail,$balance,$short)
	{
        $userid = addslashes($userid);
        $useremail = addslashes($useremail);
        $balance = addslashes($balance);
            $this->mongo_db->where(array('wallet_user_id'=>(string)$userid,"wallet_user_email" => (string)$useremail,"wallet_short" => (string)$short));
            $this->mongo_db->set("wallet_user_balance", (double)$balance);
            $update = $this->mongo_db->update("user_wallet_datas");
            
            if($update->getModifiedCount()=="1"){
            return "ok";
            }else{
                return "hata";
            }
    }

    public function userDepositInsert($userid,$useremail,$amount,$address,$txid,$short,$system)
	{
        $userid = addslashes($userid);
        $useremail = addslashes($useremail);
        $amount = addslashes($amount);
        $address = addslashes($address);
        $txid = addslashes($txid);
        $short = addslashes($short);
        $system = addslashes($system);

            $array2 = array(
                'dep_history_address' => (string)$address,
                'dep_history_txid' => (string)$txid,
                'dep_history_wallet_short' => (string)$short,
                'dep_history_user_id' => (string)$userid,
                'dep_history_user_email' => (string)$useremail,
                'dep_history_comfirmation' => (int)20,
                'dep_history_amount' => (double)$amount,
                'dep_history_system' => (string)$system,
                'dep_history_time' => (int)time(),
                'dep_history_tag' => "0",
                'dep_history_status' => (int)1,
               );
               $insert = $this->mongo_db->insert('deposit_history_datas',$array2);
            if(count($insert)){
                $this->mongo_db->where(array('wallet_user_id'=>$userid,"wallet_user_email" => $useremail,"wallet_short" => $short));
                $this->mongo_db->inc("wallet_user_balance", (double)$amount);
                $update = $this->mongo_db->update("user_wallet_datas");
                
                if($update->getModifiedCount()=="1"){return "ok";
                }else{return "hata";}
            }
		
    }

  public function userWithdrawInsert($userid,$useremail,$amount,$address,$txid,$short,$system,$walletid)
	{
        $userid = addslashes($userid);
        $useremail = addslashes($useremail);
        $amount = addslashes($amount);
        $address = addslashes($address);
        $txid = addslashes($txid);
        $short = addslashes($short);
        $system = addslashes($system);
        $walletid = addslashes($walletid);

            $array2 = array(
                'withdraw_id' => uretken(28),
                'withdraw_wallet_id' => (int)$walletid,
                'withdraw_address' => (string)$address,
                'withdraw_txid' => (string)$txid,
                'withdraw_wallet_short' => (string)$short,
                'withdraw_user_id' => (string)$userid,
                'withdraw_user_email' => (string)$useremail,
                'withdraw_amount' => (double)$amount,
                'withdraw_commission' => (double)0,
                'withdraw_tag' => "0",
                'withdraw_system' => (string)$system,
                'withdraw_time' => (int)time(),
                'withdraw_cont' => "0",
                'withdraw_status' => (int)1,
               );
               $insert = $this->mongo_db->insert('withdraw_history_datas',$array2);
            if(count($insert)){
                $this->mongo_db->where(array('wallet_user_id'=>$userid,"wallet_user_email" => $useremail,"wallet_short" => $short));
                $this->mongo_db->inc("wallet_user_balance", -(double)$amount);
                $update = $this->mongo_db->update("user_wallet_datas");
                
                if($update->getModifiedCount()=="1"){return "ok";
                }else{return "hata";}
            }
		
    }

    public function userDeleteAddress($userid,$useremail,$address,$short)
	{
        $userid = addslashes($userid);
        $useremail = addslashes($useremail);
        $address = addslashes($address);
        $short = addslashes($short);

        $this->mongo_db->where(array('wallet_user_id'=>(string)$userid,"wallet_user_email" => (string)$useremail,"wallet_short" => (string)$short,"wallet_user_address" => (string)$address));
        $this->mongo_db->set("wallet_user_address", "0");
        $this->mongo_db->set("wallet_user_tag", "0");
        $update = $this->mongo_db->update("user_wallet_datas");
        
        if($update->getModifiedCount()=="1"){return "ok";
        }else{return "hata";}
		
    }

    public function userStatusKontrol($userid,$useremail)
  {
    //alış emirleri
    $userAlis = array(
      array('$match' => array('exchange_user_email' => (string)$useremail,"exchange_user_id"=> (string)$userid,"exchange_type"=>"buy","exchange_status"=>1)),
      array('$group' => array("_id" => '$exchange_from_short', "amount" => array('$sum' => '$exchange_total'))),
      array('$sort' =>  array('_id' => 1))
      );
    $sor["allResult"]["userAlis"] =  $this->mongo_db->aggregate('exchange_datas', $userAlis);

      //satış emirleri
    $userSatis = array(
      array('$match' => array('exchange_user_email' => (string)$useremail,"exchange_user_id"=> (string)$userid,"exchange_type"=>"sell","exchange_status"=>1)),
      array('$group' => array("_id" => '$exchange_to_short', "amount" => array('$sum' => '$exchange_unit'))),
      array('$sort' =>  array('_id' => 1))
    );
    $sor["allResult"]["userSatis"] =  $this->mongo_db->aggregate('exchange_datas', $userSatis);

      //depozitolar
    $userDep = array(
      array('$match' => array('dep_history_user_email' => (string)$useremail,"dep_history_user_id"=> (string)$userid,"dep_history_status"=>1)),
      array('$group' => array("_id" => '$dep_history_wallet_short', "amount" => array('$sum' => '$dep_history_amount'))),
      array('$sort' =>  array('_id' => 1))
    );
    $sor["allResult"]["userDep"] =  $this->mongo_db->aggregate('deposit_history_datas', $userDep);

    $userWith = array(
      array('$match' => array('withdraw_user_email' => (string)$useremail,"withdraw_user_id"=> (string)$userid,"withdraw_status"=>1)),
      array('$group' => array("_id" => '$withdraw_wallet_short', "amount" => array('$sum' => '$withdraw_amount'),"withCom" => array('$sum' => '$withdraw_commission'))),
      array('$sort' =>  array('_id' => 1))
    );
    $sor["allResult"]["userWith"] =  $this->mongo_db->aggregate('withdraw_history_datas', $userWith);

    $userWallet = array(
      array('$match' => array('wallet_user_email' => (string)$useremail,"wallet_user_id"=> (string)$userid)),
      array('$group' => array("_id" => '$wallet_short', "amount" => array('$sum' => '$wallet_user_balance'))),
      array('$sort' =>  array('_id' => 1))
    );
    $sor["allResult"]["userWallet"] =  $this->mongo_db->aggregate('user_wallet_datas', $userWallet);

    $tradeAlis = array(
      array('$match' => array('trade_user_email' => (string)$useremail,"trade_user_id"=> (string)$userid,"trade_type"=>"buy")),
      array('$group' => array("_id" => '$trade_from_wallet_short', "amount" => array('$sum' => '$trade_total'))),
      array('$sort' =>  array('_id' => 1))
    );
    $sor["allResult"]["tradeAlis"] =  $this->mongo_db->aggregate('trade_datas', $tradeAlis);

    $tradeSatis = array(
      array('$match' => array('trade_user_email' => (string)$useremail,"trade_user_id"=> (string)$userid,"trade_type"=>"sell")),
      array('$group' => array("_id" => '$trade_to_wallet_short', "amount" => array('$sum' => '$trade_unit'))),
      array('$sort' =>  array('_id' => 1))
    );
    $sor["allResult"]["tradeSatis"] =  $this->mongo_db->aggregate('trade_datas', $tradeSatis);

    $tradeSatisK = array(
        array('$match' => array('trade_user_email' => (string)$useremail,"trade_user_id"=> (string)$userid,"trade_type"=>"sell")),
        array('$group' => array("_id" => '$trade_from_wallet_short', "amount" => array('$sum' => '$trade_total'))),
        array('$sort' =>  array('_id' => 1))
    );
    $sor["allResult"]["tradeSatisK"] =  $this->mongo_db->aggregate('trade_datas', $tradeSatisK);

    $tradeAlisK = array(
      array('$match' => array('trade_user_email' => (string)$useremail,"trade_user_id"=> (string)$userid,"trade_type"=>"buy")),
      array('$group' => array("_id" => '$trade_to_wallet_short', "amount" => array('$sum' => '$trade_unit'))),
      array('$sort' =>  array('_id' => 1))
    );
    $sor["allResult"]["tradeAlisK"] =  $this->mongo_db->aggregate('trade_datas', $tradeAlisK);

    $userFaucet = array(
      array('$match' => array('faucet_user_email' => (string)$useremail,"faucet_user_id"=> (string)$userid)),
      array('$group' => array("_id" => '$wallet_short', "amount" => array('$sum' => '$faucet_amount'))),
      array('$sort' =>  array('_id' => 1))
    );
    $sor["allResult"]["userFaucet"] =  $this->mongo_db->aggregate('user_faucet_datas', $userFaucet);
    return $sor;

  }

  public function updateUserWalletCheck($userid,$useremail,$short)
	{
            $this->mongo_db->where(array('wallet_user_id'=>(string)$userid,"wallet_user_email" => (string)$useremail,"wallet_short" => (string)$short));
            $this->mongo_db->set("addressCheckDtatus", 1);
            $this->mongo_db->set("addressCheckTime", time());
            $update = $this->mongo_db->update("user_wallet_datas");
            
            if($update->getModifiedCount()=="1"){
            return "ok";
            }else{
                return "hata";
            }
    }

  
}