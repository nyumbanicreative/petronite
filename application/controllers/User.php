<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        //Checks if user is already login
        if ($this->usr->isLogedin()) {
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

        $user_role = $this->session->userdata['logged_in']['user_role'];

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/view_dashboard_admin',
            'menu_data' => ['curr_menu' => 'DASHBOARD', 'curr_sub_menu' => 'DASHBOARD'],
            'content_data' => ['module_name' => 'DASHBOARD'],
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
            ['field' => 'loginPassword', 'label' => 'Username', 'rules' => 'trim|required|callback_validateUserpassword']
        ];
        $this->form_validation->set_rules($validations);


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
                $manager_role = "";
                $manage_hall_name = "";
                $hall_id = 0;

                switch ($user['user_role']) {

                    // If user role is hall manager
                    case 'HALLMANAGERROLE':

                        // Check if user is accociated with any hall
                        $manager_hall = $this->usr->getManagerHall($user['user_id']);


                        if ($manager_hall) {

                            // Yes he is connected to hall so get the role and hall name to put in a session later
                            $manager_role = $manager_hall['hu_user_role'];
                            $manage_hall_name = $manager_hall['hall_name'];
                            $hall_id = $manager_hall['hall_id'];
                        } else {

                            // User has no role so redirect to login page and infrom user that he has no hall to manage
                            $this->session->set_flashdata('error', 'Your account is not associated with any '
                                    . 'venue please contact the system administrator');
                            redirect('user/index');
                        }


                        break;

                    case 'ADMINROLE':


                        break;

                    case 'SERVICEPROVIDERROLE':


                        break;

                    case 'CUSTOMERROLE':

                        break;
                }

                $user_data = [
                    'useremail' => $user['user_email'],
                    'user_id' => $user['user_id'],
                    'user_fullname' => $user['user_fullname'],
                    'user_role' => $user['user_role'],
                    'user_role_name' => $user['user_role'],
                    'user_admin_id' => $user['user_admin_id'],
                    'manager_role' => $manager_role,
                    'manager_hall_name' => $manage_hall_name,
                    'hall_id' => $hall_id
                ];

                //echo '<pre>'.$user['user_role']; print_r($user_data) ; die();


                $this->session->set_userdata('logged_in', $user_data);
            } else {
                $this->session->set_flashdata('error', 'We were unable to find your user account. Please contact the system developer');
                redirect('user/index');
            }

            redirect('user/dashboard');
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
            $this->form_validation->set_message('validateUsername', 'Username was not found in a database');
            return FALSE;
        }
        return TRUE;
    }

    public function validateUserpassword($pass) {

        $usn = $this->input->post('loginUsername');
        $user = $this->usr->getUserInfo($usn);

        if ($user) {
            if ($user['user_password'] != sha1($pass)) {
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

        $user = $this->usr->getUserInfo($user_id,'ID');

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
                'businesses' => $this->busi->getBusinessList(NULL, ['b.business_added_by' => $user['user_id'] ])
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

}
