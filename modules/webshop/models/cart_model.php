<?php

class Cart_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // Function to retrieve an array with all product information
    function retrieve_products() {
        $query = $this->db->get('product');
        return $query->result_array();
    }

    // Updated the shopping cart

    // Updated the shopping cart
    function validate_update_cart() {
        // Get the total number of items in cart
        $total = $this->cart->total_items();

        // Retrieve the posted information
        $item = $this->input->post('rowid');
        $qty = $this->input->post('qty');
        //print_r($_POST);
        //print_r($total);exit;

        // Cycle true all items and update them
        for ($i = 0; $i < count($item); $i++) {
            // Create an array with the products rowid's and quantities.
            $data = array(
                'rowid' => $item[$i],
                'qty' => $qty[$i]
            );

            // Update the cart with the new information
            $this->cart->update($data);
        }
    }

    // Delete items
    function validate_delete_item($id) {
        $data = array(
            'rowid' => $id,
            'qty' => 0
        );

        if($this->cart->update($data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }

    // Add an item to the cart
    function validate_add_cart_item($id) {

        // $id = $this->input->post('product_id'); // Assign posted product_id to $id
        // $cty = $this->input->post('quantity'); // Assign posted quantity to $cty

        $this->db->where('product_id', $id); // Select where id matches the posted id
        $query = $this->db->get('product', 1); // Select the products where a match is found and limit the query by 1
        // Check if a row has been found
        if ($query->num_rows > 0) {

            foreach ($query->result() as $row) {
                $data = array(
                    'id' => $id,
                    'qty' => 1,
                    'price' => $row->price,
                    'name' => $row->name
                );
                //print_r($data);

                $this->cart->insert($data);
                //print_r($this->cart->contents());
                //exit;
                //echo 'masuk';exit;
                return TRUE;
            }

            // Nothing found! Return FALSE!
        } else {
            return FALSE;
        }
    }

    // Needed?
    //function cart_content(){
    //	return $this->cart->total();
    //}
}

/* End of file cart_model.php */
/* Location: ./application/models/cart_model.php */