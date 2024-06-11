<?php require '../../config.php';
$page_name = 'settings';
$sub_page_name = 'calendar-setting';
Admin()->check_login();

// page permition for admin user
if (Admin()->check_for_page_access("settings", true)) {
    wp_redirect(add_query_arg('access', 1, site_url('admin/dashboard')));
    die();
}

if (isset($_POST['save_setting'])) {

    Admin()->update_admin_meta($_SESSION['fbs_arm_admin_id'], 'client_id', sipost('client_id'));
    Admin()->update_admin_meta($_SESSION['fbs_arm_admin_id'], 'client_secret_id', sipost('client_secret_id'));
    Admin()->update_admin_meta($_SESSION['fbs_arm_admin_id'], 'calendar_id', sipost('calendar_id'));
    Admin()->update_admin_meta($_SESSION['fbs_arm_admin_id'], 'calendar_redirect_url', sipost('calendar_redirect_url'));

    $_SESSION['process_success'] = true;
    wp_redirect(site_url() . '/admin/settings/calendar-setting');
    exit;
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
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Calendar Setting</h1>
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
                                <?php if (isset($_SESSION['process_success'])) {
                                    unset($_SESSION['process_success']); ?>
                                    <div class="alert alert-success d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-success  me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-success">The calendar settings has been save successfully.</h4>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!--begin::Card-->
                                <div class="card">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <form class=" w-100 pt-10 pb-10" id="" method="post" enctype="multipart/form-data">
                                            <div class="row mb-6 mt-8 smtp_field">
                                                <div class="col-md-12 fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="fw-semibold fs-6 mb-2">Client ID</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="client_id" id="client_id" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Client ID" value="<?php echo Admin()->get_admin_meta($_SESSION['fbs_arm_admin_id'], 'client_id'); ?>" required />
                                                    <!--end::Col-->
                                                </div>
                                                <div class="col-md-12 fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="fw-semibold fs-6 mb-2">Client Secret ID</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="client_secret_id" id="client_secret_id" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Client Secret ID" value="<?php echo Admin()->get_admin_meta($_SESSION['fbs_arm_admin_id'], 'client_secret_id'); ?>" required />
                                                    <!--end::Col-->
                                                </div>
                                                <div class="col-md-12 fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="fw-semibold fs-6 mb-2">Calendar ID</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="calendar_id" id="calendar_id" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Calendar ID" value="<?php echo Admin()->get_admin_meta($_SESSION['fbs_arm_admin_id'], 'calendar_id'); ?>" required />
                                                    <!--end::Col-->
                                                </div>
                                                <div class="col-md-12 fv-row mb-7">
                                                    <!--begin::Label-->
                                                    <label class="fw-semibold fs-6 mb-2">Redirect URL</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="calendar_redirect_url" id="calendar_redirect_url" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Redirect URL" value="<?php echo Admin()->get_admin_meta($_SESSION['fbs_arm_admin_id'], 'calendar_redirect_url'); ?>" required />
                                                    <!--end::Col-->
                                                </div>

                                            </div>

                                            <div class="row mt-7">
                                                <div class="mb-0">
                                                    <button type="submit" name="save_setting" class="btn btn-primary" id="">

                                                        <!--begin::Indicator label-->
                                                        <span class="indicator-label"> Save </span>
                                                        <!--end::Indicator label-->

                                                        <!--begin::Indicator progress-->
                                                        <span class="indicator-progress">
                                                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                        </span>
                                                        <!--end::Indicator progress--> </button>
                                                </div>
                                            </div>
                                        </form>
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

    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <?php require SITE_DIR . '/footer_script.php'; ?>
    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <!--end::Vendors Javascript-->
    <!--end::Javascript-->
    <script>
        $(document).on("change", "input[type=radio][name='mail_method']", function() {
            console.log($(this).val());
            if ($(this).val() == 'smtp') {
                $(".smtp_field").show();
                $(".sendgrid_field").hide();
            } else if ($(this).val() == 'sendgrid') {
                $(".smtp_field").hide();
                $(".sendgrid_field").show();
            }
        });
    </script>
</body>
<!--end::Body-->

</html>