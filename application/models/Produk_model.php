<?php

class Produk_model extends CI_Model
{

    public function getProduk($id)
    {
        if ($id === null) {

            return $this->db->get('data_produk')->result_array();
            # code...
        } else {

            $this->db->where('id_produk', $id);
            return $this->db->get('data_produk')->result_array();
        }
    }

    public function deleteProduk($id)
    {
        $this->db->delete('data_produk', ['id_produk' => $id]);
        return $this->db->affected_rows();
    }
    public function createProduk($data)
    {
        $this->db->insert('data_produk', $data);
        return $this->db->affected_rows();
    }

    public function updateProduk($request, $id)
    {
        $updateData =
            ['nama_produk' => $request->nama_produk,
            'harga_produk' => $request->harga_produk,
            'stok_produk' => $request->stok_produk,
            'gambar_produk' => $request->gambar_produk,
            'stok_minimal_produk' => $request->stok_minimal_produk,
            'updated_date' => $request->updated_date,
            'deleted_date' => $request->deleted_date,
        ];

        if ($this->db->where('id_produk', $id)->update('data_produk', $updateData)) {
            return ['msg' => 'Berhasil Update Produk', 'error' => false];
        }
        return ['msg' => 'Gagal Update Produk', 'error' => true];
    }

    public function getProdukID($id)
    {
        $this->id = $id;
        $query = "SELECT * FROM data_produk WHERE id_produk = ?";
        $result = $this->db->query($query, $this->id);
        if ($result->num_rows() != 0) {
            return ['msg' => $result->result(), 'error' => false];
        } else {
            return ['msg' => 'Data Tidak Ditemukan', 'error' => true];
        }
    }
}