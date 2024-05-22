<?php require '../../config.php';
$page_name = 'marketing';
$sub_page_name = 'marketing';
Admin()->check_login();
// page permition for admin user
if (Admin()->check_for_page_access("campaigns", true)) {
    wp_redirect(add_query_arg('access', 1, site_url('admin/dashboard')));
    die();
}

if (!siget('id')) {
    wp_redirect(site_url() . '/admin/campaigns/list');
    return;
}

if (isset($_POST['save_interest_settings'])) {

    $response = Advisor()->update_user_interest();

    if ($response == 1) {
        $_SESSION['interest_process_success'] = true;
    } else {
        $_SESSION['interest_process_fail'] = true;
    }

    wp_redirect(site_url() . '/admin/campaigns/single/' . siget('id'));
    exit;
}

$get_selected_interest_info = Settings()->get_selected_interest_info(siget('id'));

if (!$get_selected_interest_info) {
    wp_redirect(site_url() . '/admin/campaigns/list');
    return;
}

$campaign_name = $get_selected_interest_info->name;

$get_interest_user_list = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.mobile_no,ad.gender,ad.birth_date,ad.state,ad.created_by,ad.created_by_type, user_interest.id as user_interest_tbl_id,user_interest.sub_id FROM advisor as ad INNER JOIN user_interest ON ad.id = user_interest.user_id WHERE user_interest.interest_id = " . siget('id') . " AND ad.status = 0 ");

$count_total_user = Advisor()->get_interest_user_total_count($get_selected_interest_info->id);

$get_interest_recent_users = Advisor()->get_interest_recent_users($get_selected_interest_info->id);

$get_interest_list = Settings()->get_interest_list();

/*
if (siget('id') == 1) {
    $campaign_name = 'Life Insurance';
    $get_advisor_list = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.mobile_no,ad.gender,ad.birth_date,ad.state,ad.created_by,ad.created_by_type,interest.id as interest_id FROM advisor as ad INNER JOIN interest ON ad.id = interest.user_id WHERE interest.life_insurance != '' AND ( interest.iul_mail_reminder IS NOT NULL OR interest.term_mail_reminder IS NOT NULL OR interest.wl_mail_reminder IS NOT NULL OR interest.ap_mail_reminder IS NOT NULL ) AND ( interest.iul_mail_reminder != '0000-00-00 00:00:00' OR interest.term_mail_reminder != '0000-00-00 00:00:00' OR interest.wl_mail_reminder != '0000-00-00 00:00:00' OR interest.ap_mail_reminder != '0000-00-00 00:00:00')  AND ad.advisor_status = 2 AND ad.status = 0 ");
} else if (siget('id') == 2) {
    $campaign_name = 'Fixed Indexed Annuities';
    $get_advisor_list = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.mobile_no,ad.gender,ad.birth_date,ad.state,ad.created_by,ad.created_by_type,interest.id as interest_id FROM advisor as ad INNER JOIN interest ON ad.id = interest.user_id WHERE interest.annuities != '' AND interest.fia_mail_reminder IS NOT NULL AND interest.fia_mail_reminder != '0000-00-00 00:00:00' AND ad.advisor_status = 2 AND ad.status = 0 ");
} else if (siget('id') == 3) {
    $campaign_name = 'Long-Term Care Insurance';
    $get_advisor_list = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.mobile_no,ad.gender,ad.birth_date,ad.state,ad.created_by,ad.created_by_type,interest.id as interest_id FROM advisor as ad INNER JOIN interest ON ad.id = interest.user_id WHERE interest.long_term_care_insurance != '' AND interest.ltc_mail_reminder IS NOT NULL AND interest.ltc_mail_reminder != '0000-00-00 00:00:00' AND ad.advisor_status = 2 AND ad.status = 0 ");
} else if (siget('id') == 4) {
    $campaign_name = 'Life Settlements';
    $get_advisor_list = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.mobile_no,ad.gender,ad.birth_date,ad.state,ad.created_by,ad.created_by_type,interest.id as interest_id FROM advisor as ad INNER JOIN interest ON ad.id = interest.user_id WHERE interest.critical_illness != '' AND interest.ls_mail_reminder IS NOT NULL AND interest.ls_mail_reminder != '0000-00-00 00:00:00' AND ad.advisor_status = 2 AND ad.status = 0 ");
}
*/
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
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Campaign Overview</h1>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Page title-->
                                    <!--begin::Actions-->
                                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                                        <?php
                                        $bookmark = Advisor()->check_bookmark(site_url() . '/admin/campaigns/single/' . siget('id'));

                                        if ($bookmark) { ?>
                                            <i class="bi bi-bookmarks-fill fs-2x cursor-pointer text-primary  bookmark_page" bookmark_url="<?php echo site_url(); ?>/admin/campaigns/single/<?php echo siget('id'); ?>"></i>
                                        <?php } else { ?>
                                            <i class="bi bi-bookmarks fs-2x cursor-pointer text-primary bookmark_page" data-bs-toggle="modal" data-bs-target="#kt_modal_bookmark_link" bookmark_name="User Campaign" bookmark_url="<?php echo site_url(); ?>/admin/campaigns/single/<?php echo siget('id'); ?>"></i>
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
                                <!--begin::Navbar-->
                                <div class="card mb-6 mb-xl-9">
                                    <div class="card-body pt-9 pb-0">
                                        <!--begin::Details-->
                                        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                                            <!--begin::Image-->
                                            <div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                                                <img class="mw-50px mw-lg-75px" src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/volicity-9.svg" alt="image" />
                                            </div>
                                            <!--end::Image-->
                                            <!--begin::Wrapper-->
                                            <div class="flex-grow-1">
                                                <!--begin::Head-->
                                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                                    <!--begin::Details-->
                                                    <div class="d-flex flex-column">
                                                        <!--begin::Status-->
                                                        <div class="d-flex align-items-center mb-1">
                                                            <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3"><?php echo $campaign_name; ?></a>
                                                            <span class="badge badge-light-success me-auto">In Progress</span>
                                                        </div>
                                                        <!--end::Status-->
                                                        <!--begin::Description-->
                                                        <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-500"></div>
                                                        <!--end::Description-->
                                                    </div>
                                                    <!--end::Details-->
                                                </div>
                                                <!--end::Head-->
                                                <!--begin::Info-->
                                                <div class="d-flex flex-wrap justify-content-start">
                                                    <!--begin::Stats-->
                                                    <div class="d-flex flex-wrap">
                                                        <!--begin::Stat-->
                                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                            <!--begin::Number-->
                                                            <div class="d-flex align-items-center">
                                                                <div class="fs-4 fw-bold"><?php echo date("m/d/Y", strtotime($get_selected_interest_info->created_at)); ?></div>
                                                            </div>
                                                            <!--end::Number-->
                                                            <!--begin::Label-->
                                                            <div class="fw-semibold fs-6 text-gray-500">Created Date</div>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Stat-->
                                                        <!--begin::Stat-->
                                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                            <!--begin::Number-->
                                                            <div class="d-flex align-items-center">
                                                                <i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i>
                                                                <div class="fs-4 fw-bold" data-kt-countup="true" data-kt-countup-value="<?php echo $count_total_user; ?>" data-kt-countup-prefix="">0</div>
                                                            </div>
                                                            <!--end::Number-->
                                                            <!--begin::Label-->
                                                            <div class="fw-semibold fs-6 text-gray-500">Total Users</div>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Stat-->
                                                    </div>
                                                    <!--end::Stats-->
                                                    <!--begin::Users-->
                                                    <div class="symbol-group symbol-hover mb-3">
                                                        <!--begin::User-->
                                                        <?php
                                                        if ($get_interest_recent_users) {

                                                            foreach ($get_interest_recent_users as $recent_user_result) {

                                                                $advisor_info = Advisor()->get_selected_advisor_general_details($recent_user_result->user_id);

                                                                $advisor_profile = Advisor()->get_advisor_meta($recent_user_result->user_id, 'profile_img'); ?>

                                                                <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="<?php echo $advisor_info->first_name . ' ' . $advisor_info->last_name; ?>">
                                                                    <?php if ($advisor_profile) { ?>
                                                                        <img alt="Pic" src="<?php echo site_url(); ?>/uploads/advisor/<?php echo $advisor_profile; ?>" />
                                                                    <?php } else { ?>
                                                                        <span class="symbol-label bg-primary text-inverse-primary fw-bold"><?php echo Advisor()->get_advisor_name_initial($advisor_info->first_name . ' ' . $advisor_info->last_name); ?></span>
                                                                    <?php } ?>
                                                                </div>
                                                        <?php }
                                                        } ?>
                                                        <!--end::User-->
                                                        <?php if ($count_total_user > 5) { ?>
                                                            <!--begin::All users-->
                                                            <a href="#" class="symbol symbol-35px symbol-circle">
                                                                <span class="symbol-label bg-dark text-inverse-dark fs-8 fw-bold" data-bs-toggle="tooltip" data-bs-trigger="hover" title="View More Users">+<?php echo $count_total_user - 1; ?></span>
                                                            </a>
                                                            <!--end::All users-->
                                                        <?php } ?>
                                                    </div>
                                                    <!--end::Users-->
                                                </div>
                                                <!--end::Info-->
                                            </div>
                                            <!--end::Wrapper-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Nav-->
                                        <!--end::Nav-->
                                    </div>
                                </div>
                                <!--end::Navbar-->

                                <!--begin::Row-->
                                <div class="row gx-6 gx-xl-9 mb-6">
                                    <!--begin::Col-->
                                    <div class="col-lg-6">
                                        <!--begin::Summary-->
                                        <div class="card card-flush h-lg-100">
                                            <!--begin::Card header-->
                                            <div class="card-header mt-6">
                                                <!--begin::Card title-->
                                                <div class="card-title flex-column">
                                                    <h3 class="fw-bold mb-1">Tasks Summary</h3>
                                                    <div class="fs-6 fw-semibold text-gray-500">24 Overdue Tasks</div>
                                                </div>
                                                <!--end::Card title-->
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <a href="#" class="btn btn-light btn-sm">View Tasks</a>
                                                </div>
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body p-9 pt-5">
                                                <!--begin::Wrapper-->
                                                <div class="d-flex flex-wrap">
                                                    <!--begin::Chart-->
                                                    <div class="position-relative d-flex flex-center h-175px w-175px me-15 mb-7">
                                                        <div class="position-absolute translate-middle start-50 top-50 d-flex flex-column flex-center">
                                                            <span class="fs-2qx fw-bold">237</span>
                                                            <span class="fs-6 fw-semibold text-gray-500">Total Tasks</span>
                                                        </div>
                                                        <canvas id="project_overview_chart"></canvas>
                                                    </div>
                                                    <!--end::Chart-->
                                                    <!--begin::Labels-->
                                                    <div class="d-flex flex-column justify-content-center flex-row-fluid pe-11 mb-5">
                                                        <!--begin::Label-->
                                                        <div class="d-flex fs-6 fw-semibold align-items-center mb-3">
                                                            <div class="bullet bg-primary me-3"></div>
                                                            <div class="text-gray-500">Active</div>
                                                            <div class="ms-auto fw-bold text-gray-700">30</div>
                                                        </div>
                                                        <!--end::Label-->
                                                        <!--begin::Label-->
                                                        <div class="d-flex fs-6 fw-semibold align-items-center mb-3">
                                                            <div class="bullet bg-success me-3"></div>
                                                            <div class="text-gray-500">Completed</div>
                                                            <div class="ms-auto fw-bold text-gray-700">45</div>
                                                        </div>
                                                        <!--end::Label-->
                                                        <!--begin::Label-->
                                                        <div class="d-flex fs-6 fw-semibold align-items-center mb-3">
                                                            <div class="bullet bg-danger me-3"></div>
                                                            <div class="text-gray-500">Overdue</div>
                                                            <div class="ms-auto fw-bold text-gray-700">0</div>
                                                        </div>
                                                        <!--end::Label-->
                                                        <!--begin::Label-->
                                                        <div class="d-flex fs-6 fw-semibold align-items-center">
                                                            <div class="bullet bg-gray-300 me-3"></div>
                                                            <div class="text-gray-500">Yet to start</div>
                                                            <div class="ms-auto fw-bold text-gray-700">25</div>
                                                        </div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Labels-->
                                                </div>
                                                <!--end::Wrapper-->
                                                <!--begin::Notice-->
                                                <!--end::Notice-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Summary-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-lg-6">
                                        <!--begin::Graph-->
                                        <div class="card card-flush h-lg-100">
                                            <!--begin::Card header-->
                                            <div class="card-header mt-6">
                                                <!--begin::Card title-->
                                                <div class="card-title flex-column">
                                                    <h3 class="fw-bold mb-1">Tasks Over Time</h3>
                                                    <!--begin::Labels-->
                                                    <div class="fs-6 d-flex text-gray-500 fs-6 fw-semibold">
                                                        <!--begin::Label-->
                                                        <div class="d-flex align-items-center me-6">
                                                            <span class="menu-bullet d-flex align-items-center me-2">
                                                                <span class="bullet bg-success"></span>
                                                            </span>Complete
                                                        </div>
                                                        <!--end::Label-->
                                                        <!--begin::Label-->
                                                        <div class="d-flex align-items-center">
                                                            <span class="menu-bullet d-flex align-items-center me-2">
                                                                <span class="bullet bg-primary"></span>
                                                            </span>Incomplete
                                                        </div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Labels-->
                                                </div>
                                                <!--end::Card title-->
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <!--begin::Select-->
                                                    <select name="status" data-control="select2" data-hide-search="true" class="form-select form-select-solid form-select-sm fw-bold w-100px">
                                                        <option value="1">2020 Q1</option>
                                                        <option value="2">2020 Q2</option>
                                                        <option value="3" selected="selected">2020 Q3</option>
                                                        <option value="4">2020 Q4</option>
                                                    </select>
                                                    <!--end::Select-->
                                                </div>
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-10 pb-0 px-5">
                                                <!--begin::Chart-->
                                                <div id="kt_project_overview_graph" class="card-rounded-bottom" style="height: 300px"></div>
                                                <!--end::Chart-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Graph-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
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
                                                <!--begin::Menu 1-->

                                                <!--end::Menu 1-->
                                                <!--end::Filter-->
                                                <!--begin::Export-->
                                                <?php /*
                                                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_advisor_export_modal">
                                                    <i class="ki-outline ki-exit-up fs-2"></i>Export</button>
                                                <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_advisor_import_modal">
                                                    <i class="ki-outline ki-exit-down fs-2"></i>Import</button>
                                                */ ?>
                                                <!--end::Export-->
                                                <!--begin::Add Advisor-->
                                                <?php /*
                                                <a href="<?php echo site_url() ?>/admin/advisor/add-advisor" class="btn btn-primary" title="Add Advisor">
                                                    <i class="ki-duotone ki-plus fs-2"></i>
                                                    Add Advisor
                                                </a>
                                                */ ?>
                                                <button type="button" class="btn btn-primary assign_advisor_modal" data-bs-toggle="modal" data-bs-target="#kt_modal_assign_advisor" title="Assign Advisor">
                                                    <i class="ki-duotone ki-plus fs-2"></i>
                                                    Assign Advisor
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
                                                    <th>Current Step </th>
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
                        <!--end::Content-->
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

    <!--begin:: Modal Assign Advisor -->
    <div class="modal fade" id="kt_modal_assign_advisor" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog mw-700px p-9">
            <!--begin::Modal content-->
            <div class="modal-content modal-rounded">
                <!--begin::Modal header-->
                <div class="modal-header py-7 d-flex justify-content-between">
                    <!--begin::Modal title-->
                    <h2>Assing Contact</h2>
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
                        <div class="row">
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Contact</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select class="form-select form-select-solid" data-placeholder="Select a contact..." data-allow-clear="true" name="assign_contact[]" id="assign_contact" multiple="multiple">
                                    <option value="">Select Contact</option>
                                    <option value="1" data-kt-select2-user="<?php echo site_url(); ?>/assets/media/avatars/300-6.jpg">Emma Smith</option>
                                    <option value="2" data-kt-select2-user="<?php echo site_url(); ?>/assets/media/avatars/300-1.jpg">Max Smith</option>
                                    ...
                                </select>
                                <!--end::Input-->
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end:: Modal Assign Advisor -->

    <!--begin::Modal - Settings-->
    <div class="modal fade" id="user_settings_modal" tabindex="-1" aria-hidden="true">
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
                        <input type="hidden" name="interest_advisor_id" id="interest_advisor_id" class="is_empty">
                        <!--begin::Scroll-->
                        <div class="d-flex flex-column  px-5 px-lg-10">
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <div class="col-md-12 fv-row">
                                    <?php foreach ($get_interest_list as $interest_result) { ?>
                                        <div class="form-check form-check-custom form-check-solid mb-3">
                                            <input class="form-check-input" type="radio" name="interest" value="<?php echo $interest_result->id; ?>" id="interest_<?php echo $interest_result->id; ?>" />
                                            <label class="form-check-label text-black fs-4 fw-bold" for="interest_<?php echo $interest_result->id; ?>">
                                                <?php echo $interest_result->name; ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                    <div class="form-check form-check-custom form-check-solid mb-3">
                                        <input class="form-check-input" type="radio" name="interest" value="close_all" id="interest_close_all" />
                                        <label class="form-check-label text-black fs-4 fw-bold" for="interest_close_all">
                                            Stop Campaigns
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Scroll-->

                        <!--begin::Actions-->
                        <div class="text-center pt-5">
                            <button type="submit" name="save_interest_settings" id="save_interest_settings" class="btn btn-primary" data-kt-users-modal-action="submit">
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

    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <?php require SITE_DIR . '/footer_script.php'; ?>
    <!--end::Global Javascript Bundle-->
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/projects/project/project.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/widgets.bundle.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/widgets.js"></script>
    <script src="<?php echo site_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script>
        $(document).on("click", ".user_settings_modal", function() {

            jQuery('.is_empty').val('');
            jQuery('input[name="interest"]').removeAttr('checked');

            var interest_advisor_id = $(this).attr("id");
            var current_interest = $(this).attr("current_interest");
            var current_interest_sub_id = $(this).attr("current_interest_sub_id");
            var current_interest_status = $(this).attr("current_interest_status");

            if (current_interest_status == 1) {
                current_interest = 'close_all';
            }

            jQuery('#interest_advisor_id').val(interest_advisor_id);
            jQuery('input[name="interest"][value="' + current_interest + '"]').attr('checked', true);

        });

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
                        [0, 'desc']
                    ],
                    stateSave: true,
                    select: {
                        style: 'multi',
                        selector: 'td:first-child input[type="checkbox"]',
                        className: 'row-selected'
                    },
                    ajax: {
                        url: "<?php echo site_url(); ?>/admin/campaigns/interest-user-list-ajax.php",
                        data: {
                            interest_id: '<?php echo siget('id'); ?>'
                        }
                    },
                    columns: [{
                            data: 'record_id'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'current_step'
                        },
                        {
                            data: null
                        },
                    ],
                    columnDefs: [{
                            targets: 0,
                            orderable: true,
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
                                            ${data.is_close == 1 ? `<a href="#" id="${data.advisor_id}" class="menu-link user_settings_modal" data-bs-toggle="modal" data-bs-target="#user_settings_modal" data-kt-docs-table-filter="edit_row" current_interest="${data.interest_id}" current_interest_sub_id="${data.interest_sub_id}" current_interest_status="${data.is_close}">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-3 fw-bold text-gray-700"> 
                                                        <i class="las la-bullhorn fs-2 text-danger"></i> 
                                                    </div>
                                                </div>
                                            </a>` : `<a href="#" id="${data.advisor_id}" class="menu-link user_settings_modal" data-bs-toggle="modal" data-bs-target="#user_settings_modal" data-kt-docs-table-filter="edit_row" current_interest="${data.interest_id}" current_interest_sub_id="${data.interest_sub_id}" current_interest_status="${data.is_close}">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-3 fw-bold text-gray-700"> 
                                                        <i class="las la-bullhorn fs-2 text-primary"></i> 
                                                    </div>
                                                </div>
                                            </a>` }
                                            
                                            <a href="<?php echo site_url(); ?>/admin/advisor/view-advisor/${data.advisor_id}" data-bs-toggle="tooltip" title="View Quick Info">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-3 fw-bold text-gray-700">
                                                        <i class="las la-eye fs-2 text-primary"></i>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="<?php echo site_url(); ?>/admin/advisor/edit-advisor/${data.advisor_id}" data-bs-toggle="tooltip" title="Edit Contact">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-2 fw-bold text-gray-700">
                                                        <i class="las la-user-edit fs-2 text-primary"></i>
                                                    </div>
                                                </div> 
                                            </a>
                                            <a href="#" data-kt-docs-table-filter="delete_row" id="${data.record_id}" data-bs-toggle="tooltip" title="Delete contact from this campaign">
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
                    /*
                    createdRow: function(row, data, dataIndex) {
                        $(row).find('td:eq(3)').attr('data-filter', data.CreditCardType);
                    }
                    */
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

                        var record_id = d.getAttribute('id');

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
                                        action: 'delete_interest_user',
                                        id: record_id
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
        // Format options
        var optionFormat = function(item) {
            if (!item.id) {
                return item.text;
            }

            var span = document.createElement('span');
            var imgUrl = item.element.getAttribute('data-kt-select2-user');
            var template = '';

            template += '<img src="' + imgUrl + '" class="rounded-circle h-20px me-2" alt="image"/>';
            template += item.text;

            span.innerHTML = template;

            return $(span);
        }

        // Init Select2 --- more info: https://select2.org/
        $('#assign_contact').select2({
            templateSelection: optionFormat,
            templateResult: optionFormat
        });
    </script>
</body>
<!--end::Body-->

</html>