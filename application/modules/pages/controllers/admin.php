<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
	function __construct(){
		   parent::__construct();
		   // Check for access permission
			//check('Pages');
			// Load modules/menus/models/mmenus
			$this->load->model('menus/mmenus');
			// Load pages model
			$this->load->model('mpages');
			// Set breadcrumb
			//$this->bep_site->set_crumb($this->lang->line('backendpro_pages'),'pages/admin');
	}
  

	function index(){
			// we use the following variables in the view
			$data['title'] = "Manage Pages";
			$data['pages'] = $this->mpages->getAllPages();
			$data['header'] = $this->lang->line('backendpro_access_control');
			// This how Bep load views
			$data['page'] = $this->config->item('backendpro_template_admin') . "admin_pages_home";
			$data['module'] = 'pages';
			$this->load->view('admin_pages_home',$data);
	}
  

	function create(){
		// We need TinyMCE, so load it
	  	//$this->bep_assets->load_asset_group('TINYMCE');
	   	if ($this->input->post('name')){
	   		// if info is filled in then do this
	  		$this->mpages->addPage();
	  		// This is CI way to show flashdata
	  		// $this->session->set_flashdata('message','Page created');
	  		// But here we use Bep way to display flash msg
	  		//flashMsg('success','Page created');
	  		// and redirect to this index page
	  		redirect('pages/admin/index','refresh');
	  	}else{
	  		// this must be first visit to the creat page
			$data['title'] = "Create Page";
			$data['menus'] = $this->mmenus->getAllMenusDisplay();
			// Set breadcrumb
			//$this->bep_site->set_crumb($this->lang->line('userlib_page_create'),'pages/admin/create');
			$data['header'] = $this->lang->line('backendpro_access_control');
			// Setting up page and telling which module 
			$data['page'] = $this->config->item('backendpro_template_admin') . "admin_pages_create";
			$data['module'] = 'pages';
			$this->load->view('admin_pages_create',$data);
		} 
	}
  
	  
	function edit($id=0){
			// we are using TinyMCE here, so load it.
		  	//$this->bep_assets->load_asset_group('TINYMCE');
		  	if ($this->input->post('name')){
		  		// info is filled out, so the followings
		  		$this->mpages->updatePage();
		  		// This is CI way to show flashdata
		  		// $this->session->set_flashdata('message','Page updated');
		  		// But here we use Bep way to display flash msg
	  			//flashMsg('success','Page updated');
		  		redirect('pages/admin/index','refresh');
		  	}else{
		  		// set variables here
				$data['title'] = "Edit Page";
				$data['page'] = $this->config->item('backendpro_template_admin') . "admin_pages_edit";
				$data['pagecontent'] = $this->mpages->getPage($id);
				if (!count($data['page'])){
					// if page is not specified redirect to index
					redirect('pages/admin/index','refresh');
				}
				$data['menus'] = $this->mmenus->getAllMenusDisplay();
				// Set breadcrumb
				//$this->bep_site->set_crumb($this->lang->line('userlib_page_edit'),'pages/admin/edit');
				$data['header'] = $this->lang->line('backendpro_access_control');
				$data['module'] = 'pages';
				$this->load->view('admin_pages_edit',$data);
			}
	}

	
	function delete($id){
			$this->mpages->deletePage($id);
			// CI way
			// $this->session->set_flashdata('message','Page deleted');
			//flashMsg('success','Page deleted');
			redirect('pages/admin/index','refresh');
	}

	
	function changePageStatus($id){
		$this->mpages->changePageStatus($id);
		// CI way
		// $this->session->set_flashdata('message','Page status changed');
		//flashMsg('success','Page status changed');
		redirect('pages/admin/index','refresh');
	}

	
}//end class
?>