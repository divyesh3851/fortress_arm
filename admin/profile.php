<?php require '../config.php';
$page_name = 'profile';
$sub_page_name = '';
Admin()->check_login();

if (isset($_POST['save_profile'])) {

    $response = Admin()->update_login_admin_profile($_SESSION['fbs_arm_admin_id']);

    if ($response) {
        $_SESSION['process_success'] = true;
        wp_redirect(site_url() . '/admin/profile');
        die();
    }
}

$get_login_admin_info = Admin()->get_login_admin_info($_SESSION['fbs_arm_admin_id']);
$admin_profile_img = Admin()->get_admin_meta($get_login_admin_info->id, 'profile_img');
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
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Profile</h1>
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
                                            <h4 class="mb-1 text-success">The profile has been updated successfully.</h4>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!--begin::Navbar-->
                                <div class="card mb-5 mb-xl-10">
                                    <div class="card-body pt-9 pb-0">
                                        <!--begin::Details-->
                                        <div class="d-flex flex-wrap flex-sm-nowrap">
                                            <!--begin: Pic-->
                                            <div class="me-7 mb-4">
                                                <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                                    <?php if ($admin_profile_img) { ?>
                                                        <img src="<?php echo site_url(); ?>/uploads/admin/<?php echo $admin_profile_img; ?>" alt="profile_image" />
                                                    <?php } else { ?>
                                                        <img src="<?php echo site_url(); ?>/uploads/admin/blank.png" alt="profile_image" />
                                                    <?php } ?>

                                                    <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                                                </div>
                                            </div>
                                            <!--end::Pic-->
                                            <!--begin::Info-->
                                            <div class="flex-grow-1">
                                                <!--begin::Title-->
                                                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                                    <!--begin::User-->
                                                    <div class="d-flex flex-column">
                                                        <!--begin::Name-->
                                                        <div class="d-flex align-items-center mb-2">
                                                            <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1"><?php echo $get_login_admin_info->first_name . ' ' . $get_login_admin_info->last_name; ?></a>
                                                            <a href="#">
                                                                <i class="ki-outline ki-verify fs-1 text-primary"></i>
                                                            </a>
                                                        </div>
                                                        <!--end::Name-->
                                                        <!--begin::Info-->
                                                        <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                                            <a href="mailto:<?php echo $get_login_admin_info->email; ?>" class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                                                <i class="ki-outline ki-sms fs-4"></i>&nbsp;<?php echo $get_login_admin_info->email; ?>
                                                            </a>
                                                            &emsp;
                                                            <a href="tel:<?php echo $get_login_admin_info->mobile_no; ?>" class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                                                <i class="ki-outline ki-sms fs-4"></i>&nbsp;<?php echo $get_login_admin_info->mobile_no; ?>
                                                            </a>
                                                            &emsp;
                                                            <a href="#" class="d-flex align-items-center text-gray-500 text-hover-primary mb-2">
                                                                <i class="ki-outline ki-geolocation fs-4"></i>&nbsp;<?php echo $get_login_admin_info->state; ?>
                                                            </a>
                                                        </div>
                                                        <!--end::Info-->
                                                    </div>
                                                    <!--end::User-->
                                                </div>
                                                <!--end::Title-->
                                                <!--begin::Stats-->
                                                <div class="d-flex flex-wrap flex-stack">
                                                    <!--begin::Wrapper-->
                                                    <div class="d-flex flex-column flex-grow-1 pe-8">
                                                        <!--begin::Stats-->
                                                        <div class="d-flex flex-wrap">
                                                            <!--begin::Stat-->
                                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                                <!--begin::Number-->
                                                                <div class="d-flex align-items-center">
                                                                    <i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i>
                                                                    <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="<?php echo Advisor()->count_total_advisor(); ?>" data-kt-countup-prefix="">0</div>
                                                                </div>
                                                                <!--end::Number-->
                                                                <!--begin::Label-->
                                                                <div class="fw-semibold fs-6 text-gray-500">Advisor</div>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--end::Stat-->
                                                            <!--begin::Stat-->
                                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                                <!--begin::Number-->
                                                                <div class="d-flex align-items-center">
                                                                    <i class="ki-outline ki-arrow-down fs-3 text-danger me-2"></i>
                                                                    <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="<?php echo Advisor()->count_total_verified_advisor(); ?>">0</div>
                                                                </div>
                                                                <!--end::Number-->
                                                                <!--begin::Label-->
                                                                <div class="fw-semibold fs-6 text-gray-500">Total Verified</div>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--end::Stat-->
                                                            <!--begin::Stat-->
                                                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                                                <!--begin::Number-->
                                                                <div class="d-flex align-items-center">
                                                                    <i class="ki-outline ki-arrow-up fs-3 text-success me-2"></i>
                                                                    <div class="fs-2 fw-bold" data-kt-countup="true" data-kt-countup-value="60" data-kt-countup-prefix="">0</div>
                                                                </div>
                                                                <!--end::Number-->
                                                                <!--begin::Label-->
                                                                <div class="fw-semibold fs-6 text-gray-500">Campaign</div>
                                                                <!--end::Label-->
                                                            </div>
                                                            <!--end::Stat-->
                                                        </div>
                                                        <!--end::Stats-->
                                                    </div>
                                                    <!--end::Wrapper-->
                                                    <!--begin::Progress-->
                                                    <div class="d-flex align-items-center w-200px w-sm-300px flex-column mt-3">
                                                        <div class="d-flex justify-content-between w-100 mt-auto mb-2">
                                                            <span class="fw-semibold fs-6 text-gray-500">Profile Compleation</span>
                                                            <span class="fw-bold fs-6">50%</span>
                                                        </div>
                                                        <div class="h-5px mx-3 w-100 bg-light mb-3">
                                                            <div class="bg-success rounded h-5px" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                    <!--end::Progress-->
                                                </div>
                                                <!--end::Stats-->
                                            </div>
                                            <!--end::Info-->
                                        </div>
                                        <!--end::Details-->
                                        <!--begin::Navs-->
                                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                                            <!--begin::Nav item-->
                                            <li class="nav-item mt-2">
                                                <a class="nav-link text-active-primary ms-0 me-10 py-5 <?php echo (siget('tab') == 'overview' || siget('tab') == '') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/profile/overview">Overview</a>
                                            </li>
                                            <!--end::Nav item-->
                                            <!--begin::Nav item-->
                                            <li class="nav-item mt-2">
                                                <a class="nav-link text-active-primary ms-0 me-10 py-5 <?php echo (siget('tab') == 'logs') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/profile/logs">Logs</a>
                                            </li>
                                            <!--end::Nav item-->
                                        </ul>
                                        <!--begin::Navs-->
                                    </div>
                                </div>
                                <!--end::Navbar-->

                                <!--begin::Row-->
                                <?php if (siget('tab') == '' || siget('tab') == 'overview') { ?>
                                    <div class="row gy-5 g-xl-10">
                                        <!--begin::Col-->
                                        <div class="col-xl-4 mb-xl-10">
                                            <!--begin::List widget 9-->
                                            <div class="card card-flush h-xl-100">
                                                <!--begin::Header-->
                                                <div class="card-header py-7">
                                                    <!--begin::Title-->
                                                    <h3 class="card-title align-items-start flex-column">
                                                        <span class="card-label fw-bold text-gray-800">Social Network Visits</span>
                                                        <span class="text-gray-500 mt-1 fw-semibold fs-6">20 social visitors</span>
                                                    </h3>
                                                    <!--end::Title-->
                                                    <!--begin::Toolbar-->
                                                    <div class="card-toolbar">
                                                        <a href="#" class="btn btn-sm btn-light">View All</a>
                                                    </div>
                                                    <!--end::Toolbar-->
                                                </div>
                                                <!--end::Header-->
                                                <!--begin::Body-->
                                                <div class="card-body card-body d-flex justify-content-starts flex-column pt-3">
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Flag-->
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/linkedin-1.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                                        <!--end::Flag-->
                                                        <!--begin::Section-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Linked In</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Media</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">2</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <div class="m-0">
                                                                    <!--begin::Label-->
                                                                    <span class="badge badge-light-danger fs-base">
                                                                        <i class="ki-outline ki-arrow-down fs-5 text-danger ms-n1"></i>0.4%</span>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Section-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Flag-->
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/youtube-3.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                                        <!--end::Flag-->
                                                        <!--begin::Section-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">YouTube</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Video Channel</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">4</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <div class="m-0">
                                                                    <!--begin::Label-->
                                                                    <span class="badge badge-light-success fs-base">
                                                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>4.1%</span>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Section-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Flag-->
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/instagram-2-1.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                                        <!--end::Flag-->
                                                        <!--begin::Section-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Instagram</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Network</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">5</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <div class="m-0">
                                                                    <!--begin::Label-->
                                                                    <span class="badge badge-light-success fs-base">
                                                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>8.3%</span>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Section-->
                                                    </div>
                                                    <!--end::Item-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed my-3"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::Item-->
                                                    <div class="d-flex flex-stack">
                                                        <!--begin::Flag-->
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/brand-logos/facebook-3.svg" class="me-4 w-30px" style="border-radius: 4px" alt="" />
                                                        <!--end::Flag-->
                                                        <!--begin::Section-->
                                                        <div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                                                            <!--begin::Content-->
                                                            <div class="me-5">
                                                                <!--begin::Title-->
                                                                <a href="#" class="text-gray-800 fw-bold text-hover-primary fs-6">Facebook</a>
                                                                <!--end::Title-->
                                                                <!--begin::Desc-->
                                                                <span class="text-gray-500 fw-semibold fs-7 d-block text-start ps-0">Social Network</span>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--end::Content-->
                                                            <!--begin::Wrapper-->
                                                            <div class="d-flex align-items-center">
                                                                <!--begin::Number-->
                                                                <span class="text-gray-800 fw-bold fs-4 me-3">6</span>
                                                                <!--end::Number-->
                                                                <!--begin::Info-->
                                                                <div class="m-0">
                                                                    <!--begin::Label-->
                                                                    <span class="badge badge-light-success fs-base">
                                                                        <i class="ki-outline ki-arrow-up fs-5 text-success ms-n1"></i>1.9%</span>
                                                                    <!--end::Label-->
                                                                </div>
                                                                <!--end::Info-->
                                                            </div>
                                                            <!--end::Wrapper-->
                                                        </div>
                                                        <!--end::Section-->
                                                    </div>
                                                    <!--end::Item-->
                                                </div>
                                                <!--end::Body-->
                                            </div>
                                            <!--end::List widget 9-->
                                        </div>
                                        <!--end::Col-->
                                        <!--begin::Col-->
                                        <div class="col-xl-12 col-xxl-8 mb-5 mb-xl-10">
                                            <div class="card mb-5 mb-xl-10">
                                                <!--begin::Card header-->
                                                <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_profile_details" aria-expanded="true" aria-controls="kt_account_profile_details">
                                                    <!--begin::Card title-->
                                                    <div class="card-title m-0">
                                                        <h3 class="fw-bold m-0">Profile Details</h3>
                                                    </div>
                                                    <!--end::Card title-->
                                                </div>
                                                <!--begin::Card header-->
                                                <!--begin::Content-->
                                                <div id="kt_account_settings_profile_details" class="collapse show">
                                                    <!--begin::Form-->
                                                    <form id="kt_create_account_form" method="post" class="" enctype="multipart/form-data">
                                                        <!--begin::Card body-->
                                                        <div class="card-body border-top p-9">
                                                            <!--begin::Input group-->
                                                            <div class="row mb-6">
                                                                <!--begin::Label-->
                                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">Profile Image</label>
                                                                <!--end::Label-->
                                                                <!--begin::Col-->
                                                                <div class="col-lg-8">
                                                                    <!--begin::Image input-->
                                                                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('<?php echo site_url(); ?>/assets/media/svg/avatars/blank.svg')">
                                                                        <!--begin::Preview existing avatar-->
                                                                        <?php if ($admin_profile_img) { ?>
                                                                            <div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?php echo site_url(); ?>/uploads/admin/<?php echo $admin_profile_img; ?>)"></div>
                                                                        <?php } else { ?>
                                                                            <div class="image-input-wrapper w-125px h-125px" style="background-image: url(<?php echo site_url(); ?>/uploads/admin/blank.png)"></div>
                                                                        <?php } ?>

                                                                        <!--end::Preview existing avatar-->
                                                                        <!--begin::Label-->
                                                                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change Profile">
                                                                            <i class="ki-outline ki-pencil fs-7"></i>
                                                                            <!--begin::Inputs-->
                                                                            <input type="file" name="profile_img" accept=".png, .jpg, .jpeg" />
                                                                            <input type="hidden" name="profile_img_remove" />
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
                                                                <!--end::Col-->
                                                            </div>
                                                            <!--end::Input group-->
                                                            <!--begin::Input group-->
                                                            <div class="row mb-6">
                                                                <!--begin::Label-->
                                                                <label class="col-lg-4 col-form-label required fw-semibold fs-6">Full Name</label>
                                                                <!--end::Label-->
                                                                <!--begin::Col-->
                                                                <div class="col-lg-8">
                                                                    <!--begin::Row-->
                                                                    <div class="row">
                                                                        <!--begin::Col-->
                                                                        <div class="col-lg-6 fv-row">
                                                                            <input type="text" name="first_name" class="form-control form-control-lg form-control-solid mb-3 mb-lg-0" placeholder="First name" value="<?php echo $get_login_admin_info->first_name; ?>" required />
                                                                        </div>
                                                                        <!--end::Col-->
                                                                        <!--begin::Col-->
                                                                        <div class="col-lg-6 fv-row">
                                                                            <input type="text" name="last_name" class="form-control form-control-lg form-control-solid" placeholder="Last name" value="<?php echo $get_login_admin_info->last_name; ?>" required />
                                                                        </div>
                                                                        <!--end::Col-->
                                                                    </div>
                                                                    <!--end::Row-->
                                                                </div>
                                                                <!--end::Col-->
                                                            </div>
                                                            <!--end::Input group-->
                                                            <!--begin::Input group-->
                                                            <div class="row mb-6">
                                                                <!--begin::Label-->
                                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                                    <span class="required">Email</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Col-->
                                                                <div class="col-lg-8 fv-row">
                                                                    <input type="email" name="email" class="form-control form-control-lg form-control-solid" placeholder="Email" value="<?php echo $get_login_admin_info->email; ?>" required />
                                                                </div>
                                                                <!--end::Col-->
                                                            </div>
                                                            <!--end::Input group-->
                                                            <!--begin::Input group-->
                                                            <div class="row mb-6">
                                                                <!--begin::Label-->
                                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                                    <span class="required">Contact Phone</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Col-->
                                                                <div class="col-lg-8 fv-row">
                                                                    <input type="text" name="mobile_no" class="form-control form-control-lg form-control-solid" placeholder="Phone number" value="<?php echo $get_login_admin_info->mobile_no; ?>" required />
                                                                </div>
                                                                <!--end::Col-->
                                                            </div>
                                                            <!--end::Input group-->

                                                            <!--begin::Input group-->
                                                            <div class="row mb-6">
                                                                <!--begin::Label-->
                                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                                    <span class="">Password</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Col-->
                                                                <div class="col-lg-8 fv-row">
                                                                    <input type="password" name="password" class="form-control form-control-lg form-control-solid" placeholder="Password" />
                                                                </div>
                                                                <!--end::Col-->
                                                            </div>
                                                            <!--end::Input group-->

                                                            <!--begin::Input group-->
                                                            <div class="row mb-6">
                                                                <!--begin::Label-->
                                                                <label class="col-lg-4 col-form-label fw-semibold fs-6">
                                                                    <span class="required">State</span>
                                                                </label>
                                                                <!--end::Label-->
                                                                <!--begin::Col-->
                                                                <div class="col-lg-8 fv-row">
                                                                    <select name="state" aria-label="Select a State" data-control="select2" data-placeholder="Select a state..." class="form-select form-select-solid form-select-lg fw-semibold" required>
                                                                        <option value="">Select a State...</option>
                                                                        <?php foreach (Settings()->get_state_list() as $state_result) { ?>
                                                                            <option <?php echo ($get_login_admin_info->state == $state_result) ? 'selected' : ''; ?> value="<?php echo $state_result; ?>"><?php echo $state_result; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                                <!--end::Col-->
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--end::Card body-->

                                                        <!--begin::Actions-->
                                                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                                                            <button type="submit" name="save_profile" class="btn btn-primary" id="">Save Changes</button>
                                                        </div>
                                                        <!--end::Actions-->
                                                    </form>
                                                    <!--end::Form-->
                                                </div>
                                                <!--end::Content-->
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                <?php } else if (siget('tab') == 'logs') { ?>
                                    <!--begin::Card-->
                                    <div class="card pt-4">
                                        <!--begin::Card header-->
                                        <div class="card-header border-0">
                                            <!--begin::Card title-->
                                            <div class="card-title">
                                                <h2>Logs</h2>
                                            </div>
                                            <!--end::Card title-->
                                            <!--begin::Card toolbar-->
                                            <div class="card-toolbar">
                                                <!--begin::Button-->
                                                <!--end::Button-->
                                            </div>
                                            <!--end::Card toolbar-->
                                        </div>
                                        <!--end::Card header-->
                                        <!--begin::Card body-->
                                        <div class="card-body py-0">
                                            <!--begin::Table wrapper-->
                                            <div class="table-responsive">
                                                <!--begin::Table-->
                                                <table class="table align-middle table-row-dashed fw-semibold text-gray-600 fs-6 gy-5" id="">
                                                    <!--begin::Table body-->
                                                    <tbody>
                                                        <!--begin::Table row-->
                                                        <tr>
                                                            <!--begin::Badge=-->
                                                            <td colspan="1" class="min-w-70px">
                                                                Coming Soon
                                                            </td>
                                                            <!--end::Timestamp=-->
                                                        </tr>
                                                        <!--end::Table row-->
                                                    </tbody>
                                                    <!--end::Table body-->
                                                </table>
                                                <!--end::Table-->
                                            </div>
                                            <!--end::Table wrapper-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Card-->
                                <?php } ?>
                                <!--end::Row-->
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
    <script src="<?php echo site_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--begin::Custom Javascript(used for this page only)-->
    <script src="<?php echo site_url(); ?>/assets/js/custom/pages/user-profile/general.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/widgets.bundle.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/widgets.js"></script>
    <!--end::Custom Javascript-->
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>