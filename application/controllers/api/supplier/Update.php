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
        $this->load->model('Supplier_model');
    }

    public function index_post($id = null)
    {
        $supplier = new UserData();
        $supplier->nama_supplier = $this->post('nama_supplier');
        $supplier->alamat_supplier = $this->post('alamat_supplier');
        $supplier->nomor_telepon_supplier= $this->post('nomor_telepon_supplier');
        $supplier->updated_date = date("Y-m-d H:i:s");
        $supplier->deleted_date = date("0000:00:0:00:00");

        $response = $this->Supplier_model->updateCustomer($supplier, $id);

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
    public $nama_supplier;
    public $alamat_supplier;
    public $nomor_telepon_supplier;
    public $updated_date;
    public $deleted_date;
}