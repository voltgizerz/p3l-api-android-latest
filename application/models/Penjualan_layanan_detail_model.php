<?php

class Penjualan_Layanan_Detail_model extends CI_Model
{

    public function getDetailPenjualanLayanan($id)
    {
        if ($id === null) {

            $this->db->select('data_detail_penjualan_jasa_layanan.id_detail_penjualan_jasa_layanan,
            data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk,
            data_detail_penjualan_jasa_layanan.kode_transaksi_penjualan_jasa_layanan_fk,
            data_detail_penjualan_jasa_layanan.jumlah_jasa_layanan,
            data_detail_penjualan_jasa_layanan.subtotal,
            data_jasa_layanan.nama_jasa_layanan,
            a.id_jenis_hewan AS id_jenis_hewan,
            b.id_ukuran_hewan AS id_ukuran_hewan,
            data_jenis_hewan.nama_jenis_hewan,
            data_ukuran_hewan.ukuran_hewan');
            $this->db->join('data_jasa_layanan', 'data_jasa_layanan.id_jasa_layanan = data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk');
            $this->db->join('data_jasa_layanan a', 'a.id_jasa_layanan = data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk');
            $this->db->join('data_jasa_layanan b', 'b.id_jasa_layanan = data_detail_penjualan_jasa_layanan.id_jasa_layanan_fk');
            $this->db->join('data_ukuran_hewan', 'data_ukuran_hewan.id_ukuran_hewan = b.id_ukuran_hewan');
            $this->db->join('data_jenis_hewan', 'data_jenis_hewan.id_jenis_hewan = a.id_jenis_hewan');
         
            $this->db->from('data_detail_penjualan_jasa_layanan');
            $query = $this->db->get();
            $arrTemp = $query->result_array();

            return $arrTemp;
            # code...
        } else {

            $this->db->where('id_detail_penjualan_produk', $id);
            return $this->db->get('data_detail_penjualan_produk')->result_array();
        }
    }

    public function deletePenjualanProduk($id, $kode)
    {
        $this->db->delete('data_detail_penjualan_produk', ['id_detail_penjualan_produk' => $id]);
        $rowdelete = $this->db->affected_rows();

        //CARI NILAI TOTAL HARGA UPDATE
        $this->db->select('data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_produk.harga_produk');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk');
        $this->db->where('data_detail_penjualan_produk.kode_transaksi_penjualan_produk_fk', $kode['kode_transaksi_penjualan_produk_fk']);
        $this->db->from('data_detail_penjualan_produk');
        $query = $this->db->get();
        $arrTemp = json_decode(json_encode($query->result()), true);
        
        $this->db->where('kode_transaksi_penjualan_produk', $kode)->update('data_transaksi_penjualan_produk', ['updated_date' =>date("Y-m-d H:i:s")]);

        // NILAI TAMPUNG TOTAL HARGA YANG BARU
        $temp = 0;
        for ($i = 0; $i < count($arrTemp); $i++) {
            $temp = $temp + $arrTemp[$i]['jumlah_produk'] * $arrTemp[$i]['harga_produk'];
        }
        //UPDATE NILAI TOTAL PENGADAAN
        $this->db->where('kode_transaksi_penjualan_produk', $kode['kode_transaksi_penjualan_produk_fk'])->update('data_transaksi_penjualan_produk', ['total_penjualan_produk' => $temp]);

        return $rowdelete;

    }

    public function createPenjualanProdukDetail($data)
    {
        //MASUKAN DATA NYA BOS

        $this->db->insert('data_detail_penjualan_produk', $data);
        $rowcreate = $this->db->affected_rows();
        //CARI NILAI SUBTOTAL PRODUK DETAIL HARGA UPDATE
        $this->db->select('data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_produk.harga_produk');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk');
        $this->db->where('data_detail_penjualan_produk.subtotal', '0');
        $this->db->from('data_detail_penjualan_produk');
        $query = $this->db->get();
        $arrTemp = json_decode(json_encode($query->result()), true);

        // NILAI TAMPUNG SUB TOTAL  DETAIL PENJUALAN HARGA YANG BARU
        $temp = $arrTemp[0]['jumlah_produk'] * $arrTemp[0]['harga_produk'];
        //UPDATE NILAI TOTAL PENGADAAN
        $this->db->where('subtotal', '0')->update('data_detail_penjualan_produk', ['subtotal' => $temp]);

        //CARI NILAI TOTAL HARGA UPDATE
        $this->db->select('data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_produk.harga_produk');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk');
        $this->db->where('data_detail_penjualan_produk.kode_transaksi_penjualan_produk_fk', $data['kode_transaksi_penjualan_produk_fk']);
        $this->db->from('data_detail_penjualan_produk');
        $query = $this->db->get();
        $arrTemp = json_decode(json_encode($query->result()), true);

        // NILAI TAMPUNG TOTAL HARGA PENJUALAN YANG BARU
        $temp = 0;
        for ($i = 0; $i < count($arrTemp); $i++) {
            $temp = $temp + $arrTemp[$i]['jumlah_produk'] * $arrTemp[$i]['harga_produk'];
        }
        //UPDATE NILAI TOTAL PENGADAAN
        $this->db->where('kode_transaksi_penjualan_produk', $data['kode_transaksi_penjualan_produk_fk'])->update('data_transaksi_penjualan_produk', ['total_penjualan_produk' => $temp,'updated_date' =>date("Y-m-d H:i:s")]);

        return $rowcreate;
    }

    public function updatePenjualanProdukDetail($request, $id)
    {
        $updateData =
            [
            'kode_transaksi_penjualan_produk_fk' => $request->kode_transaksi_penjualan_produk_fk,
            'id_produk_penjualan_fk' => $request->id_produk_penjualan_fk,
            'jumlah_produk' => $request->jumlah_produk,
        ];

        if ($this->db->where('id_detail_penjualan_produk', $id)->update('data_detail_penjualan_produk', $updateData)) {
            //CARI NILAI TOTAL HARGA UPDATE
            $this->db->select('data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_produk.harga_produk');
            $this->db->join('data_produk', 'data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk');
            $this->db->where('data_detail_penjualan_produk.kode_transaksi_penjualan_produk_fk', $updateData['kode_transaksi_penjualan_produk_fk']);
            $this->db->from('data_detail_penjualan_produk');
            $query = $this->db->get();
            $arrTemp = json_decode(json_encode($query->result()), true);

            // NILAI TAMPUNG TOTAL HARGA PENJUALAN YANG BARU
            $temp = 0;
            for ($i = 0; $i < count($arrTemp); $i++) {
                $temp = $temp + $arrTemp[$i]['jumlah_produk'] * $arrTemp[$i]['harga_produk'];
            }
            //UPDATE NILAI TOTAL PENGADAAN
            $this->db->where('kode_transaksi_penjualan_produk', $updateData['kode_transaksi_penjualan_produk_fk'])->update('data_transaksi_penjualan_produk', ['total_penjualan_produk' => $temp,'updated_date' =>date("Y-m-d H:i:s")]);

            //CARI NILAI SUBTOTAL PRODUK DETAIL HARGA UPDATE
            $this->db->select('data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_produk.harga_produk');
            $this->db->join('data_produk', 'data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk');
            $this->db->where('data_detail_penjualan_produk.id_detail_penjualan_produk', $id);
            $this->db->from('data_detail_penjualan_produk');
            $query = $this->db->get();
            $arrTemp = json_decode(json_encode($query->result()), true);

            // NILAI TAMPUNG SUB TOTAL  DETAIL PENJUALAN HARGA YANG BARU
            $temp = $arrTemp[0]['jumlah_produk'] * $arrTemp[0]['harga_produk'];
            //UPDATE NILAI TOTAL PENGADAAN
            $this->db->where('id_detail_penjualan_produk', $id)->update('data_detail_penjualan_produk', ['subtotal' => $temp]);

            return ['msg' => 'Berhasil Update Penjualan Produk', 'error' => false];
        }

        return ['msg' => 'Gagal Update Penjualan Produk', 'error' => true];
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