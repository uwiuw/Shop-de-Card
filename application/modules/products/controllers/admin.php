<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Admin extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mproducts');
        $this->load->model('categories/mcats');
        // Your own constructor code
    }

    function index(){
  		// Setting variables
		$data['title'] = "Manage Products";
		$data['products'] = $this->mproducts->getAllProducts();
		$data['categories'] = $this->mcats->getCategoriesDropDown();
		// we are pulling a header word from language file
		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_product_home";
		$data['module'] = 'products';
		$this->load->view('admin_product_home',$data);
	}


  	function create(){
  		// we are using TinyMCE in this page, so load it
  		//$this->bep_assets->load_asset_group('TINYMCE');

	   	if ($this->input->post('name')){
	   		// fields are filled up so do the followings
	  		$this->mproducts->insertProduct();
	  		// CI way to set flashdata, but we are not using it
	  		// $this->session->set_flashdata('message','Product created');
	  		// we are using Bep function for flash msg
	  		//flashMsg('success','Product created');
	  		redirect('products/admin/index','refresh');
	  	}else{
	  		// this must be the first time, so set variables
			$data['title'] = "Create Product";
			$data['categories'] = $this->mcats->getCategoriesDropDown();
			// loading this for giving some instructions.f
			//$this->bep_site->set_crumb($this->lang->line('userlib_product_create'),'products/admin/create');
			$data['header'] = $this->lang->line('backendpro_access_control');
			$data['page'] = $this->config->item('backendpro_template_admin') . "admin_product_create";
			$data['module'] = 'products';
			$this->load->view('admin_product_create',$data);
		}
  	}


  	function edit($id=0){
  		// we are using TinyMCE in edit as well
	  	//$this->bep_assets->load_asset_group('TINYMCE');
	  	if ($this->input->post('name')){
	  		// fields filled up so,
	  		$this->mproducts->new_updateProduct();
	  		// CI way to set flashdata, but we are not using it
	  		// $this->session->set_flashdata('message','Product updated');
	  		// we are using Bep function for flash msg
	  		//flashMsg('success','Product updated');
	  		redirect('products/admin/index','refresh');
	  	}else{
			//$id = $this->uri->segment(4);
			$data['title'] = "Edit Product";
			// $data['main'] = 'admin_product_edit';
			$data['page'] = $this->config->item('backendpro_template_admin') . "admin_product_edit";
			$data['product'] = $this->mproducts->getProduct($id);
			$data['categories'] = $this->mcats->getCategoriesDropDown();
			// I am not using colors and sizes any more. But they are available if you want to use them.
			// I am loading product_right here which gives instructions.
			//$data['right'] = 'admin/product_right';
			if (!count($data['product'])){
				redirect('products/admin/index','refresh');
			}
			// 	Set breadcrumb
			//$this->bep_site->set_crumb($this->lang->line('userlib_product_edit'),'products/admin/edit');
			//$data['header'] = $this->lang->line('backendpro_access_control');
			$data['module'] = 'products';
			$this->load->view('admin_product_edit',$data);
		}
  	}

	function delete($id){
		$this->mproducts->deleteProduct($id);
		$this->session->set_flashdata('message','Product deleted');
		redirect('products/admin/index','refresh');
	}

	function changeProductStatus($id){
		$this->mproducts->changeProductStatus($id);
		$this->session->set_flashdata('message','Page status changed');
		redirect('products/admin/index','refresh');
	}

}
