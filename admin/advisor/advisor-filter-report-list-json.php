<?php
require '../../config.php';

// Fetch records 
$data = array();

$AND = '';
if (siget('user_type')) {
    $AND = ' AND created_by = ' . siget('fbs_arm_admin_id') . ' AND created_by_type = "admin" ';
}

if (siget('advisor_status')) {
    $AND .= ' AND advisor_status = ' . siget('advisor_status');
}

if (siget('state')) {
    $AND .= ' AND state = "' . urldecode(siget('state')) . '" ';
}

if (siget('gender')) {
    $AND .= ' AND gender = "' . urldecode(siget('gender')) . '" ';
}

if (siget('marital_status')) {
    $AND .= ' AND marital_status = "' . urldecode(siget('marital_status')) . '" ';
}

if (siget('lead_source')) {
    $AND .= ' AND lead_source = "' . urldecode(siget('lead_source')) . '" ';
}

if (siget('lead_owner')) {
    $AND .= ' AND lead_owner = "' . urldecode(siget('lead_owner')) . '" ';
}

if (siget('rating')) {
    $AND .= ' AND rating = "' . urldecode(siget('rating')) . '" ';
}

if (siget('date_range')) {

    $date_range = explode("-", siget('date_range'));

    $start_date = ($date_range[0]) ? date('Y-m-d', strtotime(trim($date_range[0]))) : '';
    $end_date = ($date_range[1]) ? date('Y-m-d', strtotime(trim($date_range[1]))) : '';

    $AND .= ' AND created_at BETWEEN "' . $start_date . '" AND "' . $end_date . '"';
}

$advisor_list   = $wpdb->get_results('SELECT * FROM advisor WHERE status = 0 ' . $AND . ' ORDER BY id DESC');

foreach ($advisor_list as $advisor_result) {

    $profile_img = Advisor()->get_advisor_meta($advisor_result->id, 'profile_img');

    $profile_img = '<!--begin:: Avatar -->
                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                        <a href="' . site_url() . '/admin/advisor/view-advisor/' . $advisor_result->id . '">
                            <div class="symbol-label">
                                <img src="' . SITE_URL . '/uploads/advisor/' . $profile_img . '" alt="' . $advisor_result->first_name . ' ' . $advisor_result->last_name . '" class="w-100">
                            </div>
                        </a>
                    </div>
                    <!--end::Avatar-->';

    if ($advisor_result->is_verified) {
        $verify_icon = ' <i class="bi bi-patch-check-fill text-success"></i>';
    } else {
        $verify_icon = ' <i class="bi bi-patch-exclamation-fill text-danger"></i>';
    }

    $name = '<!--begin::User details-->
            <div class="d-flex flex-column">
                <a href="' . site_url() . '/admin/advisor/view-advisor/' . $advisor_result->id . '" class="text-gray-800        text-hover-primary mb-1">' . ' ' . $advisor_result->first_name  . ' ' . $advisor_result->last_name . $verify_icon . ' </a>
                <span>' . $advisor_result->email . '</span>
            </div>
            <!--begin::User details-->';

    /*
    $advisor_status = '';
    if ($advisor_result->advisor_status == 1) {
        $advisor_status = '<div class="badge py-3 px-4 fs-7 badge-light-success">New</div>';
    } else if ($advisor_result->advisor_status == 2) {
        $advisor_status = '<div class="badge py-3 px-4 fs-7 badge-light-primary">Cold</div>';
    } else if ($advisor_result->advisor_status == 3) {
        $advisor_status = '<div class="badge py-3 px-4 fs-7 badge-light-warning">Warm</div>';
    } else if ($advisor_result->advisor_status == 4) {
        $advisor_status = '<div class="badge py-3 px-4 fs-7 badge-light-info">Hot</div>';
    } else if ($advisor_result->advisor_status == 5) {
        $advisor_status = '<div class="badge py-3 px-4 fs-7 badge-light-dark">FBS Agent</div>';
    }
    */

    $lead_source = ($advisor_result->lead_source) ? Settings()->get_selected_lead_source_data($advisor_result->lead_source)->type : '';

    $rating = Settings()->show_ration_star($advisor_result->rating);

    $get_current_campaign = $wpdb->get_row("SELECT id,campaign_id,is_close FROM campaign_user WHERE user_id = " . $advisor_result->id);

    $data[] = array(
        'record_id'     => $advisor_result->id,
        'name'          => $profile_img . ' ' . $name,
        'email'         => $advisor_result->email,
        'mobile_no'     => $advisor_result->mobile_no,
        'rating'        => $rating,
        'status'        => ($advisor_result->advisor_status) ? intval($advisor_result->advisor_status) : 0,
        'city'          => $advisor_result->city,
        'state'         => $advisor_result->state,
        'lead_source'   => $lead_source,
        'created_at'    => $advisor_result->created_at,
        'campaign_user_tbl_id'  => ($get_current_campaign) ? $get_current_campaign->id : '',
        'campaign_id'       => ($get_current_campaign) ? $get_current_campaign->campaign_id : '',
        'is_close'          => ($get_current_campaign) ? intval($get_current_campaign->is_close) : 0,
        'stop_email'        => $advisor_result->stop_email,
    );
}

echo json_encode($data);
die();