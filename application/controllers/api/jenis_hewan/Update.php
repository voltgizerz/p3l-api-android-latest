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
        $this->load->model('Jenis_Hewan_model');
    }

    public function index_post($id = null)
    {
        $jenis_hewan = new UserData();
        $jenis_hewan->nama_jenis_hewan = $this->post('nama_jenis_hewan');
        $jenis_hewan->created_date = date("Y-m-d H:i:s");
        $jenis_hewan->updated_date = date("Y-m-d H:i:s");
        $jenis_hewan->deleted_date = date("0000:00:0:00:00");

        $response = $this->Jenis_Hewan_model->updateJenisHewan($jenis_hewan, $id);

        return $this->returnData($response['msg'], $response['error']);
    }

    public function returnData($msg, $error)
    {
        $response['error'] = $error;
        $response['message'] = $msg;
        return $this->response($response);
    }
}
class UserData
{
    public $nama_jenis_hewan;
    public $created_date;
    public $updated_date;
    public $deleted_date;
}
