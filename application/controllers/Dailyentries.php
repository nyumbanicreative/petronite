<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dailyentries extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function attendantsShifts() {

        $this->usr->checkStatus(1, 1, 1);

        // Get latest Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_att = $this->att->getLatestAtt($this->usr->station_id);
            if ($latest_att) {
                $date = $latest_att['att_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving attendants shifts due to date 
        $cond = ['att.att_station_id' => $this->usr->station_id, 'att.att_date' => $date];
        $order_by = 's.shift_sequence ASC, u.user_name ASC, p.pump_name ASC, f.fuel_type_generic_name ASC';
        $atts = $this->rpt->getSales($cond, null, $order_by); // reused this function from report model coz it does the same
        //cus_print_r($atts);        die();
        // Creating view data

        $opened_pumps = $this->rpt->getSales(['att.att_station_id' => $this->usr->station_id, 'att_shift_status' => 'Opened'], ['att.att_pump_id'], NULL);

        if ($opened_pumps) {
            $opened_pumps = array_column($opened_pumps, 'att_pump_id');
        } else {
            $opened_pumps = [];
        }

        $data = [
            'menu' => 'menu/view_sys_menu', // View for menu
            'content' => 'contents/dailyentries/view_attendants_shifts', // View for contnet
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'], //Inorder to collapse  menu items
            'content_data' => [//Contents data pass here
                'module_name' => 'Attendant Shifts',
                'customer' => $this->usr->customer,
                'atts' => $atts,
                'date' => $date,
                'next_day' => date('Y-m-d', strtotime('+1 day', strtotime($date))),
                'prev_day' => date('Y-m-d', strtotime('-1 day', strtotime($date))),
                'attendants' => $this->mnt->getStationAttendants($this->usr->station_id),
                'pumps' => $this->mnt->getPumps($this->usr->station_id),
                'shifts' => $this->mnt->getShifts($this->usr->station_id),
                'opened_pumps' => $opened_pumps
            ],
            'modals_data' => [
                'modals' => ['modal_add_credit_sale', 'modal_close_att_shift'],
                'customers' => $this->cust->getCreditCustomers(['s.station_id' => $this->usr->station_id]),
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

        $this->usr->checkStatusJson(1, 1, 1);

        $att_id = $this->uri->segment(3);

        $cols = ['u.user_name', 's.shift_name', 'att.att_id', 'p.pump_name', 'f.fuel_type_generic_name'];
        $att = $this->rpt->getSales(['att_station_id' => $this->usr->station_id], $cols, NULL, $att_id, []);

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
        $this->usr->checkStatus(1, 1, 1);


        // Attendants shifts date
        $att_id = $this->uri->segment(3);


        // Retrieving attendants shifts due to date 
        $cond = ['att.att_station_id' => $this->usr->station_id];

        $sale = $this->rpt->getSales($cond, NULL, NULL, $att_id); // reused this function from report model coz it does the same
        //echo '<pre>';        print_r($sale); die();

        if (!$sale) {
            //Sale details not found so we redirect to attendant shifts
            $this->usr->setSessMsg('Sale details was not found or may have been removed from the system', 'error', 'dailyentries/attendantsshifts');
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
                'customer' => $this->usr->customer,
                'sale' => $sale,
                'credit_sales' => $credit_sales
            ],
            'modals_data' => [
                'modals' => ['modal_add_credit_sale'],
                'user_system_role' => $this->usr->user_system_role,
                'customers' => $this->cust->getCreditCustomers(['s.station_id' => $this->usr->station_id])
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function creditSales() {

        //Check user status
        $this->usr->checkStatus(1, 1, 1);

        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_att = $this->att->getLatestAtt($this->usr->station_id);
            if ($latest_att) {
                $date = $latest_att['att_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving attendants shifts due to date 
        $cond = ['att.att_station_id' => $this->usr->station_id, 'att.att_date' => $date, 'cs.customer_sale_tts' => '0'];
        $credit_sales = $this->rpt->getCreditSales($cond); // reused this function from report model coz it does the same
        //cus_print_r($atts);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/dailyentries/view_credit_sales',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Credit Sales',
                'customer' => $this->usr->customer,
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

    public function attendantsCollections() {

        //Check user status
        $this->usr->checkStatus(1, 1, 1);

        // Attendants shifts date
        $date = $this->input->get('date');

        if (empty($date)) {
            $latest_att = $this->att->getLatestAtt($this->usr->station_id);
            if ($latest_att) {
                $date = $latest_att['att_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving attendants shifts due to date 
        $cond = ['att.att_station_id' => $this->usr->station_id, 'att.att_date' => $date];
        $attendant_collections = $this->att->getAttendantCollection(NULL, $cond); // reused this function from report model coz it does the same
        //echo '<pre>'; cus_print_r($attendant_collections);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/dailyentries/view_attendants_collection',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Attendants Collection',
                'customer' => $this->usr->customer,
                'attendant_collections' => $attendant_collections,
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

    public function submitAddCollection() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->usr->checkStatusJson(1, 1, 1);

        $date = $this->input->get('date');
        $attendant = $this->input->get('attendant');
        $shift = $this->input->get('shift');

        $collection = $this->att->getAttendantCollection(NULL, ['att.att_date' => $date, 'att.att_shift_id' => $shift, 'att.att_employee_id' => $attendant, 'att.att_station_id' => $this->usr->station_id], 1, NULL);


        if (!$collection) {
            cus_json_error('Shift details was not found or may have been removed from the system');
        }

        if (!empty($collection['attc_id'])) {
            cus_json_error('Collection is already completed for this shift. Only editing is allowed');
        }

        $validations = [
                ['field' => 'addc_amount_collected', 'label' => 'Amount collected', 'rules' => 'trim|required|numeric'],
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

            $amount_collected = $this->input->post('addc_amount_collected');
            $cond = ['att.att_date' => $collection['att_date'], 'att_employee_id' => $collection['att_employee_id'], 'att_shift_id' => $collection['att_shift_id'], 'att.att_station_id' => $collection['att_station_id']];
            $cols = ['att.att_id', 'credit_sales', 'return_to_tank', 'transfered_to_station', 'att_sale_price_per_ltr'];

            $atts = $this->att->getAttendances($cond, $cols, NULL, NULL, NULL);

            $collection_data = [
                'attc_attendant_id' => $collection['att_employee_id'],
                'attc_date' => $collection['att_date'],
                'attc_shift_id' => $collection['att_shift_id'],
                'attc_amount' => $amount_collected,
                'attc_user_id' => $this->usr->user_id,
                'attc_station_id' => $this->usr->station_id
            ];

            $res = $this->att->saveAddCollection(['atts' => $atts, 'amount_collected' => $amount_collected, 'collection_data' => $collection_data]);

            if ($res) {
                $this->usr->setSessMsg('Attendant collection added succesffuly', 'success');

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('dailyentries/attendantscollections?date=' . $collection['att_date'])
                    ]
                ]);

                die();
            } else {
                cus_json_error('Something went wrong. Unable to add attendant collection, Contact the system developer.');
            }
        }
    }

    public function submitEditCollection() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->usr->checkStatusJson(1, 1, 1);

        $date = $this->input->get('date');
        $attendant = $this->input->get('attendant');
        $shift = $this->input->get('shift');

        $collection = $this->att->getAttendantCollection(NULL, ['att.att_date' => $date, 'att.att_shift_id' => $shift, 'att.att_employee_id' => $attendant, 'att.att_station_id' => $this->usr->station_id], 1, NULL);


        if (!$collection) {
            cus_json_error('Shift details was not found or may have been removed from the system');
        }

        if (empty($collection['attc_id'])) {
            cus_json_error('Collection not yet done for selected shift. Use add option to add collection');
        }

        $validations = [
                ['field' => 'editc_amount_collected', 'label' => 'Amount collected', 'rules' => 'trim|required|numeric'],
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

            $amount_collected = $this->input->post('editc_amount_collected');
            $cond = ['att.att_date' => $collection['att_date'], 'att_employee_id' => $collection['att_employee_id'], 'att_shift_id' => $collection['att_shift_id'], 'att.att_station_id' => $collection['att_station_id']];
            $cols = ['att.att_id', 'credit_sales', 'return_to_tank', 'transfered_to_station', 'att_sale_price_per_ltr'];

            $atts = $this->att->getAttendances($cond, $cols, NULL, NULL, NULL);

            $collection_data = [
                'attc_amount' => $amount_collected,
                'attc_user_id' => $this->usr->user_id
            ];

            $res = $this->att->saveEditCollection(['atts' => $atts, 'amount_collected' => $amount_collected, 'collection' => $collection, 'collection_data' => $collection_data]);

            if ($res) {
                $this->usr->setSessMsg('Attendant collection edited succesffuly', 'success');

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('dailyentries/attendantscollections?date=' . $collection['att_date'])
                    ]
                ]);

                die();
            } else {
                cus_json_error('Something went wrong. Unable to edit attendant collection, Contact the system developer.');
            }
        }
    }

    public function expenditure() {

        //Check user status
        $this->usr->checkStatus(1, 1, 1);


        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_date = $this->exps->getLatestExpenditureDate($this->usr->station_id);
            if ($latest_date) {
                $date = $latest_date['general_expenditure_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving expenditure shifts due to date 
        $cond = ['ge.general_expenditure_station_id' => $this->usr->station_id, 'ge.general_expenditure_date' => $date];
        $expenditures = $this->rpt->getGeneralExpenditures($cond); // reused this function from report model coz it does the same
        //cus_print_r($credit_sales);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/dailyentries/view_general_expenditure',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'General Expenditure <span class="module-date">&nbsp;&nbsp;(' . cus_nice_date($date) . ')</span> ',
                'customer' => $this->usr->customer,
                'expenditures' => $expenditures,
                'expenditure_dates' => $this->exps->getAllExpenditureDates($this->usr->station_id),
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
        $this->usr->checkStatus(1, 1, 1);


        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_date = $this->dipping->getLatestDipping($this->usr->station_id);
            if ($latest_date) {
                $date = $latest_date['inventory_traking_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving expenditure shifts due to date 
        $cond = ['tr.inventory_traking_station_id' => $this->usr->station_id, 'tr.inventory_traking_date' => $date];
        $dippings = $this->dipping->getDippings($cond); // reused this function from report model coz it does the same
        //cus_print_r($dippings);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/dailyentries/view_dippings',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Dipping <span class="module-date">&nbsp;&nbsp;(' . cus_nice_date($date) . ')</span> ',
                'customer' => $this->usr->customer,
                'dippings' => $dippings,
                'fuel_types' => $this->mnt->getFuelTypes($this->usr->station_id),
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
        $this->usr->checkStatus(1, 1, 1);


        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_date = $this->purchase->getLatestPurchaseDate($this->usr->station_id);
            if ($latest_date) {
                $date = $latest_date['inventory_purchase_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving expenditure shifts due to date 
        $cond = ['pur.inventory_purchase_station_id' => $this->usr->station_id, 'pur.inventory_purchase_date' => $date];
        $purchases = $this->purchase->getPurchases($cond); // reused this function from report model coz it does the same
        //cus_print_r($dippings);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/dailyentries/view_purchases',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Purchases <span class="module-date">&nbsp;&nbsp;(' . cus_nice_date($date) . ')</span> ',
                'customer' => $this->usr->customer,
                'purchases' => $purchases,
                'fuel_types' => $this->mnt->getFuelTypes($this->usr->station_id),
                'purchase_dates' => $this->purchase->getAllPurchaseDates($this->usr->station_id),
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
        $this->usr->checkStatus(1, 1, 1);


        // Retrieving expenditure shifts due to date 
        $cond = ['po.po_station_id' => $this->usr->station_id];
        $purchase_orders = $this->purchase->getPurchaseOrders($cond); // reused this function from report model coz it does the same
        //cus_print_r($dippings);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/dailyentries/view_purchase_orders',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Purchase Orders',
                'customer' => $this->usr->customer,
                'purchase_orders' => $purchase_orders
            ],
            'modals_data' => [// Modals data
                'modals' => ['modal_add_purchase_order'], // Put array of popup modals which you want them to appear on current page
                'fuel_types_group' => $this->mnt->getFuelTypesGroup(), // Pass data for popup modals here
                'station_depots' => $this->depo->getDepots(['depo.depo_admin_id' => $this->usr->admin_id]) // Get station depots for creating purchase order
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function stocktransfer() {

        //Check user status
        $this->usr->checkStatus(1, 1, 1);


        // Attendants shifts date
        $date = $this->input->get('date');
        if (empty($date)) {
            $latest_att = $this->att->getLatestAtt($this->usr->station_id);
            if ($latest_att) {
                $date = $latest_att['att_date'];
            } else {
                $date = date('Y-m-d');
            }
        }

        // Retrieving attendants shifts due to date 
        $cond = ['att.att_station_id' => $this->usr->station_id, 'att.att_date' => $date, 'cs.customer_sale_tts' => '1'];
        $credit_sales = $this->rpt->getCreditSales($cond); // reused this function from report model coz it does the same
        //cus_print_r($atts);        die();

        $data = [
            'menu' => 'menu/view_sys_menu',
            'content' => 'contents/dailyentries/view_stock_transfer',
            'menu_data' => ['curr_menu' => 'DAILY', 'curr_sub_menu' => 'DAILY'],
            'content_data' => [
                'module_name' => 'Stock Transfer <span class="module-date">&nbsp;&nbsp;(' . cus_nice_date($date) . ')</span> ',
                'customer' => $this->usr->customer,
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

        $this->usr->checkStatusJson(1, 1, 1);

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
                'po_station_id' => $this->usr->station_id,
                'po_user_id' => $this->usr->user_id,
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
                $this->usr->setSessMsg('Order created succesffuly', 'success');

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

        $this->usr->checkStatusJson(1, 1, 1);

        $att_id = $this->uri->segment(3);

        $att = $this->rpt->getSales(['att.att_station_id' => $this->usr->station_id], ['att.att_id', 'att.att_sale_price_per_ltr', 'f.fuel_type_generic_name'], NULL, $att_id, []);

        if (!$att) {
            cus_json_error('Attendant shift was not found or it may have been removed');
        }

        $validations = [
            //['field' => 'order_date', 'label' => 'Order Date', 'rules' => 'trim|required|callback_validateOrderDate', 'errors' => ['required' => 'Select the order date.']],
                ['field' => 'add_credit_form', 'label' => 'From Error', 'rules' => 'trim|callback_validateAddCreditForm'],
                ['field' => 'cr_del_no', 'label' => 'Delivery Note Number', 'rules' => 'trim'],
                ['field' => 'cr_order_no', 'label' => 'Order Number', 'rules' => 'trim'],
                ['field' => 'cr_customer', 'label' => 'Customer', 'rules' => 'trim|required|callback_validateCreditCustomer'],
                ['field' => 'cr_truck_no', 'label' => 'Truck Number', 'rules' => 'trim'],
                ['field' => 'cr_qty', 'label' => 'Quantity sold', 'rules' => 'trim|required|numeric|callback_validateCrQtySold'],
                ['field' => 'cr_notes', 'label' => 'Credit Notes', 'rules' => 'trim'],
                ['field' => 'cr_driver_name', 'label' => 'Driver Name', 'rules' => 'trim|callback_validateDriverName'],
                ['field' => 'cr_delivery_point', 'label' => 'Delivery Point', 'rules' => 'trim|callback_validateDeliveryPoint']
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

            $credit = $this->cust->getCreditCustomers(['crdt.credit_type_id' => $customer_id, 'crdt.credit_type_admin_id' => $this->usr->admin_id], NULL, 1);

            if (!$credit) {
                cus_json_error('Customer was not found or may have been removed from the sysytem');
            }

            if ($credit['credit_type_type_description'] == 'STATION') {
                $tts = 1;
            }

            if ($credit['credit_type_allow_rtt'] == '1' OR $this->usr->auto_rtt == '1') {
                $rtt = 1;
            }

            $sale_price = $att['att_sale_price_per_ltr'];
            $amount = $ltrs * $sale_price;
            $balance_after = $credit['credit_type_balance'] + ($amount);

            $credit_data = [
                'customer_sale_customer_id' => 1,
                'customer_sale_att_id' => $att['att_id'],
                'customer_sale_ltrs' => $ltrs,
                'customer_sale_credit_type_id' => $credit['credit_type_id'],
                'customer_sale_added_by' => $this->usr->user_id,
                'customer_sale_credit_number' => time(),
                'customer_sale_order_number' => $this->input->post('cr_order_no'),
                'customer_sale_track_number' => $this->input->post('cr_truck_no'),
                'customer_sale_del_no' => $this->input->post('cr_del_no'),
                'customer_sale_balance_before' => $credit['credit_type_balance'],
                'customer_sale_balance_after' => $balance_after,
                'customer_sale_rtt' => $rtt,
                'customer_sale_tts' => $tts,
                'customer_sale_price' => $sale_price,
                'customer_sale_notes' => $this->input->post('cr_notes'),
                'customer_sale_driver_name' => $this->input->post('cr_driver_name'),
                'customer_sale_delivery_point' => $this->input->post('cr_delivery_point')
            ];

            $notes = "Fuel Purchase. " . $ltrs . ' ltr(s) of ' . $att['fuel_type_generic_name'] . ' @' . cus_price_form($sale_price);

            $res = $this->cust->saveCreditSale(['credit_data' => $credit_data, 'amount' => $amount, 'admin_id' => $this->usr->admin_id, 'notes' => $notes, 'new_credit_sale' => $this->usr->station_new_credit_sales]);

            if ($res) {
                $this->usr->setSessMsg('Credit sale saved successfully', 'success');

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('dailyentries/saledetails/' . $att['att_id'])
                    ]
                ]);

                die();
            } else {
                cus_json_error('Unable to add credit sale, please refresh the page and try again.');
            }
        }
    }

    public function submitAssignShift() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->usr->checkStatusJson(1, 1, 1);


        $validations = [
            //['field' => 'order_date', 'label' => 'Order Date', 'rules' => 'trim|required|callback_validateOrderDate', 'errors' => ['required' => 'Select the order date.']],
                ['field' => 'as_attendant', 'label' => 'Attendant', 'rules' => 'trim|required|callback_validateAsAttendant'],
                ['field' => 'as_pump_id', 'label' => 'Pump', 'rules' => 'trim|required|callback_validateAsPumpId'],
                ['field' => 'as_form', 'label' => 'Delivery Point', 'rules' => 'callback_validateAsForm']
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

            $pump_id = $this->input->post('as_pump_id');

            $pump = $this->mnt->getPumps($this->usr->station_id, ['pump_id' => $pump_id], NULL, 1);

            if (!$pump) {
                cus_json_error('Pump was not found or may have been removed from the system');
            }

            // Lets have max and min shift sequences
            $min_shift = $this->mnt->getShifts($this->usr->station_id, NULL, NULL, 1, NULL, [['col' => 'shift_sequence', 'sort' => 'ASC']]);
            $max_shift = $this->mnt->getShifts($this->usr->station_id, NULL, NULL, 1, NULL, [['col' => 'shift_sequence', 'sort' => 'DESC']]);

            // Get last shift for selected pump
            $last_pump_shift = $this->att->getAttendances(['att.att_pump_id' => $pump['pump_id'], 'att.att_station_id' => $this->usr->station_id], ['att.att_date', 's.shift_sequence'], 1, NULL, [['col' => 'att.att_date', 'sort' => 'DESC'], ['col' => 's.shift_sequence', 'sort' => 'DESC']]);

            // Check if we have it
            if ($last_pump_shift) {

                // If we have it lets check if next shift is latest
                if (((int) $last_pump_shift['shift_sequence'] + 1) > $max_shift['shift_sequence']) {

                    $next_shift_date = date('Y-m-d', strtotime('+1 day', strtotime($last_pump_shift['att_date'])));
                    $next_shift_id = $min_shift['shift_id'];
                } else {

                    $next_shift_date = $last_pump_shift['att_date'];
                    $next_shift = $this->mnt->getShifts($this->usr->station_id, ['shift_sequence' => ((int) $last_pump_shift['shift_sequence'] + 1)], NULL, 1, NULL, NULL);

                    if ($next_shift) {
                        $next_shift_id = $next_shift['shift_id'];
                    } else {
                        $next_shift_date = date('Y-m-d', strtotime('+1 day', strtotime($last_pump_shift['att_date'])));
                        $next_shift_id = $min_shift['shift_id'];
                    }
                }
            } else {

                $next_shift_id = $min_shift['shift_id'];
                $next_shift_date = $this->usr->station_first_day;
            }

            $att_data = [
                'att_date' => $next_shift_date,
                'att_shift_id' => $next_shift_id,
                'att_op_mtr_reading' => $pump['pump_curr_mtr_rdngs'],
                'att_clo_mtr_reading' => 0,
                'att_employee_id' => $this->input->post('as_attendant'),
                'att_shift_status' => 'Opened',
                'att_pump_id' => $pump['pump_id'],
                'att_sale_price_per_ltr' => $pump['fuel_type_curr_price_per_ltr'],
                'att_station_id' => $this->usr->station_id,
                'att_amount_banked' => 0
            ];

            $res = $this->att->saveAssignShift(['att_data' => $att_data]);

            if ($res) {

                $this->usr->setSessMsg('Pump ' . $pump['pump_name'] . ' assigned to attendant successfully', 'success');

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('dailyentries/attendantsshifts?date=' . $next_shift_date)
                    ]
                ]);

                die();
            } else {
                cus_json_error('Something went wrong, system was unable to assign pump to an attendant.');
            }
        }
    }

    public function requestCloseShiftForm() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->usr->checkStatusJson(1, 1, 1);

        $att_id = $this->uri->segment(3);

        $cols = ['u.user_name', 'credit_sales', 'return_to_tank', 'transfered_to_station', 's.shift_name', 'att.att_id', 'att.att_op_mtr_reading', 'p.pump_name', 'f.fuel_type_generic_name'];

        $att = $this->att->getAttendances(['att_station_id' => $this->usr->station_id, 'att_id' => $att_id], $cols, 1, NULL, NULL);

        if (!$att) {
            cus_json_error('Attendant shift was not found or may have been removed from the system');
        }


        $json = json_encode([
            'status' => ['error' => FALSE, 'redirect' => FALSE, 'pop_form' => TRUE, 'form_type' => 'closeAttShift', 'form_url' => site_url('dailyentries/submitcloseattshift/' . $att['att_id'])],
            'att' => $att
        ]);

        echo $json;

        die();
    }

    public function requestCloseDipping() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->usr->checkStatusJson(1, 1, 1);

        $dipping_id = $this->uri->segment(3);

        $dipping = $this->dipping->getDippings(['tr.inventory_traking_id' => $dipping_id, 'tr.inventory_traking_station_id' => $this->usr->station_id], 1);

        if (!$dipping) {
            cus_json_error('Dipping details was not found or may have been removed from the system');
        }

        $json = json_encode([
            'status' => ['error' => FALSE, 'redirect' => FALSE, 'pop_form' => TRUE, 'form_type' => 'closeDipping', 'form_url' => site_url('dailyentries/submitclosedipping/' . $dipping['inventory_traking_id'])],
            'dipping' => $dipping
        ]);

        echo $json;

        die();
    }

    public function requestEditDipping() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->usr->checkStatusJson(1, 1, 1);

        $dipping_id = $this->uri->segment(3);

        $dipping = $this->dipping->getDippings(['tr.inventory_traking_id' => $dipping_id, 'tr.inventory_traking_station_id' => $this->usr->station_id], 1);

        if (!$dipping) {
            cus_json_error('Dipping details was not found or may have been removed from the system');
        }

        $json = json_encode([
            'status' => ['error' => FALSE, 'redirect' => FALSE, 'pop_form' => TRUE, 'form_type' => 'editDipping', 'form_url' => site_url('dailyentries/submiteditdipping/' . $dipping['inventory_traking_id'])],
            'dipping' => $dipping
        ]);

        echo $json;

        die();
    }

    public function requestEditCollectionForm() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->usr->checkStatusJson(1, 1, 1);

        $date = $this->input->get('date');
        $attendant = $this->input->get('attendant');
        $shift = $this->input->get('shift');

        $collection = $this->att->getAttendantCollection(NULL, ['att.att_date' => $date, 'att.att_shift_id' => $shift, 'att.att_employee_id' => $attendant, 'att.att_station_id' => $this->usr->station_id], 1, NULL);


        if (!$collection) {
            cus_json_error('Shift details was not found or may have been removed from the system');
        }

        if (empty($collection['attc_id'])) {
            cus_json_error('Collection not yet done for selected shift. Use add option to add collection');
        }


        $json = json_encode([
            'status' => ['error' => FALSE, 'redirect' => FALSE, 'pop_form' => TRUE, 'form_type' => 'editCollection', 'form_url' => site_url('dailyentries/submiteditcollection?date=' . urlencode($collection['att_date']) . '&shift=' . urlencode($collection['att_shift_id']) . '&attendant=' . urlencode($collection['att_employee_id']))],
            'collection' => $collection
        ]);

        echo $json;

        die();
    }

    public function postToLedger() {

        //Check user status
        $this->usr->checkStatus(1, 1, 1);

        $att_id = $this->uri->segment(3);

        $att = $this->rpt->getSales(['att.att_station_id' => $this->usr->station_id], NULL, NULL, $att_id);



        if (!$att) {
            $this->usr->setSessMsg('Details was not found or may have been removed from the system', 'error', 'dailyentries/attendantsshifts');
        }

        if ($this->usr->station_new_credit_sales) {
            $this->usr->setSessMsg('Posting to ledger can not be performed at this momoment. Contact the system developer', 'error', 'dailyentries/saledetails/' . $att['att_id'] . '?url=' . site_url('dailyentries/attendantsshifts?date=') . urlencode($att['att_date']));
        }

        if ($att['att_posted_to_ledger'] == '1') {
            $this->usr->setSessMsg('Sale details were alredy posted to ledger.', 'error', 'dailyentries/saledetails/' . $att['att_id'] . '?url=' . site_url('dailyentries/attendantsshifts?date=') . urlencode($att['att_date']));
        }
        if ($att['att_shift_status'] == 'Opened') {
            $this->usr->setSessMsg('You should close this shift before posting to ledger.', 'error', 'dailyentries/saledetails/' . $att['att_id'] . '?url=' . site_url('dailyentries/attendantsshifts?date=') . urlencode($att['att_date']));
        }

        // get credit sales in this shift

        $credit_sales = $this->rpt->getCreditSales(['cs.customer_sale_att_id' => $att['att_id']], NULL);

        $res = $this->txn->saveShiftToLedger(['att' => $att, 'credit_sales' => $credit_sales, 'user_id' => $this->usr->user_id, 'admin_id' => $this->usr->admin_id]);

        if ($res) {
            $this->usr->setSessMsg('Sale details posted to ledger successfully', 'success', 'dailyentries/saledetails/' . $att['att_id'] . '?url=' . site_url('dailyentries/attendantsshifts?date=') . urlencode($att['att_date']));
        } else {
            $this->usr->setSessMsg('Something went wrong. Sale details was not posted to ledger', 'error', 'dailyentries/saledetails/' . $att['att_id'] . '?url=' . site_url('dailyentries/attendantsshifts?date=') . urlencode($att['att_date']));
        }
    }

    public function submitCloseDipping() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->usr->checkStatusJson(1, 1, 1);

        $dipping_id = $this->uri->segment(3);

        $dipping = $this->dipping->getDippings(['tr.inventory_traking_id' => $dipping_id, 'tr.inventory_traking_station_id' => $this->usr->station_id], 1);

        if (!$dipping) {
            cus_json_error('Dipping details was not found or may have been removed from the system');
        }

        if (strtolower($dipping['inventory_traking_status']) == 'closed') {
            cus_json_error('Dipping is already closed');
        }

        $validations = [
                ['field' => 'cd_closing', 'label' => 'Closing Stock Dipping', 'rules' => 'trim|required|numeric'],
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

            $closing_dipping = $this->input->post('cd_closing');
            $min_shift = $this->mnt->getMinShift($this->usr->station_id);
            $next_shift_date = date('Y-m-d', strtotime($dipping['inventory_traking_date'] . ' +1 day'));
            $next_shift_id = $min_shift['shift_id'];

            // Checks if there is next shift within same day
            $next_shift = $this->mnt->getShifts($this->usr->station_id, ['shift_sequence >' => $dipping['shift_sequence'], 'shift_sequence <' => ($dipping['shift_sequence'] + 2)], NULL, 1);



            // If Yes the change next shift values
            if ($next_shift) {
                $next_shift_date = $dipping['inventory_traking_date'];
                $next_shift_id = $next_shift['shift_id'];
            }

            // Clossing current dipping data
            $close_dipping_data = [
                'inventory_traking_phisical_clo' => $closing_dipping,
                'inventory_traking_status' => 'Closed'
            ];


            // Data for next dipping shift
            $new_dipping_data = [
                'inventory_traking_phisical_op' => $closing_dipping,
                'inventory_traking_phisical_clo' => 0,
                'inventory_traking_date' => $next_shift_date,
                'inventory_traking_status' => 'Opened',
                'inventory_traking_user_id' => $this->usr->user_id,
                'inventory_traking_shift_id' => $next_shift_id,
                'inventory_traking_station_id' => $this->usr->station_id,
                'inventory_traking_fuel_tank_id' => $dipping['inventory_traking_fuel_tank_id']
            ];


            $res = $this->dipping->saveCloseDipping(['close_dipping_data' => $close_dipping_data, 'new_dipping_data' => $new_dipping_data, 'dipping_id' => $dipping['inventory_traking_id']]);

            if ($res) {

                $this->usr->setSessMsg('Dipping was closed successfully', 'success');

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('dailyentries/dipping?date=' . $dipping['inventory_traking_date'])
                    ]
                ]);

                die();
            } else {
                cus_json_error('Something went wrong, dipping was not closed.');
            }
        }
    }

    public function submitEditDipping() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->usr->checkStatusJson(1, 1, 1);

        $dipping_id = $this->uri->segment(3);

        $dipping = $this->dipping->getDippings(['tr.inventory_traking_id' => $dipping_id, 'tr.inventory_traking_station_id' => $this->usr->station_id], 1);

        if (!$dipping) {
            cus_json_error('Dipping details was not found or may have been removed from the system');
        }

        if (strtolower($dipping['inventory_traking_status']) == 'opened') {
            cus_json_error('In-progress dipping can not be edited.');
        }

        $validations = [
                ['field' => 'ed_opening', 'label' => 'Opening Stock Dipping', 'rules' => 'trim|required|numeric'],
                ['field' => 'ed_closing', 'label' => 'Closing Stock Dipping', 'rules' => 'trim|required|numeric'],
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

            $closing_dipping = $this->input->post('ed_closing');
            $opening_dipping = $this->input->post('ed_opening');
            $previous_dipping_data = [];
            $next_dipping_data = [];
            $previous_dipping_id = NULL;
            $next_dipping_id = NULL;

            $min_shift = $this->mnt->getMinShift($this->usr->station_id);
            $max_shift = $this->mnt->getMaxShift($this->usr->station_id);

            $next_shift_date = date('Y-m-d', strtotime($dipping['inventory_traking_date'] . ' +1 day'));
            $next_shift_id = $min_shift['shift_id'];

            $previous_shift_date = date('Y-m-d', strtotime($dipping['inventory_traking_date'] . ' -1 day'));
            $previous_shift_id = $max_shift['shift_id'];


            // Checks if there is next shift sequence and previous shift sequence preaty much in a same day
            $next_shift = $this->mnt->getShifts($this->usr->station_id, ['shift_sequence >' => $dipping['shift_sequence'], 'shift_sequence <' => ($dipping['shift_sequence'] + 2)], NULL, 1);
            $previous_shift = $this->mnt->getShifts($this->usr->station_id, ['shift_sequence <' => $dipping['shift_sequence'], 'shift_sequence >' => ($dipping['shift_sequence'] - 2)], NULL, 1);


            // If Yes the change next shift values
            if ($next_shift) {
                $next_shift_date = $dipping['inventory_traking_date'];
                $next_shift_id = $next_shift['shift_id'];
            }

            // If Yes the change next shift values
            if ($previous_shift) {
                $previous_shift_date = $dipping['inventory_traking_date'];
                $previous_shift_id = $previous_shift['shift_id'];
            }

            $previous_dipping = $this->dipping->getDippings([
                'inventory_traking_date' => $previous_shift_date,
                'inventory_traking_shift_id' => $previous_shift_id,
                'inventory_traking_fuel_tank_id' => $dipping['inventory_traking_fuel_tank_id']
                    ], 1);


            $next_dipping = $this->dipping->getDippings([
                'inventory_traking_date' => $next_shift_date,
                'inventory_traking_shift_id' => $next_shift_id,
                'inventory_traking_fuel_tank_id' => $dipping['inventory_traking_fuel_tank_id']
                    ], 1);



            if ($previous_dipping) {
                $previous_dipping_data = [
                    'inventory_traking_phisical_clo' => $opening_dipping,
                    'inventory_traking_user_id' => $this->usr->user_id
                ];
                $previous_dipping_id = $previous_dipping['inventory_traking_id'];
            }

            if ($next_dipping) {
                $next_dipping_data = [
                    'inventory_traking_phisical_op' => $closing_dipping,
                    'inventory_traking_user_id' => $this->usr->user_id
                ];
                $next_dipping_id = $next_dipping['inventory_traking_id'];
            }


            // Closing current dipping data
            $edit_dipping_data = [
                'inventory_traking_phisical_clo' => $closing_dipping,
                'inventory_traking_phisical_op' => $opening_dipping,
                'inventory_traking_user_id' => $this->usr->user_id
            ];

            $dipping_ids = [
                'next_dipping_id' => $next_dipping_id,
                'previous_dipping_id' => $previous_dipping_id,
                'edit_dipping_id' => $dipping['inventory_traking_id']
            ];

            $res = $this->dipping->saveEditDipping([
                'previous_dipping_data' => $previous_dipping_data,
                'edit_dipping_data' => $edit_dipping_data,
                'next_dipping_data' => $next_dipping_data,
                'dipping_ids' => $dipping_ids
            ]);

            if ($res) {

                $this->usr->setSessMsg('Dipping was edited successfully', 'success');

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('dailyentries/dipping?date=' . $dipping['inventory_traking_date'])
                    ]
                ]);

                die();
            } else {
                cus_json_error('Something went wrong, dipping was not edited.');
            }
        }
    }

    public function submitCloseAttShift() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->usr->checkStatusJson(1, 1, 1);

        $att_id = $this->uri->segment(3);

        $att = $this->att->getAttendances(['att_id' => $att_id, 'att_station_id' => $this->usr->station_id], NULL, 1, NULL, NULL);

        if (!$att) {
            cus_json_error('Shift details was not found or may have been removed from the system');
        }

        if ($att['att_shift_status'] == 'Closed') {
            cus_json_error('Attendant shift is already closed');
        }

        $validations = [
            //['field' => 'order_date', 'label' => 'Order Date', 'rules' => 'trim|required|callback_validateOrderDate', 'errors' => ['required' => 'Select the order date.']],
                ['field' => 'cs_clo_mtr_rdngs', 'label' => 'Closing Meter Readings', 'rules' => 'trim|required|callback_validateCloMtrRdngs'],
                ['field' => 'cs_throughput', 'label' => 'Throughput', 'rules' => 'callback_validateThroughput'],
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

            $att_data = [
                'att_clo_mtr_reading' => $this->input->post('cs_clo_mtr_rdngs'),
                'att_shift_status' => 'Closed'
            ];

            $res = $this->att->saveCloseShift(['att_data' => $att_data, 'att_id' => $att['att_id']]);

            if ($res) {

                $this->usr->setSessMsg('Attendant shift closed successfully', 'success');

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('dailyentries/attendantsshifts?date=' . $att['att_date'])
                    ]
                ]);

                die();
            } else {
                cus_json_error('Something went wrong, attendant shift was not closed.');
            }
        }
    }

//    Forms validations 

    public function validateCloMtrRdngs($clo_mtr_readings) {

        if (empty($clo_mtr_readings)) {
            return TRUE;
        }

        $att_id = $this->uri->segment(3);

        $att = $this->att->getAttendances(['att_id' => $att_id, 'att_station_id' => $this->usr->station_id], NULL, 1, NULL, NULL);

        if (!$att) {
            cus_json_error('Shift details was not found or may have been removed from the system');
        }

        if ($att['att_op_mtr_reading'] > $clo_mtr_readings) {
            $this->form_validation->set_message('validateCloMtrRdngs', '<b>Closing meter readings</b> should be greater than or equal to <b>Opening meter readings</b>');
            return FALSE;
        }


        return TRUE;
    }

    public function validateThroughput() {

        $clo_mtr_readings = $this->input->post('cs_clo_mtr_rdngs');

        if (empty($clo_mtr_readings)) {
            return TRUE;
        }

        $att_id = $this->uri->segment(3);

        $att = $this->att->getAttendances(['att_id' => $att_id, 'att_station_id' => $this->usr->station_id], NULL, 1, NULL, NULL);

        if (!$att) {
            cus_json_error('Shift details was not found or may have been removed from the system');
        }

        $total_credit_sales = $att['credit_sales'] + $att['return_to_tank'] + $att['transfered_to_station'];
        $throughput = $clo_mtr_readings - $att['att_op_mtr_reading'];

        if ($total_credit_sales > $throughput) {
            $this->form_validation->set_message('validateThroughput', 'Throughput should atleast be equal to or exceed <b>Total Credit Sales</b>. Check if the <b>Closing Meter Readings</b> field or <b>Added Credit Sales</b> in this PUMP are correct');
            return FALSE;
        }


        return TRUE;
    }

    public function validateAddCreditForm() {

        $att_id = $this->uri->segment(3);
        $customer_id = $this->input->post('cr_customer');


        $customer = $this->cust->getCreditCustomers(['credit_type_id' => $customer_id, 'credit_type_admin_id' => $this->usr->admin_id], NULL, 1);

        if (!$customer) {
            return TRUE;
        }

        $last_credit_sale = $this->rpt->getCreditSales("(customer_sale_timestamp BETWEEN DATE_SUB(NOW() , INTERVAL 2 MINUTE) AND NOW()) AND customer_sale_credit_type_id ='" . $customer['credit_type_id'] . "' AND customer_sale_att_id = '" . $att_id . "' ", ['customer_sale_id'], 1);

        if ($last_credit_sale) {

            $this->form_validation->set_message('validateAddCreditForm', 'This record may have already been added. <a href="' . site_url('dailyentries/saledetails/' . $att_id) . '">Refresh</a> the page to confirm');
            return FALSE;
        }

        return TRUE;
    }

    public function validateDeliveryPoint($delivery_point) {
        $customer_id = $this->input->post('cr_customer');

        $customer = $this->cust->getCreditCustomers(['crdt.credit_type_id' => $customer_id], NULL, 1);

        if (!$customer) {
            return TRUE;
        }

        if ($customer['credit_type_type_description'] == 'TRANSIT' AND empty($delivery_point)) {
            $this->form_validation->set_message('validateDeliveryPoint', 'Delivery point is required');
            return FALSE;
        }
        return TRUE;
    }

    public function validateDriverName($driver_name) {

        $customer_id = $this->input->post('cr_customer');

        $customer = $this->cust->getCreditCustomers(['crdt.credit_type_id' => $customer_id], NULL, 1);

        if (!$customer) {
            return TRUE;
        }

        if ($customer['credit_type_type_description'] == 'TRANSIT' AND empty($driver_name)) {
            $this->form_validation->set_message('validateDriverName', 'Driver name is required');
            return FALSE;
        }

        return TRUE;
    }

    public function releaseOrder() {

        $this->usr->checkStatus();

        $order_id = $this->uri->segment(3);

        $po = $this->purchase->getPurchaseOrders(['po.po_id' => $order_id], 1);

        if (!$po) {
            $this->usr->setSessMsg('Purchase order was not found or it may have been removed from the system', 'error', 'dailyentries/purchaseorders');
        }

        if ($this->purchase->updatePurchaseOrder(['po_status' => 'RELEASED'], ['po_id' => $po['po_id']])) {
            $this->usr->setSessMsg('Purchase order updated successfully', 'success', 'dailyentries/purchaseorders');
        } else {
            $this->usr->setSessMsg('Something went wrong, Purchase order was not updates', 'warning', 'dailyentries/purchaseorders');
        }
    }

    public function validateOrderDate($order_date) {
        return TRUE;
    }

    public function validateOrderNumber($order_number) {
        return TRUE;
    }

    public function validateCreditCustomer($customer_id) {

        if (empty($customer_id)) {
            return TRUE;
        }

        $credit = $this->cust->getCreditCustomers(['crdt.credit_type_id' => $customer_id, 'crdt.credit_type_admin_id' => $this->usr->admin_id], NULL, 1);

        if (!$credit AND ! empty($customer_id)) {
            $this->form_validation->set_message('validateCreditCustomer', 'Select a valid customer');
            return FALSE;
        }

        return TRUE;
    }

    public function validateAsAttendant($attendant_id) {

        if (empty($attendant_id)) {
            return TRUE;
        }

        $attendant = $this->mnt->getStationAttendants($this->usr->station_id, ['user_id' => $attendant_id], NULL, 1);
        if (!$attendant) {
            $this->form_validation->set_message('validateAsPumpId', 'Attendant was not found or may have been removed form the system');
            return FALSE;
        }
        return TRUE;
    }

    public function validateAsPumpId($pump_id) {

        if (empty($pump_id)) {
            return TRUE;
        }

        $pump = $this->mnt->getPumps($this->usr->station_id, ['pump_id' => $pump_id], NULL, 1);

        if (!$pump) {
            $this->form_validation->set_message('validateAsPumpId', 'Pump was not found or may have been removed form the system');
            return FALSE;
        }

        $opened_pumps = $this->rpt->getSales(['att.att_station_id' => $this->usr->station_id, 'att_shift_status' => 'Opened'], ['att.att_pump_id'], NULL);

        if ($opened_pumps) {
            $opened_pumps = array_column($opened_pumps, 'att_pump_id');
        } else {
            $opened_pumps = [];
        }

        if (in_array($pump['pump_id'], $opened_pumps)) {
            $this->form_validation->set_message('validateAsPumpId', 'Pump is assigned to an open shift');
            return FALSE;
        }

        return TRUE;
    }

    public function validateAsForm() {
        return TRUE;
    }

    public function validateCrQtySold($qty) {

        if (empty($qty)) {
            return TRUE;
        }
        $att_id = $this->uri->segment(3);

        $att = $this->rpt->getSales(['att.att_station_id' => $this->usr->station_id], ['att.att_shift_status', 'credit_sales', 'return_to_tank', 'transfered_to_station'], NULL, $att_id, []);

        if ($att['att_shift_status'] == 'Opened') {
            return TRUE;
        }

        $total_credit_sales = $att['credit_sales'] + $att['return_to_tank'] + $att['transfered_to_station'];

        if (($total_credit_sales + $qty) > $att['throughput']) {
            $this->form_validation->set_message('validateCrQtySold', 'Total credit sales should not exceed the throughput');
            return FALSE;
        }

        return TRUE;
    }

}
