<div id='pleft'>
    <?php
    if ($this->session->flashdata('conf_msg')) {
        echo "<div class='status_box'>";
        echo $this->session->flashdata('conf_msg');
        echo "</div>";
    }
    ?>
    <?php
    $imageinfo = $product['image'];
    $image = convert_image_path(base_url() . $imageinfo);
    echo "<img src='" . $image . "' border='0' align='left'/>\n";
    echo "<div class=\"procont\"><h2>" . $product['name'] . "</h2>\n";
    echo $product['shortdesc'] . "<br />\n";
    echo $product['longdesc'] . "\n";
    echo "<br />";
    echo "<p><b>" . $this->lang->line('webshop_price') . "</b>: " . $this->lang->line('webshop_currency_symbol') . $product['price'] . "</p>\n";
    echo '<input type="submit" value="Buy" name="add" />';
    echo '<input type="hidden" name="product_id" value="' . $product['product_id'] . '" />';
    echo '<input type="hidden" name="qty" value="1" />';
    //echo '<p><a class="cartlinkbut" href="' . site_url() . "/" .
    //$this->lang->line('webshop_folder') . '/add_cart_item/' . $product['product_id'] .
    //'"><span class="addtocart addcart">' . $this->lang->line('webshop_buy') . '</span></a></p></div>';
    ?>

</div>
