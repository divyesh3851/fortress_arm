<?php require '../../config.php';
$page_name = 'advisor';
$sub_page_name = 'advisor-list';
Admin()->check_login();

if (siget('advisor_id')) {
    $selected_advisor_data = Advisor()->get_selected_advisor_data(siget('advisor_id'));
}

if (!$selected_advisor_data) {
    wp_redirect(site_url() . '/admin/advisor/advisor-list');
    exit;
}

if (isset($_POST['save_advisor']) || isset($_POST['save_step'])) {

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

$get_market_list = Settings()->get_market_list();

$get_interest_life_insurance_list = Settings()->get_interest_life_insurance();

$get_interest_annuities_list = Settings()->get_interest_annuities();

$get_interest_long_term_care_insurance_list = Settings()->get_interest_long_term_care_insurance();

$get_interest_critical_illness_list = Settings()->get_interest_critical_illness();

$get_interest_disability_income_list = Settings()->get_interest_disability_income();

$get_interest_group_insurance_list = Settings()->get_interest_group_insurance();

$get_selected_advisor_interest = Advisor()->get_selected_advisor_interest($selected_advisor_data->id);

$selected_life_insurance = ($get_selected_advisor_interest && $get_selected_advisor_interest->life_insurance) ? explode(",", $get_selected_advisor_interest->life_insurance) : array();

$selected_annuities = ($get_selected_advisor_interest && $get_selected_advisor_interest->annuities) ? explode(",", $get_selected_advisor_interest->annuities) : array();

$selected_long_term_care_insurance = ($get_selected_advisor_interest && $get_selected_advisor_interest->long_term_care_insurance) ? explode(",", $get_selected_advisor_interest->long_term_care_insurance) : array();

$selected_critical_illness = ($get_selected_advisor_interest && $get_selected_advisor_interest->critical_illness) ? explode(",", $get_selected_advisor_interest->critical_illness) : array();

$birth_date = ($selected_advisor_data->birth_date && $selected_advisor_data->birth_date != '0000-00-00') ? date("m/d/Y", strtotime($selected_advisor_data->birth_date)) : '';

$anniversary_date = ($selected_advisor_data->anniversary_date && $selected_advisor_data->birth_date != '0000-00-00') ? date("m/d/Y", strtotime($selected_advisor_data->anniversary_date)) : '';

$spouses_birthdate = (Advisor()->get_advisor_meta($selected_advisor_data->id, "spouses_birthdate")) ? date("m/d/Y", strtotime(Advisor()->get_advisor_meta($selected_advisor_data->id, "spouses_birthdate"))) : '';

$type_of_licenses = ($selected_advisor_data->licenses_type) ? explode(',', $selected_advisor_data->licenses_type) : array();

$carrier_with_business = ($selected_advisor_data->carrier_with_business) ? explode(',', $selected_advisor_data->carrier_with_business) : array();

$production_percentages = ($selected_advisor_data->production_percentages) ? explode(',', $selected_advisor_data->production_percentages) : array();

$markets = ($selected_advisor_data->markets) ? explode(',', $selected_advisor_data->markets) : array();

$get_advisor_extra_contact = Advisor()->get_advisor_extra_contact($selected_advisor_data->id);

$get_last_employment = Advisor()->get_advisor_last_employment($selected_advisor_data->id);

$emp_assistant_contact = (isset($get_last_employment) && $get_last_employment->assistant_contact) ? unserialize($get_last_employment->assistant_contact)  : '';

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
                                <!--begin::Stepper-->
                                <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid gap-10" id="kt_create_account_stepper">
                                    <!--begin::Aside-->
                                    <div class="card d-flex justify-content-center justify-content-xl-start flex-row-auto w-100 w-xl-300px w-xxl-400px">
                                        <!--begin::Wrapper-->
                                        <div class="card-body px-6 px-lg-10 px-xxl-15 py-20">
                                            <!--begin::Nav-->
                                            <div class="stepper-nav">
                                                <!--begin::Step 1-->
                                                <div class="stepper-item current" data-kt-stepper-element="nav">
                                                    <!--begin::Wrapper-->
                                                    <div class="stepper-wrapper">
                                                        <!--begin::Icon-->
                                                        <div class="stepper-icon w-40px h-40px">
                                                            <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                                            <span class="stepper-number">1</span>
                                                        </div>
                                                        <!--end::Icon-->
                                                        <!--begin::Label-->
                                                        <div class="stepper-label">
                                                            <h3 class="stepper-title">Personal Info</h3>
                                                            <div class="stepper-desc fw-semibold">Personal Details</div>
                                                        </div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                    <!--begin::Line-->
                                                    <div class="stepper-line h-40px"></div>
                                                    <!--end::Line-->
                                                </div>
                                                <!--end::Step 1-->
                                                <!--begin::Step 2-->
                                                <div class="stepper-item" data-kt-stepper-element="nav">
                                                    <!--begin::Wrapper-->
                                                    <div class="stepper-wrapper">
                                                        <!--begin::Icon-->
                                                        <div class="stepper-icon w-40px h-40px">
                                                            <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                                            <span class="stepper-number">2</span>
                                                        </div>
                                                        <!--end::Icon-->
                                                        <!--begin::Label-->
                                                        <div class="stepper-label">
                                                            <h3 class="stepper-title">Contact Info</h3>
                                                            <div class="stepper-desc fw-semibold">Additional Contact Info</div>
                                                        </div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                    <!--begin::Line-->
                                                    <div class="stepper-line h-40px"></div>
                                                    <!--end::Line-->
                                                </div>
                                                <!--end::Step 2-->
                                                <!--begin::Step 3-->
                                                <div class="stepper-item" data-kt-stepper-element="nav">
                                                    <!--begin::Wrapper-->
                                                    <div class="stepper-wrapper">
                                                        <!--begin::Icon-->
                                                        <div class="stepper-icon w-40px h-40px">
                                                            <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                                            <span class="stepper-number">3</span>
                                                        </div>
                                                        <!--end::Icon-->
                                                        <!--begin::Label-->
                                                        <div class="stepper-label">
                                                            <h3 class="stepper-title">Des/Aff</h3>
                                                            <div class="stepper-desc fw-semibold"> </div>
                                                        </div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                    <!--begin::Line-->
                                                    <div class="stepper-line h-40px"></div>
                                                    <!--end::Line-->
                                                </div>
                                                <!--end::Step 3-->
                                                <!--begin::Step 4-->
                                                <div class="stepper-item" data-kt-stepper-element="nav">
                                                    <!--begin::Wrapper-->
                                                    <div class="stepper-wrapper">
                                                        <!--begin::Icon-->
                                                        <div class="stepper-icon w-40px h-40px">
                                                            <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                                            <span class="stepper-number">4</span>
                                                        </div>
                                                        <!--end::Icon-->
                                                        <!--begin::Label-->
                                                        <div class="stepper-label">
                                                            <h3 class="stepper-title">Carrier Info</h3>
                                                            <div class="stepper-desc fw-semibold"> </div>
                                                        </div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                    <!--begin::Line-->
                                                    <div class="stepper-line h-40px"></div>
                                                    <!--end::Line-->
                                                </div>
                                                <!--end::Step 4-->
                                                <!--begin::Step 5-->
                                                <div class="stepper-item" data-kt-stepper-element="nav">
                                                    <!--begin::Wrapper-->
                                                    <div class="stepper-wrapper">
                                                        <!--begin::Icon-->
                                                        <div class="stepper-icon w-40px h-40px">
                                                            <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                                            <span class="stepper-number">5</span>
                                                        </div>
                                                        <!--end::Icon-->
                                                        <!--begin::Label-->
                                                        <div class="stepper-label">
                                                            <h3 class="stepper-title">Production Info</h3>
                                                            <div class="stepper-desc fw-semibold"> </div>
                                                        </div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                    <!--begin::Line-->
                                                    <div class="stepper-line h-40px"></div>
                                                    <!--end::Line-->
                                                </div>
                                                <!--end::Step 5-->
                                                <!--begin::Step 6-->
                                                <div class="stepper-item" data-kt-stepper-element="nav">
                                                    <!--begin::Wrapper-->
                                                    <div class="stepper-wrapper">
                                                        <!--begin::Icon-->
                                                        <div class="stepper-icon w-40px h-40px">
                                                            <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                                            <span class="stepper-number">6</span>
                                                        </div>
                                                        <!--end::Icon-->
                                                        <!--begin::Label-->
                                                        <div class="stepper-label">
                                                            <h3 class="stepper-title">Interests</h3>
                                                            <div class="stepper-desc fw-semibold"> </div>
                                                        </div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                    <!--begin::Line-->
                                                    <div class="stepper-line h-40px"></div>
                                                    <!--end::Line-->
                                                </div>
                                                <!--end::Step 6-->
                                                <!--begin::Step 7-->
                                                <div class="stepper-item" data-kt-stepper-element="nav">
                                                    <!--begin::Wrapper-->
                                                    <div class="stepper-wrapper">
                                                        <!--begin::Icon-->
                                                        <div class="stepper-icon w-40px h-40px">
                                                            <i class="ki-outline ki-check fs-2 stepper-check"></i>
                                                            <span class="stepper-number">7</span>
                                                        </div>
                                                        <!--end::Icon-->
                                                        <!--begin::Label-->
                                                        <div class="stepper-label">
                                                            <h3 class="stepper-title">Social Links</h3>
                                                            <div class="stepper-desc fw-semibold"> </div>
                                                        </div>
                                                        <!--end::Label-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                </div>
                                                <!--end::Step 7-->
                                            </div>
                                            <!--end::Nav-->
                                        </div>
                                        <!--end::Wrapper-->
                                    </div>
                                    <!--begin::Aside-->
                                    <!--begin::Content-->
                                    <div class="card d-flex flex-row-fluid flex-center">
                                        <!--begin::Form-->
                                        <form class="card-body py-10 w-100 px-9" id="kt_create_account_form" method="post" enctype="multipart/form-data">
                                            <!--begin::Step 1-->
                                            <div class="current" data-kt-stepper-element="content">
                                                <input type="hidden" name="advisor_id" value="<?php echo $selected_advisor_data->id; ?>">
                                                <!--begin::Wrapper-->
                                                <div class="w-100">
                                                    <div class="pb-10 pb-lg-15">
                                                        <!--begin::Title-->
                                                        <h2 class="fw-bold text-gray-900">Personal Info</h2>
                                                        <!--end::Title-->
                                                        <!--begin::Notice-->
                                                        <div class="text-muted fw-semibold fs-6">Personal Details
                                                        </div>
                                                        <!--end::Notice-->
                                                    </div>
                                                    <div class="row ">
                                                        <div class="fv-row col-md-2 mb-7">
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
                                                                <?php
                                                                $profile_img = Advisor()->get_advisor_meta($selected_advisor_data->id, 'profile_img');
                                                                $profile_img = ($profile_img) ? site_url() . '/uploads/advisor/' . $profile_img : '';
                                                                if (!$profile_img) {
                                                                    $profile_img = site_url() . '/assets/media/svg/files/blank-image.svg';
                                                                }
                                                                ?>
                                                                <div class="image-input-wrapper w-125px h-125px" id="advisor_profile_src" style="background-image: url(<?php echo $profile_img; ?>);"></div>
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
                                                        <div class="col-md-10 fv-row">
                                                            <div class="row mb-7">
                                                                <div class="fv-row col-md-4 mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fw-semibold fs-6 mb-2">Title</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <select name="prefix" id="prefix" data-control="select2" data-placeholder="Select a Title..." class="form-select form-select-solid">
                                                                        <option value="">Select Title</option>
                                                                        <?php foreach (Settings()->get_name_prefix_list() as $prefix_result) { ?>
                                                                            <option <?php echo ($selected_advisor_data->prefix ==  $prefix_result) ? 'selected' : '';  ?> value="<?php echo $prefix_result; ?>"><?php echo $prefix_result; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                    <!--end::Input-->
                                                                </div>
                                                                <div class="fv-row col-md-8 mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fw-semibold fs-6 mb-2">Preferred Name</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text" name="preferred_name" id="preferred_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Preferred Name" value="<?php echo $selected_advisor_data->preferred_name; ?>" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <div class="col-md-4 fv-row">
                                                                    <!--begin::Label-->
                                                                    <label class="required fw-semibold fs-6 mb-2">First Name</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text" name="first_name" id="first_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="First Name" value="<?php echo $selected_advisor_data->first_name; ?>" required />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <div class="col-md-4 fv-row">
                                                                    <div class="middle_name_field" style="display: <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, "no_middle_name")) ? 'none' : ''; ?>;">
                                                                        <!--begin::Label-->
                                                                        <label class="fw-semibold fs-6 mb-2">Middle Name</label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="middle_name" id="middle_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Middle Name" value="<?php echo $selected_advisor_data->middle_name; ?>" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <label class="form-check form-check-custom form-check-solid no_middle_name_checkbox <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, "no_middle_name")) ? 'mt-8' : 'mt-3'; ?>">
                                                                        <input class="form-check-input" type="checkbox" name="no_middle_name" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, "no_middle_name")) ? 'checked' : ''; ?>>
                                                                        <span class="form-check-label text-gray-600">
                                                                            No Middle Name
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-4 fv-row">
                                                                    <!--begin::Label-->
                                                                    <label class="required fw-semibold fs-6 mb-2">Last Name</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text" name="last_name" id="last_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Last Name" value="<?php echo $selected_advisor_data->last_name; ?>" required />
                                                                    <!--end::Input-->
                                                                </div>

                                                            </div>
                                                            <div class="row mb-7">
                                                                <div class="fv-row col-md-4 mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fw-semibold fs-6 mb-2">License #</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text" name="license_no" id="license_no" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="License No" value="<?php echo $selected_advisor_data->license_no; ?>" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <div class="fv-row col-md-4 mb-7">
                                                                    <!--begin::Label-->
                                                                    <label class="fw-semibold fs-6 mb-2">NPN #</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text" name="npn_no" id="npn_no" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="NPN No" value="<?php echo $selected_advisor_data->npn_no; ?>" />
                                                                    <!--end::Input-->
                                                                </div>
                                                                <div class="col-md-4 fv-row">
                                                                    <!--begin::Label-->
                                                                    <label class="fw-semibold fs-6 mb-2">Company Name</label>
                                                                    <!--end::Label-->
                                                                    <!--begin::Input-->
                                                                    <input type="text" name="company_name" id="company_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Company Name" value="<?php echo $selected_advisor_data->company_name; ?>" />
                                                                    <!--end::Input-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--begin::Input group-->
                                                    </div>
                                                    <!--end::Input group-->

                                                    <div class="row mb-7">
                                                        <div class="col-md-3 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">Birthdate</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="birth_date" id="birth_date" class="flatpickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="mm/dd/yyyy" value="<?php echo $birth_date; ?>" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <div class="col-md-3 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">Gender</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="gender" id="gender" data-control="select2" data-placeholder="Select a Gender..." class="form-select form-select-solid is_empty">
                                                                <option value="">Select Gender</option>
                                                                <?php foreach (Settings()->get_gender_type_list() as $gender_result) { ?>
                                                                    <option <?php echo ($selected_advisor_data->gender ==  $gender_result) ? 'selected' : '';  ?> value="<?php echo $gender_result; ?>"><?php echo $gender_result; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <div class="col-md-3 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">Status</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="advisor_status" id="advisor_status" data-control="select2" data-placeholder="Select a Status..." class="form-select form-select-solid is_empty">
                                                                <option value="">Select Status</option>
                                                                <?php foreach (Settings()->get_advisor_status_list() as $key => $advisor_status_result) { ?>
                                                                    <option <?php echo ($selected_advisor_data->advisor_status ==  $key) ? 'selected' : '';  ?> value="<?php echo $key; ?>"><?php echo $advisor_status_result; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <div class="col-md-3 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">City</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="city" id="city" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="City" value="<?php echo $selected_advisor_data->city; ?>" />
                                                            <!--end::Input-->
                                                        </div>
                                                    </div>
                                                    <div class="row mb-7">

                                                        <div class="col-md-3 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">State</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="state" id="state" data-control="select2" data-placeholder="Select a State..." class="form-select form-select-solid is_empty">
                                                                <option value="">Select State</option>
                                                                <?php foreach ($get_state_list as $state_result) { ?>
                                                                    <option <?php echo ($selected_advisor_data->state ==  $state_result) ? 'selected' : '';  ?> value="<?php echo $state_result; ?>"><?php echo $state_result; ?></option>
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
                                                                    <option <?php echo (in_array($license_type_result->id, $type_of_licenses)) ? 'selected' : ''; ?> value="<?php echo $license_type_result->id; ?>"><?php echo $license_type_result->type; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <div class="col-md-3 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">Marital Status</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="marital_status" id="marital_status" data-control="select2" data-placeholder="Select a Status..." class="form-select form-select-solid is_empty">
                                                                <option value="">Select Status</option>
                                                                <option <?php echo ($selected_advisor_data->marital_status == 'Married') ? 'selected' : ''; ?> value="Married">Married</option>
                                                                <option <?php echo ($selected_advisor_data->marital_status == 'Unmarried') ? 'selected' : ''; ?> value="Unmarried">Unmarried</option>
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
                                                            <input type="text" name="anniversary_date" id="anniversary_date" class="flatpickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="mm/dd/YYYY" value="<?php echo $anniversary_date; ?>" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <div class="col-md-3 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">Spouses Name</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="spouses_name" id="spouses_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Spouses Name" value="<?php echo Advisor()->get_advisor_meta($selected_advisor_data->id, "spouses_name"); ?>" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <div class="col-md-3 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">Spouses Birthdate</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="spouses_birthdate" id="spouses_birthdate" class="flatpickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Spouses Birthdate" value="<?php echo $spouses_birthdate; ?>" />
                                                            <!--end::Input-->
                                                        </div>
                                                        <div class="col-md-3 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">How Many Children</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <input type="text" name="total_children" id="total_children" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="How Many Children" value="<?php echo Advisor()->get_advisor_meta($selected_advisor_data->id, "total_children"); ?>" />
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
                                                                    <option <?php echo ($selected_advisor_data->lead_source ==  $lead_source_result->id) ? 'selected' : ''; ?> value="<?php echo $lead_source_result->id; ?>"><?php echo $lead_source_result->type; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <div class="col-md-3 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">Lead Owner</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="lead_owner" id="lead_owner" data-control="select2" data-placeholder="Select a Lead Owner..." class="form-select form-select-solid is_empty">
                                                                <option value="">Select Lead Owner</option>
                                                                <?php foreach (Settings()->get_lead_owner_list() as $lead_owner_result) { ?>
                                                                    <option <?php echo ($selected_advisor_data->lead_owner ==  $lead_owner_result->id) ? 'selected' : ''; ?> value="<?php echo $lead_owner_result->id; ?>"><?php echo $lead_owner_result->name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <div class="col-md-3 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">Rating</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="rating" id="rating" data-control="select2" data-placeholder="Select a Rate..." class="form-select form-select-solid is_empty">
                                                                <option value="">Select rating</option>
                                                                <option <?php echo ($selected_advisor_data->rating == 1) ? 'selected' : ''; ?> value="1">1</option>
                                                                <option <?php echo ($selected_advisor_data->rating == 2) ? 'selected' : ''; ?> value="2">2</option>
                                                                <option <?php echo ($selected_advisor_data->rating == 3) ? 'selected' : ''; ?> value="3">3</option>
                                                                <option <?php echo ($selected_advisor_data->rating == 4) ? 'selected' : ''; ?> value="4">4</option>
                                                                <option <?php echo ($selected_advisor_data->rating == 5) ? 'selected' : ''; ?> value="5">5</option>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                    </div>

                                                    <div class="row mt-7">
                                                        <div class="mb-0">
                                                            <button type="submit" name="save_step" class="btn btn-primary" id="">

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
                                                </div>

                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Step 1-->
                                            <!--begin::Step 2-->
                                            <div data-kt-stepper-element="content">
                                                <!--begin::Wrapper-->
                                                <div class="mx-auto w-100">
                                                    <div class="pb-5 pb-lg-8">
                                                        <!--begin::Title-->
                                                        <h2 class="fw-bold text-gray-900">Contact Info
                                                        </h2>
                                                        <!--end::Title-->
                                                        <!--begin::Notice-->
                                                        <div class="text-muted fw-semibold fs-6">Additional Contact Info
                                                        </div>
                                                        <!--end::Notice-->
                                                    </div>
                                                    <!--begin::Repeater-->
                                                    <div id="">
                                                        <!--begin::Form group-->
                                                        <div class="form-group mb-10">
                                                            <div data-repeater-list="kt_docs_repeater_basic">
                                                                <div data-repeater-item>
                                                                    <div class="form-group row">
                                                                        <div class="col-md-12 mb-2">
                                                                            <h4>Primary Phone Number</h4>
                                                                        </div>
                                                                        <?php /*
                                                                            <div class="col-md-2">
                                                                                <label class="required form-label">Type</label>
                                                                                <select name="contact_type" data-control="select2" data-placeholder="Select a type..." class="form-select form-select-solid is_empty" required>
                                                                                    <option value="">Select Type</option>
                                                                                    <?php foreach (Settings()->get_contact_type_list() as $contact_type_result) { ?>
                                                                                        <option <?php echo ($selected_advisor_data->contact_type ==  $contact_type_result) ? 'selected' : ''; ?> value="<?php echo $contact_type_result; ?>"><?php echo $contact_type_result; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                            */ ?>
                                                                        <div class="col-md-4">
                                                                            <label class="form-label">Phone Number</label>
                                                                            <input type="text" name="mobile_no" class="form-control mb-2 mb-md-0 " placeholder="Enter Phone Number" value="<?php echo $selected_advisor_data->mobile_no;  ?>" />
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label class="required form-label">Email Address</label>
                                                                            <input type="email" name="email" class="form-control mb-2 mb-md-0 " placeholder="Enter Email Address" value="<?php echo $selected_advisor_data->email; ?>" required />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--end::Form group-->

                                                        <!--begin::Form group-->
                                                        <div id="contact_info_multi_row" style="display: block">
                                                            <div class="mb-2 ">
                                                                <h4>Additional Phone Number</h4>
                                                            </div>
                                                            <div class="extra_contact">
                                                                <?php if (!empty($get_advisor_extra_contact)) {
                                                                    $i = 1;
                                                                    foreach ($get_advisor_extra_contact as $contact_results) { ?>
                                                                        <div class="form-group row mb-5" id="row_id_<?php echo $i; ?>">
                                                                            <?php /* 
                                                                                <div class="col-md-2">
                                                                                    <label class="form-label">Type</label>
                                                                                    <select id="contact_type_1" name="contact_type_1" data-control="select2" data-placeholder="Select a type..." class="form-select form-select-solid is_empty">
                                                                                        <option value="">Select Type</option>
                                                                                        <?php foreach (Settings()->get_contact_type_list() as $contact_type_result) { ?>
                                                                                            <option <?php echo ($contact_results->contact_type ==  $contact_type_result) ? 'selected' : ''; ?> value="<?php echo $contact_type_result; ?>"><?php echo $contact_type_result; ?></option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                                */ ?>
                                                                            <div class="col-md-4">
                                                                                <label class="form-label"> Phone Number</label>
                                                                                <input type="text" name="mobile_no_<?php echo $i; ?>" class="form-control mb-2 mb-md-0" placeholder="Enter  Phone Number" value="<?php echo $contact_results->mobile_no; ?>" />
                                                                            </div>
                                                                            <div class="col-md-4">
                                                                                <label class="form-label"> Email Address</label>
                                                                                <input type="email" name="email_<?php echo $i; ?>" class="form-control mb-2 mb-md-0" placeholder="Enter Email Address" value="<?php echo $contact_results->email; ?>" />
                                                                            </div>

                                                                            <div class="col-md-2">
                                                                                <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8 remove_row" id="<?php echo $i; ?>">
                                                                                    <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                                                                    Delete
                                                                                </a>
                                                                            </div>
                                                                            <input type="hidden" name="contact_info_row_list[]" id="contact_info_row_list" class="contact_info_row_list" value="<?php echo $i; ?>">
                                                                            <input type="hidden" name="contact_id_<?php echo $i; ?>" id="contact_id_<?php echo $i; ?>" class="" value="<?php echo $contact_results->id; ?>">
                                                                        </div>
                                                                    <?php $i++;
                                                                    }
                                                                } else { ?>
                                                                    <div class="form-group row mb-5" id="row_id_1">
                                                                        <?php /* 
                                                                            <div class="col-md-2">
                                                                                <label class="form-label">Type</label>
                                                                                <select id="contact_type_1" name="contact_type_1" data-control="select2" data-placeholder="Select a type..." class="form-select form-select-solid is_empty">
                                                                                    <option value="">Select Type</option>
                                                                                    <?php foreach (Settings()->get_contact_type_list() as $contact_type_result) { ?>
                                                                                        <option value="<?php echo $contact_type_result; ?>"><?php echo $contact_type_result; ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                            */ ?>
                                                                        <div class="col-md-4">
                                                                            <label class="form-label"> Phone Number</label>
                                                                            <input type="text" name="mobile_no_1" class="form-control mb-2 mb-md-0" placeholder="Enter Phone Number" />
                                                                        </div>
                                                                        <div class="col-md-4">
                                                                            <label class="form-label"> Email Address</label>
                                                                            <input type="email" name="email_1" class="form-control mb-2 mb-md-0" placeholder="Enter Email Address" />
                                                                        </div>

                                                                        <div class="col-md-2">
                                                                            <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger mt-3 mt-md-8 remove_row" id="1">
                                                                                <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                                                                                Delete
                                                                            </a>
                                                                        </div>
                                                                        <input type="hidden" name="contact_info_row_list[]" id="contact_info_row_list" class="contact_info_row_list" value="1">
                                                                    </div>
                                                                <?php } ?>
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
                                                    <div class="row mt-7">
                                                        <div class="mb-0">
                                                            <button type="submit" name="save_step" class="btn btn-primary" id="">

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
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Step 2-->
                                            <!--begin::Step 3-->
                                            <div data-kt-stepper-element="content">
                                                <!--begin::Wrapper-->
                                                <div class="w-100">
                                                    <div class="pb-5 pb-lg-8">
                                                        <!--begin::Title-->
                                                        <h2 class="fw-bold text-gray-900">Des/Aff</h2>
                                                        <!--end::Title-->
                                                        <!--begin::Notice-->
                                                        <div class="text-muted fw-semibold fs-6"></div>
                                                        <!--end::Notice-->
                                                    </div>
                                                    <div class="row mb-7">
                                                        <div class="col-md-6 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">Professional Designations</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="designation" id="designation" data-control="select2" data-placeholder="Select a Designation..." class="form-select form-select-solid is_empty">
                                                                <option value="">Select Designation</option>
                                                                <?php foreach ($get_designation_list as $designation_result) { ?>
                                                                    <option <?php echo ($selected_advisor_data->designation == $designation_result->id) ? 'selected' : ''; ?> value="<?php echo $designation_result->id; ?>"><?php echo $designation_result->initials . ' - ' . $designation_result->name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <div class="col-md-6 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">Affiliations</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="affiliations" id="affiliations" data-control="select2" data-placeholder="Select a Affiliations..." class="form-select form-select-solid is_empty">
                                                                <option value="">Select Affiliation</option>
                                                                <?php foreach ($get_affiliations_list as $affiliation_result) { ?>
                                                                    <option <?php echo ($selected_advisor_data->affiliations == $affiliation_result->id) ? 'selected' : ''; ?> value="<?php echo $affiliation_result->id; ?>"><?php echo $affiliation_result->type; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <div class="col-md-12 fv-row mt-5">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">Please describe:</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <textarea name="organization" id="organization" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Are you active within the leadership of any of these organizations, locally or nationally?" /><?php echo Advisor()->get_advisor_meta($selected_advisor_data->id, "organization"); ?></textarea>
                                                            <em>Are you active within the leadership of any of these organizations, locally or nationally? </em>
                                                            <!--end::Input-->
                                                        </div>
                                                    </div>
                                                    <div class="row mt-7">
                                                        <div class="mb-0">
                                                            <button type="submit" name="save_step" class="btn btn-primary" id="">

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
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Step 3-->
                                            <!--begin::Step 4-->
                                            <div data-kt-stepper-element="content">
                                                <!--begin::Wrapper-->
                                                <div class="w-100">
                                                    <div class="pb-5 pb-lg-8">
                                                        <!--begin::Title-->
                                                        <h2 class="fw-bold text-gray-900">Carrier Info </h2>
                                                        <!--end::Title-->
                                                        <!--begin::Notice-->
                                                        <div class="text-muted fw-semibold fs-6"></div>
                                                        <!--end::Notice-->
                                                    </div>
                                                    <div class="row mb-7">
                                                        <div class="col-md-6 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">How many carriers are you currently appointed with? </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="carrier_appointed" id="carrier_appointed" data-control="select2" data-placeholder="Select a Carriers..." class="form-select form-select-solid is_empty">
                                                                <option value="">Select Appointed</option>
                                                                <?php foreach ($get_carrier_appointed_list as $carrier_appointed_result) { ?>
                                                                    <option <?php echo ($selected_advisor_data->carrier_appointed == $carrier_appointed_result->id) ? 'selected' : ''; ?> value="<?php echo $carrier_appointed_result->id; ?>"><?php echo $carrier_appointed_result->type; ?></option>
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
                                                                    <option <?php echo (in_array($carrier_result->id, $carrier_with_business)) ? 'selected' : ''; ?> value="<?php echo $carrier_result->id; ?>"><?php echo $carrier_result->name; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                    </div>
                                                    <div class="row mt-7">
                                                        <div class="mb-0">
                                                            <button type="submit" name="save_step" class="btn btn-primary" id="">

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
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Step 4-->
                                            <!--begin::Step 5-->
                                            <div data-kt-stepper-element="content">
                                                <!--begin::Wrapper-->
                                                <div class="w-100">
                                                    <div class="pb-5 pb-lg-8">
                                                        <!--begin::Title-->
                                                        <h2 class="fw-bold text-gray-900"> Production Info
                                                        </h2>
                                                        <!--end::Title-->
                                                        <!--begin::Notice-->
                                                        <div class="text-muted fw-semibold fs-6"></div>
                                                        <!--end::Notice-->
                                                    </div>
                                                    <div class="row mb-7">
                                                        <div class="col-md-4 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">Premium Volume </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="premium_volume" id="premium_volume" data-control="select2" data-placeholder="Select a Premium Volume..." class="form-select form-select-solid is_empty">
                                                                <option value="">Select Volume</option>
                                                                <?php foreach ($get_premium_volume_list as $premium_volume_result) { ?>
                                                                    <option <?php echo ($selected_advisor_data->premium_volume == $premium_volume_result->id) ? 'selected' : ''; ?> value="<?php echo $premium_volume_result->id; ?>"><?php echo $premium_volume_result->type; ?></option>
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
                                                                    <option <?php echo (in_array($production_percentage_result->id, $production_percentages)) ? 'selected' : ''; ?> value="<?php echo $production_percentage_result->id; ?>"><?php echo $production_percentage_result->type; ?></option>
                                                                <?php } ?>
                                                            </select>
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
                                                                    <option <?php echo (in_array($market_result->id, $markets)) ? 'selected' : ''; ?> value="<?php echo $market_result->id; ?>"><?php echo $market_result->type; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                    </div>
                                                    <div class="row mt-7">
                                                        <div class="mb-0">
                                                            <button type="submit" name="save_step" class="btn btn-primary" id="">

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
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Step 5-->
                                            <!--begin::Step 6-->
                                            <div data-kt-stepper-element="content">
                                                <!--begin::Wrapper-->
                                                <div class="w-100">
                                                    <div class="pb-5 pb-lg-8">
                                                        <!--begin::Title-->
                                                        <h2 class="fw-bold text-gray-900"> Interests
                                                        </h2>
                                                        <!--end::Title-->
                                                        <!--begin::Notice-->
                                                        <div class="text-muted fw-semibold fs-6">What is the agent's current interest in selling in the industry?
                                                        </div>
                                                        <!--end::Notice-->
                                                    </div>

                                                    <div class="row mb-7">
                                                        <div class="col-md-3 fv-row">
                                                            <h3 class="m-0 text-gray-900 flex-grow-1 mb-6">
                                                                Life Insurance
                                                            </h3>
                                                            <?php
                                                            foreach ($get_interest_life_insurance_list as $key => $life_insurance_result) {

                                                            ?>
                                                                <div class=" fv-row">
                                                                    <!--begin::Option-->
                                                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                                                        <!--begin::Input-->
                                                                        <input class="form-check-input me-3" type="checkbox" name="life_insurance[]" value="<?php echo $key; ?>" <?php echo (in_array($key, $selected_life_insurance)) ? 'checked' : ''; ?> />
                                                                        <!--end::Input-->
                                                                        <!--begin::Label-->
                                                                        <span class="form-label d-flex flex-column align-items-start">
                                                                            <span class="fw-bold fs-5 mb-0"><?php echo $life_insurance_result; ?></span>
                                                                        </span>
                                                                        <!--end::Label-->
                                                                    </label>
                                                                    <!--end::Option-->
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-md-3 fv-row">
                                                            <h3 class="m-0 text-gray-900 flex-grow-1 mb-6">
                                                                Annuities
                                                            </h3>
                                                            <?php
                                                            foreach ($get_interest_annuities_list as $key => $annuities_result) { ?>
                                                                <div class="fv-row">
                                                                    <!--begin::Option-->
                                                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                                                        <!--begin::Input-->
                                                                        <input class="form-check-input me-3" type="checkbox" name="annuities[]" value="<?php echo $key; ?>" <?php echo (in_array($key, $selected_annuities)) ? 'checked' : ''; ?>>
                                                                        <!--end::Input-->
                                                                        <!--begin::Label-->
                                                                        <span class=" form-label d-flex flex-column align-items-start">
                                                                            <span class="fw-bold fs-5 mb-0"><?php echo $annuities_result; ?></span>
                                                                        </span>
                                                                        <!--end::Label-->
                                                                    </label>
                                                                    <!--end::Option-->
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-md-3 fv-row">
                                                            <h3 class="m-0 text-gray-900 flex-grow-1 mb-6">
                                                                Long-Term Care Insurance
                                                            </h3>
                                                            <?php
                                                            foreach ($get_interest_long_term_care_insurance_list as $key => $long_term_care_result) { ?>
                                                                <div class="fv-row">
                                                                    <!--begin::Option-->
                                                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                                                        <!--begin::Input-->
                                                                        <input class="form-check-input me-3" type="checkbox" name="long_term_care_insurance[]" value="<?php echo $key; ?>" <?php echo (in_array($key, $selected_long_term_care_insurance)) ? 'checked' : ''; ?> />
                                                                        <!--end::Input-->
                                                                        <!--begin::Label-->
                                                                        <span class="form-label d-flex flex-column align-items-start">
                                                                            <span class="fw-bold fs-5 mb-0"><?php echo $long_term_care_result; ?></span>
                                                                        </span>
                                                                        <!--end::Label-->
                                                                    </label>
                                                                    <!--end::Option-->
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="col-md-3 fv-row">
                                                            <h3 class="m-0 text-gray-900 flex-grow-1 mb-6">
                                                                Critical Illness
                                                            </h3>
                                                            <?php
                                                            foreach ($get_interest_critical_illness_list as $key => $critical_illness_result) { ?>
                                                                <div class="fv-row">
                                                                    <!--begin::Option-->
                                                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                                                        <!--begin::Input-->
                                                                        <input class="form-check-input me-3" type="checkbox" name="critical_illness[]" value="<?php echo $key; ?>" <?php echo (in_array($key, $selected_critical_illness)) ? 'checked' : ''; ?> />
                                                                        <!--end::Input-->
                                                                        <!--begin::Label-->
                                                                        <span class="form-label d-flex flex-column align-items-start">
                                                                            <span class="fw-bold fs-5 mb-0"><?php echo $critical_illness_result; ?></span>
                                                                        </span>
                                                                        <!--end::Label-->
                                                                    </label>
                                                                    <!--end::Option-->
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-7">
                                                        <!--begin::Input wrapper-->
                                                        <div class="col-md-6 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">Disability Income</label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="disability_income" id="disability_income_edit" data-control="select2" data-placeholder="Select a Disability Income..." class="form-select form-select-solid is_empty">
                                                                <option value="">Select Disability Income</option>
                                                                <?php foreach ($get_interest_disability_income_list as $key => $disability_income_result) { ?>
                                                                    <option <?php echo ($get_selected_advisor_interest && ($key == $get_selected_advisor_interest->disability_income)) ? 'selected' : ''; ?> value="<?php echo $key; ?>"><?php echo $disability_income_result; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input wrapper-->
                                                        <!--begin::Input wrapper-->
                                                        <div class="col-md-6 fv-row">
                                                            <!--begin::Label-->
                                                            <label class="fw-semibold fs-6 mb-2">Group Insurance </label>
                                                            <!--end::Label-->
                                                            <!--begin::Input-->
                                                            <select name="group_insurance" id="group_insurance_edit" data-control="select2" data-placeholder="Select a Group Insurance ..." class="form-select form-select-solid is_empty">
                                                                <option value="">Select Group Insurance </option>
                                                                <?php foreach ($get_interest_group_insurance_list as $key => $group_insurance_result) { ?>
                                                                    <option <?php echo ($get_selected_advisor_interest && ($key == $get_selected_advisor_interest->group_insurance)) ? 'selected' : ''; ?> value="<?php echo $key; ?>"><?php echo $group_insurance_result; ?></option>
                                                                <?php } ?>
                                                            </select>
                                                            <!--end::Input-->
                                                        </div>
                                                        <!--end::Input wrapper-->
                                                    </div>
                                                    <div class="row mt-7">
                                                        <div class="mb-0">
                                                            <button type="submit" name="save_step" class="btn btn-primary" id="">

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
                                                </div>
                                                <!--end::Wrapper-->
                                            </div>
                                            <!--end::Step 6-->
                                            <!--begin::Step 7-->
                                            <div data-kt-stepper-element="content">
                                                <!--begin::Wrapper-->
                                                <div class="w-100">
                                                    <div class="pb-5 pb-lg-8">
                                                        <!--begin::Title-->
                                                        <h2 class="fw-bold text-gray-900"> Social Links
                                                        </h2>
                                                        <!--end::Title-->
                                                        <!--begin::Notice-->
                                                        <div class="text-muted fw-semibold fs-6">
                                                        </div>
                                                        <!--end::Notice-->
                                                    </div>
                                                    <!--begin::Card body-->
                                                    <div class="pt-0">
                                                        <div class="row mb-4">
                                                            <div class="col-md-6 fv-row">
                                                                <div class="input-group mb-5">
                                                                    <span class="input-group-text" id="basic-addon1">
                                                                        <i class="bi bi-instagram fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                                    </span>
                                                                    <input type="url" class="form-control" name="instagram_url" id="instagram_url" placeholder="Instagram URL" aria-label="Instagram URL" aria-describedby="basic-addon1" value="<?php echo Advisor()->get_advisor_meta($selected_advisor_data->id, "instagram_url"); ?>" />
                                                                </div>
                                                            </div>
                                                            <!--begin::Input wrapper-->
                                                            <div class="col-md-6 fv-row">
                                                                <div class="input-group mb-5">
                                                                    <span class="input-group-text" id="basic-addon1">
                                                                        <i class="bi bi-facebook fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                                    </span>
                                                                    <input type="url" class="form-control" name="facebook_url" id="facebook_url" placeholder="Facebok URL" aria-label="Facebok URL" aria-describedby="basic-addon1" value="<?php echo Advisor()->get_advisor_meta($selected_advisor_data->id, "facebook_url"); ?>" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row mb-4">
                                                            <div class="col-md-6 fv-row">
                                                                <div class="input-group mb-5">
                                                                    <span class="input-group-text" id="basic-addon1">
                                                                        <i class="bi bi-linkedin fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                                    </span>
                                                                    <input type="url" class="form-control" name="linkedin_url" id="linkedin_url" placeholder="LinkedIn URL" aria-label="LinkedIn URL" aria-describedby="basic-addon1" value="<?php echo Advisor()->get_advisor_meta($selected_advisor_data->id, "linkedin_url"); ?>" />
                                                                </div>
                                                                <!--begin::Input-->
                                                            </div>
                                                            <!--end::Input wrapper-->
                                                            <!--begin::Input wrapper-->
                                                            <div class="col-md-6 fv-row">
                                                                <div class="input-group mb-5">
                                                                    <span class="input-group-text" id="basic-addon1">
                                                                        <i class="bi bi-youtube fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                                    </span>
                                                                    <input type="url" class="form-control" name="youtube_url" id="youtube_url" placeholder="Youtube URL" aria-label="Youtube URL" aria-describedby="basic-addon1" value="<?php echo Advisor()->get_advisor_meta($selected_advisor_data->id, "youtube_url"); ?>" />
                                                                </div>
                                                            </div>
                                                            <!--end::Input wrapper-->
                                                        </div>
                                                        <div class="row mb-4">
                                                            <!--begin::Input wrapper-->
                                                            <div class="col-md-6 fv-row">
                                                                <div class="input-group mb-5">
                                                                    <span class="input-group-text" id="basic-addon1">
                                                                        <i class="bi bi-twitter fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                                    </span>
                                                                    <input type="url" class="form-control" name="twitter_url" id="twitter_url" placeholder="Twitter URL" aria-label="Twitter URL" aria-describedby="basic-addon1" value="<?php echo Advisor()->get_advisor_meta($selected_advisor_data->id, "twitter_url"); ?>" />
                                                                </div>
                                                            </div>
                                                            <!--end::Input wrapper-->
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--begin::Wrapper-->
                                            </div>
                                            <!--end::Step 7-->
                                            <!--begin::Actions-->
                                            <div class="d-flex flex-stack pt-10">
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
                                    <!--end::Content-->
                                </div>
                                <!--end::Stepper-->
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
    <!--<script src="<?php echo site_url(); ?>/assets/js/custom/utilities/modals/create-account.js"></script>-->
    <script type="text/javascript" src="<?php echo SITE_URL; ?>/assets/js/underscore.min.js"></script>
    <script type="text/javascript" src="<?php echo SITE_URL; ?>/assets/js/wp-util.js"></script>
    <!--end::Vendors Javascript-->
    <!--end::Javascript-->

    <script type="text/html" id="tmpl-contact-info-row-list">
        <div class="form-group row mb-5" id="row_id_{{{data.index}}}">
            <!--<div class="col-md-2">
                <label class="form-label">Type</label>
                <select id="contact_type_{{{data.index}}}" name="contact_type_{{{data.index}}}" data-control="select2" data-placeholder="Select a type..." class="form-select form-select-solid is_empty">
                    <option value="">Select Type</option>
                    <?php foreach (Settings()->get_contact_type_list() as $contact_type_result) { ?>
                        <option value="<?php echo $contact_type_result; ?>"><?php echo $contact_type_result; ?></option>
                    <?php } ?>
                </select>
            </div>-->

            <div class="col-md-4">
                <label class="form-label">Phone Number</label>
                <input type="text" name="mobile_no_{{{data.index}}}" class="form-control mb-2 mb-md-0" placeholder="Enter Phone Number" />
            </div>
            <div class="col-md-4">
                <label class="form-label">Email Address</label>
                <input type="email" name="email_{{{data.index}}}" class="form-control mb-2 mb-md-0" placeholder="Enter Email Address" />
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
            console.log("inside");
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
                $(".no_middle_name_checkbox").addClass("mt-3");
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