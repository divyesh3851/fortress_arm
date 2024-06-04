<?php
$profile_img = Admin()->get_admin_meta($_SESSION['fbs_arm_admin_id'], 'profile_img');
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
                    <form data-kt-search-element="form" id="searchForm" class="d-none d-lg-block w-100 position-relative mb-5 mb-lg-0" autocomplete="off">
                        <!--begin::Hidden input(Added to disable form autocomplete)-->
                        <input type="hidden" />
                        <!--end::Hidden input-->
                        <!--begin::Icon-->
                        <i class="ki-outline ki-magnifier search-icon fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-5"></i>
                        <!--end::Icon-->
                        <!--begin::Input-->
                        <input type="text" class="search-input form-control form-control border h-lg-45px ps-13" name="search" id="searchInput" value="" placeholder="Search..." data-kt-search-element="input" />
                        <!--end::Input-->
                        <!--begin::Spinner-->
                        <span class="search-spinner position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-5" data-kt-search-element="spinner">
                            <span class="spinner-border h-15px w-15px align-middle text-gray-500"></span>
                        </span>
                        <!--end::Spinner-->
                        <!--begin::Reset-->
                        <span class="search-reset btn btn-flush btn-active-color-primary position-absolute top-50 end-0 translate-middle-y lh-0 d-none me-4" data-kt-search-element="clear">
                            <i class="ki-outline ki-cross fs-2 fs-lg-1 me-0"></i>
                        </span>
                        <!--end::Reset-->
                    </form>
                    <!--end::Form-->
                    <!--begin::Menu-->
                    <div id="searchResults"></div>
                    <!--end::Menu-->
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Notifications-->
            <div class="app-navbar-item ms-2 ms-lg-6">
                <!--begin::Menu- wrapper-->
                <div class="btn btn-icon btn-custom btn-color-white-600 btn-active-color-primary w-35px h-35px w-md-40px h-md-40px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                    <i class="ki-outline ki-calendar fs-1"></i>
                    <?php if (count($get_upcoming_birthday_anniversary_list) > 0) { ?>
                        <span class="position-relative  start-25 translate-middle badge badge-circle badge-danger w-15px h-15px ms-n4 mt-3" style="top:-5px"><?php echo count($get_upcoming_birthday_anniversary_list); ?></span>
                    <?php } ?>
                </div>
                <!--begin::Menu-->
                <div class="menu menu-sub menu-sub-dropdown menu-column w-450px w-lg-450px" data-kt-menu="true" id="kt_menu_notifications">
                    <!--begin::Heading-->
                    <div class="d-flex flex-column bgi-size-cover rounded-top" style="background-image:url('<?php echo site_url() ?>/assets/media/misc/menu-header-bg.jpg')">
                        <!--begin::Title-->
                        <h3 class="text-white fw-semibold px-9 mt-10 mb-6">Notifications
                            <?php if (count($get_upcoming_birthday_anniversary_list) > 0) { ?>
                                <span class="fs-8 opacity-75 ps-3">(<?php echo count($get_upcoming_birthday_anniversary_list); ?>)</span>
                            <?php } ?>
                        </h3>
                        <!--end::Title-->
                        <!--begin::Tabs-->
                        <ul class="nav nav-line-tabs nav-line-tabs-2x nav-stretch fw-semibold px-9">
                            <li class="nav-item">
                                <a class="nav-link text-white opacity-75 opacity-state-100 pb-4 active" data-bs-toggle="tab" href="#kt_topbar_notifications_1">Birthdays & Anniversaries </a>
                            </li>
                        </ul>
                        <!--end::Tabs-->
                    </div>
                    <!--end::Heading-->
                    <!--begin::Tab content-->
                    <div class="tab-content">
                        <!--begin::Tab panel-->
                        <div class="tab-pane fade  show active" id="kt_topbar_notifications_1" role="tabpanel">
                            <!--begin::Items-->
                            <div class="scroll-y mh-325px my-5 px-8">
                                <?php if (!empty($get_upcoming_birthday_anniversary_list)) {
                                    foreach ($get_upcoming_birthday_anniversary_list as $greeting_result) { ?>
                                        <div class="d-flex flex-stack pt-4">
                                            <!--begin::Section-->
                                            <div class="d-flex">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-40px symbol-circle mb-5 me-4">
                                                    <?php
                                                    $profile_img = Advisor()->get_advisor_meta($greeting_result['id'], 'profile_img');
                                                    if ($profile_img) { ?>
                                                        <img src="<?php echo site_url(); ?>/uploads/advisor/<?php echo $profile_img; ?>" alt="image" />
                                                    <?php } else { ?>
                                                        <img src="<?php echo site_url(); ?>/uploads/advisor/blank.png" alt="image" />
                                                    <?php } ?>
                                                </div>
                                                <!--end::Symbol-->
                                                <!--begin::Title-->
                                                <div class="mb-0 me-2">
                                                    <a href="<?php echo site_url(); ?>/admin/advisor/view-advisor/<?php echo $greeting_result['id']; ?>" class="fs-6 text-gray-800 text-hover-primary fw-bold"><?php echo $greeting_result['prefix'] . " " . $greeting_result['first_name'] . " " . $greeting_result['last_name']; ?></a>
                                                    <div class="text-gray-500 fs-7">
                                                        <?php if ($greeting_result['greeting'] == 'anniversary') { ?>
                                                            Anniversary Date : <?php echo ($greeting_result['greeting_date']) ? date("m/d/Y", strtotime($greeting_result['greeting_date'])) : ''; ?>
                                                        <?php } ?>
                                                        <?php if ($greeting_result['greeting'] == 'birthday') { ?>
                                                            Birthday Date : <?php echo ($greeting_result['greeting_date']) ? date("m/d/Y", strtotime($greeting_result['greeting_date'])) : ''; ?>
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Section-->
                                            <!--begin::Label-->
                                            <div class="d-flex">
                                                <a href="tel:<?php echo $greeting_result['mobile_no']; ?>">
                                                    <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                        <div class="fs-3 fw-bold text-gray-700">
                                                            <i class="las la-phone-volume fs-2 text-success"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="mailto:<?php echo $greeting_result['email']; ?>">
                                                    <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                        <div class="fs-2 fw-bold text-gray-700">
                                                            <i class="las la-envelope-open-text fs-2  text-success"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                            <!--end::Label-->
                                        </div>
                                        <!--begin::Menu separator-->
                                        <div class="separator separator-dashed"></div>
                                        <!--end::Menu separator-->
                                <?php }
                                } else {
                                    echo '<div class="text-gray-500 fs-16">No birthday or anniversary was discovered...</div>';
                                } ?>
                                <!--end::Item-->
                            </div>
                            <!--end::Items-->

                        </div>
                        <!--end::Tab panel-->
                    </div>
                    <!--end::Tab content-->
                </div>
                <!--end::Menu-->
                <!--end::Menu wrapper-->
            </div>
            <!--end::Notifications-->
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
                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-400px" data-kt-menu="true">
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
                                    $get_login_admin_info = Admin()->get_login_admin_info($_SESSION['fbs_arm_admin_id']);
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
                        <a href="<?php echo site_url(); ?>/admin/profile" class="menu-link px-5">Profile</a>
                    </div>
                    <!--end::Menu item-->
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
</div>