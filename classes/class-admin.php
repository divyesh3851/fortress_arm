<?php

/**
 * Class For Admin Login And Manage All Modual
 */

class Admin
{

    protected static $instance;

    public function __construct()
    {
        add_action('wp_ajax_get_selected_admin_user_data', array($this, 'get_selected_admin_user_data'));

        add_action('wp_ajax_admin_user_delete', array($this, 'admin_user_delete'));
    }

    public function admin_user_delete($id)
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        return $wpdb->update("admin", array("status" => 1, "is_active" => 0), array("id" => $id));
    }

    public function get_selected_admin_user_data($id)
    {
        global $wpdb;

        $id = (sipost('id')) ? sipost('id') : $id;

        if (!$id) {
            return false;
        }

        $user_info = $wpdb->get_row("SELECT * FROM admin WHERE id = " . $id);

        if (sipost('is_ajax')) {
            echo json_encode($user_info);
            die();
        } else {
            return $user_info;
        }
    }

    public function update_admin_user()
    {
        global $wpdb;

        if (!sipost('id') || !sipost('first_name') || !sipost('last_name') || !sipost('email')) {
            return false;
        }

        $first_name = ucwords(sipost('first_name'));
        $last_name  = ucwords(sipost('last_name'));
        $email      = strtolower(sipost('email'));

        $check = $wpdb->get_var("SELECT id FROM admin WHERE email = '" . $email . "' AND id != " . sipost('id') . " AND status = 0");

        if ($check) {
            return "duplicate";
        }

        $user_info  = array(
            'first_name'    => $first_name,
            'last_name'     => $last_name,
            'email'         => $email,
            'mobile_no'     => sipost('mobile_no'),
            'password'      => sipost('password'),
            'updated_at'    => current_time('mysql')
        );

        return $wpdb->update("admin", $user_info, array('id' => sipost('id')));
    }

    public function add_admin_user()
    {
        global $wpdb;

        if (!sipost('first_name') || !sipost('last_name') || !sipost('email') || !sipost('password')) {
            return false;
        }

        $first_name = ucwords(sipost('first_name'));
        $last_name  = ucwords(sipost('last_name'));
        $email      = strtolower(sipost('email'));

        $check = $wpdb->get_var("SELECT id FROM admin WHERE email = '" . $email . "' AND status = 0");

        if ($check) {
            return "duplicate";
        }

        $user_info  = array(
            'first_name'    => $first_name,
            'last_name'     => $last_name,
            'email'         => $email,
            'mobile_no'     => sipost('mobile_no'),
            'password'      => sipost('password'),
            'role_id'       => 1,
            'is_active'     => 1,
            'created_at'    => current_time('mysql')
        );

        return $wpdb->insert("admin", $user_info);
    }

    public function get_track_log($form_id = '')
    {
        global $wpdb;

        $AND = '';
        if (!IS_ADMIN) {

            $AND = " AND user_id = '" . $_SESSION['admin_id'] . "'";
        }

        return $wpdb->get_results("SELECT * FROM track_log WHERE form_id = '" . $form_id . "'" . $AND . " ORDER BY id DESC");
    }

    public function get_advisor_activity_list($user_id = '')
    {
        global $wpdb;

        return $wpdb->get_results("SELECT * FROM track_log WHERE user_id = '" . $user_id . "' ORDER BY id DESC");
    }

    public function create_track_log_activity($advisor_id, $form_id, $form_name, $action, $before = array(), $after = array(), $message = '', $user_type = '')
    {

        global $wpdb;

        $form_id = (isset($_POST['form_id'])) ? $_POST['form_id'] : $form_id;

        if (!$form_id && !ADMIN_USER_ID) {
            return;
        }

        $log_data = array(
            'logged_id'         => ADMIN_USER_ID,
            'user_id'           => $advisor_id,
            'form_id'           => $form_id,
            'form_name'         => $form_name,
            'form_action'       => $action,
            'before'            => maybe_serialize($before),
            'after'             => maybe_serialize($after),
            'message'           => $message,
            'action_date'       => date('Y-m-d'),
            'user_type'         => $user_type,
            'created_at'        => current_time('mysql'),
            'ip'                => get_ip(),
        );

        return $wpdb->insert('track_log', $log_data);
    }

    public function create_mail_log($user_id, $email, $mail_type = '', $user_type = '')
    {
        global $wpdb;

        $mail_log_info = array(
            "logged_id"     => $_SESSION['fbs_admin_id'],
            "user_id"       => $user_id,
            "email"         => $email,
            "mail_type"     => $mail_type,
            "user_type"     => $user_type,
            "created_at"    => current_time('mysql')
        );

        return $wpdb->insert("mail_log", $mail_log_info);
    }

    // Checked Currenty Admin Login or Not If Not Then Redirect Login page
    public function check_login()
    {

        if (!$_SESSION || !$_SESSION['is_fbs_admin_logged_id'] || !$_SESSION['fbs_admin_id']) {

            if (wp_doing_ajax()) {

                $error = new WP_Error('not_logged_in', 'User is not logged in.');
                wp_send_json_error($error);
            }

            wp_redirect(admin_url('index.php'));
            exit;
        }

        return true;
    }


    // Get All Information About Current Loged Admin
    public function get_login_admin_info($admin_id = '')
    {

        global $wpdb;

        $admin_id = (isset($_SESSION['fbs_admin_id'])) ? $_SESSION['fbs_admin_id'] : $admin_id;

        if (!$admin_id) {
            return array();
        }

        return $wpdb->get_row($wpdb->prepare('SELECT * FROM admin WHERE id = %d', $admin_id));
    }


    // Checked Admin Available or Not If Available then make login process
    public function login($user_name, $password, $remember_login = false)
    {

        global $wpdb;

        $admin_data = $wpdb->get_row("SELECT id, email, mobile_no, password, role_id FROM admin WHERE ( LOWER(email) = '" . trim(strtolower($user_name)) . "' ) AND status = 0 AND is_active = 1");

        if ($admin_data) {

            if ($admin_data->password === md5($password . AUTH_SALT)) {

                if ($remember_login) {
                    @setcookie('fbs_admin_mail', $admin_data->email, time() + (86400 * 10), '/'); // 86400 = 1 day
                } else {
                    if (isset($_COOKIE['fbs_admin_mail'])) {
                        @setcookie('fbs_admin_mail', '', time() - 3600, '/');
                    }
                }

                $_SESSION['is_fbs_admin_logged_id'] = true;
                $_SESSION['fbs_admin_id']           = $admin_data->id;
                $_SESSION['fbs_role_id']            = $admin_data->role_id;

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

        unset($_SESSION['fbs_admin_id']);
        unset($_SESSION['is_fbs_admin_logged_id']);
        session_unset();
        session_destroy();

        return true;
    }

    /************* Meta admin ********************/


    /**
     * add/update admin_meta table
     * 
     */
    public function update_admin_meta($admin_id, $meta_key = '', $meta_value = '')
    {

        global $wpdb;

        if (!$meta_key || !$admin_id) {
            return false;
        }

        $meta_id = $wpdb->get_var($wpdb->prepare('SELECT meta_id FROM admin_meta WHERE admin_id = %d AND meta_key = %s', $admin_id, $meta_key));

        if ($meta_id) { // Update 
            $wpdb->update('admin_meta', array('meta_value' => $meta_value), array('meta_id' => $meta_id));
            return true;
        } else { // Insert 
            $admin_meta_data = array(
                'admin_id'   => $admin_id,
                'meta_key'   => $meta_key,
                'meta_value' => $meta_value,
            );

            $wpdb->insert('admin_meta', $admin_meta_data);
            return true;
        }
    }

    /**
     * Get Perticular meta data admin_meta table
     */
    public function get_admin_meta($admin_id, $meta_key = '')
    {

        global $wpdb;

        if ($meta_key && !empty($meta_key)) {   // get one field 
            return $wpdb->get_var($wpdb->prepare('SELECT meta_value FROM admin_meta WHERE admin_id = %d AND meta_key = %s', $admin_id, $meta_key));
        } else { // get all fields 
            return $wpdb->get_results($wpdb->prepare('SELECT * FROM admin_meta WHERE admin_id = %d', $admin_id), ARRAY_N);
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

function Admin()
{
    return Admin::get_instance();
}

Admin();
