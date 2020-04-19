<?php

class Jenis_Hewan_model extends CI_Model
{

    public function getJenisHewan($id)
    {
        if ($id === null) {

            return $this->db->get('data_jenis_hewan')->result_array();
            # code...
        } else {

            $this->db->where('id_jenis_hewan', $id);
            return $this->db->get('data_jenis_hewan')->result_array();
        }
    }

    public function deleteJenisHewan($id)
    {
        $this->db->db_debug = false;
        //TAMPUNG SEMENTARA DATA YANG KEMUNGKINAN BISA DIHAPUS
        $this->db->select('*');
        $this->db->from('data_jenis_hewan');
        $this->db->where('id_jenis_hewan', $id);
        $query = $this->db->get();
        $arrTampData = $query->result_array();

        if ($this->db->delete('data_jenis_hewan', ['id_jenis_hewan' => $id]) == false) {
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
                'id_jenis_hewan' => $arrTampData[0]['id_jenis_hewan'],
                'nama_jenis_hewan' => $arrTampData[0]['nama_jenis_hewan'],
                'created_date' => $arrTampData[0]['created_date'],
                'updated_date' => $arrTampData[0]['updated_date'],
                'deleted_date' => $arrTampData[0]['deleted_date'],
            ];
            // RETURN DATA
            $this->db->insert('data_jenis_hewan', $data);
            date_default_timezone_set("Asia/Bangkok");
            // INSERT DELETE AT DAN UPDATE DATA
            $updateData =
                ['created_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("Y-m-d H:i:s"),
            ];

            $this->db->where('id_jenis_hewan', $id);
            $this->db->update('data_jenis_hewan', $updateData);
            $rowAffected = $this->db->affected_rows();

            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        }
    }
    public function createJenisHewan($data)
    {
        $this->db->insert('data_jenis_hewan', $data);
        return $this->db->affected_rows();
    }

    public function updateJenisHewan($request, $id)
    {
        $updateData =
            ['nama_jenis_hewan' => $request->nama_jenis_hewan,
            'updated_date' => $request->updated_date,
            'deleted_date' => $request->deleted_date,
        ];
        $cekID = $this->db->query("SELECT nama_jenis_hewan FROM data_jenis_hewan WHERE nama_jenis_hewan ='$request->nama_jenis_hewan' && id_jenis_hewan != '$id'");
      
        if($cekID->num_rows() >= 1){
            //JENIS HEWAN SUDAH TERDAFTAR
                return ['msg' => 'Gagal, Jenis Hewan sudah Terdaftar!', 'error' => true];
        }else{
            //JENIS HEWAN BELUM TERDAFTAR
            if ($this->db->where('id_jenis_hewan', $id)->update('data_jenis_hewan', $updateData)) {
                return ['msg' => 'Berhasil Update Jenis Hewan', 'error' => false];
            }
        }
        return ['msg' => 'Gagal Update Jenis Hewan', 'error' => true];
    }

    public function getJenisHewanID($id)
    {
        $this->id = $id;
        $query = "SELECT * FROM data_jenis_hewan WHERE id_jenis_hewan = ?";
        $result = $this->db->query($query, $this->id);
        if ($result->num_rows() != 0) {
            return ['msg' => $result->result(), 'error' => false];
        } else {
            return ['msg' => 'Data Jenis Hewan Tidak Ditemukan', 'error' => true];
        }
    }

    public function restoreJenis($request, $id)
    {
        $updateData =
            [
            'created_date' => $request->created_date,
            'deleted_date' => $request->deleted_date,
        ];

        if ($this->db->where('id_jenis_hewan', $id)->update('data_jenis_hewan', $updateData)) {
            return ['msg' => 'SUKSES RESTORE JENIS HEWAN!', 'id_jenis_hewan' => $id, 'error' => false];
        }
        return ['msg' => 'GAGAL, RESTORE JENIS HEWAN ID TIDAK DITEMUKAN !', 'error' => true];

    }
}