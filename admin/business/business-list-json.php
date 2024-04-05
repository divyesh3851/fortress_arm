<?php
require '../../config.php';

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

    $searchQuery = ' AND ( first_name LIKE "%' . $searchValue . '%" OR last_name LIKE "%' . $searchValue . '%" OR business_status LIKE "%' . $searchValue . '%" ) ';

    $_SESSION['search_business'] = $searchQuery;
} else {

    unset($_SESSION['search_business']);
}

// Fetch records 
$data = array();

$totalRecords = $wpdb->get_var('SELECT COUNT( * ) FROM business WHERE status = 0 ' . $AND);

$totalRecordwithFilter = $wpdb->get_var('SELECT COUNT( * ) FROM business WHERE status = 0 ' . $AND . '  ' . $searchQuery);

$business_list   = $wpdb->get_results('SELECT * FROM business WHERE status = 0 ' . $AND . ' ' . $searchQuery . ' ORDER BY ' . $columnName . ' ' . $columnSortOrder . ' LIMIT ' . $row . ',' . $rowperpage);

$i = 1;
foreach ($business_list as $business_result) {

    $profile_img = Business()->get_business_meta($business_result->id, 'profile_img');

    $profile_img = '<!--begin:: Avatar -->
                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                        <a href="">
                            <div class="symbol-label">
                                <img src="' . SITE_URL . '/uploads/business/' . $profile_img . '" alt="' . $business_result->first_name . ' ' . $business_result->last_name . '" class="w-100">
                            </div>
                        </a>
                    </div>
                    <!--end::Avatar-->';

    $name = '<!--begin::User details-->
            <div class="d-flex flex-column">
                <a href="" class="text-gray-800        text-hover-primary mb-1">' . $business_result->first_name . ' ' . $business_result->last_name . '</a>
                <span>' . $business_result->email . '</span>
            </div>
            <!--begin::User details-->';

    $business_status = '';
    if ($business_result->business_status == '1') {
        $business_status = '<div class="badge badge-light-success fw-bold">New</div>';
    } else if ($business_result->business_status == '2') {
        $business_status = '<div class="badge badge-light-primary fw-bold">Cold</div>';
    } else if ($business_result->business_status == '3') {
        $business_status = '<div class="badge badge-light-warning fw-bold">Warm</div>';
    } else if ($business_result->business_status == '4') {
        $business_status = '<div class="badge badge-light-danger fw-bold">Hot</div>';
    }

    $data[] = array(
        'record_id'     => $business_result->id,
        //'profile'     => $profile_img, 
        'name'          => $profile_img . ' ' . $name,
        'mobile_no'     => $business_result->mobile_no,
        'status'        => $business_status,
        'state'         => $business_result->state,
        'created_at'    => $business_result->created_at,
    );

    $i++;
}
/*
$response = array(
    //'recordsTotal'      => $totalRecords,
    //'recordsFiltered'   => $totalRecordwithFilter,
    'data'  => $data,
);*/

echo json_encode($data);
die();
