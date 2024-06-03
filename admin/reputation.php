<?php require '../config.php';
$page_name = 'reputation';
$sub_page_name = '';
Admin()->check_login();

// Your Google Places API key
$apiKey = 'AIzaSyDWcAIndKrbI6UyBVfIFugYE5rqcQZhH9M';

// The Place ID of the location for which you want to fetch reviews
$placeId = 'ChIJv_-AdTsO9YgRK3WGs23Y5gY';

// The endpoint URL for the Place Details request
$url = "https://maps.googleapis.com/maps/api/place/details/json?place_id={$placeId}&key={$apiKey}";

// Initialize a cURL session
$curl = curl_init();

// Set the cURL options
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request and get the response
$response = curl_exec($curl);

// Close the cURL session
curl_close($curl);

// Decode the JSON response
$data = json_decode($response, true);

?>

<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/head.php'; ?>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_app_body" data-kt-app-header-fixed="true" data-kt-app-header-fixed-mobile="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" data-kt-app-aside-enabled="true" data-kt-app-aside-fixed="true" data-kt-app-aside-push-toolbar="true" data-kt-app-aside-push-footer="true" class="app-default view_advisor">
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

                        <?php
                        if (isset($_SESSION['process_activity_success'])) {
                            unset($_SESSION['process_activity_success']); ?>
                            <div class="alert alert-success d-flex align-items-center p-5 ms-lg-15">
                                <i class="ki-duotone ki-shield-tick fs-2hx text-success  me-4"><span class="path1"></span><span class="path2"></span></i>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1 text-success">The activity has been saved successfully.</h4>
                                </div>
                            </div>
                        <?php } ?>

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
                                                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Reputation</h1>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Page title-->
                                            <?php
                                            $bookmark = Advisor()->check_bookmark(site_url() . '/admin/reputation');

                                            if ($bookmark) { ?>
                                                <i class="bi bi-bookmarks-fill fs-2x cursor-pointer text-primary  bookmark_page" bookmark_url="<?php echo site_url(); ?>/admin/reputation"></i>
                                            <?php } else { ?>
                                                <i class="bi bi-bookmarks fs-2x cursor-pointer text-primary bookmark_page" data-bs-toggle="modal" data-bs-target="#kt_modal_bookmark_link" bookmark_name="Reputation" bookmark_url="<?php echo site_url(); ?>/admin/reputation"></i>
                                            <?php } ?>
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
                                        <!--begin::Card-->
                                        <div class="card">
                                            <!--begin::Card body-->
                                            <div class="card-body">
                                                <!--begin::Calendar-->
                                                <?php
                                                // Check if the request was successful
                                                if (isset($data['result']['reviews'])) {
                                                    // Get the reviews
                                                    $reviews = $data['result']['reviews'];

                                                    // Display the reviews
                                                    foreach ($reviews as $review) {
                                                        echo "Author: " . $review['author_name'] . "<br>";
                                                        echo "Rating: " . $review['rating'] . "<br>";
                                                        echo "Text: " . $review['text'] . "<br>";
                                                        echo "Time: " . date('Y-m-d H:i:s', $review['time']) . "<br>";
                                                        echo "<hr>";
                                                    }
                                                } else {
                                                    echo "No reviews found or an error occurred.";
                                                }

                                                ?>
                                                <!--end::Calendar-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Content container-->
                                </div>
                                <!--end::Content-->
                            </div>
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
    <!--begin::Drawers-->

    <!--end::Drawers-->
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
    <!--begin::Custom Javascript(used for this page only)-->

</body>
<!--end::Body-->

</html>