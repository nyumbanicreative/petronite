<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dailyentries extends CI_Controller {

    // Initialize gloabal variables
    var $user_id = null;
    var $station_id = null;
    var $is_logged_in = false;
    var $customer = null;

    public function __construct() {
        parent::__construct();

        // Check if user has logged in using session
        if ($this->usr->isLogedin()) {
            $this->user_id = $this->session->userdata['logged_in']['user_id'];
            $this->station_id = $this->session->userdata['logged_in']['user_station_id'];
            $this->admin_id = $this->session->userdata['logged_in']['user_admin_id'];
            $this->customer = $this->cust->getCustomerDetails($this->admin_id);
            $this->is_logged_in = TRUE;
        }
    }

    private function setSessMsg($msg, $type, $redirect_to = null) {
        $this->session->set_flashdata($type, $msg);
        if (null !== $redirect_to) {
            redirect($redirect_to);
        }
    }
    
    private function checkStatus($logged_in = null, $customer = null, $admin = null) {
        
        if(null !== $logged_in AND !$this->is_logged_in){
            // User session expired they must login to continue
            $this->setSessMsg('Loging in is required', 'error', 'user/index');
        }
      
        if (null !== $customer AND null === $this->customer) {
            // not a valid customer
            $this->setSessMsg('It appears that, customer details was not found or may have been removed.', 'error', 'user/logout'); 
        }

        if (null !== $admin AND null === $this->admin_id) {
            // admin identity not set
            $this->setSessMsg('Select a valid customer', 'error','developer/customers');
        }
    }

    public function attendantsShifts() {

        $this->checkStatus(1, 1, 1);

        // Get latest Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_att = $this->att->getLatestAtt($this->station_id);
            if ($latest_att) {
                $date = $latest_att['att_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving attendants shifts due to date 
        $cond = ['att.att_station_id' => $this->station_id, 'att.att_date' => $date];
        $order_by = 's.shift_sequence ASC, u.user_name ASC, p.pump_name ASC, f.fuel_type_generic_name ASC';
        $atts = $this->rpt->getSales($cond, null, $order_by); // reused this function from report model coz it does the same
        //cus_print_r($atts);        die();

        // Creating view data
        $data = [
            'menu' => 'menu/view_sys_menu', // View for menu
            'content' => 'contents/dailyentries/view_attendants_shifts', // View for contnet
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'], //Inorder to collapse  menu items
            'content_data' => [ //Contents data pass here
                'module_name' => 'Attendant Shifts',
                'customer' => $this->customer,
                'atts' => $atts,
                'date' => $date,
                'next_day' => date('Y-m-d', strtotime('+1 day', strtotime($date))),
                'prev_day' => date('Y-m-d', strtotime('-1 day', strtotime($date)))
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }

    public function saleDetails() {

        //Check user status
        $this->checkStatus(1, 1, 1);


        // Attendants shifts date
        $att_id = $this->uri->segment(3);


        // Retrieving attendants shifts due to date 
        $cond = ['att.att_station_id' => $this->station_id];

        $sale = $this->rpt->getSales($cond, NULL, NULL, $att_id); // reused this function from report model coz it does the same

        if (!$sale) {
            //Sale details not found so we redirect to attendant shifts
            $this->setSessMsg('Sale details was not found or may have been removed from the system', 'error','dailyentries/attendantsshifts');
        }

        //cus_print_r($sale);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/dailyentries/view_sale_details',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Shift Details',
                'customer' => $this->customer,
                'sale' => $sale
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function creditSales() {
        
        //Check user status
        $this->checkStatus(1, 1, 1);
        
        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_att = $this->att->getLatestAtt($this->station_id);
            if ($latest_att) {
                $date = $latest_att['att_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving attendants shifts due to date 
        $cond = ['att.att_station_id' => $this->station_id, 'att.att_date' => $date, 'cs.customer_sale_tts' => '0'];
        $credit_sales = $this->rpt->getCreditSales($cond); // reused this function from report model coz it does the same
        //cus_print_r($atts);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/dailyentries/view_credit_sales',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Credit Sales',
                'customer' => $this->customer,
                'credit_sales' => $credit_sales,
                'date' => $date,
                'next_day' => date('Y-m-d', strtotime('+1 day', strtotime($date))),
                'prev_day' => date('Y-m-d', strtotime('-1 day', strtotime($date)))
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function expenditure() {

        //Check user status
        $this->checkStatus(1, 1, 1);


        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_date = $this->exps->getLatestExpenditureDate($this->station_id);
            if ($latest_date) {
                $date = $latest_date['general_expenditure_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving expenditure shifts due to date 
        $cond = ['ge.general_expenditure_station_id' => $this->station_id, 'ge.general_expenditure_date' => $date];
        $expenditures = $this->rpt->getGeneralExpenditures($cond); // reused this function from report model coz it does the same
        //cus_print_r($credit_sales);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/dailyentries/view_general_expenditure',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'General Expenditure <span class="module-date">&nbsp;&nbsp;(' . cus_nice_date($date) . ')</span> ',
                'customer' => $this->customer,
                'expenditures' => $expenditures,
                'expenditure_dates' => $this->exps->getAllExpenditureDates($this->station_id),
                'date' => $date,
                'next_day' => date('Y-m-d', strtotime('+1 day', strtotime($date))),
                'prev_day' => date('Y-m-d', strtotime('-1 day', strtotime($date)))
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function dipping() {

        //Check user status
        $this->checkStatus(1, 1, 1);


        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_date = $this->dipping->getLatestDipping($this->station_id);
            if ($latest_date) {
                $date = $latest_date['inventory_traking_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving expenditure shifts due to date 
        $cond = ['tr.inventory_traking_station_id' => $this->station_id, 'tr.inventory_traking_date' => $date];
        $dippings = $this->dipping->getDippings($cond); // reused this function from report model coz it does the same
        //cus_print_r($dippings);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/dailyentries/view_dippings',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Dipping <span class="module-date">&nbsp;&nbsp;(' . cus_nice_date($date) . ')</span> ',
                'customer' => $this->customer,
                'dippings' => $dippings,
                'fuel_types' => $this->mnt->getFuelTypes($this->station_id),
                'date' => $date,
                'next_day' => date('Y-m-d', strtotime('+1 day', strtotime($date))),
                'prev_day' => date('Y-m-d', strtotime('-1 day', strtotime($date)))
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function purchases() {

        //Check user status
        $this->checkStatus(1, 1, 1);


        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_date = $this->purchase->getLatestPurchaseDate($this->station_id);
            if ($latest_date) {
                $date = $latest_date['inventory_purchase_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving expenditure shifts due to date 
        $cond = ['pur.inventory_purchase_station_id' => $this->station_id, 'pur.inventory_purchase_date' => $date];
        $purchases = $this->purchase->getPurchases($cond); // reused this function from report model coz it does the same
        //cus_print_r($dippings);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/dailyentries/view_purchases',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Purchases <span class="module-date">&nbsp;&nbsp;(' . cus_nice_date($date) . ')</span> ',
                'customer' => $this->customer,
                'purchases' => $purchases,
                'fuel_types' => $this->mnt->getFuelTypes($this->station_id),
                'purchase_dates' => $this->purchase->getAllPurchaseDates($this->station_id),
                'date' => $date,
                'next_day' => date('Y-m-d', strtotime('+1 day', strtotime($date))),
                'prev_day' => date('Y-m-d', strtotime('-1 day', strtotime($date)))
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function stocktransfer() {

        //Check user status
        $this->checkStatus(1, 1, 1);


        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_att = $this->att->getLatestAtt($this->station_id);
            if ($latest_att) {
                $date = $latest_att['att_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving attendants shifts due to date 
        $cond = ['att.att_station_id' => $this->station_id, 'att.att_date' => $date, 'cs.customer_sale_tts' => '1'];
        $credit_sales = $this->rpt->getCreditSales($cond); // reused this function from report model coz it does the same
        //cus_print_r($atts);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/dailyentries/view_stock_transfer',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Stock Transfer <span class="module-date">&nbsp;&nbsp;(' . cus_nice_date($date) . ')</span> ',
                'customer' => $this->customer,
                'credit_sales' => $credit_sales,
                'date' => $date,
                'next_day' => date('Y-m-d', strtotime('+1 day', strtotime($date))),
                'prev_day' => date('Y-m-d', strtotime('-1 day', strtotime($date)))
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

}
