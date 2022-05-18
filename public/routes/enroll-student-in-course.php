<?php

require $_SERVER['DOCUMENT_ROOT'] . '/rb-config.php';

$student_id = $_POST['student'];
$course_id = $_POST['course'];

$student = R::load('student', $student_id);
$course = R::load('course', $course_id);

$student->sharedCourseList[] = $course;

try {
    R::store($student);
    header('Location: /views/enroll-student-in-course.php');
} catch (Exception $e) {
    echo $e->getMessage();
}

