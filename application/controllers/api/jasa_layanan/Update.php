<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Update extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Jasa_Layanan_model');
    }

    public function index_post($id = null)
    {
        $jasa_layanan = new UserData();
        $jasa_layanan->nama_jasa_layanan = $this->post('nama_jasa_layanan');
        $jasa_layanan->harga_jasa_layanan = $this->post('harga_jasa_layanan');
        $jasa_layanan->id_jenis_hewan = $this->post('id_jenis_hewan');
        $jasa_layanan->id_ukuran_hewan = $this->post('id_ukuran_hewan');
        $jasa_layanan->updated_date = date("Y-m-d H:i:s");
        $jasa_layanan->deleted_date = date("0000:00:0:00:00");

        $response = $this->Jasa_Layanan_model->updateJasaLayanan($jasa_layanan, $id);

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
    public $nama_jasa_layanan;
    public $harga_jasa_layanan;
    public $id_jenis_hewan;
    public $id_ukuran_hewan;
    public $updated_date;
    public $deleted_date;
}