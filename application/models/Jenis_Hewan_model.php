<?php

class Jenis_Hewan_model extends CI_Model
{

    public function getJenisHewan($id)
    {
        if ($id === null) {

            return $this->db->get('data_jenis_hewan')->result_array();
            # code...
        } else {

            $this->db->where('id_jenis_hewan', $id);
            return $this->db->get('data_jenis_hewan')->result_array();
        }
    }

    public function deleteJenisHewan($id)
    {
        $this->db->delete('data_jenis_hewan', ['id_jenis_hewan' => $id]);
        return $this->db->affected_rows();
    }
    public function createJenisHewan($data)
    {
        $this->db->insert('data_jenis_hewan', $data);
        return $this->db->affected_rows();
    }

    public function updateJenisHewan($request, $id)
    {
        $updateData =
            ['nama_jenis_hewan' => $request->nama_jenis_hewan,
            'updated_date' => $request->updated_date,
            'deleted_date' => $request->deleted_date,
        ];

        if ($this->db->where('id_jenis_hewan', $id)->update('data_jenis_hewan', $updateData)) {
            return ['msg' => 'Berhasil Update Jenis Hewan', 'error' => false];
        }
        return ['msg' => 'Gagal Update Jenis Hewan', 'error' => true];
    }

    public function getJenisHewanID($id)
    {
        $this->id = $id;
        $query = "SELECT * FROM data_jenis_hewan WHERE id_jenis_hewan = ?";
        $result = $this->db->query($query, $this->id);
        if ($result->num_rows() != 0) {
            return ['msg' => $result->result(), 'error' => false];
        } else {
            return ['msg' => 'Data Jenis Hewan Tidak Ditemukan', 'error' => true];
        }
    }
}
