<?php
/* By Haidar Mar'ie
 * Email = coder5@ymail.com
  admin_user */
?>
<h2><?php echo $title; ?></h2>

<p><a href="<?= site_url(); ?>/users/add">Create user</a></p>
<?php
if ($this->session->flashdata('message')) {
    echo "<div class='status_box'>" . $this->session->flashdata('message') . "</div>";
}
if (count($alluser)) {
?>
<a href="<?=site_url()?>/users/delete/" class="del_selected">Delete</a>
    <table id="tablesorter_product" class="tablesorter" border="1" cellspacing="0" cellpadding="3" width="100%">
        <tr>
            <th>&nbsp;</th><th>Username</th><th>Email</th><th>Last Visited</th><th>Activate</th><th>Actions</th>
        </tr>
    <?php foreach ($alluser as $users) {
    ?>
        <tr id="<?= $users->id_user ?>">
            <td><input type="checkbox" name='deleteCB[]' value="<?= $users->id_user; ?>"/></td>
            <td align="center"><?= $users->username; ?></td>
            <td align="center"><?= $users->email; ?></td>
            <td align="center"><?= $users->last_visit; ?></td>
        <?php $active = $users->active == '1' ? 'active' : 'not Active'; ?>
        <td align="center"><a href="<?= site_url() ?>/users/active/<?= $users->id_user; ?>"> <?= $active; ?></a></td>
        <td align="center"><a href="<?= site_url() ?>/users/edit/<?= $users->id_user; ?>" >Edit</a> |
            <a href="<?= site_url() ?>/users/delete/<?= $users->id_user; ?>" class="delete" >Delete<?=$users->id_user?></a> </td>
    </tr>
    <?php } ?>

</table>
<?php } ?>