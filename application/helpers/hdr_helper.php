<?php

@session_start();

function get_tag_condition($condition, $pre="AND") {
    if ($condition) {
        $return = $condition ? $pre . ' ' . $condition . ' ' : '';
        return " " . $return . " ";
    } return false;
}

function id_user() {
    return $_SESSION['bid_user_s'];
}

function user_name() {
    return $_SESSION['bsname_s'];
}

function level() {
    return $_SESSION['blevel'];
}

function is_reminder() {
    return $_SESSION['is_reminder'];
}

function shift() {
    return $_SESSION['shift'];
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

function get_local_no($phone) {
    $clean_no = preg_replace('/[^0-9]/', '', $phone);
    $local_code = substr($clean_no, 0, 3);
    if (preg_match("/" . $_SESSION['local_no'] . "/i", $local_code))
        return substr($clean_no, 3, 100);
    else
        return $clean_no;
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
?>