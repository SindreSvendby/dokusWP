<?php
$d_id = $_POST['d_id'];
$group_id = $_POST['group_id'];

$dokusGroup = $dokus->customerGroups->get((int)$group_id);
$json_group = json_encode($dokusGroup);
foreach($dokusGroup->members as $key => $member):
    if((int)$member->id == (int)$d_id):
        array_splice($dokusGroup->members, $key, 1);
    endif;
endforeach;

$json_group = json_encode($dokusGroup);
$success = $dokus->customerGroups->save($dokusGroup);


if($success) {
    $message = "Removing group from dokus.no successful";
    include 'default.php';
} else {
    echo  "Removing a group from dokus.no failed";
}