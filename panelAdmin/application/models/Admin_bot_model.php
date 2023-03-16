<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_bot_model extends CI_Model
{

    public function getAllMarket()
    {
        $this->mongo_db->order_by(array('from_wallet_short' => 'desc'));
        $this->mongo_db->where('market_status', (int)1);
        $this->mongo_db->where('wallet_status', (int)1);
        $sor = $this->mongo_db->get('market_datas');
        if (!empty($sor)) {
            return $sor;
        } else {
            return $sor;
        }
    }

    public function getAllBot()
    {
        $sor = $this->mongo_db->get('bot_datas');
        if (!empty($sor)) {
            return $sor;
        } else {
            return $sor;
        }
    }

    public function addBot()
    {
        $Market = $this->input->post("bot_short");
        $Api = $this->input->post("bot_api");
        $Trade = $this->input->post("bot_trade");
        $userEmail = $this->input->post("userEmail");
        $userId = $this->input->post("userID");
        $buyPrice = $this->input->post("bot_buyPrice");
        $sellPrice = $this->input->post("bot_sellPrice");
        $volume = $this->input->post("bot_volume");
        $refCoin1 = $this->input->post("ref_coin_1");
        $refCoin2 = $this->input->post("ref_coin_2");
        $actionType = $this->input->post("bot_action_type");
        $data = explode("_", $Market);
        if ($userEmail == '') {
            $userEmail = "bot";
        }
        if ($userId == '') {
            $userId = "bot";
        }
        $veri = array(
            'bot_id' => (string)uretken(25),
            'bot_from_short' => (string)$data[0],
            'bot_from_id' => (string)$data[1],
            'bot_to_short' => (string)$data[2],
            'bot_to_id' => (string)$data[3],
            'bot_api' => (string)$Api,
            'bot_userEmail' => (string)$userEmail,
            'bot_userId' => (string)$userId,
            'bot_status' => (int)0,
            'bot_trade' => (int)$Trade,
            'bot_sellPrice' => (int)$sellPrice,
            'bot_buyPrice' => (int)$buyPrice,
            'bot_volume' => (float)$volume,
            'ref_coin_1' => (string)$refCoin1,
            'ref_coin_2' => (string)$refCoin2,
            'bot_action_type' => (int)$actionType,
        );
        $insert = $this->mongo_db->insert('bot_datas', $veri);
        if (count($insert)) {
            $this->session->set_flashdata('onay', 'New matket bot added!');
            redirect('/bot');
        } else {
            $this->session->set_flashdata('hata', 'New matket bot not added!');
            redirect('/bot');
        }
    }

    public function deleteBot()
    {
        $botID = $this->input->post("bot_id");
        $this->mongo_db->where('bot_id', (string)$botID);
        $bul = $this->mongo_db->get('bot_datas');

        $this->mongo_db->where('bot_id', (string)$botID);
        $delete = $this->mongo_db->delete('bot_datas');
        if ($delete->getDeletedCount() == 1) {
            $this->deleteBotExchange($botID, $bul[0]["bot_from_short"], $bul[0]["bot_to_short"], $bul[0]["bot_userEmail"], $bul[0]["bot_userId"]);
            $this->session->set_flashdata('onay', 'Data was deleted successfully.!');
        } else {
            $this->session->set_flashdata('onay', 'Data was deleted not successfully.!');
        }
    }

    public function deleteBotExchange($botID, $fromShort, $toShort, $userEmail, $userId)
    {
        $delarray = array(
            'exchange_user_email' => (string)$userEmail,
            'exchange_user_id' => (string)$userId,
            'exchange_from_short' => (string)$fromShort,
            'exchange_to_short' => (string)$toShort,
        );
        $this->mongo_db->where($delarray);
        $cancel = $this->mongo_db->delete_all('exchange_datas');
    }

    public function updateBot()
    {
        $botID = $this->input->post("bot_id");
        $priceBuy = $this->input->post("priceBuy");
        $priceSell = $this->input->post("priceSell");
        $botStatus = $this->input->post("botStatus");
        $botVolume = $this->input->post("botVolume");
        $this->mongo_db->where('bot_id', (string)$botID);
        $this->mongo_db->set("bot_buyPrice", (float)$priceBuy);
        $this->mongo_db->set("bot_sellPrice", (float)$priceSell);
        $this->mongo_db->set("bot_status", (int)$botStatus);
        $this->mongo_db->set("bot_volume", (float)$botVolume);
        $update = $this->mongo_db->update('bot_datas');
        if ($update->getModifiedCount() == 1) {
            return "ok";
        } else {
            return null;
        }
    }

    public function updateStatusBot()
    {
        $botID = $this->input->post("bot_id");
        $botStatus = $this->input->post("botStatus");
        $this->mongo_db->where('bot_id', (string)$botID);
        $this->mongo_db->set("bot_status", (int)$botStatus);
        $update = $this->mongo_db->update('bot_datas');
        if ($update->getModifiedCount() == 1) {
            return "ok";
        } else {
            return null;
        }
    }
}
