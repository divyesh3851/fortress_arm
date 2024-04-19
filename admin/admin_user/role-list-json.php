<?php
require '../../config.php';

$data = array();

$totalRecords = $wpdb->get_var('SELECT COUNT(*) FROM admin_role');

$totalRecordwithFilter = $wpdb->get_var('SELECT COUNT(*) FROM admin_role');

$role_list   = $wpdb->get_results('SELECT * FROM admin_role');

$i = 1;
foreach ($role_list as $role_result) {

    $all_users = Admin()->get_all_admin_user_list_role_wise($role_result->role_id);

    $role_wise_users = "";
    $count = 1;
    foreach ($all_users as $result) {
        if ($count == 4)
            break;
        $role_wise_users  .= $result->first_name . " " . $result->last_name . ",";
        $count++;
    }

    $role_wise_users = rtrim($role_wise_users, ",");

    $data[] = array(
        'record_id'         => $role_result->role_id,
        'role_name'         => $role_result->role_name,
        'users'             => ($role_wise_users) ? rtrim($role_wise_users, ",") . ' ... <span class="show_role_user cursor-pointer text-primary" id=' . $role_result->role_id . ' data-bs-toggle="modal" data-bs-target="#show_role_user"> Show All </a>' : '',
        'all_page_access'   => $role_result->all_page_access,
        'export_data_access' => ($role_result->export_data_access) ? 'yes' : '',
    );

    $i++;
}
echo json_encode($data);
die();
