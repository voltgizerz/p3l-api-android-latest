<?php

class Hewan_model extends CI_Model 
{

    public function getHewan($id_hewan)
    {
        if ($id_hewan === null) {

            return $this->db->get('data_hewan')->result_array();
            # code...
        } else {

            $this->db->where('id_hewan', $id_hewan);
            return $this->db->get('data_hewan')->result_array();
        }
    }

    public function deleteHewan($id_hewan)
    {
        $this->db->delete('data_hewan', ['id_hewan' => $id_hewan]);
        return $this->db->affected_rows();
    }
    public function createHewan($data)
    {
        $this->db->insert('data_hewan', $data);
        return $this->db->affected_rows();
    }

    public function updateHewan($request, $id_hewan)
    {
        $updateData =
            ['nama_hewan' => $request->nama_hewanr,
            'id_jenis_hewan' => $request->id_jenis_hewan,
            'id_ukuran_hewan' => $request->id_ukuran_hewan,
            'id_customer' => $request->id_customer,
            'tanggal_lahir_hewan' => $request->tanggal_lahir_hewan,
            'updated_date' => $request->updated_date,
            'deleted_date' => $request->deleted_date,
        ];

        if ($this->db->where('id_hewan', $id_hewan)->update('data_hewan', $updateData)) {
            return ['msg' => 'SUSKSES UPDATE HEWAN!', 'id_hewan' => $id_hewan, 'error' => false];
        }
        return ['msg' => 'GAGAL, UPDATE HEWAN ID TIDAK DITEMUKAN !', 'error' => true];
    }

    public function getHewanID($id_hewan)
    {
        $this->id_hewan = $id_hewan;
        $query = "SELECT * FROM data_hewan WHERE id_hewan = ?";
        $result = $this->db->query($query, $this->id_hewan);
        if ($result->num_rows() != 0) {
            return ['msg' => $result->result(), 'error' => false];
        } else {
            return ['msg' => 'GAGAL, CARI HEWAN ID TIDAK DITEMUKAN !', 'error' => true];
        }
    }
}
