<?php require '../../config.php';
$page_name = 'verification';
$sub_page_name = 'verification-list';
Admin()->check_login();
// page permition for admin user
if (Admin()->check_for_page_access("advisor", true)) {
    wp_redirect(add_query_arg('access', 1, site_url('admin/dashboard')));
    die();
}
if (sipost('first_name') || sipost('last_name') || sipost('email')) {

    $response = Advisor()->add_advisor();

    if ($response == 1) {
        $_SESSION['process_success'] = true;
    } elseif ($response == 'duplicate') {
        $_SESSION['process_duplicate'] = true;
    } else {
        $_SESSION['process_fail'] = true;
    }

    wp_redirect(site_url() . '/admin/verification/advisor-list');
    exit;
}

$get_state_list = Settings()->get_state_list();

$get_lead_source_list = Settings()->get_lead_source_list(); ?>
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
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Verification</h1>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Page title-->
                                    <!--begin::Actions-->
                                    <button type="button" class="btn btn-primary advisor_modal" data-bs-toggle="modal" data-bs-target="#kt_modal_advisor" title="Add Advisor">
                                        <i class="ki-duotone ki-plus fs-2"></i>
                                        Add Advisor
                                    </button>
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

                                <div class="row">
                                    <div class="col-md-6">
                                        <!--begin::Card-->
                                        <div class="card">
                                            <!--begin::Card header-->
                                            <div class="card-header border-0 pt-6">
                                                <!--begin::Card title-->
                                                <div class="card-title">
                                                    <!--begin::Search-->
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span class="path2"></span></i>
                                                        <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Advisor" />
                                                    </div>
                                                    <!--end::Search-->
                                                </div>
                                                <!--begin::Card title-->
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <!--begin::Toolbar-->
                                                    <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">
                                                        <!--begin::Filter-->
                                                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                            <i class="ki-outline ki-filter fs-2"></i>Filter</button>
                                                        <!--begin::Menu 1-->
                                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                                                            <!--begin::Header-->
                                                            <div class="px-7 py-5">
                                                                <div class="fs-4 text-gray-900 fw-bold">Filter Options</div>
                                                            </div>
                                                            <!--end::Header-->
                                                            <!--begin::Separator-->
                                                            <div class="separator border-gray-200"></div>
                                                            <!--end::Separator-->
                                                            <!--begin::Content-->
                                                            <div class="px-7 py-5">
                                                                <!--begin::Input group-->
                                                                <div class="mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fs-5 fw-semibold mb-3">Advisor Status :</label>
                                                                    <!--end::Label-->

                                                                    <!--begin::Options-->
                                                                    <div class="d-flex flex-column flex-wrap fw-semibold" data-kt-docs-table-filter="advisor_status">
                                                                        <!--begin::Option-->
                                                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                                            <input class="form-check-input" type="radio" name="advisor_status" value="all" checked="checked">
                                                                            <span class="form-check-label text-gray-600">
                                                                                All
                                                                            </span>
                                                                        </label>
                                                                        <!--end::Option-->

                                                                        <!--begin::Option-->
                                                                        <?php foreach (Settings()->get_advisor_status_list() as $key => $status_result) { ?>
                                                                            <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                                                <input class="form-check-input" type="radio" name="advisor_status" value="<?php echo $status_result; ?>">
                                                                                <span class="form-check-label text-gray-600">
                                                                                    <?php echo $status_result; ?>
                                                                                </span>
                                                                            </label>
                                                                        <?php } ?>
                                                                        <!--end::Option-->


                                                                    </div>
                                                                    <!--end::Options-->
                                                                </div>
                                                                <!--end::Input group-->

                                                                <!--begin::Actions-->
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-docs-table-filter="reset">Reset</button>

                                                                    <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-docs-table-filter="filter">Apply</button>
                                                                </div>
                                                                <!--end::Actions-->
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                        <!--end::Menu 1-->
                                                        <!--end::Filter-->
                                                        <!--begin::Add Advisor-->

                                                        <!--end::Add Advisor-->
                                                    </div>
                                                    <!--end::Toolbar-->
                                                    <!--begin::Group actions-->
                                                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                                                        <div class="fw-bold me-5">
                                                            <span class="me-2" data-kt-docs-table-select="selected_count"></span>Selected
                                                        </div>
                                                        <button type="button" class="btn btn-danger" data-kt-docs-table-select="delete_selected">Delete Selected</button>
                                                    </div>
                                                    <!--end::Group actions-->
                                                </div>
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <!--begin::Datatable-->
                                                <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
                                                    <thead>
                                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                            <th class="w-10px pe-2">
                                                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_example_1 .form-check-input" value="1" />
                                                                </div>
                                                            </th>
                                                            <th>Name</th>
                                                            <th>Lead Source</th>
                                                            <th class="text-start">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-gray-600 fw-semibold">
                                                    </tbody>
                                                </table>
                                                <!--end::Datatable-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <div class="col-md-6">
                                        <!--begin::Card-->
                                        <div class="card">
                                            <!--begin::Card header-->
                                            <div class="card-header border-0 pt-6">
                                                <!--begin::Card title-->
                                                <div class="card-title">
                                                    <!--begin::Search-->
                                                    <div class="d-flex align-items-center position-relative my-1">
                                                        <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span class="path2"></span></i>
                                                        <input type="text" data-kt-docs-table-sent-verification-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Advisor" />
                                                    </div>
                                                    <!--end::Search-->
                                                </div>
                                                <!--begin::Card title-->
                                                <!--begin::Card toolbar-->
                                                <div class="card-toolbar">
                                                    <!--begin::Toolbar-->
                                                    <div class="d-flex justify-content-end" data-kt-docs-table-verification-sent-toolbar="base">
                                                        <!--begin::Filter-->
                                                        <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                                            <i class="ki-outline ki-filter fs-2"></i>Filter</button>
                                                        <!--begin::Menu 1-->
                                                        <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true" id="kt-toolbar-filter">
                                                            <!--begin::Header-->
                                                            <div class="px-7 py-5">
                                                                <div class="fs-4 text-gray-900 fw-bold">Filter Options</div>
                                                            </div>
                                                            <!--end::Header-->
                                                            <!--begin::Separator-->
                                                            <div class="separator border-gray-200"></div>
                                                            <!--end::Separator-->
                                                            <!--begin::Content-->
                                                            <div class="px-7 py-5">
                                                                <!--begin::Input group-->
                                                                <div class="mb-10">
                                                                    <!--begin::Label-->
                                                                    <label class="form-label fs-5 fw-semibold mb-3">Advisor Status :</label>
                                                                    <!--end::Label-->

                                                                    <!--begin::Options-->
                                                                    <div class="d-flex flex-column flex-wrap fw-semibold" data-kt-docs-table-sent-verification-filter="advisor_status">
                                                                        <!--begin::Option-->
                                                                        <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                                            <input class="form-check-input" type="radio" name="advisor_status" value="all" checked="checked">
                                                                            <span class="form-check-label text-gray-600">
                                                                                All
                                                                            </span>
                                                                        </label>
                                                                        <!--end::Option-->

                                                                        <!--begin::Option-->
                                                                        <?php foreach (Settings()->get_advisor_status_list() as $key => $status_result) { ?>
                                                                            <label class="form-check form-check-sm form-check-custom form-check-solid mb-3 me-5">
                                                                                <input class="form-check-input" type="radio" name="advisor_status" value="<?php echo $status_result; ?>">
                                                                                <span class="form-check-label text-gray-600">
                                                                                    <?php echo $status_result; ?>
                                                                                </span>
                                                                            </label>
                                                                        <?php } ?>
                                                                        <!--end::Option-->


                                                                    </div>
                                                                    <!--end::Options-->
                                                                </div>
                                                                <!--end::Input group-->

                                                                <!--begin::Actions-->
                                                                <div class="d-flex justify-content-end">
                                                                    <button type="reset" class="btn btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true" data-kt-docs-table-sent-verification-filter="reset">Reset</button>

                                                                    <button type="submit" class="btn btn-primary" data-kt-menu-dismiss="true" data-kt-docs-table-sent-verification-filter="filter">Apply</button>
                                                                </div>
                                                                <!--end::Actions-->
                                                            </div>
                                                            <!--end::Content-->
                                                        </div>
                                                        <!--end::Menu 1-->
                                                        <!--end::Filter-->
                                                        <!--begin::Add Advisor-->
                                                        <!--end::Add Advisor-->
                                                    </div>
                                                    <!--end::Toolbar-->
                                                    <!--begin::Group actions-->
                                                    <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-verification-sent-toolbar="selected">
                                                        <div class="fw-bold me-5">
                                                            <span class="me-2" data-kt-docs-table-verification-sent-select="selected_count"></span>Selected
                                                        </div>
                                                        <button type="button" class="btn btn-danger" data-kt-docs-table-verification-sent-select="delete_selected">Delete Selected</button>
                                                    </div>
                                                    <!--end::Group actions-->
                                                </div>
                                                <!--end::Card toolbar-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <!--begin::Datatable-->
                                                <table id="verification_sent_datatable" class="table align-middle table-row-dashed fs-6 gy-5">
                                                    <thead>
                                                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                            <th class="w-10px pe-2">
                                                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#verification_sent_datatable .form-check-input" value="1" />
                                                                </div>
                                                            </th>
                                                            <th>Name</th>
                                                            <th>Lead Source</th>
                                                            <th class="text-start">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-gray-600 fw-semibold">
                                                    </tbody>
                                                </table>
                                                <!--end::Datatable-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
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

    <!--begin::Modal - Send Mail -->
    <div class="modal fade" id="kt_modal_send_verification_mail_popup" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-600px">
            <!--begin::Modal content-->
            <div class="modal-content modal-rounded">
                <!--begin::Modal header-->
                <div class="modal-header py-7 d-flex justify-content-between">
                    <!--begin::Modal title-->
                    <h2>Verification</h2>
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
                    <form id="kt_modal_send_verification_mail_form" class="form" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="advisor_id" class="is_empty">
                        <!--begin::Scroll-->
                        <div class="row">
                            <div class="col-md-12 fv-row">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Enter Email</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="verification_req_email" id="verification_req_email" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Enter Email" required />
                                <!--end::Input-->
                            </div>
                        </div>
                        <!--end::Scroll-->
                        <!--begin::Actions-->
                        <div class="text-center mt-7">
                            <button type="button" name="send_mail_btn" id="send_mail_btn" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">Send</span>
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
    <!--end::Javascript-->
    <script>
        $(document).on("click", ".send_verification_mail", function() {
            $("#advisor_id").val($(this).attr("advisor_id"));
        });

        $(document).ready(function() {

            //$('#kt_modal_advisor_form').submit(function(event) {
            $('#save_advisor').click(function(event) {

                if (!$("#email").val()) {
                    return false;
                }

                // Prevent the default form submission
                event.preventDefault();

                $.post(ajax_url, {
                    action: 'check_email_exist',
                    email: $("#email").val(),
                    is_ajax: true,
                }, function(result) {

                    var results = JSON.parse(result);

                    if (results.status) {
                        $("#email").val('');
                        $("#save_advisor").after("<p class='email_exist_msg text-danger mt-2'>Email already exist.</p>");
                        setTimeout(function() {
                            $('.email_exist_msg').remove();
                        }, 2000);
                    } else {
                        $('#kt_modal_advisor_form').submit();
                    }

                });
            });
        });
    </script>
    <script>
        "use strict";
        // Class definition
        var KTDatatablesServerSide = function() {
            // Shared variables
            var table;
            var dt;
            var filterAdvisor;

            // Private functions
            var initDatatable = function() {
                dt = $("#kt_datatable_example_1").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    order: [
                        [3, 'desc']
                    ],
                    stateSave: true,
                    select: {
                        style: 'multi',
                        selector: 'td:first-child input[type="checkbox"]',
                        className: 'row-selected'
                    },
                    ajax: {
                        url: "<?php echo site_url(); ?>/admin/verification/advisor-list-ajax.php",
                    },
                    columns: [{
                            data: 'record_id'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'lead_source'
                        },
                        {
                            data: null
                        },
                    ],
                    columnDefs: [{
                            targets: 0,
                            orderable: false,
                            render: function(data) {
                                return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="${data}" />
                            </div>`;
                            }
                        },
                        {
                            target: 1,
                            orderable: false,
                            className: 'd-flex align-items-center'
                        },
                        {
                            target: 2,
                            orderable: false,
                        },
                        {
                            target: 3,
                            orderable: false,
                        },

                        /*{
                            targets: 4,
                            render: function(data, type, row) {
                                return `<img src="${hostUrl}media/svg/card-logos/${row.CreditCardType}.svg" class="w-35px me-3" alt="${row.CreditCardType}">` + data;
                            }
                        },*/
                        {
                            targets: -1,
                            data: null,
                            orderable: false,
                            className: 'text-start',
                            render: function(data, type, row) {

                                let send_btn = '';
                                if (data.send_verification == 1) {
                                    send_btn = `<a href="<?php echo site_url(); ?>/admin/advisor/edit-advisor/${data.record_id}" target="_blank" class="badge badge-light-info flex-shrink-0 align-self-center py-3 px-4 fs-7 me-2 cursor-pointer" title="Send Mail">Complete Now</a>`;
                                } else {
                                    send_btn = `<span class="badge badge-light-danger flex-shrink-0 align-self-center py-3 px-4 fs-7 me-2 cursor-pointer send_verification_mail" id="send_verification_mail_btn_${data.record_id}" advisor_id="${data.record_id}" data-bs-toggle="modal" data-bs-target="#kt_modal_send_verification_mail_popup" title="Send Mail">Send Mail</span>`;
                                }

                                return `<div class="d-flex">
                                            ${send_btn}
                                            <a href="tel:${data.mobile_no}">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-3 fw-bold text-gray-700">
                                                        <i class="las la-phone-volume fs-2 text-success"></i>
                                                    </div>
                                                </div>
                                            </a> 
                                            <a href="mailto:${data.email}">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-2 fw-bold text-gray-700">
                                                        <i class="las la-envelope-open-text fs-2  text-success"></i>
                                                    </div>
                                                </div> 
                                            </a>  
                                    </div>`;
                            },
                        },
                    ],
                    // Add data-filter attribute
                    createdRow: function(row, data, dataIndex) {
                        $(row).find('td:eq(3)').attr('data-filter', data.CreditCardType);
                    }
                });

                table = dt.$;

                // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                dt.on('draw', function() {
                    initToggleToolbar();
                    toggleToolbars();
                    handleDeleteRows();
                    KTMenu.createInstances();
                });
            }

            // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
            var handleSearchDatatable = function() {
                const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
                filterSearch.addEventListener('keyup', function(e) {
                    dt.search(e.target.value).draw();
                });
            }

            // Filter Datatable
            var handleFilterDatatable = () => {
                // Select filter options
                filterAdvisor = document.querySelectorAll('[data-kt-docs-table-filter="advisor_status"] [name="advisor_status"]');

                const filterButton = document.querySelector('[data-kt-docs-table-filter="filter"]');

                // Filter datatable on submit
                if (filterButton) {
                    filterButton.addEventListener('click', function() {
                        // Get filter values
                        let advisorStatus = '';

                        // Get Advisor value
                        filterAdvisor.forEach(r => {

                            if (r.checked) {
                                advisorStatus = r.value;
                            }

                            // Reset Advisor value if "All" is selected
                            if (advisorStatus === 'all') {
                                advisorStatus = '';
                            }
                        });

                        // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
                        dt.search(advisorStatus).draw();
                    });
                }

            }

            // Delete Row
            var handleDeleteRows = () => {
                // Select all delete buttons
                const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

                deleteButtons.forEach(d => {
                    // Delete button on click
                    d.addEventListener('click', function(e) {
                        e.preventDefault();

                        // Select parent row
                        const parent = e.target.closest('tr');

                        // Get customer name
                        const customerName = parent.querySelectorAll('td')[1].innerText;

                        var advisor_id = d.getAttribute('advisor_id');

                        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Are you sure you want to delete " + customerName + "?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            }
                        }).then(function(result) {
                            if (result.value) {
                                // Simulate delete request -- for demo purpose only
                                Swal.fire({
                                    text: "Deleting " + customerName,
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    $.post(ajax_url, {
                                        action: 'advisor_delete',
                                        advisor_id: advisor_id
                                    }, function(result) {

                                    });
                                    Swal.fire({
                                        text: "You have deleted " + customerName + "!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function() {
                                        // delete row data from server and re-draw datatable 

                                        dt.draw();
                                    });
                                });
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: customerName + " was not deleted.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    })
                });
            }

            // Reset Filter
            var handleResetForm = () => {
                // Select reset button
                const resetButton = document.querySelector('[data-kt-docs-table-filter="reset"]');

                // Reset datatable
                if (resetButton) {
                    resetButton.addEventListener('click', function() {
                        // Reset Advisor type
                        filterAdvisor[0].checked = true;

                        // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
                        dt.search('').draw();
                    });
                }

            }

            // Init toggle toolbar
            var initToggleToolbar = function() {
                // Toggle selected action toolbar
                // Select all checkboxes
                const container = document.querySelector('#kt_datatable_example_1');
                const checkboxes = container.querySelectorAll('[type="checkbox"]');

                // Select elements
                const deleteSelected = document.querySelector('[data-kt-docs-table-select="delete_selected"]');

                var SelectedRow = [];
                // Toggle delete selected toolbar
                checkboxes.forEach(c => {
                    // Checkbox on click event
                    c.addEventListener('click', function() {
                        SelectedRow.push(c.value);
                        setTimeout(function() {
                            toggleToolbars();
                        }, 50);
                    });
                });

                // Deleted selected rows
                if (deleteSelected) {

                    deleteSelected.addEventListener('click', function() {
                        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Are you sure you want to delete selected customers?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            showLoaderOnConfirm: true,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            },
                        }).then(function(result) {

                            if (result.value) {
                                // Simulate delete request -- for demo purpose only
                                Swal.fire({
                                    text: "Deleting selected customers",
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    Swal.fire({
                                        text: "You have deleted all selected customers!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function() {
                                        $.post(ajax_url, {
                                            action: 'delete_multiple_selected_advisor',
                                            advisor_ids: SelectedRow
                                        }, function(result) {

                                        });
                                        // delete row data from server and re-draw datatable
                                        dt.draw();
                                    });

                                    // Remove header checked box
                                    const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];
                                    headerCheckbox.checked = false;
                                });
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: "Selected customers was not deleted.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    });

                }
            }

            // Toggle toolbars
            var toggleToolbars = function() {
                // Define variables
                const container = document.querySelector('#kt_datatable_example_1');
                const toolbarBase = document.querySelector('[data-kt-docs-table-toolbar="base"]');
                const toolbarSelected = document.querySelector('[data-kt-docs-table-toolbar="selected"]');
                const selectedCount = document.querySelector('[data-kt-docs-table-select="selected_count"]');

                // Select refreshed checkbox DOM elements
                const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

                // Detect checkboxes state & count
                let checkedState = false;
                let count = 0;

                // Count checked boxes
                allCheckboxes.forEach(c => {
                    if (c.checked) {
                        checkedState = true;
                        count++;
                    }
                });

                // Toggle toolbars
                if (checkedState) {
                    selectedCount.innerHTML = count;
                    toolbarBase.classList.add('d-none');
                    toolbarSelected.classList.remove('d-none');
                } else {
                    toolbarBase.classList.remove('d-none');
                    toolbarSelected.classList.add('d-none');
                }
            }

            // Public methods
            return {
                init: function() {
                    initDatatable();
                    handleSearchDatatable();
                    initToggleToolbar();
                    handleFilterDatatable();
                    handleDeleteRows();
                    handleResetForm();
                }
            }
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            KTDatatablesServerSide.init();
        });

        // verification sent datatable
        var verification_sent_datatable = function() {
            // Shared variables
            var table;
            var dt;
            var filterAdvisor;

            // Private functions
            var initDatatable = function() {
                dt = $("#verification_sent_datatable").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    order: [
                        [3, 'desc']
                    ],
                    stateSave: true,
                    select: {
                        style: 'multi',
                        selector: 'td:first-child input[type="checkbox"]',
                        className: 'row-selected'
                    },
                    ajax: {
                        url: "<?php echo site_url(); ?>/admin/verification/advisor-list-sent-verification-ajax.php",
                    },
                    columns: [{
                            data: 'record_id'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'lead_source'
                        },
                        {
                            data: null
                        },
                    ],
                    columnDefs: [{
                            targets: 0,
                            orderable: false,
                            render: function(data) {
                                return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="${data}" />
                            </div>`;
                            }
                        },
                        {
                            target: 1,
                            orderable: false,
                            className: 'd-flex align-items-center'
                        },
                        {
                            target: 2,
                            orderable: false,
                        },
                        {
                            target: 3,
                            orderable: false,
                        },

                        /*{
                            targets: 4,
                            render: function(data, type, row) {
                                return `<img src="${hostUrl}media/svg/card-logos/${row.CreditCardType}.svg" class="w-35px me-3" alt="${row.CreditCardType}">` + data;
                            }
                        },*/
                        {
                            targets: -1,
                            data: null,
                            orderable: false,
                            className: 'text-start',
                            render: function(data, type, row) {
                                return `<div class="d-flex">  
                                            <a href="<?php echo site_url(); ?>/admin/advisor/edit-advisor/${data.record_id}" target="_blank" class="badge badge-light-info flex-shrink-0 align-self-center py-3 px-4 fs-7 me-2 cursor-pointer" title="Complete Now">Complete Now</a>
                                            <a href="tel:${data.mobile_no}">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-3 fw-bold text-gray-700">
                                                        <i class="las la-phone-volume fs-2 text-success"></i>
                                                    </div>
                                                </div>
                                            </a> 
                                            <a href="mailto:${data.email}">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-2 fw-bold text-gray-700">
                                                        <i class="las la-envelope-open-text fs-2  text-success"></i>
                                                    </div>
                                                </div> 
                                            </a>  
                                    </div>`;
                            },
                        },
                    ],
                    // Add data-filter attribute
                    createdRow: function(row, data, dataIndex) {
                        $(row).find('td:eq(3)').attr('data-filter', data.CreditCardType);
                    }
                });

                table = dt.$;

                // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                dt.on('draw', function() {
                    initToggleToolbar();
                    toggleToolbars();
                    handleDeleteRows();
                    KTMenu.createInstances();
                });
            }

            // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
            var handleSearchDatatable = function() {
                const filterSearch = document.querySelector('[data-kt-docs-table-sent-verification-filter="search"]');
                filterSearch.addEventListener('keyup', function(e) {
                    dt.search(e.target.value).draw();
                });
            }

            // Filter Datatable
            var handleFilterDatatable = () => {
                // Select filter options
                filterAdvisor = document.querySelectorAll('[data-kt-docs-table-sent-verification-filter="advisor_status"] [name="advisor_status"]');

                const filterButton = document.querySelector('[data-kt-docs-table-sent-verification-filter="filter"]');

                // Filter datatable on submit
                if (filterButton) {
                    filterButton.addEventListener('click', function() {
                        // Get filter values
                        let advisorStatus = '';

                        // Get Advisor value
                        filterAdvisor.forEach(r => {

                            if (r.checked) {
                                advisorStatus = r.value;
                            }

                            // Reset Advisor value if "All" is selected
                            if (advisorStatus === 'all') {
                                advisorStatus = '';
                            }
                        });

                        // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
                        dt.search(advisorStatus).draw();
                    });
                }

            }

            // Delete Row
            var handleDeleteRows = () => {
                // Select all delete buttons
                const deleteButtons = document.querySelectorAll('[data-kt-docs-table-sent-verification-filter="delete_row"]');

                deleteButtons.forEach(d => {
                    // Delete button on click
                    d.addEventListener('click', function(e) {
                        e.preventDefault();

                        // Select parent row
                        const parent = e.target.closest('tr');

                        // Get customer name
                        const customerName = parent.querySelectorAll('td')[1].innerText;

                        var advisor_id = d.getAttribute('advisor_id');

                        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Are you sure you want to delete " + customerName + "?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            }
                        }).then(function(result) {
                            if (result.value) {
                                // Simulate delete request -- for demo purpose only
                                Swal.fire({
                                    text: "Deleting " + customerName,
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    $.post(ajax_url, {
                                        action: 'advisor_delete',
                                        advisor_id: advisor_id
                                    }, function(result) {

                                    });
                                    Swal.fire({
                                        text: "You have deleted " + customerName + "!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function() {
                                        // delete row data from server and re-draw datatable 

                                        dt.draw();
                                    });
                                });
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: customerName + " was not deleted.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    })
                });
            }

            // Reset Filter
            var handleResetForm = () => {
                // Select reset button
                const resetButton = document.querySelector('[data-kt-docs-table-sent-verification-filter="reset"]');

                // Reset datatable
                if (resetButton) {
                    resetButton.addEventListener('click', function() {
                        // Reset Advisor type
                        filterAdvisor[0].checked = true;

                        // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
                        dt.search('').draw();
                    });
                }

            }

            // Init toggle toolbar
            var initToggleToolbar = function() {
                // Toggle selected action toolbar
                // Select all checkboxes
                const container = document.querySelector('#verification_sent_datatable');
                const checkboxes = container.querySelectorAll('[type="checkbox"]');

                // Select elements
                const deleteSelected = document.querySelector('[data-kt-docs-table-sent-verification-select="delete_selected"]');

                var SelectedRow = [];
                // Toggle delete selected toolbar
                checkboxes.forEach(c => {
                    // Checkbox on click event
                    c.addEventListener('click', function() {
                        SelectedRow.push(c.value);
                        setTimeout(function() {
                            toggleToolbars();
                        }, 50);
                    });
                });

                // Deleted selected rows
                if (deleteSelected) {

                    deleteSelected.addEventListener('click', function() {
                        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Are you sure you want to delete selected customers?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            showLoaderOnConfirm: true,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            },
                        }).then(function(result) {

                            if (result.value) {
                                // Simulate delete request -- for demo purpose only
                                Swal.fire({
                                    text: "Deleting selected customers",
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    Swal.fire({
                                        text: "You have deleted all selected customers!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function() {
                                        $.post(ajax_url, {
                                            action: 'delete_multiple_selected_advisor',
                                            advisor_ids: SelectedRow
                                        }, function(result) {

                                        });
                                        // delete row data from server and re-draw datatable
                                        dt.draw();
                                    });

                                    // Remove header checked box
                                    const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];
                                    headerCheckbox.checked = false;
                                });
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: "Selected customers was not deleted.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    });

                }
            }

            // Toggle toolbars
            var toggleToolbars = function() {
                // Define variables
                const container = document.querySelector('#verification_sent_datatable');
                const toolbarBase = document.querySelector('[data-kt-docs-table-verification-sent-toolbar="base"]');
                const toolbarSelected = document.querySelector('[data-kt-docs-table-verification-sent-toolbar="selected"]');
                const selectedCount = document.querySelector('[data-kt-docs-table-verification-sent-select="selected_count"]');

                // Select refreshed checkbox DOM elements
                const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

                // Detect checkboxes state & count
                let checkedState = false;
                let count = 0;

                // Count checked boxes
                allCheckboxes.forEach(c => {
                    if (c.checked) {
                        checkedState = true;
                        count++;
                    }
                });

                // Toggle toolbars
                if (checkedState) {
                    selectedCount.innerHTML = count;
                    toolbarBase.classList.add('d-none');
                    toolbarSelected.classList.remove('d-none');
                } else {
                    toolbarBase.classList.remove('d-none');
                    toolbarSelected.classList.add('d-none');
                }
            }

            // Public methods
            return {
                init: function() {
                    initDatatable();
                    handleSearchDatatable();
                    initToggleToolbar();
                    handleFilterDatatable();
                    handleDeleteRows();
                    handleResetForm();
                }
            }
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            verification_sent_datatable.init();
        });

        $('#send_mail_btn').click(function(event) {

            if (!$("#verification_req_email").val() || !$("#advisor_id").val()) {
                return false;
            }

            var advisor_id = $("#advisor_id").val();

            $("#send_mail_btn .indicator-label").hide();
            $("#send_mail_btn .indicator-progress").show();

            // Prevent the default form submission
            event.preventDefault();

            $.post(ajax_url, {
                action: 'send_verification_mail',
                email: $("#verification_req_email").val(),
                advisor_id: advisor_id,
                is_ajax: true,
            }, function(result) {

                var results = JSON.parse(result);

                $("#send_mail_btn .indicator-label").show();
                $("#send_mail_btn .indicator-progress").hide();
                $("#kt_modal_send_verification_mail_form p.text-success").html('');

                if (results.status) {
                    $('#kt_modal_send_verification_mail_form')[0].reset();
                    $("#send_verification_mail_btn_" + advisor_id).text("Sent");
                    $("#send_verification_mail_btn_" + advisor_id).removeClass("badge-light-danger");
                    $("#send_verification_mail_btn_" + advisor_id).addClass("badge-light-success");
                    $("#send_mail_btn").after('<p class="text-success">' + results.msg + '</p>');
                    setTimeout(function() {
                        location.reload(true);
                    }, 2000);
                } else {
                    $("#send_mail_btn").after('<p class="text-danger">' + results.msg + '</p>');
                }

            });
        });
    </script>

</body>
<!--end::Body-->

</html>