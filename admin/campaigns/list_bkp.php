<?php require '../../config.php';
$page_name = 'campaigns';
$sub_page_name = 'campaigns-list';
Admin()->check_login();
// page permition for admin user
if (Admin()->check_for_page_access("campaigns", true)) {
    wp_redirect(add_query_arg('access', 1, site_url('admin/dashboard')));
    die();
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
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">All Campaigns</h1>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Page title-->
                                    <!--begin::Actions-->

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

                                <!--begin::Row-->
                                <div class="row g-6 g-xl-9">
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-xl-4">
                                        <!--begin::Card-->
                                        <a href="<?php echo site_url(); ?>/admin/campaigns/single/1" class="card border-hover-primary">
                                            <!--begin::Card header-->
                                            <div class="card-header border-0 pt-9">
                                                <!--begin::Card Title-->
                                                <div class="card-title m-0">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-50px w-50px bg-light">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/plurk.svg" alt="image" class="p-3" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                </div>
                                                <!--end::Car Title-->
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <span class="badge badge-light-primary fw-bold me-auto px-4 py-3">In Progress</span>
                                                </div>
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end:: Card header-->
                                            <!--begin:: Card body-->
                                            <div class="card-body p-9">
                                                <!--begin::Name-->
                                                <div class="fs-3 fw-bold text-gray-900">Fitnes App</div>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <p class="text-gray-500 fw-semibold fs-5 mt-1 mb-7">CRM App application to HR efficiency</p>
                                                <!--end::Description-->
                                                <!--begin::Info-->
                                                <div class="d-flex flex-wrap mb-5">
                                                    <!--begin::Due-->
                                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                                        <div class="fs-6 text-gray-800 fw-bold">Feb 21, 2024</div>
                                                        <div class="fw-semibold text-gray-500">Due Date</div>
                                                    </div>
                                                    <!--end::Due-->
                                                    <!--begin::Budget-->
                                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                                        <div class="fs-6 text-gray-800 fw-bold">$284,900.00</div>
                                                        <div class="fw-semibold text-gray-500">Budget</div>
                                                    </div>
                                                    <!--end::Budget-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Progress-->
                                                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="This project 50% completed">
                                                    <div class="bg-primary rounded h-4px" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <!--end::Progress-->
                                                <!--begin::Users-->
                                                <div class="symbol-group symbol-hover">
                                                    <!--begin::User-->
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Emma Smith">
                                                        <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-6.jpg" />
                                                    </div>
                                                    <!--begin::User-->
                                                    <!--begin::User-->
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Rudy Stone">
                                                        <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-1.jpg" />
                                                    </div>
                                                    <!--begin::User-->
                                                    <!--begin::User-->
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Susan Redwood">
                                                        <span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
                                                    </div>
                                                    <!--begin::User-->
                                                </div>
                                                <!--end::Users-->
                                            </div>
                                            <!--end:: Card body-->
                                        </a>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-xl-4">
                                        <!--begin::Card-->
                                        <a href="<?php echo site_url(); ?>/admin/campaigns/single/2" class="card border-hover-primary">
                                            <!--begin::Card header-->
                                            <div class="card-header border-0 pt-9">
                                                <!--begin::Card Title-->
                                                <div class="card-title m-0">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-50px w-50px bg-light">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/disqus.svg" alt="image" class="p-3" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                </div>
                                                <!--end::Car Title-->
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <span class="badge badge-light fw-bold me-auto px-4 py-3">Pending</span>
                                                </div>
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end:: Card header-->
                                            <!--begin:: Card body-->
                                            <div class="card-body p-9">
                                                <!--begin::Name-->
                                                <div class="fs-3 fw-bold text-gray-900">Leaf CRM</div>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <p class="text-gray-500 fw-semibold fs-5 mt-1 mb-7">CRM App application to HR efficiency</p>
                                                <!--end::Description-->
                                                <!--begin::Info-->
                                                <div class="d-flex flex-wrap mb-5">
                                                    <!--begin::Due-->
                                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                                        <div class="fs-6 text-gray-800 fw-bold">May 10, 2021</div>
                                                        <div class="fw-semibold text-gray-500">Due Date</div>
                                                    </div>
                                                    <!--end::Due-->
                                                    <!--begin::Budget-->
                                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                                        <div class="fs-6 text-gray-800 fw-bold">$36,400.00</div>
                                                        <div class="fw-semibold text-gray-500">Budget</div>
                                                    </div>
                                                    <!--end::Budget-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Progress-->
                                                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="This project 30% completed">
                                                    <div class="bg-info rounded h-4px" role="progressbar" style="width: 30%" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <!--end::Progress-->
                                                <!--begin::Users-->
                                                <div class="symbol-group symbol-hover">
                                                    <!--begin::User-->
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Alan Warden">
                                                        <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                                                    </div>
                                                    <!--begin::User-->
                                                    <!--begin::User-->
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Brian Cox">
                                                        <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-5.jpg" />
                                                    </div>
                                                    <!--begin::User-->
                                                </div>
                                                <!--end::Users-->
                                            </div>
                                            <!--end:: Card body-->
                                        </a>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-xl-4">
                                        <!--begin::Card-->
                                        <a href="<?php echo site_url(); ?>/admin/campaigns/single/3" class="card border-hover-primary">
                                            <!--begin::Card header-->
                                            <div class="card-header border-0 pt-9">
                                                <!--begin::Card Title-->
                                                <div class="card-title m-0">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-50px w-50px bg-light">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/figma-1.svg" alt="image" class="p-3" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                </div>
                                                <!--end::Car Title-->
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <span class="badge badge-light-success fw-bold me-auto px-4 py-3">Completed</span>
                                                </div>
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end:: Card header-->
                                            <!--begin:: Card body-->
                                            <div class="card-body p-9">
                                                <!--begin::Name-->
                                                <div class="fs-3 fw-bold text-gray-900">Atica Banking</div>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <p class="text-gray-500 fw-semibold fs-5 mt-1 mb-7">CRM App application to HR efficiency</p>
                                                <!--end::Description-->
                                                <!--begin::Info-->
                                                <div class="d-flex flex-wrap mb-5">
                                                    <!--begin::Due-->
                                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                                        <div class="fs-6 text-gray-800 fw-bold">Mar 14, 2021</div>
                                                        <div class="fw-semibold text-gray-500">Due Date</div>
                                                    </div>
                                                    <!--end::Due-->
                                                    <!--begin::Budget-->
                                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                                        <div class="fs-6 text-gray-800 fw-bold">$605,100.00</div>
                                                        <div class="fw-semibold text-gray-500">Budget</div>
                                                    </div>
                                                    <!--end::Budget-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Progress-->
                                                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="This project 100% completed">
                                                    <div class="bg-success rounded h-4px" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <!--end::Progress-->
                                                <!--begin::Users-->
                                                <div class="symbol-group symbol-hover">
                                                    <!--begin::User-->
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Mad Macy">
                                                        <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-2.jpg" />
                                                    </div>
                                                    <!--begin::User-->
                                                    <!--begin::User-->
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Cris Willson">
                                                        <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-9.jpg" />
                                                    </div>
                                                    <!--begin::User-->
                                                    <!--begin::User-->
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Mike Garcie">
                                                        <span class="symbol-label bg-info text-inverse-info fw-bold">M</span>
                                                    </div>
                                                    <!--begin::User-->
                                                </div>
                                                <!--end::Users-->
                                            </div>
                                            <!--end:: Card body-->
                                        </a>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-xl-4">
                                        <!--begin::Card-->
                                        <a href="<?php echo site_url(); ?>/admin/campaigns/single/4" class="card border-hover-primary">
                                            <!--begin::Card header-->
                                            <div class="card-header border-0 pt-9">
                                                <!--begin::Card Title-->
                                                <div class="card-title m-0">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-50px w-50px bg-light">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/sentry-3.svg" alt="image" class="p-3" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                </div>
                                                <!--end::Car Title-->
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <span class="badge badge-light fw-bold me-auto px-4 py-3">Pending</span>
                                                </div>
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end:: Card header-->
                                            <!--begin:: Card body-->
                                            <div class="card-body p-9">
                                                <!--begin::Name-->
                                                <div class="fs-3 fw-bold text-gray-900">Finance Dispatch</div>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <p class="text-gray-500 fw-semibold fs-5 mt-1 mb-7">CRM App application to HR efficiency</p>
                                                <!--end::Description-->
                                                <!--begin::Info-->
                                                <div class="d-flex flex-wrap mb-5">
                                                    <!--begin::Due-->
                                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                                        <div class="fs-6 text-gray-800 fw-bold">Sep 22, 2024</div>
                                                        <div class="fw-semibold text-gray-500">Due Date</div>
                                                    </div>
                                                    <!--end::Due-->
                                                    <!--begin::Budget-->
                                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                                        <div class="fs-6 text-gray-800 fw-bold">$284,900.00</div>
                                                        <div class="fw-semibold text-gray-500">Budget</div>
                                                    </div>
                                                    <!--end::Budget-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Progress-->
                                                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="This project 60% completed">
                                                    <div class="bg-info rounded h-4px" role="progressbar" style="width: 60%" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <!--end::Progress-->
                                                <!--begin::Users-->
                                                <div class="symbol-group symbol-hover">
                                                    <!--begin::User-->
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Nich Warden">
                                                        <span class="symbol-label bg-warning text-inverse-warning fw-bold">N</span>
                                                    </div>
                                                    <!--begin::User-->
                                                    <!--begin::User-->
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Rob Otto">
                                                        <span class="symbol-label bg-success text-inverse-success fw-bold">R</span>
                                                    </div>
                                                    <!--begin::User-->
                                                </div>
                                                <!--end::Users-->
                                            </div>
                                            <!--end:: Card body-->
                                        </a>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-xl-4">
                                        <!--begin::Card-->
                                        <a href="<?php echo site_url(); ?>/admin/campaigns/single/5" class="card border-hover-primary">
                                            <!--begin::Card header-->
                                            <div class="card-header border-0 pt-9">
                                                <!--begin::Card Title-->
                                                <div class="card-title m-0">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-50px w-50px bg-light">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/xing-icon.svg" alt="image" class="p-3" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                </div>
                                                <!--end::Car Title-->
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <span class="badge badge-light-primary fw-bold me-auto px-4 py-3">In Progress</span>
                                                </div>
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end:: Card header-->
                                            <!--begin:: Card body-->
                                            <div class="card-body p-9">
                                                <!--begin::Name-->
                                                <div class="fs-3 fw-bold text-gray-900">9 Degree</div>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <p class="text-gray-500 fw-semibold fs-5 mt-1 mb-7">CRM App application to HR efficiency</p>
                                                <!--end::Description-->
                                                <!--begin::Info-->
                                                <div class="d-flex flex-wrap mb-5">
                                                    <!--begin::Due-->
                                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                                        <div class="fs-6 text-gray-800 fw-bold">Mar 10, 2024</div>
                                                        <div class="fw-semibold text-gray-500">Due Date</div>
                                                    </div>
                                                    <!--end::Due-->
                                                    <!--begin::Budget-->
                                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                                        <div class="fs-6 text-gray-800 fw-bold">$284,900.00</div>
                                                        <div class="fw-semibold text-gray-500">Budget</div>
                                                    </div>
                                                    <!--end::Budget-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Progress-->
                                                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="This project 40% completed">
                                                    <div class="bg-primary rounded h-4px" role="progressbar" style="width: 40%" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <!--end::Progress-->
                                                <!--begin::Users-->
                                                <div class="symbol-group symbol-hover">
                                                    <!--begin::User-->
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Francis Mitcham">
                                                        <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-20.jpg" />
                                                    </div>
                                                    <!--begin::User-->
                                                    <!--begin::User-->
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Michelle Swanston">
                                                        <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-7.jpg" />
                                                    </div>
                                                    <!--begin::User-->
                                                    <!--begin::User-->
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Susan Redwood">
                                                        <span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
                                                    </div>
                                                    <!--begin::User-->
                                                </div>
                                                <!--end::Users-->
                                            </div>
                                            <!--end:: Card body-->
                                        </a>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-xl-4">
                                        <!--begin::Card-->
                                        <a href="<?php echo site_url(); ?>/admin/campaigns/single/6" class="card border-hover-primary">
                                            <!--begin::Card header-->
                                            <div class="card-header border-0 pt-9">
                                                <!--begin::Card Title-->
                                                <div class="card-title m-0">
                                                    <!--begin::Avatar-->
                                                    <div class="symbol symbol-50px w-50px bg-light">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/tvit.svg" alt="image" class="p-3" />
                                                    </div>
                                                    <!--end::Avatar-->
                                                </div>
                                                <!--end::Car Title-->
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <span class="badge badge-light-primary fw-bold me-auto px-4 py-3">In Progress</span>
                                                </div>
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end:: Card header-->
                                            <!--begin:: Card body-->
                                            <div class="card-body p-9">
                                                <!--begin::Name-->
                                                <div class="fs-3 fw-bold text-gray-900">GoPro App</div>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <p class="text-gray-500 fw-semibold fs-5 mt-1 mb-7">CRM App application to HR efficiency</p>
                                                <!--end::Description-->
                                                <!--begin::Info-->
                                                <div class="d-flex flex-wrap mb-5">
                                                    <!--begin::Due-->
                                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                                        <div class="fs-6 text-gray-800 fw-bold">Oct 25, 2024</div>
                                                        <div class="fw-semibold text-gray-500">Due Date</div>
                                                    </div>
                                                    <!--end::Due-->
                                                    <!--begin::Budget-->
                                                    <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                                        <div class="fs-6 text-gray-800 fw-bold">$284,900.00</div>
                                                        <div class="fw-semibold text-gray-500">Budget</div>
                                                    </div>
                                                    <!--end::Budget-->
                                                </div>
                                                <!--end::Info-->
                                                <!--begin::Progress-->
                                                <div class="h-4px w-100 bg-light mb-5" data-bs-toggle="tooltip" title="This project 70% completed">
                                                    <div class="bg-primary rounded h-4px" role="progressbar" style="width: 70%" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                                <!--end::Progress-->
                                                <!--begin::Users-->
                                                <div class="symbol-group symbol-hover">
                                                    <!--begin::User-->
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Melody Macy">
                                                        <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-2.jpg" />
                                                    </div>
                                                    <!--begin::User-->
                                                    <!--begin::User-->
                                                    <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Robin Watterman">
                                                        <span class="symbol-label bg-success text-inverse-success fw-bold">R</span>
                                                    </div>
                                                    <!--begin::User-->
                                                </div>
                                                <!--end::Users-->
                                            </div>
                                            <!--end:: Card body-->
                                        </a>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Pagination-->
                                <div class="d-flex flex-stack flex-wrap pt-10">
                                    <div class="fs-6 fw-semibold text-gray-700">Showing 1 to 6 of 10 entries</div>
                                    <!--begin::Pages-->
                                    <ul class="pagination">
                                        <li class="page-item previous">
                                            <a href="#" class="page-link">
                                                <i class="previous"></i>
                                            </a>
                                        </li>
                                        <li class="page-item active">
                                            <a href="#" class="page-link">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a href="#" class="page-link">2</a>
                                        </li>
                                        <li class="page-item next">
                                            <a href="#" class="page-link">
                                                <i class="next"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <!--end::Pages-->
                                </div>
                                <!--end::Pagination-->
                                <!--begin::Modals-->
                                <!--begin::Modal - View Users-->
                                <div class="modal fade" id="kt_modal_view_users" tabindex="-1" aria-hidden="true">
                                    <!--begin::Modal dialog-->
                                    <div class="modal-dialog mw-650px">
                                        <!--begin::Modal content-->
                                        <div class="modal-content">
                                            <!--begin::Modal header-->
                                            <div class="modal-header pb-0 border-0 justify-content-end">
                                                <!--begin::Close-->
                                                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </div>
                                                <!--end::Close-->
                                            </div>
                                            <!--begin::Modal header-->
                                            <!--begin::Modal body-->
                                            <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                                                <!--begin::Heading-->
                                                <div class="text-center mb-13">
                                                    <!--begin::Title-->
                                                    <h1 class="mb-3">Browse Users</h1>
                                                    <!--end::Title-->
                                                    <!--begin::Description-->
                                                    <div class="text-muted fw-semibold fs-5">If you need more info, please check out our
                                                        <a href="#" class="link-primary fw-bold">Users Directory</a>.
                                                    </div>
                                                    <!--end::Description-->
                                                </div>
                                                <!--end::Heading-->
                                                <!--begin::Users-->
                                                <div class="mb-15">
                                                    <!--begin::List-->
                                                    <div class="mh-375px scroll-y me-n7 pe-7">
                                                        <!--begin::User-->
                                                        <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                                            <!--begin::Details-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-35px symbol-circle">
                                                                    <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-6.jpg" />
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-6">
                                                                    <!--begin::Name-->
                                                                    <a href="#" class="d-flex align-items-center fs-5 fw-bold text-gray-900 text-hover-primary">Emma Smith
                                                                        <span class="badge badge-light fs-8 fw-semibold ms-2">Art Director</span></a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Email-->
                                                                    <div class="fw-semibold text-muted">smith@kpmg.com</div>
                                                                    <!--end::Email-->
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::Details-->
                                                            <!--begin::Stats-->
                                                            <div class="d-flex">
                                                                <!--begin::Sales-->
                                                                <div class="text-end">
                                                                    <div class="fs-5 fw-bold text-gray-900">$23,000</div>
                                                                    <div class="fs-7 text-muted">Sales</div>
                                                                </div>
                                                                <!--end::Sales-->
                                                            </div>
                                                            <!--end::Stats-->
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                                            <!--begin::Details-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-35px symbol-circle">
                                                                    <span class="symbol-label bg-light-danger text-danger fw-semibold">M</span>
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-6">
                                                                    <!--begin::Name-->
                                                                    <a href="#" class="d-flex align-items-center fs-5 fw-bold text-gray-900 text-hover-primary">Melody Macy
                                                                        <span class="badge badge-light fs-8 fw-semibold ms-2">Marketing Analytic</span></a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Email-->
                                                                    <div class="fw-semibold text-muted">melody@altbox.com</div>
                                                                    <!--end::Email-->
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::Details-->
                                                            <!--begin::Stats-->
                                                            <div class="d-flex">
                                                                <!--begin::Sales-->
                                                                <div class="text-end">
                                                                    <div class="fs-5 fw-bold text-gray-900">$50,500</div>
                                                                    <div class="fs-7 text-muted">Sales</div>
                                                                </div>
                                                                <!--end::Sales-->
                                                            </div>
                                                            <!--end::Stats-->
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                                            <!--begin::Details-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-35px symbol-circle">
                                                                    <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-1.jpg" />
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-6">
                                                                    <!--begin::Name-->
                                                                    <a href="#" class="d-flex align-items-center fs-5 fw-bold text-gray-900 text-hover-primary">Max Smith
                                                                        <span class="badge badge-light fs-8 fw-semibold ms-2">Software Enginer</span></a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Email-->
                                                                    <div class="fw-semibold text-muted">max@kt.com</div>
                                                                    <!--end::Email-->
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::Details-->
                                                            <!--begin::Stats-->
                                                            <div class="d-flex">
                                                                <!--begin::Sales-->
                                                                <div class="text-end">
                                                                    <div class="fs-5 fw-bold text-gray-900">$75,900</div>
                                                                    <div class="fs-7 text-muted">Sales</div>
                                                                </div>
                                                                <!--end::Sales-->
                                                            </div>
                                                            <!--end::Stats-->
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                                            <!--begin::Details-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-35px symbol-circle">
                                                                    <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-5.jpg" />
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-6">
                                                                    <!--begin::Name-->
                                                                    <a href="#" class="d-flex align-items-center fs-5 fw-bold text-gray-900 text-hover-primary">Sean Bean
                                                                        <span class="badge badge-light fs-8 fw-semibold ms-2">Web Developer</span></a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Email-->
                                                                    <div class="fw-semibold text-muted">sean@dellito.com</div>
                                                                    <!--end::Email-->
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::Details-->
                                                            <!--begin::Stats-->
                                                            <div class="d-flex">
                                                                <!--begin::Sales-->
                                                                <div class="text-end">
                                                                    <div class="fs-5 fw-bold text-gray-900">$10,500</div>
                                                                    <div class="fs-7 text-muted">Sales</div>
                                                                </div>
                                                                <!--end::Sales-->
                                                            </div>
                                                            <!--end::Stats-->
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                                            <!--begin::Details-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-35px symbol-circle">
                                                                    <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-25.jpg" />
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-6">
                                                                    <!--begin::Name-->
                                                                    <a href="#" class="d-flex align-items-center fs-5 fw-bold text-gray-900 text-hover-primary">Brian Cox
                                                                        <span class="badge badge-light fs-8 fw-semibold ms-2">UI/UX Designer</span></a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Email-->
                                                                    <div class="fw-semibold text-muted">brian@exchange.com</div>
                                                                    <!--end::Email-->
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::Details-->
                                                            <!--begin::Stats-->
                                                            <div class="d-flex">
                                                                <!--begin::Sales-->
                                                                <div class="text-end">
                                                                    <div class="fs-5 fw-bold text-gray-900">$20,000</div>
                                                                    <div class="fs-7 text-muted">Sales</div>
                                                                </div>
                                                                <!--end::Sales-->
                                                            </div>
                                                            <!--end::Stats-->
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                                            <!--begin::Details-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-35px symbol-circle">
                                                                    <span class="symbol-label bg-light-warning text-warning fw-semibold">C</span>
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-6">
                                                                    <!--begin::Name-->
                                                                    <a href="#" class="d-flex align-items-center fs-5 fw-bold text-gray-900 text-hover-primary">Mikaela Collins
                                                                        <span class="badge badge-light fs-8 fw-semibold ms-2">Head Of Marketing</span></a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Email-->
                                                                    <div class="fw-semibold text-muted">mik@pex.com</div>
                                                                    <!--end::Email-->
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::Details-->
                                                            <!--begin::Stats-->
                                                            <div class="d-flex">
                                                                <!--begin::Sales-->
                                                                <div class="text-end">
                                                                    <div class="fs-5 fw-bold text-gray-900">$9,300</div>
                                                                    <div class="fs-7 text-muted">Sales</div>
                                                                </div>
                                                                <!--end::Sales-->
                                                            </div>
                                                            <!--end::Stats-->
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                                            <!--begin::Details-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-35px symbol-circle">
                                                                    <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-9.jpg" />
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-6">
                                                                    <!--begin::Name-->
                                                                    <a href="#" class="d-flex align-items-center fs-5 fw-bold text-gray-900 text-hover-primary">Francis Mitcham
                                                                        <span class="badge badge-light fs-8 fw-semibold ms-2">Software Arcitect</span></a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Email-->
                                                                    <div class="fw-semibold text-muted">f.mit@kpmg.com</div>
                                                                    <!--end::Email-->
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::Details-->
                                                            <!--begin::Stats-->
                                                            <div class="d-flex">
                                                                <!--begin::Sales-->
                                                                <div class="text-end">
                                                                    <div class="fs-5 fw-bold text-gray-900">$15,000</div>
                                                                    <div class="fs-7 text-muted">Sales</div>
                                                                </div>
                                                                <!--end::Sales-->
                                                            </div>
                                                            <!--end::Stats-->
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                                            <!--begin::Details-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-35px symbol-circle">
                                                                    <span class="symbol-label bg-light-danger text-danger fw-semibold">O</span>
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-6">
                                                                    <!--begin::Name-->
                                                                    <a href="#" class="d-flex align-items-center fs-5 fw-bold text-gray-900 text-hover-primary">Olivia Wild
                                                                        <span class="badge badge-light fs-8 fw-semibold ms-2">System Admin</span></a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Email-->
                                                                    <div class="fw-semibold text-muted">olivia@corpmail.com</div>
                                                                    <!--end::Email-->
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::Details-->
                                                            <!--begin::Stats-->
                                                            <div class="d-flex">
                                                                <!--begin::Sales-->
                                                                <div class="text-end">
                                                                    <div class="fs-5 fw-bold text-gray-900">$23,000</div>
                                                                    <div class="fs-7 text-muted">Sales</div>
                                                                </div>
                                                                <!--end::Sales-->
                                                            </div>
                                                            <!--end::Stats-->
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                                            <!--begin::Details-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-35px symbol-circle">
                                                                    <span class="symbol-label bg-light-primary text-primary fw-semibold">N</span>
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-6">
                                                                    <!--begin::Name-->
                                                                    <a href="#" class="d-flex align-items-center fs-5 fw-bold text-gray-900 text-hover-primary">Neil Owen
                                                                        <span class="badge badge-light fs-8 fw-semibold ms-2">Account Manager</span></a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Email-->
                                                                    <div class="fw-semibold text-muted">owen.neil@gmail.com</div>
                                                                    <!--end::Email-->
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::Details-->
                                                            <!--begin::Stats-->
                                                            <div class="d-flex">
                                                                <!--begin::Sales-->
                                                                <div class="text-end">
                                                                    <div class="fs-5 fw-bold text-gray-900">$45,800</div>
                                                                    <div class="fs-7 text-muted">Sales</div>
                                                                </div>
                                                                <!--end::Sales-->
                                                            </div>
                                                            <!--end::Stats-->
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                                            <!--begin::Details-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-35px symbol-circle">
                                                                    <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-23.jpg" />
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-6">
                                                                    <!--begin::Name-->
                                                                    <a href="#" class="d-flex align-items-center fs-5 fw-bold text-gray-900 text-hover-primary">Dan Wilson
                                                                        <span class="badge badge-light fs-8 fw-semibold ms-2">Web Desinger</span></a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Email-->
                                                                    <div class="fw-semibold text-muted">dam@consilting.com</div>
                                                                    <!--end::Email-->
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::Details-->
                                                            <!--begin::Stats-->
                                                            <div class="d-flex">
                                                                <!--begin::Sales-->
                                                                <div class="text-end">
                                                                    <div class="fs-5 fw-bold text-gray-900">$90,500</div>
                                                                    <div class="fs-7 text-muted">Sales</div>
                                                                </div>
                                                                <!--end::Sales-->
                                                            </div>
                                                            <!--end::Stats-->
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                                            <!--begin::Details-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-35px symbol-circle">
                                                                    <span class="symbol-label bg-light-danger text-danger fw-semibold">E</span>
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-6">
                                                                    <!--begin::Name-->
                                                                    <a href="#" class="d-flex align-items-center fs-5 fw-bold text-gray-900 text-hover-primary">Emma Bold
                                                                        <span class="badge badge-light fs-8 fw-semibold ms-2">Corporate Finance</span></a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Email-->
                                                                    <div class="fw-semibold text-muted">emma@intenso.com</div>
                                                                    <!--end::Email-->
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::Details-->
                                                            <!--begin::Stats-->
                                                            <div class="d-flex">
                                                                <!--begin::Sales-->
                                                                <div class="text-end">
                                                                    <div class="fs-5 fw-bold text-gray-900">$5,000</div>
                                                                    <div class="fs-7 text-muted">Sales</div>
                                                                </div>
                                                                <!--end::Sales-->
                                                            </div>
                                                            <!--end::Stats-->
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="d-flex flex-stack py-5 border-bottom border-gray-300 border-bottom-dashed">
                                                            <!--begin::Details-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-35px symbol-circle">
                                                                    <img alt="Pic" src="<?php echo site_url(); ?>/assets/media/avatars/300-12.jpg" />
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-6">
                                                                    <!--begin::Name-->
                                                                    <a href="#" class="d-flex align-items-center fs-5 fw-bold text-gray-900 text-hover-primary">Ana Crown
                                                                        <span class="badge badge-light fs-8 fw-semibold ms-2">Customer Relationship</span></a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Email-->
                                                                    <div class="fw-semibold text-muted">ana.cf@limtel.com</div>
                                                                    <!--end::Email-->
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::Details-->
                                                            <!--begin::Stats-->
                                                            <div class="d-flex">
                                                                <!--begin::Sales-->
                                                                <div class="text-end">
                                                                    <div class="fs-5 fw-bold text-gray-900">$70,000</div>
                                                                    <div class="fs-7 text-muted">Sales</div>
                                                                </div>
                                                                <!--end::Sales-->
                                                            </div>
                                                            <!--end::Stats-->
                                                        </div>
                                                        <!--end::User-->
                                                        <!--begin::User-->
                                                        <div class="d-flex flex-stack py-5">
                                                            <!--begin::Details-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-35px symbol-circle">
                                                                    <span class="symbol-label bg-light-info text-info fw-semibold">A</span>
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-6">
                                                                    <!--begin::Name-->
                                                                    <a href="#" class="d-flex align-items-center fs-5 fw-bold text-gray-900 text-hover-primary">Robert Doe
                                                                        <span class="badge badge-light fs-8 fw-semibold ms-2">Marketing Executive</span></a>
                                                                    <!--end::Name-->
                                                                    <!--begin::Email-->
                                                                    <div class="fw-semibold text-muted">robert@benko.com</div>
                                                                    <!--end::Email-->
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::Details-->
                                                            <!--begin::Stats-->
                                                            <div class="d-flex">
                                                                <!--begin::Sales-->
                                                                <div class="text-end">
                                                                    <div class="fs-5 fw-bold text-gray-900">$45,500</div>
                                                                    <div class="fs-7 text-muted">Sales</div>
                                                                </div>
                                                                <!--end::Sales-->
                                                            </div>
                                                            <!--end::Stats-->
                                                        </div>
                                                        <!--end::User-->
                                                    </div>
                                                    <!--end::List-->
                                                </div>
                                                <!--end::Users-->
                                                <!--begin::Notice-->
                                                <div class="d-flex justify-content-between">
                                                    <!--begin::Label-->
                                                    <div class="fw-semibold">
                                                        <label class="fs-6">Adding Users by Team Members</label>
                                                        <div class="fs-7 text-muted">If you need more info, please check budget planning</div>
                                                    </div>
                                                    <!--end::Label-->
                                                    <!--begin::Switch-->
                                                    <label class="form-check form-switch form-check-custom form-check-solid">
                                                        <input class="form-check-input" type="checkbox" value="" checked="checked" />
                                                        <span class="form-check-label fw-semibold text-muted">Allowed</span>
                                                    </label>
                                                    <!--end::Switch-->
                                                </div>
                                                <!--end::Notice-->
                                            </div>
                                            <!--end::Modal body-->
                                        </div>
                                        <!--end::Modal content-->
                                    </div>
                                    <!--end::Modal dialog-->
                                </div>
                                <!--end::Modal - View Users-->
                                <!--begin::Modal - Users Search-->
                                <div class="modal fade" id="kt_modal_users_search" tabindex="-1" aria-hidden="true">
                                    <!--begin::Modal dialog-->
                                    <div class="modal-dialog modal-dialog-centered mw-650px">
                                        <!--begin::Modal content-->
                                        <div class="modal-content">
                                            <!--begin::Modal header-->
                                            <div class="modal-header pb-0 border-0 justify-content-end">
                                                <!--begin::Close-->
                                                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                                                    <i class="ki-outline ki-cross fs-1"></i>
                                                </div>
                                                <!--end::Close-->
                                            </div>
                                            <!--begin::Modal header-->
                                            <!--begin::Modal body-->
                                            <div class="modal-body scroll-y mx-5 mx-xl-18 pt-0 pb-15">
                                                <!--begin::Content-->
                                                <div class="text-center mb-13">
                                                    <h1 class="mb-3">Search Users</h1>
                                                    <div class="text-muted fw-semibold fs-5">Invite Collaborators To Your Project</div>
                                                </div>
                                                <!--end::Content-->
                                                <!--begin::Search-->
                                                <div id="kt_modal_users_search_handler" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="inline">
                                                    <!--begin::Form-->
                                                    <form data-kt-search-element="form" class="w-100 position-relative mb-5" autocomplete="off">
                                                        <!--begin::Hidden input(Added to disable form autocomplete)-->
                                                        <input type="hidden" />
                                                        <!--end::Hidden input-->
                                                        <!--begin::Icon-->
                                                        <i class="ki-outline ki-magnifier fs-2 fs-lg-1 text-gray-500 position-absolute top-50 ms-5 translate-middle-y"></i>
                                                        <!--end::Icon-->
                                                        <!--begin::Input-->
                                                        <input type="text" class="form-control form-control-lg form-control-solid px-15" name="search" value="" placeholder="Search by username, full name or email..." data-kt-search-element="input" />
                                                        <!--end::Input-->
                                                        <!--begin::Spinner-->
                                                        <span class="position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5" data-kt-search-element="spinner">
                                                            <span class="spinner-border h-15px w-15px align-middle text-muted"></span>
                                                        </span>
                                                        <!--end::Spinner-->
                                                        <!--begin::Reset-->
                                                        <span class="btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 me-5 d-none" data-kt-search-element="clear">
                                                            <i class="ki-outline ki-cross fs-2 fs-lg-1 me-0"></i>
                                                        </span>
                                                        <!--end::Reset-->
                                                    </form>
                                                    <!--end::Form-->
                                                </div>
                                                <!--end::Search-->
                                            </div>
                                            <!--end::Modal body-->
                                        </div>
                                        <!--end::Modal content-->
                                    </div>
                                    <!--end::Modal dialog-->
                                </div>
                                <!--end::Modal - Users Search-->
                                <!--end::Modals-->
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
</body>
<!--end::Body-->

</html>