<?php require '../config.php';
$page_name = 'opportunities';
$sub_page_name = '';
Admin()->check_login();

require SITE_DIR . '/vendor/autoload.php';

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/head.php'; ?>
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="<?php echo site_url(); ?>/assets/plugins/custom/jkanban/jkanban.bundle.css" rel="stylesheet" type="text/css" />

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
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Opportunities</h1>
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
                                    <!--begin::Card body-->
                                    <div class="card-body">
                                        <div id="kt_docs_jkanban_rich"></div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end::Content container-->
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
    <script src="<?php echo site_url(); ?>/assets/plugins/custom/jkanban/jkanban.bundle.js"></script>
    <!--end::Vendors Javascript-->
    <!--end::Javascript-->
    <script>
        "use strict";

        // Class definition
        var KTJKanbanDemoRich = function() {
            // Private functions
            var exampleRich = function() {
                var kanban = new jKanban({
                    element: '#kt_docs_jkanban_rich',
                    gutter: '0',
                    click: function(el) {
                        alert(el.innerHTML);
                    },
                    boards: [{
                            'id': '_backlog',
                            'title': 'Backlog',
                            'class': 'light-dark',
                            'item': [{
                                    'title': `
                                <div class="d-flex align-items-center">
                        	        <div class="symbol symbol-success me-3">
                        	            <img alt="Pic" src="${hostUrl}media/avatars/300-6.jpg" />
                        	        </div>
                        	        <div class="d-flex flex-column align-items-start">
                        	            <span class="text-gray-900-50 fw-bold mb-1">SEO Optimization</span>
                        	            <span class="badge badge-light-success">In progress</span>
                        	        </div>
                        	    </div>
                            `,
                                },
                                {
                                    'title': `
                                <div class="d-flex align-items-center">
                        	        <div class="symbol symbol-success me-3">
                        	            <span class="symbol-label fs-4">A.D</span>
                        	        </div>
                        	        <div class="d-flex flex-column align-items-start">
                        	            <span class="text-gray-900-50 fw-bold mb-1">Finance</span>
                        	            <span class="badge badge-light-danger">Pending</span>
                        	        </div>
                        	    </div>
                            `,
                                }
                            ]
                        },
                        {
                            'id': '_todo',
                            'title': 'To Do',
                            'class': 'light-danger',
                            'item': [{
                                    'title': `
                                <div class="d-flex align-items-center">
                        	        <div class="symbol symbol-success me-3">
                        	            <img alt="Pic" src="${hostUrl}media/avatars/300-1.jpg" />
                        	        </div>
                        	        <div class="d-flex flex-column align-items-start">
                        	            <span class="text-gray-900-50 fw-bold mb-1">Server Setup</span>
                        	            <span class="badge badge-light-info">Completed</span>
                        	        </div>
                        	    </div>
                            `,
                                },
                                {
                                    'title': `
                                <div class="d-flex align-items-center">
                        	        <div class="symbol symbol-success me-3">
                        	            <img alt="Pic" src="${hostUrl}media/avatars/300-2.jpg" />
                        	        </div>
                        	        <div class="d-flex flex-column align-items-start">
                        	            <span class="text-gray-900-50 fw-bold mb-1">Report Generation</span>
                        	            <span class="badge badge-light-warning">Due</span>
                        	        </div>
                        	    </div>
                            `,
                                }
                            ]
                        },
                        {
                            'id': '_working',
                            'title': 'Working',
                            'class': 'light-primary',
                            'item': [{
                                    'title': `
                                <div class="d-flex align-items-center">
                        	        <div class="symbol symbol-success me-3">
                            	         <img alt="Pic" src="${hostUrl}media/avatars/300-6.jpg" />
                        	        </div>
                        	        <div class="d-flex flex-column align-items-start">
                        	            <span class="text-gray-900-50 fw-bold mb-1">Marketing</span>
                        	            <span class="badge badge-light-danger">Planning</span>
                        	        </div>
                        	    </div>
                            `,
                                },
                                {
                                    'title': `
                                <div class="d-flex align-items-center">
                        	        <div class="symbol symbol-light-info me-3">
                        	            <span class="symbol-label fs-4">A.P</span>
                        	        </div>
                        	        <div class="d-flex flex-column align-items-start">
                        	            <span class="text-gray-900-50 fw-bold mb-1">Finance</span>
                        	            <span class="badge badge-light-primary">Done</span>
                        	        </div>
                        	    </div>
                            `,
                                }
                            ]
                        },
                        {
                            'id': '_done',
                            'title': 'Done',
                            'class': 'light-success',
                            'item': [{
                                    'title': `
                                <div class="d-flex align-items-center">
                        	        <div class="symbol symbol-success me-3">
                        	            <img alt="Pic" src="${hostUrl}media/avatars/300-5.jpg" />
                        	        </div>
                        	        <div class="d-flex flex-column align-items-start">
                        	            <span class="text-gray-900-50 fw-bold mb-1">SEO Optimization</span>
                        	            <span class="badge badge-light-success">In progress</span>
                        	        </div>
                        	    </div>
                            `,
                                },
                                {
                                    'title': `
                                <div class="d-flex align-items-center">
                        	        <div class="symbol symbol-success me-3">
                        	            <img alt="Pic" src="${hostUrl}media/avatars/300-20.jpg" />
                        	        </div>
                        	        <div class="d-flex flex-column align-items-start">
                        	            <span class="text-gray-900-50 fw-bold mb-1">Product Team</span>
                        	            <span class="badge badge-light-danger">In progress</span>
                        	        </div>
                        	    </div>
                            `,
                                }
                            ]
                        },
                        {
                            'id': '_deploy',
                            'title': 'Deploy',
                            'class': 'light-primary',
                            'item': [{
                                    'title': `
                                <div class="d-flex align-items-center">
                        	        <div class="symbol symbol-light-warning me-3">
                        	            <span class="symbol-label fs-4">D.L</span>
                        	        </div>
                        	        <div class="d-flex flex-column align-items-start">
                        	            <span class="text-gray-900-50 fw-bold mb-1">SEO Optimization</span>
                        	            <span class="badge badge-light-success">In progress</span>
                        	        </div>
                        	    </div>
                            `,
                                },
                                {
                                    'title': `
                                <div class="d-flex align-items-center">
                        	        <div class="symbol symbol-light-danger me-3">
                        	            <span class="symbol-label fs-4">E.K</span>
                        	        </div>
                        	        <div class="d-flex flex-column align-items-start">
                        	            <span class="text-gray-900-50 fw-bold mb-1">Requirement Study</span>
                        	            <span class="badge badge-light-warning">Scheduled</span>
                        	        </div>
                        	    </div>
                            `,
                                }
                            ]
                        }
                    ]
                });

                var toDoButton = document.getElementById('addToDo');
                toDoButton.addEventListener('click', function() {
                    kanban.addElement(
                        '_todo', {
                            'title': `
                        <div class="d-flex align-items-center">
                            <div class="symbol symbol-light-primary me-3">
                                <img alt="Pic" src="${hostUrl}media/avatars/300-23.jpg" />
                            </div>
                            <div class="d-flex flex-column align-items-start">
                                <span class="text-gray-900-50 fw-bold mb-1">Requirement Study</span>
                                <span class="badge badge-light-success">Scheduled</span>
                            </div>
                        </div>
                    `
                        }
                    );
                });

                var addBoardDefault = document.getElementById('addDefault');
                addBoardDefault.addEventListener('click', function() {
                    kanban.addBoards(
                        [{
                            'id': '_default',
                            'title': 'New Board',
                            'class': 'light-primary',
                            'item': [{
                                'title': `
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-success me-3">
                                        <img alt="Pic" src="${hostUrl}media/avatars/300-12.jpg" />
                                    </div>
                                    <div class="d-flex flex-column align-items-start">
                                        <span class="text-gray-900-50 fw-bold mb-1">Payment Modules</span>
                                        <span class="badge badge-light-primary">In development</span>
                                    </div>
                                </div>
                        `
                            }, {
                                'title': `
                                <div class="d-flex align-items-center">
                                    <div class="symbol symbol-success me-3">
                                        <img alt="Pic" src="${hostUrl}media/avatars/300-9.jpg" />
                                    </div>
                                    <div class="d-flex flex-column align-items-start">
                                    <span class="text-gray-900-50 fw-bold mb-1">New Project</span>
                                    <span class="badge badge-light-danger">Pending</span>
                                </div>
                            </div>
                        `
                            }]
                        }]
                    )
                });

                var removeBoard = document.getElementById('removeBoard');
                removeBoard.addEventListener('click', function() {
                    kanban.removeBoard('_done');
                });
            }

            return {
                // Public Functions
                init: function() {
                    exampleRich();
                }
            };
        }();

        // On document ready
        KTUtil.onDOMContentLoaded(function() {
            KTJKanbanDemoRich.init();
        });

        (function() {
            // Collect analytics data
            var analyticsData = {
                page: window.location.pathname,
                referrer: document.referrer,
                page_name: 'opportunities'
            };

            // Send data to the server
            var xhr = new XMLHttpRequest();
            xhr.open("POST", site_url + "/track.php", true);
            xhr.setRequestHeader("Content-Type", "application/json;charset=UTF-8");
            xhr.send(JSON.stringify(analyticsData));
        })();
    </script>
</body>
<!--end::Body-->

</html>