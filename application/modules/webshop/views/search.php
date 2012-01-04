<div id='pleft'>
    <h2><?php echo lang('general_search_results'); ?></h2>

    <?php
    if (count($results)) {
        /**
         * Output from welcome/search will be id,name,shortdesc,thumbnail
         */
        foreach ($results as $key => $list) {

            $thumbnail = prod_thumb_dir() . $list['image_id'] . $list['extension'];
            echo "<div class='productlisting'><img src=\"" . $thumbnail . "\"  border='0' class='thumbnail'/>\n";
            echo "<span class='hdrproduct'>";
            echo anchor('/product/' . $list['product_id'], $list['name']);
            echo "</span>\n";
            echo $list['shortdesc'] . "<br/>";
            echo '<a href="' . site_url() . $this->lang->line('webshop_folder') . '/cart/' . $list['product_id'] . '"><p class="addtocart">' . $this->lang->line('webshop_buy') . '</p></a></div>';
        }
    } else {
        echo "<p>Sorry, no records were found to match your search term.</p>";
    }
    ?>
</div>