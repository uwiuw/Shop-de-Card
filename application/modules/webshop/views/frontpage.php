

    <?php //echo $pagecontent['content']
    /*
    echo '<div id="slideshow" class="pics">';
       
        if (isset($slides)) {
            foreach ($slides as $slide) {
                $imageinfo = $slide['image'];
                $slideimg = convert_image_path($imageinfo);
                echo '<img class="hideme" src="' . $slideimg . '" alt="' . $slide['name'] .
                '" />';
            }
        }
        echo '</div>'
     * *
     */
        ?>
    <?php
        foreach ($images as $image) {
            $imageinfo = $image['thumbnail'];
            $thumbnail = convert_image_path($imageinfo);

            echo '<div class="product_list">' . "\n" ;
            echo '<a href="' . site_url() . '/' . lang('webshop_folder') . '/product/' . $image['product_id'] . '">';
            echo "<img src='" . base_url() . $thumbnail . "' border='0' class='thumbnail' width='118' height='150'/></a>\n";
            //echo '<span class="hdrproduct"><a href="' . site_url() . '/' . lang('webshop_folder') . '/product/' . $image['product_id'] . '">' . "\n";
            //echo "<div class='vt ar'><b>" . lang('webshop_price') . "</b>: <span class='price'>" . lang('webshop_currency_symbol') . $image['price'] . "</span><br />\n";
            echo '<div class="product_desc">'.$image['name'].$image['shortdesc'].'</div>';
            //echo "<div class=\"product_buy\"> ";
            echo "<input type='hidden' value='{$image["product_id"]}' name='product_id' /> ";
            echo '<input type="button" value="Buy"  name="add" />';
            echo "</div>";
        }
    ?>


