<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class MProducts extends CI_Model {

    function __construct() {
        parent::__construct();
        //$this->load->model('categories/mcats');
    }

    function getProduct($id) {
        // getting info of single product.
        $data = array();
        $options = array('product_id' => id_clean($id));
        //$Q = $this->db->get_where('product', $options, 1);

        $Q = $this->db->query('SELECT *,p.name AS name, p.status AS pstatus, p.product_id as product_id FROM product p
                                LEFT JOIN image i ON p.product_id = i.product_id
                                WHERE p.product_id ="' . $id . '" ORDER BY p.name ASC');
        //echo $this->db->last_query();
        if ($Q->num_rows() > 0 && $Q->num_rows() == 1) {
            $data = $Q->row_array();
        } elseif ($Q->num_rows > 1) {
            $data = $Q->result_array();
            $data['multi'] = 1;
        }
        //echo $this->db->last_query();
        $Q->free_result();
        return $data;
    }

    function showAllProductImg() {
        $sql = $this->db->query('SELECT * FROM image');
        return $sql->result();
    }

    function showProductImg($id) {
        $sql = $this->db->query('SELECT * FROM image WHERE product_id =' . $id);
        //echo $this->db->last_query();
        return $sql->result();
    }

    function getAllProducts() {
        // getting all the products of the same categroy.
        $data = array();
        $Q = $this->db->query('SELECT P.*, C.Name AS CatName FROM product AS P LEFT JOIN category AS C ON C.category_id = P.category_id WHERE P.name!="1"');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    /* Not used any more
     * This was used to get featured products. Need to replace featured_name_here to a featured name.
      function getProducts(){
      $data = array();
      $Q = $this->db->query('SELECT P.*, C.Name AS CatName
      FROM product AS P
      LEFT JOIN category AS C ON C.id = P.category_id
      WHERE featured = "featured_name_here"');
      return $Q;
      }
     */

    function getProductsByCategory($catid) {
        // this is used in function cat($id) in the shop frontend
        // When a product is clicked this will be used.
        // If not $cat['parentid'] < 1
        // $catid is given in URI, the third element
        $data = array();
        /*
          $this->db->where('category_id', id_clean($catid));
          $this->db->where('status', 'active');
          $this->db->order_by('name', 'asc');
          $Q = $this->db->get('product');
         */
        $Q = $this->db->query('SELECT *,p.name AS name FROM product p
                                INNER JOIN image i ON p.product_id = i.product_id
                                WHERE p.category_id ="' . $catid . '"
                                 AND p.status ="active" GROUP BY i.product_id ORDER BY p.name,i.default ASC');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        //echo $this->db->last_query();
        $Q->free_result();
        return $data;
    }

    function getProductsByGroup($limit, $group, $skip) {
        // page 99
        // for the shop fron-end controller function product($id)
        $data = array();
        if ($limit == 0) {
            $limit = 3;
        }
        $this->db->select('product_id,name,shortdesc,thumbnail');
        $this->db->where('grouping', db_clean($group, 16));
        $this->db->where('status', 'active');
        $this->db->where('product_id !=', id_clean($skip));
        $this->db->orderby('name', 'asc');
        $this->db->limit($limit);
        $Q = $this->db->get('product');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getGallery($id) {

        $data = array();

        $Q = $this->db->query('SELECT P.*, C.Name AS CatName
				   FROM product AS P
				   LEFT JOIN category C
				   ON C.category_id = P.category_id
				   WHERE C.Name = "Galleri ' . $id . '"
				   AND P.status = "active"
				   ');


        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }

        $Q->free_result();

        return $data;
    }

    function getImg($id) {
        $query = $this->db->query("SELECT * FROM image WHERE image_id=" . $id);
        return $query->row();
    }

    function getMainFeature() {
        $data = array();
        $this->db->select("product_id,name,shortdesc,image");
        $this->db->where('featured', 'true');
        $this->db->where('status', 'active');
        $this->db->order_by('name', 'random');

        $Q = $this->db->get('product');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getFrontFeature($feature, $other_feature=NULL) {
        $data = array();
        /*
          $this->db->join('image', 'image.product_id = product.product_id','left');
          $this->db->where('featured', $feature);
          $this->db->where('status', 'active');
          $this->db->LIMIT(4);
          $this->db->order_by('name', 'random');
          $Q = $this->db->get('product'); */
        $others = $other_feature == NULL ? '' : "AND other_feature ='{$other_feature}'";
        //echo $others;exit;
        $sql = $this->db->query("SELECT *,p.product_id AS product_id, p.name  AS name, LEFT(shortdesc, 30) as shortdesc  FROM product p
                        INNER JOIN `image` i ON i.product_id = p.product_id
                        WHERE `featured` = '$feature' $others AND `status` = 'active' AND p.name!=1
                        ORDER BY RAND() LIMIT 4");
        //echo $this->db->last_query();
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $row) {
                $data[] = $row;
            }
        }
        $sql->free_result();
        return $data;
    }

    function getFeatureProducts($catname) {
        $data = array();
        $Q = $this->db->query("SELECT P.*, C.Name AS CatName
	                   FROM product AS P
	                   LEFT JOIN category AS C
	                   ON C.category_id = P.category_id
	                   WHERE C.Name = '$catname'
	                   AND P.status = 'active'
	                   ORDER BY RAND() LIMIT 4
	                   ");
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getFrontbottom() {
        $data = array();
        $Q = $this->db->query("SELECT P.*, C.Name AS CatName
	                   FROM product AS P
	                   LEFT JOIN category AS C
	                   ON C.category_id = P.category_id
	                   WHERE C.Name = 'Front bottom'
	                   AND P.status = 'active''
	                   ORDER BY RAND()
	                   ");
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function getRandomProducts($limit, $skip) {
        // when you want to select three random products, use this.
        $data = array();
        $temp = array();
        if ($limit == 0) {
            $limit = 3; // change this number
        }
        $this->db->select("product_id,name,thumbnail,category_id");
        $this->db->where('product_id !=', id_clean($skip));
        $this->db->where('status', 'active');
        $this->db->orderby("category_id", "asc");
        $this->db->limit(100);
        $Q = $this->db->get('product');
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $temp[$row['category_id']] = array(
                    "id" => $row['product_id'],
                    "name" => $row['name'],
                    "thumbnail" => $row['thumbnail']
                );
            }
        }

        shuffle($temp);
        if (count($temp)) {
            for ($i = 1; $i <= $limit; $i++) {
                $data[] = array_shift($temp);
            }
        }
        $Q->free_result();
        return $data;
    }

    function search($term) {
        $data = array();
        $sql = $this->db->query("SELECT * FROM product p
                                INNER JOIN image i ON i.product_id = p.product_id
                                WHERE (p.name LIKE '%$term%' OR shortdesc LIKE '%$term%' OR longdesc LIKE '%$term%')
                                AND status='active' ORDER BY p.name ASC LIMIT 50
            ");
        /*
          $this->db->select('product_id,name,shortdesc');
          $this->db->where("(name LIKE '%$term%' OR shortdesc LIKE '%$term%' OR longdesc LIKE '%$term%') AND status='active'");
          $this->db->orderby('name', 'asc');
          $this->db->limit(50);
          $Q = $this->db->get('product'); */
        if ($sql->num_rows() > 0) {
            foreach ($sql->result_array() as $row) {
                $data[] = $row;
            }
        }
        $sql->free_result();
        return $data;
    }

    function addProduct() {
        $data = $this->dataProduct();
        $this->db->insert('product', $data);
        $new_product_id = $this->db->insert_id();
    }

    function addImage($data) {
        $this->db->insert('image', $data);
        return $this->db->insert_id();
    }

    function insertIdProduct() {
        $data['name'] = '1';
        $this->db->insert('product', $data);
        return $this->db->insert_id();
    }

    function insertProduct() {
        $data = array(
            'name' => db_clean($_POST['name']),
            'shortdesc' => db_clean($_POST['shortdesc']),
            'longdesc' => db_clean($_POST['longdesc'], 5000),
            'status' => db_clean($_POST['status'], 8),
            'product_order' => db_clean($_POST['product_order']),
            'class' => db_clean($_POST['class'], 30),
            'grouping' => db_clean($_POST['grouping'], 16),
            'category_id' => id_clean($_POST['category_id']),
            'featured' => db_clean($_POST['featured'], 20),
            'price' => db_clean($_POST['price'], 16),
            'other_feature' => db_clean($_POST['other_feature'], 20),
            'thumbnail' => db_clean($_POST['thumbnail']),
            'image' => db_clean($_POST['image'])
        );
        $this->db->insert('product', $data);
        $new_product_id = $this->db->insert_id();
    }

    function updateProduct() {
        $data = $this->dataProduct();
        $this->db->where('product_id', $_POST['product_id']);
        $this->db->update('product', $data);
        /* $this->db->where('product_id', $_POST['product_id']);
          $this->db->delete('product_colors');
          $this->db->where('product_id', $_POST['product_id']);
          $this->db->delete('product_sizes');
          if (isset($_POST['colors'])) {
          foreach ($_POST['colors'] as $value) {
          $data = array('product_id' => $_POST['product_id'],
          'color_id' => $value);
          $this->db->insert('product_colors', $data);
          }
          }

          if (isset($_POST['sizes'])) {
          foreach ($_POST['sizes'] as $value) {
          $data = array('product_id' => $_POST['product_id'],
          'size_id' => $value);
          $this->db->insert('product_sizes', $data);
          }
          }
         *
         */
    }

    function new_updateProduct() {
        $data = array(
            'name' => db_clean($_POST['name']),
            'shortdesc' => db_clean($_POST['shortdesc']),
            'longdesc' => db_clean($_POST['longdesc'], 5000),
            'status' => db_clean($_POST['status'], 8),
            'stock_status' => db_clean($_POST['stock_status'], 20),
            'ship_restrict' => db_clean($_POST['ship_restrict'], 100),
            'product_order' => db_clean($_POST['product_order']),
            'class' => db_clean($_POST['class'], 30),
            'grouping' => db_clean($_POST['grouping'], 16),
            'category_id' => id_clean($_POST['category_id']),
            'featured' => db_clean($_POST['featured'], 20),
            'price' => db_clean($_POST['price'], 16),
            'other_feature' => db_clean($_POST['other_feature'], 20),
                //'thumbnail' => db_clean($_POST['thumbnail']),
                //'image' => db_clean($_POST['image'])
        );
        $this->db->where('product_id', $_POST['product_id']);
        $this->db->update('product', $data);
    }

    function getFeaturedProducts($feature) {
        $data = array();
        $this->db->from('product');
        $this->db->where('other_feature', $feature);
        $this->db->where('status', 'active');
        $this->db->limit(1);
        $this->db->order_by("id", "random");
        $Q = $this->db->get();
        if ($Q->num_rows() > 0) {
            foreach ($Q->result_array() as $row) {
                $data[] = $row;
            }
        }
        $Q->free_result();
        return $data;
    }

    function dataProduct() {
        $data = array(
            'name' => db_clean($_POST['name']),
            'shortdesc' => db_clean($_POST['shortdesc']),
            'longdesc' => db_clean($_POST['longdesc'], 5000),
            'status' => db_clean($_POST['status'], 8),
            'stock_status' => db_clean($_POST['stock_status'], 20),
            'ship_restrict' => db_clean($_POST['ship_restrict'], 100),
            'class' => db_clean($_POST['class'], 30),
            'grouping' => db_clean($_POST['grouping'], 16),
            'category_id' => id_clean($_POST['category_id']),
            'featured' => db_clean($_POST['featured'], 20),
            'price' => db_clean($_POST['price'], 16),
            'other_feature' => db_clean($_POST['other_feature'], 20)
        );
        $catname = array();
        $category_id = $data['category_id'];
        $catname = $this->mcats->getCategoryNamebyProduct($category_id);
        foreach ($catname as $key => $name) {
            $foldername = createdirname($name);
        }
        return $data;
    }

    function deleteProduct($id) {
        // $data = array('status' => 'inactive');
        $this->db->where('product_id', id_clean($id));
        $this->db->delete('product');
    }

    function deleteImg($id) {
        $this->db->where('image_id', id_clean($id));
        $this->db->delete('image');
    }

    function changePrimary($id) {
        $imginfo = $this->getImg($id);
        $status = $imginfo->default;
        if ($status == '1') {
            $data = array('default' => '0');
            $query = $this->db->query("UPDATE image
                                        SET `default`=0 WHERE image_id =" . id_clean($id));
        } else {
            $data = array('default' => '1');
            $query = $this->db->query("UPDATE image
                                        SET `default`=0 WHERE image_id !=" . id_clean($id));
            $query = $this->db->query("UPDATE image
                                        SET `default`=1 WHERE image_id =" . id_clean($id));
        }
    }

    function changeProductStatus($id) {
        // getting status of page
        $productinfo = array();
        $productinfo = $this->getProduct($id);
        $status = $productinfo['pstatus'];

        //print_r($status);exit;
        if ($status == 'active') {
            $data = array('status' => 'inactive');
            $this->db->where('product_id', id_clean($id));
            $this->db->update('product', $data);
        } else {
            $data = array('status' => 'active');
            $this->db->where('product_id', id_clean($id));
            $this->db->update('product', $data);
        }
    }

    function exportProduct() {
        $file_now = 'product_' . date('Ymd-H_i_s') . '.csv';
        $query = $this->db->query(" SELECT 'Product Name','Category Name','Short Desc','Long Desc','Status','Stock','Shipping Restriction'
                                    UNION SELECT
                                    p.name , c.name  , p.shortdesc,p.longdesc  , p.status  ,p.stock_status  ,p.ship_restrict
                                    FROM product as p
                                    INNER JOIN category as c ON c.category_id = p.category_id
                                    INTO OUTFILE '/tmp/$file_now' FIELDS TERMINATED BY '|' LINES TERMINATED BY '\\r\\n';
                                    ");
        $this->load->helper('download');
        $file_path = '/tmp/' . $file_now;
        $files_real = file_get_contents($file_path);
        force_download($file_now, $files_real);
    }

}
