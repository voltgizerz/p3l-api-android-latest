<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Restore extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jasa_Layanan_model');
    }

    public function index_post($id = null)
    {
        date_default_timezone_set("Asia/Bangkok");
        $layanan = new UserData();
        $layanan->created_date = date("Y-m-d H:i:s");
        $layanan->deleted_date = date("0000:00:0:00:00");

        $response = $this->Jasa_Layanan_model->restorelayanan($layanan, $id);

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
    public $created_date;
    public $deleted_date;
}