<?php

Class DippingModel extends CI_Model {
    
    
    public function __construct()
    {
        
    }
    
    
    public function getDippings($cond = null, $limit = null) {
        
        
        if($cond !== NULL){
            $this->db->where($cond);
        }
        
        if($limit == 1){
            $this->db->limit(1);
        }
        
        $res = $this->db
                ->from('inventrory_traking tr')
                ->join('shifts s','tr.inventory_traking_shift_id = s.shift_id','LEFT OUTER')
                ->join('users u','tr.inventory_traking_user_id = u.user_id','INNER')
                ->join('fuel_tanks t','t.fuel_tank_id = tr.inventory_traking_fuel_tank_id','INNER')
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
    
    
    public function getLatestDipping($station_id) {
        $res = $this->db
                ->where('inventory_traking_station_id',$station_id)
                ->order_by('inventory_traking_date','DESC')
                ->limit(1)
                ->get('inventrory_traking');
        if($res->num_rows() == 1){
            return $res->row_array();
        }else{
            return FALSE;
        }
    }
    
    
   
}