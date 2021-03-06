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

    public function deletePenjualanProduk($id, $kode)
    {
        $this->db->delete('data_detail_penjualan_produk', ['kode_transaksi_penjualan_produk_fk' => $kode['kode_transaksi_penjualan_produk']]);
        $this->db->delete('data_transaksi_penjualan_produk', ['id_transaksi_penjualan_produk' => $id]);
        $rowdelete = $this->db->affected_rows();
        return $rowdelete;

    }

    public function createPenjualan($data)
    {
        //MASUKAN DATA NYA BOS
        $this->db->insert('data_transaksi_penjualan_produk', $data);

        return $this->db->affected_rows();
    }

    public function updatePenjualanProduk($request, $id)
    {
        $updateData =
            [
            'tanggal_penjualan_produk' => $request->tanggal_penjualan_produk,
            'status_penjualan' => $request->status_penjualan,
            'id_hewan'=>$request->id_hewan,
            'updated_date' => $request->updated_date,
        ];

        if ($this->db->where('id_transaksi_penjualan_produk', $id)->update('data_transaksi_penjualan_produk', $updateData)) {
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