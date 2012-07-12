<?php

// already defined:
// define("WORDPRESS_DOKUS_USER_FIELD", "dokus_id");
// define("WORDPRESS_DOKUS_GROUP_FIELD", "dokus_group_ids");

$w_id = $_POST['w_id'];

$wordpress_user = get_userdata($w_id);

$newCustomer = array(
    'name' => $wordpress_user->data->user_nicename,
    'email' => $wordpress_user->data->user_email,
    'country' => 1);

$newCustomer = $dokus->customers->save($newCustomer);

$success = add_user_meta($w_id, WORDPRESS_DOKUS_USER_FIELD, $newCustomer->id, true);

$d_groups_ids = get_user_meta($w_id, WORDPRESS_DOKUS_GROUP_FIELD, true);

if (!empty($d_groups)):
    foreach ($d_groups_ids as $d_group_id):
        $dokus_group = $dokus->customerGroups->get($d_group_id);
        $members = $dokus_group['members'];
        $members[] = $newCustomer;
        $dokus->customerGroups->save($dokus_group);
    endforeach;
endif;
if ($success) {
    $message = "User Created Successfully";
    include 'default.php';
} else {
    echo  "User creation problems, check if user was added in dokus...";
}


