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
        $pengadaan = new UserData();
        $pengadaan->kode_pengadaan = $this->post('kode_pengadaan');
        $pengadaan->status = $this->post('status');
        $pengadaan->tanggal_pengadaan = $this->post('tanggal_pengadaan');
        $pengadaan->total = $this->post('total');

        $response = $this->Pengadaan_model->updatePengadaan($pengadaan, $id);

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