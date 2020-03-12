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

        $this->load->model('Pengadaan_model', 'pengadaan');
    }

    public function index_get()
    {
        $id = $this->get('id_pengadaan');
        if ($id === null) {

            $pengadaan = $this->pengadaan->getPengadaan($id);
            # code...

        } else {

            $pengadaan = $this->pengadaan->getPengadaan($id);
        }

        if ($pengadaan) {

            $this->response([
                'status' => true,
                'data' => $pengadaan,

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