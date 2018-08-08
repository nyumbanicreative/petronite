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
                'module_name' => $customer['pc_name'] . ' - Stations',
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
            $this->session->userdata['logged_id']['user_station_auto_rtt'] = $station['station_auto_rtt'];

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
                'modals' => ['modal_add_purchase_order_hq', 'modal_edit_purchase_order_hq'], // Put array of popup modals which you want them to appear on current page
                'fuel_types_group' => $this->mnt->getFuelTypesGroup(), // Pass data for popup modals here
                'station_depots' => $this->depo->getDepots(['depo.depo_admin_id' => $this->admin_id]), // Get station depots for creating purchase order
                'delivery_points' => $this->stn->getUserStations($this->user_id, $this->admin_id),
                'drivers' => $this->usr->getUsersList(['user_admin_id' => $this->admin_id, 'user_role' => 'driver']),
                'suppliers' => $this->sup->getSuppliers(['sup.supplier_admin_id' => $this->admin_id])
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function createPurchaseOrder() {

        // check session status of the user
        $this->checkStatus(1, 1, 1);

        $data = [
            'menu' => 'menu/view_stations_menu',
            'content' => 'contents/station/view_create_purchase_order',
            'menu_data' => ['curr_menu' => 'PURCHASE', 'curr_sub_menu' => 'PURCHASE'],
            'content_data' => [
                'module_name' => 'Create Purchase Order',
                'customer' => $this->customer,
                'drivers' => $this->usr->getUsersList(['user_admin_id' => $this->admin_id, 'user_role' => 'driver']),
                'suppliers' => $this->sup->getSuppliers(['sup.supplier_admin_id' => $this->admin_id]),
                'ftgs' => $this->mnt->getFuelTypesGroup()
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
                'depots' => $this->depo->getDepots(['depo.depo_admin_id' => $this->admin_id]), // Get station depots for creating purchase order
                'authorizers' => $this->usr->getUsersList("user_admin_id ='" . $this->admin_id . "' AND user_role NOT IN ('attendant','driver','developer','manager')")
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

        $cols = ['u.user_name', 'ri.ri_status', 'ri.ri_id', 'ri.ri_number', 'ri.ri_loading_date', 'depo.depo_name', 'seller.pc_name seller_name', 'customer.pc_name customer_name', 'customer.pc_contact_text', 'customer.pc_logo', 'customer.pc_slogan'];
        $ri = $this->purchase->getReleaseInstructionInfo($ri_id, $cols);

        if (!$ri) {
            $this->setSessMsg('Release instruction was not found or it may havebeen removed from the system', 'error', 'station/releaseinstructions');
        }

        $cols = ['poq.order_qty', 'po.po_id', 'po.po_date', 'po.po_number', 'd.user_fullname po_driver_name', 'd.user_driving_license po_driver_license', 'po.po_truck_number', 'st.station_name'];
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
                'modals' => ['modal_add_po_in_ri', 'modal_edit_purchase_order_hq'], // Put array of popup modals which you want them to appear on current page
                'ri_id' => $ri['ri_id'],
                'pos' => $this->purchase->getPurchaseOrders(['po.po_ri_id' => NULL], NULL, ['po.po_id', 'poq.order_qty', 'po.po_number', 'd.user_fullname po_driver_name', 'po.po_truck_number'], ['po.po_station_id' => $station_ids]),
                'station_depots' => $this->depo->getDepots(['depo.depo_admin_id' => $this->admin_id]), // Get station depots for creating purchase order
                'delivery_points' => $this->stn->getUserStations($this->user_id, $this->admin_id),
                'drivers' => $this->usr->getUsersList(['user_admin_id' => $this->admin_id, 'user_role' => 'driver'])
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

        $cols = ['u.user_name', 'ri.ri_status', 'ri.ri_id', 'ri.ri_number', 'ri.ri_loading_date', 'depo.depo_name', 'seller.pc_name seller_name', 'customer.pc_name customer_name', 'customer.pc_contact_text', 'customer.pc_logo', 'customer.pc_slogan', 'auth.user_fullname auth_name'];
        $ri = $this->purchase->getReleaseInstructionInfo($ri_id, $cols);

        if (!$ri) {
            $this->setSessMsg('Release instruction was not found or it may havebeen removed from the system', 'error', 'station/releaseinstructions');
        }

        $cols = ['poq.order_qty', 'po.po_id', 'po.po_date', 'po.po_number', 'po.po_volume', 'd.user_fullname po_driver_name', 'd.user_driving_license po_driver_license', 'po.po_truck_number'];
        $ri_orders = $this->purchase->getPurchaseOrders(['po.po_ri_id' => $ri['ri_id']], null, $cols);

        $ri_fuel_types = $this->purchase->getRiFuelTypes($ri['ri_id']);


        $data = ['ri_orders' => $ri_orders, 'ri' => $ri, 'ri_vessels' => $this->purchase->getRiVessels($ri['ri_id']), 'ri_fuel_types' => $ri_fuel_types, 'contact_text' => $ri['pc_contact_text']];

        $html = $this->load->view('export/view_export_release_instruction', $data, true); // render the view into HTML

        $this->load->library('pdf');

        $pdf = $this->pdf->load('c', 'A4');

        $pdf->SetFooter('|Powered By Petronite<br>www.petronite.com|');
        //$pdf->SetFooter($ri['pc_contact_text']); // Add a footer for good measure ;)

        $pdf->WriteHTML($html); // write the HTML into the PDF

        $pdf->Output();
        return;
    }

    public function pdfPurchaseOrderInfo() {

        ini_set('memory_limit', '50M'); // boost the memory limit if it's low ;)
        // check session status of the user
        $this->checkStatus(1, 1, 1);

        $po_id = $this->uri->segment(3);

        $po = $this->purchase->getPurchaseOrders(['po.po_id' => $po_id], 1);


        if (!$po) {
            $this->setSessMsg('Purchase order was not found or it may havebeen removed from the system', 'error', 'station/purchaseorders');
        }

        $qty_in_words = '';

        $order_qty = [];

        if (cus_is_json('[' . $po['order_qty'] . ']')) {
            $order_qty = json_decode('[' . $po['order_qty'] . ']');
        }


        if (class_exists('NumberFormatter')) {
            $f = new NumberFormatter('en', NumberFormatter::SPELLOUT);

            foreach ($order_qty as $j => $oq) {
                $qty_in_words .= $j > 0 ? ", " : " ";

                if (AGO == $oq->poq_ftg_id) {
                    $qty_in_words .= ucwords($f->format(round($oq->poq_volume))) . ' Litres Of <b>DIESEL</b>';
                } elseif (PMS == $oq->poq_ftg_id) {
                    $qty_in_words .= ucwords($f->format(round($oq->poq_volume))) . ' Litres Of <b>SUPER</b>';
                } elseif (IK == $oq->poq_ftg_id) {
                    $qty_in_words .= ucwords($f->format(round($oq->poq_volume))) . ' Litres Of <b>KEROSENE</b>';
                }
            }


            $qty_in_words .= ' Only';
        }


        $data = ['po' => $po, 'contact_text' => $po['pc_contact_text'], 'qty_in_words' => $qty_in_words];

        $html = $this->load->view('export/view_export_purchase_order', $data, true); // render the view into HTML


        $this->load->library('pdf');

        $pdf = $this->pdf->load('c', 'A4');

        $pdf->SetFooter('|Powered By Petronite<br>www.petronite.com|'); // Add a footer for good measure ;)

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
        
        $list = $this->purchase->get_datatables_purchase_order("", $this->admin_id);


        foreach ($list as $p) {

            $no++;
            $row = array();
            $status = "<div class='text-nowrap'>";
            $driver = "";
            $volume = "<div class='text-nowrap'>";
            $delivery = "<div class='text-nowrap'>";
            $order_qty = [];
            $can_edit = FALSE;

            if (cus_is_json('[' . $p->order_qty . ']')) {
                $order_qty = json_decode('[' . $p->order_qty . ']');
            }

            foreach ($order_qty as $i => $oq) {
                if ($i > 0) {
                    $volume .= '<br/>';
                }
                $volume .= $oq->product . ' - ' . $oq->poq_volume;
            }

            foreach ($order_qty as $i => $oq) {
                if ($i > 0) {
                    $delivery .= '<br/>';
                }
                $delivery .= $oq->product . ' - ' . $oq->station_name;
            }

            $volume .= "</div>";
            $delivery .= "</div>";

            $driver .= "<div class='text-nowrap'>";
            $driver .= $p->po_driver_name;
            $driver .= !empty($p->po_driver_license) ? '<br/>' . $p->po_driver_license : '';
            $driver .= "</div>";

            foreach ($order_qty as $i => $oq) {

                switch ($oq->poq_status) {

                    case 'NEW':
                        $status .= "<h5><span class='badge badge-info'>" . $oq->product . " - NEW</span></h5>";
                        $can_edit = TRUE;
                        break;
                    case 'LOADED':
                        $status .= "<h5><span class='badge badge-info'>" . $oq->product . " - LOADED</span></h5>";
                        break;
                    case 'UNRELEASED':
                        $status .= "<h5><span class='badge badge-danger'>" . $oq->product . " - UNRELEASED</span></h5>";
                        $can_edit = TRUE;
                        break;
                    case 'RELEASED':
                        $status .= "<h5><span class='badge badge-warning'>" . $oq->product . " - RELEASED</span></h5>";
                        break;
                    case 'DELIVERED':
                        $status .= "<h5><span class='badge badge-success'>" . $oq->product . " - DELIVERED</span></h5>";
                        break;
                }
            }

            $status .= "</div>";

            $row[] = "<div class='text-nowrap'>" . $p->po_number . '</div>';
            $row[] = "<div class='text-nowrap'>" . $p->po_date . '</div>';
            $row[] = $volume;
            $row[] = $driver;
            $row[] = "<div class='text-nowrap'>" . $p->po_truck_number . '</div>';
            $row[] = $status;
            $row[] = $delivery;


            $actions = "";

            $actions .= '
                <div class="dropdown">
                    <button type="button" id="closeCard2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="btn btn-info btn-sm"><i class="fa fa-ellipsis-v"></i></button>
                        <div aria-labelledby="closeCard2" class="dropdown-menu dropdown-menu-right has-shadow">
                                                ';

            // $actions .= '<a href="' . site_url('station/editpurchaseorder/' . $p->po_id) . '" class="dropdown-item text-success"> <i class="fa fa-list"></i>&nbsp;&nbsp;PO Details</a>';
            if ($can_edit) {
                $actions .= '<a href="' . site_url('station/requesteditpoform/' . $p->po_id) . '?url=' . site_url('station/purchaseorders') . '" class="dropdown-item text-info request_form"> <i class="fa fa-edit"></i>&nbsp;&nbsp;Edit LPO</a>';
            }


//            if ($p->po_status == 'UNRELEASED') {
//                $actions .= '<!-- <a href="' . site_url('station/editpurchaseorder/' . $p->po_id) . '" class="dropdown-item text-danger confirm"> <i class="fa fa-trash"></i>&nbsp;&nbsp;Delete LPO</a> -->';
//            }

            $actions .= '<a href="' . site_url('station/pdfpurchaseorderinfo/' . $p->po_id) . '" target="_blank" class="dropdown-item text-secondary"> <i class="fa fa-file-pdf-o"></i>&nbsp;&nbsp;Export PDF</a>';

            $actions .= '</div>'
                    . '</div>';

            $row[] = $actions;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->purchase->count_all_purchase_order($type, $this->admin_id),
            "recordsFiltered" => $this->purchase->count_filtered_purchase_order($type, $this->admin_id),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }

    public function requestEditPoForm() {

        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');


        // Check user session as usual
        $this->checkStatusJson(1, 1, 1);



        $diesel_qty = "";
        $super_qty = "";
        $kerose_qty = "";
        $selected_vessels = [];

        $po_id = $this->uri->segment(3);

        $url = $this->input->get('url');

        $po = $this->purchase->getPurchaseOrders(['po_id' => $po_id], 1);



        if (!$po) {
            cus_json_error('Purchase order was not found or it may have been removed form the system');
        }

        $order_qty = [];


        if (cus_is_json('[' . $po['order_qty'] . ']')) {
            $order_qty = json_decode('[' . $po['order_qty'] . ']');
        }

        foreach ($order_qty as $i => $oq) {

            $selected_vessels[] = $oq->poq_vessel_id;

            if ($oq->poq_ftg_id == AGO) {
                $diesel_qty = $oq->poq_volume;
            } elseif ($oq->poq_ftg_id == PMS) {
                $super_qty = $oq->poq_volume;
            } elseif ($oq->poq_ftg_id == IK) {
                $kerose_qty = $oq->poq_volume;
            }
        }

        $depo_vessels = $this->depo->getStockVessels(['vessel_depot_id' => $po['po_depo_id'], 'vessel_status <>' => 'CLOSED']);

        foreach ($depo_vessels as $dv) {
            $vessels[] = ['text' => $dv['vessel_name'], 'id' => $dv['vessel_id']];
        }



        $data['po'] = $po;
        $data['vessels'] = $vessels;
        $data['selected_vessels'] = $selected_vessels;

        $data['poq'] = [
            'diesel_qty' => $diesel_qty,
            'super_qty' => $super_qty,
            'kerosene_qty' => $kerose_qty
        ];

        echo json_encode([
            'status' => [
                'error' => FALSE,
                'redirect' => FALSE,
                'pop_form' => TRUE,
                'form_type' => 'editPurchaseOrder',
                'form_url' => site_url('station/submiteditorderhq/' . $po['po_id']) . '?url=' . $url,
                'form_data' => $data
            ]
        ]);

        die();
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
                case 'RELEASED':
                    $status .= "<h4><span class='badge badge-success'>RELEASED</span></h4>";
                    break;
                case 'UNRELEASED':
                    $status .= "<h4><span class='badge badge-warning'>UNRELEASED</span></h4>";
                    break;
            }


            $row[] = $ri->ri_number;
            $row[] = $ri->ri_loading_date;
            $row[] = $ri->depo_name;
            $row[] = $ri->authorizer;

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

    public function validateEditPoStationId($station_id) {
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
            //['field' => 'po_station_id', 'label' => 'Delivery Point', 'rules' => 'trim|required|callback_validatePoStationId'],
            //['field' => 'po_depo_id', 'label' => 'Depo', 'rules' => 'trim|required'],
            //['field' => 'super_qty', 'label' => 'super quantity', 'rules' => 'trim|numeric|callback_validateSuperQty'],
            //['field' => 'diesel_qty', 'label' => 'diesel quantity', 'rules' => 'trim|numeric|callback_validateDieselQty'],
            //['field' => 'kerosene_qty', 'label' => 'kerosene quantity', 'rules' => 'trim|numeric|callback_validateKeroseneQty'],
            ['field' => 'truck_number', 'label' => 'Truck Number', 'rules' => 'trim|required'],
                ['field' => 'driver_id', 'label' => 'Driver', 'rules' => 'trim|required'],
                ['field' => 'lpo_notes', 'label' => 'Purchase order notes', 'rules' => 'trim'],
                ['field' => 'supplier_id', 'label' => 'Supplier', 'rules' => 'trim|required'],
                ['field' => 'product[]', 'label' => 'Product type', 'rules' => 'trim|required'],
                ['field' => 'qty[]', 'label' => 'Order quantity', 'rules' => 'trim|required'],
                //['field' => 'price[]', 'label' => 'Unit Price', 'rules' => 'trim|required'],
                //['field' => 'po_vessel_id[]', 'label' => 'Vessel', 'rules' => 'trim|required|callback_validatePoVessels']
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


            $po_qty_data = [];
            $products = $this->input->post('product[]');
            $qty = $this->input->post('qty[]');
            $price = $this->input->post('price[]');


            foreach ($products as $key => $p) {
                $po_qty_data[] = [
                    'poq_ftg_id' => $p,
                    'poq_volume' => $qty[$key],
                    'poq_unit_price' => $price[$key]
                ];
            }
           

            $transfer_note_data = [
                'stn_status' => 'GENERATED'
            ];


            $order_data = [
                'po_date' => date('Y-m-d', strtotime($this->input->post('order_date'))),
//                'po_depo_id' => $this->input->post('po_depo_id'),
//                'po_station_id' => $this->input->post('po_station_id'),
                'po_user_id' => $this->user_id,
                'po_truck_number' => $this->input->post('truck_number'),
//                'po_volume' => $this->input->post('volume_ordered'),
                'po_driver_id' => $this->input->post('driver_id'),
                'po_notes' => $this->input->post('lpo_notes'),
                'po_admin_id' => $this->usr->admin_id,
                'po_supplier_id' => $this->input->post('supplier_id'),
                'po_status' => 'UNRELEASED'
//                'po_vessel_id' => $vessel['vessel_id'],
//                'po_fuel_type_group_id' => $vessel['vessel_fuel_type_group_id']
            ];

            $res = $this->purchase->savePurchaseOrder(['order_data' => $order_data, 'po_qty_data' => $po_qty_data,  'transfer_note_data' => $transfer_note_data], $this->admin_id); //'vessels' => $vessels,

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

    public function submitEditOrderHq() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $po_id = $this->uri->segment(3);

        $url = $this->input->get('url');

        $po = $this->purchase->getPurchaseOrders(['po_id' => $po_id], 1);

        if (!$po) {
            cus_json_error('Purchase order was not found or it may have been removed form the system');
        }

        $validations = [
                ['field' => 'edit_order_date', 'label' => 'Order Date', 'rules' => 'trim|required|callback_validateOrderDate', 'errors' => ['required' => 'Select the order date.']],
                ['field' => 'edit_po_station_id', 'label' => 'Delivery Point', 'rules' => 'trim|required|callback_validateEditPoStationId'],
                ['field' => 'edit_po_depo_id', 'label' => 'Depo', 'rules' => 'trim|required'],
                ['field' => 'edit_super_qty', 'label' => 'super quantity', 'rules' => 'trim|numeric|callback_validateEditSuperQty'],
                ['field' => 'edit_diesel_qty', 'label' => 'diesel quantity', 'rules' => 'trim|numeric|callback_validateEditDieselQty'],
                ['field' => 'edit_kerosene_qty', 'label' => 'kerosene quantity', 'rules' => 'trim|numeric|callback_validateEditKeroseneQty'],
                ['field' => 'edit_truck_number', 'label' => 'Truck Number', 'rules' => 'trim|required'],
                ['field' => 'edit_driver_id', 'label' => 'Driver', 'rules' => 'trim|required'],
                ['field' => 'edit_po_vessel_id[]', 'label' => 'Vessel', 'rules' => 'trim|required|callback_validateEditPoVessels']
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


            $vessel_ids = $this->input->post('edit_po_vessel_id[]');
            $vessels = $this->depo->getStockVessels(NULL, NULL, $vessel_ids);

            $super_qty = $this->input->post('edit_super_qty');
            $diesel_qty = $this->input->post('edit_diesel_qty');
            $kerosene_qty = $this->input->post('edit_kerosene_qty');
            $station_id = $this->input->post('edit_po_station_id');

            if (empty($super_qty) AND empty($diesel_qty) AND empty($diesel_qty)) {
                cus_json_error('Atleast one product (Diesel, Super or Kerosine) should have volume ordered');
            }

            if (count($vessels) !== count($vessel_ids)) {
                cus_json_error('One or more vessel was not found');
            }

            $po_qty_data = [];

            if (!empty($super_qty)) {
                $po_qty_data[] = [
                    'poq_ftg_id' => PMS,
                    'poq_volume' => $super_qty,
                    'poq_station_id' => $station_id
                ];
            }

            if (!empty($kerosene_qty)) {
                $po_qty_data[] = [
                    'poq_ftg_id' => IK,
                    'poq_volume' => $kerosene_qty,
                    'poq_station_id' => $station_id
                ];
            }

            if (!empty($diesel_qty)) {
                $po_qty_data[] = [
                    'poq_ftg_id' => AGO,
                    'poq_volume' => $diesel_qty,
                    'poq_station_id' => $station_id
                ];
            }


            $order_data = [
                'po_date' => date('Y-m-d', strtotime($this->input->post('edit_order_date'))),
                'po_depo_id' => $this->input->post('edit_po_depo_id'),
                'po_station_id' => $station_id,
                'po_truck_number' => $this->input->post('edit_truck_number'),
                'po_driver_id' => $this->input->post('edit_driver_id'),
            ];

            $res = $this->purchase->saveEdittPurchaseOrder(['po_id' => $po['po_id'], 'order_data' => $order_data, 'po_qty_data' => $po_qty_data, 'vessels' => $vessels], $this->admin_id);

            if ($res) {
                $this->setSessMsg('Order edited succesffuly', 'success');

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => !empty($url) ? $url : site_url('station/purchaseorders')
                    ]
                ]);
            } else {
                cus_json_error('Nothing was updated');
            }
        }
    }

    public function orderDelivery() {

        // check session status of the user
        $this->checkStatus(1, 1, 1);

        $orders = $this->purchase->getPurchaseOrders(['st.station_admin_id' => $this->admin_id, 'po_status' => 'LOADED'], NULL, ['po.po_id', 'po.po_number']);

        $data = [
            'menu' => 'menu/view_stations_menu',
            'content' => 'contents/station/view_order_delivery',
            'menu_data' => ['curr_menu' => 'PURCHASE', 'curr_sub_menu' => 'PURCHASE'],
            'content_data' => [
                'module_name' => 'Orders Delivery',
                'customer' => $this->customer
            ],
            'modals_data' => [// Modals data
                'modals' => ['modal_add_order_delivery'], // Put array of popup modals which you want them to appear on current page
                'depots' => $this->depo->getDepots(['depo.depo_admin_id' => $this->admin_id]), // Get station depots for creating purchase order
                'authorizers' => $this->usr->getUsersList(['user_admin_id' => $this->admin_id, 'user_role <>' => 'attendant']),
                'orders' => $orders
            ],
            'header_data' => [],
            'footer_data' => [],
            'top_bar_data' => []
        ];

        $this->load->view('view_base', $data);
    }

    public function submitReleaseInstruction() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->checkStatusJson(1, 1, 1);

        $validations = [
                ['field' => 'loading_date', 'label' => 'Loading Date', 'rules' => 'trim|required|callback_validateRILoadingDate', 'errors' => ['required' => 'Select the order date.']],
                ['field' => 'depo_id', 'label' => 'Depot', 'rules' => 'trim|required'],
                ['field' => 'auth_id', 'label' => 'Authorizer', 'rules' => 'trim|required']
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
                'ri_status' => 'NEW',
                'ri_authorizer_id' => $this->input->post('auth_id')
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
            'po_ri_id' => $ri['ri_id'],
            'po_status' => 'RELEASED'
        ];

        if ($this->purchase->updatePo($po_data, NULL, $po_ids)) {

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

        $this->checkStatus(1, 1, 1);

        $po_id = $this->uri->segment(3);

        $po = $this->purchase->getPurchaseOrders(['po_id' => $po_id], 1, ['po.po_id', 'po.po_ri_id']);

        if (!$po) {
            $this->setSessMsg('Purchase order may have been removed from release instruction.', 'info', 'station/releaseinstructions');
        }

        if ($this->purchase->updatePo(['po_ri_id' => NULL, 'po_status' => 'UNRELEASED'], ['po_id' => $po['po_id']])) {
            $this->setSessMsg('Purchase order removed successfully.', 'success', 'station/releaseinstructioninfo/' . $po['po_ri_id']);
        } else {
            $this->setSessMsg('Something went wrong. Please try again', 'warning', 'station/releaseinstructioninfo/' . $po['po_ri_id']);
        }
    }

    public function markRiAsReleased() {

        $this->checkStatus(1, 1, 1);

        $ri_id = $this->uri->segment(3);
        $ri = $this->purchase->getReleaseInstructionInfo($ri_id, ['ri.ri_id', 'ri.ri_status']);

        if (!$ri) {
            $this->setSessMsg('Release instruction was not found or it may have been removed from the system', 'error', 'station/releaseinstructions');
        }

        if (!in_array($ri['ri_status'], ['NEW'])) {
            $this->setSessMsg('Release instruction is not in a right status to be marked as released.', 'error', 'station/releaseinstructioninfo/' . $ri['ri_id']);
        }

        $pos = $this->purchase->getPurchaseOrders(['po_ri_id' => $ri['ri_id']], NULL, ['po_id']);

        if (!$pos) {
            $this->setSessMsg('Release instruction has no order added to be released', 'error', 'station/releaseinstructioninfo/' . $ri['ri_id']);
        }

        $po_ids = array_column($pos, 'po_id');

        if ($this->purchase->updateRi(['ri_status' => 'RELEASED'], ['ri_id' => $ri['ri_id']], NULL, $po_ids)) {
            $this->setSessMsg('Release instruction marked as RELEASED successfully', 'suucess', 'station/releaseinstructioninfo/' . $ri['ri_id']);
        } else {
            $this->setSessMsg('Something went wrong. Please try again', 'error', 'station/releaseinstructioninfo/' . $ri['ri_id']);
        }
    }

    public function validateSuperQty($super_qty) {

        $selected_vessels = $this->input->post('po_vessel_id[]');

        if (!empty($super_qty) AND ! empty($selected_vessels)) {
            $vessels = $this->depo->getStockVessels(NULL, NULL, $selected_vessels);
            $vessels_fuel_types = array_column($vessels, 'fuel_type_group_id');

            if (!in_array(PMS, $vessels_fuel_types)) {
                $this->form_validation->set_message('validateSuperQty', 'If super is to be ordered you should select its vessel, otherwise clear this field');
                return FALSE;
            }
        }

        return TRUE;
    }

    public function validateEditSuperQty($super_qty) {

        $selected_vessels = $this->input->post('edit_po_vessel_id[]');

        if (!empty($super_qty) AND ! empty($selected_vessels)) {
            $vessels = $this->depo->getStockVessels(NULL, NULL, $selected_vessels);
            $vessels_fuel_types = array_column($vessels, 'fuel_type_group_id');

            if (!in_array(PMS, $vessels_fuel_types)) {
                $this->form_validation->set_message('validateEditSuperQty', 'If super is to be ordered you should select its vessel, otherwise clear this field');
                return FALSE;
            }
        }

        return TRUE;
    }

    public function validateDieselQty($diesel_qty) {

        $selected_vessels = $this->input->post('po_vessel_id[]');

        if (!empty($diesel_qty) AND ! empty($selected_vessels)) {
            $vessels = $this->depo->getStockVessels(NULL, NULL, $selected_vessels);
            $vessels_fuel_types = array_column($vessels, 'fuel_type_group_id');

            if (!in_array(AGO, $vessels_fuel_types)) {
                $this->form_validation->set_message('validateDieselQty', 'If diesel is to be ordered you should select its vessel, otherwise clear this field');
                return FALSE;
            }
        }

        return TRUE;
    }

    public function validateEditDieselQty($diesel_qty) {

        $selected_vessels = $this->input->post('edit_po_vessel_id[]');

        if (!empty($diesel_qty) AND ! empty($selected_vessels)) {
            $vessels = $this->depo->getStockVessels(NULL, NULL, $selected_vessels);
            $vessels_fuel_types = array_column($vessels, 'fuel_type_group_id');

            if (!in_array(AGO, $vessels_fuel_types)) {
                $this->form_validation->set_message('validateEditDieselQty', 'If diesel is to be ordered you should select its vessel, otherwise clear this field');
                return FALSE;
            }
        }

        return TRUE;
    }

    public function validateEditKeroseneQty($kerosene_qty) {

        $selected_vessels = $this->input->post('edit_po_vessel_id[]');

        if (!empty($kerosene_qty) AND ! empty($selected_vessels)) {
            $vessels = $this->depo->getStockVessels(NULL, NULL, $selected_vessels);
            $vessels_fuel_types = array_column($vessels, 'fuel_type_group_id');

            if (!in_array(IK, $vessels_fuel_types)) {
                $this->form_validation->set_message('validateEditKeroseneQty', 'If kerosene is to be ordered you should select its vessel, otherwise clear this field');
                return FALSE;
            }
        }

        return TRUE;
    }

    public function validateKeroseneQty($kerosene_qty) {

        $selected_vessels = $this->input->post('po_vessel_id[]');

        if (!empty($kerosene_qty) AND ! empty($selected_vessels)) {
            $vessels = $this->depo->getStockVessels(NULL, NULL, $selected_vessels);
            $vessels_fuel_types = array_column($vessels, 'fuel_type_group_id');

            if (!in_array(IK, $vessels_fuel_types)) {
                $this->form_validation->set_message('validateKeroseneQty', 'If kerosene is to be ordered you should select its vessel, otherwise clear this field');
                return FALSE;
            }
        }

        return TRUE;
    }

    public function validatePoVessels($vessel_id) {

        $vessel = $this->depo->getStockVessels(['v.vessel_id' => $vessel_id], 1);
        $diesel_qty = $this->input->post('diesel_qty');
        $super_qty = $this->input->post('super_qty');
        $kerosene_qty = $this->input->post('kerosene_qty');

        if ($vessel AND ! empty($vessel_id)) {

            if ($vessel['fuel_type_group_id'] == AGO AND empty($diesel_qty)) {
                $this->form_validation->set_message('validatePoVessels', 'If ' . $vessel['vessel_name'] . ' - ' . $vessel['fuel_type_group_name'] . ' is selected, diesel qty field should not be empty, otherwise remove it');
                return FALSE;
            }

            if ($vessel['fuel_type_group_id'] == PMS AND empty($super_qty)) {
                $this->form_validation->set_message('validatePoVessels', 'If ' . $vessel['vessel_name'] . ' - ' . $vessel['fuel_type_group_name'] . ' is selected, super qty field should not be empty, otherwise remove it');
                return FALSE;
            }

            if ($vessel['fuel_type_group_id'] == IK AND empty($kerosene_qty)) {
                $this->form_validation->set_message('validatePoVessels', 'If ' . $vessel['vessel_name'] . ' - ' . $vessel['fuel_type_group_name'] . ' is selected, kerosene qty field should not be empty, otherwise remove it');
                return FALSE;
            }
        }

        return TRUE;
    }

    public function validateEditPoVessels($vessel_id) {

        $vessel = $this->depo->getStockVessels(['v.vessel_id' => $vessel_id], 1);
        $diesel_qty = $this->input->post('edit_diesel_qty');
        $super_qty = $this->input->post('edit_super_qty');
        $kerosene_qty = $this->input->post('edit_kerosene_qty');

        if ($vessel AND ! empty($vessel_id)) {

            if ($vessel['fuel_type_group_id'] == AGO AND empty($diesel_qty)) {
                $this->form_validation->set_message('validateEditPoVessels', 'If ' . $vessel['vessel_name'] . ' - ' . $vessel['fuel_type_group_name'] . ' is selected, diesel qty field should not be empty, otherwise remove it');
                return FALSE;
            }

            if ($vessel['fuel_type_group_id'] == PMS AND empty($super_qty)) {
                $this->form_validation->set_message('validateEditPoVessels', 'If ' . $vessel['vessel_name'] . ' - ' . $vessel['fuel_type_group_name'] . ' is selected, super qty field should not be empty, otherwise remove it');
                return FALSE;
            }

            if ($vessel['fuel_type_group_id'] == IK AND empty($kerosene_qty)) {
                $this->form_validation->set_message('validateEditPoVessels', 'If ' . $vessel['vessel_name'] . ' - ' . $vessel['fuel_type_group_name'] . ' is selected, kerosene qty field should not be empty, otherwise remove it');
                return FALSE;
            }
        }

        return TRUE;
    }

}
