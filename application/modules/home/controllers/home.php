<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Cherub extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //$this->load->model('job_model');
        //$this->load->library('unit_test');
        // Your own constructor code
    }
/*
 * home index file
 */    
    public function index(){
        $data['title'] = 'Cherub';
        $this->load->view('home',$data);
    }
    
}

