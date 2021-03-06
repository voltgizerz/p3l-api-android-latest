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

        $this->load->model('Login_model', 'login');
    }

    public function index_post()
    {
        $user = $this->post('username');
        $pass = $this->post('password');
        //CEK USERNAME ADA ATAU TIDAK
        $queryuser = "SELECT * FROM data_pegawai WHERE BINARY username = '$user'";
        $resultuser = $this->db->query($queryuser, $user);
        if ($resultuser->num_rows() >= 1) {
            $checkPass = $this->db->get_where('data_pegawai', ['username' => $user])->row()->password;
            if (password_verify($pass, $checkPass)) {
                $query = "SELECT * FROM data_pegawai WHERE BINARY username = '$user' && BINARY password = '$checkPass'";
            } else {
                $query = "SELECT * FROM data_pegawai WHERE BINARY username = '$user' && BINARY password = '$pass'";
            }
        } else {
            $query = "SELECT * FROM data_pegawai WHERE BINARY username = '$user' && BINARY password = '$pass'";
        }

        $this->db->select('*');
        $this->db->where('username', $user);
        $testing = $this->db->get('data_pegawai');

        $result = $this->db->query($query, $user);

        if ($resultuser->num_rows() >= 1 && $result->num_rows() < 1) {

            $this->response([
                'status' => false,
                'message' => 'PASSWORD ANDA SALAH!',

            ], REST_Controller::HTTP_CREATED);
        } else if ($resultuser->num_rows() < 1) {

            $this->response([
                'status' => false,
                'message' => 'USERNAME TIDAK TERDAFTAR!',

            ], REST_Controller::HTTP_CREATED);
        } else if ($result->num_rows() >= 1) {

            $arr = $this->login->getLoginInfo($user, $checkPass);

            $this->response([
                'status' => true,
                'message' => 'SUKSES, LOGIN PEGAWAI!',
                'data' => $arr,

            ], REST_Controller::HTTP_CREATED);
        } else {

            $this->response([
                'status' => false,
                'message' => 'GAGAL, LOGIN PEGAWAI!',

            ], REST_Controller::HTTP_BAD_REQUEST);
        }
    }
}