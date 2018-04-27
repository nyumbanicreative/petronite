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
    
   
}