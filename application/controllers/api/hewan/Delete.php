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
        $this->load->model('Hewan_model');
    }
    public function index_post($id_hewan)
    {
        if ($id_hewan === null) {
            # code...
            $this->response([
                'status' => false,
                'message' => 'GAGAL, ID HEWAN TIDAK BOLEH KOSONG !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->Hewan_model->deleteHewan($id_hewan) > 0) {
                //ok
                $this->response([
                    'status' => true,
                    'id_hewan' => $id_hewan,
                    'message' => 'SUKSES DELETE HEWAN !',
                ], REST_Controller::HTTP_CREATED);
            } else if ($this->Hewan_model->deleteHewan($id_hewan) == 0) {
                ////id not found
                $this->response([
                    'status' => false,
                    'message' => 'GAGAL DELETE HEWAN ID TIDAK DITEMUKAN !',

                ], REST_Controller::HTTP_BAD_REQUEST);
            } else if ($this->Hewan_model->deleteHewan($id_hewan) == -1) {
                // ada foreign key
                $this->response([
                    'status' => false,
                    'message' => 'DATA INI SEDANG DIGUNAKAN!',
                ], REST_Controller::HTTP_CREATED);
            }
        }
    }
}