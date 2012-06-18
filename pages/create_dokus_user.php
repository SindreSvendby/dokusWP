<?php

// already defined:
// define("WORDPRESS_DOKUS_USER_FIELD", "dokus_id");

$w_id = $_POST['w_id'];

$wordpress_user = get_userdata($w_id);

$newCustomer = array(
    'name' => $wordpress_user->data->user_nicename,
    'email' => $wordpress_user->data->user_email,
    'country' => 1);

$newCustomer = $dokus->customers->save($newCustomer);

$success =  add_user_meta($w_id, WORDPRESS_DOKUS_USER_FIELD, $newCustomer->id, true);

if($success) {
    $message = "User Created Successfully";
    include 'default.php';
} else {
    echo  "User creation problems, check if user was added in dokus...";
    exit;
}


