<?php
$imageinfo = $product['image'];
$image = convert_image_path(base_url() . $imageinfo);
$image = prod_dir() . $product['image_id'] . $product['extension'];
$image_thumb = prod_thumb_dir() . $product['image_id'] . $product['extension'];
$ship_restrict = $product['ship_restrict'] != "" ? 'This Product is not available to ship to ' . $product['ship_restrict'] : "Available All State";
?>
<div id="image">
    <div id="imageview">
        <img src="<?= timthumb($image, NULL, 200) ?>" alt="<?= $product['name'] ?>" alt="<?= $product['name'] ?>" />
    </div>
    <?php if ($images > 0) {
 ?>

        <div id="thumbnails">
        <?php foreach ($images as $img) {
        ?>
            <a href="<?= timthumb(prod_dir() . $img, NULL, 200) ?>"><img src='<?= timthumb(prod_thumb_dir() . $img, NULL, 80) ?>' alt="<?= $product['name'] ?>" class='prod_img' align='left'/></a>
        <?php } ?>
    </div>
<?php } else {
?>
<?php } ?>
</div>
    <div class="left_desc">
        <h2><?= $product['name'] ?></h2>
        <p>Status : <?= $product['stock_status'] ?></p>
        <p>Ship Restrictions : <?= $ship_restrict ?></p>
        <p>$ <?= $product['price']; ?></p>
        <div class="product_buy">
            <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>" />
            <input type="hidden" name="qty" value="1" />
            <input type="submit" value="Buy" name="add" class="buy" />
        </div>
    </div>
    <div class="long_desc"><?= htmlspecialchars_decode($product['longdesc']); ?></div>
<br />