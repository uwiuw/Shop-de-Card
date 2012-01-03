<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MPages extends CI_Model{

	function __construct(){
		parent::__construct();
	}


	function getPage($id){
	    $data = array();
	    $this->db->where('page_id',id_clean($id));
	    $this->db->limit(1);
	    $Q = $this->db->get('page');
	    if ($Q->num_rows() > 0){
	      	$data = $Q->row_array();
	    }
	    $Q->free_result();    
	    return $data;    
	}
	
	function getPagePath($path){
	    $data = array();
	    $this->db->where('path',db_clean($path));
	    $this->db->where('status', 'active');
	    $this->db->limit(1);
	    $Q = $this->db->get('page');
	    if ($Q->num_rows() > 0){
	      	$data = $Q->row_array();
	    }else{
			$data = array();// this prevent visiting unexistent page  
		}
	    $Q->free_result();
	    return $data;    
	}

	 
	function getAllPages(){
	     $data = array();
	     $Q = $this->db->get('page');
	     if ($Q->num_rows() > 0){
	       	foreach ($Q->result_array() as $row){
	         	$data[] = $row;
	       	}
	    }
	    $Q->free_result();  
	    return $data; 
	}
	
	 
	function getAllPageswithnone(){
	     $data[0] = 'none';
	     $Q = $this->db->get('page');
	     if ($Q->num_rows() > 0){
	       	foreach ($Q->result_array() as $row){
	         	$data[$row['page_id']] = $row['name'];
	       }
	    }
	    $Q->free_result();  
	    return $data; 
	}
	 
	 function getAllPathwithnone(){
	     $data[0] = 'none';
	     $Q = $this->db->get('page');
	     if ($Q->num_rows() > 0){
	       	foreach ($Q->result_array() as $row){
	        	$data[$row['path']] = $row['path'];
	       	}
	    }
	    $Q->free_result();  
	    return $data; 
	 }
		
	 
	 function addPage(){
		$data = array( 
			'name' => db_clean($_POST['name']),
			'keywords' => db_clean($_POST['keywords']),
			'description' => db_clean($_POST['description']),
			'status' => db_clean($_POST['status'],8),
			'path' => db_clean($_POST['path']),
			'content' => $_POST['content'],
		);
	
		$this->db->insert('page', $data);	 
	 }
	 
	 
	 function updatePage(){
		$data = array( 
			'name' => db_clean($_POST['name']),
			'keywords' => db_clean($_POST['keywords']),
			'description' => db_clean($_POST['description']),
			'status' => db_clean($_POST['status'],8),
			'path' => db_clean($_POST['path']),
			'content' => $_POST['content'],
	);
	
	 	$this->db->where('page_id', id_clean($_POST['page_id']));
		$this->db->update('page', $data);	
	 
	 }

	 
	 function deletePage($id){
	 	$this->db->where('page_id', id_clean($id));
		$this->db->delete('page');	
	 }
	 
	 
	 function changePageStatus($id){
		// getting status of page
		$pageinfo = array();
		$pageinfo = $this->getPage($id);
		$status = $pageinfo['status'];
		if($status =='active'){
			$data = array('status' => 'inactive');
			$this->db->where('page_id', id_clean($id));
			$this->db->update('page', $data);	
		}else{
			$data = array('status' => 'active');
			$this->db->where('page_id', id_clean($id));
			$this->db->update('page', $data);	
		}
	 }
	 
}

?>