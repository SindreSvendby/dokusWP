<?php

define("WORDPRESS_DOKUS_USER_FIELD" , "dokus_id");
define("WORDPRESS_DOKUS_GROUP_FIELD",  "dokus_group_ids");

function get_dokusWpUsers()
{
    $users = get_users();
    $dokusWpUsers = array();
    foreach( $users as  $user):
         $dokus_user_id = get_user_meta($user, WORDPRESS_DOKUS_USER_FIELD );
         $dokus_groups = get_user_meta($user, WORDPRESS_DOKUS_GROUP_FIELD);
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


function get_dokus_users_not_in_wp() {
    $dokus_users = get_dokus_user(null);
    $dokus_ids = get_dokus_ids_in_wordpress();
    $dokus_users_not_in_wp = array();
    foreach($dokus_users as $dokus_user):
        if(!in_array($dokus_user->ID, $dokus_ids)):
            $dokus_users_not_in_wp[] = $dokus_user->ID;
        endif;
    endforeach;
    return $dokus_users_not_in_wp;
}

function get_dokus_ids_in_wordpress() {
    $users = get_users();
    $ids = array();
    foreach($users as $user):
        $id = get_user_meta($user->ID, WORDPRESS_DOKUS_USER_FIELD);
        if(!empty($id)):
            $ids[] = $id;
        endif;
    endforeach;
    return $ids;
}

/**
 * Returns a dokus user or a list of dokus users.
 * @param $id
 * @return a Dokus User, or a list of Dokus Users if $id is empty.
 *
 */
function get_dokus_user($id) {

    $dokusCustomersResource = new DokusCustomersResource(getDokusService());
    if (empty($id)) {
        return $dokusCustomersResource->all();
    }
    return $dokusCustomersResource->get($id);
}