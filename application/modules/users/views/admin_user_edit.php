<?php
/* By Haidar Mar'ie
 * Email = coder5@ymail.com
  admin_user_edit */
?>

<form id="user_edit" name="user_edit"  method="POST"  action="#">
    <p><label for="parent" >Username</label><br />
        <input type="text" name="username" value="<?=$user->username?>" />
    </p>
    <p><label for="parent" >Email</label><br />
        <input type="text" name="email" value="<?=$user->email?>" />
    </p>
    <p><label for="parent" >Password</label><br />
        <input type="password" name="password" />
    </p>
    <p><label for="parent" >Retype Password</label><br />
        <input type="password" name="re-password"  />
    </p>
    <input type="hidden" name="id_user" value="<?=$user->id_user?>" />
    <input type="submit" value="Save" />
</form>
