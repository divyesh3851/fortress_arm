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
                            <i class="ki-outline ki-home-2 fs-2x"></i>
                        </span>
                        <span class="menu-title">Dashboard</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <?php if (Admin()->check_for_page_access('messages')) { ?>
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link <?php echo ($page_name == 'message') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/message/messages-list">
                            <span class="menu-icon">
                                <i class="las la-comment-dots fs-2x"></i>
                            </span>
                            <span class="menu-title">Conversations</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                <?php } ?>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <?php if (Admin()->check_for_page_access('activities')) { ?>
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link <?php echo ($page_name == 'activity') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/activity/activity-list">
                            <span class="menu-icon">
                                <i class="las la-project-diagram fs-2x"></i>
                            </span>
                            <span class="menu-title">Activities</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                <?php } ?>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'calendar') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/calendar">
                        <span class="menu-icon">
                            <i class="las la-calendar fs-2x"></i>
                        </span>
                        <span class="menu-title">Calendar</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <?php if (Admin()->check_for_page_access('advisor')) { ?>
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link <?php echo ($page_name == 'advisor') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/advisor/advisor-list">
                            <span class="menu-icon">
                                <i class="las la-user-friends fs-2x"></i>
                            </span>
                            <span class="menu-title">Contacts</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                <?php } ?>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'opportunities') ? 'active' : ''; ?>" href="">
                        <span class="menu-icon">
                            <i class="las la-compress-arrows-alt fs-2x"></i>
                        </span>
                        <span class="menu-title">Opportunities</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <?php if (Admin()->check_for_page_access('verification')) { ?>
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link <?php echo ($page_name == 'verification') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/verification/advisor-list">
                            <span class="menu-icon">
                                <i class="las la-check-double fs-2x"></i>
                            </span>
                            <span class="menu-title">Verification</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                <?php } ?>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'sites') ? 'active' : ''; ?>" href="">
                        <span class="menu-icon">
                            <i class="las la-globe fs-2x"></i>
                        </span>
                        <span class="menu-title">Sites</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'marketing') ? 'active' : ''; ?>" href="">
                        <span class="menu-icon">
                            <i class="las la-bullhorn fs-2x"></i>
                        </span>
                        <span class="menu-title">Marketing</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'automation') ? 'active' : ''; ?>" href="">
                        <span class="menu-icon">
                            <i class="las la-robot fs-2x"></i>
                        </span>
                        <span class="menu-title">Automation</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'reputation') ? 'active' : ''; ?>" href="">
                        <span class="menu-icon">
                            <i class="las la-star fs-2x"></i>
                        </span>
                        <span class="menu-title">Reputation</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'reporting') ? 'active' : ''; ?>" href="">
                        <span class="menu-icon">
                            <i class="las la-notes-medical fs-2x"></i>
                        </span>
                        <span class="menu-title">Reporting</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'university') ? 'active' : ''; ?>" href="">
                        <span class="menu-icon">
                            <i class="las la-university fs-2"></i>
                        </span>
                        <span class="menu-title">University</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <?php if (Admin()->check_for_page_access('document_vault')) { ?>
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link <?php echo ($page_name == 'doc_vault') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/document/document-vault">
                            <span class="menu-icon">
                                <i class="lab la-dropbox fs-2x"></i>
                            </span>
                            <span class="menu-title">Document Vault</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                <?php } ?>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'important_links') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/important-links-list">
                        <span class="menu-icon">
                            <i class="las la-link fs-2x"></i>
                        </span>
                        <span class="menu-title">Important Links</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'marketplace') ? 'active' : ''; ?>" href="">
                        <span class="menu-icon">
                            <i class="las la-chart-bar fs-2x"></i>
                        </span>
                        <span class="menu-title">Marketplace</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

                <?php /* 
                <!--begin:Menu item-->
                <?php if (Admin()->check_for_page_access('notes')) { ?>
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link <?php echo ($page_name == 'notes') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/notes">
                            <span class="menu-icon">
                                <i class="las la-pencil-alt fs-2x"></i>
                            </span>
                            <span class="menu-title">Notes</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                <?php } ?>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <?php if (Admin()->check_for_page_access('campaigns')) { ?>
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link <?php echo ($page_name == 'campaigns') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/campaigns/list">
                            <span class="menu-icon">
                                <i class="las la-bullhorn fs-2x"></i>
                            </span>
                            <span class="menu-title">Campaigns</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                <?php } ?>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <?php if (Admin()->check_for_page_access('newsletter')) { ?>
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link <?php echo ($page_name == 'newsletter') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/newsletter">
                            <span class="menu-icon">
                                <i class="las la-envelope-open fs-2x"></i>
                            </span>
                            <span class="menu-title">Newsletter</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                <?php } ?>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <?php if (Admin()->check_for_page_access('analytics')) { ?>
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link <?php echo ($page_name == 'analytics') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/analytics/dashboard">
                            <span class="menu-icon">
                                <i class="lar la-chart-bar fs-2x"></i>
                            </span>
                            <span class="menu-title">Analytics</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                <?php } ?>
                <!--end:Menu item-->

                <!--begin:Menu item-->
                <?php if (Admin()->check_for_page_access('compliance')) { ?>
                    <div class="menu-item">
                        <!--begin:Menu link-->
                        <a class="menu-link <?php echo ($page_name == 'compliance') ? 'active' : ''; ?>" href="">
                            <span class="menu-icon">
                                <i class="las la-file-alt fs-2x"></i>
                            </span>
                            <span class="menu-title">Compliance</span>
                        </a>
                        <!--end:Menu link-->
                    </div>
                    <!--end:Menu item-->
                <?php } ?>

                */ ?>


                <!--begin:Menu item-->
                <?php if (IS_ADMIN) { ?>

                    <!--begin:Menu item-->
                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion <?php echo ($page_name == 'user_management') ? ' show' : ''; ?>">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="las la-user-tie fs-2x"></i>
                            </span>
                            <span class="menu-title">User</span>
                            <span class="menu-arrow"></span>
                        </span>
                        <!--end:Menu link-->
                        <!--begin:Menu sub-->
                        <div class="menu-sub menu-sub-accordion">
                            <!--begin:Menu item-->
                            <div class="menu-item">
                                <!--begin:Menu link-->
                                <a class="menu-link <?php echo ($sub_page_name == 'user') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/admin-user/list">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Users</span>
                                </a>
                                <!--end:Menu link-->
                                <!--begin:Menu link-->
                                <a class="menu-link <?php echo ($sub_page_name == 'roles') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/admin-user/role-list">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Roles</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                    <!--end:Menu item-->

                    <div data-kt-menu-trigger="click" class="menu-item menu-accordion <?php echo ($page_name == 'settings') ? ' show' : ''; ?>">
                        <!--begin:Menu link-->
                        <span class="menu-link">
                            <span class="menu-icon">
                                <i class="las la-cog fs-2x"></i>
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

                                <div data-kt-menu-trigger="click" class="menu-item menu-accordion <?php echo ($sub_page_name == 'indexed-universal-life' || $sub_page_name == 'term' || $sub_page_name == 'whole_life' || $sub_page_name == 'advanced_planing' || $sub_page_name == 'fixed_indexed_annuities' || $sub_page_name == 'long_term_care' || $sub_page_name == 'life_settlements') ? 'hover show' : ''; ?> ">
                                    <!--begin:Menu link-->
                                    <span class="menu-link">
                                        <span class="menu-bullet">
                                            <span class="bullet bullet-dot"></span>
                                        </span>
                                        <span class="menu-title">Interest Communication</span>
                                        <span class="menu-arrow"></span>
                                    </span>
                                    <!--end:Menu link-->
                                    <!--begin:Menu sub-->
                                    <div class="menu-sub menu-sub-accordion">
                                        <!--begin:Menu item-->
                                        <div data-kt-menu-trigger="click" class="menu-item menu-accordion">
                                            <!--begin:Menu link-->
                                            <span class="menu-link">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Life Insurance</span>
                                                <span class="menu-arrow"></span>
                                            </span>
                                            <!--end:Menu link-->
                                            <!--begin:Menu sub-->
                                            <div class="menu-sub menu-sub-accordion menu-active-bg <?php echo ($sub_page_name == 'indexed-universal-life' || $sub_page_name == 'term' || $sub_page_name == 'whole_life' || $sub_page_name == 'advanced_planing') ? 'show' : ''; ?> ">
                                                <!--begin:Menu item-->
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a class="menu-link <?php echo ($sub_page_name == 'indexed-universal-life') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/settings/indexed-universal-life">
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title">Indexed Universal Life</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                                <!--end:Menu item-->
                                                <!--begin:Menu item-->
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a class="menu-link <?php echo ($sub_page_name == 'term') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/settings/term">
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title">Term</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                                <!--end:Menu item-->
                                                <!--begin:Menu item-->
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a class="menu-link <?php echo ($sub_page_name == 'whole_life') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/settings/whole-life">
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title">Whole Life</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                                <!--end:Menu item-->
                                                <!--begin:Menu item-->
                                                <div class="menu-item">
                                                    <!--begin:Menu link-->
                                                    <a class="menu-link <?php echo ($sub_page_name == 'advanced_planing') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/settings/advanced-planning">
                                                        <span class="menu-bullet">
                                                            <span class="bullet bullet-dot"></span>
                                                        </span>
                                                        <span class="menu-title">Advanced Planning</span>
                                                    </a>
                                                    <!--end:Menu link-->
                                                </div>
                                                <!--end:Menu item-->
                                            </div>
                                            <!--end:Menu sub-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link <?php echo ($sub_page_name == 'fixed_indexed_annuities') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/settings/fixed-indexed-annuities">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Fixed Indexed Annuities </span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link <?php echo ($sub_page_name == 'long_term_care') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/settings/long-term-care">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Long-Term Care Insurance</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                        <!--begin:Menu item-->
                                        <div class="menu-item">
                                            <!--begin:Menu link-->
                                            <a class="menu-link <?php echo ($sub_page_name == 'life_settlements') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/admin/settings/life-settlements">
                                                <span class="menu-bullet">
                                                    <span class="bullet bullet-dot"></span>
                                                </span>
                                                <span class="menu-title">Life Settlements</span>
                                            </a>
                                            <!--end:Menu link-->
                                        </div>
                                        <!--end:Menu item-->
                                    </div>
                                    <!--end:Menu sub-->

                                </div>
                                <!--begin:Menu link-->
                                <a class="menu-link <?php echo ($sub_page_name == 'mail-setting') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/settings/mail-setting">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Mail Settings</span>
                                </a>
                                <!--end:Menu link-->
                                <!--begin:Menu link-->
                                <a class="menu-link <?php echo ($sub_page_name == 'cron_setting') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/admin/settings/cron-setting">
                                    <span class="menu-bullet">
                                        <span class="bullet bullet-dot"></span>
                                    </span>
                                    <span class="menu-title">Cron Settings</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        </div>
                        <!--end:Menu sub-->
                    </div>
                <?php } ?>
                <!--end:Menu item-->
            </div>
            <!--end::Sidebar menu-->
        </div>
    </div>
    <!--end::Wrapper-->
</div>