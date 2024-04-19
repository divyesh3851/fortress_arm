<?php require '../../config.php';
$page_name = 'activity';
$sub_page_name = 'activity-list';
Admin()->check_login();
// page permition for admin user
if (Admin()->check_for_page_access("activities", true)) {
    wp_redirect(add_query_arg('access', 1, site_url('admin/dashboard')));
    die();
}
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/admin/head.php'; ?>
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
                        <!--begin::Toolbar-->
                        <div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
                            <!--begin::Toolbar container-->
                            <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
                                <!--begin::Toolbar wrapper-->
                                <div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
                                    <!--begin::Page title-->
                                    <div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
                                        <!--begin::Title-->
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Activity List</h1>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Page title-->
                                    <!--begin::Actions-->
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


                                <!--begin::Card-->
                                <div class="card">
                                    <!--begin::Card header-->
                                    <div class="card-header border-0 pt-6">
                                        <!--begin::Card title-->
                                        <div class="card-title">
                                            <!--begin::Search-->
                                            <div class="d-flex align-items-center position-relative my-1">
                                                <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span class="path2"></span></i>
                                                <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Activity" />
                                            </div>
                                            <!--end::Search-->
                                        </div>
                                        <!--begin::Card title-->
                                        <!--begin::Card toolbar-->
                                        <div class="card-toolbar">
                                            <!--begin::Toolbar-->
                                            <div class="d-flex justify-content-end" data-kt-docs-table-toolbar="base">

                                            </div>
                                            <!--end::Toolbar-->
                                            <!--begin::Group actions-->
                                            <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
                                                <div class="fw-bold me-5">
                                                    <span class="me-2" data-kt-docs-table-select="selected_count"></span>Selected
                                                </div>
                                                <button type="button" class="btn btn-danger" data-kt-docs-table-select="delete_selected">Delete Selected</button>
                                            </div>
                                            <!--end::Group actions-->
                                        </div>
                                        <!--end::Card toolbar-->
                                    </div>
                                    <!--end::Card header-->
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">
                                        <!--begin::Datatable-->
                                        <table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
                                            <thead>
                                                <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                                                    <th class="w-10px pe-2">
                                                        <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                                            <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_example_1 .form-check-input" value="1" />
                                                        </div>
                                                    </th>
                                                    <th>Name</th>
                                                    <th>Message</th>
                                                    <th>Action Date</th>
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
    <!--begin::Vendors Javascript(used for this page only)-->
    <script src="<?php echo site_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--end::Javascript-->
    <script>
        "use strict";

        // Class definition
        var KTDatatablesServerSide = function() {
            // Shared variables
            var table;
            var dt;
            var filterActivity;

            // Private functions
            var initDatatable = function() {
                dt = $("#kt_datatable_example_1").DataTable({
                    searchDelay: 500,
                    processing: true,
                    serverSide: true,
                    order: [
                        [3, 'desc']
                    ],
                    stateSave: true,
                    select: {
                        style: 'multi',
                        selector: 'td:first-child input[type="checkbox"]',
                        className: 'row-selected'
                    },
                    ajax: {
                        url: "<?php echo site_url(); ?>/admin/activity/activity-list-ajax.php",
                    },
                    columns: [{
                            data: 'record_id'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'message'
                        },
                        {
                            data: 'action_date'
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
                            className: 'd-flex align-items-center'
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
                                return `<div class="d-flex">   
                                            <a href="<?php echo site_url(); ?>/admin/activity/view-activity/${data.user_id}">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-3 fw-bold text-gray-700">
                                                        <i class="las la-eye fs-2 text-primary"></i>
                                                    </div>
                                                </div>
                                            </a>  
                                    </div>`;
                            },
                        },
                    ],
                    // Add data-filter attribute
                    createdRow: function(row, data, dataIndex) {
                        $(row).find('td:eq(3)').attr('data-filter', data.CreditCardType);
                    }
                });

                table = dt.$;

                // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
                dt.on('draw', function() {
                    initToggleToolbar();
                    toggleToolbars();
                    handleDeleteRows();
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

            // Filter Datatable
            var handleFilterDatatable = () => {
                // Select filter options
                filterActivity = document.querySelectorAll('[data-kt-docs-table-filter="activity_status"] [name="activity_status"]');

                const filterButton = document.querySelector('[data-kt-docs-table-filter="filter"]');

                // Filter datatable on submit
                if (filterButton) {
                    filterButton.addEventListener('click', function() {
                        // Get filter values
                        let activityStatus = '';

                        // Get Activity value
                        filterActivity.forEach(r => {

                            if (r.checked) {
                                activityStatus = r.value;
                            }

                            // Reset Activity value if "All" is selected
                            if (activityStatus === 'all') {
                                activityStatus = '';
                            }
                        });

                        // Filter datatable --- official docs reference: https://datatables.net/reference/api/search()
                        dt.search(activityStatus).draw();
                    });
                }

            }

            // Delete Row
            var handleDeleteRows = () => {
                // Select all delete buttons
                const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

                deleteButtons.forEach(d => {
                    // Delete button on click
                    d.addEventListener('click', function(e) {
                        e.preventDefault();

                        // Select parent row
                        const parent = e.target.closest('tr');

                        // Get customer name
                        const customerName = parent.querySelectorAll('td')[1].innerText;

                        var activity_id = d.getAttribute('activity_id');

                        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Are you sure you want to delete " + customerName + "?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            }
                        }).then(function(result) {
                            if (result.value) {
                                // Simulate delete request -- for demo purpose only
                                Swal.fire({
                                    text: "Deleting " + customerName,
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    $.post(ajax_url, {
                                        action: 'activity_delete',
                                        activity_id: activity_id
                                    }, function(result) {

                                    });
                                    Swal.fire({
                                        text: "You have deleted " + customerName + "!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function() {
                                        // delete row data from server and re-draw datatable 

                                        dt.draw();
                                    });
                                });
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: customerName + " was not deleted.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    })
                });
            }

            // Reset Filter
            var handleResetForm = () => {
                // Select reset button
                const resetButton = document.querySelector('[data-kt-docs-table-filter="reset"]');

                // Reset datatable
                if (resetButton) {
                    resetButton.addEventListener('click', function() {
                        // Reset Activity type
                        filterActivity[0].checked = true;

                        // Reset datatable --- official docs reference: https://datatables.net/reference/api/search()
                        dt.search('').draw();
                    });
                }

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

                // Deleted selected rows
                if (deleteSelected) {

                    deleteSelected.addEventListener('click', function() {
                        // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                        Swal.fire({
                            text: "Are you sure you want to delete selected customers?",
                            icon: "warning",
                            showCancelButton: true,
                            buttonsStyling: false,
                            showLoaderOnConfirm: true,
                            confirmButtonText: "Yes, delete!",
                            cancelButtonText: "No, cancel",
                            customClass: {
                                confirmButton: "btn fw-bold btn-danger",
                                cancelButton: "btn fw-bold btn-active-light-primary"
                            },
                        }).then(function(result) {

                            if (result.value) {
                                // Simulate delete request -- for demo purpose only
                                Swal.fire({
                                    text: "Deleting selected customers",
                                    icon: "info",
                                    buttonsStyling: false,
                                    showConfirmButton: false,
                                    timer: 2000
                                }).then(function() {
                                    Swal.fire({
                                        text: "You have deleted all selected customers!.",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function() {
                                        $.post(ajax_url, {
                                            action: 'delete_multiple_selected_activity',
                                            activity_ids: SelectedRow
                                        }, function(result) {

                                        });
                                        // delete row data from server and re-draw datatable
                                        dt.draw();
                                    });

                                    // Remove header checked box
                                    const headerCheckbox = container.querySelectorAll('[type="checkbox"]')[0];
                                    headerCheckbox.checked = false;
                                });
                            } else if (result.dismiss === 'cancel') {
                                Swal.fire({
                                    text: "Selected customers was not deleted.",
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "Ok, got it!",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-primary",
                                    }
                                });
                            }
                        });
                    });

                }
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

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            KTDatatablesServerSide.init();
        });
    </script>
</body>
<!--end::Body-->

</html>