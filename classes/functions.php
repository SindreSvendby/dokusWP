<?php


function get_dokusWpUsers()
{
    $wordpress_dokus_user_field = dokus_id;
    $wordpress_dokus_group_field = dokus_group_ids;

    $users = get_users();
    $dokusWpUsers = array();
    foreach( $users as  $user):
         $dokus_user_id = get_user_meta($user, $wordpress_dokus_user_field);
         $dokus_groups = get_user_meta($user, $wordpress_dokus_group_field);
         $dokusWpUser = new DokusWPUser();
         $dokusWpUser->set_d_id($dokus_user_id);
         $dokusWpUser->set_d_groups($dokus_groups);
         $dokusWpUser->set_w_name($user->user_nicename);
         $dokusWpUser->set_w_id($user->ID);
         $dokusUser = get_dokus_user($dokus_user_id);
         $dokusWpUser->set_d_name($dokusUser->name);
         $dokusWpUsers[$user->ID] =  $dokusWpUser;
    endforeach;
    return $dokusWpUsers;
}


function get_dokus_user($id) {

    $dokusCustomersResource = new DokusCustomersResource(getDokusService());
    return $dokusCustomersResource->get($id);
}