<?php
require_once '../config.php';

require_once SITE_DIR . '/vendor/autoload.php';

$client = new Google_Client();
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(CALENDAR_REDIRECT_URL);
$client->addScope(Google_Service_Calendar::CALENDAR);

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    Admin()->update_admin_meta($_SESSION['fbs_arm_admin_id'], 'google_auth_access_token', $token['access_token']);
    wp_redirect(site_url() . '/admin/calendar');
    exit;
} else {
    $authUrl = $client->createAuthUrl();
    wp_redirect($authUrl);
    exit;
    //echo "<a href='$authUrl'>Connect with Google Calendar</a>";
}
