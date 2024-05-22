<?php
require '../../config.php';

$data = array();

$get_interest_user_list   = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.mobile_no,ad.gender,ad.birth_date,ad.state,ad.created_by,ad.created_by_type, user_interest.id as user_interest_tbl_id,user_interest.sub_id FROM advisor as ad INNER JOIN user_interest ON ad.id = user_interest.user_id WHERE user_interest.interest_id = " . siget('interest_id') . " AND ad.status = 0 ORDER BY user_interest.id DESC");

$i = 1;
foreach ($get_interest_user_list as $user_result) {

    if (siget('interest_id') == 4) {

        $iul_step = Advisor()->get_advisor_meta($user_result->id, 'iul_current_mail_reminder_step');

        $term_step = Advisor()->get_advisor_meta($user_result->id, 'term_current_mail_reminder_step');

        $wl_step = Advisor()->get_advisor_meta($user_result->id, 'wl_current_mail_reminder_step');

        $ap_step = Advisor()->get_advisor_meta($user_result->id, 'ap_current_mail_reminder_step');

        $current_step = '';
        if ($iul_step) {
            $current_step .= 'IUL : ' . $iul_step . ', ';
        }
        if ($term_step) {
            $current_step .= 'Term : ' . $term_step . ', ';
        }
        if ($wl_step) {
            $current_step .= 'WL : ' . $wl_step . ', ';
        }
        if ($ap_step) {
            $current_step .= 'AP : ' . $ap_step . ', ';
        }
    } else if (siget('interest_id') == 3) {
        $current_step = Advisor()->get_advisor_meta($user_result->id, 'fia_current_mail_reminder_step');
    } else if (siget('interest_id') == 2) {
        $current_step = Advisor()->get_advisor_meta($user_result->id, 'ltc_current_mail_reminder_step');
    } else if (siget('interest_id') == 1) {
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

    $get_current_interest = $wpdb->get_row("SELECT id,interest_id,sub_id,is_close,created_at FROM user_interest WHERE user_id = " . $user_result->id);

    $data[] = array(
        'record_id'     => $user_result->user_interest_tbl_id,
        'advisor_id'    => $user_result->id,
        'name'          => $profile_img . ' ' . $name,
        'email'         => $user_result->email,
        'mobile_no'     => $user_result->mobile_no,
        'current_step'  => $current_step,
        'created_at'    => ($get_current_interest) ? $get_current_interest->created_at : '',
        'user_interest_tbl_id'  => ($get_current_interest) ? $get_current_interest->id : '',
        'interest_id'       => ($get_current_interest) ? $get_current_interest->interest_id : '',
        'interest_sub_id'   => ($get_current_interest) ? $get_current_interest->sub_id : '',
        'is_close'          => ($get_current_interest) ? intval($get_current_interest->is_close) : 0,
    );

    $i++;
}
echo json_encode($data);
die();
