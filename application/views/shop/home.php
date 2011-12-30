<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <script type="text/javascript" src="<?= js_dir() ?>jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="<?= js_dir() ?>jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="<?= js_dir() ?>cart.js"></script>
        <link href="<?php echo css_dir(); ?>style.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" type="text/css" href="<?= css_dir() ?>smoothness/jquery-ui-1.8.16.custom.css" />
        <title><?= $title ?></title>
    </head>
    <body>
        <div id="main">

            <div class="container">
                <?php $this->load->view('shop/header'); ?>
                <!--main product-->
                <div class="main_product">
                    <!--Left Bar-->
                    <?php $this->load->view('shop/left_bar'); ?>

                    <!-- Product Main Highlight -->
                    <div class="product_left"></div>
                    <div class="product_center">
                        <div class="prod_highlight">
                            <p class="p_highlight">Lorem ipsum dolor sit amet</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                Ut sit amet augue enim, id interdum arcu. Suspendisse vehicula,
                                nisl sit amet ultricies aliquam.</p>

                            <a href="#" class="check_product_button">Check Product</a>
                        </div>
                    </div>
                    <div class="product_right"></div>

                    <!--items-->
                    <div class="items">

                        <div class="items_left"></div>
                        <div class="items_center">

                            <div class="item_in"><h3>Item you might be interest in</h3></div>
                            <div class="products"><?= $contents ?>

                            </div>

                        </div>
                        <div class="items_right"></div>
                    </div>

                     <?php $this->load->view('shop/footer'); ?>