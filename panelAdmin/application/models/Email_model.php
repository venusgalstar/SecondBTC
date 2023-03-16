<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Email_model extends CI_Model {

	
    public function pass_update($code,$email)
	{
        $date = date("d-m-Y H:i:s");
        $IP = GetIP();
        $baslik = siteSetting()["site_name"].' '.lang("passconfcode");
        require_once(APPPATH . 'email/pass_email.php');
        echo $this->send_mail($baslik,$email,$mailText);
    }
    public function send_admin_mail($subject,$email,$detail,$name)
	{
        $date = date("d-m-Y H:i:s");
        $baslik = siteSetting()["site_name"].' '.$subject;
        require_once(APPPATH . 'email/send_mail.php');
        $this->send_mail($baslik,$email,$mailText);
    }

    public function send_admin_mail_warn($email,$detail)
	{
        $date = date("d-m-Y H:i:s");
        $baslik = siteSetting()["site_name"].' - There is a warning from the admin panel.';
        require_once(APPPATH . 'email/send_mail.php');
        $this->send_mail($baslik,$email,$mailText);
    }

    public function send_support_mail($subject,$email,$detail,$reply,$name)
	{
        $date = date("d-m-Y H:i:s");
        $baslik = '['.siteSetting()["site_name"].' Support] Re:'.$subject;
        require_once(APPPATH . 'email/send_mail_support.php');
        $this->send_mail($baslik,$email,$mailText);
    }

    public function send_mail($baslik,$email,$mailText)
	{
        if(siteSetting()["site_email_ssl"]=="disable"){
            $ssl = false;
        }else{
            $ssl = siteSetting()["site_email_ssl"];
        }
        $server = siteSetting()["site_email_server"];
        $fromemail = siteSetting()["site_email_support"];
        $port = siteSetting()["site_email_port"];
        $pass = yeniSifreCoz(siteSetting()["site_email_pass_support"]);
        
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
        $this->email->from($fromemail,siteSetting()["site_name"]);
        $this->email->subject($baslik);
        $this->email->message($mailText);
        $this->email->send();
    }


}