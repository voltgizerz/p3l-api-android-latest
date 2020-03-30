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

        $this->load->model('Pegawai_model', 'pegawai');
    }

    public function index_post()
    {
        date_default_timezone_set("Asia/Bangkok");    
        $data = [
            'nama_pegawai' => $this->post('nama_pegawai'),
            'alamat_pegawai' => $this->post('alamat_pegawai'),
            'tanggal_lahir_pegawai' => $this->post('tanggal_lahir_pegawai'),
            'nomor_hp_pegawai' => $this->post('nomor_hp_pegawai'),
            'role_pegawai' => $this->post('role_pegawai'),
            'username' => $this->post('username'),
            'password' => password_hash($this->post('password'),PASSWORD_DEFAULT),
            'created_date' => date("Y-m-d H:i:s"),
            'updated_date' => date("0000:00:0:00:00"),
            'deleted_date' => date("0000:00:0:00:00"),
        ];
        
        // check username 
        $user = $this->post('username');

        $query = "SELECT username FROM data_pegawai WHERE username = '$user'";
        $result = $this->db->query($query, $user);
        if ($result->num_rows() >= 1) {
    
            $this->response([
                'status' => false,
                'message' => 'GAGAL, USERNAME SUDAH TERDAFTAR!',

            ], REST_Controller::HTTP_BAD_REQUEST);
        } else {
            if ($this->pegawai->createPegawai($data) > 0) {
                # code...
                $this->response([
                    'status' => true,
                    'message' => 'SUKSES PEGAWAI BERHASIL DI TAMBAHKAN !',
    
                ], REST_Controller::HTTP_CREATED);
            } else {
    
                $this->response([
                    'status' => false,
                    'message' => 'GAGAL, MENAMBAHKAN PEGAWAI BARU !',
    
                ], REST_Controller::HTTP_BAD_REQUEST);
            }
        }
        
    }
}