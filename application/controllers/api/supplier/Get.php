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

        $this->load->model('Supplier_model', 'supplier');
    }

    public function index_get()
    {
        $id = $this->get('id_supplier');
        if ($id === null) {

            $supplier = $this->supplier->getSupplier($id);
            # code...

        } else {

            $supplier = $this->supplier->getSupplier($id);
        }

        if ($supplier) {

            $this->response([
                'status' => true,
                'data' => $supplier,

            ], REST_Controller::HTTP_OK);
            # code...
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, ID SUPPLIER TIDAK DITEMUKAN / SALAH FORMAT !',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}