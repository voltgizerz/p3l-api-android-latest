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
        $this->load->model('Ukuran_Hewan_model'); 
    }
    public function index_post($id_ukuran_hewan)
    {

        if ($id_ukuran_hewan === null) {
            # code...
            $this->response([
                'status' => false,
                'message' => 'GAGAL, ID UKURAN HEWAN TIDAK BOLEH KOSONG !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->Ukuran_Hewan_model->deleteUkuranHewan($id_ukuran_hewan) > 0) {
                //ok

                $this->response([
                    'status' => true,
                    'id_hewan' => $id_ukuran_hewan,
                    'message' => 'SUKSES DELETE UKURAN HEWAN !',
                ], REST_Controller::HTTP_CREATED);
                # code...
            } else {
                ////id not found
                $this->response([
                    'status' => false,
                    'message' => 'GAGAL DELETE UKURAN HEWAN ID TIDAK DITEMUKAN !',

                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}