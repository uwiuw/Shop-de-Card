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
            <div class="nav_top">Welcome User &nbsp; &nbsp; <span class="my_account">My Account &nbsp; |  &nbsp; Logout&nbsp;&nbsp;&nbsp;</span></div>
        </div>
        <div class="top_nav_right"></div>
    </div>

    <!--logo-->
    <div id="logo">
        <div class="top_left"></div>
        <div class="top_center">
            <div class="cart">your cart</div> <div class="phone"></div>
        </div>
        <div class="top_right"></div>
    </div>

    <!--search bar-->
    <div id="search_bar">
        <div class="search_bar_left"></div>
        <div class="search_bar_center">
            <div class="search">Search</div>
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
<?php /*
  //print_r($this->nav_list);
  echo '<ul>';
  foreach ($this->nav_list as $menu) {
  echo '<li>';
  echo $menu['name'];
  echo '</li>';
  }
  echo '</ul>';
  echo $this->data['loginstatus'];

 */ ?>

<div id="cart_content">
<?php //echo $this->view('webshop/cart.php');  ?>
</div>