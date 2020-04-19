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
        $this->load->model('Customer_model');
    }

    public function index_post($id = null)
    {
        date_default_timezone_set("Asia/Bangkok");
        $customer = new UserData();
        $customer->created_date = date("Y-m-d H:i:s");
        $customer->deleted_date = date("0000:00:0:00:00");

        $response = $this->Customer_model->restoreCustomer($customer, $id);

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