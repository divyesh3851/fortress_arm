<?php require '../../config.php';
$page_name = 'advisor';
$sub_page_name = 'advisor-list';
Admin()->check_login();

$selected_advisor_data = Advisor()->get_selected_advisor_data(siget('advisor_id'));

if (!$selected_advisor_data) {
	wp_redirect(site_url() . 'admin/advisor-list');
	die();
}

if (isset($_POST['save_profile'])) {

	$response = Advisor()->update_advisor_profile($selected_advisor_data->id);

	if ($response == 1) {
		$_SESSION['update_profile_process_success'] = true;
	} elseif ($response == 'duplicate') {
		$_SESSION['update_profile_process_duplicate'] = true;
	} else {
		$_SESSION['update_profile_process_fail'] = true;
	}

	wp_redirect(site_url() . '/admin/advisor/view-advisor/' . siget('advisor_id'));
	exit;
}

if (isset($_POST['save_employment'])) {

	if (sipost('employment_history_id')) {
		$response = Advisor()->add_advisor_employment($selected_advisor_data->id);
	} else {
		$response = Advisor()->add_advisor_employment($selected_advisor_data->id);
	}

	if ($response == 1) {
		$_SESSION['process_employment_success'] = true;
	} elseif ($response == 'duplicate') {
		$_SESSION['process_employment_duplicate'] = true;
	} else {
		$_SESSION['process_employment_fail'] = true;
	}

	wp_redirect(site_url() . '/admin/advisor/view-advisor/' . siget('advisor_id'));
	exit;
}

if (isset($_POST['save_resident_address'])) {

	$response = Advisor()->update_advisor_resident_address($selected_advisor_data->id);

	if ($response == 1) {
		$_SESSION['update_address_process_success'] = true;
	} else {
		$_SESSION['update_address_process_fail'] = true;
	}

	wp_redirect(site_url() . '/admin/advisor/view-advisor/' . siget('advisor_id'));
	exit;
}

if (isset($_POST['save_business_address'])) {

	$response = Advisor()->update_advisor_business_address($selected_advisor_data->id);

	if ($response == 1) {
		$_SESSION['update_address_process_success'] = true;
	} else {
		$_SESSION['update_address_process_fail'] = true;
	}

	wp_redirect(site_url() . '/admin/advisor/view-advisor/' . siget('advisor_id'));
	exit;
}

if (isset($_POST['save_interest']) || isset($_POST['update_interest'])) {

	$response = Advisor()->update_interest($selected_advisor_data->id);

	if ($response == 1) {
		$_SESSION['process_interest_success'] = true;
	} elseif ($response == 'duplicate') {
		$_SESSION['process_interest_duplicate'] = true;
	} else {
		$_SESSION['process_interest_fail'] = true;
	}

	wp_redirect(site_url() . '/admin/advisor/view-advisor/' . siget('advisor_id'));
	exit;
}

$advisor_profile = Advisor()->get_advisor_meta($selected_advisor_data->id, 'profile_img');

$get_state_list = Settings()->get_state_list();

$get_advisor_employment_history = Advisor()->get_advisor_employment_history($selected_advisor_data->id);

$get_interest_life_insurance_list = Settings()->get_interest_life_insurance();

$get_interest_annuities_list = Settings()->get_interest_annuities();

$get_interest_long_term_care_insurance_list = Settings()->get_interest_long_term_care_insurance();

$get_interest_critical_illness_list = Settings()->get_interest_critical_illness();

$get_interest_disability_income_list = Settings()->get_interest_disability_income();

$get_interest_group_insurance_list = Settings()->get_interest_group_insurance();

$get_selected_advisor_interest = Advisor()->get_selected_advisor_interest($selected_advisor_data->id);

$selected_life_insurance = ($get_selected_advisor_interest && $get_selected_advisor_interest->life_insurance) ? explode(",", $get_selected_advisor_interest->life_insurance) : array();

$selected_annuities = ($get_selected_advisor_interest && $get_selected_advisor_interest->annuities) ? explode(",", $get_selected_advisor_interest->annuities) : array();

$selected_long_term_care_insurance = ($get_selected_advisor_interest && $get_selected_advisor_interest->long_term_care_insurance) ? explode(",", $get_selected_advisor_interest->long_term_care_insurance) : array();

$selected_critical_illness = ($get_selected_advisor_interest && $get_selected_advisor_interest->critical_illness) ? explode(",", $get_selected_advisor_interest->critical_illness) : array();


?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<?php require SITE_DIR . '/admin/head.php'; ?>
	<link href="<?php echo site_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
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
						if (isset($_SESSION['update_address_process_success'])) {
							unset($_SESSION['update_address_process_success']); ?>
							<div class="alert alert-success d-flex align-items-center p-5 ms-lg-15">
								<i class="ki-duotone ki-shield-tick fs-2hx text-success  me-4"><span class="path1"></span><span class="path2"></span></i>
								<div class="d-flex flex-column">
									<h4 class="mb-1 text-success">The address has been updated successfully.</h4>
								</div>
							</div>
						<?php }

						if (isset($_SESSION['update_address_process_fail'])) {
							unset($_SESSION['update_profile_process_fail']); ?>
							<div class="alert alert-danger d-flex align-items-center p-5 ms-lg-15">
								<i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
								<div class="d-flex flex-column">
									<h4 class="mb-1 text-danger">The address update has failed.</h4>
								</div>
							</div>
						<?php }


						if (isset($_SESSION['update_profile_process_success'])) {
							unset($_SESSION['update_profile_process_success']); ?>
							<div class="alert alert-success d-flex align-items-center p-5 ms-lg-15">
								<i class="ki-duotone ki-shield-tick fs-2hx text-success  me-4"><span class="path1"></span><span class="path2"></span></i>
								<div class="d-flex flex-column">
									<h4 class="mb-1 text-success">The profile has been updated successfully.</h4>
								</div>
							</div>
						<?php }

						if (isset($_SESSION['update_profile_process_duplicate'])) {
							unset($_SESSION['update_profile_process_duplicate']); ?>
							<div class="alert alert-danger d-flex align-items-center p-5 ms-lg-15">
								<i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
								<div class="d-flex flex-column">
									<h4 class="mb-1 text-danger">The email has been already exist.</h4>
								</div>
							</div>
						<?php }

						if (isset($_SESSION['update_profile_process_fail'])) {
							unset($_SESSION['update_profile_process_fail']); ?>
							<div class="alert alert-danger d-flex align-items-center p-5 ms-lg-15">
								<i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
								<div class="d-flex flex-column">
									<h4 class="mb-1 text-danger">The profile update has failed.</h4>
								</div>
							</div>
						<?php }

						if (isset($_SESSION['process_employment_success'])) {
							unset($_SESSION['process_employment_success']); ?>
							<div class="alert alert-success d-flex align-items-center p-5 ms-lg-15">
								<i class="ki-duotone ki-shield-tick fs-2hx text-success  me-4"><span class="path1"></span><span class="path2"></span></i>
								<div class="d-flex flex-column">
									<h4 class="mb-1 text-success">The profile update has failed.</h4>
								</div>
							</div>
						<?php }

						if (isset($_SESSION['process_employment_duplicate'])) {
							unset($_SESSION['process_employment_duplicate']); ?>
							<div class="alert alert-danger d-flex align-items-center p-5 ms-lg-15">
								<i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
								<div class="d-flex flex-column">
									<h4 class="mb-1 text-danger">The employment has been already exist.</h4>
								</div>
							</div>
						<?php }

						if (isset($_SESSION['process_employment_fail'])) {
							unset($_SESSION['process_employment_fail']); ?>
							<div class="alert alert-danger d-flex align-items-center p-5 ms-lg-15">
								<i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
								<div class="d-flex flex-column">
									<h4 class="mb-1 text-danger">The employment has been save failed.</h4>
								</div>
							</div>
						<?php }

						if (isset($_SESSION['process_interest_success'])) {
							unset($_SESSION['process_interest_success']); ?>
							<div class="alert alert-success d-flex align-items-center p-5 ms-lg-15">
								<i class="ki-duotone ki-shield-tick fs-2hx text-success  me-4"><span class="path1"></span><span class="path2"></span></i>
								<div class="d-flex flex-column">
									<h4 class="mb-1 text-success">The interest has been updated successfully.</h4>
								</div>
							</div>
						<?php } ?>

						<!--begin::Toolbar-->
						<div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">

							<!--begin::Toolbar container-->
							<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
								<!--begin::Toolbar wrapper-->
								<div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
									<!--begin::Page title-->
									<div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
										<!--begin::Title-->
										<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0"> Advisor Details</h1>
										<!--end::Title-->
										<!--begin::Breadcrumb-->
										<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0">
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">
												<a href="<?php echo site_url(); ?>/admin/advisor/advisor-list" class="text-muted text-hover-primary">Advisor List</a>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item">
												<span class="bullet bg-gray-500 w-5px h-2px"></span>
											</li>
											<!--end::Item-->
											<!--begin::Item-->
											<li class="breadcrumb-item text-muted">Advisor</li>
											<!--end::Item-->
										</ul>
										<!--end::Breadcrumb-->
									</div>
									<!--end::Page title-->
									<!--begin::Actions-->
									<div class="d-flex align-items-center gap-2 gap-lg-3">
										<?php /*  
										<a href="#" class="btn btn-sm fw-bold btn-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_interests">Add Interests</a>
										
										<a href="#" class="btn btn-flex btn-primary h-40px fs-7 fw-bold" data-bs-toggle="modal" data-bs-target="#kt_modal_create_campaign">New Campaign</a>
										*/ ?>
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
									<div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
										<!--begin::Card-->
										<div class="ribbon ribbon-end ribbon-clip">
											<div class="ribbon-label">
												<?php if ($selected_advisor_data->advisor_status == '1') {
													echo 'New <span class="ribbon-inner bg-success"></span>';
												} else if ($selected_advisor_data->advisor_status == '2') {
													echo 'Cold <span class="ribbon-inner bg-primary"></span>';
												} else if ($selected_advisor_data->advisor_status == '3') {
													echo 'Warm <span class="ribbon-inner bg-warning"></span>';
												} else if ($selected_advisor_data->advisor_status == '4') {
													echo 'Hot <span class="ribbon-inner bg-info"></span>';
												} else {
													echo 'Inactive <span class="ribbon-inner bg-danger"></span>';
												} ?>
											</div>
										</div>
										<div class="card mb-5 mb-xl-8">
											<!--begin::Card body-->
											<div class="card-body">
												<!--begin::Summary-->
												<!--begin::User Info-->
												<div class="d-flex flex-center flex-column py-5">
													<!--begin::Avatar-->
													<div class="symbol symbol-100px symbol-circle mb-7">
														<img src="<?php echo site_url(); ?>/uploads/advisor/<?php echo $advisor_profile; ?>" alt="image" />
													</div>
													<!--end::Avatar-->
													<!--begin::Name-->
													<a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-1"><?php echo $selected_advisor_data->prefix . '. ' . $selected_advisor_data->first_name . ' ' . $selected_advisor_data->last_name; ?></a>
													<!--end::Name-->

													<div class="text-gray-600 mb-2">Advisor Since <?php echo date("m-d-Y", strtotime($selected_advisor_data->created_at)); ?></div>
													<div class="rating mb-5">
														<div class="rating-label checked">
															<i class="ki-duotone ki-star fs-6"></i>
														</div>
														<div class="rating-label checked">
															<i class="ki-duotone ki-star fs-6"></i>
														</div>
														<div class="rating-label checked">
															<i class="ki-duotone ki-star fs-6"></i>
														</div>
														<div class="rating-label checked">
															<i class="ki-duotone ki-star fs-6"></i>
														</div>
														<div class="rating-label checked">
															<i class="ki-duotone ki-star fs-6"></i>
														</div>
													</div>

													<!--begin::Position-->
													<div class="mb-9">
														<!--begin::Badge-->
														<div class="badge badge-lg badge-light-primary d-inline"><?php echo $selected_advisor_data->state; ?></div>
														<!--begin::Badge-->
														<!--begin::Badge-->
														<div class="badge badge-lg badge-light-warning d-inline"><?php echo $selected_advisor_data->gender; ?></div>
														<!--begin::Badge-->
													</div>
													<!--end::Position-->
													<div class="d-flex flex-wrap flex-center">
														<!--begin::Stats-->
														<a href="tel:<?php echo $selected_advisor_data->mobile_no; ?>">
															<div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mb-3">
																<div class="fs-3 fw-bold text-gray-700">
																	<i class="las la-phone-volume fs-2 text-success"></i>
																</div>
															</div>
														</a>
														<!--end::Stats-->
														<!--begin::Stats-->
														<a href="mailto:<?php echo $selected_advisor_data->email; ?>">
															<div class="border border-gray-300 border-dashed rounded pt-2 pb-1 px-3 mx-4 mb-3">
																<div class="fs-2 fw-bold text-gray-700">
																	<i class="las la-envelope-open-text fs-2  text-success"></i>
																</div>
															</div>
															<!--end::Stats-->
														</a>
													</div>
												</div>
												<!--end::User Info-->
												<!--end::Summary-->
												<!--begin::Details toggle-->
												<div class="d-flex flex-stack fs-4 py-3">
													<div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">Details
														<span class="ms-2 rotate-180">
															<i class="ki-outline ki-down fs-3"></i>
														</span>
													</div>
													<span data-bs-toggle="tooltip" data-bs-trigger="hover" title="Edit Advisor Details">
														<a href="<?php echo site_url() ?>/admin/advisor/edit-advisor/<?php echo $selected_advisor_data->id; ?>" class="btn btn-sm btn-light-primary">Edit</a>
													</span>
												</div>
												<!--end::Details toggle-->
												<div class="separator"></div>
												<!--begin::Details content-->
												<div id="kt_user_view_details" class="collapse show">
													<div class="pb-5 fs-6">
														<!--begin::Details item-->
														<div class="fw-bold mt-5">License No</div>
														<div class="text-gray-600"><?php echo $selected_advisor_data->license_no; ?></div>
														<!--begin::Details item-->
														<!--begin::Details item-->
														<div class="fw-bold mt-5">NPN No</div>
														<div class="text-gray-600"><?php echo $selected_advisor_data->npn_no; ?></div>
														<!--begin::Details item-->
														<!--begin::Details item-->
														<div class="fw-bold mt-5">Address</div>
														<div class="text-gray-600"><?php echo $selected_advisor_data->city . ', ' . $selected_advisor_data->state; ?>
														</div>
														<!--begin::Details item-->
														<!--begin::Details item-->
														<div class="fw-bold mt-5">Birthdate</div>
														<div class="text-gray-600"><?php echo ($selected_advisor_data->birth_date) ? date("F, d Y", strtotime($selected_advisor_data->birth_date)) : ''; ?></div>
														<!--begin::Details item-->
														<!--begin::Details item-->
														<div class="fw-bold mt-5">Marital Status</div>
														<div class="text-gray-600"><?php echo ($selected_advisor_data->marital_status) ? $selected_advisor_data->marital_status  : ''; ?></div>
														<!--begin::Details item-->
														<!--begin::Details item-->
														<?php if ($selected_advisor_data->marital_status == 'Married') { ?>
															<div class="fw-bold mt-5">Anniversary</div>
															<div class="text-gray-600"><?php echo ($selected_advisor_data->anniversary_date) ? date("F, d Y", strtotime($selected_advisor_data->anniversary_date))  : ''; ?></div>
															<!--begin::Details item-->
														<?php } ?>

														<!--begin::Details item-->
														<div class="fw-bold mt-5">Lead Source</div>
														<div class="text-gray-600"><?php echo ($selected_advisor_data->lead_source) ? Settings()->get_selected_lead_source_data($selected_advisor_data->lead_source)->type  : ''; ?></div>

														<!--begin::Details item-->
														<div class="fw-bold mt-5">Affiliations</div>
														<div class="text-gray-600"><?php echo ($selected_advisor_data->affiliations) ? Settings()->get_selected_affiliations_data($selected_advisor_data->affiliations)->type  : ''; ?></div>

														<!--begin::Details item-->
														<div class="fw-bold mt-5">Carriers Appointed</div>
														<div class="text-gray-600"><?php echo ($selected_advisor_data->carrier_appointed) ? Settings()->get_selected_carrier_appointed_data($selected_advisor_data->carrier_appointed)->type  : ''; ?></div>

														<!--begin::Details item-->
														<div class="fw-bold mt-5">Carriers Business</div>
														<div class="text-gray-600"><?php echo ($selected_advisor_data->carrier_with_business) ? Settings()->get_selected_multiple_carrier_name($selected_advisor_data->carrier_with_business)  : ''; ?></div>

														<!--begin::Details item-->
														<div class="fw-bold mt-5">Premium Volume</div>
														<div class="text-gray-600"><?php echo ($selected_advisor_data->premium_volume) ? Settings()->get_selected_premium_volume_data($selected_advisor_data->premium_volume)->type  : ''; ?></div>

														<!--begin::Details item-->
														<div class="fw-bold mt-5">Production Percentages </div>
														<div class="text-gray-600"><?php echo ($selected_advisor_data->production_percentages) ? Settings()->get_selected_multiple_production_percentage_name($selected_advisor_data->production_percentages)  : ''; ?></div>

														<!--begin::Details item-->
														<div class="fw-bold mt-5">Markets </div>
														<div class="text-gray-600"><?php echo ($selected_advisor_data->markets) ? Settings()->get_selected_multiple_market_name($selected_advisor_data->markets)  : ''; ?></div>
													</div>
												</div>
												<!--end::Details content-->
											</div>
											<!--end::Card body-->
										</div>
										<!--end::Card-->
									</div>
									<!--end::Sidebar-->
									<!--begin::Content-->
									<div class="flex-lg-row-fluid ms-lg-15">

										<!--begin:::Tabs-->
										<ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x  fs-4 fw-semibold mb-8">
											<!--begin:::Tab item-->
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_user_view_overview_personal_info_tab">Personal Info </a>
											</li>
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_user_view_overview_address_tab">Address Info</a>
											</li>
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_user_view_overview_historic_emp_tab">Business Info </a>
											</li>
											<li class="nav-item">
												<a class="nav-link text-active-primary pb-4 " data-bs-toggle="tab" href="#kt_user_view_overview_interests_tab">Interests</a>
											</li>
											<!--end:::Tab item-->
										</ul>
										<!--end:::Tabs-->
										<!--begin:::Tab content-->
										<div class="tab-content" id="myTabContent">
											<!--begin:::Tab pane-->
											<div class="tab-pane fade active show" id="kt_user_view_overview_personal_info_tab" role="tabpanel">
												<!--begin::details View-->
												<div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
													<!--begin::Card header-->
													<div class="card-header">
														<!--begin::Card title-->
														<div class="card-title m-0">
															<h3 class="fw-bold m-0">Profile Details</h3>
														</div>
														<!--end::Card title-->
														<!--begin::Action-->
														<a href="" class="btn btn-sm btn-primary align-self-center" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_profile" id="edit_profile" advisor_id="<?php echo $selected_advisor_data->id; ?>">Edit Profile</a>
														<!--end::Action-->
													</div>
													<!--begin::Card header-->
													<!--begin::Card body-->
													<div class="card-body p-9">
														<!--begin::Row-->
														<div class="row mb-7">
															<!--begin::Label-->
															<label class="col-lg-4 fw-semibold text-muted">Full Name</label>
															<!--end::Label-->
															<!--begin::Col-->
															<div class="col-lg-8">
																<span class="fw-bold fs-6 text-gray-800"><?php echo $selected_advisor_data->first_name . ' ' . $selected_advisor_data->last_name; ?></span>
															</div>
															<!--end::Col-->
														</div>
														<!--end::Row-->
														<!--begin::Input group-->
														<div class="row mb-7">
															<!--begin::Label-->
															<label class="col-lg-4 fw-semibold text-muted">Email</label>
															<!--end::Label-->
															<!--begin::Col-->
															<div class="col-lg-8 d-flex align-items-center">
																<span class="fw-bold fs-6 text-gray-800 me-2"><?php echo $selected_advisor_data->email; ?></span>
																<span class="badge badge-success">Verified</span>
															</div>
															<!--end::Col-->
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="row mb-7">
															<!--begin::Label-->
															<label class="col-lg-4 fw-semibold text-muted">Phone No</label>
															<!--end::Label-->
															<!--begin::Col-->
															<div class="col-lg-8">
																<a href="#" class="fw-semibold fs-6 text-gray-800 text-hover-primary"><?php echo $selected_advisor_data->mobile_no; ?></a>
															</div>
															<!--end::Col-->
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="row mb-7">
															<!--begin::Label-->
															<label class="col-lg-4 fw-semibold text-muted">Birthdate</label>
															<!--end::Label-->
															<!--begin::Col-->
															<div class="col-lg-8">
																<span class="fw-bold fs-6 text-gray-800"><?php echo ($selected_advisor_data->birth_date) ? date("d, M Y", strtotime($selected_advisor_data->birth_date)) : '-'; ?></span>
															</div>
															<!--end::Col-->
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="row mb-7">
															<!--begin::Label-->
															<label class="col-lg-4 fw-semibold text-muted">Gender</label>
															<!--end::Label-->
															<!--begin::Col-->
															<div class="col-lg-8">
																<span class="fw-bold fs-6 text-gray-800"><?php echo $selected_advisor_data->gender; ?></span>
															</div>
															<!--end::Col-->
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<div class="row mb-7">
															<!--begin::Label-->
															<label class="col-lg-4 fw-semibold text-muted">Marital</label>
															<!--end::Label-->
															<!--begin::Col-->
															<div class="col-lg-8">
																<span class="fw-bold fs-6 text-gray-800"><?php echo $selected_advisor_data->marital_status; ?></span>
															</div>
															<!--end::Col-->
														</div>
														<!--end::Input group-->
														<!--begin::Input group-->
														<?php if ($selected_advisor_data->marital_status == 'Married') { ?>
															<div class="row mb-7">
																<!--begin::Label-->
																<label class="col-lg-4 fw-semibold text-muted">Anniversary</label>
																<!--end::Label-->
																<!--begin::Col-->
																<div class="col-lg-8">
																	<span class="fw-bold fs-6 text-gray-800"><?php echo ($selected_advisor_data->anniversary_date) ? date('d, M Y', strtotime($selected_advisor_data->anniversary_date)) : ''; ?></span>
																</div>
																<!--end::Col-->
															</div>
														<?php } ?>
														<!--end::Input group-->
													</div>
													<!--end::Card body-->
												</div>
												<!--end::details View-->
											</div>
											<!--end:::Tab pane-->

											<!--begin:::Tab pane-->
											<div class="tab-pane fade address_info_tab_content" id="kt_user_view_overview_address_tab" role="tabpanel">
												<!--begin::details View-->
												<div class="card mb-5 mb-xl-10" id="">
													<!--begin::Card header-->
													<div class="card-header ">
														<!--begin::Card title-->
														<div class="card-title m-0">
															<h3 class="fw-bold m-0">Address Details</h3>
														</div>
														<!--end::Card title-->
														<!--begin::Action-->
														<!--end::Action-->
													</div>
													<!--begin::Card header-->
													<!--begin::Card body-->
													<div class="card-body p-9">
														<div class="row g-9 mb-8">
															<div class="col-md-6 fv-row">

																<div class="row mb-2">
																	<div class="col-md-10">
																		<h4 class="text-gray-800 fw-bold"><?php echo Advisor()->get_advisor_meta($selected_advisor_data->id, 'resident_address_label'); ?> </h4>
																	</div>
																	<div class="col-md-2">
																		<a href="" class="badge badge-light-primary fw-bold me-auto px-4 py-3 " data-bs-toggle="modal" data-bs-target="#kt_modal_edit_resident_address" address_type='resident' id="edit_resident_address" advisor_id="<?php echo $selected_advisor_data->id; ?>">Edit </a>
																	</div>
																</div>
																<div class="card-rounded bg-primary bg-opacity-5 p-10">
																	<div class="mb-8">
																		<img src="<?php echo site_url(); ?>/assets/media/stock/900x600/44.jpg" class="rounded mw-75" alt="">
																	</div>
																	<!--begin::Item-->
																	<div class="d-flex align-items-center ">
																		<!--begin::Icon-->
																		<i class="ki-outline ki-geolocation fs-1 text-primary me-5"></i>
																		<!--end::Icon-->
																		<!--begin::Info-->
																		<div class="d-flex flex-column">
																			<h5 class="text-gray-800 fw-bold">Resident Address
																			</h5>
																			<!--begin::Section-->
																			<div class="fw-semibold">
																				<!--begin::Link-->
																				<a href="#" class="link-primary"><?php echo Advisor()->get_advisor_meta($selected_advisor_data->id, 'resident_street_address') . '  ' . Advisor()->get_advisor_meta($selected_advisor_data->id, 'resident_building_name') . ', ' . $selected_advisor_data->city . ', ' . $selected_advisor_data->state . ', ' . $selected_advisor_data->zipcode; ?></a>
																				<!--end::Link-->
																			</div>
																			<!--end::Section-->
																		</div>
																		<!--end::Info-->
																	</div>
																	<!--end::Item-->
																</div>
															</div>
															<div class="col-md-6 fv-row">
																<div class="row mb-2">
																	<div class="col-md-10">
																		<h4 class="text-gray-800 fw-bold"><?php echo Advisor()->get_advisor_meta($selected_advisor_data->id, 'business_address_label'); ?> </h4>
																	</div>
																	<div class="col-md-2">
																		<a href="" class="badge badge-light-primary fw-bold me-auto px-4 py-3 " data-bs-toggle="modal" data-bs-target="#kt_modal_edit_business_address" address_type='business' id="edit_business_address" advisor_id="<?php echo $selected_advisor_data->id; ?>">Edit </a>
																	</div>
																</div>
																<div class="card-rounded bg-primary bg-opacity-5 p-10">
																	<div class="mb-8">

																		<img src="<?php echo site_url(); ?>/assets/media/stock/900x600/44.jpg" class="rounded mw-75" alt="">
																	</div>
																	<!--begin::Item-->
																	<div class="d-flex align-items-center ">
																		<!--begin::Icon-->
																		<i class="ki-outline ki-geolocation fs-1 text-primary me-5"></i>
																		<!--end::Icon-->
																		<!--begin::Info-->
																		<div class="d-flex flex-column">
																			<h5 class="text-gray-800 fw-bold">Businss Address
																			</h5>
																			<!--begin::Section-->
																			<div class="fw-semibold">
																				<!--begin::Link-->
																				<a href="#" class="link-primary"><?php echo Advisor()->get_advisor_meta($selected_advisor_data->id, 'business_street_address') . '  ' . Advisor()->get_advisor_meta($selected_advisor_data->id, 'business_building_name') . ', ' . $selected_advisor_data->business_city . ', ' . $selected_advisor_data->business_state . ', ' . $selected_advisor_data->business_zipcode; ?></a>
																				<!--end::Link-->
																			</div>
																			<!--end::Section-->
																		</div>
																		<!--end::Info-->
																	</div>
																	<!--end::Item-->
																</div>
															</div>
														</div>
													</div>
													<!--end::Card body-->
												</div>
												<!--end::details View-->
											</div>

											<!--begin:::Tab pane-->
											<div class="tab-pane fade" id="kt_user_view_overview_historic_emp_tab" role="tabpanel">
												<!--begin::details View-->
												<div class="card mb-5 mb-xl-10" id="">
													<!--begin::Card header-->
													<div class="card-header cursor-pointer">
														<!--begin::Card title-->
														<div class="card-title m-0">
															<h3 class="fw-bold m-0">Employment History</h3>
														</div>
														<!--end::Card title-->
														<!--begin::Action-->
														<a href="" class="btn btn-sm btn-primary align-self-center" data-bs-toggle="modal" data-bs-target="#kt_modal_employment">Add Employment</a>
														<!--end::Action-->
													</div>
													<!--begin::Card header-->
													<!--begin::Card body-->
													<div class="card-body p-9">
														<!--begin::Table wrapper-->
														<div class="table-responsive">
															<!--begin::Table-->
															<table class="table align-middle table-row-bordered table-row-solid gy-4 gs-9">
																<!--begin::Thead-->
																<thead class="border-gray-200 fs-5 fw-semibold bg-lighten">
																	<tr>
																		<th class="min-w-250px">Company Name</th>
																		<th class="min-w-100px">Address</th>
																		<th class="min-w-100px">State</th>
																		<th class="min-w-150px">Start Date</th>
																		<th class="min-w-150px">End Date</th>
																	</tr>
																</thead>
																<!--end::Thead-->
																<!--begin::Tbody-->
																<tbody class="fw-6 fw-semibold text-gray-600">
																	<?php
																	if ($get_advisor_employment_history) {
																		foreach ($get_advisor_employment_history as $employment_history) {
																	?>
																			<tr>
																				<td><?php echo $employment_history->company_name; ?></td>
																				<td><?php echo $employment_history->company_address; ?></td>
																				<td><span class="badge badge-light-primary fs-7 fw-bold"><?php echo $employment_history->state; ?></span></td>
																				<td><?php echo date("F, d Y", strtotime($employment_history->start_date)); ?></td>
																				<td><?php echo date("F, d Y", strtotime($employment_history->end_date)); ?></td>
																			</tr>
																	<?php
																		}
																	} ?>

																</tbody>
																<!--end::Tbody-->
															</table>
															<!--end::Table-->
														</div>
														<!--end::Table wrapper-->
													</div>
													<!--end::Card body-->
												</div>
												<!--end::details View-->
											</div>
											<!--end:::Tab pane-->
											<!--begin:::Tab pane-->
											<div class="tab-pane fade " id="kt_user_view_overview_interests_tab" role="tabpanel">
												<div class="card mb-5 mb-xl-10">
													<!--begin::Card header-->
													<div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse" data-bs-target="#kt_account_email_preferences" aria-expanded="true" aria-controls="kt_account_email_preferences">
														<div class="card-title m-0">
															<h3 class="fw-bold m-0">What is the agent's current interest in selling in the industry?
															</h3>
														</div>
													</div>
													<!--begin::Card header-->
													<!--begin::Content-->
													<div id="" class="">
														<!--begin::Form-->
														<form class="form" method="post">
															<!--begin::Card body-->
															<div class="card-body border-top px-9 py-5">
																<h3 class="m-0 text-gray-900 flex-grow-1 mb-6">
																	Life Insurance
																</h3>
																<div class="row mb-7">
																	<?php
																	foreach ($get_interest_life_insurance_list as $key => $life_insurance_result) { ?>
																		<div class="col-md-4 fv-row">
																			<!--begin::Option-->
																			<label class="form-check form-check-custom form-check-solid align-items-start">
																				<!--begin::Input-->
																				<input class="form-check-input me-3" type="checkbox" name="life_insurance[]" value="<?php echo $key; ?>" <?php echo (in_array($key, $selected_life_insurance)) ? 'checked' : ''; ?> />
																				<!--end::Input-->
																				<!--begin::Label-->
																				<span class="form-check-label d-flex flex-column align-items-start">
																					<span class="fw-bold fs-5 mb-0"><?php echo $life_insurance_result; ?></span>
																				</span>
																				<!--end::Label-->
																			</label>
																			<!--end::Option-->
																			<!--begin::Option-->
																			<div class="separator separator-dashed my-6"></div>
																			<!--end::Option-->
																		</div>
																	<?php } ?>
																</div>
																<h3 class="m-0 text-gray-900 flex-grow-1 mb-6">
																	Annuities
																</h3>
																<div class="row mb-7">
																	<?php
																	foreach ($get_interest_annuities_list as $key => $annuities_result) { ?>
																		<div class="col-md-4 fv-row">
																			<!--begin::Option-->
																			<label class="form-check form-check-custom form-check-solid align-items-start">
																				<!--begin::Input-->
																				<input class="form-check-input me-3" type="checkbox" name="annuities[]" value="<?php echo $key; ?>" <?php echo (in_array($key, $selected_annuities)) ? 'checked' : ''; ?> />
																				<!--end::Input-->
																				<!--begin::Label-->
																				<span class="form-check-label d-flex flex-column align-items-start">
																					<span class="fw-bold fs-5 mb-0"><?php echo $annuities_result; ?></span>
																				</span>
																				<!--end::Label-->
																			</label>
																			<!--end::Option-->
																			<!--begin::Option-->
																			<div class="separator separator-dashed my-6"></div>
																			<!--end::Option-->
																		</div>
																	<?php } ?>
																</div>
																<h3 class="m-0 text-gray-900 flex-grow-1 mb-6">
																	Long-Term Care Insurance
																</h3>
																<div class="row mb-7">
																	<?php
																	foreach ($get_interest_long_term_care_insurance_list as $key => $long_term_care_result) { ?>
																		<div class="col-md-4 fv-row">
																			<!--begin::Option-->
																			<label class="form-check form-check-custom form-check-solid align-items-start">
																				<!--begin::Input-->
																				<input class="form-check-input me-3" type="checkbox" name="long_term_care_insurance[]" value="<?php echo $key; ?>" <?php echo (in_array($key, $selected_long_term_care_insurance)) ? 'checked' : ''; ?> />
																				<!--end::Input-->
																				<!--begin::Label-->
																				<span class="form-check-label d-flex flex-column align-items-start">
																					<span class="fw-bold fs-5 mb-0"><?php echo $long_term_care_result; ?></span>
																				</span>
																				<!--end::Label-->
																			</label>
																			<!--end::Option-->
																			<!--begin::Option-->
																			<div class="separator separator-dashed my-6"></div>
																			<!--end::Option-->
																		</div>
																	<?php } ?>
																</div>
																<h3 class="m-0 text-gray-900 flex-grow-1 mb-6">
																	Critical Illness
																</h3>
																<div class="row mb-7">
																	<?php
																	foreach ($get_interest_critical_illness_list as $key => $critical_illness_result) { ?>
																		<div class="col-md-4 fv-row">
																			<!--begin::Option-->
																			<label class="form-check form-check-custom form-check-solid align-items-start">
																				<!--begin::Input-->
																				<input class="form-check-input me-3" type="checkbox" name="critical_illness[]" value="<?php echo $key; ?>" <?php echo (in_array($key, $selected_critical_illness)) ? 'checked' : ''; ?> />
																				<!--end::Input-->
																				<!--begin::Label-->
																				<span class="form-check-label d-flex flex-column align-items-start">
																					<span class="fw-bold fs-5 mb-0"><?php echo $critical_illness_result; ?></span>
																				</span>
																				<!--end::Label-->
																			</label>
																			<!--end::Option-->
																			<!--begin::Option-->
																			<div class="separator separator-dashed my-6"></div>
																			<!--end::Option-->
																		</div>
																	<?php } ?>
																</div>
																<div class="row mb-7">
																	<!--begin::Input wrapper-->
																	<div class="col-md-6 fv-row">
																		<!--begin::Label-->
																		<label class="fw-semibold fs-6 mb-2">Disability Income</label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<select name="disability_income" id="disability_income_edit" data-control="select2" data-placeholder="Select a Disability Income..." class="form-select form-select-solid is_empty">
																			<option value="">Select Disability Income</option>
																			<?php foreach ($get_interest_disability_income_list as $key => $disability_income_result) { ?>
																				<option <?php echo ($get_selected_advisor_interest && ($key == $get_selected_advisor_interest->disability_income)) ? 'selected' : ''; ?> value="<?php echo $key; ?>"><?php echo $disability_income_result; ?></option>
																			<?php } ?>
																		</select>
																		<!--end::Input-->
																	</div>
																	<!--end::Input wrapper-->
																	<!--begin::Input wrapper-->
																	<div class="col-md-6 fv-row">
																		<!--begin::Label-->
																		<label class="fw-semibold fs-6 mb-2">Group Insurance </label>
																		<!--end::Label-->
																		<!--begin::Input-->
																		<select name="group_insurance" id="group_insurance_edit" data-control="select2" data-placeholder="Select a Group Insurance ..." class="form-select form-select-solid is_empty">
																			<option value="">Select Group Insurance </option>
																			<?php foreach ($get_interest_group_insurance_list as $key => $group_insurance_result) { ?>
																				<option <?php echo ($get_selected_advisor_interest && ($key == $get_selected_advisor_interest->group_insurance)) ? 'selected' : ''; ?> value="<?php echo $key; ?>"><?php echo $group_insurance_result; ?></option>
																			<?php } ?>
																		</select>
																		<!--end::Input-->
																	</div>
																	<!--end::Input wrapper-->
																</div>
															</div>
															<!--end::Card body-->
															<!--begin::Card footer-->
															<div class="card-footer d-flex justify-content-end py-6 px-9">
																<button type="submit" name="update_interest" class="btn btn-primary px-6">Save Changes</button>
															</div>
															<!--end::Card footer-->
														</form>
														<!--end::Form-->
													</div>
													<!--end::Content-->
												</div>
											</div>
											<!--end:::Tab pane-->
										</div>
										<!--end:::Tab content-->
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
	<!--begin::Modals-->
	<!--begin::Modal - Edit Profile -->
	<div class="modal fade" id="kt_modal_edit_profile" tabindex="-1" aria-hidden="true">
		<!--begin::Modal dialog-->
		<div class="modal-dialog modal-dialog-centered mw-850px">
			<!--begin::Modal content-->
			<div class="modal-content modal-rounded">
				<!--begin::Modal header-->
				<div class="modal-header py-5 d-flex justify-content-between">
					<!--begin::Modal title-->
					<h2>Profile Details</h2>
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
					<form class="" id="edit_profile_form" method="post" enctype="multipart/form-data">
						<div class="w-100">
							<!--begin::Input group-->
							<div class="row mb-7">
								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">First Name</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="first_name" id="first_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="First Name" required />
									<!--end::Input-->
								</div>

								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Last Name</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="last_name" id="last_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Last Name" required />
									<!--end::Input-->
								</div>
							</div>
							<!--begin::Input group-->
							<div class="row mb-7">
								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Email</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="email" name="email" id="email" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Email" required />
									<!--end::Input-->
								</div>

								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Phone No</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="mobile_no" id="mobile_no" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Mobile No" required />
									<!--end::Input-->
								</div>
							</div>

							<!--begin::Input group-->
							<div class="row mb-7">
								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Birthdate</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="birth_date" id="birth_date" class="flatpickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Birthdate" required />
									<!--end::Input-->
								</div>

								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Gender</label>
									<!--end::Label-->
									<!--begin::Input-->
									<select name="gender" id="gender" data-control="select2" data-placeholder="Select a Gender..." class="form-select form-select-solid is_empty" data-dropdown-parent="#kt_modal_edit_profile" required>
										<option value="">Select Gender</option>
										<option value="Male">Male</option>
										<option value="Female">Female</option>
										<option value="Other">Other</option>
									</select>
									<!--end::Input-->
								</div>
							</div>

							<!--begin::Input group-->
							<div class="row mb-7">
								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Marital Status</label>
									<!--end::Label-->
									<!--begin::Input-->
									<select name="marital_status" id="marital_status" data-control="select2" data-placeholder="Select a Status..." class="form-select form-select-solid is_empty" data-dropdown-parent="#kt_modal_edit_profile" required>
										<option value="">Select Status</option>
										<option value="Married">Married</option>
										<option value="Unmarried">Unmarried</option>
									</select>
									<!--end::Input-->
								</div>

								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class="fw-semibold fs-6 mb-2">Wedding Anniversary</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="anniversary_date" id="anniversary_date" class="flatpickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Wedding Anniversary" />
									<!--end::Input-->
								</div>
							</div>

							<div class="d-flex justify-content-end align-items-center mt-12">

								<!--begin::Button-->
								<button type="submit" class="btn btn-primary" id="save_profile" name="save_profile">
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

	<!--begin::Modals-->
	<!--begin::Modal - Edit Resident Address -->
	<div class="modal fade" id="kt_modal_edit_resident_address" tabindex="-1" aria-hidden="true">
		<!--begin::Modal dialog-->
		<div class="modal-dialog modal-dialog-centered mw-850px">
			<!--begin::Modal content-->
			<div class="modal-content modal-rounded">
				<!--begin::Modal header-->
				<div class="modal-header py-5 d-flex justify-content-between">
					<!--begin::Modal title-->
					<h2>Residential Address Details</h2>
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
					<form class="" id="edit_resident_address_form" method="post" enctype="multipart/form-data">
						<div class="w-100">
							<!--begin::Input group-->
							<div class="row mb-7">
								<div class="col-md-12 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Custom Residential Label
									</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="resident_address_label" id="resident_address_label" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Street Address" required />
									<!--end::Input-->
								</div>
							</div>
							<div class="row mb-7">

								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Street Address</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="resident_street_address" id="resident_street_address" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Street Address" required />
									<!--end::Input-->
								</div>

								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class=" fw-semibold fs-6 mb-2">Apartment, suite, unit, building, floor, etc.</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="resident_building_name" id="resident_building_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Apartment, suite, unit, building, floor, etc" />
									<!--end::Input-->
								</div>
							</div>
							<div class="row mb-7">
								<div class="col-md-4 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">City</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="resident_city" id="resident_city" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="City" required />
									<!--end::Input-->
								</div>

								<div class="col-md-4 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">State</label>
									<!--end::Label-->
									<!--begin::Input-->
									<select name="resident_state" id="resident_state" data-control="select2" data-placeholder="Select a State..." class="form-select form-select-solid is_empty" data-dropdown-parent="#kt_modal_edit_resident_address" required>
										<option value="">Select State</option>
										<?php foreach ($get_state_list as $state_result) { ?>
											<option value="<?php echo $state_result; ?>"><?php echo $state_result; ?></option>
										<?php } ?>
									</select>
									<!--end::Input-->
								</div>

								<div class="col-md-4 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Zipcode</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="resident_zipcode" id="resident_zipcode" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Zipcode" required />
									<!--end::Input-->
								</div>
							</div>
							<div class="d-flex justify-content-end align-items-center mt-12">
								<!--begin::Button-->
								<button type="submit" class="btn btn-primary" id="save_resident_address" name="save_resident_address">
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
		<!--end::Modal - Edit Resident Address-->
	</div>
	<!--end::Modals-->

	<!--begin::Modals-->
	<!--begin::Modal - Edit Business Address -->
	<div class="modal fade" id="kt_modal_edit_business_address" tabindex="-1" aria-hidden="true">
		<!--begin::Modal dialog-->
		<div class="modal-dialog modal-dialog-centered mw-850px">
			<!--begin::Modal content-->
			<div class="modal-content modal-rounded">
				<!--begin::Modal header-->
				<div class="modal-header py-5 d-flex justify-content-between">
					<!--begin::Modal title-->
					<h2>Business Address Details</h2>
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
					<form class="" id="edit_business_address_form" method="post" enctype="multipart/form-data">
						<div class="w-100">
							<!--begin::Input group-->
							<div class="row mb-7">
								<div class="col-md-12 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Custom Business Label
									</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="business_address_label" id="business_address_label" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Street Address" required />
									<!--end::Input-->
								</div>
							</div>
							<div class="row mb-7">

								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Street Address</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="business_street_address" id="business_street_address" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Street Address" required />
									<!--end::Input-->
								</div>

								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class=" fw-semibold fs-6 mb-2">Apartment, suite, unit, building, floor, etc.</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="business_building_name" id="business_building_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Apartment, suite, unit, building, floor, etc" />
									<!--end::Input-->
								</div>
							</div>
							<div class="row mb-7">
								<div class="col-md-4 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">City</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="business_city" id="business_city" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="City" required />
									<!--end::Input-->
								</div>

								<div class="col-md-4 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">State</label>
									<!--end::Label-->
									<!--begin::Input-->
									<select name="business_state" id="business_state" data-control="select2" data-placeholder="Select a State..." class="form-select form-select-solid is_empty" data-dropdown-parent="#kt_modal_edit_business_address" required>
										<option value="">Select State</option>
										<?php foreach ($get_state_list as $state_result) { ?>
											<option value="<?php echo $state_result; ?>"><?php echo $state_result; ?></option>
										<?php } ?>
									</select>
									<!--end::Input-->
								</div>

								<div class="col-md-4 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Zipcode</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="business_zipcode" id="business_zipcode" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Zipcode" required />
									<!--end::Input-->
								</div>
							</div>
							<div class="d-flex justify-content-end align-items-center mt-12">

								<!--begin::Button-->
								<button type="submit" class="btn btn-primary" id="save_business_address" name="save_business_address">
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

	<!--begin::Modals-->
	<!--begin::Modal - Create Campaign-->
	<div class="modal fade" id="kt_modal_employment" tabindex="-1" aria-hidden="true">
		<!--begin::Modal dialog-->
		<div class="modal-dialog modal-dialog-centered mw-1000px">
			<!--begin::Modal content-->
			<div class="modal-content modal-rounded">
				<!--begin::Modal header-->
				<div class="modal-header py-5 d-flex justify-content-between">
					<!--begin::Modal title-->
					<h2>Employment</h2>
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
					<form class="" id="employment_form" method="post" enctype="multipart/form-data">
						<div class="w-100">
							<!--begin::Input group-->
							<div class="row mb-7">
								<div class="col-md-4 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Employment Status</label>
									<!--end::Label-->
									<!--begin::Input-->
									<select name="employe_status" id="employment_status" data-control="select2" data-placeholder="Select a Employment Status..." class="form-select form-select-solid" data-dropdown-parent="#kt_modal_employment" required>
										<option value="">Select Title</option>
										<?php foreach (Settings()->get_employment_status_list() as $key => $employment_status_result) { ?>
											<option value="<?php echo $key; ?>"><?php echo $employment_status_result; ?></option>
										<?php } ?>
									</select>
									<!--end::Input-->
								</div>
								<div class="col-md-8 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Company Name</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="company_name" id="company_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Employment Name" required />
									<!--end::Input-->
								</div>
							</div>
							<div class="row mb-7">
								<div class="col-md-2 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Start Date</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="start_date" id="start_date" class="flatpickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Start Date" required />
									<!--end::Input-->
								</div>
								<div class="col-md-2 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">End Date</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="end_date" id="end_date" class="flatpickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="End Date" required />
									<!--end::Input-->
								</div>
								<div class="col-md-8 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Company Street Address</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="company_address" id="company_address" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Company Street Address" required />
									<!--end::Input-->
								</div>

							</div>
							<div class="row mb-7">
								<div class="col-md-4 fv-row">
									<!--begin::Label-->
									<label class=" fw-semibold fs-6 mb-2">Apartment, suite, unit, building, floor, etc.</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="building" id="building" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Apartment, suite, unit, building, floor, etc." />
									<!--end::Input-->
								</div>
								<div class="col-md-3 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">City</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="city" id="city" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="City" required />
									<!--end::Input-->
								</div>
								<div class="col-md-3 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">State</label>
									<!--end::Label-->
									<!--begin::Input-->
									<select name="state" id="state" data-control="select2" data-placeholder="Select a State..." class="form-select form-select-solid is_empty" data-dropdown-parent="#kt_modal_employment" required>
										<option value="">Select State</option>
										<?php foreach ($get_state_list as $state_result) { ?>
											<option value="<?php echo $state_result; ?>"><?php echo $state_result; ?></option>
										<?php } ?>
									</select>
									<!--end::Input-->
								</div>
								<div class="col-md-2 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Zipcode</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="zipcode" id="zipcode" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Zipcode" required />
									<!--end::Input-->
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 fv-row">
									<!--begin::Label-->
									<label class="fw-semibold fs-6 mb-1">Types of Business</label>
									<!--end::Label-->
								</div>
							</div>
							<div class="row mb-6">
								<div class="col-md-6 fv-row">
									<div class="row">
										<!--begin::Label-->
										<label class="col-lg-2 col-form-label fw-semibold fs-6 text-center">
											<span class="">RIA</span>
										</label>
										<!--end::Label-->

										<!--begin::Col-->
										<div class="col-lg-10 fv-row fv-plugins-icon-container">
											<input type="text" name="ria" class="form-control form-control-lg form-control-solid" placeholder="Name">
										</div>
										<!--end::Col-->
									</div>
								</div>
								<div class="col-md-6 fv-row">
									<div class="row">
										<!--begin::Label-->
										<label class="col-lg-2 col-form-label fw-semibold fs-6 text-center">
											<span class="">BD</span>
										</label>
										<!--end::Label-->

										<!--begin::Col-->
										<div class="col-lg-10 fv-row fv-plugins-icon-container">
											<input type="text" name="bd" class="form-control form-control-lg form-control-solid" placeholder="Name">
										</div>
										<!--end::Col-->
									</div>
								</div>
							</div>
							<div class="row mb-6">
								<div class="col-md-6 fv-row">
									<div class="row">
										<!--begin::Label-->
										<label class="col-lg-2 col-form-label fw-semibold fs-6 text-center">
											<span class="">GA</span>
										</label>
										<!--end::Label-->

										<!--begin::Col-->
										<div class="col-lg-10 fv-row fv-plugins-icon-container">
											<input type="text" name="ga" class="form-control form-control-lg form-control-solid" placeholder="GA">
										</div>
										<!--end::Col-->
									</div>
								</div>
								<div class="col-md-6 fv-row">
									<div class="row">
										<!--begin::Label-->
										<label class="col-lg-2 col-form-label fw-semibold fs-6 text-center">
											<span class="">MGA</span>
										</label>
										<!--end::Label-->

										<!--begin::Col-->
										<div class="col-lg-10 fv-row fv-plugins-icon-container">
											<input type="text" name="mga" class="form-control form-control-lg form-control-solid" placeholder="MGA">
										</div>
										<!--end::Col-->
									</div>
								</div>
							</div>
							<div class="row mb-6">
								<div class="col-md-6 fv-row">
									<div class="row ">
										<!--begin::Label-->
										<label class="col-lg-2 col-form-label fw-semibold fs-6 text-center">
											<span class="">PPGA</span>
										</label>
										<!--end::Label-->

										<!--begin::Col-->
										<div class="col-lg-10 fv-row fv-plugins-icon-container">
											<input type="text" name="ppga" class="form-control form-control-lg form-control-solid" placeholder="PPGA">
										</div>
										<!--end::Col-->
									</div>
								</div>
								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class=" fw-semibold fs-6 mb-2">What type of back office supports your company? </label>
									<!--end::Label-->
									<!--begin::Input-->

									<div class="d-flex">
										<label class="form-check form-check-custom form-check-solid mt-3 office_support me-10">
											<input class="form-check-input" type="radio" name="office_support" value="I have a full back office">
											<span class="form-check-label  text-gray-800">
												I have a full back office
											</span>
										</label>
										<label class="form-check form-check-custom form-check-solid mt-3 office_support">
											<input class="form-check-input" type="radio" name="office_support" value="I do not have a full back office">
											<span class="form-check-label text-gray-800">
												I do not have a full back office
											</span>
										</label>
									</div>
									<!--end::Input-->
								</div>
							</div>
							<div class="row">
								<!--end::Wrapper-->
								<div class="card card-flush">
									<!--begin::Card header-->
									<div class="card-header">
										<div class="card-title">
											<h2>Assistant Contact Information</h2>
										</div>
									</div>
									<!--end::Card header-->

									<!--begin::Card body-->
									<div class="card-body pt-0">
										<!--begin::Input group-->
										<div class="row mb-4 mb-7">
											<!--begin::Input wrapper-->
											<div class="col-md-4 fv-row">
												<!--begin::Label-->
												<label class="fw-semibold fs-6 mb-2">Name</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" name="assistant_name" id="assistant_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Name" />
												<!--end::Input-->
											</div>
											<!--end::Input wrapper-->
											<!--begin::Input wrapper-->
											<div class="col-md-4 fv-row">
												<!--begin::Label-->
												<label class="fw-semibold fs-6 mb-2">Phone</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" name="assistant_phone" id="assistant_phone" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Phone" />
												<!--end::Input-->
											</div>
											<!--end::Input wrapper-->
											<!--begin::Input wrapper-->
											<div class="col-md-4 fv-row">
												<!--begin::Label-->
												<label class="fw-semibold fs-6 mb-2">Email</label>
												<!--end::Label-->
												<!--begin::Input-->
												<input type="text" name="assistant_email" id="assistant_email" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Email" />
												<!--end::Input-->
											</div>
											<!--end::Input wrapper-->
										</div>

									</div>
									<!--end::Card header-->
								</div>
							</div>
							<div class="d-flex justify-content-end align-items-center mt-12">

								<!--begin::Button-->
								<button type="submit" class="btn btn-primary" id="save_employment" name="save_employment">
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
	</div>
	<!--end::Modals-->

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
		$(document).on("click", "#edit_profile", function() {

			var advisor_id = $(this).attr('advisor_id');

			$(".is_empty").val("");

			$("select.is_empty").val(null).trigger("change");

			$("textarea.is_empty").html("");

			if (!advisor_id)
				return false;

			$.post(ajax_url, {
				action: 'get_selected_advisor_data',
				advisor_id: advisor_id,
				is_ajax: true,
			}, function(result) {

				var results = JSON.parse(result);

				if (results) {
					$("#first_name").val(results.advisor_info.first_name);
					$("#last_name").val(results.advisor_info.last_name);
					$("#email").val(results.advisor_info.email);
					$("#mobile_no").val(results.advisor_info.mobile_no);
					if (results.advisor_info.birth_date) {
						$("#birth_date").val(change_ymd_to_dmy_text(results.advisor_info.birth_date));
					}
					$("#gender").val(results.advisor_info.gender).trigger("change");
					$("#marital_status").val(results.advisor_info.marital_status).trigger("change");

					if (results.advisor_info.anniversary_date) {
						$("#anniversary_date").val(change_ymd_to_dmy_text(results.advisor_info.anniversary_date));
					}
				}

			});
		});

		$(document).on("click", "#edit_resident_address", function() {

			var advisor_id = $(this).attr('advisor_id');

			var address_type = $(this).attr('address_type');

			$(".is_empty").val("");

			$("select.is_empty").val(null).trigger("change");

			$("textarea.is_empty").html("");

			if (!advisor_id)
				return false;

			get_address(advisor_id, address_type);

		});

		$(document).on("click", "#edit_business_address", function() {

			var advisor_id = $(this).attr('advisor_id');

			var address_type = $(this).attr('address_type');

			$(".is_empty").val("");

			$("select.is_empty").val(null).trigger("change");

			$("textarea.is_empty").html("");

			if (!advisor_id)
				return false;

			get_address(advisor_id, address_type);

		});

		function get_address(advisor_id, address_type) {

			if (!advisor_id)
				return false;

			console.log(address_type);

			$.post(ajax_url, {
				action: 'get_selected_address_data',
				advisor_id: advisor_id,
				is_ajax: true,
			}, function(result) {

				var results = JSON.parse(result);

				if (results) {

					if (address_type == 'resident') {
						$("#resident_address_label").val(results.resident.address_label);
						$("#resident_street_address").val(results.resident.street_address);
						$("#resident_building_name").val(results.resident.resident_building_name);
						$("#resident_city").val(results.resident.city);
						$("#resident_state").val(results.resident.state).trigger("change");
						$("#resident_zipcode").val(results.resident.zipcode);
					}

					if (address_type == 'business') {
						$("#business_address_label").val(results.business.address_label);
						$("#business_street_address").val(results.business.street_address);
						$("#business_building_name").val(results.business.business_building_name);
						$("#business_city").val(results.business.city);
						$("#business_state").val(results.business.state).trigger("change");
						$("#business_zipcode").val(results.business.zipcode);
					}

				}

			});
		}
	</script>
</body>
<!--end::Body-->

</html>