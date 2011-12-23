<?php

class Admin extends MX_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('mcats');
        // Your own constructor code
    }

    function index() {
        $data['title'] = "Manage Categories";
        $data['categories'] = $this->mcats->getAllCategories();
        //$data['header'] = $this->lang->line('backendpro_access_control');
        //$data['page'] = $this->config->item('backendpro_template_admin') . "admin_cat_home";
        $data['module'] = 'categories';
        $this->load->view('admin_cat_home', $data);
    }

    function create() {
        //$this->bep_assets->load_asset_group('TINYMCE');

        if ($this->input->post('name')) {
            $this->mcats->addCategory();
            $string = $this->input->post('name');
            // createdirname function is from plugin mytools.php
            $folder = createdirname($string);
            $folder = 'assets/images/' . $folder;
            create_path($folder);

            // we used to use like this. $this->session->set_flashdata('message','Category created');
            // now we are using Bep's flashMsg function to show messages.
            //flashMsg('success', $this->lang->line('userlib_category_created'));
            redirect('categories/admin/index', 'refresh');
        } else {
            $data['title'] = "Create Category";
            $data['categories'] = $this->mcats->getTopCategories();
            $data['right'] = 'category_right';

            // Set breadcrumb
            //$this->bep_site->set_crumb($this->lang->line('userlib_category_create'), 'categories/admin/create');

            $data['header'] = $this->lang->line('backendpro_access_control');

            // This is how BackendPro do
            $data['page'] = $this->config->item('backendpro_template_admin') . "admin_cat_create";
            $data['module'] = 'categories';
            $this->load->view('admin_cat_create', $data);
        }
    }

    function edit($id=0) {
        //$this->bep_assets->load_asset_group('TINYMCE');

        if ($this->input->post('name')) {
            $this->mcats->updateCategory();

            //flashMsg('success', $this->lang->line('userlib_category_updated'));
            redirect('categories/admin/index', 'refresh');
        } else {
            //$id = $this->uri->segment(4);
            $data['title'] = "Edit Category";
            // $data['main'] = 'admin_cat_edit';
            //$data['page'] = $this->config->item('backendpro_template_admin') . "admin_cat_edit";
            $data['category'] = $this->mcats->getCategory($id);
            $data['categories'] = $this->mcats->getTopCategories();
            $data['right'] = 'admin/category_right';
            if (!count($data['category'])) {
                redirect('admin/categories/index', 'refresh');
            }

            // Set breadcrumb
            //$this->bep_site->set_crumb($this->lang->line('userlib_category_edit'), 'categories/admin/edit');

            $data['header'] = $this->lang->line('backendpro_access_control');
            $data['module'] = 'categories';
            $this->load->view('admin_cat_edit', $data);
        }
    }

    function changeCatStatus($id){
		//$id = $this->uri->segment(4);
		$this->mcats->changeCatStatus($id);

		//flashMsg('success',$this->lang->line('userlib_category_status'));
		redirect('categories/admin/index','refresh');
  	}
        
    function delete($id) {

        $cat = $this->mcats->getCategory($id);
        $string = $cat['name'];
        $catname = createdirname($string);
        $catname = 'assets/images/' . $catname;
        recursive_remove_directory($catname, $empty = FALSE);

        $orphans = $this->mcats->checkOrphans($id);
        if (count($orphans)) {
            $this->session->set_userdata('orphans', $orphans);
            redirect('categories/admin/reassign/' . $id, 'refresh');
        } else {
            $this->mcats->deleteCategory($id);

            //flashMsg('success', $this->lang->line('userlib_category_deleted'));
            redirect('categories/admin/index', 'refresh');
        }
    }

}