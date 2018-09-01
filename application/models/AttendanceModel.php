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
    
    
    public function getAttendances($cond = NULL, $cols = NULL, $limit = NULL, $where_in = NULL, $order_by = NULL) {

        if ($cols !== NULL) {
            $this->db->select($cols);
        }else{
            $this->db->select('*');
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
        
        $this->db->from('tbl_attandance att')
                ->select('(att_clo_mtr_reading - att_op_mtr_reading) throughput')
                ->join('pumps p', 'att.att_pump_id = p.pump_id')
                ->join('shifts s', 'att.att_shift_id = s.shift_id')
                ->join('fuel_tanks t', 'p.pump_fuel_tank_id = t.fuel_tank_id')
                ->join('fuel_types f', 't.fuel_tank_fuel_type_id = f.fuel_type_id')
                ->join('(SELECT cr.customer_sale_att_id, '
                        //. "GROUP_CONCAT(CONCAT('{\"customer_sale_id\":\"',customer_sale_id,'\",\"customer_sale_ltrs\" :\"',customer_sale_ltrs,'\",\"credit_type_name\" :\"',credit_type_name,'\",\"customer_sale_rtt\" :\"',customer_sale_rtt,'\",\"customer_sale_tts\" :\"',customer_sale_tts,'\" }')) credit_list, "
                        . 'SUM(if(customer_sale_ltrs > 0 AND customer_sale_rtt = 0 AND customer_sale_tts = 0, customer_sale_ltrs,0)) credit_sales, '
                        . 'SUM(if(customer_sale_ltrs > 0 AND customer_sale_rtt = 1 AND customer_sale_tts = 0, customer_sale_ltrs,0)) return_to_tank, '
                        . 'SUM(if(customer_sale_ltrs > 0 AND customer_sale_rtt = 0 AND customer_sale_tts = 1, customer_sale_ltrs,0)) transfered_to_station '
                        . 'FROM ' . $this->db->dbprefix . 'customer_sales cr, ' . $this->db->dbprefix . 'credit_types cus '
                        . 'WHERE cr.customer_sale_credit_type_id = cus.credit_type_id '
                        . 'GROUP BY customer_sale_att_id ORDER BY cus.credit_type_name) credits', 'att.att_id = credits.customer_sale_att_id', 'LEFT OUTER')
                ->join('users u', 'att.att_employee_id = u.user_id');
        
        if($order_by !== NULL){
            foreach ($order_by as $key => $ob) {
                $this->db->order_by($ob['col'],$ob['sort']);
            }
        }

        $res = $this->db->get();

        if ($limit == 1 AND $res->num_rows() == 1) {
            return $res->row_array();
        } elseif ($limit == 1 AND $res->num_rows() != 1) {
            return false;
        } else {
            return $res->result_array();
        }
    }
    
    
    public function saveAssignShift($data) {
        
        $this->db->trans_start();
        
        $this->db->insert('attandance', $data['att_data']);
        
        $this->db->trans_complete();

        if ($this->db->trans_status() == false) {

            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
        
    }
    
    
    public function saveCloseShift($data) {
        
        $this->db->trans_start();
        
        $this->db->where('att_id',$data['att_id'])->update('attandance',$data['att_data']);

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