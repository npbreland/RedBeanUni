<?php
require_once '../bootstrap.php';

use \RedBeanPHP\R as R;

$faker = Faker\Factory::create();

// Students
for ($i = 0; $i < 100; $i++) {
    $student = R::dispense('student');
    $student->first_name = $faker->firstName();
    $student->last_name = $faker->lastName();
    $student->date_of_birth = new DateTime($faker->date());
    R::store($student);
}

// Instructor
for ($i = 0; $i < 5; $i++) {
    $instructor = R::dispense('instructor');
    $instructor->first_name = $faker->firstName();
    $instructor->last_name = $faker->lastName();
    $instructor->date_of_birth = new DateTime($faker->date());
    R::store($instructor);
}








