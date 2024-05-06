<?php
require '../config.php';

// Fetch records 
$data = array();

$advisor_list   = $wpdb->get_results('SELECT * FROM advisor WHERE status = 0 AND created_by = "' . siget('fbs_advisor_id') . '" AND created_by_type = "advisor"  ORDER BY id DESC');

foreach ($advisor_list as $advisor_result) {

    $profile_img = Advisor()->get_advisor_meta($advisor_result->id, 'profile_img');

    $profile_img = '<!--begin:: Avatar -->
                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                        <a href="' . site_url() . '/advisor/view-advisor/' . $advisor_result->id . '">
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
                <a href="' . site_url() . '/advisor/view-advisor/' . $advisor_result->id . '" class="text-gray-800        text-hover-primary mb-1">' . ' ' . $advisor_result->first_name  . ' ' . $advisor_result->last_name . $verify_icon . ' </a>
                <span>' . $advisor_result->email . '</span>
            </div>
            <!--begin::User details-->';

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

    $lead_source = ($advisor_result->lead_source) ? Settings()->get_selected_lead_source_data($advisor_result->lead_source)->type : '';

    $rating = Settings()->show_ration_star($advisor_result->rating);

    $data[] = array(
        'record_id'     => $advisor_result->id,
        'name'          => $profile_img . ' ' . $name,
        'email'         => $advisor_result->email,
        'mobile_no'     => $advisor_result->mobile_no,
        'rating'        => $rating,
        'status'        => $advisor_status,
        'city'          => $advisor_result->city,
        'state'         => $advisor_result->state,
        'lead_source'   => $lead_source,
        'created_at'    => $advisor_result->created_at,
    );
}

echo json_encode($data);
die();
