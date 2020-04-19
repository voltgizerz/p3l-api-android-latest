<?php

class Customer_model extends CI_Model
{

    public function getCustomer($id)
    {
        if ($id === null) {

            return $this->db->get('data_customer')->result_array();
            # code...
        } else {

            $this->db->where('id_customer', $id);
            return $this->db->get('data_customer')->result_array();
        }
    }

    public function deleteCustomer($id)
    {
        $this->db->db_debug = false;
        //TAMPUNG SEMENTARA DATA YANG KEMUNGKINAN BISA DIHAPUS
        $this->db->select('*');
        $this->db->from('data_customer');
        $this->db->where('id_customer', $id);
        $query = $this->db->get();
        $arrTampData = $query->result_array();

        if ($this->db->delete('data_customer', ['id_customer' => $id]) == false) {
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
                'id_customer' => $arrTampData[0]['id_customer'],
                'nama_customer' => $arrTampData[0]['nama_customer'],
                'alamat_customer' => $arrTampData[0]['alamat_customer'],
                'tanggal_lahir_customer' => $arrTampData[0]['tanggal_lahir_customer'],
                'nomor_hp_customer' => $arrTampData[0]['nomor_hp_customer'],
                'created_date' => $arrTampData[0]['created_date'],
                'updated_date' => $arrTampData[0]['updated_date'],
                'deleted_date' => $arrTampData[0]['deleted_date'],
            ];
            // RETURN DATA
            $this->db->insert('data_customer', $data);
            date_default_timezone_set("Asia/Bangkok");
            // INSERT DELETE AT DAN UPDATE DATA
            $updateData =
                ['created_date' => date("0000:00:0:00:00"),
                'deleted_date' => date("Y-m-d H:i:s"),
            ];

            $this->db->where('id_customer', $id);
            $this->db->update('data_customer', $updateData);
            $rowAffected = $this->db->affected_rows();

            $e = $this->db->error();

            if ($e['code'] == 1451) {
                return -1;
            } else {
                return $rowAffected;
            }
        }
    }
    
    public function createCustomer($data)
    {
        $this->db->insert('data_customer', $data);
        return $this->db->affected_rows();
    }

    public function updateCustomer($request, $id)
    {
        $updateData =
            ['nama_customer' => $request->nama_customer,
            'alamat_customer' => $request->alamat_customer,
            'tanggal_lahir_customer' => $request->tanggal_lahir_customer,
            'nomor_hp_customer' => $request->nomor_hp_customer,
            'updated_date' => $request->updated_date,
            'deleted_date' => $request->deleted_date,
        ];

        if ($this->db->where('id_customer', $id)->update('data_customer', $updateData)) {
            return ['msg' => 'SUSKSES UPDATE CUSTOMER!', 'id_customer' => $id, 'error' => false];
        }
        return ['msg' => 'GAGAL, UPDATE CUSTOMER ID TIDAK DITEMUKAN !', 'error' => true];
    }

    public function getCustomerID($id)
    {
        $this->id = $id;
        $query = "SELECT * FROM data_customer WHERE id_customer = ?";
        $result = $this->db->query($query, $this->id);
        if ($result->num_rows() != 0) {
            return ['msg' => $result->result(), 'error' => false];
        } else {
            return ['msg' => 'GAGAL, CARI CUSTOMER ID TIDAK DITEMUKAN !', 'error' => true];
        }
    }

    public function restoreCustomer($request, $id){
        $updateData =
            [
            'created_date' => $request->created_date,
            'deleted_date' => $request->deleted_date,
        ];

        if ($this->db->where('id_customer', $id)->update('data_customer', $updateData)) {
            return ['msg' => 'SUKSES RESTORE CUSTOMER!', 'id_customer' => $id, 'error' => false];
        }
        return ['msg' => 'GAGAL, RESTORE CUSTOMER ID TIDAK DITEMUKAN !', 'error' => true];
        
    }
}