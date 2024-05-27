<?php

// Load dependency
require_once SITE_DIR . '/core/settings.php';

// Load functions
require_once SITE_DIR . '/functions.php';

// Load classes #
require_once SITE_DIR . '/classes/class-settings.php';

require_once SITE_DIR . '/classes/class-admin.php';

require_once SITE_DIR . '/classes/class-advisor.php';

require_once SITE_DIR . '/classes/class-social.php';

//require_once SITE_DIR . '/classes/class-business.php';

// Define Admin Vars
$admin_user = Admin()->get_login_admin_info();

define('ADMIN_USER_ID', $admin_user ? $admin_user->id : '');

define('IS_ADMIN', $admin_user ? $admin_user->is_master : '');

define('CURRENT_USER_NAME', $admin_user ? $admin_user->first_name . ' ' . $admin_user->last_name : '');

// Load modules hook
do_action('cms_load_modules');

// Load default hooks
require_once SITE_DIR . '/default_hooks.php';

// init
do_action('init');
