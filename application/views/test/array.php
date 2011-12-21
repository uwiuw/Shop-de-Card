<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$array = array('step one', 'step two', 'step three', 'step four');
// by default, the pointer is on the first element
echo "current ".current($array) . "<br />\n"; // "step one"
// skip two steps
next($array);
next($array);
echo "next ".current($array) . "<br />\n"; // "step three"
// reset pointer, start again on step one
reset($array);
echo "reset ".current($array) . "<br />\n"; // "step one"
?>
