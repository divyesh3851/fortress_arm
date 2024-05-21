<?php require '../config.php';
$page_name = 'calendar';
$sub_page_name = '';
Admin()->check_login();

if (isset($_POST['save_activity'])) {

    if (sipost('activity_id')) {
        $response = Advisor()->update_activity();
    } else {
        $response = Advisor()->add_activity();
    }


    if ($response == 1) {
        $_SESSION['process_activity_success'] = true;
    } elseif ($response == 'duplicate') {
        $_SESSION['process_activity_duplicate'] = true;
    } else {
        $_SESSION['process_activity_fail'] = true;
    }

    wp_redirect(site_url() . '/admin/calendar');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/head.php'; ?>
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
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Page title-->
                                            <?php
                                            $bookmark = Advisor()->check_bookmark(site_url() . '/admin/calendar');

                                            if ($bookmark) { ?>
                                                <i class="bi bi-bookmarks-fill fs-2x cursor-pointer text-primary  bookmark_page" bookmark_url="<?php echo site_url(); ?>/admin/calendar"></i>
                                            <?php } else { ?>
                                                <i class="bi bi-bookmarks fs-2x cursor-pointer text-primary bookmark_page" data-bs-toggle="modal" data-bs-target="#kt_modal_bookmark_link" bookmark_name="Calendar" bookmark_url="<?php echo site_url(); ?>/admin/calendar"></i>
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
                                            <!--begin::Card header-->
                                            <div class="card-header">
                                                <div class="d-flex flex-stack flex-wrap gap-4 w-100">
                                                    <div class="d-flex flex-column justify-content-center gap-1 me-3">
                                                        <h2 class="card-title fw-bold">Calendar</h2>
                                                    </div>
                                                    <div class="w-25">
                                                        <select name="timezone" id="timezone" data-control="select2" data-placeholder="Select a Time Zone..." class="form-select form-select-solid" required>
                                                            <option value="">Select Time Zone</option>
                                                            <?php foreach (Settings()->get_timezone_list() as $key => $timezone_result) { ?>
                                                                <option <?php echo ($key == 7) ? 'selected' : ''; ?> value="<?php echo $key; ?>"><?php echo $timezone_result; ?></option>
                                                            <?php } ?>
                                                        </select>

                                                    </div>
                                                </div>

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
                                                <div id="activity_calendar"></div>
                                                <!--end::Calendar-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->
                                        <!--begin::Modals-->
                                        <!--begin::Modal - New Product-->
                                        <div class="modal fade" id="kt_modal_activity" tabindex-="1" aria-hidden="true" data-bs-focus="false">
                                            <!--begin::Modal dialog-->
                                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                                <!--begin::Modal content-->
                                                <div class="modal-content">
                                                    <!--begin::Modal header-->
                                                    <div class="modal-header">
                                                        <!--begin::Modal title-->
                                                        <h2 class="fw-bold" data-kt-calendar="title"> Event Details</h2>
                                                        <!--end::Modal title-->
                                                        <!--begin::Close-->
                                                        <div class="btn btn-icon btn-sm btn-active-icon-primary" id="kt_modal_activity_close" data-bs-dismiss="modal">
                                                            <i class="ki-outline ki-cross fs-1"></i>
                                                        </div>
                                                        <!--end::Close-->
                                                    </div>
                                                    <!--end::Modal header-->
                                                    <!--begin::Form-->
                                                    <div class="modal-body">
                                                        <form class="" id="kt_modal_activity_form" method="post" enctype="multipart/form-data">
                                                            <input type="hidden" name="activity_id" id="activity_id" class="is_empty" value="">
                                                            <div class="w-100">
                                                                <!--begin::Input group-->
                                                                <div class="row mb-7">
                                                                    <div class="col-md-8 fv-row">
                                                                        <!--begin::Label-->
                                                                        <label class="required fw-semibold fs-6 mb-2">Title</label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="title" id="activity_title" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Title" required />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <div class="col-md-4 fv-row">
                                                                        <!--begin::Label-->
                                                                        <label class="required fw-semibold fs-6 mb-2">Date</label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="date" id="activity_date" class="flatpickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Date" required />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                </div>
                                                                <!--begin::Input group-->
                                                                <div class="row mb-7">
                                                                    <div class="col-md-4 fv-row">
                                                                        <!--begin::Label-->
                                                                        <label class="required fw-semibold fs-6 mb-2">Recurring</label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <select name="recurring" id="recurring" data-control="select2" data-placeholder="Select ..." class="form-select form-select-solid is_empty" required>
                                                                            <option value="">Select </option>
                                                                            <option value="once"> Once </option>
                                                                            <option value="weekly"> Weekly </option>
                                                                            <option value="monthly"> Monthly </option>
                                                                            <option value="yearly"> Yearly </option>
                                                                        </select>
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <div class="col-md-4 fv-row">
                                                                        <!--begin::Label-->
                                                                        <label class=" fw-semibold fs-6 mb-2">Start Time</label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="start_time" id="activity_start_time" class="flat_time_pickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Start Time" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <div class="col-md-4 fv-row">
                                                                        <!--begin::Label-->
                                                                        <label class=" fw-semibold fs-6 mb-2">End Time</label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="end_time" id="activity_end_time" class="flat_time_pickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="End Time" data-bs-focus="true" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                </div>
                                                                <!--begin::Input group-->
                                                                <div class="row mb-7">
                                                                    <div class="col-md-6 fv-row">
                                                                        <!--begin::Label-->
                                                                        <label class="fw-semibold fs-6 mb-2">Type</label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <select name="type" id="activity_type" data-control="select2" data-placeholder="Select a Type..." class="form-select form-select-solid is_empty" required>
                                                                            <option value="">Select Type</option>
                                                                            <?php foreach (Settings()->get_activity_type_list() as $key => $type_result) { ?>
                                                                                <option value="<?php echo $key; ?>"><?php echo $type_result; ?></option>
                                                                            <?php } ?>
                                                                        </select>
                                                                        <!--end::Input-->
                                                                    </div>
                                                                    <div class="col-md-6 fv-row">
                                                                        <!--begin::Label-->
                                                                        <label class="fw-semibold fs-6 mb-2">Location</label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <input type="text" name="location" id="activity_location" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Location" />
                                                                        <!--end::Input-->
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-7">
                                                                    <div class="col-md-12 fv-row">
                                                                        <!--begin::Label-->
                                                                        <label class="fw-semibold fs-6 mb-2">Note</label>
                                                                        <!--end::Label-->
                                                                        <!--begin::Input-->
                                                                        <textarea type="text" name="note" id="activity_note" rows="5" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Note"></textarea>
                                                                        <!--end::Input-->
                                                                    </div>
                                                                </div>

                                                                <div class=" text-center">
                                                                    <!--begin::Button-->
                                                                    <button type="reset" id="kt_modal_activity_cancel" class="btn btn-light me-3">Cancel</button>
                                                                    <!--end::Button-->
                                                                    <!--begin::Button-->
                                                                    <button type="submit" name="save_activity" id="save_activity" class="btn btn-primary">
                                                                        <span class="indicator-label">Submit</span>
                                                                        <span class="indicator-progress">Please wait...
                                                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                                                    </button>
                                                                    <!--end::Button-->
                                                                </div>

                                                            </div>
                                                        </form>
                                                    </div>
                                                    <!--end::Form-->
                                                </div>
                                            </div>
                                        </div>
                                        <!--end::Modal - New Product-->
                                        <!--begin::Modal - New Product-->
                                        <div class="modal fade" id="kt_modal_view_activity" tabindex="-1" data-bs-focus="false" aria-hidden="true">
                                            <!--begin::Modal dialog-->
                                            <div class="modal-dialog modal-dialog-centered mw-650px">
                                                <!--begin::Modal content-->
                                                <div class="modal-content">
                                                    <!--begin::Modal header-->
                                                    <div class="modal-header border-0 justify-content-end">
                                                        <!--begin::Edit-->
                                                        <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary me-2" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Edit Activity" id="kt_modal_activity_edit">
                                                            <i class="ki-outline ki-pencil fs-2"></i>
                                                        </div>
                                                        <!--end::Edit-->
                                                        <!--begin::Edit-->
                                                        <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-danger me-2" data-bs-toggle="tooltip" data-bs-dismiss="click" title="Delete Activity" id="kt_modal_activity_delete">
                                                            <i class="ki-outline ki-trash fs-2"></i>
                                                        </div>
                                                        <!--end::Edit-->
                                                        <!--begin::Close-->
                                                        <div class="btn btn-icon btn-sm btn-color-gray-500 btn-active-icon-primary" data-bs-toggle="tooltip" title="Hide Activity" data-bs-dismiss="modal">
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
    <?php require SITE_DIR . '/footer_script.php'; ?>
    <script src="<?php echo site_url(); ?>/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used for this page only)-->
    <!--end::Custom Javascript-->
    <script>
        var kt_modal_activity = new bootstrap.Modal(document.getElementById('kt_modal_activity'));
        var kt_modal_view_activity = new bootstrap.Modal(document.getElementById('kt_modal_view_activity'));

        document.addEventListener('DOMContentLoaded', function() {
            var todayDate = moment().startOf('day');
            var YM = todayDate.format('YYYY-MM');
            var YESTERDAY = todayDate.clone().subtract(1, 'day').format('YYYY-MM-DD');
            var TODAY = todayDate.format('YYYY-MM-DD');
            var TOMORROW = todayDate.clone().add(1, 'day').format('YYYY-MM-DD');

            var calendarEl = document.getElementById('activity_calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: "prev,next today",
                    center: "title",
                    right: "dayGridMonth,timeGridWeek,timeGridDay",
                },
                height: 800,
                contentHeight: 780,
                aspectRatio: 3, // see: https://fullcalendar.io/docs/aspectRatio

                nowIndicator: true,
                now: TODAY + 'T09:25:00',
                initialDate: TODAY,
                editable: true,
                dayMaxEvents: true, // allow "more" link when too many events
                navLinks: true,
                selectable: true,
                selectAllow: function(selectInfo) {
                    return moment().diff(selectInfo.start) <= 0
                },
                select: function(arg) {

                    $(".is_empty").val("");
                    $("select.is_empty").val(null).trigger("change");
                    $("textarea.is_empty").html("");

                    $("#activity_date").val(change_ymd_to_dmy_text(arg.startStr));
                    kt_modal_activity.show();
                },

                eventClick: function(info) {

                    $(".is_empty").val("");

                    $("select.is_empty").val(null).trigger("change");

                    $("textarea.is_empty").html("");

                    $('[data-kt-calendar="event_name"]').html(info.event.title);
                    $('[data-kt-calendar="event_description"]').html(info.event.extendedProps.description);
                    $('[data-kt-calendar="event_start_date"]').html(info.event.extendedProps.activity_date + ' - ' + info.event.extendedProps.start_time);
                    $('[data-kt-calendar="event_end_date"]').html(info.event.extendedProps.activity_date + ' - ' + info.event.extendedProps.end_time);
                    $('[data-kt-calendar="event_location"]').html(info.event.extendedProps.location);
                    kt_modal_view_activity.show();

                    // Edit event button click handler
                    $('#kt_modal_activity_edit').on('click', function() {

                        kt_modal_view_activity.hide();

                        $("#activity_id").val(info.event.id);
                        $("#activity_title").val(info.event.title);
                        $("#activity_date").val(info.event.extendedProps.activity_date);
                        $("#recurring").val(info.event.extendedProps.recurring).trigger("change");
                        $("#activity_start_time").val(info.event.extendedProps.start_time);
                        $("#activity_end_time").val(info.event.extendedProps.end_time);
                        $("#activity_type").val(info.event.extendedProps.type).trigger("change");
                        $("#activity_location").val(info.event.extendedProps.location);
                        $("#activity_note").val(info.event.extendedProps.description);

                        kt_modal_activity.show();


                        // Hide modal
                        //$('#kt_modal_view_activity').modal('hide');
                    });

                    $('#kt_modal_activity_delete').on('click', function() {
                        kt_modal_activity.hide();
                        var event = calendar.getEventById(info.event.id);
                        if (event) {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to revert this!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Yes, delete it!'
                            }).then((result) => {

                                if (result.isConfirmed) {

                                    $.post(ajax_url, {
                                        action: 'delete_activity',
                                        activity_id: info.event.id,
                                        is_ajax: true,
                                    }, function(result) {

                                        var results = JSON.parse(result);

                                        if (results.status) {
                                            event.remove();
                                            Swal.fire(
                                                'Deleted!',
                                                'Your event has been deleted.',
                                                'success'
                                            );

                                            setTimeout(function() {
                                                location.reload();
                                            }, 1000);

                                        }

                                    });
                                }
                            });
                        }
                    });

                },
                events: {
                    url: site_url + '/admin/get_activity.php',
                },
                eventContent: function(info) {
                    var element = $(info.el);

                    if (info.event.extendedProps && info.event.extendedProps.description) {
                        if (element.hasClass('fc-day-grid-event')) {
                            element.data('content', info.event.extendedProps.description);
                            element.data('placement', 'top');
                            KTApp.initPopover(element);
                        } else if (element.hasClass('fc-time-grid-event')) {
                            element.find('.fc-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        } else if (element.find('.fc-list-item-title').lenght !== 0) {
                            element.find('.fc-list-item-title').append('<div class="fc-description">' + info.event.extendedProps.description + '</div>');
                        }
                    }
                },
                //datesSet: function() {},
            });
            calendar.render();
        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>