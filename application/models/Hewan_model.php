<?php

class Hewan_model extends CI_Model
{

    public function getHewan($id_hewan)
    {
        if ($id_hewan === null) {

            $this->db->select('id_hewan, nama_hewan, data_hewan.id_jenis_hewan, data_hewan.id_ukuran_hewan, data_hewan.id_hewan, tanggal_lahir_hewan, data_hewan.created_date, data_hewan.updated_date, data_hewan.deleted_date,nama_hewan, ukuran_hewan,nama_jenis_hewan');
            $this->db->join('data_ukuran_hewan', 'data_ukuran_hewan.id_ukuran_hewan = data_hewan.id_ukuran_hewan');
            $this->db->join('data_jenis_hewan', 'data_jenis_hewan.id_jenis_hewan = data_hewan.id_jenis_hewan');
            $this->db->join('data_hewan', 'data_hewan.id_hewan = data_hewan.id_hewan');
            $this->db->from('data_hewan');
            $query = $this->db->get();

            return $query->result_array();
            # code...
        } else {

            $this->db->where('id_hewan', $id_hewan);
            return $this->db->get('data_hewan')->result_array();
        }
    }

    public function deleteHewan($id)
    {
        $this->db->db_debug = false;
        //TAMPUNG SEMENTARA DATA YANG KEMUNGKINAN BISA DIHAPUS
        $this->db->select('*');
        $this->db->from('data_hewan');
        $this->db->where('id_hewan', $id);
        $query = $this->db->get();
        $arrTampData = $query->result_array();

        if ($this->db->delete('data_hewan', ['id_hewan' => $id]) == false) {
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
                'id_hewan' => $arrTampData[0]['id_hewan'],
                'nama_hewan' => $arrTampData[0]['nama_hewan'],
                'id_jenis_hewan' => $arrTampData[0]['id_jenis_hewan'],
                'id_ukuran_hewan' => $arrTampData[0]['id_ukuran_hewan'],
                'id_customer' => $arrTampData[0]['id_customer'],
                'tanggal_lahir_hewan' => $arrTampData[0]['tanggal_lahir_hewan'],
                'created_date' => date("Y-m-d H:i:s"),
                'updated_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("0000:00:0:00:00"),
            ];
            // RETURN DATA
            $this->db->insert('data_hewan', $data);
            date_default_timezone_set("Asia/Bangkok");
            // INSERT DELETE AT DAN UPDATE DATA
            $updateData =
                ['created_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("Y-m-d H:i:s"),
            ];

            $this->db->where('id_hewan', $id);
            $this->db->update('data_hewan', $updateData);
            $rowAffected = $this->db->affected_rows();

            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        }
    }
    public function createHewan($data)
    {
        $this->db->insert('data_hewan', $data);
        return $this->db->affected_rows();
    }

    public function updateHewan($request, $id_hewan)
    {
        $updateData =
            ['nama_hewan' => $request->nama_hewan,
            'id_jenis_hewan' => $request->id_jenis_hewan,
            'id_ukuran_hewan' => $request->id_ukuran_hewan,
            'id_hewan' => $request->id_hewan,
            'tanggal_lahir_hewan' => $request->tanggal_lahir_hewan,
            'updated_date' => $request->updated_date,
            'deleted_date' => $request->deleted_date,
        ];

        if ($this->db->where('id_hewan', $id_hewan)->update('data_hewan', $updateData)) {
            return ['msg' => 'SUSKSES UPDATE HEWAN!', 'id_hewan' => $id_hewan, 'error' => false];
        }
        return ['msg' => 'GAGAL, UPDATE HEWAN ID TIDAK DITEMUKAN !', 'error' => true];
    }

    public function getHewanID($id_hewan)
    {
        $this->id_hewan = $id_hewan;
        $query = "SELECT * FROM data_hewan WHERE id_hewan = ?";
        $result = $this->db->query($query, $this->id_hewan);
        if ($result->num_rows() != 0) {
            return ['msg' => $result->result(), 'error' => false];
        } else {
            return ['msg' => 'GAGAL, CARI HEWAN ID TIDAK DITEMUKAN !', 'error' => true];
        }
    }

    public function restoreHewan($request, $id)
    {
        $updateData =
            [
            'created_date' => $request->created_date,
            'deleted_date' => $request->deleted_date,
        ];

        if ($this->db->where('id_hewan', $id)->update('data_hewan', $updateData)) {
            return ['msg' => 'SUKSES RESTORE HEWAN!', 'id_hewan' => $id, 'error' => false];
        }
        return ['msg' => 'GAGAL, RESTORE HEWAN ID TIDAK DITEMUKAN !', 'error' => true];

    }
}