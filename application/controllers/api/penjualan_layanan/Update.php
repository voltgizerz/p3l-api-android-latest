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
        $this->load->model('Penjualan_layanan_model');
    }

    public function index_post($id = null)
    {
        date_default_timezone_set("Asia/Bangkok");
        $penjualan = new UserData();
        $penjualan->tanggal_penjualan_jasa_layanan = date("Y-m-d H:i:s");
        $penjualan->status_penjualan = $this->post('status_penjualan');
        $penjualan->status_layanan = $this->post('status_layanan');
        $penjualan->id_hewan = $this->post('id_hewan');
        $penjualan->updated_date = date("Y-m-d H:i:s");
        $kodePenjualan = [
            'kode_transaksi_penjualan_jasa_layanan' => $this->post('kode_transaksi_penjualan_jasa_layanan'),
        ];

        $response = $this->Penjualan_layanan_model->updatePenjualanLayanan($penjualan, $id);
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