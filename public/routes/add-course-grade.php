<?php

require $_SERVER['DOCUMENT_ROOT'] . '/rb-config.php';

$student_id = $_POST['student'];
$course_id = $_POST['course'];
$grade_100 = $_POST['grade_100'];

$student = R::load('student', $student_id);
$course = R::load('course', $course_id);

$grade = R::dispense('grade');
$grade->course = $course;
$grade->grade_100 = $grade_100;

$student->ownGradesList[] = $grade;

try {
    R::store($student);
    header('Location: /views/grade-student.php?student='.$student_id);
} catch (Exception $e) {
    echo $e->getMessage();
}

