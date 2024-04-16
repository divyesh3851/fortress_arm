<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
    <!--begin::Wrapper-->
    <div id="kt_app_sidebar_wrapper" class="app-sidebar-wrapper">
        <div class="hover-scroll-y my-5 my-lg-2 mx-4" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header" data-kt-scroll-wrappers="#kt_app_sidebar_wrapper" data-kt-scroll-offset="5px">
            <!--begin::Sidebar menu-->
            <div id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false" class="app-sidebar-menu-primary menu menu-column menu-rounded menu-sub-indention menu-state-bullet-primary px-3 mb-5">

                <!--begin:Menu item-->
                <div class="menu-item">
                    <!--begin:Menu link-->
                    <a class="menu-link <?php echo ($page_name == 'dashboard') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/advisor/dashboard">
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
                    <a class="menu-link <?php echo ($page_name == 'advisor') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/advisor/advisor-list">
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
                    <a class="menu-link <?php echo ($page_name == 'verification') ? 'active' : ''; ?>" href="<?php echo site_url() ?>/advisor/verification/advisor-list">
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
                    <a class="menu-link <?php echo ($page_name == 'notes') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/advisor/notes">
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
                    <a class="menu-link <?php echo ($page_name == 'message') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/advisor/message/messages-list">
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
                    <a class="menu-link <?php echo ($page_name == 'doc_vault') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/advisor/document/document-vault">
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
                    <a class="menu-link <?php echo ($page_name == 'campaigns') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/advisor/campaigns/list">
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
                    <a class="menu-link <?php echo ($page_name == 'analytics') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/advisor/analytics/dashboard">
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
                    <a class="menu-link <?php echo ($page_name == 'activity') ? 'active' : ''; ?>" href="<?php echo site_url(); ?>/advisor/activity/activity-list/">
                        <span class="menu-icon">
                            <i class="las la-project-diagram fs-2"></i>
                        </span>
                        <span class="menu-title">Activities</span>
                    </a>
                    <!--end:Menu link-->
                </div>
                <!--end:Menu item-->

            </div>
            <!--end::Sidebar menu-->
        </div>
    </div>
    <!--end::Wrapper-->
</div>