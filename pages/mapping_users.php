<?php
$users = get_users();
$dokusWpUsers = array();
echo "<table>";
echo "<tr>";
echo "<td>";
echo "Wordpress ID";
echo "</td>";
echo "<td>";
echo "Wordpress Navn";
echo "</td>";
echo "<td>";
echo "Dokus ID";
echo "</td>";
echo "<td>";
echo "Dokus Group ID's";
echo "</td>";
echo "</tr>";
foreach ($users as $user):
    echo "<tr>";

    echo "<td>";
    echo $user->ID;
    echo "</td>";

    echo "<td>";
    echo $user->user_nicename;
    echo "</td>";

    $dokus_user_id = get_user_meta($user->ID, WORDPRESS_DOKUS_USER_FIELD, true);
    echo "<td>";
    echo $dokus_user_id;
    echo "</td>";

    $dokus_group_ids = get_user_meta($user->ID, WORDPRESS_DOKUS_GROUP_FIELD, true);
    echo "<td>";
    echo $dokus_group_ids;
    echo "</td>";
    echo "</tr>";

endforeach;
echo "</table>";