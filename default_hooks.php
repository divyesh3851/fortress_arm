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
