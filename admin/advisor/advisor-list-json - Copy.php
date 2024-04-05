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

    $searchQuery = ' AND ( first_name LIKE "%' . $searchValue . '%" OR last_name LIKE "%' . $searchValue . '%" OR advisor_status LIKE "%' . $searchValue . '%" ) ';

    $_SESSION['search_advisor'] = $searchQuery;
} else {

    unset($_SESSION['search_advisor']);
}

// Fetch records 
$data = array();

$totalRecords = $wpdb->get_var('SELECT COUNT( * ) FROM advisor WHERE status = 0 ' . $AND);

$totalRecordwithFilter = $wpdb->get_var('SELECT COUNT( * ) FROM advisor WHERE status = 0 ' . $AND . '  ' . $searchQuery);

$advisor_list   = $wpdb->get_results('SELECT * FROM advisor WHERE status = 0 ' . $AND . ' ' . $searchQuery . ' ORDER BY ' . $columnName . ' ' . $columnSortOrder . ' LIMIT ' . $row . ',' . $rowperpage);

$i = 1;
foreach ($advisor_list as $advisor_result) {

    $profile_img = Advisor()->get_advisor_meta($advisor_result->id, 'profile_img');

    $profile_img = '<!--begin:: Avatar -->
                    <div class="symbol symbol-circle symbol-50px overflow-hidden me-3">
                        <a href="' . site_url() . '/admin/advisor/view-advisor/' . $advisor_result->id . '">
                            <div class="symbol-label">
                                <img src="' . SITE_URL . '/uploads/advisor/' . $profile_img . '" alt="' . $advisor_result->first_name . ' ' . $advisor_result->last_name . '" class="w-100">
                            </div>
                        </a>
                    </div>
                    <!--end::Avatar-->';

    $name = '<!--begin::User details-->
            <div class="d-flex flex-column">
                <a href="' . site_url() . '/admin/advisor/view-advisor/' . $advisor_result->id . '" class="text-gray-800        text-hover-primary mb-1">' . $advisor_result->first_name . ' ' . $advisor_result->last_name . '</a>
                <span>' . $advisor_result->email . '</span>
            </div>
            <!--begin::User details-->';

    $advisor_status = '';
    if ($advisor_result->advisor_status == '1') {
        $advisor_status = '<div class="badge badge-light-success fw-bold">New</div>';
    } else if ($advisor_result->advisor_status == '2') {
        $advisor_status = '<div class="badge badge-light-primary fw-bold">Cold</div>';
    } else if ($advisor_result->advisor_status == '3') {
        $advisor_status = '<div class="badge badge-light-warning fw-bold">Warm</div>';
    } else if ($advisor_result->advisor_status == '4') {
        $advisor_status = '<div class="badge badge-light-danger fw-bold">Hot</div>';
    }

    $lead_source = ($advisor_result->lead_source) ? Settings()->get_selected_lead_source_data($advisor_result->lead_source)->type : '';

    $rating = '<td class="float-end text-end border-0">
    <div class="rating">
        <div class="rating-label checked">
            <i class="ki-duotone ki-star fs-6"></i>
        </div>
        <div class="rating-label checked">
            <i class="ki-duotone ki-star fs-6"></i>
        </div>
        <div class="rating-label checked">
            <i class="ki-duotone ki-star fs-6"></i>
        </div>
        <div class="rating-label checked">
            <i class="ki-duotone ki-star fs-6"></i>
        </div>
        <div class="rating-label checked">
            <i class="ki-duotone ki-star fs-6"></i>
        </div>
    </div> 
</td>';

    $data[] = array(
        'record_id'     => $advisor_result->id,
        'name'          => $profile_img . ' ' . $name,
        'rating'        => $rating,
        'status'        => $advisor_status,
        'city'          => $advisor_result->city,
        'state'         => $advisor_result->state,
        'lead_source'   => $lead_source,
        'created_at'    => $advisor_result->created_at,
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
