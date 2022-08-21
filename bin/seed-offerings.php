<?php

require_once '../bootstrap.php';

use \RedBeanPHP\R as R;


$instructors = R::findAll( 'instructor' );
$terms = R::findAll( 'term' );
$courses = R::findAll( 'course' );

for ($i = 0; $i < 100; $i++) {
    $offering = R::dispense( 'offering' );
    $offering->instructor = $instructors[rand(1, count($instructors))];
    $offering->term = $terms[rand(1, count($terms))];
    $offering->course = $courses[rand(1, count($courses))];

    R::store( $offering );
}


