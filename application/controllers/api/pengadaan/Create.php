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
        $data = [
            'kode_pengadaan' => $this->post('kode_pengadaan'),
            'status' => $this->post('status'),
            'tanggal_pengadaan' => $this->post('tanggal_pengadaan'),
            'total' => $this->post('total'),
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