<?php

class Produk_model extends CI_Model
{

    public function getProduk($id)
    {

        $this->db->select('id_produk,gambar_produk,gambar_produk_desktop');
        $this->db->from('data_produk');
        $this->db->where('gambar_produk', 'Gambar dari Desktop');
        $arrGambarDesktop = $this->db->get()->result_array();

        for ($i = 0; $i < count($arrGambarDesktop); $i++) {
            $filename = "img" . rand(9, 9999) . ".jpg";
            file_put_contents('upload/gambar_produk/' . $filename, $arrGambarDesktop[$i]['gambar_produk_desktop']);
            $this->db->where('id_produk', $arrGambarDesktop[$i]['id_produk'])->update('data_produk', ['gambar_produk' => 'upload/gambar_produk/' . $filename]);
        }

        if ($id === null) {

            $this->db->select('id_produk,nama_produk,harga_produk,gambar_produk,stok_minimal_produk,created_date,updated_date,deleted_date');
            $this->db->from('data_produk');
            return $this->db->get()->result_array();
            # code...
        } else {

            $this->db->select('id_produk,nama_produk,harga_produk,gambar_produk,stok_minimal_produk,created_date,updated_date,deleted_date');
            $this->db->from('data_produk');
            $this->db->where('id_produk', $id);
            return $this->db->get()->result_array();
        }
    }

    public function deleteProduk($id)
    {
        $this->db->db_debug = false;
        $this->db->delete('data_produk', ['id_produk' => $id]);
        $rowAffected = $this->db->affected_rows();
        $e = $this->db->error();

        if ($e['code'] == 1451) {
            return -1;
        } else {
            return $rowAffected;
        }
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
            'gambar_produk_desktop' =>$request->gambar_produk_desktop,
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

    public function cekGambar($id)
    {
        $this->id = $id;
        $query = "SELECT * FROM data_produk WHERE id_produk = $id &&  gambar_produk='upload/gambar_produk/default.jpg'";
        $result = $this->db->query($query, $this->id);

        $this->db->select('gambar_produk');
        $this->db->from('data_produk');
        $this->db->where('id_produk', $id);

        $gambar = $this->db->get()->row('gambar_produk');

        if ($result->num_rows() == 1) {
            return 1;
        } else {
            return $gambar;
        }

    }

}