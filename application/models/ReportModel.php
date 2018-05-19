<?php

Class ReportModel extends CI_Model {

    public function __construct() {
        
    }

    public function getDates($start_date, $end_date) {
        $res = $this->db->where('dt >=', $start_date)->where('dt <=', $end_date)->get('calendar');
        return $res->result_array();
    }

    public function getSales($cond, $cols = NULL, $order_by = NULL, $att_id = NULL, $where_ins = []) {

        $this->db->where($cond);

        if ($cols !== NULL) {
            $this->db->select($cols);
        } else {
            $this->db->select('*');
        }

        if ($order_by !== NULL) {
            $this->db->order_by($order_by);
        }

        if ($att_id !== NULL) {
            $this->db->where('att.att_id', $att_id);
            $this->db->limit(1);
        }

        foreach ($where_ins as $wn) {
            $this->db->where_in($wn['col'], $wn['vals']);
        }

        $res = $this->db->from('tbl_attandance att')
                ->select('(att_clo_mtr_reading - att_op_mtr_reading) throughput')
                ->join('pumps p', 'att.att_pump_id = p.pump_id')
                ->join('shifts s', 'att.att_shift_id = s.shift_id')
                ->join('fuel_tanks t', 'p.pump_fuel_tank_id = t.fuel_tank_id')
                ->join('fuel_types f', 't.fuel_tank_fuel_type_id = f.fuel_type_id')
                ->join('(SELECT cr.customer_sale_att_id, '
                        . "GROUP_CONCAT(CONCAT('{\"customer_sale_id\":\"',customer_sale_id,'\",\"customer_sale_ltrs\" :\"',customer_sale_ltrs,'\",\"credit_type_name\" :\"',credit_type_name,'\",\"customer_sale_rtt\" :\"',customer_sale_rtt,'\",\"customer_sale_tts\" :\"',customer_sale_tts,'\" }')) credit_list, "
                        . 'SUM(if(customer_sale_ltrs > 0 AND customer_sale_rtt = 0 AND customer_sale_tts = 0, customer_sale_ltrs,0)) credit_sales, '
                        . 'SUM(if(customer_sale_ltrs > 0 AND customer_sale_rtt = 1 AND customer_sale_tts = 0, customer_sale_ltrs,0)) return_to_tank, '
                        . 'SUM(if(customer_sale_ltrs > 0 AND customer_sale_rtt = 0 AND customer_sale_tts = 1, customer_sale_ltrs,0)) transfered_to_station '
                        . 'FROM ' . $this->db->dbprefix . 'customer_sales cr, ' . $this->db->dbprefix . 'credit_types cus '
                        . 'WHERE cr.customer_sale_credit_type_id = cus.credit_type_id '
                        . 'GROUP BY customer_sale_att_id ORDER BY cus.credit_type_name) credits', 'att.att_id = credits.customer_sale_att_id', 'LEFT OUTER')
                ->join('users u', 'att.att_employee_id = u.user_id')
                ->get();

        // If attendance id is set means 1 row is requested so we return it
        if ($att_id !== NULL) {
            if ($res->num_rows() == 1) {
                return $res->row_array();
            } else {
                return FALSE;
            }
        } else {
            // Eles means many rows are requested
            return $res->result_array();
        }
    }

    public function getCreditSales($cond = null) {

        if ($cond !== NULL) {
            $this->db->where($cond);
        }

        $res = $this->db
                ->select('a.user_name attendant_name, cs.*, att.*,ct.*,f.*,s.shift_name,p.pump_name,m.user_name')
                ->from('customer_sales cs')
                ->join('attandance att', 'cs.customer_sale_att_id = att.att_id', 'INNER')
                ->join('users m', 'cs.customer_sale_added_by = m.user_id')
                ->join('credit_types ct', 'cs.customer_sale_credit_type_id = ct.credit_type_id', 'INNER')
                ->join('pumps p', 'att.att_pump_id = p.pump_id','INNER')
                ->join('fuel_tanks t', 'p.pump_fuel_tank_id = t.fuel_tank_id')
                ->join('fuel_types f', 't.fuel_tank_fuel_type_id = f.fuel_type_id')
                ->join('shifts s', 'att.att_shift_id = s.shift_id','INNER')
                ->join('users a','att.att_employee_id = a.user_id')
                ->order_by('s.shift_sequence ASC,ct.credit_type_name ASC, p.pump_name ASC')
                ->get();

        return $res->result_array();
    }
    
    
    public function getGeneralExpenditures($cond = null, $cols = null, $limit = null) {
        
        if ($cond !== NULL) {
            $this->db->where($cond);
        }
        
        if ($cols !== NULL) {
            $this->db->select($cols);
        }else{
            $this->db->select(''
                    . 'ge.general_expenditure_id,ge.general_expenditure_amount, ge.general_expenditure_notes, '
                    . 'ge.general_expenditure_aproved approval_status, sh.shift_name, et.expenditure_type_title,'
                    . 'm.user_name added_by, a.user_name approved_by,pa.approval_time');
        }
        
        $res = $this->db
                ->from('general_expenditure ge')
                ->join('expenditure_type et','et.expenditure_type_id = ge.general_expenditure_expenditure_type_id','LEFT OUTER')
                ->join('approval pa',"pa.approval_reference_id = ge.general_expenditure_id AND pa.approval_type ='EXPENDITURE'  AND  approval_status = '1'", 'LEFT OUTER')
                ->join("users a","pa.approval_user_id = a.user_id AND pa.approval_status = '1'",'LEFT OUTER')
                ->join("users m","m.user_id = ge.general_expenditure_user_id",'INNER')
                ->join("shifts sh", "sh.shift_id = ge.general_expenditure_shift_id","INNER")
                ->get();
        
        
        if($limit == 1 AND $res->num_rows() == 1){
            return $res->row_array();
        }elseif($limit == 1 AND $res->num_rows != 1){
            return FALSE;
        }else{
            return $res->result_array();
        }
     
    }

}
