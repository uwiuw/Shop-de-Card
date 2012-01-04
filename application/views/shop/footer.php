<?php
/* By Haidar Mar'ie
 * Email = coder5@ymail.com
  footer */
?>
<!--bottom-->
<div id="bottom">

    <!--Sign UP-->

    <div id="links">
        <ul class="links">
            <li><input type="text" class="sign_up" name="email" value="Email Address"/></li>
            <li><input type="text" class="sign_up" name="email" value="First Name" /></li>
            <li><input type="text" class="sign_up" name="email" value="Zip Code" /></li>
        </ul>
    </div>

    <!--Links-->

    <div id="links">
        Links
        <ul class="links">
            <?php foreach ($this->nav_list as $menu) {
                $urls = '';
            ?>
                <li><a href="<?php echo site_url() . '/webshop/pages/' . $menu['page_uri'] ?>"><?= $menu['name']; ?></a></li>
            <?php } ?>
        </ul>
    </div>

    <!--External Links-->

    <div id="links">
        <p>Cherub Defense</p>
        <ul class="links">
            <?php foreach ($this->ext_links as $ext_links) { ?>
                <li><a href="<?php echo $ext_links->page_uri ?>"><?= $ext_links->name; ?></a></li>
            <?php } ?>
        </ul>
    </div>
</div>

</div><!--main_product end div  -->


<!-- Footer -->

<div id="footer">
    <div class="container">
        <div class="footer_center">Copyright <?= date('Y') ?></div>
    </div>
</div>

</div><!--container_wrap end div  -->
</div><!--container end div -->
</div><!--main end div -->

<!-- JJJJJJavascript Block pop up-->
<div id="dialog" style="display: none;" title="Product Buy">
    <p></p>
</div>
</body>
</html>