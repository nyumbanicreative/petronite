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
    
    private function checkStatusJson($logged_in = null, $customer = null, $admin = null) {

        if (null !== $logged_in AND ! $this->is_logged_in) {
            // User session expired they must login to continue
            cus_json_error('Your session may have been expired, Please refresh the page');
        }

        if (null !== $customer AND null === $this->customer) {
            // not a valid customer
            cus_json_error('It appears that, customer details was not found or may have been removed.');
        }

        if (null !== $admin AND null === $this->admin_id) {
            // admin identity not set
            cus_json_error('Please refresh the page to select a valid customer');
        }
    }

   
    public function usersManagement() {

        // Check user status
        $this->checkStatus(1, 1, 1);

        $data = [
            'menu' => 'menu/view_stations_menu', // View for menu
            'content' => 'contents/administrator/view_stations_users', // View for content
            'menu_data' => ['curr_menu' => 'ADMIN', 'curr_sub_menu' => 'ADMIN'], //Inorder to collapse  menu items
            'content_data' => [ //Contents data pass here
                'module_name' => 'Users Management',
                'customer' => $this->customer,
                'stations_users' => $this->usr->getStationsUsers($this->admin_id),
                'customer_drivers' => $this->usr->getUsersList(['user_admin_id' => $this->admin_id, 'user_role' => 'driver']),
            ],
            'modals_data' => [
                'modals' => ['modal_add_user'],
                'user_roles' => USER_ROLES,
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }
    
    
    public function manageUserStations() {

        // Check user status
        $this->checkStatus(1, 1, 1);
        
        $user_id = $this->uri->segment(3);
        
        $user = $this->usr->getUserInfo($user_id, "ID");
        
        if(!$user){
            $this->setSessMsg("User was not found or may have been removed from the system", "error","admin/stationsusers");
        }

        $data = [
            'menu' => 'menu/view_stations_menu', // View for menu
            'content' => 'contents/administrator/view_manage_user_stations', // View for contnet
            'menu_data' => ['curr_menu' => 'ADMIN', 'curr_sub_menu' => 'ADMIN'], //Inorder to collapse  menu items
            'content_data' => [ //Contents data pass here
                'module_name' => "User's Stations For ". $user['user_name'],
                'customer' => $this->customer,
                'user' => $user,
                'user_stations' => $this->stn->getUserStations($user['user_id'],$user['user_admin_id'])
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }
    
    
    public function submitnewuser() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1,1,1);
        
        $validations = [
            ['field' => 'full_name', 'label' => 'Full Name', 'rules' => 'trim|required'],
            ['field' => 'user_role', 'label' => 'User Role', 'rules' => 'trim|required'],
            ['field' => 'user_name', 'label' => 'Username', 'rules' => 'trim|required|is_unique['.$this->db->dbprefix.'users.user_name]', 'errors' =>['is_unique' => 'Username is not available, try the different one']],
            ['field' => 'user_phone', 'label' => 'User Phone', 'rules' => 'trim|required'],
        ];

        $this->form_validation->set_rules($validations);

        if ($this->form_validation->run() === FALSE) {

            echo json_encode([
                'status' => [
                    'error' => TRUE,
                    'error_type' => 'display',
                    "form_errors" => validation_errors_array()
                ]
            ]);
            die();
        } else {
            
            $user_data = [
                'user_station_id' => $this->station_id,
                'user_admin_id' => $this->admin_id,
                'user_fullname' => $this->input->post('full_name'),
                'user_name' => $this->input->post('user_name'),
                'user_driving_license' => $this->input->post('driving_license'),
                'user_role' => $this->input->post('user_role'),
                'user_phone' => $this->input->post('user_phone'),
                'user_email' => $this->input->post('user_email'),
                'user_address' => $this->input->post('user_address'),
                'user_active' => 1
            ];

            $res = $this->usr->saveUserDetails($user_data);

            if ($res) {

                $this->session->set_flashdata('success', 'User data saved successfully');
                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => TRUE,
                        'redirect_url' => site_url('admin/usersmanagement')
                    ]
                ]);
            } else {
                echo json_encode([
                    'status' => [
                        'error' => TRUE,
                        'error_type' => 'pop',
                        "error_msg" => 'Something went wrong. We have failed to save your venue details please try again.'
                    ]
                ]);
            }
        }
    }

   

}
