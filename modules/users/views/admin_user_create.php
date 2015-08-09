<?php
/* By Haidar Mar'ie
 * Email = coder5@ymail.com
  admin_user_edit */
?>

<form id="user_create" name="user_create" method="POST" action="#">
    <p><label for="parent" >Username</label><br />
        <input type="text" name="username" />
    </p>
    <p><label for="parent" >Email</label><br />
        <input type="text" name="email" />
    </p>
    <p><label for="parent" >Password</label><br />
        <input type="password" name="password" />
    </p>
    <p><label for="parent" >Retype Password</label><br />
        <input type="password" name="re-password" />
    </p>
    <input type="submit" value="Save" />
</form>
