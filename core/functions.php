<?php
// functions
function print_rr( $content = '', $subject = null ) {
	if ( $subject ) {
		echo '<strong>' . $subject . '</strong><br>';
	}

	echo '<pre>';
	print_r( $content );
	echo '</pre>';
}

function siget( $name, $default = '', $array = null ) {
	if ( ! isset( $array ) ) {
		$array = $_GET;
	}

	if ( ! is_array( $array ) ) {
		return $default;
	}

	if ( isset( $array[ $name ] ) ) {
		return $array[ $name ];
	}

	return $default;
}

function sipost( $name, $default = '', $do_stripslashes = true ) {
	if ( isset( $_POST[ $name ] ) ) {
		return $do_stripslashes && function_exists( 'stripslashes_deep' ) ? stripslashes_deep( $_POST[ $name ] ) : $_POST[ $name ];
	}

	return $default;
}

function siar( $array, $name, $default = '' ) {
	if ( ! is_array( $array ) && ! ( is_object( $array ) && $array instanceof ArrayAccess ) ) {
		return $default;
	}

	if ( isset( $array[ $name ] ) ) {
		return $array[ $name ];
	}

	return $default;
}

function siars( $array, $name, $default = '' ) {
	if ( ! is_array( $array ) && ! ( is_object( $array ) && $array instanceof ArrayAccess ) ) {
		return $default;
	}

	$names = explode( '/', $name );
	$val   = $array;

	foreach ( $names as $current_name ) {
		$val = siar( $val, $current_name, $default );
	}

	return $val;
}

function siempty( $name, $array = null ) {
	if ( is_array( $name ) ) {
		return empty( $name );
	}

	if ( ! $array ) {
		$array = $_POST;
	}

	$val = siar( $array, $name );

	return empty( $val );
}

function siblank( $text ) {
	return is_array( $text ) ? empty( $text ) : ( empty( $text ) && strval( $text ) != '0' );
}

function siobj( $obj, $name, $default = '' ) {
	if ( isset( $obj->$name ) ) {
		return $obj->$name;
	}

	return $default;
}

function siexplode( $sep, $string, $count ) {
	$ary = explode( $sep, $string );
	while ( count( $ary ) < $count ) {
		$ary[] = '';
	}

	return $ary;
}

// extended functions
function site_url( $path = '', $scheme = null ) {
	return get_site_url( null, $path, $scheme );
}

function get_site_url( $blog_id = null, $path = '', $scheme = null ) {
	$url = untrailingslashit( SITE_URL ); // get_option( 'siteurl' );

	$url = set_url_scheme( $url, $scheme );

	if ( $path && is_string( $path ) ) {
		$url .= '/' . ltrim( $path, '/' );
	}

	return apply_filters( 'site_url', $url, $path, $scheme, $blog_id );
}

function admin_url( $path = '', $scheme = 'admin' ) {
	return get_admin_url( null, $path, $scheme );
}

function get_admin_url( $blog_id = null, $path = '', $scheme = 'admin' ) {
	$url = get_site_url( $blog_id, 'admin/', $scheme );

	if ( $path && is_string( $path ) ) {
		$url .= ltrim( $path, '/' );
	}

	return apply_filters( 'admin_url', $url, $path, $blog_id, $scheme );
}

function set_url_scheme( $url, $scheme = null ) {
	$orig_scheme = $scheme;

	if ( ! $scheme ) {
		$scheme = is_ssl() ? 'https' : 'http';
	} elseif ( 'admin' === $scheme || 'login' === $scheme || 'login_post' === $scheme || 'rpc' === $scheme ) {
		$scheme = is_ssl() || force_ssl_admin() ? 'https' : 'http';
	} elseif ( 'http' !== $scheme && 'https' !== $scheme && 'relative' !== $scheme ) {
		$scheme = is_ssl() ? 'https' : 'http';
	}

	$url = trim( $url );
	if ( substr( $url, 0, 2 ) === '//' ) {
		$url = 'http:' . $url;
	}

	if ( 'relative' === $scheme ) {
		$url = ltrim( preg_replace( '#^\w+://[^/]*#', '', $url ) );
		if ( '' !== $url && '/' === $url[0] ) {
			$url = '/' . ltrim( $url, "/ \t\n\r\0\x0B" );
		}
	} else {
		$url = preg_replace( '#^\w+://#', $scheme . '://', $url );
	}

	return apply_filters( 'set_url_scheme', $url, $scheme, $orig_scheme );
}

function home_url( $path = '', $scheme = null ) {
	return get_site_url( null, $path, $scheme );
}

function network_home_url( $path = '', $scheme = null ) {
	return home_url( $path, $scheme );
}

function network_admin_url( $path = '', $scheme = 'admin' ) {
	return admin_url( $path, $scheme );
}

function rrmdir( $dir ) {
	if ( is_dir( $dir ) ) {
		$objects = scandir( $dir );

		if ( $objects ) {
			foreach ( $objects as $object ) {
				if ( $object !== '.' && $object !== '..' ) {
					if ( filetype( $dir . '/' . $object ) === 'dir' ) {
						rrmdir( $dir . '/' . $object );
					} else {
						@unlink( $dir . '/' . $object );
					}
				}
			}
		}

		reset( $objects );
		@rmdir( $dir );
	}
}
