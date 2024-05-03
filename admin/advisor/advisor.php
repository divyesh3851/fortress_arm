<?php require '../../config.php';
$page_name = 'advisor';
$sub_page_name = 'advisor-list';
Admin()->check_login();

if (isset($_POST['save_advisor'])) {

    if (!empty(sipost('advisor_id'))) {
        $response = Advisor()->update_advisor();
    } else {

        $response = Advisor()->add_advisor();
    }

    if ($response == 1) {
        $_SESSION['process_success'] = true;
    } elseif ($response == 'duplicate') {
        $_SESSION['process_duplicate'] = true;
    } else {
        $_SESSION['process_fail'] = true;
    }

    wp_redirect(site_url() . '/admin/advisor/advisor-list');
    exit;
}

$get_state_list = Settings()->get_state_list();

$get_designation_list = Settings()->get_designation_list();

$get_license_type_list = Settings()->get_license_type_list();

$get_lead_source_list = Settings()->get_lead_source_list();

$get_affiliations_list = Settings()->get_affiliations_list();

$get_carrier_appointed_list = Settings()->get_carrier_appointed_list();

$get_carrier_list = Settings()->get_carrier_list();

$get_premium_volume_list = Settings()->get_premium_volume_list();

$get_production_percentage_list = Settings()->get_production_percentage_list();

$get_market_list = Settings()->get_market_list(); ?>

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
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Advisor</h1>
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

                                <!--begin::Card-->
                                <div class="card">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-10">
                                        <!--begin::Stepper-->
                                        <div class="stepper stepper-links d-flex flex-column pt-5" id="kt_create_account_stepper">
                                            <!--begin::Nav-->
                                            <div class="stepper-nav mb-5">
                                                <!--begin::Step 1-->
                                                <div class="stepper-item current" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                                    <h3 class="stepper-title">Personal Info</h3>
                                                </div>
                                                <!--end::Step 1-->
                                                <!--begin::Step 2-->
                                                <div class="stepper-item" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                                    <h3 class="stepper-title">Contact Info</h3>
                                                </div>
                                                <!--end::Step 2-->
                                                <!--begin::Step 3-->
                                                <div class="stepper-item" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                                    <h3 class="stepper-title">Des/Aff</h3>
                                                </div>
                                                <!--end::Step 3-->
                                                <!--begin::Step 4-->
                                                <div class="stepper-item" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                                    <h3 class="stepper-title">Carrier Info</h3>
                                                </div>
                                                <!--end::Step 4-->
                                                <!--begin::Step 5-->
                                                <div class="stepper-item" data-kt-stepper-element="nav" data-kt-stepper-action="step">
                                                    <h3 class="stepper-title">Production Info</h3>
                                                </div>
                                                <!--end::Step 5-->
                                            </div>
                                            <!--end::Nav-->
                                            <!--begin::Form-->
                                            <form class=" w-100 pt-15 pb-10" novalidate="novalidate" id="kt_create_account_form" method="post" enctype="multipart/form-data">
                                                <!--begin::Step 1-->
                                                <div class="current" data-kt-stepper-element="content">
                                                    <!--begin::Wrapper-->
                                                    <div class="w-100">
                                                        <div class="row mb-7">
                                                            <!--begin::Input group-->
                                                            <div class="fv-row col-md-3 mb-7">
                                                                <!--begin::Label-->
                                                                <label class="d-block fw-semibold fs-6 mb-5">Profile Image</label>
                                                                <!--end::Label-->
                                                                <!--begin::Image placeholder-->
                                                                <style>
                                                                    .image-input-placeholder {
                                                                        background-image: url('<?php echo site_url(); ?>/assets/media/svg/files/blank-image.svg');
                                                                    }

                                                                    [data-bs-theme="dark"] .image-input-placeholder {
                                                                        background-image: url('<?php echo site_url(); ?>/assets/media/svg/files/blank-image-dark.svg');
                                                                    }
                                                                </style>
                                                                <!--end::Image placeholder-->
                                                                <!--begin::Image input-->
                                                                <div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
                                                                    <!--begin::Preview existing avatar-->
                                                                    <div class="image-input-wrapper w-125px h-125px" id="advisor_profile_src" style="background-image: url(<?php echo site_url(); ?>/assets/media/svg/files/blank-image.svg);"></div>
                                                                    <!--end::Preview existing avatar-->
                                                                    <!--begin::Label-->
                                                                    <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Profile Image">
                                                                        <i class="ki-outline ki-pencil fs-7"></i>
                                                                        <!--begin::Inputs-->
                                                                        <input type="file" name="advisor_profile" accept=".png, .jpg, .jpeg" />
                                                                        <input type="hidden" name="advisor_profile_remove" />
                                                                        <!--end::Inputs-->
                                                                    </label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Cancel-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel Profile">
                                                                        <i class="ki-outline ki-cross fs-2"></i>
                                                                    </span>
                                                                    <!--end::Cancel-->
                                                                    <!--begin::Remove-->
                                                                    <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove Profile">
                                                                        <i class="ki-outline ki-cross fs-2"></i>
                                                                    </span>
                                                                    <!--end::Remove-->
                                                                </div>
                                                                <!--end::Image input-->
                                                                <!--begin::Hint-->
                                                                <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                                                                <!--end::Hint-->
                                                            </div>
                                                        </div>
                                                        <!--end::Input group-->
                                                        <!--begin::Input group-->
                                                        <div class="row mb-7">
                                                            <div class="col-md-2 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Title</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="prefix" id="prefix" data-control="select2" data-placeholder="Select a Title..." class="form-select form-select-solid" required>
                                                                    <option value="">Select Title</option>
                                                                    <?php foreach (Settings()->get_name_prefix_list() as $prefix_result) { ?>
                                                                        <option value="<?php echo $prefix_result; ?>"><?php echo $prefix_result; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <!--end::Input-->
                                                            </div>

                                                            <div class="col-md-4 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Preferred Name</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="preferred_name" id="preferred_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Preferred Name" required />
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">License #</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="license_no" id="license_no" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="License No" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">NPN #</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="npn_no" id="npn_no" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="NPN No" />
                                                                <!--end::Input-->
                                                            </div>
                                                        </div>
                                                        <div class="row mb-7">
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">First Name</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="first_name" id="first_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="First Name" required />
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-3 fv-row">
                                                                <div class="middle_name_field">
                                                                    <!--begin::Label-->
                                                                    <label class="fw-semibold fs-6 mb-2">Middle Name</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text" name="middle_name" id="middle_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Middle Name" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <label class="form-check form-check-custom form-check-solid mt-3 no_middle_name_checkbox">
                                                                    <input class="form-check-input" type="checkbox" name="no_middle_name">
                                                                    <span class="form-check-label text-gray-600">
                                                                        No Middle Name
                                                                    </span>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Last Name</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="last_name" id="last_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Last Name" required />
                                                                <!--end::Input-->
                                                            </div>

                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">Company Name</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="company_name" id="company_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Company Name" />
                                                                <!--end::Input-->
                                                            </div>

                                                        </div>
                                                        <div class="row mb-7">
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Birthdate</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="birth_date" id="birth_date" class="flatpickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Birthdate" required />
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Gender</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="gender" id="gender" data-control="select2" data-placeholder="Select a Gender..." class="form-select form-select-solid is_empty" required>
                                                                    <option value="">Select Gender</option>
                                                                    <option value="Male">Male</option>
                                                                    <option value="Female">Female</option>
                                                                    <option value="Other">Other</option>
                                                                </select>
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Status</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="advisor_status" id="advisor_status" data-control="select2" data-placeholder="Select a Status..." class="form-select form-select-solid is_empty" required>
                                                                    <option value="">Select Status</option>
                                                                    <?php foreach (Settings()->get_advisor_status_list() as $key => $advisor_status_result) { ?>
                                                                        <option value="<?php echo $key; ?>"><?php echo $advisor_status_result; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">City</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="city" id="city" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="City" required />
                                                                <!--end::Input-->
                                                            </div>
                                                        </div>
                                                        <div class="row mb-7">
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">State</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="state" id="state" data-control="select2" data-placeholder="Select a State..." class="form-select form-select-solid is_empty" required>
                                                                    <option value="">Select State</option>
                                                                    <?php foreach ($get_state_list as $state_result) { ?>
                                                                        <option value="<?php echo $state_result; ?>"><?php echo $state_result; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-6 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">Types of Licenses</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="licenses_type[]" id="licenses_type" class="form-select  form-select-solid" data-control="select2" data-close-on-select="false" data-placeholder="Select a Type" data-allow-clear="true" multiple="multiple">
                                                                    <option value="">Select a Type</option>
                                                                    <?php foreach ($get_license_type_list as $license_type_result) { ?>
                                                                        <option value="<?php echo $license_type_result->id; ?>"><?php echo $license_type_result->type; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Marital Status</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="marital_status" id="marital_status" data-control="select2" data-placeholder="Select a Status..." class="form-select form-select-solid is_empty" required>
                                                                    <option value="">Select Status</option>
                                                                    <option value="Married">Married</option>
                                                                    <option value="Unmarried">Unmarried</option>
                                                                </select>
                                                                <!--end::Input-->
                                                            </div>
                                                        </div>
                                                        <div class="row mb-7">

                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">Wedding Anniversary</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="anniversary_date" id="anniversary_date" class="flatpickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Wedding Anniversary" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">Spouses Name</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="spouses_name" id="spouses_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Spouses Name" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">Spouses Birthdate</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="spouses_birthdate" id="spouses_birthdate" class="flatpickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Spouses Birthdate" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">How Many Children</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="total_children" id="total_children" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="How Many Children" />
                                                                <!--end::Input-->
                                                            </div>
                                                        </div>
                                                        <div class="row mb-7">

                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">Lead Source</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="lead_source" id="lead_source" data-control="select2" data-placeholder="Select a Source..." class="form-select form-select-solid is_empty">
                                                                    <option value="">Select Source</option>
                                                                    <?php foreach ($get_lead_source_list as $lead_source_result) { ?>
                                                                        <option value="<?php echo $lead_source_result->id; ?>"><?php echo $lead_source_result->type; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">Lead Owner</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="lead_owner" id="lead_owner" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Lead Owner" />
                                                                <!--end::Input-->
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <!--end::Wrapper-->
                                                            <div class="card card-flush">
                                                                <!--begin::Card header-->
                                                                <div class="card-header">
                                                                    <div class="card-title">
                                                                        <h2>Social Links</h2>
                                                                    </div>
                                                                </div>
                                                                <!--end::Card header-->

                                                                <!--begin::Card body-->
                                                                <div class="card-body pt-0">
                                                                    <!--begin::Input group-->
                                                                    <div class="row mb-4 mb-7">
                                                                        <!--begin::Input wrapper-->
                                                                        <div class="col-md-6 fv-row">
                                                                            <!--begin::Input-->
                                                                            <input type="url" name="instagram_url" id="instagram_url" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Instagram URL" />
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <!--end::Input wrapper-->
                                                                        <!--begin::Input wrapper-->
                                                                        <div class="col-md-6 fv-row">
                                                                            <!--begin::Input-->
                                                                            <input type="url" name="facebook_url" id="facebook_url" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Facebok URL" />
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <!--end::Input wrapper-->
                                                                    </div>
                                                                    <div class="row mb-4 mb-7">
                                                                        <!--begin::Input wrapper-->
                                                                        <div class="col-md-6 fv-row">
                                                                            <!--begin::Input-->
                                                                            <input type="url" name="linkedin_url" id="linkedin_url" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="LinkedIn URL" />
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <!--end::Input wrapper-->
                                                                        <!--begin::Input wrapper-->
                                                                        <div class="col-md-6 fv-row">
                                                                            <!--begin::Input-->
                                                                            <input type="url" name="youtube_url" id="youtube_url" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Youtube URL" />
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <!--end::Input wrapper-->
                                                                    </div>
                                                                    <div class="row mb-4 mb-7">
                                                                        <!--begin::Input wrapper-->
                                                                        <div class="col-md-6 fv-row">
                                                                            <!--begin::Input-->
                                                                            <input type="url" name="twitter_url" id="twitter_url" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Twitter URL" />
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <!--end::Input wrapper-->
                                                                    </div>
                                                                    <!--end::Input group-->
                                                                </div>
                                                                <!--end::Card header-->
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                                <!--end::Step 1-->
                                                <!--begin::Step 2-->
                                                <div data-kt-stepper-element="content">
                                                    <!--begin::Wrapper-->
                                                    <div class="mx-auto w-100">
                                                        <!--begin::Repeater-->
                                                        <div id="">
                                                            <!--begin::Form group-->
                                                            <div class="form-group">
                                                                <div data-repeater-list="kt_docs_repeater_basic">
                                                                    <div data-repeater-item>
                                                                        <div class="form-group row">
                                                                            <div class="col-md-2">
                                                                                <label class="required form-label">Type</label>
                                                                                <select name="contact_type" data-control="select2" data-placeholder="Select a type..." class="form-select form-select-solid is_empty" required>
                                                                                    <option value="">Select Type</option>
                                                                                    <option value="Work">Work</option>
                                                                                    <option value="Mobile">Mobile</option>
                                                                                    <option value="Other">Other</option>
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <label class="required form-label">Primary Phone Number</label>
                                                                                <input type="text" name="mobile_no" class="form-control mb-2 mb-md-0 " placeholder="Enter Primary Phone Number" required />
                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <label class="required form-label">Primary Email Address</label>
                                                                                <input type="email" name="email" class="form-control mb-2 mb-md-0 " placeholder="Enter Primary Email Address" required />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end::Form group-->

                                                            <div class="form-group mt-5">
                                                                <a href="javascript:;" data-repeater-create class="btn btn-light-primary" id="add_extra_contact_btn_default">
                                                                    <i class="ki-duotone ki-plus fs-3"></i> Add
                                                                </a>
                                                            </div>

                                                            <!--begin::Form group-->
                                                            <div id="contact_info_multi_row" style="display: none;">
                                                                <div class="extra_contact">
                                                                    <div class="form-group row mb-5" id="row_id_1">
                                                                        <div class="col-md-2">
                                                                            <label class="form-label">Type</label>
                                                                            <select id="contact_type_1" name="contact_type_1" data-control="select2" data-placeholder="Select a type..." class="form-select form-select-solid is_empty">
                                                                                <option value="">Select Type</option>
                                                                                <?php foreach (Settings()->get_contact_type_list() as $contact_type_result) { ?>
                                                                                    <option value="<?php echo $contact_type_result; ?>"><?php echo $contact_type_result; ?></option>
                                                                                <?php } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label class="form-label">Additional Phone Number</label>
                                                                            <input type="text" name="mobile_no_1" class="form-control mb-2 mb-md-0" placeholder="Enter Additional Phone Number" />
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label class="form-label">Additional Email Address</label>
                                                                            <input type="email" name="email_1" class="form-control mb-2 mb-md-0" placeholder="Enter Additional Email Address" />
                                                                        </div>

                                                                        <div class="col-md-2">
                                                                            <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8 remove_row" id="1">
                                                                                <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                                                                Delete
                                                                            </a>
                                                                        </div>
                                                                        <input type="hidden" name="contact_info_row_list[]" id="contact_info_row_list" class="contact_info_row_list" value="1">
                                                                    </div>
                                                                </div>
                                                                <div class="form-group mt-5">
                                                                    <a href="javascript:;" data-repeater-create class="btn btn-light-primary" id="add_extra_contact_btn">
                                                                        <i class="ki-duotone ki-plus fs-3"></i> Add
                                                                    </a>
                                                                </div>
                                                            </div>
                                                            <!--end::Form group-->
                                                        </div>
                                                        <!--end::Repeater-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                </div>
                                                <!--end::Step 2-->
                                                <!--begin::Step 3-->
                                                <div data-kt-stepper-element="content">
                                                    <div class="w-100">
                                                        <div class="row mb-7">
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">Professional Designations</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="designation" id="designation" data-control="select2" data-placeholder="Select a Designation..." class="form-select form-select-solid is_empty">
                                                                    <option value="">Select Designation</option>
                                                                    <?php foreach ($get_designation_list as $designation_result) { ?>
                                                                        <option value="<?php echo $designation_result->id; ?>"><?php echo $designation_result->initials . ' - ' . $designation_result->name; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-3 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">Affiliations</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="affiliations" id="affiliations" data-control="select2" data-placeholder="Select a Affiliations..." class="form-select form-select-solid is_empty">
                                                                    <option value="">Select Affiliation</option>
                                                                    <?php foreach ($get_affiliations_list as $affiliation_result) { ?>
                                                                        <option value="<?php echo $affiliation_result->id; ?>"><?php echo $affiliation_result->type; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-6 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">Please describe:</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <textarea name="organization" id="organization" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Are you active within the leadership of any of these organizations, locally or nationally?" /></textarea>
                                                                <!--end::Input-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Step 3-->
                                                <!--begin::Step 4-->
                                                <div data-kt-stepper-element="content">
                                                    <div class="w-100">
                                                        <div class="row mb-7">
                                                            <div class="col-md-6 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">How many carriers are you currently appointed with? </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="carrier_appointed" id="carrier_appointed" data-control="select2" data-placeholder="Select a Carriers..." class="form-select form-select-solid is_empty">
                                                                    <option value="">Select Appointed</option>
                                                                    <?php foreach ($get_carrier_appointed_list as $carrier_appointed_result) { ?>
                                                                        <option value="<?php echo $carrier_appointed_result->id; ?>"><?php echo $carrier_appointed_result->type; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-6 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">Which Carrier(s) does the agent do business with? </label>

                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="carrier_with_business[]" id="carrier_with_business" class="form-select  form-select-solid" data-control="select2" data-close-on-select="false" data-placeholder="Select an Carrier" data-allow-clear="true" multiple="multiple">
                                                                    <option value="">Select Carrier</option>
                                                                    <?php foreach ($get_carrier_list as $carrier_result) { ?>
                                                                        <option value="<?php echo $carrier_result->id; ?>"><?php echo $carrier_result->name; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <em>Please check all that apply and indicate a percentage totaling 100%</em>
                                                                <!--end::Input-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Step 4-->
                                                <!--begin::Step 5-->
                                                <div data-kt-stepper-element="content">
                                                    <div class="w-100">
                                                        <div class="row mb-7">
                                                            <div class="col-md-4 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">Premium Volume </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="premium_volume" id="premium_volume" data-control="select2" data-placeholder="Select a Premium Volume..." class="form-select form-select-solid is_empty">
                                                                    <option value="">Select Volume</option>
                                                                    <?php foreach ($get_premium_volume_list as $premium_volume_result) { ?>
                                                                        <option value="<?php echo $premium_volume_result->id; ?>"><?php echo $premium_volume_result->type; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-4 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">Production Percentages </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="production_percentages[]" id="production_percentages" data-control="select2" data-close-on-select="false" data-placeholder="Select a Production Percentages..." data-allow-clear="true" multiple="multiple" class="form-select form-select-solid">
                                                                    <option value="">Select Production Percentages</option>
                                                                    <?php foreach ($get_production_percentage_list as $production_percentage_result) { ?>
                                                                        <option value="<?php echo $production_percentage_result->id; ?>"><?php echo $production_percentage_result->type; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <em>Please check all that apply and indicate a percentage totaling 100%</em>
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-4 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">Markets</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="markets[]" id="markets" data-control="select2" data-close-on-select="false" data-placeholder="Select a Markets..." data-allow-clear="true" multiple="multiple" class="form-select form-select-solid">
                                                                    <option value="">Select Markets</option>
                                                                    <?php foreach ($get_market_list as $market_result) { ?>
                                                                        <option value="<?php echo $market_result->id; ?>"><?php echo $market_result->type; ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <em>Please check all that apply and indicate a percentage totaling 100%</em>
                                                                <!--end::Input-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--end::Step 5-->
                                                <!--begin::Actions-->
                                                <div class="d-flex flex-stack pt-15">
                                                    <!--begin::Wrapper-->
                                                    <div class="mr-2">
                                                        <button type="button" class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
                                                            <i class="ki-outline ki-arrow-left fs-4 me-1"></i>Back</button>
                                                    </div>
                                                    <!--end::Wrapper-->
                                                    <!--begin::Wrapper-->
                                                    <div>
                                                        <button type="submit" name="save_advisor" class="btn btn-lg btn-primary me-3" data-kt-stepper-action="submit">
                                                            <span class="indicator-label">Submit
                                                                <i class="ki-outline ki-arrow-right fs-3 ms-2 me-0"></i></span>
                                                            <span class="indicator-progress">Please wait...
                                                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                        </button>
                                                        <button type="button" class="btn btn-lg btn-primary" data-kt-stepper-action="next">Continue
                                                            <i class="ki-outline ki-arrow-right fs-4 ms-1 me-0"></i></button>
                                                    </div>
                                                    <!--end::Wrapper-->
                                                </div>
                                                <!--end::Actions-->
                                            </form>
                                            <!--end::Form-->
                                        </div>
                                        <!--end::Stepper-->
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
    <!--<script src="<?php echo site_url(); ?>/assets/js/custom/utilities/modals/create-account.js"></script>-->
    <script type="text/javascript" src="<?php echo SITE_URL; ?>/assets/js/underscore.min.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL; ?>/assets/js/wp-util.js"></script>
    <!--end::Vendors Javascript-->
    <!--end::Javascript-->

    <script type="text/html" id="tmpl-contact-info-row-list">
        <div class="form-group row mb-5" id="row_id_{{{data.index}}}">
            <div class="col-md-2">
                <label class="form-label">Type</label>
                <select id="contact_type_{{{data.index}}}" name="contact_type_{{{data.index}}}" data-control="select2" data-placeholder="Select a type..." class="form-select form-select-solid is_empty">
                    <option value="">Select Type</option>
                    <?php foreach (Settings()->get_contact_type_list() as $contact_type_result) { ?>
                        <option value="<?php echo $contact_type_result; ?>"><?php echo $contact_type_result; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Additional Phone Number</label>
                <input type="text" name="mobile_no_{{{data.index}}}" class="form-control mb-2 mb-md-0" placeholder="Enter Additional Phone Number" />
            </div>
            <div class="col-md-3">
                <label class="form-label">Additional Email Address</label>
                <input type="email" name="email_{{{data.index}}}" class="form-control mb-2 mb-md-0" placeholder="Enter Additional Email Address" />
            </div>

            <div class="col-md-2">
                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8 remove_row" id="{{{data.index}}}">
                    <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                    Delete
                </a>
            </div>
            <input type="hidden" name="contact_info_row_list[]" id="contact_info_row_list" class="contact_info_row_list" value="{{{data.index}}}">
        </div>
    </script>
    <script>
        $(document).on("click", "#add_extra_contact_btn_default", function(e) {
            $("#add_extra_contact_btn_default").hide();
            $("#contact_info_multi_row").show();
        });

        $(document).on("click", "#contact_info_multi_row #add_extra_contact_btn", function(e) {

            var contact_info_row_list = [];
            $("#contact_info_multi_row .contact_info_row_list").each(function(index, element) {
                contact_info_row_list.push(element.value);
            });

            var max_contact_info_row_list_id = contact_info_row_list.length ? Math.max.apply(null, contact_info_row_list) : 1;
            max_contact_info_row_list_id = max_contact_info_row_list_id ? max_contact_info_row_list_id + 1 : 1;

            var template = wp.template('contact-info-row-list');

            $('#contact_info_multi_row .extra_contact').append(template({
                index: max_contact_info_row_list_id
            }));

            $('select').select2({});

        });


        $(document).on("click", "#contact_info_multi_row .remove_row", function(e) {

            var pro_detail_row_id = jQuery(this).attr("id");

            $("#contact_info_multi_row #row_id_" + pro_detail_row_id).remove();

        });
    </script>
    <script>
        $(document).on("change", "input[name='no_middle_name']", function() {
            if ($(this).prop('checked')) {
                $(".no_middle_name_checkbox").addClass("mt-8");
                $(".middle_name_field").hide();
            } else {
                $(".no_middle_name_checkbox").removeClass("mt-8");
                $(".middle_name_field").show();
            }
        });


        // Stepper lement
        var element = document.querySelector("#kt_create_account_stepper");

        // Initialize Stepper
        var stepper = new KTStepper(element);

        stepper.on("kt.stepper.click", function(stepper) {
            stepper.goTo(stepper.getClickedStepIndex()); // go to clicked step
        });

        // Handle next step
        stepper.on("kt.stepper.next", function(stepper) {
            stepper.goNext(); // go next step
        });

        // Handle previous step
        stepper.on("kt.stepper.previous", function(stepper) {
            stepper.goPrevious(); // go previous step
        });
    </script>
</body>
<!--end::Body-->

</html>