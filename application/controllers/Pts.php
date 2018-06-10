<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pts extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function testJson() {
        
        header('Access-Control-Allow-Origin: *');
        header('Content-type: text/json');
        
        
        echo json_encode(['info' => $this->input->post()]);
        
        die();

    }
    
//    1. Click authorize ==> authorize price()
//    2. set authorize true
//    3. get price
//    4. on get price response update seling price variable
//    5. check if authorize iz true
//    6. run authorize price()

}
