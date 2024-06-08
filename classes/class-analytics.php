<?php

/**
 * Class For Analytics Site
 */

class Analytics
{

    protected static $instance;

    public function __construct()
    {
        add_action('wp_ajax_get_page_visit_chart_data', array($this, 'get_page_visit_chart_data'));
    }

    public function get_page_visit_chart_data($date_range = '')
    {
        global $wpdb;

        $date_range = (isset($_POST['date_range'])) ? $_POST['date_range'] : $date_range;

        if (!$date_range) {
            return;
        }

        $data_found = false;

        $date_range = explode("-", $date_range);

        $start_date = ($date_range[0]) ? date('Y-m-d', strtotime(trim($date_range[0]))) : '';
        $end_date = ($date_range[1]) ? date('Y-m-d', strtotime(trim($date_range[1]))) : '';

        $days = calculateDaysBetween($start_date, $end_date);

        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $end->modify('+1 day'); // Include the end date in the array

        // Create a DateInterval for daily increment
        $interval = new DateInterval('P1D'); // 1 day interval

        // Create a DatePeriod instance
        $period = new DatePeriod($start, $interval, $end);

        if ($days <= 8) {

            // Loop through the DatePeriod and add each date to the array
            foreach ($period as $date) {

                $total_visitor_count = $wpdb->get_var('SELECT COUNT(id) as total_record FROM page_analytics WHERE  DATE(visit_time) = "' . $date->format('Y-m-d') . '"');

                $total_visit_data[] = array(
                    'total_visitor' => ($total_visitor_count) ? $total_visitor_count : 0,
                    'visit_time'    => $date->format('Y-m-d'),
                );
            }

            //$total_visitor_data_sort_array = array_reverse($total_visit_data);

            $data[0][0] = 'Days';
            $data[0][1] = 0;
            $x          = 1;

            foreach ($total_visit_data as $result) {

                $data[$x][0] = date('d M', strtotime($result['visit_time']));
                $data[$x][1] = (int) $result['total_visitor'];
                $x++;
            }

            $data_found = true;
        } elseif ($days > 8 && $days <= 30) {
            // Initialize an empty array to hold the month-wise data
            $month_wise_data = [];

            // Loop through the DatePeriod and add each date to the array
            foreach ($period as $date) {

                // Extract month and year from the current date
                $month_year = $date->format('M/Y');

                // Fetch total visitor count for the current month
                $total_visitors_data = $wpdb->get_row(
                    'SELECT COUNT(id) as total_record 
                    FROM page_analytics 
                    WHERE YEAR(DATE(visit_time)) = YEAR("' . $date->format('Y-m-d') . '")
                    AND MONTH(DATE(visit_time)) = MONTH("' . $date->format('Y-m-d') . '")'
                );

                // Store the total visitor count in the month-wise data array
                $month_wise_data[$month_year] = array(
                    'total_visitor' => ($total_visitors_data) ? (int)$total_visitors_data->total_record : 0,
                    'visit_time'    => $month_year,
                );
            }

            $data[0][0] = 'Month';
            $data[0][1] = 0;
            $x          = 1;

            foreach ($month_wise_data as $result) {

                $data[$x][0] = $result['visit_time'];
                $data[$x][1] = (int) $result['total_visitor'];
                $x++;
            }

            $data_found = true;
        } else if ($days > 31) {

            // Initialize an empty array to hold the month-wise data
            $month_wise_data = [];

            // Loop through the DatePeriod and add each date to the array
            foreach ($period as $date) {

                // Extract month and year from the current date
                $month_year = $date->format('M/Y');

                // Fetch total visitor count for the current month
                $total_visitors_data = $wpdb->get_row(
                    'SELECT COUNT(id) as total_record 
                    FROM page_analytics 
                    WHERE YEAR(DATE(visit_time)) = YEAR("' . $date->format('Y-m-d') . '")
                    AND MONTH(DATE(visit_time)) = MONTH("' . $date->format('Y-m-d') . '")'
                );

                // Store the total visitor count in the month-wise data array
                $month_wise_data[$month_year] = array(
                    'total_visitor' => ($total_visitors_data) ? (int)$total_visitors_data->total_record : 0,
                    'visit_time'    => $month_year,
                );
            }

            $data[0][0] = 'Month';
            $data[0][1] = 0;
            $x          = 1;

            foreach ($month_wise_data as $result) {

                $data[$x][0] = $result['visit_time'];
                $data[$x][1] = (int) $result['total_visitor'];
                $x++;
            }

            $data_found = true;
        } /*else {

            // Initialize an empty array to hold the month-wise data
            $year_wise_data = [];

            // Loop through the DatePeriod and add each date to the array
            foreach ($period as $date) {

                // Extract month and year from the current date
                $year = $date->format('Y');

                $total_visitors_data = $wpdb->get_row('SELECT COUNT(id) as total_record,visit_time FROM page_analytics GROUP BY YEAR(visit_time)');

                // Store the total visitor count in the month-wise data array
                $year_wise_data[$year] = array(
                    'total_visitor' => ($total_visitors_data) ? (int)$total_visitors_data->total_record : 0,
                    'visit_time'    => $year,
                );
            }

            $data[0][0] = 'Year';
            $data[0][1] = 0;
            $x          = 1;

            foreach ($year_wise_data as $result) {

                $data[$x][0] = $result['visit_time'];
                $data[$x][1] = (int) $result['total_visitor'];
                $x++;
            }

            $data_found = true;
        } */

        if ($data_found) {

            echo (json_encode($data));
        } else {

            //echo (json_encode(array(array('Days', 0), array(date('Y'), 0))));
        }

        die;
    }

    public static function get_instance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}

function Analytics()
{
    return Analytics::get_instance();
}

Analytics();
