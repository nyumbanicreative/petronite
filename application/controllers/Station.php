<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Station extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }
        
        $user_id = $this->session->userdata['logged_in']['user_id'];
        $admin_id = $this->session->userdata['logged_in']['user_admin_id'];
        $customer = $this->cust->getCustomerDetails($admin_id);
        
        
        if(!$customer){
            // not a valid customer
            $this->session->set_flashdata('error', 'It appears that, customer details was not found or may have been removed.');
            redirect('user/logout');
        }
        
        
        $stations = $this->stn->getUserStations($user_id, $admin_id);
        
        
        if(empty($admin_id)){
            $this->session->set_flashdata('error', 'Select a valid customer');
            redirect('developer/customers');
        }
        
        $data = [
            'menu' => 'menu/view_stations_menu',
            'content' => 'contents/view_stations',
            'menu_data' => ['curr_menu' => 'STATIONS', 'curr_sub_menu' => 'STATIONS'],
            'content_data' => [
                'module_name' => $customer['pc_name'] . ' Stations',
                'customer' => $customer,
                'stations' => $stations
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }
    
    public function setStation() {
        
        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }
        
        $station_id = $this->uri->segment(3);
        $user_id = $this->session->userdata['logged_in']['user_id'];
        
        $station = $this->stn->canAccessStation($user_id, $station_id);
        
        
        if($station){
            
            $this->session->userdata['logged_in']['user_station_id'] = $station['station_id'];
            $this->session->userdata['logged_in']['user_station_name'] = $station['station_name'];
            $this->session->userdata['logged_in']['user_station_role'] = $station['organize_user_role'];
            
            redirect('user/dashboard');
        }else{
            $this->session->set_flashdata('error','Select a valid station');
            redirect('station');
        }
       
    }

    

}
