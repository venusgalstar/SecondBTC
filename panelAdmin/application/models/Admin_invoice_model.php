<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_invoice_model extends CI_Model
{

    public function invoice()
    {
        $sor = $this->mongo_db->get('invoice_datas');
        if (!empty($sor)) {
            return $sor;
        } else {
            return $sor;
        }
    }

    public function parasutClient()
    {
        include __DIR__ . '/../../../parasut/Client.php';
        include __DIR__ . '/../../../parasut/Base.php';
        include __DIR__ . '/../../../parasut/Account.php';
        include __DIR__ . '/../../../parasut/Product.php';
        include __DIR__ . '/../../../parasut/Invoice.php';
        $data = $this->invoice();
        return $client = new parasut\Client([
            "client_id" => yeniSifreCoz($data[0]["client_id"]),
            "username" => yeniSifreCoz($data[0]["username"]),
            "password" => yeniSifreCoz($data[0]["password"]),
            "grant_type" => "password",
            "redirect_uri" => yeniSifreCoz($data[0]["redirect_uri"]),
            'company_id' => yeniSifreCoz($data[0]["company_id"])
        ]);
    }

    public function invoiceUpdate()
    {
        $sor = $this->mongo_db->get('invoice_datas');
        $invoiceID = $this->input->post("invoice_id");
        $invoiceClientID = yeniSifrele($this->input->post("client_id"));
        $invoicename = yeniSifrele($this->input->post("username"));
        $invoicepass = yeniSifrele($this->input->post("password"));
        $invoiceRediUri = yeniSifrele($this->input->post("redirect_uri"));
        $invoiceCompanyID = yeniSifrele($this->input->post("company_id"));
        $invoiceStatus = $this->input->post("invoice_status");
        if (!empty($sor)) {
            $this->mongo_db->where(array('invoice_id' => (string)$invoiceID));
            $this->mongo_db->set("client_id", (string)$invoiceClientID);
            $this->mongo_db->set("username", (string)$invoicename);
            $this->mongo_db->set("password", (string)$invoicepass);
            $this->mongo_db->set("redirect_uri", (string)$invoiceRediUri);
            $this->mongo_db->set("company_id", (string)$invoiceCompanyID);
            $this->mongo_db->set("invoice_status", (int)$invoiceStatus);
            $update = $this->mongo_db->update('invoice_datas');
            if ($update->getModifiedCount() == 1) {
                $this->session->set_flashdata('onay', 'Invoice update success!');
                redirect('/invoice');
            } else {
                $this->session->set_flashdata('hata', 'Invoice update error!');
                redirect('/invoice');
            }
        } else {
            $veri = array(
                'invoice_id' => (string)uretken(25),
                'client_id' => (string)$invoiceClientID,
                'username' => (string)$invoicename,
                'password' => (string)$invoicepass,
                'redirect_uri' => (string)$invoiceRediUri,
                'company_id' => (string)$invoiceCompanyID,
                'invoice_status' => (string)0,
            );
            $insert = $this->mongo_db->insert('invoice_datas', $veri);
            if (count($insert)) {
                $this->session->set_flashdata('onay', 'Invoice update success!');
                redirect('/invoice');
            } else {
                $this->session->set_flashdata('hata', 'Invoice update error!');
                redirect('/invoice');
            }
        }
    }

    public function userDetail()
    {
        $email = $this->input->post("email");
        $this->mongo_db->where(array('user_email' => (string)$email));
        $sor = $this->mongo_db->get('user_info_datas');
        if (!empty($sor)) {
            return $sor;
        } else {
            return $sor;
        }
    }

    public function CreateInvoice()
    {
        $email = $this->input->post("email");
        $userID = $this->input->post("userID");
        $amount = $this->input->post("amount");
        $tradeid = $this->input->post("tradeID");

        //ürün bul
        $client = $this->parasutClient();
        $id = "18029476";
        $customer = array(
            'data' =>
            array(
                'type' => 'products',
            ),
        );
        $urun   = $client->call(Parasut\Product::class)->show($id, $customer);
        if (!empty($urun)) {
            //üye müşteri id bul yok ise yeni müşteri id belirle
            $this->mongo_db->where(array('user_id' => (string)$userID));
            $this->mongo_db->where(array('user_email' => (string)$email));
            $musteriTax = $this->mongo_db->get('user_info_datas');
            if (!empty($musteriTax)) {
                if ($musteriTax[0]["user_tax_id"] == "0" || empty($musteriTax[0]["user_tax_id"])) {
                    $m_mail      = $email;
                    $m_username  = $musteriTax[0]["user_first_name"] . " " . $musteriTax[0]["user_middle_name"] . " " . $musteriTax[0]["user_last_name"];
                    $m_nickname  = $musteriTax[0]["user_first_name"] . $musteriTax[0]["user_middle_name"] . $musteriTax[0]["user_last_name"];
                    $m_city      = $musteriTax[0]["user_city"];
                    $m_adres     = $musteriTax[0]["user_address"];
                    $m_district  = $musteriTax[0]["user_district"];
                    $m_phone     = $musteriTax[0]["user_tel"];
                    $m_taxnumber = $musteriTax[0]["user_id_number"];
                    $m_taxoffice = $musteriTax[0]["user_district"];

                    $customer = array(
                        'data' =>
                        array(
                            'type' => 'contacts',
                            'attributes' => array(
                                'email' => $m_mail,
                                'name' => $m_username, // gerekli
                                'short_name' => $m_nickname,
                                'contact_type' => 'person', // bireysel yada kurumsal
                                'district' => $m_district,
                                'city' => $m_city,
                                'address' => $m_adres,
                                'phone' => $m_phone,
                                'account_type' => 'customer', // gerekli
                                'tax_number' => $m_taxnumber,
                                'tax_office' => $m_taxoffice,
                            )
                        ),
                    );

                    $uye   = $client->call(Parasut\Account::class)->create($customer); // Kayıt Oluştur
                    $uyeid = $uye["data"]["id"];
                    if (!empty($uyeid)) {
                        $this->mongo_db->where(array('user_id' => (string)$userID));
                        $this->mongo_db->where(array('user_email' => (string)$email));
                        $this->mongo_db->set("user_tax_id", (string)$uyeid);
                        $update = $this->mongo_db->update('user_info_datas');
                    }
                } else {
                    $uyeid = $musteriTax[0]["user_tax_id"];
                }

                if (!empty($uyeid)) {
                    $invoice = array(
                        'data' => array(
                            'type' => 'sales_invoices', // gerekli
                            'attributes' => array(
                                'item_type' => 'invoice', // gerekli
                                'description' => siteSetting()["site_name"],
                                'issue_date' => date("Y-m-d"), // fatura tarih
                                'due_date' => date("Y-m-d"),
                                'invoice_series' => 'BDY' . date("Y"),
                                'invoice_id' => '',
                                'currency' => 'TRL'
                            ),
                            'relationships' => array(
                                'details' => array(
                                    'data' => array(
                                        0 => array(
                                            'type' => 'sales_invoice_details',
                                            'attributes' => array(
                                                'quantity' => 1,
                                                'unit_price' => $amount,
                                                'vat_rate' => 18,
                                                'description' => $urun["data"]["attributes"]["name"]
                                            ),
                                            "relationships" => array(
                                                "product" => array(
                                                    "data" => array(
                                                        "id" => $urun["data"]["id"],
                                                        "type" => "products"
                                                    )
                                                )
                                            )
                                        )
                                    ),
                                ),
                                'contact' => array(
                                    'data' => array(
                                        'id' => $uyeid,
                                        'type' => 'contacts'
                                    )
                                )
                            ),
                        )
                    );

                    ## Fatura Oluştur
                    $fatura = $client->call(Parasut\Invoice::class)->create($invoice); // fatura oluştur
                    if (!empty($fatura["data"]["id"])) {
                        //fatura oluştu diğer işlemleri yap
                        foreach ($tradeid as $tradeid) {
                            if (!empty($tradeid)) {
                                $this->mongo_db->where(array('trade_id' => (int)$tradeid));
                                $this->mongo_db->where(array('trade_user_id' => (string)$userID));
                                $this->mongo_db->where(array('trade_user_email' => (string)$email));
                                $this->mongo_db->set("invoice_id", (string)$fatura["data"]["id"]);
                                $update = $this->mongo_db->update('trade_datas');
                                if ($update->getModifiedCount() != 1) {
                                    return $data = array("durum" => 'error', "mesaj" => "Update Çalışmadı.");
                                }
                            }
                        }
                        return $data = array("durum" => 'success', "mesaj" => "Fatura oluşturuldu. ID : " . $fatura["data"]["id"]);
                    } else {
                        return $data = array("durum" => 'error', "mesaj" => "Fatura oluşturulamadı. Kontrol et!");
                    }
                } else {
                    return $data = array("durum" => 'error', "mesaj" => "Müsteri tax id bulunamadı veya oluşturulamadı.");
                }
            } else {
                return $data = array("durum" => 'error', "mesaj" => "Müsteri info bilgileri girilmemiş.");
            }
        } else {
            return $data = array("durum" => 'error', "mesaj" => "Ürün ekli değil.");
        }
    }

    public function invoiceSave($id)
    {
        # code...
    }
}
