<?php

// Report all PHP errors
error_reporting(E_ALL);

require_once 'vendor/autoload.php';
require_once 'src/autoload.php';

\RedBeanPHP\R::setup();
//\RedBeanPHP\R::fancyDebug(true);

define('REDBEAN_MODEL_PREFIX', '\\RedBeanUni\\Model\\');
define('MYSQL_TIME_FMT', 'H:i:s');
define('PASSING_GRADE', 70);
define('DAY_MAP', [
    '1' => [
        'full' => 'Sunday',
        'short' => 'Sun',
    ],
    '2' => [
        'full' => 'Monday',
        'short' => 'M',
    ],
    '3' => [
        'full' => 'Tuesday',
        'short' => 'Tue',
    ],
    '4' => [
        'full' => 'Wednesday',
        'short' => 'W',
    ],
    '5' => [
        'full' => 'Thursday',
        'short' => 'Thu',
    ],
    '6' => [
        'full' => 'Friday',
        'short' => 'F',
    ],
    '7' => [
        'full' => 'Saturday',
        'short' => 'Sat',
    ]
]);
