<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Cherub Defense Warehouse Admin Backend</title>
        <link rel="stylesheet" type="text/css" href="<?= css_dir() ?>login.css" media="screen" title="bbxcss" />
    </head>
    <body>
        <p class="live"><a href="<?= site_url() ?>">&laquo; Live Site</a></p>
        <form id="start" method="post" action="<?= site_url() ?>/admin/log_in">
            <h1>Cherub Admin Backend</h1>
            <p>
                <label for="email">Email</label>
                <input id="email" name="email" type="text" />
            </p>
            <p>
                <label for="password">Password</label>
                <input id="password" name="password" type="password" />
            </p>
            <p>
                <input type="submit" value="Submit" name="submit" class="submit" />
            </p>
            <?php
            if ($this->session->flashdata('message')) {
                echo "<p class='msg'>*" . $this->session->flashdata('message') . '</p>';
            } ?>
            <p id="credits">Cherub Defense Admin Backend .<br />
                <a href="http://www.brands-up.com/">Brands up Developement</a>.</p>
        </form>
    </body>
</html>