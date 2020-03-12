<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Update extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Ukuran_Hewan_model');
    }

    public function index_post($id_hewan = null)
    {
        $ukuran_hewan = new UkuranHewanData();
        $ukuran_hewan->ukuran_hewan = $this->post('ukuran_hewan');
        $ukuran_hewan->updated_date = date("Y-m-d H:i:s");
        $ukuran_hewan->deleted_date = date("0000:00:0:00:00");

        $response = $this->Ukuran_Hewan_model->updateUkuranHewan($ukuran_hewan, $id_ukuran_hewan);

        return $this->returnData($response['msg'], $response['error']);
    }

    public function returnData($msg, $error)
    {
        $response['error'] = $error;
        $response['message'] = $msg;
        return $this->response($response);
    }
}
class UkuranHewanData
{
    public $ukuran_hewan;
    public $created_date;
    public $updated_date;
    public $deleted_date;
}
