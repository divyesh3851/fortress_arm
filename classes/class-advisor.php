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

        add_action('wp_ajax_check_email_exist', array($this, 'check_email_exist'));

        add_action('wp_ajax_get_selected_note_data', array($this, 'get_selected_note_data'));
    }

    public function get_upcoming_birthday_list()
    {
        global $wpdb;

        $AND = '';
        if (IS_ADMIN) {
            $AND = " AND created_by = " . $_SESSION['fbs_admin_id'];
        }

        return $wpdb->get_results("SELECT id, prefix, first_name, last_name, email, mobile_no,birth_date FROM advisor WHERE birth_date BETWEEN CURDATE() AND CURDATE() +  INTERVAL 7 DAY " . $AND . " ORDER BY birth_date ASC");
    }

    public function get_upcoming_anniversary_list()
    {
        global $wpdb;

        $AND = '';
        if (IS_ADMIN) {
            $AND = " AND created_by = " . $_SESSION['fbs_admin_id'];
        }

        return $wpdb->get_results("SELECT id, prefix, first_name, last_name, email, mobile_no,anniversary_date FROM advisor WHERE anniversary_date BETWEEN CURDATE() AND CURDATE() + INTERVAL 7 DAY " . $AND . " ORDER BY anniversary_date ASC");
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

        return $wpdb->get_results("SELECT * FROM activity WHERE activity_date < '" . date('Y-m-d') . "' ORDER BY activity_date DESC LIMIT 0,5");
    }

    public function get_advisor_upcoming_activity($advisor_id)
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id) {
            return false;
        }

        return $wpdb->get_results("SELECT * FROM activity WHERE activity_date >= '" . date('Y-m-d') . "' ORDER BY activity_date ASC LIMIT 0,5");
    }

    public function add_activity($advisor_id)
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id) {
            return false;
        }

        $activity_date = (sipost('date')) ? strtotime(str_replace(',', '', sipost('date'))) : '';
        $activity_date = ($activity_date) ? date('Y-m-d', $activity_date) : '';

        $activity_info = array(
            'user_id'       => $advisor_id,
            'user_type'     => 'advisor',
            'title'         => sipost('title'),
            'activity_date' => $activity_date,
            'start_time'    => sipost('start_time'),
            'end_time'      => sipost('end_time'),
            'type'          => sipost('type'),
            'location'      => sipost('location'),
            'note'          => sipost('note'),
            'created_at'    => current_time('mysql')
        );

        if ($wpdb->insert("activity", $activity_info)) {

            $last_id = $wpdb->insert_id;

            Admin()->create_track_log_activity($advisor_id, $last_id, 'activity add', 'activity_add', $activity_info, '', 'New Activity Added', 'advisor');

            return true;
        }
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

    public function get_note_list()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM advisor_notes ORDER BY id DESC");
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

    public function get_selected_address_data($advisor_id)
    {
        global $wpdb;

        $advisor_id = (sipost('advisor_id')) ? sipost('advisor_id') : $advisor_id;

        if (!$advisor_id) {
            return false;
        }

        $address_info = $wpdb->get_row("SELECT city,state,zipcode,business_city,business_state,business_zipcode FROM advisor WHERE id = " . $advisor_id);

        $resident_address_info = array(
            'city'          => $address_info->city,
            'state'         => $address_info->state,
            'zipcode'       => $address_info->zipcode,
            'address_label' => $this->get_advisor_meta($advisor_id, 'resident_address_label'),
            'street_address' => $this->get_advisor_meta($advisor_id, 'resident_street_address'),
            'building_name' => $this->get_advisor_meta($advisor_id, 'resident_building_name'),
        );

        $business_address_info = array(
            'city'          => $address_info->business_city,
            'state'         => $address_info->business_state,
            'zipcode'       => $address_info->business_zipcode,
            'address_label' => $this->get_advisor_meta($advisor_id, 'business_address_label'),
            'street_address' => $this->get_advisor_meta($advisor_id, 'business_street_address'),
            'building_name' => $this->get_advisor_meta($advisor_id, 'business_building_name'),
        );

        echo json_encode(array("resident" => $resident_address_info, "business" => $business_address_info));
        die();
    }

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

        if (!sipost('employe_status') || !sipost('company_name') || !sipost('start_date') || !sipost('end_date') || !sipost('company_address') || !sipost('city') || !sipost('state') || !sipost('zipcode')) {
            return false;
        }

        $start_date = (sipost('start_date')) ? strtotime(str_replace(',', '', sipost('start_date'))) : '';
        $start_date = ($start_date) ? date('Y-m-d', $start_date) : '';

        $end_date = (sipost('end_date')) ? strtotime(str_replace(',', '', sipost('end_date'))) : '';
        $end_date = ($end_date) ? date('Y-m-d', $end_date) : '';

        $employment_info = array(
            'advisor_id'        => $advisor_id,
            'employe_status'    => sipost('employe_status'),
            'company_name'      => ucwords(sipost('company_name')),
            'start_date'        => $start_date,
            'end_date'          => $end_date,
            'company_address'   => sipost('company_address'),
            'building'          => sipost('building'),
            'city'              => sipost('city'),
            'state'             => sipost('state'),
            'zipcode'           => sipost('zipcode'),
            'ria'               => sipost('ria'),
            'bd'                => sipost('bd'),
            'ga'                => sipost('ga'),
            'mga'               => sipost('mga'),
            'ppga'              => sipost('ppga'),
            'office_support'    => sipost('office_support'),
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

    public function update_advisor()
    {
        global $wpdb;

        if (!sipost('advisor_id') || !sipost("preferred_name") || !sipost('first_name') || !sipost('last_name') || !sipost('email')) {
            return false;
        }

        $advisor_id = sipost('advisor_id');

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
            "contact_type"      => sipost("contact_type"),
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
            "anniversary_date"  => $anniversary_date,
            "updated_at"        => current_time('mysql')
        );

        $old_advisor_data = $wpdb->get_row("SELECT * FROM advisor WHERE id = " . $advisor_id . " AND status = 0 ", ARRAY_A);
        $old_advisor_data['advisor_meta'] = $this->get_advisor_meta($advisor_id);

        $wpdb->update("advisor", $advisor_info, array("id" => $advisor_id));

        if (!empty(sipost('contact_info_row_list'))) {

            foreach (sipost('contact_info_row_list') as $row_no) {

                $email = trim(strtolower(sipost("email_" . $row_no)));

                $advisor_contact = array(
                    "advisor_id"    => $advisor_id,
                    "contact_type"  => sipost("contact_type_" . $row_no),
                    "mobile_no"     => sipost("mobile_no_" . $row_no),
                    "email"         => $email,
                );

                $wpdb->update("advisor_extra_contact", $advisor_contact, array("id" => sipost("contact_id_" . $row_no)));
            }
        }

        $this->update_advisor_meta($advisor_id, 'lead_owner', sipost('lead_owner'));

        $this->update_advisor_meta($advisor_id, 'no_middle_name', sipost('no_middle_name'));

        $this->update_advisor_meta($advisor_id, 'spouses_name', sipost('spouses_name'));

        $spouses_birthdate = (sipost('spouses_birthdate')) ? strtotime(str_replace(',', '', sipost('spouses_birthdate'))) : '';
        $spouses_birthdate = ($spouses_birthdate) ? date('Y-m-d', $spouses_birthdate) : '';

        $this->update_advisor_meta($advisor_id, 'spouses_birthdate', $spouses_birthdate);

        $this->update_advisor_meta($advisor_id, 'total_children', sipost('total_children'));

        $this->update_advisor_meta($advisor_id, 'email_opt_out', sipost('email_opt_out'));

        $this->update_advisor_meta($advisor_id, 'facebook_url', sipost('facebook_url'));

        $this->update_advisor_meta($advisor_id, 'linkedin_url', sipost('linkedin_url'));

        $this->update_advisor_meta($advisor_id, 'youtube_url', sipost('youtube_url'));

        $this->update_advisor_meta($advisor_id, 'twitter_url', sipost('twitter_url'));

        $this->update_advisor_meta($advisor_id, 'organization', sipost('organization'));

        $this->update_advisor_meta($advisor_id, 'note', sipost('note'));

        $check_interest = $wpdb->get_row("SELECT id FROM interest WHERE advisor_id = " . $advisor_id);

        $life_insurance     = (sipost('life_insurance')) ? implode(',', sipost('life_insurance')) : '';
        $annuities          = (sipost('annuities')) ? implode(',', sipost('annuities')) : '';
        $long_term_care_insurance = (sipost('long_term_care_insurance')) ? implode(',', sipost('long_term_care_insurance')) : '';
        $critical_illness   = (sipost('critical_illness')) ? implode(',', sipost('critical_illness')) : '';

        $interest_info = array(
            'advisor_id'    => $advisor_id,
            'life_insurance' => $life_insurance,
            'annuities'     => $annuities,
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

        $advisor_info = array(
            "prefix"            => sipost("prefix"),
            "preferred_name"    => $preferred_name,
            "license_no"        => sipost("license_no"),
            "npn_no"            => sipost("npn_no"),
            "first_name"        => ucwords(sipost("first_name")),
            "middle_name"       => $middle_name,
            "last_name"         => ucwords(sipost("last_name")),
            "gender"            => sipost("gender"),
            "contact_type"      => sipost("contact_type"),
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
            "anniversary_date"  => $anniversary_date,
            "created_at"        => current_time('mysql')
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

            $this->update_advisor_meta($last_id, 'email_opt_out', sipost('email_opt_out'));

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

        return $wpdb->get_results("SELECT id,first_name,middle_name,last_name,gender,email,mobile_no,city,state,zipcode,birth_date FROM advisor WHERE status = 0 ORDER BY id DESC");
    }

    public function get_selected_advisor_general_details($advisor_id = '')
    {
        global $wpdb;
        if (!$advisor_id) {
            return false;
        }

        return $wpdb->get_row("SELECT id,first_name,middle_name,last_name,gender,email,mobile_no,city,state,zipcode,birth_date FROM advisor WHERE id = " . $advisor_id  . " ORDER BY id DESC");
    }

    // Checked Currenty Advisor Login or Not If Not Then Redirect Login page
    public function check_login()
    {

        if (!$_SESSION || !$_SESSION['is_fbs_advisor_logged_id'] || !$_SESSION['fbs_advisor_id']) {

            if (wp_doing_ajax()) {

                $error = new WP_Error('not_logged_in', 'User is not logged in.');
                wp_send_json_error($error);
            }

            wp_redirect(admin_url('index.php'));
            exit;
        }

        return true;
    }


    // Get All Information About Current Loged Advisor
    public function get_login_advisor_info($advisor_id = '')
    {

        global $wpdb;

        $advisor_id = (isset($_SESSION['fbs_advisor_id'])) ? $_SESSION['fbs_advisor_id'] : $advisor_id;

        if (!$advisor_id) {
            return array();
        }

        return $wpdb->get_row($wpdb->prepare('SELECT * FROM advisor WHERE id = %d', $advisor_id));
    }


    // Checked Admin Available or Not If Available then make login process
    public function login($user_name, $password, $remember_login = false)
    {

        global $wpdb;
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
        unset($_SESSION['is_fbs_advisor_logged_id']);
        session_unset();
        session_destroy();

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
