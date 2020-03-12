<?php

class Pegawai_model extends CI_Model
{

    public function getPegawai($id)
    {
        if ($id === null) {

            return $this->db->get('data_pegawai')->result_array();
            # code...
        } else {

            $this->db->where('id_pegawai', $id);
            return $this->db->get('data_pegawai')->result_array();
        }
    }

    public function deletePegawai($id)
    {
        $this->db->delete('data_pegawai', ['id_pegawai' => $id]);
        return $this->db->affected_rows();
    }
    public function createPegawai($data)
    {
        $this->db->insert('data_pegawai', $data);
        return $this->db->affected_rows();
    }

    public function updatePegawai($request, $id)
    {
        $updateData =
            ['nama_pegawai' => $request->nama_pegawai,
            'alamat_pegawai' => $request->alamat_pegawai,
            'tanggal_lahir_pegawai' => $request->tanggal_lahir_pegawai,
            'nomor_hp_pegawai' => $request->nomor_hp_pegawai,
            'role_pegawai' => $request->role_pegawai,
            'username' => $request->username,
            'password' => $request->password,
            'updated_date' => $request->updated_date,
            'deleted_date' => $request->deleted_date,
        ];

        if ($this->db->where('id_pegawai', $id)->update('data_pegawai', $updateData)) {
            return ['msg' => 'Berhasil Update Pegawai', 'error' => false];
        }
        return ['msg' => 'Gagal Update Pegawai', 'error' => true];
    }

    public function getPegawaiID($id)
    {
        $this->id = $id;
        $query = "SELECT * FROM data_pegawai WHERE id_pegawai = ?";
        $result = $this->db->query($query, $this->id);
        if ($result->num_rows() != 0) {
            return ['msg' => $result->result(), 'error' => false];
        } else {
            return ['msg' => 'Data Pegawai Tidak Ditemukan', 'error' => true];
        }
    }
}
