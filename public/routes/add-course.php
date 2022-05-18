<?php

require $_SERVER['DOCUMENT_ROOT'] . '/rb-config.php';

$instructor_id = $_POST['instructor'];
$day_nums = $_POST['days'];

$course = R::dispense('course');
$instructor = R::load('instructor', $instructor_id);

foreach ($day_nums as $day_num) {
    $day = R::findOneOrDispense('day', 'day_num = ?', [ $day_num ]);
    $day->day_num = $day_num;
    $course->sharedDayList[] = $day;
}

$course->instructor = $instructor;

$course->name = trim($_POST['name']);
$course->start_time = $_POST['start_time'];
$course->end_time = $_POST['end_time'];

try {
    R::store($course);
    header('Location: /views/courses.php');
} catch (Exception $e) {
    echo $e->getMessage();
}

