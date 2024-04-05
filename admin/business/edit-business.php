<?php require '../../config.php';
$page_name = 'business';
$sub_page_name = 'business-list';
Admin()->check_login();

if (isset($_POST['save_business'])) {

    if (!empty(sipost('business_id'))) {
        $response = Business()->update_business();
    } else {

        $response = Business()->add_business();
    }

    if ($response == 1) {
        $_SESSION['process_success'] = true;
    } elseif ($response == 'duplicate') {
        $_SESSION['process_duplicate'] = true;
    } else {
        $_SESSION['process_fail'] = true;
    }

    wp_redirect(site_url() . '/admin/business/business-list');
    exit;
}

$get_state_list = Settings()->get_state_list(); ?>

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
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Business</h1>
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
                                            <h4 class="mb-1 text-success">The business has been save successfully.</h4>
                                        </div>
                                    </div>
                                <?php }

                                if (isset($_SESSION['process_duplicate'])) {
                                    unset($_SESSION['process_duplicate']); ?>
                                    <div class="alert alert-danger d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-danger">The business has been already exist.</h4>
                                        </div>
                                    </div>
                                <?php }

                                if (isset($_SESSION['process_fail'])) {
                                    unset($_SESSION['process_fail']); ?>
                                    <div class="alert alert-danger d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-danger">The business has been save failed.</h4>
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
                                                <div class="stepper-item current" data-kt-stepper-element="nav">
                                                    <h3 class="stepper-title">Current Employment</h3>
                                                </div>
                                                <!--end::Step 1-->
                                                <!--begin::Step 2-->
                                                <div class="stepper-item" data-kt-stepper-element="nav">
                                                    <h3 class="stepper-title">Historic Employment</h3>
                                                </div>
                                                <!--end::Step 2-->
                                            </div>
                                            <!--end::Nav-->
                                            <!--begin::Form-->
                                            <form class=" w-100 pt-15 pb-10" novalidate="novalidate" id="kt_create_account_form" method="post" enctype="multipart/form-data">
                                                <!--begin::Step 1-->
                                                <div class="current" data-kt-stepper-element="content">
                                                    <!--begin::Wrapper-->
                                                    <div class="w-100">
                                                        <!--begin::Input group-->
                                                        <div class="row mb-7">
                                                            <div class="col-md-4 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Employment Status</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="employe_status" id="employment_status" data-control="select2" data-placeholder="Select a Employment Status..." class="form-select form-select-solid" required>
                                                                    <option value="">Select Title</option>
                                                                    <option value="Employed">Employed</option>
                                                                </select>
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-4 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Employment Name</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="employment_name" id="employment_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Employment Name" required />
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-4 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Company Name</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="company_name" id="company_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Employment Name" required />
                                                                <!--end::Input-->
                                                            </div>
                                                        </div>
                                                        <div class="row mb-7">
                                                            <div class="col-md-2 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Start Date</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="start_date" id="start_date" class="flatpickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Start Date" required />
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-2 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">End Date</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="end_date" id="end_date" class="flatpickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="End Date" required />
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-4 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Company Street Address</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="company_address" id="company_address" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Company Street Address" required />
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-4 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Apartment, suite, unit, building, floor, etc.</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="building" id="building" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Apartment, suite, unit, building, floor, etc." required />
                                                                <!--end::Input-->
                                                            </div>
                                                        </div>
                                                        <div class="row mb-7">
                                                            <div class="col-md-2 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">City</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="city" id="city" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="City" required />
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-2 fv-row">
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
                                                            <div class="col-md-2 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="required fw-semibold fs-6 mb-2">Zipcode</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" name="zipcode" id="zipcode" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Zipcode" required />
                                                                <!--end::Input-->
                                                            </div>
                                                        </div>
                                                        <div class="row mb-7">
                                                            <div class="col-md-6 fv-row">
                                                                <!--begin::Label-->
                                                                <label class="fw-semibold fs-6 mb-2">Types of Business</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <select name="type_of_business[]" id="type_of_business" class="form-select  form-select-solid" data-control="select2" data-close-on-select="true" data-placeholder="Select a Type of Business" data-allow-clear="true">
                                                                    <option value="">Select a Business</option>
                                                                    <option value="RIA">RIA</option>
                                                                    <option value="BD">BD</option>
                                                                    <option value="GA">GA</option>
                                                                    <option value="MGA">MGA</option>
                                                                    <option value="PPGA">PPGA</option>
                                                                </select>
                                                                <!--end::Input-->
                                                            </div>
                                                            <div class="col-md-6 fv-row">
                                                                <!--begin::Label-->
                                                                <label class=" fw-semibold fs-6 mb-2">What type of back office supports your company? </label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->

                                                                <div class="d-flex">
                                                                    <label class="form-check form-check-custom form-check-solid mt-3 office_support me-10">
                                                                        <input class="form-check-input" type="checkbox" name="office_support">
                                                                        <span class="form-check-label  text-gray-800">
                                                                            I have a full back office
                                                                        </span>
                                                                    </label>
                                                                    <label class="form-check form-check-custom form-check-solid mt-3 office_support">
                                                                        <input class="form-check-input" type="checkbox" name="office_support">
                                                                        <span class="form-check-label text-gray-800">
                                                                            I do not have a full back office
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                                <!--end::Input-->
                                                            </div>

                                                        </div>
                                                        <div class="row">
                                                            <!--end::Wrapper-->
                                                            <div class="card card-flush">
                                                                <!--begin::Card header-->
                                                                <div class="card-header">
                                                                    <div class="card-title">
                                                                        <h2>Assistant Contact Information</h2>
                                                                    </div>
                                                                </div>
                                                                <!--end::Card header-->

                                                                <!--begin::Card body-->
                                                                <div class="card-body pt-0">
                                                                    <!--begin::Input group-->
                                                                    <div class="row mb-4 mb-7">
                                                                        <!--begin::Input wrapper-->
                                                                        <div class="col-md-4 fv-row">
                                                                            <!--begin::Label-->
                                                                            <label class="fw-semibold fs-6 mb-2">Name</label>
                                                                            <!--end::Label-->
                                                                            <!--begin::Input-->
                                                                            <input type="text" name="assistant_name" id="assistant_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Name" />
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <!--end::Input wrapper-->
                                                                        <!--begin::Input wrapper-->
                                                                        <div class="col-md-4 fv-row">
                                                                            <!--begin::Label-->
                                                                            <label class="fw-semibold fs-6 mb-2">Phone</label>
                                                                            <!--end::Label-->
                                                                            <!--begin::Input-->
                                                                            <input type="text" name="assistant_phone" id="assistant_phone" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Phone" />
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <!--end::Input wrapper-->
                                                                        <!--begin::Input wrapper-->
                                                                        <div class="col-md-4 fv-row">
                                                                            <!--begin::Label-->
                                                                            <label class="fw-semibold fs-6 mb-2">Email</label>
                                                                            <!--end::Label-->
                                                                            <!--begin::Input-->
                                                                            <input type="text" name="assistant_email" id="assistant_email" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Email" />
                                                                            <!--end::Input-->
                                                                        </div>
                                                                        <!--end::Input wrapper-->
                                                                    </div>

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

                                                    <!--end::Wrapper-->
                                                </div>
                                                <!--end::Step 2-->
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
                                                        <button type="submit" name="save_business" class="btn btn-lg btn-primary me-3" data-kt-stepper-action="submit">
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
                $(".middle_name_field").show();
            }
        });

        // Stepper lement
        var element = document.querySelector("#kt_create_account_stepper");

        // Initialize Stepper
        var stepper = new KTStepper(element);

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