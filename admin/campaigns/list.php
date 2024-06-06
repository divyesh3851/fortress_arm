<?php require '../../config.php';
$page_name = 'marketing';
$sub_page_name = 'marketing';
Admin()->check_login();
// page permition for admin user
if (Admin()->check_for_page_access("campaigns", true)) {
    wp_redirect(add_query_arg('access', 1, site_url('admin/dashboard')));
    die();
}

$get_campaign_list = Campaign()->get_campaign_list();
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
                                    <?php foreach ($get_campaign_list as $campaign_result) {

                                        $count_total_user = Campaign()->get_campaign_user_total_count($campaign_result->id);

                                        $get_campaign_recent_users = Campaign()->get_campaign_recent_users($campaign_result->id);

                                    ?>
                                        <div class="col-md-6 col-xl-3">
                                            <!--begin::Card-->
                                            <a href="<?php echo site_url(); ?>/admin/campaigns/single/<?php echo $campaign_result->id; ?>" class="card border-hover-primary">
                                                <!--begin::Card header-->
                                                <div class="card-header border-0 pt-9">
                                                    <!--begin::Card Title-->
                                                    <div class="card-title m-0">
                                                        <!--begin::Avatar-->
                                                        <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                            <div class="fs-3 fw-bold text-gray-700">
                                                                <i class="las la-bullhorn fs-2x text-primary"></i>
                                                            </div>
                                                        </div>
                                                        <!--end::Avatar-->
                                                    </div>
                                                    <!--end::Car Title-->
                                                    <!--begin::Card toolbar-->
                                                    <!--end::Card toolbar-->
                                                </div>
                                                <!--end:: Card header-->
                                                <!--begin:: Card body-->
                                                <div class="card-body p-9 pt-5">
                                                    <!--begin::Name-->
                                                    <div class="fs-3 fw-bold text-gray-900"><?php echo $campaign_result->name; ?></div>
                                                    <!--end::Name-->
                                                    <!--begin::Description-->
                                                    <p class="text-gray-500 fw-semibold fs-5 mt-1 mb-7"></p>
                                                    <!--end::Description-->
                                                    <!--begin::Info-->
                                                    <div class="d-flex flex-wrap mb-5">
                                                        <!--begin::Due-->
                                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-7 mb-3">
                                                            <div class="fs-6 text-gray-800 fw-bold"><?php echo date("m/d/Y", strtotime($campaign_result->created_at)); ?></div>
                                                            <div class="fw-semibold text-gray-500">Created Date</div>
                                                        </div>
                                                        <!--end::Due-->
                                                        <!--begin::Budget-->
                                                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 mb-3">
                                                            <div class="fs-6 text-gray-800 fw-bold"><?php echo $count_total_user; ?></div>
                                                            <div class="fw-semibold text-gray-500">Total Users</div>
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
                                                        <?php
                                                        if ($get_campaign_recent_users) {

                                                            foreach ($get_campaign_recent_users as $recent_user_result) {

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
                                                    </div>
                                                    <!--end::Users-->
                                                </div>
                                                <!--end:: Card body-->
                                            </a>
                                            <!--end::Card-->
                                        </div>
                                    <?php } ?>
                                    <!--end::Col-->
                                </div>
                                <!--end::Row-->
                                <!--begin::Pagination-->
                                <?php /*
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
                                */ ?>
                                <!--end::Pagination-->
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
    <script>
        (function() {
            // Collect analytics data
            var analyticsData = {
                page: window.location.pathname,
                referrer: document.referrer,
                page_name: 'campaign'
            };

            // Send data to the server
            var xhr = new XMLHttpRequest();
            xhr.open("POST", site_url + "/track.php", true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.send(JSON.stringify(analyticsData));
        })();
    </script>
</body>
<!--end::Body-->

</html>