<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Search extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jasa_Layanan_model', 'jasa_layanan');
    }
    public function index_get($id)
    {

        $response = $this->jasa_layanan->getJasaLayananID($id);
        return $this->returnData($response['msg'], $response['error']);
    }

    public function returnData($msg, $error)
    {
        $response['error'] = $error;
        $response['message'] = $msg;
        return $this->response($response);
    }
}