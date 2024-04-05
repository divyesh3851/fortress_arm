<?php
require '../../config.php';

$data = array();

$totalRecords = $wpdb->get_var('SELECT COUNT( * ) FROM markets WHERE status = 0');

$totalRecordwithFilter = $wpdb->get_var('SELECT COUNT( * ) FROM markets WHERE status = 0');

$market_list   = $wpdb->get_results('SELECT * FROM markets WHERE status = 0 ORDER BY id DESC');

$i = 1;
foreach ($market_list as $result) {

    $data[] = array(
        'record_id'     => $result->id,
        'type'          => $result->type,
    );

    $i++;
}
echo json_encode($data);
die();
