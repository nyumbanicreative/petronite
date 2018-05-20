<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    // Initialize gloabal variables
    var $user_id = null;
    var $station_id = null;
    var $is_logged_in = false;
    var $customer = null;
    var $admin_id = null;

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

   
    public function stationsUsers() {

        // Check user status
        $this->checkStatus(1, 1, 1);

        $data = [
            'menu' => 'menu/view_stations_menu', // View for menu
            'content' => 'contents/administrator/view_stations_users', // View for contnet
            'menu_data' => ['curr_menu' => 'ADMIN', 'curr_sub_menu' => 'ADMIN'], //Inorder to collapse  menu items
            'content_data' => [ //Contents data pass here
                'module_name' => 'Stations Users',
                'customer' => $this->customer,
                'stations_users' => $this->usr->getStationsUsers($this->admin_id)
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }

   

}
