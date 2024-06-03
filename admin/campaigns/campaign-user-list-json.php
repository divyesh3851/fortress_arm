<?php
require '../../config.php';

$data = array();

$get_campaign_user_list   = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.mobile_no,ad.gender,ad.birth_date,ad.state,ad.created_by,ad.created_by_type, campaign_user.id as campaign_user_tbl_id FROM advisor as ad INNER JOIN campaign_user ON ad.id = campaign_user.user_id WHERE campaign_user.campaign_id = " . siget('campaign_id') . " AND ad.status = 0 ORDER BY campaign_user.id DESC");

$i = 1;
foreach ($get_campaign_user_list as $user_result) {

    $current_step = '';
    if (siget('campaign_id') == 1) {
        $current_step = Advisor()->get_advisor_meta($user_result->id, 'iul_current_mail_reminder_step');
    } else if (siget('campaign_id') == 2) {
        $current_step = Advisor()->get_advisor_meta($user_result->id, 'term_current_mail_reminder_step');
    } else if (siget('campaign_id') == 3) {
        $current_step = Advisor()->get_advisor_meta($user_result->id, 'wl_current_mail_reminder_step');
    } else if (siget('campaign_id') == 4) {
        $current_step = Advisor()->get_advisor_meta($user_result->id, 'ap_current_mail_reminder_step');
    } else if (siget('campaign_id') == 5) {
        $current_step = Advisor()->get_advisor_meta($user_result->id, 'fia_current_mail_reminder_step');
    } else if (siget('campaign_id') == 6) {
        $current_step = Advisor()->get_advisor_meta($user_result->id, 'ltc_current_mail_reminder_step');
    } else if (siget('campaign_id') == 7) {
        $current_step = Advisor()->get_advisor_meta($user_result->id, 'ls_current_mail_reminder_step');
    }

    $profile_img = Advisor()->get_advisor_meta($user_result->id, 'profile_img');

    $profile_img = '<!--begin:: Avatar -->
                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                        <a href="' . site_url() . '/admin/advisor/view-advisor/' . $user_result->id . '">
                            <div class="symbol-label">
                                <img src="' . SITE_URL . '/uploads/advisor/' . $profile_img . '" alt="' . $user_result->first_name . ' ' . $user_result->last_name . '" class="w-100">
                            </div>
                        </a>
                    </div>
                    <!--end::Avatar-->';

    $name = '<!--begin::User details-->
            <div class="d-flex flex-column">
                <a href="' . site_url() . '/admin/advisor/view-advisor/' . $user_result->id . '" class="text-gray-800        text-hover-primary mb-1">' . ' ' . $user_result->first_name  . ' ' . $user_result->last_name . ' </a>
                <span>' . $user_result->email . '</span>
            </div>
            <!--begin::User details-->';

    $get_current_campaign = $wpdb->get_row("SELECT id,campaign_id,is_close,created_at FROM campaign_user WHERE user_id = " . $user_result->id);

    $data[] = array(
        'record_id'     => $user_result->campaign_user_tbl_id,
        'advisor_id'    => $user_result->id,
        'name'          => $profile_img . ' ' . $name,
        'email'         => $user_result->email,
        'mobile_no'     => $user_result->mobile_no,
        'current_step'  => $current_step,
        'created_at'    => ($get_current_campaign) ? $get_current_campaign->created_at : '',
        'campaign_user_tbl_id'  => ($get_current_campaign) ? $get_current_campaign->id : '',
        'campaign_id'       => ($get_current_campaign) ? $get_current_campaign->campaign_id : '',
        'is_close'          => ($get_current_campaign) ? intval($get_current_campaign->is_close) : 0,
    );

    $i++;
}
echo json_encode($data);
die();
