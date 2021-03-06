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

        $this->load->model('Penjualan_layanan_model', 'penjualan');
    }

    public function index_get()
    {
        $id = $this->get('id_transaksi_penjualan_jasa_layanan');
        if ($id === null) {

            $penjualan = $this->penjualan->getPenjualanLayanan($id);
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
        } else if($penjualan == null) {

            $this->response([
                'status' => true,
                'data' => $penjualan,
                'message' => 'DATA PENJUALAN MASIH KOSONG',
            ], REST_Controller::HTTP_OK);
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, ID PENJUALAN TIDAK DITEMUKAN / SALAH FORMAT !',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}