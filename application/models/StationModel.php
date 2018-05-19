<?php

Class StationModel extends CI_Model {
    
    
    public function __construct()
    {
        
    }
    
    
    public function getUserStations($user_id,$admin_id) {
        
       // $q ="SELECT s.*, o.* FROM tbl_stations s,tbl_organize o WHERE s.station_id = o.organize_station_id AND o.organize_user_id = :user_id";
          
        $res = $this->db->from('stations s, organize o')
                ->where('s.station_id = o.organize_station_id')
                ->where('o.organize_user_id',$user_id)
                ->where('s.station_admin_id',$admin_id)
                ->order_by('s.station_name','ACS')
                ->get();
        
        return $res->result_array();
    }
    
    
    public function canAccessStation($user_id,$station_id) {
        $res = $this->db->where('o.organize_user_id',$user_id)
                ->where('o.organize_station_id',$station_id)
                ->where('o.organize_station_id = s.station_id')
                ->where('s.station_id',$station_id)
                ->limit(1)
                ->get('organize o, stations s');
        
        if($res->num_rows() == 1){
            return $res->row_array();
        }else{
            return FALSE;
        }
    }
    
    public function getStationDetails($station_id) {
        
        $res = $this->db->where('s.station_id',$station_id)
                ->limit(1)
                ->get('station s');
        
        if($res->num_rows() == 1){
            return $res->row_array();
        }else{
            return FALSE;
        }
    }
    
    public function getStationTanks($station_id) {
        
        $res = $this->db->where('fuel_tank_station_id',$station_id)
                ->where('t.fuel_tank_fuel_type_id = f.fuel_type_id')
                ->get('fuel_tanks t, fuel_types f');
        
        return $res->result_array();
    }
    
   
}