<?php
require_once $_ENV['CONFIG_PATH'] . '/config.php';

$faker = Faker\Factory::create();

for ($i = 0; $i < 100; $i++) {
    $student = R::dispense('student');
    $student->first_name = $faker->firstName();
    $student->last_name = $faker->lastName();
    $student->date_of_birth = new DateTime($faker->date());
    R::store($student);
}







