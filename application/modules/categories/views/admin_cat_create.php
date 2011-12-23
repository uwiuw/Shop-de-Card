<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="pageleftcont">
    <h2><?php echo $title; ?></h2>
    <div id="create_edit">
<?php
echo form_open('categories/admin/create');
echo "\n<p><label for='catname'>Name</label><br/>\n";
$data = array('name' => 'name', 'id' => 'catname', 'size' => 25);
echo form_input($data) . "</p>\n";

echo "<p><label for='short'>Short Description</label><br/>\n";
$data = array('name' => 'shortdesc', 'id' => 'short', 'rows' => 5, 'cols' => '40');
echo form_textarea($data) . "</p>\n";
?>
        <a href="javascript:toggleEditor('short');">Add/Remove editor</a><br /><br />
<?php
echo "<p><label for='long'>Long Description</label><br/>\n";
$data = array('name' => 'longdesc', 'id' => 'long', 'rows' => 5, 'cols' => '40');
echo form_textarea($data) . "</p>\n";
?>
        <a href="javascript:toggleEditor('long');">Add/Remove editor</a><br /><br />
<?php
echo "<p><label for='status'>Status</label><br/>\n";
$options = array('active' => 'active', 'inactive' => 'inactive');
echo form_dropdown('status', $options) . "</p>\n";

echo "<p><label for='parent'>Category Parent</label><br/>\n";
echo form_dropdown('parentid', $categories) . "</p>\n";


echo form_submit('submit', 'create category');
echo form_close();
?>
    </div>
</div>
<div id="pagerightcont">
<?php // $this->load->view($right); ?>
</div>