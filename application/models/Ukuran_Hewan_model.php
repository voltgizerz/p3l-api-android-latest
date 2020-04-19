<?php

class Ukuran_Hewan_model extends CI_Model
{

    public function getUkuranHewan($id_ukuran_hewan)
    {
        if ($id_ukuran_hewan === null) {

            return $this->db->get('data_ukuran_hewan')->result_array();
            # code...
        } else {

            $this->db->where('id_ukuran_hewan', $id_ukuran_hewan);
            return $this->db->get('data_hewan')->result_array();
        }
    }

    public function deleteUkuranHewan($id)
    {
        $this->db->db_debug = false;
        //TAMPUNG SEMENTARA DATA YANG KEMUNGKINAN BISA DIHAPUS
        $this->db->select('*');
        $this->db->from('data_ukuran_hewan');
        $this->db->where('id_ukuran_hewan', $id);
        $query = $this->db->get();
        $arrTampData = $query->result_array();

        if ($this->db->delete('data_ukuran_hewan', ['id_ukuran_hewan' => $id]) == false) {
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
                'id_ukuran_hewan' => $arrTampData[0]['id_ukuran_hewan'],
                'ukuran_hewan' => $arrTampData[0]['ukuran_hewan'],
                'created_date' => $arrTampData[0]['created_date'],
                'updated_date' => $arrTampData[0]['updated_date'],
                'deleted_date' => $arrTampData[0]['deleted_date'],
            ];
            // RETURN DATA
            $this->db->insert('data_ukuran_hewan', $data);
            date_default_timezone_set("Asia/Bangkok");
            // INSERT DELETE AT DAN UPDATE DATA
            $updateData =
                ['created_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("Y-m-d H:i:s"),
            ];

            $this->db->where('id_ukuran_hewan', $id);
            $this->db->update('data_ukuran_hewan', $updateData);
            $rowAffected = $this->db->affected_rows();

            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        }
    }
    
    public function createUkuranHewan($data)
    {
        $this->db->insert('data_ukuran_hewan', $data);
        return $this->db->affected_rows();
    }

    public function updateUkuranHewan($request, $id)
    {
        $updateData =
            ['ukuran_hewan' => $request->ukuran_hewan,
            'updated_date' => $request->updated_date,
            'deleted_date' => $request->deleted_date,
        ];

        $cekID = $this->db->query("SELECT ukuran_hewan FROM data_ukuran_hewan WHERE ukuran_hewan ='$request->ukuran_hewan' && id_ukuran_hewan != '$id'");

        if ($cekID->num_rows() >= 1) {
            //ukuran SUDAH TERDAFTAR
            return ['msg' => 'Gagal, Ukuran Hewan sudah Terdaftar!', 'error' => true];
        } else {
            //ukuranBELUM TERDAFTAR
            if ($this->db->where('id_ukuran_hewan', $id)->update('data_ukuran_hewan', $updateData)) {
                return ['msg' => 'Berhasil Update Ukuran Hewan', 'error' => false];
            }
        }
        return ['msg' => 'GAGAL, UPDATE HEWAN ID TIDAK DITEMUKAN !', 'error' => true];
    }

    public function getUkuranHewanID($id_ukuran_hewan)
    {
        $this->id_ukuran_hewan = $id_ukuran_hewan;
        $query = "SELECT * FROM data_ukuran_hewan WHERE id_ukuran_hewan = ?";
        $result = $this->db->query($query, $this->id_ukuran_hewan);
        if ($result->num_rows() != 0) {
            return ['msg' => $result->result(), 'error' => false];
        } else {
            return ['msg' => 'GAGAL, CARI UKURAN HEWAN ID TIDAK DITEMUKAN !', 'error' => true];
        }
    }

    public function restoreUkuran($request, $id)
    {
        $updateData =
            [
            'created_date' => $request->created_date,
            'deleted_date' => $request->deleted_date,
        ];

        if ($this->db->where('id_ukuran_hewan', $id)->update('data_ukuran_hewan', $updateData)) {
            return ['msg' => 'SUKSES RESTORE UKURAN HEWAN!', 'id_ukuran_hewan' => $id, 'error' => false];
        }
        return ['msg' => 'GAGAL, RESTORE UKURAN HEWAN ID TIDAK DITEMUKAN !', 'error' => true];

    }
}