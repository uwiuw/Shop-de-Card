<div id="maintop">

    <?php //echo $pagecontent['content'] ;?>
    <div id="slideshow" class="pics">
        <?php
        if (isset($slides)) {
            foreach ($slides as $slide) {
                $imageinfo = $slide['image'];
                $slideimg = convert_image_path($imageinfo);
                echo '<img class="hideme" src="' . $slideimg . '" alt="' . $slide['name'] .
                '" />';
            }
        }
        ?>
    </div>
</div>
<div id="frontproducttable">

    <?php
        foreach ($images as $image) {
            $imageinfo = $image['thumbnail'];
            $thumbnail = convert_image_path($imageinfo);

            echo '<div class="vt ac" >' . "\n" . '<div class="frontpro">' . "\n" . '<div class="vt">' . "\n";
            echo '<a href="' . site_url() . '/' . lang('webshop_folder') . '/product/' . $image['product_id'] . '">';
            echo "<img src='" . base_url() . $thumbnail . "' border='0' class='thumbnail'/></a>\n</div>\n<div class='vt al'>\n";
            echo '<span class="hdrproduct"><a href="' . site_url() . '/' . lang('webshop_folder') . '/product/' . $image['product_id'] . '">' . "\n";
            echo $image['name'] . "</a></span><br />\n";
            echo $image['shortdesc'] . "</div>\n";
            echo "<div class='vt ar'><b>" . lang('webshop_price') . "</b>: <span class='price'>" . lang('webshop_currency_symbol') . $image['price'] . "</span><br />\n";
            echo '</div>';
            echo "<div class=\"product_buy\"> ";
            echo "<input type='hidden' value='{$image["product_id"]}' name='product_id' /> ";
            echo '<input type="button" value="Buy"  name="add" />';
            echo "</div>";
            echo "\n</div>\n</div>\n";
        }
    ?>

</div>

