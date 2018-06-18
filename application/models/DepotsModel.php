<?php

Class DepotsModel extends CI_Model {

    public function __construct() {
        
    }

    public function getUserDepots($user_id, $admin_id) {

        // $q ="SELECT s.*, o.* FROM tbl_stations s,tbl_organize o WHERE s.station_id = o.organize_station_id AND o.organize_user_id = :user_id";

        $res = $this->db->from('depots d, organize_depots o')
                ->where('d.depo_id = o.organize_depo_id')
                ->where('o.organize_user_id', $user_id)
                ->where('d.depo_admin_id', $admin_id)
                ->order_by('d.depo_name', 'ACS')
                ->get();

        return $res->result_array();
    }

    public function canAccessDepot($user_id, $depo_id) {
        $res = $this->db->where('o.organize_user_id', $user_id)
                ->where('o.organize_depo_id', $depo_id)
                ->where('o.organize_depo_id = d.depo_id')
                ->where('d.depo_id', $depo_id)
                ->limit(1)
                ->get('organize_depots o, depots d');

        if ($res->num_rows() == 1) {
            return $res->row_array();
        } else {
            return FALSE;
        }
    }

    public function getDepotDetails($depo_id) {

        $res = $this->db->where('s.depo_id', $depo_id)
                ->limit(1)
                ->get('depot d');

        if ($res->num_rows() == 1) {
            return $res->row_array();
        } else {
            return FALSE;
        }
    }

    public function getStockVessels($cond = null, $limit = null) {

        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }

        $res = $this->db
                ->from('vessels v')
                ->join('fuel_types_group ft', 'ft.fuel_type_group_id = v.vessel_fuel_type_group_id', 'INNER')
                ->join('users u', 'u.user_id = v.vessel_user_id', 'INNER')
                ->order_by('v.vessel_received_on', 'DESC')
                ->get();

        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return FALSE;
        } else {
            return $res->result_array();
        }
    }

    public function getDepots($cond = null) {

        if (null !== $cond) {
            $this->db->where($cond);
        }
        $res = $this->db->get('depots depo');
        return $res->result_array();
    }

    public function saveNewVessel($data) {
        $this->db->insert('vessels', $data['vessel_data']);
        return $this->db->affected_rows();
    }

    public function getStockLoadings($cond = null, $limit = null, $cols = null) {

        if(null !== $cols){
            $this->db->select($cols);
        }else{
            $this->db->select('*,d.user_fullname po_driver_name, d.user_driving_license po_driver_license');
        }
        
        
        if ($cond !== null) {
            $this->db->where($cond);
        }

        if ($limit == 1) {
            $this->db->limit(1);
        }

        $res = $this->db
                ->from('stock_loading sl')
                ->join('purchase_order po', 'po.po_id = sl.sl_po_id', 'INNER')
                ->join('users d','d.user_id = po.po_driver_id','INNER')
                ->join('vessels vs', 'vs.vessel_id = sl.sl_vessel_id', 'INNER')
                ->join('users u', 'u.user_id = sl.sl_user_id', 'INNER')
                ->join('fuel_types_group ftg', 'ftg.fuel_type_group_id = vs.vessel_fuel_type_group_id')
                ->order_by('sl.sl_date', 'DESC')
                ->get();


        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }

    public function saveLoading($data) {


        $this->db->trans_start();

        $this->db->insert('stock_loading', $data['loading_data']);
        $this->db->where('vessel_id', $data['vessel_id'])->update('vessels', $data['vessel_data']);

        $this->db->where('po_id', $data['po_id'])->update('purchase_order', $data['po_data']);

        $this->db->trans_complete();

        if ($this->db->trans_status() == FALSE) {

            $this->db->trans_rollback();
            return FALSE;
        } else {

            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    public function closeVessel($data) {
        
        $this->db->trans_start();
        
        $this->db->where('vessel_id',$data['vessel_id'])->update('vessels',$data['vessel_data']);
        
        if(isset($data['selected_vessel_data'])){
            $this->db->where('vessel_id',$data['selected_vessel_id'])->update('vessels',$data['selected_vessel_data']);
        }
        
        if(isset($data['unreleased_pos'])){
            $this->db->where_in('po_id',$data['unreleased_pos'])->update('purchase_order',['po_vessel_id' => $data['selected_vessel_id']]);
        }
        
        $this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE){
            
            $this->db->trans_rollback();
            return FALSE;
        }else{
            $this->db->trans_commit();
            return TRUE;
        }
    }
    
    
    public function getVesselStockLoadings($vessel_id, $cols = null) {
        
        if(null !== $cols){
            $this->db->select($cols);
        }else{
            $this->db->select('*, d.user_fullname po_driver_name');
        }
        $this->db->where('sl.sl_vessel_id',$vessel_id);
        
        $res = $this->db->from('stock_loading sl')
                ->join('purchase_order po','po.po_id = sl.sl_po_id','INNER')
                ->join('vessels vs','vs.vessel_id = po.po_vessel_id','INNER')
                ->join('fuel_types_group ftg','ftg.fuel_type_group_id = vs.vessel_fuel_type_group_id','INNER')
                ->join('users u','u.user_id = sl.sl_user_id','INNER')
                ->join('users d','d.user_id = po.po_driver_id','INNER')
                ->join('stations st', 'st.station_id = po.po_station_id', 'INNER')
                ->order_by('sl.sl_timestamp')->get();
        
        return $res->result_array();
    }
  
}
