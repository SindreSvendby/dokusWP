<?php

// already defined:
// define("WORDPRESS_DOKUS_USER_FIELD", "dokus_id");

$w_id = $_POST['w_id'];

$success = delete_user_meta($w_id, WORDPRESS_DOKUS_USER_FIELD);

if($success) {
    $message = "Removed Mapping Successfully";
    include 'default.php';
} else {
    echo  "Removal of mapping failed";
    exit;
}
