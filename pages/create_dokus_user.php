<?php


$w_id = $_POST['w_id'];

if ($w_id == "ALL"):
    $users = get_users();
    $users_not_in_dokus = array();
    foreach ($users as $user):
        $dokus_user_id = get_user_meta($user->ID, WORDPRESS_DOKUS_USER_FIELD, true);
        if (empty($dokus_user_id)):
            $success = create_dokus_user($user->ID, $dokus);
            if (!$success):
                break;
            endif;
        endif;
    endforeach;
else:
    $success = create_dokus_user($w_id, $dokus);
endif;

if ($success) {
    $message = "User Created Successfully";
    include 'default.php';
} else {
    echo  "User creation problems, check if user was added in dokus...";
}


