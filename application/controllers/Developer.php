<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Developer extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function customers() {


        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        if (!$this->usr->isDeveloper()) {
            $this->session->set_flashdata('error', 'You do not have permission to perform requested action');
            redirect('user/index');
        }


        $data = [
            'menu' => 'menu/view_developer_menu',
            'content' => 'contents/view_petronite_customers',
            'menu_data' => ['curr_menu' => 'CUSTOMERS', 'curr_sub_menu' => 'CUSTOMERS'],
            'content_data' => [
                'module_name' => 'Petronite Customers',
                'customers' => $this->cust->getPetroniteCustomers()
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function logs($log_date = NULL) {

        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        if (!$this->usr->isDeveloper()) {
            $this->session->set_flashdata('error', 'You do not have permission to perform requested action');
            redirect('user/index');
        }

        $this->load->library('log_library');

        if ($log_date == NULL) {
            // default: today
            $log_date = date('Y-m-d');
        }
        
        $cols = $this->log_library->get_file('log-' . $log_date . '.php');
        
        $data = [
            'menu' => 'menu/view_developer_menu',
            'content' => 'contents/view_logs',
            'menu_data' => ['curr_menu' => 'LOGS', 'curr_sub_menu' => 'LOGS'],
            'content_data' => [
                'module_name' => 'System Logs',
                'cols' => $cols,
                'log_date' => $log_date
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }
    
    public function setCustomer() {
        
        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        if (!$this->usr->isDeveloper()) {
            $this->session->set_flashdata('error', 'You do not have permission to perform requested action');
            redirect('user/index');
        }
        
        
        $admin_id = $this->uri->segment(3);
        
     
        
        if($this->usr->isStationAdmin($admin_id)){
            
            $this->session->userdata['logged_in']['user_admin_id'] = $admin_id;
            redirect('station');
        }else{
            $this->session->set_flashdata('error', 'Select a valid customer');
            redirect('developer/customers');
        }
        
    }

}
