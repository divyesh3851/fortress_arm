<?php
require '../../config.php';

$data = array();

$totalRecords = $wpdb->get_var('SELECT COUNT( * ) FROM designation WHERE status = 0');

$totalRecordwithFilter = $wpdb->get_var('SELECT COUNT( * ) FROM designation WHERE status = 0');

$designation_list   = $wpdb->get_results('SELECT * FROM designation WHERE status = 0 ORDER BY id DESC');

$i = 1;
foreach ($designation_list as $designation_result) {

    $data[] = array(
        'record_id'     => $designation_result->id,
        'name'          => $designation_result->initials . ' - ' . $designation_result->name,
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

    $searchQuery = ' AND ( name LIKE "%' . $searchValue . '%" OR initials LIKE "%' . $searchValue . '%" ) ';

    $_SESSION['search_designation'] = $searchQuery;
} else {

    unset($_SESSION['search_designation']);
}

// Fetch records 
$data = array();

$totalRecords = $wpdb->get_var('SELECT COUNT( * ) FROM designation WHERE status = 0 ' . $AND);

$totalRecordwithFilter = $wpdb->get_var('SELECT COUNT( * ) FROM designation WHERE status = 0 ' . $AND . '  ' . $searchQuery);

$designation_list   = $wpdb->get_results('SELECT * FROM designation WHERE status = 0 ' . $AND . ' ' . $searchQuery . ' ORDER BY ' . $columnName . ' ' . $columnSortOrder . ' LIMIT ' . $row . ',' . $rowperpage);

$i = 1;
foreach ($designation_list as $designation_result) {

    $data[] = array(
        'record_id'     => $designation_result->id,
        'name'          => $designation_result->initials . ' - ' . $designation_result->name,
    );

    $i++;
}
echo json_encode($data);
