<?php require '../../config.php';
$page_name = 'message';
$sub_page_name = 'messages-list';
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
                        <!--begin::Toolbar-->
                        <div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
                            <!--begin::Toolbar container-->
                            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
                                <!--begin::Toolbar wrapper-->
                                <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                                    <!--begin::Page title-->
                                    <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                                        <!--begin::Title-->
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Messages</h1>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Page title-->
                                    <!--begin::Actions-->
                                    <div class="d-flex align-items-center gap-2 gap-lg-3">
                                    </div>
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
                                <!--begin::Layout-->
                                <div class="d-flex flex-column flex-lg-row">
                                    <!--begin::Sidebar-->
                                    <div class="flex-column flex-lg-row-auto w-100 w-lg-300px w-xl-400px mb-10 mb-lg-0">
                                        <!--begin::Contacts-->
                                        <div class="card card-flush">
                                            <!--begin::Card header-->
                                            <div class="card-header pt-7" id="kt_chat_contacts_header">
                                                <!--begin::Form-->
                                                <form class="w-100 position-relative" autocomplete="off">
                                                    <!--begin::Icon-->
                                                    <i class="ki-outline ki-magnifier fs-3 text-gray-500 position-absolute top-50 ms-5 translate-middle-y"></i>
                                                    <!--end::Icon-->
                                                    <!--begin::Input-->
                                                    <input type="text" class="form-control form-control-solid px-13" name="search" value="" placeholder="Search by username or email..." />
                                                    <!--end::Input-->
                                                </form>
                                                <!--end::Form-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body pt-5" id="kt_chat_contacts_body">
                                                <!--begin::List-->
                                                <div class="scroll-y me-n5 pe-5 h-200px h-lg-auto" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_toolbar, #kt_app_toolbar, #kt_footer, #kt_app_footer, #kt_chat_contacts_header" data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_contacts_body" data-kt-scroll-offset="5px">
                                                    <!--begin::User-->
                                                    <div class="d-flex flex-stack py-4">
                                                        <!--begin::Details-->
                                                        <div class="d-flex align-items-center">
                                                            <!--begin::Avatar-->
                                                            <div class="symbol symbol-45px symbol-circle">
                                                                <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">M</span>
                                                                <div class="symbol-badge bg-success start-100 top-100 border-4 h-8px w-8px ms-n2 mt-n2"></div>
                                                            </div>
                                                            <!--end::Avatar-->
                                                            <!--begin::Details-->
                                                            <div class="ms-5">
                                                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Melody Macy</a>
                                                                <div class="fw-semibold text-muted">melody@altbox.com</div>
                                                            </div>
                                                            <!--end::Details-->
                                                        </div>
                                                        <!--end::Details-->
                                                        <!--begin::Lat seen-->
                                                        <div class="d-flex flex-column align-items-end ms-2">
                                                            <span class="text-muted fs-7 mb-1">1 day</span>
                                                            <span class="badge badge-sm badge-circle badge-light-warning">9</span>
                                                        </div>
                                                        <!--end::Lat seen-->
                                                    </div>
                                                    <!--end::User-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed d-none"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::User-->
                                                    <div class="d-flex flex-stack py-4">
                                                        <!--begin::Details-->
                                                        <div class="d-flex align-items-center">
                                                            <!--begin::Avatar-->
                                                            <div class="symbol symbol-45px symbol-circle">
                                                                <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">O</span>
                                                            </div>
                                                            <!--end::Avatar-->
                                                            <!--begin::Details-->
                                                            <div class="ms-5">
                                                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Olivia Wild</a>
                                                                <div class="fw-semibold text-muted">olivia@corpmail.com</div>
                                                            </div>
                                                            <!--end::Details-->
                                                        </div>
                                                        <!--end::Details-->
                                                        <!--begin::Lat seen-->
                                                        <div class="d-flex flex-column align-items-end ms-2">
                                                            <span class="text-muted fs-7 mb-1">1 day</span>
                                                        </div>
                                                        <!--end::Lat seen-->
                                                    </div>
                                                    <!--end::User-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed d-none"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::User-->
                                                    <div class="d-flex flex-stack py-4">
                                                        <!--begin::Details-->
                                                        <div class="d-flex align-items-center">
                                                            <!--begin::Avatar-->
                                                            <div class="symbol symbol-45px symbol-circle">
                                                                <span class="symbol-label bg-light-primary text-primary fs-6 fw-bolder">N</span>
                                                                <div class="symbol-badge bg-success start-100 top-100 border-4 h-8px w-8px ms-n2 mt-n2"></div>
                                                            </div>
                                                            <!--end::Avatar-->
                                                            <!--begin::Details-->
                                                            <div class="ms-5">
                                                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Neil Owen</a>
                                                                <div class="fw-semibold text-muted">owen.neil@gmail.com</div>
                                                            </div>
                                                            <!--end::Details-->
                                                        </div>
                                                        <!--end::Details-->
                                                        <!--begin::Lat seen-->
                                                        <div class="d-flex flex-column align-items-end ms-2">
                                                            <span class="text-muted fs-7 mb-1">5 hrs</span>
                                                            <span class="badge badge-sm badge-circle badge-light-warning">9</span>
                                                        </div>
                                                        <!--end::Lat seen-->
                                                    </div>
                                                    <!--end::User-->
                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed d-none"></div>
                                                    <!--end::Separator-->

                                                    <!--begin::Separator-->
                                                    <div class="separator separator-dashed d-none"></div>
                                                    <!--end::Separator-->
                                                    <!--begin::User-->
                                                    <div class="d-flex flex-stack py-4">
                                                        <!--begin::Details-->
                                                        <div class="d-flex align-items-center">
                                                            <!--begin::Avatar-->
                                                            <div class="symbol symbol-45px symbol-circle">
                                                                <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">E</span>
                                                                <div class="symbol-badge bg-success start-100 top-100 border-4 h-8px w-8px ms-n2 mt-n2"></div>
                                                            </div>
                                                            <!--end::Avatar-->
                                                            <!--begin::Details-->
                                                            <div class="ms-5">
                                                                <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary mb-2">Emma Bold</a>
                                                                <div class="fw-semibold text-muted">emma@intenso.com</div>
                                                            </div>
                                                            <!--end::Details-->
                                                        </div>
                                                        <!--end::Details-->
                                                        <!--begin::Lat seen-->
                                                        <div class="d-flex flex-column align-items-end ms-2">
                                                            <span class="text-muted fs-7 mb-1">3 hrs</span>
                                                            <span class="badge badge-sm badge-circle badge-light-success">2</span>
                                                        </div>
                                                        <!--end::Lat seen-->
                                                    </div>
                                                    <!--end::User-->
                                                </div>
                                                <!--end::List-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Contacts-->
                                    </div>
                                    <!--end::Sidebar-->
                                    <!--begin::Content-->
                                    <div class="flex-lg-row-fluid ms-lg-7 ms-xl-10">
                                        <!--begin::Messenger-->
                                        <div class="card" id="kt_chat_messenger">
                                            <!--begin::Card header-->
                                            <div class="card-header" id="kt_chat_messenger_header">
                                                <!--begin::Title-->
                                                <div class="card-title">
                                                    <!--begin::User-->
                                                    <div class="d-flex justify-content-center flex-column me-3">
                                                        <a href="#" class="fs-4 fw-bold text-gray-900 text-hover-primary me-1 mb-2 lh-1">Melody Macy</a>
                                                        <!--begin::Info-->
                                                        <div class="mb-0 lh-1">
                                                            <span class="badge badge-success badge-circle w-10px h-10px me-1"></span>
                                                            <span class="fs-7 fw-semibold text-muted">Active</span>
                                                        </div>
                                                        <!--end::Info-->
                                                    </div>
                                                    <!--end::User-->
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body" id="kt_chat_messenger_body">
                                                <!--begin::Messages-->
                                                <div class="scroll-y me-n5 pe-5 h-300px h-lg-auto" data-kt-element="messages" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_header, #kt_app_header, #kt_app_toolbar, #kt_toolbar, #kt_footer, #kt_app_footer, #kt_chat_messenger_header, #kt_chat_messenger_footer" data-kt-scroll-wrappers="#kt_content, #kt_app_content, #kt_chat_messenger_body" data-kt-scroll-offset="5px">
                                                    <!--begin::Message(in)-->
                                                    <div class="d-flex justify-content-start mb-10">
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex flex-column align-items-start">
                                                            <!--begin::User-->
                                                            <div class="d-flex align-items-center mb-2">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-45px symbol-circle">
                                                                    <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">M</span>
                                                                    <div class="symbol-badge bg-success start-100 top-100 border-4 h-8px w-8px ms-n2 mt-n2"></div>
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-3">
                                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Melody Macy</a>
                                                                    <span class="text-muted fs-7 mb-1">2 mins</span>
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::User-->
                                                            <!--begin::Text-->
                                                            <div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">How likely are you to recommend our company to your friends and family ?</div>
                                                            <!--end::Text-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Message(in)-->
                                                    <!--begin::Message(out)-->
                                                    <div class="d-flex justify-content-end mb-10">
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex flex-column align-items-end">
                                                            <!--begin::User-->
                                                            <div class="d-flex align-items-center mb-2">
                                                                <!--begin::Details-->
                                                                <div class="me-3">
                                                                    <span class="text-muted fs-7 mb-1">5 mins</span>
                                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                                                </div>
                                                                <!--end::Details-->
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-45px symbol-circle">
                                                                    <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">A</span>
                                                                    <div class="symbol-badge bg-success start-100 top-100 border-4 h-8px w-8px ms-n2 mt-n2"></div>
                                                                </div>
                                                                <!--end::Avatar-->
                                                            </div>
                                                            <!--end::User-->
                                                            <!--begin::Text-->
                                                            <div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-end" data-kt-element="message-text">Hey there, we’re just writing to let you know that you’ve been subscribed to a repository on GitHub.</div>
                                                            <!--end::Text-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Message(out)-->
                                                    <!--begin::Message(in)-->
                                                    <div class="d-flex justify-content-start mb-10">
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex flex-column align-items-start">
                                                            <!--begin::User-->
                                                            <div class="d-flex align-items-center mb-2">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-45px symbol-circle">
                                                                    <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">M</span>
                                                                    <div class="symbol-badge bg-success start-100 top-100 border-4 h-8px w-8px ms-n2 mt-n2"></div>
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-3">
                                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Melody Macy</a>
                                                                    <span class="text-muted fs-7 mb-1">1 Hour</span>
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::User-->
                                                            <!--begin::Text-->
                                                            <div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">Ok, Understood!</div>
                                                            <!--end::Text-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Message(in)-->
                                                    <!--begin::Message(out)-->
                                                    <div class="d-flex justify-content-end mb-10">
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex flex-column align-items-end">
                                                            <!--begin::User-->
                                                            <div class="d-flex align-items-center mb-2">
                                                                <!--begin::Details-->
                                                                <div class="me-3">
                                                                    <span class="text-muted fs-7 mb-1">2 Hours</span>
                                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                                                </div>
                                                                <!--end::Details-->
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-45px symbol-circle">
                                                                    <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">A</span>
                                                                    <div class="symbol-badge bg-success start-100 top-100 border-4 h-8px w-8px ms-n2 mt-n2"></div>
                                                                </div>
                                                                <!--end::Avatar-->
                                                            </div>
                                                            <!--end::User-->
                                                            <!--begin::Text-->
                                                            <div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-end" data-kt-element="message-text">You’ll receive notifications for all issues, pull requests!</div>
                                                            <!--end::Text-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Message(out)-->
                                                    <!--begin::Message(in)-->
                                                    <div class="d-flex justify-content-start mb-10">
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex flex-column align-items-start">
                                                            <!--begin::User-->
                                                            <div class="d-flex align-items-center mb-2">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-45px symbol-circle">
                                                                    <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">M</span>
                                                                    <div class="symbol-badge bg-success start-100 top-100 border-4 h-8px w-8px ms-n2 mt-n2"></div>
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-3">
                                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Melody Macy</a>
                                                                    <span class="text-muted fs-7 mb-1">3 Hours</span>
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::User-->
                                                            <!--begin::Text-->
                                                            <div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">You can unwatch this repository immediately
                                                            </div>
                                                            <!--end::Text-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Message(in)-->
                                                    <!--begin::Message(out)-->
                                                    <div class="d-flex justify-content-end mb-10">
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex flex-column align-items-end">
                                                            <!--begin::User-->
                                                            <div class="d-flex align-items-center mb-2">
                                                                <!--begin::Details-->
                                                                <div class="me-3">
                                                                    <span class="text-muted fs-7 mb-1">4 Hours</span>
                                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                                                </div>
                                                                <!--end::Details-->
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-45px symbol-circle">
                                                                    <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">A</span>
                                                                    <div class="symbol-badge bg-success start-100 top-100 border-4 h-8px w-8px ms-n2 mt-n2"></div>
                                                                </div>
                                                                <!--end::Avatar-->
                                                            </div>
                                                            <!--end::User-->
                                                            <!--begin::Text-->
                                                            <div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-end" data-kt-element="message-text">Most purchased Business courses during this sale!</div>
                                                            <!--end::Text-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Message(out)-->
                                                    <!--begin::Message(in)-->
                                                    <div class="d-flex justify-content-start mb-10">
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex flex-column align-items-start">
                                                            <!--begin::User-->
                                                            <div class="d-flex align-items-center mb-2">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-45px symbol-circle">
                                                                    <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">M</span>
                                                                    <div class="symbol-badge bg-success start-100 top-100 border-4 h-8px w-8px ms-n2 mt-n2"></div>
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-3">
                                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Melody Macy</a>
                                                                    <span class="text-muted fs-7 mb-1">5 Hours</span>
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::User-->
                                                            <!--begin::Text-->
                                                            <div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">Company BBQ to celebrate the last quater achievements and goals. Food and drinks provided</div>
                                                            <!--end::Text-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Message(in)-->
                                                    <!--begin::Message(template for out)-->
                                                    <div class="d-flex justify-content-end mb-10 d-none" data-kt-element="template-out">
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex flex-column align-items-end">
                                                            <!--begin::User-->
                                                            <div class="d-flex align-items-center mb-2">
                                                                <!--begin::Details-->
                                                                <div class="me-3">
                                                                    <span class="text-muted fs-7 mb-1">Just now</span>
                                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary ms-1">You</a>
                                                                </div>
                                                                <!--end::Details-->
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-45px symbol-circle">
                                                                    <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">A</span>
                                                                    <div class="symbol-badge bg-success start-100 top-100 border-4 h-8px w-8px ms-n2 mt-n2"></div>
                                                                </div>
                                                                <!--end::Avatar-->
                                                            </div>
                                                            <!--end::User-->
                                                            <!--begin::Text-->
                                                            <div class="p-5 rounded bg-light-primary text-gray-900 fw-semibold mw-lg-400px text-end" data-kt-element="message-text"></div>
                                                            <!--end::Text-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Message(template for out)-->
                                                    <!--begin::Message(template for in)-->
                                                    <div class="d-flex justify-content-start mb-10 d-none" data-kt-element="template-in">
                                                        <!--begin::Wrapper-->
                                                        <div class="d-flex flex-column align-items-start">
                                                            <!--begin::User-->
                                                            <div class="d-flex align-items-center mb-2">
                                                                <!--begin::Avatar-->
                                                                <div class="symbol symbol-45px symbol-circle">
                                                                    <span class="symbol-label bg-light-danger text-danger fs-6 fw-bolder">M</span>
                                                                    <div class="symbol-badge bg-success start-100 top-100 border-4 h-8px w-8px ms-n2 mt-n2"></div>
                                                                </div>
                                                                <!--end::Avatar-->
                                                                <!--begin::Details-->
                                                                <div class="ms-3">
                                                                    <a href="#" class="fs-5 fw-bold text-gray-900 text-hover-primary me-1">Melody Macy</a>
                                                                    <span class="text-muted fs-7 mb-1">Just now</span>
                                                                </div>
                                                                <!--end::Details-->
                                                            </div>
                                                            <!--end::User-->
                                                            <!--begin::Text-->
                                                            <div class="p-5 rounded bg-light-info text-gray-900 fw-semibold mw-lg-400px text-start" data-kt-element="message-text">Right before vacation season we have the next Big Deal for you.</div>
                                                            <!--end::Text-->
                                                        </div>
                                                        <!--end::Wrapper-->
                                                    </div>
                                                    <!--end::Message(template for in)-->
                                                </div>
                                                <!--end::Messages-->
                                            </div>
                                            <!--end::Card body-->
                                            <!--begin::Card footer-->
                                            <div class="card-footer pt-4" id="kt_chat_messenger_footer">
                                                <!--begin::Input-->
                                                <textarea class="form-control form-control-flush mb-3" rows="1" data-kt-element="input" placeholder="Type a message"></textarea>
                                                <!--end::Input-->
                                                <!--begin:Toolbar-->
                                                <div class="d-flex flex-stack">
                                                    <!--begin::Actions-->
                                                    <div class="d-flex align-items-center me-2">
                                                        <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="Coming soon">
                                                            <i class="ki-outline ki-paper-clip fs-3"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-icon btn-active-light-primary me-1" type="button" data-bs-toggle="tooltip" title="Coming soon">
                                                            <i class="ki-outline ki-exit-up fs-3"></i>
                                                        </button>
                                                    </div>
                                                    <!--end::Actions-->
                                                    <!--begin::Send-->
                                                    <button class="btn btn-primary" type="button" data-kt-element="send">Send</button>
                                                    <!--end::Send-->
                                                </div>
                                                <!--end::Toolbar-->
                                            </div>
                                            <!--end::Card footer-->
                                        </div>
                                        <!--end::Messenger-->
                                    </div>
                                    <!--end::Content-->
                                </div>
                                <!--end::Layout-->
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
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="<?php echo site_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/inbox/listing.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/widgets.bundle.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/widgets.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/chat/chat.js"></script>
    <!--end::Vendors Javascript-->
</body>
<!--end::Body-->

</html>