
<link rel="stylesheet" href="<?= css_dir() ?>jquery.fileupload-ui.css" type="text/css" />
<div id="pageleftcont">
    <div id="create_edit">
        <h2><?php echo $title; ?></h2>
        
        <form id="fileupload" name="create_product" action="<?= site_url() ?>/products/uploaders" method="POST" enctype="multipart/form-data">
        <?php
        //echo form_open_multipart('products/create') . "\n";

        echo "<p><label for='parent'>Category</label><br/>\n";
        echo form_dropdown('category_id', $categories) . "</p>\n";


        echo "<p><label for='pname'>Name</label><br/>";
        $data = array('name' => 'name', 'product_id' => 'pname', 'size' => 25);
        echo form_input($data) . "</p>\n";

        echo "<p><label for='short'>Short Description</label><br/>";
        //$data = array('name' => 'shortdesc', 'product_id' => 'short', 'rows' => 5, 'cols' => '80');
        //echo form_textarea($data) . "</p>\n";
        ?>
            <textarea name="shortdesc" rows="5" cols="80" id="shortdesc"></textarea></p>
        You have <span id="charsLeft"></span> chars left.

        <a href="javascript:toggleEditor('short');">Add/Remove editor</a><br /><br />
        <?php
        echo "<p><label for='long'>Long Description</label><br/>";
        $data = array('name' => 'longdesc', 'product_id' => 'long', 'rows' => 10, 'cols' => '80');
        echo form_textarea($data) . "</p>\n";
        ?>
        <input type="hidden" name="product_id" value="<?=$product_id?>" />
        
        <a href="javascript:toggleEditor('long');">Add/Remove editor</a><br /><br />
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
        <div id="gallery-loader"></div>
        <!-- gallery-modal is the modal dialog used for the image gallery -->
        <div id="gallery-modal" class="modal hide fade">
            <div class="modal-header">
                <a href="#" class="close">&times;</a>
                <h3 class="title"></h3>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <a class="btn primary next">Next</a>
                <a class="btn info prev">Previous</a>
                <a class="btn success download" target="_blank">Download</a>
            </div>
        </div>
        <?php
        /*
        echo "<p><label for='uimage'>Select Image</label><br/>";
        $data = array('name' => 'image', 'product_id' => 'uimage', 'size' => 80);
        echo form_textarea($data) . "</p>\n";

        echo "<p><label for='uthumb'>Select Thumbnail</label><br/>";
        $data = array('name' => 'thumbnail', 'product_id' => 'uthumb', 'size' => 80);
        echo form_textarea($data) . "</p>\n";
        */
        echo "<p><label for='status'>Status</label><br/>";
        $options = array('1' => 'active', '0' => 'inactive');
        echo form_dropdown('status', $options) . "</p>\n";

        echo "<p><label for='product_order'>Product Order</label><br/>";
        $data = array('name' => 'product_order', 'product_id' => 'product_order', 'size' => 11);
        echo form_input($data) . "</p>\n";

        echo "<p><label for='class'>Class</label><br/>";
        $data = array('name' => 'class', 'product_id' => 'class', 'size' => 50);
        echo form_input($data) . "</p>\n";

        echo "<p><label for='group'>Grouping</label><br/>";
        $data = array('name' => 'grouping', 'product_id' => 'group', 'size' => 50);
        echo form_input($data) . "</p>\n";

        echo "<p><label for='price'>Price</label><br/>";
        $data = array('name' => 'price', 'product_id' => 'price', 'size' => 20);
        echo form_input($data) . "</p>\n";

        echo "<p><label for='featured'>Featured?</label><br/>\n";
        $options = array('none' => 'none', 'front' => 'Main frontpage', 'webshop' => 'Webshop frontpage');
        echo form_dropdown('featured', $options) . "</p>\n";

        echo "<p><label for='other_feature'>Other Feature?</label><br/>\n";
        $options = array('none' => 'none', 'most sold' => 'Most sold', 'new product' => 'New Product');
        echo form_dropdown('other_feature', $options) . "</p>\n";

        echo form_submit('submit', 'create product',' onclick="create_product.action=\'#\'; return true;"');
        echo form_close();
        ?>
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
                {% } %}
                <td class="delete">
                    <button class="btn danger" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}">Delete</button>
                    <input type="checkbox" name="delete" value="1">
                </td>
            </tr>
            {% } %}
            </script>
            <script src="<?= js_dir() ?>upload/tmpl.min.js"></script>
            <script src="<?= js_dir() ?>upload/load-image.min.js"></script>
            <script src="<?= js_dir() ?>upload/jquery.fileupload.js"></script>
            <script src="<?= js_dir() ?>upload/jquery.fileupload-ui.js"></script>
            <script src="<?= js_dir() ?>upload/application.js"></script>