<h2><?php echo $title;?></h2>
<p>The following products are about to be orphaned. They used to belong to the <b><?php echo $menu['name'];?></b> menu, but now they need to be reassigned.</p>

<ul>
<?php
foreach ($this->session->userdata('orphans') as $id => $name){
	echo "<li>$name</li>\n";
}
echo "<pre>";
 print_r ($menu);
 print_r ($menus);
echo "</pre>";
echo "</br >";
// echo $categories[$category['id']];
// echo $category['id'];
?>
</ul>

<?php
echo form_open('menus/reassign');
unset($menus[$menu['menu_id']]);
echo form_dropdown('menus',$menus);
echo form_hidden('id', $menu['id'] );
echo form_submit('submit','reassign');
echo form_close();
?>