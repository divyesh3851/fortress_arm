<?php
require '../config.php';

$data = array();

$important_links_list   = $wpdb->get_results('SELECT * FROM important_links WHERE user_id = ' . siget('user_id') . ' AND user_type = "' . siget('user_type') . '" ORDER BY id DESC');

foreach ($important_links_list as $result) {

    $data[] = array(
        'record_id' => $result->id,
        'name'      => $result->name,
        'url'       => '<a href="' . $result->url . '" target="_blank">' . $result->url . '</a>',
        'notes'     => $result->notes,
    );
}
echo json_encode($data);
die();
