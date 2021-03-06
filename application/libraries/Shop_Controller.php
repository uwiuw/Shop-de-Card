<?php

class Shop_Controller Extends CI_Controller {
    /*
     * Controller for shopping page
     */

    function __construct() {
        parent::__construct();
        $this->load->helper('image_helper');
        $this->load->library('form_validation');
        $this->load->model('webshop/cart_model');
        $this->load->model('pages/mpages');
        $this->load->model('categories/mcats');
        $this->load->model('menus/mmenus');
        $this->load->model('customers/mcustomers');
        $this->load->model('orders/morders');
        $this->load->model('products/mproducts');
        $this->lang->load('webshop');
        // navigation
        $cats = array();
        $cats = $this->mcats->getAllActiveCategories();
        $this->categories = $cats;
        $this->nav_list = $this->mmenus->getLinks($position="left");
        $this->ext_links = $this->mmenus->getLinks($position="right");
        // Set Container Template
        $this->_container = 'shop/container';
        $this->_home = 'shop/home';
        if ($this->cart->total()) {
            $this->total_cart = $this->cart->total();
        } else {
            $this->total_cart = '0.00';
        }
        // This part is used in all the pages so load it here
        // For customer login status
        if (isset($_SESSION['customer_first_name'])) {
            $this->data['customer_status'] = 1;
            $this->data['loginstatus'] = lang('general_hello') . $_SESSION['customer_first_name'] . " | " . lang('general_logged_in') . "</a>
			<a href=" . site_url() . '/webshop' . "/logout \">Log out</a>";
        } else {
            $this->data['customer_status'] = 0;
            $this->data['loginstatus'] = "<a href='" . site_url() . "/webshop/login' >You are not logged in.</a> | <a href=\"" . site_url() . '/webshop/login' . "/registration \">My Account</a>";
        }
        // Total price will be displayed
        // handlekurv means shopping cart in Norwegian
        // sorry for this. I will use English in future. 
        // It's too late and too much work to replace now.
        if (isset($_SESSION['totalprice'])) {
            $this->data['handlekurv'] = $_SESSION['totalprice'];
        } else {
            $this->data['handlekurv'] = 0;
        }

        if ($this->uri->segment(2) != 'login') {
            $last_url = str_replace(site_url(), '', current_url());
            $_SESSION['last_url_shop'] = $last_url;
        }
    }

}
