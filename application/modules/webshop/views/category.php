<div id='pleft'>	
<?php
  echo "<h1>".$category['name']."</h1>\n";
  echo "<p>".$category['shortdesc'] . "</p>\n";
  
  foreach ($listing as $key => $list){
    echo "<div class='productlisting'>";
    $imageinfo = $list['thumbnail'];
  	$thumbnail=convert_image_path($imageinfo);
  	
	switch($level){
		  // category level is 1, and product is 2
		  // see function cat($id) in controllers/.php 
			case "1":
			echo '<a href="' . site_url(). '/'.$this->lang->line('webshop_folder').'/cat/'.$list['product_id']. '">';
			echo '<img src="'.base_url().$list['thumbnail'].'"'. "border='0' class='thumbnail'/>\n";
			echo "</a><br />";
			echo "<span class='hdrproduct'>";
			echo anchor('/cat/'.$list['product_id'],$list['name']);
			echo "</span>\n";
			break;
			
			case "2":
			echo '<a href="' . site_url(). '/'. $this->lang->line('webshop_folder').'/product/'.$list['product_id']. '">';
			echo '<img src="'.base_url().$thumbnail.'"'. "border='0' class='thumbnail'/>\n";
			echo "</a><br />";
			echo "<span class='hdrproduct'>";
			 echo anchor($this->lang->line('webshop_folder').'/product/'.$list['product_id'],$list['name']);
			echo "</span>\n";
			// echo ;
			break;
		}
    
  
    echo $list['shortdesc'];
	echo "<p><b>".$this->lang->line('webshop_price')."</b>: ".$this->lang->line('webshop_currency_symbol'). $list['price']. "</p>\n";
	echo '<a href="' . site_url(). '/'.$this->lang->line('webshop_folder').'/cart/'.$list['product_id']. '"><p class="addtocart">'.$this->lang->line('webshop_buy').'</p></a></div>';
  }
?>
</div>
