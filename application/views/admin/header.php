<?php
/* By Haidar Mar'ie
 * Email = coder5@ymail.com
  header */
$check_url = $this->uri->segment(1);
$current_url = current_url();
$active = 'id="menu-active"';
?>

<div id="menu" class="box">

    <ul class="box f-right">
        <li><a href="<?php echo site_url();?>"><span><strong>Visit Site &raquo;</strong></span></a></li>
    </ul>

    <ul class="box">
        <li <?php echo $check_url =='categories'?$active:''?>><a href="<?php echo site_url(); ?>/categories"><span>Categories</span> </a></li>
        <li <?php echo $check_url =='products'?$active:''?>><a href="<?php echo site_url(); ?>/products"><span>Products</span></a></li>
        <li <?php echo $check_url =='customers'?$active:''?>><a href="<?php echo site_url(); ?>/customers"><span>Customers</span></a></li>
        <li <?php echo $check_url =='orders'?$active:''?>><a href="<?php echo site_url(); ?>/orders"><span>Orders</span></a></li>
        <li <?php echo $check_url =='menus'?$active:''?>><a href="<?php echo site_url(); ?>/menus"><span>Menu</span></a></li>
    </ul>

</div> 