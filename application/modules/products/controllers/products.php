<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Products extends Admin_Controller {

    public function __construct() {
        parent::__construct();
        $this->check();
        $this->load->model('mproducts');
        $this->load->model('categories/mcats');
        // Your own constructor code
    }

    function index() {
        // Setting variables
        $data['title'] = "Manage Products";
        $data['products'] = $this->mproducts->getAllProducts();
        $data['categories'] = $this->mcats->getCategoriesDropDown();
        // we are pulling a header word from language file
        $data['module'] = 'products';
        $this->template->load($this->_container, 'admin_product_home', $data);
    }

    function create() {
        // we are using TinyMCE in this page, so load it
        //$this->bep_assets->load_asset_group('TINYMCE');

        if ($this->input->post('name')) {
            // fields are filled up so do the followings
            $this->mproducts->insertProduct();
            // CI way to set flashdata, but we are not using it
            // flashMsg('message','Product created');
            // we are using Bep function for flash msg
            flashMsg('message','Product created');
            redirect('products/', 'refresh');
        } else {
            // this must be the first time, so set variables
            $data['title'] = "Create Product";
            $data['categories'] = $this->mcats->getCategoriesDropDown();
            // loading this for giving some instructions.f
            //$this->bep_site->set_crumb($this->lang->line('userlib_product_create'),'products/create');
            $data['module'] = 'products';
            $this->template->load($this->_container, 'admin_product_create', $data);
        }
    }

    function edit($id=0) {
        // we are using TinyMCE in edit as well
        //$this->bep_assets->load_asset_group('TINYMCE');
        if ($this->input->post('name')) {
            // fields filled up so,
            $this->mproducts->new_updateProduct();
            // CI way to set flashdata, but we are not using it
            // flashMsg('message','Product updated');
            // we are using Bep function for flash msg
            flashMsg('message','Product updated');
            redirect('products/', 'refresh');
        } else {
            //$id = $this->uri->segment(4);
            $data['title'] = "Edit Product";
            // $data['main'] = 'admin_product_edit';
            $data['product'] = $this->mproducts->getProduct($id);
            $data['categories'] = $this->mcats->getCategoriesDropDown();
            // I am not using colors and sizes any more. But they are available if you want to use them.
            // I am loading product_right here which gives instructions.
            //$data['right'] = 'admin/product_right';
            if (!count($data['product'])) {
                redirect('products/', 'refresh');
            }
            // 	Set breadcrumb
            //$this->bep_site->set_crumb($this->lang->line('userlib_product_edit'),'products/edit');
            //$data['header'] = $this->lang->line('backendpro_access_control');
            $data['module'] = 'products';
            $this->template->load($this->_container, 'admin_product_edit', $data);
        }
    }

    function delete($id) {
        $this->mproducts->deleteProduct($id);
        flashMsg('message', 'Product deleted');
        redirect('products', 'refresh');
    }

    function changeProductStatus($id) {
        $this->mproducts->changeProductStatus($id);
        flashMsg('message', 'Page status changed');
        redirect('products', 'refresh');
    }

}
