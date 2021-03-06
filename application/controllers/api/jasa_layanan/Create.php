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
        date_default_timezone_set("Asia/Bangkok");
        $data = [
            'nama_jasa_layanan' => $this->post('nama_jasa_layanan'),
            'harga_jasa_layanan' => $this->post('harga_jasa_layanan'),
            'id_jenis_hewan' => $this->post('id_jenis_hewan'),
            'id_ukuran_hewan' => $this->post('id_ukuran_hewan'),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("0000:00:0:00:00"),
            'deleted_date' => date("0000:00:0:00:00"),
        ];

         // check layanan
         $layanan = $this->post('nama_jasa_layanan');
         $ukuran =$this->post('id_ukuran_hewan');
         $jenis = $this->post('id_jenis_hewan');

         $query = "SELECT nama_jasa_layanan FROM data_jasa_layanan WHERE nama_jasa_layanan = '$layanan' AND id_jenis_hewan = '$jenis' AND id_ukuran_hewan = '$ukuran' ";
         $result = $this->db->query($query, $layanan);

        if ($result->num_rows() >= 1) {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, JASA LAYANAN SUDAH ADA!',

            ], REST_Controller::HTTP_CREATED);
        } else {

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
}