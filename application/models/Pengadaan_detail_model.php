<?php

class Pengadaan_detail_model extends CI_Model
{

    public function getPengadaan($id)
    {
        if ($id === null) {

            $this->db->select('data_detail_pengadaan.id_detail_pengadaan,data_detail_pengadaan.id_produk_fk,data_produk.nama_produk,data_produk.gambar_produk,data_detail_pengadaan.kode_pengadaan_fk,data_detail_pengadaan.satuan_pengadaan,data_detail_pengadaan.jumlah_pengadaan,data_detail_pengadaan.tanggal_pengadaan');
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

    public function deletePengadaanDetail($PengadaanDetail,$id)
    {
        $this->db->delete('data_detail_pengadaan', ['id_detail_pengadaan' => $id]);
        $rowdelete = $this->db->affected_rows();
        //CARI NILAI TOTAL HARGA UPDATE
        $this->db->select('data_detail_pengadaan.id_produk_fk,data_detail_pengadaan.jumlah_pengadaan,data_produk.harga_produk');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_pengadaan.id_produk_fk');
        $this->db->where('data_detail_pengadaan.kode_pengadaan_fk', $PengadaanDetail['kode_pengadaan_fk']);
        $this->db->from('data_detail_pengadaan');
        $query = $this->db->get();
        $arrTemp = json_decode(json_encode($query->result()), true);
        
        $this->db->where('kode_pengadaan', $PengadaanDetail['kode_pengadaan_fk'])->update('data_pengadaan', ['updated_date' =>date("Y-m-d H:i:s")]);

        // NILAI TAMPUNG TOTAL HARGA YANG BARU
        $temp = 0;
        for ($i = 0; $i < count($arrTemp); $i++) {
            $temp = $temp + $arrTemp[$i]['jumlah_pengadaan'] * $arrTemp[$i]['harga_produk'];
        }
        //UPDATE NILAI TOTAL PENGADAAN
        $this->db->where('kode_pengadaan', $PengadaanDetail['kode_pengadaan_fk'])->update('data_pengadaan', ['total' => $temp]);

        return $rowdelete;

    }
    public function createPengadaanDetail($data)
    {
        //MASUKAN DATA NYA BOS
        $this->db->insert('data_detail_pengadaan', $data);
        //CARI NILAI TOTAL HARGA UPDATE
        $this->db->select('data_detail_pengadaan.id_produk_fk,data_detail_pengadaan.jumlah_pengadaan,data_produk.harga_produk');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_pengadaan.id_produk_fk');
        $this->db->where('data_detail_pengadaan.kode_pengadaan_fk', $data['kode_pengadaan_fk']);
        $this->db->from('data_detail_pengadaan');
        $query = $this->db->get();
        $arrTemp = json_decode(json_encode($query->result()), true);
        // NILAI TAMPUNG TOTAL HARGA YANG BARU
        $temp = 0;
        for ($i = 0; $i < count($arrTemp); $i++) {
            $temp = $temp + $arrTemp[$i]['jumlah_pengadaan'] * $arrTemp[$i]['harga_produk'];
        }
        //UPDATE NILAI TOTAL PENGADAAN
        $this->db->where('kode_pengadaan', $data['kode_pengadaan_fk'])->update('data_pengadaan', ['total' => $temp,'updated_date' =>date("Y-m-d H:i:s")]);

        return $this->db->affected_rows();
    }

    public function updatePengadaanDetail($request, $id)
    {
        date_default_timezone_set("Asia/Bangkok");
        $updateData =
            ['id_produk_fk' => $request->id_produk_fk,
            'satuan_pengadaan' => $request->satuan_pengadaan,
            'jumlah_pengadaan' => $request->jumlah_pengadaan,
        ];

        if ($this->db->where('id_detail_pengadaan', $id)->update('data_detail_pengadaan', $updateData)) {
            //CARI NILAI TOTAL HARGA UPDATE
            $this->db->select('data_detail_pengadaan.id_produk_fk,data_detail_pengadaan.jumlah_pengadaan,data_produk.harga_produk');
            $this->db->join('data_produk', 'data_produk.id_produk = data_detail_pengadaan.id_produk_fk');
            $this->db->where('data_detail_pengadaan.kode_pengadaan_fk', $request->kode_pengadaan_fk);
            $this->db->from('data_detail_pengadaan');
            $query = $this->db->get();
            $arrTemp = json_decode(json_encode($query->result()), true);
            // NILAI TAMPUNG TOTAL HARGA YANG BARU
            $temp = 0;
            for ($i = 0; $i < count($arrTemp); $i++) {
                $temp = $temp + $arrTemp[$i]['jumlah_pengadaan'] * $arrTemp[$i]['harga_produk'];
            }
            //UPDATE NILAI TOTAL PENGADAAN
            $this->db->where('kode_pengadaan', $request->kode_pengadaan_fk)->update('data_pengadaan', ['total' => $temp,'updated_date' =>date("Y-m-d H:i:s")]);

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