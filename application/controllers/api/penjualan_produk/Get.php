<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Get extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Penjualan_produk_model', 'penjualan');
    }

    public function index_get()
    {
        $id = $this->get('id_transaksi_penjualan_produk');
        if ($id === null) {

            $penjualan = $this->penjualan->getPenjualanProduk($id);
            # code...

        } else {

            $penjualan = $this->penjualan->getPenjualanProduk($id);
        }

        if ($penjualan) {

            $this->response([
                'status' => true,
                'data' => $penjualan,

            ], REST_Controller::HTTP_OK);
            # code...
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, ID PENGADAAN TIDAK DITEMUKAN / SALAH FORMAT !',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}