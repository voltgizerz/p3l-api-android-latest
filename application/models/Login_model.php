<?php

class Login_model extends CI_Model
{
    public function getLoginInfo($user)
    {
        $this->db->select('id_pegawai,nama_pegawai,username,role_pegawai');
        $this->db->where('username', $user);
        return $this->db->get('data_pegawai')->result_array();
    }
}