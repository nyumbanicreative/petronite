<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends CI_Controller {

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

        if (null !== $logged_in AND ! $this->is_logged_in) {
            // User session expired they must login to continue
            $this->setSessMsg('Loging in is required', 'error', 'user/index');
        }

        if (null !== $customer AND null === $this->customer) {
            // not a valid customer
            $this->setSessMsg('It appears that, customer details was not found or may have been removed.', 'error', 'user/logout');
        }

        if (null !== $admin AND null === $this->admin_id) {
            // admin identity not set
            $this->setSessMsg('Select a valid customer', 'error', 'developer/customers');
        }
    }

    private function checkStatusJson($logged_in = null, $customer = null, $admin = null) {

        if (null !== $logged_in AND ! $this->is_logged_in) {
            // User session expired they must login to continue
            cus_json_error('Loging in is required, Please refresh the page');
        }

        if (null !== $customer AND null === $this->customer) {
            // not a valid customer
            cus_json_error('It appears that, customer details was not found or may have been removed.');
        }

        if (null !== $admin AND null === $this->admin_id) {
            // admin identity not set
            cus_json_error('Select a valid customer');
        }
    }

    public function index() {

        // Check user status
        $this->checkStatus(1, 1, 1);

        $data = [
            'menu' => 'menu/view_stations_menu', // View for menu
            'content' => 'contents/customers_suppliers/view_credit_customers', // View for contnet
            'menu_data' => ['curr_menu' => 'CUSTOMERS', 'curr_sub_menu' => 'CUSTOMERS'], //Inorder to collapse  menu items
            'content_data' => [//Contents data pass here
                'module_name' => 'Credit Customers',
                'customer' => $this->customer,
                'credit_customers' => $this->cust->getStationCustomers($this->admin_id)
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }

    public function suppliers() {
        // Check user status
        $this->checkStatus(1, 1, 1);

        $data = [
            'menu' => 'menu/view_stations_menu', // View for menu
            'content' => 'contents/customers/view_credit_customers', // View for contnet
            'menu_data' => ['curr_menu' => 'CUSTOMERS', 'curr_sub_menu' => 'CUSTOMERS'], //Inorder to collapse  menu items
            'content_data' => [//Contents data pass here
                'module_name' => 'Credit Customers',
                'customer' => $this->customer,
                'credit_customers' => $this->cust->getStationCustomers($this->admin_id)
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }

    public function ajaxsCustomerBreakdown() {

        $this->checkStatusJson(1, 1, 1);

        $data = [];

        $datatable_data = [
            'admin_id' => $this->usr->admin_id,
            'search_columns' => ['ct.credit_type_name'],
            'order_columns' => ['ct.credit_type_name', 'ct.credit_type_balance', NULL],
            'default_order_columns' => ['ct.credit_type_name' => 'ACS']
        ];

        $list = $this->cust->get_datatables_station_customers($datatable_data);

        $no = $_POST['start'];

        foreach ($list as $a) {
            $no++;
            $row = array();

            $status = "";

            $balance = $a->credit_type_balance;

            if ($balance <= 0) {
                $balance = "<h4><span class='badge badge-success'>" . CURRENCY . '  ' . cus_price_form(abs($balance)) . " Cr</span></h4>";
            } else {
                $balance = "<h4><span class='badge badge-danger'>" . CURRENCY . '  ' . cus_price_form(abs($balance)) . " Dr</span></h4>";
            }

            $link = '<a href="' . site_url('customers/customersstatement/' . $a->credit_type_id) . '" class="btn btn-sm btn-outline-info">View Statement</a>';

            //$row[] = $no;
            $row[] = $a->credit_type_name;
            $row[] = $balance;
            $row[] = $link;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cust->count_all_station_customers($datatable_data),
            "recordsFiltered" => $this->cust->count_filtered_station_customers($datatable_data),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }

    public function ajaxStationCustomersList() {

        $this->checkStatusJson(1, 1, 1);

        $data = [];
        $datatable_data = [
            'admin_id' => $this->usr->admin_id,
            'search_columns' => ['ct.credit_type_name', 'cts.stations'],
            'order_columns' => ['ct.credit_type_name', NULL, NULL],
            'default_order_columns' => ['ct.credit_type_name' => 'ACS']
        ];

        $list = $this->cust->get_datatables_station_customers($datatable_data);
        $no = $_POST['start'];

        foreach ($list as $a) {
            $no++;
            $row = array();

            $status = "";
            $link = '<div class="dropdown">
                        <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                            <a href=""  class="dropdown-item edit_item text-success"> <i class="fa fa-list-ul"></i>&nbsp;&nbsp;Details</a>
                        </div>
                    </div>';

            //$row[] = $no;
            $row[] = $a->credit_type_name;
            $row[] = $a->stations;
            $row[] = $a->credit_type_type_description;
            $row[] = $a->credit_type_allow_rtt;
            $row[] = $link;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->cust->count_all_station_customers($datatable_data),
            "recordsFiltered" => $this->cust->count_filtered_station_customers($datatable_data),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }

    public function customersBalance() {
        // Check user status
        $this->checkStatus(1, 1, 1);

        $data = [
            'menu' => 'menu/view_stations_menu', // View for menu
            'content' => 'contents/customers_suppliers/view_customers_breakdown', // View for contnet
            'menu_data' => ['curr_menu' => 'CUSTOMERS', 'curr_sub_menu' => 'CUSTOMERS'], //Inorder to collapse  menu items
            'content_data' => [//Contents data pass here
                'module_name' => 'Credit Customers Balance',
                'customer' => $this->customer,
                'credit_customers' => $this->cust->getStationCustomers($this->admin_id)
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }

    public function customersStatement() {

        // Check user status
        $this->checkStatus(1, 1, 1);
        $customer_id = $this->uri->segment(3);

        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-30 days'));

        $cc = $this->cust->getCreditCustomers(['credit_type_id' => $customer_id], null, 1);

        if (!$cc) {
            $this->usr->setSessMsg('Customer was not found or may have been removed from the system', 'error', 'customers/customersbalance');
        }

        $validation = [
                ['field' => 'date_range', 'label' => 'Date Range', 'rules' => 'callback_validateReportDateRange']
        ];

        $this->form_validation->set_rules($validation);
        $this->form_validation->run();

        $cond = NULL;
        $date_string = $start_date . ' to ' . $end_date;
        $date_range = $this->input->post('date_range');

        if (!empty($date_range)) {

            $date_range_segments = explode('to', $date_range);

            if (sizeof($date_range_segments) == 2) {
                $start_date = $date_range_segments[0];
                $end_date = $date_range_segments[1];
                $cond = ['txn.txn_acc_ref' => $cc['credit_type_id'], "DATE(txn.txn_timestamp) >= " => trim($date_range_segments[0]), " DATE(txn.txn_timestamp) <=  " => trim($date_range_segments[1])];
                $date_string = $date_range;
            } else {
                $cond = ['txn.txn_acc_ref' => $cc['credit_type_id'], "DATE(txn.txn_timestamp) >= " => trim($start_date), " DATE(txn.txn_timestamp) <=  " => trim($end_date)];
            }
        } else {
            $cond = ['txn.txn_acc_ref' => $cc['credit_type_id'], "DATE(txn.txn_timestamp) >= " => trim($start_date), " DATE(txn.txn_timestamp) <=  " => trim($end_date)];
        }


        // $txns = $this->txn->getTransactions(NULL, "txn.txn_type IN ('CREDIT_SALE','CREDIT_PAYMENT') AND txn.txn_acc_ref = '".$cc['credit_type_id']."'");

        $txns = $this->txn->getTransactions(NULL, $cond, NULL, ['txn.txn_type' => ['CREDIT_SALE', 'CREDIT_PAYMENT','CANCELLED_PAYMENT']]);

//        echo '<pre>';
//        print_r($txns);
//        
//        die();
        $data = [
            'menu' => 'menu/view_stations_menu', // View for menu
            'content' => 'contents/customers_suppliers/view_customer_statement', // View for contnet
            'menu_data' => ['curr_menu' => 'CUSTOMERS', 'curr_sub_menu' => 'CUSTOMERS'], //Inorder to collapse  menu items
            'content_data' => [//Contents data pass here
                'module_name' => 'Credit Customers',
                'customer' => $this->customer,
                'txns' => $txns,
                'cc' => $cc,
                'datefrom' => $start_date,
                'dateto' => $end_date,
                'date_string' => $date_string,
                'credit_customers' => $this->cust->getStationCustomers($this->admin_id)
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }

    public function pdfCustomerStatement() {

        ini_set('memory_limit', '50M'); // boost the memory limit if it's low ;)
        // Check user status
        $this->checkStatus(1, 1, 1);
        $customer_id = $this->uri->segment(3);

        $end_date = $this->input->get('dateto');
        $start_date = $this->input->get('date_from');

        $cc = $this->cust->getCreditCustomers(['credit_type_id' => $customer_id], null, 1);

        if (!$cc) {
            $this->usr->setSessMsg('Customer was not found or may have been removed from the system', 'error', 'customers/customersbalance');
        }

        $cond = ['txn.txn_acc_ref' => $cc['credit_type_id'], "DATE(txn.txn_timestamp) >= " => trim($start_date), " DATE(txn.txn_timestamp) <=  " => trim($end_date)];

        $txns = $this->txn->getTransactions(NULL, $cond, NULL, ['txn.txn_type' => ['CREDIT_SALE', 'CREDIT_PAYMENT']]);

        if (!$txns) {
            $this->usr->setSessMsg('No transaction between selected dates. Try a different date range', 'error', 'customers/customersstatement/' . $cc['credit_type_id']);
        }

        $data = ['txns' => $txns, 'cc' => $cc, 'customer' => $this->customer];

        $html = $this->load->view('export/view_export_customer_statement', $data, true); // render the view into HTML


        $this->load->library('pdf');

        $pdf = $this->pdf->load('c', 'A4');

        $pdf->SetFooter('Powered By Petronite|{PAGENO}|www.petronite.com'); // Add a footer for good measure ;)

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->Output();
        return;
    }

    public function customerPayments() {

        // Check user status
        $this->checkStatus(1, 1, 1);

        $credit_customers = $this->cust->getStationCustomers($this->admin_id);

        $data = [
            'menu' => 'menu/view_stations_menu', // View for menu
            'content' => 'contents/customers_suppliers/view_customer_payments', // View for contnet
            'menu_data' => ['curr_menu' => 'CUSTOMERS', 'curr_sub_menu' => 'CUSTOMERS'], //Inorder to collapse  menu items
            'content_data' => [//Contents data pass here
                'module_name' => 'Customer Payments',
                'customer' => $this->customer,
                'credit_customers' => $credit_customers
            ],
            'modals_data' => [
                'modals' => ['modal_add_payment'],
                'credit_customers' => $credit_customers,
                'pay_methods' => ['MPESA', 'CASH', 'BANK', 'CHEQUE'],
                'pay_points' => $this->stn->getUserStations($this->usr->user_id, $this->usr->admin_id)
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }

    public function submitCustomerPayment() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $validations = [
                ['field' => 'add_payment_form_error', 'label' => 'Form', 'rules' => 'callback_validateAddPaymentForm'],
                ['field' => 'pay_date', 'label' => 'Payment Date', 'rules' => 'trim|required'],
                ['field' => 'pay_customer', 'label' => 'Customer', 'rules' => 'trim|required|callback_validatePaymentCustomer'],
                ['field' => 'pay_method', 'label' => 'Payment Method', 'rules' => 'trim|required|callback_validatePaymentMethod'],
                ['field' => 'pay_amount', 'label' => 'Amount Paid', 'rules' => 'trim|required|numeric'],
                ['field' => 'pay_reference', 'label' => 'Payment Reference', 'rules' => 'trim|callback_validatePaymentReference'],
                ['field' => 'pay_notes', 'label' => 'Payment Notes', 'rules' => 'trim'],
                ['field' => 'pay_point', 'label' => 'Payment Point', 'rules' => 'trim|required|callback_validatePayPoint']
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
            $customer_id = $this->input->post('pay_customer');
            $amount = $this->input->post('pay_amount');
            $pay_date = $this->input->post('pay_date');


            $customer = $this->cust->getCreditCustomers(['credit_type_id' => $customer_id, 'credit_type_admin_id' => $this->usr->admin_id], NULL, 1);

            if (!$customer) {
                cus_json_error("Credit customer was not found or may have been removed from the system");
            }

            $balance_after = $customer['credit_type_balance'] - $amount;

            $txn_data = [
                'txn_credit' => $amount,
                'txn_type' => 'CREDIT_PAYMENT',
                'txn_acc_ref' => $customer['credit_type_id'],
                'txn_debit' => 0,
                'txn_user_id' => $this->usr->user_id,
                'txn_balance_before' => $customer['credit_type_balance'],
                'txn_balance_after' => $balance_after,
                'txn_admin_id' => $this->usr->admin_id,
                'txn_notes' => $this->input->post('pay_notes'),
                'txn_method' => $this->input->post('pay_method'),
                'txn_reference_no' => $this->input->post('pay_reference'),
                'txn_date' => date('Y-m-d', strtotime($pay_date)),
                'txn_station_id' => $this->input->post('pay_point')
            ];

            $credit_data = ['credit_type_balance' => $balance_after];

            $res = $this->cust->saveCreditPayment(['credit_data' => $credit_data, 'customer' => $customer, 'txn_data' => $txn_data]);

            if ($res) {
                $this->setSessMsg('Credit payment saved successfully', 'success');

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('customers/customerpayments')
                    ]
                ]);

                die();
            } else {
                cus_json_error('Unable to add credit payment, please refresh the page and try again.');
            }
        }
    }

    public function validatePayPoint($pay_point) {

        if ($pay_point == '0') {
            return TRUE;
        }

        $stations = $this->stn->getUserStations($this->usr->user_id, $this->usr->admin_id);

        if (!$stations) {
            $this->form_validation->set_message('validatePayPoint', 'Select a valid pay poin');
            return FALSE;
        }

        $station_ids = array_column($stations, 'station_id');

        if (!in_array($pay_point, $station_ids)) {
            $this->form_validation->set_message('validatePayPoint', 'Select a valid pay poin');
            return FALSE;
        }

        return TRUE;
    }

    public function validateAddPaymentForm() {

        $cust_id = $this->input->post('pay_customer');
        $pay_date = $this->input->post('pay_date');

        $txn = $this->txn->getTransactions(['txn_id'], "(txn_timestamp BETWEEN DATE_SUB(NOW() , INTERVAL 2 MINUTE) AND NOW()) AND txn_acc_ref ='" . $cust_id . "' AND txn_date = '" . date('Y-m-d', strtotime($pay_date)) . "' ", 1, NULL);

        if ($txn) {
            $this->form_validation->set_message('validateAddPaymentForm', 'The record might have been submitted alredy, <a href="' . site_url('customers/customerpayments') . '">Refresh</a> the page to confirm');
            return FALSE;
        }

        return TRUE;
    }

    public function requestEditPetroniteCustomerForm() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $customer_id = $this->uri->segment(3);

        $customer = $this->cust->getPetroniteCustomers(NULL, ['pc_id' => $customer_id], 1);

        if (!$customer) {
            cus_json_error('Customer was not found or may have been removed form the system');
        }

        $admin = $this->usr->getUserInfo($customer['pc_admin_id'], 'ID');

        if (!$admin) {
            cus_json_error("Admin for " . $customer['pc_name'] . " was not found or may have been removed form the system");
        }

        $data = [
            'customer_data' => $customer,
            'admin_data' => $admin
        ];

        echo json_encode([
            'status' => [
                'error' => FALSE,
                'redirect' => FALSE,
                'pop_form' => TRUE,
                'form_type' => 'editPetroniteCustomer',
                'form_url' => site_url('customers/submitEditPetroniteCustomers/' . $customer['pc_id']),
                'form_data' => $data
            ]
        ]);
    }

    public function submitAddPetroniteCustomer() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $validations = [
                ['field' => 'company_name', 'label' => 'Company Name', 'rules' => 'trim|required|is_unique[' . $this->db->dbprefix . 'petronite_customers.pc_name]'],
                ['field' => 'company_slogan', 'label' => 'Company Slogan', 'rules' => 'trim'],
                ['field' => 'company_tin', 'label' => 'Company TIN', 'rules' => 'trim|required|is_unique[' . $this->db->dbprefix . 'petronite_customers.pc_tin_number]'],
                ['field' => 'company_vrn', 'label' => 'Company VRN', 'rules' => 'trim|is_unique[' . $this->db->dbprefix . 'petronite_customers.pc_vrn]'],
                ['field' => 'company_contact_text', 'label' => 'Company Contact text', 'rules' => 'trim|required'],
                ['field' => 'admin_full_name', 'label' => 'Admin Fullname', 'rules' => 'trim|required'],
                ['field' => 'admin_user_name', 'label' => 'Admin User Name', 'rules' => 'trim|required|is_unique[' . $this->db->dbprefix . 'users.user_name]'],
                ['field' => 'admin_phone', 'label' => 'Admin Phone Number', 'rules' => 'trim|required'],
                ['field' => 'admin_email', 'label' => 'Admin Email', 'rules' => 'trim'],
                ['field' => 'admin_address', 'label' => 'Admin Address', 'rules' => 'trim'],
                ['field' => 'file', 'label' => 'Company Banner', 'rules' => 'trim|callback_validateCompanyBanner']
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


            $temp_file = $this->utl->getTempFiles(NULL, ['temp_file_user_id' => $this->usr->user_id, 'temp_file_type' => 'COMPANY_BANNER'], 1);

            if (!$temp_file) {
                cus_json_error('You should attach company banner');
            }

            $customer_data = [
                'pc_name' => $this->input->post('company_name'),
                'pc_contact_text' => $this->input->post('company_contact_text'),
                'pc_slogan' => $this->input->post('company_slogan'),
                'pc_tin_number' => $this->input->post('company_tin'),
                'pc_vrn' => $this->input->post('company_vrn'),
                'pc_logo' => $temp_file['temp_file_name']
            ];

            $admin_data = [
                'user_fullname' => $this->input->post('admin_full_name'),
                'user_name' => $this->input->post('admin_user_name'),
                'user_pwd' => sha1('admin'),
                'user_phone' => $this->input->post('admin_phone'),
                'user_email' => $this->input->post('admin_email'),
                'user_address' => $this->input->post('admin_address'),
                'user_active' => 1,
                'user_role' => 'admin'
            ];

            $res = $this->cust->savePetroniteCustomer(['customer_data' => $customer_data, 'admin_data' => $admin_data, 'temp_file' => $temp_file]);

            if ($res) {

                $this->setSessMsg('Petronite customer added successfully', 'success');

                $location = './uploads/company_banners/';
                $og_file = './uploads/temp/' . $temp_file['temp_file_name'];
                $file = $location . $temp_file['temp_file_name'];
                // Create folder if no exist
                if (!file_exists($location)) {
                    mkdir($location, 0777, true);
                }

                // Move file to a new folder
                if (file_exists($og_file)) {
                    rename($og_file, $file);
                }
                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('developer/customers')
                    ]
                ]);

                die();
            } else {
                cus_json_error('Unable to add petronite customer, please refresh the page and try again.');
            }
        }
    }

    public function submitEditPetroniteCustomers() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $customer_id = $this->uri->segment(3);
        $customer = $this->cust->getPetroniteCustomers(NULL, ['pc_id' => $customer_id], 1);

        if (!$customer) {
            cus_json_error("Customer was not found or may have been removed from the system");
        }

        $validations = [
                ['field' => 'edit_company_name', 'label' => 'Company Name', 'rules' => 'trim|required|callback_validateEditPCName'],
                ['field' => 'edit_company_slogan', 'label' => 'Company Slogan', 'rules' => 'trim'],
                ['field' => 'edit_company_tin', 'label' => 'Company TIN', 'rules' => 'trim|required|callback_validateEditPCTin'],
                ['field' => 'edit_company_vrn', 'label' => 'Company VRN', 'rules' => 'trim|callback_validateEditPCVrn'],
                ['field' => 'edit_company_contact_text', 'label' => 'Company Contact text', 'rules' => 'trim|required'],
                ['field' => 'edit_admin_full_name', 'label' => 'Admin Fullname', 'rules' => 'trim|required'],
                ['field' => 'edit_admin_phone', 'label' => 'Admin Phone Number', 'rules' => 'trim|required'],
                ['field' => 'edit_admin_email', 'label' => 'Admin Email', 'rules' => 'trim'],
                ['field' => 'edit_admin_address', 'label' => 'Admin Address', 'rules' => 'trim'],
                //['field' => 'edit_file', 'label' => 'Company Banner', 'rules' => 'trim|callback_validateEditCompanyBanner']
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

            $customer_data = [
                'pc_name' => $this->input->post('edit_company_name'),
                'pc_contact_text' => $this->input->post('edit_company_contact_text'),
                'pc_slogan' => $this->input->post('edit_company_slogan'),
                'pc_tin_number' => $this->input->post('edit_company_tin'),
                'pc_vrn' => $this->input->post('edit_company_vrn')
            ];

            $temp_file = $this->utl->getTempFiles(NULL, ['temp_file_user_id' => $this->usr->user_id, 'temp_file_type' => 'EDIT_COMPANY_BANNER'], 1);

            if ($temp_file) {
                $customer_data['pc_logo'] = $temp_file['temp_file_name'];
            }

            $admin_data = [
                'user_fullname' => $this->input->post('edit_admin_full_name'),
                'user_phone' => $this->input->post('edit_admin_phone'),
                'user_email' => $this->input->post('edit_admin_email'),
                'user_address' => $this->input->post('edit_admin_address')
            ];

            $res = $this->cust->saveEditPetroniteCustomer(['customer_data' => $customer_data, 'admin_data' => $admin_data, 'temp_file' => $temp_file, 'admin_id' => $customer['pc_admin_id'], 'pc_id' => $customer['pc_id']]);

            if ($res) {

                $this->setSessMsg('Petronite customer edited successfully', 'success');

                if ($temp_file) {

                    $location = './uploads/company_banners/';
                    $og_file = './uploads/temp/' . $temp_file['temp_file_name'];
                    $file = $location . $temp_file['temp_file_name'];
                    // Create folder if no exist
                    if (!file_exists($location)) {
                        mkdir($location, 0777, true);
                    }

                    // Move file to new location 
                    if (file_exists($og_file)) {
                        rename($og_file, $file);
                    }

                    //Delete old file
                    $old_file = $location . $customer['pc_logo'];

                    if (file_exists($old_file) AND ! empty($customer['pc_logo'])) {
                        unlink($old_file);
                    }
                }

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('developer/customers')
                    ]
                ]);

                die();
            } else {
                cus_json_error('Unable to edited petronite customer, please refresh the page and try again.');
            }
        }
    }

    public function validateEditPCName($pc_name) {
        return TRUE;
    }

    public function validateEditPCTin($tin) {
        return TRUE;
    }

    public function validateEditPCVrn($vrn) {
        return TRUE;
    }

    public function validateCompanyBanner() {

        $res = $this->utl->getTempFiles(NULL, ['temp_file_user_id' => $this->usr->user_id, 'temp_file_type' => 'COMPANY_BANNER'], 1);
        if (!$res) {
            $this->form_validation->set_message('validateCompanyBanner', 'You should attach company banner');
            return FALSE;
        }

        return TRUE;
    }

    public function validatePaymentReference($pay_reference) {
        return TRUE;
    }

    public function validatePaymentMethod($payment_method) {
        return TRUE;
    }

    public function validatePaymentCustomer($payment_customer) {
        return TRUE;
    }

    public function validateReportDateRange($param) {
        return TRUE;
    }

}
