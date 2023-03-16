<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Invoice extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // if(siteSetting()["site_status"]!=1 && $_SESSION['key']!="admin_bakim"){redirect('/maintenance');}
        if ($_SESSION['user_data_admin']{
        0}['admin_type'] == '') {
            redirect('/login');
        }
    }
    public function index()
    {
        if ($_POST) {
            if (yetki($_SESSION['user_data_admin']{
            0}['admin_email']) >= 10) {
                $this->admin_invoice_model->invoiceUpdate();
            } else {
                $this->session->set_flashdata('hata', 'You are not authorized to perform this operation.');
            }
        }
        $data["invoice"] = $this->admin_invoice_model->invoice();
        $this->load->view('invoice', $data);
    }

    public function invoiceGenerated()
    {
        echo "burada";
    }

    public function invoiceCreate()
    {
        $this->load->view('create_invoice');
    }

    public function userDetail()
    {
        $data = $this->admin_invoice_model->userDetail();
        echo json_encode($data);
    }

    public function invoiceCreateRun()
    {
        if (yetki($_SESSION['user_data_admin']{
        0}['admin_email']) >= 4) {
            if ($_POST) {
                $data = $this->admin_invoice_model->CreateInvoice();
            }
        } else {
            $data = array("durum" => 'error', "mesaj" => "You are not authorized to perform this operation.");
        }
        echo json_encode($data);
    }
}
