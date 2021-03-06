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
        $this->load->model('Pengadaan_model');
    }

    public function index_post($id = null)
    {
        date_default_timezone_set("Asia/Bangkok");
        $pengadaan = new UserData();
        $pengadaan->id_supplier = $this->post('id_supplier');
        $pengadaan->status = $this->post('status');
        $pengadaan->updated_date = date("Y-m-d H:i:s");
        $kodePengadaan = [
            'kode_pengadaan_fk' => $this->post('kode_pengadaan_fk'),
        ];

        $response = $this->Pengadaan_model->updatePengadaan($pengadaan, $id,$kodePengadaan);

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
    public $kode_pengadaan;
    public $status;
    public $tanggal_pengadaan;
    public $total;
}