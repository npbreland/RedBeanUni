<?php
require_once $_ENV['CONFIG_PATH'] . '/config.php';

$faker = Faker\Factory::create();

for ($i = 0; $i < 5; $i++) {
    $instructor = R::dispense('instructor');
    $instructor->first_name = $faker->firstName();
    $instructor->last_name = $faker->lastName();
    $instructor->date_of_birth = new DateTime($faker->date());
    R::store($instructor);
}







