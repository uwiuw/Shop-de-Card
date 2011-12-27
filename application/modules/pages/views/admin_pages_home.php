<h2><?php echo $title;?></h2>
<p>
<?php
echo anchor("pages/create", "Create new page");
?>
</p>
<?php

if ($this->session->flashdata('message')){
	echo "<div class='status_box'>".$this->session->flashdata('message')."</div>";
}
if (count($pages)){
	echo "<table id='tablesorter' class='tablesorter' border='1' cellspacing='0' cellpadding='3' width='100%'>\n";
	echo "<thead>\n<tr valign='top'>\n";
	echo "<th>ID</th>\n<th>Name</th><th>Full Path</th><th>Status</th><th>Actions</th>\n";
	echo "</tr>\n</thead>\n<tbody>\n";
	foreach ($pages as $key => $list){
		echo "<tr valign='top'>\n";
		echo "<td align='center'>".$list['page_id']."</td>\n";
		echo "<td>".$list['name']."</td>\n";
		echo "<td>";
   		if (!preg_match("/\.html$/",$list['path'])){
  			$list['path'] .= ".html";
  		}		
		
		if ($list['category_id'] == 0){
			echo "/". $list['path'];
		}else{
			echo "/". $cats[$list['category_id']]. "/". $list['path'];
		}
		echo "</td>";
		echo "<td align='center'>";
		echo anchor('pages/changePageStatus/'.$list['page_id'],$list['status'], array('class' => $list['status']));
		echo "</td>\n";
		echo "<td align='center'>";
		echo anchor('pages/edit/'.$list['page_id'],'edit');
		echo " | ";
		echo anchor('pages/delete/'.$list['page_id'],'delete');
		echo "</td>\n";
		echo "</tr>\n";
	}
	echo "</tbody>\n</table>";
}
?>