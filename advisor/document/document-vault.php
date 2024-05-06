<?php require '../../config.php';
$page_name = 'doc_vault';
$sub_page_name = 'doc-list';
Advisor()->check_advisor_login();
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
            <?php require SITE_DIR . '/advisor/header.php'; ?>
            <!--end::Header-->
            <!--begin::Wrapper-->
            <div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
                <!--begin::Sidebar-->
                <?php require SITE_DIR . '/advisor/sidebar.php'; ?>
                <!--end::Sidebar-->
                <!--begin::Main-->
                <div class="app-main flex-column flex-row-fluid" id="kt_app_main">
                    <!--begin::Content wrapper-->
                    <div class="d-flex flex-column flex-column-fluid">
                        <!--begin::Content-->
                        <div id="kt_app_content" class="app-content flex-column-fluid pt-1">
                            <!--begin::Content container-->
                            <div id="kt_app_content_container" class="app-container container-fluid">

                                <!--begin::Documents toolbar-->
                                <div class="d-flex flex-wrap flex-stack mb-6">
                                    <!--begin::Title-->
                                    <h3 class="fw-bold my-2">My Documents
                                        <span class="fs-6 text-gray-500 fw-semibold ms-1">100+ resources</span>
                                    </h3>
                                    <!--end::Title-->
                                    <!--begin::Controls-->
                                    <div class="d-flex my-2">
                                        <!--begin::Search-->
                                        <div class="d-flex align-items-center position-relative me-4">
                                            <i class="ki-outline ki-magnifier fs-3 position-absolute ms-3"></i>
                                            <input type="text" id="kt_filter_search" class="form-control form-control-sm form-control-solid w-150px ps-10" placeholder="Search" />
                                        </div>
                                        <!--end::Search-->
                                    </div>
                                    <!--end::Controls-->
                                </div>
                                <!--end::Documents toolbar-->
                                <!--begin::Row-->
                                <!--begin::Row-->
                                <div class="row g-6 g-xl-9 mb-6 mb-xl-9">
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <!--begin::Card-->
                                        <div class="card h-100">
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                                <!--begin::Name-->
                                                <a href="" class="text-gray-800 text-hover-primary d-flex flex-column">
                                                    <!--begin::Image-->
                                                    <div class="symbol symbol-75px mb-5">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/folder-document.svg" class="theme-light-show" alt="" />
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/folder-document-dark.svg" class="theme-dark-show" alt="" />
                                                    </div>
                                                    <!--end::Image-->
                                                    <!--begin::Title-->
                                                    <div class="fs-5 fw-bold mb-2">Finance</div>
                                                    <!--end::Title-->
                                                </a>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <div class="fs-7 fw-semibold text-gray-500">7 files</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <!--begin::Card-->
                                        <div class="card h-100">
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                                <!--begin::Name-->
                                                <a href="" class="text-gray-800 text-hover-primary d-flex flex-column">
                                                    <!--begin::Image-->
                                                    <div class="symbol symbol-75px mb-5">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/folder-document.svg" class="theme-light-show" alt="" />
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/folder-document-dark.svg" class="theme-dark-show" alt="" />
                                                    </div>
                                                    <!--end::Image-->
                                                    <!--begin::Title-->
                                                    <div class="fs-5 fw-bold mb-2">Customers</div>
                                                    <!--end::Title-->
                                                </a>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <div class="fs-7 fw-semibold text-gray-500">3 files</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <!--begin::Card-->
                                        <div class="card h-100">
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                                <!--begin::Name-->
                                                <a href="" class="text-gray-800 text-hover-primary d-flex flex-column">
                                                    <!--begin::Image-->
                                                    <div class="symbol symbol-75px mb-5">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/folder-document.svg" class="theme-light-show" alt="" />
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/folder-document-dark.svg" class="theme-dark-show" alt="" />
                                                    </div>
                                                    <!--end::Image-->
                                                    <!--begin::Title-->
                                                    <div class="fs-5 fw-bold mb-2">CRM Project</div>
                                                    <!--end::Title-->
                                                </a>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <div class="fs-7 fw-semibold text-gray-500">25 files</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end:Row-->
                                <div class="row g-6 g-xl-9 mb-6 mb-xl-9">
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <!--begin::Card-->
                                        <div class="card h-100">
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                                <!--begin::Name-->
                                                <a href="" class="text-gray-800 text-hover-primary d-flex flex-column">
                                                    <!--begin::Image-->
                                                    <div class="symbol symbol-60px mb-5">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/pdf.svg" class="theme-light-show" alt="" />
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/pdf-dark.svg" class="theme-dark-show" alt="" />
                                                    </div>
                                                    <!--end::Image-->
                                                    <!--begin::Title-->
                                                    <div class="fs-5 fw-bold mb-2">Project Reqs..</div>
                                                    <!--end::Title-->
                                                </a>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <div class="fs-7 fw-semibold text-gray-500">3 days ago</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <!--begin::Card-->
                                        <div class="card h-100">
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                                <!--begin::Name-->
                                                <a href="" class="text-gray-800 text-hover-primary d-flex flex-column">
                                                    <!--begin::Image-->
                                                    <div class="symbol symbol-60px mb-5">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/doc.svg" class="theme-light-show" alt="" />
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/doc-dark.svg" class="theme-dark-show" alt="" />
                                                    </div>
                                                    <!--end::Image-->
                                                    <!--begin::Title-->
                                                    <div class="fs-5 fw-bold mb-2">CRM App Docs..</div>
                                                    <!--end::Title-->
                                                </a>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <div class="fs-7 fw-semibold text-gray-500">3 days ago</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <!--begin::Card-->
                                        <div class="card h-100">
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                                <!--begin::Name-->
                                                <a href="" class="text-gray-800 text-hover-primary d-flex flex-column">
                                                    <!--begin::Image-->
                                                    <div class="symbol symbol-60px mb-5">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/css.svg" class="theme-light-show" alt="" />
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/css-dark.svg" class="theme-dark-show" alt="" />
                                                    </div>
                                                    <!--end::Image-->
                                                    <!--begin::Title-->
                                                    <div class="fs-5 fw-bold mb-2">User CRUD Styles</div>
                                                    <!--end::Title-->
                                                </a>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <div class="fs-7 fw-semibold text-gray-500">4 days ago</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <!--begin::Card-->
                                        <div class="card h-100">
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                                <!--begin::Name-->
                                                <a href="" class="text-gray-800 text-hover-primary d-flex flex-column">
                                                    <!--begin::Image-->
                                                    <div class="symbol symbol-60px mb-5">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/ai.svg" class="theme-light-show" alt="" />
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/ai-dark.svg" class="theme-dark-show" alt="" />
                                                    </div>
                                                    <!--end::Image-->
                                                    <!--begin::Title-->
                                                    <div class="fs-5 fw-bold mb-2">Product Logo</div>
                                                    <!--end::Title-->
                                                </a>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <div class="fs-7 fw-semibold text-gray-500">5 days ago</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <!--begin::Card-->
                                        <div class="card h-100">
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                                <!--begin::Name-->
                                                <a href="" class="text-gray-800 text-hover-primary d-flex flex-column">
                                                    <!--begin::Image-->
                                                    <div class="symbol symbol-60px mb-5">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/sql.svg" class="theme-light-show" alt="" />
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/sql-dark.svg" class="theme-dark-show" alt="" />
                                                    </div>
                                                    <!--end::Image-->
                                                    <!--begin::Title-->
                                                    <div class="fs-5 fw-bold mb-2">Orders backup</div>
                                                    <!--end::Title-->
                                                </a>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <div class="fs-7 fw-semibold text-gray-500">1 week ago</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <!--begin::Card-->
                                        <div class="card h-100">
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                                <!--begin::Name-->
                                                <a href="" class="text-gray-800 text-hover-primary d-flex flex-column">
                                                    <!--begin::Image-->
                                                    <div class="symbol symbol-60px mb-5">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/xml.svg" class="theme-light-show" alt="" />
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/xml-dark.svg" class="theme-dark-show" alt="" />
                                                    </div>
                                                    <!--end::Image-->
                                                    <!--begin::Title-->
                                                    <div class="fs-5 fw-bold mb-2">UTAIR CRM API Co..</div>
                                                    <!--end::Title-->
                                                </a>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <div class="fs-7 fw-semibold text-gray-500">2 weeks ago</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                    <!--begin::Col-->
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <!--begin::Card-->
                                        <div class="card h-100">
                                            <!--begin::Card body-->
                                            <div class="card-body d-flex justify-content-center text-center flex-column p-8">
                                                <!--begin::Name-->
                                                <a href="" class="text-gray-800 text-hover-primary d-flex flex-column">
                                                    <!--begin::Image-->
                                                    <div class="symbol symbol-60px mb-5">
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/tif.svg" class="theme-light-show" alt="" />
                                                        <img src="<?php echo site_url(); ?>/assets/media/svg/files/tif-dark.svg" class="theme-dark-show" alt="" />
                                                    </div>
                                                    <!--end::Image-->
                                                    <!--begin::Title-->
                                                    <div class="fs-5 fw-bold mb-2">Tower Hill App..</div>
                                                    <!--end::Title-->
                                                </a>
                                                <!--end::Name-->
                                                <!--begin::Description-->
                                                <div class="fs-7 fw-semibold text-gray-500">3 weeks ago</div>
                                                <!--end::Description-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                    </div>
                                    <!--end::Col-->
                                </div>
                                <!--end:Row-->
                            </div>
                            <!--end::Content container-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Content wrapper-->
                    <!--begin::Footer-->
                    <?php require SITE_DIR . '/advisor/footer.php'; ?>
                    <!--end::Footer-->
                </div>
                <!--end:::Main-->
                <!--begin::aside-->
                <?php require SITE_DIR . '/advisor/right_sidebar.php'; ?>
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
</body>
<!--end::Body-->

</html>