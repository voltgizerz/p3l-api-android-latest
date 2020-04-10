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
        $this->load->model('Pengadaan_detail_model');
    }

    public function index_post($id = null)
    {
        date_default_timezone_set("Asia/Bangkok");
        $pengadaanDetail = new UserData();
        $pengadaanDetail->id_produk_fk = $this->post('id_produk_fk');
        $pengadaanDetail->kode_pengadaan_fk = $this->post('kode_pengadaan_fk');
        $pengadaanDetail->satuan_pengadaan = $this->post('satuan_pengadaan');
        $pengadaanDetail->jumlah_pengadaan = $this->post('jumlah_pengadaan');

        $response = $this->Pengadaan_detail_model->updatePengadaanDetail($pengadaanDetail, $id);

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