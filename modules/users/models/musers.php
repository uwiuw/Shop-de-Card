<?php

class MUsers extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function allUser() {
        $query = $this->db->query("SELECT * FROM be_users");
        return $query->result();
    }

    public function getUser($id) {
        $query = $this->db->query("SELECT * FROM be_users WHERE id_user=" . $id);
        return $query->row();
    }

    public function postData() {
        $data = array(
            'username' => db_clean($_POST['username']),
            'email' => db_clean($_POST['email']));
        if ($_POST['password'] != "") {
            $password = sha1($_POST['password'] . $this->config->item('encryption_key'));
            $data['password'] = db_clean($password, 100);
        }
        return $data;
    }

    public function addUser() {
        $data = $this->postData();
        $this->db->insert('be_users', $data);
        return $this->db->insert_id();
    }

    public function editUser() {
        $data = $this->postData();
        $this->db->where('id_user', $this->input->post('id_user'));
        return $this->db->update('be_users', $data);
    }

    public function deleteUser($id_user) {
        $this->db->delete('be_users', array('id_user' => $id_user));
    }

    public function activated($id) {
        $userinfo = $this->getUser($id);
        $status = $userinfo->active;
        if ($status == '1') {
            $data = array('active' => '0');
            $this->db->where('id_user', id_clean($id));
            $this->db->update('be_users', $data);
        } else {
            $data = array('active' => '1');
            $this->db->where('id_user', id_clean($id));
            $this->db->update('be_users', $data);
        }
    }

}

?>