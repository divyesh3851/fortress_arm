<?php require '../../config.php';
$page_name = 'user_management';
$sub_page_name = 'roles';
Admin()->check_login();

if (isset($_POST['save_role'])) {

    if (!empty(sipost('role_id'))) {
        $response = Admin()->update_role();
    } else {
        $response = Admin()->add_role();
    }

    if ($response == 1) {
        $_SESSION['process_success'] = true;
    } elseif ($response == 'duplicate') {
        $_SESSION['process_duplicate'] = true;
    } else {
        $_SESSION['process_fail'] = true;
    }

    wp_redirect(site_url() . '/admin/admin-user/role-list');
    exit;
}

$role_data = '';
$pages     = array();
if (siget('role_id')) {

    $role_data = Admin()->get_selected_role_data(siget('role_id'));

    $pages = explode(',', $role_data->page_access);
    $pages = $pages && is_array($pages) ? $pages : array();
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
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Role</h1>
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
                                            <h4 class="mb-1 text-success">The role has been save successfully.</h4>
                                        </div>
                                    </div>
                                <?php }

                                if (isset($_SESSION['process_duplicate'])) {
                                    unset($_SESSION['process_duplicate']); ?>
                                    <div class="alert alert-danger d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-danger">The role has been already exist.</h4>
                                        </div>
                                    </div>
                                <?php }

                                if (isset($_SESSION['process_fail'])) {
                                    unset($_SESSION['process_fail']); ?>
                                    <div class="alert alert-danger d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-danger">The role has been save failed.</h4>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!--begin::Card-->
                                <div class="card">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-5">
                                        <form class=" w-100 " id="" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="role_id" value="<?php echo ($role_data) ? $role_data->role_id : ''; ?>" required />

                                            <div class="row mb-4">
                                                <!--begin::Input group-->
                                                <div class="fv-row col-md-3 mb-7">
                                                    <!--begin::Label-->
                                                    <label class="required fw-semibold fs-6 mb-2">Role Name</label>
                                                    <!--end::Label-->
                                                    <!--begin::Input-->
                                                    <input type="text" name="role_name" id="role_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Role Name" value="<?php echo ($role_data) ? $role_data->role_name : ''; ?>" required />
                                                    <!--end::Input-->
                                                </div>
                                                <!--begin::Input group-->
                                                <div class="col-md-2 fv-row mt-11">
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input me-3" type="checkbox" name="all_page_access" value="yes" <?php echo ($role_data && $role_data->all_page_access == 1) ? 'checked' : ''; ?> />
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="form-check-label d-flex flex-column align-items-start">
                                                            <span class="fw-bold fs-5 mb-0">All Page Access</span>
                                                        </span>
                                                        <!--end::Label-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                                <div class="col-md-2 fv-row mt-11">
                                                    <!--begin::Option-->
                                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input me-3" type="checkbox" name="export_data_access" value="1" <?php echo ($role_data && $role_data->export_data_access == 1) ? 'checked' : ''; ?> />
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="form-check-label d-flex flex-column align-items-start">
                                                            <span class="fw-bold fs-5 mb-0">Data Export Access</span>
                                                        </span>
                                                        <!--end::Label-->
                                                    </label>
                                                    <!--end::Option-->
                                                </div>
                                            </div>
                                            <div class="row mb-7">
                                                <!--begin::Label-->
                                                <label class="fw-semibold fs-6 mb-2"> Page Access
                                                </label>
                                                <!--end::Label-->
                                                <!--begin::Input-->
                                                <select name="page_access[]" id="page_access" data-control="select2" data-close-on-select="false" data-placeholder="Select a page access..." data-allow-clear="true" multiple="multiple" class="form-select form-select-solid">
                                                    <option value="">Select Page Access</option>
                                                    <option <?php if (in_array('advisor', $pages)) {
                                                                echo 'Selected';
                                                            } ?> value="advisor">Advisor</option>
                                                    <option <?php if (in_array('verification', $pages)) {
                                                                echo 'Selected';
                                                            } ?> value="verification">Verification</option>
                                                    <option <?php if (in_array('notes', $pages)) {
                                                                echo 'Selected';
                                                            } ?> value="notes">Notes</option>
                                                    <option <?php if (in_array('messages', $pages)) {
                                                                echo 'Selected';
                                                            } ?> value="messages">Messages</option>
                                                    <option <?php if (in_array('document_vault', $pages)) {
                                                                echo 'Selected';
                                                            } ?> value="document_vault">Document Vault</option>
                                                    <option <?php if (in_array('campaigns', $pages)) {
                                                                echo 'Selected';
                                                            } ?> value="campaigns">Campaigns</option>
                                                    <option <?php if (in_array('newsletter', $pages)) {
                                                                echo 'Selected';
                                                            } ?> value="newsletter">Newsletter</option>
                                                    <option <?php if (in_array('analytics', $pages)) {
                                                                echo 'Selected';
                                                            } ?> value="analytics">Analytics</option>
                                                    <option <?php if (in_array('compliance', $pages)) {
                                                                echo 'Selected';
                                                            } ?> value="compliance">Compliance</option>
                                                    <option <?php if (in_array('activities', $pages)) {
                                                                echo 'Selected';
                                                            } ?> value="activities">Activities</option>
                                                    <option <?php if (in_array('user_management', $pages)) {
                                                                echo 'Selected';
                                                            } ?> value="user_management">User Management</option>
                                                    <option <?php if (in_array('settings', $pages)) {
                                                                echo 'Selected';
                                                            } ?> value="settings">Settings</option>
                                                </select>
                                                <!--end::Input-->
                                            </div>
                                            <!--begin::Actions-->
                                            <div class="d-flex flex-stack pt-5">
                                                <!--begin::Wrapper-->
                                                <div>
                                                    <button type="submit" name="save_role" class="btn btn-lg btn-primary me-3" data-kt-stepper-action="submit">
                                                        <span class="indicator-label">Submit
                                                            <i class="ki-outline ki-arrow-right fs-3 ms-2 me-0"></i></span>
                                                        <span class="indicator-progress">Please wait...
                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                    </button>
                                                </div>
                                                <!--end::Wrapper-->
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
        $(document).on("change", "input[name='no_middle_name']", function() {
            if ($(this).prop('checked')) {
                $(".no_middle_name_checkbox").addClass("mt-8");
                $(".middle_name_field").hide();
            } else {
                $(".no_middle_name_checkbox").removeClass("mt-8");
                $(".no_middle_name_checkbox").addClass("mt-3");
                $(".middle_name_field").show();
            }
        });
    </script>
</body>
<!--end::Body-->

</html>