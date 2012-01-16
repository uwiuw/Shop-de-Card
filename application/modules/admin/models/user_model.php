<?php

/* Haidar Mar'ie 
 * coder5@ymail.com To change this template, choose Tools | Templates
 * coder5@ymail.com and open the template in the editor.
 */

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function check_session() {
        if ($this->session->userdata('ca_email') AND $this->session->userdata('ca_username') == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
     *  Check login if username and password and block are correct
     */

    function login($get_user) {
        $password = sha1($get_user['password'].$this->config->item('encryption_key'));
        $sql = 'SELECT * FROM be_users WHERE email="' . $get_user['email'] . '" AND password="' . $password . '" AND active="1"';
        $query = $this->db->query($sql);
        $data = $query->row();
        if (!empty($data)) {
            $_SESSION['ca_email'] = $data->email;
            $_SESSION['ca_username'] = $data->username;
            $_SESSION['ca_id_user'] = $data->id_user;
            $_SESSION['ca_last_visit'] = date('Y-m-d H:i:s');
            $_SESSION['ca_group'] = $data->group;
            $new_log['user_status'] = 'online';
            $new_log['last_visit'] = $_SESSION['ca_last_visit'];
            $new_log['login_failed'] = '0';
            //die(print_r($_SESSION));
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function is_activate($email) {
        $query = $this->db->get_where('be_users', array('email' => $email,'active'=>0));
        $data = $query->row();
        //echo $this->db->last_query();exit;
        if ($query->num_rows()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function validateLogin($login_field, $password) {
        if (!$password OR !$login_field) {
            // If there is no password
            return array('valid' => FALSE, 'query' => NULL);
        }

        switch ($this->preference->item('login_field')) {
            case'email':
                $this->db->where('email', $login_field);
                break;

            case 'username':
                $this->db->where('username', $login_field);
                break;

            default:
                $this->db->where('(email = ' . $this->db->escape($login_field) . ' OR username = ' . $this->db->escape($login_field) . ')');
                break;
        }

        $this->db->where('password', $password);

        $query = $this->fetch('Users', 'id,active');

        $found = ($query->num_rows() == 1);
        return array('valid' => $found, 'query' => $query);
    }

    /**
     * Update Login Date
     *
     * Updates a users last_visit record to the current time
     *
     * @access public
     * @param integer $user_id Users user_id
     */
    function updateUserLogin($id) {
        $this->update('Users', array('last_visit' => date("Y-m-d H:i:s")), array('id' => $id));
    }

    /**
     * Valid Email
     *
     * Checks the given email is one that belongs to a valid email
     *
     * @access public
     * @param string $email Email to validate
     * @return boolean
     */
    function validEmail($email) {
        $query = $this->fetch('Users', NULL, NULL, array('email' => $email));
        return ($query->num_rows() == 0) ? FALSE : TRUE;
    }

    /**
     * Activate User Account
     *
     * When given an activation_key, make that user account active
     *
     * @access public
     * @param string $key Activation Key
     * @return boolean
     */
    function activateUser($key) {
        $this->update('Users', array('active' => '1', 'activation_key' => NULL), array('activation_key' => $key));

        return ($this->db->affected_rows() == 1) ? TRUE : FALSE;
    }

    /**
     * Get Users
     *
     * @access public
     * @param mixed $where Where query string/array
     * @param array $limit Limit array including offset and limit values
     * @return object
     */
    function getUsers($where = NULL, $limit = array('limit' => NULL, 'offset' => '')) {
        // Load the khacl config file so we can get the correct table name
        $this->load->config('khaos', true, true);
        $options = $this->config->item('acl', 'khaos');
        $acl_tables = $options['tables'];

        // If Profiles are enabled load get their values also
        $profile_columns = '';
        if ($this->preference->item('allow_user_profiles')) {
            // Select only the column names of the profile fields
            $profile_fields_array = array_keys($this->config->item('userlib_profile_fields'));

            // Implode and seperate with comma
            $profile_columns = implode(', profiles.', $profile_fields_array);
            $profile_columns = (empty($profile_fields_array)) ? '' : ', profiles.' . $profile_columns;
        }

        $this->db->select('users.id, users.username, users.email, users.password, users.active, users.last_visit, users.created, users.modified, groups.name `group`, groups.id group_id' . $profile_columns);
        $this->db->from($this->_TABLES['Users'] . " users");
        $this->db->join($this->_TABLES['UserProfiles'] . " profiles", 'users.id=profiles.user_id');
        $this->db->join($acl_tables['aros'] . " groups", 'groups.id=users.group');
        if (!is_null($where)) {
            $this->db->where($where);
        }
        if (!is_null($limit['limit'])) {
            $this->db->limit($limit['limit'], ( isset($limit['offset']) ? $limit['offset'] : ''));
        }
        return $this->db->get();
    }

    /**
     * Delete Users
     *
     * Extend the delete users function to make sure we delete all data related
     * to the user
     *
     * @access private
     * @param mixed $where Delete user where
     * @return boolean
     */
    function delete($where) {
        // Get the ID's of the users to delete
        //$query = $this->fetch('Users', 'id', NULL, $where);
        $sql = "SELECT * FROM users WHERE " . $where;
        $query = $this->db->query($sql);
        foreach ($query->result() as $row) {
            $this->db->trans_begin();
            // -- ADD USER REMOVAL QUERIES/METHODS BELOW HERE
            // Delete main user details
            $this->db->delete($this->_TABLES['Users'], array('id' => $row->id));

            // Delete user profile
            $this->delete('UserProfiles', array('user_id' => $row->id));

            // -- DON'T CHANGE BELOW HERE
            // Check all the tasks completed
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return FALSE;
            } else {
                $this->db->trans_commit();
            }
        }
        return TRUE;
    }

    function logout() {
        $data->last_visit = date('Y-m-d H:i:s');
        $this->db->update('be_users', $data, array('id_user' => @$_SESSION['ca_id_user']));
        //$this->session->sess_destroy();
        session_destroy();
        return true;
    }

}

?>
