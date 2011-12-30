<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MMenus extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function generateTree(&$tree, $parentid = 0) {
        $this->db->select('menu_id,name,shortdesc,status,parentid,page_uri,order');
        $this->db->where('status', 'active');
        $this->db->where('page_uri !=','0');
        $this->db->order_by('order asc, parentid asc');
        $res = $this->db->get('menu');
        if ($res->num_rows() > 0) {
            return $res->result_array();
        } else {
            return false;
        }
    }

    function generateallTree(&$tree, $parentid = 0) {
        $this->db->select('menu_id,name,shortdesc,status,parentid,page_uri,order');
        $this->db->where('parentid', $parentid);
        $this->db->order_by('order asc, parentid asc');
        $res = $this->db->get('menu');
        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $r) {

                // push found result onto existing tree
                $tree[$r['menu_id']] = $r;
                // create placeholder for children
                $tree[$r['menu_id']]['children'] = array();
                // find any children of currently found child
                $this->generateallTree($tree[$r['menu_id']]['children'], $r['menu_id']);
            }
        }
    }

    function generateTree1(&$tree, $parentid = 0) {

        $this->db->join('page', 'menu.id = page.menu_id');
        $this->db->where('parentid', $parentid);

        $this->db->order_by('order asc, parentid asc');
        $res = $this->db->get('menu');
        if ($res->num_rows() > 0) {
            foreach ($res->result_array() as $r) {

                $tree[$r['menu_id']] = $r;
                $tree[$r['menu_id']]['children'] = array();
                $this->generateTree($tree[$r['menu_id']]['children'], $r['menu_id']);
            }
        }
    }

    function getMenu($id) {
        $data = array();
        $options = array('menu_id' => id_clean($id));
        $Q = $this->db->get_where('menu', $options, 1);
        if ($Q->num_rows() > 0) {
            $data = $Q->row_array();
        }

        $Q->free_result();
        return $data;
    }

    function getAllMenus() {
        // This is used to show menus in home tables
        $data = array();
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getAllMenusDisplay() {
        $data[0] = 'root';
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[$row['menu_id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;
    }

    function getMenusNav() {
        $data = array();
        $this->db->select('menu_id,name,parentid');
        // $this->db->where('status', 'active');
        $this->db->orderby('parentid', 'asc');
        $this->db->orderby('name', 'asc');
        $this->db->groupby('parentid,id');
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result() as $row) {

                if ($row->parentid > 0) {
                    $data[0][$row->parentid]['children'][$row->id] = $row->name;
                } else {
                    $data[0][$row->id]['name'] = $row->name;
                }
            }
        }
        $Q->free_result();
        return $data;
    }

    function getMenusDropDown() {
        $data = array();
        $this->db->select('menu_id,name');
        $this->db->where('parentid !=', 0);
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[$row['menu_id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;
    }

    function getTopMenus() {
        $data[0] = 'root';
        $this->db->where('parentid', 0);
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[$row['menu_id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;
    }

    function getrootMenus() {
        $this->db->where('parentid', 0);
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[$row['menu_id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;
    }

    function addMenu() {
        $data = array(
            'name' => db_clean($_POST['name']),
            'shortdesc' => db_clean($_POST['shortdesc']),
            'status' => db_clean($_POST['status'], 8),
            'parentid' => id_clean($_POST['parentid']),
            'order' => id_clean($_POST['order'], 10),
            'page_uri' => db_clean($_POST['page_uri'])
        );

        $this->db->insert('menu', $data);
    }

    function updateMenu() {
        $data = array(
            'name' => db_clean($_POST['name']),
            'shortdesc' => db_clean($_POST['shortdesc']),
            'status' => db_clean($_POST['status'], 8),
            'order' => id_clean($_POST['order'], 10),
            'parentid' => id_clean($_POST['parentid']),
            'page_uri' => db_clean($_POST['page_uri'])
        );

        $this->db->where('menu_id', id_clean($_POST['menu_id']));
        $this->db->update('menu', $data);
    }

    function deleteMenu($id) {
        // $data = array('status' => 'inactive');
        $this->db->where('menu_id', id_clean($id));
        $this->db->delete('menu');
    }

    function changeMenuStatus($id) {
        // getting status of page
        $menuinfo = array();
        $menuinfo = $this->getMenu($id);
        $status = $menuinfo['status'];
        if ($status == 'active') {

            $data = array('status' => 'inactive');
            $this->db->where('menu_id', id_clean($id));
            $this->db->update('menu', $data);
        } else {

            $data = array('status' => 'active');
            $this->db->where('menu_id', id_clean($id));
            $this->db->update('menu', $data);
        }
    }

    function exportCsv() {
        $this->load->dbutil();
        $Q = $this->db->query("select * from menu");
        return $this->dbutil->csv_from_result($Q, ",", "\n");
    }

    function checkMenuOrphans($id) {
        $data = array();
        $this->db->select('menu_id,name');
        $this->db->where('parentid', id_clean($id));
        $Q = $this->db->get('menu');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[$row['menu_id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;
    }

}
