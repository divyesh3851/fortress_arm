<?php require '../../config.php';
$page_name = 'activity';
$sub_page_name = 'activity-list';
Admin()->check_login();
$advisor_info = Advisor()->get_selected_advisor_general_details(siget('advisor_id'));

$get_advisor_activity_list = Admin()->get_advisor_activity_list(siget('advisor_id'));
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/admin/head.php'; ?>
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

                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-fluid">

                                <!--begin::Timeline-->
                                <div class="card">
                                    <!--begin::Card head-->
                                    <div class="card-header card-header-stretch">
                                        <!--begin::Title-->
                                        <div class="card-title d-flex align-items-center">
                                            <i class="ki-outline ki-notepad-bookmark fs-1 text-primary me-3 lh-0"></i>
                                            <h3 class="fw-bold m-0 text-gray-800">Activity of <?php echo $advisor_info->first_name . ' ' . $advisor_info->last_name; ?></h3>
                                        </div>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Card head-->
                                    <!--begin::Card body-->
                                    <div class="card-body">
                                        <!--begin::Tab Content-->
                                        <div class="tab-content">
                                            <!--begin::Tab panel-->
                                            <div id="kt_activity_today" class="card-body p-0 tab-pane fade show active" role="tabpanel" aria-labelledby="kt_activity_today_tab">
                                                <!--begin::Timeline-->
                                                <div class="timeline timeline-border-dashed">

                                                    <?php foreach ($get_advisor_activity_list as $activity_result) {

                                                        $log_created_from = $wpdb->get_row("SELECT first_name, last_name FROM admin WHERE id = " . $activity_result->logged_id);

                                                        if ($log_created_from) {
                                                            $name = $log_created_from->first_name . ' ' . $log_created_from->last_name;
                                                        } else if ($activity_result->user_id && $activity_result->user_type == 'advisor') {
                                                            $get_advisor_info = $wpdb->get_row("SELECT first_name, last_name FROM advisor WHERE id = " . $activity_result->user_id);
                                                            $name = $get_advisor_info->first_name . ' ' . $get_advisor_info->last_name;
                                                        }

                                                        $created_from_profile = Admin()->get_admin_meta($activity_result->logged_id, "profile_img");
                                                    ?>
                                                        <!--begin::Timeline item-->
                                                        <div class="timeline-item">
                                                            <!--begin::Timeline line-->
                                                            <div class="timeline-line"></div>
                                                            <!--end::Timeline line-->
                                                            <!--begin::Timeline icon-->
                                                            <div class="timeline-icon">
                                                                <i class="ki-outline ki-pencil fs-2 text-gray-500"></i>
                                                            </div>
                                                            <!--end::Timeline icon-->
                                                            <!--begin::Timeline content-->
                                                            <div class="timeline-content mb-10 mt-n1">
                                                                <!--begin::Timeline heading-->
                                                                <div class="pe-3 mb-5">
                                                                    <!--begin::Title-->
                                                                    <div class="fs-5 fw-semibold mb-2">
                                                                        <?php echo ($activity_result->message) ? ucfirst($activity_result->message) : ''; ?>
                                                                    </div>
                                                                    <!--end::Title-->
                                                                    <!--begin::Description-->
                                                                    <div class="d-flex align-items-center mt-1 fs-6">
                                                                        <!--begin::Info-->
                                                                        <div class="text-muted me-2 fs-7">Created at <?php echo date("F d,Y", strtotime($activity_result->created_at)); ?> by <?php echo  $name; ?></div>
                                                                        <!--end::Info-->
                                                                        <!--begin::User-->
                                                                        <div class="symbol symbol-circle symbol-25px" data-bs-toggle="tooltip" data-bs-boundary="window" data-bs-placement="top" title="<?php echo  $name; ?>">
                                                                            <?php
                                                                            if ($created_from_profile) { ?>
                                                                                <img src="<?php echo site_url(); ?>/uploads/admin/<?php echo $created_from_profile; ?>" alt="img" />
                                                                            <?php } else { ?>
                                                                                <img src="<?php echo site_url(); ?>/uploads/admin/blank.png" alt="img" />
                                                                            <?php } ?>
                                                                        </div>
                                                                        <!--end::User-->
                                                                    </div>
                                                                    <!--end::Description-->
                                                                </div>
                                                                <!--end::Timeline heading-->
                                                            </div>
                                                            <!--end::Timeline content-->
                                                        </div>
                                                        <!--end::Timeline item-->
                                                    <?php } ?>
                                                </div>
                                                <!--end::Tab panel-->
                                            </div>
                                            <!--end::Tab Content-->
                                        </div>
                                        <!--end::Card body-->
                                    </div>
                                    <!--end::Timeline-->
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
</body>
<!--end::Body-->

</html>