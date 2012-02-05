<h2><?php echo $title;?></h2>

<?php
echo form_open('menus/edit');
echo "\n<p><label for='menuname'>Name</label>\n";
$data = array('name'=>'name','menu_id'=>'menuname','size'=>25, 'value' => $menu['name']);
echo form_input($data) ."</p>\n";

echo "<p><label for='short'>Short Description</label>\n";
$data = array('name'=>'shortdesc','menu_id'=>'short','size'=>40, 'value' => $menu['shortdesc']);
echo form_input($data) ."</p>\n";

echo "<p><label for='page_uri'>Page you want to show.(URI)</label>\n";
echo form_dropdown('page_uri',$pages, $menu['page_uri']) ."</p>\n";

$ext_url = $menu['ext_url']==1? $menu['page_uri'] :'';
echo "<p><label for='page_uri'>Create Own Link (URL)</label>\n";
$data = array('name'=>'own_url','menu_id'=>'short','size'=>40, 'value' => $ext_url);
echo form_input($data) ."</p>\n";

echo "<p><label for='status'>Status</label>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options, $menu['status']) ."</p>\n";
?>
<p><label for="position">Position</label>
    <select name="position">
        <option value="left" <?php echo $menu['position']=="left"?'selected':'';?>>Left</option>
        <option value="right" <?php echo $menu['position']=="right"?'selected':'';?>>Right</option>
    </select>
</p>
<?php
echo "<p><label for='parent'>Parent Menu</label>\n";
echo form_dropdown('parentid',$menus, $menu['parentid']) ."</p>\n";

echo "<p><label for='order'>Order</label>\n";
$data = array('name'=>'order', 'value' => $menu['order'], 'menu_id'=>'order','size'=>10);
echo form_input($data) ."</p>\n";

echo form_hidden('menu_id',$menu['menu_id']);
echo form_submit('submit','update menu');
echo form_close();

?>