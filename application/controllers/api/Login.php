<?php

use Restserver\Libraries\REST_Controller;

defined('BASEPATH') or exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Login extends REST_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Login_model','api');
    }

    public function index_post()
    {

        $user = $this->post('username');
        $pass = $this->post('password');
        
        $query = "SELECT username FROM data_pegawai WHERE username = '$user' && password = '$pass'";
        $queryuser =  "SELECT username FROM data_pegawai WHERE username = '$user'";

        $result = $this->db->query($query, $user);
        $resultuser = $this->db->query($queryuser, $user);
    

        if ($resultuser->num_rows() >= 1 && $result->num_rows() < 1) {

            $this->response([
                'status' => false,
                'message' => 'PASSWORD ANDA SALAH!',

            ], REST_Controller::HTTP_CREATED);
        }else if($resultuser->num_rows() < 1){
            
            $this->response([
                'status' => false,
                'message' => 'USERNAME TIDAK TERDAFTAR!',

            ], REST_Controller::HTTP_CREATED);
        } else if($result->num_rows() >= 1){
            
            $this->response([
                'status' => true,
                'message' => 'SUKSES, LOGIN PEGAWAI!',

            ], REST_Controller::HTTP_CREATED);
        } else {
            
            $this->response([
                'status' => false,
                'message' => 'GAGAL, LOGIN PEGAWAI!',
                
            ], REST_Controller::HTTP_BAD_REQUEST);
        }
}
}