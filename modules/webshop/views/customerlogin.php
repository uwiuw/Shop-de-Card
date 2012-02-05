
<?php if (isset($_SESSION['customer_first_name'])) { ?>

    <h2>Enjoy your shopping!</h2>
    <br /><h2><a href="<?= site_url() ?>/webshop/checkout" >Go to check out</a></h2><br />

<?php } else {
 ?>

    <h2>Please Chose Login Option</h2>
    <h3>Returning Customers</h3>
    <p>If you have purchased from Cherub Defense AND have previously created an
        account, please login below</p>
<?php }

if ($this->session->flashdata('message')) { ?>
    <div class='status_box'>";
<?= $this->session->flashdata('message'); ?>
</div>
<?php
}

$udata = array('name' => 'email', 'id' => 'email', 'size' => 30);
$pdata = array('name' => 'password', 'id' => 'password', 'size' => 16);
?>
<form action="<?= site_url() ?>/webshop/login" method="post" name="formlogin" >
    <p><label for='email'>Email Address</label><br/>
        <input type="text" name="email" size="30" id="email" /></p>
    <p><label for='password'>Password</label><br/>
        <input type="password" name="password" size="16" id="password" /></p>
    <p class="forgot_pass"> i forgot my password</p>
    <input type="submit" value="Secure Login" />
</form>

<h3>New Customers</h3>
<p>If this your first purchase from Cherub Defense please click "Continue".</p>

<input type="button" value="Continue" onclick="window.location.href='<?= site_url() ?>/webshop/registration'" name="continue" />


<div id="forget_pass" title="Forget Password">
	<fieldset>
		<label for="email_req">Email</label>
		<input type="text" name="email_req" id="email_req" value="" class="text ui-widget-content ui-corner-all" />
	</fieldset>
</div>


<button id="create-user">Create new user</button>
