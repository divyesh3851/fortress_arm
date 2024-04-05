<?php
$apps = glob( SITE_DIR . '/apps/*', GLOB_ONLYDIR );

$allowed_apps = apply_filters(
	'crm_allowed_apps',
	get_option( 'crm_active_apps', array() )
);
$allowed_apps = array_map( 'strtolower', $allowed_apps );

if ( $apps ) {
	foreach ( $apps as $app ) {
		if ( file_exists( $app . '/index.php' ) && in_array( strtolower( basename( $app ) ), $allowed_apps ) ) {
			include_once $app . '/index.php';
		}
	}
}

unset( $apps );
unset( $allowed_apps );
