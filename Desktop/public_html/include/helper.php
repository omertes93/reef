<?php
$days = [
    1 => "ראשון",
    2 => "שני",
    3 => "שלישי",
    4 => "רביעי",
    5 => "חמישי",
    6 => "שישי",
    7 => "שבת"
];

function get_today_num(){
    $day = date('w');
    return $day + 1;
}


// מחזירה את המספר של היום בשבוע לפי תאריך.
function get_date_number( $date ) {
    $weekday = date('w', strtotime($date)) + 1;
    return $weekday;
}

// מחזירה את התאריך של יום ראשון בשבוע שלאחר מכן
function get_first_day_date( $nextWeek = false ) {
    $day = date('w'); // 0 - 6
    if( $nextWeek ) {
        $days = '+'.(7 - $day).' days';
    } else {
        $days = '-'.$day.' days';
    }
    $week_start = date('Y-m-d', strtotime($days));
    return $week_start;
}

// מחזירה את התאריך של יום שבת בשבוע שלאחר מכן
function get_last_day_date( $nextWeek = false  ) {
    $day = date('w');
    if( $nextWeek ) {
        $days = 13 - $day;
    } else {
        $days = 6 - $day;
    }
    $end_week = date('Y-m-d', strtotime('+'.$days.' days'));
    return $end_week;
}


function get_hour_format( $number ) {
    if( $number < 10 ) {
        return '0'.$number.':00';
    } else {
        return $number.':00';
    }
}

function isLogin() {
    if( isset( $_SESSION['employee_id']) ) {
        return true;
    }
    return false;
}

function getRoleId() {
    if( isset($_SESSION['role_id'])) {
        return $_SESSION['role_id'];
    }
}
