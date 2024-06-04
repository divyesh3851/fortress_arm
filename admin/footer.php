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