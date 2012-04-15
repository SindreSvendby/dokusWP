<?php
/**
 * Created by Sindre Svendby
 * License under common sense and respect.
 */


list($users, $w_user_not_in_d, $d_user_not_in_w) = get_list_of_users($dokus);
output_users($users, $w_user_not_in_d, $d_user_not_in_w);
