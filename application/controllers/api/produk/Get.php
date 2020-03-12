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

        $this->load->model('Produk_model', 'produk');
    }

    public function index_get()
    {
        $id = $this->get('id_produk');
        if ($id === null) {

            $produk = $this->produk->getProduk($id);
            # code...

        } else {

            $produk = $this->produk->getProduk($id);
        }

        if ($produk) {

            $this->response([
                'status' => true,
                'data' => $produk,

            ], REST_Controller::HTTP_OK);
            # code...
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, ID produk TIDAK DITEMUKAN / SALAH FORMAT !',
            ], REST_Controller::HTTP_NOT_FOUND);
        }
    }
}