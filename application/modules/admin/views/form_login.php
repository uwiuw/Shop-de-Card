<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Cherub Defense Warehouse Admin Backend</title>
        <link rel="stylesheet" type="text/css" href="<?= css_dir() ?>login.css" media="screen" title="bbxcss" />
        <style type="text/css">
        </style>
    </head>
    <body>
        <p style="left:10px; position:absolute; top:10px;"><a href="<?= site_url() ?>">&laquo; Live Site</a></p>
        <form id="start" method="post" action="admin/log_in">
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
                <label for="remember">Remeber This ?</label>
                <input id="remember" name="remember" type="checkbox" />
            </p>
            <p></p>
            <p>
                <input type="submit" value="Submit" name="submit" class="submit" /> &nbsp;&nbsp;&nbsp; <a href="<?php echo site_url('auth/forgotten_password') ?>">
            			Forget Password
                </a>
            </p>
            <div id="finish">
                <p>
			Cherub Admin Backend
                </p>
            </div>
        </form>
        <p id="credits">Cherub Defense Admin Backend .<br />
            <a href="http://bbxdesign.com/2010/03/24/tutoriel-formulaire-css3-sans-image-sans-javascript">Brands up Developement</a>.</p>
    </body>
</html>