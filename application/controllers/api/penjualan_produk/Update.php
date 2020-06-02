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
        $this->load->model('Penjualan_produk_model');
    }

    public function index_post($id = null)
    {
        date_default_timezone_set("Asia/Bangkok");
        $penjualan = new UserData();
        $penjualan->tanggal_penjualan_produk = date("Y-m-d H:i:s");
        $penjualan->id_hewan = $this->post('id_hewan');
        $penjualan->status_penjualan = $this->post('status_penjualan');
        $penjualan->updated_date = date("Y-m-d H:i:s");
        $kodePenjualan = [
            'kode_transaksi_penjualan_produk' => $this->post('kode_transaksi_penjualan_produk'),
        ];
        
        $response = $this->Penjualan_produk_model->updatePenjualanProduk($penjualan, $id);
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