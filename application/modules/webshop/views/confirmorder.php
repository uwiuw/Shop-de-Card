<?php //print displayStatus(); ?>

<h1><?php echo lang('orders_plz_confirm'); ?></h1>
<p class="padnmgn"><?php echo lang('orders_confirm_before'); ?>

    <?php
    $data = lang('orders_go_to_cart');
    echo anchor("webshop/cart", $data);
    ?>.</p>
<?php
    if ($this->data['customer_status'] == 0) {
        echo "<h2>";
        echo "Or click <span class='login'>";
        echo anchor(lang('webshop_folder') . '/login', lang('general_login'));
        echo "</span> if you are already registered.";
        echo "</h2><br />";
    }
?>

<?php echo validation_errors('<div class="message error">', '</div>'); ?>
    <h2>Order details</h2><br />
<?php echo form_open(lang('webshop_folder') . "/emailorder"); ?>
<?php
    echo 'Total ' . $this->cart->total();
    if ($this->cart->total()) {
        $count = 1;
        foreach ($this->cart->contents() as $items) {
            echo "<p class='padnmgn'><b>" . $items['qty'] . " " . $items['name'] . " @ " . $items['price'] . "</b></p><br/>\n";
            echo "<input type='hidden' name='item_name_" . $count . "' value='" . $items['name'] . "'/>\n";
            echo "<input type='hidden' name='item_quantity_" . $count . "' value='" . $items['qty'] . "'/>\n";
            echo "<input type='hidden' name='item_price_" . $count . "' value='" . $items['price'] . "'/>\n";
            echo "<input type='hidden' name='item_currency_" . $count . "' value='NOK'/>\n";
            echo "<input type='hidden' name='ship_method_name_" . $count . "' value='Posten'/>\n";
            echo "<input type='hidden' name='ship_method_price_" . $count . "' value='" . $shippingprice . "'/>\n";
        }
    }
    if ($this->cart->total()) {
        $totalprice = $this->cart->total();
        //echo 'totaaaal ='.$totalprice;
        $grandtotal = (int) $totalprice + $shippingprice;
        echo "<p class='padnmgn'><b>" . lang('orders_sub_total_nor') . number_format($totalprice, 2, '.', ',') . "</b></p>\n";
    }
    echo "<p class='padnmgn'><b>" . lang('orders_shipping_nor') . number_format($shippingprice, 2, '.', ',') . "</b></p>\n";
    echo "<p class='padnmgn'><b>" . lang('orders_total_with_shipping') . number_format($grandtotal, 2, '.', ',') . "</b></p>\n";
?>

    <h3><?php echo lang('orders_first_name'); ?></h3>
    <input type="text" name="customer_first_name" value="<?php
    if (isset($fname)) {
        echo $fname;
    } else {
        echo set_value('customer_first_name');
    }
?>" size="30" />

<h3><?php echo lang('orders_last_name'); ?></h3>
<input type="text" name="customer_last_name" value="<?php
    if (isset($lname)) {
        echo $lname;
    } else {
        echo set_value('customer_last_name');
    }
?>" size="30" />

<h3><?php echo lang('orders_mobile_tel'); ?></h3>
    <input type="text" name="telephone" value="<?php
    if (isset($telephone)) {
        echo $telephone;
    } else {
        echo set_value('telephone');
    }
?>" size="15" />

<h3><?php echo lang('orders_email'); ?></h3>
    <input type="text" name="email" value="<?php
    if (isset($email)) {
        echo $email;
    } else {
        echo set_value('email');
    }
?>" size="40" />

    <h3><?php echo lang('orders_email_confirm'); ?></h3>
    <input type="text" name="emailconf" value="<?php
    if (isset($email)) {
        echo $email;
    } else {
        echo set_value('emailconf');
    }
?>" size="40" />

    <h3><?php echo lang('orders_shipping_address'); ?></h3>
    <input type="text" name="shippingaddress" value="<?php
    if (isset($address)) {
        echo $address;
    } else {
        echo set_value('shippingaddress');
    }
?>" size="50" />

    <h3><?php echo lang('orders_post_code'); ?></h3>
<input type="text" name="post_code" value="<?php
       if (isset($pcode)) {
           echo $pcode;
       } else {
           echo set_value('post_code');
       }
?>" size="8" />

       <h3><?php echo lang('orders_city'); ?></h3>
<input type="text" name="city" value="<?php
       if (isset($city)) {
           echo $city;
       } else {
           echo set_value('city');
       }
?>" size="20" />

       <br />
       <input type="submit" name="submit" value="<?php echo lang('orders_email_order'); ?>" />

<?php echo form_close(); ?>
