<?php require '../config.php';
$page_name = 'notes';
$sub_page_name = '';
Admin()->check_login();

// page permition for admin user
if (Admin()->check_for_page_access("notes", true)) {
    wp_redirect(add_query_arg('access', 1, site_url('admin/dashboard')));
    die();
}

if (isset($_POST['save_note'])) {

    if (sipost('note_id')) {
        $response = Advisor()->update_advisor_note();
    } else {
        $response = Advisor()->add_advisor_note();
    }


    if ($response == 1) {
        $_SESSION['process_success'] = true;
    } else {
        $_SESSION['process_fail'] = true;
    }

    wp_redirect(site_url() . '/admin/notes');
    exit;
}

$advisor_list = Advisor()->get_advisor_list_with_general_details();

$get_notes_list = Advisor()->get_note_list();

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/admin/head.php'; ?>
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
                                                <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Notes</h1>
                                                <!--end::Title-->
                                            </div>
                                            <!--end::Page title-->
                                            <!--begin::Actions-->
                                            <div class="d-flex align-items-center gap-2 gap-lg-3">
                                                <!--begin::Primary button-->
                                                <a href="" class="btn btn-sm btn-primary align-self-center note_modal" data-bs-toggle="modal" data-bs-target="#kt_modal_note" id="add_note">Add Note</a>
                                                <!--end::Primary button-->
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

                                        <!--begin::Row-->
                                        <div class="row g-5 g-xl-8">
                                            <?php foreach ($get_notes_list as $note_result) {
                                                $advisor_profile_img = Advisor()->get_advisor_meta($note_result->advisor_id, 'profile_img'); ?>
                                                <!--begin::Col-->
                                                <div class="col-xl-4">
                                                    <!--begin::Timeline-->
                                                    <div class="card card-xl-stretch mb-xl-8">
                                                        <!--begin::Body-->
                                                        <div class="card-body d-flex flex-column pb-10 pb-lg-15">
                                                            <div class="flex-grow-1">
                                                                <!--begin::Info-->
                                                                <div class="d-flex align-items-center pe-2 mb-5">
                                                                    <span class="text-muted fw-bold fs-5 flex-grow-1"><?php echo date('m/d/Y', strtotime($note_result->created_at)); ?></span>
                                                                    <div class="symbol symbol-50px">

                                                                        <span class="">
                                                                            <a href="" class="badge badge-light-primary fw-bold me-auto px-4 py-3 note_modal" data-bs-toggle="modal" data-bs-target="#kt_modal_note" note_id="<?php echo $note_result->id; ?>">Edit </a>
                                                                            <span href="" class="badge badge-light-danger fw-bold me-auto px-4 py-3 cursor-pointer delete_note_modal" note_id="<?php echo $note_result->id; ?>"> Delete </span>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <!--end::Info-->
                                                                <!--begin::Link-->
                                                                <a href="#" class="text-gray-900 fw-bold text-hover-primary fs-4"><?php echo $note_result->label; ?></a>
                                                                <!--end::Link-->
                                                                <!--begin::Desc-->
                                                                <p class="py-3">
                                                                    <?php echo $note_result->note; ?>
                                                                </p>
                                                                <!--end::Desc-->
                                                            </div>
                                                            <!--begin::Team-->
                                                            <div class="d-flex align-items-center">
                                                                <a href="#" class="symbol symbol-35px me-2" data-bs-toggle="tooltip" title="">
                                                                    <?php
                                                                    if ($advisor_profile_img) { ?>
                                                                        <img src="<?php echo site_url(); ?>/uploads/advisor/<?php echo $advisor_profile_img; ?>" alt="" />
                                                                    <?php } else { ?>
                                                                        <img src="<?php echo site_url(); ?>/assets/images/blank.png" alt="" />
                                                                    <?php } ?>
                                                                </a>
                                                            </div>
                                                            <!--end::Team-->
                                                        </div>
                                                        <!--end::Body-->
                                                    </div>
                                                    <!--end::Timeline-->
                                                </div>
                                                <!--end::Col-->
                                            <?php } ?>
                                        </div>
                                        <!--end::Row-->

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

    <!--begin::Modal - Add Note Modal -->
    <div class="modal fade" id="kt_modal_note" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content modal-rounded">
                <!--begin::Modal header-->
                <div class="modal-header py-5 d-flex justify-content-between">
                    <!--begin::Modal title-->
                    <h2>Note</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y m-2">
                    <form class="" id="" method="post" enctype="multipart/form-data">
                        <input type="hidden" class="is_empty" name="note_id" id="note_id">
                        <div class="w-100">
                            <!--begin::Input group-->
                            <div class="row mb-7">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Advisor</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <select name="advisor_id" id="advisor_id" data-control="select2" data-placeholder="Select a Advisor..." class="form-select form-select-solid is_empty" data-dropdown-parent="#kt_modal_note" required>
                                    <option value="">Select Advisor</option>
                                    <?php foreach ($advisor_list as $advisor_result) { ?>
                                        <option value="<?php echo $advisor_result->id ?>"><?php echo $advisor_result->first_name . ' ' . $advisor_result->last_name . ' - ' . $advisor_result->email; ?></option>
                                    <?php } ?>
                                </select>
                                <!--end::Input-->
                            </div>
                            <div class="row mt-10">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Note Label</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="label" id="label" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Label" value="" required />
                                <!--end::Input-->
                            </div>
                            <div class="row mt-10">
                                <!--begin::Label-->
                                <label class="required fw-semibold fs-6 mb-2">Note</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea type="text" name="note" id="note" class="form-control form-control-solid is_empty" rows="5" placeholder="Write Note" required /></textarea>
                                <!--end::Input-->
                            </div>

                            <div class="d-flex justify-content-end align-items-center mt-12">

                                <!--begin::Button-->
                                <button type="submit" class="btn btn-primary" id="save_note" name="save_note">
                                    <span class="indicator-label">
                                        Save
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                                <!--end::Button-->
                            </div>
                        </div>
                    </form>
                </div>
                <!--begin::Modal body-->
            </div>
        </div>
        <!--end::Modal - Edit Profile-->
    </div>
    <!--end::Modals-->

    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <?php require SITE_DIR . '/admin/footer_script.php'; ?>
    <!--end::Global Javascript Bundle-->
    <!--begin::Custom Javascript(used for this page only)-->
    <!--end::Custom Javascript-->
    <script>
        $(document).on("click", ".delete_note_modal", function() {
            var note_id = $(this).attr("note_id");
            Swal.fire({
                text: "Are you sure you want to delete ?",
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
                        text: "Deleting Note",
                        icon: "info",
                        buttonsStyling: false,
                        showConfirmButton: false,
                        timer: 2000
                    }).then(function() {
                        $.post(ajax_url, {
                            action: 'delete_note',
                            note_id: note_id
                        }, function(result) {
                            location.reload();
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
        });

        $(document).on("click", ".note_modal", function() {

            var note_id = $(this).attr('note_id');

            $(".is_empty").val("");

            $("select.is_empty").val(null).trigger("change");

            $("textarea.is_empty").html("");

            if (!note_id)
                return false;

            $.post(ajax_url, {
                action: 'get_selected_note_data',
                note_id: note_id,
                is_ajax: true,
            }, function(result) {

                var results = JSON.parse(result);

                if (results) {
                    $("#note_id").val(results.note_info.id);
                    $("#advisor_id").val(results.note_info.advisor_id).trigger("change");
                    $("#label").val(results.note_info.label);
                    $("#note").val(results.note_info.note);
                }

            });
        });
    </script>
    <!--end::Javascript-->
</body>
<!--end::Body-->

</html>