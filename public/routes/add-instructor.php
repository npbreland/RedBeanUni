<?php

require $_SERVER['DOCUMENT_ROOT'] . '/rb-config.php';

$instructor = R::dispense('instructor');
$instructor->trimport($_POST);

try {
    R::store($instructor);
    header('Location: /views/instructors.php');
} catch (Exception $e) {
    echo $e->getMessage();
}

