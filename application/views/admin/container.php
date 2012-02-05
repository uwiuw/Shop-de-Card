<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <meta http-equiv="content-language" content="en" />
        <meta name="robots" content="noindex,nofollow" />
        <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo css_dir(); ?>reset.css" /> <!-- RESET -->
        <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo css_dir(); ?>main_backend.css" /> <!-- MAIN STYLE SHEET -->
        <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo css_dir(); ?>2col.css" title="2col" /> <!-- DEFAULT: 2 COLUMNS -->
        <link rel="alternate stylesheet" media="screen,projection" type="text/css" href="<?php echo css_dir(); ?>1col.css" title="1col" /> <!-- ALTERNATE: 1 COLUMN -->
        <!--[if lte IE 6]><link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo css_dir(); ?>main-ie6.css" /><![endif]--> <!-- MSIE6 -->
        <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo css_dir(); ?>style_backend.css" /> <!-- GRAPHIC THEME -->
        <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo css_dir(); ?>mystyle.css" /> <!-- WRITE YOUR CSS CODE HERE -->
        <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo css_dir(); ?>FlashStatus.css" /> <!-- WRITE YOUR CSS CODE HERE -->
        <link rel="stylesheet" media="screen,projection" type="text/css" href="<?php echo css_dir(); ?>smoothness/jquery-ui-1.8.16.custom.css" /> <!-- WRITE YOUR CSS CODE HERE -->
        <script type="text/javascript" src="<?php echo js_dir(); ?>jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="<?php echo js_dir(); ?>jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="<?php echo js_dir(); ?>cherub.js"></script>
        <title><?= $title ?></title>
    </head>
    <body>
        <div id="main">

            <!-- Tray -->
            <div id="tray" class="box">

                <p class="f-left box">

                    <!-- Switcher -->
                    <span class="f-left" id="switcher">
                        <a href="#" rel="1col" class="styleswitch ico-col1" title="Display one column"><img src="<?php echo backend_img_dir(); ?>/switcher-1col.gif" alt="1 Column" /></a>
                        <a href="#" rel="2col" class="styleswitch ico-col2" title="Display two columns"><img src="<?php echo backend_img_dir(); ?>/switcher-2col.gif" alt="2 Columns" /></a>
                    </span>

                    <strong>Cherub Defense WhareHouse Admin Backend</strong>

                </p>

                <p class="f-right">User: <strong><a href="#"><?= $_SESSION['ca_username'] ?></a></strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <strong><a href="<?= site_url() ?>/admin/logout" id="logout">Log out</a></strong></p>

            </div> <!--  /tray -->

            <hr class="noscreen" />

            <!-- Menu -->
            <?php $this->load->view('admin/header'); ?>
            <!-- /header -->
            <hr class="noscreen" />

            <!-- Columns -->
            <div id="cols" class="box">

                <!-- Aside (Left Column) -->
                <div id="aside" class="box">

                    <div class="padding box">

                        <!-- Logo (Max. width = 200px) -->
                        <p id="logo"><a href="<?php echo site_url(); ?>" target="_blank"><img src="<?php echo backend_img_dir(); ?>/cherub.png"  alt="Our logo" title="Visit Site" /></a></p>

                        <!-- Search -->
                        <form action="#" method="get" id="search">
                            <fieldset>
                                <legend>Search</legend>

                                <p><input type="text" size="17" name="" class="input-text" />&nbsp;<input type="submit" value="OK" class="input-submit-02" /><br />
                                    <a href="javascript:toggle('search-options');" class="ico-drop">Advanced search</a></p>

                                <!-- Advanced search -->
                                <div id="search-options" style="display:none;">

                                    <p>
                                        <label><input type="checkbox" name="" checked="checked" /> Option I.</label>
                                        <label><input type="checkbox" name="" /> Option II.</label>
                                        <label><input type="checkbox" name="" /> Option III.</label>
                                    </p>

                                </div> <!-- /search-options -->

                            </fieldset>
                        </form>


                    </div> <!-- /padding -->
                    <?php
                    $check_url = $this->uri->segment(1);
                    $current_url = current_url();
                    $active = 'id="submenu-active"';
                    ?>

                    <ul class="box">
                        <li <?php echo $check_url == 'users' ? $active : '' ?>><a href="<?php echo site_url(); ?>/users">Users</a></li>
                        <li <?php echo $check_url == 'products' ? $active : '' ?>><a href="<?php echo site_url(); ?>/products">Products</a></li>
                        <li <?php echo $check_url == 'categories' ? $active : '' ?>><a href="<?php echo site_url(); ?>/categories">Categories</a></li>
                        <li <?php echo $check_url == 'customers' ? $active : '' ?>><a href="<?php echo site_url(); ?>/customers">Customers</a></li>
                        <li <?php echo $check_url == 'orders' ? $active : '' ?>><a href="<?php echo site_url(); ?>/orders">Orders</a></li>

                        <!-- For new Orders -->
                        <ul>
                            <li><a href="#">Lorem ipsum</a></li>
                            <li><a href="#">Lorem ipsum</a></li>
                            <li><a href="#">Lorem ipsum</a></li>
                            <li><a href="#">Lorem ipsum</a></li>
                            <li><a href="#">Lorem ipsum</a></li>
                        </ul>
                        <li <?php echo $check_url == 'menus' ? $active : '' ?>><a href="#">Menu</a></li>
                        <li <?php echo $check_url == 'pages' ? $active : '' ?>><a href="#">Pages</a></li>
                    </ul>

                </div> <!-- /aside -->

                <hr class="noscreen" />

                <!-- Content (Right Column) -->
                <div id="content" class="box">
                    <div id="contents">
                        <?= 'Admin ' . create_breadcrumb() ?>
                        <?= $contents ?>
                    </div> <!-- /cols -->

                    <hr class="noscreen" />

                    <!-- Footer -->
                    <div id="footer" class="box">

                        <p class="f-left">&copy; <?= date('Y'); ?> <a href="#">Cherub Defense</a>, All Rights Reserved &reg;</p>

                        <p class="f-right">Developed by <a href="http://www.brands-up.com/">Brands Up</a></p>

                    </div> <!-- /footer -->

                </div> <!-- /main -->

                <div id="dialog-confirm" title="Delete this?">
                    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
                        These items will be permanently deleted and cannot be recovered. Are you sure?
                        <input type="hidden" name="id_delete" value="" /></p>
                </div>
                </body>
                </html>
