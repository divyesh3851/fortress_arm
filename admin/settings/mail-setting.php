<?php require '../../config.php';
$page_name = 'settings';
$sub_page_name = 'mail-setting';
Admin()->check_login();

if (isset($_POST['save_setting'])) {

    update_option('mail_method', sipost('mail_method'));

    if (sipost('mail_method') == 'smtp') {
        update_option('sender_name', sipost('sender_name'));
        update_option('sender_email', sipost('sender_email'));
        update_option('smtp_host', sipost('smtp_host'));
        update_option('smtp_user_name', sipost('smtp_user_name'));
        update_option('smtp_password', sipost('smtp_password'));
        update_option('smtp_port', sipost('smtp_port'));
    }

    if (sipost('mail_method') == 'sendgrid') {
        update_option('sendgrid_api_key', sipost('sendgrid_api_key'));
    }

    wp_redirect(site_url() . '/admin/settings/mail-setting');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/admin/head.php'; ?>
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
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Mail Setting</h1>
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
                                            <h4 class="mb-1 text-success">The designation has been save successfully.</h4>
                                        </div>
                                    </div>
                                <?php }

                                if (isset($_SESSION['process_duplicate'])) {
                                    unset($_SESSION['process_duplicate']); ?>
                                    <div class="alert alert-danger d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-danger">The designation has been already exist.</h4>
                                        </div>
                                    </div>
                                <?php }

                                if (isset($_SESSION['process_fail'])) {
                                    unset($_SESSION['process_fail']); ?>
                                    <div class="alert alert-danger d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-danger">The designation has been save failed.</h4>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!--begin::Card-->
                                <div class="card">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <form class=" w-100 pt-10 pb-10" id="" method="post" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <div class="col-md-6 fv-row">
                                                    <div class="d-flex">
                                                        <label class="form-check form-check-custom form-check-solid  mail_method me-10">
                                                            <input class="form-check-input" type="radio" name="mail_method" value="smtp" <?php echo (get_option('mail_method') == '' || get_option('mail_method') == 'smtp') ? 'checked' : ''; ?>>
                                                            <span class="form-check-label text-gray-800">
                                                                SMTP
                                                            </span>
                                                        </label>
                                                        <label class="form-check form-check-custom form-check-solid  mail_method">
                                                            <input class="form-check-input" type="radio" name="mail_method" value="sendgrid" <?php echo (get_option('mail_method') == 'sendgrid') ? 'checked' : ''; ?>>
                                                            <span class="form-check-label text-gray-800">
                                                                Sendgrid
                                                            </span>
                                                        </label>
                                                    </div>
                                                    <!--end::Input-->
                                                </div>
                                            </div>
                                            <div class="row mb-6 mt-8 smtp_field" style="display: <?php echo (get_option('mail_method') == '' || get_option('mail_method') == 'smtp') ? 'flex' : 'none'; ?>;">
                                                <div class="col-md-4 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="fw-semibold fs-6 mb-2">Sender Name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="sender_name" id="sender_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Sender Name" value="<?php echo (get_option('sender_name')) ? get_option('sender_name') : ''; ?>" />
                                                    <!--end::Col-->
                                                </div>
                                                <div class="col-md-4 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="fw-semibold fs-6 mb-2">Sender Email</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="sender_email" id="sender_email" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Sender Email" value="<?php echo (get_option('sender_email')) ? get_option('sender_email') : ''; ?>" />
                                                    <!--end::Col-->
                                                </div>
                                                <div class="col-md-4 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="fw-semibold fs-6 mb-2">SMTP Host</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="smtp_host" id="smtp_host" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="SMTP Host" value="<?php echo (get_option('smtp_host')) ? get_option('smtp_host') : ''; ?>" />
                                                    <!--end::Col-->
                                                </div>

                                                <div class="col-md-4 mt-7 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="fw-semibold fs-6 mb-2">SMTP Username</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="smtp_user_name" id="smtp_user_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="SMTP Username" value="<?php echo (get_option('smtp_user_name')) ? get_option('smtp_user_name') : ''; ?>" />
                                                    <!--end::Col-->
                                                </div>

                                                <div class="col-md-4 mt-7 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="fw-semibold fs-6 mb-2">SMTP Password</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="smtp_password" id="smtp_password" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="SMTP Password" value="<?php echo (get_option('smtp_password')) ? get_option('smtp_password') : ''; ?>" />
                                                    <!--end::Col-->
                                                </div>

                                                <div class="col-md-4 mt-7 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="fw-semibold fs-6 mb-2">Port</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="smtp_port" id="smtp_port" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="SMTP Password" value="<?php echo (get_option('smtp_port')) ? get_option('smtp_port') : ''; ?>" />
                                                    <!--end::Col-->
                                                </div>
                                            </div>
                                            <div class="row mb-6 sendgrid_field" style="display: <?php echo (get_option('mail_method') == 'sendgrid') ? 'flex' : 'none'; ?>;">
                                                <div class="col-md-6 mt-7 fv-row">
                                                    <!--begin::Label-->
                                                    <label class="fw-semibold fs-6 mb-2">API Key</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="sendgrid_api_key" id="sendgrid_api_key" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="API Key" value="<?php echo (get_option('sendgrid_api_key')) ? get_option('sendgrid_api_key') : ''; ?>" />
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
    <?php require SITE_DIR . '/admin/footer_script.php'; ?>
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