<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {

    public function login_code($code,$email)
    {
        $date = date("d-m-Y H:i:s");
        $IP = GetIP();
        $baslik = "(".$email.") ".lang("loginconfcode");
        require_once(APPPATH . 'email/login_code.php');
        $this->send_mail_havuz($baslik,$email,$mailText,2);
    }
    public function code_email($code,$email,$islem="")
    {   
        $date = date("d-m-Y H:i:s");
        $IP = GetIP();
        $baslik = "(".$email.") ".lang("processconfcode").' - '.$islem;
        require_once(APPPATH . 'email/code_mail.php');
        $this->send_mail_havuz($baslik,$email,$mailText,1);
    }
    public function email_confirm($code,$email)
    {
        $date = date("d-m-Y H:i:s");
        $IP = GetIP();
        $baslik = "(".$email.") ".lang("accountconfcode");
        require_once(APPPATH . 'email/confirm_email.php');
        $this->send_mail_havuz($baslik,$email,$mailText,4);
    }
    public function pass_update($code,$email)
    {
        $date = date("d-m-Y H:i:s");
        $IP = GetIP();
        $baslik = "(".$email.") ".lang("passconfcode");
        require_once(APPPATH . 'email/pass_email.php');
        $this->send_mail_havuz($baslik,$email,$mailText,3);
    }

    public function my_email_send($email,$message)
    {
        $date = date("d-m-Y H:i:s");
        $baslik = "The website warns you. ".$date;
        require_once(APPPATH . 'email/my_email_send.php');
        $this->send_mail_havuz($baslik,$email,$mailText,1);
    }

    public function send_mail($baslik,$email,$mailText)
    {
        if(siteSetting()["site_email_ssl"]=="disable"){
            $ssl = false;
        }else{
            $ssl = siteSetting()["site_email_ssl"];
        }
        $server = siteSetting()["site_email_server"];
        $fromemail = siteSetting()["site_email"];
        $port = siteSetting()["site_email_port"];
        $pass = yeniSifreCoz(siteSetting()["site_email_pass"]);
        
        $config = array(
            'protocol' => 'smtp', 
            'smtp_host' => $server, 
            'smtp_port' => $port,
            'smtp_user' => $fromemail,
            'smtp_pass' => $pass,
            'smtp_crypto' => $ssl, 
            'mailtype' => 'html', 
            'smtp_timeout' => '4',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->to($email);
        $this->email->from($fromemail,siteSetting()["site_name"].".com");
        $this->email->subject($baslik);
        $this->email->message($mailText);
        $this->email->send();
    }

    public function send_mail_havuz($baslik,$email,$mailText,$rand)
    {
        if($rand==1)    {$fromemail=siteSetting()["site_email"]; $pass= yeniSifreCoz(siteSetting()["site_email_pass"]);}
        elseif($rand==2){$fromemail=siteSetting()["site_email_login"]; $pass= yeniSifreCoz(siteSetting()["site_email_pass_login"]);}
        elseif($rand==3){$fromemail=siteSetting()["site_email_support"]; $pass= yeniSifreCoz(siteSetting()["site_email_pass_support"]);}
        elseif($rand==4){$fromemail=siteSetting()["site_email_register"]; $pass= yeniSifreCoz(siteSetting()["site_email_pass_register"]);}


        if(siteSetting()["site_email_ssl"]=="disable"){
            $ssl = false;
        }else{
            $ssl = siteSetting()["site_email_ssl"];
        }
        $server = siteSetting()["site_email_server"];
        $fromemail = $fromemail;
        $port = siteSetting()["site_email_port"];
        $pass = $pass;
        
        $config = array(
            'protocol' => 'smtp', 
            'smtp_host' => $server, 
            'smtp_port' => $port,
            'smtp_user' => $fromemail,
            'smtp_pass' => $pass,
            'smtp_crypto' => $ssl, 
            'mailtype' => 'html', 
            'smtp_timeout' => '4',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );
        $this->email->initialize($config);
        $this->email->set_mailtype("html");
        $this->email->set_newline("\r\n");
        $this->email->to($email);
        $this->email->from($fromemail,siteSetting()["site_name"].".com");
        $this->email->subject($baslik);
        $this->email->message($mailText);
        $this->email->send();
    }


}