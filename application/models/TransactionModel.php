<?php

Class TransactionModel extends CI_Model {

    var $credit_sales_txn_search_columns = ['crdt.credit_type_name', 'ctxn.txn_reference_no'];
    var $credit_sales_txn_order_columns = ['crdt.credit_type_name', null, 'ctxn.txn_timestamp'];
    var $credit_sales_txn_default_order_columns = ['ctxn.txn_timestamp' => 'DESC'];

    public function __construct() {
        
    }

    // AJAX CALLS
    //AJAX RETRIEVING OUTGOING SMSs

    private function _get_datatables_credit_sales_txn($data) {

        $this->db->select('*');


        $this->db->where('ctxn.txn_type', 'CREDIT_PAYMENT')->where('ctxn.txn_admin_id', $data['admin_id']);
        $this->db->from('transactions ctxn')
                ->join('credit_types crdt', 'crdt.credit_type_id = ctxn.txn_acc_ref', 'INNER');


        $i = 0;
        foreach ($this->credit_sales_txn_search_columns as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->credit_sales_txn_search_columns) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->credit_sales_txn_order_columns[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->credit_sales_txn_default_order_columns)) {
            $order = $this->credit_sales_txn_default_order_columns;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_credit_sales_txn($data) {

        $this->_get_datatables_credit_sales_txn($data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_credit_sales_txn($data) {
        $this->_get_datatables_credit_sales_txn($data);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_credit_sales_txn($data) {
        $this->db->select('credit_type_id');
        $this->db->from('transactions ')->where('txn_admin_id', $data['admin_id']);
        return $this->db->count_all_results();
    }

    // AJAX FINISHES

    public function getTransactions($cols = null, $cond = null, $limit = null, $where_in = null) {
        if ($cols !== NULL) {
            $this->db->select($cols);
        }

        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit !== NULL) {
            $this->db->limit($limit);
        }

        if($where_in != NULL){
            foreach ($where_in as $key => $wn){
                $this->db->where_in($key,$wn);
            }
        }
        $res = $this->db->order_by('txn.txn_timestamp','ACS')->get('transactions txn');

        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }

}
