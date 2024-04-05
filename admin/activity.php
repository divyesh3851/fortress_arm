<?php require '../config.php';
$page_name = 'activity';
$sub_page_name = 'activity-list';
Admin()->check_login();
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/admin/head.php'; ?>
    <link href="<?php echo site_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true" data-kt-app-aside-push-footer="true" class="app-default view_advisor">
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
                                                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Activity</h1>
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

                                        <!--begin::Timeline-->
                                        <div class="card">
                                            <!--begin::Card head-->
                                            <div class="card-header card-header-stretch">
                                                <!--begin::Title-->
                                                <div class="card-title d-flex align-items-center">
                                                    <i class="ki-outline ki-calendar-8 fs-1 text-primary me-3 lh-0"></i>
                                                    <h3 class="fw-bold m-0 text-gray-800"><?php echo date('M d, Y') ?></h3>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Card head-->
                                            <!--begin::Card body-->
                                            <div class="card-body">
                                                <table id="kt_datatable_column_rendering" class="table table-striped table-row-bordered gy-5 gs-7">
                                                    <thead>
                                                        <tr class="fw-semibold fs-6 text-gray-800">
                                                            <th>Name</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Michael Baratta</td>
                                                            <td>Updated residentional & business addreess</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Ashleigh White</td>
                                                            <td>Updated residentional & business addreess</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Timeline-->
                                    </div>
                                    <!--end::Content container-->
                                </div>
                                <!--end::Content-->
                            </div>
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
    <!--begin::Drawers-->

    <!--end::Drawers-->
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
    <?php require SITE_DIR . '/admin/footer_script.php'; ?>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="<?php echo site_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/user-management/users/view/view.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/user-management/users/view/update-details.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/user-management/users/view/add-schedule.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/user-management/users/view/add-task.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/user-management/users/view/update-email.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/user-management/users/view/update-password.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/user-management/users/view/update-role.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/user-management/users/view/add-auth-app.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/user-management/users/view/add-one-time-password.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/widgets.bundle.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/widgets.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/chat/chat.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/utilities/modals/upgrade-plan.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/utilities/modals/create-campaign.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/utilities/modals/users-search.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>