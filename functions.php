<?php
// Write all functions here including add_action and all stuff
// var functions
function base64url_encode($data)
{
	return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

function base64url_decode($data)
{
	return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}

function date2mysql($date = '', $is_only_date = false)
{
	if ($date == '' && $is_only_date) {
		return '0000-00-00';
	} elseif ($date == '' && !$is_only_date) {
		return '0000-00-00 00:00:00';
	}

	$date = str_replace('/', '-', $date);
	$date = str_replace('.', '-', $date);

	if ($is_only_date) {
		return date('Y-m-d', strtotime($date));
	} else {
		return date('Y-m-d H:i:s', strtotime($date));
	}
}
/*
function view_full_date( $date = '', $is_only_date = false ) {
	if ( $date == '' && $is_only_date ) {
		return '';
	} elseif ( $date == '' && ! $is_only_date || $date == '0000-00-00 00:00:00' && ! $is_only_date ) {
		return '';
	}

	$date = str_replace( '/', '-', $date );
	$date = str_replace( '.', '-', $date );

	if ( $is_only_date ) {
		return date( 'Y-m-d', strtotime( $date ) );
	} else {
		return date( 'd-m-Y H:i:s', strtotime( $date ) );
	}
}*/

function view_full_date($date = '', $with_time_ago = false, $full = false)
{
	if ($date == '') {
		return '';
	} elseif ($date == '' || $date == '0000-00-00 00:00:00') {
		return '';
	}

	$date = str_replace('/', '-', $date);
	$date = str_replace('.', '-', $date);

	if ($with_time_ago) {

		$now  = new DateTime();
		$ago  = new DateTime($date);
		$diff = $now->diff($ago);

		$diff->w  = floor($diff->d / 7);
		$diff->d -= $diff->w * 7;

		$type = array(
			'y' => 'Year',
			'm' => 'Month',
			'w' => 'Week',
			'd' => 'Day',
			'h' => 'Hour',
			'i' => 'Minute',
			's' => 'Second',
		);
		foreach ($type as $k => &$v) {
			if ($diff->$k) {
				$v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
			} else {
				unset($type[$k]);
			}
		}

		if (!$full) {
			$type = array_slice($type, 0, 1);
		}
		$for_ago = $type ? implode(', ', $type) . ' ago' : 'right now';

		return $for_ago;
	} else {

		return date('d/m/Y H:i:s', strtotime($date));
	}
}

function view_date($date = '')
{
	if ($date == '') {
		return '';
	}

	if ($date == '0000-00-00' || $date == '0000-00-00 00:00:00') {
		return '';
	}

	$date = str_replace('/', '-', $date);
	$date = str_replace('.', '-', $date);

	return date('d/m/Y', strtotime($date));
}

function get_ip()
{
	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}

	return $ip;
}

function user_agent()
{
	return $_SERVER['HTTP_USER_AGENT'];
}

function make_thumbnail($sourcefile, $max_width, $max_height, $endfile, $type)
{
	// Takes the sourcefile (path/to/image.jpg) and makes a thumbnail from it
	// and places it at endfile (path/to/thumb.jpg).

	// Load image and get image size.
	$image_info = getimagesize($endfile);

	if ($image_info['mime'] == 'image/jpeg') {
		$source_image = imagecreatefromjpeg($endfile);
		imagejpeg($endfile, $compress_image, 75);
	} elseif ($image_info['mime'] == 'image/gif') {
		$source_image = imagecreatefromgif($endfile);
		imagegif($endfile, $compress_image, 75);
	} elseif ($image_info['mime'] == 'image/png') {
		$source_image = imagecreatefrompng($endfile);
		imagepng($endfile, $compress_image, 6);
	}

	switch ($type) {
		case 'image/png':
			$img = imagecreatefrompng($sourcefile);
			break;
		case 'image/jpeg':
			$img = imagecreatefromjpeg($sourcefile);
			break;
		case 'image/gif':
			$img = imagecreatefromgif($sourcefile);
			break;
		default:
			return 'Un supported format';
	}

	$width  = imagesx($img);
	$height = imagesy($img);

	if ($width > $height) {
		if ($width < $max_width) {
			$newwidth = $width;
		} else {
			$newwidth = $max_width;
		}

		$divisor   = $width / $newwidth;
		$newheight = floor($height / $divisor);
	} else {
		if ($height < $max_height) {
			$newheight = $height;
		} else {
			$newheight = $max_height;
		}

		$divisor  = $height / $newheight;
		$newwidth = floor($width / $divisor);
	}

	// Create a new temporary image.
	$tmpimg = imagecreatetruecolor($newwidth, $newheight);

	imagealphablending($tmpimg, false);
	imagesavealpha($tmpimg, true);

	// Copy and resize old image into new image.
	imagecopyresampled($tmpimg, $img, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

	// Save thumbnail into a file.
	// compressing the file
	switch ($type) {
		case 'image/png':
			imagepng($tmpimg, $endfile, 0);
			break;
		case 'image/jpeg':
			imagejpeg($tmpimg, $endfile, 100);
			break;
		case 'image/gif':
			imagegif($tmpimg, $endfile, 0);
			break;
	}

	// release the memory
	imagedestroy($tmpimg);
	imagedestroy($img);

	return true;
}

function perpage($count, $record_per_page = '10', $current_page_href)
{
	$output = '';

	if (!isset($_POST['page_no'])) {
		$_POST['page_no'] = 1;
	}

	if ($record_per_page != 0) {
		$pages = ceil($count / $record_per_page);
	}

	if ($pages > 1) {
		if (($_POST['page_no'] - 3) > 0) {
			if ($_POST['page_no'] == 1) {
				$output = $output . '<span id=1 class="current-page">1</span>';
			} else {
				$output = $output . '<input type="submit" name="page_no" class="perpage-link" value="1" />';
			}
		}

		if (($_POST['page_no'] - 3) > 1) {
			$output = $output . '...';
		}

		for ($i = ($_POST['page_no'] - 2); $i <= ($_POST['page_no'] + 2); $i++) {
			if ($i < 1) {
				continue;
			}

			if ($i > $pages) {
				break;
			}

			if ($_POST['page_no'] == $i) {
				$output = $output . '<span id=' . $i . ' class="current-page" >' . $i . '</span>';
			} else {
				$output = $output . '<input type="submit" name="page_no" class="perpage-link" value="' . $i . '" />';
			}
		}

		if (($pages - ($_POST['page_no'] + 2)) > 1) {
			$output = $output . '...';
		}

		if (($pages - ($_POST['page_no'] + 2)) > 0) {
			if ($_POST['page_no'] == $pages) {
				$output = $output . '<span id=' . ($pages) . ' class="current-page">' . ($pages) . '</span>';
			} else {
				$output = $output . '<input type="submit" class="perpage-link" name="page_no" value="' . $pages . '" />';
			}
		}
	}

	return $output;
}

function showperpage($sql, $record_per_page = 20, $current_page_href)
{
	global $wpdb;

	$result  = $wpdb->get_results($sql);
	$count   = $wpdb->num_rows;
	$perpage = perpage($count, $record_per_page, $current_page_href);

	return $perpage;
}

function debug_log($msg = '')
{
	error_log(date('[Y-m-d H:i:s e') . ' IP: ' . $_SERVER['REMOTE_ADDR'] . '] ' . print_r($msg, 1) . PHP_EOL, 3, SITE_DIR . '/logs/log_' . date('d_m_Y') . '.log');
}

function description_excerpt($description, $length)
{
	if (strlen($description) <= $length) {
		return $description;
	} else {
		return substr($description, 0, $length) . ' ...';
	}
}

function send_mail($to, $subject, $body, $attachments = array(), $mail_from = '')
{

	$sender_name  = SITE_TITLE;
	$sender_email = 'info@fortressbrokeragesolution.com';
	$return_email = 'info@fortressbrokeragesolution.com';
	$headers = 'From: ' . $sender_name . ' <' . $sender_email . '>' . "\r\n";

	$headers .= 'Reply-To: ' . $return_email . '' . "\r\n";
	$headers .= 'Return-Path: ' . $return_email . "\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-type: text/html; charset: utf8\r\n";
	$headers .= 'X-Mailer: PHP/' . phpversion() . "\r\n";
	$headers .= "X-Priority: 1 (Highest)\n";
	$headers .= "X-MSMail-Priority: High\n";
	$headers .= "Importance: High\n";

	if (is_array($to)) {
		foreach ($to as $recipient) {
			wp_mail($recipient, $subject, $body, $headers, $attachments);
		}
	} else {
		wp_mail($to, $subject, $body, $headers, $attachments);
	}

	return true;
}


function localize_scripts($object_name, $l10n)
{

	if (is_string($l10n)) {
		$l10n = html_entity_decode($l10n, ENT_QUOTES, 'UTF-8');
	} else {
		foreach ((array) $l10n as $key => $value) {
			if (!is_scalar($value)) {
				continue;
			}

			$l10n[$key] = html_entity_decode((string) $value, ENT_QUOTES, 'UTF-8');
		}
	}

	$script = "var $object_name = " . wp_json_encode($l10n) . ';';

	echo '<script type="text/javascript">' . PHP_EOL . $script . PHP_EOL . '</script>' . PHP_EOL;
}

function replace_merge_fields($string, $merge_fields = array())
{
	if ($merge_fields && is_array($merge_fields)) {
		foreach ($merge_fields as $field_key => $field_value) {
			$string = str_replace($field_key, $field_value, $string);
		}
	}

	return $string;
}

// Random Key Generate
function digit_code($length = "6")
{

	$chars = "01234" . time() . "56789";

	return substr(str_shuffle($chars), 0, $length);
}

/********* check cell number and correct **************/
function formate_cell_number($number = '')
{

	$number = str_replace(' ', '', $number);

	$numlength = strlen((string) $number);

	if (!$number || $numlength < 10) {
		return;
	}

	$first_number = substr($number, 0, 1);

	if ($first_number == 0) {
		$number = substr($number, 1, 999);
	}

	$number = str_replace('+', '', $number);

	$number = ($numlength > 10) ? $number : '39' . $number;

	return $number;
}

// Random Password Generate 
function random_pass($length = "6")
{

	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-=+?";
	$password = substr(str_shuffle($chars), 0, $length);
	$password = $password;
	return $password;
}

function generate_hash()
{
	return md5(rand() . microtime() . time() . uniqid());
}

// function to get  the address
function get_lat_long($address)
{

	$url = "https://maps.google.com/maps/api/geocode/json?key=AIzaSyAtn_6pknHHgNWM5jVyGTgb563QASsfkS0&address=" . urlencode($address);

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$responseJson = curl_exec($ch);
	curl_close($ch);

	$response = json_decode($responseJson);

	if ($response->status == 'OK') {

		$latitude = $response->results[0]->geometry->location->lat;
		$longitude = $response->results[0]->geometry->location->lng;

		return array('latitude' => $latitude, 'longitude' => $longitude);
	}
}

function convert_kg_to_gram($total_kg)
{

	return $total_kg * 1000;
}

function view_kg($total_gram)
{

	return $total_gram / 1000;
}

function create_time_range($start, $end, $interval = '30 mins', $format = '12')
{
	$startTime = strtotime($start);
	$endTime   = strtotime($end);
	$returnTimeFormat = ($format == '12') ? 'g:i a' : 'G:i';

	$current   = time();
	$addTime   = strtotime('+' . $interval, $current);
	$diff      = $addTime - $current;

	$times = array();
	while ($startTime < $endTime) {
		$times[] = date($returnTimeFormat, $startTime);
		$startTime += $diff;
	}
	$times[] = date($returnTimeFormat, $startTime);
	return $times;
}

if (!function_exists('str_contains')) {
	function str_contains(string $haystack, string $needle)
	{
		return empty($needle) || strpos($haystack, $needle) !== false;
	}
}
