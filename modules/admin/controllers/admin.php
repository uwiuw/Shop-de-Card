<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin Extends Admin_Controller {
    /*
     * Controller for Admin module
     */

    function __construct() {
        parent::__construct();
        $this->load->model('user_model');
    }

    function index() {
        $data['title'] = 'Login';
        $this->load->view('form_login', $data);
    }

    function log_in() {
        //$this->output->enable_profiler("TRUE");
        //print_r($_POST);exit;
        $email = $this->input->post('email');
        if (isset($email)) {
            $data['email'] = strtolower($this->input->post('email', TRUE));
            $data['password'] = strtolower($this->input->post('password', TRUE));
            if ($this->user_model->login($data)) {
                if (isset($_SESSION['last_url'])) {
                    redirect($_SESSION['last_url']);
                } else {
                    redirect('categories');
                }
            } elseif ($this->user_model->is_activate($email)) {
                flashMsg('message', 'You cannot Acces, because your account is not Activated, Please Ask Admin to Activated it');
                redirect('admin/index');
            } else {
                flashMsg('message', 'Please type the correct username and password You have  failed');
                redirect('admin/index');
            }
        }
    }
    
    function logout() {
        $this->user_model->logout();
        redirect('/admin/');
    }

}
