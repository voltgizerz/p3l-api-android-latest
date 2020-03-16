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

        $this->load->model('Jasa_Layanan_model', 'jasa_layanan');
    }

    public function index_post()
    {
        $data = [
            'nama_jasa_layanan' => $this->post('nama_jasa_layanan'),
            'harga_jasa_layanan' => $this->post('harga_jasa_layanan'),
            'id_jenis_hewan' => $this->post('id_jenis_hewan'),
            'id_ukuran_hewan' => $this->post('id_ukuran_hewan'),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("0000:00:0:00:00"),
            'deleted_date' => date("0000:00:0:00:00"),
        ];
        if ($this->jasa_layanan->createJasaLayanan($data) > 0) {
            # code...
            $this->response([
                'status' => true,
                'message' => 'SUKSES JASA LAYANAN BERHASIL DI TAMBAHKAN !',

            ], REST_Controller::HTTP_CREATED);
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, MENAMBAHKAN JASA LAYANAN BARU !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}