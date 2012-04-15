<?php
/**
 * Created by Sindre Svendby
 * License under common sense and respect.
 */
 
$groupsResource = new DokusCustomerGroupsResource($dokus->dokus_service);
$group_nr = $_GET[GROUP_NR];
if (!empty($group_nr)):
    $groupsResource->get($group_nr);
else:
    $groupsResource->all();
endif;

list($groups, $w_groups_not_in_d, $d_groups_not_in_w) = get_list_of_groups($dokus);
output_groups($groups, $w_groups_not_in_d, $d_groups_not_in_w);

