<?php

class Penjualan_Produk_model extends CI_Model
{

    public function getPenjualanProduk($id)
    {
        if ($id === null) {

            $this->db->select('data_transaksi_penjualan_produk.id_transaksi_penjualan_produk,data_transaksi_penjualan_produk.kode_transaksi_penjualan_produk
            ,data_transaksi_penjualan_produk.tanggal_penjualan_produk,
            data_transaksi_penjualan_produk.tanggal_pembayaran_produk,data_transaksi_penjualan_produk.diskon,
            data_transaksi_penjualan_produk.total_penjualan_produk,data_transaksi_penjualan_produk.total_harga,data_transaksi_penjualan_produk.status_penjualan,data_transaksi_penjualan_produk.status_pembayaran,data_transaksi_penjualan_produk.id_cs,
            data_transaksi_penjualan_produk.id_kasir,data_transaksi_penjualan_produk.created_date,data_transaksi_penjualan_produk.updated_date,
            data_pegawai.nama_pegawai AS nama_cs, a.nama_pegawai AS nama_kasir');
            $this->db->join('data_pegawai', 'data_pegawai.id_pegawai = data_transaksi_penjualan_produk.id_cs');
            $this->db->join('data_pegawai a', 'a.id_pegawai = data_transaksi_penjualan_produk.id_kasir');
            $this->db->from('data_transaksi_penjualan_produk');
            $query = $this->db->get();
            $arrTemp = $query->result_array();

            return $arrTemp;

            # code...
        } else {
            $this->db->where('id_transaksi_penjualan_produk', $id);
            
            return $this->db->get('data_transaksi_penjualan_produk')->result_array();
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
        // NILAI TAMPUNG TOTAL HARGA YANG BARU
        $temp = 0;
        for ($i = 0; $i < count($arrTemp); $i++) {
            $temp = $temp + $arrTemp[$i]['jumlah_pengadaan'] * $arrTemp[$i]['harga_produk'];
        }
        //UPDATE NILAI TOTAL PENGADAAN
        $this->db->where('kode_pengadaan', $PengadaanDetail['kode_pengadaan_fk'])->update('data_pengadaan', ['total' => $temp]);

        return $rowdelete;

    }
    public function createPenjualan($data)
    {
        //MASUKAN DATA NYA BOS
        $this->db->insert('data_transaksi_penjualan_produk', $data);
        
        return $this->db->affected_rows();
    }

    public function updatePengadaanDetail($request, $id)
    {
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
            $this->db->where('kode_pengadaan', $request->kode_pengadaan_fk)->update('data_pengadaan', ['total' => $temp]);

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

    public function ambilKode()
    {
        date_default_timezone_set("Asia/Bangkok");
        $query = "SHOW TABLE STATUS LIKE 'data_transaksi_penjualan_produk'";
        $result = $this->db->query($query)->result();
        $hari = date('d');
        $bln = date('m');
        $thn = date('y');
        if ($result[0]->Auto_increment > 9) {
            return ("PR-" . $hari . $bln . $thn . "-" . $result[0]->Auto_increment);
        } else {
            return ("PR-" . $hari . $bln . $thn . "-0" . $result[0]->Auto_increment);
        }
    }

}