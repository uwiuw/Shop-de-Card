<?php

class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('unit_test');
        // Your own constructor code
    }

    public function index() {
        //echo 'test';
        echo 'haidar';exit;
        echo 'site='.site_url();
        $arr = array("one", "two", "three");
        reset($arr);
        while (list($key, $value) = each($arr)) {
            echo "Key: $key; Value: $value<br />\n";
        }
        foreach ($arr as $key => $value) {
            echo "Key: $key; Value: $value<br />\n";
        }
    }

    public function t_array() {
        $data['title'] = 'Array';
        $this->load->view('test/array', $data);
    }

    public function t_global() {
        $data['title'] = 'Global';
        $this->load->view('test/global', $data);
    }

    public function data() {
        $data['last_ten'] = $this->job_model->get_last_ten_entries();
        //echo xdebug_call_function();
        $this->load->view('test/data', $data);
    }

    private function _te($num) {
        return $num * 2;
    }
    
    public function nums(){
        $num = 10;
        echo $this->_te($num);
    }

    public function untest() {
        $test = 1 + 1;
        $str = "1";
        $expected_result = 2;

        $test_name = 'Adds one plus one';

        echo $this->unit->run($test, $expected_result, $test_name);
    }
    
    

}
?>
