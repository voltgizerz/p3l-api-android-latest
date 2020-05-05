<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Create extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Penjualan_produk_detail_model', 'penjualan');
    }

    public function index_post()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data = [
            'kode_transaksi_penjualan_produk_fk' => $this->post('kode_transaksi_penjualan_produk_fk'),
            'id_produk_penjualan_fk' => $this->post('id_produk_penjualan_fk'),
            'jumlah_produk' => $this->post('jumlah_produk'),
            'subtotal' => '0',
        ];
        if ($this->penjualan->createPenjualanProdukDetail($data) > 0) {
            # code...
            $this->response([
                'status' => true,
                'message' => 'SUKSES PENJUALAN PRODUK DETAIL BERHASIL DI TAMBAHKAN !',

            ], REST_Controller::HTTP_CREATED);
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, MENAMBAHKAN PENJUALAN PRODUK DETAIL BARU !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}