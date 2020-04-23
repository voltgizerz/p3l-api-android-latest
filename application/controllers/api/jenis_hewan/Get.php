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

        $this->load->model('Jenis_Hewan_model', 'jenis_hewan');
    }

    public function index_get()
    {
        $id = $this->get('id_jenis_hewan');
        if ($id === null) {

            $jenis_hewan = $this->jenis_hewan->getJenisHewan($id);
            # code...

        } else {

            $jenis_hewan = $this->jenis_hewan->getJenisHewan($id);
        }

        if ($jenis_hewan) {

            $this->response([
                'status' => true,
                'data' => $jenis_hewan,

            ], REST_Controller::HTTP_OK);
            # code...
        } else if($jenis_hewan == null) {

            $this->response([
                'status' => true,
                'data' => $jenis_hewan,
                'message' => 'DATA JENIS HEWAN MASIH KOSONG',
            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'GAGAL, ID JENIS HEWAN TIDAK DITEMUKAN / SALAH FORMAT !',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {

        $id = $this->delete('id_jenis_hewan');
        var_dump($id);
        if ($id === null) {
            # code...
            $this->response([
                'status' => false,

                'message' => 'GAGAL, ID JENIS HEWAN TIDAK BOLEH KOSONG!',

            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->jenis_hewan->deleteJenisHewan($id) > 0) {
                //ok

                $this->response([
                    'status' => true,
                    'id_jenis_hewan' => $id,
                    'message' => 'SUKSES DELETE JENIS HEWAN !',
                ], REST_Controller::HTTP_OK);
                # code...
            } else {
                ////id not found
                $this->response([
                    'status' => false,
                    'message' => 'GAGAL, ID JENIS HEWAN TIDAK DITEMUKAN !',

                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_post()
    {

        $data = [
            'id_jenis_hewan' => $this->post('id_jenis_hewan'),
            'nama_jenis_hewan' => $this->post('nama_jenis_hewan'),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("0000:00:0:00:00"),
            'deleted_date' => date("0000:00:0:00:00"),
        ];
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

    public function index_put()
    {
        $id = $this->put('id_jenis_hewan');
        $data = [
            'id_jenis_hewan' => $this->post('id_jenis_hewan'),
            'nama_jenis_hewan' => $this->post('nama_jenis_hewan'),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("0000:00:0:00:00"),
            'deleted_date' => date("0000:00:0:00:00"),

        ];

        if ($this->jenis_hewan->updateJenisHewan($data, $id) > 0) {
            # code...
            $this->response([
                'status' => true,
                'id_jenis_hewan' => $id,
                'message' => 'SUKSES UPDATED JENIS HEWAN !',

            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'GAGAL UPDATED JENIS HEWAN ID TIDAK DI TEMUKAN! !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}