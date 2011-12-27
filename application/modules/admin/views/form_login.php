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