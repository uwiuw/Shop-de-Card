<?php
/* By Haidar Mar'ie
 * Email = coder5@ymail.com
  footer */
?>

<!--bottom-->
<div id="bottom">
    <div class="bottom_left"></div>
    <div class="bottom_center">
        <!--Sign UP-->
        <div id="sign_up">
            <input type="text" class="sign_up" name="email" value="Email Address"/>
            <input type="text" class="sign_up" name="email" value="First Name" />
            <input type="text" class="sign_up" name="email" value="Zip Code" />
        </div>
        <!--Links-->
        <div id="links">
            <?php
            //print_r($this->nav_list);
            echo '<ul class="links">';
            foreach ($this->nav_list as $menu) {
                echo '<li><a href="'.site_url().'/webshop/'.$menu['page_uri'].'">';
                echo $menu['name'];
                echo '</a></li>';
            }
            echo '</ul>';
            //
            ?>
        </div>
        <!--External Links-->
        <div id="ext_links">
            <ul>
                <li>Cherub blog</li>
                <li>Youtube</li>
                <li>Facebook</li>
                <li>Twitter</li>
            </ul>
        </div>
    </div>
    <div class="bottom_right"></div>
</div>
</div>
<div id="dialog" style="display: none;" title="Product Buy">
    <p>Thanks you buy this product</p>
</div>
</div>
</div>
<div id="footer">
    <div class="container">
        <div class="footer_left"></div>
        <div class="footer_center">Copyright <?= date('Y') ?></div>
        <div class="footer_right"></div>
    </div>
</div>
</body>
</html>