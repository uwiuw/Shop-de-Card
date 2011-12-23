<h2><?php echo $title;?></h2>
<p><?php echo anchor("menus/admin/create", "Create new menu");?> | <?php echo anchor("menus/admin/export","Export");?></p>
<?php
if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}

echo '<h2>Menus</h2>';
/**
 * @param array $level The current navigation level array
 * @param string $output The output to be added to
 * @param int $depth The current depth of the tree to determine classname
 */
function generateRowsByLevel($level, &$output, $depth = 0) {

    $depthClassMapping = array(0 => 'parent', 1 => 'child', 2 => 'grandchild');

    foreach ($level as $row) {
        $output .= "<tr valign='top'>\n";
        $output .= "<td>". $row['menu_id']."</td>\n";
        $output .= "<td class=\"" . $depthClassMapping[$depth] . "\"><a href=\"". site_url(). '/menus/admin/edit/' .  $row['menu_id'] . '">' . $row['name']."</a></td>\n";
       
				$output .= "<td align='center'>";
				$output .= anchor('menus/admin/changeMenuStatus/'.$row['menu_id'],$row['status'], array('class' => $row['status']));
				$output .= "</td>\n";
			 
			  //$output .= "<td align='center'>". $row['status']."</td>\n";
       
			  $output .= "<td align='center'>". $row['parentid']."</td>\n";
				$output .= "<td class=\"" . $depthClassMapping[$depth] . "\" >". $row['order']."</td>\n";
				$output .= "<td align='center'>". $row['page_uri']."</td>\n";
        $output .= "<td align='center'>";
        $output .= anchor('menus/admin/edit/'. $row['menu_id'],'edit');
        $output .= " | ";
        $output .= anchor('menus/admin/deleteMenu/'. $row['menu_id'],'delete', array('class' => 'delete_link', 'menu_id' => 'delete_link_'.$row['menu_id']));
        $output .= "</td>\n";
        $output .= "</tr>\n";

        // if the row has any children, parse those to ensure we have a properly 
        // displayed nested table
        if (!empty($row['children'])) {
            generateRowsByLevel($row['children'], $output, $depth + 1);
        }
    }
}

//==================
// RUN THE GENERATOR 
//==================
if (count($navlist)){

    // begin table
    $output = "<div  id='menutable'><table border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
    $output .= "<thead>\n<tr valign='top'>\n";
    $output .= "<th>ID</th>\n<th>Name</th><th>Status</th><th>parentid</th><th>Order</th><th>Page URI</th><th>Actions</th>\n";
    $output .= "</tr>\n</thead>\n<tbody>\n";

    // generate all table rows
    generateRowsByLevel($navlist, $output);

    // close up the table
    $output .= "</tbody>\n</table></div>";

    // display table
    echo $output;
    
}


?>
