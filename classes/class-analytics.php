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

    public function get_page_visit_chart_data($date_formate = '')
    {
        global $wpdb;

        if ($date_formate == 'Year') {
        } elseif ($date_formate == 'Month') {
        } elseif ($date_formate == 'Week') {
        } else {

            $total_visit_data = array();

            for ($i = 0; $i <= 6; $i++) {

                $to_date = date('Y-m-d', strtotime('-' . $i . ' days'));

                $total_visitor_count = $wpdb->get_var('SELECT COUNT(id) as total_record FROM page_analytics WHERE  DATE(visit_time) = "' . $to_date . '"');

                $total_visit_data[] = array(
                    'total_clienti' => ($total_visitor_count) ? $total_visitor_count : 0,
                    'created_at'    => $to_date,
                );
            }

            $total_visitor_data_sort_array = array_reverse($total_visit_data);

            $data[0][0] = 'Days';
            $data[0][1] = 0;
            $x          = 1;

            foreach ($total_visitor_data_sort_array as $result) {

                $data[$x][0] = date('d M', strtotime($result['created_at']));
                $data[$x][1] = (int) $result['total_clienti'];
                $x++;
            }

            $data_found = true;
        }

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
