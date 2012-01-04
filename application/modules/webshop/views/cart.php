<?php
//print_r($this->cart->contents());
if (!$this->cart->contents()):
    echo 'You don\'t have any items yet.';
else:
?>

<?php echo form_open('webshop/update_cart'); ?>
    <table id="cart_list" width="100%" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <td>Qty</td>
                <td>Item Description</td>
                <td>Item Price</td>
                <td>Sub-Total</td>
            </tr>
        </thead>
        <tbody>    
        <?php $i = 1; ?>
        <?php foreach ($this->cart->contents() as $items): ?>


            <tr id="item-<?= $items['id'] ?>" <?php
            if ($i & 1) {
                echo 'class="alt" ';
            }
        ?>>
            <td>
                <?php echo form_input(array('name' => 'qty[]', 'value' => $items['qty'], 'maxlength' => '3', 'size' => '5')); ?>
            </td>

            <td><?php echo $items['name']; ?></td>

            <td><?php echo $items['price']; ?></td>
            <td><?php echo $items['subtotal']; ?></td>

            <td><div class="del_item"><?php echo form_hidden('rowid[]', $items['rowid']); ?><input type="button" value="Delete" class="delete_item" name="delete_item" /><input type="hidden" name="id" value="<?= $items['id'] ?>" /></div></td>
        </tr>

        <?php $i++; ?>
        <?php endforeach; ?>

                <tr>
                    <td</td>
                    <td></td>
                    <td><strong>Total</strong></td>
                    <td><?php echo $this->cart->format_number($this->cart->total()); ?></td>
                </tr>
            </tbody>
        </table>

        <p><?php echo form_submit('', 'Update your Cart');
                echo anchor('webshop/empty_cart', 'Empty Cart', 'class="empty"'); ?></p>
            <p><small>If the quantity is set to zero, the item will be removed from the cart.</small></p>
            <h2><a href="<?=site_url()?>webshop/checkout">Go To Checkout</a></h2>
<?php
                echo form_close();
            endif;
?>



