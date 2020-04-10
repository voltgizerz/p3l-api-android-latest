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

        $this->load->model('Pengadaan_model', 'pengadaan');
    }

    public function index_post()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data = [
            'kode_pengadaan' => $this->pengadaan->ambilKode(),
            'id_supplier' => $this->post('id_supplier'),
            'status' => $this->post('Belum Diterima'),
            'tanggal_pengadaan' => date("Y-m-d H:i:s"),
            'total' => $this->pengadaan->totalBayarPengadaan($this->pengadaan->ambilKode()),
        ];
        if ($this->pengadaan->createPengadaan($data) > 0) {
            # code...
            $this->response([
                'status' => true,
                'message' => 'SUKSES PENGADAAN BERHASIL DI TAMBAHKAN !',

            ], REST_Controller::HTTP_CREATED);
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, MENAMBAHKAN PENGADAAN BARU !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}