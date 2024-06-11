<?php require '../config.php';
$page_name = 'reporting';
$sub_page_name = '';
Admin()->check_login();

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
                                                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Reporting</h1>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Page title-->
                                            <?php
                                            $bookmark = Advisor()->check_bookmark(site_url() . '/admin/reporting');

                                            if ($bookmark) { ?>
                                                <i class="bi bi-bookmarks-fill fs-2x cursor-pointer text-primary  bookmark_page" bookmark_url="<?php echo site_url(); ?>/admin/reporting"></i>
                                            <?php } else { ?>
                                                <i class="bi bi-bookmarks fs-2x cursor-pointer text-primary bookmark_page" data-bs-toggle="modal" data-bs-target="#kt_modal_bookmark_link" bookmark_name="Reporting" bookmark_url="<?php echo site_url(); ?>/admin/reporting"></i>
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
                                        <div class="card mb-7">

                                            <!--begin::Card header-->
                                            <div class="card-header bg-theme-color">
                                                <h2 class="card-title fw-bold text-white">Contacts</h2>
                                            </div>
                                            <!--end::Card header-->

                                            <!--begin::Card body-->
                                            <div class="card-body pt-0">
                                                <div class="row mt-5">
                                                    <div class="col-md-4">
                                                        <!--begin::Line Chart -->
                                                        <div class="fs-5 fw-semibold mb-7">
                                                            <label>Filter</label>
                                                            <input class="form-control form-control-solid" placeholder="Pick date rage" id="filter_advisor_date_range" />
                                                            <input type="hidden" id="filter_advisor_date_range_month_name">
                                                        </div>
                                                        <!--end::Line Chart-->
                                                    </div>
                                                </div>
                                                <div class="row mb-7 mt-3">
                                                    <div id="advisor_chart"></div>
                                                </div>
                                                <!--begin::Search-->
                                                <div class="d-flex align-items-center position-relative my-1">
                                                    <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span class="path2"></span></i>
                                                    <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Advisor" />
                                                </div>
                                                <!--end::Search-->
                                                <!--begin::Datatable-->
                                                <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
                                                    <thead>
                                                        <tr class="text-start text-gray-500 fw-bold fs-7  gs-0">
                                                            <th class="w-10px pe-2">
                                                                <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                                    <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_example_1 .form-check-input" value="1" />
                                                                </div>
                                                            </th>
                                                            <th>Name</th>
                                                            <th>Status</th>
                                                            <th>Rating</th>
                                                            <th>City</th>
                                                            <th>State</th>
                                                            <th>Lead Source</th>
                                                            <th>Contact Added On </th>
                                                            <th class="text-start">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-gray-600 fw-semibold">
                                                    </tbody>
                                                </table>
                                                <!--end::Datatable-->
                                            </div>
                                            <!--end::Card body-->
                                        </div>
                                        <!--end::Card-->

                                        <!--begin::Card-->
                                        <div class="card">
                                            <div class="card-header bg-theme-color">
                                                <h2 class="card-title fw-bold  text-white">Traffic acquisition</h2>
                                            </div>
                                            <!--begin::Card body-->
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <!--begin::Line Chart -->
                                                        <div class=" fw-semibold mb-7">
                                                            <label>Filter</label>
                                                            <input class="form-control form-control-solid" placeholder="Pick date rage" id="kt_daterangepicker_4" />
                                                        </div>
                                                        <div id="kt_docs_google_chart_line"></div>
                                                        <!--end::Line Chart-->
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div id="page_visitor_chart_by_state" style="height: 350px;"></div>
                                                    </div>
                                                </div>
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
    <script src="<?php echo site_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script src="//www.google.com/jsapi"></script>
    <!--end::Vendors Javascript-->
    <script>
        var start = moment().subtract(29, "days");
        var end = moment();

        function advisor_date_range(start, end) {
            advisor_filter_date_range = start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY");
            $("#filter_advisor_date_range").html(advisor_filter_date_range);
            $("#filter_advisor_date_range_month_name").val(advisor_filter_date_range);
            if (advisor_filter_date_range) {
                advisor_chart_load(advisor_filter_date_range);
            }
        }

        $("#filter_advisor_date_range").daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                "Today": [moment(), moment()],
                "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "This Week (Sun-Today)": [moment().startOf('week'), moment()],
                "Last Week (Sun-Sat)": [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "Last 90 Days": [moment().subtract(89, "days"), moment()],
                "Last 12 Months": [moment().subtract(1, "year").startOf("month"), moment()],
                "Last Calendar Year": [moment().subtract(1, "year").startOf("year"), moment().subtract(1, "year").endOf("year")],
                "This Year": [moment().startOf('year'), moment()],
                "This Month": [moment().startOf("month"), moment().endOf("month")],
                "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")],

            }
        }, advisor_date_range);

        advisor_date_range(start, end);


        // page traffic chart
        function page_visit_chart_load(date_range) {

            //var date_formate = $(".filter_page_traffic_chart:checked").val();
            //var date_formate = $("#kt_daterangepicker_4").val();
            if (!date_range) {
                return;
            }

            // page visit line chart
            $.post(ajax_url, {
                action: 'get_page_visit_chart_data',
                date_range: date_range,
            }, function(result) {

                // GOOGLE CHARTS INIT
                google.load('visualization', '1', {
                    packages: ['corechart', 'line'],
                    callback: draw_chart_for_page_visit
                });

                function draw_chart_for_page_visit(params) {

                    params = params instanceof Event ? {} : params;
                    params = typeof params !== 'undefined' ? params : {};

                    var data = '';
                    result = JSON.parse(result);

                    // LINE CHART
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', '');
                    data.addColumn('number', 'No of visitor');
                    data.addRows(result);

                    var options = {
                        chart: {
                            //title: 'Traffic acquisition',
                            //subtitle: 'in millions of dollars (USD)'
                        },
                        colors: ['#1A73E8'],
                        height: '350',
                    };

                    var chart = new google.charts.Line(document.getElementById('kt_docs_google_chart_line'));
                    chart.draw(data, options);
                }

            });

            // page visit bar chart 
            $.post(ajax_url, {
                action: 'get_page_visit_chart_data_by_state',
                date_range: date_range,
            }, function(result) {

                // GOOGLE CHARTS INIT
                google.load('visualization', '1', {
                    packages: ['corechart', 'bar'],
                    callback: draw_chart_for_page_visit_by_state
                });

                function draw_chart_for_page_visit_by_state() {

                    /*
                    var data = google.visualization.arrayToDataTable([
                        ['City', 'Visitor By Region'],
                        ['New York City, NY', 8175000],
                        ['Los Angeles, CA', 3792000],
                        ['Chicago, IL', 2695000],
                        ['Houston, TX', 2099000],
                        ['Philadelphia, PA', 1526000]
                    ]);
                    */
                    var data = '';
                    result = JSON.parse(result);

                    // LINE CHART
                    data = new google.visualization.DataTable();
                    data.addColumn('string', 'City');
                    data.addColumn('number', 'Visitor By Region');
                    data.addRows(result);

                    var options = {
                        title: 'Visitor By Region',
                        chartArea: {
                            width: '50%'
                        },
                    };

                    var chart = new google.visualization.BarChart(document.getElementById('page_visitor_chart_by_state'));

                    chart.draw(data, options);
                }
            });
        }

        function cb(start, end) {
            var date_range = start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY");
            $("#kt_daterangepicker_4").html(date_range);

            if (date_range) {
                page_visit_chart_load(date_range);
            }
        }

        $("#kt_daterangepicker_4").daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                "Today": [moment(), moment()],
                "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "This Week (Sun-Today)": [moment().startOf('week'), moment()],
                "Last Week (Sun-Sat)": [moment().subtract(1, 'week').startOf('week'), moment().subtract(1, 'week').endOf('week')],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "Last 90 Days": [moment().subtract(89, "days"), moment()],
                "Last 12 Months": [moment().subtract(1, "year").startOf("month"), moment()],
                "Last Calendar Year": [moment().subtract(1, "year").startOf("year"), moment().subtract(1, "year").endOf("year")],
                "This Year": [moment().startOf('year'), moment()],
                "This Month": [moment().startOf("month"), moment().endOf("month")],
                "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")],

            }
        }, cb);

        cb(start, end);

        // advisor chart
        function advisor_chart_load(date_range) {

            if (!date_range) {
                return;
            }

            $.post(ajax_url, {
                action: 'get_advisor_chart_data',
                date_range: date_range,
            }, function(result) {
                //KTDatatablesServerSide.init();
                //KTDatatablesServerSide.reloadTable();
                // $('#kt_datatable_example_1').DataTable(); 

                // GOOGLE CHARTS INIT
                google.load('visualization', '1', {
                    packages: ['corechart', 'bar', 'line'],
                    callback: draw_chart_for_advisor
                });

                function draw_chart_for_advisor(params) {

                    params = params instanceof Event ? {} : params;
                    params = typeof params !== 'undefined' ? params : {};

                    var data = '';

                    result = JSON.parse(result);

                    // LINE CHART
                    var data = new google.visualization.DataTable();
                    data.addColumn('string', '');
                    data.addColumn('number', 'New');
                    data.addColumn('number', 'Cold');
                    data.addColumn('number', 'Warm');
                    data.addColumn('number', 'Hot');
                    data.addColumn('number', 'FBS Agent');

                    data.addRows(result);

                    var options = {
                        chart: {
                            //title: 'Traffic acquisition',
                            //subtitle: 'in millions of dollars (USD)'
                        },
                        colors: ['#50CD89', '#1B84FF', '#F6C000', '#7239EA', '#1E2129'],
                        height: '350',
                    };

                    var chart = new google.charts.Line(document.getElementById('advisor_chart'));
                    chart.draw(data, options);

                    // Destroy  DataTable
                    if ($.fn.DataTable.isDataTable('#kt_datatable_example_1')) {
                        $('#kt_datatable_example_1').DataTable().destroy();
                    }

                    // Class definition
                    var KTDatatablesServerSide = function() {
                        // Shared variables
                        var table;
                        var dt;
                        var filterAdvisor;

                        // Private functions
                        var initDatatable = function() {

                            dt = $("#kt_datatable_example_1").DataTable({
                                searchDelay: 500,
                                processing: true,
                                serverSide: true,
                                order: [
                                    [7, 'desc']
                                ],
                                stateSave: true,
                                select: {
                                    style: 'multi',
                                    selector: 'td:first-child input[type="checkbox"]',
                                    className: 'row-selected'
                                },
                                ajax: {
                                    url: "<?php echo site_url(); ?>/admin/advisor/advisor-filter-report-list-ajax.php",
                                    data: {
                                        //date_range: encodeURIComponent(advisor_filter_date_range),
                                        date_range: encodeURIComponent($("#filter_advisor_date_range_month_name").val()),
                                        advisor_status: '<?php echo sipost('status'); ?>',
                                        state: '<?php echo urlencode(sipost('state')); ?>',
                                        gender: '<?php echo urlencode(sipost('gender')); ?>',
                                        marital_status: '<?php echo urlencode(sipost('marital_status')); ?>',
                                        lead_source: '<?php echo urlencode(sipost('lead_source')); ?>',
                                        lead_owner: '<?php echo urlencode(sipost('lead_owner')); ?>',
                                        rating: '<?php echo urlencode(sipost('rating')); ?>',
                                    }
                                },
                                columns: [{
                                        data: 'record_id'
                                    },
                                    {
                                        data: 'name'
                                    },
                                    {
                                        data: 'status'
                                    },
                                    {
                                        data: 'rating'
                                    },
                                    {
                                        data: 'city'
                                    },
                                    {
                                        data: 'state'
                                    },
                                    {
                                        data: 'lead_source'
                                    },
                                    {
                                        data: 'created_at'
                                    },
                                    {
                                        data: null
                                    },
                                ],
                                columnDefs: [{
                                        targets: 0,
                                        orderable: false,
                                        render: function(data) {
                                            return `
                            <div class="form-check form-check-sm form-check-custom form-check-solid">
                                <input class="form-check-input" type="checkbox" value="${data}" />
                            </div>`;
                                        }
                                    },
                                    {
                                        target: 1,
                                        orderable: false,
                                        className: 'd-flex align-items-center',
                                    },
                                    {
                                        target: 2,
                                        orderable: false,
                                        render: function(data) {
                                            if (data == 2) {
                                                return `<div class="badge py-3 px-4 fs-7 badge-light-primary">Cold</div>`;
                                            } else if (data == 3) {
                                                return `<div class="badge py-3 px-4 fs-7 badge-light-warning">Warm</div>`;
                                            } else if (data == 4) {
                                                return `<div class="badge py-3 px-4 fs-7 badge-light-info">Hot</div>`;
                                            } else if (data == 5) {
                                                return `<div class="badge py-3 px-4 fs-7 badge-light-dark">FBS Agent</div>`;
                                            } else {
                                                return `<div class="badge py-3 px-4 fs-7 badge-light-success">New</div>`;
                                            }
                                        }
                                    },
                                    {
                                        target: 3,
                                        orderable: false,
                                    },
                                    {
                                        target: 4,
                                        orderable: false,
                                    },
                                    {
                                        target: 5,
                                        orderable: false,
                                    },
                                    {
                                        target: 6,
                                        orderable: false,
                                    },
                                    /*{
                                        targets: 4,
                                        render: function(data, type, row) {
                                            return `<img src="${hostUrl}media/svg/card-logos/${row.CreditCardType}.svg" class="w-35px me-3" alt="${row.CreditCardType}">` + data;
                                        }
                                    },*/
                                    {
                                        targets: -1,
                                        data: null,
                                        orderable: false,
                                        className: 'text-start',
                                        render: function(data, type, row) {

                                            let html = '<div class="d-flex">';

                                            html +=
                                                `<a href="tel:${data.mobile_no}" data-bs-toggle="tooltip" title="Call Contact">
                                        <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                            <div class="fs-3 fw-bold text-gray-700"> 
                                                <i class="las la-phone-volume fs-2 text-success"></i>
                                            </div>
                                        </div>
                                    </a> 
                                    <a href="mailto:${data.email}"  data-bs-toggle="tooltip" title="Email Contact">
                                        <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                            <div class="fs-2 fw-bold text-gray-700">
                                                <i class="las la-envelope-open-text fs-2  text-success"></i>
                                            </div>
                                        </div> 
                                    </a>`;

                                            return html;
                                        },
                                    },
                                ],

                                // Add data-filter attribute
                                createdRow: function(row, data, dataIndex) {

                                }
                            });

                            table = dt.$;

                            // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                            dt.on('draw', function() {
                                initToggleToolbar();
                                //toggleToolbars();
                                //handleDeleteRows();
                                KTMenu.createInstances();
                            });
                        }

                        // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
                        var handleSearchDatatable = function() {
                            const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
                            filterSearch.addEventListener('keyup', function(e) {
                                dt.search(e.target.value).draw();
                            });
                        }

                        // Init toggle toolbar
                        var initToggleToolbar = function() {
                            // Toggle selected action toolbar
                            // Select all checkboxes
                            const container = document.querySelector('#kt_datatable_example_1');
                            const checkboxes = container.querySelectorAll('[type="checkbox"]');

                            // Select elements
                            const deleteSelected = document.querySelector('[data-kt-docs-table-select="delete_selected"]');

                            var SelectedRow = [];
                            // Toggle delete selected toolbar
                            checkboxes.forEach(c => {
                                // Checkbox on click event
                                c.addEventListener('click', function() {
                                    SelectedRow.push(c.value);
                                    setTimeout(function() {
                                        toggleToolbars();
                                    }, 50);
                                });
                            });

                        }

                        // Toggle toolbars
                        var toggleToolbars = function() {
                            // Define variables
                            const container = document.querySelector('#kt_datatable_example_1');
                            const toolbarBase = document.querySelector('[data-kt-docs-table-toolbar="base"]');
                            const toolbarSelected = document.querySelector('[data-kt-docs-table-toolbar="selected"]');
                            const selectedCount = document.querySelector('[data-kt-docs-table-select="selected_count"]');

                            // Select refreshed checkbox DOM elements
                            const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

                            // Detect checkboxes state & count
                            let checkedState = false;
                            let count = 0;

                            // Count checked boxes
                            allCheckboxes.forEach(c => {
                                if (c.checked) {
                                    checkedState = true;
                                    count++;
                                }
                            });

                            // Toggle toolbars
                            if (checkedState) {
                                selectedCount.innerHTML = count;
                                toolbarBase.classList.add('d-none');
                                toolbarSelected.classList.remove('d-none');
                            } else {
                                toolbarBase.classList.remove('d-none');
                                toolbarSelected.classList.add('d-none');
                            }
                        }

                        // Public methods
                        return {
                            init: function() {
                                initDatatable();
                                handleSearchDatatable();
                                //initToggleToolbar();
                                //handleFilterDatatable();
                                //handleDeleteRows();
                                //handleResetForm();
                            }
                        }
                    }();

                    KTUtil.onDOMContentLoaded(function() {
                        KTDatatablesServerSide.init();
                    });
                }
            });
        }


        // On document ready
        /*
        KTUtil.onDOMContentLoaded(function() {
            KTDatatablesServerSide.init();
        });
        */
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>