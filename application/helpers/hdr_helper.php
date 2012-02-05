<?php

@session_start();

function get_tag_condition($condition, $pre="AND") {
    if ($condition) {
        $return = $condition ? $pre . ' ' . $condition . ' ' : '';
        return " " . $return . " ";
    } return false;
}

function css_dir() {
    return base_url() . 'assets/css/';
}

function js_dir() {
    return base_url() . 'assets/js/';
}

function img_dir() {
    return base_url() . 'assets/images/';
}

function prod_dir() {
    return base_url() . 'assets/product/';
}
function timthumb($img,$h=NULL,$w=NULL){
    $height = $h!=NULL?'&h='.$h:'';
    $width = $w!=NULL?'&w='.$w:'';
    return base_url() . 'assets/script/timthumb.php?src='.$img.$height.$width;
}
function prod_thumb_dir() {
    return base_url() . 'assets/product_thumb/';
}

function backend_img_dir() {
    return base_url() . 'assets/backend_img/';
}

function resize($image, $width, $height) {
    $new_image = imagecreatetruecolor($width, $height);
    imagecopyresampled($new_image, $image, 0, 0, 0, 0, $width, $height, imagesx($image), imagesy($image));
    $image = $new_image;
}

function createfoldername($string) {
    $string = mb_strtolower($string, 'utf-8');
    $regexp = '/( |g)/iU';
    // $regexp = '/( |å|ø|æ|Å|Ø|Æ|Ã¥|Ã¸|Ã¦|Ã…|Ã˜|Ã†)/iU';
    $replace_char = '_';
    $data = preg_replace($regexp, $replace_char, $string);
    return $data;
}

/*
 * This will replace non English to similar letter in English
 *
 */

function createdirname($string) {

    $forbidden = array(" ", "å", "Å", "ø", "Ø", "æ", "Æ", "ã…", "ã˜", "ã†", "ã¥", "ã¸", "ã¦");
    // order is space, å, Å,ø, Ø,æ, Æ, and Å, Ø, Æ, å,ø,æ
    $normal = array("_", "aa", "aa", "o", "o", "ae", "ae", "aa", "o", "ae", "aa", "o", "ae");
    $string = str_replace($forbidden, $normal, $string);
    $data = mb_strtolower($string, 'utf-8');
    return $data;
}

function create_path($folder) {
    // create dir if not exists
    $folder = explode("/", $folder);
    $mkfolder = "";
    //sets the complete directory path
    for ($i = 0; isset($folder[$i]); $i++) {
        $mkfolder .= $folder[$i] . '/';
        if (!is_dir($mkfolder)) {
            mkdir("$mkfolder");
            mkdir("$mkfolder/thumbnails");
        }
    }
}

function recursive_remove_directory($directory, $empty=FALSE) {
    // if the path has a slash at the end we remove it here
    if (substr($directory, -1) == '/') {
        $directory = substr($directory, 0, -1);
    }

    // if the path is not valid or is not a directory ...
    if (!file_exists($directory) || !is_dir($directory)) {
        // ... we return false and exit the function
        return FALSE;

        // ... if the path is not readable
    } elseif (!is_readable($directory)) {
        // ... we return false and exit the function
        return FALSE;

        // ... else if the path is readable
    } else {

        // we open the directory
        $handle = opendir($directory);

        // and scan through the items inside
        while (FALSE !== ($item = readdir($handle))) {
            // if the filepointer is not the current directory
            // or the parent directory
            if ($item != '.' && $item != '..') {
                // we build the new path to delete
                $path = $directory . '/' . $item;

                // if the new path is a directory
                if (is_dir($path)) {
                    // we call this function with the new path
                    // you need to change to $this->recursive_remove_directory($path);
                    // in controller.
                    recursive_remove_directory($path);

                    // if the new path is a file
                } else {
                    // we remove the file
                    unlink($path);
                }
            }
        }
        // close the directory
        closedir($handle);

        // if the option to empty is not set to true
        if ($empty == FALSE) {
            // try to delete the now empty directory
            if (!rmdir($directory)) {
                // return false if not possible
                return FALSE;
            }
        }
        // return success
        return TRUE;
    }
}

function id_clean($id, $size=11) {
    return intval(substr($id, 0, $size));
}

function db_clean($string, $size=255) {
    return htmlspecialchars(xss_clean((substr($string, 0, $size))));
}

function id_user() {
    return $_SESSION['cid_user_'];
}

function user_name() {
    return $_SESSION['csname'];
}

function basic_path() {
    $fr_loc = explode('/', $_SERVER['SCRIPT_NAME']);
    $base_path = $_SERVER['DOCUMENT_ROOT'] . '/' . $fr_loc[1] . '/';
    return $base_path;
}

function date_now() {
    return date('Y-m-d');
}

function month_now() {
    return date('n');
}

function get_now() {
    return date('Y-m-d H:i:s');
}

function dohash($str, $type = 'sha1') {
    if ($type == 'sha1') {
        if (!function_exists('sha1')) {
            if (!function_exists('mhash')) {
                require_once(BASEPATH . 'libraries/Sha1' . EXT);
                $SH = new CI_SHA;
                return $SH->generate($str);
            } else {
                return bin2hex(mhash(MHASH_SHA1, $str));
            }
        } else {
            return sha1($str);
        }
    } else {
        return md5($str);
    }
}

function price_format($price) {
    if ($price == '0.00' OR $price == '' OR $price == 'no debtor') {
        return '';
    } else {
        $format_price = number_format($price, 2);
        return str_replace('.00', '', $format_price);
    }
}

function date_formating($date) {
    if ($date == '0000-00-00' OR $date == '' OR $date == 'no_debtor' OR $date == 'no debtor' OR $date == '00000000') {
        return '';
    } else {
        $dated = strtotime($date);
        return strftime('%d-%b-%y', $dated);
    }
}

function max_broken_date() {
    $sum = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "-9 days");
    $maxbrokendate = date('Y-m-d', $sum);
    return $maxbrokendate;
}

function min_broken_date() {
    $sum = strtotime(date("Y-m-d", strtotime(date("Y-m-d"))) . "-30 days");
    $minbrokendate = date('Y-m-d', $sum);
    return $minbrokendate;
}

function word_wrapping($string) {
    return wordwrap($string, 70, "\n");
}

function strs_to_arrs($strsp) {
    $vals = explode('|', $strsp);
    return $vals;
}

function c_str_f($strp) {
    $lens = strlen($strp) - 1;
    return $lens;
}

function c_str_s($strp) {
    $lens = strlen($strp);
    return $lens;
}

function set_filename($path, $filename, $file_ext, $encrypt_name = FALSE) {
    if ($encrypt_name == TRUE) {
        mt_srand();
        $filename = md5(uniqid(mt_rand())) . $file_ext;
    }

    if (!file_exists($path . $filename)) {
        return $filename;
    }

    $filename = str_replace($file_ext, '', $filename);

    $new_filename = '';
    for ($i = 1; $i < 100; $i++) {
        if (!file_exists($path . $filename . $i . $file_ext)) {
            $new_filename = $filename . $i . $file_ext;
            break;
        }
    }

    if ($new_filename == '') {
        return FALSE;
    } else {
        return $new_filename;
    }
}

function dir_rep($arr_dir=array(), $pat) {
    $ext = fileext($_FILES['Filedata']['name']);
    $fr_loc = explode('/', $_SERVER['SCRIPT_NAME']);
    $correct_p = $_SERVER['DOCUMENT_ROOT'] . '/' . $fr_loc[1] . '/assets/upload/' . $pat . '/';
    $pat_fla = array('/\/htdocs\//', '/\.txt/');
    $rep_fla = array('/' . $correct_p . '/', '/' . fileext($_FILES['Filedata']['name']) . '/');
    $repla_all = preg_replace($pat_fla, $rep_all, $arr_dir);
    //print_r($rep_fla);
    $sh = str_replace('/htdocs/', $correct_p, $arr_dir);
    return $sh;
}

function prep_filename($filename) {
    if (strpos($filename, '.') === FALSE) {
        return $filename;
    }
    $parts = explode('.', $filename);
    $ext = array_pop($parts);
    $filename = array_shift($parts);
    foreach ($parts as $part) {
        $filename .= '.' . $part;
    }
    $filename .= '.' . $ext;
    return $filename;
}

function get_extension($filename) {
    $x = explode('.', $filename);
    return '.' . end($x);
}

function query($sql, $querycount, $totaltime) {
    if (empty($querycount))
        $querycount = 0;
    if (empty($totaltime))
        $totaltime = 0;
    list($usec, $sec) = explode(' ', microtime());
    $querytime_before = ((float) $usec + (float) $sec);
    $result = mysql_query($sql);
    list($usec, $sec) = explode(' ', microtime());
    $querytime_after = ((float) $usec + (float) $sec);
    $querytime = $querytime_after - $querytime_before;
    $totaltime += $querytime;
    $querycount++;
    return array($result, $querycount, $totaltime);
}

function display_time($querycount, $totaltime) {
    $strQueryTime = 'Query took %01.4f seconds';
    echo '<p class="querytime">' . sprintf($strQueryTime, $totaltime) . ' with ' . $querycount . ' queries.</p>';
}

function num2alpha($n) {
    for ($r = ""; $n >= 0; $n = intval($n / 26) - 1)
        $r = chr($n % 26 + 0x41) . $r;
    return $r;
}

/*
 * Convert a string of uppercase letters to an integer.
 */

function indo_word($x) {
    $x = abs($x);
    $angka = array("", "satu", "dua", "tiga", "empat", "lima",
        "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
    $temp = "";
    if ($x < 12) {
        $temp = " " . $angka[$x];
    } else if ($x < 20) {
        $temp = indo_word($x - 10) . " belas";
    } else if ($x < 100) {
        $temp = indo_word($x / 10) . " puluh" . indo_word($x % 10);
    } else if ($x < 200) {
        $temp = " seratus" . indo_word($x - 100);
    } else if ($x < 1000) {
        $temp = indo_word($x / 100) . " ratus" . indo_word($x % 100);
    } else if ($x < 2000) {
        $temp = " seribu" . indo_word($x - 1000);
    } else if ($x < 1000000) {
        $temp = indo_word($x / 1000) . " ribu" . indo_word($x % 1000);
    } else if ($x < 1000000000) {
        $temp = indo_word($x / 1000000) . " juta" . indo_word($x % 1000000);
    } else if ($x < 1000000000000) {
        $temp = indo_word($x / 1000000000) . " milyar" . indo_word(fmod($x, 1000000000));
    } else if ($x < 1000000000000000) {
        $temp = indo_word($x / 1000000000000) . " trilyun" . indo_word(fmod($x, 1000000000000));
    }
    return $temp;
}

function indo_price($x, $style=4) {
    if ($x < 0) {
        $hasil = "minus " . trim(indo_word($x));
    } else {
        $hasil = trim(indo_word($x));
    }
    switch ($style) {
        case 1:
            $hasil = strtoupper($hasil);
            break;
        case 2:
            $hasil = strtolower($hasil);
            break;
        case 3:
            $hasil = ucwords($hasil);
            break;
        default:
            $hasil = ucfirst($hasil);
            break;
    }
    return $hasil;
}

function alpha2num($a) {
    $l = strlen($a);
    $n = 0;
    for ($i = 0; $i < $l; $i++)
        $n = $n * 26 + ord($a[$i]) - 0x40;
    return $n - 1;
}

function create_breadcrumb() {
    $CI = &get_instance();
    $i = 1;
    $uri = $CI->uri->segment($i);
    $link = '';

    while ($uri != '') {
        $prep_link = '';
        for ($j = 1; $j <= $i; $j++) {
            $prep_link .= $CI->uri->segment($j) . '/';
        }

        if ($CI->uri->segment($i + 1) == '') {
            $link.='» <a href="' . site_url($prep_link) . '"><b>' . $CI->uri->segment($i) . '</b></a> ';
        } else {
            $link.='» <a href="' . site_url($prep_link) . '">' . $CI->uri->segment($i) . '</a> ';
        }

        $i++;
        $uri = $CI->uri->segment($i);
    }
    $link .= '';
    return $link;
}

/*
 * Create flash message more like displaystatus() and flashdata
 */

function flashMsg($type= NULL, $message=NULL) {
    $CI = &get_instance();
    return $CI->session->set_flashdata($type, $message);
}

function del_ext($strName) {
    $ext = strrchr($strName, '.');

    if ($ext !== false) {
        $strName = substr($strName, 0, -strlen($ext));
    }
    return $strName;
}

?>