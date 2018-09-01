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

    public function fuel() {

        // Check user status
        $this->checkStatus(1, 1, 1);

        $data = [
            'menu' => 'menu/view_sys_menu', // View for menu
            'content' => 'contents/maintenance/view_fuel_and_pricing', // View for contnet
            'menu_data' => ['curr_menu' => 'MAINTENANCE', 'curr_sub_menu' => 'MAINTENANCE'], //Inorder to collapse  menu items
            'content_data' => [//Contents data pass here
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
            'content_data' => [//Contents data pass here
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
            'content_data' => [//Contents data pass here
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
            'content_data' => [//Contents data pass here
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
            'content_data' => [//Contents data pass here
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

    public function cacheFields() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        // Initialize valid fields
        $valid_fields = ['po_depo_id', 'loading_vessel_id', 'loading_po_id', 'cr_customer', 'as_pump_id'];

        // initialize post inputs
        $field = $this->input->post('field');
        $value = $this->input->post('value');

        if (!in_array($field, $valid_fields)) {
            cus_json_error('Invalid field encountered, Please contact system developer');
        }

        switch ($field) {

            // If case is purchase order depot id we will need to populate vessels with that selected depot
            case 'po_depo_id':

                $vessels [] = ['text' => '', 'id' => ''];
                $depo_vessels = $this->depo->getStockVessels(['vessel_depot_id' => $value, 'vessel_status <>' => 'CLOSED']);
                if (!$depo_vessels) {
                    cus_json_error('Currently there is no active vessel for a selected depot');
                }

                foreach ($depo_vessels as $dv) {
                    $vessels[] = ['text' => $dv['vessel_name'] . ' - ' . $dv['fuel_type_group_name'], 'id' => $dv['vessel_id']];
                }
                $json = ['status' => ['error' => FALSE], 'vessels' => $vessels];

                break;

            case 'loading_vessel_id':

                $pos [] = ['text' => '', 'id' => ''];
                $released_pos = $this->purchase->getPurchaseOrders(['po.po_vessel_id' => $value, 'ri.ri_status' => 'RELEASED', 'po.po_status' => 'RELEASED']);

                if (!$released_pos) {
                    cus_json_error('No purchase order has been requested for this vessel');
                }

                foreach ($released_pos as $po) {
                    $pos[] = ['text' => $po['po_number'] . ' - ' . $po['po_driver_name'] . ' ' . $po['po_truck_number'], 'id' => $po['po_id']];
                }

                $json = ['status' => ['error' => FALSE], 'po' => $pos];

                break;

            case 'loading_po_id':

                $po = $this->purchase->getPoForVessel(['poq.poq_id' => $value], 1);

                if (!$po) {
                    cus_json_error('Purchase order may have been removed from the system');
                }

                $json = ['status' => ['error' => FALSE], 'po' => $po];

                break;

            case 'cr_customer':

                $customer = $this->cust->getCreditCustomers(['credit_type_id' => $value], NULL, 1);

                if (!$customer) {
                    cus_json_error('Customer was not found or may have been removed from the system');
                }

                $json = ['status' => ['error' => FALSE], 'customer' => $customer];
                break;

            case 'as_pump_id':

                $pump = $this->mnt->getPumps($this->usr->station_id, ['pump_id' => $value], NULL, 1);

                if (!$pump) {
                    cus_json_error('Pump was not found');
                }

                $opened_pumps = $this->rpt->getSales(['att.att_station_id' => $this->usr->station_id, 'att_shift_status' => 'Opened'], ['att.att_pump_id'], NULL);

                if ($opened_pumps) {
                    $opened_pumps = array_column($opened_pumps, 'att_pump_id');
                } else {
                    $opened_pumps = [];
                }

                if (in_array($pump['pump_id'], $opened_pumps)) {
                    cus_json_error('Pump is assigned to an open shift');
                }
                
                // Lets have max and min shift sequences
                $min_shift = $this->mnt->getShifts($this->usr->station_id, NULL, NULL, 1, NULL, [['col' => 'shift_sequence', 'sort' => 'ASC']]);
                $max_shift = $this->mnt->getShifts($this->usr->station_id, NULL, NULL, 1, NULL, [['col' => 'shift_sequence', 'sort' => 'DESC']]);

                // Get last shift for selected pump
                $last_pump_shift = $this->att->getAttendances(['att.att_pump_id' => $pump['pump_id'], 'att.att_station_id' => $this->usr->station_id], ['att.att_date', 's.shift_sequence'], 1, NULL, [['col' => 'att.att_date', 'sort' => 'DESC'], ['col' => 's.shift_sequence', 'sort' => 'DESC']]);

                // Check if we have it
                if ($last_pump_shift) {

                    // If we have it lets check if next shift is latest
                    if (((int)$last_pump_shift['shift_sequence'] + 1) > $max_shift['shift_sequence']) {

                        $next_shift_date = date('Y-m-d', strtotime('+1 day', strtotime($last_pump_shift['att_date'])));
                        $next_shift_id = $min_shift['shift_id'];
                        
                    } else {

                        $next_shift_date = $last_pump_shift['att_date'];
                        $next_shift = $this->mnt->getShifts($this->usr->station_id, ['shift_sequence' => ((int)$last_pump_shift['shift_sequence'] + 1)], NULL, 1, NULL, NULL);
                      
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

                $data = ['next_shift_id' => $next_shift_id, 'next_shift_date' => $next_shift_date,'open_mtr_readings' => $pump['pump_curr_mtr_rdngs']];
                $json = ['status' => ['error' => FALSE], 'next_shift' => $data];
                
                
                break;
        }

        echo json_encode($json);
        die();
    }

}
