<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin extends CI_Controller {

    function __construct() {
        parent::__construct();
        // Check for access permission
        //check('Orders');
        // load category model from module categories
        $this->load->model('categories/mcats', 'mcats');
        $this->load->model('products/mproducts', 'mproducts');
        // load orders model
        $this->load->model('morders');
        // Set breadcrumb
        //$this->bep_site->set_crumb($this->lang->line('backendpro_orders'), 'orders/admin');
    }

    function index() {

        $data['title'] = "Manage Orders";
        //$data['main'] = 'admin_orders_home';
        $data['products'] = $this->mproducts->getAllProducts();
        $data['categories'] = $this->mcats->getCategoriesDropDown();
        $data['orders'] = $this->morders->getAllOrders();
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_orders_home";
        $data['module'] = 'orders';
        $this->load->view('admin_orders_home', $data);
    }

    function details($id) {

        $data['title'] = "Order Details";
        //$data['main'] = 'admin_orders_details';
        $data['products'] = $this->mproducts->getAllProducts();
        $data['categories'] = $this->mcats->getCategoriesDropDown();
        $data['orderdetails'] = $this->morders->getOrderDetails($id);
        // Set breadcrumb
        //$this->bep_site->set_crumb($this->lang->line('userlib_order_details'), 'orders/admin/details');
        $data['header'] = $this->lang->line('backendpro_access_control');
        $data['page'] = $this->config->item('backendpro_template_admin') . "admin_orders_details";
        $data['module'] = 'orders';
        $this->load->view('admin_orders_details', $data);
    }

    function paid($id) {
        $this->morders->setpayment($id);
        $this->session->set_flashdata('message', 'Payment Date updated!');
        redirect('orders/admin');
    }

    function delivered($id) {
        $this->morders->setdelivery($id);
        $this->session->set_flashdata('message', 'Delivery Date updated!');
        redirect('orders/admin/');
    }

    function deleteitem($order_id, $order_item_id) {
        $order_id = $this->uri->segment(4);
        $order_item_id = $this->uri->segment(5);

        if (count($this->morders->findsiblings($order_id)) < 2) {
            $this->morders->deleteOrder($order_id);
            $this->morders->deleteOrderItem($order_item_id);
            $this->session->set_flashdata('message', 'Order deleted');
            redirect('orders/admin/index', 'refresh');
        } else {
            $this->morders->deleteOrderItem($order_item_id);
            $this->session->set_flashdata('message', 'Order item deleted');
            redirect('orders/admin/details/' . $order_id, 'refresh');
        }
    }

}
?>