<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * CodeIgniter Logger Class
 *
 * Advanced logger to write log with custom message, zip all older versions and send email
 *
 * @package        	CodeIgniter
 * @subpackage    	Libraries
 * @category    	Libraries
 * @author        	Florian GUERIN
 * @link			http://timoagency.fr
 */

class AccountMonitor
{
  /**
   * Default CodeIgniter handler
   *
   * @var handler
   */
  protected $CI;
  private $_accountAddress;
  private $_apiKey;
  private $_baseUrl;
  private $_networks;
  // --------------------------------------------------------------------
  /**
   * Class constructor
   *
   * @return void
   * @param array all configuration datas
   */
  public function __construct($config = array())
  {
    $this->CI = &get_instance();
    $this->_accountAddress =  "0xa897d010116DC441Ac2635A54b3880Da2f42b008"; // production
    // $this->_accountAddress =  "0x46E9EddF02ae3cd666B5025c12F4B4B7CD822895"; // test

    $this->_networks = array(
      'ethereum' => array(
        'url' => 'https://api.etherscan.io/api',
        'api_key' => 'E4ZITQZWA7W6EZPNK4YDYHB5MRSXWCXK9J'
      ),

      'binance' => array(
        'url' => 'https://api.bscscan.com/api',
        'api_key' => '8UAJWJYVFKREBZFFXCJT3FU1SDAAU6HEBD'
      )
    ); // production

    // $this->_networks = array(
    //   'ethereum' => array(
    //     'url' => 'https://api-rinkeby.etherscan.io/api',
    //     'api_key' => 'TZ7XXBPMA2DIRENK2FMUDKGQUFB2NRU2GC') ,

    //     'binance' => array(
    //       'url'=>'https://api-testnet.bscscan.com/api',
    //       'api_key'=>'X3K3TR2WTK162IMR4ZKC1EPMTEYP27P2PH')
    //     ); // test
  }
  function getUrl($network, $startblock, $tokenAddress = '')
  {
    $url = $this->_networks[$network]['url'];

    if ($tokenAddress !== '') {
      $url .= "?module=account&action=tokentx&address={$this->_accountAddress}&startblock={$startblock}&sort=asc&contractAddress={$tokenAddress}&apikey={$this->_networks[$network]['api_key']}";
    } else {
      $url .= "?module=account&action=txlist&address={$this->_accountAddress}&startblock={$startblock}&sort=asc&apikey={$this->_networks[$network]['api_key']}";
    }

    return $url;
  }

  public function getAccountAddress()
  {
    return $this->_accountAddress;
  }

  private function executeCurl($url)
  {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }



  public function checkEther()
  {
    $sor = $this->CI->wallet_model->getWalletShort('ETH');
    $walletDetail = $sor[0];
    $startblock = $walletDetail['wallet_last_block'] + 1;

    $url = $this->getUrl('ethereum', $startblock);
    $res = json_decode($this->executeCurl($url));

    if ($res->status == 1) {
      for ($i = 0; $i < count($res->result); $i++) {
        $transaction = $res->result[$i];
        if (strtolower($transaction->to) == strtolower($this->_accountAddress)) {
          $user = $this->CI->account_model->getUserByAddress($transaction->from);
          if (count($user) > 0) {

            $wallet = $this->CI->wallet_model->getUserWallet($user[0]['user_id'], 'ETH');
            if (!empty($wallet)) {

              $depositHistory = $this->CI->wallet_model->depositHistoryByTxid($transaction->hash);
              if (empty($depositHistory)) {

                $amount = $transaction->value / 10 ** 18;
                $this->CI->wallet_model->incrementUserWalletBalanceToken($user[0]['user_id'], $amount, 'ETH');
                // insert into deposit_history table
                $this->CI->wallet_model->depositCreate('ETH', $user[0]['user_id'], $user[0]['user_email'], $amount, $walletDetail['wallet_system'], $wallet->wallet_user_tag, $transaction->from, $transaction->hash);
              }
            }
          }
        }

        if ($i == count($res->result) - 1) {
          $this->CI->wallet_model->updateWalletLastblock('ETH', $transaction->blockNumber);
          // echo json_encode(100000000000000000 / 10 ** 18);
        }
      }
    }

    return $res;
  }
  public function checkBinance()
  {
    $sor = $this->CI->wallet_model->getWalletShort('BNB');
    $walletDetail = $sor[0];
    $startblock = $walletDetail['wallet_last_block'] + 1;

    $url = $this->getUrl('binance', $startblock);
    $res = json_decode($this->executeCurl($url));

    if ($res->status == 1) {
      for ($i = 0; $i < count($res->result); $i++) {
        $transaction = $res->result[$i];
        if (strtolower($transaction->to) == strtolower($this->_accountAddress)) {
          $user = $this->CI->account_model->getUserByAddress($transaction->from);
          if (count($user) > 0) {

            $wallet = $this->CI->wallet_model->getUserWallet($user[0]['user_id'], 'BNB');
            if (!empty($wallet)) {

              $depositHistory = $this->CI->wallet_model->depositHistoryByTxid($transaction->hash);
              if (empty($depositHistory)) {

                $amount = $transaction->value / 10 ** 18;
                $this->CI->wallet_model->incrementUserWalletBalanceToken($user[0]['user_id'], $amount, 'BNB');
                // insert into deposit_history table
                $this->CI->wallet_model->depositCreate('BNB', $user[0]['user_id'], $user[0]['user_email'], $amount, $walletDetail['wallet_system'], $wallet->wallet_user_tag, $transaction->from, $transaction->hash);
              }
            }
          }
        }

        if ($i == count($res->result) - 1) {
          $this->CI->wallet_model->updateWalletLastblock('BNB', $transaction->blockNumber);
          // echo json_encode(100000000000000000 / 10 ** 18);
        }
      }
    }

    return $res;
  }

  public function checkTokensEthereum()
  {
    $response = array();
    $response = ['status' => 'ok', 'message' => 'operation successfull'];
    // Obtain current tokens
    $tokens = $this->getTokens();

    // get token transactions
    foreach ($tokens[0] as $token) {
      $startblock = $token['wallet_last_block'] + 1;
      $tokenAddress = $token['wallet_cont'];

      $url = $this->getUrl('ethereum', $startblock, $tokenAddress);
      $res = json_decode($this->executeCurl($url));

      // if there are transactions for that token then get the associated clients
      if ($res->status == '1') {

        $transactions = $res->result;
        foreach ($transactions as $transaction) {

          if (strtolower($transaction->to) == strtolower($this->_accountAddress)) {
            $user = $this->CI->account_model->getUserByAddress($transaction->from);

            if (!empty($user)) {
              $user = $user[0];

              // check if the token is registered
              // $wallet = $this->CI->wallet_model->getWalletShort(strtoupper($transaction->tokenSymbol));
              $wallet = $this->CI->wallet_model->getUserWallet($user['user_id'], $transaction->tokenSymbol);
              if (!empty($wallet)) {
                if ($token['wallet_dec'] > 0) {

                  $depositHistory = $this->CI->wallet_model->depositHistoryByTxid($transaction->hash);
                  if (empty($depositHistory)) {
                    $amount = $transaction->value / $token['wallet_dec'];
                    $this->CI->wallet_model->incrementUserWalletBalanceToken($user['user_id'], $amount, $token['wallet_short']);
                    $this->CI->wallet_model->depositCreate($token['wallet_short'], $user['user_id'], $user['user_email'], $amount, $token['wallet_system'], $wallet->wallet_user_tag, $transaction->from, $transaction->hash);
                  }
                }
                // die("found {$transaction->tokenSymbol}");
              } else {
                // token wallet does not exist and could not register it
                $response = ['status' => 'error', 'message' => 'no user wallet'];
              }


              /*
                            if ($this->CI->wallet_model->incrementUserWalletBalanceToken($user['user_id'], $transaction->value / 10 ** $token['wallet_dec'], $token['wallet_short']) == "ok") {
                                array_push($response, ['token' => $tokenAddress, 'transacciones' => $user]);
                            } else {
                                array_push($response, ['address' => $tokenAddress, 'user' => $user, 'transaction' => $transaction, 'token' => $token, 'transacciones' => 'error incrementing->' . $user['user_id'] . '->' . $transaction->value / 10 ** $token['wallet_dec'] . '->' . $token['wallet_short']]);
                            }
                            */
            }
          }
          if (next($transactions) == false) {
            $this->CI->wallet_model->updateWalletLastblock($token['wallet_short'], $transaction->blockNumber);
          }
        }
      } else {
        $response = ['status' => 'error', 'message' => 'failed retrieving transactions data'];
      }

      // array_push($respuesta, 'registro');
      // array_push($response, ['token' => $tokenAddress, 'transacciones' => $transactions]);

      // 300000 = 0.30 segundos
      usleep(300000);
    }
    // echo json_encode($this->CI->account_model-);
    return $response;
  }
  public function checkTokensBinance()
  {
    $response = array();
    $response = ['status' => 'ok', 'message' => 'operation successfull'];
    // Obtain current tokens
    $tokens = $this->getTokens();

    // get token transactions
    foreach ($tokens[1] as $token) {
      $startblock = $token['wallet_last_block'] + 1;
      $tokenAddress = $token['wallet_cont'];

      $url = $this->getUrl('binance', $startblock, $tokenAddress);
      $res = json_decode($this->executeCurl($url));

      // if there are transactions for that token then get the associated clients
      if ($res->status == '1') {

        $transactions = $res->result;
        foreach ($transactions as $transaction) {

          if (strtolower($transaction->to) == strtolower($this->_accountAddress)) {
            $user = $this->CI->account_model->getUserByAddress($transaction->from);

            if (!empty($user)) {
              $user = $user[0];

              // check if the token is registered
              // $wallet = $this->CI->wallet_model->getWalletShort(strtoupper($transaction->tokenSymbol));
              $wallet = $this->CI->wallet_model->getUserWallet($user['user_id'], $transaction->tokenSymbol);
              if (!empty($wallet)) {
                if ($token['wallet_dec'] > 0) {

                  $depositHistory = $this->CI->wallet_model->depositHistoryByTxid($transaction->hash);
                  if (empty($depositHistory)) {
                    $amount = $transaction->value / $token['wallet_dec'];
                    $this->CI->wallet_model->incrementUserWalletBalanceToken($user['user_id'], $amount, $token['wallet_short']);
                    $this->CI->wallet_model->depositCreate($token['wallet_short'], $user['user_id'], $user['user_email'], $amount, $token['wallet_system'], $wallet->wallet_user_tag, $transaction->from, $transaction->hash);
                  }
                }
                // die("found {$transaction->tokenSymbol}");
              } else {
                // token wallet does not exist and could not register it
                $response = ['status' => 'error', 'message' => 'no user wallet'];
              }


              /*
                            if ($this->CI->wallet_model->incrementUserWalletBalanceToken($user['user_id'], $transaction->value / 10 ** $token['wallet_dec'], $token['wallet_short']) == "ok") {
                                array_push($response, ['token' => $tokenAddress, 'transacciones' => $user]);
                            } else {
                                array_push($response, ['address' => $tokenAddress, 'user' => $user, 'transaction' => $transaction, 'token' => $token, 'transacciones' => 'error incrementing->' . $user['user_id'] . '->' . $transaction->value / 10 ** $token['wallet_dec'] . '->' . $token['wallet_short']]);
                            }
                            */
            }
          }
          if (next($transactions) == false) {
            $this->CI->wallet_model->updateWalletLastblock($token['wallet_short'], $transaction->blockNumber);
          }
        }
      } else {
        $response = ['status' => 'error', 'message' => 'failed retrieving transactions data'];
      }

      // array_push($respuesta, 'registro');
      // array_push($response, ['token' => $tokenAddress, 'transacciones' => $transactions]);

      // 300000 = 0.30 segundos
      usleep(300000);
    }
    // echo json_encode($this->CI->account_model-);
    return $response;
  }

  public function getTokens()
  {
    $tokens = $this->CI->api_model->tokenCurrencies();
    $tokensEther = array_filter($tokens,  array($this, 'isEther'));
    $tokensBinance = array_filter($tokens,  array($this, 'isBinance'));
    return [$tokensEther, $tokensBinance];
  }
  function isEther($token)
  {
    if ($token['wallet_network'] == 1) {
      return ($token);
    }
  }
  function isBinance($token)
  {
    if ($token['wallet_network'] == 56) {
      return ($token);
    }
  }
}
