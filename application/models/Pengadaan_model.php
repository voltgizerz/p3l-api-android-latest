<?php

class Pengadaan_model extends CI_Model
{

    public function getPengadaan($id)
    {
        if ($id === null) {

            $this->db->select('data_pengadaan.kode_pengadaan,data_pengadaan.id_supplier,data_supplier.nama_supplier,data_pengadaan.status as status_pengadaan,data_pengadaan.tanggal_pengadaan,data_pengadaan.total AS total_pengadaan');
            $this->db->join('data_supplier', 'data_supplier.id_supplier = data_pengadaan.id_supplier');
            $this->db->from('data_pengadaan');
            $query = $this->db->get();
            $arrTemp = $query->result_array();

            for ($i = 0; $i < count($arrTemp); $i++) {

                $this->db->select('data_detail_pengadaan.kode_pengadaan_fk,data_detail_pengadaan.id_produk_fk,data_detail_pengadaan.satuan_pengadaan,data_detail_pengadaan.jumlah_pengadaan');
                $this->db->join('data_pengadaan', 'data_pengadaan.kode_pengadaan = data_detail_pengadaan.kode_pengadaan_fk');
                $this->db->join('data_supplier', 'data_supplier.id_supplier = data_pengadaan.id_supplier');
                $this->db->from('data_detail_pengadaan');
                $this->db->where('data_detail_pengadaan.kode_pengadaan_fk', $arrTemp[$i]['kode_pengadaan']);
                $queryDetail = $this->db->get();
                $arrTempDetail = $queryDetail->result_array();

                $arrTemp[$i]['produk_dibeli'] = $arrTempDetail;
            }

            return $arrTemp;

            # code...
        } else {
            $this->db->where('kode_pengadaan', $id);

            return $this->db->get('data_pengadaan')->result_array();
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
            'tanggal_pengadaan' => date("Y-m-d H:i:s"),
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

    public function ambilKode()
    {
        date_default_timezone_set("Asia/Bangkok");
        $query = "SHOW TABLE STATUS LIKE 'data_pengadaan'";
        $result = $this->db->query($query)->result();
        $hari = date('d');
        $bln = date('m');
        $thn = date('Y');
        if ($result[0]->Auto_increment > 9) {
            return ("PO-" . $thn . "-" . $bln . "-" . $hari . "-" . $result[0]->Auto_increment);
        } else {
            return ("PO-" . $thn . "-" . $bln . "-" . $hari . "-0" . $result[0]->Auto_increment);
        }
    }

    public function totalBayarPengadaan($kode)
    {
        $this->db->select('data_detail_pengadaan.id_produk_fk,data_detail_pengadaan.jumlah_pengadaan,data_produk.harga_produk');
        $this->db->join('data_produk', 'data_produk.id_produk = data_detail_pengadaan.id_produk_fk');
        $this->db->where('data_detail_pengadaan.kode_pengadaan_fk', 'PO-2020-02-02-01');
        $this->db->from('data_detail_pengadaan');
        $query = $this->db->get();
        $arrTemp = json_decode(json_encode($query->result()), true);
        $temp = 0;
        for ($i = 0; $i < count($arrTemp); $i++) {
            $temp = $temp + $arrTemp[$i]['jumlah_pengadaan'] * $arrTemp[$i]['harga_produk'];
        }
        return $temp;
    }
}