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
        $this->load->model('Hewan_model', 'hewan');
    }
    public function index_get($id_hewan)
    {

        $response = $this->hewan->getHewanID($id_hewan);
        return $this->returnData($response['msg'], $response['error']);
    }

    public function returnData($msg, $error)
    {
        $response['error'] = $error;
        $response['message'] = $msg;
        return $this->response($response);
    }
}
