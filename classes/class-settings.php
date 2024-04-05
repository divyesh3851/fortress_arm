<?php

/**
 * Class For Settings Login And Manage All Modual
 */

class Settings
{

    protected static $instance;

    public function __construct()
    {
        add_action('wp_ajax_get_selected_designation_data', array($this, 'get_selected_designation_data'));

        add_action('wp_ajax_designation_delete', array($this, 'designation_delete'));

        add_action('wp_ajax_get_selected_license_type_data', array($this, 'get_selected_license_type_data'));

        add_action('wp_ajax_license_type_delete', array($this, 'license_type_delete'));

        add_action('wp_ajax_lead_source_delete', array($this, 'lead_source_delete'));

        add_action('wp_ajax_get_selected_affiliations_data', array($this, 'get_selected_affiliations_data'));

        add_action('wp_ajax_affiliations_delete', array($this, 'affiliations_delete'));

        add_action('wp_ajax_get_selected_carrier_appointed_data', array($this, 'get_selected_carrier_appointed_data'));

        add_action('wp_ajax_carrier_appointed_delete', array($this, 'carrier_appointed_delete'));

        add_action('wp_ajax_get_selected_carrier_data', array($this, 'get_selected_carrier_data'));

        add_action('wp_ajax_carrier_delete', array($this, 'carrier_delete'));

        add_action('wp_ajax_get_selected_premium_volume_data', array($this, 'get_selected_premium_volume_data'));

        add_action('wp_ajax_premium_volume_delete', array($this, 'premium_volume_delete'));

        add_action('wp_ajax_get_selected_production_percentage_data', array($this, 'get_selected_production_percentage_data'));

        add_action('wp_ajax_production_percentage_delete', array($this, 'production_percentage_delete'));

        add_action('wp_ajax_get_selected_market_data', array($this, 'get_selected_market_data'));

        add_action('wp_ajax_market_delete', array($this, 'market_delete'));
    }

    public function get_lead_owner_list()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM lead_owner WHERE status = 0 ORDER BY id DESC");
    }

    public function get_selected_activity_type_name($id)
    {
        $activity_type = array(
            "1" => "Phone Call",
            "2" => "Email",
            "3" => "Video Call",
            "4" => "In-Office Meeting",
            "5" => "Out-Office Meeting",
            "6" => "Note",
        );

        return $activity_type[$id];
    }

    public function get_activity_type_list()
    {
        return array(
            "1" => "Phone Call",
            "2" => "Email",
            "3" => "Video Call",
            "4" => "In-Office Meeting",
            "5" => "Out-Office Meeting",
            "6" => "Note",
        );
    }

    public function get_interest_group_insurance()
    {
        return array(
            "1" => "Small Group",
            "2" => "Large Group",
        );
    }

    public function get_interest_disability_income()
    {
        return array(
            "1" => "Individual Disability Income",
            "2" => "Business Overhead Expense",
            "3" => "Key Man Disability",
            "4" => "Disability Buy-Out",
        );
    }

    public function get_interest_critical_illness()
    {
        return array(
            "1" => "Critical Illness",
            "2" => "Heart Attack",
            "3" => "Stroke",
            "4" => "Cancer",
        );
    }

    public function get_interest_long_term_care_insurance()
    {
        return array(
            "1" => "Traditional LTC",
            "2" => "Benefit-Linked LTC",
            "3" => "LTC Annuity",
            "4" => "Life with LTC Rider",
        );
    }

    public function get_interest_annuities()
    {
        return array(
            "1" => "Fixed Index Annuities",
            "2" => "Variable Annuities",
            "3" => "Multi-Year Guaranteed Annuities",
            "4" => "Single Premium Immediate Annuities",
            "5" => "Deferred Income Annuities",
            "6" => "Long-Term Care Annuities",
        );
    }

    public function get_interest_life_insurance()
    {
        return array(
            "1" => "IUL",
            "2" => "VUL",
            "3" => "Term",
            "4" => "Living Benefits",
            "5" => "Whole Life",
            "6" => "Final Expense",
            "7" => "Advanced Case design like premium finance, executive bonus structure",
        );
    }

    public function get_selected_multiple_market_name($ids)
    {
        global $wpdb;

        if (!$ids) {
            return false;
        }

        $ids_array = explode(",", $ids);

        $markets = '';
        foreach ($ids_array as $id) {
            $markets .= $wpdb->get_var("SELECT type FROM markets WHERE id = " . $id) . ', ';
        }

        return $markets;
    }

    public function market_delete($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        return $wpdb->update("markets", array("status" => 1), array("id" => $id));
    }

    public function get_selected_market_data($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        $market = $wpdb->get_row("SELECT * FROM markets WHERE id = " . $id);

        if (sipost('is_ajax')) {
            echo json_encode(array("market_info" => $market));
            die();
        } else {
            return $market;
        }
    }

    public function update_market()
    {
        global $wpdb;

        if (!sipost('id') || !sipost('market')) {
            return false;
        }

        $market = ucwords(sipost('market'));

        $check_type = $wpdb->get_var("SELECT id FROM markets WHERE id != " . sipost('id') . " AND type = '" . $market . "' AND status = 0");

        if ($check_type) {
            return "duplicate";
        }

        return $wpdb->update("markets", array("type" => $market), array("id" => sipost('id')));
    }

    public function add_market()
    {
        global $wpdb;

        if (!sipost('market')) {
            return false;
        }

        $market = ucwords(sipost('market'));

        $check_type = $wpdb->get_var("SELECT id FROM markets WHERE type = '" . $market . "' AND status = 0");

        if ($check_type) {
            return "duplicate";
        }

        return $wpdb->insert("markets", array("type" => $market));
    }

    public function get_market_list()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM markets WHERE status = 0 ORDER BY id DESC");
    }

    /****** Production Percentage ********/
    public function get_selected_multiple_production_percentage_name($ids)
    {
        global $wpdb;

        if (!$ids) {
            return false;
        }

        $ids_array = explode(",", $ids);

        $production_percentage_type = '';
        foreach ($ids_array as $id) {
            $production_percentage_type .= $wpdb->get_var("SELECT type FROM production_percentage WHERE id = " . $id) . ', ';
        }

        return $production_percentage_type;
    }

    public function production_percentage_delete($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        return $wpdb->update("production_percentage", array("status" => 1), array("id" => $id));
    }

    public function get_selected_production_percentage_data($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        $production_percentage = $wpdb->get_row("SELECT * FROM production_percentage WHERE id = " . $id);

        if (sipost('is_ajax')) {
            echo json_encode(array("production_percentage_info" => $production_percentage));
            die();
        } else {
            return $production_percentage;
        }
    }

    public function update_production_percentage()
    {
        global $wpdb;

        if (!sipost('id') || !sipost('production_percentage')) {
            return false;
        }

        $production_percentage = ucwords(sipost('production_percentage'));

        $check_type = $wpdb->get_var("SELECT id FROM production_percentage WHERE id != " . sipost('id') . " AND type = '" . $production_percentage . "' AND status = 0");

        if ($check_type) {
            return "duplicate";
        }

        return $wpdb->update("production_percentage", array("type" => $production_percentage), array("id" => sipost('id')));
    }

    public function add_production_percentage()
    {
        global $wpdb;

        if (!sipost('production_percentage')) {
            return false;
        }

        $production_percentage = ucwords(sipost('production_percentage'));

        $check_type = $wpdb->get_var("SELECT id FROM production_percentage WHERE type = '" . $production_percentage . "' AND status = 0");

        if ($check_type) {
            return "duplicate";
        }

        return $wpdb->insert("production_percentage", array("type" => $production_percentage));
    }

    public function get_production_percentage_list()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM production_percentage WHERE status = 0 ORDER BY id DESC");
    }

    /********* Premium Volume ***********/

    public function premium_volume_delete($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        return $wpdb->update("premium_volume", array("status" => 1), array("id" => $id));
    }

    public function get_selected_premium_volume_data($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        $premium_volume_info = $wpdb->get_row("SELECT * FROM premium_volume WHERE id = " . $id);

        if (sipost('is_ajax')) {
            echo json_encode(array("premium_volume_info" => $premium_volume_info));
            die();
        } else {
            return $premium_volume_info;
        }
    }

    public function update_premium_volume()
    {
        global $wpdb;

        if (!sipost('id') || !sipost('premium_volume')) {
            return false;
        }

        $premium_volume = ucwords(sipost('premium_volume'));

        $check_type = $wpdb->get_var("SELECT id FROM premium_volume WHERE id != " . sipost('id') . " AND type = '" . $premium_volume . "' AND status = 0");

        if ($check_type) {
            return "duplicate";
        }

        return $wpdb->update("premium_volume", array("type" => $premium_volume), array("id" => sipost('id')));
    }

    public function add_premium_volume()
    {
        global $wpdb;

        if (!sipost('premium_volume')) {
            return false;
        }

        $premium_volume = ucwords(sipost('premium_volume'));

        $check_type = $wpdb->get_var("SELECT id FROM premium_volume WHERE type = '" . $premium_volume . "' AND status = 0");

        if ($check_type) {
            return "duplicate";
        }

        return $wpdb->insert("premium_volume", array("type" => $premium_volume));
    }

    public function get_premium_volume_list()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM premium_volume WHERE status = 0 ORDER BY id DESC");
    }

    /******* Carrier  *********/

    public function carrier_delete($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        return $wpdb->update("carrier", array("status" => 1), array("id" => $id));
    }

    public function get_selected_multiple_carrier_name($ids)
    {
        global $wpdb;

        if (!$ids) {
            return false;
        }

        $ids_array = explode(",", $ids);

        $carriers = '';
        foreach ($ids_array as $id) {
            $carriers .= $wpdb->get_var("SELECT name FROM carrier WHERE id = " . $id) . ', ';
        }

        return $carriers;
    }

    public function get_selected_carrier_data($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        $carrier_info = $wpdb->get_row("SELECT * FROM carrier WHERE id = " . $id);

        if (sipost('is_ajax')) {
            echo json_encode(array("carrier_info" => $carrier_info));
            die();
        } else {
            return $carrier_info;
        }
    }

    public function update_carrier()
    {
        global $wpdb;

        if (!sipost('id') || !sipost('carrier')) {
            return false;
        }

        $carrier = ucwords(sipost('carrier'));

        $check_carrier = $wpdb->get_var("SELECT id FROM carrier WHERE id != " . sipost('id') . " AND name = '" . $carrier . "' AND status = 0");

        if ($check_carrier) {
            return "duplicate";
        }

        return $wpdb->update("carrier", array("name" => $carrier), array("id" => sipost('id')));
    }

    public function add_carrier()
    {
        global $wpdb;

        if (!sipost('carrier')) {
            return false;
        }

        $carrier = ucwords(sipost('carrier'));

        $check_carrier = $wpdb->get_var("SELECT id FROM carrier WHERE name = '" . $carrier . "' AND status = 0");

        if ($check_carrier) {
            return "duplicate";
        }

        return $wpdb->insert("carrier", array("name" => $carrier));
    }

    public function get_carrier_list()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM carrier WHERE status = 0 ORDER BY id DESC");
    }

    /******* Carrier Appointed ******/

    public function carrier_appointed_delete($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        return $wpdb->update("carrier_appointed", array("status" => 1), array("id" => $id));
    }

    public function get_selected_carrier_appointed_data($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        $carrier_appointed_info = $wpdb->get_row("SELECT * FROM carrier_appointed WHERE id = " . $id);

        if (sipost('is_ajax')) {
            echo json_encode(array("carrier_appointed_info" => $carrier_appointed_info));
            die();
        } else {
            return $carrier_appointed_info;
        }
    }

    public function update_carrier_appointed()
    {
        global $wpdb;

        if (!sipost('id') || !sipost('carrier_appointed')) {
            return false;
        }

        $carrier_appointed = ucwords(sipost('carrier_appointed'));

        $check_type = $wpdb->get_var("SELECT id FROM carrier_appointed WHERE id != " . sipost('id') . " AND type = '" . $carrier_appointed . "' AND status = 0");

        if ($check_type) {
            return "duplicate";
        }

        return $wpdb->update("carrier_appointed", array("type" => $carrier_appointed), array("id" => sipost('id')));
    }

    public function add_carrier_appointed()
    {
        global $wpdb;

        if (!sipost('carrier_appointed')) {
            return false;
        }

        $carrier_appointed = ucwords(sipost('carrier_appointed'));

        $check_type = $wpdb->get_var("SELECT id FROM carrier_appointed WHERE type = '" . $carrier_appointed . "' AND status = 0");

        if ($check_type) {
            return "duplicate";
        }

        return $wpdb->insert("carrier_appointed", array("type" => $carrier_appointed));
    }

    public function get_carrier_appointed_list()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM carrier_appointed WHERE status = 0 ORDER BY id DESC");
    }

    /******* Affiliations **********/

    public function affiliations_delete($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        return $wpdb->update("affiliations", array("status" => 1), array("id" => $id));
    }

    public function get_selected_affiliations_data($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        $affiliations_info = $wpdb->get_row("SELECT * FROM affiliations WHERE id = " . $id);

        if (sipost('is_ajax')) {
            echo json_encode(array("affiliations_info" => $affiliations_info));
            die();
        } else {
            return $affiliations_info;
        }
    }

    public function update_affiliations()
    {
        global $wpdb;

        if (!sipost('id') || !sipost('affiliations')) {
            return false;
        }

        $affiliations = ucwords(sipost('affiliations'));

        $check_type = $wpdb->get_var("SELECT id FROM affiliations WHERE id != " . sipost('id') . " AND type = '" . $affiliations . "' AND status = 0");

        if ($check_type) {
            return "duplicate";
        }

        return $wpdb->update("affiliations", array("type" => $affiliations), array("id" => sipost('id')));
    }

    public function add_affiliations()
    {
        global $wpdb;

        if (!sipost('affiliations')) {
            return false;
        }

        $affiliations = ucwords(sipost('affiliations'));

        $check_type = $wpdb->get_var("SELECT id FROM affiliations WHERE type = '" . $affiliations . "' AND status = 0");

        if ($check_type) {
            return "duplicate";
        }

        return $wpdb->insert("affiliations", array("type" => $affiliations));
    }

    public function get_affiliations_list()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM affiliations WHERE status = 0 ORDER BY id DESC");
    }

    /********* Lead Source ***********/

    public function lead_source_delete($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        return $wpdb->update("lead_source", array("status" => 1), array("id" => $id));
    }

    public function get_selected_lead_source_data($id = '')
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        $lead_source_info = $wpdb->get_row("SELECT * FROM lead_source WHERE id = " . $id);

        if (sipost('is_ajax')) {
            echo json_encode(array("lead_source_info" => $lead_source_info));
            die();
        } else {
            return $lead_source_info;
        }
    }

    public function update_lead_source()
    {
        global $wpdb;

        if (!sipost('id') || !sipost('lead_source')) {
            return false;
        }

        $lead_source = ucwords(sipost('lead_source'));

        $check_type = $wpdb->get_var("SELECT id FROM lead_source WHERE id != " . sipost('id') . " AND type = '" . $lead_source . "' AND status = 0");

        if ($check_type) {
            return "duplicate";
        }

        return $wpdb->update("lead_source", array("type" => $lead_source), array("id" => sipost('id')));
    }

    public function add_lead_source()
    {
        global $wpdb;

        if (!sipost('lead_source')) {
            return false;
        }

        $lead_source = ucwords(sipost('lead_source'));

        $check_type = $wpdb->get_var("SELECT id FROM lead_source WHERE type = '" . $lead_source . "' AND status = 0");

        if ($check_type) {
            return "duplicate";
        }

        return $wpdb->insert("lead_source", array("type" => $lead_source));
    }

    public function get_lead_source_list()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM lead_source WHERE status = 0 ORDER BY id DESC");
    }

    /***** License Type */

    public function license_type_delete($license_type_id = '')
    {
        global $wpdb;

        $license_type_id = (sipost('license_type_id')) ? sipost('license_type_id') : $license_type_id;

        if (!$license_type_id) {
            return false;
        }

        return $wpdb->update("license_type", array("status" => 1), array("id" => $license_type_id));
    }

    public function get_selected_license_type_data($license_type_id = '')
    {
        global $wpdb;

        $license_type_id = (sipost('license_type_id')) ? sipost('license_type_id') : $license_type_id;

        if (!$license_type_id) {
            return false;
        }

        $license_type_info = $wpdb->get_row("SELECT * FROM license_type WHERE id = " . $license_type_id);

        if (sipost('is_ajax')) {
            echo json_encode(array("license_type_info" => $license_type_info));
            die();
        } else {
            return $license_type_info;
        }
    }

    public function update_license_type()
    {
        global $wpdb;

        if (!sipost('license_type_id') || !sipost('license_type')) {
            return false;
        }

        $license_type = ucwords(sipost('license_type'));

        $check_type = $wpdb->get_var("SELECT id FROM license_type WHERE id != " . sipost('license_type_id') . " AND type = '" . $license_type . "' AND status = 0");

        if ($check_type) {
            return "duplicate";
        }

        return $wpdb->update("license_type", array("type" => $license_type), array("id" => sipost('license_type_id')));
    }

    public function add_license_type()
    {
        global $wpdb;

        if (!sipost('license_type')) {
            return false;
        }

        $license_type = ucwords(sipost('license_type'));

        $check_type = $wpdb->get_var("SELECT id FROM license_type WHERE type = '" . $license_type . "' AND status = 0");

        if ($check_type) {
            return "duplicate";
        }

        return $wpdb->insert("license_type", array("type" => $license_type));
    }

    public function get_license_type_list()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM license_type WHERE status = 0 ORDER BY id DESC");
    }

    /***** Designation ********/

    public function designation_delete($designation_id = '')
    {
        global $wpdb;

        $designation_id = (sipost('designation_id')) ? sipost('designation_id') : $designation_id;

        if (!$designation_id) {
            return false;
        }

        return $wpdb->update("designation", array("status" => 1), array("id" => $designation_id));
    }

    public function get_selected_designation_data($designation_id = '')
    {
        global $wpdb;

        $designation_id = (sipost('designation_id')) ? sipost('designation_id') : $designation_id;

        if (!$designation_id) {
            return false;
        }

        $designation_info = $wpdb->get_row("SELECT * FROM designation WHERE id = " . $designation_id);

        if (sipost('is_ajax')) {
            echo json_encode(array("designation_info" => $designation_info));
            die();
        } else {
            return $designation_info;
        }
    }

    public function update_designation()
    {
        global $wpdb;

        if (!sipost('designation_id') || !sipost('designation')) {
            return false;
        }

        $designation = ucwords(sipost('designation'));

        $check_designation = $wpdb->get_var("SELECT id FROM designation WHERE id != " . sipost('designation_id') . " AND name = '" . $designation . "' AND status = 0");

        if ($check_designation) {
            return "duplicate";
        }

        return $wpdb->update("designation", array("name" => $designation, "initials" => sipost('initials')), array("id" => sipost('designation_id')));
    }

    public function add_designation()
    {
        global $wpdb;

        if (!sipost('designation')) {
            return false;
        }

        $designation = ucwords(sipost('designation'));

        $check_designation = $wpdb->get_var("SELECT id FROM designation WHERE name = '" . $designation . "' AND status = 0");

        if ($check_designation) {
            return "duplicate";
        }

        return $wpdb->insert("designation", array("name" => $designation, "initials" => sipost('initials')));
    }

    public function get_designation_list()
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM designation WHERE status = 0 ORDER BY id DESC");
    }

    public function get_employment_status_list()
    {
        return array(
            "1" => "Self-Employed",
            "2" => "Contract Employee",
            "3" => "Full-Time Employee",
            "4" => "Independent Contractor",
            "5" => "Intern or Apprentice",
            "6" => "Part-Time Employee",
            "7" => "Temporary or Seasonal Employee",
            "8" => "Unemployed",
            "9" => "Volunteer",
        );
    }

    public function get_advisor_status_list()
    {
        return array(
            "1" => "New",
            "2" => "Cold",
            "3" => "Warm",
            "4" => "Hot",
            "5" => "Inactive"
        );
    }

    public function get_name_prefix_list()
    {
        return array(
            "Mr", "Mrs", "Miss", "Ms", "Sir", "Dr"
        );
    }

    public function get_gender_type_list()
    {
        return array(
            "Male", "Female", "Other"
        );
    }

    public function get_contact_type_list()
    {
        return array(
            "Work", "Mobile", "Other"
        );
    }

    public function get_state_list()
    {
        $states = array("Alabama" => "Alabama", "Alaska" => "Alaska", "Arizona" => "Arizona", "Arkansas" => "Arkansas", "California" => "California", "Colorado" => "Colorado", "Connecticut" => "Connecticut", "Delaware" => "Delaware", "District of Columbia" => "District of Columbia", "Florida" => "Florida", "Georgia" => "Georgia", "Hawaii" => "Hawaii", "Idaho" => "Idaho", "Illinois" => "Illinois", "Indiana" => "Indiana", "Iowa" => "Iowa", "Kansas" => "Kansas", "Kentucky" => "Kentucky", "Louisiana" => "Louisiana", "Maine" => "Maine", "Maryland" => "Maryland", "Massachusetts" => "Massachusetts", "Michigan" => "Michigan", "Minnesota" => "Minnesota", "Mississippi" => "Mississippi", "Missouri" => "Missouri", "Montana" => "Montana", "Nebraska" => "Nebraska", "Nevada" => "Nevada", "New Hampshire" => "New Hampshire", "New Jersey" => "New Jersey", "New Mexico" => "New Mexico", "New York" => "New York", "North Carolina" => "North Carolina", "North Dakota" => "North Dakota", "Ohio" => "Ohio", "Oklahoma" => "Oklahoma", "Oregon" => "Oregon", "Pennsylvania" => "Pennsylvania", "Rhode Island" => "Rhode Island", "South Carolina" => "South Carolina", "South Dakota" => "South Dakota", "Tennessee" => "Tennessee", "Texas" => "Texas", "Utah" => "Utah", "Vermont" => "Vermont", "Virginia" => "Virginia", "Washington" => "Washington", "West Virginia" => "West Virginia", "Wisconsin" => "Wisconsin", "Wyoming" => "Wyoming");

        return $states;
    }

    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

function Settings()
{
    return Settings::get_instance();
}

Settings();
