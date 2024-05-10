<?php
require '../config.php';

if (!get_option('iul_email_cron')) {
    return;
}

$current_date = date('Y-m-d H:i', strtotime(current_time('mysql')));

$get_advisor_list = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.gender,ad.birth_date,ad.state,ad.mail_reminder,ad.created_by,ad.created_by_type FROM advisor as ad INNER JOIN interest ON ad.id = interest.advisor_id WHERE interest.life_insurance != '' AND ad.advisor_status = 2 AND ad.status = 0 AND ( ad.mail_reminder != '' OR ad.mail_reminder != NULL OR ad.mail_reminder != '0000-00-00 00:00:00') AND DATE(ad.mail_reminder) = CURDATE()");

$step_4_subject = get_option('iul_step_4_subject');

foreach ($get_advisor_list as $advisor_result) {

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

    $step_4_mail_body = get_option('iul_step_4_mail_body');

    $step_4_mail_body  = replace_merge_fields($step_4_mail_body, $merge_fields);

    $_SESSION['use_smtp'] = true;
    //send_mail($advisor_result->email, $step_4_subject, $step_4_mail_body, $attachment);
    $status = send_mail('demo.starline2020@gmail.com', $step_4_subject, $step_4_mail_body);
    if ($status) {

        $current_time = strtotime($advisor_result->mail_reminder);
        $new_time = strtotime("+1 week", $current_time);
        $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);

        Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_iul_step_4', 'advisor');

        $wpdb->update("advisor", array("mail_reminder" => $next_mail_reminder_date), array("id" => $advisor_result->id));
    }
    unset($_SESSION['use_smtp']);
}
