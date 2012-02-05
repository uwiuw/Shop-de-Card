<h1><?= $category['name'] ?></h1>
<p><?= $category['shortdesc'] ?></p>
<div class="product_list">
    <?php
    if ($listing) {
        foreach ($listing as $key => $list) {
    ?>
    <?php
            $imageinfo = $list['thumbnail'];
            //$thumbnail = convert_image_path($imageinfo);
            $thumbnail = prod_thumb_dir() . $list['image_id'] . $list['extension'];
            switch ($level) {
                // category level is 1, and product is 2
                // see function cat($id) in controllers/.php
                case "1": ?>
                    <div class="product_desc">
                        <a href="<?php echo site_url() . '/' . $this->lang->line('webshop_folder') . '/cat/' . $list['product_id'] ?>">
                            <img src="<?php echo timthumb($thumbnail, NULL, 80) ?>" alt=""   border='0' class='thumbnail'/>
                        </a>
                    <a href="<?= site_url('/webshop/') ?>/cat/<?= $list['product_id'] ?>" ><?= $list['name'] ?></a>
    <?php break;

                case "2": ?>
                    <div class="product_desc">
                        <a href="<?php echo site_url('/webshop/') . '/product/' . $list['product_id'] ?>">
                            <img src="<?php echo timthumb($thumbnail, NULL, 80) ?>" alt="" border='0' class='thumbnail'/>
                        </a>
    <?php
                    break;
            } ?>
    <?= $list['shortdesc']; ?>
            <?php echo $list['name'] ?><div class="price_category">$ <?= $list['price']; ?></div>
                <div class="product_buy">
                    <input type="hidden" name="product_id" value="<?= $list['product_id'] ?>" />
                    <input type="hidden" name="qty" value="1" />
                    <input type="submit" value="Buy" name="add" />
                </div>
            </div>
    <?php } ?>

    <?php } else {
 ?>

        <h3>No Product Found</h3>

<?php } ?>
</div>
