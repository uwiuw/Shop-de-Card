<div id="pageleftcont">
<div id="create_edit">
<h2><?php echo $title;?></h2>
<?php
echo form_open_multipart('products/admin/edit/'.$product['product_id']);

echo "\n<p><label for='parent'>Category</label><br/>\n";
echo form_dropdown('category_id',$categories,$product['category_id']) ."</p>\n";

echo "<p><label for='pname'>Name(This will be used for image alt.)</label><br/>\n";
$data = array('name'=>'name','product_id'=>'pname','size'=>25, 'value' => $product['name']);
echo form_input($data) ."</p>\n";

echo "<p><label for='short'>Short Description</label><br/>\n";
$data = array('name'=>'shortdesc','product_id'=>'short','rows'=>5, 'cols'=>'80', 'value' => $product['shortdesc']);
echo form_textarea($data) ."</p>\n";
?>
<a href="javascript:toggleEditor('short');">Add/Remove editor</a><br /><br />
<?php
echo "<p><label for='long'>Long Description</label><br/>\n";
$data = array('name'=>'longdesc','product_id'=>'long','rows'=>10, 'cols'=>'80', 'value' => $product['longdesc']);
echo form_textarea($data) ."</p>\n";
?>
<a href="javascript:toggleEditor('long');">Add/Remove editor</a><br /><br />
<?php
echo "<p><label for='uimage'>Select Image</label><br/>\n";
$data = array('name'=>'image','product_id'=>'uimage','size'=>100, 'value' => $product['image']);
echo form_textarea($data) . "</p>\n";

echo "<p><label for='uthumb'>Select Thumbnail</label><br/>\n";
$data = array('name'=>'thumbnail','product_id'=>'uthumb','size'=>100, 'value' => $product['thumbnail']);
echo form_textarea($data) ."</p>\n";

echo "<p><label for='status'>Status</label><br/>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status',$options, $product['status']) ."</p>\n";

echo "<p><label for='product_order'>Product Order</label><br/>";
$data = array('name'=>'product_order','product_id'=>'product_order','size'=>11);
echo form_input($data) ."</p>\n";

echo "<p><label for='class'>Class(This will be used for html class and filtable.)</label><br/>";
$data = array('name'=>'class','product_id'=>'class','size'=>50, 'value' => $product['class']);
echo form_input($data) ."</p>\n";

echo "<p><label for='group'>Grouping(This will be used for light box grouping and added to rel.)</label><br/>\n";
$data = array('name'=>'grouping','product_id'=>'group','size'=>50, 'value' => $product['grouping']);
echo form_input($data) ."</p>";

echo "<p><label for='price'>Price</label><br/>\n";
$data = array('name'=>'price','product_id'=>'price','size'=>20, 'value' => $product['price']);
echo form_input($data) ."</p>\n";

echo "<p><label for='featured'>Featured?</label><br/>\n";
$options = array('none' => 'none', 'front' => 'Main frontpage', 'webshop' => 'Webshop frontpage');
echo form_dropdown('featured',$options, $product['featured']) ."</p>\n";

echo "<p><label for='other_feature'>Other Feature?</label><br/>\n";
$options = array('none' => 'none', 'most sold' => 'Most sold', 'new product' => 'New Product');
echo form_dropdown('other_feature',$options, $product['other_feature']) ."</p>\n";

echo form_hidden('product_id',$product['product_id']);
echo form_submit('submit','update product');
echo form_close();


?>
</div>
 </div>