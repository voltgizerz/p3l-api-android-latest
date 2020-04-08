<?php

class Pengadaan_detail_model extends CI_Model
{

    public function getPengadaan($id)
    {
        if ($id === null) {

           

            $this->db->select('data_detail_pengadaan.id_produk_fk,data_produk.nama_produk,data_detail_pengadaan.kode_pengadaan_fk,data_detail_pengadaan.satuan_pengadaan,data_detail_pengadaan.jumlah_pengadaan,data_detail_pengadaan.tanggal_pengadaan');
            $this->db->join('data_produk', 'data_produk.id_produk = data_detail_pengadaan.id_produk_fk');
            $this->db->from('data_detail_pengadaan');
            $query = $this->db->get();
            $arrTemp = $query->result_array();
            
            return $arrTemp;

            # code...
        } else {
            $this->db->where('kode_pengadaan', $id);

            return $this->db->get('data_detail_pengadaan')->result_array();
        }
    }

    public function deletePengadaan($id)
    {
        $this->db->delete('data_pengadaan', ['kode_pengadaan' => $id]);
        return $this->db->affected_rows();
    }
    public function createPengadaan($data)
    {
        $this->db->insert('data_pengadaan', $data);
        return $this->db->affected_rows();
    }

    public function updatePengadaan($request, $id)
    {
        $updateData =
            ['kode_pengadaan' => $request->kode_pengadaan,
            'id_supplier' => $request->id_supplier,
            'status' => $request->status,
            'tanggal_pengadaan' => $request->tanggal_pengadaan,
            'total' => $request->total,
        ];

        if ($this->db->where('kode_pengadaan', $id)->update('data_pengadaan', $updateData)) {
            return ['msg' => 'Berhasil Update pengadaan', 'error' => false];
        }
        return ['msg' => 'Gagal Update pengadaan', 'error' => true];
    }

    public function getPengadaanID($id)
    {
        $this->id = $id;
        $query = "SELECT * FROM data_pengadaan WHERE kode_pengadaan = ?";
        $result = $this->db->query($query, $this->id);
        if ($result->num_rows() != 0) {
            return ['msg' => $result->result(), 'error' => false];
        } else {
            return ['msg' => 'Data pengadaan Tidak Ditemukan', 'error' => true];
        }
    }
}