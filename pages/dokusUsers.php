<?php
/**
 * Created by Sindre Svendby
 * License under common sense and respect.
 */
 
$customerResource = new DokusCustomersResource($dokus);
$users = $customerResource->all();
print_array($users);
?>