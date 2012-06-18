<?php
/**
 * Created by Sindre Svendby
 * License under common sense and respect.
 */

$not_mapped_users = get_dokus_users_not_in_wp();
$dwp_users = get_dokusWpUsers();

echo "<h3>" . $message . "</h3>";
echo "<table>";
echo "<thead>";
echo "<td>Wordpress User</td><td>Dokus User</td><td>Groups</td><td>Remove</td><td>Create</td>";
echo "</thead>";


foreach ($dwp_users as $dwp_user):
    $dokus_id = $dwp_user->get_d_id();
    if ($dwp_user->get_w_name() == "Sindre Svendby"):
        $dokus_id = $dwp_user->get_d_id();
    endif;
    echo "<tr>";
    echo "<td>" . $dwp_user->get_w_name() . " D:" . $dokus_id . "</td>";

    if (!empty($dokus_id)):
        echo "<td>" . $dwp_user->get_d_name() . "</td>";
        echo "<td>";
        foreach ($dwp_user->get_d_groups() as $group):
            echo $group;
        endforeach;
        echo "</td>";
        echo "<td><form action='" . $_SERVER['PHP_SELF'] . "?page=dokus&dokus-page=remove_mapping' method='POST'><input type='hidden' name='w_id' value='" . $dwp_user->get_w_id() . "'>";
        echo "<input type='submit' value='Remove Mapping'></form></td>";
        echo "<td></td>";
    else:
        echo "<td>";
        if (!empty($not_mapped_users)):
            echo "<form action='" . $_SERVER['PHP_SELF'] . "?page=dokus&dokus-page=map_user' method='POST'>";
            echo "<select name='d_id'>";
            foreach ($not_mapped_users as $nm_users):
                echo "<option value='" . $nm_users->id . "'>" . $nm_users->name . "</option>";
            endforeach;
            echo "</select>";
            echo "<input type='hidden' name='w_id' value='" . $dwp_user->get_w_id() . "' />";
            echo "<input type='submit' value='Map'></submit>";
            echo "</form>";
        endif;
        echo "</td>";
        echo "<td></td><td></td>";
        echo "<td><form action='" . $_SERVER['PHP_SELF'] . "?page=dokus&dokus-page=create_dokus_user' method='POST'>";
        echo "<input type='hidden' name='w_id' value='" . $dwp_user->get_w_id() . "' />";
        echo "<input type='submit' value='Create new dokus user based on " . $dwp_user->get_w_name() . "'/></form></td>";
        echo "</tr>";
    endif;
endforeach;

echo "</table>";
?>