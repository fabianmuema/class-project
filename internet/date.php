<?php

date_default_timezone_set('Africa/Nairobi');

$date1 = date('M-d-Y');

$time = date("H:i:s");

if ($freq == 'daily') {
    $your_date = strtotime("1 day", strtotime($date1));
    $date = date("M/d/Y", $your_date);
} elseif ($freq == "weekly") {
    $your_date = strtotime("7 days", strtotime($date1));
    $date = date("M/d/Y", $your_date);
} elseif($freq == "monthly"){
    $your_date = strtotime("30 days", strtotime($date1));
    $date = date("M/d/Y", $your_date);
} elseif($freq == "half") {
    $date = date("M/d/Y H:i:s", strtotime('+12 hours'));
    $time = date("H:i:s", strtotime("+12 hours"));

} elseif($freq == "quarter") {
    $date = date("M/d/Y H:i:s", strtotime('+6 hours'));
    $time = date("H:i:s", strtotime("+6 hours"));

}