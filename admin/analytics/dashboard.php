<?php require '../../config.php';
$page_name = 'analytics';
$sub_page_name = '';
Admin()->check_login();

// page permition for admin user
if (Admin()->check_for_page_access("analytics", true)) {
    wp_redirect(add_query_arg('access', 1, site_url('admin/dashboard')));
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/admin/head.php'; ?>
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
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Analytics</h1>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Page title-->
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
                                <div class="row gx-5 gx-xl-10">
                                    <!--begin::Col-->
                                    <div class="col-xxl-4 mb-5 mb-xl-10">
                                        <!--begin::Chart widget 27-->
                                        <div class="card card-flush h-xl-100">
                                            <!--begin::Header-->
                                            <div class="card-header py-7">
                                                <!--begin::Statistics-->
                                                <div class="m-0">
                                                    <!--begin::Heading-->
                                                    <div class="d-flex align-items-center mb-2">
                                                        <!--begin::Title-->
                                                        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">35,568</span>
                                                        <!--end::Title-->
                                                        <!--begin::Label-->
                                                        <span class="badge badge-light-danger fs-base">
                                                            <i class="ki-outline ki-arrow-up fs-5 text-danger ms-n1"></i>8.02%</span>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Heading-->
                                                    <!--begin::Description-->
                                                    <span class="fs-6 fw-semibold text-gray-500">Organic Traffic</span>
                                                    <!--end::Description-->
                                                </div>
                                                <!--end::Statistics-->
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Body-->
                                            <div class="card-body pt-0 pb-1">
                                                <div id="kt_charts_widget_27" class="min-h-auto"></div>
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Chart widget 27-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-xxl-4 mb-5 mb-xl-10">
                                        <!--begin::Chart widget 28-->
                                        <div class="card card-flush h-xl-100">
                                            <!--begin::Header-->
                                            <div class="card-header py-7">
                                                <!--begin::Statistics-->
                                                <div class="m-0">
                                                    <!--begin::Heading-->
                                                    <div class="d-flex align-items-center mb-2">
                                                        <!--begin::Title-->
                                                        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">2,579</span>
                                                        <!--end::Title-->
                                                        <!--begin::Label-->
                                                        <span class="badge badge-light-success fs-base">
                                                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.2%</span>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Heading-->
                                                    <!--begin::Description-->
                                                    <span class="fs-6 fw-semibold text-gray-500">Domain External Links</span>
                                                    <!--end::Description-->
                                                </div>
                                                <!--end::Statistics-->
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Body-->
                                            <div class="card-body d-flex align-items-end ps-4 pe-0 pb-4">
                                                <!--begin::Chart-->
                                                <div id="kt_charts_widget_28" class="h-300px w-100 min-h-auto"></div>
                                                <!--end::Chart-->
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::Chart widget 28-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-xxl-4 mb-5 mb-xl-10">
                                        <!--begin::List widget 9-->
                                        <div class="card card-flush h-xl-100">
                                            <!--begin::Header-->
                                            <div class="card-header py-7">
                                                <!--begin::Statistics-->
                                                <div class="m-0">
                                                    <!--begin::Heading-->
                                                    <div class="d-flex align-items-center mb-2">
                                                        <!--begin::Title-->
                                                        <span class="fs-2hx fw-bold text-gray-800 me-2 lh-1 ls-n2">5,037</span>
                                                        <!--end::Title-->
                                                        <!--begin::Label-->
                                                        <span class="badge badge-light-success fs-base">
                                                            <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>2.2%</span>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Heading-->
                                                    <!--begin::Description-->
                                                    <span class="fs-6 fw-semibold text-gray-500">Visits by Social Networks</span>
                                                    <!--end::Description-->
                                                </div>
                                                <!--end::Statistics-->
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Body-->
                                            <div class="card-body card-body d-flex justify-content-between flex-column pt-3">
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack">
                                                    <!--begin::Flag-->
                                                    <img src="<?php echo site_url(); ?>/assets/media/svg/social-logos/linkedin.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
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
                                                            <span class="text-gray-800 fw-bold fs-4 me-3">1,088</span>
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
                                                    <img src="<?php echo site_url(); ?>/assets/media/svg/social-logos/youtube.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
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
                                                            <span class="text-gray-800 fw-bold fs-4 me-3">978</span>
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
                                                <!--begin::Separator-->
                                                <div class="separator separator-dashed my-3"></div>
                                                <!--end::Separator-->
                                                <!--begin::Item-->
                                                <div class="d-flex flex-stack">
                                                    <!--begin::Flag-->
                                                    <img src="<?php echo site_url(); ?>/assets/media/svg/social-logos/instagram.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
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
                                                            <span class="text-gray-800 fw-bold fs-4 me-3">1,458</span>
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
                                                    <img src="<?php echo site_url(); ?>/assets/media/svg/social-logos/facebook.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
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
                                                            <span class="text-gray-800 fw-bold fs-4 me-3">1,458</span>
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
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::List widget 9-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Row-->
                                <div class="row gx-5 gx-xl-10">
                                    <!--begin::Col-->
                                    <div class="col-xl-4 mb-5 mb-xl-10">
                                        <!--begin::List widget 12-->
                                        <div class="card card-flush h-xl-100">
                                            <!--begin::Header-->
                                            <div class="card-header pt-7">
                                                <!--begin::Title-->
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold text-gray-800">Visits by Source</span>
                                                    <span class="text-gray-500 mt-1 fw-semibold fs-6">29.4k visitors</span>
                                                </h3>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Body-->
                                            <div class="card-body d-flex align-items-end">
                                                <!--begin::Wrapper-->
                                                <div class="w-100">
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
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Direct Source</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Direct link clicks</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">1,067</span>
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
                                                                <i class="ki-outline ki-tiktok fs-3 text-gray-600"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Container-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Social Networks</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">All Social Channels</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">24,588</span>
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
                                                                <i class="ki-outline ki-sms fs-3 text-gray-600"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Container-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Email Newsletter</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Mailchimp Campaigns</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">794</span>
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
                                                                <i class="ki-outline ki-icon fs-3 text-gray-600"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Container-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Referrals</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Impact Radius visits</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">6,578</span>
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
                                                                <i class="ki-outline ki-abstract-25 fs-3 text-gray-600"></i>
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
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Many Sources</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">79,458</span>
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
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex align-items-center">
                                                        <!--begin::Symbol-->
                                                        <div class="symbol symbol-30px me-5">
                                                            <span class="symbol-label">
                                                                <i class="ki-outline ki-abstract-39 fs-3 text-gray-600"></i>
                                                            </span>
                                                        </div>
                                                        <!--end::Symbol-->
                                                        <!--begin::Container-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap d-grid gap-1 flex-row-fluid">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Rising Networks</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Network</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">18,047</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <!--begin::label-->
                                                                <span class="badge badge-light-success fs-base">
                                                                    <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>1.9%</span>
                                                                <!--end::label-->
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Container-->
                                                    </div>
                                                    <!--end::Item-->
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Body-->
                                        </div>
                                        <!--end::List widget 12-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-xl-8 mb-5 mb-xl-10">
                                        <!--begin::Chart widget 24-->
                                        <div class="card card-flush overflow-hidden h-xl-100">
                                            <!--begin::Header-->
                                            <div class="card-header py-5">
                                                <!--begin::Title-->
                                                <h3 class="card-title align-items-start flex-column">
                                                    <span class="card-label fw-bold text-gray-900">Human Resources</span>
                                                    <span class="text-gray-500 mt-1 fw-semibold fs-6">Reports by states and ganders</span>
                                                </h3>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <!--begin::Chart-->
                                                <div id="kt_charts_widget_24" class="min-h-auto" style="height: 300px"></div>
                                                <!--end::Chart-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Chart widget 24-->
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
                    <!--end::Footer container-->
                </div>
                <!--end::Footer-->
            </div>
            <!--end:::Main-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
    </div>
    <!--end::App-->
    <!--end::Drawers-->
    <!--begin::Scrolltop-->
    <div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
        <i class="ki-outline ki-arrow-up"></i>
    </div>
    <!--end::Scrolltop-->
    <!--begin::Javascript-->
    <?php require SITE_DIR . '/admin/footer_script.php'; ?>
    <!--end::Global Javascript Bundle-->

    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="<?php echo site_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="<?php echo site_url(); ?>/assets/plugins/custom/vis-timeline/vis-timeline.bundle.js"></script>
    <script src="//cdn.amcharts.com/lib/5/index.js"></script>
    <script src="//cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="//cdn.amcharts.com/lib/5/percent.js"></script>
    <script src="//cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="//cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script src="//cdn.amcharts.com/lib/5/map.js"></script>
    <script src="//cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
    <script src="//cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
    <script src="//cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
    <script src="//cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
    <script src="//cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="<?php echo site_url(); ?>/assets/js/widgets.bundle.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/widgets.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/chat/chat.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>