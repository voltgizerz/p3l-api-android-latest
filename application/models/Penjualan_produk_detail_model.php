<?php

class Penjualan_Produk_Detail_model extends CI_Model
{

    public function getDetailPenjualanProduk($id)
    {
        if ($id === null) {

            $this->db->select('data_detail_penjualan_produk.id_detail_penjualan_produk,data_detail_penjualan_produk.kode_transaksi_penjualan_produk_fk,data_detail_penjualan_produk.id_produk_penjualan_fk,data_detail_penjualan_produk.jumlah_produk,data_detail_penjualan_produk.subtotal,data_produk.nama_produk,data_produk.gambar_produk');
            $this->db->join('data_produk', 'data_produk.id_produk = data_detail_penjualan_produk.id_produk_penjualan_fk');
            $this->db->from('data_detail_penjualan_produk');
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