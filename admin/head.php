<title><?php echo SITE_TITLE; ?></title>
<meta charset="utf-8" />
<link rel="shortcut icon" href="<?php echo site_url(); ?>/assets/images/favicon.png" />
<!--begin::Fonts(mandatory for all pages)-->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
<!--end::Fonts-->
<!--begin::Vendor Stylesheets(used for this page only)-->
<link href="<?php echo site_url(); ?>/assets/plugins/custom/fullcalendar/fullcalendar.bundle.css" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url(); ?>/assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<!--end::Vendor Stylesheets-->
<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
<link href="<?php echo site_url(); ?>/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url(); ?>/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
<link href="<?php echo site_url(); ?>/assets/css/custom.css" rel="stylesheet" type="text/css" />
<!--end::Global Stylesheets Bundle-->
<?php do_action('after_header_scripts', $page_name); ?>