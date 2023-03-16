<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Router_model extends CI_Model
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
    */
    //addresscontrol - walletbalance - createaddress - gonder
    public function addressControl($walletShort, $address, $decimal, $rpcport, $rpcusername, $rpcpass, $system)
    {
        $data = array(
            '1000' => yeniSifrele('addresscontrol'), //function
            '1002' => yeniSifrele($address), //address
            '1003' => yeniSifrele($walletShort), //market short
            '1007' => yeniSifrele($decimal),
            '1009' => $rpcport,
            '1010' => $rpcpass,
            '1011' => $rpcusername,
            '1015' => yeniSifrele("12345"),
            '1016' => "a41d8cd98f00b204e9800998fcf8427e"
        );
        $result = curl(serverUrl($system), $data);
        die(serverUrl($result));
        return $veri = json_decode($result, true);
    }

    public function createAddress($email, $userID, $walletShort, $system, $tokenCont, $decimal, $rpcport, $rpcusername, $rpcpass, $walletPass)
    {
        $data = array(
            '1000' => yeniSifrele('createaddress'),
            '1005' => yeniSifrele($userID),
            '1003' => yeniSifrele($walletShort),
            '1004' => yeniSifrele($email),
            '1006' => yeniSifrele($tokenCont),
            '1007' => yeniSifrele($decimal),
            '1008' => yeniSifrele($system),
            '1009' => $rpcport,
            '1010' => $rpcpass,
            '1011' => $rpcusername,
            '1015' => $walletPass,
            '1016' => "a41d8cd98f00b204e9800998fcf8427e"
        );
        $result = curl(serverUrl($system), $data);
        return $veri = json_decode($result, true);
    }

    public function serverControl()
    {
        $data = array(
            '1000' => yeniSifrele('walletbalance'),
            '1003' => yeniSifrele("BTC"),
            '1008' => yeniSifrele("COIN"),
            '1009' => yeniSifrele("32801"),
            '1010' => yeniSifrele("wrtyDF23245VAfdsfx*-Tsf548"),
            '1011' => yeniSifrele("wallet_Crypto"),
            '1014' => "halilbeydilli@gmail.com",
            '1016' => "a41d8cd98f00b204e9800998fcf8427e"
        );
        $result = curl(serverUrl("coin"), $data);
        return $data = json_decode($result, true);
    }
}
