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

        $this->load->model('Hewan_model', 'hewan');
    }

    public function index_get()
    {
        $id_hewan = $this->get('id_hewan');
        if ($id_hewan === null) {

            $hewan = $this->hewan->gethewan($id_hewan);
            # code...

        } else {

            $hewan = $this->hewan->gethewan($id_hewan);
        }

        if ($hewan) {

            $this->response([
                'status' => true,
                'data' => $hewan,

            ], REST_Controller::HTTP_OK);
            # code...
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, ID HEWAN TIDAK DITEMUKAN / SALAH FORMAT !',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }

    public function index_delete()
    {

        $id_hewan = $this->delete('id_hewan');
        var_dump($id_hewan);
        if ($id_hewan === null) {
            # code...
            $this->response([
                'status' => false,

                'message' => 'GAGAL, ID HEWAN TIDAK BOLEH KOSONG!',

            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->hewan->deleteHewan($id_hewan) > 0) {
                //ok

                $this->response([
                    'status' => true,
                    'id_hewan' => $id_hewan,
                    'message' => 'SUKSES DELETE HEWAN !',
                ], REST_Controller::HTTP_OK);
                # code...
            } else {
                ////id not found
                $this->response([
                    'status' => false,
                    'message' => 'GAGAL, ID HEWAN TIDAK DITEMUKAN !',

                ], REST_Controller::HTTP_NOT_FOUND);
            }
        }
    }

    public function index_post()
    {

        $data = [
            'nama_hewan' => $this->post('nama_hewan'),
            'id_jenis_hewan' => $this->post('id_jenis_hewan'),
            'id_ukuran_hewan' => $this->post('id_ukuran_hewan'),
            'id_customer' => $this->post('id_customer'),
            'tanggal_lahir_hewan' => $this->post('tanggal_lahir_hewan'),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("0000:00:0:00:00"),
            'deleted_date' => date("0000:00:0:00:00"),
        ];
        if ($this->hewan->createHewan($data) > 0) {
            # code...
            $this->response([
                'status' => true,
                'message' => 'SUKSES HEWAN BERHASIL DI TAMBAHKAN !',

            ], REST_Controller::HTTP_CREATED);
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, MENAMBAHKAN HEWAN BARU !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }

    public function index_put()
    {
        $id_hewan = $this->put('id_hewan');
        $data = [
            'nama_hewan' => $this->post('nama_hewan'),
            'id_jenis_hewan' => $this->post('id_jenis_hewan'),
            'id_ukuran_hewan' => $this->post('id_ukuran_hewan'),
            'id_customer' => $this->post('id_customer'),
            'tanggal_lahir_hewan' => $this->post('tanggal_lahir_hewan'),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("0000:00:0:00:00"),
            'deleted_date' => date("0000:00:0:00:00"),
        ];

        if ($this->hewan->updateHewan($data, $id_hewan) > 0) {
            # code...
            $this->response([
                'status' => true,
                'id_hewan' => $id_hewan,
                'message' => 'SUKSES UPDATED HEWAN !',

            ], REST_Controller::HTTP_OK);
        } else {
            $this->response([
                'status' => false,
                'message' => 'GAGAL UPDATED HEWAN ID TIDAK DI TEMUKAN! !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}