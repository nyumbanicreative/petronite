<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function hall_nice_timestamp($time) {

    return date('d M y G:i', strtotime($time));
}

function hall_nice_date($time) {

    return date('d M y', strtotime($time));
}

function hall_nice_short_date($time) {

    return date('d M', strtotime($time));
}

function lz($num) {
    $num = floor($num);
    return (strlen($num) < 2) ? "0{$num}" : $num;
}

function isWeekend($date) {
    return (date('N', strtotime($date)) >= 6);
}

function getSecondsFromHrsMinSec($str_time) {

    sscanf($str_time, "%d:%d:%d", $hours, $minutes, $seconds);
    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;

    return $time_seconds;
}

function hall_random_password() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function hall_print_r($input) {

    echo "<pre>";

    print_r($input);
}

function hall_price_form($price) {
    return number_format($price, 0, '.', ',');
}

function hall_price_form_french($price) {
    return number_format($price, 2, '.', ' ');
}

function getListingPaginationConfig($base_url, $total_rows) {

    $config = array();
    $config["base_url"] = $base_url;
    $config["total_rows"] = $total_rows;

    $config["per_page"] = LISTINGS_PER_PAGE;
    $config["num_links"] = 2;

    $config['first_tag_open'] = '<li>';
    $config['first_tag_close'] = '</li>';


    $config['tag_open'] = '<li>';
    $config['tag_close'] = '</li>';

    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';

    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';

    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="active"><a >';
    $config['cur_tag_close'] = '</a></li>';

    $config['last_tag_open'] = '<li>';
    $config['last_tag_close'] = '</li>';


    return $config;
}

function get_payment_instruction($option = "MPESA", $amount = "", $number = "155234") {

    return 'Pay the amount of <b>' . $amount . '</b> to a busness number <b>' . $number . '</b><br/><br/>
            <ol style="padding: 0 15px ;">
                <li>Dial <b>*150*00#</b></li>
                <li>Choose <b>1</b> Pay by M-Pesa</li>
                <li>Choose <b>1</b> Enter LIPA Number </li>
                <li>Enter <b>' . $number . '</b> as the LIPA Number </li>
                <li>Enter the amount <b>' . $amount . '</b> in Tanzania Shillings</li>
                <li>Enter <b>1</b> to confirm the payment</li>
            </ol>';
}

function c_get_session_expire_json() {

    return json_encode([
        'status' => [
            'error' => TRUE,
            'error_type' => 'pop',
            "error_msg" => 'Your Session has expired, Please Login again',
            'redirect' => true,
        ],
        'url' => site_url('user/index')
    ]);
}

function c_time_ago($timestamp = 0, $now = 0) {

    // Set up an array of time intervals.
    $intervals = array(
        60 * 60 * 24 * 365 => 'year',
        60 * 60 * 24 * 30 => 'month',
        60 * 60 * 24 * 7 => 'week',
        60 * 60 * 24 => 'day',
        60 * 60 => 'hour',
        60 => 'minute',
        1 => 'second',
    );

    // Get the current time if a reference point has not been provided.
    if (0 === $now) {
        $now = time();
    }

    // Make sure the timestamp to check predates the current time reference point.
    if ($timestamp > $now) {
        throw new \Exception('Timestamp postdates the current time reference point');
    }

    // Calculate the time difference between the current time reference point and the timestamp we're comparing.
    $time_difference = (int) abs($now - $timestamp);

    // Check the time difference against each item in our $intervals array. When we find an applicable interval,
    // calculate the amount of intervals represented by the the time difference and return it in a human-friendly
    // format.
    foreach ($intervals as $interval => $label) {

        // If the current interval is larger than our time difference, move on to the next smaller interval.
        if ($time_difference < $interval) {
            continue;
        }

        // Our time difference is smaller than the interval. Find the number of times our time difference will fit into
        // the interval.
        $time_difference_in_units = round($time_difference / $interval);

        if ($time_difference_in_units <= 1) {
            $time_ago = sprintf('one %s ago', $label
            );
        } else {
            $time_ago = sprintf('%s %ss ago', $time_difference_in_units, $label
            );
        }

        return $time_ago;
    }
}

function c_get_file_extension($filename) {
    $file_array = explode('.', $filename);
    return end($file_array);
}
