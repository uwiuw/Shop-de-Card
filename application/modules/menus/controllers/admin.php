<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
  function __construct(){
   	parent::__construct();
   	// Check for access permission
	//check('Menus');
   	// load modules/menus/model/mmenus
   	$this->load->model('mmenus');
   
   	// Load modules/pages/models/mpages
	$this->load->model('pages/mpages','mpages');
	
	// Set breadcrumb
	//$this->bep_site->set_crumb($this->lang->line('backendpro_menus'),'menus/admin');
		
    }
  

  function index(){
		$data['title'] = "Manage Menus";
		$tree = array();
		$parentid = 0;
		$this->mmenus->generateallTree($tree,$parentid);
		$data['navlist'] = $tree;
		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_menu_home";
		$data['module'] = 'menus';
		$this->load->view('admin_menu_home',$data);
  }
  
  
  function create(){
    // This is used in admin/menus, when you click Create new menu, then this is called
    // 'parentid' ,'0' is in hidden in views/admin_menu_create.php
   	if ($this->input->post('name')){
  		$this->mmenus->addMenu();
  		$this->session->set_flashdata('message','Menu created');
  		redirect('menus/admin/index','refresh');
  	}else{
		$data['title'] = "Create Menu";
	  	$data['menus'] = $this->mmenus->getAllMenusDisplay();
		$data['pages'] = $this->mpages->getAllPathwithnone();
		
		// Set breadcrumb
		//$this->bep_site->set_crumb($this->lang->line('userlib_menu_create'),'menus/admin/create');
		
		//$data['header'] = $this->lang->line('backendpro_access_control');
		//$data['page'] = $this->config->item('backendpro_template_admin') . "admin_menu_create";
		$data['module'] = 'menus';
		$this->load->view('admin_menu_create',$data);
	} 
  }

  function edit($id=0){
    // This is for editing Menu, such as Main menu etc
  	if ($this->input->post('name')){
  		$this->mmenus->updateMenu();
  		$this->session->set_flashdata('message','Menu updated');
  		redirect('menus/admin/index','refresh');
  	}else{
		//$id = $this->uri->segment(4);
		$data['title'] = "Edit Menu";
		// $data['main'] = 'admin_menu_edit';
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_menu_edit";
		$data['menu'] = $this->mmenus->getMenu($id);
		$data['menus'] = $this->mmenus->getAllMenusDisplay();
		$data['pages'] = $this->mpages->getAllPathwithnone();
		if (!count($data['menu'])){
			redirect('menus/admin/index','refresh');
		}
	
		$data['header'] = $this->lang->line('backendpro_access_control');
		
		// Set breadcrumb
		//$this->bep_site->set_crumb($this->lang->line('userlib_menu_edit'),'menus/admin/edit');
			
		$data['module'] = 'menus';
		$this->load->view('admin_menu_edit',$data);
	}
  }
  
  function deleteMenu($id){
    // This will be called to delete a menu(not sub-menu item).
	//$id = $this->uri->segment(4);
	
	$orphans = $this->mmenus->checkMenuOrphans($id);
	if (count($orphans)){
		$this->session->set_userdata('orphans',$orphans);
		redirect('menus/admin/reassign/'.$id,'refresh');	
	}else{
		$this->mmenus->deleteMenu($id);
		$this->session->set_flashdata('message','Menu deleted');
		redirect('menus/admin/index','refresh');
	}
  }
  
  function changeMenuStatus($id){
    
	$orphans = $this->mmenus->checkMenuOrphans($id);
	if (count($orphans)){
		$this->session->set_userdata('orphans',$orphans);
		redirect('menus/admin/reassign/'.$id,'refresh');	
	}else{
		$this->mmenus->changeMenuStatus($id);
		$this->session->set_flashdata('message','Menu status changed');
		redirect('menus/admin/index','refresh');
	}
  }
  
  
  function export(){
  	$this->load->helper('download');
  	$csv = $this->mmenus->exportCsv();
  	$name = "Menu_export.csv";
  	force_download($name,$csv);

  }

  function reassign($id=0){
    // This is called when you delete one of menu from deleteMenu() function above.
	  if ($_POST){
		
		$this->mmenus->reassignMenus();
		$this->session->set_flashdata('message','Menu deleted and sub-menus reassigned');
		redirect('menus/admin/index','refresh');
		}else{
		//$id = $this->uri->segment(4);
		
		$data['menu'] = $this->mmenus->getMenu($id);
		$data['title'] = "Reassign Sub-menus";
		$data['menus'] = $this->mmenus->getrootMenus();
		$this->mmenus->deleteMenu($id);
		
		// Set breadcrumb
		//$this->bep_site->set_crumb($this->lang->line('userlib_menu_reassign'),'menus/admin/reassign');
		
		$data['header'] = $this->lang->line('backendpro_access_control');
		$data['page'] = $this->config->item('backendpro_template_admin') . "admin_submenu_reassign";
		$data['module'] = 'menus';
		$this->load->view('admin_menu_reassign',$data);
		}	
	}

	
}//end class
?>