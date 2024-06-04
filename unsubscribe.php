<?php require 'config.php';
$page_name = 'unsubscribe';
$sub_page_name = '';

if (!siget('key')) {
    return;
}

$selected_advisor_data = $wpdb->get_row("SELECT id,first_name,last_name,email FROM advisor WHERE hash_key = '" . siget('key') . "'");

if (!$selected_advisor_data) {
    return;
}

if (isset($_POST['unsubscribe'])) {

    $response = Advisor()->unsubscribe(siget('key'), siget('campaign_id'));

    if ($response == 1) {
        $_SESSION['process_success'] = true;
    } else {
        $_SESSION['process_fail'] = true;
    }

    wp_redirect(site_url() . '/unsubscribe/' . siget('key') . '/' . siget('campaign_id'));
    exit;
}

$advisor_stop_email = $wpdb->get_var("SELECT stop_email FROM advisor WHERE id = " . $selected_advisor_data->id);

$campaign_stop = $wpdb->get_var("SELECT is_close FROM campaign_user WHERE user_id = " . $selected_advisor_data->id . " AND campaign_id = " . siget('campaign_id'));

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/head.php'; ?>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-layout="dark-header" data-kt-app-header-fixed="true" data-kt-app-toolbar-enabled="true" class="app-default">
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
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid mt-0" id="kt_app_wrapper">

                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">

                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid pt-0">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container w-850px" style="margin: 0 auto;">
                                <!--begin::Card-->
                                <div class="card">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-10">
                                        <?php if (isset($_SESSION['process_success'])) {
                                            unset($_SESSION['process_success']); ?>
                                            <div class="alert alert-success d-flex align-items-center p-5">
                                                <i class="ki-duotone ki-shield-tick fs-2hx text-success  me-4"><span class="path1"></span><span class="path2"></span></i>
                                                <div class="d-flex flex-column">
                                                    <h4 class="mb-1 text-success">You have been unsubscribed successfully.</h4>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <?php if (isset($_SESSION['process_fail'])) {
                                            unset($_SESSION['process_fail']); ?>
                                            <div class="alert alert-danger d-flex align-items-center p-5">
                                                <i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
                                                <div class="d-flex flex-column">
                                                    <h4 class="mb-1 text-danger">Unsubscribed failed. Please try after some times.</h4>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <div class="row">
                                            <div class="text-center">
                                                <img src="<?php echo site_url(); ?>/assets/images/logo_blue.png">
                                                <h2 class="mt-10 mb-10">Unsubscribe</h2>
                                            </div>
                                        </div>
                                        <form method="post">
                                            <div class="row">
                                                <p class="text-gray-600 fs-4">Your email address <b><?php echo $selected_advisor_data->email; ?></b></p>
                                                <p class="text-gray-600 fs-6">Your will not receive any more emails from <b>info@fortressbrokerage.com</b></p>
                                                <p class=" fs-6 mt-3"><b>You can:</b></p>
                                                <div class="mt-3 mb-7">
                                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input me-3" type="checkbox" name="unsubscribe_preference[]" value="all_emails" <?php echo ($advisor_stop_email) ? 'checked disabled' : ''; ?>>
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="fs-6">Unsubscribe from all emails</span>
                                                        <!--end::Label-->
                                                    </label>
                                                    <div class="separator separator-dashed my-6"></div>
                                                    <label class="form-check form-check-custom form-check-solid align-items-start">
                                                        <!--begin::Input-->
                                                        <input class="form-check-input me-3" type="checkbox" name="unsubscribe_preference[]" value="campaign" <?php echo ($campaign_stop) ? 'checked disabled' : ''; ?>>
                                                        <!--end::Input-->
                                                        <!--begin::Label-->
                                                        <span class="fs-6">Unsubscribe from the email campaign.</span>
                                                        <!--end::Label-->
                                                    </label>
                                                </div>
                                                <button type="submit" name="unsubscribe" class="btn btn-primary  px-6 w-auto" id="">Unsubscribe</button>
                                            </div>
                                        </form>
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
    <?php require SITE_DIR . '/footer_script.php'; ?>
</body>
<!--end::Body-->

</html>