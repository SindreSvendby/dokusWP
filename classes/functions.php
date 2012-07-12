<?php

define("WORDPRESS_DOKUS_USER_FIELD", "dokus_id");
define("WORDPRESS_DOKUS_GROUP_FIELD", "dokus_group_ids");

/**
 * @return array
 */
function get_dokusWpUsers()
{
    $users = get_users();
    $dokusWpUsers = array();
    foreach ($users as $user):
        $dokus_user_id = get_user_meta($user->ID, WORDPRESS_DOKUS_USER_FIELD, true);
        $dokusWpUser = new DokusWPUser();
        $w_groups = get_user_meta($user->ID, WORDPRESS_DOKUS_GROUP_FIELD);
        if (!empty($dokus_user_id)):
            $dokusUser = get_dokus_user($dokus_user_id);
            $dokusWpUser->set_d_name($dokusUser->name);
            $d_groups = get_all_dokus_groups($dokus_user_id);
            $groups = compare_groups($w_groups, $d_groups);
        endif;
        $dokusWpUser->set_groups($groups);
        $dokusWpUser->set_w_name($user->user_nicename);
        $dokusWpUser->set_w_id($user->ID);
        $dokusWpUser->set_d_id($dokus_user_id);
        $dokusWpUsers[$user->ID] = $dokusWpUser;
    endforeach;
    return $dokusWpUsers;
}

/**
 * Compares the groups ids in dokus and in wordpress.
 *
 * @param $w_groups array of ids registered dokus groups in wordpress
 * @param $d_groups array containing the ids the user have in dokus
 * @return Groups
 */
function compare_groups($w_groups, $d_groups)
{
    return new Groups($d_groups, $w_groups);
}

function get_dokus_users_not_in_wp()
{
    $dokus_users = get_dokus_user(null);
    $dokus_ids = get_dokus_ids_in_wordpress();
    $dokus_users_not_in_wp = array();
    foreach ($dokus_users as $dokus_user):
        if (!in_array($dokus_user->id, $dokus_ids)):
            $dokus_users_not_in_wp[] = $dokus_user;
        endif;
    endforeach;
    return $dokus_users_not_in_wp;
}

/**
 * Returns the groups ids of the user id
 * @param $dokus_user_id
 * @return array
 */
function get_all_dokus_groups($dokus_user_id)
{
    $dokus_groups = get_dokus_group(null);
    $ids_of_groups_containing_dokus_user_id = array();
    foreach ($dokus_groups as $dokus_group):
        foreach ($dokus_group->members as $dokus_members):
            if (strval($dokus_members->id) == $dokus_user_id):
                $ids_of_groups_containing_dokus_user_id[] = $dokus_group->id;
            endif;
        endforeach;
    endforeach;
    return $ids_of_groups_containing_dokus_user_id;
}

/**
 * @return array
 */
function get_dokus_ids_in_wordpress()
{
    $users = get_users();
    $ids = array();
    foreach ($users as $user):
        $id = get_user_meta($user->ID, WORDPRESS_DOKUS_USER_FIELD, true);
        if (!empty($id)):
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
function get_dokus_user($id)
{
    return DokusCustomersCache::getCustomer($id);
}

function get_dokus_group($id)
{
    return DokusCustomerGroupCache::getGroup($id);
}
