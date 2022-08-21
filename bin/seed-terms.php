<?php

require_once '../bootstrap.php';

use \RedBeanPHP\R as R;

define('TERM_DATES_RELATIVE', [
    'spring' => [
        'start' => 'first Monday of January',
        'end' => 'third Friday of May'
    ],
    'summer' => [
        'end' => 'first Friday of August'
    ],
    'autumn' => [
        'end' => 'second Friday of December'
    ]
]);

$current_year = (new DateTime())->format('Y');

if (R::findOne('term', 'YEAR(start_date) = ?', [ $current_year ])) {
    exit('Terms already loaded for this year.' . PHP_EOL);
}

$spring = R::dispense('term');
$spring->name = 'Spring ' . $current_year;
$start_date = new DateTime(TERM_DATES_RELATIVE['spring']['start']);
$spring->start_date = $start_date;
$end_date = new DateTime(TERM_DATES_RELATIVE['spring']['end']);
$spring->end_date = $end_date;

$summer = R::dispense('term');
$summer->name = 'Summer ' . $current_year;
// Summer term starts on the Monday following the end of the previous term
$start_date = $end_date->modify('Monday');
$summer->start_date = $start_date;
$end_date = new DateTime(TERM_DATES_RELATIVE['summer']['end']);
$summer->end_date = $end_date;

$autumn = R::dispense('term');
$autumn->name = 'Autumn ' . $current_year;
// Autumn term starts on the Monday following the end of the previous term
$start_date = $end_date->modify('Monday');
$autumn->start_date = $start_date;
$end_date = new DateTime(TERM_DATES_RELATIVE['autumn']['end']);
$autumn->end_date = $end_date;

R::storeAll([$spring, $summer, $autumn]);
