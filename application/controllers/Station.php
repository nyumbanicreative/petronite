<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Station extends CI_Controller {

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

        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        $user_id = $this->session->userdata['logged_in']['user_id'];
        $admin_id = $this->session->userdata['logged_in']['user_admin_id'];
        $customer = $this->cust->getCustomerDetails($admin_id);


        if (!$customer) {
            // not a valid customer
            $this->session->set_flashdata('error', 'It appears that, customer details was not found or may have been removed.');
            redirect('user/logout');
        }


        $stations = $this->stn->getUserStations($user_id, $admin_id);


        if (empty($admin_id)) {
            $this->session->set_flashdata('error', 'Select a valid customer');
            redirect('developer/customers');
        }

        $data = [
            'menu' => 'menu/view_stations_menu',
            'content' => 'contents/view_stations',
            'menu_data' => ['curr_menu' => 'STATIONS', 'curr_sub_menu' => 'STATIONS'],
            'content_data' => [
                'module_name' => $customer['pc_name'] . ' Stations',
                'customer' => $customer,
                'stations' => $stations
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function setStation() {

        if (!$this->usr->isLogedin()) {
            $this->session->set_flashdata('error', 'Login is required');
            redirect('user/index');
        }

        $station_id = $this->uri->segment(3);
        $user_id = $this->session->userdata['logged_in']['user_id'];

        $station = $this->stn->canAccessStation($user_id, $station_id);


        if ($station) {

            $this->session->userdata['logged_in']['user_station_id'] = $station['station_id'];
            $this->session->userdata['logged_in']['user_station_name'] = $station['station_name'];
            $this->session->userdata['logged_in']['user_station_role'] = $station['organize_user_role'];

            redirect('user/dashboard');
        } else {
            $this->session->set_flashdata('error', 'Select a valid station');
            redirect('station');
        }
    }

    public function purchaseOrders() {

        // check session status of the user
        $this->checkStatus(1, 1, 1);

        $data = [
            'menu' => 'menu/view_stations_menu',
            'content' => 'contents/station/view_purchase_orders',
            'menu_data' => ['curr_menu' => 'PURCHASE', 'curr_sub_menu' => 'PURCHASE'],
            'content_data' => [
                'module_name' => 'Purchase Orders',
                'customer' => $this->customer
            ],
            'modals_data' => [// Modals data
                'modals' => ['modal_add_purchase_order_hq'], // Put array of popup modals which you want them to appear on current page
                'fuel_types_group' => $this->mnt->getFuelTypesGroup(), // Pass data for popup modals here
                'station_depots' => $this->depo->getDepots(['depo.depo_admin_id' => $this->admin_id]), // Get station depots for creating purchase order
                'delivery_points' => $this->stn->getUserStations($this->user_id, $this->admin_id)
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function releaseInstructions() {

        // check session status of the user
        $this->checkStatus(1, 1, 1);

        $data = [
            'menu' => 'menu/view_stations_menu',
            'content' => 'contents/station/view_release_instructions',
            'menu_data' => ['curr_menu' => 'PURCHASE', 'curr_sub_menu' => 'PURCHASE'],
            'content_data' => [
                'module_name' => 'Release Instructions',
                'customer' => $this->customer
            ],
            'modals_data' => [// Modals data
                'modals' => ['modal_add_release_instruction'], // Put array of popup modals which you want them to appear on current page
                'depots' => $this->depo->getDepots(['depo.depo_admin_id' => $this->admin_id]) // Get station depots for creating purchase order
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function releaseInstructionInfo() {

        // check session status of the user
        $this->checkStatus(1, 1, 1);

        $ri_id = $this->uri->segment(3);

        $cols = ['u.user_name','ri.ri_id','ri.ri_number','ri.ri_loading_date','depo.depo_name','seller.pc_name seller_name','customer.pc_name customer_name', 'customer.pc_contact_text','customer.pc_logo','customer.pc_slogan'];
        $ri = $this->purchase->getReleaseInstructionInfo($ri_id,$cols);

        if (!$ri) {
            $this->setSessMsg('Release instruction was not found or it may havebeen removed from the system', 'error', 'station/releaseinstructions');
        }

        $cols = ['po.po_id','po.po_date','po.po_number','po.po_volume','ftg.fuel_type_group_id','ftg.fuel_type_group_name','po.po_driver_name','po.po_driver_license','po.po_truck_number','st.station_name','po.po_status'];
        $ri_orders = $this->purchase->getPurchaseOrders(['po.po_ri_id' => $ri['ri_id']], null, $cols);
        
       
        $stations = $this->stn->getUserStations($this->user_id, $this->admin_id);
        $station_ids = array_column($stations, 'station_id');


        $data = [
            'menu' => 'menu/view_stations_menu',
            'content' => 'contents/station/view_release_instruction_info',
            'menu_data' => ['curr_menu' => 'PURCHASE', 'curr_sub_menu' => 'PURCHASE'],
            'content_data' => [
                'module_name' => 'Release Instructions No. ' . $ri['ri_number'],
                'customer' => $this->customer,
                'ri' => $ri,
                'ri_orders' => $ri_orders,
                'ri_vessels' => $this->purchase->getRiVessels($ri['ri_id']),
                'ri_fuel_types' => $this->purchase->getRiFuelTypes($ri['ri_id'])
            ],
            'modals_data' => [// Modals data
                'modals' => ['modal_add_po_in_ri'], // Put array of popup modals which you want them to appear on current page
                'ri_id' => $ri['ri_id'],
                'pos' => $this->purchase->getPurchaseOrders(['po.po_ri_id' => NULL], NULL, ['po.po_id', 'po.po_number', 'po.po_driver_name', 'po.po_truck_number', 'ftg.fuel_type_group_name'], ['po.po_station_id' => $station_ids])
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }
    
    public function pdfReleaseInstructionInfo() {

        ini_set('memory_limit', '50M'); // boost the memory limit if it's low ;)
        
        // check session status of the user
        $this->checkStatus(1, 1, 1);

        $ri_id = $this->uri->segment(3);

        $cols = ['u.user_name','ri.ri_id','ri.ri_number','ri.ri_loading_date','depo.depo_name','seller.pc_name seller_name','customer.pc_name customer_name', 'customer.pc_contact_text','customer.pc_logo','customer.pc_slogan'];
        $ri = $this->purchase->getReleaseInstructionInfo($ri_id,$cols);

        if (!$ri) {
            $this->setSessMsg('Release instruction was not found or it may havebeen removed from the system', 'error', 'station/releaseinstructions');
        }

        $cols = ['po.po_id','po.po_date','po.po_number','po.po_volume','ftg.fuel_type_group_id','ftg.fuel_type_group_name','po.po_driver_name','po.po_driver_license','po.po_truck_number','st.station_name','po.po_status'];
        $ri_orders = $this->purchase->getPurchaseOrders(['po.po_ri_id' => $ri['ri_id']], null, $cols);
        
        $ri_fuel_types = $this->purchase->getRiFuelTypes($ri['ri_id']);
  

        $data = ['ri_orders' => $ri_orders,'ri' => $ri, 'ri_vessels' => $this->purchase->getRiVessels($ri['ri_id']),'ri_fuel_types' => $ri_fuel_types];
        
        $html = $this->load->view('export/view_export_release_instruction', $data, true); // render the view into HTML


        $this->load->library('pdf');

        $pdf = $this->pdf->load();


        $pdf->SetFooter($ri['pc_contact_text']); // Add a footer for good measure ;)

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->Output();
        return;
    }

    public function ajaxPurchaseOrders() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        // check session status of the user
        $this->checkStatusJson(1, 1, 1);

        $data = [];
        $station_ids = [];
        $type = $_POST['type'];
        $no = $_POST['start'];
        $stations = $this->stn->getUserStations($this->user_id, $this->admin_id);
        $station_ids = array_column($stations, 'station_id');

        $list = $this->purchase->get_datatables_purchase_order("", $station_ids);


        foreach ($list as $p) {

            $no++;
            $row = array();
            $status = "";
            $driver = "";

            $driver .= "<div class='text-nowrap'>";
            $driver .= $p->po_driver_name;
            $driver .= !empty($p->po_driver_license) ? '<br/>' . $p->po_driver_license : '';
            $driver .= "</div>";

            switch ($p->po_status) {
                case 'NEW':
                    $status .= "<h5><span class='badge badge-info'>NEW</span></h5>";
                    break;
                case 'LOADED':
                    $status .= "<h4><span class='badge badge-success'>LOADED</span></h4>";
                    break;
                case 'UNRELEASED':
                    $status .= "<h4><span class='badge badge-warning'>UNRELEASED</span></h4>";
                    break;
            }


            $row[] = $p->po_number;
            $row[] = $p->po_date;
            $row[] = $p->fuel_type_group_name;
            $row[] = $p->po_volume;
            $row[] = $driver;
            $row[] = $p->po_truck_number;
            $row[] = $status;
            $row[] = $p->station_name;


            $actions = "";

            $actions .= '
                <div class="dropdown">
                    <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                ';

            $actions .= '
                <a href="' . site_url('applicant/applicantdetails/' . $p->po_id) . '" class="dropdown-item text-success applicant_details"> <i class="fa fa-check-circle-o"></i>&nbsp;&nbsp;Approval</a>
                <a href="#" class="dropdown-item"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;PDF Preview</a>
                                            ';

            $actions .= '</div>'
                    . '</div>';

            $row[] = $actions;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase->count_all_purchase_order($type, $station_ids),
            "recordsFiltered" => $this->purchase->count_filtered_purchase_order($type, $station_ids),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }

    public function ajaxreleaseinstructions() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        // check session status of the user
        $this->checkStatusJson(1, 1, 1);

        $data = [];
        $type = $_POST['type'];
        $no = $_POST['start'];

        $list = $this->purchase->get_datatables_release_instructions();


        foreach ($list as $ri) {

            $no++;
            $row = array();
            $status = "";

            switch ($ri->ri_status) {
                case 'NEW':
                    $status .= "<h4><span class='badge badge-info'>NEW</span></h4>";
                    break;
                case 'LOADED':
                    $status .= "<h4><span class='badge badge-success'>LOADED</span></h4>";
                    break;
                case 'UNRELEASED':
                    $status .= "<h4><span class='badge badge-warning'>UNRELEASED</span></h4>";
                    break;
            }


            $row[] = $ri->ri_number;
            $row[] = $ri->ri_loading_date;
            $row[] = $ri->depo_name;

            $row[] = $status;

            $actions = "";

            $actions .= '<a href="' . site_url('station/releaseinstructioninfo/' . $ri->ri_id) . '" class="btn btn-primary btn-sm"> <i class="fa fa-search"></i></a>';

            $row[] = $actions;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase->count_all_release_instructions(),
            "recordsFiltered" => $this->purchase->count_filtered_release_instructions(),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }

    public function validatePoStationId($station_id) {
        return TRUE;
    }

    public function validateOrderDate($po_date) {
        return TRUE;
    }

    public function validateRILoadingDate($loading_date) {
        return TRUE;
    }

    public function submitCreateOrderHq() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $validations = [
                ['field' => 'order_date', 'label' => 'Order Date', 'rules' => 'trim|required|callback_validateOrderDate', 'errors' => ['required' => 'Select the order date.']],
                ['field' => 'po_station_id', 'label' => 'Delivery Point', 'rules' => 'trim|required|callback_validatePoStationId'],
                ['field' => 'po_depo_id', 'label' => 'Depo', 'rules' => 'trim|required'],
                ['field' => 'volume_ordered', 'label' => 'Volume ordered', 'rules' => 'trim|required|numeric'],
                ['field' => 'truck_number', 'label' => 'Truck Number', 'rules' => 'trim|required'],
                ['field' => 'driver_name', 'label' => 'Driver Name', 'rules' => 'trim|required'],
                ['field' => 'driver_license', 'label' => 'Driver License', 'rules' => 'trim|required'],
                ['field' => 'po_vessel_id', 'label' => 'Vessel', 'rules' => 'trim|required']
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
                'po_depo_id' => $this->input->post('po_depo_id'),
                'po_station_id' => $this->input->post('po_station_id'),
                'po_user_id' => $this->user_id,
                'po_truck_number' => $this->input->post('truck_number'),
                'po_volume' => $this->input->post('volume_ordered'),
                'po_driver_name' => $this->input->post('driver_name'),
                'po_status' => 'UNRELEASED',
                'po_vessel_id' => $vessel['vessel_id'],
                'po_fuel_type_group_id' => $vessel['vessel_fuel_type_group_id'],
                'po_driver_license' => $this->input->post('driver_license')
            ];

            $res = $this->purchase->savePurchaseOrder(['order_data' => $order_data]);

            if ($res) {
                $this->setSessMsg('Order created succesffuly', 'success');

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('station/purchaseorders')
                    ]
                ]);
            } else {
                cus_json_error('Unable to create new order please refresh the page and try again.');
            }
        }
    }

    public function submitReleaseInstruction() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $validations = [
                ['field' => 'loading_date', 'label' => 'Loading Date', 'rules' => 'trim|required|callback_validateRILoadingDate', 'errors' => ['required' => 'Select the order date.']],
                ['field' => 'depo_id', 'label' => 'Depot', 'rules' => 'trim|required']
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


            $ri_data = [
                'ri_loading_date' => date('Y-m-d', strtotime($this->input->post('loading_date'))),
                'ri_admin_id' => $this->admin_id,
                'ri_depo_id' => $this->input->post('depo_id'),
                'ri_user_id' => $this->user_id,
                'ri_status' => 'NEW'
            ];

            $res = $this->purchase->saveReleaseInstruction(['ri_data' => $ri_data]);

            if ($res) {
                $this->setSessMsg('Release instruction created succesffuly', 'success');

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('station/releaseinstructions')
                    ]
                ]);
            } else {
                cus_json_error('Unable to create new order please refresh the page and try again.');
            }
        }
    }

    public function validatePoIdForRi($po_id) {
        return TRUE;
    }

    public function submitPoInRi($param) {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $ri_id = $this->uri->segment(3);

        $ri = $this->purchase->getReleaseInstructionInfo($ri_id);

        if (!$ri) {
            cus_json_error('Release Instruction was not found or it may have been removed from the system');
        }

        $validations = [
                ['field' => 'po_id[]', 'label' => 'Purchase Order', 'rules' => 'trim|required|callback_validatePoIdForRi', 'errors' => []]
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
        }

        $stations = $this->stn->getUserStations($this->user_id, $this->admin_id);
        $station_ids = array_column($stations, 'station_id');
        

        $po_ids = $this->input->post('po_id');

        $po_data = [
            'po_ri_id' => $ri['ri_id']
        ];

        if ($this->purchase->updatePo($po_data, NULL,$po_ids)) {
            
            $this->setSessMsg('Purchase order added in release instruction successfully!', 'success');
            echo json_encode([
                'status' => [
                    'error' => FALSE,
                    'redirect' => true,
                    'redirect_url' => site_url('station/releaseinstructioninfo/' . $ri['ri_id'])
                ]
            ]);
        } else {
            cus_json_error('Something went wrong please refresh the page');
        }
    }
    
    
    public function removePoFromRi() {
        
        $this->checkStatus(1,1,1);
        
        $po_id = $this->uri->segment(3);
        
        $po = $this->purchase->getPurchaseOrders(['po_id' => $po_id],1,['po.po_id','po.po_ri_id']);
        
        if(!$po){
            $this->setSessMsg('Purchase order may have been removed from release instruction.', 'info','station/releaseinstructions');
        }
        
        if($this->purchase->updatePo(['po_ri_id' => NULL],['po_id' => $po['po_id']])){
            $this->setSessMsg('Purchase order removed successfully.', 'success', 'station/releaseinstructioninfo/'. $po['po_ri_id']);
        }else{
            $this->setSessMsg('Something went wrong. Please try again', 'warning','station/releaseinstructioninfo/'. $po['po_ri_id']);
        }
    }

}
