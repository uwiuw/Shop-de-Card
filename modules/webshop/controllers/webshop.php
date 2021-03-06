<?php

class Webshop extends Shop_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('Paypal_Lib');
        // load the form_validation library
        //$this->load->model('subscribers/msubscribers');
    }

    function index() {
        //$this->output->enable_profiler('TRUE');
        // you need to change webshop_lang $lang['webshop_folder'] = 'webshop';
        // according to your folder name.
        $webshop = $this->lang->line('webshop_folder');
        $page = $this->mpages->getPagePath($webshop);
        //echo 'we='.$webshop;exit;
        $featureimages = $this->mproducts->getFrontFeature($webshop, 'most sold');

        // load slideshow preference
        //$this->bep_assets->load_asset_group($this->preference->item('webshop_slideshow'));
        // slideshow images
        $catname = "Slideshow";
        $slideimages = $this->mproducts->getFeatureProducts($catname);
        $data['slides'] = $slideimages;
        $data['content'] = 'cart/products'; // Select view to display
        $data['images'] = $featureimages;
        $data['title'] = lang('webshop_shop_name');
        $data['module'] = lang('webshop_folder');

        $this->template->load($this->_home, 'frontpage', $data);
    }

    function cat($id) {
        //$this->output->enable_profiler('TRUE');
        $cat = $this->mcats->getCategory($id);
        /**
         * $id is the third(3) in URI which represents the ID and any
         * variables that will be passed to the controller.
         */
        if (!count($cat)) {
            // if there is no such a category id, then redirect.
            redirect(lang('webshop_folder') . '/index', 'refresh');
        }
        $data['title'] = lang('webshop_shop_name') . " | " . $cat['name'];

        if ($cat['parentid'] < 1) {
            /**
             * If a parent id is 0, it must be a root category, so show children/sub-categories
             */
            $data['listing'] = $this->mcats->getSubCategories($id);
            /**
             * this will receive a series of array with id, name, shortdesc and thumbnail
             * and store them in listing. Array ([0]=>array([id]=>14 [name]=>long-sleeve...))
             */
            $data['level'] = 1;
        } else {
            // otherwise, it must be a category, so let's show products
            $data['listing'] = $this->mproducts->getProductsByCategory($id);
            // this will receive a series of product with array.id,name,shortdesc,thumbnail
            $data['level'] = 2;
        }
        $data['category'] = $cat;
        $data['module'] = lang('webshop_folder');
        $this->template->load($this->_container, 'category', $data);
    }

    function product($id) {
        $product = $this->mproducts->getProduct($id);
        /** this returns all, i.e. id, name, shortdesc, longdesc, thumbnail,
         * image, grouping, status, category_id, featured and price
         * from product db.
         */
        if (!count($product)) {
            // no product so redirect
            redirect(lang('webshop_folder') . '/index', 'refresh');
        }
        $images = '';
        //print_r($product);exit;
        // Condition for multi image
        if (isset($product['multi'])) {
            unset($product['multi']);
            //print_r($product);exit;
            foreach ($product as $img) {
                $images[] = $img['image_id'] . $img['extension'];
            }
            //print_r($images);exit;
            $data['product'] = $product[0];
            $data['title'] = lang('webshop_shop_name') . " | " . $product[0]['name'];
        } else {
            $data['product'] = $product;
            $data['title'] = lang('webshop_shop_name') . " | " . $product['name'];
        }
        //print_r($images);exit;
        $data['images'] = $images;

        //print_r($product);exit;
        // I am not using colors and sizes, but you can.
        //$data['assigned_colors'] = $this->mproducts->getAssignedColors($id);
        //$data['assigned_sizes'] = $this->mproducts->getAssignedSizes($id);
        $data['module'] = lang('webshop_folder');
        $this->template->load($this->_container, 'product', $data);
    }

    function page($menu) {
        
    }

    function pages($path) {

        $page = $this->mpages->getPagePath($path);
        if (!empty($page)) { //$page will return empty array if there is no page
            $data['pagecontent'] = $page;
            $data['title'] = lang('webshop_shop_name') . " | " . $page['name'];
        } else {
            // if there is no page redirect
            redirect(lang('webshop_folder') . '/index', 'refresh');
        }
        $data['page'] = $this->config->item('backendpro_template_shop') . 'page';
        $data['module'] = lang('webshop_folder');
        $this->template->load($this->_container, 'page', $data);
    }

    function contact() {

        $data['title'] = lang('webshop_shop_name') . " | " . "Contact us";
        //$data['cap_img'] = $this->_generate_captcha();
        $data['module'] = lang('webshop_folder');
        $this->template->load($this->_container, 'contact', $data);
    }

    function _generate_captcha() {
        //$this->bep_assets->load_asset('recaptcha');
        $this->load->module_library('recaptcha', 'Recaptcha');
        return $this->recaptcha->recaptcha_get_html();
    }

    function message() {

        $rules['name'] = 'trim|required|max_length[32]';
        $rules['email'] = 'trim|required|max_length[254]|valid_email';
        $rules['message'] = 'trim|required';
        $rules['recaptcha_response_field'] = 'trim|required|valid_captcha';

        $this->form_validation->set_rules($rules);

        $fields['name'] = lang('general_name');
        $fields['email'] = lang('webshop_email');
        $fields['message'] = lang('message_message');
        $fields['recaptcha_response_field'] = 'Recaptcha';

        $this->form_validation->set_fields($fields);
        /**
         * form_validation, next version of Bep will update to form_validation
         */
        //$this->form_validation->set_rules('name', 'Name', 'required');
        //$this->form_validation->set_rules('email', 'Email',  'required|valid_email');
        //$this->form_validation->set_rules('message', 'Message', 'required');
        //$this->form_validation->set_rules('captcha', 'Captcha', 'required');


        if ($this->form_validation->run() == FALSE) {
            // if any form_validation errors, display them
            $this->form_validation->output_errors();

            $captcha_result = '';
            $data['cap_img'] = $this->_generate_captcha();

            $data['title'] = lang('webshop_shop_name') . " | " . lang('webshop_message_contact_us');
            $data['module'] = lang('webshop_folder');
            $this->template->load($this->_container, 'message', $data);
        } else {
            // you need to send email
            // form_validation has passed. Now send the email
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $message = $this->input->post('message');
            // get email from preferences/settings
            $myemail = $this->preference->item('admin_email');
            $this->load->library('email');
            $this->email->from($email . $name);
            $this->email->to($myemail);
            $this->email->subject(lang('webshop_message_subject'));
            $this->email->message(lang('webshop_message_sender') .
                    $name . "\r\n" . lang('webshop_message_sender_email') . ": " .
                    $email . "\r\n" . lang('webshop_message_message') . ": " . $message);
            $this->email->send();
            //flashMsg('success', lang('webshop_message_thank_for_message'));
            // $this->session->set_flashdata('subscribe_msg', lang('webshop_message_thank_for_message'));
            redirect(lang('webshop_folder') . '/contact');
        }
    }

    /*
     * forgot password send to email 
     */

    function forgot_pass() {
        $email = $this->input->post('email_req');


        if (isset($email)) {
            $data = $this->mcustomers->getPassword($email);

            $this->load->library('email');

            $this->email->from('admin@cherubdefense.com', 'Cherub Defense');
            $this->email->to('coder5@ymail.com');

            $this->email->subject('Cherub Defense Forgot Password');
            $this->email->message('Try to reset your pass by clicking this link.');

            $this->email->send();

            echo $this->email->print_debugger();
        }
    }

    function registration() {
        /* If you are using recaptcha, don't forget to configure modules/recaptcha/config/recaptcha.php
         * Add your own key
         * */
        $captcha_result = '';
        //$data['cap_img'] = $this->_generate_captcha();

        if ($this->input->post('email')) {

            $data['title'] = lang('webshop_shop_name') . " | " . "Registration";

            /* set rules
              $rules['email'] = 'trim|required|matches[emailconf]|valid_email';
              $rules['emailconf'] = 'trim|required|valid_email';
              $rules['password'] = 'trim|required';
              $rules['customer_first_name'] = 'trim|required|min_length[3]|max_length[20]';
              $rules['customer_last_name'] = 'trim|required|min_length[3]|max_length[20]';
              $rules['phone_number'] = 'trim|required|min_length[8]|max_length[12]|numeric';
              $rules['address'] = 'trim|required';
              $rules['city'] = 'trim|required|alpha_dash';
              $rules['post_code'] = 'trim|required|numeric';
              // if you want to use recaptcha, set modules/recaptcha/config and uncomment the following
              $rules['recaptcha_response_field'] = 'trim|required|valid_captcha';
             */
            //$this->form_validation->set_rules($rules);
            // set fields. This will be used for error messages
            // for example instead of customer_first_name, First Name will be used in errors
            $rules = array(
                //array('field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|min_length[5]|max_length[12]|xss_clean'),
                array('field' => 'password', 'label' => 'Password', 'rules' => 'trim|required|matches[passconf]|md5'),
                array('field' => 'passconf', 'label' => 'Password Confirmation', 'rules' => 'trim|required'),
                array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|matches[emailconf]|valid_email'),
                array('field' => 'emailconf', 'label' => 'Email Verified', 'rules' => 'trim|required|valid_email'),
                array('field' => 'customer_first_name', 'First Name' => 'Username', 'rules' => 'trim|required|min_length[3]|max_length[20]'),
                array('field' => 'customer_last_name', 'label' => 'Last Name', 'rules' => 'trim|required|min_length[3]|max_length[20]'),
                array('field' => 'phone_number', 'label' => 'Phone', 'rules' => 'trim|required|min_length[8]|max_length[12]|numeric'),
                array('field' => 'address', 'label' => 'Address', 'rules' => 'trim|required'),
                array('field' => 'city', 'label' => 'City', 'rules' => 'trim|required|alpha_dash'),
                array('field' => 'post_code', 'label' => 'Post Code', 'rules' => 'trim|required|numeric')
            );
            //print_r($rules);exit;
            //$fields['recaptcha_response_field'] = 'Recaptcha';

            $this->form_validation->set_rules($rules);
            // run form_validation
            if ($this->form_validation->run() == FALSE) {
                // if false outputs errors
                // and take them to registration page to show errors
                $data['module'] = lang('webshop_folder');
                $this->template->load($this->_container, 'registration', $data);
            } else {
                $e = $this->input->post('email');
                // otherwise check if the customer's email is in the database
                $numrow = $this->mcustomers->checkCustomer($e);
                if ($numrow == TRUE) {
                    // you have registered before, set the message and redirect to login page.
                    flashMsg('message', lang('webshop_registed_before'));
                    $this->template->load($this->_container, 'registration', $data);
                    // $this->session->set_flashdata('msg', lang('webshop_registed_before'));
                    //redirect(lang('webshop_folder') . '/login', 'refresh');
                } else {
                    // a customer is new, so create the new customer, set message and redirect to login page.
                    $this->mcustomers->addCustomer();
                    flashMsg('message', lang('webshop_thank_registration'));
                    // $this->session->set_flashdata('msg', lang('webshop_thank_registration'));
                    redirect(lang('webshop_folder') . '/login');
                }
            }
        }// end of if($this->input->post('email'))

        $data['title'] = lang('webshop_shop_name') . " | " . "Registration";
        $data['module'] = lang('webshop_folder');
        $this->template->load($this->_container, 'registration', $data);
    }

    function login() {
        if ($this->input->post('email')) {
            $e = $this->input->post('email');
            $pw = $this->input->post('password');
            $this->mcustomers->verifyCustomer($e, $pw);
            if (isset($_SESSION['customer_id'])) {
                //$this->session->set_flashdata('info', lang('success'));
                flashMsg('message', 'Success login');
                //echo 'success';exit;
                if (isset($_SESSION['last_url_shop'])) {
                    $last_url = $_SESSION['last_url_shop'];
                }

                redirect($last_url, 'refresh');
            }
            //echo 'failed';exit;
            flashMsg('message', 'Login incorrect');
            //$this->session->set_flashdata('info', lang('incorrect'));
            redirect(lang('webshop_folder') . '/login', 'refresh');
        }
        $data['title'] = "Customer Login";
        //$data['module'] = lang('webshop_folder');
        $this->template->load($this->_container, 'customerlogin', $data);
    }

    function logout() {
        // this would remove all the variable in the session
        session_unset();

        //destroy the session
        session_destroy();

        redirect(lang('webshop_folder') . '/index', 'refresh');
    }

    function newsletter() {
        $data['title'] = lang('webshop_shop_name') . " | " . "Registration";
        $email = $this->input->post('email');
        $rules = array(
            array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|valid_email'),
            array('field' => 'first_name', 'label' => 'First Name', 'rules' => 'trim|required|'),
            array('field' => 'zip_code', 'label' => 'Zip Code', 'rules' => 'trim|required|numeric'),
                //array('field' => 'passconf', 'label' => 'Password Confirmation', 'rules' => 'trim|required|matches[passconf]|md5')
        );

        $this->form_validation->set_rules($rules);
        // run form_validation
        if ($this->form_validation->run() == FALSE) {
            $data['module'] = lang('webshop_folder');
            $this->template->load($this->_container, 'frontpage', $data);
        } else {
            $numrow = $this->mcustomers->checkNewsletter($email);
            if ($numrow == TRUE) {
                // you have registered before, set the message and redirect to login page.
                flashMsg('message', lang('webshop_registed_before'));
                $this->template->load($this->_container, 'webshop', $data);
                // $this->session->set_flashdata('msg', lang('webshop_registed_before'));
                //redirect(lang('webshop_folder') . '/login', 'refresh');
            } else {
                // a customer is new, so create the new customer, set message and redirect to login page.
                $this->mcustomers->newsletter();
                flashMsg('message', lang('webshop_thank_registration'));
                // $this->session->set_flashdata('msg', lang('webshop_thank_registration'));
                redirect(lang('webshop_folder') . '/index');
            }
        }
    }

    function subscribe() {
        $data['title'] = lang('webshop_shop_name') . " | " . 'Subscribe to our News letter';

        $captcha_result = '';
        $data['cap_img'] = $this->_generate_captcha();
        if ($this->input->post('name')) {
            $rules['name'] = 'required';
            $rules['email'] = 'required|valid_email';
            $rules['recaptcha_response_field'] = 'trim|required|valid_captcha';

            $this->form_validation->set_rules($rules);

            $fields['email'] = lang('webshop_email');
            $fields['name'] = lang('subscribe_name');
            $fields['recaptcha_response_field'] = 'Recaptcha';
            $this->_generate_captcha('test');
            $this->form_validation->set_fields($fields);

            if ($this->form_validation->run() == FALSE) {
                // if false outputs errors
                $this->form_validation->output_errors();
            } else {
                $email = $this->input->post('email');
                // otherwise check if the customer's email is in the database
                $numrow = $this->msubscribers->checkSubscriber($email);
                if ($numrow == TRUE) {
                    // you have registered before, set the message and redirect to login page.
                    //flashMsg('info', lang('subscribe_registed_before'));
                    redirect(lang('webshop_folder') . '/subscribe', 'refresh');
                }
                $this->msubscribers->createSubscriber();
                //flashMsg('success', lang('subscribe_thank_for_subscription'));
                redirect(lang('webshop_folder') . '/subscribe', 'refresh');
            }
        }
        $data['module'] = lang('webshop_folder');
        $this->template->load($this->_container, 'subscribe', $data);
    }

    function unsubscribe($email = '') {
        if (!$this->input->post('email')) {
            $data['title'] = lang('webshop_shop_name') . " | " . 'Unsubscribe our Newsletter';
            $captcha_result = '';
            $data['cap_img'] = $this->_generate_captcha();
            $data['module'] = lang('webshop_folder');
            $this->template->load($this->_container, 'unsubscribe', $data);
        } else {

            $rules['email'] = 'trim|required|max_length[254]|valid_email';
            $rules['recaptcha_response_field'] = 'trim|required|valid_captcha';

            $this->form_validation->set_rules($rules);

            $fields['email'] = lang('webshop_email');
            $fields['recaptcha_response_field'] = 'Recaptcha';

            $this->form_validation->set_fields($fields);

            if ($this->form_validation->run() == FALSE) {
                // if false outputs errors
                $this->form_validation->output_errors();
                redirect(lang('webshop_folder') . '/unsubscribe', 'refresh');
            } else {
                $email = $this->input->post('email');
                $this->msubscribers->removeSubscriber($email);
                //flashMsg('success', lang('subscribe_you_been_unsubscribed'));
                redirect(lang('webshop_folder') . '/index', 'refresh');
            }
        }
    }

    function insert() {
        $data = array(
            'id' => 'sku_123ABC',
            'qty' => 1,
            'price' => 39.95,
            'name' => 'T-Shirt',
            'options' => array('Size' => 'L', 'Color' => 'Red')
        );

        $this->cart->insert($data);
        print_r($this->cart->contents());
    }

    /*
     *  show shopping cart details
     */

    function cart() {
        $data['cart'] = 'cart';
        $data['title'] = 'Your Shopping Cart';
        $this->template->load($this->_container, 'cart', $data);
        //$this->load->view('cart',$data);
    }

    /*
     *  Add item shopping cart using CodeIgniter Shopping Cart Class
     */

    function add_cart_item() {
        $id = $this->input->post('product_id');
        if ($this->cart_model->validate_add_cart_item($id) == TRUE) {

            // Check if user has javascript enabled
            if ($this->input->post('ajax') != '1') {
                //echo 'test';exit;
                redirect('webshop/index'); // If javascript is not enabled, reload the page with new data
            } else {
                echo 'true'; // If javascript is enabled, return true, so the cart gets updated
            }
        }
    }

    /*
     *  Update shopping cart using CodeIgniter Shopping Cart Class
     */

    function update_cart() {
        $this->cart_model->validate_update_cart();
        redirect('webshop/cart');
    }

    /*
     *  Update shopping cart using CodeIgniter Shopping Cart Class
     */

    function delete_item() {
        $id = $this->input->post('rowid');
        // echo $id;
        //echo 'test';
        if ($this->cart_model->validate_delete_item($id) == TRUE) {
            //echo $id;
            // Check if user has javascript enabled
            if ($this->input->post('ajax') != '1') {
                //echo 'test';exit;
                redirect('webshop/index'); // If javascript is not enabled, reload the page with new data
            } else {
                echo 'true'; // If javascript is enabled, return true, so the cart gets updated
            }
        }
    }

    /*
     *  Show total cart
     */

    function total() {
        echo $this->cart->total();
    }

    /*
     *  Show shopping cart using CodeIgniter Shopping Cart Class
     */

    function show_cart() {
        $this->load->view('webshop/cart');
        //$this->load->view('webshop');
    }

    /*
     *  Empty shopping cart using CodeIgniter Shopping Cart Class
     */

    function empty_cart() {
        $this->cart->destroy();
        redirect('webshop');
    }

    function shippingprice() {
        // You need to modify this. This is for Norwegian system. At the moment, if a max of individual product is more
        // than 268 kr, then shipping price will be 65 kr otherwise 0 kr or 25 kr.
        $maxprice = 0;
        if ($this->cart->total()) {
            foreach ($this->cart->contents() as $item) {
                if ($item['price'] > $maxprice) {
                    $maxprice = $item['price'];
                }
            }
            $data['maxprice'] = $maxprice;
            $shippingprice = 0;
            if ($maxprice > 268) {
                $shippingprice = 65.0;
            } elseif ($maxprice == 0) {
                $shippingprice = 0;
            } else {
                $shippingprice = 25.0;
            }
            $_SESSION['shippingprice'] = $shippingprice;
            $data['shippingprice'] = $shippingprice;
            return $data;
        }
    }

    function search($search_url = NULL) {
        /**
         * form in views/header.php point to this search
         * form_open("websearch");
         * This will look in name, shortdesc and longdesc
         *
         */
        $term = $this->input->post('term');

        if ($term) {
            /**
             * In CodeIgniter, the way to check for form input is to use the $this - > input - > post() method
             */
            $data['results'] = $this->mproducts->search($term);
            /**
             * This output id,name,shortdesc,thumbnail
             */
            //redirect(lang('webshop_folder') . '/search/'.$term);
        } else {
            redirect(lang('webshop_folder') . '/index', 'refresh');
            /**
             * if nothing in search form, then redirect to index
             */
        }
        //$data['main'] = 'websearch';// this is using views/search.php. Output will be displayed in views/search.php
        $data['title'] = lang('webshop_shop_name') . " | " . "Search Results";

        //$this->load->vars($data);
        //$this->load->view('webtemplate');

        $data['module'] = lang('webshop_folder');
        $this->template->load($this->_container, 'search', $data);
    }

    function gallery($id) {
        $data['title'] = lang('webshop_shop_name') . " | " . "Gallery " . $id;
        $data['products'] = $this->mproducts->getGallery($id);
        // getGalleryone returns id, name shortdesc thumbnail image class grouping category
        $data['main'] = 'gallery'; // this is using views/galleryone.php etc
        $data['galleriid'] = $id; // used for if statement to add top sub-category
        $this->load->vars($data);
        $this->template->load($this->_container, 'webtemplate', $data);
    }

    function checkout() {

        // $this->morders->verifyCart();
        //$data['main'] = 'webconfirmorder';// this is using views/confirmaorder.php
        $data['title'] = lang('webshop_shop_name') . " | " . "Order Confirmation";


        $totalprice = $this->cart->total();
        //echo 'totaaaal ='.$totalprice;
        $shippingprice = $this->shippingprice();
        $grandtotal = (int) $totalprice + $shippingprice['shippingprice'];

        $data['shippingprice'] = $shippingprice['shippingprice'];
        if (isset($_SESSION['customer_id'])) {
            $data['fname'] = $_SESSION['customer_first_name'];
            $data['lname'] = $_SESSION['customer_last_name'];
            $data['telephone'] = $_SESSION['phone_number'];
            $data['email'] = $_SESSION['email'];
            $data['address'] = $_SESSION['address'];
            $data['city'] = $_SESSION['city'];
            $data['pcode'] = $_SESSION['post_code'];
        }
        $data['grandtotal'] = 0;
        //echo $_SESSION['phone_number'];exit;


        $data['module'] = lang('webshop_folder');
        $this->template->load($this->_container, 'confirmorder', $data);
    }

    function emailorder() {

        $data['title'] = lang('webshop_shop_name') . " | " . "checkout";


        $rules = array(
            //array('field' => 'username', 'label' => 'Username', 'rules' => 'trim|required|min_length[5]|max_length[12]|xss_clean'),
            array('field' => 'email', 'label' => 'Email', 'rules' => 'trim|required|matches[emailconf]|valid_email'),
            array('field' => 'emailconf', 'label' => 'Email Verified', 'rules' => 'trim|required|valid_email'),
            array('field' => 'customer_first_name', 'First Name' => 'Username', 'rules' => 'trim|required|min_length[3]|max_length[20]'),
            array('field' => 'customer_last_name', 'label' => 'Last Name', 'rules' => 'trim|required|min_length[3]|max_length[20]'),
            array('field' => 'telephone', 'label' => 'Telephone', 'rules' => 'trim|required|min_length[8]|max_length[12]|numeric'),
            array('field' => 'shippingaddress', 'label' => 'Shipping Address', 'rules' => 'trim|required'),
            array('field' => 'city', 'label' => 'City', 'rules' => 'trim|required|alpha_dash'),
            array('field' => 'post_code', 'label' => 'Post Code', 'rules' => 'trim|required|numeric')
        );

        $shippingprice = $this->shippingprice();
        $data['shippingprice'] = $shippingprice['shippingprice'];


        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == FALSE) {
            // $this->session->set_flashdata('msg', 'Please fill all the fields. Please try again!');
            // send back to confirmorder. form_validation error will be displayed automatically
            //$this->form_validation->output_errors();
            $data['module'] = lang('webshop_folder');
            $this->template->load($this->_container, 'confirmorder', $data);
        } else {
            /*
             * If form_validation is ok, then
             * 1. enter customer info to db through $this->morders->entercustomerinfo();
             * 2. enter oder info to db through $this->morders->enterorderinfo();
             * 3. enter oder items to db $this->morders->enterorderitems();
             * 4. send email to the customer and me
             * 5. redirect to ordersuccess page and display thanks message
             *
             */
            $totalprice = $this->cart->total();

            $this->morders->enterorder();

            //Create body of message by cleaning each field and then appending each name and value to it

            $body = "<h1>" . lang('email_here_is') . "</h1><br />";
            $email = db_clean($this->input->post('email'));
            $lastname = db_clean($this->input->post('lname'));
            $firstname = db_clean($this->input->post('fname'));
            $name = $firstname + " " + $lastname;

            // $shipping= 65;
            $shipping = $_SESSION['shippingprice'];
            $body .= "<table border='1' cellspacing='0' cellpadding='5' width='80%'><tr><td><b>" . lang('email_number_of_order') . "</b></td><td><b>" . lang('email_product_name') . "</b></td><td><b>" . lang('email_product_price') . "</b></td></tr>";
            if (count($this->cart->total())) {
                $count = 1;
                foreach ($this->cart->contents() as $items) {

                    $body .= "<tr><td><b>" . $items['qty'] . "</b></td><td><b>" . $items['name'] . "</b></td><td><b>" . $items['price'] . "</b></td></tr>";
                }
            }
            $grandtotal = (int) $totalprice + $shipping;
            $body .= "<tr><td colspan='2'><b>" . lang('orders_sub_total_nor') . " </b></td><td colspan='1'><b>" . number_format($totalprice, 2, '.', ',') . "</b></td></tr>";
            $body .= "<tr><td colspan='2'><b>" . lang('orders_shipping_nor') . " </b></td><td colspan='1'><b>" . number_format($shipping, 2, '.', ',') . "</b></td></tr>";
            $body .= "<tr><td colspan='2'><b>" . lang('orders_total_with_shipping') . " </b></td><td colspan='1'><b>" . number_format($grandtotal, 2, '.', ',') . "</b></td></tr>";
            $body .= "</table><br />";

            $body .= "<table border=\"1\" cellspacing='0' cellpadding='5' width='80%'>";
            $body .= "<tr><td><b>" . lang('orders_name') . ": </b></td><td><b>" . $_POST['customer_first_name'] . " " . $_POST['customer_last_name'] . "</b></td></tr>";
            $body .= "<tr><td><b>" . lang('orders_email') . ": </b></td><td><b>" . $_POST['email'] . "</b></td></tr>";
            $body .= "<tr><td><b>" . lang('orders_mobile_tel') . ": </b></td><td><b>" . $_POST['telephone'] . "</b></td></tr>";
            $body .= "<tr><td><b>" . lang('orders_shipping_address') . ": </b></td><td><b>" . $_POST['shippingaddress'] . "</b></td></tr>";
            $body .= "<tr><td><b>" . lang('orders_post_code') . ": </b></td><td><b>" . $_POST['post_code'] . "</b></td></tr>";
            $body .= "<tr><td><b>" . lang('orders_city') . ": </b></td><td><b>" . $_POST['city'] . "</b></td></tr>";
            $body .= "</table>";
            $body .= "<p><b>" . lang('email_we_will_call') . "</b></p>";
            extract($_POST);
            //removes newlines and returns from $email and $name so they can't smuggle extra email addresses for spammers

            $headers = "Content-Type: text/html; charset=UTF-8\n";
            $headers .= "Content-Transfer-Encoding: 8bit\n\n";

            //Create header that puts email in From box along with name in parentheses and sends bcc to alternate address
            $from = 'From: ' . $email . "(" . $name . ")" . "\r\n" . 'Bcc: admin@gmail.com' . "\r\n";


            //Creates intelligible subject line that also shows me where it came from
            $subject = 'webshop.com Order confirmation';

            //Sends mail to me, with elements created above
            mail('admin@gmail.com', $subject, $body, $headers, $from);
            // Send confirmation email to the customer
            mail($email, $subject, $body, $headers, 'post@webshop.com');

            // $this->session->set_flashdata('msg', 'Thank you for your order! We will get in touch as soon as possible.');
            redirect(lang('webshop_folder') . '/ordersuccess');
        }
    }

    function ordersuccess() {
        $totalprice = $this->cart->total();
        $shippingprice = $this->shippingprice();
        $grandtotal = (int) $totalprice + $shippingprice['shippingprice'];
        $this->paypal_lib->add_field('business', 'admin@cherubdefense.com');
        $this->paypal_lib->add_field('return', site_url('webshop/success'));
        $this->paypal_lib->add_field('cancel_return', site_url('webshop/cancel'));
        $this->paypal_lib->add_field('notify_url', site_url('webshop/ipn')); // <-- IPN url
        $this->paypal_lib->add_field('custom', '1234567890'); // <-- Verify return

        $this->paypal_lib->image('/assets/images/btn_paypal.gif');
        $this->paypal_lib->add_field('item_name', 'Payment For Cherub Defense Items');

        foreach ($this->cart->contents() as $items) {
            // $this->paypal_lib->add_field($items['name'], $items['price']);
        }
        $this->paypal_lib->add_field('amount', $grandtotal);


        // otherwise, don't write anything or (if you want to
        // change the default button text), write this:
        // $this->paypal_lib->button('Click to Pay!');

        $data['paypal_form'] = $this->paypal_lib->paypal_form();
        $data['title'] = lang('webshop_shop_name') . " | " . "Contact us";
        $data['module'] = lang('webshop_folder');
        $this->template->load($this->_container, 'ordersuccess', $data);
    }

    function cancel() {
        $this->template->load($this->_container, 'paypal/cancel');
    }

    function success() {
        // This is where you would probably want to thank the user for their order
        // or what have you.  The order information at this point is in POST
        // variables.  However, you don't want to "process" the order until you
        // get validation from the IPN.  That's where you would have the code to
        // email an admin, update the database with payment status, activate a
        // membership, etc.
        // You could also simply re-direct them to another page, or your own
        // order status page which presents the user with the status of their
        // order based on a database (which can be modified with the IPN code
        // below).

        $data['pp_info'] = $this->input->post();
        $this->template->load($this->_container, 'paypal/success', $data);
    }

    function ipn() {
        // Payment has been received and IPN is verified.  This is where you
        // update your database to activate or process the order, or setup
        // the database with the user's order details, email an administrator,
        // etc. You can access a slew of information via the ipn_data() array.
        // Check the paypal documentation for specifics on what information
        // is available in the IPN POST variables.  Basically, all the POST vars
        // which paypal sends, which we send back for validation, are now stored
        // in the ipn_data() array.
        // For this example, we'll just email ourselves ALL the data.
        $to = 'YOUR@EMAIL.COM';    //  your email

        if ($this->paypal_lib->validate_ipn()) {
            $body = 'An instant payment notification was successfully received from ';
            $body .= $this->paypal_lib->ipn_data['payer_email'] . ' on ' . date('m/d/Y') . ' at ' . date('g:i A') . "\n\n";
            $body .= " Details:\n";

            foreach ($this->paypal_lib->ipn_data as $key => $value)
                $body .= "\n$key: $value";

            // load email lib and email results
            $this->load->library('email');
            $this->email->to($to);
            $this->email->from($this->paypal_lib->ipn_data['payer_email'], $this->paypal_lib->ipn_data['payer_name']);
            $this->email->subject('CI paypal_lib IPN (Received Payment)');
            $this->email->message($body);
            $this->email->send();
        }
    }

}

//end controller class