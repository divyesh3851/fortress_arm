<?php

/**
 * Class For Advisor Login And Manage All Modual
 */

class Advisor
{

    protected static $instance;

    public function __construct()
    {
        add_action('wp_ajax_get_selected_advisor_data', array($this, 'get_selected_advisor_data'));

        add_action('wp_ajax_advisor_delete', array($this, 'advisor_delete'));

        add_action('wp_ajax_get_selected_address_data', array($this, 'get_selected_address_data'));

        add_action('wp_ajax_delete_multiple_selected_advisor', array($this, 'delete_multiple_selected_advisor'));

        add_action('wp_ajax_update_advisor_personal_interest', array($this, 'update_advisor_personal_interest'));

        add_action('wp_ajax_update_advisor_financial_interest', array($this, 'update_advisor_financial_interest'));

        add_action('wp_ajax_update_advisor_business_interest', array($this, 'update_advisor_business_interest'));

        add_action('wp_ajax_check_email_exist', array($this, 'check_email_exist'));

        add_action('wp_ajax_get_selected_note_data', array($this, 'get_selected_note_data'));

        add_action('wp_ajax_send_verification_mail', array($this, 'send_verification_mail'));

        add_action('wp_ajax_delete_note', array($this, 'delete_note'));

        add_action('wp_ajax_get_selected_activity_data', array($this, 'get_selected_activity_data'));

        add_action('wp_ajax_get_selected_advisor_professional_data', array($this, 'get_selected_advisor_professional_data'));

        add_action('wp_ajax_save_bookmark', array($this, 'save_bookmark'));

        add_action('wp_ajax_remove_bookmark', array($this, 'remove_bookmark'));

        add_action('wp_ajax_delete_activity', array($this, 'delete_activity'));
    }

    public function delete_activity($activity_id = '')
    {
        global $wpdb;

        $activity_id = (sipost('activity_id')) ? sipost('activity_id') : $activity_id;

        if (!$activity_id) {
            return false;
        }

        $response = $wpdb->update("activity", array('status' => 1), array("id" => $activity_id));

        echo json_encode(array("status" => $response));
        die();
    }

    public function remove_bookmark($url = '')
    {
        global $wpdb;

        $url = (sipost('url')) ? sipost('url') : $url;

        if (!$url) {
            return;
        }

        if (isset($_SESSION['fbs_advisor_id'])) {
            $user_id = $_SESSION['fbs_advisor_id'];
            $user_type = 'advisor';
        } else if (isset($_SESSION['fbs_arm_admin_id'])) {
            $user_id = $_SESSION['fbs_arm_admin_id'];
            $user_type = 'admin';
        }

        return $wpdb->delete("important_links", array("user_id" => $user_id, "user_type" => $user_type, "url" => $url));
    }

    public function check_bookmark($url = '')
    {
        global $wpdb;

        $url = (sipost('url')) ? sipost('url') : $url;

        if (!$url) {
            return;
        }

        if (isset($_SESSION['fbs_advisor_id'])) {
            $user_id = $_SESSION['fbs_advisor_id'];
            $user_type = 'advisor';
        } else if (isset($_SESSION['fbs_arm_admin_id'])) {
            $user_id = $_SESSION['fbs_arm_admin_id'];
            $user_type = 'admin';
        }

        $bookmark_id = $wpdb->get_var("SELECT id FROM important_links WHERE user_id = " . $user_id . " AND user_type = '" . $user_type . "' AND url = '" . $url . "'");

        return $bookmark_id;
    }

    public function save_bookmark()
    {
        global $wpdb;

        $user_id = '';
        $user_type = '';

        if (isset($_SESSION['fbs_advisor_id'])) {
            $user_id = $_SESSION['fbs_advisor_id'];
            $user_type = 'advisor';
        } else if (isset($_SESSION['fbs_arm_admin_id'])) {
            $user_id = $_SESSION['fbs_arm_admin_id'];
            $user_type = 'admin';
        }

        if (!$user_id || !sipost("url")) {
            return;
        }

        $check_bookmark = $this->check_bookmark(sipost("url"));

        if ($check_bookmark) {
            $status = $wpdb->delete("important_links", array('id' => $check_bookmark));
        } else {
            $status = $wpdb->insert(
                "important_links",
                array(
                    "user_id"   => $user_id,
                    "user_type" => $user_type,
                    "name"      => sipost("name"),
                    "url"       => sipost("url"),
                    "notes"     => sipost("notes"),
                    "created_at" => current_time('mysql')
                )
            );
        }

        echo json_encode(array("status" => $status));
        die();
    }

    public function get_selected_advisor_professional_data($advisor_id = '')
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id) {
            return false;
        }

        $profiessional_info = $wpdb->get_row("SELECT license_no,npn_no,city,state,designation,affiliations,carrier_appointed,carrier_with_business,premium_volume,production_percentages,markets FROM advisor WHERE id = " . $advisor_id);

        if (sipost('is_ajax')) {
            echo json_encode(array("profiessional_info" => $profiessional_info));
            die();
        } else {
            return $profiessional_info;
        }
    }

    public function update_professional_info($advisor_id)
    {
        global $wpdb;

        if (!$advisor_id) {
            return false;
        }

        $carrier_with_business = (!empty(sipost('carrier_with_business'))) ? implode(',', sipost('carrier_with_business')) : '';

        $production_percentages = (!empty(sipost('production_percentages'))) ? implode(',', sipost('production_percentages')) : '';

        $markets = (!empty(sipost('markets'))) ? implode(',', sipost('markets')) : '';

        $profiessional_info = array(
            'license_no'        => sipost('license_no'),
            'npn_no'            => sipost('npn_no'),
            'city'              => sipost('city'),
            'state'             => sipost('state'),
            'designation'       => sipost('designation'),
            'affiliations'      => sipost('affiliations'),
            'carrier_appointed' => sipost('carrier_appointed'),
            'carrier_with_business'     => $carrier_with_business,
            'premium_volume'            => sipost('premium_volume'),
            'production_percentages'    => $production_percentages,
            'markets'                   => $markets,
            'updated_at'                => current_time('mysql'),
        );

        return $wpdb->update("advisor", $profiessional_info, array("id" => $advisor_id));
    }

    public function get_upcoming_activity($id)
    {
        global $wpdb;

        $id = ($id) ? $id : $_SESSION['fbs_arm_admin_id'];

        if (!$id) {
            return false;
        }

        $AND = "";
        if (!IS_ADMIN) {
            $AND = " AND logged_id = " . $id . " AND user_type = 'admin'";
        }

        return $wpdb->get_results("SELECT * FROM activity WHERE activity_date > '" . date('Y-m-d') . "' " . $AND . " ORDER BY activity_date ASC LIMIT 0,5");
    }

    public function get_today_activity($id)
    {
        global $wpdb;

        $id = ($id) ? $id : $_SESSION['fbs_arm_admin_id'];

        if (!$id) {
            return false;
        }

        $AND = "";
        if (!IS_ADMIN) {
            $AND = " AND logged_id = " . $id . " AND user_type = 'admin'";
        }

        return $wpdb->get_results("SELECT * FROM activity WHERE activity_date = '" . date('Y-m-d') . "' AND status = 0 " . $AND);
    }

    public function get_count_total_advisor_by_status($status)
    {
        global $wpdb;

        if (!$status) {
            return false;
        }

        $AND = "";
        if (!IS_ADMIN) {
            $AND = " AND created_by = " . $_SESSION['fbs_arm_admin_id'] . " AND created_by_type = 'admin'";
        }

        return $wpdb->get_var("SELECT COUNT(id) FROM advisor WHERE advisor_status = " . $status . " AND status = 0 " . $AND);
    }

    public function get_advisor_records_between_two_dates($start_date = '', $end_date = '', $advisor_status = array())
    {
        global $wpdb;

        $AND = '';
        if (isset($_SESSION['fbs_advisor_id'])) {
            $AND = ' AND created_by = "' . $_SESSION['fbs_advisor_id'] . '" AND created_by_type = "advisor"';
        } else {
            if (!IS_ADMIN) {
                $AND = ' AND created_by = ' . siget('fbs_arm_admin_id') . ' AND created_by_type = "admin" ';
            }
        }

        if ($start_date && $end_date && $advisor_status) {

            $advisor_status = implode(',', array_map('intval', $advisor_status));

            $advisor_list = $wpdb->get_results("SELECT first_name, last_name, email, mobile_no, city, state, created_at FROM advisor WHERE DATE(created_at) >= '" . $start_date . "' AND DATE(created_at) <= '" . $end_date . "' AND advisor_status IN ($advisor_status) AND status = 0 " . $AND);
        } else if (($start_date || $end_date) && $advisor_status) {

            $start_date = ($start_date) ? $start_date : date('Y-m-d');

            $end_date   = ($end_date) ? $end_date : date('Y-m-d');

            $advisor_status = implode(',', array_map('intval', $advisor_status));

            $advisor_list = $wpdb->get_results("SELECT first_name, last_name, email, mobile_no, city, state, created_at FROM advisor WHERE DATE(created_at) >= '" . $end_date . "' AND DATE(created_at) <= '" . $end_date . "' AND advisor_status IN ($advisor_status) AND status = 0 " . $AND);
        } else if ($start_date && $end_date) {

            $start_date = ($start_date) ? $start_date : date('Y-m-d');

            $end_date   = ($end_date) ? $end_date : date('Y-m-d');

            $advisor_list = $wpdb->get_results("SELECT first_name, last_name, email, mobile_no, city, state, created_at FROM advisor WHERE DATE(created_at) >= '" . $start_date . "' AND DATE(created_at) <= '" . $end_date . "' AND  status = 0 " . $AND);
        } else if ($advisor_status) {

            $advisor_status = implode(',', array_map('intval', $advisor_status));

            $advisor_list = $wpdb->get_results("SELECT first_name, last_name, email, mobile_no, city, state, created_at FROM advisor WHERE advisor_status IN ($advisor_status) AND status = 0 " . $AND);
        } else {
            $advisor_list = $wpdb->get_results("SELECT first_name, last_name, email, mobile_no, city, state, created_at FROM advisor WHERE status = 0 " . $AND);
        }

        return $advisor_list;
    }

    public function profile_completion_percentage($advisor_id)
    {
        global $wpdb;

        $advisor_info = $this->get_selected_advisor_data($advisor_id);

        // Sample user data
        $user_data = array(
            'prefix'            => $advisor_info->prefix,
            'preferred_name'    => $advisor_info->preferred_name,
            'first_name'        => $advisor_info->first_name,
            'last_name'         => $advisor_info->last_name,
            'birth_date'        => $advisor_info->birth_date,
            'gender'            => $advisor_info->gender,
            'advisor_status'    => $advisor_info->advisor_status,
            'city'              => $advisor_info->city,
            'state'             => $advisor_info->state,
            'marital_status'    => $advisor_info->marital_status,
        );

        // Define the required fields for a complete profile
        $requiredFields = array('prefix', 'preferred_name', 'first_name', 'last_name', 'birth_date', 'gender', 'advisor_status', 'city', 'state', 'marital_status'); // Example required fields

        // Calculate profile completion percentage
        $totalFields = count($requiredFields);
        $completedFields = 0;

        foreach ($requiredFields as $field) {
            if (isset($userData[$field]) && !empty($userData[$field])) {
                $completedFields++;
            }
        }

        $profileCompletionPercentage = ($completedFields / $totalFields) * 100;

        // Display the profile completion percentage
        return round($profileCompletionPercentage, 2);
    }

    public function count_total_verified_advisor()
    {
        global $wpdb;

        $AND = '';
        if (!IS_ADMIN) {
            if (isset($_SESSION['fbs_arm_admin_id'])) {
                $AND = ' AND created_by = ' . $_SESSION['fbs_arm_admin_id'];
            } else if (isset($_SESSION['fbs_advisor_id'])) {
                $AND = ' AND created_by = ' . $_SESSION['fbs_advisor_id'];
            }
        }

        return $wpdb->get_var("SELECT COUNT(id) FROM advisor WHERE status = 0 AND is_verified = 1 " . $AND);
    }

    public function count_total_advisor()
    {
        global $wpdb;

        $AND = '';
        if (!IS_ADMIN) {
            if (isset($_SESSION['fbs_arm_admin_id'])) {
                $AND = ' AND created_by = ' . $_SESSION['fbs_arm_admin_id'];
            } else if (isset($_SESSION['fbs_advisor_id'])) {
                $AND = ' AND created_by = ' . $_SESSION['fbs_advisor_id'];
            }
        }

        return $wpdb->get_var("SELECT COUNT(id) FROM advisor WHERE status = 0 " . $AND);
    }

    public function update_address($advisor_id = '')
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id || !sipost('address_id') || !sipost('type') || !sipost('address_label') || !sipost('street_address') || !sipost('city') || !sipost('state')) {
            return false;
        }

        $address_info = array(
            'advisor_id'        => $advisor_id,
            'type'              => sipost('type'),
            'address_label'     => sipost('address_label'),
            'street_address'    => sipost('street_address'),
            'building_name'     => sipost('building_name'),
            'city'              => sipost('city'),
            'state'             => sipost('state'),
            'zipcode'           => sipost('zipcode'),
            'updated_at'        => current_time('mysql')
        );

        if ($_FILES['banner'] && $_FILES['banner']['error'] == 0) {

            $file_name  = $_FILES['banner']['name'];

            $file_tmp   = $_FILES['banner']['tmp_name'];

            $file_type  = $_FILES['banner']['type'];

            $ext        = strtolower(end(explode('.', $file_name)));

            $new_file_name    = time() . rand(111, 999) . "." . $ext;

            if (move_uploaded_file($file_tmp, SITE_DIR . '/uploads/address/' . $new_file_name)) {
                $address_info['banner'] = $new_file_name;
            }
        }

        $wpdb->update("advisor_address", $address_info, array('id' => sipost('address_id')));

        Admin()->create_track_log_activity($advisor_id, sipost('address_id'), 'address updated', 'address_update', $address_info, $address_info, 'address has been updated', 'advisor');

        return true;
    }

    public function add_address($advisor_id = '')
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id || !sipost('type') || !sipost('address_label') || !sipost('street_address') || !sipost('city') || !sipost('state')) {
            return false;
        }

        $check_default = $wpdb->get_row("SELECT id FROM advisor_address WHERE advisor_id = " . $advisor_id . " AND type = " . sipost('type') . " AND default_address = 1");

        if ($check_default) {
            $wpdb->update("advisor_address", array("default_address" => 0), array("id" => $check_default->id));
        }

        $address_info = array(
            'advisor_id'        => $advisor_id,
            'type'              => sipost('type'),
            'address_label'     => sipost('address_label'),
            'street_address'    => sipost('street_address'),
            'building_name'     => sipost('building_name'),
            'city'              => sipost('city'),
            'state'             => sipost('state'),
            'zipcode'           => sipost('zipcode'),
            'default_address'   => 1,
            'created_at'        => current_time('mysql')
        );

        if ($_FILES['banner'] && $_FILES['banner']['error'] == 0) {

            $file_name  = $_FILES['banner']['name'];

            $file_tmp   = $_FILES['banner']['tmp_name'];

            $file_type  = $_FILES['banner']['type'];

            $ext        = strtolower(end(explode('.', $file_name)));

            $new_file_name    = time() . rand(111, 999) . "." . $ext;

            if (move_uploaded_file($file_tmp, SITE_DIR . '/uploads/address/' . $new_file_name)) {
                $address_info['banner'] = $new_file_name;
            }
        }

        $wpdb->insert("advisor_address", $address_info);
        $last_id = $wpdb->insert_id;

        Admin()->create_track_log_activity($advisor_id, $last_id, 'new address add', 'address_add', $address_info, $address_info, 'address has been added', 'advisor');

        return true;
    }

    public function get_advisor_address_list($advisor_id = '')
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id) {
            return false;
        }

        return $wpdb->get_results("SELECT * FROM advisor_address WHERE advisor_id = " . $advisor_id . " AND status = 0");
    }

    public function get_advisor_default_address($advisor_id = '')
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id) {
            return false;
        }

        $address_list = $wpdb->get_results("SELECT * FROM advisor_address WHERE advisor_id = " . $advisor_id . " AND  default_address = 1 AND status = 0");

        $address_array = array();
        if ($address_list) {
            foreach ($address_list as $address_result) {
                if ($address_result->type == 1) {
                    $address_array['resident'] = $address_result;
                } else if ($address_result->type == 2) {
                    $address_array['business'] = $address_result;
                } else if ($address_result->type) {
                    $address_array['other'] = $address_result;
                }
            }
        }

        return $address_array;
    }

    public function send_verification_mail()
    {
        global $wpdb;

        if (!sipost('email') || !sipost('advisor_id')) {
            echo json_encode(array('status' => false));
            die();
        }

        $hash_key = generate_hash();

        $email  = strtolower(sipost('email'));

        $subject = 'Advisor Verification Request';

        $mail_body = 'Please click the link below to fill out the form and complete your profile. <br>';

        $mail_body .= '<a href="' . site_url() . '/advisor-profile/' . $hash_key . '">' . site_url() . '/advisor-profile/' . $hash_key . '</a> <br><br>';

        $mail_body .= 'Regards <br>';
        $mail_body .= 'Fortress Brokerage Solution';

        $_SESSION['use_smtp'] = true;
        if (send_mail($email, $subject, $mail_body)) {

            $wpdb->update("advisor", array("hash_key" => $hash_key, 'send_verification' => 1), array("id" => sipost('advisor_id')));

            Admin()->create_mail_log(sipost("advisor_id"), $email, "advisor_complete_profile", "advisor");

            echo json_encode(array('status' => true, 'msg' => 'Mail sent successfully'));
            die();
        }
        unset($_SESSION['use_smtp']);

        echo json_encode(array('status' => false, 'msg' => 'Mail sent failed.'));
        die();
    }

    public function get_upcoming_birthday_list()
    {
        global $wpdb;

        $AND = '';
        if (isset($_SESSION['fbs_arm_admin_id']) && !IS_ADMIN) {
            $AND = " AND created_by = " . $_SESSION['fbs_arm_admin_id'] . " AND created_by_type = 'admin' ";
        } else if (isset($_SESSION['fbs_advisor_id'])) {
            $AND = " AND created_by = " . $_SESSION['fbs_advisor_id'] . " AND created_by_type = 'advisor' ";
        }

        return $wpdb->get_results("SELECT id, prefix, first_name, last_name, email, mobile_no,birth_date FROM advisor WHERE DATE_FORMAT(birth_date, '%m-%d') BETWEEN DATE_FORMAT(CURDATE(), '%m-%d') 
        AND DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 7 DAY), '%m-%d') AND status = 0 " . $AND . " ORDER BY birth_date ASC");
    }

    public function get_upcoming_anniversary_list()
    {
        global $wpdb;

        $AND = '';
        if (isset($_SESSION['fbs_arm_admin_id']) && !IS_ADMIN) {
            $AND = " AND created_by = " . $_SESSION['fbs_arm_admin_id'] . " AND created_by_type = 'admin' ";
        } else if (isset($_SESSION['fbs_advisor_id'])) {
            $AND = " AND created_by = " . $_SESSION['fbs_advisor_id'] . " AND created_by_type = 'advisor' ";
        }

        return $wpdb->get_results("SELECT id, prefix, first_name, last_name, email, mobile_no,anniversary_date FROM advisor WHERE DATE_FORMAT(anniversary_date, '%m-%d') BETWEEN DATE_FORMAT(CURDATE(), '%m-%d') 
        AND DATE_FORMAT(DATE_ADD(CURDATE(), INTERVAL 7 DAY), '%m-%d') AND status = 0 " . $AND . " ORDER BY anniversary_date ASC");
    }

    public function get_upcoming_birthday_anniversary_list()
    {
        $birthday = $this->get_upcoming_birthday_list();
        $anniversary = $this->get_upcoming_anniversary_list();

        $get_upcoming_birthday_anniversary_list = array_merge($birthday, $anniversary);

        $upcoming_greeting = [];

        foreach ($get_upcoming_birthday_anniversary_list as $item) {
            if (isset($item->anniversary_date)) {
                $upcoming_greeting[] = array(
                    'id'                => $item->id,
                    'prefix'            => $item->prefix,
                    'first_name'        => $item->first_name,
                    'last_name'         => $item->last_name,
                    'email'             => $item->email,
                    'mobile_no'         => $item->mobile_no,
                    'greeting_date'     => $item->anniversary_date,
                    'greeting'          => 'anniversary'
                );
            }
            if (isset($item->birth_date)) {
                $upcoming_greeting[] = array(
                    'id'                => $item->id,
                    'prefix'            => $item->prefix,
                    'first_name'        => $item->first_name,
                    'last_name'         => $item->last_name,
                    'email'             => $item->email,
                    'mobile_no'         => $item->mobile_no,
                    'greeting_date'     => $item->birth_date,
                    'greeting'          => 'birthday'
                );
            }
        }

        usort($upcoming_greeting, function ($a, $b) {
            return strtotime($a['greeting_date']) - strtotime($b['greeting_date']);
        });

        return $upcoming_greeting;
    }

    public function delete_note($note_id = '')
    {
        global $wpdb;

        $note_id = (sipost('note_id')) ? sipost('note_id') : $note_id;

        if (!$note_id) {
            return false;
        }

        return $wpdb->delete("advisor_notes", array("id" => $note_id));
    }

    public function get_selected_note_data($note_id = '')
    {
        global $wpdb;

        $note_id = (sipost('note_id')) ? sipost('note_id') : $note_id;

        if (!$note_id) {
            return false;
        }

        $note_info = $wpdb->get_row("SELECT * FROM advisor_notes WHERE id = " . $note_id);

        if (sipost('is_ajax')) {
            echo json_encode(array("status" => true, "note_info" => $note_info));
            die();
        }
        return $note_info;
    }

    public function check_email_exist($email = '')
    {
        global $wpdb;

        $email = (sipost('email')) ? sipost('email') : $email;

        if (!$email) {
            return false;
        }

        $email = strtolower($email);

        if ($wpdb->get_var("SELECT id FROM advisor WHERE email = '" . $email . "' AND status = 0")) {
            echo json_encode(array("status" => true));
        } else {
            echo json_encode(array("status" => false));
        }
        die();
    }

    public function get_advisor_past_activity($advisor_id)
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id) {
            return false;
        }

        return $wpdb->get_results("SELECT * FROM activity WHERE activity_date < '" . date('Y-m-d') . "' AND user_id = " . $advisor_id . " ORDER BY activity_date DESC LIMIT 0,5");
    }

    public function get_advisor_upcoming_activity($id)
    {
        global $wpdb;

        $id = (sipost('advisor_id')) ? sipost('advisor_id') : $id;

        if (!$id) {
            return false;
        }

        return $wpdb->get_results("SELECT * FROM activity WHERE activity_date >= '" . date('Y-m-d') . "' AND user_id = " . $id . " ORDER BY activity_date ASC LIMIT 0,5");
    }

    public function get_selected_activity_data($activity_id = '')
    {
        global $wpdb;

        $activity_id = (sipost('activity_id')) ? sipost('activity_id') : $activity_id;

        if (!$activity_id) {
            return false;
        }

        $activity_info = $wpdb->get_row("SELECT * FROM activity WHERE id = " . $activity_id);

        if (sipost('is_ajax') == true) {
            if ($activity_info) {
                echo json_encode(array("status" => true, "activity_info" => $activity_info));
            } else {
                echo json_encode(array("status" => false));
            }
        } else {
            return $activity_info;
        }
        die();
    }

    public function update_activity($advisor_id = '')
    {
        global $wpdb;

        if (!sipost('title') || !sipost('date')) {
            return false;
        }

        if (sipost('advisor_id') || $advisor_id) {
            $user_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;
            $user_type = 'advisor';
        } else if (isset($_SESSION['fbs_advisor_id'])) {
            $user_id = $_SESSION['fbs_advisor_id'];
            $user_type = 'advisor';
        } else if (isset($_SESSION['fbs_arm_admin_id'])) {
            $user_id = $_SESSION['fbs_arm_admin_id'];
            $user_type = 'admin';
        }

        $activity_date = (sipost('date')) ? strtotime(str_replace(',', '', sipost('date'))) : '';
        $activity_date = ($activity_date) ? date('Y-m-d', $activity_date) : '';

        $activity_info = array(
            'title'         => sipost('title'),
            'activity_date' => $activity_date,
            'recurring'     => sipost('recurring'),
            'start_time'    => sipost('start_time'),
            'end_time'      => sipost('end_time'),
            'type'          => sipost('type'),
            'location'      => sipost('location'),
            'note'          => sipost('note'),
            'created_at'    => current_time('mysql')
        );

        if ($wpdb->update("activity", $activity_info, array('id' => sipost('activity_id')))) {

            Admin()->create_track_log_activity($user_id, sipost('activity_id'), 'activity update', 'activity_update', $activity_info, '', 'Activity has been updated', $user_type);

            return true;
        }
    }

    public function add_activity($advisor_id = '')
    {
        global $wpdb;

        if (!sipost('title') || !sipost('date')) {
            return false;
        }

        if (sipost('advisor_id') || $advisor_id) {
            $user_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;
            $user_type = 'advisor';
        } else if (isset($_SESSION['fbs_advisor_id'])) {
            $user_id = $_SESSION['fbs_advisor_id'];
            $user_type = 'advisor';
        } else if (isset($_SESSION['fbs_arm_admin_id'])) {
            $user_id = $_SESSION['fbs_arm_admin_id'];
            $user_type = 'admin';
        }

        if (!$user_id) {
            return false;
        }

        $activity_date = (sipost('date')) ? strtotime(str_replace(',', '', sipost('date'))) : '';
        $activity_date = ($activity_date) ? date('Y-m-d', $activity_date) : '';

        $activity_info = array(
            'logged_id'     => ADMIN_USER_ID,
            'user_id'       => $user_id,
            'user_type'     => $user_type,
            'title'         => sipost('title'),
            'activity_date' => $activity_date,
            'recurring'     => sipost('recurring'),
            'start_time'    => sipost('start_time'),
            'end_time'      => sipost('end_time'),
            'type'          => sipost('type'),
            'location'      => sipost('location'),
            'note'          => sipost('note'),
            'created_at'    => current_time('mysql')
        );

        if ($wpdb->insert("activity", $activity_info)) {

            $last_id = $wpdb->insert_id;

            Admin()->create_track_log_activity($user_id, $last_id, 'activity add', 'activity_add', $activity_info, '', 'New Activity Added', 'advisor');

            return true;
        }
    }

    public function update_advisor_business_interest()
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : '';

        if (!$advisor_id) {
            return false;
        }

        $business_interest = (sipost('business_interest')) ? serialize(sipost('business_interest')) : '';

        $business_interest_old = $wpdb->get_var("SELECT business_interest FROM advisor WHERE id = " . $advisor_id);

        $wpdb->update("advisor", array("business_interest" => $business_interest), array("id" => $advisor_id));

        Admin()->create_track_log_activity($advisor_id, $advisor_id, 'business interest update', 'business_interest_update', unserialize($business_interest_old), sipost('business_interest'), 'business interest has been updated', 'advisor');

        echo json_encode(array("status" => true));
        die();
    }

    public function update_advisor_financial_interest()
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : '';

        if (!$advisor_id) {
            return false;
        }

        $financial_interest = (sipost('financial_interest')) ? serialize(sipost('financial_interest')) : '';

        $financial_interest_old = $wpdb->get_var("SELECT financial_interest FROM advisor WHERE id = " . $advisor_id);

        $wpdb->update("advisor", array("financial_interest" => $financial_interest), array("id" => $advisor_id));

        Admin()->create_track_log_activity($advisor_id, $advisor_id, 'financial interest update', 'financial_interest_update', unserialize($financial_interest_old), sipost('financial_interest'), 'financial interest has been updated', 'advisor');

        echo json_encode(array("status" => true));
        die();
    }


    public function update_advisor_personal_interest()
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : '';

        if (!$advisor_id) {
            return false;
        }

        $personal_interest = (sipost('personal_interest')) ? serialize(sipost('personal_interest')) : '';

        $personal_interest_old = $wpdb->get_var("SELECT personal_interest FROM advisor WHERE id = " . $advisor_id);

        $wpdb->update("advisor", array("personal_interest" => $personal_interest), array("id" => sipost('advisor_id')));

        Admin()->create_track_log_activity($advisor_id, $advisor_id, 'personal interest update', 'personal_interest_update', unserialize($personal_interest_old), sipost('personal_interest'), 'personal interest has been updated', 'advisor');

        echo json_encode(array("status" => true));
        die();
    }

    public function delete_multiple_selected_advisor()
    {
        global $wpdb;

        $advisor_ids = (sipost('advisor_ids')) ? sipost('advisor_ids') : '';

        if (empty($advisor_ids)) {
            return false;
        }

        foreach ($advisor_ids as $advisor_result) {
            $wpdb->update("advisor", array("status" => 1), array("id" => $advisor_result));

            Admin()->create_track_log_activity($advisor_result, $advisor_result, 'advisor delete', 'advisor_delete', '', '', 'advisor has been deleted', 'advisor');
        }
        echo json_encode(array("status" => true));
        die();
    }

    public function get_note_list($advisor_id = '')
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        $WHERE = '';
        if ($advisor_id) {
            $WHERE = ' WHERE advisor_id = ' . $advisor_id;
        }

        return $wpdb->get_results("SELECT * FROM advisor_notes " . $WHERE . " ORDER BY id DESC");
    }

    public function update_advisor_note()
    {
        global $wpdb;

        if (!sipost('note_id')) {
            return false;
        }

        $advisor_notes_old = $wpdb->get_row("SELECT label,note FROM advisor_notes WHERE id = " . sipost('note_id'), ARRAY_A);

        if ($wpdb->update("advisor_notes", array("advisor_id" => sipost('advisor_id'), "label" => sipost('label'), "note" => sipost('note'), "updated_at" => current_time('mysql')), array("id" => sipost('note_id')))) {

            Admin()->create_track_log_activity(sipost('advisor_id'), sipost('note_id'), 'note update', 'note_update', $advisor_notes_old, array("advisor_id" => sipost('advisor_id'), "label" => sipost('label'), "note" => sipost('note')), 'note has been updated', 'advisor');

            return true;
        }
    }

    public function add_advisor_note()
    {
        global $wpdb;

        //$check = $wpdb->get_var("SELECT id FROM advisor_notes WHERE advisor_id = " . sipost('advisor_id') . " AND DATE(created_at) = CURDATE()");

        if ($wpdb->insert("advisor_notes", array("advisor_id" => sipost('advisor_id'), "label" => sipost('label'), "note" => sipost('note'), "created_at" => current_time('mysql')))) {

            $last_id = $wpdb->insert_id;

            Admin()->create_track_log_activity(sipost('advisor_id'), $last_id, 'note add', 'note_add', array("advisor_id" => sipost('advisor_id'), "label" => sipost('label')), '', 'note has been added', 'advisor');

            return true;
        }
        return false;
        /*
        if ($check) {
            return $wpdb->update("advisor_notes", array("advisor_id" => sipost('advisor_id'), "label" => sipost('label'), "note" => sipost('note'), "updated_at" => current_time('mysql')), array("id" => $check));
        } else {
            
        }
        */
    }

    public function get_selected_address_data($address_id = '')
    {
        global $wpdb;

        $address_id = (sipost('address_id')) ? sipost('address_id') : $address_id;

        if (!$address_id) {
            return false;
        }

        $address_info = $wpdb->get_row("SELECT * FROM advisor_address WHERE id = " . $address_id);

        if ($address_info) {
            echo json_encode(array("status" => true, "address_info" => $address_info));
        } else {
            echo json_encode(array("status" => false));
        }

        die();
    }

    // no use
    public function update_advisor_business_address($advisor_id)
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id || !sipost('business_address_label') || !sipost('business_street_address') || !sipost('business_city') || !sipost('business_state') || !sipost('business_zipcode')) {
            return false;
        }

        $get_business_address_info = $wpdb->get_row("SELECT business_city,business_state,business_zipcode FROM advisor WHERE id = " . $advisor_id);

        $old_address = array(
            'business_address_label' => $this->get_advisor_meta($advisor_id, 'business_address_label'),
            'business_city' => ($get_business_address_info) ?  $get_business_address_info->business_city : '',
            'business_state' => ($get_business_address_info) ? $get_business_address_info->business_state : '',
            'business_building_name' => $this->get_advisor_meta($advisor_id, 'business_building_name'),
            'business_street_address' => $this->get_advisor_meta($advisor_id, 'business_street_address'),
            'business_zipcode'  => ($get_business_address_info) ? $get_business_address_info->business_zipcode : '',
        );

        $this->update_advisor_meta($advisor_id, 'business_address_label', sipost('business_address_label'));
        $this->update_advisor_meta($advisor_id, 'business_street_address', sipost('business_street_address'));
        $this->update_advisor_meta($advisor_id, 'business_building_name', sipost('business_building_name'));

        if ($wpdb->update("advisor", array('business_city' => sipost('business_city'), 'business_state' => sipost('business_state'), 'business_zipcode' => sipost('business_zipcode'), 'updated_at' => current_time('mysql')), array("id" => $advisor_id))) {

            $new_address = array(
                'business_address_label'    => sipost('business_address_label'),
                'business_city'             => sipost('business_city'),
                'business_state'            => sipost('business_state'),
                'business_building_name'    => sipost('business_building_name'),
                'business_street_address'   => sipost('business_street_address'),
                'business_zipcode'          => sipost('business_zipcode'),
            );

            Admin()->create_track_log_activity($advisor_id, $advisor_id, 'business address update', 'business_address_update', $old_address, $new_address, 'business address has been updated', 'advisor');

            return true;
        }
    }

    // no use
    public function update_advisor_resident_address($advisor_id)
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id || !sipost('resident_address_label') || !sipost('resident_street_address') || !sipost('resident_city') || !sipost('resident_state') || !sipost('resident_zipcode')) {
            return false;
        }

        $get_resident_address_info = $wpdb->get_row("SELECT city,state,zipcode FROM advisor WHERE id = " . $advisor_id);

        $old_address = array(
            'resident_address_label' => $this->get_advisor_meta($advisor_id, 'resident_address_label'),
            'resident_city'          => ($get_resident_address_info) ?  $get_resident_address_info->city : '',
            'resident_state'         => ($get_resident_address_info) ? $get_resident_address_info->state : '',
            'resident_building_name' => $this->get_advisor_meta($advisor_id, 'resident_building_name'),
            'resident_street_address' => $this->get_advisor_meta($advisor_id, 'resident_street_address'),
            'resident_zipcode'                => ($get_resident_address_info) ? $get_resident_address_info->zipcode : '',
        );

        $this->update_advisor_meta($advisor_id, 'resident_address_label', sipost('resident_address_label'));
        $this->update_advisor_meta($advisor_id, 'resident_street_address', sipost('resident_street_address'));
        $this->update_advisor_meta($advisor_id, 'resident_building_name', sipost('resident_building_name'));

        if ($wpdb->update("advisor", array('city' => sipost('resident_city'), 'state' => sipost('resident_state'), 'zipcode' => sipost('resident_zipcode'), 'updated_at' => current_time('mysql')), array("id" => $advisor_id))) {

            $new_address = array(
                'resident_address_label'    => sipost('resident_address_label'),
                'resident_city'             => sipost('resident_city'),
                'resident_state'            => sipost('resident_state'),
                'resident_building_name'    => sipost('resident_building_name'),
                'resident_street_address'   => sipost('resident_street_address'),
                'resident_zipcode'          => sipost('resident_zipcode'),
            );

            Admin()->create_track_log_activity($advisor_id, $advisor_id, 'resident address update', 'resident_address_update', $old_address, $new_address, 'resident address has been updated', 'advisor');

            return true;
        }
    }

    public function update_advisor_profile($advisor_id)
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id || !sipost('first_name') || !sipost('last_name') || !sipost('email')) {
            return false;
        }

        $email = trim(strtolower(sipost('email')));

        $check_advisor = $wpdb->get_row("SELECT id FROM advisor WHERE id != " . $advisor_id . " AND ( LOWER(email) = '" . $email . "' ) AND status = 0 ");

        if ($check_advisor) {
            return "duplicate";
        }

        $birth_date = (sipost('birth_date')) ? strtotime(str_replace(',', '', sipost('birth_date'))) : '';
        $birth_date = ($birth_date) ? date('Y-m-d', $birth_date) : '';

        $anniversary_date = (sipost('anniversary_date')) ? strtotime(str_replace(',', '', sipost('anniversary_date'))) : '';
        $anniversary_date = ($anniversary_date) ? date('Y-m-d', $anniversary_date) : '';

        $advisor_profile = array(
            'first_name'    => sipost('first_name'),
            'last_name'     => sipost('last_name'),
            'email'         => sipost('email'),
            'mobile_no'     => sipost('mobile_no'),
            'birth_date'    => $birth_date,
            'gender'        => sipost('gender'),
            'marital_status'    => sipost('marital_status'),
            'anniversary_date'  => $anniversary_date,
            'updated_at'        => current_time('mysql')
        );

        $advisor_old_info = $wpdb->get_row("SELECT id,first_name,last_name,email,mobile_no,birth_date,gender,marital_status,anniversary_date FROM advisor WHERE id = " . $advisor_id);

        $old_advisor_profile = array(
            'first_name'    => $advisor_old_info->first_name,
            'last_name'     => $advisor_old_info->last_name,
            'email'         => $advisor_old_info->email,
            'mobile_no'     => $advisor_old_info->mobile_no,
            'birth_date'    => $advisor_old_info->birth_date,
            'gender'        => $advisor_old_info->gender,
            'marital_status'    => $advisor_old_info->marital_status,
            'anniversary_date'  => $advisor_old_info->anniversary_date,
        );

        if ($wpdb->update("advisor", $advisor_profile, array("id" => $advisor_id))) {

            Admin()->create_track_log_activity($advisor_id, $advisor_id, 'advisor profile update', 'advisor_profile_update', $old_advisor_profile, $advisor_profile, 'advisor profile has been updated', 'advisor');

            return true;
        }
    }

    public function get_selected_advisor_interest($advisor_id)
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id) {
            return false;
        }

        return $wpdb->get_row("SELECT * FROM interest WHERE advisor_id = " . $advisor_id);
    }

    public function update_interest($advisor_id)
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id) {
            return false;
        }

        $check_interest = $wpdb->get_row("SELECT * FROM interest WHERE advisor_id = " . $advisor_id);

        $life_insurance     = (sipost('life_insurance')) ? implode(',', sipost('life_insurance')) : '';
        $annuities          = (sipost('annuities')) ? implode(',', sipost('annuities')) : '';
        $long_term_care_insurance = (sipost('long_term_care_insurance')) ? implode(',', sipost('long_term_care_insurance')) : '';
        $critical_illness   = (sipost('critical_illness')) ? implode(',', sipost('critical_illness')) : '';

        $interest_info = array(
            'advisor_id'        => $advisor_id,
            'life_insurance'    => $life_insurance,
            'annuities'         => $annuities,
            'long_term_care_insurance' => $long_term_care_insurance,
            'critical_illness'  => $critical_illness,
            'disability_income' => sipost('disability_income'),
            'group_insurance'   => sipost('group_insurance'),
        );

        if ($check_interest) {

            $old_interest_info = array(
                'advisor_id'        => $check_interest->advisor_id,
                'life_insurance'    => $check_interest->life_insurance,
                'annuities'         => $check_interest->annuities,
                'long_term_care_insurance' => $check_interest->long_term_care_insurance,
                'critical_illness'  => $check_interest->critical_illness,
                'disability_income' => $check_interest->disability_income,
                'group_insurance'   => $check_interest->group_insurance,
            );

            $interest_info['updated_at'] = current_time('mysql');

            if ($wpdb->update("interest", $interest_info, array("id" => $check_interest->id))) {

                Admin()->create_track_log_activity($advisor_id, $check_interest->id, 'interest update', 'update_interest', $old_interest_info, $interest_info, 'interest has been updated', 'advisor');

                return true;
            }
        } else {
            $interest_info['created_at'] = current_time('mysql');
            if ($wpdb->insert("interest", $interest_info)) {
                $last_id = $wpdb->insert_id;
                Admin()->create_track_log_activity($advisor_id, $last_id, 'interest add', 'interest_add', $interest_info, '', 'interest has been added', 'advisor');

                return true;
            }
        }
    }

    public function add_advisor_employment($advisor_id)
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id) {
            return false;
        }

        if (!sipost('emp_status') || !sipost('emp_company_name') || !sipost('emp_start_date') || !sipost('emp_end_date') || !sipost('emp_company_address') || !sipost('emp_city') || !sipost('emp_state') || !sipost('emp_zipcode')) {
            return false;
        }

        $start_date = (sipost('emp_start_date')) ? strtotime(str_replace(',', '', sipost('emp_start_date'))) : '';
        $start_date = ($start_date) ? date('Y-m-d', $start_date) : '';

        $end_date = (sipost('emp_end_date')) ? strtotime(str_replace(',', '', sipost('emp_end_date'))) : '';
        $end_date = ($end_date) ? date('Y-m-d', $end_date) : '';

        $assistant_info = array();
        if (sipost('emp_assistant_name') || sipost('emp_assistant_phone') || sipost('emp_assistant_email')) {
            $assistant_info = array(
                'name'      => (sipost('emp_assistant_name')) ? sipost('emp_assistant_name') : '',
                'phone'     => (sipost('emp_assistant_phone')) ? sipost('emp_assistant_phone') : '',
                'email'     => (sipost('emp_assistant_email')) ? sipost('emp_assistant_email') : '',
            );
        }

        $employment_info = array(
            'advisor_id'        => $advisor_id,
            'employe_status'    => sipost('emp_status'),
            'company_name'      => ucwords(sipost('emp_company_name')),
            'start_date'        => $start_date,
            'end_date'          => $end_date,
            'company_address'   => sipost('emp_company_address'),
            'building'          => sipost('emp_building'),
            'city'              => sipost('emp_city'),
            'state'             => sipost('emp_state'),
            'zipcode'           => sipost('emp_zipcode'),
            'ria'               => sipost('ria'),
            'bd'                => sipost('bd'),
            'ga'                => sipost('ga'),
            'mga'               => sipost('mga'),
            'ppga'              => sipost('ppga'),
            'office_support'    => sipost('office_support'),
            'assistant_contact' => ($assistant_info) ? maybe_serialize($assistant_info) : '',
            'created_at'        => current_time('mysql')
        );

        if ($wpdb->insert("employment", $employment_info)) {

            $last_id = $wpdb->insert_id;

            Admin()->create_track_log_activity($advisor_id, $last_id, 'employment add', 'employment_add', $employment_info, '', 'employment has been added', 'advisor');

            return true;
        }
    }

    public function get_advisor_last_employment($advisor_id)
    {

        global $wpdb;

        if (!$advisor_id) {
            return;
        }

        return $wpdb->get_row("SELECT * FROM employment WHERE advisor_id = " . $advisor_id . " ORDER BY id DESC LIMIT 0, 1");
    }

    public function get_advisor_employment_history($advisor_id)
    {

        global $wpdb;

        if (!$advisor_id) {
            return;
        }

        return $wpdb->get_results("SELECT * FROM employment WHERE advisor_id = " . $advisor_id);
    }

    public function get_advisor_extra_contact($advisor_id)
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id) {
            return false;
        }

        return $wpdb->get_results("SELECT * FROM advisor_extra_contact WHERE advisor_id = " . $advisor_id);
    }

    public function advisor_delete($advisor_id)
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id) {
            return false;
        }

        if ($wpdb->update("advisor", array("status" => 1), array("id" => $advisor_id))) {

            Admin()->create_track_log_activity($advisor_id, $advisor_id, 'advisor delete', 'advisor_delete', '', '', 'advisor has been deleted', 'advisor');
        }
    }

    public function get_selected_advisor_data($advisor_id = '')
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id) {
            return false;
        }

        $advisor_info = $wpdb->get_row("SELECT * FROM advisor WHERE id = " . $advisor_id);

        if (sipost('is_ajax')) {

            $advisor_metas = array(
                'profile_img' => $this->get_advisor_meta($advisor_id, 'profile_img'),
                'note' => $this->get_advisor_meta($advisor_id, 'note'),
            );

            echo json_encode(
                array(
                    "advisor_info" => $advisor_info,
                    "advisor_meta" => $advisor_metas
                )
            );
            die();
        } else {
            return $advisor_info;
        }
    }

    public function update_advisor($advisor_id = '')
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id || !sipost("preferred_name") || !sipost('first_name') || !sipost('last_name') || !sipost('email')) {
            return false;
        }

        $email = trim(strtolower(sipost('email')));

        $preferred_name = trim(ucwords(sipost("preferred_name")));

        $check_advisor = $wpdb->get_row("SELECT id FROM advisor WHERE id != " . $advisor_id . " AND ( LOWER(email) = '" . $email . "' ) AND status = 0 ");

        if ($check_advisor) {
            return "duplicate";
        }

        $birth_date = (sipost('birth_date')) ? strtotime(str_replace(',', '', sipost('birth_date'))) : '';
        $birth_date = ($birth_date) ? date('Y-m-d', $birth_date) : '';

        $anniversary_date = (sipost('anniversary_date')) ? strtotime(str_replace(',', '', sipost('anniversary_date'))) : '';
        $anniversary_date = ($anniversary_date) ? date('Y-m-d', $anniversary_date) : '';

        $middle_name = (sipost('middle_name') && !sipost('no_middle_name')) ? ucwords((sipost('middle_name'))) : '';

        $licenses_type = (!empty(sipost('licenses_type'))) ? implode(',', sipost('licenses_type')) : '';

        $carrier_with_business = (!empty(sipost('carrier_with_business'))) ? implode(',', sipost('carrier_with_business')) : '';

        $production_percentages = (!empty(sipost('production_percentages'))) ? implode(',', sipost('production_percentages')) : '';

        $markets = (!empty(sipost('markets'))) ? implode(',', sipost('markets')) : '';

        $advisor_info = array(
            "prefix"            => sipost("prefix"),
            "preferred_name"    => $preferred_name,
            "license_no"        => sipost("license_no"),
            "npn_no"            => sipost("npn_no"),
            "first_name"        => ucwords(sipost("first_name")),
            "middle_name"       => $middle_name,
            "last_name"         => ucwords(sipost("last_name")),
            "gender"            => sipost("gender"),
            "contact_type"      => (sipost("contact_type")) ? sipost("contact_type") : 'Mobile',
            "email"             => $email,
            "mobile_no"         => sipost("mobile_no"),
            "company_name"      => sipost("company_name"),
            "city"              => sipost("city"),
            "state"             => sipost("state"),
            "birth_date"        => $birth_date,
            "advisor_status"    => sipost("advisor_status"),
            "designation"       => sipost("designation"),
            "licenses_type"     => $licenses_type,
            "marital_status"    => sipost("marital_status"),
            "lead_source"       => sipost("lead_source"),
            "affiliations"      => sipost("affiliations"),
            "carrier_appointed"     => sipost("carrier_appointed"),
            "carrier_with_business" => $carrier_with_business,
            "premium_volume"        => sipost("premium_volume"),
            "production_percentages" => $production_percentages,
            "markets"           => $markets,
            "lead_owner"        => sipost('lead_owner'),
            "rating"            => sipost('rating'),
            "anniversary_date"  => $anniversary_date,
            "updated_at"        => current_time('mysql')
        );

        $old_advisor_data = $wpdb->get_row("SELECT * FROM advisor WHERE id = " . $advisor_id . " AND status = 0 ", ARRAY_A);
        $old_advisor_data['advisor_meta'] = $this->get_advisor_meta($advisor_id);

        $wpdb->update("advisor", $advisor_info, array("id" => $advisor_id));

        if (!empty(sipost('contact_info_row_list'))) {

            $all_contact_ids = $wpdb->get_results($wpdb->prepare("SELECT id FROM advisor_extra_contact WHERE advisor_id = %d", $advisor_id));

            $old_ids = array();
            foreach ($all_contact_ids as $contact_result) {
                $old_ids[] = $contact_result->id;
            }

            $need_to_delete = array();

            $i = 0;
            foreach ($_POST['contact_info_row_list'] as $row_no) {

                if (!sipost("contact_type_" . $row_no) && (!sipost("mobile_no_" . $row_no) || !sipost("email_" . $row_no))) {
                    continue;
                }

                $advisor_contact = array(
                    "advisor_id"    => $advisor_id,
                    "contact_type"  => sipost("contact_type_" . $row_no),
                    "mobile_no"     => sipost("mobile_no_" . $row_no),
                    "email"         => $email,
                );

                if (sipost("contact_id_"  . $row_no)) {

                    if (in_array(sipost("contact_id_"  . $row_no), $old_ids)) {

                        $email = trim(strtolower(sipost("email_" . $row_no)));

                        //$wpdb->update("advisor_extra_contact", $advisor_contact, array("id" => sipost("contact_id_"  . $row_no)));

                        $need_to_delete[] = sipost("contact_id_"  . $row_no);
                    }
                } else {
                    $check_contact = $wpdb->get_var("SELECT id FROM advisor_extra_contact WHERE contact_type = '" . sipost("contact_type_" . $row_no) . "' AND ( mobile_no = '" . sipost("mobile_no_" . $row_no) . "' || email = '" . $email . "')");

                    if (!$check_contact) {
                        //$wpdb->insert("advisor_extra_contact", $advisor_contact);
                    }
                }

                $i++;
            }

            $remove_ids = array_diff($old_ids, $need_to_delete);

            foreach ($remove_ids as $delete_id) {
                $wpdb->delete("advisor_extra_contact", array('id' => $delete_id));
            }
        } else {
            $wpdb->delete("advisor_extra_contact", array('advisor_id' => $advisor_id));
        }

        $this->update_advisor_meta($advisor_id, 'lead_owner', sipost('lead_owner'));

        $this->update_advisor_meta($advisor_id, 'no_middle_name', sipost('no_middle_name'));

        $this->update_advisor_meta($advisor_id, 'spouses_name', sipost('spouses_name'));

        $spouses_birthdate = (sipost('spouses_birthdate')) ? strtotime(str_replace(',', '', sipost('spouses_birthdate'))) : '';
        $spouses_birthdate = ($spouses_birthdate) ? date('Y-m-d', $spouses_birthdate) : '';

        $this->update_advisor_meta($advisor_id, 'spouses_birthdate', $spouses_birthdate);

        $this->update_advisor_meta($advisor_id, 'total_children', sipost('total_children'));

        $this->update_advisor_meta($advisor_id, 'instagram_url', sipost('instagram_url'));

        $this->update_advisor_meta($advisor_id, 'facebook_url', sipost('facebook_url'));

        $this->update_advisor_meta($advisor_id, 'linkedin_url', sipost('linkedin_url'));

        $this->update_advisor_meta($advisor_id, 'youtube_url', sipost('youtube_url'));

        $this->update_advisor_meta($advisor_id, 'twitter_url', sipost('twitter_url'));

        $this->update_advisor_meta($advisor_id, 'organization', sipost('organization'));

        $this->update_advisor_meta($advisor_id, 'note', sipost('note'));

        /**** Save Employement ****/
        if (sipost('emp_status') || sipost('emp_company_name') || sipost('emp_start_date') || sipost('emp_end_date') || sipost('emp_company_address') || sipost('emp_city') || sipost('emp_state') || sipost('emp_zipcode')) {

            $start_date = (sipost('emp_start_date')) ? strtotime(str_replace(',', '', sipost('emp_start_date'))) : '';
            $start_date = ($start_date) ? date('Y-m-d', $start_date) : '';

            $end_date = (sipost('emp_end_date')) ? strtotime(str_replace(',', '', sipost('emp_end_date'))) : '';
            $end_date = ($end_date) ? date('Y-m-d', $end_date) : '';

            $assistant_info = array();
            if (sipost('emp_assistant_name') || sipost('emp_assistant_phone') || sipost('emp_assistant_email')) {
                $assistant_info = array(
                    'name'      => (sipost('emp_assistant_name')) ? sipost('emp_assistant_name') : '',
                    'phone'     => (sipost('emp_assistant_phone')) ? sipost('emp_assistant_phone') : '',
                    'email'     => (sipost('emp_assistant_email')) ? sipost('emp_assistant_email') : '',
                );
            }

            $employment_info = array(
                'advisor_id'        => $advisor_id,
                'employe_status'    => sipost('emp_status'),
                'company_name'      => ucwords(sipost('emp_company_name')),
                'start_date'        => $start_date,
                'end_date'          => $end_date,
                'company_address'   => sipost('emp_company_address'),
                'building'          => sipost('emp_building'),
                'city'              => sipost('emp_city'),
                'state'             => sipost('emp_state'),
                'zipcode'           => sipost('emp_zipcode'),
                'ria'               => sipost('ria'),
                'bd'                => sipost('bd'),
                'ga'                => sipost('ga'),
                'mga'               => sipost('mga'),
                'ppga'              => sipost('ppga'),
                'office_support'    => sipost('office_support'),
                'assistant_contact' => ($assistant_info) ? maybe_serialize($assistant_info) : '',
            );

            if (sipost('employment_history_id')) {
                $employment_info['updated_at'] = current_time('mysql');
                $wpdb->update("employment", $employment_info, array("id" => sipost('employment_history_id')));
            } else {
                $employment_info['created_at'] = current_time('mysql');
                $wpdb->insert("employment", $employment_info);
            }
        }
        /**** End Save Employement ****/

        /**** Save Interest ****/
        $check_interest = $wpdb->get_row("SELECT id FROM interest WHERE advisor_id = " . $advisor_id);

        $life_insurance     = (sipost('life_insurance')) ? implode(',', sipost('life_insurance')) : '';
        $annuities          = (sipost('annuities')) ? implode(',', sipost('annuities')) : '';
        $long_term_care_insurance = (sipost('long_term_care_insurance')) ? implode(',', sipost('long_term_care_insurance')) : '';
        $critical_illness   = (sipost('critical_illness')) ? implode(',', sipost('critical_illness')) : '';

        $interest_info = array(
            'advisor_id'        => $advisor_id,
            'life_insurance'    => $life_insurance,
            'annuities'         => $annuities,
            'long_term_care_insurance' => $long_term_care_insurance,
            'critical_illness'  => $critical_illness,
            'disability_income' => sipost('disability_income'),
            'group_insurance'   => sipost('group_insurance'),
        );

        if ($check_interest) {
            $interest_info['updated_at'] = current_time('mysql');
            $wpdb->update("interest", $interest_info, array("id" => $check_interest->id));
        } else {
            $interest_info['created_at'] = current_time('mysql');
            $wpdb->insert("interest", $interest_info);
        }
        /**** End Save Interest ****/

        if ($_FILES['advisor_profile'] && $_FILES['advisor_profile']['error'] == 0) {

            $file_name  = $_FILES['advisor_profile']['name'];

            $file_tmp   = $_FILES['advisor_profile']['tmp_name'];

            $file_type  = $_FILES['advisor_profile']['type'];

            $ext        = strtolower(end(explode('.', $file_name)));

            $new_file_name    = time() . rand(111, 999) . "." . $ext;

            if (move_uploaded_file($file_tmp, SITE_DIR . '/uploads/advisor/' . $new_file_name)) {
                $this->update_advisor_meta($advisor_id, 'profile_img', $new_file_name);
            } else {
                $this->update_advisor_meta($advisor_id, 'profile_img', 'blank.png'); // default profile
            }
        }

        $advisor_info['advisor_meta'] = $this->get_advisor_meta($advisor_id);

        Admin()->create_track_log_activity($advisor_id, $advisor_id, 'advisor update', 'advisor_update', $old_advisor_data, $advisor_info, 'advisor has been updated', 'advisor');

        return true;
    }

    public function add_advisor()
    {
        global $wpdb;


        if (!sipost('first_name') || !sipost('last_name') || !sipost('email')) {
            return false;
        }

        $email = trim(strtolower(sipost('email')));

        $preferred_name = (sipost("preferred_name")) ?  trim(ucwords(sipost("preferred_name"))) : '';

        $check_advisor = $wpdb->get_row("SELECT id FROM advisor WHERE ( LOWER(email) = '" . $email . "' ) AND status = 0 ");

        if ($check_advisor) {
            return "duplicate";
        }

        $birth_date = (sipost('birth_date')) ? strtotime(str_replace(',', '', sipost('birth_date'))) : '';
        $birth_date = ($birth_date) ? date('Y-m-d', $birth_date) : '';

        $anniversary_date = (sipost('anniversary_date')) ? strtotime(str_replace(',', '', sipost('anniversary_date'))) : '';
        $anniversary_date = ($anniversary_date) ? date('Y-m-d', $anniversary_date) : '';

        $middle_name = (sipost('middle_name')) ? ucwords((sipost('middle_name'))) : '';

        $licenses_type = (!empty(sipost('licenses_type'))) ? implode(',', sipost('licenses_type')) : '';

        $carrier_with_business = (!empty(sipost('carrier_with_business'))) ? implode(',', sipost('carrier_with_business')) : '';

        $production_percentages = (!empty(sipost('production_percentages'))) ? implode(',', sipost('production_percentages')) : '';

        $markets = (!empty(sipost('markets'))) ? implode(',', sipost('markets')) : '';

        $created_by = '';
        if (isset($_SESSION['fbs_advisor_id'])) {
            $created_by = $_SESSION['fbs_advisor_id'];
            $created_by_type = 'advisor';
        } else if (isset($_SESSION['fbs_arm_admin_id'])) {
            $created_by = $_SESSION['fbs_arm_admin_id'];
            $created_by_type = 'admin';
        }

        $advisor_info = array(
            "prefix"            => sipost("prefix"),
            "preferred_name"    => $preferred_name,
            "license_no"        => sipost("license_no"),
            "npn_no"            => sipost("npn_no"),
            "first_name"        => ucwords(sipost("first_name")),
            "middle_name"       => $middle_name,
            "last_name"         => ucwords(sipost("last_name")),
            "gender"            => sipost("gender"),
            "contact_type"      => (sipost("contact_type")) ? sipost("contact_type") : 'Mobile',
            "email"             => $email,
            "mobile_no"         => sipost("mobile_no"),
            "company_name"      => sipost("company_name"),
            "city"              => sipost("city"),
            "state"             => sipost("state"),
            "birth_date"        => $birth_date,
            "advisor_status"    => (sipost("advisor_status")) ? sipost("advisor_status") : 1,
            "designation"       => sipost("designation"),
            "licenses_type"     => $licenses_type,
            "marital_status"    => sipost("marital_status"),
            "lead_source"       => sipost("lead_source"),
            "affiliations"      => sipost("affiliations"),
            "carrier_appointed"     => sipost("carrier_appointed"),
            "carrier_with_business" => $carrier_with_business,
            "premium_volume"        => sipost("premium_volume"),
            "production_percentages" => $production_percentages,
            "markets"           => $markets,
            "anniversary_date"  => $anniversary_date,
            "lead_owner"        => sipost('lead_owner'),
            "rating"            => sipost('rating'),
            "created_at"        => current_time('mysql'),
            "created_by"        => $created_by,
            "created_by_type"   => $created_by_type,
            "mail_reminder"     => current_time('mysql'),
        );

        $wpdb->insert("advisor", $advisor_info);
        $last_id = $wpdb->insert_id;

        if ($last_id) {

            if (!empty(sipost('contact_info_row_list'))) {

                foreach (sipost('contact_info_row_list') as $row_no) {

                    $email = trim(strtolower(sipost("email_" . $row_no)));

                    $advisor_contact = array(
                        "advisor_id"    => $last_id,
                        "contact_type"  => sipost("contact_type_" . $row_no),
                        "mobile_no"     => sipost("mobile_no_" . $row_no),
                        "email"         => $email,
                    );

                    $wpdb->insert("advisor_extra_contact", $advisor_contact);
                }
            }

            $this->update_advisor_meta($last_id, 'lead_owner', sipost('lead_owner'));

            $this->update_advisor_meta($last_id, 'no_middle_name', sipost('no_middle_name'));

            $this->update_advisor_meta($last_id, 'spouses_name', sipost('spouses_name'));

            $spouses_birthdate = (sipost('spouses_birthdate')) ? strtotime(str_replace(',', '', sipost('spouses_birthdate'))) : '';
            $spouses_birthdate = ($spouses_birthdate) ? date('Y-m-d', $spouses_birthdate) : '';

            $this->update_advisor_meta($last_id, 'spouses_birthdate', $spouses_birthdate);

            $this->update_advisor_meta($last_id, 'total_children', sipost('total_children'));

            $this->update_advisor_meta($last_id, 'instagram_url', sipost('instagram_url'));

            $this->update_advisor_meta($last_id, 'facebook_url', sipost('facebook_url'));

            $this->update_advisor_meta($last_id, 'linkedin_url', sipost('linkedin_url'));

            $this->update_advisor_meta($last_id, 'youtube_url', sipost('youtube_url'));

            $this->update_advisor_meta($last_id, 'twitter_url', sipost('twitter_url'));

            $this->update_advisor_meta($last_id, 'organization', sipost('organization'));

            $this->update_advisor_meta($last_id, 'note', sipost('note'));

            $this->update_advisor_meta($last_id, 'profile_img', 'blank.png'); // default profile

            if ($_FILES['advisor_profile'] && $_FILES['advisor_profile']['error'] == 0) {

                $file_name  = $_FILES['advisor_profile']['name'];

                $file_tmp   = $_FILES['advisor_profile']['tmp_name'];

                $file_type  = $_FILES['advisor_profile']['type'];

                $ext        = strtolower(end(explode('.', $file_name)));

                $new_file_name    = time() . rand(111, 999) . "." . $ext;

                if (move_uploaded_file($file_tmp, SITE_DIR . '/uploads/advisor/' . $new_file_name)) {
                    $this->update_advisor_meta($last_id, 'profile_img', $new_file_name);
                }
            }

            $advisor_info['advisor_meta'] = $this->get_advisor_meta($last_id);
            Admin()->create_track_log_activity($last_id, $last_id, 'advisor add', 'advisor_add', $advisor_info, '', 'advisor has been added', 'advisor');

            return true;
        }

        return false;
    }


    public function get_advisor_list()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM advisor WHERE status = 0 ORDER BY id DESC");
    }

    public function get_advisor_list_with_general_details()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT id,first_name,middle_name,last_name,gender,email,mobile_no,city,state,birth_date FROM advisor WHERE status = 0 ORDER BY id DESC");
    }

    public function get_selected_advisor_general_details($advisor_id = '')
    {
        global $wpdb;
        if (!$advisor_id) {
            return false;
        }

        return $wpdb->get_row("SELECT id,first_name,middle_name,last_name,gender,email,mobile_no,city,state,birth_date FROM advisor WHERE id = " . $advisor_id  . " ORDER BY id DESC");
    }

    public function update_login_advisor_profile($advisor_id = '')
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id || !sipost('first_name') || !sipost('last_name') || !sipost('email')) {
            return false;
        }

        $first_name = ucwords(sipost('first_name'));
        $last_name  = ucwords(sipost('last_name'));
        $email      = strtolower(sipost('email'));

        $check = $wpdb->get_var("SELECT id FROM advisor WHERE email = '" . $email . "' AND id != " . $advisor_id . " AND status = 0");

        if ($check) {
            return "duplicate";
        }

        $user_info  = array(
            'first_name'    => $first_name,
            'last_name'     => $last_name,
            'email'         => $email,
            'mobile_no'     => sipost('mobile_no'),
            'state'         => sipost('state'),
            'updated_at'    => current_time('mysql')
        );

        if (sipost('password')) {
            $user_info['password'] = md5(sipost('password') . AUTH_SALT);
        }

        if ($_FILES['profile_img'] && $_FILES['profile_img']['error'] == 0) {

            $file_name  = $_FILES['profile_img']['name'];

            $file_tmp   = $_FILES['profile_img']['tmp_name'];

            $file_type  = $_FILES['profile_img']['type'];

            $ext        = strtolower(end(explode('.', $file_name)));

            $new_file_name    = time() . rand(111, 999) . "." . $ext;

            if (move_uploaded_file($file_tmp, SITE_DIR . '/uploads/advisor/' . $new_file_name)) {
                $this->update_advisor_meta($advisor_id, 'profile_img', $new_file_name);
            }
        }

        return $wpdb->update("advisor", $user_info, array('id' => $advisor_id));
    }


    // Get All Information About Current Loged Admin
    public function get_login_advisor_info($advisor_id = '')
    {

        global $wpdb;

        $advisor_id = (isset($_SESSION['fbs_advisor_id'])) ? $_SESSION['fbs_advisor_id'] : $advisor_id;

        if (!$advisor_id) {
            return array();
        }

        return $wpdb->get_row($wpdb->prepare('SELECT * FROM advisor WHERE id = %d', $advisor_id));
    }


    // Checked Currenty Advisor Login or Not If Not Then Redirect Login page
    public function check_advisor_login()
    {

        if (!$_SESSION || !$_SESSION['is_fbs_advisor_login'] || !$_SESSION['fbs_advisor_id']) {

            if (wp_doing_ajax()) {

                $error = new WP_Error('not_logged_in', 'User is not logged in.');
                wp_send_json_error($error);
            }

            wp_redirect(site_url('advisor/index.php'));
            exit;
        }

        return true;
    }


    // Checked Admin Available or Not If Available then make login process
    public function login($user_name, $password, $remember_login = false)
    {

        global $wpdb;

        $advisor_data = $wpdb->get_row("SELECT id, email, mobile_no, password FROM advisor WHERE ( LOWER(email) = '" . trim(strtolower($user_name)) . "' ) AND status = 0 AND is_verified = 1");

        if ($advisor_data) {

            if ($advisor_data->password === md5($password . AUTH_SALT)) {

                if ($remember_login) {
                    @setcookie('fbs_advisor_mail', $advisor_data->email, time() + (86400 * 10), '/'); // 86400 = 1 day
                } else {
                    if (isset($_COOKIE['fbs_advisor_mail'])) {
                        @setcookie('fbs_advisor_mail', '', time() - 3600, '/');
                    }
                }

                $_SESSION['is_fbs_advisor_login']   = true;
                $_SESSION['fbs_advisor_id']             = $advisor_data->id;

                return 'success';
            } else {
                return 'password_wrong';
            }
        }

        return 'email_not_found';
    }


    /**
     * Make Log Out Process
     *
     * @param SESSION ID Handles To Destroy Perticular SESSION
     *
     * @return bool
     * @since 1.0
     */
    public function logout()
    {

        if (!session_id()) {
            @session_start();
        }

        unset($_SESSION['fbs_advisor_id']);
        unset($_SESSION['is_fbs_advisor_login']);

        return true;
    }

    /************* Meta advisor ********************/


    /**
     * add/update advisor_meta table
     * 
     */
    public function update_advisor_meta($advisor_id, $meta_key = '', $meta_value = '')
    {

        global $wpdb;

        if (!$meta_key || !$advisor_id) {
            return false;
        }

        $meta_id = $wpdb->get_var($wpdb->prepare('SELECT meta_id FROM advisor_meta WHERE advisor_id = %d AND meta_key = %s', $advisor_id, $meta_key));

        if ($meta_id) { // Update 
            $wpdb->update('advisor_meta', array('meta_value' => $meta_value), array('meta_id' => $meta_id));
            return true;
        } else { // Insert 
            $advisor_meta_data = array(
                'advisor_id'   => $advisor_id,
                'meta_key'   => $meta_key,
                'meta_value' => $meta_value,
            );

            $wpdb->insert('advisor_meta', $advisor_meta_data);
            return true;
        }
    }

    /**
     * Get Perticular meta data advisor_meta table
     */
    public function get_advisor_meta($advisor_id, $meta_key = '')
    {

        global $wpdb;

        if ($meta_key && !empty($meta_key)) {   // get one field 
            return $wpdb->get_var($wpdb->prepare('SELECT meta_value FROM advisor_meta WHERE advisor_id = %d AND meta_key = %s', $advisor_id, $meta_key));
        } else { // get all fields 
            return $wpdb->get_results($wpdb->prepare('SELECT * FROM advisor_meta WHERE advisor_id = %d', $advisor_id), ARRAY_N);
        }
    }


    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

function Advisor()
{
    return Advisor::get_instance();
}

Advisor();
