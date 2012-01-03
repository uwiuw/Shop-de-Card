<?php

$prefix="../../../../";
$pagecontent = str_replace($prefix, "", $pagecontent['content']);
echo '<h2>'.$pagecontent['name'].'</h2>';
echo $pagecontent;



?>