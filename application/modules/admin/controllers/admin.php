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
            // $get_user = $this->user_model->is_online($data);
            if ($this->user_model->login($data)) {
                //echo 'correct';
                if (isset($_SESSION['last_url'])) {
                    redirect($_SESSION['last_url']);
                } else {
                    redirect('categories');
                    //$this->redirect_logged();
                }
            } elseif ($this->user_model->is_activate($email)) {
                flashMsg('message', 'You cannot Acces, because your account is not Activated, Please Ask Admin to Activated it');
                redirect('admin/index');
                //echo 'You cannot Acces, because your account is not Activated, Please Ask Admin to Activated it';
            } else {
                //echo 'Please type the correct username and password You have  failed';exit;
                flashMsg('message', 'Please type the correct username and password You have  failed');
                redirect('admin/index');
            }
        }
    }

    function redirect_logged() {
        if (!empty($_SESSION['ca_group'])) {
            if ($_SESSION["ca_group"] == '2') {
                echo "Please wait, <p>This page will automatically redirecting to Admin Page</p>";
                echo '<script>location.href="' . site_url() . '/categories"</script>';
            } elseif ($_SESSION["ca_group"] == '1') {
                echo "Please wait, <p>This page is automatically redirecting to Telecollector Page</p>";
            }
        }
        return false;
    }

    function logout() {
        $this->user_model->logout();
        redirect('/admin/');
    }

    function forgotten_password() {
        $this->auth_form_processing->forgotten_password_form($this->_container);
    }

    function register() {
        $this->auth_form_processing->register_form($this->_container);
    }

    function activate() {
        $this->auth_form_processing->activate();
    }

}
