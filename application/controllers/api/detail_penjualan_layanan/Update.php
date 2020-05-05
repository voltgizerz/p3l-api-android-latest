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
        $this->load->model('Penjualan_produk_detail_model');
    }

    public function index_post($id = null)
    {
        date_default_timezone_set("Asia/Bangkok");
        $penjualanProdukDetail = new UserData();
        $penjualanProdukDetail->id_produk_penjualan_fk = $this->post('id_produk_penjualan_fk');
        $penjualanProdukDetail->kode_transaksi_penjualan_produk_fk = $this->post('kode_transaksi_penjualan_produk_fk');
        $penjualanProdukDetail->jumlah_produk = $this->post('jumlah_produk');
        $penjualanProdukDetail->subtotal = $this->post('subtotal');

        $response = $this->Penjualan_produk_detail_model->updatePenjualanProdukDetail($penjualanProdukDetail, $id);

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