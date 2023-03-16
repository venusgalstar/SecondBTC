<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_router_model extends CI_Model
{

    //post code
    /*
    func = 1000
    code = 1001
    address = 1002
    walletShort = 1003
    useremail = 1004
    userid = 1005
    tokencont = 1006
    decimal = 1007
    system = 1008
    port = 1009
    pass = 1010
    username = 1011
    amount = 1012
    tag = 1013,
    1014 = admin email
    1015 = wallet pass
    1016 = encrypt key
    */
    //addresscontrol - walletbalance - createaddress - gonder
    public function sendTransaction($withaddress, $withcont, $withtag, $withamount, $walletShort, $googleCode, $decimal, $rpcport, $rpcusername, $rpcpass, $system, $walletPass)
    {
        $data = array(
            '1000' => yeniSifrele('gonder'),
            '1001' => yeniSifrele($googleCode),
            '1002' => yeniSifrele($withaddress),
            '1003' => yeniSifrele($walletShort),
            '1006' => yeniSifrele($withcont),
            '1007' => yeniSifrele($decimal),
            '1008' => yeniSifrele($system),
            '1009' => $rpcport,
            '1010' => $rpcpass,
            '1011' => $rpcusername,
            '1012' => $withamount,
            '1013' => yeniSifrele($withtag),
            '1014' => $_SESSION['user_data_admin'][0]['admin_email'],
            '1015' => $walletPass,
            '1016' => "a41d8cd98f00b204e9800998fcf8427e"

        );
        $result = curl(serverUrl($system), $data);
        return $data = json_decode($result, true);
    }
}
