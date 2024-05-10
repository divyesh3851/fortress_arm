<?php

if (!session_id()) {
	@session_start();
}

// Site URL & DIR #
define('SITE_URL', 'http://localhost/fortress_arm'); // Write URL without /

define('ADMIN_URL', 'http://localhost/fortress_arm/admin'); // Write URL without /

define('SITE_DIR', __DIR__); // This will return path without /

define('SITE_ADMIN_DIR', SITE_DIR . '/admin');

define('APPS_DIR', SITE_DIR . '/apps');

define('SITE_TITLE', 'Fortress Brokerage Solutions');

define('AJAX_URL', SITE_URL . '/ajax.php');

// Database info #
define('DB_HOST', 'localhost');

define('DB_USER', 'root');

define('DB_PASSWORD', '');

define('DB_NAME', 'fortress_arm');

// General configuration #
define('AUTH_SALT', 'RzX6*?HM#Lfb2JujZMyTWP.Kfp{FggQ+IVt~6:aMwO+ky=spPg,/g(wEf;Ek?*~/');

define('RECORD_PER_PAGE', 20);


// Load version
require_once SITE_DIR . '/version.php';

// Load dependency
require_once SITE_DIR . '/load.php';

define('FBS_LOGO', site_url() . '/assets/images/logo_blue.png');
define('FBS_FIRST_NAME', 'Ashleigh');
define('FBS_LAST_NAME', 'White');
define('FBS_PROFESSIONAL_TITLE', 'Direct Life Sales');
define('FBS_PHONE_NO', '678-322-3040');
define('FBS_EMAIL', 'info@fortressbrokerage.com');

ini_set('display_errors', 1);
