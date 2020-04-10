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

        $this->load->model('Pengadaan_detail_model', 'pengadaan');
    }

    public function index_post()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data = [
            'id_produk_fk' => $this->post('id_produk_fk'),
            'kode_pengadaan_fk' => $this->post('kode_pengadaan_fk'),
            'satuan_pengadaan' => $this->post('satuan_pengadaan'),
            'jumlah_pengadaan' => $this->post('jumlah_pengadaan'),
            'tanggal_pengadaan' =>  date("Y-m-d H:i:s")
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