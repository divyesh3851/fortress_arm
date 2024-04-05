<?php
/**
 * Executing Ajax process.
 *
 * @since 2.1.0
 */
define( 'DOING_AJAX', true );
define( 'WP_ADMIN', false );

/** Load WordPress Bootstrap */
require_once __DIR__ . '/config.php';

/** Allow for cross-domain requests (from the front end). */
send_origin_headers();

header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );
header( 'X-Robots-Tag: noindex' );

// Require an action parameter.
if ( empty( $_REQUEST['action'] ) ) {
	wp_die( '0', 400 );
}

send_nosniff_header();
nocache_headers();

$action = ( isset( $_REQUEST['action'] ) ) ? $_REQUEST['action'] : '';

// If no action is registered, return a Bad Request response.
if ( ! has_action( "wp_ajax_{$action}" ) ) {
	wp_die( '0', 400 );
}

do_action( "wp_ajax_{$action}" );

// Default status.
wp_die( '0' );
