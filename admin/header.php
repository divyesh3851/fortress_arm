<?php
$profile_img = Admin()->get_admin_meta($_SESSION['fbs_admin_id'], 'profile_img');
$get_upcoming_birthday_anniversary_list = Advisor()->get_upcoming_birthday_anniversary_list();
?>
<div id="kt_app_header" class="app-header d-flex flex-column flex-stack">
    <!--begin::Header main-->
    <div class="d-flex flex-stack flex-grow-1 logo_with_header">
        <div class="app-header-logo d-flex align-items-center ps-lg-12" id="kt_app_header_logo">
            <!--begin::Sidebar toggle-->
            <div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-sm btn-icon bg-body btn-color-gray-500 btn-active-color-primary w-30px h-30px ms-n2 me-4 d-none d-lg-flex" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
                <i class="ki-outline ki-abstract-14 fs-3 mt-1"></i>
            </div>
            <!--end::Sidebar toggle-->
            <!--begin::Sidebar mobile toggle-->
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px ms-3 me-2 d-flex d-lg-none" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-outline ki-abstract-14 fs-2"></i>
            </div>
            <!--end::Sidebar mobile toggle-->
            <!--begin::Logo-->
            <a href="<?php echo site_url(); ?>/admin" class="app-sidebar-logo">
                <img alt="Logo" src="<?php echo site_url(); ?>/assets/images/logo-white.png" class="theme-light-show" />
                <img alt="Logo" src="<?php echo site_url(); ?>/assets/images/logo-white.png" class="theme-dark-show" />
            </a>
            <!--end::Logo-->
        </div>
        <!--begin::Navbar-->
        <div class="app-navbar flex-grow-1 justify-content-end" id="kt_app_header_navbar">
            <div class="app-navbar-item d-flex align-items-stretch flex-lg-grow-1">
                <!--begin::Search-->
                <div id="kt_header_search" class="header-search d-flex align-items-center w-lg-350px" data-kt-search-keypress="true" data-kt-search-min-length="2" data-kt-search-enter="enter" data-kt-search-layout="menu" data-kt-search-responsive="true" data-kt-menu-trigger="auto" data-kt-menu-permanent="true" data-kt-menu-placement="bottom-start">
                    <!--begin::Tablet and mobile search toggle-->
                    <div data-kt-search-element="toggle" class="search-toggle-mobile d-flex d-lg-none align-items-center">
                        <div class="d-flex">
                            <i class="ki-outline ki-magnifier fs-1 fs-1"></i>
                        </div>
                    </div>
                    <!--end::Tablet and mobile search toggle-->
                    <!--begin::Form(use d-none d-lg-block classes for responsive search)-->
                    <form data-kt-search-element="form" class="d-none d-lg-block w-100 position-relative mb-5 mb-lg-0" autocomplete="off">
                        <!--begin::Hidden input(Added to disable form autocomplete)-->
                        <input type="hidden" />
                        <!--end::Hidden input-->
                        <!--begin::Icon-->
                        <i class="ki-outline ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5"></i>
                        <!--end::Icon-->
                        <!--begin::Input-->
                        <input type="text" class="search-input form-control form-control border h-lg-45px ps-13" name="search" value="" placeholder="Search..." data-kt-search-element="input" />
                        <!--end::Input-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Chat-->
            <div class="app-navbar-item ms-2 ms-lg-6">
                <!--begin::Menu wrapper-->
                <div class="btn btn-icon btn-custom btn-color-white-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px position-relative" data-bs-toggle="modal" data-bs-target="#kt_modal_upcoming_birthday_anniversary" title="Upcoming Birthday / Anniversary Advisor">
                    <i class="ki-outline ki-calendar fs-1"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge badge-circle badge-danger w-15px h-15px ms-n4 mt-3"><?php echo count($get_upcoming_birthday_anniversary_list); ?></span>
                </div>
                <!--end::Menu wrapper-->
            </div>
            <!--end::Chat-->
            <!--begin::User menu-->
            <div class="app-navbar-item ms-2 ms-lg-6" id="kt_header_user_menu_toggle">
                <!--begin::Menu wrapper-->
                <div class="cursor-pointer symbol symbol-circle symbol-30px symbol-lg-45px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">

                    <?php
                    if ($profile_img) { ?>
                        <img src="<?php echo site_url(); ?>/uploads/admin/<?php echo $profile_img; ?>" alt="user" />
                    <?php } else { ?>
                        <img src="<?php echo site_url(); ?>/uploads/admin/blank.png" alt="user" />
                    <?php } ?>

                </div>
                <!--begin::User account menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-300px" data-kt-menu="true">
                    <!--begin::Menu item-->
                    <div class="menu-item px-3">
                        <div class="menu-content d-flex align-items-center px-3">
                            <!--begin::Avatar-->
                            <div class="symbol symbol-50px me-5">
                                <?php
                                if ($profile_img) { ?>
                                    <img alt="Logo" src="<?php echo site_url(); ?>/uploads/admin/<?php echo $profile_img; ?>" />
                                <?php } else { ?>
                                    <img alt="Logo" src="<?php echo site_url(); ?>/uploads/admin/blank.png" />
                                <?php } ?>
                            </div>
                            <!--end::Avatar-->
                            <!--begin::Username-->
                            <div class="d-flex flex-column">
                                <div class="fw-bold d-flex align-items-center fs-5">
                                    <?php
                                    $get_login_admin_info = Admin()->get_login_admin_info($_SESSION['fbs_admin_id']);
                                    echo $get_login_admin_info->first_name . ' ' . $get_login_admin_info->last_name;
                                    ?>
                                </div>
                                <a href="mailto:<?php echo $get_login_admin_info->email; ?>" class="fw-semibold text-muted text-hover-primary fs-7"><?php echo $get_login_admin_info->email; ?></a>
                            </div>
                            <!--end::Username-->
                        </div>
                    </div>
                    <!--end::Menu item-->
                    <!--begin::Menu separator-->
                    <div class="separator my-2"></div>
                    <!--end::Menu separator-->
                    <!--begin::Menu item-->
                    <div class="menu-item px-5">
                        <a href="<?php echo site_url(); ?>/admin/logout" class="menu-link px-5">Log Out</a>
                    </div>
                    <!--end::Menu item-->
                </div>
                <!--end::User account menu-->
                <!--end::Menu wrapper-->
            </div>
            <!--end::User menu-->
            <!--begin::Action-->
            <div class="app-navbar-item ms-2 ms-lg-6 me-lg-6">
                <!--begin::Link-->
                <a href="<?php echo site_url() ?>/admin/logout" class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px">
                    <i class="ki-outline ki-exit-right fs-1"></i>
                </a>
                <!--end::Link-->
            </div>
            <!--end::Action-->
            <!--begin::Header menu toggle-->
            <div class="app-navbar-item ms-2 ms-lg-6 ms-n2 me-3 d-flex d-lg-none">
                <div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px" id="kt_app_aside_mobile_toggle">
                    <i class="ki-outline ki-burger-menu-2 fs-2"></i>
                </div>
            </div>
            <!--end::Header menu toggle-->
        </div>
        <!--end::Navbar-->
    </div>
    <!--end::Header main-->
    <!--begin::Separator-->
    <div class="app-header-separator"></div>
    <!--end::Separator-->
</div>