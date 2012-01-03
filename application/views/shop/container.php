<?php
/* By Haidar Mar'ie
 * Email = coder5@ymail.com
  footer */
?>
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
                <div class="container_wrap">
                    <?php $this->load->view('shop/header'); ?>
                    <!--main product-->
                    <div class="main_product">

                        <!--Left Bar-->
                        <?php $this->load->view('shop/left_bar'); ?>

                        <!-- Product Main Highlight -->
                        <div id="content">
                                <?= $contents ?>
                        </div>

                        <!--items-->
                        <div class="items">
                            <div class="products">
                            </div>
                        </div>

                        <?php $this->load->view('shop/footer'); ?>
                    
