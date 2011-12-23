
<h2><?php echo $title;?></h2>
<p><?php echo anchor("categories/admin/create", "Create new category");?> | <?php echo anchor("categories/admin/export","Export");?></p>
<?php
if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}

if (count($categories)){
	echo "<table id='tablesorter' class='tablesorter' border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
	echo "<thead>\n<tr valign='top'>\n";
	echo "<th>ID</th>\n<th>Name</th><th>Status</th><th>Parent id</th><th>Actions</th>\n";
	echo "</tr>\n</thead>\n<tbody>\n";
	foreach ($categories as $key => $list){
		echo "<tr valign='top'>\n";
		echo "<td>".$list['category_id']."</td>\n";
		echo "<td>".$list['name']."</td>\n";

		echo "<td align='center'>";
		echo anchor('categories/admin/changeCatStatus/'.$list['category_id'],$list['status'], array('class' => $list['status']));
		echo "</td>\n";

		// echo "<td align='center'>".$list['status']."</td>\n";

		echo "<td align='center'>".$list['parentid']."</td>\n";
		echo "<td align='center'>";
		echo anchor('categories/admin/edit/'.$list['category_id'],'edit');
		echo " | ";
		echo anchor('categories/admin/delete/'.$list['category_id'],'delete', array('class' => 'delete_link'));
		echo "</td>\n";
		echo "</tr>\n";
	}
	echo "</tbody>\n</table>";
}
?>
