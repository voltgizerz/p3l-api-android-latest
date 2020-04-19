<?php

class Supplier_model extends CI_Model
{

    public function getSupplier($id)
    {
        if ($id === null) {

            return $this->db->get('data_supplier')->result_array();
            # code...
        } else {

            $this->db->where('id_supplier', $id);
            return $this->db->get('data_supplier')->result_array();
        }
    }

    public function deleteSupplier($id)
    {
        $this->db->db_debug = false;
        //TAMPUNG SEMENTARA DATA YANG KEMUNGKINAN BISA DIHAPUS
        $this->db->select('*');
        $this->db->from('data_supplier');
        $this->db->where('id_supplier', $id);
        $query = $this->db->get();
        $arrTampData = $query->result_array();

        if ($this->db->delete('data_supplier', ['id_supplier' => $id]) == false) {
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
                'id_supplier' => $arrTampData[0]['id_supplier'],
                'nama_supplier' => $arrTampData[0]['nama_supplier'],
                'alamat_supplier' => $arrTampData[0]['alamat_supplier'],
                'nomor_telepon_supplier' => $arrTampData[0]['nomor_telepon_supplier'],
                'created_date' => $arrTampData[0]['created_date'],
                'updated_date' => $arrTampData[0]['updated_date'],
                'deleted_date' => $arrTampData[0]['deleted_date'],
            ];
            // RETURN DATA
            $this->db->insert('data_supplier', $data);
            date_default_timezone_set("Asia/Bangkok");
            // INSERT DELETE AT DAN UPDATE DATA
            $updateData =
                ['created_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("Y-m-d H:i:s"),
            ];

            $this->db->where('id_supplier', $id);
            $this->db->update('data_supplier', $updateData);
            $rowAffected = $this->db->affected_rows();

            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        }
    }
    public function createSupplier($data)
    {
        $this->db->insert('data_supplier', $data);
        return $this->db->affected_rows();
    }

    public function updateSupplier($request, $id)
    {
        $updateData =
            ['nama_supplier' => $request->nama_supplier,
            'alamat_supplier' => $request->alamat_supplier,
            'nomor_telepon_supplier' => $request->nomor_telepon_supplier,
            'updated_date' => $request->updated_date,
            'deleted_date' => $request->deleted_date,
        ];

        $cekID = $this->db->query("SELECT nama_supplier FROM data_supplier WHERE nama_supplier ='$request->nama_supplier' && id_supplier != '$id'");

        if ($cekID->num_rows() >= 1) {
            //SUPPLIER SUDAH TERDAFTAR
            return ['msg' => 'Gagal, Supplier sudah Terdaftar!', 'error' => true];
        } else {

            if ($this->db->where('id_supplier', $id)->update('data_supplier', $updateData)) {
                return ['msg' => 'Berhasil Update Supplier', 'error' => false];
            }
        }
        return ['msg' => 'Gagal Update Supplier', 'error' => true];
    }

    public function getSupplierID($id)
    {
        $this->id = $id;
        $query = "SELECT * FROM data_supplier WHERE id_supplier = ?";
        $result = $this->db->query($query, $this->id);
        if ($result->num_rows() != 0) {
            return ['msg' => $result->result(), 'error' => false];
        } else {
            return ['msg' => 'Data Supplier Tidak Ditemukan', 'error' => true];
        }
    }

    public function restoreSupplier($request, $id)
    {
        $updateData =
            [
            'created_date' => $request->created_date,
            'deleted_date' => $request->deleted_date,
        ];

        if ($this->db->where('id_supplier', $id)->update('data_supplier', $updateData)) {
            return ['msg' => 'SUKSES RESTORE SUPPLIER!', 'id_supplier' => $id, 'error' => false];
        }
        return ['msg' => 'GAGAL, RESTORE SUPPLIER ID TIDAK DITEMUKAN !', 'error' => true];

    }
}