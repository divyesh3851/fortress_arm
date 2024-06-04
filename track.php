<?php
require 'config.php';

$data = json_decode(file_get_contents('php://input'), true);

$page = $data['page'];
$referrer = $data['referrer'];
$user_ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
/*
$page = $_SERVER['REQUEST_URI'];
$referrer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$user_ip = $_SERVER['REMOTE_ADDR'];
$user_agent = $_SERVER['HTTP_USER_AGENT'];
*/
$wpdb->insert(
    "page_analytics",
    array(
        "page"      => $page,
        "referrer"  => $referrer,
        "user_ip"   => $user_ip,
        "user_agent" => $user_agent,
    )
);
