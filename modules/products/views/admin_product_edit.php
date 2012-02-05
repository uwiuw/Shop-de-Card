
<link rel="stylesheet" href="<?= css_dir() ?>jquery.fileupload-ui.css" type="text/css" />
<div id="pageleftcont">
    <div id="create_edit">
        <h2><?php echo $title; ?></h2>
        <fieldset>
            <legend>Product Edit</legend>
            <form id="fileupload" name="edit_product" action="<?= site_url() ?>/products/uploaders/<?= $product['product_id'] ?>" method="POST" enctype="multipart/form-data">
                <?php
                //echo form_open_multipart('products/edit/' . $product['product_id']);

                echo "\n<p><label for='parent'>Category</label><br/>\n";
                echo form_dropdown('category_id', $categories, $product['category_id']) . "</p>\n";

                echo "<p><label for='pname'>Name(This will be used for image alt.)</label><br/>\n";
                $data = array('name' => 'name', 'product_id' => 'pname', 'size' => 25, 'value' => $product['name']);
                echo form_input($data) . "</p>\n";

                echo "<p><label for='short'>Short Description</label><br/>\n";
                //$data = array('name' => 'shortdesc', 'product_id' => 'short', 'rows' => 5, 'cols' => '80', 'value' => $product['shortdesc']);
                //echo form_textarea($data) . "</p>\n";
                ?>
                <textarea name="shortdesc" rows="5" cols="80" id="shortdesc"><?= $product['shortdesc'] ?></textarea></p>
                You have <span id="charsLeft"></span> chars left.
                <br /><br />
                <?php
                //echo "<p><label for='long'>Long Description</label><br/>\n";
                //$data = array('name' => 'longdesc', 'product_id' => 'long', 'class' =>"tinymce", 'rows' => 10, 'cols' => '80', 'value' => $product['longdesc']);
                //echo form_textarea($data) . "</p>\n";
                ?>
                <textarea  name="longdesc" class="tinymce" style="width:80%"><?=$product['longdesc']?></textarea><br /><br />
                <div class="row">
                    <div class="span16 fileupload-buttonbar">
                        <div class="progressbar fileupload-progressbar"><div style="width:0%;"></div></div>
                        <span class="btn success fileinput-button">
                            <span>Add files...</span>
                            <input type="file" name="files[]" multiple>
                        </span>
                        <button type="submit" class="btn primary start">Start upload</button>
                        <button type="reset" class="btn info cancel">Cancel upload</button>
                        <button type="button" class="btn danger delete">Delete selected</button>
                        <input type="checkbox" class="toggle">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="span16">
                        <table class="zebra-striped"><tbody class="files"></tbody></table>
                    </div>
                </div>

                <?php
                echo "<p><label for='status'>Status</label><br/>\n";
                $options = array('active' => 'active', 'inactive' => 'inactive');
                echo form_dropdown('status', $options, $product['status']) . "</p>\n";
                ?>
                <p><label for="stock_status">Stock Status</label><br/>
                    <select name="stock_status">
                        <option value="in-stock" <?php echo $product['stock_status']=='in-stock'?'selected':'' ?>>In-Stok</option>
                        <option value="factory" <?php echo $product['stock_status']=='factory'?'selected':'' ?>>Factory Shipped</option>
                    </select>
                </p>
                <p><label for="ship_restrict">Shipping Restriction</label><br>
                    <input type="text" name="ship_restrict" size="50" value="<?=$product['ship_restrict']?>" />
                </p>
                <?php
                echo "<p><label for='product_order'>Product Order</label><br/>";
                $data = array('name' => 'product_order', 'product_id' => 'product_order', 'size' => 11);
                echo form_input($data) . "</p>\n";

                echo "<p><label for='class'>Class(This will be used for html class and filtable.)</label><br/>";
                $data = array('name' => 'class', 'product_id' => 'class', 'size' => 50, 'value' => $product['class']);
                echo form_input($data) . "</p>\n";

                echo "<p><label for='group'>Grouping(This will be used for light box grouping and added to rel.)</label><br/>\n";
                $data = array('name' => 'grouping', 'product_id' => 'group', 'size' => 50, 'value' => $product['grouping']);
                echo form_input($data) . "</p>";

                echo "<p><label for='price'>Price</label><br/>\n";
                $data = array('name' => 'price', 'product_id' => 'price', 'size' => 20, 'value' => $product['price']);
                echo form_input($data) . "</p>\n";

                echo "<p><label for='featured'>Featured?</label><br/>\n";
                $options = array('none' => 'none', 'front' => 'Main frontpage', 'webshop' => 'Webshop frontpage');
                echo form_dropdown('featured', $options, $product['featured']) . "</p>\n";

                echo "<p><label for='other_feature'>Other Feature?</label><br/>\n";
                $options = array('none' => 'none', 'most sold' => 'Most sold', 'new product' => 'New Product');
                echo form_dropdown('other_feature', $options, $product['other_feature']) . "</p>\n";

                echo form_hidden('product_id', $product['product_id']);
                echo form_submit('submit', 'update product', ' onclick="edit_product.action=\'#\'; return true;"');
                echo form_close();
                ?>
        </fieldset>
    </div>
</div>

<script>
    var fileUploadErrors = {
        maxFileSize: 'File is too big',
        minFileSize: 'File is too small',
        acceptFileTypes: 'Filetype not allowed',
        maxNumberOfFiles: 'Max number of files exceeded',
        uploadedBytes: 'Uploaded bytes exceed file size',
        emptyResult: 'Empty file upload result'
    };
    function masuk(id){
         $.get("<?= site_url() ?>/products/change_primary/"+id, function(data) {
            //alert("Data Loaded: " + data);
        });
        //  $('.primary'+id).text('prim');
    }
    $(".prim").click(function() {
        //alert('test');
        $.get("<?= site_url() ?>/products/change_primary/"+id, function(data) {
           // alert("Has been set primary: " + data);
        });
    });
</script>

<script id="template-upload" type="text/html">
    {% for (var i=0, files=o.files, l=files.length, file=files[0]; i<l; file=files[++i]) { %}
        <tr class="template-upload fade">
            <td class="preview"><span class="fade"></span></td>
            <td class="name">{%=file.name%}</td>
            <td class="size">{%=o.formatFileSize(file.size)%}</td>
            {% if (file.error) { %}
            <td class="error" colspan="2"><span class="label important">Error</span> {%=fileUploadErrors[file.error] || file.error%}</td>
            {% } else if (o.files.valid && !i) { %}
            <td class="progress"><div class="progressbar"><div style="width:0%;"></div></div></td>
            <td class="start">{% if (!o.options.autoUpload) { %}<button class="btn primary">Start</button>{% } %}</td>
            {% } else { %}
            <td colspan="2"></td>
            <td colspan="2"><input type="radio" onclick="masuk({%=file.image_id%})" class="prim" name="primary" /></td>
            {% } %}
            <td class="cancel">{% if (!i) { %}<button class="btn info">Cancel</button>{% } %}</td>
        </tr>
        {% } %}
</script>
<script id="template-download" type="text/html">
    {% for (var i=0, files=o.files, l=files.length, file=files[0]; i<l; file=files[++i]) { %}
        <tr class="template-download fade">
            {% if (file.error) { %}
            <td></td>
            <td class="name">{%=file.name%}</td>
            <td class="size">{%=o.formatFileSize(file.size)%}</td>
            <td class="error" colspan="2"><span class="label important">Error</span> {%=fileUploadErrors[file.error] || file.error%}</td>
            {% } else { %}
            <td class="preview">{% if (file.thumbnail_url) { %}
                <a href="{%=file.url%}" title="{%=file.name%}" rel="gallery"><img src="{%=file.thumbnail_url%}"></a>
                {% } %}</td>
            <td class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" rel="{%=file.thumbnail_url&&'gallery'%}">{%=file.name%}</a>
            </td>
            <td class="size">{%=o.formatFileSize(file.size)%}</td>
            <td colspan="2"></td>
            <td colspan="2"><input type="radio" onclick="masuk({%=file.image_id%})" {%= file.default %} class="prim" name="primary"  />{%= file.default %}</td>
            {% } %}
            <td class="delete">
                <button class="btn danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">Delete</button>
                <input type="checkbox" name="delete" value="1">
            </td>
        </tr>
        {% } %}
</script>
<script src="<?= js_dir() ?>upload/load-image.min.js"></script>
<script src="<?= js_dir() ?>upload/jquery.fileupload.js"></script>
<script src="<?= js_dir() ?>upload/jquery.fileupload-ui.js"></script>

<!-- Load TinyMCE -->
<script type="text/javascript" src="<?= js_dir() ?>tiny_mce/jquery.tinymce.js"></script>
<script type="text/javascript">
        $(function() {
                $('textarea.tinymce').tinymce({
                        // Location of TinyMCE script
                        script_url : '<?= js_dir() ?>tiny_mce/tiny_mce_gzip.php',

                        // General options
                        theme : "advanced",
                        plugins : "style,advimage,advlink,inlinepopups,insertdatetime,preview,searchreplace,print,contextmenu,paste,directionality,fullscreen,nonbreaking",

                        // Theme options
                        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
                        theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,fullscreen",
                        theme_advanced_toolbar_location : "top",
                        theme_advanced_toolbar_align : "left",
                        theme_advanced_statusbar_location : "bottom",
                        theme_advanced_resizing : true,

                        // Replace values for the template plugin
                        template_replace_values : {
                                username : "Cherub Defense Admin",
                                staffid : "991234"
                        }
                });
        });
</script>
<!-- End TinyMCE -->