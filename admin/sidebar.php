<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Wrapper-->
    <div id="kt_app_sidebar_wrapper" class="app-sidebar-wrapper">
        <div class="hover-scroll-y my-5 my-lg-2 mx-4" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_sidebar_wrapper" data-kt-scroll-offset="5px">
            <!--begin::Sidebar menu-->
            <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary px-3 mb-5">

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'dashboard') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/dashboard">
                        <span class="menu-icon">
                            <i class="ki-outline ki-home-2 fs-2"></i>
                        </span>
                        <span class="menu-title">ARM Dashboard</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'advisor') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/advisor/advisor-list">
                        <span class="menu-icon">
                            <i class="las la-user-friends fs-2"></i>
                        </span>
                        <span class="menu-title">Advisor Information</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'verification') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/verification/advisor-list">
                        <span class="menu-icon">
                            <i class="las la-check-double fs-2"></i>
                        </span>
                        <span class="menu-title">Verification</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'notes') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/notes">
                        <span class="menu-icon">
                            <i class="las la-pencil-alt fs-2"></i>
                        </span>
                        <span class="menu-title">Notes</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'message') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/message/messages-list">
                        <span class="menu-icon">
                            <i class="las la-comment-dots fs-2"></i>
                        </span>
                        <span class="menu-title">Messages</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'doc_vault') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/document/document-vault">
                        <span class="menu-icon">
                            <i class="lab la-dropbox fs-2"></i>
                        </span>
                        <span class="menu-title">Document Vault</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'campaigns') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/campaigns/list">
                        <span class="menu-icon">
                            <i class="las la-bullhorn fs-2"></i>
                        </span>
                        <span class="menu-title">Campaigns</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'newsletter') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/newsletter">
                        <span class="menu-icon">
                            <i class="las la-envelope-open fs-2"></i>
                        </span>
                        <span class="menu-title">Newsletter</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'analytics') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/analytics/dashboard">
                        <span class="menu-icon">
                            <i class="lar la-chart-bar fs-2"></i>
                        </span>
                        <span class="menu-title">Analytics</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'compliance') ? 'active' : ''; ?>" href="">
                        <span class="menu-icon">
                            <i class="las la-file-alt fs-2"></i>
                        </span>
                        <span class="menu-title">Compliance</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'activity') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/activity/activity-list/">
                        <span class="menu-icon">
                            <i class="las la-project-diagram fs-2"></i>
                        </span>
                        <span class="menu-title">Activities</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'user') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/admin_user/list">
                        <span class="menu-icon">
                            <i class="ki-outline ki-user-tick fs-2"></i>
                        </span>
                        <span class="menu-title">Users</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <?php /*
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'business') ? 'active' : ''; ?>" href="<?php echo admin_url() ?>business/business-list">
                        <span class="menu-icon">
                            <i class="ki-outline ki-briefcase  fs-2"></i>
                        </span>
                        <span class="menu-title">Business Information</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                */ ?>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div data-kt-menu-trigger="click" class="menu-item menu-accordion <?php echo ($page_name == 'settings') ? ' show' : ''; ?>">
                    <!--begin:Menu link-->
                    <span class="menu-link">
                        <span class="menu-icon">
                            <i class="ki-outline ki-abstract-26 fs-2"></i>
                        </span>
                        <span class="menu-title">Settings</span>
                        <span class="menu-arrow"></span>
                    </span>
                    <!--end:Menu link-->
                    <!--begin:Menu sub-->
                    <div class="menu-sub menu-sub-accordion">
                        <!--begin:Menu item-->
                        <div class="menu-item">
                            <!--begin:Menu link-->
                            <a class="menu-link <?php echo ($sub_page_name == 'designation-list') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/settings/designation-list">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Designation</span>
                            </a>
                            <!--end:Menu link-->
                            <!--begin:Menu link-->
                            <a class="menu-link <?php echo ($sub_page_name == 'licenses-type-list') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/settings/licenses-type-list">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Licenses Types</span>
                            </a>
                            <!--end:Menu link-->
                            <!--begin:Menu link-->
                            <a class="menu-link <?php echo ($sub_page_name == 'lead-source-list') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/settings/lead-source-list">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Lead Source</span>
                            </a>
                            <!--end:Menu link-->
                            <!--begin:Menu link-->
                            <a class="menu-link <?php echo ($sub_page_name == 'affiliations-list') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/settings/affiliations-list">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Affiliations</span>
                            </a>
                            <!--end:Menu link-->
                            <!--begin:Menu link-->
                            <a class="menu-link <?php echo ($sub_page_name == 'carrier-appointed-list') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/settings/carrier-appointed-list">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Carrier Appointed</span>
                            </a>
                            <!--end:Menu link-->
                            <!--begin:Menu link-->
                            <a class="menu-link <?php echo ($sub_page_name == 'carrier-list') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/settings/carrier-list">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Carriers</span>
                            </a>
                            <!--end:Menu link-->
                            <!--begin:Menu link-->
                            <a class="menu-link <?php echo ($sub_page_name == 'premium-volume-list') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/settings/premium-volume-list">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Premium Volume</span>
                            </a>
                            <!--end:Menu link-->
                            <!--begin:Menu link-->
                            <a class="menu-link <?php echo ($sub_page_name == 'production-percentage-list') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/settings/production-percentage-list">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Production Percentage</span>
                            </a>
                            <!--end:Menu link-->
                            <!--begin:Menu link-->
                            <a class="menu-link <?php echo ($sub_page_name == 'market-list') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/settings/market-list">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Markets</span>
                            </a>
                            <!--end:Menu link-->
                            <!--begin:Menu link-->
                            <a class="menu-link <?php echo ($sub_page_name == 'mail-setting') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/settings/mail-setting">
                                <span class="menu-bullet">
                                    <span class="bullet bullet-dot"></span>
                                </span>
                                <span class="menu-title">Mail Settings</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    </div>
                    <!--end:Menu sub-->
                </div>
                <!--end:Menu item-->
            </div>
            <!--end::Sidebar menu-->
        </div>
    </div>
    <!--end::Wrapper-->
</div>