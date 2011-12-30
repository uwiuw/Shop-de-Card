<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Products extends Admin_Controller {

    private $options;

    public function __construct($options=null) {
        parent::__construct();

        $this->check();
        $this->load->model('mproducts');
        $this->load->model('categories/mcats');
        // Your own constructor code
    }

    function index() {
        // Setting variables
        $data['title'] = "Manage Products";
        $data['products'] = $this->mproducts->getAllProducts();
        $data['categories'] = $this->mcats->getCategoriesDropDown();
        // we are pulling a header word from language file
        $data['module'] = 'products';
        $this->template->load($this->_container, 'admin_product_home', $data);
    }

    function create() {
        // we are using TinyMCE in this page, so load it
        //$this->bep_assets->load_asset_group('TINYMCE');

        if ($this->input->post('name')) {
            // fields are filled up so do the followings
            $this->mproducts->insertProduct();
            // CI way to set flashdata, but we are not using it
            // flashMsg('message','Product created');
            // we are using Bep function for flash msg
            flashMsg('message', 'Product created');
            redirect('products/', 'refresh');
        } else {
            // this must be the first time, so set variables
            $data['title'] = "Create Product";
            $data['categories'] = $this->mcats->getCategoriesDropDown();
            // loading this for giving some instructions.f
            //$this->bep_site->set_crumb($this->lang->line('userlib_product_create'),'products/create');
            $data['module'] = 'products';
            $this->template->load($this->_container, 'admin_product_create', $data);
        }
    }

    function test() {
        echo 'test';
    }

    function uploading() {
        //echo 'test';
        $data['title'] = "Manage Products";
        $data['module'] = 'products';
        $this->template->load($this->_container, 'upload', $data);
    }

    function edit($id=0) {
        // we are using TinyMCE in edit as well
        //$this->bep_assets->load_asset_group('TINYMCE');
        if ($this->input->post('name')) {
            // fields filled up so,
            $this->mproducts->new_updateProduct();
            // CI way to set flashdata, but we are not using it
            // flashMsg('message','Product updated');
            // we are using Bep function for flash msg
            flashMsg('message', 'Product updated');
            redirect('products/', 'refresh');
        } else {
            //$id = $this->uri->segment(4);
            $data['title'] = "Edit Product";
            // $data['main'] = 'admin_product_edit';
            $data['product'] = $this->mproducts->getProduct($id);
            $data['categories'] = $this->mcats->getCategoriesDropDown();
            // I am not using colors and sizes any more. But they are available if you want to use them.
            // I am loading product_right here which gives instructions.
            //$data['right'] = 'admin/product_right';
            if (!count($data['product'])) {
                redirect('products/', 'refresh');
            }
            // 	Set breadcrumb
            //$this->bep_site->set_crumb($this->lang->line('userlib_product_edit'),'products/edit');
            //$data['header'] = $this->lang->line('backendpro_access_control');
            $data['module'] = 'products';
            $this->template->load($this->_container, 'admin_product_edit', $data);
        }
    }

    function delete($id) {
        $this->mproducts->deleteProduct($id);
        flashMsg('message', 'Product deleted');
        redirect('products', 'refresh');
    }

    function changeProductStatus($id) {
        $this->mproducts->changeProductStatus($id);
        flashMsg('message', 'Page status changed');
        redirect('products', 'refresh');
    }

    public function uploaders($options=null) {
        $script_url = site_url() . '/products/uploader';
        //echo $script_url;
        $this->options = array(
            'script_url' => $script_url,
            'upload_dir' => basic_path() . 'assets/images/files/', //dirname(__FILE__) . '/files/',
            'upload_url' => img_dir(), //$this->getFullUrl() . '/files/',
            'param_name' => 'files',
            // The php.ini settings upload_max_filesize and post_max_size
            // take precedence over the following max_file_size setting:
            'max_file_size' => null,
            'min_file_size' => 1,
            'accept_file_types' => '/.+$/i',
            'max_number_of_files' => null,
            // Set the following option to false to enable non-multipart uploads:
            'discard_aborted_uploads' => true,
            // Set to true to rotate images based on EXIF meta data, if available:
            'orient_image' => false,
            'image_versions' => array(
                // Uncomment the following version to restrict the size of
                // uploaded images. You can also add additional versions with
                // their own upload directories:
                /*
                  'large' => array(
                  'upload_dir' => dirname(__FILE__).'/files/',
                  'upload_url' => dirname($_SERVER['PHP_SELF']).'/files/',
                  'max_width' => 1920,
                  'max_height' => 1200
                  ),
                 */
                'thumbnail' => array(
                    'upload_dir' => basic_path() . 'assets/images/thumbnails/',
                    'upload_url' => img_dir() . '/thumbnails/',
                    'max_width' => 80,
                    'max_height' => 80
                )
            )
        );

        if ($options) {
            $this->options = array_replace_recursive($this->options, $options);
        }
        header('Pragma: no-cache');
        header('Cache-Control: private, no-cache');
        header('Content-Disposition: inline; filename="files.json"');
        header('X-Content-Type-Options: nosniff');
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: OPTIONS, HEAD, GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: X-File-Name, X-File-Type, X-File-Size');

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'OPTIONS':
                break;
            case 'HEAD':
            case 'GET':
                $this->get();
                break;
            case 'POST':
                $this->post();
                break;
            case 'DELETE':
                $this->delete_upload();
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
        }
    }

    public function post() {
        //
        if (isset($_REQUEST['_method']) && $_REQUEST['_method'] === 'DELETE') {
            return $this->delete_upload();
        }
        $upload = isset($_FILES[$this->options['param_name']]) ?
                $_FILES[$this->options['param_name']] : null;
        $info = array();
        //print_r($this->options['param_name']);
        if ($upload && is_array($upload['tmp_name'])) {
            foreach ($upload['tmp_name'] as $index => $value) {
                $info[] = $this->handle_file_upload(
                                $upload['tmp_name'][$index],
                                isset($_SERVER['HTTP_X_FILE_NAME']) ?
                                        $_SERVER['HTTP_X_FILE_NAME'] : $upload['name'][$index],
                                isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                                        $_SERVER['HTTP_X_FILE_SIZE'] : $upload['size'][$index],
                                isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                                        $_SERVER['HTTP_X_FILE_TYPE'] : $upload['type'][$index],
                                $upload['error'][$index]
                );
            }
        } elseif ($upload || isset($_SERVER['HTTP_X_FILE_NAME'])) {
            $info[] = $this->handle_file_upload(
                            isset($upload['tmp_name']) ? $upload['tmp_name'] : null,
                            isset($_SERVER['HTTP_X_FILE_NAME']) ?
                                    $_SERVER['HTTP_X_FILE_NAME'] : (isset($upload['name']) ?
                                            isset($upload['name']) : null),
                            isset($_SERVER['HTTP_X_FILE_SIZE']) ?
                                    $_SERVER['HTTP_X_FILE_SIZE'] : (isset($upload['size']) ?
                                            isset($upload['size']) : null),
                            isset($_SERVER['HTTP_X_FILE_TYPE']) ?
                                    $_SERVER['HTTP_X_FILE_TYPE'] : (isset($upload['type']) ?
                                            isset($upload['type']) : null),
                            isset($upload['error']) ? $upload['error'] : null
            );
        }
        header('Vary: Accept');
        $json = json_encode($info);
        $redirect = isset($_REQUEST['redirect']) ?
                stripslashes($_REQUEST['redirect']) : null;
        if ($redirect) {
            header('Location: ' . sprintf($redirect, rawurlencode($json)));
            return;
        }
        if (isset($_SERVER['HTTP_ACCEPT']) &&
                (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
        echo $json;
    }

    private function get_file_object($file_name) {
        $file_path = $this->options['upload_dir'] . $file_name;
        if (is_file($file_path) && $file_name[0] !== '.') {
            $file = new stdClass();
            $file->name = $file_name;
            $file->size = filesize($file_path);
            $file->url = $this->options['upload_url'] . rawurlencode($file->name);
            foreach ($this->options['image_versions'] as $version => $options) {
                if (is_file($options['upload_dir'] . $file_name)) {
                    $file->{$version . '_url'} = $options['upload_url']
                            . rawurlencode($file->name);
                }
            }
            $file->delete_url = site_url('/products/delete_upload/')
                    . '/' . rawurlencode($file->name);
            $file->delete_type = 'DELETE';
            return $file;
        }
        return null;
    }

    private function get_file_objects() {
        return array_values(array_filter(array_map(
                                array($this, 'get_file_object'),
                                scandir($this->options['upload_dir'])
                )));
    }

    private function create_scaled_image($file_name, $options) {
        $file_path = $this->options['upload_dir'] . $file_name;
        $new_file_path = basic_path() . 'assets/images/thumbnails/' . $file_name;
        list($img_width, $img_height) = @getimagesize($file_path);
        if (!$img_width || !$img_height) {
            return false;
        }
        $scale = min(
                        $options['max_width'] / $img_width,
                        $options['max_height'] / $img_height
        );
        if ($scale > 1) {
            $scale = 1;
        }
        $new_width = $img_width * $scale;
        $new_height = $img_height * $scale;
        $new_img = @imagecreatetruecolor($new_width, $new_height);
        switch (strtolower(substr(strrchr($file_name, '.'), 1))) {
            case 'jpg':
            case 'jpeg':
                $src_img = @imagecreatefromjpeg($file_path);
                $write_image = 'imagejpeg';
                break;
            case 'gif':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                $src_img = @imagecreatefromgif($file_path);
                $write_image = 'imagegif';
                break;
            case 'png':
                @imagecolortransparent($new_img, @imagecolorallocate($new_img, 0, 0, 0));
                @imagealphablending($new_img, false);
                @imagesavealpha($new_img, true);
                $src_img = @imagecreatefrompng($file_path);
                $write_image = 'imagepng';
                break;
            default:
                $src_img = $image_method = null;
        }
        $success = $src_img && @imagecopyresampled(
                        $new_img,
                        $src_img,
                        0, 0, 0, 0,
                        $new_width,
                        $new_height,
                        $img_width,
                        $img_height
                ) && $write_image($new_img, $new_file_path);
        // Free up memory (imagedestroy does not delete files):
        @imagedestroy($src_img);
        @imagedestroy($new_img);
        return $success;
    }

    private function has_error($uploaded_file, $file, $error) {
        if ($error) {
            return $error;
        }
        if (!preg_match($this->options['accept_file_types'], $file->name)) {
            return 'acceptFileTypes';
        }
        if ($uploaded_file && is_uploaded_file($uploaded_file)) {
            $file_size = filesize($uploaded_file);
        } else {
            $file_size = $_SERVER['CONTENT_LENGTH'];
        }
        if ($this->options['max_file_size'] && (
                $file_size > $this->options['max_file_size'] ||
                $file->size > $this->options['max_file_size'])
        ) {
            return 'maxFileSize';
        }
        if ($this->options['min_file_size'] &&
                $file_size < $this->options['min_file_size']) {
            return 'minFileSize';
        }
        if (is_int($this->options['max_number_of_files']) && (
                count($this->get_file_objects()) >= $this->options['max_number_of_files'])
        ) {
            return 'maxNumberOfFiles';
        }
        return $error;
    }

    private function trim_file_name($name, $type) {
        // Remove path information and dots around the filename, to prevent uploading
        // into different directories or replacing hidden system files.
        // Also remove control characters and spaces (\x00..\x20) around the filename:
        $file_name = trim(basename(stripslashes($name)), ".\x00..\x20");
        // Add missing file extension for known image types:
        if (strpos($file_name, '.') === false &&
                preg_match('/^image\/(gif|jpe?g|png)/', $type, $matches)) {
            $file_name .= '.' . $matches[1];
        }
        return $file_name;
    }

    private function orient_image($file_path) {
        $exif = exif_read_data($file_path);
        $orientation = intval(@$exif['Orientation']);
        if (!in_array($orientation, array(3, 6, 8))) {
            return false;
        }
        $image = @imagecreatefromjpeg($file_path);
        switch ($orientation) {
            case 3:
                $image = @imagerotate($image, 180, 0);
                break;
            case 6:
                $image = @imagerotate($image, 270, 0);
                break;
            case 8:
                $image = @imagerotate($image, 90, 0);
                break;
            default:
                return false;
        }
        $success = imagejpeg($image, $file_path);
        // Free up memory (imagedestroy does not delete files):
        @imagedestroy($image);
        return $success;
    }

    private function handle_file_upload($uploaded_file, $name, $size, $type, $error) {
        $file = new stdClass();
        $file->name = $this->trim_file_name($name, $type);
        $file->size = intval($size);
        $file->type = $type;
        $error = $this->has_error($uploaded_file, $file, $error);
        if (!$error && $file->name) {
            $file_path = $this->options['upload_dir'] . $file->name;
            $append_file = !$this->options['discard_aborted_uploads'] &&
                    is_file($file_path) && $file->size > filesize($file_path);
            clearstatcache();
            if ($uploaded_file && is_uploaded_file($uploaded_file)) {
                // multipart/formdata uploads (POST method uploads)
                if ($append_file) {
                    file_put_contents(
                            $file_path,
                            fopen($uploaded_file, 'r'),
                            FILE_APPEND
                    );
                } else {
                    move_uploaded_file($uploaded_file, $file_path);
                }
            } else {
                // Non-multipart uploads (PUT method support)
                file_put_contents(
                        $file_path,
                        fopen('php://input', 'r'),
                        $append_file ? FILE_APPEND : 0
                );
            }
            $file_size = filesize($file_path);
            if ($file_size === $file->size) {
                if ($this->options['orient_image']) {
                    $this->orient_image($file_path);
                }
                $file->url = $this->options['upload_url'] . rawurlencode($file->name);
                foreach ($this->options['image_versions'] as $version => $options) {
                    if ($this->create_scaled_image($file->name, $options)) {
                        $file->{$version . '_url'} = $options['upload_url']
                                . rawurlencode($file->name);
                    }
                }
            } else if ($this->options['discard_aborted_uploads']) {
                unlink($file_path);
                $file->error = 'abort';
            }
            $file->size = $file_size;
            $file->delete_url = $this->options['script_url']
                    . '?file=' . rawurlencode($file->name);
            $file->delete_type = 'DELETE';
        } else {
            $file->error = $error;
        }
        return $file;
    }

    public function get() {
        $file_name = isset($_REQUEST['file']) ?
                basename(stripslashes($_REQUEST['file'])) : null;
        if ($file_name) {
            $info = $this->get_file_object($file_name);
        } else {
            $info = $this->get_file_objects();
        }
        header('Content-type: application/json');
        echo json_encode($info);
    }

    public function delete_upload($file_name) {
        $file_path = $this->options['upload_dir'] . $file_name;
        echo $this->options['upload_dir'];
        $success = is_file($file_path) && $file_name[0] !== '.' && unlink($file_path);
        if ($success) {
            foreach ($this->options['image_versions'] as $version => $options) {
                $file = $options['upload_dir'] . $file_name;
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
        header('Content-type: application/json');
        echo json_encode($success);
    }

}
