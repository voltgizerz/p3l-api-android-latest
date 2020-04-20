<?php

class Jasa_Layanan_model extends CI_Model
{

    public function getJasaLayanan($id)
    {
        if ($id === null) {

            $this->db->select('data_jasa_layanan.id_jasa_layanan,data_jasa_layanan.nama_jasa_layanan,data_jasa_layanan.harga_jasa_layanan,data_jasa_layanan.id_jenis_hewan,data_jasa_layanan.id_ukuran_hewan,data_jasa_layanan.created_date,data_jasa_layanan.updated_date,data_jasa_layanan.deleted_date,data_ukuran_hewan.ukuran_hewan,data_jenis_hewan.nama_jenis_hewan');
            $this->db->join('data_ukuran_hewan', 'data_ukuran_hewan.id_ukuran_hewan = data_jasa_layanan.id_ukuran_hewan');
            $this->db->join('data_jenis_hewan', 'data_jenis_hewan.id_jenis_hewan = data_jasa_layanan.id_jenis_hewan');
            $this->db->from('data_jasa_layanan');
            $query = $this->db->get();

            return $query->result_array();
            # code...
        } else {

            $this->db->where('id_jasa_layanan', $id);
            return $this->db->get('data_jasa_layanan')->result_array();
        }
    }

    public function deleteJasaLayanan($id)
    {
        $this->db->db_debug = false;
        //TAMPUNG SEMENTARA DATA YANG KEMUNGKINAN BISA DIHAPUS
        $this->db->select('*');
        $this->db->from('data_jasa_layanan');
        $this->db->where('id_jasa_layanan', $id);
        $query = $this->db->get();
        $arrTampData = $query->result_array();

        if ($this->db->delete('data_jasa_layanan', ['id_jasa_layanan' => $id]) == false) {
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
                'id_jasa_layanan' => $arrTampData[0]['id_jasa_layanan'],
                'nama_jasa_layanan' => $arrTampData[0]['nama_jasa_layanan'],
                'harga_jasa_layanan' => $arrTampData[0]['harga_jasa_layanan'],
                'id_jenis_hewan' => $arrTampData[0]['id_jenis_hewan'],
                'id_ukuran_hewan' => $arrTampData[0]['id_ukuran_hewan'],
                'created_date' => $arrTampData[0]['created_date'],
                'updated_date' => $arrTampData[0]['updated_date'],
                'deleted_date' => $arrTampData[0]['deleted_date'],
            ];
            // RETURN DATA
            $this->db->insert('data_jasa_layanan', $data);
            date_default_timezone_set("Asia/Bangkok");
            // INSERT DELETE AT DAN UPDATE DATA
            $updateData =
                ['created_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("Y-m-d H:i:s"),
            ];

            $this->db->where('id_jasa_layanan', $id);
            $this->db->update('data_jasa_layanan', $updateData);
            $rowAffected = $this->db->affected_rows();

            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        }
    }
    public function createJasaLayanan($data)
    {
        $this->db->insert('data_jasa_layanan', $data);
        return $this->db->affected_rows();
    }

    public function updateJasaLayanan($request, $id)
    {
        $updateData =
            ['nama_jasa_layanan' => $request->nama_jasa_layanan,
            'harga_jasa_layanan' => $request->harga_jasa_layanan,
            'id_jenis_hewan' => $request->id_jenis_hewan,
            'id_ukuran_hewan' => $request->id_ukuran_hewan,
            'updated_date' => $request->updated_date,
            'deleted_date' => $request->deleted_date,
        ];

        $cekID = $this->db->query("SELECT nama_jasa_layanan FROM data_jasa_layanan WHERE nama_jasa_layanan ='$request->nama_jasa_layanan' && id_jasa_layanan != '$id'");

        if ($cekID->num_rows() >= 1) {
            //JENIS HEWAN SUDAH TERDAFTAR
            return ['msg' => 'Gagal, Jasa Layanan sudah Terdaftar!', 'error' => true];
        } else {
            if ($this->db->where('id_jasa_layanan', $id)->update('data_jasa_layanan', $updateData)) {
                return ['msg' => 'Berhasil Update Jasa Layanan', 'error' => false];
            }
        }
        return ['msg' => 'Gagal Update Jasa Layanan', 'error' => true];
    }

    public function getJasaLayananID($id)
    {
        $this->id = $id;
        $query = "SELECT * FROM data_jasa_layanan WHERE id_jasa_layanan = ?";
        $result = $this->db->query($query, $this->id);
        if ($result->num_rows() != 0) {
            return ['msg' => $result->result(), 'error' => false];
        } else {
            return ['msg' => 'Data Jasa Layanan Tidak Ditemukan', 'error' => true];
        }
    }

    public function restoreLayanan($request, $id)
    {
        $updateData =
            [
            'created_date' => $request->created_date,
            'deleted_date' => $request->deleted_date,
        ];

        if ($this->db->where('id_jasa_layanan', $id)->update('data_jasa_layanan', $updateData)) {
            return ['msg' => 'SUKSES RESTORE JASA LAYANAN!', 'id_jasa_layanan' => $id, 'error' => false];
        }
        return ['msg' => 'GAGAL, RESTORE JASA LAYANAN ID TIDAK DITEMUKAN !', 'error' => true];

    }

    public function deletePermanentJasaLayanan($id)
    {
        $this->db->db_debug = FALSE;
        $this->db->delete('data_jasa_layanan', ['id_jasa_layanan' => $id]);
        $rowAffected = $this->db->affected_rows();
        $e = $this->db->error();
        
        if ($e['code'] == 1451) {
            return -1;
        } else {
            return $rowAffected;
        }
    }
}