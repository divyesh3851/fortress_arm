<?php
require '../../config.php';

// Fetch records 
$data = array();

$activity_list   = $wpdb->get_results('SELECT * FROM track_log WHERE status = 0 AND logged_id = 1 GROUP BY user_id ORDER BY id DESC');

foreach ($activity_list as $activity_result) {

    $advisor_info = $wpdb->get_row("SELECT id,first_name,middle_name,last_name,email,mobile_no,is_verified FROM advisor WHERE id = " . $activity_result->user_id  . " ORDER BY id DESC");

    $profile_img = Advisor()->get_advisor_meta($activity_result->user_id, 'profile_img');

    $profile_img = '<!--begin:: Avatar -->
                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                        <div class="symbol-label">
                        <img src="' . SITE_URL . '/uploads/advisor/' . $profile_img . '" alt="' . $advisor_info->first_name . ' ' . $advisor_info->last_name . '" class="w-100">
                    </div>
                    </div>
                    <!--end::Avatar-->';

    if ($advisor_info->is_verified) {
        $verify_icon = ' <i class="bi bi-patch-check-fill text-success"></i>';
    } else {
        $verify_icon = ' <i class="bi bi-patch-exclamation-fill text-danger"></i>';
    }

    $name = '<!--begin::User details-->
            <div class="d-flex flex-column">
                <a href="' . site_url() . '/admin/activity/view-activity/' . $activity_result->user_id . '" class="text-gray-800        text-hover-primary mb-1">' . ' ' . $advisor_info->first_name  . ' ' . $advisor_info->last_name . ' ' . $verify_icon . '</a>
                <span>' . $advisor_info->email . '</span>
            </div>
            <!--begin::User details-->';

    $action_date = date("m/d/Y", strtotime($activity_result->action_date));

    $data[] = array(
        'record_id'     => $activity_result->id,
        'user_id'       => $activity_result->user_id,
        'name'          => $profile_img . ' ' . $name,
        'email'         => $advisor_info->email,
        'mobile_no'     => $advisor_info->mobile_no,
        'message'       => ($activity_result->message) ? ucfirst($activity_result->message) : '',
        'action_date'   => $action_date,
        'created_at'    => $activity_result->created_at,
    );
}

echo json_encode($data);
die();
