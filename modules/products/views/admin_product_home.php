<h2><?php echo $title; ?></h2>
<p><?php echo anchor("products/create", "Create new product"); ?> | <a href="<?=site_url()?>/products/export_product">Export </a></p>

<?php
echo form_open_multipart("products/import");
$data = array('name' => 'csvfile', 'size' => 15);
echo form_upload($data);
echo form_hidden('csvinit', true);
echo form_submit('submit', 'IMPORT');
echo form_close();
?>

<?php
if ($this->session->flashdata('message')) {
    echo "<div class='status_box'>" . $this->session->flashdata('message') . "</div>";
}
if (count($products)) {
    echo form_open("products/batchmode");
    echo "<p>Category: " . form_dropdown('category_id', $categories);
    echo "&nbsp;";
    //$data = array('name'=>'grouping','size'=>'10');
    //echo "Grouping: ". form_input($data);
    //echo form_submit("submit","batch update");
    echo "</p>";
    echo '<table id="tablesorter_product" class="tablesorter" border="1" cellspacing="0" cellpadding="3" width="100%">';
    echo "<thead>\n<tr valign='top'>\n";
    echo "<th>&nbsp;</th><th>Product ID</th>\n<th>Name</th><th>Class</th><th>Grouping</th><th>Status</th><th>Category Name</th><th>Featured</th><th>Price</th><th>Actions</th>\n";
    echo "</tr>\n</thead>\n<tbody>\n";
    foreach ($products as $key => $list) {
        echo "<tr valign='top'>\n";
        echo "<td align='center'>" . form_checkbox('p_id[]', $list['product_id'], FALSE) . "</td>";
        echo "<td align='center'>" . $list['product_id'] . "</td>\n";
        echo "<td align='center'>" . $list['name'] . "</td>\n";
        echo "<td align='center'>" . $list['class'] . "</td>\n";
        echo "<td align='center'>" . $list['grouping'] . "</td>\n";

        echo "<td align='center'>";
        echo anchor('products/changeProductStatus/' . $list['product_id'], $list['status'], array('class' => $list['status']));
        echo "</td>\n";

        // echo "<td align='center'>".$list['category_id']."</td>\n";
        echo "<td align='center'>" . $list['CatName'] . "</td>\n";
        echo "<td align='center'>" . $list['featured'] . "</td>\n";
        echo "<td align='center'>" . $list['price'] . "</td>\n";
        echo "<td align='center'>";
        echo anchor('products/edit/' . $list['product_id'], 'edit');
        echo " | ";
        echo anchor('products/delete/' . $list['product_id'], 'delete');
        echo "</td>\n";
        echo "</tr>\n";
    }
    echo "</tbody></table>";
    echo form_close();
}
?>