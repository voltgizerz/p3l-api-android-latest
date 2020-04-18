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

    public function deleteUkuranHewan($id_ukuran_hewan)
    {
        $this->db->db_debug = false;
        $this->db->delete('data_ukuran_hewan', ['id_ukuran_hewan' => $id_ukuran_hewan]);
        $rowAffected = $this->db->affected_rows();
        $e = $this->db->error();

        if ($e['code'] == 1451) {
            return -1;
        } else {
            return $rowAffected;
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
      
        if($cekID->num_rows() >= 1){
            //ukuran SUDAH TERDAFTAR
                return ['msg' => 'Gagal, Ukuran Hewan sudah Terdaftar!', 'error' => true];
        }else{
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
}