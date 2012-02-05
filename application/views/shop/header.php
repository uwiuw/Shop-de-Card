<?php
/* By Haidar Mar'ie 
 * Email = coder5@ymail.com 
  header */
?>
<div id="header">
    <div id="top_nav">
        <div class="nav_top"><span class="my_account"><?= $this->data['loginstatus']; ?></span></div>
    </div>

    <!--logo-->
    <div id="logo">
        <div class="cart">
            <div class="shop_cart"><a href="<?= site_url('/webshop/cart/') ?>" >your cart</a> <div class="total_price">$ <?= $this->cart->format_number($this->total_cart) ?></div></div>
        </div>
        <div class="phone"></div>
        <a href="<?= site_url() ?>"><img src="<?= img_dir() ?>cherub_logo.png" alt="Cherub Defense Logo" width="675" height="149" /></a>
    </div>

    <!--search bar-->
    <div id="search_bar">
        <form  method="post" name="search" action="<?= site_url() ?>/webshop/search/"  id="searchform">
            <div class="search">Search 
                <input type="text" name="term" id="search" class="searching"/>
                <input type="submit" name="submit"  value="Go" />
            </div>
        </form>
    </div>
</div>
<?php
/*
if ($this->cart->total()) {
    echo lang('webshop_currency_symbol') . '' . $this->cart->format_number($this->cart->total());
} else {
    echo lang('webshop_shoppingcart_empty');
}
 */
?>