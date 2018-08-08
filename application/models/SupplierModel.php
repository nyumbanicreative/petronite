<?php

Class SupplierModel extends CI_Model {

    public function __construct() {
        
    }

    public function getSuppliers($cond = null, $cols = null, $limit = null) {

        if (null !== $cond) {
            $this->db->where($cond);
        }

        if (null !== $cols) {
            $this->db->select($cols);
        } else {
            $this->db->select('*');
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }

        $res = $this->db->from('suppliers sup')->get();

        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return;
        } else {
            return $res->result_array();
        }
    }

    public function saveSupplierDetails($data) {

        $this->db->trans_start();
        
        $this->db->insert('suppliers',$data['supplier_data']);
        
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}
