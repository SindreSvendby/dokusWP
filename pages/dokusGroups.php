<?php
/**
 * Created by Sindre Svendby
 * License under common sense and respect.
 */

$customerGroups = new DokusCustomerGroupsResource($dokus);
$groups = $customerGroups->all();
print_array($groups);
?>