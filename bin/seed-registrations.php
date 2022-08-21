<?php
require_once '../bootstrap.php';

use \RedBeanPHP\R as R;

$students = R::findAll( 'student' );
$offerings = R::findAll( 'student' );

R::wipe( 'registration' );

foreach ($students as $student) {
    // 5 registrations for each student
    for ($i = 0; $i < 5; $i++) {
        $reg = R::dispense( 'registration' );
        $reg->offering = $offerings[rand(1, count($offerings))];
        $reg->student = $student;
        R::store( $reg );
    }
}
