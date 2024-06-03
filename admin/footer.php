<?php
$modal_width = '1300px';
if (isset($get_upcoming_birthday_anniversary_list) && count($get_upcoming_birthday_anniversary_list) == 0) {
    $modal_width = '500px';
} ?>
<!--begin::Modal - View Users-->
<div class="modal fade" id="kt_modal_upcoming_birthday_anniversary" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mw-<?php echo $modal_width; ?> p-9">
        <!--begin::Modal content-->
        <div class="modal-content modal-rounded">
            <!--begin::Modal header-->
            <div class="modal-header py-5 d-flex justify-content-between">
                <!--begin::Modal title-->
                <h2>Notification</h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y m-0">

                <?php if (!empty($get_upcoming_birthday_anniversary_list)) { ?>

                    <h4 class="mb-8">Birthdays and Anniversaries</h4>
                    <!--begin::Row-->
                    <div class="row g-6 g-xl-9">
                        <?php foreach ($get_upcoming_birthday_anniversary_list as $greeting_result) { ?>
                            <!--begin::Col-->
                            <div class="col-md-6 col-xxl-4">
                                <?php if ($greeting_result['greeting'] == 'anniversary') { ?>
                                    <div class="fw-semibold text-gray-500 mb-2">Anniversary is coming</div>
                                <?php } else { ?>
                                    <div class="fw-semibold text-gray-500 mb-2">Birthday is coming</div>
                                <?php } ?>

                                <!--begin::Card-->
                                <div class="card">
                                    <!--begin::Card body-->
                                    <div class="card-body d-flex flex-center flex-column pt-12 p-9">
                                        <?php if ($greeting_result['greeting'] == 'anniversary') { ?>
                                            <!--begin::Position-->
                                            <div class="fw-semibold text-gray-500 mb-6">Happy Anniversary To</div>
                                            <!--end::Position-->
                                        <?php } else { ?>
                                            <!--begin::Position-->
                                            <div class="fw-semibold text-gray-500 mb-6">Happy Birthday To</div>
                                            <!--end::Position-->
                                        <?php } ?>
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-65px symbol-circle mb-5">
                                            <?php
                                            $profile_img = Advisor()->get_advisor_meta($greeting_result['id'], 'profile_img');
                                            if ($profile_img) { ?>
                                                <img src="<?php echo site_url(); ?>/uploads/advisor/<?php echo $profile_img; ?>" alt="image" />
                                            <?php } else { ?>
                                                <img src="<?php echo site_url(); ?>/uploads/advisor/blank.png" alt="image" />
                                            <?php } ?>
                                            <div class="bg-success position-absolute border border-4 border-body h-15px w-15px rounded-circle translate-middle start-100 top-100 ms-n3 mt-n3"></div>
                                        </div>
                                        <!--end::Avatar-->
                                        <!--begin::Name-->
                                        <a href="<?php echo site_url(); ?>/admin/advisor/view-advisor/<?php echo $greeting_result['id']; ?>" class="fs-4 text-gray-800 text-hover-primary fw-bold mb-0"><?php echo $greeting_result['prefix'] . " " . $greeting_result['first_name'] . " " . $greeting_result['last_name']; ?></a>
                                        <!--end::Name-->

                                        <!--begin::Info-->
                                        <?php if ($greeting_result['greeting'] == 'anniversary') { ?>
                                            <div class="fw-semibold text-gray-500 mb-6">Anniversary Date : <?php echo ($greeting_result['greeting_date']) ? date("m/d/Y", strtotime($greeting_result['greeting_date'])) : ''; ?></div>
                                        <?php } ?>
                                        <?php if ($greeting_result['greeting'] == 'birthday') { ?>
                                            <div class="fw-semibold text-gray-500 mb-6">Birthday Date : <?php echo ($greeting_result['greeting_date']) ? date("m/d/Y", strtotime($greeting_result['greeting_date'])) : ''; ?></div>
                                        <?php } ?>
                                        <!--end::Info-->
                                        <div class="d-flex">
                                            <a href="tel:<?php echo $greeting_result['mobile_no']; ?>">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-3 fw-bold text-gray-700">
                                                        <i class="las la-phone-volume fs-2 text-success"></i>
                                                    </div>
                                                </div>
                                            </a>
                                            <a href="mailto:<?php echo $greeting_result['email']; ?>">
                                                <div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3 me-2">
                                                    <div class="fs-2 fw-bold text-gray-700">
                                                        <i class="las la-envelope-open-text fs-2  text-success"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                    <!--end::Card body-->
                                </div>
                                <!--end::Card-->
                            </div>
                            <!--end::Col-->
                        <?php } ?>
                    </div>
                <?php } else {
                    echo '<h3>No birthday or anniversary was discovered.</h3>';
                } ?>

            </div>
            <!--begin::Modal body-->
        </div>
    </div>
</div>
<!--end::Modal -->

<!--begin::Modal - Book Mark Links -->
<div class="modal fade" id="kt_modal_bookmark_link" tabindex="-1" aria-hidden="true">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable mw-700px p-9">
        <!--begin::Modal content-->
        <div class="modal-content modal-rounded">
            <!--begin::Modal header-->
            <div class="modal-header py-5 d-flex justify-content-between">
                <!--begin::Modal title-->
                <h2>Bookmark </h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-outline ki-cross fs-1"></i>
                </div>
                <!--end::Close-->
            </div>
            <!--begin::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body scroll-y m-0">
                <!--begin::Row-->
                <form class="" id="bookmark_form" method="post" enctype="multipart/form-data">
                    <div class="w-100">
                        <div class="row ">
                            <div class="col-md-12 fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Link Name</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="bookmark_name" id="bookmark_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Link Name" />
                                <!--end::Input-->
                            </div>
                            <div class="col-md-12 fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Link URL</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <input type="text" name="bookmark_url" id="bookmark_url" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Link URL" readonly />
                                <!--end::Input-->
                            </div>
                            <div class="col-md-12 fv-row mb-7">
                                <!--begin::Label-->
                                <label class="fw-semibold fs-6 mb-2">Link Notes</label>
                                <!--end::Label-->
                                <!--begin::Input-->
                                <textarea type="text" name="bookmark_notes" id="bookmark_notes" rows="4" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Link Notes"></textarea>
                                <!--end::Input-->
                            </div>
                        </div>
                        <div class="text-center">

                            <!--begin::Button-->
                            <button type="button" class="btn btn-primary" id="save_bookmark" name="save_bookmark">
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
                <!--end::Row-->
            </div>
            <!--begin::Modal body-->
        </div>
    </div>
</div>
<!--end::Modal - Book Mark Links-->