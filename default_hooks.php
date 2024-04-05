<?php
// default hooks


/*
*  Store ajax and site url in script variable in all pages
*  That helps to call ajax file while call operation using AJAX
*/
function define_js_variables($page_name = '')
{
	$defaults = array(
		'ajax_url'  => site_url('ajax.php'),
		'site_url'  => site_url(),
		'page_name' => $page_name,
	);

	$defaults = apply_filters('defaults_js_variables', $defaults);

	if (!$defaults || !is_array($defaults)) {
		return;
	}

	// TODO: remove
	echo '<script type="text/javascript">' . PHP_EOL;
	foreach ($defaults as $js_key => $js_var) {
		echo $js_key . ' = "' . $js_var . '";' . PHP_EOL;
	}
	echo '</script>' . PHP_EOL;

	localize_scripts('default_params', $defaults);
}
add_action('after_header_scripts', 'define_js_variables', 10, 1);

function send_mail_using_smtp(&$phpmailer)
{

	if (!isset($_SESSION['use_smtp']) || !$_SESSION['use_smtp']) {
		return;
	}

	if (!empty(get_option('smtp_host')) && !empty(get_option('smtp_user_name')) && !empty(get_option('smtp_password'))) {

		define('USE_SMTP', true);
		define('SMTP_DISABLE_AUTOTLS', true);
		define('SMTP_ALLOW_INSECURE_SSL', true);

		$phpmailer->IsSMTP();
		$phpmailer->Host       = get_option('smtp_host'); //smtp.hostinger.com
		$phpmailer->SMTPSecure = 'ssl';
		$phpmailer->Port       = get_option('smtp_port'); //465
		$phpmailer->SMTPAuth   = true;

		if (defined('SMTP_FROM_EMAIL') && get_option('sender_email')) {
			$phpmailer->From = get_option('sender_email');
		}

		$phpmailer->Username = get_option('smtp_user_name'); //info@ieee-sensors-jcsynergy.org
		$phpmailer->Password = get_option('smtp_password'); //Pass@Info321&admin

		// PHPMailer 5.2.10 introduced this option. However, this might cause issues if the server is advertising TLS with an invalid certificate.
		if (defined('SMTP_DISABLE_AUTOTLS') && SMTP_DISABLE_AUTOTLS) {
			$phpmailer->SMTPAutoTLS = false;
		}

		if (defined('SMTP_ALLOW_INSECURE_SSL') && SMTP_ALLOW_INSECURE_SSL) {
			// Insecure SSL option enabled
			$phpmailer->SMTPOptions = array(
				'ssl' => array(
					'verify_peer'       => false,
					'verify_peer_name'  => false,
					'allow_self_signed' => true,
				),
			);
		}
	}
}
add_action('phpmailer_init', 'send_mail_using_smtp', 30, 1);
