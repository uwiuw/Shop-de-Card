<?php
/*By Haidar Mar'ie 
 *Email = coder5@ymail.com 
header */
?>
<?php
        foreach ($this->nav_list as $key => $menu){
				echo "\n<li class='menuone'>\n";
				echo anchor ($this->lang->line('webshop_folder')."/pages/".$menu['page_uri'], $menu['name']);
						if (count($menu['children'])){
								echo "\n<ul>";
								foreach ($menu['children'] as $subkey => $submenu){
								  echo "\n<li class='menutwo'>\n";
								  echo anchor($this->lang->line('webshop_folder')."/pages/".$submenu['page_uri'],$submenu['name']);
												if (count($submenu['children'])){
																echo "\n<ul>";
																foreach ($submenu['children'] as $subkey => $subsubname){
																		echo "\n<li class='menuthree'>\n";
																		echo anchor($this->lang->line('webshop_folder')."/cat/",$subsubname['name']);
																		echo "\n</li>";
																}
																echo "\n</ul>";
												}
								  echo "\n</li>";
								}
						echo "\n</ul>";
						}
				echo "\n</li>\n";
		}
        ?>