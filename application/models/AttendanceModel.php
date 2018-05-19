<?php

Class AttendanceModel extends CI_Model {
    
    
    public function __construct()
    {
        
    }
    
    
    public function getLatestAtt($station_id) {
        $res = $this->db
                ->where('att_station_id',$station_id)
                ->order_by('att_date','DESC')
                ->limit(1)
                ->get('attandance');
        if($res->num_rows() == 1){
            return $res->row_array();
        }else{
            return FALSE;
        }
    }
    
    
    
   
}