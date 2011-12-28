<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <script type="text/javascript" src="<?= js_dir() ?>jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="<?= js_dir() ?>jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="<?= js_dir() ?>cart.js"></script>
    <link rel="stylesheet" type="text/css" href="<?=css_dir()?>smoothness/jquery-ui-1.8.16.custom.css" />
    <title><?= $title ?></title>

    <body>
        <?php $this->load->view('shop/header'); ?>
        <div id="dialog" title="Product Buy">
            <p>Thanks you buy this product</p>
        </div>
        <div id="contents"><?= $contents ?></div>
        <div id="footer">Copyright <?= date('Y') ?></div>
    </body>
</html>
