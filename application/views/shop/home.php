<?php
/* By Haidar Mar'ie
 * Email = coder5@ymail.com
  footer */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="<?php echo css_dir(); ?>style.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?= css_dir() ?>smoothness/jquery-ui-1.8.16.custom.css" />
        <title><?= $title ?></title>
    </head>
    <body>
        <div id="main">
            <div class="container">
                <!-- Wrap All contain using CSS3 Box Shadow -->
                <div class="container_wrap">
                    <!--Header -->
                    <?php $this->load->view('shop/header'); ?>
                    <!--main product-->
                    <div class="main_product">
                        <!--Left Bar-->
                        <?php $this->load->view('shop/left_bar'); ?>

                        <!-- Product Main Highlight -->
                        <div class="product_center">
                            <div class="prod_highlight">
                                <p class="p_highlight">Lorem ipsum dolor sit amet</p>
                                <p class="p_desc">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                    Ut sit amet augue enim, id interdum arcu. Suspendisse vehicula,
                                    nisl sit amet ultricies aliquam.</p>

                                <a href="#" class="check_product_button">Check Product</a>
                            </div>
                        </div>

                        <!--items-->
                        <div class="items">
                            <div class="item_in"><h3>Item you might be interest in</h3></div>
                            <div class="products">
                                <?= $contents ?>
                            </div>
                        </div>

                        <?php $this->load->view('shop/footer'); ?>