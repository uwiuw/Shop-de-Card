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
        <?php
        //print_r($this->nav_list);
        echo '<ul class="links">';
        foreach ($this->nav_list as $menu) {
            echo '<li><a href="' . site_url() . '/webshop/pages/' . $menu['page_uri'] . '">';
            echo $menu['name'];
            echo '</a></li>';
        }
        echo '</ul>';
        //
        ?>
    </div>
    <!--External Links-->
    <div id="links">
        <p>Cherub Defense</p>
        <?php
        //print_r($this->nav_list);
        echo '<ul class="links">';
        foreach ($this->nav_list as $menu) {
            echo '<li><a href="' . site_url() . '/webshop/' . $menu['page_uri'] . '">';
            echo $menu['name'];
            echo '</a></li>';
        }
        echo '</ul>';
        //
        ?>
    </div>
</div>
</div><!--main_product end div  -->
<div id="dialog" style="display: none;" title="Product Buy">
    <p></p>
</div>
<div id="footer">
    <div class="container">
        <div class="footer_center">Copyright <?= date('Y') ?></div>
    </div>
</div>
</div><!--container_wrap end div  -->
</div><!--container end div -->
</div><!--main end div -->
</body>
</html>