<?php

// already defined:
// define("WORDPRESS_DOKUS_USER_FIELD", "dokus_id");



$d_id = $_POST['d_id'];
$w_id = $_POST['w_id'];

$success = add_user_meta( $w_id, WORDPRESS_DOKUS_USER_FIELD, $d_id, true);

if($success) {
    $message = "Mapped User Successfully";
    header($_SERVER['PHP_SELF'] . "?page=dokus&message=" . $message );
} else {
    echo  "Mapping of user failed";
    exit;
}

