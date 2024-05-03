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
                                <?php /*
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
                                */ ?>
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
                                                <div id="event_calendar"></div>
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
                                                            <div class="btn btn-icon btn-sm btn-active-icon-primary" id="kt_modal_add_event_close" data-bs-dismiss="modal">
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
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used for this page only)-->
    <!--end::Custom Javascript-->
    <script>
        "use strict";
        var KTAppCalendar = (function() {
            var e,
                t,
                n,
                a,
                o,
                r,
                i,
                l,
                d,
                c,
                s,
                m,
                u,
                v,
                f,
                p,
                y,
                D,
                k,
                _,
                b,
                g,
                S,
                h,
                T,
                Y,
                w,
                x,
                L,
                E = {
                    id: "",
                    eventName: "",
                    eventDescription: "",
                    eventLocation: "",
                    startDate: "",
                    endDate: "",
                    allDay: !1
                };
            const M = () => {
                    (v.innerText = "Activity Details"), u.show();
                    const o = f.querySelectorAll('[data-kt-calendar="datepicker"]'),
                        i = f.querySelector("#kt_calendar_datepicker_allday");
                    i.addEventListener("click", (e) => {
                            e.target.checked ?
                                o.forEach((e) => {
                                    e.classList.add("d-none");
                                }) :
                                (l.setDate(E.startDate, !0, "Y-m-d"),
                                    o.forEach((e) => {
                                        e.classList.remove("d-none");
                                    }));
                        }),
                        C(E),
                        D.addEventListener("click", function(o) {
                            o.preventDefault(),
                                p &&
                                p.validate().then(function(o) {
                                    console.log("validated!"),
                                        "Valid" == o ?
                                        (D.setAttribute("data-kt-indicator", "on"),
                                            (D.disabled = !0),
                                            setTimeout(function() {
                                                D.removeAttribute("data-kt-indicator"),
                                                    Swal.fire({
                                                        text: "New event added to calendar!",
                                                        icon: "success",
                                                        buttonsStyling: !1,
                                                        confirmButtonText: "Ok, got it!",
                                                        customClass: {
                                                            confirmButton: "btn btn-primary"
                                                        }
                                                    }).then(function(
                                                        o
                                                    ) {
                                                        if (o.isConfirmed) {
                                                            u.hide(), (D.disabled = !1);
                                                            let o = !1;
                                                            i.checked && (o = !0), 0 === c.selectedDates.length && (o = !0);
                                                            var d = moment(r.selectedDates[0]).format(),
                                                                s = moment(l.selectedDates[l.selectedDates.length - 1]).format();
                                                            if (!o) {
                                                                const e = moment(r.selectedDates[0]).format("YYYY-MM-DD"),
                                                                    t = e;
                                                                (d = e + "T" + moment(c.selectedDates[0]).format("HH:mm:ss")), (s = t + "T" + moment(m.selectedDates[0]).format("HH:mm:ss"));
                                                            }
                                                            e.addEvent({
                                                                id: A(),
                                                                title: t.value,
                                                                description: n.value,
                                                                location: a.value,
                                                                start: d,
                                                                end: s,
                                                                allDay: o
                                                            }), e.render(), f.reset();
                                                        }
                                                    });
                                            }, 2e3)) :
                                        Swal.fire({
                                            text: "Sorry, looks like there are some errors detected, please try again.",
                                            icon: "error",
                                            buttonsStyling: !1,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            },
                                        });
                                });
                        });
                },
                B = () => {
                    var e, t, n;
                    w.show(),
                        E.allDay ?
                        ((e = ""), (t = moment(E.startDate).format("Do MMM, YYYY")), (n = moment(E.endDate).format("Do MMM, YYYY"))) :
                        ((e = ""), (t = moment(E.startDate).format("Do MMM, YYYY - h:mm a")), (n = moment(E.endDate).format("Do MMM, YYYY - h:mm a"))),
                        (b.innerText = E.eventName),
                        (g.innerText = e),
                        (S.innerText = E.eventDescription ? E.eventDescription : "--"),
                        (h.innerText = E.eventLocation ? E.eventLocation : "--"),
                        (T.innerText = t),
                        (Y.innerText = n);
                },
                q = () => {
                    x.addEventListener("click", (o) => {
                        o.preventDefault(),
                            w.hide(),
                            (() => {
                                (v.innerText = "Edit an activity"), u.show();
                                const o = f.querySelectorAll('[data-kt-calendar="datepicker"]'),
                                    i = f.querySelector("#kt_calendar_datepicker_allday");
                                i.addEventListener("click", (e) => {
                                        e.target.checked ?
                                            o.forEach((e) => {
                                                e.classList.add("d-none");
                                            }) :
                                            (l.setDate(E.startDate, !0, "Y-m-d"),
                                                o.forEach((e) => {
                                                    e.classList.remove("d-none");
                                                }));
                                    }),
                                    C(E),
                                    D.addEventListener("click", function(o) {
                                        o.preventDefault(),
                                            p &&
                                            p.validate().then(function(o) {
                                                console.log("validated!"),
                                                    "Valid" == o ?
                                                    (D.setAttribute("data-kt-indicator", "on"),
                                                        (D.disabled = !0),
                                                        setTimeout(function() {
                                                            D.removeAttribute("data-kt-indicator"),
                                                                Swal.fire({
                                                                    text: "New event added to calendar!",
                                                                    icon: "success",
                                                                    buttonsStyling: !1,
                                                                    confirmButtonText: "Ok, got it!",
                                                                    customClass: {
                                                                        confirmButton: "btn btn-primary"
                                                                    },
                                                                }).then(function(o) {
                                                                    if (o.isConfirmed) {
                                                                        u.hide(), (D.disabled = !1), e.getEventById(E.id).remove();
                                                                        let o = !1;
                                                                        i.checked && (o = !0), 0 === c.selectedDates.length && (o = !0);
                                                                        var d = moment(r.selectedDates[0]).format(),
                                                                            s = moment(l.selectedDates[l.selectedDates.length - 1]).format();
                                                                        if (!o) {
                                                                            const e = moment(r.selectedDates[0]).format("YYYY-MM-DD"),
                                                                                t = e;
                                                                            (d = e + "T" + moment(c.selectedDates[0]).format("HH:mm:ss")), (s = t + "T" + moment(m.selectedDates[0]).format("HH:mm:ss"));
                                                                        }
                                                                        e.addEvent({
                                                                            id: A(),
                                                                            title: t.value,
                                                                            description: n.value,
                                                                            location: a.value,
                                                                            start: d,
                                                                            end: s,
                                                                            allDay: o
                                                                        }), e.render(), f.reset();
                                                                    }
                                                                });
                                                        }, 2e3)) :
                                                    Swal.fire({
                                                        text: "Sorry, looks like there are some errors detected, please try again.",
                                                        icon: "error",
                                                        buttonsStyling: !1,
                                                        confirmButtonText: "Ok, got it!",
                                                        customClass: {
                                                            confirmButton: "btn btn-primary"
                                                        },
                                                    });
                                            });
                                    });
                            })();
                    });
                },
                C = () => {
                    (t.value = E.eventName ? E.eventName : ""), (n.value = E.eventDescription ? E.eventDescription : ""), (a.value = E.eventLocation ? E.eventLocation : ""), r.setDate(E.startDate, !0, "Y-m-d");
                    const e = E.endDate ? E.endDate : moment(E.startDate).format();
                    l.setDate(e, !0, "Y-m-d");
                    const o = f.querySelector("#kt_calendar_datepicker_allday"),
                        i = f.querySelectorAll('[data-kt-calendar="datepicker"]');
                    E.allDay ?
                        ((o.checked = !0),
                            i.forEach((e) => {
                                e.classList.add("d-none");
                            })) :
                        (c.setDate(E.startDate, !0, "Y-m-d H:i"),
                            m.setDate(E.endDate, !0, "Y-m-d H:i"),
                            l.setDate(E.startDate, !0, "Y-m-d"),
                            (o.checked = !1),
                            i.forEach((e) => {
                                e.classList.remove("d-none");
                            }));
                },
                N = (e) => {
                    (E.id = e.id), (E.eventName = e.title), (E.eventDescription = e.description), (E.eventLocation = e.location), (E.startDate = e.startStr), (E.endDate = e.endStr), (E.allDay = e.allDay);
                },
                A = () => Date.now().toString() + Math.floor(1e3 * Math.random()).toString();
            return {
                init: function() {
                    const C = document.getElementById("kt_modal_add_event");
                    (f = C.querySelector("#kt_modal_add_event_form")),
                    (t = f.querySelector('[name="calendar_event_name"]')),
                    (n = f.querySelector('[name="calendar_event_description"]')),
                    (a = f.querySelector('[name="calendar_event_location"]')),
                    (o = f.querySelector("#kt_calendar_datepicker_start_date")),
                    (i = f.querySelector("#kt_calendar_datepicker_end_date")),
                    (d = f.querySelector("#kt_calendar_datepicker_start_time")),
                    (s = f.querySelector("#kt_calendar_datepicker_end_time")),
                    (y = document.querySelector('[data-kt-calendar="add"]')),
                    (D = f.querySelector("#kt_modal_add_event_submit")),
                    (k = f.querySelector("#kt_modal_add_event_cancel")),
                    (_ = C.querySelector("#kt_modal_add_event_close")),
                    (v = f.querySelector('[data-kt-calendar="title"]')),
                    (u = new bootstrap.Modal(C));
                    const H = document.getElementById("kt_modal_view_event");
                    var F, O, I, R, V, P;
                    (w = new bootstrap.Modal(H)),
                    (b = H.querySelector('[data-kt-calendar="event_name"]')),
                    (g = H.querySelector('[data-kt-calendar="all_day"]')),
                    (S = H.querySelector('[data-kt-calendar="event_description"]')),
                    (h = H.querySelector('[data-kt-calendar="event_location"]')),
                    (T = H.querySelector('[data-kt-calendar="event_start_date"]')),
                    (Y = H.querySelector('[data-kt-calendar="event_end_date"]')),
                    (x = H.querySelector("#kt_modal_view_event_edit")),
                    (L = H.querySelector("#kt_modal_view_event_delete")),
                    (F = document.getElementById("event_calendar")),
                    (O = moment().startOf("day")),
                    (I = O.format("YYYY-MM")),
                    (R = O.clone().subtract(1, "day").format("YYYY-MM-DD")),
                    (V = O.format("YYYY-MM-DD")),
                    (P = O.clone().add(1, "day").format("YYYY-MM-DD")),
                    (e = new FullCalendar.Calendar(F, {
                        headerToolbar: {
                            left: "prev,next today",
                            center: "title",
                            right: "dayGridMonth,timeGridWeek,timeGridDay"
                        },
                        initialDate: V,
                        navLinks: !0,
                        selectable: !0,
                        selectMirror: !0,
                        select: function(e) {
                            N(e), M();
                        },
                        eventClick: function(e) {
                            N({
                                id: e.event.id,
                                title: e.event.title,
                                description: e.event.extendedProps.description,
                                location: e.event.extendedProps.location,
                                startStr: e.event.startStr,
                                endStr: (e.event.endStr) ? e.event.endStr : e.event.startStr,
                                allDay: e.event.allDay
                            }), B();
                        },
                        editable: !0,
                        dayMaxEvents: !0,
                        events: {
                            url: site_url + '/admin/get_activity.php',
                        },
                        datesSet: function() {},
                    })).render(),
                        (p = FormValidation.formValidation(f, {
                            fields: {
                                calendar_event_name: {
                                    validators: {
                                        notEmpty: {
                                            message: "Event name is required"
                                        }
                                    }
                                },
                                calendar_event_start_date: {
                                    validators: {
                                        notEmpty: {
                                            message: "Start date is required"
                                        }
                                    }
                                },
                                calendar_event_end_date: {
                                    validators: {
                                        notEmpty: {
                                            message: "End date is required"
                                        }
                                    }
                                },
                            },
                            plugins: {
                                trigger: new FormValidation.plugins.Trigger(),
                                bootstrap: new FormValidation.plugins.Bootstrap5({
                                    rowSelector: ".fv-row",
                                    eleInvalidClass: "",
                                    eleValidClass: ""
                                })
                            },
                        })),
                        (r = flatpickr(o, {
                            enableTime: !1,
                            dateFormat: "Y-m-d"
                        })),
                        (l = flatpickr(i, {
                            enableTime: !1,
                            dateFormat: "Y-m-d"
                        })),
                        (c = flatpickr(d, {
                            enableTime: !0,
                            noCalendar: !0,
                            dateFormat: "H:i"
                        })),
                        (m = flatpickr(s, {
                            enableTime: !0,
                            noCalendar: !0,
                            dateFormat: "H:i"
                        })),
                        q(),
                        y.addEventListener("click", (e) => {
                            (E = {
                                id: "",
                                eventName: "",
                                eventDescription: "",
                                startDate: new Date(),
                                endDate: new Date(),
                                allDay: !1
                            }), M();
                        }),
                        L.addEventListener("click", (t) => {
                            t.preventDefault(),
                                Swal.fire({
                                    text: "Are you sure you would like to delete this event?",
                                    icon: "warning",
                                    showCancelButton: !0,
                                    buttonsStyling: !1,
                                    confirmButtonText: "Yes, delete it!",
                                    cancelButtonText: "No, return",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                        cancelButton: "btn btn-active-light"
                                    },
                                }).then(function(t) {
                                    t.value ?
                                        (e.getEventById(E.id).remove(), w.hide()) :
                                        "cancel" === t.dismiss && Swal.fire({
                                            text: "Your event was not deleted!.",
                                            icon: "error",
                                            buttonsStyling: !1,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                });
                        }),
                        k.addEventListener("click", function(e) {
                            e.preventDefault(),
                                Swal.fire({
                                    text: "Are you sure you would like to cancel?",
                                    icon: "warning",
                                    showCancelButton: !0,
                                    buttonsStyling: !1,
                                    confirmButtonText: "Yes, cancel it!",
                                    cancelButtonText: "No, return",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                        cancelButton: "btn btn-active-light"
                                    },
                                }).then(function(e) {
                                    e.value ?
                                        (f.reset(), u.hide()) :
                                        "cancel" === e.dismiss && Swal.fire({
                                            text: "Your form has not been cancelled!.",
                                            icon: "error",
                                            buttonsStyling: !1,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                });
                        }),
                        _.addEventListener("click", function(e) {
                            e.preventDefault(),
                                Swal.fire({
                                    text: "Are you sure you would like to cancel?",
                                    icon: "warning",
                                    showCancelButton: !0,
                                    buttonsStyling: !1,
                                    confirmButtonText: "Yes, cancel it!",
                                    cancelButtonText: "No, return",
                                    customClass: {
                                        confirmButton: "btn btn-primary",
                                        cancelButton: "btn btn-active-light"
                                    },
                                }).then(function(e) {
                                    e.value ?
                                        (f.reset(), u.hide()) :
                                        "cancel" === e.dismiss && Swal.fire({
                                            text: "Your form has not been cancelled!.",
                                            icon: "error",
                                            buttonsStyling: !1,
                                            confirmButtonText: "Ok, got it!",
                                            customClass: {
                                                confirmButton: "btn btn-primary"
                                            }
                                        });
                                });
                        }),
                        ((e) => {
                            e.addEventListener("hidden.bs.modal", (e) => {
                                p && p.resetForm(!0);
                            });
                        })(C);
                },
            };
        })();
        KTUtil.onDOMContentLoaded(function() {
            KTAppCalendar.init();
        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>