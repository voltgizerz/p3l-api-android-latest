<?php
use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class DeletePermanent extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jenis_Hewan_model');
    }
    public function index_post($id)
    {

        if ($id === null) {
            # code...
            $this->response([
                'status' => false,
                'message' => 'provide an id not found',

            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->Jenis_Hewan_model->deletePermanentJenisHewan($id) > 0) {
                //ok

                $this->response([
                    'status' => true,
                    'id_jenis_hewan' => $id,
                    'message' => 'delete jenis hewan Sukses',
                ], REST_Controller::HTTP_CREATED);
                # code...
            } else if ($this->Jenis_Hewan_model->deletePermanentJenisHewan($id) == 0) {
                ////id not found
                $this->response([
                    'status' => false,
                    'message' => 'id tidak ada',

                ], REST_Controller::HTTP_BAD_REQUEST);
            } else if ($this->Jenis_Hewan_model->deletePermanentJenisHewan($id) == -1) {
                // ada foreign key
                $this->response([
                    'status' => false,
                    'message' => 'DATA INI SEDANG DIGUNAKAN!',
                ], REST_Controller::HTTP_CREATED);
            }
        }
    }
}