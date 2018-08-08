<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Suppliers extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        // Check user status
        $this->usr->checkStatus(1, 1, 1);

        $data = [
            'menu' => 'menu/view_stations_menu', // View for menu
            'content' => 'contents/customers_suppliers/view_suppliers', // View for contnet
            'menu_data' => ['curr_menu' => 'CUSTOMERS', 'curr_sub_menu' => 'CUSTOMERS'], //Inorder to collapse  menu items
            'content_data' => [//Contents data pass here
                'module_name' => 'Suppliers',
                'suppliers' => $this->sup->getSuppliers(['sup.supplier_admin_id' => $this->usr->admin_id])
            ],
            'modals_data' => [
                'modals' => ['modal_add_supplier']
            ],
            'header_data' => [], //Header data pass here
            'footer_data' => [], //Footer data pass here
            'top_bar_data' => [] //Top bar data pass here
        ];

        // Now call the base view which have everything we need to dispaly
        $this->load->view('view_base', $data);
    }

    public function submitNewSupplier() {


        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');

        $this->usr->checkStatusJson(1, 1, 1);

        $validations = [
                ['field' => 'sup_name', 'label' => 'Supplier Name', 'rules' => 'trim|required'],
                ['field' => 'sup_tel', 'label' => 'Supplier Telephone No.', 'rules' => 'trim'],
                ['field' => 'sup_mob_1', 'label' => 'Supplier Mobile No 1', 'rules' => 'trim|required'],
                ['field' => 'sup_mobile_2', 'label' => 'Supplier Mobile No 2', 'rules' => 'trim'],
                ['field' => 'sup_email', 'label' => 'Supplier Email', 'rules' => 'trim|valid_email'],
                ['field' => 'sup_fax', 'label' => 'Supplier Fax', 'rules' => 'trim'],
                ['field' => 'sup_url', 'label' => 'Supplier Url', 'rules' => 'trim|valid_url'],
                ['field' => 'sup_address', 'label' => 'Supplier Address', 'rules' => 'trim']
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

        
            $supplier_data = [
                'supplier_name' => $this->input->post('sup_name'),
                'supplier_telephone' => $this->input->post('sup_tel'),
                'supplier_address' => $this->input->post('sup_address'),
                'supplier_phone' => $this->input->post('sup_mob_1'),
                'supplier_phone_2' => $this->input->post('sup_mob_2'),
                'supplier_fax' => $this->input->post('sup_mob_2'),
                'supplier_email' => $this->input->post('sup_email'),
                'supplier_added_by' => $this->usr->user_id,
                'supplier_admin_id' => $this->usr->admin_id
            ];

            $res = $this->sup->saveSupplierDetails(['supplier_data' => $supplier_data]);

            if ($res) {
                $this->session->set_flashdata('success', 'Supplier added successfully');
                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('suppliers')
                    ]
                ]);
                die();
            } else {
                cus_json_error('Something went wrong, supplier was not added');
            }
        }
    }

}
