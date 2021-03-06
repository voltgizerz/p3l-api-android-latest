<?php

class Penjualan_Layanan_model extends CI_Model
{

    public function getPenjualanLayanan($id)
    {
        if ($id === null) {

            $this->db->select('data_transaksi_penjualan_jasa_layanan.id_transaksi_penjualan_jasa_layanan,
            data_transaksi_penjualan_jasa_layanan.kode_transaksi_penjualan_jasa_layanan,
            data_transaksi_penjualan_jasa_layanan.id_hewan,
            data_transaksi_penjualan_jasa_layanan.tanggal_penjualan_jasa_layanan, 
            data_transaksi_penjualan_jasa_layanan.tanggal_pembayaran_jasa_layanan,status_layanan,
            data_transaksi_penjualan_jasa_layanan.status_penjualan,
            data_transaksi_penjualan_jasa_layanan.status_pembayaran,
            data_transaksi_penjualan_jasa_layanan.diskon,total_penjualan_jasa_layanan,
            data_transaksi_penjualan_jasa_layanan.id_cs,
            data_transaksi_penjualan_jasa_layanan.id_kasir,
            data_transaksi_penjualan_jasa_layanan.total_harga,
            data_transaksi_penjualan_jasa_layanan.created_date,
            data_transaksi_penjualan_jasa_layanan.updated_date,
            data_hewan.nama_hewan,
            data_pegawai.nama_pegawai AS nama_cs, 
            a.nama_pegawai AS nama_kasir ');
            $this->db->join('data_hewan', 'data_hewan.id_hewan = data_transaksi_penjualan_jasa_layanan.id_hewan');
            $this->db->join('data_pegawai', 'data_pegawai.id_pegawai = data_transaksi_penjualan_jasa_layanan.id_cs');
            $this->db->join('data_pegawai a', 'a.id_pegawai = data_transaksi_penjualan_jasa_layanan.id_kasir');
            $this->db->from('data_transaksi_penjualan_jasa_layanan');
            $query = $this->db->get();
            $arrTemp = $query->result_array();

            return $arrTemp;

            # code...
        } else {
            $this->db->where('id_transaksi_penjualan_jasa_layanan', $id);

            return $this->db->get('data_transaksi_penjualan_jasa_layanan')->result_array();
        }
    }

    public function deletePenjualanLayanan($id, $kode)
    {
        $this->db->delete('data_detail_penjualan_jasa_layanan', ['kode_transaksi_penjualan_jasa_layanan_fk' => $kode['kode_transaksi_penjualan_jasa_layanan']]);
        $this->db->delete('data_transaksi_penjualan_jasa_layanan', ['id_transaksi_penjualan_jasa_layanan' => $id]);
        $rowdelete = $this->db->affected_rows();
        return $rowdelete;

    }
    
    public function createPenjualan($data)
    {
        //MASUKAN DATA NYA BOS
        $this->db->insert('data_transaksi_penjualan_jasa_layanan', $data);

        return $this->db->affected_rows();
    }

    public function updatePenjualanLayanan($request, $id)
    {
        $updateData =
            [
            'tanggal_penjualan_jasa_layanan' => $request->tanggal_penjualan_jasa_layanan,
            'status_penjualan' => $request->status_penjualan,
            'status_layanan' => $request->status_layanan,
            'id_hewan'=> $request->id_hewan,
            'updated_date' => $request->updated_date,
        ];

        if ($this->db->where('id_transaksi_penjualan_jasa_layanan', $id)->update('data_transaksi_penjualan_jasa_layanan', $updateData)) {
            return ['msg' => 'Berhasil Update Penjualan Jasa Layanan', 'error' => false];
        }

        return ['msg' => 'Gagal Update Penjualan Jasa Layanan', 'error' => true];
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
        $query = "SHOW TABLE STATUS LIKE 'data_transaksi_penjualan_jasa_layanan'";
        $result = $this->db->query($query)->result();
        $hari = date('d');
        $bln = date('m');
        $thn = date('y');
        if ($result[0]->Auto_increment > 9) {
            return ("LY-" . $hari . $bln . $thn . "-" . $result[0]->Auto_increment);
        } else {
            return ("LY-" . $hari . $bln . $thn . "-0" . $result[0]->Auto_increment);
        }
    }

}