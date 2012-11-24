<?php

$not_mapped_users = get_dokus_users_not_in_wp($cache);
$dwp_users = get_dokusWpUsers($cache);

echo "<h2>WordPress Plugin for Dokus.no </h2>";
if (empty($message)) {
    $message = "<p>Her kan du koble sammen en dokus kunde og en wordpress bruker, lage en kunde i dokus basert på en bruker, eller fjerne koblingen mellom de</p>";
}
echo "<h3>" . $message . "</h3>";
echo "<form action='" . $_SERVER['PHP_SELF'] . "?page=dokus&dokus-page=create_dokus_user' method='POST'>";
echo "<input type='hidden' name='w_id' value='ALL' />";
echo "<input type='submit' value='Create user in dokus for all users not in dokus'/></form><br/>";

echo "<table>";
echo "<thead>";
echo "<td>Wordpress User</td><td>Dokus User</td><td>Wordpress Groups</td><td>Dokus Groups</td><td>Remove</td><td>Create</td>";
echo "</thead>";

foreach ($dwp_users as $dwp_user):

    $dokus_id = $dwp_user->get_d_id();
    echo "<tr>";
     echo "<td>" . $dwp_user->get_w_name() . "</td>";

    if (!empty($dokus_id)):
        echo "<td>" . $dwp_user->get_d_name() . "</td>";
        echo "<td>";
        foreach ($dwp_user->get_groups()->get_only_wordpress() as $group):
            echo "<form action='" . $_SERVER['PHP_SELF'] . "?page=dokus&dokus-page=add_group_to_dokus' method='POST'>";
            echo "<input type='hidden' name='group_id' value='" . $group . "'>";
            echo "<input type='hidden' name='d_id' value='" . $dokus_id . "'>";
            echo "<input type='submit' value='Add Group - " . $group . "'></form>";
        endforeach;
        echo "</td>";
        echo "<td>";
        foreach (array_merge($dwp_user->get_groups()->get_only_dokus(), $dwp_user->get_groups()->get_both()) as $group):
            echo "<form action='" . $_SERVER['PHP_SELF'] . "?page=dokus&dokus-page=remove_group_mapping' method='POST'>";
            echo "<input type='hidden' name='d_id' value='" . $dokus_id . "'>";
            echo "<input type='hidden' name='group_id' value='" . $group . "'>";
            echo "<input type='submit' value='Remove Group - " . $group . "'></form>";
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
        echo "<td></td><td></td><td></td>";
        echo "<td><form action='" . $_SERVER['PHP_SELF'] . "?page=dokus&dokus-page=create_dokus_user' method='POST'>";
        echo "<input type='hidden' name='w_id' value='" . $dwp_user->get_w_id() . "' />";
        echo "<input type='submit' value='Create user in dokus'/></form></td>";
        echo "</tr>";
    endif;
endforeach;

echo "</table>";
?>