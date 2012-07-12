<?php
$d_id = $_POST['d_id'];
$group_id = $_POST['group_id'];

$dokusGroup = $dokus->customerGroups->get((int)$group_id);
$members = array();
foreach($dokusGroup->members as $member ):
    $members[$member->id] = $member;
endforeach;

unset($members[$d_id]);

$dokusGroup->members = $members;

$success = $dokus->customerGroups->save($dokusGroup);

if($success) {
    $message = "Removing group from dokus.no successful";
    include 'default.php';
} else {
    echo  "Removing a group from dokus.no failed";
}