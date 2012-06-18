<?php
if ($_SERVER['REQUEST_METHOD'] == "POST"):
    setAccountSettings();
    $dokusAccount = getDokusAccountSettings();
    if ($dokusAccount->validDokusAccount()):
        $message = "Settings Updated, valid settings :)";
    else:
        $message = "Settings Updated, but the settings was not correct. Was not able to login at dokus.no";
    endif;
endif;
$dokusAccount = getDokusAccountSettings();
$pageName = "settings";
?>

<h1>Dokus Account Settings</h1>
<?= $message; ?>
<form name="settings" action="<?= DOKUS_ADMIN_URL . "&" . DOKUS_PAGE . "=" . $pageName ?>" method="POST">
    <br/> Email: <input name='email' value="<?= $dokusAccount->email?>" />
    <br/> Password: <input name='password' type='password' value="<?=$dokusAccount->password ?>" />
    <br/> Subdomain:<input name='subdomain' value="<?=$dokusAccount->subdomain ?>" />
    <br/> <input type='submit' value='Update Settings'/>
</form>