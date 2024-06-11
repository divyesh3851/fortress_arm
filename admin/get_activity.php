<?php
require '../config.php';
require_once SITE_DIR . '/vendor/autoload.php';

Admin()->check_login();

$get_today_activity = Advisor()->get_today_activity($_SESSION['fbs_arm_admin_id']);

$get_advisor_upcoming_activity_list = Advisor()->get_upcoming_activity($_SESSION['fbs_arm_admin_id']);

$event_list_array = array();

foreach ($get_today_activity as $activity_result) {
    $event_list_array[] = array(
        "id"        => $activity_result->id,
        "title"     => $activity_result->title,
        "start"     => $activity_result->activity_date,
        "activity_date" => date("m/d/Y", strtotime($activity_result->activity_date)),
        "start_time"    => $activity_result->start_time,
        "end_time"      => $activity_result->end_time,
        "recurring"     => $activity_result->recurring,
        "type"          => $activity_result->type,
        "description" => $activity_result->note,
        "className" => "border-primary bg-primary text-inverse-success",
        "location" => $activity_result->location,
    );
}

foreach ($get_advisor_upcoming_activity_list as $activity_result) {
    $event_list_array[] = array(
        "id"        => $activity_result->id,
        "title"     => $activity_result->title,
        "start"     => $activity_result->activity_date,
        "activity_date" => date("m/d/Y", strtotime($activity_result->activity_date)),
        "start_time"    => $activity_result->start_time,
        "end_time"      => $activity_result->end_time,
        "recurring"     => $activity_result->recurring,
        "type"          => $activity_result->type,
        "description" => $activity_result->note,
        "className" => "border-warning bg-warning text-inverse-success",
        "location" => $activity_result->location,
    );
}

$google_auth_access_token = Admin()->get_admin_meta($_SESSION['fbs_arm_admin_id'], 'google_auth_access_token');

if ($google_auth_access_token && CLIENT_ID && CLIENT_SECRET && CALENDAR_REDIRECT_URL && CALENDAR_ID) {

    $client = new Google_Client();
    $client->setClientId(CLIENT_ID);
    $client->setClientSecret(CLIENT_SECRET);
    $client->setRedirectUri(CALENDAR_REDIRECT_URL);
    $client->addScope(Google_Service_Calendar::CALENDAR);

    $client->setAccessToken($google_auth_access_token);

    $service = new Google_Service_Calendar($client);

    $optParams = array(
        'maxResults' => 10,
        'orderBy' => 'startTime',
        'singleEvents' => true,
        'timeMin' => date('c'),
    );

    $calendarId = CALENDAR_ID;

    $results = $service->events->listEvents($calendarId, $optParams);

    if (count($results->getItems()) >= 1) {
        foreach ($results->getItems() as $event) {

            $start = $event->start->dateTime;
            if (empty($start)) {
                $start = $event->start->date;
            }

            $event_list_array[] = array(
                "id"        => '',
                "title"     => $event->getSummary(),
                "start"     => $event->start->date,
                "activity_date" => date("m/d/Y", strtotime($event->start->date)),
                "start_time"    => $start,
                "end_time"      => '',
                "recurring"     => '',
                "type"          => '',
                "description" => $event->getDescription(),
                "className" => "border-warning bg-warning text-inverse-success",
                "location" => $event->location,
            );
        }
    }
}

echo json_encode($event_list_array);
die();
