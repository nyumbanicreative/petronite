<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dailyentries extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function attendantsShifts() {

        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        $user_id = $this->session->userdata['logged_in']['user_id'];
        $station_id = $this->session->userdata['logged_in']['user_station_id'];
        $admin_id = $this->session->userdata['logged_in']['user_admin_id'];
        $customer = $this->cust->getCustomerDetails($admin_id);

        if (!$customer) {
            // not a valid customer
            $this->session->set_flashdata('error', 'It appears that, customer details was not found or may have been removed.');
            redirect('user/logout');
        }

        if (empty($admin_id)) {
            $this->session->set_flashdata('error', 'Select a valid customer');
            redirect('developer/customers');
        }


        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_att = $this->att->getLatestAtt($station_id);
            if ($latest_att) {
                $date = $latest_att['att_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving attendants shifts due to date 
        $cond = ['att.att_station_id' => $station_id, 'att.att_date' => $date];
        $order_by = 's.shift_sequence ASC, u.user_name ASC, p.pump_name ASC, f.fuel_type_generic_name ASC';
        $atts = $this->rpt->getSales($cond, null, $order_by); // reused this function from report model coz it does the same
        //cus_print_r($atts);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_attendants_shifts',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Attendant Shifts',
                'customer' => $customer,
                'atts' => $atts,
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

    public function saleDetails() {

        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        $user_id = $this->session->userdata['logged_in']['user_id'];
        $station_id = $this->session->userdata['logged_in']['user_station_id'];
        $admin_id = $this->session->userdata['logged_in']['user_admin_id'];
        $customer = $this->cust->getCustomerDetails($admin_id);


        if (!$customer) {
            // not a valid customer
            $this->session->set_flashdata('error', 'It appears that, customer details was not found or may have been removed.');
            redirect('user/logout');
        }

        if (empty($admin_id)) {
            $this->session->set_flashdata('error', 'Select a valid customer');
            redirect('developer/customers');
        }


        // Attendants shifts date
        $att_id = $this->uri->segment(3);


        // Retrieving attendants shifts due to date 
        $cond = ['att.att_station_id' => $station_id];

        $sale = $this->rpt->getSales($cond, NULL, NULL, $att_id); // reused this function from report model coz it does the same

        if (!$sale) {
            $this->session->set_flashdata('error', 'Sale details was not found or may have been removed from the system');
            redirect('dailyentries/attendantsshifts');
        }

        //cus_print_r($sale);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_sale_details',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Shift Details',
                'customer' => $customer,
                'sale' => $sale
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function creditSales() {

        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        $user_id = $this->session->userdata['logged_in']['user_id'];
        $station_id = $this->session->userdata['logged_in']['user_station_id'];
        $admin_id = $this->session->userdata['logged_in']['user_admin_id'];
        $customer = $this->cust->getCustomerDetails($admin_id);

        if (!$customer) {
            // not a valid customer
            $this->session->set_flashdata('error', 'It appears that, customer details was not found or may have been removed.');
            redirect('user/logout');
        }

        if (empty($admin_id)) {
            $this->session->set_flashdata('error', 'Select a valid customer');
            redirect('developer/customers');
        }


        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_att = $this->att->getLatestAtt($station_id);
            if ($latest_att) {
                $date = $latest_att['att_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving attendants shifts due to date 
        $cond = ['att.att_station_id' => $station_id, 'att.att_date' => $date, 'cs.customer_sale_tts' => '0'];
        $credit_sales = $this->rpt->getCreditSales($cond); // reused this function from report model coz it does the same
        //cus_print_r($atts);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_credit_sales',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Credit Sales',
                'customer' => $customer,
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
        
        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        $user_id = $this->session->userdata['logged_in']['user_id'];
        $station_id = $this->session->userdata['logged_in']['user_station_id'];
        $admin_id = $this->session->userdata['logged_in']['user_admin_id'];
        $customer = $this->cust->getCustomerDetails($admin_id);

        if (!$customer) {
            // not a valid customer
            $this->session->set_flashdata('error', 'It appears that, customer details was not found or may have been removed.');
            redirect('user/logout');
        }

        if (empty($admin_id)) {
            $this->session->set_flashdata('error', 'Select a valid customer');
            redirect('developer/customers');
        }


        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_date = $this->exps->getLatestExpenditureDate($station_id);
            if ($latest_date) {
                $date = $latest_date['general_expenditure_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving expenditure shifts due to date 
        $cond = ['ge.general_expenditure_station_id' => $station_id, 'ge.general_expenditure_date' => $date];
        $expenditures = $this->rpt->getGeneralExpenditures($cond); // reused this function from report model coz it does the same
        //cus_print_r($credit_sales);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_general_expenditure',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'General Expenditure <span class="module-date">&nbsp;&nbsp;(' . cus_nice_date($date) . ')</span> ',
                'customer' => $customer,
                'expenditures' => $expenditures,
                'expenditure_dates' => $this->exps->getAllExpenditureDates($station_id),
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
        
        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        $user_id = $this->session->userdata['logged_in']['user_id'];
        $station_id = $this->session->userdata['logged_in']['user_station_id'];
        $admin_id = $this->session->userdata['logged_in']['user_admin_id'];
        $customer = $this->cust->getCustomerDetails($admin_id);

        if (!$customer) {
            // not a valid customer
            $this->session->set_flashdata('error', 'It appears that, customer details was not found or may have been removed.');
            redirect('user/logout');
        }

        if (empty($admin_id)) {
            $this->session->set_flashdata('error', 'Select a valid customer');
            redirect('developer/customers');
        }


        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_date = $this->dipping->getLatestDipping($station_id);
            if ($latest_date) {
                $date = $latest_date['inventory_traking_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving expenditure shifts due to date 
        $cond = ['tr.inventory_traking_station_id' => $station_id, 'tr.inventory_traking_date' => $date];
        $dippings = $this->dipping->getDippings($cond); // reused this function from report model coz it does the same
        //cus_print_r($dippings);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_dippings',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Dipping <span class="module-date">&nbsp;&nbsp;(' . cus_nice_date($date) . ')</span> ',
                'customer' => $customer,
                'dippings' => $dippings,
                'fuel_types' => $this->mnt->getFuelTypes($station_id),
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
        
        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        $user_id = $this->session->userdata['logged_in']['user_id'];
        $station_id = $this->session->userdata['logged_in']['user_station_id'];
        $admin_id = $this->session->userdata['logged_in']['user_admin_id'];
        $customer = $this->cust->getCustomerDetails($admin_id);

        if (!$customer) {
            // not a valid customer
            $this->session->set_flashdata('error', 'It appears that, customer details was not found or may have been removed.');
            redirect('user/logout');
        }

        if (empty($admin_id)) {
            $this->session->set_flashdata('error', 'Select a valid customer');
            redirect('developer/customers');
        }


        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_date = $this->purchase->getLatestPurchaseDate($station_id);
            if ($latest_date) {
                $date = $latest_date['inventory_purchase_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving expenditure shifts due to date 
        $cond = ['pur.inventory_purchase_station_id' => $station_id, 'pur.inventory_purchase_date' => $date];
        $purchases = $this->purchase->getPurchases($cond); // reused this function from report model coz it does the same
        //cus_print_r($dippings);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_purchases',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Purchases <span class="module-date">&nbsp;&nbsp;(' . cus_nice_date($date) . ')</span> ',
                'customer' => $customer,
                'purchases' => $purchases,
                'fuel_types' => $this->mnt->getFuelTypes($station_id),
                'purchase_dates' => $this->purchase->getAllPurchaseDates($station_id),
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

        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        $user_id = $this->session->userdata['logged_in']['user_id'];
        $station_id = $this->session->userdata['logged_in']['user_station_id'];
        $admin_id = $this->session->userdata['logged_in']['user_admin_id'];
        $customer = $this->cust->getCustomerDetails($admin_id);

        if (!$customer) {
            // not a valid customer
            $this->session->set_flashdata('error', 'It appears that, customer details was not found or may have been removed.');
            redirect('user/logout');
        }

        if (empty($admin_id)) {
            $this->session->set_flashdata('error', 'Select a valid customer');
            redirect('developer/customers');
        }


        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_att = $this->att->getLatestAtt($station_id);
            if ($latest_att) {
                $date = $latest_att['att_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving attendants shifts due to date 
        $cond = ['att.att_station_id' => $station_id, 'att.att_date' => $date, 'cs.customer_sale_tts' => '1'];
        $credit_sales = $this->rpt->getCreditSales($cond); // reused this function from report model coz it does the same
        //cus_print_r($atts);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_stock_transfer',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Stock Transfer <span class="module-date">&nbsp;&nbsp;(' . cus_nice_date($date) . ')</span> ',
                'customer' => $customer,
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
