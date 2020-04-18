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

        $this->load->model('Jenis_Hewan_model', 'jenis_hewan');
    }

    public function index_post()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data = [
            'id_jenis_hewan' => $this->post('id_jenis_hewan'),
            'nama_jenis_hewan' => $this->post('nama_jenis_hewan'),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("0000:00:0:00:00"),
            'deleted_date' => date("0000:00:0:00:00"),
        ];

        // check jenis hwan
        $jenis = $this->post('nama_jenis_hewan');

        $query = "SELECT nama_jenis_hewan FROM data_jenis_hewan WHERE nama_jenis_hewan = '$jenis'";
        $result = $this->db->query($query, $jenis);

        if ($result->num_rows() >= 1) {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, JENIS HEWAN SUDAH ADA!',

            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {

            if ($this->jenis_hewan->createJenisHewan($data) > 0) {
                # code...
                $this->response([
                    'status' => true,
                    'message' => 'SUKSES JENIS HEWAN BERHASIL DI TAMBAHKAN !',

                ], REST_Controller::HTTP_CREATED);
            } else {

                $this->response([
                    'status' => false,
                    'message' => 'GAGAL, MENAMBAHKAN JENIS HEWAN BARU !',

                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}