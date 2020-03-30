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
        $this->load->model('Hewan_model');
    }

    public function index_post($id_hewan = null)
    {
        date_default_timezone_set("Asia/Bangkok");
        $hewan = new HewanData();
        $hewan->nama_hewan = $this->post('nama_hewan');
        $hewan->id_jenis_hewan = $this->post('id_jenis_hewan');
        $hewan->id_ukuran_hewan = $this->post('id_ukuran_hewan');
        $hewan->id_customer = $this->post('id_customer');
        $hewan->tanggal_lahir_hewan = $this->post('tanggal_lahir_hewan');
        $hewan->updated_date = date("Y-m-d H:i:s");
        $hewan->deleted_date = date("0000:00:0:00:00");

        $response = $this->Hewan_model->updateHewan($hewan, $id_hewan);

        return $this->returnData($response['msg'], $response['error']);
    }

    public function returnData($msg, $error)
    {
        $response['error'] = $error;
        $response['message'] = $msg;
        return $this->response($response);
    }
}
class HewanData
{
    public $nama_hewan;
    public $id_jenis_hewan;
    public $id_ukuran_hewan;
    public $id_customer;
    public $tanggal_lahir_hewan;
    public $created_date;
    public $updated_date;
    public $deleted_date;
}