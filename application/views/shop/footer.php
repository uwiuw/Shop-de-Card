<?php
/* By Haidar Mar'ie
 * Email = coder5@ymail.com
  footer */
?>
<!--bottom-->
<div id="bottom">

    <!--Sign UP-->
    <div class="links">
        <p class="email_deals">Email Deals</p>
        <p class="small">Sales Specials & Exclusive</p>
        <ul class="link_list">
            <form action="<?= site_url() ?>/webshop/newsletter" method="post">
                <li><input type="text" class="sign_up" name="email" value="Email Address"/></li>
                <li><input type="text" class="sign_up" name="first_name" value="First Name" /></li>
                <li><input type="text" class="sign_up" name="zip_code" value="Zip Code" /></li>
                <li><input type="submit" value="SIGN UP" /> </li>
            </form>
        </ul>
    </div>

    <!--Links-->

    <div class="links">
        <p>Links</p>
        <ul class="link_list">
            <li><a href="<?=site_url()?>" >Home</a>
            <?php foreach ($this->nav_list as $menu) { ?>
                <li><a href="<?php echo site_url("/webshop") . '/pages/' . $menu['page_uri'] ?>" ><?= $menu['name']; ?></a></li>
            <?php } ?>
        </ul>
    </div>

    <!--External Links-->

    <div class="links">
        <p>Cherub Defense</p>
        <ul class="link_list">
            <?php foreach ($this->ext_links as $ext_links) {
                $blank = $ext_links->target==1 ? ' target="_blank"':'';?>
                <li><a href="<?php echo $ext_links->page_uri ?>" <?= $blank?>><?= $ext_links->name; ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>

</div><!--main_product end div  -->


<!-- Footer -->

<div id="footer">
    <div class="container">
        <div class="footer_center">
            <p>Copyright &copy;<?= date('Y') ?> CherubDefense.com, All Rights Reserved.</p>
            <p><a href="http://www.brands-up.com">Design & Developed by Brands-Up</a></p>
        </div>
    </div>
</div>

</div><!--container_wrap end div  -->
</div><!--container end div -->
</div><!--main end div -->

<!-- Javascript Block pop up-->

<script type="text/javascript" src="<?= js_dir() ?>jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="<?= js_dir() ?>jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="<?= js_dir() ?>cherub.js"></script>
</body>
</html>