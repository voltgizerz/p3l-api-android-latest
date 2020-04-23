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

        $this->load->model('Ukuran_Hewan_model', 'ukuran_hewan');
    }

    public function index_get()
    {
        $id_ukuran_hewan = $this->get('id_ukuran_hewan');
        if ($id_ukuran_hewan === null) {

            $ukuran_hewan = $this->ukuran_hewan->getukuranhewan($id_ukuran_hewan);
            # code...

        } else {

            $ukuran_hewan = $this->ukuran_hewan->getukuranhewan($id_ukuran_hewan);
        }

        if ($ukuran_hewan) {

            $this->response([
                'status' => true,
                'data' => $ukuran_hewan,

            ], REST_Controller::HTTP_OK);
            # code...
        } else if($ukuran_hewan == null) {

            $this->response([
                'status' => true,
                'data' => $ukuran_hewan,
                'message' => 'DATA UKURAN HEWAN MASIH KOSONG',
            ], REST_Controller::HTTP_OK);
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, ID UKURAN HEWAN TIDAK DITEMUKAN / SALAH FORMAT !',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {

        $id_ukuran_hewan = $this->delete('id_ukuran_hewan');
        var_dump($id_ukuran_hewan);
        if ($id_ukuran_hewan === null) {
            # code...
            $this->response([
                'status' => false,

                'message' => 'GAGAL, ID UKURAN HEWAN TIDAK BOLEH KOSONG!',

            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->ukuran_hewan->deleteukuranHewan($id_ukuran_hewan) > 0) {
                //ok

                $this->response([
                    'status' => true,
                    'id_ukuran_hewan' => $id_ukuran_hewan,
                    'message' => 'SUKSES DELETE UKURAN HEWAN !',
                ], REST_Controller::HTTP_OK);
                # code...
            } else {
                ////id not found
                $this->response([
                    'status' => false,
                    'message' => 'GAGAL, ID UKURAN HEWAN TIDAK DITEMUKAN !',

                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_post()
    {

        $data = [
            'ukuran_hewan' => $this->post('ukuran_hewan'),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("0000:00:0:00:00"),
            'deleted_date' => date("0000:00:0:00:00"),
        ];
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

    public function index_put()
    {
        $id_ukuran_hewan = $this->put('id_ukuran_hewan');
        $data = [
            'ukuran_hewan' => $this->post('id_customer'),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("0000:00:0:00:00"),
            'deleted_date' => date("0000:00:0:00:00"),
        ];

        if ($this->ukuran_hewan->updateUkuranHewan($data, $id_ukuran_hewan) > 0) {
            # code...
            $this->response([
                'status' => true,
                'id_ukuran_hewan' => $id_ukuran_hewan,
                'message' => 'SUKSES UPDATED UKURAN HEWAN !',

            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'GAGAL UPDATED UKURAN HEWAN ID TIDAK DI TEMUKAN! !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}