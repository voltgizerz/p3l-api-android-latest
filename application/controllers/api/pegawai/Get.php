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

        $this->load->model('Pegawai_model', 'pegawai');
    }

    public function index_get()
    {
        $id = $this->get('id_pegawai');
        if ($id === null) {

            $pegawai = $this->pegawai->getPegawai($id);
            # code...

        } else {

            $pegawai = $this->pegawai->getPegawai($id);
        }

        if ($pegawai) {

            $this->response([
                'status' => true,
                'data' => $pegawai,

            ], REST_Controller::HTTP_OK);
            # code...
        } else if($pegawai == null) {

            $this->response([
                'status' => true,
                'data' => $pegawai,
                'message' => 'DATA PEGAWAI MASIH KOSONG',
            ], REST_Controller::HTTP_OK);
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, ID PEGAWAI TIDAK DITEMUKAN / SALAH FORMAT !',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

}