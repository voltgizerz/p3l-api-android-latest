<?php

class Login_model extends CI_Model
{
    public function getLoginInfo($user,$pass)
    {
        $this->db->select('id_pegawai,nama_pegawai,username,role_pegawai');
        $this->db->where("username like binary",$user);
        $this->db->where("password like binary",$pass);
        return $this->db->get('data_pegawai')->result_array();
    }
}