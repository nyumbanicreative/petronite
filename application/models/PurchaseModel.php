<?php

Class PurchaseModel extends CI_Model {
    
    
    public function __construct()
    {
        
    }
    
    
    public function getPurchases($cond = null, $limit = null) {
        
        
        if($cond !== NULL){
            $this->db->where($cond);
        }
        
        if($limit == 1){
            $this->db->limit(1);
        }
        
        $res = $this->db
                ->from('inventory_purchases pur')
                ->join('shifts s','pur.inventory_purchase_shift_id = s.shift_id','LEFT OUTER')
                ->join('users u','pur.inventory_purchase_user_id = u.user_id','INNER')
                ->join('fuel_tanks t','t.fuel_tank_id = pur.inventory_purchase_tank_id','INNER')
                ->join('fuel_types f','f.fuel_type_id = t.fuel_tank_fuel_type_id','INNER')
                ->order_by('s.shift_sequence')
                ->get();
        
        
        if($limit == 1 AND $res->num_rows() == 1){
            return $res->row_array();
        }elseif($limit == 1 AND $res->num_rows() != 1){
            return false;
        }else{
            return $res->result_array();
        }
    }
    
    
    public function getLatestPurchaseDate($station_id) {
        $res = $this->db
                ->where('inventory_purchase_station_id',$station_id)
                ->order_by('inventory_purchase_date','DESC')
                ->limit(1)
                ->get('inventory_purchases');
        if($res->num_rows() == 1){
            return $res->row_array();
        }else{
            return FALSE;
        }
    }
    
    
    public function getAllPurchaseDates($station_id) {
        $dates = [];
        $res = $this->db->select('inventory_purchase_date')
                ->where('inventory_purchase_station_id',$station_id)
                ->group_by('inventory_purchase_date')
                ->get('inventory_purchases');
        $res = $res->result_array();
        foreach ( $res as $d){
            $dates[] = date('m/d/Y', strtotime($d['inventory_purchase_date']));
        }
        return $dates;
    }
    
    
   
}