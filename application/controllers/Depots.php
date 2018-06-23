<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Depots extends CI_Controller {

    // Initialize gloabal variables
    var $user_id = null;
    var $depo_id = null;
    var $is_logged_in = false;
    var $customer = null;

    public function __construct() {
        parent::__construct();

        // Check if user has logged in using session
        if ($this->usr->isLogedin()) {
            $this->user_id = $this->session->userdata['logged_in']['user_id'];
            $this->depo_id = $this->session->userdata['logged_in']['user_depo_id'];
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

    // Normal Pages

    public function index() {

        // Check user statuses
        $this->checkStatus(1, 1, 1);

        $depots = $this->depo->getUserDepots($this->user_id, $this->admin_id);

        $data = [
            'menu' => 'menu/view_stations_menu',
            'content' => 'contents/depots/view_depots',
            'menu_data' => ['curr_menu' => 'DEPOTS', 'curr_sub_menu' => 'DEPOTS'],
            'content_data' => [
                'module_name' => $this->customer['pc_name'] . ' Depots',
                'customer' => $this->customer,
                'depots' => $depots
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function stockControlReport() {

        // Check user statuses
        $this->checkStatus(1, 1, 1);


        $filter = NULL;
        $total_volume_received = 0;

        $filter['v.vessel_depot_id'] = $this->depo_id;

        $date_range = $this->input->post('date_range');
        $fuel_type = $this->input->post('fuel_type');

        if (!empty($date_range)) {

            $date_range_segments = explode('to', $date_range);
            if (sizeof($date_range_segments) == 2) {
                $filter = ["DATE(v.vessel_received_on) >= " => trim($date_range_segments[0]), " DATE(v.vessel_received_on) <=  " => trim($date_range_segments[1])];
            }
        }

        if ($fuel_type > 0) {
            $filter['v.vessel_fuel_type_group_id'] = $fuel_type;
        }

        $vessels = $this->depo->getStockVessels($filter);

        $fuel_types = $this->mnt->getFuelTypesGroup();

        $selected_date_range = !empty($date_range) ? $date_range : 'From The Begining';

        $selected_fuel_type = 0;
        $selected_fuel_type_name = 'All Types';


        foreach ($fuel_types as $ft) {
            if ($ft['fuel_type_group_id'] == $fuel_type) {
                $selected_fuel_type = $ft['fuel_type_group_id'];
                $selected_fuel_type_name = $ft['fuel_type_group_generic_name'] . ' - ' . $ft['fuel_type_group_name'];
            }
        }

        foreach ($vessels as $v) {
            $total_volume_received += $v['vessel_received_volume'];
        }

        $data = [
            'menu' => 'menu/view_depot_menu',
            'content' => 'contents/depots/view_stock_control_report',
            'menu_data' => ['curr_menu' => 'REPORT', 'curr_sub_menu' => 'REPORT'],
            'content_data' => [
                'module_name' => 'Stock Control Report',
                'customer' => $this->customer,
                'vessels' => $vessels,
                'fuel_types' => $fuel_types,
                'selected_date_range' => $selected_date_range,
                'selected_fuel_type_name' => $selected_fuel_type_name,
                'selected_fuel_type' => $selected_fuel_type,
                'total_volume_received' => $total_volume_received
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function setDepot() {

        // Check user statuses
        $this->checkStatus(1, 1, 1);

        $depo_id = $this->uri->segment(3);
        $depot = $this->depo->canAccessDepot($this->user_id, $depo_id);


        if ($depot) {
            $this->session->userdata['logged_in']['user_depo_id'] = $depot['depo_id'];
            $this->session->userdata['logged_in']['user_depo_name'] = $depot['depo_name'];
            $this->session->userdata['logged_in']['user_depo_role'] = $depot['organize_user_role'];
            redirect('depots/stockvessels');
        } else {
            $this->session->set_flashdata('error', 'Select a valid depot');
            redirect('depots');
        }
    }

    public function stockVessels() {

        // Check user statuses
        $this->checkStatus(1, 1, 1);

        if (empty($this->depo_id)) {
            $this->setSessMsg('Select a depot', 'error', 'depots/index');
        }

        $stock_vessels = $this->depo->getStockVessels(['vessel_depot_id' => $this->depo_id]);

        $data = [
            'menu' => 'menu/view_depot_menu',
            'content' => 'contents/depots/view_stock_vessels',
            'menu_data' => ['curr_menu' => 'STOCK_CONTROL', 'curr_sub_menu' => 'STOCK_CONTROL'],
            'content_data' => [
                'module_name' => 'Stock Vessels',
                'customer' => $this->customer,
                'stock_vessels' => $stock_vessels
            ],
            'modals_data' => [
                'modals' => ['modal_add_vessel', 'modal_close_vessel'],
                'fuel_types_group' => $this->mnt->getFuelTypesGroup()
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function stockLoading() {

        // Check user statuses
        $this->checkStatus(1, 1, 1);

        if (empty($this->depo_id)) {
            $this->setSessMsg('Select a depot', 'error', 'depots/index');
        }

        $stock_loadings = $this->depo->getStockLoadings(['vs.vessel_depot_id' => $this->depo_id]);

        $data = [
            'menu' => 'menu/view_depot_menu',
            'content' => 'contents/depots/view_stock_loadings',
            'menu_data' => ['curr_menu' => 'STOCK_CONTROL', 'curr_sub_menu' => 'STOCK_CONTROL'],
            'content_data' => [
                'module_name' => 'Stock Loading',
                'customer' => $this->customer,
                'stock_loading' => $stock_loadings
            ],
            'modals_data' => [
                'modals' => ['modal_add_stock_loading'],
                'vessels' => $this->depo->getStockVessels(['vessel_depot_id' => $this->depo_id, 'vessel_status' => 'OPENED'])
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function vesselStockLoading($param) {

        // Check user statuses
        $this->checkStatus(1, 1, 1);

        if (empty($this->depo_id)) {
            $this->setSessMsg('Select a depot', 'error', 'depots/index');
        }

        $vessel_id = $this->uri->segment(3);


        $vessel = $this->depo->getStockVessels(['vessel_depot_id' => $this->depo_id, 'vessel_id' => $vessel_id], 1);

        if (!$vessel) {
            $this->setSessMsg('Vessel was not found or it may have been removed from the system', 'error', 'depots/stockvessels');
        }

        $opening_balance = $vessel['vessel_received_volume'];

        $vessel_successor = $this->depo->getStockVessels(['vessel_depot_id' => $this->depo_id, 'vessel_remains_transfered_to_vessel_id' => $vessel['vessel_id']], 1);
        if ($vessel_successor) {
            $opening_balance += $vessel_successor['vessel_balance'];
        }

        $stock_loadings = $this->depo->getVesselStockLoadings($vessel['vessel_id']);

        $data = [
            'menu' => 'menu/view_depot_menu',
            'content' => 'contents/depots/view_vessel_stock_loading',
            'menu_data' => ['curr_menu' => 'STOCK_CONTROL', 'curr_sub_menu' => 'STOCK_CONTROL'],
            'content_data' => [
                'module_name' => 'Vessel Stock Loadings',
                'customer' => $this->customer,
                'vessel' => $vessel,
                'stock_loading' => $stock_loadings,
                'opening_balance' => $opening_balance
            ],
            'modals_data' => [
                'modals' => ['modal_add_stock_loading_single'],
                'vessel_id' => $vessel['vessel_id'],
                'orders' => $this->purchase->getPoForVessel(['vs.vessel_id' =>$vessel['vessel_id'],'poq.poq_status' => 'RELEASED']) //$this->purchase->getPurchaseOrders(['po.po_vessel_id' => $vessel['vessel_id'], 'ri.ri_status' => 'RELEASED', 'po.po_status' => 'RELEASED'])
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];
        
   
        $this->load->view('view_base', $data);
    }

    // Ajax Requests
    public function submitStockLoading() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $validations = [
                ['field' => 'loading_date', 'label' => 'Loading Date', 'rules' => 'trim|required|callback_validateLoadingDate'],
                ['field' => 'invoice_number', 'label' => 'Invoice Number', 'rules' => 'trim|required|callback_validateLoadingInvoiceNumber'],
                ['field' => 'loading_vessel_id', 'label' => 'Stock Vessel', 'rules' => 'trim|required|callback_validateLoadingVesselId'],
                ['field' => 'volume_loaded', 'label' => 'Volume Loaded', 'rules' => 'trim|required|numeric'],
                ['field' => 'transfer_note', 'label' => 'Transfer Note Number', 'rules' => 'trim|required'],
                ['field' => 'loading_po_id', 'label' => 'Purchase Order', 'rules' => 'trim|required'],
                ['field' => 'conversion_factor', 'label' => 'Conversion Factor', 'rules' => 'trim|required|numeric']
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

            $vessel_id = $this->input->post('loading_vessel_id');
            $po_id = $this->input->post('loading_po_id');
            $vessel = $this->depo->getStockVessels(['vessel_id' => $vessel_id], 1);
            $volume_loaded = $this->input->post('volume_loaded');
            $conversion_factor = $this->input->post('conversion_factor');
            $balance_after = $vessel['vessel_balance'] - ($volume_loaded * $conversion_factor);

            if (!$vessel) {
                cus_json_error('Vessel was not found or may have been removed form the system');
            }

            $loading_data = [
                'sl_date' => date('Y-m-d', strtotime($this->input->post('loading_date'))),
                'sl_po_id' => $po_id,
                'sl_vessel_id' => $vessel['vessel_id'],
                'sl_volume_loaded' => $volume_loaded,
                'sl_balance_before' => $vessel['vessel_balance'],
                'sl_balance_after' => $balance_after,
                'sl_user_id' => $this->user_id,
                'sl_invoice_number' => $this->input->post('invoice_number'),
                'sl_conversion_factor' => $conversion_factor,
                'sl_transfer_note' => $this->input->post('transfer_note')
            ];

            $vessel_data = ['vessel_balance' => $balance_after];

            $po_data = ['po_status' => 'LOADED'];

            $data = [
                'loading_data' => $loading_data,
                'vessel_data' => $vessel_data,
                'vessel_id' => $vessel['vessel_id'],
                'po_data' => $po_data,
                'po_id' => $po_id
            ];

            $res = $this->depo->saveLoading($data);

            if ($res) {
                echo json_encode(['status' => ['error' => false, 'redirect' => true, 'redirect_url' => site_url('depots/stockloading')]]);
            } else {
                cus_json_error('Something went wrong, Stock Loading was not saved, Please try again', 'error', 'depots/stockloading');
            }
        }
    }

    public function submitStockLoadingSingle() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $vessel_id = $this->uri->segment(3);

        $vessel = $this->depo->getStockVessels(['vessel_id' => $vessel_id], 1);

        if (!$vessel) {
            cus_json_error('Vessel was not found or it may have been removed from the system');
        }

        $validations = [
                ['field' => 'loading_date', 'label' => 'Loading Date', 'rules' => 'trim|required|callback_validateLoadingDate'],
                ['field' => 'invoice_number', 'label' => 'Invoice Number', 'rules' => 'trim|required|callback_validateLoadingInvoiceNumber'],
                ['field' => 'volume_loaded', 'label' => 'Volume Loaded', 'rules' => 'trim|required|numeric'],
                ['field' => 'loading_po_id', 'label' => 'Purchase Order', 'rules' => 'trim|required'],
                ['field' => 'transfer_note', 'label' => 'Transfer Note Number', 'rules' => 'trim|required'],
                ['field' => 'conversion_factor', 'label' => 'Conversion Factor', 'rules' => 'trim|required|numeric']
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


            $po_id = $this->input->post('loading_po_id');
            $volume_loaded = $this->input->post('volume_loaded');
            $conversion_factor = $this->input->post('conversion_factor');
            $balance_after = $vessel['vessel_balance'] - ($volume_loaded * $conversion_factor);



            $loading_data = [
                'sl_date' => date('Y-m-d', strtotime($this->input->post('loading_date'))),
                'sl_poq_id' => $po_id,
                'sl_vessel_id' => $vessel['vessel_id'],
                'sl_volume_loaded' => $volume_loaded,
                'sl_balance_before' => $vessel['vessel_balance'],
                'sl_balance_after' => $balance_after,
                'sl_user_id' => $this->user_id,
                'sl_invoice_number' => $this->input->post('invoice_number'),
                'sl_conversion_factor' => $conversion_factor,
                'sl_transfer_note' => $this->input->post('transfer_note')
            ];

            $vessel_data = ['vessel_balance' => $balance_after];

            $po_data = ['poq_status' => 'LOADED'];

            $data = [
                'loading_data' => $loading_data,
                'vessel_data' => $vessel_data,
                'vessel_id' => $vessel['vessel_id'],
                'po_data' => $po_data,
                'po_id' => $po_id
            ];

            $res = $this->depo->saveLoading($data);

            if ($res) {
                echo json_encode(['status' => ['error' => false, 'redirect' => true, 'redirect_url' => site_url('depots/stockloading')]]);
            } else {
                cus_json_error('Something went wrong, Stock Loading was not saved, Please try again', 'error', 'depots/stockloading');
            }
        }
    }

    public function openVessel() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $vessel_id = $this->uri->segment(3);

        $vessel = $this->depo->getStockVessels(['vessel_id' => $vessel_id, 'vessel_depot_id' => $this->depo_id], 1);

        if (!$vessel) {
            cus_json_error('Vessel was not found or it may have been removed from the system');
        }

        $opened_vessel = $this->depo->getStockVessels(['vessel_fuel_type_group_id' => $vessel['vessel_fuel_type_group_id'], 'vessel_status' => 'OPENED', 'vessel_depot_id' => $this->depo_id], 1);

        if ($opened_vessel) {
            cus_json_error($opened_vessel['vessel_name'] . ' should be closed before opening of ' . $vessel['vessel_name']);
        }

        if ($this->purchase->updateVessel(['vessel_status' => 'OPENED'], ['vessel_id' => $vessel['vessel_id'], 'vessel_depot_id' => $this->depo_id])) {
            echo json_encode([
                'status' => [
                    'error' => FALSE,
                    'redirect' => TRUE,
                    'redirect_url' => site_url('depots/stockvessels')
                ]
            ]);
        } else {
            cus_json_error('Something went wrong. Vessel was not opened');
        }
    }

    public function requestCloseVesselForm() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $vessel_id = $this->uri->segment(3);

        $vessel = $this->depo->getStockVessels(['vessel_id' => $vessel_id, 'vessel_depot_id' => $this->depo_id], 1);

        if (!$vessel) {
            cus_json_error('Vessel was not found or it may have been removed from the system');
        }

        if ($vessel['vessel_status'] != 'OPENED') {
            cus_json_error('Vessel is not in a right status to be closed');
        }

        $vessels [] = ['text' => '', 'id' => ''];
        $received_vessel = $this->depo->getStockVessels(['vessel_fuel_type_group_id' => $vessel['vessel_fuel_type_group_id'], 'vessel_status' => 'RECEIVED', 'vessel_depot_id' => $this->depo_id]);


        foreach ($received_vessel as $rv) {
            $vessels[] = ['text' => $rv['vessel_name'], 'id' => $rv['vessel_id']];
        }

        $data['vessel_name'] = $vessel['vessel_name'];
        $data['vessel_balance'] = $vessel['vessel_balance'];
        $data['vessels'] = $vessels;


        echo json_encode([
            'status' => [
                'error' => FALSE,
                'redirect' => FALSE,
                'pop_form' => TRUE,
                'form_type' => 'closeVessel',
                'form_url' => site_url('depots/submitCloseVessel/' . $vessel['vessel_id']),
                'form_data' => $data
            ]
        ]);
    }

    public function submitCloseVessel() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $vessel_id = $this->uri->segment(3);

        $vessel = $this->depo->getStockVessels(['vessel_id' => $vessel_id, 'vessel_depot_id' => $this->depo_id], 1);

        if (!$vessel) {
            cus_json_error('Vessel was not found or it may have been removed from the system');
        }

        if ($vessel['vessel_status'] != 'OPENED') {
            cus_json_error('Vessel is not in a right status to be closed');
        }


        $validations = [
                ['field' => 'close_vs_remain_transfered_to', 'label' => 'Remains transfered to', 'rules' => 'trim|numeric|callback_validateRemainsTransferedTo']
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

            $selected_vessel_id = $this->input->post('close_vs_remain_transfered_to');
            $vessel_remains_transfered_to_vessel_id = NULL;

            $unreleased_po = $this->purchase->getPurchaseOrders(['po.po_vessel_id' => $vessel['vessel_id'], 'po.po_status' => 'RELEASED']);

            if ($unreleased_po) {
                $data['unreleased_pos'] = array_column($unreleased_po, 'po_id');
            }



            if ($unreleased_po AND empty($selected_vessel_id)) {
                cus_json_error('There is unloaded orders that should be tranfered to another vessel. Therefore you should select a vessel or add new');
            }

            if (!empty($selected_vessel_id)) {

                $selected_vessel = $this->depo->getStockVessels(['vessel_id' => $selected_vessel_id, 'vessel_depot_id' => $this->depo_id], 1);

                if (!$selected_vessel) {
                    cus_json_error('Vessel was not found or it may have been removed from the system');
                }
                $vessel_remains_transfered_to_vessel_id = $selected_vessel['vessel_id'];

                $data['selected_vessel_data'] = ['vessel_status' => 'OPENED', 'vessel_balance' => $vessel['vessel_balance'] + $selected_vessel['vessel_balance']];
                $data['selected_vessel_id'] = $selected_vessel['vessel_id'];
            }

            $data['vessel_data'] = ['vessel_status' => 'CLOSED', 'vessel_remains_transfered_to_vessel_id' => $vessel_remains_transfered_to_vessel_id];
            $data['vessel_id'] = $vessel['vessel_id'];


            if ($this->depo->closeVessel($data)) {
                $this->setSessMsg($vessel['vessel_name'] . ' closed successfully', 'success');
                echo json_encode(['status' => ['error' => false, 'redirect' => TRUE, 'redirect_url' => site_url('depots/stockvessels')]]);
            } else {
                cus_json_error('Something went wrong. Nothing was updated please try again');
            }
        }
    }

    // Form Validations

    public function submitNewVessel() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $validations = [
                ['field' => 'vessel_name', 'label' => 'Vessel Name', 'rules' => 'trim|required', 'errors' => ['required' => 'Enter the vessel name.']],
                ['field' => 'ftg_id', 'label' => 'Product Type', 'rules' => 'trim|required'],
                ['field' => 'vesselaycan', 'label' => 'Vessel Laycan', 'rules' => 'trim|required'],
                ['field' => 'date_received', 'label' => 'Date Received', 'rules' => 'trim|required'],
                ['field' => 'volume_ordered', 'label' => 'Volume Ordered', 'rules' => 'trim|required'],
                ['field' => 'volume_received', 'label' => 'Volume Received', 'rules' => 'trim|required']
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

            $received_volume = $this->input->post('volume_received');
            $vessel_data = [
                'vessel_name' => $this->input->post('vessel_name'),
                'vessel_fuel_type_group_id' => $this->input->post('ftg_id'),
                'vessel_laycan' => date('Y-m-d', strtotime($this->input->post('vesselaycan'))), // Should convert to mysql date
                'vessel_received_on' => date('Y-m-d', strtotime($this->input->post('date_received'))),
                'vessel_ordered_volume' => $this->input->post('volume_ordered'),
                'vessel_received_volume' => $received_volume,
                'vessel_user_id' => $this->user_id,
                'vessel_status' => 'RECEIVED',
                'vessel_depot_id' => $this->depo_id,
                'vessel_balance' => $received_volume
            ];


            $res = $this->depo->saveNewVessel(['vessel_data' => $vessel_data]);

            if ($res) {
                $this->setSessMsg('Vsessel added succesffuly', 'success');

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('depots/stockvessels')
                    ]
                ]);
            } else {
                cus_json_error('Unable to add new vessel, please refresh the page and try again.');
            }
        }
    }

    public function validateLoadingDate($l_date) {
        return TRUE;
    }

    public function validateLoadingInvoiceNumber($invoice_number) {
        return TRUE;
    }

    public function validateLoadingVesselId($vessel_id) {
        $volume_loaded = $this->input->post('volume_loaded');

        $vessel = $this->depo->getStockVessels(['vessel_id' => $vessel_id], 1);


        if (!empty($volume_loaded) AND $vessel) {

            if ($volume_loaded > $vessel['vessel_balance']) {
                $this->form_validation->set_message('validateLoadingVesselId', 'Available balance for this vessel is not enough to be loaded to a selected order');
                return FALSE;
            }
        }

        return TRUE;
    }

    public function validateRemainsTransferedTo($selected_vessel_id) {

        $vessel_id = $this->uri->segment(3);

        $vessel = $this->depo->getStockVessels(['vessel_id' => $vessel_id, 'vessel_depot_id' => $this->depo_id], 1);

        if (!$vessel) {
            $this->form_validation->set_message('validateRemainsTransferedTo', 'Vessel to be closed was not found or it may have been removed from the system');
            return FALSE;
        }

        if (empty($selected_vessel_id) AND $vessel['vessel_balance'] > 0) {
            $this->form_validation->set_message('validateRemainsTransferedTo', 'The remains transfered to field is required');
            return FALSE;
        }

        $selected_vessel = $this->depo->getStockVessels(['vessel_id' => $selected_vessel_id, 'vessel_depot_id' => $this->depo_id], 1);

        if (!$selected_vessel) {
            $this->form_validation->set_message('validateRemainsTransferedTo', 'Vessel was not found or it may have been removed from the system');
            return FALSE;
        }

        return TRUE;
    }

    public function excelVesselStockLoading() {

        // Chek if user is logged in

        $this->checkStatus(1, 1, 1);

        // Check user statuses
        $this->checkStatus(1, 1, 1);

        if (empty($this->depo_id)) {
            $this->setSessMsg('Select a depot', 'error', 'depots/index');
        }

        $vessel_id = $this->uri->segment(3);


        $vessel = $this->depo->getStockVessels(['vessel_depot_id' => $this->depo_id, 'vessel_id' => $vessel_id], 1);

        if (!$vessel) {
            $this->setSessMsg('Vessel was not found or it may have been removed from the system', 'error', 'depots/stockvessels');
        }

        $opening_balance = $vessel['vessel_received_volume'];

        $vessel_successor = $this->depo->getStockVessels(['vessel_depot_id' => $this->depo_id, 'vessel_remains_transfered_to_vessel_id' => $vessel['vessel_id']], 1);
        if ($vessel_successor) {
            $opening_balance += $vessel_successor['vessel_balance'];
        }

        $stock_loadings = $this->depo->getVesselStockLoadings($vessel['vessel_id']);


        // Creating Excel File
        require_once APPPATH . '/third_party/Phpexcel/Bootstrap.php';


        //\PhpOffice\Settings::setZipClass(PHPExcel_Settings::PCLZIP);
        //PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);
        // Create new Spreadsheet object
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        // Top Barner
//        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
//        $drawing->setName('Logo');
//        $drawing->setDescription('Logo');
//        $drawing->setPath( './assets/img/afroiltopbanner.jpg');
//        $drawing->setHeight(36);
        //$drawing->setWorksheet($spreadsheet->getActiveSheet());
        // Set document properties
        $spreadsheet->getProperties()->setCreator('nyumbanicreative.com')
                ->setLastModifiedBy($this->session->userdata['logged_in']['user_name'])
                ->setTitle('Vessel Stock Loading')
                ->setSubject('Vessel Stock Loading generated in ' . SYSTEM_NAME)
                ->setDescription('Vessel Stock Loading generated in ' . SYSTEM_NAME);

        // add style to the header
        $styleArray = array(
            'font' => array(
                'bold' => true, 'size' => 15
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ),
            "borders" => [
                "outline" => [
                    "style" => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    "color" => ["argb" => "00000000"],
                ],
                'inside' => [
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ]
            ],
            'fill' => array(
                'type' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => array('rgb' => 'FFFF00')
            )
        );

        $styleHeaderArray = [
            'font' => ['bold' => TRUE],
            'borders' => [
                'outline' => [
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
                'inside' => [
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ]
        ];

        $styleDataArray = [
            "borders" => [
                "outline" => [
                    "style" => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    "color" => ["argb" => "00000000"],
                ],
                'inside' => [
                    'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ]
            ]
        ];



        $spreadsheet->getActiveSheet()->getStyle('A2:N2')->applyFromArray($styleArray);
        $spreadsheet->getActiveSheet()->mergeCells('A2:N2');
        $spreadsheet->getActiveSheet()->getStyle('A3:N3')->applyFromArray($styleHeaderArray);
        $spreadsheet->getActiveSheet()->getStyle('A4:L4')->applyFromArray($styleHeaderArray);
        $spreadsheet->getActiveSheet()->getStyle('L4:N4')->applyFromArray($styleHeaderArray);
        $spreadsheet->getActiveSheet()->getStyle('A3:L3')->getAlignment()->setWrapText(true);

        $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(12);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(15);



        //Merge rows
        foreach (range('A', 'K') as $columnID) {
            $spreadsheet->getActiveSheet()->mergeCells($columnID . "3:" . $columnID . "4");
        }

        $spreadsheet->setActiveSheetIndex(0)->setCellValue("A2", "EX-VESSEL:  " . strtoupper($vessel['vessel_name']) . " \t\t\t\t LAYCAN:  " . cus_nice_date($vessel['vessel_laycan']) . " \t\t\t\t RECEIVED ON:  " . cus_nice_date($vessel['vessel_received_on']));

        // set the names of header cells
        $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue("A3", "S/N")
                ->setCellValue("B3", "DATE")
                ->setCellValue("C3", 'PRODUCTS')
                ->setCellValue("D3", "TRUCK \nREG NUMBER")
                ->setCellValue("E3", "ORDER No.")
                ->setCellValue("F3", "INVOICE NUMBER")
                ->setCellValue("G3", "OBS VOLUME \nLOADED(L)")
                ->setCellValue("H3", "CONVERSION \nFACTOR")
                ->setCellValue("I3", "AT 20 VOL \nLOADED")
                ->setCellValue("J3", "AVAILABLE \nVOL @20")
                ->setCellValue("K3", "STOCK TRANSFER \nNOTE NO.")
                ->setCellValue("L4", 'NOTE NO')
                ->setCellValue("M4", 'DATE')
                ->setCellValue("N4", 'LOCATION')
                ->setCellValue("J5", $opening_balance)
        ;

        $spreadsheet->getActiveSheet()->mergeCells('L3:N3');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("L3", 'DELIVERY');
        $spreadsheet->getActiveSheet()->getStyle("A5:N5")->applyFromArray($styleDataArray);


        // Add some data
        $x = 6;
        foreach ($stock_loadings as $index => $sl) {

            $note_no = !empty($sl['od_id'])? 'OD_'.cus_preciding_zeros($sl['od_id']): "";
            $del_date = !empty($sl['inventory_purchase_date'])? cus_nice_date($sl['inventory_purchase_date']): "";
            $spreadsheet->getActiveSheet()->getStyle("A$x:N$x")->applyFromArray($styleDataArray);
            
            $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue("A$x", ($index + 1))
                    ->setCellValue("B$x", cus_nice_date($sl['sl_date']))
                    ->setCellValue("C$x", $sl['fuel_type_group_name'])
                    ->setCellValue("D$x", $sl['po_truck_number'])
                    ->setCellValue("E$x", $sl['po_number'])
                    ->setCellValue("F$x", $sl['sl_invoice_number'])
                    ->setCellValue("G$x", $sl['sl_volume_loaded'])
                    ->setCellValue("H$x", $sl['sl_conversion_factor'])
                    ->setCellValue("I$x", ($sl['sl_volume_loaded'] * $sl['sl_conversion_factor']))
                    ->setCellValue("J$x", $sl['sl_balance_after'])
                    ->setCellValue("K$x", $sl['sl_transfer_note'])
                    ->setCellValue("L$x", $note_no)
                    ->setCellValue("M$x", $del_date)
                    ->setCellValue("N$x", $sl['station_name']);
            $x++;
        }
        
        $x +=2;
        
        $spreadsheet->getActiveSheet()->mergeCells("A$x:E$x");
        $spreadsheet->getActiveSheet()->getStyle("A$x:E$x")->applyFromArray($styleHeaderArray); 
        
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("A$x", "FROM OUTTURN REPORT");$x++;
        
        $spreadsheet->getActiveSheet()->getStyle("A$x:E$x")->applyFromArray($styleDataArray);
        $spreadsheet->getActiveSheet()->mergeCells("B$x:C$x");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("B$x", "ARRIVED QUANTITY");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("E$x", "XXXXXXXXXX"); $x++;
        
        $spreadsheet->getActiveSheet()->getStyle("A$x:E$x")->applyFromArray($styleDataArray);
        $spreadsheet->getActiveSheet()->mergeCells("B$x:C$x");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("A$x", "Less");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("B$x", "SHIP TO SHORE LOSS");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("E$x", ""); $x++;

        
        $spreadsheet->getActiveSheet()->getStyle("A$x:E$x")->applyFromArray($styleDataArray);
        $spreadsheet->getActiveSheet()->mergeCells("B$x:C$x");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("A$x", "");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("B$x", "RECEIVED QUANTITY");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("E$x", "XXXXXXXXXX"); $x++;
        
        $spreadsheet->getActiveSheet()->getStyle("A$x:E$x")->applyFromArray($styleDataArray);
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("A$x", "Less");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("B$x", "MI LOSS");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("E$x", "XXXXXXXXXX"); $x++;
        
        $spreadsheet->getActiveSheet()->getStyle("A$x:E$x")->applyFromArray($styleDataArray);
        $spreadsheet->getActiveSheet()->mergeCells("B$x:C$x");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("A$x", "");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("B$x", "LOADED QUANTITY");
        $spreadsheet->setActiveSheetIndex(0)->setCellValue("E$x", "XXXXXXXXXX"); $x++;


        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Vessel Stock Loading');

        // set right to left direction
        //$spreadsheet->getActiveSheet()->setRightToLeft(true);
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="stock_loading_sheet.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Excel2007');
        $writer->save('php://output');
        exit;

        //  create new file and remove Compatibility mode from word title
    }

}
