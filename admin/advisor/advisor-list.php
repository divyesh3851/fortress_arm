<?php
require '../../config.php';
$page_name = 'advisor';
$sub_page_name = 'advisor-list';
Admin()->check_login();

require SITE_DIR . '/vendor/autoload.php';

// page permition for admin user
if (Admin()->check_for_page_access("advisor", true)) {
    wp_redirect(add_query_arg('access', 1, site_url('admin/dashboard')));
    die();
}
if (sipost('first_name') || sipost('last_name') || sipost('email')) {

    $response = Advisor()->add_advisor();

    if ($response == 1) {
        $_SESSION['process_success'] = true;
    } elseif ($response == 'duplicate') {
        $_SESSION['process_duplicate'] = true;
    } else {
        $_SESSION['process_fail'] = true;
    }

    wp_redirect(site_url() . '/admin/advisor/advisor-list');
    exit;
}

if (isset($_POST['advisor_export_submit'])) {

    $format = (sipost('format')) ? sipost('format') : '';

    if (!$format) {
        return false;
    }

    $start_date = '';
    $end_date   = '';

    if (sipost('date_range')) {

        $date_range = (sipost('date_range')) ? sipost('date_range') : '';

        list($start_date, $end_date) = explode(" - ", $date_range);

        $start_date = date("Y-m-d", strtotime($start_date));

        $end_date   = date("Y-m-d", strtotime($end_date));
    }

    $get_advisor_list = Advisor()->get_advisor_records_between_two_dates($start_date, $end_date, sipost('advisor_status'));


    if ($format == 'excel') {
        $spreadsheet    = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        $sheet    = $spreadsheet->getActiveSheet();

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray);

        // Set the value of header cell 
        $column         = 1;

        //$highestRow = $sheet->getHighestRow();

        $highestRow     = 1;

        $headings       =  array("No", "Name", "Email", "Mobile No", "City", "State", "Date");

        foreach ($headings as $key  => $heading) {

            $highestColumn    = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
            $sheet->setCellValue($highestColumn . $highestRow, $heading);
            $column++;
        }

        $i = 1;

        foreach ($get_advisor_list as $advisor_result) {

            $created_at = date("m/d/Y", strtotime($advisor_result->created_at));

            $fields     = array($i, $advisor_result->first_name . ' ' . $advisor_result->last_name, $advisor_result->email, $advisor_result->mobile_no, $advisor_result->city, $advisor_result->state, $created_at);

            $column         = 1;
            $highestRow     = $sheet->getHighestRow();
            $highestRow     = $highestRow + 1;

            foreach ($fields as $column_value) {

                $highestColumn    = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
                $sheet->setCellValue($highestColumn . $highestRow, $column_value);
                $column++;
            }

            $i++;
        }

        $filename    = "Advisor List - " . date('m-d-Y') . ".csv";

        // Output an .xlsx file  
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        $writer->save('php://output');
        die();
        exit;
    } else if ($format == 'pdf') {
        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => '5', 'margin_right' => '5', 'margin_top' => '10', 'margin_bottom' => '10', 'margin_header' => '5', 'margin_footer' => '5', 'defaultheaderline' => 0, 'defaulfooterline' => 0]);
        $html = '<html> 
                    <body>
                        <div class="col-md-12">
                            <p class="category" style="text-align:center; font-size: 18px;">
                                <b>Advisor List</b>
                            </p>	
                            <table class="table" width="100%" border="1" cellpadding="4" style="border-collapse: collapse; text-align:left; font-size:13px;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Name</th>
                                        <th>Email</th> 
                                        <th>Mobile No</th>
                                        <th>City</th> 
                                        <th>State</th>    
                                        <th>Date</th>   
                                    </tr>
                                </thead>
                                <tbody>';
        $j = 1;
        foreach ($get_advisor_list as $advisor_result) {

            $created_at = date("m/d/Y", strtotime($advisor_result->created_at));

            $html .= "<tr>
                        <td>" . $j . "</td>
                        <td>" . $advisor_result->first_name . " " . $advisor_result->last_name . "</td>
                        <td>" . $advisor_result->email . "</td>
                        <td>" . $advisor_result->mobile_no . "</td>
                        <td>" . $advisor_result->city . "</td>
                        <td>" . $advisor_result->state . "</td>
                        <td>" . $created_at . "</td> 
                    </tr>";
            $j++;
        }

        $html .= '</tbody>
                            </table>
                        </div>
                    </body>
                 </html>';

        $stylesheet = file_get_contents(site_url() . '/assets/css/pdf.css'); // external css

        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);

        $path = "Advisor List - " . date('Y_m_d') . ".pdf";

        $mpdf->Output($path, 'D');
    }
}

if (isset($_POST['advisor_import_submit'])) {

    if ($_FILES['import_file'] && $_FILES['import_file']['error'] == 0) {

        $csv_file    = $_FILES['import_file']['tmp_name'];

        $handle = fopen($csv_file, 'r');
        $i      = 0;

        while (($data = fgetcsv($handle)) !== FALSE) {

            $i++;

            if ($i == 1) {
                continue;
            }

            if ($data) {

                $first_name = ($data[0]) ? ucfirst($data[0]) : '';
                $last_name  = ($data[1]) ? ucfirst($data[1]) : '';
                $email      = ($data[2]) ? strtolower(trim($data[2])) : '';
                $mobile_no  = ($data[3]) ? $data[3] : '';

                $check_advisor = $wpdb->get_row("SELECT id FROM advisor WHERE ( LOWER(email) = '" . $email . "' ) AND status = 0 ");

                if ($check_advisor) {
                    continue;
                }

                $created_by = '';
                if (isset($_SESSION['fbs_advisor_id'])) {
                    $created_by = $_SESSION['fbs_advisor_id'];
                    $created_by_type = 'advisor';
                } else if (isset($_SESSION['fbs_arm_admin_id'])) {
                    $created_by = $_SESSION['fbs_arm_admin_id'];
                    $created_by_type = 'admin';
                }

                $advisor_data = array(
                    "first_name"    => $first_name,
                    "last_name"     => $last_name,
                    "email"         => $email,
                    "mobile_no"     => $mobile_no,
                    "city"          => $data[4],
                    "created_at"    => current_time('mysql'),
                    "created_by"    => $created_by,
                    "created_by_type"   => $created_by_type,
                );

                $wpdb->insert("advisor", $advisor_data);
                $last_id = $wpdb->insert_id;

                if ($last_id) {
                    Advisor()->update_advisor_meta($last_id, 'profile_img', 'blank.png'); // default profile
                    Admin()->create_track_log_activity($created_by, $last_id, 'advisor import', 'advisor_import', $advisor_info, '', 'advisor has been import', $created_by_type);
                }
            }
        }
    }

    $_SESSION['process_success'] = true;
    wp_redirect(site_url() . '/admin/advisor/advisor-list.php');
    die();
}

$get_state_list = Settings()->get_state_list();

$get_lead_source_list = Settings()->get_lead_source_list();

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/head.php'; ?>
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="<?php echo site_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true" data-kt-app-aside-push-footer="true" class="app-default">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
            } else {
                if (localStorage.getItem("data-bs-theme") !== null) {
                    themeMode = localStorage.getItem("data-bs-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-bs-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::App-->
    <div class="d-flex flex-column flex-root app-root" id="kt_app_root">
        <!--begin::Page-->
        <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
            <!--begin::Header-->
            <?php require SITE_DIR . '/admin/header.php'; ?>
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Sidebar-->
                <?php require SITE_DIR . '/admin/sidebar.php'; ?>
                <!--end::Sidebar-->

                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--begin::Toolbar-->
                        <div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
                            <!--begin::Toolbar container-->
                            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
                                <!--begin::Toolbar wrapper-->
                                <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                                    <!--begin::Page title-->
                                    <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                                        <!--begin::Title-->
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Advisor List</h1>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Page title-->
                                    <!--begin::Actions-->
                                    <div class="">
                                        <?php
                                        $bookmark = Advisor()->check_bookmark(site_url() . '/admin/advisor/advisor-list');

                                        if ($bookmark) { ?>
                                            <i class="bi bi-bookmarks-fill fs-2x cursor-pointer text-primary  bookmark_page" bookmark_url="<?php echo site_url(); ?>/admin/advisor/advisor-list"></i>
                                        <?php } else { ?>
                                            <i class="bi bi-bookmarks fs-2x cursor-pointer text-primary bookmark_page" data-bs-toggle="modal" data-bs-target="#kt_modal_bookmark_link" bookmark_name="Contact List" bookmark_url="<?php echo site_url(); ?>/admin/advisor/advisor-list"></i>
                                        <?php } ?>

                                    </div>
                                    <!--end::Actions-->
                                </div>
                                <!--end::Toolbar wrapper-->
                            </div>
                            <!--end::Toolbar container-->
                        </div>
                        <!--end::Toolbar-->

                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-fluid">
                                <?php if (isset($_SESSION['process_success'])) {
                                    unset($_SESSION['process_success']); ?>
                                    <div class="alert alert-success d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-success  me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-success">The advisor has been save successfully.</h4>
                                        </div>
                                    </div>
                                <?php }

                                if (isset($_SESSION['process_duplicate'])) {
                                    unset($_SESSION['process_duplicate']); ?>
                                    <div class="alert alert-danger d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-danger">The advisor has been already exist.</h4>
                                        </div>
                                    </div>
                                <?php }

                                if (isset($_SESSION['process_fail'])) {
                                    unset($_SESSION['process_fail']); ?>
                                    <div class="alert alert-danger d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-danger">The advisor has been save failed.</h4>
                                        </div>
                                    </div>
                                <?php }

                                if (isset($_SESSION['process_success'])) {
                                    unset($_SESSION['process_success']); ?>

                                    <div class="alert alert-success d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-success  me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-success">The advisor import process has been successfully.</h4>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!--begin::Card-->
                                <div class="card">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0 pt-6">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <!--begin::Search-->
                                            <div class="d-flex align-items-center position-relative my-1">
                                                <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span class="path2"></span></i>
                                                <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Advisor" />
                                            </div>
                                            <!--end::Search-->
                                        </div>
                                        <!--begin::Card title-->
                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            <!--begin::Toolbar-->
                                            <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                                                <!--begin::Filter-->
                                                <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                    <i class="ki-outline ki-filter fs-2"></i>Filter</button>
                                                <!--begin::Menu 1-->
                                                <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                                                    <!--begin::Header-->
                                                    <div class="px-7 py-5">
                                                        <div class="fs-4 text-gray-900 fw-bold">Filter Options</div>
                                                    </div>
                                                    <!--end::Header-->
                                                    <!--begin::Separator-->
                                                    <div class="separator border-gray-200"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Content-->
                                                    <div class="px-7 py-5">
                                                        <!--begin::Input group-->
                                                        <div class="mb-10">
                                                            <!--begin::Label-->
                                                            <label class="form-label fs-5 fw-semibold mb-3">Advisor Status :</label>
                                                            <!--end::Label-->

                                                            <!--begin::Options-->
                                                            <div class="d-flex flex-column flex-wrap fw-semibold" data-kt-docs-table-filter="advisor_status">
                                                                <!--begin::Option-->
                                                                <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                                    <input class="form-check-input" type="radio" name="advisor_status" value="all" checked="checked">
                                                                    <span class="form-check-label text-gray-600">
                                                                        All
                                                                    </span>
                                                                </label>
                                                                <!--end::Option-->

                                                                <!--begin::Option-->
                                                                <?php foreach (Settings()->get_advisor_status_list() as $key => $status_result) { ?>
                                                                    <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                                        <input class="form-check-input" type="radio" name="advisor_status" value="<?php echo $status_result; ?>">
                                                                        <span class="form-check-label text-gray-600">
                                                                            <?php echo $status_result; ?>
                                                                        </span>
                                                                    </label>
                                                                <?php } ?>
                                                                <!--end::Option-->


                                                            </div>
                                                            <!--end::Options-->
                                                        </div>
                                                        <!--end::Input group-->

                                                        <!--begin::Actions-->
                                                        <div class="d-flex justify-content-end">
                                                            <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-docs-table-filter="reset">Reset</button>

                                                            <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-docs-table-filter="filter">Apply</button>
                                                        </div>
                                                        <!--end::Actions-->
                                                    </div>
                                                    <!--end::Content-->
                                                </div>
                                                <!--end::Menu 1-->
                                                <!--end::Filter-->
                                                <!--begin::Export-->
                                                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_advisor_export_modal">
                                                    <i class="ki-outline ki-exit-up fs-2"></i>Export</button>
                                                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_advisor_import_modal">
                                                    <i class="ki-outline ki-exit-down fs-2"></i>Import</button>
                                                <!--end::Export-->
                                                <!--begin::Add Advisor-->
                                                <?php /*
                                                <a href="<?php echo site_url() ?>/admin/advisor/add-advisor" class="btn btn-primary" title="Add Advisor">
                                                    <i class="ki-duotone ki-plus fs-2"></i>
                                                    Add Advisor
                                                </a>
                                                */ ?>
                                                <button type="button" class="btn btn-primary advisor_modal" data-bs-toggle="modal" data-bs-target="#kt_modal_advisor" title="Add Advisor">
                                                    <i class="ki-duotone ki-plus fs-2"></i>
                                                    Add Advisor
                                                </button>
                                                <!--end::Add Advisor-->

                                            </div>
                                            <!--end::Toolbar-->
                                            <!--begin::Group actions-->
                                            <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                                                <div class="fw-bold me-5">
                                                    <span class="me-2" data-kt-docs-table-select="selected_count"></span>Selected
                                                </div>
                                                <button type="button" class="btn btn-danger" data-kt-docs-table-select="delete_selected">Delete Selected</button>
                                            </div>
                                            <!--end::Group actions-->
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Datatable-->
                                        <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
                                            <thead>
                                                <tr class="text-start text-gray-500 fw-bold fs-7  gs-0">
                                                    <th class="w-10px pe-2">
                                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_example_1 .form-check-input" value="1" />
                                                        </div>
                                                    </th>
                                                    <th>Name</th>
                                                    <th>Status</th>
                                                    <th>Rating</th>
                                                    <th>City</th>
                                                    <th>State</th>
                                                    <th>Lead Source</th>
                                                    <th>Contact Added On </th>
                                                    <th class="text-start">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="text-gray-600 fw-semibold">
                                            </tbody>
                                        </table>
                                        <!--end::Datatable-->
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--begin::Wrapper-->
                    </div>
                    <!--end::Content wrapper-->
                    <!--begin::Footer-->
                    <?php require SITE_DIR . '/admin/footer.php'; ?>
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->
                <!--begin::aside-->
                <?php require SITE_DIR . '/admin/right_sidebar.php'; ?>
                <!--end::aside-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->

    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-outline ki-arrow-up"></i>
    </div>
    <!--end::Scrolltop-->

    <!--begin::Modal - Advisor -->
    <div class="modal fade" id="kt_modal_advisor" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-900px">
            <!--begin::Modal content-->
            <div class="modal-content modal-rounded">
                <!--begin::Modal header-->
                <div class="modal-header py-7 d-flex justify-content-between">
                    <!--begin::Modal title-->
                    <h2>Advisor</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body ">
                    <!--begin::Form-->
                    <form id="kt_modal_advisor_form" class="form" method="post" enctype="multipart/form-data">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column scroll-y px-5 px-lg-5">

                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <div class="col-md-4 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Title</label>
                                    <!--end::Label-->
                                    <select name="prefix" id="prefix" data-control="select2" data-placeholder="Select a Title..." class="form-select form-select-solid" data-dropdown-parent="#kt_modal_advisor" required>
                                        <option value="">Select Title</option>
                                        <?php foreach (Settings()->get_name_prefix_list() as $prefix_result) { ?>
                                            <option value="<?php echo $prefix_result; ?>"><?php echo $prefix_result; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">First Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="first_name" id="first_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="First Name" required />
                                    <!--end::Input-->
                                </div>
                                <div class="col-md-4 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Last Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="last_name" id="last_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Last Name" required />
                                    <!--end::Input-->
                                </div>
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <div class="col-md-4 fv-row">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">Company Name</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="company_name" id="company_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Company Name" />
                                    <!--end::Input-->
                                </div>
                                <div class="col-md-4 fv-row">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Lead Source</label>
                                    <!--end::Label-->
                                    <select name="lead_source" id="lead_source" data-control="select2" data-placeholder="Select a Source..." class="form-select form-select-solid is_empty" data-dropdown-parent="#kt_modal_advisor">
                                        <option value="">Select Source</option>
                                        <?php foreach ($get_lead_source_list as $lead_source_result) { ?>
                                            <option value="<?php echo $lead_source_result->id; ?>"><?php echo $lead_source_result->type; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="col-md-4 fv-row">
                                    <!--begin::Label-->
                                    <label class=" fw-semibold fs-6 mb-2">Lead Owner</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="lead_owner" id="lead_owner" data-control="select2" data-placeholder="Select a Lead Owner..." class="form-select form-select-solid is_empty" data-dropdown-parent="#kt_modal_advisor">
                                        <option value="">Select Lead Owner</option>
                                        <?php foreach (Settings()->get_lead_owner_list() as $lead_owner_result) { ?>
                                            <option alue="<?php echo $lead_owner_result->id; ?>"><?php echo $lead_owner_result->name; ?></option>
                                        <?php } ?>
                                    </select>
                                    <!--end::Input-->
                                </div>

                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <div class="col-md-4 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Phone Number</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="mobile_no" id="mobile_no" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Phone Number" required />
                                    <!--end::Input-->
                                </div>
                                <div class="col-md-4 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">Email Address</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="email" name="email" id="email" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Email Address" required />
                                    <!--end::Input-->
                                </div>
                                <div class="col-md-4 fv-row">
                                    <!--begin::Label-->
                                    <label class="required fw-semibold fs-6 mb-2">City</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="city" id="city" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="City" required />
                                    <!--end::Input-->
                                </div>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <div class="col-md-4 fv-row">
                                    <!--begin::Label-->
                                    <label class="fw-semibold fs-6 mb-2">State</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <select name="state" id="state" data-control="select2" data-placeholder="Select a State..." class="form-select form-select-solid is_empty" data-dropdown-parent="#kt_modal_advisor">
                                        <option value="">Select State</option>
                                        <?php foreach ($get_state_list as $state_result) { ?>
                                            <option value="<?php echo $state_result; ?>"><?php echo $state_result; ?></option>
                                        <?php } ?>
                                    </select>
                                    <!--end::Input-->
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center ">
                            <button type="submit" name="save_advisor" id="save_advisor" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--begin::Modal body-->
            </div>
        </div>
    </div>
    <!--end::Modal - Advisor -->


    <!--begin::Modal - Settings-->
    <div class="modal fade" id="kt_modal_user_settings" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog mw-700px p-9">
            <!--begin::Modal content-->
            <div class="modal-content modal-rounded">
                <!--begin::Modal header-->
                <div class="modal-header py-7 d-flex justify-content-between">
                    <!--begin::Modal title-->
                    <h2>Campaign</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body  m-5">
                    <!--begin::Form-->
                    <form id="" class="form" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" class="is_empty">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column  px-5 px-lg-10">

                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <div class="col-md-12 fv-row">
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center pt-10">
                            <button type="submit" name="save_lead_source" id="save_lead_source" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--begin::Modal body-->
            </div>
        </div>
    </div>
    <!--end::Modal - Settings-->

    <!--begin::Modal-->
    <div class="modal fade" id="kt_advisor_export_modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Export Advisor</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_advisor_export_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-10 my-7">
                    <!--begin::Form-->
                    <form id="" class="form" method="post">
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-semibold form-label mb-5">Select Export Format:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select data-control="select2" data-placeholder="Select a format" data-hide-search="true" name="format" class="form-select form-select-solid">
                                <option value="excel">Excel</option>
                                <option value="pdf">PDF</option>
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-semibold form-label mb-5">Select Date Range:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid" name="date_range" placeholder="Pick date range" id="kt_daterangepicker_4" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Row-->
                        <div class="row fv-row mb-15">
                            <!--begin::Label-->
                            <label class="fs-5 fw-semibold form-label mb-5">Advisor Status:</label>
                            <!--end::Label-->
                            <!--begin::Radio group-->
                            <div class="d-flex flex-column">
                                <?php foreach (Settings()->get_advisor_status_list() as $key => $status_result) { ?>
                                    <!--begin::Radio button-->
                                    <label class="form-check form-check-custom form-check-sm form-check-solid mb-3">
                                        <input class="form-check-input" type="checkbox" value="<?php echo $key ?>" name="advisor_status[]" />
                                        <span class="form-check-label text-gray-600 fw-semibold"><?php echo $status_result ?></span>
                                    </label>
                                    <!--end::Radio button-->
                                <?php } ?>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Row-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="advisor_export_cancel" class="btn btn-light me-3">Discard</button>
                            <button type="submit" id="advisor_export_submit" name="advisor_export_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <div class="modal fade" id="kt_advisor_import_modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Import Advisor</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_advisor_export_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-10 my-7">
                    <!--begin::Form-->
                    <form method="post" enctype="multipart/form-data">
                        <!--begin::Input group-->
                        <div class="fv-row col-md-12 mb-7">
                            <!--begin::Label-->
                            <label class="fw-semibold fs-6 mb-2">Upload File</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input type="file" name="import_file" id="import_file" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Upload File" />
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center mt-7">
                            <button type="submit" id="advisor_import_submit" name="advisor_import_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal -->

    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <?php require SITE_DIR . '/footer_script.php'; ?>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="<?php echo site_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--end::Javascript-->
    <script>
        var start = moment().subtract(29, "days");
        var end = moment();

        function cb(start, end) {
            $("#kt_daterangepicker_4").html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
        }

        $("#kt_daterangepicker_4").daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                "Today": [moment(), moment()],
                "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [moment().startOf("month"), moment().endOf("month")],
                "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
            }
        }, cb);

        cb(start, end);

        "use strict";

        // Class definition
        var KTDatatablesServerSide = function() {
            // Shared variables
            var table;
            var dt;
            var filterAdvisor;

            // Private functions
            var initDatatable = function() {
                dt = $("#kt_datatable_example_1").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    order: [
                        [7, 'desc']
                    ],
                    stateSave: true,
                    select: {
                        style: 'multi',
                        selector: 'td:first-child input[type="checkbox"]',
                        className: 'row-selected'
                    },
                    ajax: {
                        url: "<?php echo site_url(); ?>/admin/advisor/advisor-list-ajax.php",
                    },
                    columns: [{
                            data: 'record_id'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'rating'
                        },
                        {
                            data: 'city'
                        },
                        {
                            data: 'state'
                        },
                        {
                            data: 'lead_source'
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: null
                        },
                    ],
                    columnDefs: [{
                            targets: 0,
                            orderable: false,
                            render: function(data) {
                                return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="${data}" />
                            </div>`;
                            }
                        },
                        {
                            target: 1,
                            orderable: false,
                            className: 'd-flex align-items-center'
                        },
                        {
                            target: 2,
                            orderable: false,
                        },
                        {
                            target: 3,
                            orderable: false,
                        },
                        {
                            target: 4,
                            orderable: false,
                        },
                        {
                            target: 5,
                            orderable: false,
                        },
                        {
                            target: 6,
                            orderable: false,
                        },
                        /*{
                            targets: 4,
                            render: function(data, type, row) {
                                return `<img src="${hostUrl}media/svg/card-logos/${row.CreditCardType}.svg" class="w-35px me-3" alt="${row.CreditCardType}">` + data;
                            }
                        },*/
                        {
                            targets: -1,
                            data: null,
                            orderable: false,
                            className: 'text-start',
                            render: function(data, type, row) {
                                return `<div class="d-flex">  
                                            <a href="tel:${data.mobile_no}" data-bs-toggle="tooltip" title="Call Contact">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-3 fw-bold text-gray-700"> 
                                                        <i class="las la-phone-volume fs-2 text-success"></i>
                                                    </div>
                                                </div>
                                            </a> 
                                            <a href="mailto:${data.email}"  data-bs-toggle="tooltip" title="Email Contact">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-2 fw-bold text-gray-700">
                                                        <i class="las la-envelope-open-text fs-2  text-success"></i>
                                                    </div>
                                                </div> 
                                            </a>
                                            <a href="#" id="${data.record_id}" class="menu-link lead_source_modal" data-bs-toggle="modal" data-bs-target="#kt_modal_user_settings" data-kt-docs-table-filter="edit_row">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-3 fw-bold text-gray-700"> 
                                                        <i class="las la-user-cog fs-2 text-success"></i> 
                                                    </div>
                                                </div>
                                            </a> 
                                            <a href="<?php echo site_url(); ?>/admin/advisor/view-advisor/${data.record_id}" data-bs-toggle="tooltip" title="View Quick Info">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-3 fw-bold text-gray-700">
                                                        <i class="las la-eye fs-2 text-primary"></i>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="<?php echo site_url(); ?>/admin/advisor/edit-advisor/${data.record_id}" data-bs-toggle="tooltip" title="Edit Contact">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-2 fw-bold text-gray-700">
                                                        <i class="las la-user-edit fs-2 text-primary"></i>
                                                    </div>
                                                </div> 
                                            </a>
                                            <a href="#" data-kt-docs-table-filter="delete_row" advisor_id="${data.record_id}" data-bs-toggle="tooltip" title="Delete Contact">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-2 fw-bold text-gray-700">
                                                        <i class="las la-trash-alt fs-2 text-primary"></i>
                                                    </div>
                                                </div> 
                                            </a>  
                                    </div>`;
                            },
                        },
                    ],
                    // Add data-filter attribute
                    createdRow: function(row, data, dataIndex) {
                        $(row).find('td:eq(3)').attr('data-filter', data.CreditCardType);
                    }
                });

                table = dt.$;

                // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                dt.on('draw', function() {
                    initToggleToolbar();
                    toggleToolbars();
                    handleDeleteRows();
                    KTMenu.createInstances();
                });
            }

            // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
            var handleSearchDatatable = function() {
                const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
                filterSearch.addEventListener('keyup', function(e) {
                    dt.search(e.target.value).draw();
                });
            }

            // Filter Datatable
            var handleFilterDatatable = () => {
                // Select filter options
                filterAdvisor = document.querySelectorAll('[data-kt-docs-table-filter="advisor_status"] [name="advisor_status"]');

                const filterButton = document.querySelector('[data-kt-docs-table-filter="filter"]');

                // Filter datatable on submit
                if (filterButton) {
                    filterButton.addEventListener('click', function() {
                        // Get filter values
                        let advisorStatus = '';

                        // Get Advisor value
                        filterAdvisor.forEach(r => {

                            if (r.checked) {
                                advisorStatus = r.value;
                            }

                            // Reset Advisor value if "All" is selected
                            if (advisorStatus === 'all') {
                                advisorStatus = '';
                            }
                        });

                        // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
                        dt.search(advisorStatus).draw();
                    });
                }

            }

            // Delete Row
            var handleDeleteRows = () => {
                // Select all delete buttons
                const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

                deleteButtons.forEach(d => {
                    // Delete button on click
                    d.addEventListener('click', function(e) {
                        e.preventDefault();

                        // Select parent row
                        const parent = e.target.closest('tr');

                        // Get customer name
                        const customerName = parent.querySelectorAll('td')[1].innerText;

                        var advisor_id = d.getAttribute('advisor_id');

                        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Are you sure you want to delete " + customerName + "?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            }
                        }).then(function(result) {
                            if (result.value) {
                                // Simulate delete request -- for demo purpose only
                                Swal.fire({
                                    text: "Deleting " + customerName,
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    $.post(ajax_url, {
                                        action: 'advisor_delete',
                                        advisor_id: advisor_id
                                    }, function(result) {

                                    });
                                    Swal.fire({
                                        text: "You have deleted " + customerName + "!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function() {
                                        // delete row data from server and re-draw datatable 

                                        dt.draw();
                                    });
                                });
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: customerName + " was not deleted.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    })
                });
            }

            // Reset Filter
            var handleResetForm = () => {
                // Select reset button
                const resetButton = document.querySelector('[data-kt-docs-table-filter="reset"]');

                // Reset datatable
                if (resetButton) {
                    resetButton.addEventListener('click', function() {
                        // Reset Advisor type
                        filterAdvisor[0].checked = true;

                        // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
                        dt.search('').draw();
                    });
                }

            }

            // Init toggle toolbar
            var initToggleToolbar = function() {
                // Toggle selected action toolbar
                // Select all checkboxes
                const container = document.querySelector('#kt_datatable_example_1');
                const checkboxes = container.querySelectorAll('[type="checkbox"]');

                // Select elements
                const deleteSelected = document.querySelector('[data-kt-docs-table-select="delete_selected"]');

                var SelectedRow = [];
                // Toggle delete selected toolbar
                checkboxes.forEach(c => {
                    // Checkbox on click event
                    c.addEventListener('click', function() {
                        SelectedRow.push(c.value);
                        setTimeout(function() {
                            toggleToolbars();
                        }, 50);
                    });
                });

                // Deleted selected rows
                if (deleteSelected) {

                    deleteSelected.addEventListener('click', function() {
                        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Are you sure you want to delete selected customers?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            showLoaderOnConfirm: true,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            },
                        }).then(function(result) {

                            if (result.value) {
                                // Simulate delete request -- for demo purpose only
                                Swal.fire({
                                    text: "Deleting selected customers",
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    Swal.fire({
                                        text: "You have deleted all selected customers!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function() {
                                        $.post(ajax_url, {
                                            action: 'delete_multiple_selected_advisor',
                                            advisor_ids: SelectedRow
                                        }, function(result) {

                                        });
                                        // delete row data from server and re-draw datatable
                                        dt.draw();
                                    });

                                    // Remove header checked box
                                    const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];
                                    headerCheckbox.checked = false;
                                });
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: "Selected customers was not deleted.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    });

                }
            }

            // Toggle toolbars
            var toggleToolbars = function() {
                // Define variables
                const container = document.querySelector('#kt_datatable_example_1');
                const toolbarBase = document.querySelector('[data-kt-docs-table-toolbar="base"]');
                const toolbarSelected = document.querySelector('[data-kt-docs-table-toolbar="selected"]');
                const selectedCount = document.querySelector('[data-kt-docs-table-select="selected_count"]');

                // Select refreshed checkbox DOM elements
                const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

                // Detect checkboxes state & count
                let checkedState = false;
                let count = 0;

                // Count checked boxes
                allCheckboxes.forEach(c => {
                    if (c.checked) {
                        checkedState = true;
                        count++;
                    }
                });

                // Toggle toolbars
                if (checkedState) {
                    selectedCount.innerHTML = count;
                    toolbarBase.classList.add('d-none');
                    toolbarSelected.classList.remove('d-none');
                } else {
                    toolbarBase.classList.remove('d-none');
                    toolbarSelected.classList.add('d-none');
                }
            }

            // Public methods
            return {
                init: function() {
                    initDatatable();
                    handleSearchDatatable();
                    initToggleToolbar();
                    handleFilterDatatable();
                    handleDeleteRows();
                    handleResetForm();
                }
            }
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            KTDatatablesServerSide.init();
        });
    </script>
    <script>
        $(document).ready(function() {

            //$('#kt_modal_advisor_form').submit(function(event) {
            $('#save_advisor').click(function(event) {

                if (!$("#email").val()) {
                    return false;
                }

                // Prevent the default form submission
                event.preventDefault();

                $.post(ajax_url, {
                    action: 'check_email_exist',
                    email: $("#email").val(),
                    is_ajax: true,
                }, function(result) {

                    var results = JSON.parse(result);

                    if (results.status) {
                        $("#email").val('');
                        $("#save_advisor").after("<p class='email_exist_msg text-danger mt-2'>Email already exist.</p>");
                        setTimeout(function() {
                            $('.email_exist_msg').remove();
                        }, 2000);
                    } else {
                        $('#kt_modal_advisor_form').submit();
                    }

                });
            });
        });
    </script>
</body>
<!--end::Body-->

</html>