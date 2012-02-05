<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pages extends Admin_Controller {

    function __construct() {
        parent::__construct();
        // Load modules/menus/models/mmenus
        $this->load->model('menus/mmenus');
        // Load pages model
        $this->load->model('mpages');
        // Set breadcrumb
        //$this->bep_site->set_crumb($this->lang->line('backendpro_pages'),'pages/admin');
    }

    function index() {
        // we use the following variables in the view
        $data['title'] = "Manage Pages";
        $data['pages'] = $this->mpages->getAllPages();
        $data['header'] = $this->lang->line('backendpro_access_control');
        // This how Bep load views
        $data['module'] = 'pages';
        $this->template->load($this->_container, 'admin_pages_home', $data);
    }

    function create() {
        // We need TinyMCE, so load it
        //$this->bep_assets->load_asset_group('TINYMCE');
        if ($this->input->post('name')) {
            // if info is filled in then do this
            $this->mpages->addPage();
            // This is CI way to show flashdata
            // flashMsg('message','Page created');
            // But here we use Bep way to display flash msg
            //flashMsg('success','Page created');
            // and redirect to this index page
            flashMsg('message', 'Page created');
            redirect('pages/', 'refresh');
        } else {
            // this must be first visit to the creat page
            $data['title'] = "Create Page";
            $data['menus'] = $this->mmenus->getAllMenusDisplay();
            // Set breadcrumb
            //$this->bep_site->set_crumb($this->lang->line('userlib_page_create'),'pages/create');
            // Setting up page and telling which module
            $data['module'] = 'pages';
            $this->template->load($this->_container, 'admin_pages_create', $data);
        }
    }

    function edit($id=0) {
        // we are using TinyMCE here, so load it.
        //$this->bep_assets->load_asset_group('TINYMCE');
        if ($this->input->post('name')) {
            // info is filled out, so the followings
            $this->mpages->updatePage();
            // This is CI way to show flashdata
            // flashMsg('message','Page updated');
            // But here we use Bep way to display flash msg
            //flashMsg('success','Page updated');
            flashMsg('message', 'Page updated');
            redirect('pages/', 'refresh');
        } else {
            // set variables here
            $data['title'] = "Edit Page";
            $data['page'] = $this->config->item('backendpro_template_admin') . "admin_pages_edit";
            $data['pagecontent'] = $this->mpages->getPage($id);
            if (!count($data['page'])) {
                // if page is not specified redirect to index
                redirect('pages/', 'refresh');
            }
            $data['menus'] = $this->mmenus->getAllMenusDisplay();
            // Set breadcrumb
            //$this->bep_site->set_crumb($this->lang->line('userlib_page_edit'),'pages/edit');
            $data['module'] = 'pages';
            $this->template->load($this->_container, 'admin_pages_edit', $data);
        }
    }

    function delete($id) {
        $this->mpages->deletePage($id);
        // CI way
        // flashMsg('message','Page deleted');
        //flashMsg('success','Page deleted');
        flashMsg('message', 'Page deleted');
        redirect('pages/', 'refresh');
    }

    function changePageStatus($id) {
        $this->mpages->changePageStatus($id);
        // CI way
        // flashMsg('message','Page status changed');
        flashMsg('message','Page status changed');
        //flashMsg('message', 'Page status changed');
        redirect('pages/', 'refresh');
    }

}

//end class
?>