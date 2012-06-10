<?php
/**
 * Created by Sindre Svendby
 * License under common sense and respect.
 */

$dwp_users = get_dokusWpUsers();

echo "<table>";
echo "<thead>";
echo "<td>Wordpress User</td><td>Dokus User</td><td>Groups</td><td>Remove</td><td>Create</td>";
echo "</thead>";

foreach($dwp_users as $dwp_user):
    echo "<tr>";
    echo "<td>". $dwp_user->get_w_name() ."</td>";
    echo "<td>". $dwp_user->get_d_name() ."</td>";
    echo "<td>". $dwp_user->get_d_groups() ."</td>";
    echo "<td><a href='/options-general.php?page=dokus&remove_mapping_for_dokus_user_for_user='".$dwp_user->get_w_id().">Remove Mapping</a></td>";
    echo "<td><a href='/options-general.php?page=dokus&create_dokus_user_based_on_user='".$dwp_user->get_w_id().">Create new dokus user based on this</a></td>";
    echo "</tr>";
endforeach;

echo "</table>";
?>