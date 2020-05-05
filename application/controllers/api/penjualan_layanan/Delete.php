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
        $this->load->model('Penjualan_layanan_model');
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
            $kodePenjualanLayanan = [
                'kode_transaksi_penjualan_jasa_layanan' => $this->post('kode_transaksi_penjualan_jasa_layanan'),
            ];
            
            if ($this->Penjualan_layanan_model->deletePenjualanLayanan($id,$kodePenjualanLayanan) > 0) {
                //ok

                $this->response([
                    'status' => true,
                    'id_transaksi_pejualan_jasa_layanan' => $id,
                    'message' => 'SUKSES DELETE PENJUALAN LAYANAN!',
                ], REST_Controller::HTTP_CREATED);
                # code...
            } else {
                ////id not found
                $this->response([
                    'status' => false,
                    'message' => 'GAGAL DELETE PENJUALAN LAYANAN ID TIDAK DITEMUKAN !',

                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
    }
}