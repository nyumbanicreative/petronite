<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Payments extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }
    
    public function ajaxCustomerPayments() {

        $this->usr->checkStatusJson(1, 1, 1);

        $data = [];
        $list = $this->txn->get_datatables_credit_sales_txn(['admin_id' => $this->usr->admin_id]);
        $no = $_POST['start'];

        foreach ($list as $a) {
            $no++;
            $row = array();

            $link = "";
            $text_class = "";
            
            if($a->txn_status == 'OK'){
                $link = '<a href="' . site_url('payments/requestcancelpaymentform/' . $a->txn_id) . '" class="btn btn-outline-danger btn-sm request_form"><i class="fa fa-close"></i>&nbsp;&nbsp;Cancel</a>';
            }else{
                $text_class = "text-danger";
            }
            
            
            
           
            
            $station = 'Headquarter&nbsp;(HQ)';
            
            if(!empty($a->txn_station_id)){
                $station = $a->station_name;
            }
            
            //$row[] = $no;
            $row[] = '<span class="'.$text_class.'">' .$a->txn_date.'</span>';
            $row[] = '<span class="'.$text_class.'">' .$a->credit_type_name.'</span>';
            $row[] = '<span class="'.$text_class.'">' .cus_price_form_french($a->txn_credit).'</span>';
            $row[] = '<span class="'.$text_class.'">' .$a->txn_method.'</span>';
            $row[] = '<span class="'.$text_class.'">' .$a->txn_reference_no.'</span>';
            $row[] = '<span class="'.$text_class.'">' .$a->txn_notes.'</span>';
            $row[] = '<span class="'.$text_class.'">' .$station.'</span>';
            $row[] = $link;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->txn->count_all_credit_sales_txn(['admin_id' => $this->usr->admin_id]),
            "recordsFiltered" => $this->txn->count_filtered_credit_sales_txn(['admin_id' => $this->usr->admin_id]),
            "data" => $data,
            "post" => $_POST
        );


        //output to json format
        echo json_encode($output);
    }
    
    public function requestCancelPaymentForm($param) {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->usr->checkStatusJson(1, 1, 1);

        $txn_id = $this->uri->segment(3);

        $txn = $this->txn->getTransactions(NULL, ['txn.txn_id' => $txn_id], 1, NULL);

        if (!$txn) {
            cus_json_error('Payment was not found or may have been removed form the system');
        }



        echo json_encode([
            'status' => [
                'error' => FALSE,
                'redirect' => FALSE,
                'pop_form' => TRUE,
                'form_type' => 'cancelPayment',
                'form_url' => site_url('payments/submitcancelpayment/' . $txn['txn_id'])
            ],
            'txn' => $txn
        ]);
    }
    
    public function submitCancelPayment() {

        header('Access-allow-control-origin: *');
        header('Content-type: text/json');

        $this->usr->checkStatusJson(1, 1, 1);
        
        $txn_id = $this->uri->segment(3);

        $txn = $this->txn->getTransactions(NULL, ['txn.txn_id' => $txn_id], 1, NULL);

        if (!$txn) {
            cus_json_error('Payment was not found or may have been removed form the system');
        }
        
        if($txn['txn_status'] != 'OK'){
            cus_json_error('Payment is not in the right state to be cancelled');
        }

        $validations = [
                ['field' => 'cancel_reason', 'label' => 'Canceling Reason', 'rules' => 'trim|required|callback_validateCancelReason'],
                ['field' => 'cancel_notes', 'label' => 'Canceling Notes', 'rules' => 'trim|required']
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
            $cancel_reason  = $this->input->post('cancel_reason');
            $cancel_notes = $this->input->post('cancel_notes');
            $notes = $cancel_reason;
            $notes .= '<br/>Payment Date: '.$txn['txn_date'].'<br/>Txn Ref No. '.$txn['txn_reference_no'].' <br/>Amount Paid: '.cus_price_form_french($txn['txn_credit']) .' '. CURRENCY;
            $notes .= !empty($cancel_notes)? '<br/>'.$cancel_notes : "";
            


            $customer = $this->cust->getCreditCustomers(['credit_type_id' => $txn['credit_type_id'], 'credit_type_admin_id' => $this->usr->admin_id], NULL, 1);

            if (!$customer) {
                cus_json_error("Credit customer was not found or may have been removed from the system");
            }
            
            $balance_after = $customer['credit_type_balance'] + $txn['txn_credit'];

            $txn_data = [
                'txn_credit' => $txn['txn_debit'],
                'txn_type' => 'CANCELLED_PAYMENT',
                'txn_acc_ref' => $customer['credit_type_id'],
                'txn_debit' => $txn['txn_credit'],
                'txn_user_id' => $this->usr->user_id,
                'txn_balance_before' => $customer['credit_type_balance'],
                'txn_balance_after' => $balance_after,
                'txn_admin_id' => $this->usr->admin_id,
                'txn_notes' => $notes,
                'txn_method' => $txn['txn_method'],
                'txn_reference_no' => $txn['txn_reference_no'],
                'txn_date' => date('Y-m-d'),
                'txn_station_id' => $txn['txn_station_id']
            ];

            $credit_data = ['credit_type_balance' => $balance_after];

            $res = $this->cust->saveCreditPayment(['credit_data' => $credit_data, 'customer' => $customer, 'txn_data' => $txn_data,'cancel_txn' => $txn]);

            if ($res) {
                $this->usr->setSessMsg('Payment cancelled saved successfully', 'success');

                echo json_encode([
                    'status' => [
                        'error' => FALSE,
                        'redirect' => true,
                        'redirect_url' => site_url('customers/customerpayments')
                    ]
                ]);

                die();
            } else {
                cus_json_error('Unable to cancel payment, please refresh the page and try again.');
            }
        }
    }
    
    
    public function validateCancelReason($reason) {
        
        if(empty($reason)){
            return TRUE;
        }
        
        if(!in_array($reason, ['INVALID ENTRY','PAYMENT RETURN'])){
            $this->form_validation->set_message('validateCancelReason','Select a valid canceling reason');
            return FALSE;
        }
        
        return TRUE;
    }
}
