<?php require '../config.php';
$page_name = 'dashboard';
$sub_page_name = '';

Admin()->check_login();

if (sipost('first_name') || sipost('last_name') || sipost('email')) {

    $response = Advisor()->add_advisor();

    if ($response == 1) {
        $_SESSION['process_success'] = true;
    } elseif ($response == 'duplicate') {
        $_SESSION['process_duplicate'] = true;
    } else {
        $_SESSION['process_fail'] = true;
    }

    wp_redirect(site_url() . '/admin/dashboard');
    exit;
}

$get_state_list = Settings()->get_state_list();

$get_lead_source_list = Settings()->get_lead_source_list();

$login_admin_info = Admin()->get_login_admin_info($_SESSION['fbs_arm_admin_id']);

$total_new_advisor  = Advisor()->get_count_total_advisor_by_status(1);
$total_cold_advisor = Advisor()->get_count_total_advisor_by_status(2);
$total_warm_advisor = Advisor()->get_count_total_advisor_by_status(3);
$total_hot_advisor  = Advisor()->get_count_total_advisor_by_status(4);
$total_won_advisor  = Advisor()->get_count_total_advisor_by_status(5);

$get_today_activity = Advisor()->get_today_activity($_SESSION['fbs_arm_admin_id']);

$get_advisor_upcoming_activity_list = Advisor()->get_upcoming_activity($_SESSION['fbs_arm_admin_id']);

$get_advisor_note_list = Advisor()->get_note_list($_SESSION['fbs_arm_admin_id']);
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/head.php'; ?>
    <style>
        .swal2-popup {
            padding-bottom: 50px;
        }
    </style>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true" data-kt-app-aside-push-footer="true" class="app-default">
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
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Dashboard</h1>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Page title-->
                                    <!--begin::Actions-->
                                    <div class="">
                                        <?php
                                        $bookmark = Advisor()->check_bookmark(site_url() . '/admin/dashboard');

                                        if ($bookmark) { ?>
                                            <i class="bi bi-bookmarks-fill fs-2x cursor-pointer text-primary  bookmark_page" bookmark_url="<?php echo site_url(); ?>/admin/dashboard"></i>
                                        <?php } else { ?>
                                            <i class="bi bi-bookmarks fs-2x cursor-pointer text-primary bookmark_page" data-bs-toggle="modal" data-bs-target="#kt_modal_bookmark_link" bookmark_name="Dashboard" bookmark_url="<?php echo site_url(); ?>/admin/dashboard"></i>
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
                                <?php } ?>
                                <!--begin::Row-->
                                <div class="row g-5 g-xl-10">
                                    <!--begin::Col-->
                                    <div class="col-xl-3">
                                        <div class="card mb-5">
                                            <!--begin::Card body-->
                                            <div class="card-body">
                                                <h4>My Profile</h4>
                                                <!--begin::User Info-->
                                                <div class="d-flex flex-left flex-column py-5">
                                                    <!--begin::Name-->
                                                    <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1"><?php echo $login_admin_info->first_name . ' ' . $login_admin_info->last_name; ?></a>
                                                    <!--end::Name-->

                                                    <div class="text-gray-600 mb-5"><?php echo 'Admin'; ?></div>

                                                    <!--begin::Section-->
                                                    <a href="<?php echo site_url(); ?>/admin/profile" class="text-primary fw-semibold fs-6 me-2">My Profile </a>
                                                    <!--end::Section-->
                                                    <div class="separator separator-dashed my-3"></div>

                                                    <!--begin::Section-->
                                                    <a href="#" class="text-primary fw-semibold fs-6 me-2" data-bs-toggle="modal" data-bs-target="#kt_modal_advisor" title="Add Advisor">Add an Agent </a>
                                                    <!--end::Section-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--begin::Section-->
                                                    <a href="<?php echo site_url(); ?>/admin/verification/advisor-list" class="text-primary fw-semibold fs-6 me-2">Verification Request </a>
                                                    <!--end::Section-->
                                                    <div class="separator separator-dashed my-3"></div>

                                                </div>
                                                <!--end::User Info-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--begin::List widget 12-->
                                        <div class="card mb-5 ">
                                            <!--begin::Header-->
                                            <div class="card-header pt-7">
                                                <!--begin::Title-->
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold text-gray-800">Lead by Source</span>
                                                    <span class="text-gray-500 mt-1 fw-semibold fs-6">29.4k visitors</span>
                                                </h3>
                                                <!--end::Title-->
                                                <!--begin::Toolbar-->
                                                <div class="card-toolbar">
                                                    <!--begin::Menu-->
                                                    <button class="btn btn-icon btn-color-gray-500 btn-active-color-primary justify-content-end" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true">
                                                        <i class="ki-outline ki-dots-square fs-1 text-gray-500 me-n1"></i>
                                                    </button>
                                                    <!--begin::Menu 2-->
                                                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px" data-kt-menu="true">
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <div class="menu-content fs-6 text-gray-900 fw-bold px-3 py-4">Quick Actions</div>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu separator-->
                                                        <div class="separator mb-3 opacity-75"></div>
                                                        <!--end::Menu separator-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">Day</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">Week</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                        <!--begin::Menu item-->
                                                        <div class="menu-item px-3">
                                                            <a href="#" class="menu-link px-3">Month</a>
                                                        </div>
                                                        <!--end::Menu item-->
                                                    </div>
                                                    <!--end::Menu 2-->
                                                    <!--end::Menu-->
                                                </div>
                                                <!--end::Toolbar-->
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Body-->
                                            <div class="card-body d-flex align-items-end">
                                                <!--begin::Wrapper-->
                                                <div class="w-100 scroll h-300px">
                                                    <!--begin::Item-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <span class="symbol-label">
                                                                <i class="ki-outline ki-rocket fs-3 text-gray-600"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Container-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Web</a>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">11</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <!--begin::label-->
                                                                <span class="badge badge-light-success fs-base">
                                                                    <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.6%</span>
                                                                <!--end::label-->
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Container-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <span class="symbol-label">
                                                                <i class="ki-outline ki-rocket fs-3 text-gray-600"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Container-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Phone Inquiry</a>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">2</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <!--begin::label-->
                                                                <span class="badge badge-light-success fs-base">
                                                                    <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>4.1%</span>
                                                                <!--end::label-->
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Container-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <span class="symbol-label">
                                                                <i class="ki-outline ki-rocket fs-3 text-gray-600"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Container-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Carrier Referral</a>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">7</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <!--begin::label-->
                                                                <span class="badge badge-light-success fs-base">
                                                                    <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>0.2%</span>
                                                                <!--end::label-->
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Container-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <span class="symbol-label">
                                                                <i class="ki-outline ki-rocket fs-3 text-gray-600"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Container-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Agent Referral</a>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">6</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <!--begin::label-->
                                                                <span class="badge badge-light-danger fs-base">
                                                                    <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.4%</span>
                                                                <!--end::label-->
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Container-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <span class="symbol-label">
                                                                <i class="ki-outline ki-rocket fs-3 text-gray-600"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Container-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Partner Partner</a>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">6</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <!--begin::label-->
                                                                <span class="badge badge-light-danger fs-base">
                                                                    <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.4%</span>
                                                                <!--end::label-->
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Container-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <span class="symbol-label">
                                                                <i class="ki-outline ki-rocket fs-3 text-gray-600"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Container-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Public Relations</a>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">6</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <!--begin::label-->
                                                                <span class="badge badge-light-danger fs-base">
                                                                    <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.4%</span>
                                                                <!--end::label-->
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Container-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <span class="symbol-label">
                                                                <i class="ki-outline ki-rocket fs-3 text-gray-600"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Container-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Trade Show</a>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">6</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <!--begin::label-->
                                                                <span class="badge badge-light-danger fs-base">
                                                                    <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.4%</span>
                                                                <!--end::label-->
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Container-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <span class="symbol-label">
                                                                <i class="ki-outline ki-rocket fs-3 text-gray-600"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Container-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Word of mouth</a>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">6</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <!--begin::label-->
                                                                <span class="badge badge-light-danger fs-base">
                                                                    <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.4%</span>
                                                                <!--end::label-->
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Container-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <span class="symbol-label">
                                                                <i class="ki-outline ki-rocket fs-3 text-gray-600"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Container-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Employee Referral</a>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">6</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <!--begin::label-->
                                                                <span class="badge badge-light-danger fs-base">
                                                                    <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.4%</span>
                                                                <!--end::label-->
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Container-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <span class="symbol-label">
                                                                <i class="ki-outline ki-rocket fs-3 text-gray-600"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Container-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Purchased List</a>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">6</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <!--begin::label-->
                                                                <span class="badge badge-light-danger fs-base">
                                                                    <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.4%</span>
                                                                <!--end::label-->
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Container-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <span class="symbol-label">
                                                                <i class="ki-outline ki-rocket fs-3 text-gray-600"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Container-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Other</a>
                                                                <!--end::Title-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">0</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <!--begin::label-->
                                                                <span class="badge badge-light-success fs-base">
                                                                    <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>8.3%</span>
                                                                <!--end::label-->
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Container-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Link-->
                                                    <div class="text-center pt-8 d-1">
                                                        <a href="" class="text-primary opacity-75-hover fs-6 fw-bold">View Advisor
                                                            <i class="ki-outline ki-arrow-right fs-3 text-primary"></i></a>
                                                    </div>
                                                    <!--end::Link-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::List widget 12-->
                                        <!--begin::List widget 9-->
                                        <div class="card ">
                                            <!--begin::Header-->
                                            <div class="card-header py-7">
                                                <!--begin::Title-->
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold text-gray-800">Social Network Visits</span>
                                                    <span class="text-gray-500 mt-1 fw-semibold fs-6">20 social visitors</span>
                                                </h3>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Body-->
                                            <div class="card-body card-body d-flex justify-content-between flex-column pt-3">
                                                <div class="w-100 scroll h-300px">
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Flag-->
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/facebook-3.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                                        <!--end::Flag-->
                                                        <!--begin::Section-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Facebook</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Network</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">6</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <div class="m-0">
                                                                    <!--begin::Label-->
                                                                    <span class="badge badge-light-success fs-base">
                                                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>1.9%</span>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Section-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->

                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Flag-->
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/instagram-2-1.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                                        <!--end::Flag-->
                                                        <!--begin::Section-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Instagram</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Network</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">5</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <div class="m-0">
                                                                    <!--begin::Label-->
                                                                    <span class="badge badge-light-success fs-base">
                                                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>8.3%</span>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Section-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->

                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Flag-->
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/linkedin-1.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                                        <!--end::Flag-->
                                                        <!--begin::Section-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Linked In</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Media</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">2</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <div class="m-0">
                                                                    <!--begin::Label-->
                                                                    <span class="badge badge-light-danger fs-base">
                                                                        <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.4%</span>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Section-->
                                                    </div>
                                                    <!--end::Item-->

                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->

                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Flag-->
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/pinterest-p.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                                        <!--end::Flag-->
                                                        <!--begin::Section-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Pinterest</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Network</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">5</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <div class="m-0">
                                                                    <!--begin::Label-->
                                                                    <span class="badge badge-light-success fs-base">
                                                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>8.3%</span>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Section-->
                                                    </div>
                                                    <!--end::Item-->

                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->

                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Flag-->
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/quora.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                                        <!--end::Flag-->
                                                        <!--begin::Section-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Quora</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Network</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">5</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <div class="m-0">
                                                                    <!--begin::Label-->
                                                                    <span class="badge badge-light-success fs-base">
                                                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>8.3%</span>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Section-->
                                                    </div>
                                                    <!--end::Item-->

                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->

                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Flag-->
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/reddit.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                                        <!--end::Flag-->
                                                        <!--begin::Section-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Reddit</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Network</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">5</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <div class="m-0">
                                                                    <!--begin::Label-->
                                                                    <span class="badge badge-light-success fs-base">
                                                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>8.3%</span>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Section-->
                                                    </div>
                                                    <!--end::Item-->

                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->

                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Flag-->
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/tiktok.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                                        <!--end::Flag-->
                                                        <!--begin::Section-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">TikTok</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Network</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">5</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <div class="m-0">
                                                                    <!--begin::Label-->
                                                                    <span class="badge badge-light-success fs-base">
                                                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>8.3%</span>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Section-->
                                                    </div>
                                                    <!--end::Item-->

                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->

                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Flag-->
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/twitter.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                                        <!--end::Flag-->
                                                        <!--begin::Section-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Twitter</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Network</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">5</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <div class="m-0">
                                                                    <!--begin::Label-->
                                                                    <span class="badge badge-light-success fs-base">
                                                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>8.3%</span>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Section-->
                                                    </div>
                                                    <!--end::Item-->

                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->

                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Flag-->
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/youtube-3.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                                        <!--end::Flag-->
                                                        <!--begin::Section-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">YouTube</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Video Channel</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">4</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <div class="m-0">
                                                                    <!--begin::Label-->
                                                                    <span class="badge badge-light-success fs-base">
                                                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>4.1%</span>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Section-->
                                                    </div>
                                                    <!--end::Item-->

                                                </div>
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::List widget 9-->
                                    </div>
                                    <!--end::Col-->

                                    <!--begin::Col-->
                                    <div class="col-xl-9">
                                        <!--begin::List widget 9-->
                                        <div class="card">
                                            <!--begin::Header-->
                                            <div class="card-header">
                                                <!--begin::Title-->
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold text-gray-800">ARM Contacts</span>
                                                </h3>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Body-->
                                            <div class="card-body">
                                                <div class="row g-5">
                                                    <div class="w_20 col-sm-2 mb-xl-10">
                                                        <!--begin::Card widget 2-->
                                                        <div class="card h-lg-100">
                                                            <a href="<?php echo site_url(); ?>/admin/advisor/advisor-list/1">
                                                                <!--begin::Body-->
                                                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                                    <!--begin::Icon-->
                                                                    <div class="m-0">
                                                                        <i class="ki-outline ki-chart-simple fs-2hx text-gray-600"></i>
                                                                    </div>
                                                                    <!--end::Icon-->
                                                                    <!--begin::Section-->
                                                                    <div class="d-flex flex-column my-7 mb-2">
                                                                        <!--begin::Number-->
                                                                        <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2"><?php echo $total_new_advisor; ?></span>
                                                                        <!--end::Number-->
                                                                        <!--begin::Follower-->
                                                                        <div class="m-0">
                                                                            <span class="fw-semibold fs-6 text-gray-500">New Contacts</span>
                                                                        </div>
                                                                        <!--end::Follower-->
                                                                    </div>
                                                                    <!--end::Section-->
                                                                </div>
                                                                <!--end::Body-->
                                                            </a>
                                                        </div>
                                                        <!--end::Card widget 2-->
                                                    </div>
                                                    <!--begin::Col-->
                                                    <div class="w_20 col-sm-2 mb-xl-10">
                                                        <!--begin::Card widget 2-->
                                                        <div class="card h-lg-100">
                                                            <a href="<?php echo site_url(); ?>/admin/advisor/advisor-list/2">
                                                                <!--begin::Body-->
                                                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                                    <!--begin::Icon-->
                                                                    <div class="m-0">
                                                                        <i class="ki-outline ki-chart-simple fs-2hx text-gray-600"></i>
                                                                    </div>
                                                                    <!--end::Icon-->
                                                                    <!--begin::Section-->
                                                                    <div class="d-flex flex-column my-7 mb-2">
                                                                        <!--begin::Number-->
                                                                        <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2"><?php echo $total_cold_advisor; ?></span>
                                                                        <!--end::Number-->
                                                                        <!--begin::Follower-->
                                                                        <div class="m-0">
                                                                            <span class="fw-semibold fs-6 text-gray-500">Cold Contacts</span>
                                                                        </div>
                                                                        <!--end::Follower-->
                                                                    </div>
                                                                    <!--end::Section-->
                                                                </div>
                                                                <!--end::Body-->
                                                            </a>
                                                        </div>
                                                        <!--end::Card widget 2-->
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="w_20 col-sm-2 mb-xl-10">
                                                        <!--begin::Card widget 2-->
                                                        <div class="card h-lg-100">
                                                            <a href="<?php echo site_url(); ?>/admin/advisor/advisor-list/3">
                                                                <!--begin::Body-->
                                                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                                    <!--begin::Icon-->
                                                                    <div class="m-0">
                                                                        <i class="ki-outline ki-chart-simple fs-2hx text-gray-600"></i>
                                                                    </div>
                                                                    <!--end::Icon-->
                                                                    <!--begin::Section-->
                                                                    <div class="d-flex flex-column my-7 mb-2">
                                                                        <!--begin::Number-->
                                                                        <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2"><?php echo $total_warm_advisor; ?></span>
                                                                        <!--end::Number-->
                                                                        <!--begin::Follower-->
                                                                        <div class="m-0">
                                                                            <span class="fw-semibold fs-6 text-gray-500">Warm Contacts</span>
                                                                        </div>
                                                                        <!--end::Follower-->
                                                                    </div>
                                                                    <!--end::Section-->
                                                                </div>
                                                                <!--end::Body-->
                                                            </a>
                                                        </div>
                                                        <!--end::Card widget 2-->
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="w_20 col-sm-2 mb-xl-10">
                                                        <!--begin::Card widget 2-->
                                                        <div class="card h-lg-100">
                                                            <a href="<?php echo site_url(); ?>/admin/advisor/advisor-list/4">
                                                                <!--begin::Body-->
                                                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                                    <!--begin::Icon-->
                                                                    <div class="m-0">
                                                                        <i class="ki-outline ki-chart-simple fs-2hx text-gray-600"></i>
                                                                    </div>
                                                                    <!--end::Icon-->
                                                                    <!--begin::Section-->
                                                                    <div class="d-flex flex-column my-7 mb-2">
                                                                        <!--begin::Number-->
                                                                        <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2"><?php echo $total_hot_advisor; ?></span>
                                                                        <!--end::Number-->
                                                                        <!--begin::Follower-->
                                                                        <div class="m-0">
                                                                            <span class="fw-semibold fs-6 text-gray-500">Hot Contacts</span>
                                                                        </div>
                                                                        <!--end::Follower-->
                                                                    </div>
                                                                    <!--end::Section-->
                                                                </div>
                                                                <!--end::Body-->
                                                            </a>
                                                        </div>
                                                        <!--end::Card widget 2-->
                                                    </div>
                                                    <!--end::Col-->
                                                    <!--begin::Col-->
                                                    <div class="w_20 col-sm-2 mb-xl-10">
                                                        <!--begin::Card widget 2-->
                                                        <div class="card h-lg-100">
                                                            <a href="<?php echo site_url(); ?>/admin/advisor/advisor-list/5">
                                                                <!--begin::Body-->
                                                                <div class="card-body d-flex justify-content-between align-items-start flex-column">
                                                                    <!--begin::Icon-->
                                                                    <div class="m-0">
                                                                        <i class="ki-outline ki-chart-simple fs-2hx text-gray-600"></i>
                                                                    </div>
                                                                    <!--end::Icon-->
                                                                    <!--begin::Section-->
                                                                    <div class="d-flex flex-column my-7 mb-2">
                                                                        <!--begin::Number-->
                                                                        <span class="fw-semibold fs-2x text-gray-800 lh-1 ls-n2"><?php echo $total_won_advisor; ?></span>
                                                                        <!--end::Number-->
                                                                        <!--begin::Follower-->
                                                                        <div class="m-0">
                                                                            <span class="fw-semibold fs-6 text-gray-500">Won</span>
                                                                        </div>
                                                                        <!--end::Follower-->
                                                                    </div>
                                                                    <!--end::Section-->
                                                                </div>
                                                                <!--end::Body-->
                                                            </a>
                                                        </div>
                                                        <!--end::Card widget 2-->
                                                    </div>
                                                    <!--end::Col-->
                                                </div>
                                                <div class="text-center">
                                                    <a href="<?php echo site_url() ?>/admin/advisor/advisor-list" class="text-primary opacity-75-hover fs-6 fw-bold">View All Contact Records
                                                        <i class="ki-outline ki-arrow-right fs-3 text-primary"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-5 mt-5">
                                            <div class="col-xl-9">
                                                <!--begin::List widget 9-->
                                                <div class="card">
                                                    <!--begin::Header-->
                                                    <div class="card-header">
                                                        <!--begin::Title-->
                                                        <h3 class="card-title align-items-start flex-column">
                                                            <span class="card-label fw-bold text-gray-800">Today’s Appointments</span>
                                                        </h3>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Header-->
                                                    <!--begin::Body-->
                                                    <div class="card-body">
                                                        <div class="row g-5">
                                                            <?php
                                                            if ($get_today_activity) {
                                                                foreach ($get_today_activity as $activity_result) {

                                                                    $activity_type = ($activity_result->type) ? Settings()->get_selected_activity_type_name($activity_result->type) : '';

                                                                    $name = '';
                                                                    if ($activity_result->user_type == 'advisor') {
                                                                        $user_info = $wpdb->get_row("SELECT first_name, last_name FROM advisor WHERE id = " . $activity_result->user_id);
                                                                        $name = ($user_info) ? $user_info->first_name . ' ' . $user_info->last_name : '';
                                                                    } else if ($activity_result->user_type == 'admin') {
                                                                        $user_info = $wpdb->get_row("SELECT first_name, last_name FROM admin WHERE id = " . $activity_result->user_id);
                                                                        $name = ($user_info) ? $user_info->first_name . ' ' . $user_info->last_name : '';
                                                                    }

                                                            ?>
                                                                    <div class="col-sm-4 mb-xl-10">
                                                                        <!--begin::Card widget 2-->
                                                                        <div class="card h-lg-100">
                                                                            <!--begin::Body-->
                                                                            <div class="card-body p-5">
                                                                                <p>
                                                                                    <i class="las la-clock"></i>
                                                                                    <?php echo $activity_result->start_time . ' - ' . $activity_result->end_time; ?> <span class="text-success"> (Ongoing) </span>
                                                                                </p>
                                                                                <p class="mb-0"><?php echo $activity_type; ?></p>
                                                                                <p class="mb-0"><?php echo $name; ?></p>
                                                                                <a href="<?php echo site_url(); ?>/admin/calendar" class="btn btn-light-primary fw-bold  mt-3">
                                                                                    More Information
                                                                                </a>
                                                                            </div>
                                                                            <!--end::Body-->
                                                                        </div>
                                                                        <!--end::Card widget 2-->
                                                                    </div>
                                                                <?php }
                                                            } else { ?>
                                                                <div class="col-sm-12 mb-xl-10 text-center">I couldn't find any appointments scheduled for today. </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="text-center">
                                                            <a href="<?php echo site_url(); ?>/admin/calendar" class="text-primary opacity-75-hover fs-6 fw-bold">View All Appointments
                                                                <i class="ki-outline ki-arrow-right fs-3 text-primary"></i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xl-3">
                                                <!--begin::List widget 9-->
                                                <div class="card">
                                                    <!--begin::Header-->
                                                    <div class="card-header p-5">
                                                        <!--begin::Title-->
                                                        <h3 class="card-title align-items-start flex-column">
                                                            <span class="card-label fw-bold text-gray-800">Upcoming Appointments</span>
                                                        </h3>
                                                        <!--end::Title-->
                                                    </div>
                                                    <!--end::Header-->
                                                    <!--begin::Body-->
                                                    <div class="card-body">
                                                        <div class="w-100 scroll h-200px">
                                                            <?php
                                                            if ($get_advisor_upcoming_activity_list) {

                                                                foreach ($get_advisor_upcoming_activity_list as $activity_result) { ?>
                                                                    <div class="">
                                                                        <?php echo ($activity_result->note) ? substr($activity_result->note, 0, 55) . '...' : ''; ?>
                                                                    </div>
                                                                    <div class="meta mt-3">
                                                                        <span class="badge py-3 px-4 fs-7 badge-light-primary mb-1"><?php echo date("m/d/Y", strtotime($activity_result->activity_date)); ?></span>
                                                                        <span class="badge py-3 px-4 fs-7 badge-light-primary mb-1"><?php echo $activity_result->start_time; ?></span>
                                                                        <?php if ($activity_result->type) { ?>
                                                                            <span class="badge py-3 px-4 fs-7 badge-light-primary mb-1"><?php echo Settings()->get_selected_activity_type_name($activity_result->type); ?></span>
                                                                        <?php } ?>
                                                                    </div>
                                                                    <div class="separator separator-dashed mb-6 mt-5"></div>
                                                                <?php }
                                                            } else { ?>
                                                                <div class="col-sm-12 mb-xl-10 text-center">I couldn't find any appointments upcoming. </div>
                                                            <?php } ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!--begin::Row-->
                                        <div class="row g-5 mt-5">
                                            <!--begin::List widget 9-->
                                            <div class="card">
                                                <!--begin::Header-->
                                                <div class="card-header">
                                                    <!--begin::Title-->
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="card-label fw-bold text-gray-800">My Activities</span>
                                                    </h3>
                                                    <!--end::Title-->
                                                </div>
                                                <!--end::Header-->
                                                <!--begin::Body-->
                                                <div class="card-body">
                                                    <?php foreach ($get_advisor_note_list as $note_result) { ?>
                                                        <div class="d-flex flex-stack">
                                                            <div class="">
                                                                <div class="fs-5">
                                                                    <b><?php echo $note_result->label; ?></b> - <?php echo date("m/d/Y", strtotime($note_result->created_at)); ?>
                                                                </div>
                                                                <div class="meta mt-2">
                                                                    <span class="badge py-3 px-4 fs-7 badge-light-primary mb-1"></span>
                                                                </div>
                                                            </div>

                                                            <div class="action_btn">
                                                                <span class="badge py-3 px-4 badge-light-success"><i class="las la-check text-black fw-bold fs-2"></i> </span>
                                                                <span class="badge py-3 px-4 badge-light-danger"><i class="las la-times text-black fw-bold fs-2"></i> </span>
                                                            </div>
                                                        </div>
                                                        <div class="separator separator-dashed mb-3 mt-3"></div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Row-->
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
                    <?php require SITE_DIR . '/admin/footer.php'; ?>
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->
                <!--begin::aside-->

                <!--end::aside-->
            </div>
            <!--end::Wrapper-->
        </div>
        <!--end::Page-->
    </div>
    <!--end::App-->

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
                                    <label class=" fw-semibold fs-6 mb-2">Phone Number</label>
                                    <!--end::Label-->
                                    <!--begin::Input-->
                                    <input type="text" name="mobile_no" id="mobile_no" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Phone Number" />
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

    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-outline ki-arrow-up"></i>
    </div>
    <!--end::Scrolltop-->

    <?php require SITE_DIR . '/footer_script.php'; ?>

    <script src="<?php echo site_url(); ?>/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="//cdn.amcharts.com/lib/5/index.js"></script>
    <script src="//cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="//cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="//cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="//cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="<?php echo site_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.js"></script>

    <script src="<?php echo site_url(); ?>/assets/js/widgets.bundle.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/widgets.js"></script>

    <script type="text/javascript">
        <?php if (siget('access') == 1) { ?>
            Swal.fire({
                title: 'Sorry this page is not accessible!',
                icon: 'warning',
                showConfirmButton: false,
                allowOutsideClick: true,
                allowEscapeKey: true
            });
        <?php } ?>
    </script>

    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>