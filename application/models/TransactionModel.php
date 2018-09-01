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
                ->join('credit_types crdt', 'crdt.credit_type_id = ctxn.txn_acc_ref', 'INNER')
                ->join('stations stn', 'stn.station_id = ctxn.txn_station_id', 'LEFT OUTER');

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

        if ($where_in != NULL) {
            foreach ($where_in as $key => $wn) {
                $this->db->where_in($key, $wn);
            }
        }
        $res = $this->db->order_by('txn.txn_timestamp', 'ACS')
                ->from('transactions txn')
                ->join('customer_sales sales', "sales.customer_sale_id = txn.txn_ref AND txn.txn_type ='CREDIT_SALE'", "LEFT OUTER")
                ->join('credit_types crdt', 'crdt.credit_type_id = txn.txn_acc_ref', 'LEFT OUTER')
                ->join('attandance att', "att.att_id = sales.customer_sale_att_id ", "LEFT OUTER")
                ->join('pumps p', "p.pump_id = att.att_pump_id ", "LEFT OUTER")
                ->join('fuel_types f', "f.fuel_type_id = p.pump_fuel_type_id ", "LEFT OUTER")
                ->join('stations st', "st.station_id = att.att_station_id", "LEFT OUTER")
                ->get();

        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }

    public function saveShiftToLedger($data) {

        $this->db->trans_start();


        foreach ($data['credit_sales'] as $cs) {

            $res = $this->db->where('credit_type_id', $cs['customer_sale_credit_type_id'])->limit(1)->get('credit_types');

            if ($c = $res->row_array()) {
                
                $sale_price = $data['att']['att_sale_price_per_ltr'];
                $amount = $cs['customer_sale_ltrs'] * $sale_price;
                $balance_after = $c['credit_type_balance'] + ($amount);
                
                $notes = "Fuel Purchase. " . $cs['customer_sale_ltrs'] . ' ltr(s) of ' . $data['att']['fuel_type_generic_name'] . ' @' . cus_price_form($sale_price);

                $this->db->where('credit_type_id', $c['credit_type_id'])->update('credit_types', ['credit_type_balance' => $balance_after]);

                $transaction_data = [
                    'txn_credit' => 0,
                    'txn_debit' => $amount,
                    'txn_type' => 'CREDIT_SALE',
                    'txn_acc_ref' => $c['credit_type_id'],
                    'txn_ref' => $cs['customer_sale_id'],
                    'txn_user_id' => $data['user_id'],
                    'txn_balance_before' => $c['credit_type_balance'],
                    'txn_balance_after' => $balance_after,
                    'txn_admin_id' => $data['admin_id'],
                    'txn_notes' => $notes,
                    'txn_date' => $data['att']['att_date'],
                    'txn_station_id' => $data['att']['att_station_id']
                ];

                $this->db->insert('transactions', $transaction_data);
            }
        }
        
        $this->db->where('att_id',$data['att']['att_id'])->update('attandance',['att_posted_to_ledger' => 1]);
        
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
