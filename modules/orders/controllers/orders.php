<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Orders extends Admin_Controller {

    function __construct() {
        parent::__construct();
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
        $data['module'] = 'orders';
        $this->template->load($this->_container, 'admin_orders_home', $data);
    }

    function details($id) {

        $data['title'] = "Order Details";
        //$data['main'] = 'admin_orders_details';
        $data['products'] = $this->mproducts->getAllProducts();
        $data['categories'] = $this->mcats->getCategoriesDropDown();
        $data['orderdetails'] = $this->morders->getOrderDetails($id);
        // Set breadcrumb
        //$this->bep_site->set_crumb($this->lang->line('userlib_order_details'), 'orders/details');
        $data['module'] = 'orders';
        $this->template->load($this->_container, 'admin_orders_details', $data);
    }

    function paid($id) {
        $this->morders->setpayment($id);
        flashMsg('message', 'Payment Date updated!');
        redirect('orders');
    }

    function delivered($id) {
        $this->morders->setdelivery($id);
        flashMsg('message', 'Delivery Date updated!');
        redirect('orders');
    }
    function delete(){
        $array_id = $_POST['deleteCB'];
        foreach($array_id as $id){
            $this->morders->deleteOrders($id);
        }
        echo 'Orders Has been Delete';
    }
    function deleteitem($order_id, $order_item_id) {
        $order_id = $this->uri->segment(4);
        $order_item_id = $this->uri->segment(5);

        if (count($this->morders->findsiblings($order_id)) < 2) {
            $this->morders->deleteOrder($order_id);
            $this->morders->deleteOrderItem($order_item_id);
            flashMsg('message', 'Order deleted');
            redirect('orders', 'refresh');
        } else {
            $this->morders->deleteOrderItem($order_item_id);
            flashMsg('message', 'Order item deleted');
            redirect('orders/details/' . $order_id, 'refresh');
        }
    }

    public function export_order(){
        $this->morders->exportProduct();
    }

}
?>