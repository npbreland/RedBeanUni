<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 

require_once $_ENV['CONFIG_PATH'] . '/config.php';

R::wipe('class');

$c1 = R::dispense('course');
$c1->name = 'Introduction to American Literature';

$c2 = R::dispense('course');
$c2->name = 'Introduction to British Literature';

$c3 = R::dispense('course');
$c3->name = 'Introduction to Anthropology';

$t1 = \R::load('term', 1);

$i1 = R::load('instructor', 1);
$cl1 = R::dispense('offering');
$cl1->course = $c1;
$cl1->instructor = $i1;
$cl1->term = $t1;
$cl1->start_time = '10:00';
$cl1->end_time = '11:00';

$days = [2, 4, 6];
foreach ($days as $day_num) {
    $day_bean = R::dispense('day');
    $day_bean->day_num = $day_num;
    $cl1->sharedDayList[] = $day_bean;
}

R::store($cl1);

$i2 = R::load('instructor', 2);
$cl2 = R::dispense('offering');
$cl2->course = $c2;
$cl2->instructor = $i2;
$cl2->term = $t1;
$cl2->start_time = '10:00';
$cl2->end_time = '11:00';

$days = [2, 4, 6];
foreach ($days as $day_num) {
    $day_bean = R::dispense('day');
    $day_bean->day_num = $day_num;
    $cl2->sharedDayList[] = $day_bean;
}

R::store($cl2);

$i3 = R::load('instructor', 3);
$cl3 = R::dispense('offering');
$cl3->course = $c3;
$cl3->instructor = $i3;
$cl3->term = $t1;
$cl3->start_time = '10:00';
$cl3->end_time = '11:00';

$days = [2, 4, 6];
foreach ($days as $day_num) {
    $day_bean = R::dispense('day');
    $day_bean->day_num = $day_num;
    $cl3->sharedDayList[] = $day_bean;
}

R::store($cl3);

