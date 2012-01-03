	
<?php
echo "<h1>" . $category['name'] . "</h1>\n";
echo "<p>" . $category['shortdesc'] . "</p>\n";

foreach ($listing as $key => $list) {
?>
    <div class="product_list">
    <?php
    $imageinfo = $list['thumbnail'];
    //$thumbnail = convert_image_path($imageinfo);
    $thumbnail = prod_thumb_dir().$list['image_id'].$list['extension'];
    switch ($level) {
        // category level is 1, and product is 2
        // see function cat($id) in controllers/.php
        case "1":?> <?php
            echo '<a href="' . site_url() . '/' . $this->lang->line('webshop_folder') . '/cat/' . $list['product_id'] . '">';
            echo '<img src="' . $thumbnail .'"' . "border='0' class='thumbnail'/>\n";
            echo "</a><br />";
            //echo "<span class='hdrproduct'>";
            echo anchor('/cat/' . $list['product_id'], $list['name']);
            //echo "</span>\n";
            break;

        case "2": ?> <?php
            echo '<a href="' . site_url() . '/' . $this->lang->line('webshop_folder') . '/product/' . $list['product_id'] . '">';
            echo '<img src="' . $thumbnail . '"' . "border='0' class='thumbnail'/>\n";
            echo "</a>";
            // echo ;
            break;
    }
    echo $list['shortdesc'];
    echo "<div class=\"product_desc\">".$list['name']." " . $this->lang->line('webshop_price') . "</b>: " . $this->lang->line('webshop_currency_symbol') . $list['price'] . " ";
    echo '<a href="' . site_url() . '/' . $this->lang->line('webshop_folder') . '/cart/' . $list['product_id'] . '">' . $this->lang->line('webshop_buy') . '</a></div>';
    ?>
</div>
<?php } ?>
