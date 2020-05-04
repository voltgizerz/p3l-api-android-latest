<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Create extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Penjualan_layanan_model', 'penjualan');
    }

    public function index_post()
    {
        date_default_timezone_set("Asia/Bangkok");
        $data = [
            'kode_transaksi_penjualan_jasa_layanan' => $this->penjualan->ambilKode(),
            'tanggal_penjualan_jasa_layanan' => date("0000:00:0:00:00"),
            'tanggal_pembayaran_jasa_layanan' => date("0000:00:0:00:00"),
            'id_hewan'=>$this->post('id_hewan'),
            'diskon' => '0',
            'total_penjualan_jasa_layanan' => '0',
            'status_penjualan' => 'Belum Selesai',
            'status_pembayaran' => 'Belum Lunas',
            'id_cs' => $this->post('id_cs'),
            'id_kasir' => $this->post('id_cs'),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("0000:00:0:00:00"),
            'total_harga' => '0',
        ];
        if ($this->penjualan->createPenjualan($data) > 0) {
            # code...
            $this->response([
                'status' => true,
                'message' => 'SUKSES TRANSAKSI PENJUALAN JASA LAYANAN BERHASIL DI TAMBAHKAN !',

            ], REST_Controller::HTTP_CREATED);
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, MENAMBAHKAN TRX LAYANAN BARU !',

            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}