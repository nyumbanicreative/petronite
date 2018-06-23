<?php

Class PurchaseModel extends CI_Model {

    var $admin_id = null;
    //Purchase Order 
    var $tbl_purchase_order = 'purchase_order po';
    var $cols_select_purchase_order = ['poq.order_qty', 'd.user_fullname po_driver_name', 'd.user_driving_license po_driver_license', 'ri.ri_status', 'po.po_id', 'po.po_date', 'po.po_number', 'po.po_truck_number', 'st.station_name'];
    var $cols_search_purchase_order = ['po.po_id', 'po.po_number', 'po.po_date', 'po.po_driver_name', 'po.po_driver_license', 'st.station_name'];
    var $cols_order_purchase_order = ['po.po_id', 'po.po_volume'];
    var $col_order_by_purchase_order = ['po.po_number' => 'DESC'];
    // Release Instructions 
    var $tbl_release_instruction = 'release_instructions ri';
    var $cols_select_release_instruction = ['auth.user_name authorizer', 'ri.ri_id', 'ri.ri_number', 'ri.ri_loading_date', 'ri.ri_status', 'ri.ri_number', 'ri.ri_depo_id', 'depo.depo_name'];
    var $cols_search_release_instruction = ['ri.ri_number'];
    var $cols_order_release_instruction = ['ri.ri_loading_date'];
    var $col_order_by_release_instruction = ['ri.ri_number' => 'DESC'];

    public function __construct() {
        if (isset($this->session->userdata['logged_in']['user_admin_id'])) {
            $this->admin_id = $this->session->userdata['logged_in']['user_admin_id'];
        }
    }

    public function getPurchases($cond = null, $limit = null) {

        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }

        $res = $this->db
                ->from('inventory_purchases pur')
                ->join('shifts s', 'pur.inventory_purchase_shift_id = s.shift_id', 'LEFT OUTER')
                ->join('users u', 'pur.inventory_purchase_user_id = u.user_id', 'INNER')
                ->join('fuel_tanks t', 't.fuel_tank_id = pur.inventory_purchase_tank_id', 'INNER')
                ->join('fuel_types f', 'f.fuel_type_id = t.fuel_tank_fuel_type_id', 'INNER')
                ->order_by('s.shift_sequence')
                ->get();


        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }

    public function getLatestPurchaseDate($station_id) {
        $res = $this->db
                ->where('inventory_purchase_station_id', $station_id)
                ->order_by('inventory_purchase_date', 'DESC')
                ->limit(1)
                ->get('inventory_purchases');
        if ($res->num_rows() == 1) {
            return $res->row_array();
        } else {
            return FALSE;
        }
    }

    public function getAllPurchaseDates($station_id) {
        $dates = [];
        $res = $this->db->select('inventory_purchase_date')
                ->where('inventory_purchase_station_id', $station_id)
                ->group_by('inventory_purchase_date')
                ->get('inventory_purchases');
        $res = $res->result_array();
        foreach ($res as $d) {
            $dates[] = date('m/d/Y', strtotime($d['inventory_purchase_date']));
        }
        return $dates;
    }

    public function getPurchaseOrders($cond = null, $limit = null, $cols = null, $where_in = null) {

        if (null !== $where_in) {
            $this->db->where_in($where_in);
        }

        if ($cond !== null) {
            $this->db->where($cond);
        }

        if (null !== $limit) {
            $this->db->limit(1);
        }

        if ($cols !== null) {
            $this->db->select($cols);
        } else {
            $this->db->select('*,d.user_fullname po_driver_name,d.user_driving_license po_driver_license');
        }

        $res = $this->db
                ->from('purchase_order po')
                ->join('users u', 'u.user_id = po.po_user_id', 'INNER')
                ->join('depots depo', 'depo.depo_id = po.po_depo_id', 'INNER')
                ->join("(SELECT poq.poq_po_id,"
                        . "GROUP_CONCAT(CONCAT('{\"poq_ftg_id\":\"',poq.poq_ftg_id,'\",\"poq_volume\" :\"',poq.poq_volume,'\",\"poq_po_id\" :\"',poq.poq_po_id,'\",\"poq_status\" :\"',poq.poq_status,'\",\"poq_po_id\" :\"',poq.poq_po_id,'\",\"station_name\" :\"',s.station_name,'\",\"product\" :\"',ftg.fuel_type_group_name,'\"}')) order_qty FROM " . $this->db->dbprefix . "purchase_order_qty poq, " . $this->db->dbprefix . "stations s," . $this->db->dbprefix . "fuel_types_group ftg WHERE poq.poq_station_id = s.station_id AND poq.poq_ftg_id = ftg.fuel_type_group_id  GROUP BY poq.poq_po_id) poq", "poq.poq_po_id = po.po_id", 'INNER')
//                ->join('fuel_types_group ftg', 'ftg.fuel_type_group_id = po.po_fuel_type_group_id', 'INNER')
//                ->join('vessels v', 'v.vessel_id = po.po_vessel_id', 'INNER')
                ->join('stations st', 'st.station_id = po.po_station_id', 'INNER')
                ->join('petronite_customers c', 'c.pc_admin_id = st.station_admin_id')
                ->join('petronite_customers s', 's.pc_admin_id = depo.depo_admin_id')
                ->join('users d', 'd.user_id = po.po_driver_id', 'INNER')
                ->join('release_instructions ri', 'ri.ri_id = po.po_ri_id', 'LEFT OUTER')
                ->order_by('po.po_timestamp', 'DESC')
                ->get();

        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
    }
    
    
    public function getPoForVessel($cond = null, $limit = null) {
        
        if($cond !== NULL){
            $this->db->where($cond);
        }
        
        $this->db->select('*,d.user_fullname po_driver_name, d.user_driving_license driving_licence');
        $res = $this->db->from('purchase_order_qty poq')
                ->join('vessels vs','vs.vessel_id = poq.poq_vessel_id','INNER')
                ->join('purchase_order po','po.po_id = poq.poq_po_id','INNER')
                ->join('users d', 'd.user_id = po.po_driver_id', 'INNER')
                ->get();
        
        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
    }

    public function generatePurchaseOrderNumber($admin_id) {
        $res = $this->db->select('po.po_id')
                        ->from('purchase_order po')
                        ->join('stations st', 'st.station_id = po.po_station_id', 'INNER')
                        ->where(['st.station_admin_id' => $admin_id])->get();

        $po = 1 + (int) $res->num_rows();

        log_message(SYSTEM_LOG, 'PurchaseModel/generatePurchaseOrderNumber ' . $this->session->userdata['logged_in']['user_name'] . ' - generated a pourchase order number: ' . $po);
        return $po;
    }

    public function saveEditPurchaseOrder($data, $po_id) {


        $this->db->where('po_id', $po_id)->update('purchase_order', $data['order_data']);

        if ($this->db->affected_rows()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function savePurchaseOrder($data, $admin_id) {

        $po_id = NULL;

        $this->db->trans_start();

        $this->db->trans_strict(TRUE);

        $this->db->insert('purchase_order', $data['order_data']);

        $po_id = $this->db->insert_id();

        foreach ($data['po_qty_data'] as $key => $pqd) {
            $data['po_qty_data'][$key]['poq_po_id'] = $po_id;
            $data['po_qty_data'][$key]['poq_status'] = 'UNRELEASED';
            foreach ($data['vessels'] as $v) {
                if ($v['fuel_type_group_id'] == $data['po_qty_data'][$key]['poq_ftg_id']) {
                    $data['po_qty_data'][$key]['poq_vessel_id'] = $v['vessel_id'];
                }
            }
        }
        $this->db->insert_batch('purchase_order_qty', $data['po_qty_data']);

        $po_number = $this->generatePurchaseOrderNumber($admin_id);

        $this->db->where('po_id', $po_id)->update('purchase_order', ['po_number' => cus_preciding_zeros($po_number)]);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function saveReleaseInstruction($data) {

        $ri_number = null;
        $ri_id = NULL;

        $this->db->trans_start();

        $ri_number = $this->generateReleaseInstruction();

        $this->db->insert('release_instructions', $data['ri_data']);

        $ri_id = $this->db->insert_id();

        $this->db->where('ri_id', $ri_id)->update('release_instructions', ['ri_number' => cus_preciding_zeros($ri_number)]);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function updatePurchaseOrder($data, $cond = null, $where_in = null) {

        if ($cond == NULL AND $where_in == NULL) {
            return FALSE;
        }

        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($where_in !== NULL) {
            $this->db->where_in($where_in);
        }
        $this->db->update('purchase_order', $data);

        return $this->db->affected_rows();
    }

    //AJAX RETRIEVING PURCHASE ORDERS

    private function _get_datatables_query_purchase_orders($type = "", $station_ids = []) {

        $this->db->select($this->cols_select_purchase_order);
        $this->db->from($this->tbl_purchase_order)
                ->join('users u', 'u.user_id = po.po_user_id', 'INNER')
                ->join('users d', 'd.user_id = po.po_driver_id', 'INNER')
                ->join('depots depo', 'depo.depo_id = po.po_depo_id', 'INNER')
                ->join("(SELECT poq.poq_po_id,"
                        . "GROUP_CONCAT(CONCAT('{\"poq_ftg_id\":\"',poq.poq_ftg_id,'\",\"poq_volume\" :\"',poq.poq_volume,'\",\"poq_po_id\" :\"',poq.poq_po_id,'\",\"poq_status\" :\"',poq.poq_status,'\",\"poq_po_id\" :\"',poq.poq_po_id,'\",\"station_name\" :\"',s.station_name,'\",\"product\" :\"',ftg.fuel_type_group_name,'\"}')) order_qty FROM " . $this->db->dbprefix . "purchase_order_qty poq, " . $this->db->dbprefix . "stations s," . $this->db->dbprefix . "fuel_types_group ftg WHERE poq.poq_station_id = s.station_id AND poq.poq_ftg_id = ftg.fuel_type_group_id  GROUP BY poq.poq_po_id) poq", "poq.poq_po_id = po.po_id", 'INNER')
//                ->join('fuel_types_group ftg', 'ftg.fuel_type_group_id = po.po_fuel_type_group_id', 'INNER')
//                ->join('vessels v', 'v.vessel_id = po.po_vessel_id', 'INNER')
                ->join('stations st', 'st.station_id = po.po_station_id', 'INNER')
                ->join('petronite_customers c', 'c.pc_admin_id = st.station_admin_id')
                ->join('petronite_customers s', 's.pc_admin_id = depo.depo_admin_id')
                ->join('release_instructions ri', 'ri.ri_id = po.po_ri_id', 'LEFT OUTER');

        if (!empty($station_ids)) {
            $this->db->where_in('st.station_id', $station_ids);
        }

        $this->db->where('po.po_status <> ', 'DELETED');


        $i = 0;
        foreach ($this->cols_search_purchase_order as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->cols_search_purchase_order) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->cols_order_purchase_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->col_order_by_purchase_order)) {
            $order = $this->col_order_by_purchase_order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_purchase_order($type = "", $station_ids = []) {

        $this->_get_datatables_query_purchase_orders($type, $station_ids);

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_purchase_order($type = "", $station_ids = []) {
        $this->_get_datatables_query_purchase_orders($type, $station_ids);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_purchase_order($type = "", $station_ids = []) {
        $this->db->select($this->cols_select_purchase_order);
        $this->db->from($this->tbl_purchase_order)
                ->join('stations st', 'st.station_id = po.po_station_id', 'INNER');
        $this->db->where('po.po_status <> ', 'DELETED');

        if (!empty($station_ids)) {
            $this->db->where_in('st.station_id', $station_ids);
        }

        return $this->db->count_all_results();
    }

    //AJAX RETRIEVING LPO FINISHES HERE
    //AJAX RETRIEVING RELEAS EINSTRUCTIONS

    private function _get_datatables_query_release_instruction() {

        $this->db->select($this->cols_select_release_instruction);
        $this->db->from($this->tbl_release_instruction)
                ->join('depots depo', 'depo.depo_id = ri.ri_depo_id', 'INNER')
                ->join('users u', 'u.user_id = ri.ri_user_id', 'INNER')
                ->join('users auth', 'auth.user_id = ri.ri_authorizer_id', 'INNER')
                ->where('ri.ri_admin_id', $this->admin_id);

        $i = 0;
        foreach ($this->cols_search_release_instruction as $item) { // loop column 
            if ($_POST['search']['value']) { // if datatable send POST for search
                if ($i === 0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->cols_search_release_instruction) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->cols_order_release_instruction[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->col_order_by_release_instruction)) {
            $order = $this->col_order_by_release_instruction;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_release_instructions() {

        $this->_get_datatables_query_release_instruction();

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_release_instructions() {
        $this->_get_datatables_query_release_instruction();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all_release_instructions() {
        $this->db->select($this->cols_select_release_instruction);
        $this->db->from($this->tbl_release_instruction)
                ->where('ri.ri_admin_id', $this->admin_id);

        return $this->db->count_all_results();
    }

    //AJAX FINISHES HERE


    private function generateReleaseInstruction() {
        $res = $this->db->where('ri_admin_id', $this->admin_id)->from('release_instructions');
        return 1 + (int) $this->db->count_all_results();
    }

    public function getReleaseInstructionInfo($ri_id, $cols = null) {

        if (null !== $cols) {
            $this->db->select($cols);
        } else {
            $this->db->select('*, auth.user_fullname auth_name');
        }
        $this->db->where('ri.ri_id', $ri_id);

        $res = $this->db->from('release_instructions ri')
                ->join('depots depo', 'depo.depo_id = ri.ri_depo_id', 'INNER')
                ->join('users u', 'u.user_id = ri.ri_user_id', 'INNER')
                ->join('users auth', 'auth.user_id = ri.ri_authorizer_id', 'INNER')
                ->join('petronite_customers seller', 'seller.pc_admin_id = depo.depo_admin_id', 'INNER')
                ->join('petronite_customers customer', 'customer.pc_admin_id = ri.ri_admin_id', 'INNER')
                ->limit(1)
                ->get();

        if ($res->num_rows() == 1) {
            return $res->row_array();
        } else {
            return FALSE;
        }
    }

    public function updatePo($data, $cond = null, $where_in_po_id = null) {

        if ($cond == null AND $where_in_po_id == NULL) {
            return false;
        }

        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if (null !== $where_in_po_id) {
            $this->db->where_in('po_id', $where_in_po_id);
        }

        $this->db->update('purchase_order', $data);
        return $this->db->affected_rows();
    }

    public function updateRi($data, $cond = null, $where_in_ri = null, $po_ids = null) {


        $this->db->trans_start();

        if ($cond == null AND $where_in_ri == NULL) {
            return false;
        }

        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if (null !== $where_in_ri) {
            $this->db->where_in('ri_id', $where_in_ri);
        }

        $this->db->update('release_instructions', $data);
        
        if($po_ids !== NULL){
            $this->db->where_in('poq_po_id',$po_ids)->update('purchase_order_qty',['poq_status' => 'RELEASED']);
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    public function updateVessel($data, $cond = null, $where_in_vessel = null) {

        if ($cond == null AND $where_in_vessel == NULL) {
            return false;
        }

        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if (null !== $where_in_vessel) {
            $this->db->where_in('vessel_id', $where_in_vessel);
        }

        $this->db->update('vessels', $data);
        return $this->db->affected_rows();
    }

    public function getRiVessels($ri_id) {
        $res = $this->db->from('vessels vs')
                        ->join('fuel_types_group ftg', 'ftg,fuel_type_group_id = vs.vessel_fuel_type_group_id', 'INNER')
                        ->join('(SELECT poq.poq_vessel_id FROM ' . $this->db->dbprefix . 'purchase_order po, ' . $this->db->dbprefix . 'purchase_order_qty poq WHERE po.po_id = poq.poq_po_id AND po.po_ri_id = \'' . $ri_id . '\' GROUP BY  poq.poq_vessel_id) AS po_vs', 'po_vs.poq_vessel_id = vs.vessel_id', 'INNER')->get();
        return $res->result_array();
    }

    public function getRiFuelTypes($ri_id) {
        $res = $this->db->select('ftg.fuel_type_group_id,ftg.fuel_type_group_name')
                ->from('release_instructions ri')
                ->join('purchase_order po', "po.po_ri_id = ri.ri_id AND po.po_ri_id = '" . $ri_id . "'", 'INNER')
                ->join('purchase_order_qty poq', "poq.poq_po_id = po.po_id", "INNER")
                ->join('fuel_types_group ftg', 'ftg,fuel_type_group_id = poq.poq_ftg_id', 'INNER')
                ->group_by('ftg.fuel_type_group_id,ftg.fuel_type_group_name')
                ->get();
        return $res->result_array();
    }

}
