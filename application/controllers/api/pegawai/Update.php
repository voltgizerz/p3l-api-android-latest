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
        $this->load->model('Pegawai_model');
    }

    public function index_post($id = null)
    {
        $pegawai = new UserData();
        $pegawai->nama_pegawai = $this->post('nama_pegawai');
        $pegawai->alamat_pegawai = $this->post('alamat_pegawai');
        $pegawai->tanggal_lahir_pegawai = $this->post('tanggal_lahir_pegawai');
        $pegawai->nomor_hp_pegawai = $this->post('nomor_hp_pegawai');
        $pegawai->role_pegawai = $this->post('role_pegawai');
        $pegawai->username = $this->post('username');
        $pegawai->password = $this->post('password');
        $pegawai->updated_date = date("Y-m-d H:i:s");
        $pegawai->deleted_date = date("0000:00:0:00:00");

        $response = $this->Pegawai_model->updatePegawai($pegawai, $id);

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
    public $nama_pegawai;
    public $alamat_pegawai;
    public $tanggal_lahir_pegawai;
    public $nomor_hp_pegawai;
    public $role_pegawai;
    public $username;
    public $password;
    public $updated_date;
    public $deleted_date;
}
