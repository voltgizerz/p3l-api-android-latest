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

        $this->load->model('Penjualan_layanan_detail_model', 'penjualan');
    }

    public function index_get()
    {
        $id = $this->get('id_detail_penjualan_jasa_layanan');
        if ($id === null) {

            $penjualan = $this->penjualan->getDetailPenjualanLayanan($id);
            # code...

        } else {

            $penjualan = $this->penjualan->getDetailPenjualanLayanan($id);
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
                'message' => 'DATA DETAIL PENJUALAN LAYANAN MASIH KOSONG',
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'GAGAL, ID PENJUALAN JASA LAYANAN TIDAK DITEMUKAN / SALAH FORMAT !',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}