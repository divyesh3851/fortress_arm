<?php
require '../../config.php';

$data = array();

$totalRecords = $wpdb->get_var('SELECT COUNT(*) FROM admin WHERE role_id = 1 AND status = 0 ');

$totalRecordwithFilter = $wpdb->get_var('SELECT COUNT(*) FROM admin WHERE role_id = 1 AND status = 0');

$user_list   = $wpdb->get_results('SELECT * FROM admin WHERE role_id = 1 AND status = 0');

$i = 1;
foreach ($user_list as $user_result) {

    $data[] = array(
        'record_id'     => $user_result->id,
        'name'          => $user_result->first_name . ' ' . $user_result->last_name,
        'email'         => $user_result->email,
        'mobile_no'     => $user_result->mobile_no,
    );

    $i++;
}
echo json_encode($data);
die();
