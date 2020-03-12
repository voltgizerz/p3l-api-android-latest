<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Delete extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jasa_Layanan_model');
    }
    public function index_post($id)
    {

        if ($id === null) {
            # code...
            $this->response([
                'status' => false,
                'message' => 'GAGAL ID TIDAK BOLEH KOSONG !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->Jasa_Layanan_model->deleteJasa_Layanan($id) > 0) {
                //ok

                $this->response([
                    'status' => true,
                    'id_jasa_layananr' => $id,
                    'message' => 'SUKSES DELETE Jasa Layanan!',
                ], REST_Controller::HTTP_CREATED);
                # code...
            } else {
                ////id not found
                $this->response([
                    'status' => false,
                    'message' => 'GAGAL DELETE JASA LAYANAN ID TIDAK DITEMUKAN !',

                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}