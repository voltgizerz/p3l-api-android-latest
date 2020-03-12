<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Get extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Customer_model', 'customer');
    }

    public function index_get()
    {
        $id = $this->get('id_customer');
        if ($id === null) {

            $customer = $this->customer->getCustomer($id);
            # code...

        } else {

            $customer = $this->customer->getCustomer($id);
        }

        if ($customer) {

            $this->response([
                'status' => true,
                'data' => $customer,

            ], REST_Controller::HTTP_OK);
            # code...
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, ID CUSTOMER TIDAK DITEMUKAN / SALAH FORMAT !',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}