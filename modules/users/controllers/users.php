<?php
/*By Haidar Mar'ie 
 *Email = coder5@ymail.com 
users */

class Users extends Admin_Controller {

    public function  __construct() {
        parent::__construct();
        $this->load->model('musers');
    }

    public function index(){
        $data['title'] = "Manage Users";
        $data['alluser'] = $this->musers->allUser();
        $this->template->load($this->_container, 'admin_user', $data);
    }

    public function add(){
        $data['title'] = "Add User";
        if(isset($_POST['username'])){
            flashMsg('message', 'New User has been added');
            $id = $this->musers->addUser();
            redirect('users');
        }
        $this->template->load($this->_container, 'admin_user_create', $data);
    }

    public function edit($id){
        $data['title'] = "Edit Users";
        $data['user'] =  $this->musers->getUser($id);
        if(isset($_POST['username'])){
            flashMsg('message', 'User has been edited');
            $id = $this->musers->editUser();
            redirect('users');
        }
        $this->template->load($this->_container, 'admin_user_edit', $data);
    }

    public function active($id){
        $this->musers->activated($id);
        flashMsg('message','User Active Has Change');
        redirect('users');
    }

    public function delete(){
        //print_r($_POST['deleteCB']);
        $array_id = $_POST['deleteCB'];
        foreach($array_id as $id){
            //echo id_clean($id).'/';
            $this->musers->deleteUser(id_clean($id));
        }
        echo 'User Has been Delete';
    }


}

?>
