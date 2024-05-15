<?php require '../config.php';
$page_name = 'login';

// Checked User Already Login Or Not
if (isset($_SESSION) && isset($_SESSION['is_fbs_arm_advisor_login']) && isset($_SESSION['fbs_advisor_id'])) {

    wp_redirect(site_url() . '/advisor/dashboard');
    exit;
}

if (!siget('key')) {
    wp_redirect(site_url() . '/advisor');
    die();
}

$check_user = $wpdb->get_row("SELECT id FROM advisor WHERE reset_password_key = '" . siget('key') . "' AND status = 0 ");


if (!$check_user) {
    wp_redirect(site_url() . '/advisor');
    die();
}

if (isset($_POST['update_password'])) {

    if (!sipost('password') || !sipost('confirm-password')) {
        $_SESSION['invalid_password'] = true;
        wp_redirect(site_url() . '/advisor/reset-password/' . siget('key'));
        die();
    }

    if (sipost('password') != sipost('confirm-password')) {
        $_SESSION['invalid_password'] = true;
        wp_redirect(site_url() . '/advisor/reset-password/' . siget('key'));
        die();
    }

    $response = Advisor()->update_password(siget('key'));

    if ($response) {
        $_SESSION['reset_password_success'] = true;
        wp_redirect(site_url() . '/advisor');
        die();
    } else {
        $_SESSION['invalid_password'] = true;
        wp_redirect(site_url() . '/advisor/reset-password/' . siget('key'));
        die();
    }
} ?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <title><?php echo SITE_TITLE; ?></title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="<?php echo site_url(); ?>/assets/images/favicon.png" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="<?php echo site_url(); ?>/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo site_url(); ?>/assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
    <style>
        body.login {
            background-image: url('<?php echo site_url(); ?>/assets/images/arm_login.jpg') !important;
        }
    </style>
    <?php do_action('after_header_scripts', $page_name); ?>
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat login">
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
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url('<?php echo site_url() ?>/assets/media/auth/bg4.jpg');
            }

            [data-bs-theme="dark"] body {
                background-image: url('<?php echo site_url() ?>/assets/media/auth/bg4-dark.jpg');
            }
        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Signup Welcome Message -->
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center text-center p-10">
                <!--begin::Wrapper-->
                <div class="card card-flush w-md-500px py-5">
                    <div class="card-body  py-5 py-lg-5">
                        <?php if (isset($_SESSION['invalid_password'])) {
                            unset($_SESSION['invalid_password']) ?>
                            <div class="alert alert-danger d-flex align-items-center p-5">
                                <i class="ki-duotone ki-shield-tick fs-2hx text-danger  me-4"><span class="path1"></span><span class="path2"></span></i>
                                <div class="d-flex flex-column">
                                    <h4 class="mb-1 text-danger">The passwords don't match. </h4>
                                </div>
                            </div>
                        <?php } ?>
                        <!--begin::Logo-->
                        <div class="mb-7">
                            <a href="" class="">
                                <img alt="Logo" src="<?php echo site_url() ?>/assets/images/logo_blue.png" />
                            </a>
                        </div>
                        <!--end::Logo-->
                        <form class="form w-100" novalidate="novalidate" id="kt_new_password_form" method="post">
                            <!--begin::Heading-->
                            <div class="text-center mb-10">
                                <!--begin::Title-->
                                <h1 class="text-gray-900 fw-bolder mb-3">Setup New Password</h1>
                                <!--end::Title-->
                                <!--begin::Link-->
                                <div class="text-gray-500 fw-semibold fs-6">Have you already reset the password ?
                                    <a href="<?php echo site_url(); ?>/admin" class="link-primary fw-bold">Sign in</a>
                                </div>
                                <!--end::Link-->
                            </div>
                            <!--begin::Heading-->
                            <!--begin::Input group-->
                            <div class="fv-row mb-4" data-kt-password-meter="true">
                                <!--begin::Wrapper-->
                                <div class="mb-1">
                                    <!--begin::Input wrapper-->
                                    <div class="position-relative mb-3">
                                        <input class="form-control bg-transparent" type="password" placeholder="Password" name="password" id="password" autocomplete="off" />
                                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                            <i class="ki-outline ki-eye-slash fs-2"></i>
                                            <i class="ki-outline ki-eye fs-2 d-none"></i>
                                        </span>
                                    </div>
                                    <!--end::Input wrapper-->
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Input group=-->
                            <!--end::Input group=-->
                            <div class="fv-row mb-4">
                                <!--begin::Repeat Password-->
                                <input type="password" placeholder="Repeat Password" name="confirm-password" id="confirm-password" autocomplete="off" class="form-control bg-transparent" />
                                <!--end::Repeat Password-->
                            </div>
                            <!--end::Input group=-->
                            <div id="passwordMatchMessage" class="mb-2"></div>

                            <!--begin::Action-->
                            <div class="d-grid mb-10">
                                <button type="submit" name="update_password" id="update_password" class="btn btn-primary">
                                    <!--begin::Indicator label-->
                                    <span class="indicator-label">Submit</span>
                                    <!--end::Indicator label-->
                                    <!--begin::Indicator progress-->
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                                    <!--end::Indicator progress-->
                                </button>
                            </div>
                            <!--end::Action-->
                        </form>
                    </div>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Signup Welcome Message-->

        <!--begin::Authentication - Sign-in -->
        <!--end::Authentication - Sign-in-->
    </div>
    <!--end::Root-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = '<?php echo site_url() ?>/assets/';
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="<?php echo site_url(); ?>/assets/plugins/global/plugins.bundle.js"></script>
    <script src="<?php echo site_url(); ?>/assets/js/scripts.bundle.js"></script>

    <!--end::Global Javascript Bundle-->
    <script>
        $(document).ready(function() {
            $('#confirm-password').on('keyup', function() {
                if ($('#password').val() == $('#confirm-password').val()) {
                    $('#passwordMatchMessage').html('The Passwords match').css('color', 'green');
                } else
                    $('#passwordMatchMessage').html('The passwords don\'t match.').css('color', 'red');
            });
        });
    </script>
</body>
<!--end::Body-->

</html>