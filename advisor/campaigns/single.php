<?php require '../../config.php';
$page_name = 'campaigns';
$sub_page_name = 'campaigns-list';
Advisor()->check_advisor_login();
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/advisor/head.php'; ?>
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
            <?php require SITE_DIR . '/advisor/header.php'; ?>
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Sidebar-->
                <?php require SITE_DIR . '/advisor/sidebar.php'; ?>
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
                                                            <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">Fitness App</a>
                                                            <span class="badge badge-light-success me-auto">In Progress</span>
                                                        </div>
                                                        <!--end::Status-->
                                                        <!--begin::Description-->
                                                        <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-500">#1 Tool to get started with Web Apps any Kind & size</div>
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
                                    <!--begin::Col-->
                                    <div class="col-lg-6">
                                        <!--begin::Card-->
                                        <div class="card card-flush h-lg-100">
                                            <!--begin::Card header-->
                                            <div class="card-header mt-6">
                                                <!--begin::Card title-->
                                                <div class="card-title flex-column">
                                                    <h3 class="fw-bold mb-1">What's on the road?</h3>
                                                    <div class="fs-6 text-gray-500">Total 482 participants</div>
                                                </div>
                                                <!--end::Card title-->
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <!--begin::Select-->
                                                    <select name="status" data-control="select2" data-hide-search="true" class="form-select form-select-solid form-select-sm fw-bold w-100px">
                                                        <option value="1" selected="selected">Options</option>
                                                        <option value="2">Option 1</option>
                                                        <option value="3">Option 2</option>
                                                        <option value="4">Option 3</option>
                                                    </select>
                                                    <!--end::Select-->
                                                </div>
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body p-9 pt-4">
                                                <!--begin::Dates-->
                                                <ul class="nav nav-pills d-flex flex-nowrap hover-scroll-x py-2">
                                                    <!--begin::Date-->
                                                    <li class="nav-item me-1">
                                                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_0">
                                                            <span class="opacity-50 fs-7 fw-semibold">Su</span>
                                                            <span class="fs-6 fw-bold">22</span>
                                                        </a>
                                                    </li>
                                                    <!--end::Date-->
                                                    <!--begin::Date-->
                                                    <li class="nav-item me-1">
                                                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary active" data-bs-toggle="tab" href="#kt_schedule_day_1">
                                                            <span class="opacity-50 fs-7 fw-semibold">Mo</span>
                                                            <span class="fs-6 fw-bold">23</span>
                                                        </a>
                                                    </li>
                                                    <!--end::Date-->
                                                    <!--begin::Date-->
                                                    <li class="nav-item me-1">
                                                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_2">
                                                            <span class="opacity-50 fs-7 fw-semibold">Tu</span>
                                                            <span class="fs-6 fw-bold">24</span>
                                                        </a>
                                                    </li>
                                                    <!--end::Date-->
                                                    <!--begin::Date-->
                                                    <li class="nav-item me-1">
                                                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_3">
                                                            <span class="opacity-50 fs-7 fw-semibold">We</span>
                                                            <span class="fs-6 fw-bold">25</span>
                                                        </a>
                                                    </li>
                                                    <!--end::Date-->
                                                    <!--begin::Date-->
                                                    <li class="nav-item me-1">
                                                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_4">
                                                            <span class="opacity-50 fs-7 fw-semibold">Th</span>
                                                            <span class="fs-6 fw-bold">26</span>
                                                        </a>
                                                    </li>
                                                    <!--end::Date-->
                                                    <!--begin::Date-->
                                                    <li class="nav-item me-1">
                                                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_5">
                                                            <span class="opacity-50 fs-7 fw-semibold">Fr</span>
                                                            <span class="fs-6 fw-bold">27</span>
                                                        </a>
                                                    </li>
                                                    <!--end::Date-->
                                                    <!--begin::Date-->
                                                    <li class="nav-item me-1">
                                                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_6">
                                                            <span class="opacity-50 fs-7 fw-semibold">Sa</span>
                                                            <span class="fs-6 fw-bold">28</span>
                                                        </a>
                                                    </li>
                                                    <!--end::Date-->
                                                    <!--begin::Date-->
                                                    <li class="nav-item me-1">
                                                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_7">
                                                            <span class="opacity-50 fs-7 fw-semibold">Su</span>
                                                            <span class="fs-6 fw-bold">29</span>
                                                        </a>
                                                    </li>
                                                    <!--end::Date-->
                                                    <!--begin::Date-->
                                                    <li class="nav-item me-1">
                                                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_8">
                                                            <span class="opacity-50 fs-7 fw-semibold">Mo</span>
                                                            <span class="fs-6 fw-bold">30</span>
                                                        </a>
                                                    </li>
                                                    <!--end::Date-->
                                                    <!--begin::Date-->
                                                    <li class="nav-item me-1">
                                                        <a class="nav-link btn d-flex flex-column flex-center rounded-pill min-w-45px me-2 py-4 px-3 btn-active-primary" data-bs-toggle="tab" href="#kt_schedule_day_9">
                                                            <span class="opacity-50 fs-7 fw-semibold">Tu</span>
                                                            <span class="fs-6 fw-bold">31</span>
                                                        </a>
                                                    </li>
                                                    <!--end::Date-->
                                                </ul>
                                                <!--end::Dates-->
                                                <!--begin::Tab Content-->
                                                <div class="tab-content">
                                                    <!--begin::Day-->
                                                    <div id="kt_schedule_day_0" class="tab-pane fade show">
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">9:00 - 10:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">am</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Lunch & Learn Catch Up</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Karina Clarke</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">10:00 - 11:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">am</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Team Backlog Grooming Session</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Naomi Hayabusa</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">11:00 - 11:45
                                                                    <span class="fs-7 text-gray-500 text-uppercase">am</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Lunch & Learn Catch Up</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Terry Robins</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                    </div>
                                                    <!--end::Day-->
                                                    <!--begin::Day-->
                                                    <div id="kt_schedule_day_1" class="tab-pane fade show active">
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">13:00 - 14:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Development Team Capacity Review</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Caleb Donaldson</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">14:30 - 15:30
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Sales Pitch Proposal</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Michael Walters</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">10:00 - 11:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">am</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">9 Degree Project Estimation Meeting</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Michael Walters</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                    </div>
                                                    <!--end::Day-->
                                                    <!--begin::Day-->
                                                    <div id="kt_schedule_day_2" class="tab-pane fade show">
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">10:00 - 11:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">am</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">9 Degree Project Estimation Meeting</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Terry Robins</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">10:00 - 11:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">am</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Marketing Campaign Discussion</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Caleb Donaldson</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">16:30 - 17:30
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Creative Content Initiative</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Yannis Gloverson</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                    </div>
                                                    <!--end::Day-->
                                                    <!--begin::Day-->
                                                    <div id="kt_schedule_day_3" class="tab-pane fade show">
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">12:00 - 13:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Sales Pitch Proposal</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Sean Bean</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">13:00 - 14:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Marketing Campaign Discussion</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Terry Robins</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">13:00 - 14:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Lunch & Learn Catch Up</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Sean Bean</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                    </div>
                                                    <!--end::Day-->
                                                    <!--begin::Day-->
                                                    <div id="kt_schedule_day_4" class="tab-pane fade show">
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">14:30 - 15:30
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Creative Content Initiative</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Sean Bean</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">11:00 - 11:45
                                                                    <span class="fs-7 text-gray-500 text-uppercase">am</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">9 Degree Project Estimation Meeting</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Karina Clarke</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">9:00 - 10:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">am</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Marketing Campaign Discussion</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Karina Clarke</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                    </div>
                                                    <!--end::Day-->
                                                    <!--begin::Day-->
                                                    <div id="kt_schedule_day_5" class="tab-pane fade show">
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">12:00 - 13:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Sales Pitch Proposal</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Walter White</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">13:00 - 14:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Development Team Capacity Review</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Kendell Trevor</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">16:30 - 17:30
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Lunch & Learn Catch Up</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Terry Robins</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                    </div>
                                                    <!--end::Day-->
                                                    <!--begin::Day-->
                                                    <div id="kt_schedule_day_6" class="tab-pane fade show">
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">14:30 - 15:30
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">9 Degree Project Estimation Meeting</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Kendell Trevor</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">10:00 - 11:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">am</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Marketing Campaign Discussion</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Karina Clarke</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">12:00 - 13:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Sales Pitch Proposal</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">David Stevenson</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                    </div>
                                                    <!--end::Day-->
                                                    <!--begin::Day-->
                                                    <div id="kt_schedule_day_7" class="tab-pane fade show">
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">9:00 - 10:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">am</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Sales Pitch Proposal</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Naomi Hayabusa</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">13:00 - 14:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Team Backlog Grooming Session</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Walter White</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">12:00 - 13:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Sales Pitch Proposal</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Terry Robins</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                    </div>
                                                    <!--end::Day-->
                                                    <!--begin::Day-->
                                                    <div id="kt_schedule_day_8" class="tab-pane fade show">
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">16:30 - 17:30
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Sales Pitch Proposal</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Kendell Trevor</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">16:30 - 17:30
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">9 Degree Project Estimation Meeting</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Caleb Donaldson</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">12:00 - 13:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Development Team Capacity Review</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Kendell Trevor</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                    </div>
                                                    <!--end::Day-->
                                                    <!--begin::Day-->
                                                    <div id="kt_schedule_day_9" class="tab-pane fade show">
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">10:00 - 11:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">am</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Development Team Capacity Review</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Kendell Trevor</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">12:00 - 13:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">pm</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Development Team Capacity Review</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Mark Randall</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                        <!--begin::Time-->
                                                        <div class="d-flex flex-stack position-relative mt-8">
                                                            <!--begin::Bar-->
                                                            <div class="position-absolute h-100 w-4px bg-secondary rounded top-0 start-0"></div>
                                                            <!--end::Bar-->
                                                            <!--begin::Info-->
                                                            <div class="fw-semibold ms-5 text-gray-600">
                                                                <!--begin::Time-->
                                                                <div class="fs-5">10:00 - 11:00
                                                                    <span class="fs-7 text-gray-500 text-uppercase">am</span>
                                                                </div>
                                                                <!--end::Time-->
                                                                <!--begin::Title-->
                                                                <a href="#" class="fs-5 fw-bold text-gray-800 text-hover-primary mb-2">Project Review & Testing</a>
                                                                <!--end::Title-->
                                                                <!--begin::User-->
                                                                <div class="text-gray-500">Lead by
                                                                    <a href="#">Mark Randall</a>
                                                                </div>
                                                                <!--end::User-->
                                                            </div>
                                                            <!--end::Info-->
                                                            <!--begin::Action-->
                                                            <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View</a>
                                                            <!--end::Action-->
                                                        </div>
                                                        <!--end::Time-->
                                                    </div>
                                                    <!--end::Day-->
                                                </div>
                                                <!--end::Tab Content-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-lg-6">
                                        <!--begin::Card-->
                                        <div class="card card-flush h-lg-100">
                                            <!--begin::Card header-->
                                            <div class="card-header mt-6">
                                                <!--begin::Card title-->
                                                <div class="card-title flex-column">
                                                    <h3 class="fw-bold mb-1">Latest Files</h3>
                                                    <div class="fs-6 text-gray-500">Total 382 fiels, 2,6GB space usage</div>
                                                </div>
                                                <!--end::Card title-->
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <a href="#" class="btn btn-bg-light btn-active-color-primary btn-sm">View All</a>
                                                </div>
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body p-9 pt-3">
                                                <!--begin::Files-->
                                                <div class="d-flex flex-column mb-9">
                                                    <!--begin::File-->
                                                    <div class="d-flex align-items-center mb-5">
                                                        <!--begin::Icon-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <img alt="Icon" src="<?php echo site_url(); ?>/assets/media/svg/files/pdf.svg" />
                                                        </div>
                                                        <!--end::Icon-->
                                                        <!--begin::Details-->
                                                        <div class="fw-semibold">
                                                            <a class="fs-6 fw-bold text-gray-900 text-hover-primary" href="#">Project tech requirements</a>
                                                            <div class="text-gray-500">2 days ago
                                                                <a href="#">Karina Clark</a>
                                                            </div>
                                                        </div>
                                                        <!--end::Details-->
                                                        <!--begin::Menu-->
                                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                            <i class="ki-outline ki-element-plus fs-3"></i>
                                                        </button>
                                                        <!--begin::Menu 1-->
                                                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_65a1115dc1eb4">
                                                            <!--begin::Header-->
                                                            <div class="px-7 py-5">
                                                                <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                                                            </div>
                                                            <!--end::Header-->
                                                            <!--begin::Menu separator-->
                                                            <div class="separator border-gray-200"></div>
                                                            <!--end::Menu separator-->
                                                            <!--begin::Form-->
                                                            <div class="px-7 py-5">
                                                                <!--begin::Input group-->
                                                                <div class="mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-semibold">Status:</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <div>
                                                                        <select class="form-select form-select-solid" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_65a1115dc1eb4" data-allow-clear="true">
                                                                            <option></option>
                                                                            <option value="1">Approved</option>
                                                                            <option value="2">Pending</option>
                                                                            <option value="2">In Process</option>
                                                                            <option value="2">Rejected</option>
                                                                        </select>
                                                                    </div>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Input group-->
                                                                <div class="mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-semibold">Member Type:</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Options-->
                                                                    <div class="d-flex">
                                                                        <!--begin::Options-->
                                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                                            <input class="form-check-input" type="checkbox" value="1" />
                                                                            <span class="form-check-label">Author</span>
                                                                        </label>
                                                                        <!--end::Options-->
                                                                        <!--begin::Options-->
                                                                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                                            <input class="form-check-input" type="checkbox" value="2" checked="checked" />
                                                                            <span class="form-check-label">Customer</span>
                                                                        </label>
                                                                        <!--end::Options-->
                                                                    </div>
                                                                    <!--end::Options-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Input group-->
                                                                <div class="mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-semibold">Notifications:</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Switch-->
                                                                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                        <input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked" />
                                                                        <label class="form-check-label">Enabled</label>
                                                                    </div>
                                                                    <!--end::Switch-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Actions-->
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                                                                    <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                                                                </div>
                                                                <!--end::Actions-->
                                                            </div>
                                                            <!--end::Form-->
                                                        </div>
                                                        <!--end::Menu 1-->
                                                        <!--end::Menu-->
                                                    </div>
                                                    <!--end::File-->
                                                    <!--begin::File-->
                                                    <div class="d-flex align-items-center mb-5">
                                                        <!--begin::Icon-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <img alt="Icon" src="<?php echo site_url(); ?>/assets/media/svg/files/doc.svg" />
                                                        </div>
                                                        <!--end::Icon-->
                                                        <!--begin::Details-->
                                                        <div class="fw-semibold">
                                                            <a class="fs-6 fw-bold text-gray-900 text-hover-primary" href="#">Create FureStibe branding proposal</a>
                                                            <div class="text-gray-500">Due in 1 day
                                                                <a href="#">Marcus Blake</a>
                                                            </div>
                                                        </div>
                                                        <!--end::Details-->
                                                        <!--begin::Menu-->
                                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                            <i class="ki-outline ki-element-plus fs-3"></i>
                                                        </button>
                                                        <!--begin::Menu 1-->
                                                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_65a1115dc1ec3">
                                                            <!--begin::Header-->
                                                            <div class="px-7 py-5">
                                                                <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                                                            </div>
                                                            <!--end::Header-->
                                                            <!--begin::Menu separator-->
                                                            <div class="separator border-gray-200"></div>
                                                            <!--end::Menu separator-->
                                                            <!--begin::Form-->
                                                            <div class="px-7 py-5">
                                                                <!--begin::Input group-->
                                                                <div class="mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-semibold">Status:</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <div>
                                                                        <select class="form-select form-select-solid" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_65a1115dc1ec3" data-allow-clear="true">
                                                                            <option></option>
                                                                            <option value="1">Approved</option>
                                                                            <option value="2">Pending</option>
                                                                            <option value="2">In Process</option>
                                                                            <option value="2">Rejected</option>
                                                                        </select>
                                                                    </div>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Input group-->
                                                                <div class="mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-semibold">Member Type:</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Options-->
                                                                    <div class="d-flex">
                                                                        <!--begin::Options-->
                                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                                            <input class="form-check-input" type="checkbox" value="1" />
                                                                            <span class="form-check-label">Author</span>
                                                                        </label>
                                                                        <!--end::Options-->
                                                                        <!--begin::Options-->
                                                                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                                            <input class="form-check-input" type="checkbox" value="2" checked="checked" />
                                                                            <span class="form-check-label">Customer</span>
                                                                        </label>
                                                                        <!--end::Options-->
                                                                    </div>
                                                                    <!--end::Options-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Input group-->
                                                                <div class="mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-semibold">Notifications:</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Switch-->
                                                                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                        <input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked" />
                                                                        <label class="form-check-label">Enabled</label>
                                                                    </div>
                                                                    <!--end::Switch-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Actions-->
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                                                                    <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                                                                </div>
                                                                <!--end::Actions-->
                                                            </div>
                                                            <!--end::Form-->
                                                        </div>
                                                        <!--end::Menu 1-->
                                                        <!--end::Menu-->
                                                    </div>
                                                    <!--end::File-->
                                                    <!--begin::File-->
                                                    <div class="d-flex align-items-center mb-5">
                                                        <!--begin::Icon-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <img alt="Icon" src="<?php echo site_url(); ?>/assets/media/svg/files/css.svg" />
                                                        </div>
                                                        <!--end::Icon-->
                                                        <!--begin::Details-->
                                                        <div class="fw-semibold">
                                                            <a class="fs-6 fw-bold text-gray-900 text-hover-primary" href="#">Completed Project Stylings</a>
                                                            <div class="text-gray-500">Due in 1 day
                                                                <a href="#">Terry Barry</a>
                                                            </div>
                                                        </div>
                                                        <!--end::Details-->
                                                        <!--begin::Menu-->
                                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                            <i class="ki-outline ki-element-plus fs-3"></i>
                                                        </button>
                                                        <!--begin::Menu 1-->
                                                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_65a1115dc1ecf">
                                                            <!--begin::Header-->
                                                            <div class="px-7 py-5">
                                                                <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                                                            </div>
                                                            <!--end::Header-->
                                                            <!--begin::Menu separator-->
                                                            <div class="separator border-gray-200"></div>
                                                            <!--end::Menu separator-->
                                                            <!--begin::Form-->
                                                            <div class="px-7 py-5">
                                                                <!--begin::Input group-->
                                                                <div class="mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-semibold">Status:</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <div>
                                                                        <select class="form-select form-select-solid" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_65a1115dc1ecf" data-allow-clear="true">
                                                                            <option></option>
                                                                            <option value="1">Approved</option>
                                                                            <option value="2">Pending</option>
                                                                            <option value="2">In Process</option>
                                                                            <option value="2">Rejected</option>
                                                                        </select>
                                                                    </div>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Input group-->
                                                                <div class="mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-semibold">Member Type:</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Options-->
                                                                    <div class="d-flex">
                                                                        <!--begin::Options-->
                                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                                            <input class="form-check-input" type="checkbox" value="1" />
                                                                            <span class="form-check-label">Author</span>
                                                                        </label>
                                                                        <!--end::Options-->
                                                                        <!--begin::Options-->
                                                                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                                            <input class="form-check-input" type="checkbox" value="2" checked="checked" />
                                                                            <span class="form-check-label">Customer</span>
                                                                        </label>
                                                                        <!--end::Options-->
                                                                    </div>
                                                                    <!--end::Options-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Input group-->
                                                                <div class="mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-semibold">Notifications:</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Switch-->
                                                                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                        <input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked" />
                                                                        <label class="form-check-label">Enabled</label>
                                                                    </div>
                                                                    <!--end::Switch-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Actions-->
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                                                                    <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                                                                </div>
                                                                <!--end::Actions-->
                                                            </div>
                                                            <!--end::Form-->
                                                        </div>
                                                        <!--end::Menu 1-->
                                                        <!--end::Menu-->
                                                    </div>
                                                    <!--end::File-->
                                                    <!--begin::File-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Icon-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <img alt="Icon" src="<?php echo site_url(); ?>/assets/media/svg/files/ai.svg" />
                                                        </div>
                                                        <!--end::Icon-->
                                                        <!--begin::Details-->
                                                        <div class="fw-semibold">
                                                            <a class="fs-6 fw-bold text-gray-900 text-hover-primary" href="#">Create Project Wireframes</a>
                                                            <div class="text-gray-500">Due in 3 days
                                                                <a href="#">Roth Bloom</a>
                                                            </div>
                                                        </div>
                                                        <!--end::Details-->
                                                        <!--begin::Menu-->
                                                        <button type="button" class="btn btn-clean btn-sm btn-icon btn-icon-primary btn-active-light-primary ms-auto" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                            <i class="ki-outline ki-element-plus fs-3"></i>
                                                        </button>
                                                        <!--begin::Menu 1-->
                                                        <div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_65a1115dc1ed5">
                                                            <!--begin::Header-->
                                                            <div class="px-7 py-5">
                                                                <div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
                                                            </div>
                                                            <!--end::Header-->
                                                            <!--begin::Menu separator-->
                                                            <div class="separator border-gray-200"></div>
                                                            <!--end::Menu separator-->
                                                            <!--begin::Form-->
                                                            <div class="px-7 py-5">
                                                                <!--begin::Input group-->
                                                                <div class="mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-semibold">Status:</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <div>
                                                                        <select class="form-select form-select-solid" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_65a1115dc1ed5" data-allow-clear="true">
                                                                            <option></option>
                                                                            <option value="1">Approved</option>
                                                                            <option value="2">Pending</option>
                                                                            <option value="2">In Process</option>
                                                                            <option value="2">Rejected</option>
                                                                        </select>
                                                                    </div>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Input group-->
                                                                <div class="mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-semibold">Member Type:</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Options-->
                                                                    <div class="d-flex">
                                                                        <!--begin::Options-->
                                                                        <label class="form-check form-check-sm form-check-custom form-check-solid me-5">
                                                                            <input class="form-check-input" type="checkbox" value="1" />
                                                                            <span class="form-check-label">Author</span>
                                                                        </label>
                                                                        <!--end::Options-->
                                                                        <!--begin::Options-->
                                                                        <label class="form-check form-check-sm form-check-custom form-check-solid">
                                                                            <input class="form-check-input" type="checkbox" value="2" checked="checked" />
                                                                            <span class="form-check-label">Customer</span>
                                                                        </label>
                                                                        <!--end::Options-->
                                                                    </div>
                                                                    <!--end::Options-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Input group-->
                                                                <div class="mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fw-semibold">Notifications:</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Switch-->
                                                                    <div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                        <input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked" />
                                                                        <label class="form-check-label">Enabled</label>
                                                                    </div>
                                                                    <!--end::Switch-->
                                                                </div>
                                                                <!--end::Input group-->
                                                                <!--begin::Actions-->
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
                                                                    <button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
                                                                </div>
                                                                <!--end::Actions-->
                                                            </div>
                                                            <!--end::Form-->
                                                        </div>
                                                        <!--end::Menu 1-->
                                                        <!--end::Menu-->
                                                    </div>
                                                    <!--end::File-->
                                                </div>
                                                <!--end::Files-->
                                                <!--begin::Notice-->
                                                <div class="notice d-flex bg-light-primary rounded border-primary border border-dashed p-6">
                                                    <!--begin::Icon-->
                                                    <i class="ki-outline ki-svg/files/upload.svg fs-2tx text-primary me-4"></i>
                                                    <!--end::Icon-->
                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex flex-stack flex-grow-1">
                                                        <!--begin::Content-->
                                                        <div class="fw-semibold">
                                                            <h4 class="text-gray-900 fw-bold">Quick file uploader</h4>
                                                            <div class="fs-6 text-gray-700">Drag & Drop or choose files from computer</div>
                                                        </div>
                                                        <!--end::Content-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                </div>
                                                <!--end::Notice-->
                                            </div>
                                            <!--end::Card body -->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->
                    <!--begin::Footer-->
                    <?php require SITE_DIR . '/advisor/footer.php'; ?>
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->
                <!--begin::aside-->
                <?php require SITE_DIR . '/advisor/right_sidebar.php'; ?>
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
    <?php require SITE_DIR . '/advisor/footer_script.php'; ?>
    <!--end::Global Javascript Bundle-->
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/projects/project/project.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/widgets.bundle.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/widgets.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/chat/chat.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/utilities/modals/create-campaign.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/utilities/modals/users-search.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/utilities/modals/new-target.js"></script>
</body>
<!--end::Body-->

</html>