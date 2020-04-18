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

        $this->load->model('Ukuran_Hewan_model', 'ukuran_hewan');
    }

    public function index_post()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data = [
            'ukuran_hewan' => $this->post('ukuran_hewan'),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("0000:00:0:00:00"),
            'deleted_date' => date("0000:00:0:00:00"),
        ];

        $ukuran = $this->post('ukuran_hewan');

        $query = "SELECT ukuran_hewan FROM data_ukuran_hewan WHERE ukuran_hewan = '$ukuran'";
        $result = $this->db->query($query, $ukuran);

        if ($result->num_rows() >= 1) {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, UKURAN HEWAN SUDAH ADA!',

            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
        if ($this->ukuran_hewan->createUkuranHewan($data) > 0) {
            # code...
            $this->response([
                'status' => true,
                'message' => 'SUKSES UKURAN HEWAN BERHASIL DI TAMBAHKAN !',

            ], REST_Controller::HTTP_CREATED);
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, MENAMBAHKAN UKURAN HEWAN BARU !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
    }
}