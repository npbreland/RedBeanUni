<?php
require_once $_ENV['CONFIG_PATH'] . '/config.php';

$student_id = 1;
$course_id = 24;

$student = R::load('student', $student_id);
$course = R::load('course', $course_id);

$grade = R::dispense('grade');
$grade->course = $course;
$grade->score = 95;

$student->addGrade($grade->box());

R::store($student);


