<?php
require_once $_ENV['COMPOSER_PATH'] . '/redbean/rb-mysql.php';

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

$host = $_ENV['DB_HOST'];
$name = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];

R::setup("mysql:host=$host;dbname=$name", $user, $pass);

/* try{ */
/*     $db = new PDO("mysql:host=$host;dbname=$pass", $user, $pass); */
/* } catch(PDOException $e){ */
/*     echo $e->getmessage(); */
/* } */
//R::fancyDebug( TRUE );
