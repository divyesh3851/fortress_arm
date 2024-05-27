<?php require '../../config.php';
$page_name = 'settings';
$sub_page_name = 'mail-setting';
Admin()->check_login();

require SITE_DIR . '/vendor/autoload.php';

// page permition for admin user
if (Admin()->check_for_page_access("settings", true)) {
    wp_redirect(add_query_arg('access', 1, site_url('admin/dashboard')));
    die();
}

if (isset($_POST['export_submit'])) {

    $format = (sipost('format')) ? sipost('format') : '';

    if (!$format) {
        return false;
    }

    $start_date = '';
    $end_date   = '';

    if (sipost('date_range')) {

        $date_range = (sipost('date_range')) ? sipost('date_range') : '';

        list($start_date, $end_date) = explode(" - ", $date_range);

        $start_date = date("Y-m-d", strtotime($start_date));

        $end_date   = date("Y-m-d", strtotime($end_date));
    }


    if ($format == 'excel') {

        $spreadsheet    = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

        $sheet    = $spreadsheet->getActiveSheet();

        $styleArray = [
            'font' => [
                'bold' => true,
            ],
        ];

        $spreadsheet->getActiveSheet()->getStyle('A1:G1')->applyFromArray($styleArray);

        // Set the value of header cell 
        $column         = 1;

        //$highestRow = $sheet->getHighestRow();

        $highestRow     = 1;
        if (sipost('select_data') == 'advisor') {

            $get_advisor_list = Advisor()->get_advisor_records_between_two_dates($start_date, $end_date, sipost('advisor_status'));

            if (sipost('select_colum')) {
                $headings       =  array("No");
                foreach (sipost('select_colum') as $colum_result) {
                    $headings[] = $colum_result;
                }
            } else {
                $headings   =  array("No", "Name", "Email", "Mobile No", "City", "State", "Date");
            }
        } else if (sipost('select_data') == 'designation') {

            $get_designation_list = Settings()->get_designation_list();

            $headings = array("No", "Name");
        } else if (sipost('select_data') == 'lead_source') {

            $get_lead_source_list = Settings()->get_lead_source_list();

            $headings = array("No", "Type");
        } else if (sipost('select_data') == 'licenses_type') {

            $get_licenses_type_list = Settings()->get_lead_source_list();

            $headings = array("No", "Type");
        } else if (sipost('select_data') == 'affiliations') {

            $get_affiliations_list = Settings()->get_affiliations_list();

            $headings = array("No", "Type");
        } else if (sipost('select_data') == 'carrier_appointed') {

            $get_carrier_appointed_list = Settings()->get_carrier_appointed_list();

            $headings = array("No", "Type");
        } else if (sipost('select_data') == 'carriers') {

            $get_carrier_list = Settings()->get_carrier_list();

            $headings = array("No", "Name");
        } else if (sipost('select_data') == 'premium_volume') {

            $get_premium_volume_list = Settings()->get_premium_volume_list();

            $headings = array("No", "Type");
        } else if (sipost('select_data') == 'product_percentage') {

            $get_production_percentage_list = Settings()->get_production_percentage_list();

            $headings = array("No", "Type");
        } else if (sipost('select_data') == 'markets') {

            $get_market_list = Settings()->get_market_list();

            $headings = array("No", "Type");
        }

        foreach ($headings as $key  => $heading) {

            $highestColumn    = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
            $sheet->setCellValue($highestColumn . $highestRow, $heading);
            $column++;
        }


        $i = 1;

        if (sipost('select_data') == 'advisor') {

            foreach ($get_advisor_list as $advisor_result) {

                $created_at = date("m/d/Y", strtotime($advisor_result->created_at));

                if (sipost('select_colum')) {
                    $fields = array($i);
                    foreach (sipost('select_colum') as $colum_result) {
                        if ($colum_result == 'Name') {
                            $fields[]   = $advisor_result->first_name . ' ' . $advisor_result->last_name;
                        }
                        if ($colum_result == 'Email') {
                            $fields[]   = $advisor_result->email;
                        }
                        if ($colum_result == 'Mobile No') {
                            $fields[]   = $advisor_result->mobile_no;
                        }
                        if ($colum_result == 'City') {
                            $fields[]   = $advisor_result->city;
                        }
                        if ($colum_result == 'State') {
                            $fields[]   = $advisor_result->state;
                        }
                        if ($colum_result == 'Date') {
                            $fields[]   = $created_at;
                        }
                    }
                } else {
                    $fields = array($i, $advisor_result->first_name . ' ' . $advisor_result->last_name, $advisor_result->email, $advisor_result->mobile_no, $advisor_result->city, $advisor_result->state, $created_at);
                }

                $column         = 1;
                $highestRow     = $sheet->getHighestRow();
                $highestRow     = $highestRow + 1;

                foreach ($fields as $column_value) {

                    $highestColumn    = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValue($highestColumn . $highestRow, $column_value);
                    $column++;
                }

                $i++;

                //$fields     = array($i, $advisor_result->first_name . ' ' . $advisor_result->last_name, $advisor_result->email, $advisor_result->mobile_no, $advisor_result->city, $advisor_result->state, $created_at);
            }

            $filename    = "Advisor List - " . date('m-d-Y') . ".csv";
        } else if (sipost('select_data') == 'designation') {
            foreach ($get_designation_list as $result) {

                $fields     = array($i, $result->name);

                $column         = 1;
                $highestRow     = $sheet->getHighestRow();
                $highestRow     = $highestRow + 1;

                foreach ($fields as $column_value) {

                    $highestColumn    = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValue($highestColumn . $highestRow, $column_value);
                    $column++;
                }

                $i++;
            }

            $filename    = "Designation List - " . date('m-d-Y') . ".csv";
        } else if (sipost('select_data') == 'lead_source') {

            foreach ($get_lead_source_list as $result) {

                $fields     = array($i, $result->type);

                $column         = 1;
                $highestRow     = $sheet->getHighestRow();
                $highestRow     = $highestRow + 1;

                foreach ($fields as $column_value) {

                    $highestColumn    = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValue($highestColumn . $highestRow, $column_value);
                    $column++;
                }

                $i++;
            }

            $filename    = "Lead Source List - " . date('m-d-Y') . ".csv";
        } else if (sipost('select_data') == 'licenses_type') {

            foreach ($get_licenses_type_list as $result) {

                $fields     = array($i, $result->type);

                $column         = 1;
                $highestRow     = $sheet->getHighestRow();
                $highestRow     = $highestRow + 1;

                foreach ($fields as $column_value) {

                    $highestColumn    = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValue($highestColumn . $highestRow, $column_value);
                    $column++;
                }

                $i++;
            }

            $filename    = "Licenses Type List - " . date('m-d-Y') . ".csv";
        } else if (sipost('select_data') == 'affiliations') {

            foreach ($get_affiliations_list as $result) {

                $fields     = array($i, $result->type);

                $column         = 1;
                $highestRow     = $sheet->getHighestRow();
                $highestRow     = $highestRow + 1;

                foreach ($fields as $column_value) {

                    $highestColumn    = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValue($highestColumn . $highestRow, $column_value);
                    $column++;
                }

                $i++;
            }
            $filename    = "Affiliations List - " . date('m-d-Y') . ".csv";
        } else if (sipost('select_data') == 'carrier_appointed') {

            foreach ($get_carrier_appointed_list as $result) {

                $fields     = array($i, $result->type);

                $column         = 1;
                $highestRow     = $sheet->getHighestRow();
                $highestRow     = $highestRow + 1;

                foreach ($fields as $column_value) {

                    $highestColumn    = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValue($highestColumn . $highestRow, $column_value);
                    $column++;
                }

                $i++;
            }
            $filename    = "Carrier Appointed List - " . date('m-d-Y') . ".csv";
        } else if (sipost('select_data') == 'carriers') {

            foreach ($get_carrier_list as $result) {

                $fields     = array($i, $result->name);

                $column         = 1;
                $highestRow     = $sheet->getHighestRow();
                $highestRow     = $highestRow + 1;

                foreach ($fields as $column_value) {

                    $highestColumn    = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValue($highestColumn . $highestRow, $column_value);
                    $column++;
                }

                $i++;
            }
            $filename    = "Carrier List - " . date('m-d-Y') . ".csv";
        } else if (sipost('select_data') == 'premium_volume') {

            foreach ($get_premium_volume_list as $result) {

                $fields     = array($i, $result->type);

                $column         = 1;
                $highestRow     = $sheet->getHighestRow();
                $highestRow     = $highestRow + 1;

                foreach ($fields as $column_value) {

                    $highestColumn    = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValue($highestColumn . $highestRow, $column_value);
                    $column++;
                }

                $i++;
            }

            $filename    = "Premium Volume List - " . date('m-d-Y') . ".csv";
        } else if (sipost('select_data') == 'product_percentage') {


            foreach ($get_production_percentage_list as $result) {

                $fields     = array($i, $result->type);

                $column         = 1;
                $highestRow     = $sheet->getHighestRow();
                $highestRow     = $highestRow + 1;

                foreach ($fields as $column_value) {

                    $highestColumn    = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValue($highestColumn . $highestRow, $column_value);
                    $column++;
                }

                $i++;
            }

            $filename    = "Production Percentage List - " . date('Y_m_d') . ".csv";
        } else if (sipost('select_data') == 'markets') {

            foreach ($get_market_list as $result) {

                $fields     = array($i, $result->type);

                $column         = 1;
                $highestRow     = $sheet->getHighestRow();
                $highestRow     = $highestRow + 1;

                foreach ($fields as $column_value) {

                    $highestColumn    = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($column);
                    $sheet->setCellValue($highestColumn . $highestRow, $column_value);
                    $column++;
                }

                $i++;
            }

            $filename    = "Market List - " . date('Y_m_d') . ".csv";
        }

        // Output an .xlsx file  
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        header('Content-Encoding: UTF-8');
        header('Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet; charset=UTF-8');
        header('Content-Disposition: attachment; filename=' . $filename);
        $writer->save('php://output');
        die();
        exit;
    } else if ($format == 'pdf') {

        $mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4', 'margin_left' => '5', 'margin_right' => '5', 'margin_top' => '10', 'margin_bottom' => '10', 'margin_header' => '5', 'margin_footer' => '5', 'defaultheaderline' => 0, 'defaulfooterline' => 0]);
        $html = '<html> 
                    <body>
                    <div class="col-md-12">';
        if (sipost('select_data') == 'advisor') {

            $get_advisor_list = Advisor()->get_advisor_records_between_two_dates($start_date, $end_date, sipost('advisor_status'));

            $html .= '<p class="category" style="text-align:center; font-size: 18px;">
                                                <b>Advisor List</b>
                                            </p>	
                                            <table class="table" width="100%" border="1" cellpadding="4" style="border-collapse: collapse; text-align:left; font-size:13px;">
                                                <thead>
                                                    <tr>
                                                    <th>No.</th>';
            if (sipost('select_colum')) {
                foreach (sipost('select_colum') as $colum_result) {
                    $html .= '<th>' . $colum_result . '</th>';
                }
            } else {
                $html .= '<th>Name</th>';
                $html .= '<th>Email</th>';
                $html .= '<th>Mobile No</th>';
                $html .= '<th>City</th>';
                $html .= '<th>State</th>';
                $html .= '<th>Date</th>';
            }
            $html .= '</tr>
                                                </thead>
                                                <tbody>';
            $j = 1;
            foreach ($get_advisor_list as $advisor_result) {

                $created_at = date("m/d/Y", strtotime($advisor_result->created_at));

                $html .= "<tr>
                            <td>" . $j . "</td>";
                if (sipost('select_colum')) {
                    foreach (sipost('select_colum') as $colum_result) {
                        if ($colum_result == 'Name') {
                            $html .= '<td>' . $advisor_result->first_name . ' ' . $advisor_result->last_name . '</td>';
                        }
                        if ($colum_result == 'Email') {
                            $html .= '<td>' . $advisor_result->email . '</td>';
                        }
                        if ($colum_result == 'Mobile No') {
                            $html .= '<td>' . $advisor_result->mobile_no . '</td>';
                        }
                        if ($colum_result == 'City') {
                            $html .= '<td>' . $advisor_result->city . '</td>';
                        }
                        if ($colum_result == 'State') {
                            $html .= '<td>' . $advisor_result->state . '</td>';
                        }
                        if ($colum_result == 'Date') {
                            $html .= '<td>' . $created_at . '</td>';
                        }
                    }
                } else {
                    $html .= "<td>" . $advisor_result->first_name . " " . $advisor_result->last_name . "</td>
                            <td>" . $advisor_result->email . "</td>
                            <td>" . $advisor_result->mobile_no . "</td>
                            <td>" . $advisor_result->city . "</td>
                            <td>" . $advisor_result->state . "</td>
                            <td>" . $created_at . "</td>";
                }
                $html .= '</tr>';
                $j++;
            }

            $html .= '</tbody>
                    </table>';

            $file_name = "Advisor List - " . date('Y_m_d') . ".pdf";
        } else if (sipost('select_data') == 'designation') {
            $get_designation_list = Settings()->get_designation_list();
            $html .= '<table class="table" width="100%" border="1" cellpadding="4" style="border-collapse: collapse; text-align:left; font-size:13px;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th align="left">Name</th> 
                </tr>
            </thead>
            <tbody>';
            $j = 1;
            foreach ($get_designation_list as $result) {
                $html .= "<tr>
    <td>" . $j . "</td>
    <td>" . $result->name . "</td>
</tr>";
                $j++;
            }

            $html .= '</tbody>
        </table>';

            $file_name = "Designation List - " . date('Y_m_d') . ".pdf";
        } else if (sipost('select_data') == 'lead_source') {
            $get_lead_source_list = Settings()->get_lead_source_list();
            $html .= '<table class="table" width="100%" border="1" cellpadding="4" style="border-collapse: collapse; text-align:left; font-size:13px;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th align="left">Type</th> 
                </tr>
            </thead>
            <tbody>';
            $j = 1;
            foreach ($get_lead_source_list as $result) {
                $html .= "<tr>
    <td>" . $j . "</td>
    <td>" . $result->type . "</td>
</tr>";
                $j++;
            }

            $html .= '</tbody>
        </table>';

            $file_name = "Lead Source List - " . date('Y_m_d') . ".pdf";
        } else if (sipost('select_data') == 'licenses_type') {

            $get_license_type_list = Settings()->get_license_type_list();

            $html .= '<table class="table" width="100%" border="1" cellpadding="4" style="border-collapse: collapse; text-align:left; font-size:13px;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th align="left">Type</th> 
                </tr>
            </thead>
            <tbody>';
            $j = 1;
            foreach ($get_license_type_list as $result) {
                $html .= "<tr>
    <td>" . $j . "</td>
    <td>" . $result->type . "</td>
</tr>";
                $j++;
            }

            $html .= '</tbody>
        </table>';

            $file_name = "Licenses Type List - " . date('Y_m_d') . ".pdf";
        } else if (sipost('select_data') == 'affiliations') {

            $get_affiliations_list = Settings()->get_affiliations_list();

            $html .= '<table class="table" width="100%" border="1" cellpadding="4" style="border-collapse: collapse; text-align:left; font-size:13px;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th align="left">Type</th> 
                </tr>
            </thead>
            <tbody>';
            $j = 1;
            foreach ($get_affiliations_list as $result) {
                $html .= "<tr>
    <td>" . $j . "</td>
    <td>" . $result->type . "</td>
</tr>";
                $j++;
            }

            $html .= '</tbody>
        </table>';
            $file_name = "Affiliations List - " . date('Y_m_d') . ".pdf";
        } else if (sipost('select_data') == 'carrier_appointed') {

            $get_carrier_appointed_list = Settings()->get_carrier_appointed_list();

            $html .= '<table class="table" width="100%" border="1" cellpadding="4" style="border-collapse: collapse; text-align:left; font-size:13px;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th align="left">Type</th> 
                </tr>
            </thead>
            <tbody>';
            $j = 1;
            foreach ($get_carrier_appointed_list as $result) {
                $html .= "<tr>
    <td>" . $j . "</td>
    <td>" . $result->type . "</td>
</tr>";
                $j++;
            }

            $html .= '</tbody>
        </table>';
            $file_name = "Carrier Appointed List - " . date('Y_m_d') . ".pdf";
        } else if (sipost('select_data') == 'carriers') {

            $get_carrier_list = Settings()->get_carrier_list();

            $html .= '<table class="table" width="100%" border="1" cellpadding="4" style="border-collapse: collapse; text-align:left; font-size:13px;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th align="left">Name</th> 
                </tr>
            </thead>
            <tbody>';
            $j = 1;
            foreach ($get_carrier_list as $result) {
                $html .= "<tr>
    <td>" . $j . "</td>
    <td>" . $result->name . "</td>
</tr>";
                $j++;
            }

            $html .= '</tbody>
        </table>';
            $file_name = "Carrier List - " . date('Y_m_d') . ".pdf";
        } else if (sipost('select_data') == 'premium_volume') {

            $get_premium_volume_list = Settings()->get_premium_volume_list();

            $html .= '<table class="table" width="100%" border="1" cellpadding="4" style="border-collapse: collapse; text-align:left; font-size:13px;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th align="left">Name</th> 
                </tr>
            </thead>
            <tbody>';
            $j = 1;
            foreach ($get_premium_volume_list as $result) {
                $html .= "<tr>
    <td>" . $j . "</td>
    <td>" . $result->type . "</td>
</tr>";
                $j++;
            }

            $html .= '</tbody>
        </table>';
            $file_name = "Premium Volume List - " . date('Y_m_d') . ".pdf";
        } else if (sipost('select_data') == 'product_percentage') {

            $get_production_percentage_list = Settings()->get_production_percentage_list();

            $html .= '<table class="table" width="100%" border="1" cellpadding="4" style="border-collapse: collapse; text-align:left; font-size:13px;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th align="left">Name</th> 
                </tr>
            </thead>
            <tbody>';
            $j = 1;
            foreach ($get_production_percentage_list as $result) {
                $html .= "<tr>
    <td>" . $j . "</td>
    <td>" . $result->type . "</td>
</tr>";
                $j++;
            }

            $html .= '</tbody>
        </table>';
            $file_name = "Premium Volume List - " . date('Y_m_d') . ".pdf";
        } else if (sipost('select_data') == 'markets') {

            $get_market_list = Settings()->get_market_list();

            $html .= '<table class="table" width="100%" border="1" cellpadding="4" style="border-collapse: collapse; text-align:left; font-size:13px;">
            <thead>
                <tr>
                    <th>No.</th>
                    <th align="left">Type</th> 
                </tr>
            </thead>
            <tbody>';
            $j = 1;
            foreach ($get_market_list as $result) {
                $html .= "<tr>
    <td>" . $j . "</td>
    <td>" . $result->type . "</td>
</tr>";
                $j++;
            }

            $html .= '</tbody>
        </table>';
            $file_name = "Market List - " . date('Y_m_d') . ".pdf";
        }

        $html .= '</div>
                    </body>
                </html>';

        $stylesheet = file_get_contents(site_url() . '/assets/css/pdf.css'); // external css

        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($html);

        $mpdf->Output($file_name, 'D');
    }

    wp_redirect(site_url() . '/admin/settings/data-export');
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <?php require SITE_DIR . '/head.php'; ?>
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
                                        <h1 class="page-heading d-flex flex-column justify-content-center text-gray-900 fw-bold fs-3 m-0">Data Export</h1>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Page title-->
                                    <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_advisor_export_modal">
                                        <i class="ki-outline ki-exit-up fs-2"></i>Export</button>
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
                                <?php if (isset($_SESSION['process_success'])) {
                                    unset($_SESSION['process_success']); ?>
                                    <div class="alert alert-success d-flex align-items-center p-5">
                                        <i class="ki-duotone ki-shield-tick fs-2hx text-success  me-4"><span class="path1"></span><span class="path2"></span></i>
                                        <div class="d-flex flex-column">
                                            <h4 class="mb-1 text-success">The mail settings has been save successfully.</h4>
                                        </div>
                                    </div>
                                <?php } ?>

                                <!--begin::Card-->
                                <div class="card">
                                    <!--begin::Card body-->
                                    <div class="card-body pt-0">

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

    <!--begin::Modal-->
    <div class="modal fade" id="kt_advisor_export_modal" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Export Advisor</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div id="kt_advisor_export_close" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <i class="ki-outline ki-cross fs-1"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-10 my-7">
                    <!--begin::Form-->
                    <form id="" class="form" method="post">
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-semibold form-label mb-5">Select Data:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select data-control="select2" data-placeholder="Select a data" data-hide-search="true" name="select_data" id="select_data" class="form-select form-select-solid" required>
                                <option value="">Select</option>
                                <option value="advisor">Advisor</option>
                                <option value="designation">Designation</option>
                                <option value="lead_source">Lead Source</option>
                                <option value="licenses_type">Licenses Type</option>
                                <option value="affiliations">Affiliations</option>
                                <option value="carrier_appointed">Carrier Appointed</option>
                                <option value="carriers">Carriers</option>
                                <option value="premium_volume">Premium Volume</option>
                                <option value="product_percentage">Product Percentage</option>
                                <option value="markets">Markets</option>
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-semibold form-label mb-5">Select Colum</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <div id="">
                                <select class="form-select" data-control="select2" data-close-on-select="false" data-placeholder="Select a Production Percentages..." data-allow-clear="true" multiple="multiple" class="form-select form-select-solid" name="select_colum[]" id="select_colum">
                                </select>
                            </div>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-semibold form-label mb-5">Select Export Format:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select data-control="select2" data-placeholder="Select a format" data-hide-search="true" name="format" class="form-select form-select-solid">
                                <option value="excel">Excel</option>
                                <option value="pdf">PDF</option>
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <?php /*
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-5 fw-semibold form-label mb-5">Select Date Range:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <input class="form-control form-control-solid" name="date_range" placeholder="Pick date range" id="kt_daterangepicker_4" />
                            <!--end::Input-->
                        </div>
                        */ ?>
                        <!--end::Input group-->
                        <!--begin::Row-->
                        <?php /*
                        <div class="row fv-row mb-15">
                            <!--begin::Label-->
                            <label class="fs-5 fw-semibold form-label mb-5">Advisor Status:</label>
                            <!--end::Label-->
                            <!--begin::Radio group-->
                            <div class="d-flex flex-wrap align-items-center gap-4">
                                <?php foreach (Settings()->get_advisor_status_list() as $key => $status_result) { ?>
                                    <!--begin::Radio button-->
                                    <label class="form-check form-check-custom form-check-sm form-check-solid mb-3 d-inline">
                                        <input class="form-check-input" type="checkbox" value="<?php echo $key ?>" name="advisor_status[]" />
                                        <span class="form-check-label fw-semibold m-0"><?php echo $status_result ?></span>
                                    </label>
                                    <!--end::Radio button-->
                                <?php } ?>
                            </div>
                            <!--end::Input group-->
                        </div>
                        */ ?>
                        <!--end::Row-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="export_cancel" class="btn btn-light me-3">Discard</button>
                            <button type="submit" id="export_submit" name="export_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>

    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <?php require SITE_DIR . '/footer_script.php'; ?>
    <!--end::Global Javascript Bundle-->
    <!--end::Javascript-->
    <script>
        $(document).on("change", "#select_data", function() {

            var export_data = $(this).val();

            $('#select_colum').html('');

            if (export_data == 'advisor') {

                var optionFormat = "<option value='Name'>Name</option><option value='Email'>Email</option><option value='Mobile No'>Mobile No</option><option value='City'>City</option><option value='State'>State</option><option value='Date'>Date</option>";

                // Append it to the select element
                $('#select_colum').append(optionFormat);

            }

        });

        var start = moment().subtract(29, "days");
        var end = moment();

        function cb(start, end) {
            $("#kt_daterangepicker_4").html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
        }

        $("#kt_daterangepicker_4").daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                "Today": [moment(), moment()],
                "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [moment().startOf("month"), moment().endOf("month")],
                "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
            }
        }, cb);

        cb(start, end);
    </script>
</body>
<!--end::Body-->

</html>