<?php
if ($_SERVER['REQUEST_METHOD'] == "POST"):
    setAccountSettings();
    $dokusWP = DokusWPFactory::getDokusWP();
endif;
$dokusAccount = getDokusAccountSettings();
print_array($dokusAccount);
$pageName = basename($_SERVER[PHP_SELF]);
?>

<h1>Dokus Account Settings</h1>
<form name="settings" action="<?= DOKUS_ADMIN_URL . "&" . DOKUS_PAGE . "=" . $pageName ?>" method="POST">
    <br/> Email: <input name='email' value="<?= $dokusAccount->email?>" />
    <br/> Password: <input name='password' type='password' value="<?=$dokusAccount->password ?>" />
    <br/> Subdomain:<input name='subdomain' value="<?=$dokusAccount->subdomain ?>" />
    <br/> <input type='submit' value='Update Settings'/>
</form>