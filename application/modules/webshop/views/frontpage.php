<?php
/*
 * Show Product in front page most sold and item you might like
 */

foreach ($images as $image) {
    $imageinfo = $image['thumbnail'];
    //$thumbnail = convert_image_path($imageinfo);
    $thumbnail = prod_thumb_dir() . $image['image_id'] . $image['extension'];
?>
<div class="product_list">
    <a href="<?= site_url('/webshop') .'/' .$image['product_id'] ?>">
        <img src='<?= $thumbnail ?>' border='0' class='thumbnail' width='118' height='150'/></a>
    <div class="product_desc"><?= $image['name'] . $image['shortdesc'] ?><div class="price_category">$ <?= $image['price']; ?></div>
        <div class="product_buy">
            <input type='hidden' value="<?=$image["product_id"]?>" name='product_id' />
            <input type="button" value="Buy"  name="add" />
        </div>
    </div>
</div>
<?php } ?>