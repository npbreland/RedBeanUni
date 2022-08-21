<?php
require_once '../bootstrap.php';

use \RedBeanPHP\R as R;

$students = R::findAll( 'student' );
$offerings = R::findAll( 'offering' );

R::wipe( 'grade' );

foreach ($students as $student) {
    // 5 grades for each student
    for ($i = 0; $i < 5; $i++) {
        $grade = R::dispense( 'grade' );
        $grade->offering = $offerings[rand(1, count($offerings))];
        $grade->score_100 = rand(0, 100);
        $grade->student = $student;
        R::store( $grade );
    }
}
