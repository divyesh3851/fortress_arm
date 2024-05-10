<?php require '../../config.php';
$page_name = 'settings';
$sub_page_name = 'cron_setting';
Admin()->check_login();

// page permition for admin user
if (!IS_ADMIN) {
    wp_redirect(add_query_arg('access', 1, site_url('admin/dashboard')));
    die();
}

if (isset($_POST['save_setting'])) {

    update_option('iul_email_cron', sipost('iul_email_cron'));
    update_option('term_email_cron', sipost('term_email_cron'));
    update_option('wl_email_cron', sipost('wl_email_cron'));
    update_option('ap_email_cron', sipost('ap_email_cron'));
    update_option('fia_email_cron', sipost('fia_email_cron'));
    update_option('ltc_email_cron', sipost('ltc_email_cron'));
    update_option('ls_email_cron', sipost('ls_email_cron'));

    $_SESSION['process_success'] = true;
    wp_redirect(site_url() . '/admin/settings/cron-setting');
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
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Cron Setting</h1>
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
                                            <h4 class="mb-1 text-success">The cron settings has been save successfully.</h4>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!--begin::Card-->
                                <div class="card">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <form class=" w-100 pt-10 pb-10" id="" method="post" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <div class="col-md-3 fv-row">
                                                    <div class="d-flex">
                                                        <div class="d-flex justify-content-end">
                                                            <!--begin::Switch-->
                                                            <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input" name="iul_email_cron" type="checkbox" value="1" id="iul_email_cron" <?php echo (get_option('iul_email_cron')) ? 'checked' : ''; ?> />
                                                                <!--end::Input-->
                                                                <!--begin::Label-->
                                                                <span class="form-check-label fw-semibold text-muted" for="iul_email_cron"></span>
                                                                <!--end::Label-->
                                                            </label>
                                                            <!--end::Switch-->
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="d-flex flex-column">
                                                                <span class="fs-5 text-gray-900 text-hover-primary fw-bold">IUL - Communicatons Automation</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                                <div class="col-md-3 fv-row">
                                                    <div class="d-flex">
                                                        <div class="d-flex justify-content-end">
                                                            <!--begin::Switch-->
                                                            <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input" name="term_email_cron" type="checkbox" value="1" id="term_email_cron" <?php echo (get_option('term_email_cron')) ? 'checked' : ''; ?> />
                                                                <!--end::Input-->
                                                                <!--begin::Label-->
                                                                <span class="form-check-label fw-semibold text-muted" for="term_email_cron"></span>
                                                                <!--end::Label-->
                                                            </label>
                                                            <!--end::Switch-->
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="d-flex flex-column">
                                                                <span class="fs-5 text-gray-900 text-hover-primary fw-bold">Term - Communicatons Automation</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                                <div class="col-md-3 fv-row">
                                                    <div class="d-flex">
                                                        <div class="d-flex justify-content-end">
                                                            <!--begin::Switch-->
                                                            <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input" name="wl_email_cron" type="checkbox" value="1" id="wl_email_cron" <?php echo (get_option('wl_email_cron')) ? 'checked' : ''; ?> />
                                                                <!--end::Input-->
                                                                <!--begin::Label-->
                                                                <span class="form-check-label fw-semibold text-muted" for="wl_email_cron"></span>
                                                                <!--end::Label-->
                                                            </label>
                                                            <!--end::Switch-->
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="d-flex flex-column">
                                                                <span class="fs-5 text-gray-900 text-hover-primary fw-bold">WL - Communicatons Automation</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                                <div class="col-md-3 fv-row">
                                                    <div class="d-flex">
                                                        <div class="d-flex justify-content-end">
                                                            <!--begin::Switch-->
                                                            <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input" name="ap_email_cron" type="checkbox" value="1" id="ap_email_cron" <?php echo (get_option('ap_email_cron')) ? 'checked' : ''; ?> />
                                                                <!--end::Input-->
                                                                <!--begin::Label-->
                                                                <span class="form-check-label fw-semibold text-muted" for="ap_email_cron"></span>
                                                                <!--end::Label-->
                                                            </label>
                                                            <!--end::Switch-->
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="d-flex flex-column">
                                                                <span class="fs-5 text-gray-900 text-hover-primary fw-bold">Adv. Planning - Communicatons Automation</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3 fv-row">
                                                    <div class="d-flex">
                                                        <div class="d-flex justify-content-end">
                                                            <!--begin::Switch-->
                                                            <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input" name="fia_email_cron" type="checkbox" value="1" id="fia_email_cron" <?php echo (get_option('fia_email_cron')) ? 'checked' : ''; ?> />
                                                                <!--end::Input-->
                                                                <!--begin::Label-->
                                                                <span class="form-check-label fw-semibold text-muted" for="fia_email_cron"></span>
                                                                <!--end::Label-->
                                                            </label>
                                                            <!--end::Switch-->
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="d-flex flex-column">
                                                                <span class="fs-5 text-gray-900 text-hover-primary fw-bold">FIA - Communicatons Automation</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                                <div class="col-md-3 fv-row">
                                                    <div class="d-flex">
                                                        <div class="d-flex justify-content-end">
                                                            <!--begin::Switch-->
                                                            <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input" name="ltc_email_cron" type="checkbox" value="1" id="ltc_email_cron" <?php echo (get_option('ltc_email_cron')) ? 'checked' : ''; ?> />
                                                                <!--end::Input-->
                                                                <!--begin::Label-->
                                                                <span class="form-check-label fw-semibold text-muted" for="ltc_email_cron"></span>
                                                                <!--end::Label-->
                                                            </label>
                                                            <!--end::Switch-->
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="d-flex flex-column">
                                                                <span class="fs-5 text-gray-900 text-hover-primary fw-bold">LTC - Communicatons Automation</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                                <div class="col-md-3 fv-row">
                                                    <div class="d-flex">
                                                        <div class="d-flex justify-content-end">
                                                            <!--begin::Switch-->
                                                            <label class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
                                                                <!--begin::Input-->
                                                                <input class="form-check-input" name="ls_email_cron" type="checkbox" value="1" id="ls_email_cron" <?php echo (get_option('ls_email_cron')) ? 'checked' : ''; ?> />
                                                                <!--end::Input-->
                                                                <!--begin::Label-->
                                                                <span class="form-check-label fw-semibold text-muted" for="ls_email_cron"></span>
                                                                <!--end::Label-->
                                                            </label>
                                                            <!--end::Switch-->
                                                        </div>
                                                        <div class="d-flex">
                                                            <div class="d-flex flex-column">
                                                                <span class="fs-5 text-gray-900 text-hover-primary fw-bold">LS - Life Settlements</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                            <div class="row mt-10">
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
    </script>
</body>
<!--end::Body-->

</html>