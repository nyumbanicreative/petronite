<?php

Class CustomerModel extends CI_Model {

    public function __construct() {
        
    }

    public function getPetroniteCustomers($cols = null, $cond = null, $limit = null, $where_in = null) {

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

        $res = $this->db->from('petronite_customers pc')
                ->join('users u', 'pc.pc_admin_id = u.user_id', 'LEFT OUTER')
                ->join('(SELECT station_admin_id, COUNT(station_admin_id) total_stations '
                        . 'FROM tbl_stations GROUP BY station_admin_id) ts', 'ts.station_admin_id = u.user_id', 'LEFT OUTER')
                ->order_by('pc.pc_name', 'ACS')
                ->get();


        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }

    public function getCustomerDetails($admin_id) {

        $res = $this->db->where('pc_admin_id', $admin_id)->limit(1)->get('petronite_customers');
        if ($res->num_rows() == 1) {
            return $res->row_array();
        } else {
            return FALSE;
        }
    }

    public function getStationCustomers($admin_id) {

        $res = $this->db
                ->from('credit_types ct')
                ->join("(SELECT "
                        . "c.credit_type_station_credit_type_id,  "
                        . "GROUP_CONCAT(DISTINCT s.station_name ORDER BY  s.station_name ASC SEPARATOR ', ') stations "
                        . "FROM " . $this->db->dbprefix . "credit_type_stations c, " . $this->db->dbprefix . "stations s "
                        . "WHERE c.credit_type_station_station_id = s.station_id "
                        . "GROUP BY credit_type_station_credit_type_id) cts", "cts.credit_type_station_credit_type_id = ct.credit_type_id", "LEFT OUTER")
                ->order_by('ct.credit_type_name')
                ->where('ct.credit_type_admin_id', $admin_id)
                ->get();

        return $res->result_array();
    }

    public function getCreditCustomers($cond = null, $cols = null, $limit = null) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }

        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit !== NULL) {
            $this->db->limit($limit);
        }

        $this->db->order_by('crdt.credit_type_name', 'ACS');

        $res = $this->db->from('credit_types crdt')
                        ->join('credit_type_stations crdts', 'crdts.credit_type_station_credit_type_id = crdt.credit_type_id', 'INNER')
                        ->join('stations s', 's.station_id = crdts.credit_type_station_station_id', 'INNER')->get();




        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }

    public function getStationSuppliers($admin_id) {
        
    }

    public function saveCreditPayment($data) {

        $this->db->trans_start();

        $this->db->insert('transactions', $data['txn_data']);

        $this->db->where('credit_type_id', $data['customer']['credit_type_id'])->update('credit_types', $data['credit_data']);

        if (isset($data['cancel_txn'])) {
            $this->db->where('txn_id', $data['cancel_txn']['txn_id'])->update('transactions', ['txn_status' => 'CANCELED']);
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function saveCreditSale($data) {

        $this->db->trans_start();

        $this->db->insert('customer_sales', $data['credit_data']);

        $cs_id = $this->db->insert_id();

        if ($data['new_credit_sale']) {
            
            $this->db->where('credit_type_id', $data['credit_data']['customer_sale_credit_type_id'])->update('credit_types', ['credit_type_balance' => $data['credit_data']['customer_sale_balance_after']]);

            $transaction_data = [
                'txn_credit' => 0,
                'txn_debit' => $data['amount'],
                'txn_type' => 'CREDIT_SALE',
                'txn_acc_ref' => $data['credit_data']['customer_sale_credit_type_id'],
                'txn_ref' => $cs_id,
                'txn_user_id' => $data['credit_data']['customer_sale_added_by'],
                'txn_balance_before' => $data['credit_data']['customer_sale_balance_before'],
                'txn_balance_after' => $data['credit_data']['customer_sale_balance_after'],
                'txn_admin_id' => $data['admin_id'],
                'txn_notes' => $data['notes']
            ];

            $this->db->insert('transactions', $transaction_data);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    
    public function saveEditCreditCustomer($data) {
        
        $this->db->trans_start();
        
        $this->db->where('credit_type_id',$data['customer_id'])->update('credit_types',$data['customer_data']);
        
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function savePetroniteCustomer($data) {


        $this->db->trans_start();

        $this->db->insert('users', $data['admin_data']);

        $admin_id = $this->db->insert_id();

        $data['customer_data']['pc_admin_id'] = $admin_id;

        $this->db->insert('petronite_customers', $data['customer_data']);

        $this->db->where('temp_file_name', $data['temp_file']['temp_file_name'])->delete('temp_files');

        $this->db->where('user_id', $admin_id)->update('users', ['user_admin_id', $admin_id]);

        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $admin_id;
        }
    }

    public function saveEditPetroniteCustomer($data) {


        $this->db->trans_start();

        $this->db->where('user_id', $data['admin_id'])->update('users', $data['admin_data']);

        $this->db->where('pc_id', $data['pc_id'])->update('petronite_customers', $data['customer_data']);

        $this->db->where('temp_file_name', $data['temp_file']['temp_file_name'])->delete('temp_files');

        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    // AJAX CALLS
    //AJAX RETRIEVING OUTGOING SMSs

    private function _get_datatables_station_customers($data) {

        $this->db->select('*');

        $this->db->from('credit_types ct')
                ->join("(SELECT "
                        . "c.credit_type_station_credit_type_id,  "
                        . "GROUP_CONCAT(DISTINCT s.station_name ORDER BY  s.station_name ASC SEPARATOR ', ') stations "
                        . "FROM " . $this->db->dbprefix . "credit_type_stations c, " . $this->db->dbprefix . "stations s "
                        . "WHERE c.credit_type_station_station_id = s.station_id "
                        . "GROUP BY credit_type_station_credit_type_id) cts", "cts.credit_type_station_credit_type_id = ct.credit_type_id", "LEFT OUTER")
                ->where('ct.credit_type_admin_id', $data['admin_id']);


        $i = 0;
        foreach ($data['search_columns'] as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($data['search_columns']) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($data['order_columns'][$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($data['default_order_columns'])) {
            $order = $data['default_order_columns'];
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_station_customers($data) {

        $this->_get_datatables_station_customers($data);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_station_customers($data) {
        $this->_get_datatables_station_customers($data);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_station_customers($data) {
        $this->db->select('credit_type_id');
        $this->db->from('credit_types')->where('credit_type_admin_id', $data['admin_id']);
        return $this->db->count_all_results();
    }

    // AJAX FINISHES
}
