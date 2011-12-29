<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />
        <title></title>

        <link rel="stylesheet" type="text/css" href="<?=css_dir()?>login.css" media="all" />

        <script type="text/javascript" src="<?=js_dir()?>jquery-1.7.1.min.js"></script>
        <script type="text/javascript" src="<?=js_dir()?>jquery-ui-1.8.16.custom.min.js"></script>
        <script type="text/javascript" src="<?=js_dir()?>/jquery.inputfocus-0.9.min.js"></script>
        <script type="text/javascript" src="<?=js_dir()?>/jquery.main.js"></script>
    </head>
    <body>

        <div id="container">
            <form action="admin/log_in" method="post">
                <!-- #first_step -->
                <div id="first_step">
                    <h1>SIGN UP FOR A FREE <span>WEBEXP18</span> ACCOUNT</h1>

                    <div class="form">
                        <input type="text" name="email" id="email" value="email" />

                        <input type="password" name="password" id="password" value="password" />

                        <input type="password" name="cpassword" id="cpassword" value="password" />
                        <label for="cpassword">If your passwords aren’t equal, you won’t be able to continue with signup.</label>
                    </div>      <!-- clearfix --><div class="clear"></div><!-- /clearfix -->
                    <input class="submit" type="submit" name="submit_first" id="submit_first" value="" />

                    <input class="send submit" type="submit" name="submit_fourth" id="submit_fourth" value="" />
                </div>      <!-- clearfix --><div class="clear"></div><!-- /clearfix -->


            </form>
        </div>

    </body>
</html>
<?php
print form_open('admin/log_in', array('class' => 'horizontal'));
if ($this->session->flashdata('message')) {
    echo "<div class='status_box success'>" . $this->session->flashdata('message') . "</div>";
}
?>
<fieldset>
    <ol>
        <li>
            <label for="login_field">Email :</label>
            <input type="text" name="email" id="email" class="text" value=""/>
        </li>
        <li>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="text" />
        </li>
        <li>
            <label for="remember">Is Remember ?</label>
            <?php print form_checkbox('remember', 'yes', $this->input->post('remember')) ?>
        </li>

        <li class="submit">
            <div class="buttons">
                <button type="submit" class="positive" name="submit" value="submit">
                    <?php // print $this->bep_assets->icon('key')  ?>
            			Submit
                </button>

                <a href="<?php print site_url('auth/forgotten_password') ?>">
                    <?php //print $this->bep_assets->icon('arrow_refresh')  ?>
            			Forget Password
                </a>
        </li>
    </ol>
</fieldset>
<?php print form_close() ?>