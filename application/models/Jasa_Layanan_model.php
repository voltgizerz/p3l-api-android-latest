<?php

class Jasa_Layanan_model extends CI_Model
{

    public function getJasaLayanan($id)
    {
        if ($id === null) {

            return $this->db->get('data_jasa_layanan')->result_array();
            # code...
        } else {

            $this->db->where('id_jasa_layanan', $id);
            return $this->db->get('data_jasa_layanan')->result_array();
        }
    }

    public function deleteJasaLayanan($id)
    {
        $this->db->delete('data_jasa_layanan', ['id_jasa_layanan' => $id]);
        return $this->db->affected_rows();
    }
    public function createJasaLayanan($data)
    {
        $this->db->insert('data_jasa_layanan', $data);
        return $this->db->affected_rows();
    }

    public function updateJasaLayanan($request, $id)
    {
        $updateData =
            ['nama_jasa_layanan' => $request->nama_jasa_layanan,
            'harga_jasa_layanan' => $request->harga_jasa_layanan,
            'id_jenis_hewan' => $request->id_jenis_hewan,
            'id_ukuran_hewan' => $request->id_ukuran_hewan,
            'updated_date' => $request->updated_date,
            'deleted_date' => $request->deleted_date,
        ];

        if ($this->db->where('id_jasa_layanan', $id)->update('data_jasa_layanan', $updateData)) {
            return ['msg' => 'Berhasil Update Jasa Layanan', 'error' => false];
        }
        return ['msg' => 'Gagal Update Jasa Layanan', 'error' => true];
    }

    public function getJasaLayananID($id)
    {
        $this->id = $id;
        $query = "SELECT * FROM data_jasa_layanan WHERE id_jasa_layanan = ?";
        $result = $this->db->query($query, $this->id);
        if ($result->num_rows() != 0) {
            return ['msg' => $result->result(), 'error' => false];
        } else {
            return ['msg' => 'Data Jasa Layanan Tidak Ditemukan', 'error' => true];
        }
    }
}
