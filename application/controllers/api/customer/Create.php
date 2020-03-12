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

        $this->load->model('Customer_model', 'customer');
    }

    public function index_post()
    {
        $data = [
            'nama_customer' => $this->post('nama_customer'),
            'alamat_customer' => $this->post('alamat_customer'),
            'tanggal_lahir_customer' => $this->post('tanggal_lahir_customer'),
            'nomor_hp_customer' => $this->post('nomor_hp_customer'),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("0000:00:0:00:00"),
            'deleted_date' => date("0000:00:0:00:00"),
        ];
        if ($this->customer->createCustomer($data) > 0) {
            # code...
            $this->response([
                'status' => true,
                'message' => 'SUKSES CUSTOMER BERHASIL DI TAMBAHKAN !',

            ], REST_Controller::HTTP_CREATED);
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, MENAMBAHKAN CUSTOMER BARU !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}