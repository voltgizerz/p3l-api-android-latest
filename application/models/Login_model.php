<?php

class Login_model extends CI_Model
{

    public function loginPegawai($id)
    {
        if ($id === null) {

            return $this->db->get('data_pegawai')->result_array();
            # code...
        } else {

            $this->db->where('id_pegawai', $id);
            return $this->db->get('data_pegawai')->result_array();
        }
    }

}