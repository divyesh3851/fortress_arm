<?php
require '../config.php';

$reminder_time = date('Y-m-d H:i', strtotime(current_time('mysql')));

//$get_advisor_list = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.gender,ad.birth_date,ad.state,ad.iul_mail_reminder,ad.created_by,ad.created_by_type FROM advisor as ad INNER JOIN interest ON ad.id = interest.advisor_id WHERE interest.life_insurance != '' AND ad.advisor_status = 2 AND ad.status = 0 AND ( ad.iul_mail_reminder != '' OR ad.iul_mail_reminder != NULL OR ad.iul_mail_reminder != '0000-00-00 00:00:00') AND iul_mail_reminder < NOW() - INTERVAL 1 HOUR");

$get_advisor_list = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.gender,ad.birth_date,ad.state,ad.created_by,ad.created_by_type,user_interest.id as user_interest_tbl_id, user_interest.interest_id,user_interest.sub_id, user_interest.mail_reminder FROM advisor as ad INNER JOIN user_interest ON ad.id = user_interest.user_id WHERE ad.advisor_status = 2 AND ad.status = 0 AND user_interest.mail_reminder LIKE '" . $reminder_time . "%' AND ( user_interest.mail_reminder != NULL OR user_interest.mail_reminder != '0000-00-00 00:00:00')");

$_SESSION['use_smtp'] = true;
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

    $current_time   = strtotime($advisor_result->mail_reminder);

    if ($advisor_result->interest_id == 4 && $advisor_result->sub_id) {


        if (1 == $advisor_result->sub_id) {

            $current_step = Advisor()->get_advisor_meta($advisor_result->id, 'iul_current_mail_reminder_step');
            $current_step = ($current_step) ? $current_step : 1;

            if ($current_step == 2) {
                $attachment = array();
                $new_time   = strtotime("+1 week", $current_time);
                $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
            } else if ($current_step == 3) {
                $attachment = array(SITE_DIR . '/uploads/email_attachment/IUL - DB Options.pdf');
                $new_time   = strtotime("+1 week", $current_time);
                $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
            } else if ($current_step == 4) {
                $attachment = array();
                $new_time   = strtotime("+1 week", $current_time);
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
                $next_mail_reminder_date = current_time('mysql');
            } else if ($current_step != '' || $current_step == 1) {

                $attachment = array(SITE_DIR . '/uploads/email_attachment/IUL - Accumulation v. Protection.pdf');

                $new_time       = strtotime("+24 hours", $current_time);
                $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
            }

            $subject    = get_option('iul_step_' . $current_step . '_subject');
            $mail_body  = get_option('iul_step_' . $current_step . '_mail_body');

            $mail_body  = replace_merge_fields($mail_body, $merge_fields);

            send_mail($advisor_result->email, $subject, $mail_body, $attachment);
            $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);
            if ($status) {

                Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_iul_step_' . $current_step, 'advisor');

                $wpdb->update("user_interest", array("mail_reminder" => $next_mail_reminder_date), array("id" => $advisor_result->user_interest_tbl_id));

                if ($current_step == 6) { // last step
                    Advisor()->update_advisor_meta($advisor_result->id, 'iul_current_mail_reminder_step', $current_step);
                } else {
                    Advisor()->update_advisor_meta($advisor_result->id, 'iul_current_mail_reminder_step', $current_step + 1);
                }
            }
        }

        if (2 == $advisor_result->sub_id) {

            $current_step = Advisor()->get_advisor_meta($advisor_result->id, 'term_current_mail_reminder_step');
            $current_step = ($current_step) ? $current_step : 1;

            if ($current_step == 2) {
                $attachment = array(SITE_DIR . '/uploads/email_attachment/Term Enhanced Conversion Riders.pdf');
                $new_time   = strtotime("+1 week", $current_time);
                $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
            } else if ($current_step == 3) {
                $attachment = array(SITE_DIR . '/uploads/email_attachment/Non-Med Term.pdf');
                $new_time   = strtotime("+1 week", $current_time);
                $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
            } else if ($current_step == 4) {
                $attachment = array();
                $new_time   = strtotime("+1 week", $current_time);
                $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
            } else if ($current_step == 5) {
                $attachment = array();
                $next_mail_reminder_date = current_time('mysql');
            } else if ($current_step != '' || $current_step == 1) {
                $attachment = array(SITE_DIR . '/uploads/email_attachment/Term with Living Benefits.pdf');
                $new_time   = strtotime("+1 week", $current_time);
                $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
            }

            $subject    = get_option('term_step_' . $current_step . '_subject');
            $mail_body  = get_option('term_step_' . $current_step . '_mail_body');
            $mail_body  = replace_merge_fields($mail_body, $merge_fields);

            send_mail($advisor_result->email, $subject, $mail_body, $attachment);
            $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);
            if ($status) {

                Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_term_step_' . $current_step, 'advisor');

                $wpdb->update("user_interest", array("mail_reminder" => $next_mail_reminder_date), array("id" => $advisor_result->user_interest_tbl_id));

                if ($current_step == 5) { // last step
                    Advisor()->update_advisor_meta($advisor_result->id, 'term_current_mail_reminder_step', $current_step);
                } else {
                    Advisor()->update_advisor_meta($advisor_result->id, 'term_current_mail_reminder_step', $current_step + 1);
                }
            }
        }

        if (3 == $advisor_result->sub_id) {

            $current_step = Advisor()->get_advisor_meta($advisor_result->id, 'wl_current_mail_reminder_step');
            $current_step = ($current_step) ? $current_step : 1;

            $subject    = get_option('wl_step_' . $current_step . '_subject');
            $mail_body  = get_option('wl_step_' . $current_step . '_mail_body');
            $mail_body  = replace_merge_fields($mail_body, $merge_fields);

            if ($current_step == 2) {
                $attachment = array(SITE_DIR . '/uploads/email_attachment/WL - Direct v. Non-Direct Recognition Loans.pdf');
                $new_time   = strtotime("+1 week", $current_time);
                $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);

                send_mail($advisor_result->email, $subject, $mail_body, $attachment);
                $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);

                if ($status) {

                    Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_wl_step_' . $current_step, 'advisor');

                    $wpdb->update("user_interest", array("mail_reminder" => $next_mail_reminder_date), array("id" => $advisor_result->user_interest_tbl_id));

                    Advisor()->update_advisor_meta($advisor_result->id, 'wl_current_mail_reminder_step', $current_step + 1);
                }
            } else if ($current_step == 3) {

                $attachment = array(SITE_DIR . '/uploads/email_attachment/WL - Myth - Flexibility.pdf');
                $new_time   = strtotime("+1 week", $current_time);
                $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);

                send_mail($advisor_result->email, $subject, $mail_body, $attachment);
                $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);

                if ($status) {

                    Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_wl_step_' . $current_step, 'advisor');

                    $wpdb->update("user_interest", array("mail_reminder" => $next_mail_reminder_date), array("id" => $advisor_result->user_interest_tbl_id));

                    Advisor()->update_advisor_meta($advisor_result->id, 'wl_current_mail_reminder_step', $current_step + 1);
                }
            } else if ($current_step == 4) {

                $attachment = array();

                send_mail($advisor_result->email, $subject, $mail_body, $attachment);
                $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);

                if ($status) {

                    Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_wl_step_' . $current_step, 'advisor');

                    $wpdb->update("user_interest", array("mail_reminder" => date('Y-m-d H:i:s', strtotime(current_time('mysql')))), array("id" => $advisor_result->user_interest_tbl_id));

                    Advisor()->update_advisor_meta($advisor_result->id, 'wl_current_mail_reminder_step', $current_step + 1);
                }

                // step 5
                $subject    = get_option('wl_step_5_subject');
                $mail_body  = get_option('wl_step_5_mail_body');

                $mail_body  = replace_merge_fields($mail_body, $merge_fields);

                $attachment = array();

                send_mail($advisor_result->email, $subject, $mail_body, $attachment);
                $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);
                if ($status) {

                    Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_wl_step_5', 'advisor');

                    $wpdb->update("user_interest", array("mail_reminder" => date('Y-m-d H:i:s', strtotime(current_time('mysql')))), array("id" => $advisor_result->user_interest_tbl_id));

                    Advisor()->update_advisor_meta($advisor_result->id, 'wl_current_mail_reminder_step', 5);
                }
            } else if ($current_step != '' || $current_step == 1) {
                $subject    = get_option('wl_step_1_subject');
                $mail_body  = get_option('wl_step_1_mail_body');
                $attachment = array(SITE_DIR . '/uploads/email_attachment/WL - Portfolio Diversifier.pdf');

                $new_time       = strtotime("+1 week", $current_time);
                $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);

                send_mail($advisor_result->email, $subject, $mail_body, $attachment);
                $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);

                if ($status) {

                    Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_wl_step_' . $current_step, 'advisor');

                    $wpdb->update("user_interest", array("mail_reminder" => $next_mail_reminder_date), array("id" => $advisor_result->user_interest_tbl_id));

                    Advisor()->update_advisor_meta($advisor_result->id, 'wl_current_mail_reminder_step', $current_step + 1);
                }
            }
        }

        if (4 == $advisor_result->sub_id) {

            $current_step = Advisor()->get_advisor_meta($advisor_result->id, 'ap_current_mail_reminder_step');
            $current_step = ($current_step) ? $current_step : 1;

            $subject    = get_option('ap_step_' . $current_step . '_subject');
            $mail_body  = get_option('ap_step_' . $current_step . '_mail_body');
            $mail_body  = replace_merge_fields($mail_body, $merge_fields);

            if ($current_step == 2) {
                $attachment = array();
                $new_time   = strtotime("+1 day", $current_time);
                $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);

                send_mail($advisor_result->email, $subject, $mail_body, $attachment);
                $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);

                if ($status) {

                    Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_ap_step_' . $current_step, 'advisor');

                    $wpdb->update("user_interest", array("mail_reminder" => $next_mail_reminder_date), array("id" => $advisor_result->user_interest_tbl_id));

                    Advisor()->update_advisor_meta($advisor_result->id, 'ap_current_mail_reminder_step', 3);
                }
            } else if ($current_step == 3) {
                $attachment = array(SITE_DIR . '/uploads/email_attachment/Adv. Planning Mid-Level and Rank & File Employee Incentives.pdf');
                $new_time   = strtotime("+1 week", $current_time);
                $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);

                send_mail($advisor_result->email, $subject, $mail_body, $attachment);
                $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);

                if ($status) {

                    Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_ap_step_' . $current_step, 'advisor');

                    $wpdb->update("user_interest", array("mail_reminder" => $next_mail_reminder_date), array("id" => $advisor_result->user_interest_tbl_id));

                    Advisor()->update_advisor_meta($advisor_result->id, 'ap_current_mail_reminder_step', 4);
                }
            } else if ($current_step == 4) {
                // step 4  
                $attachment = array(
                    SITE_DIR . '/uploads/email_attachment/Group WL Request for Proposal.pdf',
                    SITE_DIR . '/uploads/email_attachment/Group WL Voluntary Benefit Census form.xlsx'
                );

                send_mail($advisor_result->email, $subject, $mail_body, $attachment);
                $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);

                if ($status) {

                    Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_ap_step_4', 'advisor');
                }



                // step 5  
                $subject    = get_option('ap_step_5_subject');
                $mail_body  = get_option('ap_step_5_mail_body');

                $mail_body  = replace_merge_fields($mail_body, $merge_fields);

                $attachment = array(
                    SITE_DIR . '/uploads/email_attachment/Adv. Planning Buy-Sell v. Key Man.pdf',
                );

                send_mail($advisor_result->email, $subject, $mail_body, $attachment);
                $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);
                if ($status) {

                    Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_ap_step_5', 'advisor');
                }

                // step 6  
                $subject    = get_option('ap_step_6_subject');
                $mail_body  = get_option('ap_step_6_mail_body');

                $mail_body  = replace_merge_fields($mail_body, $merge_fields);

                $attachment = array();

                send_mail($advisor_result->email, $subject, $mail_body, $attachment);
                $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);
                if ($status) {

                    Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_ap_step_6', 'advisor');
                }
                $wpdb->update("user_interest", array("mail_reminder" => date('Y-m-d H:i:s', strtotime(current_time('mysql')))), array("id" => $advisor_result->user_interest_tbl_id));

                Advisor()->update_advisor_meta($advisor_result->id, 'ap_current_mail_reminder_step', 6);
            } else if ($current_step != '' || $current_step == 1) {

                $attachment = array(SITE_DIR . '/uploads/email_attachment/Adv. Planning Elite Employee Incentives.pdf');

                $new_time       = strtotime("+24 hours", $current_time);
                $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);

                send_mail($advisor_result->email, $subject, $mail_body, $attachment);
                $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);
                if ($status) {

                    Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_iul_step_' . $current_step, 'advisor');

                    $wpdb->update("user_interest", array("mail_reminder" => $next_mail_reminder_date), array("id" => $advisor_result->user_interest_tbl_id));

                    Advisor()->update_advisor_meta($advisor_result->id, 'ap_current_mail_reminder_step', 2);
                }
            }
        }
    } else if ($advisor_result->interest_id == 3 && $advisor_result->sub_id) {

        $current_step = Advisor()->get_advisor_meta($advisor_result->id, 'fia_current_mail_reminder_step');
        $current_step = ($current_step) ? $current_step : 1;

        $subject    = get_option('fia_step_' . $current_step . '_subject');
        $mail_body  = get_option('fia_step_' . $current_step . '_mail_body');
        $mail_body  = replace_merge_fields($mail_body, $merge_fields);

        if ($current_step == 2) {
            $attachment = array(SITE_DIR . '/uploads/email_attachment/FIA - Uses Accum., Income, or LTC.pdf');
            $new_time   = strtotime("+1 week", $current_time);
            $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
        } else if ($current_step == 3) {
            $attachment = array(SITE_DIR . '/uploads/email_attachment/FIA - Death Benefit Rider.pdf');
            $new_time   = strtotime("+1 week", $current_time);
            $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
        } else if ($current_step == 4) {
            $attachment = array();
            $new_time   = strtotime("+1 week", $current_time);
            $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
        } else if ($current_step == 5) {
            $attachment = array();
            $next_mail_reminder_date = current_time('mysql');
        } else if ($current_step != '' || $current_step == 1) {

            $attachment = array(SITE_DIR . '/uploads/email_attachment/FIA - Pars, Caps, Spreads.pdf');

            $new_time       = strtotime("+1 week", $current_time);
            $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
        }

        send_mail($advisor_result->email, $subject, $mail_body, $attachment);
        $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);
        if ($status) {

            Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_fia_step_' . $current_step, 'advisor');

            $wpdb->update("user_interest", array("mail_reminder" => $next_mail_reminder_date), array("id" => $advisor_result->user_interest_tbl_id));
            if ($current_step == 5) { // last step
                Advisor()->update_advisor_meta($advisor_result->id, 'fia_current_mail_reminder_step', $current_step);
            } else {
                Advisor()->update_advisor_meta($advisor_result->id, 'fia_current_mail_reminder_step', $current_step + 1);
            }
        }
    } else if ($advisor_result->interest_id == 2 && $advisor_result->sub_id) {

        $current_step = Advisor()->get_advisor_meta($advisor_result->id, 'ltc_current_mail_reminder_step');
        $current_step = ($current_step) ? $current_step : 1;

        $subject    = get_option('ltc_step_' . $current_step . '_subject');
        $mail_body  = get_option('ltc_step_' . $current_step . '_mail_body');
        $mail_body  = replace_merge_fields($mail_body, $merge_fields);

        if ($current_step == 2) {
            $attachment = array();
            $new_time   = strtotime("+1 week", $current_time);
            $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);

            send_mail($advisor_result->email, $subject, $mail_body, $attachment);
            $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);
            if ($status) {

                Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_ltc_step_' . $current_step, 'advisor');

                $wpdb->update("user_interest", array("mail_reminder" => $next_mail_reminder_date), array("id" => $advisor_result->user_interest_tbl_id));

                Advisor()->update_advisor_meta($advisor_result->id, 'ltc_current_mail_reminder_step', $current_step + 1);
            }
        } else if ($current_step == 3) {
            $attachment = array(SITE_DIR . '/uploads/email_attachment/LTC - Using Pre-Tax Dollars.pdf');
            $new_time   = strtotime("+1 week", $current_time);
            $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);

            send_mail($advisor_result->email, $subject, $mail_body, $attachment);
            $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);
            if ($status) {

                Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_ltc_step_' . $current_step, 'advisor');

                $wpdb->update("user_interest", array("mail_reminder" => $next_mail_reminder_date), array("id" => $advisor_result->user_interest_tbl_id));

                Advisor()->update_advisor_meta($advisor_result->id, 'ltc_current_mail_reminder_step', $current_step + 1);
            }
        } else if ($current_step == 4) {

            $attachment = array();

            send_mail($advisor_result->email, $subject, $mail_body, $attachment);
            $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);

            if ($status) {

                Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_ltc_step_4', 'advisor');
            }

            // step 5
            $subject    = get_option('ltc_step_5_subject');
            $mail_body  = get_option('ltc_step_5_mail_body');
            $mail_body  = replace_merge_fields($mail_body, $merge_fields);

            $attachment = array(SITE_DIR . '/uploads/email_attachment/LTC - Partnership-Qualified Program.pdf');

            send_mail($advisor_result->email, $subject, $mail_body, $attachment);
            $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);

            if ($status) {

                Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_ltc_step_5', 'advisor');
            }

            // step 6
            $subject    = get_option('ltc_step_6_subject');
            $mail_body  = get_option('ltc_step_6_mail_body');
            $mail_body  = replace_merge_fields($mail_body, $merge_fields);

            $attachment = array();

            send_mail($advisor_result->email, $subject, $mail_body, $attachment);
            $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);

            if ($status) {

                Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_ltc_step_6', 'advisor');
            }

            $wpdb->update("user_interest", array("mail_reminder" => date('Y-m-d H:i:s', strtotime(current_time('mysql')))), array("id" => $advisor_result->user_interest_tbl_id));

            Advisor()->update_advisor_meta($advisor_result->id, 'ltc_current_mail_reminder_step', 6);
        } else if ($current_step != '' || $current_step == 1) {
            $attachment = array(SITE_DIR . '/uploads/email_attachment/LTC - Product Types.pdf');

            $new_time       = strtotime("+1 week", $current_time);
            $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);

            send_mail($advisor_result->email, $subject, $mail_body, $attachment);
            $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);

            if ($status) {

                Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_ltc_step_' . $current_step, 'advisor');

                $wpdb->update("user_interest", array("mail_reminder" => $next_mail_reminder_date), array("id" => $advisor_result->user_interest_tbl_id));

                Advisor()->update_advisor_meta($advisor_result->id, 'ltc_current_mail_reminder_step', $current_step + 1);
            }
        }
    } else if ($advisor_result->interest_id == 1) {

        $current_step = Advisor()->get_advisor_meta($advisor_result->id, 'ls_current_mail_reminder_step');
        $current_step = ($current_step) ? $current_step : 1;

        $subject    = get_option('ls_step_' . $current_step . '_subject');
        $mail_body  = get_option('ls_step_' . $current_step . '_mail_body');
        $mail_body  = replace_merge_fields($mail_body, $merge_fields);

        if ($current_step == 2) {
            $attachment = array(SITE_DIR . '/uploads/email_attachment/Life Settlement Consumer Brochure.pdf');
            $new_time   = strtotime("+1 week", $current_time);
            $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
        } else if ($current_step == 3) {
            $attachment = array(
                SITE_DIR . '/uploads/email_attachment/Policy Valuation Flyer.pdf',
                SITE_DIR . '/uploads/email_attachment/Life Settlement Consumer Brochure.pdf'
            );
            $new_time   = strtotime("+1 week", $current_time);
            $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
        } else if ($current_step == 4) {

            $attachment = array();
            $next_mail_reminder_date = date('Y-m-d H:i:s', strtotime(current_time('mysql')));
        } else if ($current_step != '' || $current_step == 1) {

            $attachment = array(SITE_DIR . '/uploads/email_attachment/Life Settlement Consumer Brochure.pdf');

            $new_time       = strtotime("+1 week", $current_time);
            $next_mail_reminder_date = date("Y-m-d H:i:s", $new_time);
        }

        send_mail($advisor_result->email, $subject, $mail_body, $attachment);
        $status = send_mail('demo.starline2020@gmail.com', $subject, $mail_body, $attachment);

        if ($status) {

            Admin()->create_mail_log($advisor_result->id, $advisor_result->email, 'advisor_interest_ls_step_' . $current_step, 'advisor');

            $wpdb->update("user_interest", array("mail_reminder" => $next_mail_reminder_date), array("id" => $advisor_result->user_interest_tbl_id));

            if ($current_step == 4) {
                Advisor()->update_advisor_meta($advisor_result->id, 'ls_current_mail_reminder_step', $current_step);
            } else {
                Advisor()->update_advisor_meta($advisor_result->id, 'ls_current_mail_reminder_step', $current_step + 1);
            }
        }
    }
}
unset($_SESSION['use_smtp']);
