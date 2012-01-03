<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function convert_image_path($imageinfo) {
    $str = $imageinfo;
    $m = array();
    if (preg_match('#<.*?/([^\.]+\.(jpg|jpeg|gif|png))"#', $str, $m)) {
        $image = $m[1];
    } else {
        $image = $imageinfo;
    }
    $tags = array("<p>", "</p>");
    $image = str_replace($tags, "", $image);
    return $image;
}
?>
