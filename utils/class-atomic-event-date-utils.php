<?php

defined('WPINC') or die;

class AtomicEvents_DateUtils {
    public static function get_atomic_formatted_date($event) {

        if (is_int($event)) {
            $eventModel = new AtomicEventModel($event);
        } elseif ($event instanceof AtomicEventModel) {
            $eventModel = $event;
        } else {
            return ''; // Invalid input
        }

        $start_date_str = $eventModel->get_event_start_date();
        $end_date_str = $eventModel->get_event_end_date();

        $start_hour_str = $eventModel->get_event_start_time();
        $end_hour_str = $eventModel->get_event_end_time();

        // Check if start date is empty
        $start_date = !empty($start_date_str) ? date_create($start_date_str) : null;

        // Check if end date is empty
        $end_date = !empty($end_date_str) ? date_create($end_date_str) : null;

        if ($start_date === null) {
            return ''; // If start date is empty, return empty string
        }

        $start_month = date_format($start_date, 'M');
        $start_day = date_format($start_date, 'j');
        $start_year = date_format($start_date, 'Y');

        $formatted_date = '';

        if ($eventModel->get_event_all_day() && ($start_date == $end_date) || empty($end_date)) {
            // All-day event on the same day
            $formatted_date = $start_month . ' ' . $start_day . ', ' . $start_year .  self::get_time_string($start_hour_str, $end_hour_str);
        } else {
            if ($end_date === null) {
                // If end date is empty, return formatted start date only
                return $start_month . ' ' . $start_day . ', ' . $start_year;
            }
            $end_month = date_format($end_date, 'M');
            $end_day = date_format($end_date, 'j');
            $end_year = date_format($end_date, 'Y');

            // If the start and end dates are in the same day and year
            if ($start_month === $end_month && $start_day === $end_day && $start_year === $end_year) {
                if ($eventModel->get_event_all_day()) {
                    $formatted_date = $start_month . ' ' . $start_day . ', ' . $start_year;
                } else {
                    // Event with start and end times on the same day
                    $formatted_date = $start_month . ' ' . $start_day . ', ' . $start_year . self::get_time_string($start_hour_str, $end_hour_str);
                }
            }
            // If the start and end dates are different
            else {
                // If it's an all-day event spanning multiple days
                if ($eventModel->get_event_all_day()) {
                    $formatted_date = $start_month . ' ' . $start_day . ', ' . $start_year . ' - ' . $end_month . ' ' . $end_day . ', ' . $end_year;
                } else {
                    $formatted_date = $start_month . ' ' . $start_day . ', ' . $start_year . self::get_time_string($start_hour_str, $end_hour_str) . ' - ' . $end_month . ' ' . $end_day . ', ' . $end_year . self::get_time_string($end_hour_str);
                }
            }
        }

        return $formatted_date;
    }

    public static function atomic_formatted_date($event) {
        echo esc_html(self::get_atomic_formatted_date($event));
    }

    private static function get_time_string($start_hour_str = null, $end_hour_str = null) {
        $time_string = '';

        if (!empty($start_hour_str) && !empty($end_hour_str)) {
            $time_string = ' at ' . gmdate('g:i a', strtotime($start_hour_str)) . ' - ' . gmdate('g:i a', strtotime($end_hour_str));
        } elseif (!empty($start_hour_str)) {
            $time_string = ' at ' . gmdate('g:i a', strtotime($start_hour_str));
        } elseif (!empty($end_hour_str)) {
            $time_string = ' - ' . gmdate('g:i a', strtotime($end_hour_str));
        }

        return $time_string;
    }
}
