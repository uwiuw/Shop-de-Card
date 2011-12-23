<?php

class Shop_Controller Extends CI_Controller {
    /*
     * Controller for shopping page
     */

    function __construct() {
        parent::__construct();
        $this->load->helper('image_helper');
        $this->load->library('form_validation');
        $this->load->model('pages/mpages');
        $this->load->model('categories/mcats');
        $this->load->model('menus/mmenus');
        $this->load->model('customers/mcustomers');
        $this->load->model('orders/morders');
        $this->load->model('products/mproducts');
        $this->lang->load('webshop');
        // navigation
        $nav = array();
        $this->mmenus->generateTree($nav, $parentid = 0);
        $this->template->set('nav', $nav);
        $this->nav_list = $nav;
        // Set Container Template
        $this->_container = 'shop/container';
    }

}
