<?php
require_once '../config.php';

// logout function in Admin Class
if (Admin()->logout()) {

	wp_redirect(site_url('/admin'));
	die();
}
