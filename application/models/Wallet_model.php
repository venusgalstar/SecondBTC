<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Wallet_model extends CI_Model
{

	public function getWallet()
	{
		//$this->mongo_db->limit(1);
		$this->mongo_db->where(array('wallet_status' => 1));
		$sor = $this->mongo_db->get('wallet_datas');
		return $sor;
	}
	/**
	 * get last wallet inserted id
	 */
	public function getLastWalletId()
	{
		$this->mongo_db->limit(1);
		$this->mongo_db->select(array('wallet_id'));
		//$this->mongo_db->where(array('wallet_status' => 1));
		$this->mongo_db->order_by(array('wallet_id' => -1));
		$sor = $this->mongo_db->get('wallet_datas');
		return $sor[0]['wallet_id'];
	}

	public function getWalletShort($short)
	{
		$short = addslashes($short);
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('wallet_status' => 1, "wallet_short" => (string)$short));
		$sor = $this->mongo_db->get('wallet_datas');
		return $sor;
	}
	public function updateWalletLastblock($short, $lastblock)
	{
		$this->mongo_db->where(array("wallet_short" => (string)$short));
		$this->mongo_db->set('wallet_last_block', (string)$lastblock);
		$this->mongo_db->update('wallet_datas');
	}
	public function getUserInfoDetail($email)
	{
		$email = addslashes($email);
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('user_email' => (string)$email));
		$sor = $this->mongo_db->get('user_info_datas');
		return $sor;
	}

	public function getBanka($short)
	{
		$short = addslashes($short);
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('banka_status' => 1, "fiat_short" => (string)$short));
		$sor = $this->mongo_db->get('banka_datas');
		return $sor;
	}

	public function getBankaDetail($bankid)
	{
		$short = addslashes($bankid);
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('banka_status' => 1, "banka_id" => (string)$bankid));
		$sor = $this->mongo_db->get('banka_datas');
		return $sor;
	}

	public function walletAdresKontrol($userID, $email, $wallet)
	{
		$walletDetail = $this->getWalletShort((string)$wallet);
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('wallet_user_email' => (string)$email, "wallet_user_id" => (string)$userID, "wallet_id" => (int)$walletDetail[0]['wallet_id']));
		$sor = $this->mongo_db->get('user_wallet_datas');
		if (!empty($sor)) {
			return $sor;
		} else {
			$walletKontrol = getUserWalletKontrol((int)$walletDetail[0]['wallet_id'], (string)$userID, (string)$email);
			if ($walletKontrol == 'ok') {
				return null;
			}
		}
	}

	public function getUser($userID, $email)
	{
		$this->mongo_db->limit(1);
		$this->mongo_db->where(array('user_id' => (string)$userID, 'user_email' => (string)$email));
		$sor = $this->mongo_db->get('user_datas');
		return $sor;
	}

	public function getUserMailCodeGuncelle($email)
	{
		$code = emailCode();
		$md5Code = md5($code);
		$email = addslashes($email);
		$this->email_model->code_email($code, $email);
		$this->mongo_db->limit(1);
		$this->mongo_db->where('user_email', (string)$email);
		$this->mongo_db->set('user_mailcode', $md5Code);
		$this->mongo_db->update('user_datas');
		//return $sor;
	}

	public function withdrawCreate($walletID, $walletShort, $userID, $email, $amount, $commission, $system, $address, $cont, $tag)
	{
		$array = array(
			'wallet_user_id' => (string) $userID,
			'wallet_user_email' => (string)$email,
			'wallet_id' => (int)$walletID,
			'wallet_short' => (string)$walletShort
		);
		$this->mongo_db->where($array);
		$this->mongo_db->inc('wallet_user_balance', -(float)$amount);
		$update = $this->mongo_db->update('user_wallet_datas');
		if ($update->getModifiedCount() == 1) {
			
				$withdrawAmount = (float)$amount - (float)$commission;
			
			$veri = array(
				'withdraw_id' => uretken(28),
				'withdraw_wallet_id' => (int)$walletID,
				'withdraw_wallet_short' => (string)$walletShort,
				'withdraw_user_id' => (string)$userID,
				'withdraw_user_email' => (string)$email,
				'withdraw_amount' => (float)$withdrawAmount,
				'withdraw_commission' => (float)$commission,
				'withdraw_status' => (int)0,
				'withdraw_address' => (string)$address,
				'withdraw_cont' => (string)$cont,
				'withdraw_txid' => "",
				'withdraw_tag' => (string)$tag,
				'withdraw_system' => (string)$system,
				'withdraw_time' => (int)time()
			);
			$insert = $this->mongo_db->insert('withdraw_history_datas', $veri);
			if (count($insert)) {
				// $this->load->model('email_model');
				// $this->email_model->my_email_send("noreply@secondbtc.com", "User with " . $email . " mail address requested " . $walletShort . " withdrawal. Amount : " . $withdrawAmount . " Please check.");
				return 'ok';
			}
		}
	}

	public function withdrawHistory($userID, $email)
	{
		$this->mongo_db->order_by(array('withdraw_time' => 'desc', 'withdraw_status' => 'desc'));
		$this->mongo_db->where(array('withdraw_user_id' => (string)$userID, 'withdraw_user_email' => (string)$email));

    $ops = array(
      array('$lookup'=> array('from'=>'wallet_datas', 'localField'=> 'withdraw_wallet_short', 'foreignField'=>"wallet_short", 'as'=> "wallet_info")),
      array(
        '$unwind'=> '$wallet_info'
      ),
      array( '$replaceRoot'=> array( 'newRoot'=>
      array('$mergeObjects'=> array( '$$ROOT'  , '$wallet_info' )

    ))),
      array( '$project'=> array(
        'withdraw_id' => 1,
        'withdraw_wallet_id' => 1,
        'withdraw_wallet_short' => 1,
        'withdraw_user_id' => 1,
        'withdraw_user_email' => 1,
        'withdraw_amount' => 1,
        'withdraw_commission' => 1,
        'withdraw_status' => 1,
        'withdraw_address' => 1,
        'withdraw_cont' => 1,
        'withdraw_txid' => 1,
        'withdraw_tag' => 1,
        'withdraw_system' => 1,
        'withdraw_time' => 1,
        'wallet_dec'=> 1,
        'wallet_network'=> 1,
        'wallet_name'=> 1,
        'wallet_with_com'=> 1
      ))
  );
    return $this->mongo_db->aggregate('withdraw_history_datas', $ops);
	}

	public function depositHistory($userID, $email)
  {

    $this->mongo_db->order_by(array('dep_history_time' => 'desc', 'dep_history_status' => 'desc'));
    $this->mongo_db->where(array('dep_history_user_id' => (string)$userID, 'dep_history_user_email' => (string)$email));
    $ops = array(
      array('$lookup'=> array('from'=>'wallet_datas', 'localField'=> 'dep_history_wallet_short', 'foreignField'=>"wallet_short", 'as'=> "wallet_info")),
      array(
        '$unwind'=> '$wallet_info'
      ),
      array( '$replaceRoot'=> array( 'newRoot'=>
      array('$mergeObjects'=> array( '$$ROOT'  , '$wallet_info' )

    ))),
      array( '$project'=> array(
        'dep_history_id'=> 1,
        'dep_history_address'=> 1,
        'dep_history_txid'=> 1,
        'dep_history_wallet_short'=> 1,
        'dep_history_user_id'=> 1,
        'dep_history_user_email'=> 1,
        'dep_history_comfirmation'=> 1,
        'dep_history_amount' => 1,
        'dep_history_time'=> 1,
        'dep_history_system'=> 1,
        'dep_history_tag'=> 1,
        'dep_history_status'=> 1,
        'wallet_dec'=> 1,
        'wallet_network'=> 1,
        'wallet_name'=> 1,
        'wallet_with_com'=> 1
      ))
  );
    return $this->mongo_db->aggregate('deposit_history_datas', $ops);
  }

	public function depositHistoryByTxid($txid)
	{
		$this->mongo_db->where(array('dep_history_txid' => (string)$txid));
		//$this->mongo_db->limit(10);
		$sor = $this->mongo_db->get('deposit_history_datas');
		return $sor;

	}

	public function userWithdrawCancel($userID, $email, $withdrawID)
	{
		$this->mongo_db->where(array('withdraw_user_id' => (string)$userID, 'withdraw_user_email' => (string)$email, 'withdraw_id' => (string)$withdrawID, 'withdraw_status' => 0));
		$sor = $this->mongo_db->get('withdraw_history_datas');
		if (!empty($sor)) {
			$walletID = $sor[0]['withdraw_wallet_id'];
			$withdrawCom = $sor[0]['withdraw_commission'];
			$walletShort = $sor[0]['withdraw_wallet_short'];
			$withdrawAmount = $sor[0]['withdraw_amount'];
				$delarray = array(
					'withdraw_id' => (string)$withdrawID,
					'withdraw_user_id' => (string)$userID,
					'withdraw_user_email' => (string)$email,
					'withdraw_wallet_id' => (int)$walletID,
				);
				$this->mongo_db->where($delarray);
				$cancel = $this->mongo_db->delete('withdraw_history_datas');

				$array = array(
					'wallet_user_id' => (string)$userID,
					'wallet_user_email' => (string)$email,
					'wallet_id' => (int)$walletID,
					'wallet_short' => (string)$walletShort
				);
				$this->mongo_db->where($array);
				$this->mongo_db->inc('wallet_user_balance', (float)($withdrawAmount + $withdrawCom));
				$update = $this->mongo_db->update('user_wallet_datas');
				if ($cancel->getDeletedCount() == 1) {
					return 'ok';
				}
			
		} else {
			return 'yok';
		}
	}

	public function addressControl($walletShort, $address, $walletDetail)
	{
		$this->load->model('router_model');
		$result = $this->router_model->addressControl(
			$walletShort,
			$address,
			$walletDetail[0]["wallet_dec"],
			$walletDetail[0]["wallet_server_port"],
			$walletDetail[0]["wallet_server_username"],
			$walletDetail[0]["wallet_server_pass"],
			$walletDetail[0]["wallet_system"]
		);
		if ($result["isvalid"] == true) {
			return 'ok';
		} else {
			return 'hata';
		}
	}

	public function createAddress($email, $userID, $walletDetail)
	{
		$this->load->model('router_model');
		if ($walletDetail[0]["wallet_system"] == "token") {
			$this->mongo_db->limit(1);
			$sor = $this->walletAdresKontrol($userID, $email, "ETH");
			if (!empty($sor) && $sor[0]["wallet_user_address"] != "0") {
				$data["address"] = $sor[0]["wallet_user_address"];
				$data["tag"] = $sor[0]["wallet_user_tag"];
				$this->updateUserWallet($userID, $email, $walletDetail[0]["wallet_short"], $sor[0]["wallet_user_address"], $sor[0]["wallet_user_tag"]);
				return $data;
			} else {
				$result = $this->router_model->createAddress(
					$email,
					$userID,
					$walletDetail[0]["wallet_short"],
					$walletDetail[0]["wallet_system"],
					$walletDetail[0]["wallet_cont"],
					$walletDetail[0]["wallet_dec"],
					$walletDetail[0]["wallet_server_port"],
					$walletDetail[0]["wallet_server_username"],
					$walletDetail[0]["wallet_server_pass"],
					$walletDetail[0]["wallet_password"]
				);
				if ($result["address"] != '') {
					$this->updateUserWallet($userID, $email, $walletDetail[0]["wallet_short"], $result["address"], $result["tag"]);
					$this->updateUserWallet($userID, $email, "ETH", $result["address"], $result["tag"]);
					return $result;
				} else {
					return 'hata';
				}
			}
		} else {
			$result = $this->router_model->createAddress(
				$email,
				$userID,
				$walletDetail[0]["wallet_short"],
				$walletDetail[0]["wallet_system"],
				$walletDetail[0]["wallet_cont"],
				$walletDetail[0]["wallet_dec"],
				$walletDetail[0]["wallet_server_port"],
				$walletDetail[0]["wallet_server_username"],
				$walletDetail[0]["wallet_server_pass"],
				$walletDetail[0]["wallet_password"]
			);
			if ($result["address"] != '') {
				$this->updateUserWallet($userID, $email, $walletDetail[0]["wallet_short"], $result["address"], $result["tag"]);
				return $result;
			} else {
				return 'hata';
			}
		}
	}

	public function updateUserWallet($userID, $email, $walletShort, $address, $tag)
	{
		$this->mongo_db->where(array('wallet_user_id' => (string)$userID, 'wallet_short' => (string)$walletShort, 'wallet_user_email' => (string)$email));
		$this->mongo_db->set('wallet_user_address', (string)$address);
		$this->mongo_db->set('wallet_user_tag', (string)$tag);
		$this->mongo_db->update('user_wallet_datas');
	}

	/**
	 * Create deposit
	 * @param string $walletShort wallet short code
	 * @param string $userID user id
	 * @param string $email user email address
	 * @param float $amount total value received in transaction
	 * @param string $walletSystem wallet related system
	 * @param string $bankaName wallet_user_tag field from wallet_user_datas table
	 * @param string $IBAN transaction origin address
	 * @param string $islemCode transaction hash (id)
	 * @return mixed
	 */
	public function depositCreate($walletShort, $userID, $email, $amount, $walletSystem, $tag, $from, $islemCode)
	{
		$veri = array(
			'dep_history_id' => (string)uretken(28),
			'dep_history_address' => (string)strtoupper($from),
			'dep_history_txid' => (string)$islemCode,
			'dep_history_wallet_short' => (string)$walletShort,
			'dep_history_user_id' => (string)$userID,
			'dep_history_user_email' => (string)$email,
			'dep_history_comfirmation' => (int)0,
			'dep_history_amount' => (float)$amount,
			'dep_history_time' => (int)time(),
			'dep_history_system' => (string)$walletSystem,
			'dep_history_tag' => (string)$tag,
			'dep_history_status' => (int)1,
		);
	
		$insert = $this->mongo_db->insert('deposit_history_datas', $veri);
		if (count($insert)) {
			$array = array(
				'wallet_user_id' => (string) $userID,
				'wallet_user_email' => (string)$email,
				//'wallet_id' => (int)$walletID,
				'wallet_short' => (string)$walletShort
			);
			$this->mongo_db->where($array);
			$this->mongo_db->inc('wallet_user_balance', +(float)$amount);
			$update = $this->mongo_db->update('user_wallet_datas');
			return 'ok';
			$this->load->model('email_model');
			$this->email_model->my_email_send("noreply@secondbtc.com", "User with " . $email . " mail address requested " . $walletShort . " deposit. Amount : " . $amount . " Please check.");
		}
	}

	public function userDepositCancel($userID, $email, $walletShort, $depTime)
	{
		$this->mongo_db->where(
			array(
				'dep_history_user_id' => (string)$userID,
				'dep_history_user_email' => (string)$email,
				'dep_history_wallet_short' => (string)$walletShort,
				'dep_history_time' => (int)$depTime,
				'dep_history_comfirmation' => (int)0,
				'dep_history_status' => (int)0
			)
		);
		$sor = $this->mongo_db->get('deposit_history_datas');
		if (!empty($sor)) {
			$delarray = array(
				'dep_history_user_id' => (string)$userID,
				'dep_history_user_email' => (string)$email,
				'dep_history_wallet_short' => (string)$walletShort,
				'dep_history_time' => (int)$depTime,
				'dep_history_comfirmation' => (int)0,
				'dep_history_status' => (int)0,
			);
			$this->mongo_db->where($delarray);
			$cancel = $this->mongo_db->delete('deposit_history_datas');
			if ($cancel->getDeletedCount() == 1) {
				return 'ok';
			}
		} else {
			return 'yok';
		}
	}

	public function addressCheckTime($userID, $email, $wallet)
	{
		$userID = addslashes($userID);
		$email = addslashes($email);
		$wallet = addslashes($wallet);
		$this->mongo_db->where(array('wallet_user_email' => (string)$email, "wallet_user_id" => $userID, "wallet_short" => $wallet));
		$this->mongo_db->set('addressCheckTime', time());
		$this->mongo_db->set('addressCheckDtatus', 1);
		$this->mongo_db->update('user_wallet_datas');
	}
	public function incrementUserWalletBalanceToken($userid, $balance, $short)
	{
		$userid = addslashes($userid);
		// $useraddress = addslashes($useraddress);
		$balance = addslashes($balance);
		$this->mongo_db->where(array('wallet_user_id' => (string)$userid, "wallet_short" => (string)$short));

		$this->mongo_db->inc("wallet_user_balance", (float)$balance);
		$update = $this->mongo_db->update("user_wallet_datas");

		if ($update->getModifiedCount() == "1") {
			return "ok";
		} else {
			return "hata";
		}
	}
	public function setWalletTokenBlock($wallet_name, $wallet_short,  $block)
	{
		$wallet_name = addslashes($wallet_name);
		$wallet_short = addslashes($wallet_short);
		$block = addslashes($block);
		$this->mongo_db->where(array('wallet_name' => (string)$wallet_name, "wallet_short" => (string)$wallet_short));
		$this->mongo_db->set("wallet_last_block", (float)$block);
		$update = $this->mongo_db->update("wallet_datas");

		if ($update->getModifiedCount() == "1") {
			return "ok";
		} else {
			return "hata";
		}
	}

	function getUserWallet($userID, $wallet_short)
	{
		$wallet_short = strtoupper($wallet_short);
		$this->mongo_db->where(array('wallet_short' => $wallet_short, 'wallet_user_id' => $userID));
		$sor = $this->mongo_db->get('user_wallet_datas');
		if (!empty($sor)) {
			return $sor[0]; //"ok";
		} else {
			//$wallet = $this->getWalletShort($wallet_short);
			$this->mongo_db->where(array('wallet_short' => $wallet_short));
			$sorWallet = $this->mongo_db->get('wallet_datas');

			$this->mongo_db->where(array('user_id' => $userID));
			$sorUser = $this->mongo_db->get('user_datas');
			$veri = array(
				'wallet_id' => (int)$sorWallet[0]['wallet_id'],
				'wallet_short' => $sorWallet[0]['wallet_short'],
				'wallet_name' => $sorWallet[0]['wallet_name'],
				'wallet_user_balance' => (float)0,
				'wallet_system' => $sorWallet[0]['wallet_system'],
				'wallet_user_id' => $userID,
				'wallet_date' => (int)time(),
				'wallet_user_address' => "0",
				'wallet_user_tag' => "0",
				'wallet_withdraw_address' => "0",
				'wallet_withdraw_tag' => "0",
				'wallet_user_email' => $sorUser[0]['user_email']
			);
			$insert = $this->mongo_db->insert('user_wallet_datas', $veri);
			if (count($insert)) {
				return $insert; //"ok";
			}
		}
	}
}
