<?php
require '../config.php';

if (!get_option('iul_email_cron')) {
    return;
}

$reminder_time = date('Y-m-d H:i', strtotime(current_time('mysql')));

//$get_advisor_list = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.gender,ad.birth_date,ad.state,ad.iul_mail_reminder,ad.created_by,ad.created_by_type FROM advisor as ad INNER JOIN interest ON ad.id = interest.advisor_id WHERE interest.life_insurance != '' AND ad.advisor_status = 2 AND ad.status = 0 AND ( ad.iul_mail_reminder != '' OR ad.iul_mail_reminder != NULL OR ad.iul_mail_reminder != '0000-00-00 00:00:00') AND iul_mail_reminder < NOW() - INTERVAL 1 HOUR");

$get_advisor_list = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.gender,ad.birth_date,ad.state,ad.created_by,ad.created_by_type,interest.id as interest_id, interest.iul_mail_reminder FROM advisor as ad INNER JOIN interest ON ad.id = interest.advisor_id WHERE interest.life_insurance != '' AND FIND_IN_SET('1', interest.life_insurance) AND ad.advisor_status = 2 AND ad.status = 0 AND interest.iul_mail_reminder LIKE '" . $reminder_time . "%' AND ( interest.iul_mail_reminder != '' OR interest.iul_mail_reminder != NULL OR interest.iul_mail_reminder != '0000-00-00 00:00:00')");

$_SESSION['use_smtp'] = true;
foreach ($get_advisor_list as $advisor_result) {

    $current_step = Advisor()->get_advisor_meta($advisor_result->id, 'iul_current_mail_reminder_step');
    $current_step = ($current_step) ? $current_step : 1;

    $iul_email_enable = Advisor()->get_advisor_meta($advisor_result->id, 'iul_step_' . $current_step . '_email_enable');

    if (!$iul_email_enable) {
        continue;
    }

    $subject    = get_option('iul_step_' . $current_step . '_subject');
    $mail_body  = get_option('iul_step_' . $current_step . '_mail_body');

    $birth_date = ($advisor_result->birth_date) ? date("m/d/Y", strtotime($advisor_result->birth_date)) : '';

    $merge_fields = array(
        '{{agent_first_name}}'  => $advisor_result->first_name,
        '{{first_name}}'        => FBS_FIRST_NAME,
        '{{last_name}}'         => FBS_LAST_NAME,
        '{{client_name}}'       => $advisor_result->first_name . ' ' . $advisor_result->last_name,
        '{{client_dob}}'        => $birth_date,
        '{{client_gender}}'     => $advisor_result->gender,
        '{{client_state_resident}}' => $advisor_result->state,
        '{{calendly_link}}'     => '',
        '{{fbs_logo}}'          => '<img src="' . FBS_LOGO . '">',
        '{{phone_no}}'          => '<a href="tel:' . FBS_PHONE_NO . '">' . FBS_PHONE_NO . '</a>',
        '{{email}}'             => FBS_EMAIL
    );

    $mail_body  = replace_merge_fields($mail_body, $merge_fields);

    $current_time   = strtotime($advisor_result->iul_mail_reminder);

    if ($current_step == 2) {
        $attachment = array();
        $new_time       = strtotime("+1 week", $current_time);
        $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
    } else if ($current_step == 3) {
        $attachment = array(SITE_DIR . '/uploads/email_attachment/IUL - DB Options.pdf');
        $new_time       = strtotime("+1 week", $current_time);
        $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
    } else if ($current_step == 4) {
        $new_time       = strtotime("+1 week", $current_time);
        $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
    } else if ($current_step == 5) {
        $attachment = array(
            SITE_DIR . '/uploads/email_attachment/IUL - Policy Loan Types.pdf',
            SITE_DIR . '/uploads/email_attachment/Super Charged 401(k) ROTH Alternative Flyer.pdf'
        );
        $new_time       = strtotime("+1 week", $current_time);
        $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
    } else if ($current_step == 6) {
        $attachment = array();
        $next_mail_reminder_date = '';
    } else if ($current_step != '' || $current_step == 1) {

        $attachment = array(SITE_DIR . '/uploads/email_attachment/IUL - Accumulation v. Protection.pdf');

        $new_time       = strtotime("+24 hours", $current_time);
        $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
    }

    //send_mail($advisor_result->email, $step_1_subject, $step_1_mail_body, $attachment);
    $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);
    if ($status) {

        Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_iul_step_' . $current_step, 'advisor');

        $wpdb->update("interest", array("iul_mail_reminder" => $next_mail_reminder_date), array("id" => $advisor_result->interest_id));

        Advisor()->update_advisor_meta($advisor_result->id, 'iul_current_mail_reminder_step', $current_step + 1);
    }
}
unset($_SESSION['use_smtp']);
