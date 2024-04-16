<?php
require_once '../config.php';

// logout function in advisor Class
if (Advisor()->logout()) {

	wp_redirect(site_url('/advisor'));
	die();
}
