<h2><?php echo $title;?></h2>

<?php
echo form_open('menus/edit');
echo "\n<p><label for='menuname'>Name</label><br/>\n";
$data = array('name'=>'name','menu_id'=>'menuname','size'=>25, 'value' => $menu['name']);
echo form_input($data) ."</p>\n";

echo "<p><label for='short'>Short Description</label><br/>\n";
$data = array('name'=>'shortdesc','menu_id'=>'short','size'=>40, 'value' => $menu['shortdesc']);
echo form_input($data) ."</p>\n";

echo "<p><label for='page_uri'>Page you want to show.(URI)</label><br/>\n";
echo form_dropdown('page_uri',$pages, $menu['page_uri']) ."</p>\n";

echo "<p><label for='page_uri'>Create Own Link (URL)</label><br/>\n";
$data = array('name'=>'own_url','menu_id'=>'short','size'=>40);
echo form_input($data) ."</p>\n";

echo "<p><label for='status'>Status</label><br/>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options, $menu['status']) ."</p>\n";

echo "<p><label for='parent'>Parent Menu</label><br/>\n";
echo form_dropdown('parentid',$menus, $menu['parentid']) ."</p>\n";

echo "<p><label for='order'>Order</label><br/>\n";
$data = array('name'=>'order', 'value' => $menu['order'], 'menu_id'=>'order','size'=>10);
echo form_input($data) ."</p>\n";

echo form_hidden('menu_id',$menu['menu_id']);
echo form_submit('submit','update menu');
echo form_close();

?>