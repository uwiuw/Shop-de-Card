<?php
/* By Haidar Mar'ie 
 * Email = coder5@ymail.com 
  header */
?>
<!-- Shopping cart -->
<div class="insideright10">
    <p><span id="cart"><a href="<?php echo site_url(); ?>/<?php echo $this->lang->line('webshop_folder'); ?>/pages/cart"><?php echo lang('general_shopping_cart'); ?></a></span><br />
<?php
//echo 'Total= '.$_SESSION['totalprice'];
//echo $this->data['handlekurv'];exit;
$handlekurv = $this->data['handlekurv'];
$handlekurv2 = number_format($handlekurv, 2, '.', ',');
if (isset($handlekurv2)) {
    echo lang('webshop_currency_symbol') . $handlekurv2;
} else {
    echo lang('webshop_shoppingcart_empty');
}
?>
    </p>    
</div>
<?php
foreach ($this->nav_list as $key => $menu) {
    echo "\n<li class='menuone'>\n";
    echo anchor($this->lang->line('webshop_folder') . "/pages/" . $menu['page_uri'], $menu['name']);
    if (count($menu['children'])) {
        echo "\n<ul>";
        foreach ($menu['children'] as $subkey => $submenu) {
            echo "\n<li class='menutwo'>\n";
            echo anchor($this->lang->line('webshop_folder') . "/pages/" . $submenu['page_uri'], $submenu['name']);
            if (count($submenu['children'])) {
                echo "\n<ul>";
                foreach ($submenu['children'] as $subkey => $subsubname) {
                    echo "\n<li class='menuthree'>\n";
                    echo anchor($this->lang->line('webshop_folder') . "/cat/", $subsubname['name']);
                    echo "\n</li>";
                }
                echo "\n</ul>";
            }
            echo "\n</li>";
        }
        echo "\n</ul>";
    }
    echo "\n</li>\n";
}
echo $this->data['loginstatus'];
?>
<div id="cart_content">
    <?php echo $this->view('webshop/cart.php'); ?>
</div>