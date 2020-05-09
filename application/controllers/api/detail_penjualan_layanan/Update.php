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
        $this->load->model('Penjualan_layanan_detail_model');
    }

    public function index_post($id = null)
    {
        date_default_timezone_set("Asia/Bangkok");
        $penjualanLayananDetail = new UserData();
        $penjualanLayananDetail->id_jasa_layanan_fk = $this->post('id_jasa_layanan_fk');
        $penjualanLayananDetail->kode_transaksi_penjualan_jasa_layanan_fk = $this->post('kode_transaksi_penjualan_jasa_layanan_fk');
        $penjualanLayananDetail->jumlah_jasa_layanan = $this->post('jumlah_jasa_layanan');

        $response = $this->Penjualan_layanan_detail_model->updatePenjualanLayananDetail( $penjualanLayananDetail, $id);

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