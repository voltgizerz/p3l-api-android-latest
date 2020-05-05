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
        $this->load->model('Penjualan_produk_detail_model', 'penjualan');
    }
    public function index_post($id)
    {

        if ($id === null) {
            # code...
            $this->response([
                'status' => false,
                'message' => 'GAGAL ID TIDAK BOLEH KOSONG !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            $kodePenjualanProduk = [
                'kode_transaksi_penjualan_produk_fk' => $this->post('kode_transaksi_penjualan_produk_fk'),
            ];
            if ($this->penjualan->deletePenjualanProduk($id,$kodePenjualanProduk) > 0) {
                //ok

                $this->response([
                    'status' => true,
                    'id_transaksi_penjualan_produk_detail' => $id,
                    'message' => 'SUKSES DELETE PENJUALAN PRODUK DETAIL!',
                ], REST_Controller::HTTP_CREATED);
                # code...
            } else {
                ////id not found
                $this->response([
                    'status' => false,
                    'message' => 'GAGAL DELETE PENJUALAN PRODUK DETAIL ID TIDAK DITEMUKAN !',

                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}