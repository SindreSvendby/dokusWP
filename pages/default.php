<?php
/**
 * Created by Sindre Svendby
 * License under common sense and respect.
 */

print_array(get_dokus_users_wp_ids());
$dwp_users = get_dokusWpUsers();

echo "<table>";
echo "<thead>";
echo "<td>Wordpress User</td><td>Dokus User</td><td>Groups</td><td>Remove</td><td>Create</td>";
echo "</thead>";

foreach ($dwp_users as $dwp_user):
    echo "<tr>";
    echo "<td>" . $dwp_user->get_w_name() . "</td>";
    if ($dwp_user->get_d_id()):
        echo "<td>" . $dwp_user->get_d_name() . "</td>";
        echo "<td>";
        foreach ($dwp_user->get_d_groups() as $group):
            echo $group;
        endforeach;
        echo "</td>";
        echo "<td><a href='/options-general.php?page=dokus&remove_mapping_for_dokus_user_for_user=" . $dwp_user->get_w_id() . "'>Remove Mapping</a></td>";
        echo "<td></td>";
    else:
        echo "<td></td><td></td><td></td>";
        echo "<td><a href='/options-general.php?page=dokus&create_dokus_user_based_on_user=" . $dwp_user->get_w_id() . "'>Create new dokus user based on " . $dwp_user->get_w_name() . "</a></td>";
        echo "</tr>";
    endif;
endforeach;

echo "</table>";
?>