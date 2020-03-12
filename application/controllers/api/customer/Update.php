<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Update extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Customer_model');
    }

    public function index_post($id = null)
    {
        $customer = new UserData();
        $customer->nama_customer = $this->post('nama_customer');
        $customer->alamat_customer = $this->post('alamat_customer');
        $customer->tanggal_lahir_customer = $this->post('tanggal_lahir_customer');
        $customer->nomor_hp_customer = $this->post('nomor_hp_customer');
        $customer->updated_date = date("Y-m-d H:i:s");
        $customer->deleted_date = date("0000:00:0:00:00");

        $response = $this->Customer_model->updateCustomer($customer, $id);

        return $this->returnData($response['msg'], $response['error']);
    }

    public function returnData($msg, $error)
    {
        $response['error'] = $error;
        $response['message'] = $msg;
        return $this->response($response);
    }
}
class UserData
{
    public $nama_customer;
    public $alamat_customer;
    public $tanggal_lahir_customer;
    public $nomor_hp_customer;
    public $updated_date;
    public $deleted_date;
}