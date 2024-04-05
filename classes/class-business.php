<?php

/**
 * Class For Business Login And Manage All Modual
 */

class Business
{

    protected static $instance;

    public function __construct()
    {
        add_action('wp_ajax_get_selected_advisor_data', array($this, 'get_selected_advisor_data'));

        add_action('wp_ajax_advisor_delete', array($this, 'advisor_delete'));
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

        return $wpdb->update("advisor", array("status" => 1), array("id" => $advisor_id));
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

        return true;
    }

    public function add_advisor()
    {
        global $wpdb;


        if (!sipost('first_name') || !sipost('last_name') || !sipost('email') || !sipost("preferred_name")) {
            return false;
        }

        $email = trim(strtolower(sipost('email')));

        $preferred_name = trim(ucwords(sipost("preferred_name")));

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

            return true;
        }

        return false;
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

function Business()
{
    return Business::get_instance();
}

Business();
