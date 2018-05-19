<?php

Class ExpenditureModel extends CI_Model {
    
    
    public function __construct()
    {
        
    }
    
    
    public function getLatestExpenditureDate($station_id) {
        $res = $this->db
                ->where('general_expenditure_station_id',$station_id)
                ->order_by('general_expenditure_date','DESC')
                ->limit(1)
                ->get('general_expenditure');
        if($res->num_rows() == 1){
            return $res->row_array();
        }else{
            return FALSE;
        }
    }
    
    public function getAllExpenditureDates($station_id) {
        $dates = [];
        $res = $this->db->select('general_expenditure_date')
                ->where('general_expenditure_station_id',$station_id)
                ->group_by('general_expenditure_date')
                ->get('general_expenditure');
        
        $res = $res->result_array();
        foreach ( $res as $d){
            $dates[] = date('m/d/Y', strtotime($d['general_expenditure_date']));
        }
        return $dates;
    }
    
   
}