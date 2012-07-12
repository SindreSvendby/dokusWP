<?php
$group_id = $_POST['group_id'];
$d_id = $_POST['d_id'];

$dokusGroup = $dokus->customerGroups->get((int)$group_id);
$dokus_user = $dokus->customers->get($d_id);
$dokusGroup->members[] = $dokus_user;

$success = $dokus->customerGroups->save($dokusGroup);

if($success) {
    $message = "Added Group to Dokus.no successful";
    include 'default.php';
} else {
    echo  "Adding group to dokus.no failed";
}