<?php

define('SHOW_PAGE_SETTINGS', 'settings');
define('ADD_IN_DOKUS', 'Add as dokus user');
define('REMOVE_MAPPING', 'Remove Mapping');
define('ONLY_DOKUS', "Connect dokus user with wordpress user");

define('ADD_IN_DOKUS_GROUP', 'Add as dokus group');
define('REMOVE_MAPPING_GROUP', 'Remove Mapping on group');
define('ONLY_DOKUS_GROUP', "Connect dokus group with wordpress user");
define ('GROUP_NR', 'group_nr');


function output_groups($mapped_groups, $w_group_not_in_d, $d_group_not_in_w)
{
    echo '<div class="group_menu">';
    if (!empty($mapped_groups)):
        echo '<form method="GET" action="' . DOKUS_ADMIN_URL . '">';
        echo '<select name="' . GROUP_NR . '">';
        foreach ($mapped_groups as $wordpress_group_id => $mapped_group):
            echo '<option value="' . $wordpress_group_id . '">' . $mapped_group->wordpress_group["title"] . '</option>';
        endforeach;
        echo '</select>';
        echo '<input type="hidden" name="' . DOKUS_PAGE . '" value="' . SEE_GROUPS . '" >';
        echo '<input type="hidden" name="page" value="dokus" >';
        echo '<input type="submit" value="Show group">';
        echo '</form>';
    endif;
    echo '</div>';

    echo "<h2>Groups mapped</h2>";
    echo '<table>';
    if (empty($mapped_groups)) {
        print '<tr><td>No groups are mapped </td><tr>';
    } else {
        foreach ($mapped_groups as $mapped_group):
            echo '<tr>';
            echo '<form action="' . get_admin_url() . 'options-general.php?page=dokus" method="POST">';
            echo '<input type="hidden" name="' . Dokus::POST_WORDPRESS_ID . '"value="' . $mapped_group->wordpress_group["list_id"] . '">';
            echo '<input type="hidden" name="type" value="' . REMOVE_MAPPING_GROUP . '">';
            print '<td>' . $mapped_group . '</td>';
            echo '<td><input type="submit" value="' . REMOVE_MAPPING_GROUP . '"></td></form>';
            echo '</tr>';
        endforeach;
    }
    echo '</table>';
    list_output_groups_people_list($w_group_not_in_d, "Wordpress groups not in dokus", "title", ADD_IN_DOKUS_GROUP, "list_id");
    list_output_groups($d_group_not_in_w, "Dokus groups not in wordpress", "name", ONLY_DOKUS_GROUP, "id");
}


function output_users($mapped_users, $w_user_not_in_d, $d_user_not_in_w)
{
    echo "<h2>Users mapped</h2>";
    echo '<table>';
    if (empty($mapped_users)) {
        print '<tr><td>no  users is mapped</td><tr>';
    } else {
        foreach ($mapped_users as $user):
            if ($user->wordpress_user->ID == null):
                print_array($user);
            endif;
            echo '<tr>';
            echo '<form action="' . get_admin_url() . 'options-general.php?page=dokus" method="POST">';
            echo '<input type="hidden" name="' . Dokus::POST_WORDPRESS_ID . '"value="' . $user->wordpress_user->ID . '">';
            echo '<input type="hidden" name="type" value="' . REMOVE_MAPPING . '">';
            print '<td>' . $user . '</td>';
            echo '<td><input type="submit" value="Remove mapping"></td></form>';
            echo '</tr>';
        endforeach;
    }
    echo '</table>';
    list_output($w_user_not_in_d, "Wordpress users not in dokus", "display_name", ADD_IN_DOKUS, "ID");
    list_output($d_user_not_in_w, "Dokus users not in wordpress", "name", ONLY_DOKUS, "id");
}

function list_output_groups_people_list($groups, $title, $print_call, $type, $id)
{
    echo "<h2> " . $title . " </h2>";
    if (!empty($groups)) {
    if ($type == ONLY_DOKUS_GROUP) {
        echo "<p>Fyll inn ID'en til wordpress gruppen du vil koble til</p>";
    }
    echo '<table>';


        echo '<tr>';
    echo '<td>id</td>';
    echo '<td>Navn</td>';
    echo '<td></td>';
    echo '</tr>';

    foreach ($groups as $group):
        echo '<tr>';
        echo '';
        echo '<td>' . $group[$id] . '</td>';
        echo '<form action="' . get_admin_url() . 'options-general.php?page=dokus" method="POST">';
        echo '<input type="hidden" name="' . Dokus::POST_WORDPRESS_ID . '"value="' . $group[$id] . '">';
        echo '<input type="hidden" name="type" value="' . $type . '">';
        print '<td>' . $group[$print_call] . '</td>';
        if ($type == ONLY_DOKUS_GROUP) {
            echo '<td><input type="text" name="' . Dokus::POST_DOKUS_ID . '" value="" /></td>';
        }
        echo '<td><input type="submit" value="' . $type . '"></td></form>';
        echo '</tr>';
    endforeach;
    echo '</table>';
    }
}


function list_output_groups($groups, $title, $print_call, $type, $id)
{
    echo "<h2> " . $title . " </h2>";
    if ($type == ONLY_DOKUS_GROUP) {
        echo "<p>Fyll inn ID'en til wordpress gruppen du vil koble til</p>";
    }
    echo '<table>';

    if (!empty($groups))
        echo '<tr>';
    echo '<td>id</td>';
    echo '<td>Navn</td>';
    echo '<td></td>';
    echo '</tr>';

    foreach ($groups as $group):
        echo '<tr>';
        echo '';
        echo '<td>' . $group->$id . '</td>';
        echo '<form action="' . get_admin_url() . 'options-general.php?page=dokus" method="POST">';
        echo '<input type="hidden" name="' . Dokus::POST_WORDPRESS_ID . '"value="' . $group->$id . '">';
        echo '<input type="hidden" name="type" value="' . $type . '">';
        print '<td>' . $group->$print_call . '</td>';
        if ($type == ONLY_DOKUS_GROUP) {
            echo '<td><input type="text" name="' . Dokus::POST_DOKUS_ID . '" value="" /></td>';
        }
        echo '<td><input type="submit" value="' . $type . '"></td></form>';
        echo '</tr>';
    endforeach;
    echo '</table>';
}

function list_output($users, $title, $print_call, $type, $id)
{
    echo "<h2> " . $title . " </h2>";
    if ($type == ONLY_DOKUS) {
        echo "<p>Fyll inn ID'en til wordpress brukeren du vil koble til</p>";
    }
    echo '<table>';

    if (!empty($users))
        echo '<tr>';
    echo '<td>id</td>';
    echo '<td>Navn</td>';
    echo '<td></td>';
    echo '</tr>';

    if ($users != null) {
        foreach ($users as $user):
            echo '<tr>';
            echo '';
            echo '<td>' . $user->$id . '</td>';
            echo '<form action="' . get_admin_url() . 'options-general.php?page=dokus" method="POST">';
            echo '<input type="hidden" name="' . Dokus::POST_WORDPRESS_ID . '"value="' . $user->$id . '">';
            echo '<input type="hidden" name="type" value="' . $type . '">';
            print '<td>' . $user->$print_call . '</td>';
            if ($type == ONLY_DOKUS) {
                echo '<td><input type="text" name="' . Dokus::POST_DOKUS_ID . '" value="" /></td>';
            }
            echo '<td><input type="submit" value="' . $type . '"></td></form>';
            echo '</tr>';
        endforeach;
        echo '</table>';
    }
}

function update_dokus()
{
    $dokus = new Dokus();
    if (!isset($_POST[Dokus::POST_WORDPRESS_ID])):
        throw new Exception("Dokus: POST metod to dokus page, without correct ids.");
    else:
        $type = $_POST["type"];
        if ($type == "missing-user"):
            $user_id = $_POST[Dokus::POST_WORDPRESS_ID];
            $dokus->create_user($user_id);
        elseif ($type == "created-user"):
            $user_id = $_POST[Dokus::POST_WORDPRESS_ID];
            $options = get_option(Dokus::WP_OPTION_KEY);
            $users = $options[Dokus::WP_OPTION_USERS];
            unset($users[$user_id]);
            $options[Dokus::WP_OPTION_USERS] = $users;
            update_option(Dokus::WP_OPTION_KEY, $options);
            return $users;
        elseif ($type == "missing-group"):
            $group_id = $_POST[Dokus::POST_WORDPRESS_ID];
            $dokus->create_group($group_id);
        elseif ($type == "created-group"):
            $group_id = $_POST[Dokus::POST_WORDPRESS_ID];
            $options = get_option(Dokus::WP_OPTION_KEY);
            $groups = $options[Dokus::WP_OPTION_GROUPS];
            unset($groups[$group_id]);
            $options[Dokus::WP_OPTION_USERS] = $groups;
            update_option(Dokus::WP_OPTION_KEY, $options);
            return $groups;
        elseif ($type == ONLY_DOKUS):
            $options = get_option(Dokus::WP_OPTION_KEY);
            $users = $options[Dokus::WP_OPTION_USERS];
            $w_user_id = $_POST[Dokus::POST_WORDPRESS_ID];
            $d_user_id = $_POST[Dokus::POST_DOKUS_ID];
            $users[$d_user_id] = $w_user_id;
            $options[Dokus::WP_OPTION_USERS] = $users;
            update_option(Dokus::WP_OPTION_KEY, $options);
            return $users;
        elseif ($type == REMOVE_MAPPING):
            $options = get_option(Dokus::WP_OPTION_KEY);
            $remove_user_id = $_POST[Dokus::POST_WORDPRESS_ID];
            $users = $options[Dokus::WP_OPTION_USERS];
            unset($users[$remove_user_id]);
            $options[Dokus::WP_OPTION_USERS] = $users;
            update_option(Dokus::WP_OPTION_KEY, $options);
        elseif ($type == ADD_IN_DOKUS_GROUP):
            $options = get_option(Dokus::WP_OPTION_KEY);
            $groups = $options[Dokus::WP_OPTION_GROUPS];
            $w_group_id = $_POST[Dokus::POST_WORDPRESS_ID];
            $dokus->create_group($w_group_id);
            return $groups;
        elseif ($type == REMOVE_MAPPING_GROUP):
            $options = get_option(Dokus::WP_OPTION_KEY);
            $groups = $options[Dokus::WP_OPTION_GROUPS];
            $remove_group_id = $_POST[Dokus::POST_WORDPRESS_ID];
            unset($groups[$remove_group_id]);
            $options[Dokus::WP_OPTION_GROUPS] = $groups;
            update_option(Dokus::WP_OPTION_KEY, $options);
            return $groups;
        else:
            throw new Exception("Dokus: No type defined!");
        endif;
    endif;
    return null;
}
