<?php

require $_SERVER['DOCUMENT_ROOT'] . '/rb-config.php';

$student = R::dispense('student');
$student->trimport($_POST);

try {
    R::store($student);
    header('Location: /views/students.php');
} catch (Exception $e) {
    echo $e->getMessage();
}

