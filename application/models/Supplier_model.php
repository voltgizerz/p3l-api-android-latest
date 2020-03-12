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
        $this->db->delete('data_supplier', ['id_supplier' => $id]);
        return $this->db->affected_rows();
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

        if ($this->db->where('id_supplier', $id)->update('data_supplier', $updateData)) {
            return ['msg' => 'Berhasil Update Supplier', 'error' => false];
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
}
