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

        add_action('wp_ajax_get_all_admin_user_list_role_wise', array($this, 'get_all_admin_user_list_role_wise'));

        add_action('wp_ajax_admin_role_delete', array($this, 'admin_role_delete'));

        add_action('wp_ajax_global_search', array($this, 'global_search'));
    }

    public function global_search()
    {
        global $wpdb;

        if (isset($_SESSION['fbs_advisor_id'])) {
            $user_id = $_SESSION['fbs_advisor_id'];
            $user_type = 'advisor';
        } else if (isset($_SESSION['fbs_arm_admin_id'])) {
            $user_id = $_SESSION['fbs_arm_admin_id'];
            $user_type = 'admin';
        }

        $search_result = $wpdb->get_results("SELECT * FROM important_links WHERE user_id = " . $user_id . " AND user_type = '" . $user_type . "' AND ( name LIKE '%" . sipost('search_text') . "%' OR url LIKE '" . sipost('search_text') . "') ");

        echo json_encode(array("links" => $search_result));
        die();
    }

    public function admin_role_delete($role_id = '')
    {

        global $wpdb;

        $role_id = isset($_POST['role_id']) ? $_POST['role_id'] : $role_id;

        if (!$role_id) {
            return false;
        }

        $wpdb->delete('admin_role', array('role_id' => $role_id));

        Admin()->create_track_log_activity($_SESSION['fbs_arm_admin_id'], sipost('role_id'), 'role delete', 'role_delete', '', '', 'role has been delete', 'admin');

        return true;
    }

    public function get_all_admin_user_list_role_wise($role_id = '', $status = 0)
    {

        global $wpdb;

        $role_id = (sipost('role_id')) ? sipost('role_id') : $role_id;

        if (!$role_id) {
            return false;
        }

        $user_list = $wpdb->get_results($wpdb->prepare('SELECT id, first_name, last_name, email, mobile_no FROM admin WHERE role_id = %d AND status = %d ORDER BY id DESC', $role_id, $status));

        if (sipost('is_ajax')) {
            echo json_encode($user_list);
            die();
        } else {
            return $user_list;
        }
    }

    public function check_for_page_access($page_access, $status = false)
    {

        global $wpdb;

        $admin_role_info = Admin()->get_login_admin_info();

        $all_page_access = ($admin_role_info->role_id) ? Admin()->get_selected_role_data($admin_role_info->role_id)->all_page_access : '';

        if ($status == true) {

            // for admin 
            if (IS_ADMIN) {
                return false;
            }

            // for access all pages
            if ($all_page_access == 'yes') {
                return false;
            }

            // check page allow or not in page open
            if ($admin_role_info->role_id && strpos(Admin()->get_selected_role_data($admin_role_info->role_id)->page_access, $page_access) === false) {
                return true;
            }

            // allow
            return false;
        } else {

            // for admin 
            if (IS_ADMIN) {
                return true;
            }

            // check page menu allow or not in menu bar
            if ($all_page_access == 'yes' || $admin_role_info->role_id == 0 || strpos(Admin()->get_selected_role_data($admin_role_info->role_id)->page_access, $page_access) !== $status) {

                return true;
            }

            // not allow
            return false;
        }
    }

    public function get_selected_role_data($role_id)
    {

        global $wpdb;

        if (!$role_id) {
            return false;
        }

        return $wpdb->get_row($wpdb->prepare('SELECT * FROM admin_role WHERE role_id = %d ', $role_id));
    }

    public function update_role($role_data = array())
    {

        global $wpdb;

        $check_role_type = $wpdb->get_row($wpdb->prepare("SELECT role_id FROM admin_role WHERE role_name = '%s' AND role_id != %d", sipost('role_name'), sipost('role_id')));

        if (!$check_role_type) {

            $page_access = (sipost('page_access')) ? implode(',', sipost('page_access')) : '';

            $role_data = array(
                'role_name'          => sipost('role_name'),
                'all_page_access'    => sipost('all_page_access'),
                'export_data_access' => sipost('export_data_access'),
                'page_access'        => $page_access,
                'updated_at'         => current_time('mysql'),
            );

            $wpdb->update('admin_role', $role_data, array('role_id' => sipost('role_id')));

            Admin()->create_track_log_activity($_SESSION['fbs_arm_admin_id'], sipost('role_id'), 'role update', 'role_update', '', '', 'role has been updated', 'admin');

            return true;
        }

        if ($check_role_type->role_id) {

            return 'duplicate';
        }

        return false;
    }

    public function add_role()
    {
        global $wpdb;

        $check_role_type = $wpdb->get_row($wpdb->prepare("SELECT role_id FROM admin_role WHERE  role_name = '%s' ", sipost('role_name')));

        if (!$check_role_type) {

            $page_access = (sipost('page_access')) ? implode(',', sipost('page_access')) : '';

            $role_data = array(
                'role_name'          => sipost('role_name'),
                'all_page_access'    => sipost('all_page_access'),
                'export_data_access' => sipost('export_data_access'),
                'page_access'        => $page_access,
                'created_at'         => current_time('mysql'),
            );

            $wpdb->insert('admin_role', $role_data);
            $last_id = $wpdb->insert_id;

            if ($last_id) {

                Admin()->create_track_log_activity($_SESSION['fbs_arm_admin_id'], $last_id, 'role add', 'role_add', '', '', 'role has been added', 'admin');

                return true;
            }

            return false;
        }

        if ($check_role_type->role_id) {

            return 'duplicate';
        }

        return false;
    }

    public function get_all_admin_role_list()
    {

        global $wpdb;

        return $wpdb->get_results('SELECT * FROM admin_role ORDER BY `role_id` DESC');
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

    public function update_login_admin_profile($admin_id = '')
    {
        global $wpdb;

        $admin_id = (sipost('admin_id')) ? sipost('admin_id') : $admin_id;

        if (!$admin_id || !sipost('first_name') || !sipost('last_name') || !sipost('email')) {
            return false;
        }

        $first_name = ucwords(sipost('first_name'));
        $last_name  = ucwords(sipost('last_name'));
        $email      = strtolower(sipost('email'));

        $check = $wpdb->get_var("SELECT id FROM admin WHERE email = '" . $email . "' AND id != " . $admin_id . " AND status = 0");

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

            if (move_uploaded_file($file_tmp, SITE_DIR . '/uploads/admin/' . $new_file_name)) {
                $this->update_admin_meta($admin_id, 'profile_img', $new_file_name);
            }
        }

        return $wpdb->update("admin", $user_info, array('id' => $admin_id));
    }

    public function update_admin_user()
    {
        global $wpdb;

        if (!sipost('id') || !sipost('first_name') || !sipost('last_name') || !sipost('email') || !sipost('role_id')) {
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
            'password'      => md5(sipost('password') . AUTH_SALT),
            'state'         => sipost('state'),
            'role_id'       => sipost('role_id'),
            'updated_at'    => current_time('mysql')
        );

        if ($_FILES['profile_img'] && $_FILES['profile_img']['error'] == 0) {

            $file_name  = $_FILES['profile_img']['name'];

            $file_tmp   = $_FILES['profile_img']['tmp_name'];

            $file_type  = $_FILES['profile_img']['type'];

            $ext        = strtolower(end(explode('.', $file_name)));

            $new_file_name    = time() . rand(111, 999) . "." . $ext;

            if (move_uploaded_file($file_tmp, SITE_DIR . '/uploads/admin/' . $new_file_name)) {
                $this->update_admin_meta(sipost('id'), 'profile_img', $new_file_name);
            }
        }

        return $wpdb->update("admin", $user_info, array('id' => sipost('id')));
    }

    public function add_admin_user()
    {
        global $wpdb;

        if (!sipost('first_name') || !sipost('last_name') || !sipost('email') || !sipost('password') || !sipost('role_id')) {
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
            'password'      => md5(sipost('password') . AUTH_SALT),
            'role_id'       => sipost('role_id'),
            'is_active'     => 1,
            'state'         => sipost('state'),
            'created_at'    => current_time('mysql')
        );

        $wpdb->insert("admin", $user_info);
        $last_id = $wpdb->insert_id;

        if ($last_id) {

            if ($_FILES['profile_img'] && $_FILES['profile_img']['error'] == 0) {

                $file_name  = $_FILES['profile_img']['name'];

                $file_tmp   = $_FILES['profile_img']['tmp_name'];

                $file_type  = $_FILES['profile_img']['type'];

                $ext        = strtolower(end(explode('.', $file_name)));

                $new_file_name    = time() . rand(111, 999) . "." . $ext;

                if (move_uploaded_file($file_tmp, SITE_DIR . '/uploads/admin/' . $new_file_name)) {
                    $this->update_admin_meta($last_id, 'profile_img', $new_file_name);
                }
            }

            return true;
        }
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
            "logged_id"     => (isset($_SESSION['fbs_arm_admin_id'])) ? $_SESSION['fbs_arm_admin_id'] : 1, // for cron set 1
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

        if (!$_SESSION || !$_SESSION['is_fbs_arm_admin_login'] || !$_SESSION['fbs_arm_admin_id']) {

            if (wp_doing_ajax()) {

                $error = new WP_Error('not_logged_in', 'User is not logged in.');
                wp_send_json_error($error);
            }

            wp_redirect(admin_url('login'));
            exit;
        }

        return true;
    }


    // Get All Information About Current Loged Admin
    public function get_login_admin_info($admin_id = '')
    {

        global $wpdb;

        $admin_id = (isset($_SESSION['fbs_arm_admin_id'])) ? $_SESSION['fbs_arm_admin_id'] : $admin_id;

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

                $_SESSION['is_fbs_arm_admin_login'] = true;
                $_SESSION['fbs_arm_admin_id']           = $admin_data->id;
                $_SESSION['fbs_arm_role_id']            = $admin_data->role_id;

                return 'success';
            } else {
                return 'password_wrong';
            }
        }

        return 'email_not_found';
    }

    public function update_password($key)
    {
        global $wpdb;

        if (!$key) {
            return false;
        }

        $user_info = $wpdb->get_row("SELECT id FROM admin WHERE reset_password_key = '" . $key . "'");

        if (!$user_info) {
            return false;
        }

        $password = md5(sipost('password') . AUTH_SALT);

        $status = $wpdb->update("admin", array("password" => $password, "updated_at" => current_time('mysql')), array("id" => $user_info->id));

        if ($status) {

            $wpdb->update("admin", array("reset_password_key" => ''), array("id" => $user_info->id));

            return true;
        }

        return false;
    }

    public function send_reset_password_mail($user_id)
    {
        global $wpdb;

        if (!$user_id) {
            return false;
        }

        $user_info = $wpdb->get_row("SELECT first_name, last_name, email FROM admin WHERE id = " . $user_id);

        if (!$user_info) {
            return false;
        }

        $hash_key = generate_hash();

        $subject = "Password Reset";

        $reset_link = site_url() . "/admin/reset-password/" . $hash_key;

        $mail_body = "Hi " . $user_info->first_name . ' ' . $user_info->last_name . ',<br><br>';

        $mail_body .= "To reset your password, click on the below link <br>";

        $mail_body .= $reset_link . "<br><br>";

        $mail_body .= FBS_FIRST_NAME . ' ' . FBS_LAST_NAME . '<br>';
        $mail_body .= '<img src="' . FBS_LOGO . '"><br>';
        $mail_body .= '<a href="tel:' . FBS_PHONE_NO . '">' . FBS_PHONE_NO . '</a><br>';
        $mail_body .= FBS_EMAIL;

        $_SESSION['use_smtp'] = true;
        $status = send_mail($user_info->email, $subject, $mail_body);
        if ($status) {
            $wpdb->update("admin", array("reset_password_key" => $hash_key), array("id" => $user_id));
        }
        unset($_SESSION['use_smtp']);

        return true;
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

        unset($_SESSION['fbs_arm_admin_id']);
        unset($_SESSION['is_fbs_arm_admin_login']);
        unset($_SESSION['fbs_arm_role_id']);

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
