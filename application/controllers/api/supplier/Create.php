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

        $this->load->model('Supplier_model', 'supplier');
    }

    public function index_post()
    {
        $data = [
            'nama_supplier' => $this->post('nama_supplier'),
            'alamat_supplier' => $this->post('alamat_supplier'),
            'nomor_telepon_supplier' => $this->post('nomor_telepon_supplier'),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("0000:00:0:00:00"),
            'deleted_date' => date("0000:00:0:00:00"),
        ];
        if ($this->supplier->createSupplier($data) > 0) {
            # code...
            $this->response([
                'status' => true,
                'message' => 'SUKSES SUPPLIER BERHASIL DI TAMBAHKAN !',

            ], REST_Controller::HTTP_CREATED);
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, MENAMBAHKAN SUPPLIER BARU !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}