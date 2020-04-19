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

            $this->db->select('id_produk,nama_produk,harga_produk,stok_produk,gambar_produk,stok_minimal_produk,created_date,updated_date,deleted_date');
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
        //TAMPUNG SEMENTARA DATA YANG KEMUNGKINAN BISA DIHAPUS
        $this->db->select('*');
        $this->db->from('data_produk');
        $this->db->where('id_produk', $id);
        $query = $this->db->get();
        $arrTampData = $query->result_array();

        if ($this->db->delete('data_produk', ['id_produk' => $id]) == false) {
            //INI JIKA DATA INI SEDANG DIGUNAKAN
            $rowAffected = $this->db->affected_rows();
            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        } else {
            // DATA BERHASIL DI HAPUS BERARTI TIDAK SEDANG DIGUNAKAN
           
            $data = [
                'id_produk' => $arrTampData[0]['id_produk'],
                'nama_produk' => $arrTampData[0]['nama_produk'],
                'harga_produk' => $arrTampData[0]['harga_produk'],
                'stok_produk' => $arrTampData[0]['stok_produk'],
                'gambar_produk' => $arrTampData[0]['gambar_produk'],
                'gambar_produk_desktop' =>  file_get_contents($arrTampData[0]['gambar_produk']),
                'stok_minimal_produk' => $arrTampData[0]['stok_minimal_produk'],
                'created_date' => $arrTampData[0]['created_date'],
                'updated_date' => $arrTampData[0]['updated_date'],
                'deleted_date' => $arrTampData[0]['deleted_date'],
            ];
            
            // RETURN DATA
            $this->db->insert('data_produk', $data);
            date_default_timezone_set("Asia/Bangkok");
            // INSERT DELETE AT DAN UPDATE DATA
            $updateData =
                ['created_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("Y-m-d H:i:s"),
            ];

            $this->db->where('id_produk', $id);
            $this->db->update('data_produk', $updateData);
            $rowAffected = $this->db->affected_rows();

            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
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
            'gambar_produk_desktop' => $request->gambar_produk_desktop,
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

    public function restoreProduk($request, $id)
    {
        $updateData =
            [
            'created_date' => $request->created_date,
            'deleted_date' => $request->deleted_date,
        ];

        if ($this->db->where('id_produk', $id)->update('data_produk', $updateData)) {
            return ['msg' => 'SUKSES RESTORE PRODUK!', 'id_produk' => $id, 'error' => false];
        }
        return ['msg' => 'GAGAL, RESTORE PRODUK ID TIDAK DITEMUKAN !', 'error' => true];

    }

}