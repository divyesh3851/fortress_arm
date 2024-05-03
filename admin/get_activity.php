<?php
require '../config.php';
Admin()->check_login();

$get_today_activity = Advisor()->get_today_activity();

$get_advisor_upcoming_activity_list = Advisor()->get_upcoming_activity($_SESSION['fbs_arm_admin_id']);

$event_list_array = array();

foreach ($get_today_activity as $activity_result) {
    $event_list_array[] = array(
        "id"        => $activity_result->id,
        "title"     => $activity_result->title,
        "start"     => $activity_result->activity_date,
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
        "description" => $activity_result->note,
        "className" => "border-warning bg-warning text-inverse-success",
        "location" => $activity_result->location,
    );
}
echo json_encode($event_list_array);
die();
