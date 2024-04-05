<?php
require '../../config.php';

$data = array();

$totalRecords = $wpdb->get_var('SELECT COUNT( * ) FROM license_type WHERE status = 0');

$totalRecordwithFilter = $wpdb->get_var('SELECT COUNT( * ) FROM license_type WHERE status = 0');

$license_type_list   = $wpdb->get_results('SELECT * FROM license_type WHERE status = 0 ORDER BY id DESC');

$i = 1;
foreach ($license_type_list as $type_result) {

    $data[] = array(
        'record_id'     => $type_result->id,
        'type'          => $type_result->type,
    );

    $i++;
}
echo json_encode($data);
die();

// Read value
$draw            = siget('draw');
$row             = siget('start');
$rowperpage      = siget('length'); // Rows display per page
$columnIndex     = (siget('order')) ? siget('order')[0]['column'] : ''; // Column index
$columnName      = (siget('columns') && $columnIndex) ? siget('columns')[$columnIndex]['data'] : 'id'; // Column name
$columnSortOrder = (siget('order')) ? siget('order')[0]['dir'] : ''; // asc or desc
$searchValue     = (siget('search')) ? trim(siget('search')['value']) : ''; // Search value
$AND             = '';


// Search
$searchQuery      = ' ';
if ($searchValue != '') {

    $searchQuery = ' AND ( type LIKE "%' . $searchValue . '%" ) ';

    $_SESSION['search_type'] = $searchQuery;
} else {

    unset($_SESSION['search_type']);
}

// Fetch records 
$data = array();

$totalRecords = $wpdb->get_var('SELECT COUNT( * ) FROM license_type WHERE status = 0 ' . $AND);

$totalRecordwithFilter = $wpdb->get_var('SELECT COUNT( * ) FROM license_type WHERE status = 0 ' . $AND . '  ' . $searchQuery);

$license_type_list   = $wpdb->get_results('SELECT * FROM license_type WHERE status = 0 ' . $AND . ' ' . $searchQuery . ' ORDER BY ' . $columnName . ' ' . $columnSortOrder . ' LIMIT ' . $row . ',' . $rowperpage);

$i = 1;
foreach ($license_type_list as $type_result) {

    $data[] = array(
        'record_id'     => $type_result->id,
        'type'          => $type_result->type,
    );

    $i++;
}
echo json_encode($data);
