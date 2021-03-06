<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * This is for ci_bep
 *
 */
class MCats extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function getCategory($id) {
        $data = array();
        $options = array('category_id' => id_clean($id));
        $Q = $this->db->get_where('category', $options, 1);
        if ($Q->num_rows() > 0) {
            $data = $Q->row_array();
        }
        //echo 'get_category ='.$this->db->last_query();
        $Q->free_result();
        return $data;
    }

    function getAllCategories() {
        $data = array();
        $Q = $this->db->get('category');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getAllActiveCategories() {
        $data = array();
        $this->db->where('status', 'active');
        $this->db->order_by('name', 'asc');
        $Q = $this->db->get('category');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getSubCategories($catid) {
// this runs when $cat['parentid'] < 1 in controllers/welcom.php
// Which means 0 and they are main/top categories.
//e.g. 7 and 8 have parent id 0
        $data = array();
        $this->db->select('category_id,name,shortdesc');
        $this->db->where('parentid', id_clean($catid));
        // When $catid is 7, which has 0 for parent category_id, and looking for items where parentid is this 7 $catid
        $this->db->where('status', 'active');
        $this->db->order_by('name', 'asc');
        $Q = $this->db->get('category'); // this will gives series of items such as 1 shoes, 2 shirts, 3 pants etc.
        if ($Q->num_rows() > 0) {// if there are items then
            foreach ($Q->result_array() as $row) {//each item as an array to $row
                $sql = "select thumbnail as src
       				from product
       				where category_id=" . id_clean($row['category_id']) . "
       				and status='active'
       				order by rand() limit 1";

                $Q2 = $this->db->query($sql);
                // then run a quary. select one thumbnail randumly from products where category_id is $row['category_id']
                // e.g shirts has 2 for $row['category_id']

                if ($Q2->num_rows() > 0) {
                    $thumb = $Q2->row_array();
                    $THUMB = $thumb['src']; // the result src which is result thumbnail is $THUMB
                } else {
                    $THUMB = ''; // otherwise none in $THUMB
                }

                $Q2->free_result();
                $data[] = array(
                    'product_id' => $row['product_id'],
                    'name' => $row['name'],
                    'shortdesc' => $row['shortdesc'],
                    'thumbnail' => $THUMB
                );
            }
        }
        $Q->free_result();

        return $data;
    }

    function getCategoriesNav() {
        $data = array();
        $this->db->select('category_id,name,parentid');
        $this->db->where('status', 'active');
        $this->db->order_by('parentid', 'asc');
        $this->db->order_by('name', 'asc');
        $this->db->group_by('parentid,category_id');
        $Q = $this->db->get('category');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result() as $row) {
                // see the output $navlist at http://127.0.0.1/codeigniter_shopping/test1/cat/7
                if ($row->parentid > 0) {
                    $data[0][$row->parentid]['children'][$row->id] = $row->name;
                    // [0]=>array([7]=>array([children]=>array([4]=dresses)))
                    // [0][8][children][5]=toys
                } else {
                    $data[0][$row->id]['name'] = $row->name;
                    // e.g. [0]=>array([7]=>array([name]=clothes))
                    // e.g. [0][8][name]=fun
                }
            }
        }
        $Q->free_result();
        return $data;
    }

    function getCatNav($parentid) {
        $data = array();
        $this->db->where('status', 'active');
        $this->db->where('parentid', $parentid);
        $this->db->orderby('name', 'asc');
        $Q = $this->db->get('category');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[$row['category_id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;
    }

    function getCategoriesDropDown() {
        $data = array();
        $this->db->select('category_id,name');
        $this->db->where('parentid !=', 0);
        $Q = $this->db->get('category');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[$row['category_id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;
    }

    function getTopCategories() {
        $data[0] = 'root';
        $this->db->where('parentid', 0);
        $Q = $this->db->get('category');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[$row['category_id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;
    }

    function addCategory() {
        $data = array(
            'name' => db_clean($_POST['name']),
            'shortdesc' => db_clean($_POST['shortdesc']),
            'longdesc' => db_clean($_POST['longdesc'], 5000),
            'status' => db_clean($_POST['status'], 8),
            'parentid' => id_clean($_POST['parentid'])
        );

        $this->db->insert('category', $data);
    }

    function addsubMenu($id) {
        $data = array(
            'name' => db_clean($_POST['name']),
            'shortdesc' => db_clean($_POST['shortdesc']),
            'longdesc' => db_clean($_POST['longdesc'], 5000),
            'status' => db_clean($_POST['status'], 8),
            'parentid' => id_clean($_POST['parentid'])
        );

        $this->db->insert('category', $data);
    }

    function updateCategory() {
        $data = array(
            //'name' =>  db_clean($_POST['name']),
            'name' => db_clean($_POST['name']),
            'shortdesc' => db_clean($_POST['shortdesc']),
            'longdesc' => db_clean($_POST['longdesc'], 5000),
            'status' => db_clean($_POST['status'], 8),
            'parentid' => id_clean($_POST['parentid'])
        );

        $this->db->where('category_id', id_clean($_POST['category_id']));
        $this->db->update('category', $data);
    }

    function deleteCategory($id) {
        // $data = array('status' => 'inactive');
        $this->db->where('category_id', id_clean($id));
        $this->db->delete('category');
    }

    function exportCsv() {
        $this->load->dbutil();
        $Q = $this->db->query("select * from category");
        return $this->dbutil->csv_from_result($Q, ",", "\n");
    }

    function checkOrphans($id) {
        $data = array();
        $this->db->select('category_id,name');
        $this->db->where('category_id', id_clean($id));
        $Q = $this->db->get('product');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[$row['category_id']] = $row['name'];
            }
        }
        $Q->free_result();
        return $data;
    }

    function changeCatStatus($id) {
        // getting status of page
        $catinfo = array();
        $catinfo = $this->getCategory($id);
        $status = $catinfo['status'];
        if ($status == 'active') {

            $data = array('status' => 'inactive');
            $this->db->where('category_id', id_clean($id));
            $this->db->update('category', $data);
        } else {

            $data = array('status' => 'active');
            $this->db->where('category_id', id_clean($id));
            $this->db->update('category', $data);
        }
    }

    function getCategoryNamebyProduct($category_id) {
        $this->db->select("category_id,name");
        $this->db->where('category_id', $category_id);
        $this->db->where('status', 'active');
        $sql = $this->db->get('category');

        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $row) {
                $data[$row['category_id']] = $row['name'];
            }
        }
        $sql->free_result();
        return $data;
    }

}

?>