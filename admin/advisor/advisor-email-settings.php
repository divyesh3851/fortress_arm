<?php require '../../config.php';
$page_name = 'advisor';
$sub_page_name = 'advisor-list';
Admin()->check_login();

$selected_advisor_data = Advisor()->get_selected_advisor_data(siget('advisor_id'));

if (!$selected_advisor_data) {
	wp_redirect(site_url() . '/admin/advisor/advisor-list');
	die();
}

if (isset($_POST['save_setting'])) {

	Advisor()->update_advisor_meta($selected_advisor_data->id, 'iul_step_1_email_enable', sipost('iul_step_1_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'iul_step_2_email_enable', sipost('iul_step_2_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'iul_step_3_email_enable', sipost('iul_step_3_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'iul_step_4_email_enable', sipost('iul_step_4_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'iul_step_5_email_enable', sipost('iul_step_5_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'iul_step_6_email_enable', sipost('iul_step_6_email_enable'));

	Advisor()->update_advisor_meta($selected_advisor_data->id, 'term_step_1_email_enable', sipost('term_step_1_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'term_step_2_email_enable', sipost('term_step_2_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'term_step_3_email_enable', sipost('term_step_3_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'term_step_4_email_enable', sipost('term_step_4_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'term_step_5_email_enable', sipost('term_step_5_email_enable'));

	Advisor()->update_advisor_meta($selected_advisor_data->id, 'wl_step_1_email_enable', sipost('wl_step_1_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'wl_step_2_email_enable', sipost('wl_step_2_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'wl_step_3_email_enable', sipost('wl_step_3_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'wl_step_4_email_enable', sipost('wl_step_4_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'wl_step_5_email_enable', sipost('wl_step_5_email_enable'));

	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ap_step_1_email_enable', sipost('ap_step_1_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ap_step_2_email_enable', sipost('ap_step_2_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ap_step_3_email_enable', sipost('ap_step_3_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ap_step_4_email_enable', sipost('ap_step_4_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ap_step_5_email_enable', sipost('ap_step_5_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ap_step_6_email_enable', sipost('ap_step_6_email_enable'));

	Advisor()->update_advisor_meta($selected_advisor_data->id, 'fia_step_1_email_enable', sipost('fia_step_1_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'fia_step_2_email_enable', sipost('fia_step_2_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'fia_step_3_email_enable', sipost('fia_step_3_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'fia_step_4_email_enable', sipost('fia_step_4_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'fia_step_5_email_enable', sipost('fia_step_5_email_enable'));

	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ltc_step_1_email_enable', sipost('ltc_step_1_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ltc_step_2_email_enable', sipost('ltc_step_2_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ltc_step_3_email_enable', sipost('ltc_step_3_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ltc_step_4_email_enable', sipost('ltc_step_4_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ltc_step_5_email_enable', sipost('ltc_step_5_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ltc_step_6_email_enable', sipost('ltc_step_6_email_enable'));

	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ls_step_1_email_enable', sipost('ls_step_1_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ls_step_2_email_enable', sipost('ls_step_2_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ls_step_3_email_enable', sipost('ls_step_3_email_enable'));
	Advisor()->update_advisor_meta($selected_advisor_data->id, 'ls_step_4_email_enable', sipost('ls_step_4_email_enable'));

	$_SESSION['process_success'] = true;

	wp_redirect(site_url() . '/admin/advisor/advisor-email-settings/' . $selected_advisor_data->id);
	exit;
}

//$get_advisor_interest = $wpdb->get_row("SELECT * FROM interest1 WHERE advisor_id = " . $selected_advisor_data->id);

$iul_current_mail_reminder_step = Advisor()->get_advisor_meta($selected_advisor_data->id, 'iul_current_mail_reminder_step');

$term_current_mail_reminder_step = Advisor()->get_advisor_meta($selected_advisor_data->id, 'term_current_mail_reminder_step');

$wl_current_mail_reminder_step = Advisor()->get_advisor_meta($selected_advisor_data->id, 'wl_current_mail_reminder_step');

$ap_current_mail_reminder_step = Advisor()->get_advisor_meta($selected_advisor_data->id, 'ap_current_mail_reminder_step');

$fia_current_mail_reminder_step = Advisor()->get_advisor_meta($selected_advisor_data->id, 'fia_current_mail_reminder_step');

$ltc_current_mail_reminder_step = Advisor()->get_advisor_meta($selected_advisor_data->id, 'ltc_current_mail_reminder_step');

$ls_current_mail_reminder_step = Advisor()->get_advisor_meta($selected_advisor_data->id, 'ls_current_mail_reminder_step');
?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
	<?php require SITE_DIR . '/head.php'; ?>
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

						<!--begin::Toolbar-->
						<div id="kt_app_toolbar" class="app-toolbar pt-6 pb-2">
							<!--begin::Toolbar container-->
							<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex align-items-stretch">
								<!--begin::Toolbar wrapper-->
								<div class="app-toolbar-wrapper d-flex flex-stack flex-wrap gap-4 w-100">
									<!--begin::Page title-->
									<div class="page-title d-flex flex-column justify-content-center gap-1 me-3">
										<!--begin::Title-->
										<h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0"> Email Automation Notification Settings </h1>
										<!--end::Title-->
									</div>
									<!--end::Page title-->
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
								<?php
								if (isset($_SESSION['process_success'])) {
									unset($_SESSION['process_success']); ?>
									<div class="alert alert-success d-flex align-items-center">
										<i class="ki-duotone ki-shield-tick fs-2hx text-success  me-4"><span class="path1"></span><span class="path2"></span></i>
										<div class="d-flex flex-column">
											<h4 class="mb-1 text-success">The settings has been save successfully.</h4>
										</div>
									</div>
								<?php } ?>

								<form method="post">
									<!--begin::Layout-->
									<!--end::Notifications-->
									<div class="row">
										<div class="col-md-3">
											<div class="card mb-5 mb-xl-10">
												<!--begin::Card body-->
												<div class="card-body px-9 pt-1 pb-0">
													<!--begin::Table-->
													<div class="">
														<table class="table border-gray-300 align-middle gy-3">
															<tbody class="fs-6 fw-semibold">
																<!--begin::Table row-->
																<tr>
																	<td class="min-w-250px fs-4 fw-bold">Indexed Universal Life </td>
																	<td class="w-125px">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" value="" id="iul_notification_email" data-kt-check="true" data-kt-check-target="[data-kt-iul-notification=email]" checked="checked" />
																			<label class="form-check-label ps-2" for="iul_notification_email"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 1 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="iul_step_1_email_enable" id="iul_step_1_email_enable" value="1" data-kt-iul-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'iul_step_1_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="iul_step_1_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 2 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="iul_step_2_email_enable" id="iul_step_2_email_enable" value="1" data-kt-iul-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'iul_step_2_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="iul_step_2_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 3 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="iul_step_3_email_enable" id="iul_step_3_email_enable" value="1" data-kt-iul-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'iul_step_3_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="iul_step_3_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 4 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="iul_step_4_email_enable" id="iul_step_4_email_enable" value="1" data-kt-iul-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'iul_step_4_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="iul_step_4_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 5 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="iul_step_5_email_enable" id="iul_step_5_email_enable" value="1" data-kt-iul-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'iul_step_5_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="iul_step_5_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 6 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="iul_step_6_email_enable" id="iul_step_6_email_enable" value="1" data-kt-iul-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'iul_step_6_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="iul_step_6_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
															</tbody>
														</table>
														<div class="text-center pb-3">
															<?php if ($iul_current_mail_reminder_step) { ?>
																<span class="badge badge-light-danger fw-bold me-auto px-4 py-3">Current Step : <?php echo $iul_current_mail_reminder_step; ?></span>
															<?php } ?>
														</div>
													</div>
													<!--end::Table-->
												</div>
												<!--end::Card body-->
											</div>
										</div>
										<div class="col-md-3">
											<div class="card mb-5 mb-xl-10">
												<!--begin::Card body-->
												<div class="card-body px-9 pt-1 pb-0">
													<!--begin::Table-->
													<div class="">
														<table class="table border-gray-300 align-middle gy-3">
															<tbody class="fs-6 fw-semibold">
																<!--begin::Table row-->
																<tr>
																	<td class="min-w-250px fs-4 fw-bold">Term </td>
																	<td class="w-125px">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" value="" id="term_notification_email" data-kt-check="true" data-kt-check-target="[data-kt-term-notification=email]" checked="checked" />
																			<label class="form-check-label ps-2" for="term_notification_email"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 1 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="term_step_1_email_enable" id="term_step_1_email_enable" value="1" data-kt-term-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'term_step_1_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="term_step_1_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 2 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="term_step_2_email_enable" id="term_step_2_email_enable" value="1" data-kt-term-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'term_step_2_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="term_step_2_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 3 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="term_step_3_email_enable" id="term_step_3_email_enable" value="1" data-kt-term-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'term_step_3_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="term_step_3_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 4 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="term_step_4_email_enable" id="term_step_4_email_enable" value="1" data-kt-term-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'term_step_4_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="term_step_4_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 5 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="term_step_5_email_enable" id="term_step_5_email_enable" value="1" data-kt-term-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'term_step_5_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="term_step_5_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
															</tbody>
														</table>
														<div class="text-center pb-3">
															<?php if ($term_current_mail_reminder_step) { ?>
																<span class="badge badge-light-danger fw-bold me-auto px-4 py-3">Current Step : <?php echo $term_current_mail_reminder_step; ?></span>
															<?php } ?>
														</div>
													</div>
													<!--end::Table-->
												</div>
												<!--end::Card body-->
											</div>
										</div>
										<div class="col-md-3">
											<div class="card mb-5 mb-xl-10">
												<!--begin::Card body-->
												<div class="card-body px-9 pt-1 pb-0">
													<!--begin::Table-->
													<div class="">
														<table class="table border-gray-300 align-middle gy-3">
															<tbody class="fs-6 fw-semibold">
																<!--begin::Table row-->
																<tr>
																	<td class="min-w-250px fs-4 fw-bold"> Whole Life </td>
																	<td class="w-125px">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" value="" id="wl_notification_email" data-kt-check="true" data-kt-check-target="[data-kt-wl-notification=email]" checked="checked" />
																			<label class="form-check-label ps-2" for="wl_notification_email"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 1 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="wl_step_1_email_enable" id="wl_step_1_email_enable" value="1" data-kt-wl-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'wl_step_1_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="wl_step_1_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 2 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="wl_step_2_email_enable" id="wl_step_2_email_enable" value="1" data-kt-wl-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'wl_step_2_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="wl_step_2_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 3 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="wl_step_3_email_enable" id="wl_step_3_email_enable" value="1" data-kt-wl-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'wl_step_3_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="wl_step_3_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 4 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="wl_step_4_email_enable" id="wl_step_4_email_enable" value="1" data-kt-wl-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'wl_step_4_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="wl_step_4_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 5 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="wl_step_5_email_enable" id="wl_step_5_email_enable" value="1" data-kt-wl-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'wl_step_5_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="wl_step_5_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
															</tbody>
														</table>
														<div class="text-center pb-3">
															<?php if ($wl_current_mail_reminder_step) { ?>
																<span class="badge badge-light-danger fw-bold me-auto px-4 py-3">Current Step : <?php echo $wl_current_mail_reminder_step; ?></span>
															<?php } ?>
														</div>
													</div>
													<!--end::Table-->
												</div>
												<!--end::Card body-->
											</div>
										</div>
										<div class="col-md-3">
											<div class="card mb-5 mb-xl-10">
												<!--begin::Card body-->
												<div class="card-body px-9 pt-1 pb-0">
													<!--begin::Table-->
													<div class="">
														<table class="table border-gray-300 align-middle gy-3">
															<tbody class="fs-6 fw-semibold">
																<!--begin::Table row-->
																<tr>
																	<td class="min-w-250px fs-4 fw-bold"> Advanced Planning </td>
																	<td class="w-125px">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" value="" id="ap_notification_email" data-kt-check="true" data-kt-check-target="[data-kt-ap-notification=email]" checked="checked" />
																			<label class="form-check-label ps-2" for="ap_notification_email"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 1 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ap_step_1_email_enable" id="ap_step_1_email_enable" value="1" data-kt-ap-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ap_step_1_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ap_step_1_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 2 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ap_step_2_email_enable" id="ap_step_2_email_enable" value="1" data-kt-ap-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ap_step_2_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ap_step_2_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 3 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ap_step_3_email_enable" id="ap_step_3_email_enable" value="1" data-kt-ap-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ap_step_3_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ap_step_3_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 4 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ap_step_4_email_enable" id="ap_step_4_email_enable" value="1" data-kt-ap-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ap_step_4_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ap_step_4_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 5 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ap_step_5_email_enable" id="ap_step_5_email_enable" value="1" data-kt-ap-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ap_step_5_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ap_step_5_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 6 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ap_step_6_email_enable" id="ap_step_6_email_enable" value="1" data-kt-ap-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ap_step_6_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ap_step_6_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
															</tbody>
														</table>
														<div class="text-center pb-3">
															<?php if ($ap_current_mail_reminder_step) { ?>
																<span class="badge badge-light-danger fw-bold me-auto px-4 py-3">Current Step : <?php echo $ap_current_mail_reminder_step; ?></span>
															<?php } ?>
														</div>
													</div>
													<!--end::Table-->
												</div>
												<!--end::Card body-->
											</div>
										</div>
									</div>

									<div class="row mt-10">
										<div class="col-md-3">
											<div class="card mb-5 mb-xl-10">
												<!--begin::Card body-->
												<div class="card-body px-9 pt-1 pb-0">
													<!--begin::Table-->
													<div class="">
														<table class="table border-gray-300 align-middle gy-3">
															<tbody class="fs-6 fw-semibold">
																<!--begin::Table row-->
																<tr>
																	<td class="min-w-250px fs-4 fw-bold"> Fixed Indexed Annuities </td>
																	<td class="w-125px">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" value="" id="fia_notification_email" data-kt-check="true" data-kt-check-target="[data-kt-fia-notification=email]" checked="checked" />
																			<label class="form-check-label ps-2" for="fia_notification_email"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 1 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="fia_step_1_email_enable" id="fia_step_1_email_enable" value="1" data-kt-fia-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'fia_step_1_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="fia_step_1_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 2 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="fia_step_2_email_enable" id="fia_step_2_email_enable" value="1" data-kt-fia-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'fia_step_2_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="fia_step_2_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 3 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="fia_step_3_email_enable" id="fia_step_3_email_enable" value="1" data-kt-fia-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'fia_step_3_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="fia_step_3_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 4 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="fia_step_4_email_enable" id="fia_step_4_email_enable" value="1" data-kt-fia-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'fia_step_4_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="fia_step_4_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 5 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="fia_step_5_email_enable" id="fia_step_5_email_enable" value="1" data-kt-fia-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'fia_step_5_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="fia_step_5_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
															</tbody>
														</table>
														<div class="text-center pb-3">
															<?php if ($fia_current_mail_reminder_step) { ?>
																<span class="badge badge-light-danger fw-bold me-auto px-4 py-3">Current Step : <?php echo $fia_current_mail_reminder_step; ?></span>
															<?php } ?>
														</div>
													</div>
													<!--end::Table-->
												</div>
												<!--end::Card body-->
											</div>
										</div>
										<div class="col-md-3">
											<div class="card mb-5 mb-xl-10">
												<!--begin::Card body-->
												<div class="card-body px-9 pt-1 pb-0">
													<!--begin::Table-->
													<div class="">
														<table class="table border-gray-300 align-middle gy-3">
															<tbody class="fs-6 fw-semibold">
																<!--begin::Table row-->
																<tr>
																	<td class="min-w-250px fs-4 fw-bold"> Long-Term Care Insurance </td>
																	<td class="w-125px">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" value="" id="ltc_notification_email" data-kt-check="true" data-kt-check-target="[data-kt-ltc-notification=email]" checked="checked" />
																			<label class="form-check-label ps-2" for="ltc_notification_email"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 1 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ltc_step_1_email_enable" id="ltc_step_1_email_enable" value="1" data-kt-ltc-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ltc_step_1_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ltc_step_1_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 2 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ltc_step_2_email_enable" id="ltc_step_2_email_enable" value="1" data-kt-ltc-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ltc_step_2_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ltc_step_2_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 3 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ltc_step_3_email_enable" id="ltc_step_3_email_enable" value="1" data-kt-ltc-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ltc_step_3_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ltc_step_3_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 4 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ltc_step_4_email_enable" id="ltc_step_4_email_enable" value="1" data-kt-ltc-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ltc_step_4_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ltc_step_4_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 5 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ltc_step_5_email_enable" id="ltc_step_5_email_enable" value="1" data-kt-ltc-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ltc_step_5_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ltc_step_5_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 6 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ltc_step_6_email_enable" id="ltc_step_6_email_enable" value="1" data-kt-ltc-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ltc_step_6_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ltc_step_6_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
															</tbody>
														</table>
														<div class="text-center pb-3">
															<?php if ($ltc_current_mail_reminder_step) { ?>
																<span class="badge badge-light-danger fw-bold me-auto px-4 py-3">Current Step : <?php echo $ltc_current_mail_reminder_step; ?></span>
															<?php } ?>
														</div>
													</div>
													<!--end::Table-->
												</div>
												<!--end::Card body-->
											</div>
										</div>

										<div class="col-md-3">
											<div class="card mb-5 mb-xl-10">
												<!--begin::Card body-->
												<div class="card-body px-9 pt-1 pb-0">
													<!--begin::Table-->
													<div class="">
														<table class="table border-gray-300 align-middle gy-3">
															<tbody class="fs-6 fw-semibold">
																<!--begin::Table row-->
																<tr>
																	<td class="min-w-250px fs-4 fw-bold"> Life Settlements </td>
																	<td class="w-125px">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" value="" id="ls_notification_email" data-kt-check="true" data-kt-check-target="[data-kt-ls-notification=email]" checked="checked" />
																			<label class="form-check-label ps-2" for="ls_notification_email"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 1 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ls_step_1_email_enable" id="ls_step_1_email_enable" value="1" data-kt-ls-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ls_step_1_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ls_step_1_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 2 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ls_step_2_email_enable" id="ls_step_2_email_enable" value="1" data-kt-ls-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ls_step_2_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ls_step_2_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td>Step 3 Email</td>
																	<td>
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ls_step_3_email_enable" id="ls_step_3_email_enable" value="1" data-kt-ls-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ls_step_3_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ls_step_3_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
																<!--begin::Table row-->
																<tr>
																	<td class="border-bottom-0">Step 4 Email</td>
																	<td class="border-bottom-0">
																		<div class="form-check form-check-custom form-check-solid">
																			<input class="form-check-input" type="checkbox" name="ls_step_4_email_enable" id="ls_step_4_email_enable" value="1" data-kt-ls-notification="email" <?php echo (Advisor()->get_advisor_meta($selected_advisor_data->id, 'ls_step_4_email_enable')) ? 'checked' : ''; ?> />
																			<label class="form-check-label ps-2" for="ls_step_4_email_enable"></label>
																		</div>
																	</td>
																</tr>
																<!--begin::Table row-->
															</tbody>
														</table>
														<div class="text-center pb-3">
															<?php if ($ls_current_mail_reminder_step) { ?>
																<span class="badge badge-light-danger fw-bold me-auto px-4 py-3">Current Step : <?php echo $ls_current_mail_reminder_step; ?></span>
															<?php } ?>
														</div>
													</div>
													<!--end::Table-->
												</div>
												<!--end::Card body-->
											</div>
										</div>

									</div>
									<!--end::Layout-->
									<div class="row mt-10">
										<div class="mb-0">
											<button type="submit" name="save_setting" class="btn btn-primary" id="">

												<!--begin::Indicator label-->
												<span class="indicator-label"> Save </span>
												<!--end::Indicator label-->

												<!--begin::Indicator progress-->
												<span class="indicator-progress">
													Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
												</span>
												<!--end::Indicator progress--> </button>
										</div>
									</div>
								</form>
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

	<!--begin::Javascript-->
	<script>
		var hostUrl = "assets/";
	</script>
	<!--begin::Global Javascript Bundle(mandatory for all pages)-->
	<?php require SITE_DIR . '/footer_script.php'; ?>
	<!--end::Global Javascript Bundle-->
	<!--begin::Vendors Javascript(used for this page only)-->
	<script src="<?php echo site_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.js"></script>
	<!--end::Vendors Javascript-->
	<!--end::Javascript-->
	<script>

	</script>
</body>
<!--end::Body-->

</html>