<?php require '../../config.php';
$page_name = 'campaigns';
$sub_page_name = 'campaigns-list';
Admin()->check_login();
// page permition for admin user
if (Admin()->check_for_page_access("campaigns", true)) {
    wp_redirect(add_query_arg('access', 1, site_url('admin/dashboard')));
    die();
}

if (siget('id') == 1) {
    $campaign_name = 'Life Insurance';
    $get_advisor_list = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.mobile_no,ad.gender,ad.birth_date,ad.state,ad.created_by,ad.created_by_type,interest.id as interest_id FROM advisor as ad INNER JOIN interest ON ad.id = interest.advisor_id WHERE interest.life_insurance != '' AND ( interest.iul_mail_reminder IS NOT NULL OR interest.term_mail_reminder IS NOT NULL OR interest.wl_mail_reminder IS NOT NULL OR interest.ap_mail_reminder IS NOT NULL ) AND ( interest.iul_mail_reminder != '0000-00-00 00:00:00' OR interest.term_mail_reminder != '0000-00-00 00:00:00' OR interest.wl_mail_reminder != '0000-00-00 00:00:00' OR interest.ap_mail_reminder != '0000-00-00 00:00:00')  AND ad.advisor_status = 2 AND ad.status = 0 ");
} else if (siget('id') == 2) {
    $campaign_name = 'Fixed Indexed Annuities';
    $get_advisor_list = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.mobile_no,ad.gender,ad.birth_date,ad.state,ad.created_by,ad.created_by_type,interest.id as interest_id FROM advisor as ad INNER JOIN interest ON ad.id = interest.advisor_id WHERE interest.annuities != '' AND interest.fia_mail_reminder IS NOT NULL AND interest.fia_mail_reminder != '0000-00-00 00:00:00' AND ad.advisor_status = 2 AND ad.status = 0 ");
} else if (siget('id') == 3) {
    $campaign_name = 'Long-Term Care Insurance';
    $get_advisor_list = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.mobile_no,ad.gender,ad.birth_date,ad.state,ad.created_by,ad.created_by_type,interest.id as interest_id FROM advisor as ad INNER JOIN interest ON ad.id = interest.advisor_id WHERE interest.long_term_care_insurance != '' AND interest.ltc_mail_reminder IS NOT NULL AND interest.ltc_mail_reminder != '0000-00-00 00:00:00' AND ad.advisor_status = 2 AND ad.status = 0 ");
} else if (siget('id') == 4) {
    $campaign_name = 'Life Settlements';
    $get_advisor_list = $wpdb->get_results("SELECT ad.id,ad.first_name,ad.last_name,ad.email,ad.mobile_no,ad.gender,ad.birth_date,ad.state,ad.created_by,ad.created_by_type,interest.id as interest_id FROM advisor as ad INNER JOIN interest ON ad.id = interest.advisor_id WHERE interest.critical_illness != '' AND interest.ls_mail_reminder IS NOT NULL AND interest.ls_mail_reminder != '0000-00-00 00:00:00' AND ad.advisor_status = 2 AND ad.status = 0 ");
}

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
                                                                <div class="fs-4 fw-bold">29 Jan, 2024</div>
                                                            </div>
                                                            <!--end::Number-->
                                                            <!--begin::Label-->
                                                            <div class="fw-semibold fs-6 text-gray-500">Due Date</div>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Stat-->
                                                        <!--begin::Stat-->
                                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                            <!--begin::Number-->
                                                            <div class="d-flex align-items-center">
                                                                <i class="ki-outline ki-arrow-down fs-3 text-danger me-2"></i>
                                                                <div class="fs-4 fw-bold" data-kt-countup="true" data-kt-countup-value="75">0</div>
                                                            </div>
                                                            <!--end::Number-->
                                                            <!--begin::Label-->
                                                            <div class="fw-semibold fs-6 text-gray-500">Open Tasks</div>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Stat-->
                                                        <!--begin::Stat-->
                                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                            <!--begin::Number-->
                                                            <div class="d-flex align-items-center">
                                                                <i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i>
                                                                <div class="fs-4 fw-bold" data-kt-countup="true" data-kt-countup-value="15000" data-kt-countup-prefix="$">0</div>
                                                            </div>
                                                            <!--end::Number-->
                                                            <!--begin::Label-->
                                                            <div class="fw-semibold fs-6 text-gray-500">Budget Spent</div>
                                                            <!--end::Label-->
                                                        </div>
                                                        <!--end::Stat-->
                                                    </div>
                                                    <!--end::Stats-->
                                                    <!--begin::Users-->
                                                    <div class="symbol-group symbol-hover mb-3">
                                                        <!--begin::User-->
                                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Alan Warden">
                                                            <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Michael Eberon">
                                                            <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-11.jpg" />
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Michelle Swanston">
                                                            <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-7.jpg" />
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Francis Mitcham">
                                                            <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-20.jpg" />
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Susan Redwood">
                                                            <span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Melody Macy">
                                                            <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-2.jpg" />
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Perry Matthew">
                                                            <span class="symbol-label bg-info text-inverse-info fw-bold">P</span>
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Barry Walter">
                                                            <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-12.jpg" />
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::All users-->
                                                        <a href="#" class="symbol symbol-35px symbol-circle" data-bs-toggle="modal" data-bs-target="#kt_modal_view_users">
                                                            <span class="symbol-label bg-dark text-inverse-dark fs-8 fw-bold" data-bs-toggle="tooltip" data-bs-trigger="hover" title="View more users">+42</span>
                                                        </a>
                                                        <!--end::All users-->
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
                                <div class="row gx-6 gx-xl-9">
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
                                                <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex flex-stack flex-grow-1">
                                                        <!--begin::Content-->
                                                        <div class="fw-semibold">
                                                            <div class="fs-6 text-gray-700">
                                                                <a href="#" class="fw-bold me-1">Invite New .NET Collaborators</a>to create great outstanding business to business .jsp modutr class scripts
                                                            </div>
                                                        </div>
                                                        <!--end::Content-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                </div>
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
                                <div class="row gx-6 gx-xl-9">
                                    <div class="table-responsive">
                                        <table id="kt_datatable_dom_positioning" class="table table-striped table-row-bordered gy-5 gs-7 border rounded">
                                            <thead>
                                                <tr class="fw-bold fs-6 text-gray-800 px-7">
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Phone No</th>
                                                    <th>Current Step</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($get_advisor_list as $advisor_result) {

                                                    if (siget('id') == 1) {

                                                        $iul_step = Advisor()->get_advisor_meta($advisor_result->id, 'iul_current_mail_reminder_step');

                                                        $term_step = Advisor()->get_advisor_meta($advisor_result->id, 'term_current_mail_reminder_step');

                                                        $wl_step = Advisor()->get_advisor_meta($advisor_result->id, 'wl_current_mail_reminder_step');

                                                        $ap_step = Advisor()->get_advisor_meta($advisor_result->id, 'ap_current_mail_reminder_step');

                                                        $current_step = '';
                                                        if ($iul_step) {
                                                            $current_step .= 'IUL : ' . $iul_step . ', ';
                                                        }
                                                        if ($term_step) {
                                                            $current_step .= 'Term : ' . $term_step . ', ';
                                                        }
                                                        if ($wl_step) {
                                                            $current_step .= 'WL : ' . $wl_step . ', ';
                                                        }
                                                        if ($ap_step) {
                                                            $current_step .= 'AP : ' . $ap_step . ', ';
                                                        }
                                                    } else if (siget('id') == 2) {
                                                        $current_step = Advisor()->get_advisor_meta($advisor_result->id, 'fia_current_mail_reminder_step');
                                                    } else if (siget('id') == 3) {
                                                        $current_step = Advisor()->get_advisor_meta($advisor_result->id, 'ltc_current_mail_reminder_step');
                                                    } else if (siget('id') == 4) {
                                                        $current_step = Advisor()->get_advisor_meta($advisor_result->id, 'ls_current_mail_reminder_step');
                                                    }

                                                ?>
                                                    <tr>
                                                        <td><?php echo $advisor_result->first_name . ' ' . $advisor_result->last_name; ?></td>
                                                        <td><?php echo $advisor_result->email; ?></td>
                                                        <td><?php echo $advisor_result->mobile_no; ?></td>
                                                        <td><?php echo $current_step; ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
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
        $("#kt_datatable_dom_positioning").DataTable({
            "language": {
                "lengthMenu": "Show _MENU_",
            },
            "dom": "<'row mb-2'" +
                "<'col-sm-6 d-flex align-items-center justify-conten-start dt-toolbar'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end dt-toolbar'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">"
        });
    </script>
</body>
<!--end::Body-->

</html>