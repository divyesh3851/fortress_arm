<?php require '../config.php';
$page_name = 'calendar';
$sub_page_name = '';
Admin()->check_login();

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/admin/head.php'; ?>
    <link href="<?php echo site_url(); ?>/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
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

                        <?php if (isset($_SESSION['process_success'])) {
                            unset($_SESSION['process_success']); ?>
                            <div class="alert alert-success d-flex align-items-center p-5 ms-lg-15">
                                <i class="ki-duotone ki-shield-tick fs-2hx text-success  me-4"><span class="path1"></span><span class="path2"></span></i>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1 text-success">The note has been save successfully.</h4>
                                </div>
                            </div>
                        <?php }

                        if (isset($_SESSION['process_fail'])) {
                            unset($_SESSION['process_fail']); ?>
                            <div class="alert alert-danger d-flex align-items-center p-5 ms-lg-15">
                                <i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1 text-danger">Saving the note has failed.</h4>
                                </div>
                            </div>
                        <?php }
                        ?>

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
                                                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Calendar</h1>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Page title-->
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
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <h2 class="card-title fw-bold">Calendar</h2>
                                                <?php /* 
                                                <div class="card-toolbar">
                                                    <button class="btn btn-flex btn-primary" data-kt-calendar="add">
                                                        <i class="ki-outline ki-plus fs-2"></i>Add Event</button>
                                                </div>
                                                */ ?>
                                            </div>
                                            <!--end::Card header-->
                                            <!--begin::Card body-->
                                            <div class="card-body">
                                                <!--begin::Calendar-->
                                                <div id="kt_calendar_app"></div>
                                                <!--end::Calendar-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                        <!--begin::Modals-->
                                        <!--begin::Modal - New Product-->
                                        <div class="modal fade" id="kt_modal_add_event" tabindex-="1" aria-hidden="true" data-bs-focus="false">
                                            <!--begin::Modal dialog-->
                                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                                <!--begin::Modal content-->
                                                <div class="modal-content">
                                                    <!--begin::Form-->
                                                    <form class="form" action="#" id="kt_modal_add_event_form">
                                                        <!--begin::Modal header-->
                                                        <div class="modal-header">
                                                            <!--begin::Modal title-->
                                                            <h2 class="fw-bold" data-kt-calendar="title">Add Event</h2>
                                                            <!--end::Modal title-->
                                                            <!--begin::Close-->
                                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" id="kt_modal_add_event_close">
                                                                <i class="ki-outline ki-cross fs-1"></i>
                                                            </div>
                                                            <!--end::Close-->
                                                        </div>
                                                        <!--end::Modal header-->
                                                        <!--begin::Modal body-->
                                                        <div class="modal-body py-10 px-lg-17">
                                                            <!--begin::Input group-->
                                                            <div class="fv-row mb-9">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-semibold required mb-2">Event Name</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid" placeholder="" name="calendar_event_name" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                            <!--begin::Input group-->
                                                            <div class="fv-row mb-9">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-semibold mb-2">Event Description</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid" placeholder="" name="calendar_event_description" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                            <!--begin::Input group-->
                                                            <div class="fv-row mb-9">
                                                                <!--begin::Label-->
                                                                <label class="fs-6 fw-semibold mb-2">Event Location</label>
                                                                <!--end::Label-->
                                                                <!--begin::Input-->
                                                                <input type="text" class="form-control form-control-solid" placeholder="" name="calendar_event_location" />
                                                                <!--end::Input-->
                                                            </div>
                                                            <!--end::Input group-->
                                                            <!--begin::Input group-->
                                                            <div class="fv-row mb-9">
                                                                <!--begin::Checkbox-->
                                                                <label class="form-check form-check-custom form-check-solid">
                                                                    <input class="form-check-input" type="checkbox" value="" id="kt_calendar_datepicker_allday" />
                                                                    <span class="form-check-label fw-semibold" for="kt_calendar_datepicker_allday">All Day</span>
                                                                </label>
                                                                <!--end::Checkbox-->
                                                            </div>
                                                            <!--end::Input group-->
                                                            <!--begin::Input group-->
                                                            <div class="row row-cols-lg-2 g-10">
                                                                <div class="col">
                                                                    <div class="fv-row mb-9">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-semibold mb-2 required">Event Start Date</label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input class="form-control form-control-solid" name="calendar_event_start_date" placeholder="Pick a start date" id="kt_calendar_datepicker_start_date" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                </div>
                                                                <div class="col" data-kt-calendar="datepicker">
                                                                    <div class="fv-row mb-9">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-semibold mb-2">Event Start Time</label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input class="form-control form-control-solid" name="calendar_event_start_time" placeholder="Pick a start time" id="kt_calendar_datepicker_start_time" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end::Input group-->
                                                            <!--begin::Input group-->
                                                            <div class="row row-cols-lg-2 g-10">
                                                                <div class="col">
                                                                    <div class="fv-row mb-9">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-semibold mb-2 required">Event End Date</label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input class="form-control form-control-solid" name="calendar_event_end_date" placeholder="Pick a end date" id="kt_calendar_datepicker_end_date" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                </div>
                                                                <div class="col" data-kt-calendar="datepicker">
                                                                    <div class="fv-row mb-9">
                                                                        <!--begin::Label-->
                                                                        <label class="fs-6 fw-semibold mb-2">Event End Time</label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input class="form-control form-control-solid" name="calendar_event_end_time" placeholder="Pick a end time" id="kt_calendar_datepicker_end_time" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end::Input group-->
                                                        </div>
                                                        <!--end::Modal body-->
                                                        <!--begin::Modal footer-->
                                                        <div class="modal-footer flex-center">
                                                            <!--begin::Button-->
                                                            <button type="reset" id="kt_modal_add_event_cancel" class="btn btn-light me-3">Cancel</button>
                                                            <!--end::Button-->
                                                            <!--begin::Button-->
                                                            <button type="button" id="kt_modal_add_event_submit" class="btn btn-primary">
                                                                <span class="indicator-label">Submit</span>
                                                                <span class="indicator-progress">Please wait...
                                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                            </button>
                                                            <!--end::Button-->
                                                        </div>
                                                        <!--end::Modal footer-->
                                                    </form>
                                                    <!--end::Form-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Modal - New Product-->
                                        <!--begin::Modal - New Product-->
                                        <div class="modal fade" id="kt_modal_view_event" tabindex="-1" data-bs-focus="false" aria-hidden="true">
                                            <!--begin::Modal dialog-->
                                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                                <!--begin::Modal content-->
                                                <div class="modal-content">
                                                    <!--begin::Modal header-->
                                                    <div class="modal-header border-0 justify-content-end">
                                                        <!--begin::Edit-->
                                                        <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary me-2" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Edit Event" id="kt_modal_view_event_edit">
                                                            <i class="ki-outline ki-pencil fs-2"></i>
                                                        </div>
                                                        <!--end::Edit-->
                                                        <!--begin::Edit-->
                                                        <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-danger me-2" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Delete Event" id="kt_modal_view_event_delete">
                                                            <i class="ki-outline ki-trash fs-2"></i>
                                                        </div>
                                                        <!--end::Edit-->
                                                        <!--begin::Close-->
                                                        <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary" data-bs-toggle="tooltip" title="Hide Event" data-bs-dismiss="modal">
                                                            <i class="ki-outline ki-cross fs-2x"></i>
                                                        </div>
                                                        <!--end::Close-->
                                                    </div>
                                                    <!--end::Modal header-->
                                                    <!--begin::Modal body-->
                                                    <div class="modal-body pt-0 pb-20 px-lg-17">
                                                        <!--begin::Row-->
                                                        <div class="d-flex">
                                                            <!--begin::Icon-->
                                                            <i class="ki-outline ki-calendar-8 fs-1 text-muted me-5"></i>
                                                            <!--end::Icon-->
                                                            <div class="mb-9">
                                                                <!--begin::Event name-->
                                                                <div class="d-flex align-items-center mb-2">
                                                                    <span class="fs-3 fw-bold me-3" data-kt-calendar="event_name"></span>
                                                                    <span class="badge badge-light-success" data-kt-calendar="all_day"></span>
                                                                </div>
                                                                <!--end::Event name-->
                                                                <!--begin::Event description-->
                                                                <div class="fs-6" data-kt-calendar="event_description"></div>
                                                                <!--end::Event description-->
                                                            </div>
                                                        </div>
                                                        <!--end::Row-->
                                                        <!--begin::Row-->
                                                        <div class="d-flex align-items-center mb-2">
                                                            <!--begin::Bullet-->
                                                            <span class="bullet bullet-dot h-10px w-10px bg-success ms-2 me-7"></span>
                                                            <!--end::Bullet-->
                                                            <!--begin::Event start date/time-->
                                                            <div class="fs-6">
                                                                <span class="fw-bold">Starts</span>
                                                                <span data-kt-calendar="event_start_date"></span>
                                                            </div>
                                                            <!--end::Event start date/time-->
                                                        </div>
                                                        <!--end::Row-->
                                                        <!--begin::Row-->
                                                        <div class="d-flex align-items-center mb-9">
                                                            <!--begin::Bullet-->
                                                            <span class="bullet bullet-dot h-10px w-10px bg-danger ms-2 me-7"></span>
                                                            <!--end::Bullet-->
                                                            <!--begin::Event end date/time-->
                                                            <div class="fs-6">
                                                                <span class="fw-bold">Ends</span>
                                                                <span data-kt-calendar="event_end_date"></span>
                                                            </div>
                                                            <!--end::Event end date/time-->
                                                        </div>
                                                        <!--end::Row-->
                                                        <!--begin::Row-->
                                                        <div class="d-flex align-items-center">
                                                            <!--begin::Icon-->
                                                            <i class="ki-outline ki-geolocation fs-1 text-muted me-5"></i>
                                                            <!--end::Icon-->
                                                            <!--begin::Event location-->
                                                            <div class="fs-6" data-kt-calendar="event_location"></div>
                                                            <!--end::Event location-->
                                                        </div>
                                                        <!--end::Row-->
                                                    </div>
                                                    <!--end::Modal body-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Modal - New Product-->
                                        <!--end::Modals-->
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
    <?php require SITE_DIR . '/admin/footer_script.php'; ?>
    <script src="<?php echo site_url(); ?>/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/custom/apps/calendar/calendar.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used for this page only)-->
    <!--end::Custom Javascript-->
    <script>
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>