<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dailyentries extends CI_Controller {

    // Initialize gloabal variables
    var $user_id = null;
    var $station_id = null;
    var $is_logged_in = false;
    var $customer = null;
    var $admin_id = null;
    var $auto_rtt = 0;

    public function __construct() {
        parent::__construct();

        // Check if user has logged in using session
        if ($this->usr->isLogedin()) {
            $this->user_id = $this->session->userdata['logged_in']['user_id'];
            $this->station_id = $this->session->userdata['logged_in']['user_station_id'];
            $this->admin_id = $this->session->userdata['logged_in']['user_admin_id'];
            $this->auto_rtt = $this->session->userdata['logged_in']['user_station_auto_rtt'];
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
            'content_data' => [//Contents data pass here
                'module_name' => 'Attendant Shifts',
                'customer' => $this->customer,
                'atts' => $atts,
                'date' => $date,
                'next_day' => date('Y-m-d', strtotime('+1 day', strtotime($date))),
                'prev_day' => date('Y-m-d', strtotime('-1 day', strtotime($date)))
            ],
            'modals_data' => [
                'modals' => ['modal_add_credit_sale'],
                'customers' => $this->cust->getCreditCustomers(['s.station_id' => $this->station_id])
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }

    public function addCreditSale() {
        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $att_id = $this->uri->segment(3);

        $cols = ['u.user_name', 's.shift_name', 'att.att_id', 'p.pump_name', 'f.fuel_type_generic_name'];
        $att = $this->rpt->getSales(['att_station_id' => $this->station_id], $cols, NULL, $att_id, []);

        if (!$att) {
            cus_json_error('Attendant shift was not found or may have been removed from the system');
        }


        $json = json_encode([
            'status' => ['error' => FALSE, 'redirect' => FALSE, 'pop_form' => TRUE, 'form_type' => 'addCreditSale', 'form_url' => site_url('dailyentries/submitaddcredit/' . $att['att_id'])],
            'att' => $att
        ]);

        echo $json;

        die();
    }

    public function saleDetails() {

        //Check user status
        $this->checkStatus(1, 1, 1);


        // Attendants shifts date
        $att_id = $this->uri->segment(3);


        // Retrieving attendants shifts due to date 
        $cond = ['att.att_station_id' => $this->station_id];

        $sale = $this->rpt->getSales($cond, NULL, NULL, $att_id); // reused this function from report model coz it does the same
        //echo '<pre>';        print_r($sale); die();

        if (!$sale) {
            //Sale details not found so we redirect to attendant shifts
            $this->setSessMsg('Sale details was not found or may have been removed from the system', 'error', 'dailyentries/attendantsshifts');
        }

        $cond = ['cs.customer_sale_att_id' => $sale['att_id']];
        $credit_sales = $this->rpt->getCreditSales($cond);

        //cus_print_r($sale);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/dailyentries/view_sale_details',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Shift Details',
                'customer' => $this->customer,
                'sale' => $sale,
                'credit_sales' => $credit_sales
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

    public function purchaseOrders() {

        //Check user status
        $this->checkStatus(1, 1, 1);


        // Retrieving expenditure shifts due to date 
        $cond = ['po.po_station_id' => $this->station_id];
        $purchase_orders = $this->purchase->getPurchaseOrders($cond); // reused this function from report model coz it does the same
        //cus_print_r($dippings);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/dailyentries/view_purchase_orders',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Purchase Orders',
                'customer' => $this->customer,
                'purchase_orders' => $purchase_orders
            ],
            'modals_data' => [// Modals data
                'modals' => ['modal_add_purchase_order'], // Put array of popup modals which you want them to appear on current page
                'fuel_types_group' => $this->mnt->getFuelTypesGroup(), // Pass data for popup modals here
                'station_depots' => $this->depo->getDepots(['depo.depo_admin_id' => $this->admin_id]) // Get station depots for creating purchase order
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

    public function submitCreateOrder() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $validations = [
                ['field' => 'order_date', 'label' => 'Order Date', 'rules' => 'trim|required|callback_validateOrderDate', 'errors' => ['required' => 'Select the order date.']],
                ['field' => 'order_number', 'label' => 'Order Number', 'rules' => 'trim|required|callback_validateOrderNumber'],
                ['field' => 'po_depo_id', 'label' => 'Depo', 'rules' => 'trim|required'],
                ['field' => 'volume_ordered', 'label' => 'Volume ordered', 'rules' => 'trim|required|numeric'],
                ['field' => 'truck_number', 'label' => 'Truck Number', 'rules' => 'trim|required'],
                ['field' => 'driver_name', 'label' => 'Driver Name', 'rules' => 'trim|required'],
                ['field' => 'driver_license', 'label' => 'Driver License', 'rules' => 'trim|required'],
                ['field' => 'po_vessel_id', 'label' => 'Vessel', 'rules' => 'trim|required'],
                ['field' => 'loading_date', 'label' => 'Loading Date', 'rules' => 'trim|required'],
                ['field' => 'release_inst_number', 'label' => 'Release Instruction Number', 'rules' => 'trim|required'],
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

            $vessel_id = $this->input->post('po_vessel_id');
            $vessel = $this->depo->getStockVessels(['v.vessel_id' => $vessel_id], 1);

            if (!$vessel) {
                cus_json_error('Vessel details can not be found');
            }

            $order_data = [
                'po_date' => date('Y-m-d', strtotime($this->input->post('order_date'))),
                'po_number' => $this->input->post('order_number'),
                'po_depo_id' => $this->input->post('po_depo_id'),
                'po_station_id' => $this->station_id,
                'po_user_id' => $this->user_id,
                'po_truck_number' => $this->input->post('truck_number'),
                'po_volume' => $this->input->post('volume_ordered'),
                'po_driver_name' => $this->input->post('driver_name'),
                'po_status' => 'UNRELEASED',
                'po_vessel_id' => $vessel['vessel_id'],
                'po_fuel_type_group_id' => $vessel['vessel_fuel_type_group_id'],
                'po_release_instr_no' => $this->input->post('release_inst_number'),
                'po_loading_date' => date('Y-m-d', strtotime($this->input->post('order_date'))),
                'po_driver_license' => $this->input->post('driver_license'),
            ];

            $res = $this->purchase->savePurchaseOrder(['order_data' => $order_data]);

            if ($res) {
                $this->setSessMsg('Order created succesffuly', 'success');

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('dailyentries/purchaseorders')
                    ]
                ]);

                die();
            } else {
                cus_json_error('Unable to create new order please refresh the page and try again.');
            }
        }
    }

    public function submitAddCredit() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $att_id = $this->uri->segment(3);

        $att = $this->rpt->getSales(['att.att_station_id' => $this->station_id], ['att.att_id', 'att.att_sale_price_per_ltr','f.fuel_type_generic_name'], NULL, $att_id, []);

        if (!$att) {
            cus_json_error('Attendant shift was not found or it may have been removed');
        }

        $validations = [
            //['field' => 'order_date', 'label' => 'Order Date', 'rules' => 'trim|required|callback_validateOrderDate', 'errors' => ['required' => 'Select the order date.']],
                ['field' => 'cr_del_no', 'label' => 'Delivery Note Number', 'rules' => 'trim'],
                ['field' => 'cr_order_no', 'label' => 'Order Number', 'rules' => 'trim'],
                ['field' => 'cr_customer', 'label' => 'Customer', 'rules' => 'trim|required|callback_validateCreditCustomer'],
                ['field' => 'cr_truck_no', 'label' => 'Truck Number', 'rules' => 'trim'],
                ['field' => 'cr_qty', 'label' => 'Quantity sold', 'rules' => 'trim|required|numeric'],
                ['field' => 'cr_notes', 'label' => 'Credit Notes', 'rules' => 'trim']
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

            $customer_id = $this->input->post('cr_customer');
            $ltrs = $this->input->post('cr_qty');
            $rtt = 0;
            $tts = 0;

            $credit = $this->cust->getCreditCustomers(['crdt.credit_type_id' => $customer_id, 'crdt.credit_type_admin_id' => $this->admin_id], NULL, 1);

            if (!$credit) {
                cus_json_error('Customer was not found or may have been removed from the sysytem');
            }
            
            if($credit['credit_type_type_description'] == 'STATION'){
                $tts = 1;
            }
            
            if($credit['credit_type_allow_rtt'] == '1' OR $this->auto_rtt == '1'){
                $rtt = 1;
            }
            
            $sale_price = $att['att_sale_price_per_ltr'];
            $amount = $ltrs * $sale_price;
            $balance_after = $credit['credit_type_balance'] + ($amount);

            $credit_data = [
                'customer_sale_customer_id' => 1,
                'customer_sale_att_id' => $att['att_id'],
                'customer_sale_ltrs' => $ltrs,
                'customer_sale_credit_type_id'=> $credit['credit_type_id'],
                'customer_sale_added_by' => $this->user_id,
                'customer_sale_credit_number' => time(),
                'customer_sale_order_number' => $this->input->post('cr_order_no'),
                'customer_sale_track_number' => $this->input->post('cr_truck_no'),
                'customer_sale_del_no' => $this->input->post('cr_del_no'),
                'customer_sale_balance_before' => $credit['credit_type_balance'],
                'customer_sale_balance_after' => $balance_after,
                'customer_sale_rtt' => $rtt,
                'customer_sale_tts' => $tts,
                'customer_sale_price' => $sale_price,
                'customer_sale_notes' => $this->input->post('cr_notes')
            ];
            
            $notes = "Fuel Purchase. ". $ltrs . ' ltr(s) of '. $att['fuel_type_generic_name'] . ' @'. cus_price_form($sale_price);
            
            $res = $this->cust->saveCreditSale(['credit_data' => $credit_data,'amount' => $amount,'admin_id' => $this->admin_id,'notes' => $notes]);

            if ($res) {
                $this->setSessMsg('Credit sale save successfully', 'success');

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('dailyentries/saledetails/'. $att['att_id'])
                    ]
                ]);

                die();
            } else {
                cus_json_error('Unable to add credit sale, please refresh the page and try again.');
            }
        }
    }

    public function releaseOrder() {

        $this->checkStatus();

        $order_id = $this->uri->segment(3);

        $po = $this->purchase->getPurchaseOrders(['po.po_id' => $order_id], 1);

        if (!$po) {
            $this->setSessMsg('Purchase order was not found or it may have been removed from the system', 'error', 'dailyentries/purchaseorders');
        }

        if ($this->purchase->updatePurchaseOrder(['po_status' => 'RELEASED'], ['po_id' => $po['po_id']])) {
            $this->setSessMsg('Purchase order updated successfully', 'success', 'dailyentries/purchaseorders');
        } else {
            $this->setSessMsg('Something went wrong, Purchase order was not updates', 'warning', 'dailyentries/purchaseorders');
        }
    }

    public function validateOrderDate($order_date) {
        return TRUE;
    }

    public function validateOrderNumber($order_number) {
        return TRUE;
    }

    public function validateCreditCustomer($customer_id) {

        $credit = $this->cust->getCreditCustomers(['crdt.credit_type_id' => $customer_id, 'crdt.credit_type_admin_id' => $this->admin_id], NULL, 1);

        if (!$credit AND ! empty($customer_id)) {
            $this->form_validation->set_message('validateCreditCustomer', 'Select a valid customer');
            return FALSE;
        }

        return TRUE;
    }

}
