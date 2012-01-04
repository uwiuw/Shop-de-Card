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
$image = prod_dir() . $product['image_id'] . $product['extension'];
if ($images > 0) {
    foreach ($images as $img) {
        ?>
        <img src='<?= prod_dir() . $img . $product['extension'] ?>' class='prod_img' width='260' align='left'/>
  <?php  }
} else { ?>
    <img src='<?= $image ?>' class='prod_img' width='260' align='left'/>
<?php } ?>
<div class="product_buy"><h2><?=$product['name'] ?></h2>
<?=$product['shortdesc'];?>
<?=$product['longdesc'];?>
<br />
<p>$ <?= $product['price']; ?></p>
<input type="submit" value="Buy" name="add" />
<input type="hidden" name="product_id" value="<?= $product['product_id'] ?>" />
<input type="hidden" name="qty" value="1" />
</div>