<?php

/**
 * Class For Campaign Manage All Modual
 */

class Campaign
{

    protected static $instance;

    public function __construct()
    {
        add_action('wp_ajax_delete_campaign_user', array($this, 'delete_campaign_user'));
    }

    public function update_user_campaign()
    {
        global $wpdb;

        if (!sipost('campaign_advisor_id') || !sipost('campaign')) {
            return false;
        }

        $current_campaign_type = sipost('campaign');
        $advisor_id = sipost('campaign_advisor_id');

        $campaign_info = array(
            'user_id'   => $advisor_id
        );

        $get_current_campaign_info = $wpdb->get_row("SELECT id, campaign_id, mail_reminder, is_close FROM campaign_user WHERE user_id = " . $advisor_id);

        if ($current_campaign_type == 'close_all') {

            if ($get_current_campaign_info) {
                $wpdb->update(
                    "campaign_user",
                    array(
                        'is_close'  => 1,
                        'updated_at' => current_time('mysql')
                    ),
                    array("id" => $get_current_campaign_info->id, "user_id" => $advisor_id)
                );
            } else {
                $wpdb->insert(
                    "campaign_user",
                    array(
                        'is_close'  => 1,
                        'created_at' => current_time('mysql')
                    )

                );
            }

            return true;
        }

        $one_hour_later = date('Y-m-d H:i:s', strtotime(current_time('mysql') . ' +1 hour')); // Add 1 hour

        if (1 == sipost('campaign')) {
            Advisor()->update_advisor_meta($advisor_id, 'iul_current_mail_reminder_step', 1);
        } else if (2 == sipost('campaign')) {
            Advisor()->update_advisor_meta($advisor_id, 'term_current_mail_reminder_step', 1);
        } else if (3 == sipost('campaign')) {
            Advisor()->update_advisor_meta($advisor_id, 'wl_current_mail_reminder_step', 1);
        } else if (4 == sipost('campaign')) {
            Advisor()->update_advisor_meta($advisor_id, 'ap_current_mail_reminder_step', 1);
        } else if (5 == sipost('campaign')) {
            Advisor()->update_advisor_meta($advisor_id, 'fia_current_mail_reminder_step', 1);
        } else if (6 == sipost('campaign')) {
            Advisor()->update_advisor_meta($advisor_id, 'ltc_current_mail_reminder_step', 1);
        } else if (7 == sipost('campaign')) {
            Advisor()->update_advisor_meta($advisor_id, 'ls_current_mail_reminder_step', 1);
        }

        $campaign_info['campaign_id'] = $current_campaign_type;
        $campaign_info['is_close']    = 0;

        if (!$get_current_campaign_info) {

            $campaign_info['mail_reminder'] = $one_hour_later;
            $campaign_info['created_at']    = current_time('mysql');

            $wpdb->insert('campaign_user', $campaign_info);
            $last_id = $wpdb->insert_id;

            Admin()->create_track_log_activity($last_id, $advisor_id, 'campaign added', 'campaign_add', $campaign_info, $campaign_info, 'campaign has been added');
        } else {

            $wpdb->update(
                "campaign_user",
                array(
                    'updated_at'  => current_time('mysql'),
                ),
                array("user_id" => $advisor_id)
            );

            $wpdb->update("campaign_user", $campaign_info, array("user_id" => $advisor_id));

            Admin()->create_track_log_activity($get_current_campaign_info->id, $advisor_id, 'campaign updated', 'campaign_update', $get_current_campaign_info, $campaign_info, 'campaign has been updated');
        }

        return true;
    }

    public function delete_campaign_user($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return;
        }

        $response = $wpdb->delete("campaign_user", array("id" => $id));

        echo json_encode(array("status" => $response));
        die();
    }

    public function assign_advisor_to_campaign($campaign_id = '')
    {
        global $wpdb;

        if (!$campaign_id || empty(sipost('assign_advisor'))) {
            return;
        }

        $one_hour_later = date('Y-m-d H:i:s', strtotime(current_time('mysql') . ' +1 hour')); // Add 1 hour

        foreach (sipost('assign_advisor') as $advisor_result) {

            $campaign_info = array(
                "user_id"       => $advisor_result,
                "campaign_id"   => $campaign_id,
                "mail_reminder" => $one_hour_later,
                "created_at"    => current_time('mysql'),
            );

            $wpdb->insert("campaign_user", $campaign_info);

            $last_id = $wpdb->insert_id;

            if ($last_id) {
                Admin()->create_track_log_activity($last_id, $advisor_result, 'campaign user added', 'campaign_user_add', $campaign_info, $campaign_info, 'campaign has been added from assign user');
            }
        }
        return true;
    }

    public function get_campaign_recent_users($campaign_id = '')
    {
        global $wpdb;

        $campaign_id = (sipost('campaign_id')) ? sipost('campaign_id') : $campaign_id;

        if (!$campaign_id) {
            return;
        }

        return $wpdb->get_results("SELECT * FROM campaign_user WHERE campaign_id = " . $campaign_id . " AND status = 0 ORDER BY id DESC LIMIT 0,5");
    }

    public function get_campaign_user_total_count($campaign_id = '')
    {
        global $wpdb;

        $campaign_id = (sipost('campaign_id')) ? sipost('campaign_id') : $campaign_id;

        if (!$campaign_id) {
            return;
        }

        return $wpdb->get_var("SELECT COUNT(id) FROM campaign_user WHERE campaign_id = " . $campaign_id);
    }

    public function get_campaign_list()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM campaign ORDER BY id DESC");
    }


    public function get_selected_campaign_info($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        return $wpdb->get_row("SELECT * FROM campaign WHERE id = " . $id);
    }

    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

function Campaign()
{
    return Campaign::get_instance();
}

Campaign();
