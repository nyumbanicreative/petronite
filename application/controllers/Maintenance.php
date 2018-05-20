<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Maintenance extends CI_Controller {

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

    public function fuel() {

        // Check user status
        $this->checkStatus(1, 1, 1);

        $data = [
            'menu' => 'menu/view_sys_menu', // View for menu
            'content' => 'contents/maintenance/view_fuel_and_pricing', // View for contnet
            'menu_data' => ['curr_menu' => 'MAINTENANCE', 'curr_sub_menu' => 'MAINTENANCE'], //Inorder to collapse  menu items
            'content_data' => [ //Contents data pass here
                'module_name' => 'Fuel Types And Pricing',
                'customer' => $this->customer,
                'fuel_types' => $this->mnt->getFuelTypes($this->station_id)
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }
    
    
    public function tanks() {

        // Check user status
        $this->checkStatus(1, 1, 1);

        $data = [
            'menu' => 'menu/view_sys_menu', // View for menu
            'content' => 'contents/maintenance/view_fuel_tanks', // View for contnet
            'menu_data' => ['curr_menu' => 'MAINTENANCE', 'curr_sub_menu' => 'MAINTENANCE'], //Inorder to collapse  menu items
            'content_data' => [ //Contents data pass here
                'module_name' => 'Fuel Tanks',
                'customer' => $this->customer,
                'fuel_tanks' => $this->mnt->getFuelTanks($this->station_id)
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }
    
    public function pumps() {

        // Check user status
        $this->checkStatus(1, 1, 1);

        $data = [
            'menu' => 'menu/view_sys_menu', // View for menu
            'content' => 'contents/maintenance/view_pumps', // View for contnet
            'menu_data' => ['curr_menu' => 'MAINTENANCE', 'curr_sub_menu' => 'MAINTENANCE'], //Inorder to collapse  menu items
            'content_data' => [ //Contents data pass here
                'module_name' => 'Pumps',
                'customer' => $this->customer,
                'pumps' => $this->mnt->getPumps($this->station_id)
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }
    
    
     public function attendants() {

        // Check user status
        $this->checkStatus(1, 1, 1);

        $data = [
            'menu' => 'menu/view_sys_menu', // View for menu
            'content' => 'contents/maintenance/view_attendants', // View for contnet
            'menu_data' => ['curr_menu' => 'MAINTENANCE', 'curr_sub_menu' => 'MAINTENANCE'], //Inorder to collapse  menu items
            'content_data' => [ //Contents data pass here
                'module_name' => 'Attendants',
                'customer' => $this->customer,
                'attendants' => $this->mnt->getStationAttendants($this->station_id)
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }
    
    
    public function shifts() {

        // Check user status
        $this->checkStatus(1, 1, 1);

        $data = [
            'menu' => 'menu/view_sys_menu', // View for menu
            'content' => 'contents/maintenance/view_shifts', // View for contnet
            'menu_data' => ['curr_menu' => 'MAINTENANCE', 'curr_sub_menu' => 'MAINTENANCE'], //Inorder to collapse  menu items
            'content_data' => [ //Contents data pass here
                'module_name' => 'Shifts',
                'customer' => $this->customer,
                'shifts' => $this->mnt->getShifts($this->station_id)
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }

   

}
