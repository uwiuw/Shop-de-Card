<?php
/* By Haidar Mar'ie 
 * Email = coder5@ymail.com 
  header */
?>
<!-- Shopping cart -->
<div id="header">
    <div id="top_nav">
        <div class="top_nav_left"></div>
        <div class="top_nav_center">
            <div class="nav_top"> &nbsp; &nbsp; <span class="my_account"><?= $this->data['loginstatus']; ?></span></div>
        </div>
        <div class="top_nav_right"></div>
    </div>

    <!--logo-->
    <div id="logo">
        <div class="top_left"></div>
        <div class="top_center">
            <div class="cart">
                <div class="shop_cart">your cart <div class="total_price">$ XXX.XX</div></div>
            </div>
            <div class="phone"></div>
            <a href="<?= site_url() ?>"><img src="<?= img_dir() ?>cherub_logo.png" width="675" height="149" /></a>
        </div>
        <div class="top_right"></div>
    </div>

    <!--search bar-->
    <div id="search_bar">
        <div class="search_bar_left"></div>
        <div class="search_bar_center">
            <div class="search">Search &nbsp;&nbsp;&nbsp;<input type="text" name="search" id="search"/></div>
        </div>
        <div class="search_bar_right"></div>
    </div>
</div>
<!--
<div class="insideright10">
    <p><span id="cart"><a href="<?php echo site_url(); ?>/<?php echo $this->lang->line('webshop_folder'); ?>/cart"><?php echo lang('general_shopping_cart'); ?></a></span><br />
        <span id="total_cart">
<?php
if ($this->cart->total()) {
    echo lang('webshop_currency_symbol') . '' . $this->cart->format_number($this->cart->total());
} else {
    echo lang('webshop_shoppingcart_empty');
}
?>
        </span>
    </p>    
</div>
-->


<div id="cart_content">
    <?php //echo $this->view('webshop/cart.php');  ?>
</div>