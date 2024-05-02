<?php require '../../config.php';
$page_name = 'verification';
$sub_page_name = 'verification-list';
Admin()->check_login();

$selected_advisor_data = Advisor()->get_selected_advisor_data(siget('advisor_id'));

if (!$selected_advisor_data) {
	wp_redirect(site_url() . '/admin/verification/advisor-list');
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

	wp_redirect(site_url() . '/admin/verification/view-advisor/' . siget('advisor_id'));
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

	wp_redirect(site_url() . '/admin/verification/view-advisor/' . siget('advisor_id'));
	exit;
}

if (isset($_POST['save_address'])) {

	if (sipost('address_id')) {
		$response = Advisor()->update_address($selected_advisor_data->id);
	} else {
		$response = Advisor()->add_address($selected_advisor_data->id);
	}

	if ($response == 1) {
		$_SESSION['update_address_process_success'] = true;
	} else {
		$_SESSION['update_address_process_fail'] = true;
	}

	wp_redirect(site_url() . '/admin/verification/view-advisor/' . siget('advisor_id'));
	exit;
}

if (isset($_POST['save_activity'])) {

	$response = Advisor()->add_activity($selected_advisor_data->id);

	if ($response == 1) {
		$_SESSION['process_activity_success'] = true;
	} elseif ($response == 'duplicate') {
		$_SESSION['process_activity_duplicate'] = true;
	} else {
		$_SESSION['process_activity_fail'] = true;
	}

	wp_redirect(site_url() . '/admin/verification/view-advisor/' . siget('advisor_id'));
	exit;
}

$advisor_profile = Advisor()->get_advisor_meta($selected_advisor_data->id, 'profile_img');

$get_state_list = Settings()->get_state_list();

$get_advisor_last_employment = Advisor()->get_advisor_last_employment($selected_advisor_data->id);

$get_interest_life_insurance_list = Settings()->get_interest_life_insurance();

$get_interest_annuities_list = Settings()->get_interest_annuities();

$get_interest_long_term_care_insurance_list = Settings()->get_interest_long_term_care_insurance();

$get_interest_critical_illness_list = Settings()->get_interest_critical_illness();

$get_interest_disability_income_list = Settings()->get_interest_disability_income();

$get_interest_group_insurance_list = Settings()->get_interest_group_insurance();

$get_address_type_list = Settings()->get_address_type_list();

$get_selected_advisor_interest = Advisor()->get_selected_advisor_interest($selected_advisor_data->id);

$selected_life_insurance = ($get_selected_advisor_interest && $get_selected_advisor_interest->life_insurance) ? explode(",", $get_selected_advisor_interest->life_insurance) : array();

$selected_annuities = ($get_selected_advisor_interest && $get_selected_advisor_interest->annuities) ? explode(",", $get_selected_advisor_interest->annuities) : array();

$selected_long_term_care_insurance = ($get_selected_advisor_interest && $get_selected_advisor_interest->long_term_care_insurance) ? explode(",", $get_selected_advisor_interest->long_term_care_insurance) : array();

$selected_critical_illness = ($get_selected_advisor_interest && $get_selected_advisor_interest->critical_illness) ? explode(",", $get_selected_advisor_interest->critical_illness) : array();

$personal_interest = ($selected_advisor_data->personal_interest) ? implode(",", (unserialize($selected_advisor_data->personal_interest))) : '';

$financial_interest = ($selected_advisor_data->financial_interest) ? implode(",", (unserialize($selected_advisor_data->financial_interest))) : '';

$get_advisor_upcoming_activity_list = Advisor()->get_advisor_upcoming_activity($selected_advisor_data->id);

$get_advisor_past_activity_list = Advisor()->get_advisor_past_activity($selected_advisor_data->id);

$get_advisor_default_address = Advisor()->get_advisor_default_address($selected_advisor_data->id); // 1 Resident

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
						if (isset($_SESSION['process_activity_success'])) {
							unset($_SESSION['process_activity_success']); ?>
							<div class="alert alert-success d-flex align-items-center p-5 ms-lg-15">
								<i class="ki-duotone ki-shield-tick fs-2hx text-success  me-4"><span class="path1"></span><span class="path2"></span></i>
								<div class="d-flex flex-column">
									<h4 class="mb-1 text-success">The activity has been added successfully.</h4>
								</div>
							</div>
						<?php }

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

													<div class="text-gray-600 mb-2">Advisor Since <?php echo date("m/d/Y", strtotime($selected_advisor_data->created_at)); ?></div>
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
										<div class="pb-2">
											<h4 class="mb-0 text-primary">Profile Details</h4>
										</div>
										<div class="separator border-gray-400 mb-6"></div>

										<div class="etyre">
											<div class="row">
												<div class="col-xl-8 col-md-8 col-sm-12">
													<div class="row">
														<div class="col-xl-6 col-md-6 col-sm-12">
															<div class="card mb-5 mb-xl-10" id="">
																<!--begin::Card header-->
																<div class="card-header p-5 pt-0 pb-0">
																	<!--begin::Card title-->
																	<div class="card-title">
																		<i class="ki-duotone ki-user-tick fs-2x">
																			<span class="path1"></span>
																			<span class="path2"></span>
																			<span class="path3"></span>
																		</i>
																		<h3 class="fw-bold p-2 pt-0 pb-0">
																			Profile Info
																		</h3>
																	</div>
																	<!--end::Card title-->
																	<!--begin::Action-->
																	<a href="" class=" align-self-center" data-bs-toggle="modal" data-bs-target="#kt_modal_edit_profile" id="edit_profile" advisor_id="<?php echo $selected_advisor_data->id; ?>"><i class="bi bi-pencil-square text-primary fs-2x"></i>
																	</a>
																	<!--end::Action-->
																</div>
																<!--begin::Card header-->
																<!--begin::Card body-->
																<div class="card-body p-5">
																	<!--begin::Row-->
																	<div class="text-gray-600">Legal Name</div>
																	<div class="fw-bold mt-1"><?php echo $selected_advisor_data->prefix . '. ' . $selected_advisor_data->first_name . ' ' . $selected_advisor_data->last_name; ?></div>

																	<div class="text-gray-600 mt-4">Phone No </div>
																	<div class="fw-bold mt-1"><?php echo $selected_advisor_data->mobile_no; ?></div>

																	<div class="text-gray-600 mt-4">Email </div>
																	<div class="fw-bold mt-1"><?php echo $selected_advisor_data->email; ?> <i class="bi bi-patch-check-fill text-success"></i>
																	</div>

																	<div class="row  mt-4">
																		<div class="col-md-6">
																			<div class="text-gray-600">Birthdate </div>
																			<div class="fw-bold mt-1"><?php echo ($selected_advisor_data->birth_date) ? date("m/d/Y", strtotime($selected_advisor_data->birth_date)) : '-'; ?></div>
																		</div>
																		<div class="col-md-6">
																			<div class="text-gray-600">Gender </div>
																			<div class="fw-bold mt-1"><?php echo $selected_advisor_data->gender; ?></div>
																		</div>
																	</div>

																	<div class="row mt-4">
																		<div class="col-md-6">
																			<div class="text-gray-600">Marital </div>
																			<div class="fw-bold mt-1"><?php echo $selected_advisor_data->marital_status; ?></div>
																		</div>
																		<?php if ($selected_advisor_data->marital_status == 'Married') { ?>
																			<div class="col-md-6">
																				<div class="text-gray-600">Anniversary </div>
																				<div class="fw-bold mt-1"><?php echo ($selected_advisor_data->anniversary_date) ? date('m/d/Y', strtotime($selected_advisor_data->anniversary_date)) : ''; ?></div>
																			</div>
																		<?php } ?>
																	</div>

																	<div class="text-gray-600 mt-4"> Lead Source </div>
																	<div class="fw-bold mt-1"><?php echo ($selected_advisor_data->lead_source) ? Settings()->get_selected_lead_source_data($selected_advisor_data->lead_source)->type : '-'; ?></div>
																</div>
																<!--end::Card body-->
																<div class="card-footer p-5">
																	<div class="row">
																		<div class="col-md-5">
																			Social Media
																		</div>
																		<div class="col-md-7 text-sm-end">
																			<?php
																			$facebook_url = Advisor()->get_advisor_meta($selected_advisor_data->id, 'facebook_url');

																			$linkedin_url = Advisor()->get_advisor_meta($selected_advisor_data->id, 'linkedin_url');

																			$youtube_url = Advisor()->get_advisor_meta($selected_advisor_data->id, 'youtube_url');

																			$twitter_url = Advisor()->get_advisor_meta($selected_advisor_data->id, 'twitter_url');

																			if ($facebook_url) { ?>
																				<a class="p-1" href="<?php echo $facebook_url; ?>" target="_blank"><img src="<?php echo site_url(); ?>/assets/media/svg/social-logos/facebook.svg"></a>
																			<?php }

																			if ($linkedin_url) { ?>
																				<a class="p-1" href="<?php echo $linkedin_url; ?>" target="_blank"><img src="<?php echo site_url(); ?>/assets/media/svg/social-logos/linkedin.svg"></a>
																			<?php }

																			if ($twitter_url) { ?>
																				<a class="p-1" href="<?php echo $twitter_url; ?>" target="_blank"><img src="<?php echo site_url(); ?>/assets/media/svg/social-logos/twitter.svg"></a>
																			<?php }

																			if ($youtube_url) { ?>
																				<a class="p-1" href="<?php echo $youtube_url; ?>" target="_blank"><img src="<?php echo site_url(); ?>/assets/media/svg/social-logos/youtube.svg"></a>
																			<?php } ?>

																		</div>
																	</div>
																</div>
															</div>
															<?php if (!empty($get_advisor_last_employment)) {  ?>

																<div class="card mb-5 mb-xl-10" id="">
																	<!--begin::Card header-->
																	<div class="card-header p-5 pt-0 pb-0">
																		<!--begin::Card title-->
																		<div class="card-title">
																			<i class="ki-duotone ki-brifecase-tick fs-2x">
																				<span class="path1"></span>
																				<span class="path2"></span>
																				<span class="path3"></span>
																			</i>
																			<h3 class="fw-bold p-2 pt-0 pb-0">
																				Employed
																			</h3>
																		</div>
																		<!--end::Card title-->
																		<!--begin::Action-->
																		<a href="" class=" align-self-center" data-bs-toggle="modal" data-bs-target="#kt_modal_employment" id=""><i class="bi bi-plus-circle text-primary fs-2x"></i>
																		</a>
																		<!--end::Action-->
																	</div>
																	<!--begin::Card header-->
																	<!--begin::Card body-->
																	<div class="card-body p-5">
																		<!--begin::Row-->
																		<div class="text-gray-600">Company Name</div>
																		<div class="fw-bold mt-1"><?php echo $get_advisor_last_employment->company_name; ?></div>

																		<div class="row mt-4">
																			<div class="col-md-6">
																				<div class="text-gray-600"> Employement </div>
																				<div class="fw-bold mt-1">
																					<?php
																					foreach (Settings()->get_employment_status_list() as $key => $emp_status) {
																						if ($get_advisor_last_employment->employe_status == $key && $key == 1) {
																							echo 'Self-Employed';
																						}
																						if ($get_advisor_last_employment->employe_status == $key && $key == 2) {
																							echo 'Contract Employee';
																						}
																						if ($get_advisor_last_employment->employe_status == $key && $key == 3) {
																							echo 'Full-Time Employee';
																						}
																						if ($get_advisor_last_employment->employe_status == $key && $key == 4) {
																							echo 'Independent Contractor';
																						}
																						if ($get_advisor_last_employment->employe_status == $key && $key == 5) {
																							echo 'Intern or Apprentice';
																						}
																						if ($get_advisor_last_employment->employe_status == $key && $key == 6) {
																							echo 'Part-Time Employee';
																						}
																						if ($get_advisor_last_employment->employe_status == $key && $key == 7) {
																							echo 'Temporary or Seasonal Employee';
																						}
																						if ($get_advisor_last_employment->employe_status == $key && $key == 8) {
																							echo 'Unemployed';
																						}
																						if ($get_advisor_last_employment->employe_status == $key && $key == 9) {
																							echo 'Volunteer';
																						}
																					} ?>
																				</div>
																			</div>
																			<div class="col-md-6">
																				<div class="text-gray-600"> Occupation </div>
																				<div class="fw-bold mt-1"><?php echo $get_advisor_last_employment->office_support; ?></div>

																			</div>
																		</div>

																		<div class="row mt-4">
																			<div class="col-md-6">
																				<div class="text-gray-600">Start Date </div>
																				<div class="fw-bold mt-1"><?php echo date("m/d/Y", strtotime($get_advisor_last_employment->start_date)); ?></div>
																			</div>
																			<div class="col-md-6">
																				<?php if ($get_advisor_last_employment->end_date) { ?>
																					<div class="text-gray-600">End Date </div>
																					<div class="fw-bold mt-1"><?php echo date("m/d/Y", strtotime($get_advisor_last_employment->end_date)); ?></div>
																				<?php } ?>
																			</div>
																		</div>

																		<div class="row mt-4">
																			<div class="text-gray-600"> Company Address </div>
																			<div class="fw-bold mt-1"><?php echo $get_advisor_last_employment->company_address . ', ' . $get_advisor_last_employment->city . ', ' . $get_advisor_last_employment->state . ', ' . $get_advisor_last_employment->zipcode; ?></div>
																		</div>
																	</div>
																	<!--end::Card body-->
																</div>
															<?php } ?>
														</div>
														<div class="col-xl-6 col-md-6 col-sm-12">
															<div class="card mb-5 mb-xl-10" id="">
																<!--begin::Card header-->
																<div class="card-header p-5 pt-0 pb-0">
																	<!--begin::Card title-->
																	<div class="card-title">
																		<i class="ki-duotone ki-geolocation fs-2x">
																			<span class="path1"></span>
																			<span class="path2"></span>
																		</i>
																		<h3 class="fw-bold p-2 pt-0 pb-0">
																			Address
																		</h3>
																	</div>
																	<!--end::Card title-->
																	<!--begin::Action-->
																	<a href="" class=" align-self-center modal_address" data-bs-toggle="modal" data-bs-target="#kt_modal_address" id="add_address" address_id=""><i class="bi bi-plus-circle text-primary fs-2x"></i>
																	</a>
																	<!--end::Action-->
																</div>
																<!--end::Card header-->
																<!--begin::Card body-->
																<?php
																if ($get_advisor_default_address && isset($get_advisor_default_address['resident'])) { ?>
																	<div class="card-body p-5">
																		<div class="row">
																			<div class="col-md-10">
																				<h4 class="text-gray-800 fw-bold"><?php echo $get_advisor_default_address['resident']->address_label; ?></h4>
																			</div>
																			<div class="col-md-2">
																				<a href="" class="badge badge-light-primary fw-bold me-auto px-4 py-3 modal_address" data-bs-toggle="modal" data-bs-target="#kt_modal_address" address_id="<?php echo $get_advisor_default_address['resident']->id; ?>">Edit </a>
																			</div>
																		</div>
																		<div class="">
																			<div class="mb-8 mt-4">
																				<?php if ($get_advisor_default_address['resident']->banner) { ?>
																					<img src="<?php echo site_url(); ?>/uploads/address/<?php echo $get_advisor_default_address['resident']->banner; ?>" class="rounded mw-100" alt="">
																				<?php } else { ?>
																					<img src="<?php echo site_url(); ?>/assets/media/stock/900x600/44.jpg" class="rounded mw-100" alt="">
																				<?php } ?>
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
																						<a href="#" class="link-primary"><?php echo $get_advisor_default_address['resident']->street_address . '  ' . $get_advisor_default_address['resident']->building_name . ', ' . $get_advisor_default_address['resident']->city . ', ' . $get_advisor_default_address['resident']->state . ', ' . $get_advisor_default_address['resident']->zipcode; ?></a>
																						<!--end::Link-->
																					</div>
																					<!--end::Section-->
																				</div>
																				<!--end::Info-->
																			</div>
																			<!--end::Item-->
																		</div>
																	</div>
																<?php } ?>
																<?php
																if ($get_advisor_default_address && isset($get_advisor_default_address['business'])) { ?>
																	<div class="separator separator-dashed "></div>
																	<div class="card-body p-5">
																		<div class="row">
																			<div class="col-md-10">
																				<h4 class="text-gray-800 fw-bold"><?php echo $get_advisor_default_address['business']->address_label; ?></h4>
																			</div>
																			<div class="col-md-2">
																				<a href="" class="badge badge-light-primary fw-bold me-auto px-4 py-3 modal_address" data-bs-toggle="modal" data-bs-target="#kt_modal_address" address_id="<?php echo $get_advisor_default_address['business']->id; ?>">Edit </a>
																			</div>
																		</div>
																		<div class="">
																			<div class="mb-8 mt-4">
																				<?php if ($get_advisor_default_address['business']->banner) { ?>
																					<img src="<?php echo site_url(); ?>/uploads/address/<?php echo $get_advisor_default_address['business']->banner; ?>" class="rounded mw-100" alt="">
																				<?php } else { ?>
																					<img src="<?php echo site_url(); ?>/assets/media/stock/900x600/44.jpg" class="rounded mw-100" alt="">
																				<?php } ?>
																			</div>
																			<!--begin::Item-->
																			<div class="d-flex align-items-center ">
																				<!--begin::Icon-->
																				<i class="ki-outline ki-geolocation fs-1 text-primary me-5"></i>
																				<!--end::Icon-->
																				<!--begin::Info-->
																				<div class="d-flex flex-column">

																					<h5 class="text-gray-800 fw-bold">Business Address
																					</h5>

																					<!--begin::Section-->
																					<div class="fw-semibold">
																						<!--begin::Link-->
																						<a href="#" class="link-primary"><?php echo $get_advisor_default_address['business']->street_address . '  ' . $get_advisor_default_address['business']->building_name . ', ' . $get_advisor_default_address['business']->city . ', ' . $get_advisor_default_address['business']->state . ', ' . $get_advisor_default_address['business']->zipcode; ?></a>
																						<!--end::Link-->
																					</div>
																					<!--end::Section-->
																				</div>
																				<!--end::Info-->
																			</div>
																			<!--end::Item-->
																		</div>
																	</div>
																<?php } ?>
																<!--end::Card body-->
															</div>
															<div class="card mb-5 mb-xl-10" id="">
																<!--begin::Card header-->
																<div class="card-header p-5 pt-0 pb-0">
																	<!--begin::Card title-->
																	<div class="card-title">
																		<i class="ki-duotone ki-user-tick fs-2x">
																			<span class="path1"></span>
																			<span class="path2"></span>
																			<span class="path3"></span>
																		</i>
																		<h3 class="fw-bold p-2 pt-0 pb-0">
																			Tag
																		</h3>
																	</div>
																	<!--end::Card title-->
																</div>
																<!--begin::Card body-->
																<div class="card-body p-5">
																	<div class="mb-10 personal_interest_tag_section">
																		<?php  ?>
																		<label class="form-label">Personal Interests</label>

																		<input class="form-control" value="<?php echo $personal_interest; ?>" id="personal_interest" />

																	</div>
																	<div class="mb-10 financial_interest_tag_section">
																		<label class="form-label">Financial Interests</label>

																		<input class="form-control" value="<?php echo $financial_interest; ?>" id="financial_interest" />
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
												<div class="col-xl-4 col-md-4 col-sm-12">
													<div class="card mb-5 mb-xl-10" id="">
														<!--begin::Card header-->
														<div class="card-header p-5 pt-0 pb-0">
															<!--begin::Card title-->
															<div class="card-title">
																<i class="ki-duotone ki-arrow-zigzag fs-2x">
																	<span class="path1"></span>
																	<span class="path2"></span>
																	<span class="path3"></span>
																</i>
																<h3 class="fw-bold p-2 pt-0 pb-0">
																	Activity
																</h3>
															</div>
															<!--end::Card title-->
															<!--begin::Action-->
															<a href="" class=" align-self-center" data-bs-toggle="modal" data-bs-target="#kt_modal_activity_add" id="activity_add" advisor_id="<?php echo $selected_advisor_data->id; ?>"><i class="bi bi-plus-circle text-primary fs-2x"></i>
															</a>
															<!--end::Action-->
														</div>
														<!--begin::Card body-->
														<div class="card-body p-5">
															<!--begin::Content-->
															<div class="flex-lg-row-fluid">
																<!--begin:::Tabs-->
																<ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x fs-4 fw-semibold mb-8">
																	<!--begin:::Tab item-->
																	<li class="nav-item">
																		<a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_ecommerce_customer_overview">Upcoming</a>
																	</li>
																	<!--end:::Tab item-->
																	<!--begin:::Tab item-->
																	<li class="nav-item">
																		<a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_ecommerce_customer_general">Past</a>
																	</li>
																	<!--end:::Tab item-->

																</ul>
																<!--end:::Tabs-->
																<!--begin:::Tab content-->
																<div class="tab-content" id="myTabContent">
																	<!--begin:::Tab pane-->
																	<div class="tab-pane fade show active" id="kt_ecommerce_customer_overview" role="tabpanel">
																		<?php foreach ($get_advisor_upcoming_activity_list as $activity_result) { ?>
																			<div class="">
																				<?php echo $activity_result->note; ?>
																			</div>
																			<div class="meta mt-2">
																				<span class="badge py-3 px-4 fs-7 badge-light-primary mb-1"><?php echo date("m/d/Y", strtotime($activity_result->activity_date)); ?></span>
																				<span class="badge py-3 px-4 fs-7 badge-light-primary mb-1"><?php echo $activity_result->start_time; ?></span>
																				<?php if ($activity_result->type) { ?>
																					<span class="badge py-3 px-4 fs-7 badge-light-primary mb-1"><?php echo Settings()->get_selected_activity_type_name($activity_result->type); ?></span>
																				<?php } ?>
																			</div>
																			<div class="separator separator-dashed mb-6 mt-5"></div>
																		<?php } ?>
																	</div>
																	<!--end:::Tab pane-->
																	<!--begin:::Tab pane-->
																	<div class="tab-pane fade" id="kt_ecommerce_customer_general" role="tabpanel">
																		<?php foreach ($get_advisor_past_activity_list as $activity_result) { ?>
																			<div class="">
																				<?php echo $activity_result->note; ?>
																			</div>
																			<div class="meta mt-2">
																				<span class="badge py-3 px-4 fs-7 badge-light-primary mb-1"><?php echo date("m/d/Y", strtotime($activity_result->activity_date)); ?></span>
																				<span class="badge py-3 px-4 fs-7 badge-light-primary mb-1"><?php echo $activity_result->start_time; ?></span>
																				<?php if ($activity_result->type) { ?>
																					<span class="badge py-3 px-4 fs-7 badge-light-primary mb-1"><?php echo Settings()->get_selected_activity_type_name($activity_result->type); ?></span>
																				<?php } ?>
																			</div>
																			<div class="separator separator-dashed mb-6 mt-5"></div>
																		<?php } ?>
																	</div>
																	<!--end:::Tab pane-->
																</div>
																<!--end:::Tab content-->
															</div>
															<!--end::Content-->
														</div>
													</div>
												</div>
											</div>
										</div>
										<!--begin:::Tab content-->
										<div class="tab-content" id="myTabContent">
											<!--begin:::Tab pane-->
											<div class="tab-pane fade active show" id="kt_user_view_overview_personal_info_tab" role="tabpanel">
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

	<!--begin::Modal - Edit Resident Address -->
	<div class="modal fade" id="kt_modal_address" tabindex="-1" aria-hidden="true">
		<!--begin::Modal dialog-->
		<div class="modal-dialog modal-dialog-centered mw-850px">
			<!--begin::Modal content-->
			<div class="modal-content modal-rounded">
				<!--begin::Modal header-->
				<div class="modal-header py-5 d-flex justify-content-between">
					<!--begin::Modal title-->
					<h2>Address Details</h2>
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
					<form class="" id="address_form" method="post" enctype="multipart/form-data">
						<input type="hidden" id="address_id" name="address_id" class="is_empty">
						<div class="w-100">
							<!--begin::Input group-->
							<div class="row mb-7">
								<div class="col-md-4 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">State</label>
									<!--end::Label-->
									<!--begin::Input-->
									<select name="type" id="type" data-control="select2" data-placeholder="Select a Type..." class="form-select form-select-solid is_empty" data-dropdown-parent="#kt_modal_address" required>
										<option value="">Select Type</option>
										<?php foreach (Settings()->get_address_type_list() as $key => $type_result) { ?>
											<option value="<?php echo $key; ?>"><?php echo $type_result; ?></option>
										<?php } ?>
									</select>
									<!--end::Input-->
								</div>
								<div class="col-md-8 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Custom Address Label
									</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="address_label" id="address_label" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Street Address" required />
									<!--end::Input-->
								</div>
							</div>
							<div class="row mb-7">

								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Street Address</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="street_address" id="street_address" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Street Address" required />
									<!--end::Input-->
								</div>

								<div class="col-md-6 fv-row">
									<!--begin::Label-->
									<label class=" fw-semibold fs-6 mb-2">Apartment, suite, unit, building, floor, etc.</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="building_name" id="building_name" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Apartment, suite, unit, building, floor, etc" />
									<!--end::Input-->
								</div>
							</div>
							<div class="row mb-7">
								<div class="col-md-4 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">City</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="city" id="address_city" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="City" required />
									<!--end::Input-->
								</div>

								<div class="col-md-4 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">State</label>
									<!--end::Label-->
									<!--begin::Input-->
									<select name="state" id="address_state" data-control="select2" data-placeholder="Select a State..." class="form-select form-select-solid is_empty" data-dropdown-parent="#kt_modal_address" required>
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
									<input type="text" name="zipcode" id="address_zipcode" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Zipcode" required />
									<!--end::Input-->
								</div>
							</div>
							<div class="row mb-7">
								<div class="col-md-4 fv-row">
									<!--begin::Input group-->
									<!--begin::Label-->
									<label class="d-block fw-semibold fs-6 mb-5">Banner Image</label>
									<!--end::Label-->
									<!--begin::Image placeholder-->
									<style>
										.image-input-placeholder {
											background-image: url('<?php echo site_url(); ?>/assets/media/svg/files/blank-image.svg');
										}

										[data-bs-theme="dark"] .image-input-placeholder {
											background-image: url('<?php echo site_url(); ?>/assets/media/svg/files/blank-image-dark.svg');
										}
									</style>
									<!--end::Image placeholder-->
									<!--begin::Image input-->
									<div class="image-input image-input-outline image-input-placeholder" data-kt-image-input="true">
										<div class="image-input-wrapper w-125px h-125px" id="banner_src" style="background-image: url(<?php echo site_url() . '/assets/media/svg/files/blank-image.svg'; ?>);"></div>
										<!--end::Preview existing avatar-->
										<!--begin::Label-->
										<label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Banner Image">
											<i class="ki-outline ki-pencil fs-7"></i>
											<!--begin::Inputs-->
											<input type="file" name="banner" accept=".png, .jpg, .jpeg" />
											<input type="hidden" name="banner_remove" />
											<!--end::Inputs-->
										</label>
										<!--end::Label-->
										<!--begin::Cancel-->
										<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel Banner">
											<i class="ki-outline ki-cross fs-2"></i>
										</span>
										<!--end::Cancel-->
										<!--begin::Remove-->
										<span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove Banner">
											<i class="ki-outline ki-cross fs-2"></i>
										</span>
										<!--end::Remove-->
									</div>
									<!--end::Image input-->
									<!--begin::Hint-->
									<div class="form-text">Allowed file types: png, jpg, jpeg.</div>
									<!--end::Hint-->
								</div>
							</div>
							<div class="d-flex justify-content-end align-items-center mt-12">
								<!--begin::Button-->
								<button type="submit" class="btn btn-primary" id="save_address" name="save_address">
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

	<!--begin::Modal - Edit Profile -->
	<div class="modal fade" id="kt_modal_activity_add" tabindex="-1" aria-hidden="true">
		<!--begin::Modal dialog-->
		<div class="modal-dialog modal-dialog-centered mw-850px">
			<!--begin::Modal content-->
			<div class="modal-content modal-rounded">
				<!--begin::Modal header-->
				<div class="modal-header py-5 d-flex justify-content-between">
					<!--begin::Modal title-->
					<h2>Activity Details</h2>
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
					<form class="" id="activity_form" method="post" enctype="multipart/form-data">
						<div class="w-100">
							<!--begin::Input group-->
							<div class="row mb-7">
								<div class="col-md-12 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Title</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="title" id="activity_title" class="form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Title" required />
									<!--end::Input-->
								</div>
							</div>
							<!--begin::Input group-->
							<div class="row mb-7">
								<div class="col-md-4 fv-row">
									<!--begin::Label-->
									<label class="required fw-semibold fs-6 mb-2">Date</label>
									<!--end::Label-->
									<!--begin::Input-->
									<input type="text" name="date" id="activity_date" class="flatpickr form-control form-control-solid mb-3 mb-lg-0 is_empty" placeholder="Date" required />
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
									<select name="type" id="activity_type" data-control="select2" data-placeholder="Select a Type..." class="form-select form-select-solid" required>
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
							<div class="d-flex justify-content-end align-items-center mt-12">

								<!--begin::Button-->
								<button type="submit" class="btn btn-primary" id="save_activity" name="save_activity">
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
	<!--begin::Vendors Javascript(used for this page only)-->
	<script src="<?php echo site_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<!--end::Vendors Javascript-->
	<!--end::Javascript-->
	<script>
		var personal_interest_input = document.querySelector("#personal_interest");
		var financial_interest_input = document.querySelector("#financial_interest");

		var personal_interest_tagify = new Tagify(personal_interest_input);
		var financial_interest_tagify = new Tagify(financial_interest_input);

		personal_interest_tagify.on('add', function(event) {
			update_personal_interest_tag();
		});

		financial_interest_tagify.on('add', function(event) {
			update_financial_interest_tag();
		});

		$(document).on('click', '.personal_interest_tag_section .tagify__tag', function() {
			update_personal_interest_tag();
		});

		$(document).on('click', '.financial_interest_tag_section .tagify__tag', function() {
			update_financial_interest_tag();
		});

		function update_personal_interest_tag() {

			var personal_interest_tag = personal_interest_tagify.value.map(tagData => tagData.value);

			$.post(ajax_url, {
				action: 'update_advisor_personal_interest',
				advisor_id: '<?php echo $selected_advisor_data->id ?>',
				personal_interest: personal_interest_tag,
				is_ajax: true,
			}, function(result) {

			});
		}

		function update_financial_interest_tag() {

			var financial_interest_tag = financial_interest_tagify.value.map(tagData => tagData.value);

			$.post(ajax_url, {
				action: 'update_advisor_financial_interest',
				advisor_id: '<?php echo $selected_advisor_data->id ?>',
				financial_interest: financial_interest_tag,
				is_ajax: true,
			}, function(result) {

			});
		}

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

		$(document).on("click", ".modal_address", function() {

			var address_id = $(this).attr('address_id');
			console.log(address_id);
			$(".is_empty").val("");

			$("select.is_empty").val(null).trigger("change");

			$("textarea.is_empty").html("");

			if (!address_id)
				return false;

			$.post(ajax_url, {
				action: 'get_selected_address_data',
				address_id: address_id,
				is_ajax: true,
			}, function(result) {

				var results = JSON.parse(result);

				if (results) {

					$("#address_id").val(results.address_info.id);
					$("#type").val(results.address_info.type).trigger("change");
					$("#address_label").val(results.address_info.address_label);
					$("#street_address").val(results.address_info.street_address);
					$("#building_name").val(results.address_info.building_name);
					$("#address_city").val(results.address_info.city);
					$("#address_state").val(results.address_info.state).trigger("change");
					$("#address_zipcode").val(results.address_info.zipcode);

				}

			});
		});
	</script>
</body>
<!--end::Body-->

</html>