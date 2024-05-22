<?php require '../../config.php';
$page_name = 'settings';
$sub_page_name = 'advanced_planing';
Admin()->check_login();

require SITE_DIR . '/vendor/autoload.php';

// page permition for admin user
if (Admin()->check_for_page_access("settings", true)) {
    wp_redirect(add_query_arg('access', 1, site_url('admin/dashboard')));
    die();
}

if (isset($_POST['ap_step_1'])) {

    update_option('ap_step_1_subject', sipost('ap_step_1_subject'));
    update_option('ap_step_1_mail_body', sipost('ap_step_1_mail_body'));

    $_SESSION['process_success'] = true;

    wp_redirect(site_url() . '/admin/settings/advanced-planning');
    exit;
}

if (isset($_POST['ap_step_2'])) {

    update_option('ap_step_2_subject', sipost('ap_step_2_subject'));
    update_option('ap_step_2_mail_body', sipost('ap_step_2_mail_body'));

    $_SESSION['process_success'] = true;

    wp_redirect(site_url() . '/admin/settings/advanced-planning');
    exit;
}

if (isset($_POST['ap_step_3'])) {

    update_option('ap_step_3_subject', sipost('ap_step_3_subject'));
    update_option('ap_step_3_mail_body', sipost('ap_step_3_mail_body'));

    $_SESSION['process_success'] = true;

    wp_redirect(site_url() . '/admin/settings/advanced-planning');
    exit;
}

if (isset($_POST['ap_step_4'])) {

    update_option('ap_step_4_subject', sipost('ap_step_4_subject'));
    update_option('ap_step_4_mail_body', sipost('ap_step_4_mail_body'));

    $_SESSION['process_success'] = true;

    wp_redirect(site_url() . '/admin/settings/advanced-planning');
    exit;
}

if (isset($_POST['ap_step_5'])) {

    update_option('ap_step_5_subject', sipost('ap_step_5_subject'));
    update_option('ap_step_5_mail_body', sipost('ap_step_5_mail_body'));

    $_SESSION['process_success'] = true;

    wp_redirect(site_url() . '/admin/settings/advanced-planning');
    exit;
}

if (isset($_POST['ap_step_6'])) {

    update_option('ap_step_6_subject', sipost('ap_step_6_subject'));
    update_option('ap_step_6_mail_body', sipost('ap_step_6_mail_body'));

    $_SESSION['process_success'] = true;

    wp_redirect(site_url() . '/admin/settings/advanced-planning');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/head.php'; ?>
    <!--begin::Vendor Stylesheets(used for this page only)-->
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
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Advanced Planning</h1>
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
                                            <h4 class="mb-1 text-success">Email settings save successfully.</h4>
                                        </div>
                                    </div>
                                <?php }  ?>

                                <div class="card">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                                            <li class="nav-item">
                                                <a class="nav-link active text-black fw-semibold" data-bs-toggle="tab" href="#kt_tab_pane_1">Step 1 Email </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-black fw-semibold" data-bs-toggle="tab" href="#kt_tab_pane_2">Step 2 Email </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-black fw-semibold" data-bs-toggle="tab" href="#kt_tab_pane_3">Step 3 Email </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-black fw-semibold" data-bs-toggle="tab" href="#kt_tab_pane_4">Step 4 Email </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-black fw-semibold" data-bs-toggle="tab" href="#kt_tab_pane_5">Step 5 Email </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link text-black fw-semibold" data-bs-toggle="tab" href="#kt_tab_pane_6">Step 6 Email </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="kt_tab_pane_1" role="tabpanel">
                                                <form method="POST">
                                                    <div class="mb-5">
                                                        <!--begin::Label-->
                                                        <label class="required fw-semibold fs-6 mb-2">Subject</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" name="ap_step_1_subject" id="ap_step_1_subject" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Subject" required="" value="<?php echo get_option('ap_step_1_subject'); ?>">
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--begin::Label-->
                                                    <label class="required fw-semibold fs-6 mb-2">Mail Body</label>
                                                    <!--end::Label-->
                                                    <textarea class="is_empty ck_editor" name="ap_step_1_mail_body" id="ap_step_1_mail_body"><?php echo get_option('ap_step_1_mail_body'); ?></textarea>
                                                    <div class="row mt-7">
                                                        <div class="mb-0">
                                                            <button type="submit" name="ap_step_1" class="btn btn-primary" id="">

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
                                            <div class="tab-pane fade" id="kt_tab_pane_2" role="tabpanel">
                                                <form method="POST">
                                                    <div class="mb-5">
                                                        <!--begin::Label-->
                                                        <label class="required fw-semibold fs-6 mb-2">Subject</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" name="ap_step_2_subject" id="ap_step_2_subject" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Subject" required="" value="<?php echo get_option('ap_step_2_subject'); ?>">
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--begin::Label-->
                                                    <label class="required fw-semibold fs-6 mb-2">Mail Body</label>
                                                    <!--end::Label-->
                                                    <textarea class="is_empty ck_editor" name="ap_step_2_mail_body" id="ap_step_2_mail_body"><?php echo get_option('ap_step_2_mail_body'); ?></textarea>
                                                    <div class="row mt-7">
                                                        <div class="mb-0">
                                                            <button type="submit" name="ap_step_2" class="btn btn-primary" id="">

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
                                            <div class="tab-pane fade" id="kt_tab_pane_3" role="tabpanel">
                                                <form method="POST">
                                                    <div class="mb-5">
                                                        <!--begin::Label-->
                                                        <label class="required fw-semibold fs-6 mb-2">Subject</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" name="ap_step_3_subject" id="ap_step_3_subject" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Subject" required="" value="<?php echo get_option('ap_step_3_subject'); ?>">
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--begin::Label-->
                                                    <label class="required fw-semibold fs-6 mb-2">Mail Body</label>
                                                    <!--end::Label-->
                                                    <textarea class="is_empty ck_editor" name="ap_step_3_mail_body" id="ap_step_3_mail_body"><?php echo get_option('ap_step_3_mail_body'); ?></textarea>
                                                    <div class="row mt-7">
                                                        <div class="mb-0">
                                                            <button type="submit" name="ap_step_3" class="btn btn-primary" id="">

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
                                            <div class="tab-pane fade" id="kt_tab_pane_4" role="tabpanel">
                                                <form method="POST">
                                                    <div class="mb-5">
                                                        <!--begin::Label-->
                                                        <label class="required fw-semibold fs-6 mb-2">Subject</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" name="ap_step_4_subject" id="ap_step_4_subject" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Subject" required="" value="<?php echo get_option('ap_step_4_subject'); ?>">
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--begin::Label-->
                                                    <label class="required fw-semibold fs-6 mb-2">Mail Body</label>
                                                    <!--end::Label-->
                                                    <textarea class="is_empty ck_editor" name="ap_step_4_mail_body" id="ap_step_4_mail_body"><?php echo get_option('ap_step_4_mail_body'); ?></textarea>
                                                    <div class="row mt-7">
                                                        <div class="mb-0">
                                                            <button type="submit" name="ap_step_4" class="btn btn-primary" id="">

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
                                            <div class="tab-pane fade" id="kt_tab_pane_5" role="tabpanel">
                                                <form method="POST">
                                                    <div class="mb-5">
                                                        <!--begin::Label-->
                                                        <label class="required fw-semibold fs-6 mb-2">Subject</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" name="ap_step_5_subject" id="ap_step_5_subject" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Subject" required="" value="<?php echo get_option('ap_step_5_subject'); ?>">
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--begin::Label-->
                                                    <label class="required fw-semibold fs-6 mb-2">Mail Body</label>
                                                    <!--end::Label-->
                                                    <textarea class="is_empty ck_editor" name="ap_step_5_mail_body" id="ap_step_5_mail_body"><?php echo get_option('ap_step_5_mail_body'); ?></textarea>
                                                    <div class="row mt-7">
                                                        <div class="mb-0">
                                                            <button type="submit" name="ap_step_5" class="btn btn-primary" id="">

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
                                            <div class="tab-pane fade" id="kt_tab_pane_6" role="tabpanel">
                                                <form method="POST">
                                                    <div class="mb-5">
                                                        <!--begin::Label-->
                                                        <label class="required fw-semibold fs-6 mb-2">Subject</label>
                                                        <!--end::Label-->
                                                        <!--begin::Input-->
                                                        <input type="text" name="ap_step_6_subject" id="ap_step_6_subject" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Subject" required="" value="<?php echo get_option('ap_step_6_subject'); ?>">
                                                        <!--end::Input-->
                                                    </div>
                                                    <!--begin::Label-->
                                                    <label class="required fw-semibold fs-6 mb-2">Mail Body</label>
                                                    <!--end::Label-->
                                                    <textarea class="is_empty ck_editor" name="ap_step_6_mail_body" id="ap_step_6_mail_body"><?php echo get_option('ap_step_6_mail_body'); ?></textarea>
                                                    <div class="row mt-7">
                                                        <div class="mb-0">
                                                            <button type="submit" name="ap_step_6" class="btn btn-primary" id="">

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
                                        </div>
                                    </div>
                                </div>


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

    <!--begin::Modal - Adjust Balance-->

    <!--end::Modal - New Card-->

    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <?php require SITE_DIR . '/footer_script.php'; ?>
    <script src="<?php echo site_url(); ?>/assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js"></script>

    <!--end::Global Javascript Bundle-->
    <!--begin::Vendors Javascript(used for this page only)-->
    <!--end::Vendors Javascript-->
    <script>
        const textAreas = document.querySelectorAll('.ck_editor');
        textAreas.forEach(textArea => {
            ClassicEditor
                .create(textArea)
                .then(editor => {
                    // You can perform any specific actions for each editor instance here
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>